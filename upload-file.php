<?php
	//ini_set('display_errors', 1);
	require_once "dropbox-sdk/Dropbox/autoload.php";

	use \Dropbox as dbx;

	$dropbox_config = array(
		'key'    => 'syq6vh0vl1v8ea7',
		'secret' => 'lbuflaj0ebpmh9k'
	);

	/*$appInfo = dbx\AppInfo::loadFromJson($dropbox_config);
	$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");

	$authCode = trim('4DK3_Q9x-YAAAAAAAAAAHz3BBrKOCXeOow_7R_3J4AI');

	$authorizeUrl = $webAuth->start();
	echo "1. Go to: " . $authorizeUrl . "<br>";
	echo "2. Click \"Allow\" (you might have to log in first).<br>";
	echo "3. Copy the authorization code and insert it into $authCode.<br>";



	list($accessToken, $dropboxUserId) = $webAuth->finish($authCode);
	echo "Access Token: " . $accessToken . "<br>";*/
	


   $accessToken ='4DK3_Q9x-YAAAAAAAAAAIEvfRdnXbU3Obrl8R27pBZoP7ObNXLsu2PGAegycvgAE';
   $dbxClient = new dbx\Client($accessToken, "PHP-Example/1.0");



	$fa = fopen("data-a.csv", "w+b");
	$fileMetadata_a = $dbxClient->getFile("/data-a.csv", $fa);
	fclose($fa);
	print_r($fileMetadata_a);

	$fb = fopen("data-b.csv", "w+b");
	$fileMetadata_b = $dbxClient->getFile("/data-b.csv", $fb);
	fclose($fb);
	print_r($fileMetadata_b);

	
	$file_a = 'data-a.csv';
	$file_b = 'data-b.csv';
    $output_a = 'final_a.csv';
    $output_b = 'final_b.csv';
	
	if (false !== ($ih = fopen($file_a, 'r'))) {
		$oh = fopen($output_a, 'w');

		while (false !== ($data = fgetcsv($ih))) {
			$outputData = array($data[1], $data[3], $data[5], $data[6]);
			fputcsv($oh, $outputData);
		}
		fclose($ih);
		fclose($oh);
    }
    
    if (false !== ($ih = fopen($file_b, 'r'))) {
		$oh = fopen($output_b, 'w');

		while (false !== ($data = fgetcsv($ih))) {
			// this is where you build your new row
			$outputData = array($data[1], $data[3], $data[4]);
			fputcsv($oh, $outputData);
		}
		fclose($ih);
		fclose($oh);
    }
	


	$fh = fopen('final_a.csv', 'r');
	$fhg = fopen('final_b.csv', 'r');
	
	while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
		$csv_data_a[]=$data;
	}
	while (($data = fgetcsv($fhg, 0, ",")) !== FALSE) {
		$csv_data_b[]=$data;
	}
	
	foreach($csv_data_a as $k=>$v){
		foreach($csv_data_b[$k] as $val){
			$csv_data_a[$k][] = $val;
		}
	}
        
        
    $fp = fopen('final.csv', 'w');//output file set here

	foreach ($csv_data_a as $fields) {
		fputcsv($fp, $fields);
	}
	fclose($fp);
        
        
	// Uploading the file
	$f = fopen("final.csv", "rb");
	$result = $dbxClient->uploadFile("/final.csv", dbx\WriteMode::add(), $f);
	fclose($f);
	print_r($result);
        
      
?>
