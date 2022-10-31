<?php

namespace Test\Form\Model;

use Test\Form\Model\ContactUsFactory;
use Test\Form\Model\ResourceModel\ContactUs as ContactUsAliasResource;

class ContactUsRepository
{
    /**
     * @var ContactUsFactory
     */
    private $contactUsFactory;

    /**
     * @var ContactUsAliasResource
     */
    private $contactUsResource;

    public function __construct(
        ContactUsFactory       $contactUsFactory,
        ContactUsAliasResource $contactUsResource
    )
    {
        $this->contactUsFactory = $contactUsFactory;
        $this->contactUsResource = $contactUsResource;
    }

    public function getById(int $id): ContactUs
    {
        $contactUs = $this->contactUsFactory->create();

        $this->contactUsResource->load($contactUs, $id);

        return $contactUs;
    }

    public function save(ContactUs $contactUs): ContactUs
    {
        $this->contactUsResource->save($contactUs);

        return $contactUs;
    }

    public function deleteById(int $id): void
    {
        $contactUs = $this->contactUsFactory->create();

        $this->contactUsResource->load($contactUs, $id);

        $this->contactUsResource->delete($contactUs);
    }
}