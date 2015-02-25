<?php 
include_once "app/Mage.php";
Mage::init();


if (!mkdir('mydir',0777,true)) {
    die('Failed to create folders. here..');
}
else
{
	echo "folder created";
}

die;

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
$root_path=Mage::getBaseDir();
$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
$skin_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
$media_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA); 
$js_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);

		$website_name='vimal';
		$file_name=$root_path."/index_website.php";
		$file_cng_path=$root_path."/testcreate/".$website_name."/index.php";
		
		//Create Folder for website and copy 2 files Start
		//mkdir($root_path."/".$website_name, 0755);
		if (!mkdir($root_path."/".$website_name, 0777, true)) {
    		die('Failed to create folders...');
		}
		
		
		copy($file_name, $file_cng_path);
		copy($root_path."/.htaccess", $root_path."/testcreate/".$website_name."/.htaccess");
		//Create Folder for website and copy 2 End
		
		//Edit index.php file for change website name Start 
		$filecontent=file_get_contents($file_cng_path);
		$pos=strpos($filecontent, 'Mage::run($mageRunCode, $mageRunType)');
		$string='Mage::run("'.$website_name.'", "website");';
		$filecontent=substr($filecontent, 0, $pos)."\r\n".$string."\r\n".substr($filecontent, $pos);
		$filecontent=str_replace('Mage::run($mageRunCode, $mageRunType);','',$filecontent);
		file_put_contents($file_cng_path, $filecontent);
		//Edit index.php file for change website name End

?>