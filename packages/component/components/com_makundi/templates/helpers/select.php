<?php

class ComMakundiTemplateHelperSelect extends ComDefaultTemplateHelperSelect
{
    /**
     * @param array $config
     * @return string
     */
    public function order($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'model'    => 'categories',
            'name'   	=> 'id',
            'attribs'	=> array(),
            'key'		=> 'id',
        ))->append(array(
           'indent'    => '&nbsp;&nbsp;&nbsp;',
            'value'		 => $config->name,
            'selected'   => $config->{$config->name},
            'identifier' => 'com://'.$this->getIdentifier()->application.'/'.$this->getIdentifier()->package.'.model.'.KInflector::pluralize($config->model)
        ))->append(array(
            'text'		=> $config->value,
        ))->append(array(
            'filter' 	=> array('sort' => $config->text),
        ));

        $options = array();

        $options[] = $this->option(array('text' => '- '.JText::_('Select').' -', 'value' => null));

        $options[] = $this->option(array('text' => JText::_('Title'), 'value' => 'title'));
        $options[] = $this->option(array('text' => JText::_('Creation Date'), 'value' => 'created_on'));
        $options[] = $this->option(array('text' => JText::_('Publishing Date'), 'value' => 'publish_up'));
        $options[] = $this->option(array('text' => JText::_('ID'), 'value' => 'id'));

        $config->options = $options;

        return parent::optionlist($config);
    }

    /**
     * @param array $config
     * @return string
     */
    public function direction($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'model'    => 'categories',
            'name'   	=> 'id',
            'attribs'	=> array(),
            'key'		=> 'id',
        ))->append(array(
            'indent'    => '&nbsp;&nbsp;&nbsp;',
            'value'		 => $config->name,
            'selected'   => $config->{$config->name},
            'identifier' => 'com://'.$this->getIdentifier()->application.'/'.$this->getIdentifier()->package.'.model.'.KInflector::pluralize($config->model)
        ))->append(array(
            'text'		=> $config->value,
        ))->append(array(
            'filter' 	=> array('sort' => $config->text),
        ));

        $options = array();

        $options[] = $this->option(array('text' => '- '.JText::_('Select').' -', 'value' => null));

        $options[] = $this->option(array('text' => JText::_('Ascending'), 'value' => 'ASC'));
        $options[] = $this->option(array('text' => JText::_('Descending'), 'value' => 'DESC'));

        $config->options = $options;

        return parent::optionlist($config);
    }
}