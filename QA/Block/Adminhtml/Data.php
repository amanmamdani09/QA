<?php
namespace Brainvire\QA\Block\Adminhtml;

class Data extends \Magento\Framework\View\Element\Template
{
	protected $_productRepository;
	public $testCollection;
	protected $registry;

	public function __construct(
	\Magento\Framework\View\Element\Template\Context $context,
	\Brainvire\QA\Model\ResourceModel\Test\CollectionFactory $testCollection,
	\Magento\Framework\Registry $registry,
	\Magento\Catalog\Model\Product $product,
	array $data = []
	){
	$this->testCollection = $testCollection;
	$this->_registry = $registry;
	$this->product = $product;
	parent::__construct($context, $data,);
	}
	
	public function getId()
	{
		return $this->testCollection->create()->getData('id');
	}

	public function getCollection()
	{
		$collection = $this->testCollection->create()
		->addFieldToFilter('status', 1);
	}
}