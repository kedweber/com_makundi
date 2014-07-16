<?php

/**
 * Com
 *
 * @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
 * @category	
 * @package 	
 * @subpackage	
 */

defined('KOOWA') or die('Restricted Access');

class ComMakundiViewCategoryFeed extends KViewAbstract
{
    public function display()
    {
		$model			= $this->getModel();
		$descendants	= array();
		$descendants[]	= $model->getItem()->id;

		$config = new KConfig();

		if($params = JFactory::getApplication()->getMenu()->getActive()->params) {
			$config->append($params->toArray());
		}

		if($config->show_subcategories) {
			$descendants = array_merge($descendants, $model->getItem()->getDescendants(array('level' => 1))->getColumn('id'));
		}

        $articles = $this->getService('com://site/articles.model.articles')->category_id($descendants)->limit(20)->getList();
        $doc		= JFactory::getDocument();

        foreach($articles as $article) {
            $item				= new JFeedItem();
            $item->title		= $article->title;
            $item->link 		= $this->createRoute('option=com_articles&view=article&date=' . date('Y-m-d', strtotime($article->publish_up)) . '&id=' . $article->id . '&slug=' . $article->slug . '&format=html');
            $item->description	= $article->introtext;
            $item->date			= $article->publish_up;

			$category = json_decode($article->ancestors)->category;

			if(is_numeric($category)) {
				$item->category = $this->getService('com://site/makundi.model.categories')->id($category)->getItem()->title;
			}

            $doc->addItem($item);
        }

        return parent::display();
    }
}