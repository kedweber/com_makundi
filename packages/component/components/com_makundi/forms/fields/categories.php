<?php

defined('JPATH_BASE') or die;

class JFormFieldCategories extends JFormField
{
    protected $type = 'Categories';

    protected function getInput()
    {
        $value = $this->value;
        $el_name = $this->name;

        $key_field = (string) $this->element['key_field'];
        $multiple = (string) $this->element['multiple'] == 'true';
        $deselect =  (string) $this->element['deselect'] === 'true';

        $attribs = array();
        if ($multiple) {
            $attribs['multiple'] = true;
            $attribs['size'] = $this->element['size'] ? $this->element['size'] : 5;
        }

        return KService::get('com://admin/makundi.template.helper.listbox')->categories(array(
            'name' => $el_name,
            'value' => $key_field ? $key_field : 'slug',
            'deselect' => $deselect,
            'selected' => $value,
            'attribs' => $attribs
        ));
    }
}