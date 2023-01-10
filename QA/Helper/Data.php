<?php

namespace Brainvire\QA\Helper;

use Magento\Framework\Escaper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    protected $transportBuilder;
    protected $storeManager;
    protected $inlineTranslation;
    protected $escaper;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        StateInterface $state
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        $this->escaper = $escaper;
        parent::__construct($context);
    }

    public function sendEmail($input)
    {
        try {
            $this->inlineTranslation->suspend();
            $sender =
            [
                    'name' => $this->escaper->escapeHtml('Aman'),
                    'email' =>$this->escaper->escapehtml('aman.mamdani@brainvire.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('qa1')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                ])
                ->setFrom($sender)
                ->addTo($input)
                ->getTransport();
                $transport->sendMessage();
                $this->inlineTranslation->resume();
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
    
    public function sendNEmail($data)
    {
        try {
            $this->inlineTranslation->suspend();
            $sender =
            [
                    'name' => $this->escaper->escapeHtml('Aman'),
                    'email' =>$this->escaper->escapehtml('aman.mamdani@brainvire.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('qa3')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                ])
                ->setFrom($sender)
                ->addTo($data)
                ->getTransport();
                $transport->sendMessage();
                $this->inlineTranslation->resume();
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}