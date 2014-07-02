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
