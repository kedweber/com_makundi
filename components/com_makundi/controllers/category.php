<?php
/**
 * Com
 *
 * @author      Dave Li <dave@moyoweb.nl>
 * @category    Nooku
 * @package     Socialhub
 * @subpackage  ...
 * @uses        Com_
 */
 
defined('KOOWA') or die('Protected resource');

class ComMakundiControllerCategory extends ComDefaultControllerDefault
{
	/**
	 * @param KConfig $config
	 */
	protected function _initialize(KConfig $config)
	{
		$cacheable = $this->getBehavior('com://site/moyo.controller.behavior.cacheable',
			array(
				'modules' => array(
					'banner',
					'left',
					'headlines',
				)
			)
		);

		$config->append(array(
			'behaviors' => array(
				$cacheable,
			)
		));

		parent::_initialize($config);
	}

	/**
	 * @return array|KConfig
	 */
	public function getRequest()
	{
		$this->_request->limit = $this->_request->limit ? $this->_request->limit : 4;

		return $this->_request;
	}
}