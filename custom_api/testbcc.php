<?php
include_once "../app/Mage.php";
Mage::init();

<?php 
$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
						$select = $connection->select()
						->from ('merchant', 'email')
						->where ("status= '0' ");
						$rowsArray = $connection->fetchAll($select);
$emails = array();

foreach ($rowsArray as $v1)
{
	$emails[] = $v1['email'];
}
echo "<pre>";
print_r($emails);
die;
?>
<?php

$emails = array("vishwas.bhatnagar@a3logics.in", "vimalparihar@gmail.com", "vishwasbhatnagar@ymail.com");
						
						   //Code For send email to merchant with product url Start	
							$merchant_name='Merchant';
							$reply_to='vishwas.bhatnagar@a3logics.in';
							
							$templateId = 6; // Id is that created in admin email template 
							$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
							$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
							$sender = Array('name' => $from_name,'email' => $from_email);
							$storeId = Mage::app()->getStore()->getId();
							$translate = Mage::getSingleton('core/translate');
							Mage::getModel('core/email_template')
							->addBcc($emails)
							->sendTransactional($templateId, $sender, $reply_to, $from_name, $vars, $storeId);
							$translate->setTranslateInline(true); 
							/* Event Invite Mail Code End */
							?>