<?php
/**
 * @package     DOCman
 * @copyright   Copyright (C) 2011 - 2013 Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.joomlatools.com
 */

class ComMakundiDatabaseRowNode extends KDatabaseRowDefault
{
    /**
     * Constant to fetch all levels in traverse methods
     *
     * @var int
     */
    const FETCH_ALL_LEVELS = 0;

    /**
     * Table name for main storage
     *
     * @var string
     */
    protected $_table_name;

    /**
     * Table name for node relations
     *
     * @var string
     */
    protected $_relation_table_name;

    public function __construct(KConfig $config)
    {
        parent::__construct($config);

        $this->_table_name = $this->getTable()->getName();
        $this->_relation_table_name = $this->getTable()->getRelationTable();

        if (empty($this->_relation_table_name)) {
            throw new KDatabaseRowException('Relation table cannot be empty');
        }

        $this->mixin(clone $this->getTable()->getBehavior('node'));
    }

    /**
     *
     * Move the row and all its descendants to a new position
     *
     * @link http://www.mysqlperformanceblog.com/2011/02/14/moving-subtrees-in-closure-table/
     *
     * @param  int     $target_id Target to move the subtree under
     * @return boolean Result of the operation
     */
    public function move($target_id)
    {
        $query = 'DELETE a FROM #__%1$s AS a'
            . ' JOIN #__%1$s AS d ON a.descendant_id = d.descendant_id'
            . ' LEFT JOIN #__%1$s AS x ON x.ancestor_id = d.ancestor_id AND x.descendant_id = a.ancestor_id'
            . ' WHERE d.ancestor_id = %2$d AND x.ancestor_id IS NULL';

        $result = $this->getTable()->getDatabase()->execute(sprintf($query, $this->_relation_table_name, $this->id));

        $query = 'INSERT INTO #__%1$s (ancestor_id, descendant_id, level)'
            . ' SELECT a.ancestor_id, b.descendant_id, a.level+b.level+1'
            . ' FROM #__%1$s AS a'
            . ' JOIN #__%1$s AS b'
            . ' WHERE b.ancestor_id = %2$d AND a.descendant_id = %3$d';

        $result = $this->getTable()->getDatabase()->execute(sprintf($query, $this->_relation_table_name, $this->id, $target_id));

        return $result;
    }

    /**
     * Get relatives of the row
     *
     * @param string $type  ancestors or descendants
     * @param int    $level Filters results by the level difference between ancestor and the row, ComMakundiDatabaseRowNode::FETCH_ALL_LEVELS for all
     *
     * @return KDatabaseRowsetAbstract
     */
    public function getRelatives($type, $level = ComMakundiDatabaseRowNode::FETCH_ALL_LEVELS)
    {
        if (empty($type) || !in_array($type, array('ancestors', 'descendants'))) {
            throw new InvalidArgumentException('Unknown type value');
        }

        if (!$this->id && $type === 'ancestors') {
            return $this->getTable()->getRowset();
        }

        $id_column = $this->getTable()->getIdentityColumn();

        $join_column  = $type === 'ancestors' ? 'r.ancestor_id'   : 'r.descendant_id';
        $where_column = $type === 'ancestors' ? 'r.descendant_id' : 'r.ancestor_id';

        $query = $this->getTable()->getDatabase()->getQuery();
        $query->select('tbl.*')
            ->select('COUNT(crumbs.ancestor_id) AS level')
            ->select('GROUP_CONCAT(crumbs.ancestor_id ORDER BY crumbs.level DESC SEPARATOR \'/\') AS path')
            ->from('#__'.$this->_table_name.' AS tbl')
            ->join('inner', '#__'.$this->_relation_table_name.' AS crumbs', 'crumbs.descendant_id = tbl.'.$id_column)
            ->group('tbl.'.$id_column)
            ->order('path', 'ASC');

        if ($level !== ComMakundiDatabaseRowNode::FETCH_ALL_LEVELS) {
            if ($this->id) {
                $query->where('r.level', 'IN', $level);
            } else {
                $query->having('level IN ('.implode(',', (array) $level).')');
            }
        }

        if ($this->id) {
            $query->join('inner', '#__'.$this->_relation_table_name.' AS r', $join_column.' = crumbs.descendant_id')
                ->where($where_column, 'IN', $this->id)
                ->where('tbl.makundi_category_id', 'NOT IN', $this->id);
        }

        return $this->getTable()->select($query, KDatabase::FETCH_ROWSET);
    }

    /**
     * Returns the siblings of the row
     *
     * @return KDatabaseRowAbstract
     */
    public function getSiblings()
    {
        $parent = $this->getParent();

        return $parent ? $parent->getDescendants(1) : $this->getTable()->getRow()->getDescendants(1);
    }

    /**
     * Returns the first ancestor of the row
     *
     * @return KDatabaseRowAbstract|null Parent row or null if there is no parent
     */
    public function getParent()
    {
        return $this->getRelatives('ancestors', 1)->top();
    }

    /**
     * Get ancestors of the row
     *
     * @param int $level Filters results by the level difference between ancestor and the row, ComMakundiDatabaseRowNode::FETCH_ALL_LEVELS for all
     *
     * @return KDatabaseRowsetAbstract A rowset containing all ancestors
     */
    public function getAncestors($level = ComMakundiDatabaseRowNode::FETCH_ALL_LEVELS)
    {
        return $this->getRelatives('ancestors', $level);
    }

    /**
     * Get descendants of the row
     *
     * @param int|array $level Filters results by the level difference between descendant and the row, ComMakundiDatabaseRowNode::FETCH_ALL_LEVELS for all
     *
     * @return KDatabaseRowsetAbstract A rowset containing all descendants
     */
    public function getDescendants($level = ComMakundiDatabaseRowNode::FETCH_ALL_LEVELS)
    {
        return $this->getRelatives('descendants', $level);
    }

    /**
     * Checks if the given row is a descendant of this one
     *
     * @param  int|object $target Either an integer or an object with id property
     * @return boolean
     */
    public function isDescendantOf($target)
    {
        $target_id = is_object($target) ? $target->id : $target;

        return $this->_checkRelationship($this->id, $target_id);
    }

    /**
     * Checks if the given row is an ancestor of this one
     *
     * @param  int|object $target Either an integer or an object with id property
     * @return boolean
     */
    public function isAncestorOf($target)
    {
        $target_id = is_object($target) ? $target->id : $target;

        return $this->_checkRelationship($target_id, $this->id);
    }

    /**
     * Checks if an ID is descendant of another
     *
     * @param int $descendant Descendant ID
     * @param int $ancestor   Ancestor ID
     *
     * @return boolean True if descendant is a child of the ancestor
     */
    protected function _checkRelationship($descendant, $ancestor)
    {
        if (empty($this->id)) {
            return false;
        }

		if($behavior = $this->getTable()->getBehavior('translatable')) {
			$this->getTable()->getCommandChain()->dequeue($behavior);
		}

        $query = $this->getTable()->getDatabase()->getQuery();
        $query->select('COUNT(*)')
            ->from('#__'.$this->_relation_table_name.' AS r')
            ->where('r.descendant_id', '=', (int) $descendant)
            ->where('r.ancestor_id', '=', (int) $ancestor);

        $result = $this->getTable()->select($query, KDatabase::FETCH_FIELD);

		$this->getTable()->getCommandChain()->enqueue($behavior);

		return (bool) $result;
    }

    public function __get($property)
    {
        if ($property === 'parent_ids') {
            $pieces = array_map('intval', explode('/', $this->path));
            array_pop($pieces);

            return $pieces;
        }

        if ($property === 'parent_path') {
            return substr($this->path, 0, strrpos($this->path, '/'));
        }

        if ($property === 'slug_path' && empty($this->_data['slug_path'])) {
            $this->_data['slug_path'] = $this->getSlugPath();
        }

        return parent::__get($property);
    }

    public function getSlugPath()
    {
		if($behavior = $this->getTable()->getBehavior('translatable')) {
			$this->getTable()->getCommandChain()->dequeue($behavior);
		}

		$iso_code = substr(JFactory::getLanguage()->getTag(), 0, 2);

		if($iso_code != 'en') {
			$table = $iso_code.'_'.$this->_table_name;
		} else {
			$table = $this->_table_name;
		}

        $query = $this->getTable()->getDatabase()->getQuery();
        $query->select('GROUP_CONCAT(c.slug SEPARATOR \'/\')')
            ->from('#__'.$this->_relation_table_name.' AS r')
            ->join('left', $table.' AS c', 'c.makundi_category_id = r.ancestor_id')
            ->where('r.descendant_id', '=', (int) $this->id)
            ->order('r.level', 'desc')
            ;

		$result = $this->getTable()->select($query, KDatabase::FETCH_FIELD);

		$this->getTable()->getCommandChain()->enqueue($behavior);

		return $result;
    }
}
