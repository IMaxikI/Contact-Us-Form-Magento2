<?php

namespace Test\Form\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Test\Form\Model\ContactUsFactory;
use Test\Form\Model\ContactUsRepository;


class Submit implements ActionInterface
{
    public const EMAIL_TEMPLATE_ID = 'test_form_contact_us';

    public const SEND_TO_EMAIL = 'test@gmail.com';

    public const SENDER_NAME = 'Contact Us Form';

    public const SENDER_EMAIL = 'contactus@gmail.com';

    public const NAME_PARAM = 'name';

    public const EMAIL_PARAM = 'email';

    public const MESSAGE_PARAM = 'message';

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var RedirectInterface
     */
    private $redirect;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ContactUsFactory
     */
    private $contactUsFactory;

    /**
     * @var ContactUsRepository
     */
    private $contactUsRepository;

    public function __construct(
        ResultFactory           $resultFactory,
        RequestInterface        $request,
        RedirectInterface       $redirect,
        MessageManagerInterface $messageManager,
        TransportBuilder        $transportBuilder,
        StoreManagerInterface   $storeManager,
        ContactUsFactory        $contactUsFactory,
        ContactUsRepository     $contactUsRepository
    )
    {
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->redirect = $redirect;
        $this->messageManager = $messageManager;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->contactUsFactory = $contactUsFactory;
        $this->contactUsRepository = $contactUsRepository;
    }

    public function execute()
    {
        $storeId = (int)$this->storeManager->getStore()->getId();

        $name = $this->request->getParam(self::NAME_PARAM);
        $email = $this->request->getParam(self::EMAIL_PARAM);
        $message = $this->request->getParam(self::MESSAGE_PARAM);

        $vars = [
            'name' => $name,
            'email' => $email,
            'message' => $message
        ];

        $sender = [
            'name' => self::SENDER_NAME,
            'email' => self::SENDER_EMAIL
        ];

        $options = [
            'area' => Area::AREA_FRONTEND,
            'store' => $storeId
        ];

        try {
            $this->transportBuilder->setTemplateIdentifier(
                self::EMAIL_TEMPLATE_ID
            )->setTemplateOptions(
                $options
            )->setTemplateVars(
                $vars
            )->setFromByScope(
                $sender
            )->addTo(
                self::SEND_TO_EMAIL
            );

            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();

            $this->messageManager->addSuccessMessage(__('Message sent successfully.'));

            $contactUs = $this->contactUsFactory->create();
            $contactUs->setName($name);
            $contactUs->setEmail($email);
            $contactUs->setMessage($message);

            $this->contactUsRepository->save($contactUs);
        } catch (\Exception $ex) {
            $this->messageManager->addErrorMessage(__($ex->getMessage()));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->redirect->getRefererUrl());

        return $resultRedirect;
    }
}