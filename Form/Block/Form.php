<?php

namespace Test\Form\Block;

use Magento\Framework\View\Element\Template;

class Form extends Template
{
    public const FORM_ACTION = 'form/index/submit';

    public function getFormAction(): string
    {
        return $this->getUrl(self::FORM_ACTION);
    }
}