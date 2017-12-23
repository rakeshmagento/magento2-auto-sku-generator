<?php
namespace Rakeshmagento\Autosku\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;

class Modifysku extends AbstractModifier
{
	public function modifyMeta(array $meta)
    {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

    	$scopeConfig = $objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface');
    	
	    $enabled 	 =  $scopeConfig->getValue(
	        				'autosku_section/general/enabled',
	        				\Magento\Store\Model\ScopeInterface::SCOPE_STORE
	    				);
	    $prefix   	 =  $scopeConfig->getValue(
	        				'autosku_section/general/prefix',
	        				\Magento\Store\Model\ScopeInterface::SCOPE_STORE
	    				);	
	    $increment 	 = $scopeConfig->getValue(
	        				'autosku_section/general/increment',
	        				\Magento\Store\Model\ScopeInterface::SCOPE_STORE
	    				);
	    $length 	= $scopeConfig->getValue(
	        				'autosku_section/general/sku_length',
	        				\Magento\Store\Model\ScopeInterface::SCOPE_STORE
	    				);
    	
	    if($enabled){

	    	$defaultSku = $this->_buildSku($prefix, $increment, $length);

	    	$meta['product-details']
	    			['children']
	    				['container_sku']
	    					['children']
	    						['sku']
	    							['arguments']
	    								['data']
	    									['config']
	    										['value'] = $defaultSku;
	    }
    	return $meta;
    }


    public function modifyData(array $data)
    {
        return $data;
    }

    private function _buildSku($_prefix, $_increment, $_length){

    	$skuToassign = '';
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

    	/** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection */
		$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
		/** Apply filters here */
		$collection = $productCollection
						->addAttributeToFilter(
      						[
       							['attribute' => 'sku', 'like' => $_prefix.'%']
      						]
      					)
      					->setOrder('entity_id','DESC')
      					->setPageSize(1)
		            	->load();
		
		
		if($collection->getSize() > 0){
			
			$product  			= 	$collection->getFirstItem();
			$lastMacthedSku 	=	$product->getSku();
			$findLastIncrement 	=   (int) preg_replace('/[^0-9]/', '', $lastMacthedSku);
			$nextInrement   	= 	++$findLastIncrement;
			$incrementLength 	= 	strlen($findLastIncrement) + strlen($_prefix);// 
			$skuToassign 		=	$_prefix.str_pad(
												$skuToassign,
												($_length - $incrementLength ),
												0
											).$nextInrement;

		}else{

			$subtractLength = strlen($_prefix) + strlen($_increment);
			$skuToassign = $_prefix.str_pad(
												$skuToassign,
												($_length - $subtractLength ),
												0
											).$_increment;

		}
		return $skuToassign;
    }
}