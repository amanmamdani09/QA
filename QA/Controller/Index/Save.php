<?php
namespace Brainvire\QA\Controller\Index;

use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
 
class Save extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_contactFactory;
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Brainvire\QA\Model\TestFactory $testFactory,
        \Brainvire\QA\Helper\Data $helperData,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder
    ) {
        $this->_pageFactory = $pageFactory;
        $this->testFactory = $testFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->helperData = $helperData;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
         return parent::__construct($context);
    }
 
    public function execute()
    {    
        $this->validatedParams();    
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if ($this->getRequest()->isPost()) {
             $input = $this->getRequest()->getPostValue();
             // echo "<pre>";
             // print_r($input);
             // die;
             $postData = $this->testFactory->create();
            if (isset($input['id'])) {
                $id = $input['id'];
            } else {
                $id = 0;
            }
            if ($id != 0) {
                 $postData->load($id);
                 $postData->addData($input);
                 $postData->setId($id);
                 $postData->save();
            } else {
                 $postData->setData($input)->save();
                 $this->helperData->sendEmail($input['email']);
                 // $this->sendEmail($input['email']);
            }
            // $this->messageManager->addSuccessMessage("Data Sent successfully");
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }
         $this->messageManager->addSuccessMessage("Data Sent successfully");
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
    }

    private function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('name')) === '') {
            throw new LocalizedException(__('Name is missing'));
        }

        if (false === \strpos($request->getParam('email'), '@')) {
            throw new LocalizedException(__('Invalid Email address'));
        }
       
        if (trim($request->getParam('question')) === '') {
            throw new LocalizedException(__('Question is missing'));
        }
        //Add your more validations here
        return $request->getParams();
    }

}