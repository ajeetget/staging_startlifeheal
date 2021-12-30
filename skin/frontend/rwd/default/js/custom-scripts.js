  function addItemToCart(productid)  
  {
	 // alert(productid);
	  // var baseUrl = window.location.origin;
	   var addtocartURL = window.location.origin+"/checkout/cart/addproducttocart?id="+productid; 
	   window.location.href = addtocartURL;
		return; 
  } 
  
  function checknewsletter()
  {
    var email = jQuery("#newsletter-email").val();
	jQuery.ajax({
						url: window.location.origin+'/override/index/addnewslettertozoholead',
						type: "POST",
						data: {
						    email: email						    
						},
						  success: function(response)
						 {  
					       jQuery("#msg").html(response);
						   jQuery("#msg").show("slow").delay(3000).hide("slow");
					     }
			});
		

	}
	
 