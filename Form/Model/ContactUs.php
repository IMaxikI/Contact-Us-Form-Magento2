<?php

namespace Test\Form\Model;

use Magento\Framework\Model\AbstractModel;
use Test\Form\Model\ResourceModel\ContactUs as ContactUsResource;

class ContactUs extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ContactUsResource::class);
    }
}