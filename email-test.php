<?php @ob_start();
////////////////////////////Send Email///////////////////////////////////////
							   // $to ="diet@lifeheal.in,st.homespice@gmail.com, junior@lifeheal.in,jasmine.chanana@lifeheal.in";
								$to ="st.homespice@gmail.com";
								//$to ="test@startlifeheal.com";
								$from ='shailesh33260@gmail.com';
								
								$name ="Tester";
                                $message="This is test message";
								   // Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= "From: ".$from . "\r\n";
								$subject = "A new lead filled the contact form.";
								$customeMessage="Hi, a new lead ".$name.", filled the home page contact form on ".date("d-m-Y")."<br><br> His message is as below.<br><br>";
								$customeMessage.=$message;
								if(mail($to,$subject,$customeMessage,$headers) ) { echo "Thank you <b>".ucfirst($name)."</b> we will contact you soon"; }
								else { echo "Sorry, we did not get your email.";}
					
								
				
							 ///////////////////////////////////////////////////////////////////
							 
							 echo "email sent";
							 
							 ?>