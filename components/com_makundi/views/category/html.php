<?php

class ComMakundiViewCategoryHtml extends ComDefaultViewHtml
{
	/**
	 * @param KConfig $config
	 */
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'template_filters' => array('module'),
		));

		parent::_initialize($config);
	}

    /**
     * @return mixed|object
     */
    public function getActiveMenu()
    {
        $menu = JFactory::getApplication()->getMenu()->getActive();
        if (is_null($menu)) {
            $menu = JFactory::getApplication()->getMenu()->getDefault();
        }

        return $menu;
    }

    /**
     * @return mixed
     */
    public function display()
    {
        $layout = 'default';

        if (KRequest::get('get.layout', 'string')) {
            $layout = end(explode(':', KRequest::get('get.layout', 'string')));
        }

        $this->setLayout($layout);

		$category =  $this->getModel()->getItem();

		header('X-Category-ID: '.$category->id);

		$doc =& JFactory::getDocument();
		if($category->title) {
			$doc->setTitle($category->title);
		}

		if($category->meta_keywords) {
			$doc->setMetaData('Keywords', $category->meta_keywords);
		}

		if($category->meta_description) {
			$doc->setMetaData('Description', $category->meta_description);
		}

		//TODO: Check if itemId
		$pathway = JFactory::getApplication()->getPathway();

		if(!JApplication::getInstance('site')->getMenu()->getItems('link', 'index.php?option=com_makundi&view=category&id='.$category->id, true)) {
			foreach($category->getAncestors(array('level' => 1)) as $ancestor) {
				$item = JApplication::getInstance('site')->getMenu()->getItems('link', 'index.php?option=com_makundi&view=category&id='.$ancestor->id, true);

				if($item) {
					$i = 0;
					foreach(explode('/', $item->route) as $part) {
						$pathway->addItem(ucfirst($part), 'index.php?Itemid='.$item->tree[$i]);
						$i++;
					}
				} else {
					if(!JSite::getMenu()->getActive()->id) {
						$pathway->addItem($ancestor->title, JRoute::_('index.php?option=com_makundi&view=category&parent_slug_path=' . $ancestor->parent_slug_path . '&slug=' . $ancestor->slug));
					}
				}
			}

			$pathway->addItem($category->title);
		}

		$descendants = array();
		$descendants[] = $category->id;

		$config = new KConfig();

		if($params = JFactory::getApplication()->getMenu()->getActive()->params) {
			$config->append($params->toArray());
		}

		if($config->show_subcategories) {
			$descendants = array_merge($descendants, $category->getDescendants(array('level' => 1))->getColumn('id'));
		}

		$config->append(array(
			'show_description' => 1,
			'show_articles' => 1
		));

		$this->assign('params', $config);
        $this->assign('parent', $this->getModel()->getItem()->getParent());
		$this->assign('descendants', $descendants);

        return parent::display();
    }
}
