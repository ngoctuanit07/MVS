<?php 
/*
 * Create Product And Product Auction Using Magento API 
 * @author Vimal Parihar - A3Logics (I) Ltd
 * Version 1.0
*/
//include_once "../app/Mage.php";
include_once "/opt/lampp/htdocs/eshoppingmall/app/Mage.php";
//include_once "/home/allteama/public_html/app/Mage.php";
Mage::init();

ini_set("max_execution_time", 0);

for ($i = 1; $i <= 9; $i++) {
    $process = Mage::getModel('index/process')->load($i);
    $process->reindexAll();
}

echo "Success";


?>
