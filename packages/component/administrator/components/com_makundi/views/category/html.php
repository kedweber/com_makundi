<?php

class ComMakundiViewCategoryHtml extends ComDefaultViewHtml
{
    /**
     * @return mixed
     */
    public function display()
    {
        $this->assign('parent', $this->getModel()->getItem()->getParent());

        return parent::display();
    }
}
