<?php

class ComMakundiModelCategories extends ComMakundiModelNodes
{
    /**
     * @param KConfig $config
     */
    public function __construct(KConfig $config)
    {
        parent::__construct($config);

        $this->_state
            ->insert('enabled', 'int');
    }

    /**
     * @param KDatabaseQuery $query
     */
    protected function _buildQueryWhere(KDatabaseQuery $query)
    {
        parent::_buildQueryWhere($query);

        $state = $this->_state;

        if ($state->search) {
            $query->where('tbl.title', 'LIKE', '%'.$state->search.'%');
        }

        if (is_numeric($state->enabled)) {
            $query->where('tbl.enabled','=', $state->enabled);
        }
    }
}