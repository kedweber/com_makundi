<?php

class ComMakundiTemplateHelperListbox extends ComMoyoTemplateHelperListbox
{
    /**
     * @param array $config
     * @return mixed|string
     */
    public function categories($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'model'    => 'categories',
            'value'    => 'id',
            'text'     => 'title',
            'prompt'   => '',
            'required' => false,
            'attribs' => array('data-placeholder' => $this->translate('Select a category&hellip;'), 'class' => 'select2-listbox'),
            'behaviors' => array('select2' => array('element' => '.select2-listbox'))
        ));

        return $this->_treelistbox($config);
    }
}