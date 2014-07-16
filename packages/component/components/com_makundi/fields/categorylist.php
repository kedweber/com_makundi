<?php

/**
 * ComEvents
 *
 * @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
 * @category	
 * @package 	
 * @subpackage	
 */
 
defined('KOOWA') or die('Restricted Access');

class JFormFieldCategorylist extends JFormField {
    protected $type = 'Categorylist';

    protected function getInput() {
        // Get all the content categories.
        //$categories = JHtml::_('category.options', 'com_content');

        return KService::get('com://site/makundi.template.helper.listbox')->categories(array(
            'name' => $this->name,
            'selected' => $this->value
        ));
    }
}