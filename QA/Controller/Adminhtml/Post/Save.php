<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Brainvire\QA\Controller\Adminhtml\Post;

use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;
    protected $inlineTranslation;
    protected $transportBuilder;
    protected $escaper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Brainvire\QA\Helper\Data $helperData,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->helperData = $helperData;
        $this->transportBuilder = $transportBuilder;
        $this->escaper = $escaper;
        $this->inlineTranslation = $inlineTranslation;
        return parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = (array)$this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('id');
        
            $model = $this->_objectManager->create(\Brainvire\QA\Model\Test::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Question no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            $model->setData($data);
            $status_id = $data['status'];

            $question = $data['question'];
            $this->question = $question;

            $answer = $data['answer'];
            $this->answer = $answer;
            // die();
        
            try {
                $model->save();
                if($status_id==0){
                $this->helperData->sendNEmail($data['email']);
                }
                if($status_id==1){
                $this->sendAEmail($data['email']);
                }
                $this->messageManager->addSuccessMessage(__('You saved the Question.'));
                $this->dataPersistor->clear('brainvire_qa_faq');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } 
            catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Faq.'));
            }
        
            $this->dataPersistor->set('brainvire_qa_faq', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);

        }
        return $resultRedirect->setPath('*/*/');
    }

    public function sendAEmail($data)
    {
        try {
            $this->inlineTranslation->suspend();
            $sender =
            [
                    'name' => $this->escaper->escapeHtml('Aman'),
                    'email' =>$this->escaper->escapehtml('aman.mamdani@brainvire.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('qa2')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    "question" => $this->question,
                    "answer" => $this->answer,
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