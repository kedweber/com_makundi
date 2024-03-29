<?php

defined('_JEXEC') or die;

class ComMakundiRouter
{
    public static function getInstance()
    {
        static $instance;

        if (!$instance) {
            $instance = new ComMakundiRouter();
        }

        return $instance;
    }

	public function build(&$query)
	{
		$segments	= array();

		if(isset($query['id']) && !isset($query['slug'])) {
			if($query['view'] == 'category') {
				$category = KService::get('com://site/makundi.model.categories')->id($query['id'])->getItem();

				$segments['slug'] = $category->slug;
				$segments['parent_slug_path'] = $category->parent_slug_path ? $category->parent_slug_path : null;
			}
		}

		return $segments;
	}

	public function parse($segments)
	{
		$vars = array();

		if($segments[0]) {
			return JError::raiseError(404, 'test');
		}

		return $vars;
	}
}

function MakundiBuildRoute(&$query)
{
	return ComMakundiRouter::getInstance()->build($query);
}

function MakundiParseRoute($segments)
{
	return ComMakundiRouter::getInstance()->parse($segments);
}
