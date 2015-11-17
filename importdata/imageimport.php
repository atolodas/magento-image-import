<?php 
ini_set('memory_limit', '-1');
ini_set('display_error', '1');
error_reporting(E_ALL);

require_once '../app/Mage.php';
Mage::app('admin');

#List of Siumple Product SKU
echo "<pre>";
$simple_product = array();
$row = 1;
$CsvFilePath = 'imageassign.csv';
$connectionRead = Mage::getSingleton('core/resource')->getConnection('core_read');
$write = Mage::getSingleton('core/resource')->getConnection('core_write');
if (($handle = fopen($CsvFilePath, "r")) !== FALSE)
 {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
	{
		if($row==1){ $row++; continue;}
		$attributesetid  = Mage::getModel('catalog/product')->getDefaultAttributeSetId();
		$product = Mage::getModel('catalog/product');
		$product_sku = $data[0]; 
		$product_id_new = Mage::getModel('catalog/product')->getIdBySku($product_sku);
		$image =  Mage::getBaseDir('media') . '/import' .$data[1];
		$imagethumb =  Mage::getBaseDir('media') . '/import' .$data[2];
		$imagesmall =  Mage::getBaseDir('media') . '/import' .$data[3]; 
		$product = Mage::getModel('catalog/product')->load($product_id_new);
		$product->addImageToMediaGallery($image, array('image'), false, false);
		$product->addImageToMediaGallery($imagesmall, array('small_image'), false, false);
		$product->addImageToMediaGallery($imagethumb, array('thumbnail'), false, false);
		 
		try
		{   
		$product->save();
		}
		catch(Exception $e)
		{
		echo $e;
		}
		
				
		
		
		
        
	$row++;	
	
 	}
 	
	$product->save();
	var_dump('values have been applied successfully');
 fclose($handle);
 }
?>