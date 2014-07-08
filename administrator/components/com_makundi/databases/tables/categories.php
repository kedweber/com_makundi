<?php

class ComMakundiDatabaseTableCategories extends ComMakundiDatabaseTableNodes
{
    /**
     * @param KConfig $config
     */
    protected function  _initialize(KConfig $config)
    {
        $config->append(array(
            'command_chain' => $this->getService('com://admin/makundi.command.chain'),
            'relation_table' => 'makundi_category_relations',
            'behaviors' => array(
                'lockable',
                'sluggable',
				'com://admin/moyo.database.behavior.creatable',
                'modifiable',
                'identifiable',
                'orderable',
                'com://admin/cck.database.behavior.elementable',
                'com://admin/taxonomy.database.behavior.relationable',
                'com://admin/translations.database.behavior.translatable',
            ),
            'filters' => array(
                'description' => array('html')
            )
        ));

        parent::_initialize($config);
    }
}
