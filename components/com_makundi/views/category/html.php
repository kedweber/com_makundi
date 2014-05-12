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
     * @return mixed
     */
    public function display()
    {
		$category =  $this->getModel()->getItem();

		$descendants = array();
		$descendants[] = $category->id;

		$config = new KConfig();

		if($params = JFactory::getApplication()->getMenu()->getActive()->params) {
			$config->append($params->toArray());
		}

		if($params->show_subcategories) {
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
