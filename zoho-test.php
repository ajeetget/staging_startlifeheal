<?php 

    ini_set('max_execution_time', 300000);
    define('MAGENTO', realpath(dirname(__FILE__)));
	require_once MAGENTO . '/app/Mage.php';
	Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
	
	////////////////////////// Start Creating Zoho Lead ////////////////////
					
					$zoho_access_token = Mage::helper("heal")->generate_Zoho_access_token();
					$post_data = [
		               'data'=>[
					             [
								   
									  
									 "First_Name"        => 'Ajeet',
									 "Last_Name"         => 'Kumar',  
									 "Email"             => 'ajeet@gmail.com',    //mandatory
									  "Mobile"           => '', 
									 "Description"       => '',
									 "Company"           =>""
									
								 ]
					           ],
		               
					  'trigger'=>[
					                "approval",
									"workflow",
									"blueprint"
								 ]
					];			 
		
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,"https://zohoapis.in/crm/v2/Leads");
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Zoho-oauthtoken '.$zoho_access_token,
					'Content-type: application/x-www-form-urlencoded')
					);

					$response = curl_exec($ch);
					$response = json_decode($response);
					
					echo "Lead created";
					///////////////////////// End Creating Zoho Lead ///////////////////////
	
	?>