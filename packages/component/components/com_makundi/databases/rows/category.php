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
		$result = $this->getService('com://site/articles.model.articles')->category_id($this->id)->featured(1)->getList();

		if($result->count() > 0) {
			$result = $result->top();
		} else {
			$result = null;
		}

		return $result;
	}
}