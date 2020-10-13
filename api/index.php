<?php 

$some_data = array(
			'userSecretKey'=> 'v1gc99hq-vfih-91gm-gu1s-46xxkrzxdehu',
			);
			
			
		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_POST, 1);
		  curl_setopt($curl, CURLOPT_URL, 'https://skyhint.com/api/toyyib.php');  
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

		  $result = curl_exec($curl);
		  $info = curl_getinfo($curl , CURLINFO_HTTP_CODE);   
		  curl_close($curl);
		  $obj = json_decode($result);
		  
		 echo $info . $result;die();


?>