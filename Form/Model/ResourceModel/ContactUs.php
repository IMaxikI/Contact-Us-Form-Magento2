<?php

namespace Test\Form\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ContactUs extends AbstractDb
{
    public const TABLE_NAME = 'test_form_contact_us';

    public const ID_FIELD_NAME = 'id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}