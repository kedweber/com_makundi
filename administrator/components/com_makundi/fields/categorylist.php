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

        $categories = KService::get('com://admin/makundi.model.categories')->getList();

        return JHtml::_(
            'select.genericlist', $categories->getData(), 'jform[request]['. (string) $this->element->attributes()->name .']',
            array(
                'id' => 'jform_' . (string) $this->element->attributes()->name,
                'list.attr' => 'class="inputbox" size="1"',
                'list.select' => $this->value,
                'list.translate' => false
            ), 'id', 'title'
        );
    }
}