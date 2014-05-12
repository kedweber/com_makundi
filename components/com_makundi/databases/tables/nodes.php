<?php

class ComMakundiDatabaseTableNodes extends KDatabaseTableDefault
{
    protected $_relation_table;

    /**
     * @param KConfig $config
     */
    public function __construct(KConfig $config)
    {
        parent::__construct($config);

        if (empty($config->relation_table)) {
            throw new KDatabaseTableException('Relation table cannot be empty');
        }

        $this->setRelationTable($config->relation_table);
    }

    /**
     * @param KConfig $config
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'behaviors' => array('com://site/makundi.database.behavior.node')
        ));

        parent::_initialize($config);
    }

    /**
     * @return mixed
     */
    public function getRelationTable()
    {
        return $this->_relation_table;
    }

    /**
     * @param $table
     * @return $this
     */
    public function setRelationTable($table)
    {
        $this->_relation_table = $table;

        return $this;
    }
}
