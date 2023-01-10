<?php
namespace Brainvire\QA\Block\Adminhtml\Module\Grid\Renderer\Action;

class urlBuilder {
/**
* @var \Magento\Framework\UrlInterface
*/
protected $frontendurlBuilder;
/**
* @param \Magento\Framework\UrlInterface $frontendurlBuilder
*/
public function __construct(\Magento\Framework\UrlInterface $frontendurlBuilder) {
$this->frontendurlBuilder = $frontendurlBuilder;
}
/**
* Get action url
*
* @param string $routePath
* @param string $scope
* @param string $store
* @return string
*/
public function getUrl($routePath, $scope, $store) {
$this->frontendurlBuilder->setScope($scope);
$href = $this->frontendurlBuilder->getUrl($routePath, ['_current' => false, '_query' => '___store=' . $store]);
return $href;
    }
}