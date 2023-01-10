<?php
namespace Brainvire\QA\Block;

class QA extends \Magento\Framework\View\Element\Template
{
	protected $_productRepository;
	public $testCollection;
	protected $registry;
	protected $customerSession;

	public function __construct(
	\Magento\Customer\Model\SessionFactory $customerSession,
	\Magento\Framework\View\Element\Template\Context $context,
	\Brainvire\QA\Model\ResourceModel\Test\CollectionFactory $testCollection,
	\Magento\Store\Model\StoreManagerInterface $storeManager,
	\Magento\Framework\Registry $registry,
	\Magento\Catalog\Model\Product $product,
	array $data = []
	){
	$this->customerSession = $customerSession;
	$this->testCollection = $testCollection;
	$this->_registry = $registry;
	$this->product = $product;
	$this->storeManager = $storeManager;
	parent::__construct($context, $data,);
	}
	
	public function getStoreId()
	{
		return $this->storeManager->getStore()->getId();
	}

	public function getCustomerId()
	{
		return $this->customerSession->create()->getCustomer()->getId();
		// return parent::getCustomerId();
	}
	public function getCustomerName()
	{
		return $this->customerSession->create()->getCustomer()->getName();
		// return parent::getCustomerName();
	}
	public function getCustomerEmail()
	{
		return $this->customerSession->create()->getCustomer()->getEmail();
		// return parent::getCustomerEmail();
	}
	public function getTests()
	{
		$collection = $this->testCollection->create();
		return $collection;
	}
	public function getCurrentProduct()
	{
		return $this->_registry->registry('product'); 
	}
	public function getCustomAttribute()
	{
		return $this->product->load($this->getCurrentProduct()->getId())->getQuestion();
	}
}