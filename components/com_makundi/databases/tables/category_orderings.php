<?php

class ComMakundiDatabaseTableCategory_Orderings extends KDatabaseTableDefault
{
    /**
     * @param KConfig $config
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'identity_column' => 'makundi_category_id'
        ));

        parent::_initialize($config);
    }
}
