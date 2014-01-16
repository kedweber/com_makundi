<?php

class ComMakundiDispatcher extends ComDefaultDispatcher
{
    /**
     * @param KConfig $config
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'controller' => 'categories',
        ));

        parent::_initialize($config);
    }
}