<?php

class ComMakundiDatabaseRowCategory extends ComMakundiDatabaseRowNode
{
    /**
     * @param KConfig $config
     */
    public function __construct(KConfig $config)
    {
        parent::__construct($config);

        $this->mixin(clone $this->getTable()->getBehavior('orderable'));
    }

	public function getFeatured()
	{
		$result = $this->getService('com://site/articles.model.articles')->category_id($this->id)->featured(1)->getItem();

		if ($result->isNew()) {
			$result = null;
		}

		return $result;
	}

	public function __get($column)
	{
		if($column == 'slug_path') {
			return $this->getSlugPath();
		}

		return parent::__get($column);
	}
}