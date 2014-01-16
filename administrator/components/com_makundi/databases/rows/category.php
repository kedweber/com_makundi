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
}