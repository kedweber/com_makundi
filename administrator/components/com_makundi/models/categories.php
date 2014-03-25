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
            ->insert('type', 'word')
            ->insert('enabled', 'int')
		;
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

		//TODO: Filter on array;
        if ($state->type) {
            $query->where('tbl.type','=', $state->type);
        }

		if (is_numeric($state->enabled)) {
			$query->where('tbl.enabled','=', $state->enabled);
		}
    }
}