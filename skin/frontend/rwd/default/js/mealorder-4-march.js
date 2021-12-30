// var baseUrl = 'http://localhost/curemydiabetes/index.php';
 var unitofnutritionDatabase =100; 
 var baseUrl = window.location.origin;
jQuery(document).ready(function (){
    var table = jQuery('#example').DataTable({
        'responsive': true, "order": [[ 0, "desc" ]],
		"searching": true
    });
	
	jQuery('#example tbody').on( 'click', 'tr td.details-control', function () {   
        var tr = jQuery(this).closest('tr');
        var row = table.row( tr );
      
		var orderid = tr.attr('id');
		var mealAllowedOrNot = 	jQuery("#"+orderid+"_isAllowedMeal").val();	
		if(mealAllowedOrNot=='yes')
		{
		jQuery.ajax({
				 url:baseUrl+'/heal/index/getrowdata',
				 type:"POST",
				 data:{
						 orderid:orderid
					 },
					 dataType: 'JSON',
					  beforeSend: function(){
                          
                          jQuery(".loader").css("display", "block"); 
						  
						  jQuery("tr.child td.child ul li[data-dt-column='7'] ").css("display", "none"); 
						  jQuery("tr.child td.child ul li[data-dt-column='8'] ").css("display", "none");
						  jQuery("tr.child td.child ul li[data-dt-column='9'] ").css("display", "none");
						  jQuery("tr.child td.child ul li[data-dt-column='10'] ").css("display", "none");
                        },
				      success:function(response)
					  {     
						   var dinnerData = response.dinner;  //alert(dinnerData);
						   var breakfastData = response.breakfast; //alert(breakfastData);
						   var lunchData = response.lunch;
						   var highteaData = response.hightea;
						   var printSaveReviewBtns = response.btnsPrintSaveReview;
						 
						  
						    jQuery("tr.child td.child ul li[data-dt-column='7'] .dtr-title ").text('Dinner');
				            jQuery("tr.child td.child ul li[data-dt-column='7'] .dtr-data ").html(dinnerData);
							
							jQuery("tr.child td.child ul li[data-dt-column='8'] .dtr-title ").text('Breakfast');
							jQuery("tr.child td.child ul li[data-dt-column='8'] .dtr-data ").html(breakfastData);
							
							jQuery("tr.child td.child ul li[data-dt-column='9']  .dtr-title ").text('Lunch');
							jQuery("tr.child td.child ul li[data-dt-column='9']  .dtr-data ").html(lunchData);
							
							jQuery("tr.child td.child ul li[data-dt-column='10'] .dtr-title ").text('Hitea');
							jQuery("tr.child td.child ul li[data-dt-column='10'] .dtr-data ").html(highteaData);
							
							jQuery("tr.child td.child ul li[data-dt-column='11'] .dtr-data ").html(printSaveReviewBtns);
							
							jQuery("tr.child td.child ul li[data-dt-column='7'] ").css("display", "block"); 
						  jQuery("tr.child td.child ul li[data-dt-column='8'] ").css("display", "block");
						  jQuery("tr.child td.child ul li[data-dt-column='9'] ").css("display", "block");
						  jQuery("tr.child td.child ul li[data-dt-column='10'] ").css("display", "block");
				   			   
						  
					   }
					   ,
					   complete:function(data){
						   //tr.removeClass("loader");
						   jQuery(".loader").css("display", "none"); 
					   }
			 });	
		}else
		{
			  
			jQuery("tr.child").css("display", "none"); 
			alert("Customer Package has expired");
			return false;
		}			
			 
			 
          
    } );
	
    // Handle click on "Expand All" button
    jQuery('#btn-show-all-children').on('click', function(){
        // Expand row details
        table.rows(':not(.parent)').nodes().tojQuery().find('td:first-child').trigger('click');
		
		
    });

    // Handle click on "Collapse All" button
    jQuery('#btn-hide-all-children').on('click', function(){
        // Collapse row details
        table.rows('.parent').nodes().tojQuery().find('td:first-child').trigger('click');
    });
	// Quick & dirty toggle to demonstrate modal toggle behavior
     jQuery('.js-example-basic-single').select2();
	 
	 
	
     
    function format ( d ) {
    return 'Full name: '+d.first_name+' '+d.last_name+'<br>'+
        'Salary: '+d.salary+'<br>'+
        'The child row can contain any data you wish, including links, images, inner tables etc.';
}
	
});

function operation(operand,rowId,productId,textBoxId,unitOfMeasureHiddenId,hiddenRowInfo,labelprotein,labelfat,labelcarbohydrate,labelfiber,labelcalories,hiddenProtein,hiddenFat,hiddenCarbohydrate,hiddenFiber,hiddenCalories,unitofnutrition)
    {
          var textBoxValue =   jQuery("#"+textBoxId).val();
          var unitOfMeasure =   jQuery("#"+unitOfMeasureHiddenId).val();
          var OperatedNewValue= unitOfMeasure;
          if(operand=='plus')
              {
                   OperatedNewValue = parseInt( textBoxValue ) + parseInt(unitOfMeasure);
                  
                    
                    jQuery("."+textBoxId).val( OperatedNewValue);
                    jQuery.ajax({
                    url: baseUrl+'/heal/index/rowupdate',
                    type: "POST",
                    data: {
                      orderid: rowId, 
                      entityid: productId,
                      qty:OperatedNewValue,
                      unitofmeasure:unitOfMeasure,
                      unitofnutritionDatabase:unitofnutritionDatabase
                    },
                     dataType: 'JSON',
                    success: function(response)
                        {  
                        jQuery("#"+hiddenRowInfo).val(response.hiddenRowInfo);
                        jQuery("."+hiddenRowInfo).val(response.hiddenRowInfo);
                            
                        jQuery("#"+labelprotein).text(":"+response.calculatedProtein+" gm");
                        jQuery("."+labelprotein).text(":"+response.calculatedProtein+" gm");

                        jQuery("#"+labelfat).text(":"+response.calculatedFat+" gm");
                        jQuery("."+labelfat).text(":"+response.calculatedFat+" gm");

                        jQuery("#"+labelcarbohydrate).text(":"+response.calculatedCarbohydrates+" gm");
                        jQuery("."+labelcarbohydrate).text(":"+response.calculatedCarbohydrates+" gm");

                        jQuery("#"+labelfiber).text(":"+response.calculatedFiber);
                        jQuery("."+labelfiber).text(":"+response.calculatedFiber);

                        jQuery("#"+labelcalories).text(":"+response.calculatedCalories);
                        jQuery("."+labelcalories).text(":"+response.calculatedCalories);

                        jQuery("#"+hiddenProtein).val(response.calculatedProtein);
                        jQuery("."+hiddenProtein).val(response.calculatedProtein);

                        jQuery("#"+hiddenFat).val(response.calculatedFat);
                        jQuery("."+hiddenFat).val(response.calculatedFat);

                        jQuery("#"+hiddenCarbohydrate).val(response.calculatedCarbohydrates);
                        jQuery("."+hiddenCarbohydrate).val(response.calculatedCarbohydrates);

                        jQuery("#"+hiddenFiber).val(response.calculatedFiber);
                        jQuery("."+hiddenFiber).val(response.calculatedFiber);

                        jQuery("#"+hiddenCalories).val(response.calculatedCalories);
                        jQuery("."+hiddenCalories).val(response.calculatedCalories);

                        doFinalCalculation(rowId,'no','no','no');
                        
                      
                      } 
                    });  
                    
                     
              }
              else if(operand=='minus')
              {
                  OperatedNewValue = parseInt( textBoxValue ) - parseInt(unitOfMeasure);
                  
                   if(OperatedNewValue >= 0)
                     {

                           // jQuery("#"+textBoxId).val( OperatedNewValue);
                            jQuery("."+textBoxId).val( OperatedNewValue);
                            jQuery.ajax({
                            url: baseUrl+'/heal/index/rowupdate',
                            type: "POST",
                            data: {
                              orderid: rowId, 
                              entityid: productId,
                              qty:OperatedNewValue,
                              unitofmeasure:unitOfMeasure,
                              unitofnutritionDatabase:unitofnutritionDatabase
                            },
                             dataType: 'JSON',
                            success: function(response)
                                {  
                     
                                jQuery("#"+hiddenRowInfo).val(response.hiddenRowInfo);
                                jQuery("."+hiddenRowInfo).val(response.hiddenRowInfo);

                                jQuery("#"+labelprotein).text(":"+response.calculatedProtein);
                                jQuery("."+labelprotein).text(":"+response.calculatedProtein);

                                jQuery("#"+labelfat).text(":"+response.calculatedFat);
                                jQuery("."+labelfat).text(":"+response.calculatedFat);

                                jQuery("#"+labelcarbohydrate).text(":"+response.calculatedCarbohydrates);
                                jQuery("."+labelcarbohydrate).text(":"+response.calculatedCarbohydrates);

                                jQuery("#"+labelfiber).text(":"+response.calculatedFiber);
                                jQuery("."+labelfiber).text(":"+response.calculatedFiber);

                                jQuery("#"+labelcalories).text(":"+response.calculatedCalories);
                                jQuery("."+labelcalories).text(":"+response.calculatedCalories);

                                jQuery("#"+hiddenProtein).val(response.calculatedProtein);
                                jQuery("."+hiddenProtein).val(response.calculatedProtein);

                                jQuery("#"+hiddenFat).val(response.calculatedFat);
                                jQuery("."+hiddenFat).val(response.calculatedFat);

                                jQuery("#"+hiddenCarbohydrate).val(response.calculatedCarbohydrates);
                                jQuery("."+hiddenCarbohydrate).val(response.calculatedCarbohydrates);

                                jQuery("#"+hiddenFiber).val(response.calculatedFiber);
                                jQuery("."+hiddenFiber).val(response.calculatedFiber);

                                jQuery("#"+hiddenCalories).val(response.calculatedCalories);
                                jQuery("."+hiddenCalories).val(response.calculatedCalories);
                              
                                doFinalCalculation(rowId,'no','no','no');
								 
                              }
                            });  
                    
                     }
              }
        
        
        
    }
    
    
 
        function doFinalCalculation(id,saveData,print,needConfirmAlert)
	{ 
            
               
               var carbsCalArrayVal = jQuery("#"+id+"_level").val();
             //  alert(carbsCalArrayVal);
               
               var customerLevel       = '';
               var customerLevelCarbs  = '';
               var customerLevelMInCal = '';
               var customerLevelMaxCal = '';
               var checkLevelConditions = false;
               var boolCheckLevelCarbsCalory=false;
               var CarbsCaloryLevelError ='';
               var totalCaloriesTxt = jQuery("#"+id+"_overallCalories").text();
               var totalCarbsTxt    = jQuery("#"+id+"_overallCarbsGram").text();
               
               if(carbsCalArrayVal!='')
               {
                    checkLevelConditions = true; 
                    var carbsCalArray = carbsCalArrayVal.split("_");
                    //alert(carbsCalArrayVal);
                     customerLevel       = parseInt(carbsCalArray[0]);
                     customerLevelCarbs  = parseInt(carbsCalArray[2]);
                     customerLevelMInCal = parseInt(carbsCalArray[3]);
                     customerLevelMaxCal = parseInt(carbsCalArray[4]); 
                     
                     
                     boolCheckLevelCarbsCalory = ( (totalCarbsTxt <= customerLevelCarbs)  )?true:false;
                     $x = "( ("+totalCarbsTxt+" <= "+customerLevelCarbs +  ")  && ("+totalCaloriesTxt +"> "+customerLevelMInCal+" )  && ("+totalCaloriesTxt+" < "+customerLevelMaxCal+" ) )";
                     //  alert("boolCheckLevelCarbsCalory="+boolCheckLevelCarbsCalory);
                     CarbsCaloryLevelError = "Meal's carbs should less than "+customerLevelCarbs;
            
               }
               
               var checkDataOrNot = 'no';
               
             
               ////////////////////////////////////////////////////////////////////////////
               if( saveData=='yes' && checkLevelConditions==true ) // check customer level based carbs and calory while pressed the Save button or Save and Print button
               {
                     //alert(saveData+'==yes && '+boolCheckLevelCarbsCalory+'==true' )
                   if( boolCheckLevelCarbsCalory==true)
                   {
                        if(saveData=='yes' && needConfirmAlert=='yes')
                        {
                               
                                  if(confirm("Do you want to save changes"))
                                  {
                                    checkDataOrNot = 'yes';

                                  }
                                  else { return false;}               
                       }
                       else if(saveData=='yes' && needConfirmAlert=='no')
                       {

                           checkDataOrNot = 'yes'; 
                       }
                  }
                  else 
                  {
                           var msg='';
                          // alert("bool=false");
                          // alert("totalCarbsTxt="+totalCarbsTxt+"customerLevelCarbs="+customerLevelCarbs+"totalCaloriesTxt="+totalCaloriesTxt+"customerLevelMInCal="+customerLevelMInCal+"customerLevelMaxCal="+customerLevelMaxCal);
                           if(totalCarbsTxt > customerLevelCarbs)
                           {
                             msg+="Customer level is "+customerLevel+" so meal's carbs should less than "+customerLevelCarbs; 
                           }

                           

                           
                          

                           if(msg!='')
                           { alert(msg); }
                           
                           return false;
                  }
               }
               else if( saveData=='yes' && checkLevelConditions==false ) // Don't check the Level while pressed the Save button or Save and Print button
               {
                        
                        if(saveData=='yes' && needConfirmAlert=='yes')
                        {
                               
                                 if(confirm("Do you want to save changes"))
                                  {
                                    checkDataOrNot = 'yes';

                                  }
                                  else { return false;}               
                       }
                       else if(saveData=='yes' && needConfirmAlert=='no')
                       {

                           checkDataOrNot = 'yes'; 
                       }
                  
              }

               
               ////////////////////////////////////////////////////////////////////////////
				  
		jQuery("#buttonRow_"+id).show();	
		jQuery("#resultRow_"+id).show();
		
		var DinnerCountElement = jQuery("#"+id+"_numberofrows_dinner_items_desc").val();
		var BreakfastCountElement = jQuery("#"+id+"_numberofrows_breakfast_items_desc").val();
		var LunchCountElement = jQuery("#"+id+"_numberofrows_lunch_items_desc").val();
		var HighteaCountElement = jQuery("#"+id+"_numberofrows_hightea_items_desc").val();
				 
				
					 
		 var totalProtein	     = 0;
		 var totalFat			 = 0;
		 var totalCarbohydrates	 = 0;
		 var totalFiber		 	 = 0;
		 var totalCalories    	 = 0;
					
	      																	  
		 var dinner_total_protein            = 0;
                 var dinner_total_fat                = 0; 
                 var dinner_total_carbohydrates      = 0;
             	 var dinner_total_fiber              = 0;
                 var dinner_total_calories           = 0;
                
               	
																				  
																				  
  	         var breakfast_total_protein        = 0;
		 var breakfast_total_fat            = 0; 
		 var breakfast_total_carbohydrates  = 0;
		 var breakfast_total_fiber          = 0;
		 var breakfast_total_calories       = 0;
                 
																				  
		 var lunch_total_protein        = 0;
		 var lunch_total_fat            = 0; 
		 var lunch_total_carbohydrates  = 0;
		 var lunch_total_fiber          = 0;
		 var lunch_total_calories       = 0;	
                 
		
  		 var hightea_total_protein        = 0;
		 var hightea_total_fat            = 0; 
		 var hightea_total_carbohydrates  = 0;
		 var hightea_total_fiber          = 0;
		 var hightea_total_calories       = 0;	
                 
		 
		 
		 
		var proteinPercent=0;
		var fatPercent=0;
		var carbohydratePerent=0;
		var totalCalories=0;

																			  
		 if(typeof  DinnerCountElement!="undefined") 
		 {
		   var attributeName = "dinner_items_desc";
		   for(var i=1;i<=DinnerCountElement;i++)
			{
			   var proteinQty 		= jQuery("#hiddenProtein-"+id+"-"+attributeName+"-"+i).val();
			   var fatQty			= jQuery("#hiddenFat-"+id+"-"+attributeName+"-"+i).val();
			   var carbohydratesQty = jQuery("#hiddenCarbohydrates-"+id+"-"+attributeName+"-"+i).val();
			   var fiberQty         = jQuery("#hiddenFiber-"+id+"-"+attributeName+"-"+i).val();
			   var caloriesQty      = jQuery("#hiddenCalories-"+id+"-"+attributeName+"-"+i).val();
			   var productid        = jQuery("#productid-"+id+"-"+attributeName+"-"+i).val();
			   var qty              = jQuery("#"+id+"_"+attributeName+"_"+i).val();
				
			        if(checkDataOrNot=='yes'  &&  typeof proteinQty!="undefined" && typeof fatQty!="undefined" && typeof carbohydratesQty!="undefined" && typeof fiberQty!="undefined" && typeof caloriesQty!="undefined" )
				{
					saveSingleItemInfo(id,'dinner',productid,qty,proteinQty,fatQty,carbohydratesQty,fiberQty,caloriesQty);														
				}
					 
			   if(typeof proteinQty!="undefined" &&  proteinQty!='no')
			   {
				 var protein	      = parseFloat(proteinQty);
                               
		                 totalProtein         = protein + parseFloat(totalProtein);
				 dinner_total_protein = protein + parseFloat(dinner_total_protein);
                                                                                      
			   }
				
			   if(typeof fatQty!="undefined" && fatQty!='no')
			   {
				 var fat  = parseFloat(fatQty);
		                 totalFat =  fat + parseFloat(totalFat);
				 dinner_total_fat = fat + parseFloat(dinner_total_fat);	 
			   }
					 
			  if(typeof carbohydratesQty!="undefined" && carbohydratesQty!='no')
			   {
				 var carbohydrates		 = parseFloat(carbohydratesQty);
		                 totalCarbohydrates = carbohydrates + parseFloat(totalCarbohydrates);
				 dinner_total_carbohydrates = carbohydrates + parseFloat(dinner_total_carbohydrates);															 
			   }
					 
			  if(typeof fiberQty!="undefined" && fiberQty!='no')
			   {
				 var fiber	= parseFloat(fiberQty);
		                 totalFiber = fiber + parseFloat(totalFiber);
				 dinner_total_fiber = fiber + parseFloat(dinner_total_fiber);	 
			   }
					 
					 
			   if(typeof caloriesQty!="undefined" && caloriesQty!='no')
			   {
				 var calories		 = parseFloat(caloriesQty);
				 totalCalories = calories + parseFloat(totalCalories);
				 dinner_total_calories = calories + parseFloat(dinner_total_calories);				 
			   }
		   }
			
			var dinner_total_calory_for_percent = (4*dinner_total_protein) + (9*dinner_total_fat) +(4*dinner_total_carbohydrates);														 
			
			var dinner_protein_percent = parseInt(((4*dinner_total_protein) /dinner_total_calory_for_percent)*100);
			var dinner_fat_percent = parseInt(((9*dinner_total_fat) /dinner_total_calory_for_percent)*100);															 
			var dinner_carbohydrates_percent = parseInt(((4*dinner_total_carbohydrates) /dinner_total_calory_for_percent)*100);															 
																		 
			 
			if(dinner_total_calories>0)
			{															 
				jQuery("."+id+"-info-dinner").show();
				jQuery("."+id+"_dinner_total_protein").text(parseInt(4*dinner_total_protein)+" (Cal),"+dinner_total_protein+" gm,"+dinner_protein_percent+" %"); 
				jQuery("."+id+"_dinner_total_fat").text(parseInt(9*dinner_total_fat)+" (Cal),"+dinner_total_fat+" gm,"+dinner_fat_percent+" %"); 
				jQuery("."+id+"_dinner_total_carbohydrates").text(parseInt(4*dinner_total_carbohydrates)+" (Cal),"+dinner_total_carbohydrates+" gm,"+dinner_carbohydrates_percent+" %");
				jQuery("."+id+"_dinner_total_fiber").text(parseInt(dinner_total_fiber)+"gm");    																		 
				jQuery("."+id+"_dinner_total_calories").text(parseInt(dinner_total_calories)+"gm"); 
                                
                                // alert("total protein="+dinner_total_protein);

			}else
			{
			 
				jQuery("."+id+"-info-dinner").show();
				jQuery("."+id+"_dinner_total_protein").text("0 (Cal), 0 %"); 
				jQuery("."+id+"_dinner_total_fat").text("0 (Cal),0 %"); 
				jQuery("."+id+"_dinner_total_carbohydrates").text("0 (Cal),0 %");
				jQuery("."+id+"_dinner_total_fiber").text("0");    																 
				jQuery("."+id+"_dinner_total_calories").text("0"); 
			}
			 	
		 }

		
		 if(typeof BreakfastCountElement!="undefined")
		 {
                   var attributeName = "breakfast_items_desc";
			//  alert("BreakfastCountElement="+BreakfastCountElement);
		    for(var i=1;i<=BreakfastCountElement;i++)
			{
			   var proteinQty 		= jQuery("#hiddenProtein-"+id+"-"+attributeName+"-"+i).val();
			   var fatQty			= jQuery("#hiddenFat-"+id+"-"+attributeName+"-"+i).val();
			   var carbohydratesQty = jQuery("#hiddenCarbohydrates-"+id+"-"+attributeName+"-"+i).val();
			   var fiberQty         = jQuery("#hiddenFiber-"+id+"-"+attributeName+"-"+i).val();
			   var caloriesQty      = jQuery("#hiddenCalories-"+id+"-"+attributeName+"-"+i).val();
			   var productid        = jQuery("#productid-"+id+"-"+attributeName+"-"+i).val();
			   var qty              = jQuery("#"+id+"_"+attributeName+"_"+i).val();
				
				
			    if(checkDataOrNot=='yes' &&  typeof proteinQty!="undefined" && typeof fatQty!="undefined" && typeof carbohydratesQty!="undefined" && typeof fiberQty!="undefined" && typeof caloriesQty!="undefined" )
				{ 
					
					//	alert("breakfast productid="+productid);
					saveSingleItemInfo(id,'breakfast',productid,qty,proteinQty,fatQty,carbohydratesQty,fiberQty,caloriesQty);																
				}
					
					 
				if(typeof proteinQty!="undefined" &&  proteinQty!='no')
			   {
				   var protein		 = parseFloat(proteinQty);
		           totalProtein   = protein + parseFloat(totalProtein);
				   breakfast_total_protein = protein + parseFloat(breakfast_total_protein);
			   }
				
			   if(typeof fatQty!="undefined" &&  fatQty!='no')
			   {
				 var fat  = parseFloat(fatQty);
		         totalFat =  fat + parseFloat(totalFat);
				 breakfast_total_fat = fat + parseFloat(breakfast_total_fat);
			   }
					 
			  if(typeof carbohydratesQty!="undefined" &&  carbohydratesQty!='no')
			   {
				 var carbohydrates		 = parseFloat(carbohydratesQty);
		         totalCarbohydrates = carbohydrates + parseFloat(totalCarbohydrates);
				 breakfast_total_carbohydrates = carbohydrates + parseFloat(breakfast_total_carbohydrates);
			   }
					 
			  if(typeof fiberQty!="undefined" &&  fiberQty!='no')
			   {
				 var fiber	= parseFloat(fiberQty);
		         totalFiber = fiber + parseFloat(totalFiber);
				 breakfast_total_fiber = fiber + parseFloat(breakfast_total_fiber);									
			   }
					 
					 
			   if(typeof caloriesQty!="undefined" &&  caloriesQty!='no')
			   {
				 var calories		 = parseFloat(caloriesQty);
		         totalCalories = calories + parseFloat(totalCalories);
				//alert("breakfast productid="+productid +" calory="+calories);									
				 breakfast_total_calories = calories + parseFloat(breakfast_total_calories);
			   }
		   }
			var breakfast_total_calory_for_percent = (4*breakfast_total_protein) + (9*breakfast_total_fat) +(4*breakfast_total_carbohydrates);														 
			
            var breakfast_protein_percent = parseInt(((4*breakfast_total_protein) /breakfast_total_calory_for_percent)*100);
            var breakfast_fat_percent = parseInt(((9*breakfast_total_fat) /breakfast_total_calory_for_percent)*100);															 
            var breakfast_carbohydrates_percent = parseInt(((4*breakfast_total_carbohydrates) /breakfast_total_calory_for_percent)*100);															 

			if(breakfast_total_calories>0)
			{															 
				jQuery("."+id+"-info-breakfast").show();
				jQuery("."+id+"_breakfast_total_protein").text(parseInt(4*breakfast_total_protein)+" (Cal), "+parseInt(breakfast_total_protein)+" gm, "+breakfast_protein_percent+" %"); 
				jQuery("."+id+"_breakfast_total_fat").text(parseInt(9*breakfast_total_fat)+" (Cal),"+parseInt(breakfast_total_fat)+" gm, "+breakfast_fat_percent+" %"); 
				jQuery("."+id+"_breakfast_total_carbohydrates").text(parseInt(4*breakfast_total_carbohydrates)+" (Cal),"+parseInt(breakfast_total_carbohydrates)+" gm, "+breakfast_carbohydrates_percent+" %");
				jQuery("."+id+"_breakfast_total_fiber").text(parseInt(breakfast_total_fiber+"gm"));    																		 
				jQuery("."+id+"_breakfast_total_calories").text(parseInt(breakfast_total_calories+"gm")); 

			}else
			{
			 
				jQuery("."+id+"-info-breakfast").show();
				jQuery("."+id+"_breakfast_total_protein").text("0 (Cal), 0 %"); 
				jQuery("."+id+"_breakfast_total_fat").text("0 (Cal),0 %"); 
				jQuery("."+id+"_breakfast_total_carbohydrates").text("0 (Cal),0 %");
				jQuery("."+id+"_breakfast_total_fiber").text("0");    																 
				jQuery("."+id+"_breakfast_total_calories").text("0"); 
			}
		 }
		  
	
		 if( typeof LunchCountElement!="undefined")
		 {
 			var attributeName = "lunch_items_desc";
			
		   for(var i=1;i<=LunchCountElement;i++)
			{
			   var proteinQty 		= jQuery("#hiddenProtein-"+id+"-"+attributeName+"-"+i).val();
			   var fatQty			= jQuery("#hiddenFat-"+id+"-"+attributeName+"-"+i).val();
			   var carbohydratesQty = jQuery("#hiddenCarbohydrates-"+id+"-"+attributeName+"-"+i).val();
			   var fiberQty         = jQuery("#hiddenFiber-"+id+"-"+attributeName+"-"+i).val();
			   var caloriesQty      = jQuery("#hiddenCalories-"+id+"-"+attributeName+"-"+i).val();
			   var productid        = jQuery("#productid-"+id+"-"+attributeName+"-"+i).val();
			   var qty              = jQuery("#"+id+"_"+attributeName+"_"+i).val();
				
			    if(checkDataOrNot=='yes' &&  typeof proteinQty!="undefined" && typeof fatQty!="undefined" && typeof carbohydratesQty!="undefined" && typeof fiberQty!="undefined" && typeof caloriesQty!="undefined" )
				{
					
					saveSingleItemInfo(id,'lunch',productid,qty,proteinQty,fatQty,carbohydratesQty,fiberQty,caloriesQty);																
				}
					 
			  if(typeof proteinQty!="undefined" &&  proteinQty!='no')
			   {
				 var protein		 = parseFloat(proteinQty);
		                 totalProtein   = protein + parseFloat(totalProtein);
				 lunch_total_protein = protein + parseFloat(lunch_total_protein);	
			   }
				
			   if(typeof fatQty!="undefined" &&  fatQty!='no')
			   {
				 var fat  = parseFloat(fatQty);
		                 totalFat =  fat + parseFloat(totalFat);
				 lunch_total_fat = fat + parseFloat(lunch_total_fat);
			   }
					 
			  if(typeof carbohydratesQty!="undefined" &&  carbohydratesQty!='no')
			   {
				 var carbohydrates		 = parseFloat(carbohydratesQty);
		                 totalCarbohydrates = carbohydrates + parseFloat(totalCarbohydrates);
				 lunch_total_carbohydrates = carbohydrates + parseFloat(lunch_total_carbohydrates);
			   }
					 
			  if(typeof fiberQty!="undefined" &&  fiberQty!='no')
			   {
				 var fiber	= parseFloat(fiberQty);
		                  totalFiber = fiber + parseFloat(totalFiber);
				 lunch_total_fiber = fiber + parseFloat(lunch_total_fiber);														 
			   }
					 
					 
			   if(typeof caloriesQty!="undefined" &&  caloriesQty!='no')
			   {
				 var calories		 = parseFloat(caloriesQty);
		                  totalCalories = calories + parseFloat(totalCalories);
				 lunch_total_calories = calories + parseFloat(lunch_total_calories);
			   }
		   } 
			var lunch_total_calory_for_percent = (4*lunch_total_protein) + (9*lunch_total_fat) +(4*lunch_total_carbohydrates);														 
			
            var lunch_protein_percent = parseInt(((4*lunch_total_protein) /lunch_total_calory_for_percent)*100);
            var lunch_fat_percent = parseInt(((9*lunch_total_fat) /lunch_total_calory_for_percent)*100);															 
            var lunch_carbohydrates_percent = parseInt(((4*lunch_total_carbohydrates) /lunch_total_calory_for_percent)*100);															 

			if(lunch_total_calories>0)
			{															 
				jQuery("."+id+"-info-lunch").show();
				jQuery("."+id+"_lunch_total_protein").text(parseInt(4*lunch_total_protein)+" (Cal),"+lunch_total_protein+" gm,"+lunch_protein_percent+" %"); 
				jQuery("."+id+"_lunch_total_fat").text(parseInt(9*lunch_total_fat)+" (Cal),"+lunch_total_fat+" gm,"+lunch_fat_percent+" %"); 
				jQuery("."+id+"_lunch_total_carbohydrates").text(parseInt(4*lunch_total_carbohydrates)+" (Cal),"+lunch_total_carbohydrates+" gm,"+lunch_carbohydrates_percent+" %");
				jQuery("."+id+"_lunch_total_fiber").text(parseInt(lunch_total_fiber)+"gm");    																		 
				jQuery("."+id+"_lunch_total_calories").text(parseInt(lunch_total_calories)+"gm"); 

			}else
			{
			 
				jQuery("."+id+"-info-lunch").show();
				jQuery("."+id+"_lunch_total_protein").text("0 (Cal), 0 %"); 
				jQuery("."+id+"_lunch_total_fat").text("0 (Cal),0 %"); 
				jQuery("."+id+"_lunch_total_carbohydrates").text("0 (Cal),0 %");
				jQuery("."+id+"_lunch_total_fiber").text("0");    																 
				jQuery("."+id+"_lunch_total_calories").text("0"); 
			}
		 }
	
		 if(typeof  HighteaCountElement!="undefined")
		 {
			var attributeName = "hightea_items_desc";
		        for(var i=1;i<=HighteaCountElement;i++)
			{
			   var proteinQty 	= jQuery("#hiddenProtein-"+id+"-"+attributeName+"-"+i).val();
			   var fatQty		= jQuery("#hiddenFat-"+id+"-"+attributeName+"-"+i).val();
			   var carbohydratesQty = jQuery("#hiddenCarbohydrates-"+id+"-"+attributeName+"-"+i).val();
			   var fiberQty         = jQuery("#hiddenFiber-"+id+"-"+attributeName+"-"+i).val();
			   var caloriesQty      = jQuery("#hiddenCalories-"+id+"-"+attributeName+"-"+i).val();
			   var productid        = jQuery("#productid-"+id+"-"+attributeName+"-"+i).val();
			   var qty              = jQuery("#"+id+"_"+attributeName+"_"+i).val();
				
			    if(checkDataOrNot=='yes' &&  typeof proteinQty!="undefined" && typeof fatQty!="undefined" && typeof carbohydratesQty!="undefined" && typeof fiberQty!="undefined" && typeof caloriesQty!="undefined" )
				{
					saveSingleItemInfo(id,'hightea',productid,qty,proteinQty,fatQty,carbohydratesQty,fiberQty,caloriesQty);															
				}
																	 
			   if(typeof proteinQty!="undefined" &&  proteinQty!='no')
			   {
				 var protein		 = parseFloat(proteinQty);
		                 totalProtein   = protein + parseFloat(totalProtein);
				 hightea_total_protein = protein + parseFloat(hightea_total_protein);														 
			   }
				
			   if(typeof fatQty!="undefined" &&  fatQty!='no')
			   {
				 var fat  = parseFloat(fatQty);
		         totalFat =  fat + parseFloat(totalFat);
				 hightea_total_fat = fat + parseFloat(hightea_total_fat); 
			   }
					 
			  if(typeof carbohydratesQty!="undefined" &&  carbohydratesQty!='no')
			   {
				 var carbohydrates		 = parseFloat(carbohydratesQty);
		         totalCarbohydrates = carbohydrates + parseFloat(totalCarbohydrates);
				 hightea_total_carbohydrates = carbohydrates + parseFloat(hightea_total_carbohydrates); 
			   } 
					 
			  if(typeof fiberQty!="undefined" &&  fiberQty!='no')
			   {
				 var fiber	= parseFloat(fiberQty);
		         totalFiber = fiber + parseFloat(totalFiber);
				 hightea_total_fiber = fiber + parseFloat(hightea_total_fiber); 	 
			   }
					 
					 
			   if(typeof caloriesQty!="undefined" &&  caloriesQty!='no')
			   {
				 var calories		 = parseFloat(caloriesQty);
		                totalCalories = calories + parseFloat(totalCalories);
				 hightea_total_calories = calories + parseFloat(hightea_total_calories);
			   }
		   }

			var hightea_total_calory_for_percent = (4*hightea_total_protein) + (9*hightea_total_fat) +(4*hightea_total_carbohydrates);														 
			
            var hightea_protein_percent = parseInt(((4*hightea_total_protein) /hightea_total_calory_for_percent)*100);
            var hightea_fat_percent = parseInt(((9*hightea_total_fat) /hightea_total_calory_for_percent)*100);															 
            var hightea_carbohydrates_percent = parseInt(((4*hightea_total_carbohydrates) /hightea_total_calory_for_percent)*100);															 

			if(hightea_total_calories>0)
			{															 
				jQuery("."+id+"-info-hightea").show();
				jQuery("."+id+"_hightea_total_protein").text(parseInt(4*hightea_total_protein)+" (Cal),"+hightea_total_protein+" gm,"+hightea_protein_percent+" %"); 
				jQuery("."+id+"_hightea_total_fat").text(parseInt(9*hightea_total_fat)+" (Cal),"+hightea_total_fat+" gm,"+hightea_fat_percent+" %"); 
				jQuery("."+id+"_hightea_total_carbohydrates").text(parseInt(4*hightea_total_carbohydrates)+" (Cal),"+hightea_total_carbohydrates+" gm,"+hightea_carbohydrates_percent+" %");
				jQuery("."+id+"_hightea_total_fiber").text(parseInt(hightea_total_fiber)+"gm");    																		 
				jQuery("."+id+"_hightea_total_calories").text(parseInt(hightea_total_calories)+"gm"); 

			}else
			{
			 
				jQuery("."+id+"-info-hightea").show();
				jQuery("."+id+"_hightea_total_protein").text("0 (Cal), 0 %"); 
				jQuery("."+id+"_hightea_total_fat").text("0 (Cal),0 %"); 
				jQuery("."+id+"_hightea_total_carbohydrates").text("0 (Cal),0 %");
				jQuery("."+id+"_hightea_total_fiber").text("0");    																 
				jQuery("."+id+"_hightea_total_calories").text("0"); 
			}	  
		 }
					 
			 
		var SumOfCalories = (4*totalProtein) + (9*totalFat) +(4*totalCarbohydrates);
		
		var proteinPercent = parseFloat( ( (4*totalProtein)/SumOfCalories) *100).toFixed(2);
		var fatPercent = parseFloat( ((9*totalFat)/SumOfCalories)*100).toFixed(2);
		var carbohydratePerent =  parseFloat(((4*totalCarbohydrates)/SumOfCalories) *100).toFixed(2);
		
               //  alert("totalCalories="+totalCalories+"totalCarbohydrates="+totalCarbohydrates);
           
		  //alert(totalProtein);
		 // alert(totalFat);
		 // alert(totalCarbohydrates);																 
																		 
																		 
	         //  alert(proteinPercent);
		 // alert(fatPercent);
		 //  alert(carbohydratePerent);
                 
                    jQuery("#"+id+"_overallProteinPercent").text("  "+parseInt(proteinPercent)+ " ");
                            jQuery("#"+id+"_overallFatPercent").text(" "+parseInt(fatPercent)+ " ");
                            jQuery("#"+id+"_overallCarbohideratePercent").text("  "+parseInt(carbohydratePerent)+ " ");
                            jQuery("#"+id+"_overallFiber").text(" "+totalFiber);
                            jQuery("#"+id+"_overallCalories").text(" "+parseInt(totalCalories));

                            jQuery("#"+id+"_overallProteinGram").text(" "+totalProtein);
                            jQuery("#"+id+"_overallFatGram").text(" "+totalFat);
                            jQuery("#"+id+"_overallCarbsGram").text(" "+totalCarbohydrates); 
                
            
                    if(checkDataOrNot=='yes' )
                    {
                       //if(boolCheckCarbsCaloryLevel==false){ }
                      jQuery("#pageloader").css("display", "block");		 
                       var randomNo = Math.random();
                       //alert("orderid="+id);
                            jQuery.ajax({
                                            url: baseUrl+'/heal/index/updaterowinfo',
                                            type: "POST",
                                            data: {
                                              orderid: id,
                                              random: randomNo
                                            },
                                            beforeSend: function(){
                                                                                       jQuery(".loader").css("display", "block"); 
                                                                                    },					
                                            success: function(dieticianName)
                                            {  

                                                             jQuery(".savemsg_"+id).show();
                                                             console.log("success msg");
                                                             jQuery(".savemsg_"+id).html('<div class="msgdiv">Your changes has been saved</div>'); 	
                                                             jQuery(".reviewed_"+id).html("Reviewed By : "+dieticianName);										   
                                                            setTimeout(function() 
                                                             { jQuery(".savemsg_"+id).fadeOut('fast');
                                                             }, 1000);


                                                             if(print=='yes')
                                                            {
                                                                    var pageUrl =baseUrl+'/heal/index/print?id='+id+'&random='+randomNo;
                                                                    //alert(pageUrl);
                                                              window.open(pageUrl, '_blank');

                                                            }


                                            }, complete:function()
                                               {
                                                jQuery(".loader").css("display", "none"); 
                                               }

                       });	

                    }
                   
                    
                    
            
		  								   
		
	}
                     
    
	function doFinalCalculationAfterDelete(id,cuisine,itemCountNo)
	{ 
		
		
		var checkDataOrNot = 'no';
		
												  
		jQuery("#buttonRow_"+id).show();	
		jQuery("#resultRow_"+id).show();
		
		var DinnerCountElement = jQuery("#"+id+"_numberofrows_dinner_items_desc").val();
																				
																				
		var BreakfastCountElement = jQuery("#"+id+"_numberofrows_breakfast_items_desc").val();
		var LunchCountElement = jQuery("#"+id+"_numberofrows_lunch_items_desc").val();
		var HighteaCountElement = jQuery("#"+id+"_numberofrows_hightea_items_desc").val();
				 
				
					 
		 var totalProtein	     = 0;
		 var totalFat			 = 0;
		 var totalCarbohydrates	 = 0;
		 var totalFiber		 	 = 0;
		 var totalCalories    	 = 0;
					
	      																	  
		 var dinner_total_protein        = 0;
		 var dinner_total_fat            = 0; 
		 var dinner_total_carbohydrates  = 0;
		 var dinner_total_fiber          = 0;
		 var dinner_total_calories       = 0;	
																				  
																				  
  	     var breakfast_total_protein        = 0;
		 var breakfast_total_fat            = 0; 
		 var breakfast_total_carbohydrates  = 0;
		 var breakfast_total_fiber          = 0;
		 var breakfast_total_calories       = 0;
																				  
		 var lunch_total_protein        = 0;
		 var lunch_total_fat            = 0; 
		 var lunch_total_carbohydrates  = 0;
		 var lunch_total_fiber          = 0;
		 var lunch_total_calories       = 0;					  
		
  		 var hightea_total_protein        = 0;
		 var hightea_total_fat            = 0; 
		 var hightea_total_carbohydrates  = 0;
		 var hightea_total_fiber          = 0;
		 var hightea_total_calories       = 0;																		  
		 
		 
		 
		var proteinPercent=0;
		var fatPercent=0;
		var carbohydratePerent=0;
		var totalCalories=0;

																			  
		 if(typeof  DinnerCountElement!="undefined") 
		 {
		   var attributeName = "dinner_items_desc";
		   for(var i=1;i<=DinnerCountElement;i++)
			{
				if(cuisine=='dinner' && itemCountNo==i)
				{continue;}
				else
				{
					 
												  
			   var proteinQty 		= jQuery("#hiddenProtein-"+id+"-"+attributeName+"-"+i).val();
			   var fatQty			= jQuery("#hiddenFat-"+id+"-"+attributeName+"-"+i).val();
			   var carbohydratesQty = jQuery("#hiddenCarbohydrates-"+id+"-"+attributeName+"-"+i).val();
			   var fiberQty         = jQuery("#hiddenFiber-"+id+"-"+attributeName+"-"+i).val();
			   var caloriesQty      = jQuery("#hiddenCalories-"+id+"-"+attributeName+"-"+i).val();
			   var productid        = jQuery("#productid-"+id+"-"+attributeName+"-"+i).val();
			   var qty              = jQuery("#"+id+"_"+attributeName+"_"+i).val();
				
			   
					 
			   if(typeof proteinQty!="undefined" && proteinQty!='no')
			   {
				 var protein		  = parseFloat(proteinQty);
		         totalProtein         = protein + parseFloat(totalProtein);
				 dinner_total_protein = protein + parseFloat(dinner_total_protein);	 
			   }
				
			   if(typeof fatQty!="undefined" && fatQty!='no')
			   {
				 var fat  = parseFloat(fatQty);
		         totalFat =  fat + parseFloat(totalFat);
				 dinner_total_fat = fat + parseFloat(dinner_total_fat);	 
			   }
					 
			  if(typeof carbohydratesQty!="undefined" && carbohydratesQty!='no')
			   {
				 var carbohydrates		 = parseFloat(carbohydratesQty);
		         totalCarbohydrates = carbohydrates + parseFloat(totalCarbohydrates);
				 dinner_total_carbohydrates = carbohydrates + parseFloat(dinner_total_carbohydrates);															 
			   }
					 
			  if(typeof fiberQty!="undefined" && fiberQty!='no')
			   {
				 var fiber	= parseFloat(fiberQty);
		         totalFiber = fiber + parseFloat(totalFiber);
				 dinner_total_fiber = fiber + parseFloat(dinner_total_fiber);	 
			   }
					 
				 	 
			   if(typeof caloriesQty!="undefined" && caloriesQty!='no')
			   {
				 var calories		 = parseFloat(caloriesQty);
				 totalCalories = calories + parseFloat(totalCalories);
				 dinner_total_calories = calories + parseFloat(dinner_total_calories);	
				// alert(i+" dinner item calories ="+calories );
				 //alert(i+" dinner total calories ="+dinner_total_calories );
			   }
		   
																		 
				 }
			}
			
			var dinner_total_calory_for_percent = (4*dinner_total_protein) + (9*dinner_total_fat) +(4*dinner_total_carbohydrates);														 
			
			var dinner_protein_percent = parseInt(((4*dinner_total_protein) /dinner_total_calory_for_percent)*100);
			var dinner_fat_percent = parseInt(((9*dinner_total_fat) /dinner_total_calory_for_percent)*100);															 
			var dinner_carbohydrates_percent = parseInt(((4*dinner_total_carbohydrates) /dinner_total_calory_for_percent)*100);	
			
			//alert(' dinner total calories='+dinner_total_calories);												 
			if(dinner_total_calories>0)
			{															 
				jQuery("."+id+"-info-dinner").show();
				jQuery("."+id+"_dinner_total_protein").text(parseInt(4*dinner_total_protein)+" (Cal),"+dinner_total_protein+" gm,"+dinner_protein_percent+" %"); 
				jQuery("."+id+"_dinner_total_fat").text(parseInt(9*dinner_total_fat)+" (Cal),"+dinner_total_fat+" gm,"+dinner_fat_percent+" %"); 
				jQuery("."+id+"_dinner_total_carbohydrates").text(parseInt(4*dinner_total_carbohydrates)+" (Cal),"+dinner_total_carbohydrates+" gm,"+dinner_carbohydrates_percent+" %");
				jQuery("."+id+"_dinner_total_fiber").text(parseInt(dinner_total_fiber+"gm"));    																		 
				jQuery("."+id+"_dinner_total_calories").text(parseInt(dinner_total_calories)+"gm"); 

			}else
			{
			 
				jQuery("."+id+"-info-dinner").show();
				jQuery("."+id+"_dinner_total_protein").text("0 (Cal), 0 %"); 
				jQuery("."+id+"_dinner_total_fat").text("0 (Cal),0 %"); 
				jQuery("."+id+"_dinner_total_carbohydrates").text("0 (Cal),0 %");
				jQuery("."+id+"_dinner_total_fiber").text("0");    																 
				jQuery("."+id+"_dinner_total_calories").text("0"); 
			}
		 }

		
		 if(typeof BreakfastCountElement!="undefined")
		 {
             var attributeName = "breakfast_items_desc";
			
		    for(var i=1;i<=BreakfastCountElement;i++)
			{
				if(cuisine=='breakfast' && itemCountNo==i)
				{continue;}
				else
				{
					  
				   var proteinQty 		= jQuery("#hiddenProtein-"+id+"-"+attributeName+"-"+i).val();
				   var fatQty			= jQuery("#hiddenFat-"+id+"-"+attributeName+"-"+i).val();
				   var carbohydratesQty = jQuery("#hiddenCarbohydrates-"+id+"-"+attributeName+"-"+i).val();
				   var fiberQty         = jQuery("#hiddenFiber-"+id+"-"+attributeName+"-"+i).val();
				   var caloriesQty      = jQuery("#hiddenCalories-"+id+"-"+attributeName+"-"+i).val();
				   var productid        = jQuery("#productid-"+id+"-"+attributeName+"-"+i).val();
				   var qty              = jQuery("#"+id+"_"+attributeName+"_"+i).val();


					 if(typeof proteinQty!="undefined" && proteinQty!='no')
				   {
					   var protein		 = parseFloat(proteinQty);
					   totalProtein   = protein + parseFloat(totalProtein);
					   breakfast_total_protein = protein + parseFloat(breakfast_total_protein);
				   }

				   if(typeof fatQty!="undefined" && fatQty!='no')
				   {
					 var fat  = parseFloat(fatQty);
					 totalFat =  fat + parseFloat(totalFat);
					 breakfast_total_fat = fat + parseFloat(breakfast_total_fat);
				   }

				  if(typeof carbohydratesQty!="undefined" && carbohydratesQty!='no')
				   {
					 var carbohydrates		 = parseFloat(carbohydratesQty);
					 totalCarbohydrates = carbohydrates + parseFloat(totalCarbohydrates);
					 breakfast_total_carbohydrates = carbohydrates + parseFloat(breakfast_total_carbohydrates);
				   }

				  if(typeof fiberQty!="undefined" && fiberQty!='no')
				   {
					 var fiber	= parseFloat(fiberQty);
					 totalFiber = fiber + parseFloat(totalFiber);
					 breakfast_total_fiber = fiber + parseFloat(breakfast_total_fiber);									
				   }


				   if(typeof caloriesQty!="undefined" && caloriesQty!='no')
				   {
					 var calories		 = parseFloat(caloriesQty);
					 totalCalories = calories + parseFloat(totalCalories);
					 breakfast_total_calories = calories + parseFloat(breakfast_total_calories);
					 // alert(i+" breakfast item calories ="+calories );
				     // alert(i+" breakfast total calories ="+breakfast_total_calories );
				   }
		   
			}
		}
			var breakfast_total_calory_for_percent = (4*breakfast_total_protein) + (9*breakfast_total_fat) +(4*breakfast_total_carbohydrates);														 
			
            var breakfast_protein_percent = parseInt(((4*breakfast_total_protein) /breakfast_total_calory_for_percent)*100);
            var breakfast_fat_percent = parseInt(((9*breakfast_total_fat) /breakfast_total_calory_for_percent)*100);															 
            var breakfast_carbohydrates_percent = parseInt(((4*breakfast_total_carbohydrates) /breakfast_total_calory_for_percent)*100);															 
           
			
	        if(breakfast_total_calories>0)	
			{  jQuery("."+id+"-info-breakfast").show();
			jQuery("."+id+"_breakfast_total_protein").text(parseInt(4*breakfast_total_protein)+" (Cal),"+breakfast_total_protein+" gm,"+breakfast_protein_percent+" %"); 
		   
			jQuery("."+id+"_breakfast_total_fat").text(parseInt(9*breakfast_total_fat)+" (Cal),"+breakfast_total_fat+" gm,"+breakfast_fat_percent+" %"); 
			jQuery("."+id+"_breakfast_total_carbohydrates").text(parseInt(4*breakfast_total_carbohydrates)+" (Cal),"+breakfast_total_carbohydrates+" gm,"+breakfast_carbohydrates_percent+" %");
			jQuery("."+id+"_breakfast_total_fiber").text(parseInt(breakfast_total_fiber)+"gm");    																		 
			jQuery("."+id+"_breakfast_total_calories").text(parseInt(breakfast_total_calories)+"gm");
			 }
			 else
			 {
			    
				jQuery("."+id+"-info-breakfast").show();
				jQuery("."+id+"_breakfast_total_protein").text("0 (Cal), 0 %"); 
				jQuery("."+id+"_breakfast_total_fat").text("0 (Cal),0 %"); 
				jQuery("."+id+"_breakfast_total_carbohydrates").text("0 (Cal),0 %");
				jQuery("."+id+"_breakfast_total_fiber").text("0");    														
				jQuery("."+id+"_breakfast_total_calories").text("0"); 
			 }
		 }
		  
	
		 if( typeof LunchCountElement!="undefined")
		 {
 			var attributeName = "lunch_items_desc";
			
		   for(var i=1;i<=LunchCountElement;i++)
			{
				if(cuisine=='lunch' && itemCountNo==i)
				{continue;}
				else
				{
					 
			   var proteinQty 		= jQuery("#hiddenProtein-"+id+"-"+attributeName+"-"+i).val();
			   var fatQty			= jQuery("#hiddenFat-"+id+"-"+attributeName+"-"+i).val();
			   var carbohydratesQty = jQuery("#hiddenCarbohydrates-"+id+"-"+attributeName+"-"+i).val();
			   var fiberQty         = jQuery("#hiddenFiber-"+id+"-"+attributeName+"-"+i).val();
			   var caloriesQty      = jQuery("#hiddenCalories-"+id+"-"+attributeName+"-"+i).val();
			   var productid        = jQuery("#productid-"+id+"-"+attributeName+"-"+i).val();
			   var qty              = jQuery("#"+id+"_"+attributeName+"_"+i).val();
				
			   
					
																			
				
					 
			  if(typeof proteinQty!="undefined" && proteinQty!='no')
			   {
				 var protein		 = parseFloat(proteinQty);
		         totalProtein   = protein + parseFloat(totalProtein);
				 lunch_total_protein = protein + parseFloat(lunch_total_protein);	
			   }
				
			   if(typeof fatQty!="undefined" &&   fatQty!='no')
			   {
				 var fat  = parseFloat(fatQty);
		         totalFat =  fat + parseFloat(totalFat);
				 lunch_total_fat = fat + parseFloat(lunch_total_fat);
			   }
					 
			  if(typeof carbohydratesQty!="undefined" &&  carbohydratesQty!='no')
			   {
				 var carbohydrates		 = parseFloat(carbohydratesQty);
		         totalCarbohydrates = carbohydrates + parseFloat(totalCarbohydrates);
				 lunch_total_carbohydrates = carbohydrates + parseFloat(lunch_total_carbohydrates);
			   }
					 
			  if(typeof fiberQty!="undefined" &&  fiberQty!='no')
			   {
				 var fiber	= parseFloat(fiberQty);
		         totalFiber = fiber + parseFloat(totalFiber);
				 lunch_total_fiber = fiber + parseFloat(lunch_total_fiber);														 
			   }
					 
					 
			   if(typeof caloriesQty!="undefined" &&  caloriesQty!='no')
			   {
				 var calories		 = parseFloat(caloriesQty);
		         totalCalories = calories + parseFloat(totalCalories);
				 lunch_total_calories = calories + parseFloat(lunch_total_calories);
				 
				  //alert(i+" lunch item calories ="+calories );
				   //   alert(i+" lunch total calories ="+lunch_total_calories );
				
			   }
		   
				}
			 } 
			var lunch_total_calory_for_percent = (4*lunch_total_protein) + (9*lunch_total_fat) +(4*lunch_total_carbohydrates);														 
			
            var lunch_protein_percent = parseInt(((4*lunch_total_protein) /lunch_total_calory_for_percent)*100);
            var lunch_fat_percent = parseInt(((9*lunch_total_fat) /lunch_total_calory_for_percent)*100);															 
            var lunch_carbohydrates_percent = parseInt(((4*lunch_total_carbohydrates) /lunch_total_calory_for_percent)*100);			 											 
      		if(lunch_total_calories >0)
			{  jQuery("."+id+"-info-lunch").show();
				jQuery("."+id+"_lunch_total_protein").text(parseInt(4*lunch_total_protein)+" (Cal),"+lunch_total_protein+" gm,"+lunch_protein_percent+" %"); 
				jQuery("."+id+"_lunch_total_fat").text(parseInt(9*lunch_total_fat)+" (Cal),"+lunch_total_fat+" gm,"+lunch_fat_percent+" %"); 
				jQuery("."+id+"_lunch_total_carbohydrates").text(parseInt(4*lunch_total_carbohydrates)+" (Cal),"+lunch_total_carbohydrates+" gm,"+lunch_carbohydrates_percent+" %");
				jQuery("."+id+"_lunch_total_fiber").text(parseInt(lunch_total_fiber)+"gm");    																		 
				jQuery("."+id+"_lunch_total_calories").text(parseInt(lunch_total_calories)+"gm");
			}
			else
			{
			    jQuery("."+id+"-info-lunch").show();
				jQuery("."+id+"_lunch_total_protein").text("0 (Cal), 0 %"); 
				jQuery("."+id+"_lunch_total_fat").text("0 (Cal),0 %"); 
				jQuery("."+id+"_lunch_total_carbohydrates").text("0 (Cal),0 %");
				jQuery("."+id+"_lunch_total_fiber").text("0");    														
				jQuery("."+id+"_lunch_total_calories").text("0"); 
			 }
			
		 }
	
		 if(typeof  HighteaCountElement!="undefined")
		 {
			var attributeName = "hightea_items_desc";
		    for(var i=1;i<=HighteaCountElement;i++)
			{
				if(cuisine=='hightea' && itemCountNo==i)
				{continue;}
				else
				{
				   
			   var proteinQty 		= jQuery("#hiddenProtein-"+id+"-"+attributeName+"-"+i).val();
			   var fatQty			= jQuery("#hiddenFat-"+id+"-"+attributeName+"-"+i).val();
			   var carbohydratesQty = jQuery("#hiddenCarbohydrates-"+id+"-"+attributeName+"-"+i).val();
			   var fiberQty         = jQuery("#hiddenFiber-"+id+"-"+attributeName+"-"+i).val();
			   var caloriesQty      = jQuery("#hiddenCalories-"+id+"-"+attributeName+"-"+i).val();
			   var productid        = jQuery("#productid-"+id+"-"+attributeName+"-"+i).val();
			   var qty              = jQuery("#"+id+"_"+attributeName+"_"+i).val();
				
			   													 
			   if(typeof proteinQty!="undefined" && proteinQty!='no')
			   {
				 var protein		 = parseFloat(proteinQty);
		         totalProtein   = protein + parseFloat(totalProtein);
				 hightea_total_protein = protein + parseFloat(hightea_total_protein);														 
			   }
				
			   if(typeof fatQty!="undefined" && fatQty!='no')
			   {
				 var fat  = parseFloat(fatQty);
		         totalFat =  fat + parseFloat(totalFat);
				 hightea_total_fat = fat + parseFloat(hightea_total_fat); 
			   }
					 
			  if(typeof carbohydratesQty!="undefined" && carbohydratesQty!='no')
			   {
				 var carbohydrates		 = parseFloat(carbohydratesQty);
		         totalCarbohydrates = carbohydrates + parseFloat(totalCarbohydrates);
				 hightea_total_carbohydrates = carbohydrates + parseFloat(hightea_total_carbohydrates); 
			   } 
					 
			  if(typeof fiberQty!="undefined" && fiberQty!='no')
			   {
				 var fiber	= parseFloat(fiberQty);
		         totalFiber = fiber + parseFloat(totalFiber);
				 hightea_total_fiber = fiber + parseFloat(hightea_total_fiber); 	 
			   }
					 
					 
			   if(typeof caloriesQty!="undefined" && caloriesQty!='no')
			   {
				 var calories		 = parseFloat(caloriesQty);
		         totalCalories = calories + parseFloat(totalCalories);
				 hightea_total_calories = calories + parseFloat(hightea_total_calories);
				
			   }
		   
				}
			}

			var hightea_total_calory_for_percent = (4*hightea_total_protein) + (9*hightea_total_fat) +(4*hightea_total_carbohydrates);														 
			
            var hightea_protein_percent = parseInt(((4*hightea_total_protein) /hightea_total_calory_for_percent)*100);
            var hightea_fat_percent = parseInt(((9*hightea_total_fat) /hightea_total_calory_for_percent)*100);															 
            var hightea_carbohydrates_percent = parseInt(((4*hightea_total_carbohydrates) /hightea_total_calory_for_percent)*100);		
			

            if(hightea_total_calories>0)
			{
			jQuery("."+id+"-info-hightea").show();
			jQuery("."+id+"_hightea_total_protein").text(parseInt(4*hightea_total_protein)+" (Cal),"+hightea_total_protein+" gm,"+hightea_protein_percent+" %"); 
			jQuery("."+id+"_hightea_total_fat").text(parseInt(9*hightea_total_fat)+" (Cal),"+hightea_total_fat+" gm,"+hightea_fat_percent+" %"); 
			jQuery("."+id+"_hightea_total_carbohydrates").text(parseInt(4*hightea_total_carbohydrates)+" (Cal),"+hightea_total_carbohydrates+" gm,"+hightea_carbohydrates_percent+" %");
			jQuery("."+id+"_hightea_total_fiber").text(parseInt(hightea_total_fiber)+"gm");    																		 
			jQuery("."+id+"_hightea_total_calories").text(parseInt(hightea_total_calories)+"gm"); 	
			 }
			 else
			{ 
			   jQuery("."+id+"-info-hightea").show();
				jQuery("."+id+"_hightea_total_protein").text("0 (Cal), 0 %"); 
				jQuery("."+id+"_hightea_total_fat").text("0 (Cal),0 %"); 
				jQuery("."+id+"_hightea_total_carbohydrates").text("0 (Cal),0 %");
				jQuery("."+id+"_hightea_total_fiber").text("0");    														
				jQuery("."+id+"_hightea_total_calories").text("0"); 
			 }
		 }
					 
			 
		var SumOfCalories = (4*totalProtein) + (9*totalFat) +(4*totalCarbohydrates);
		
		var proteinPercent = parseFloat( ( (4*totalProtein)/SumOfCalories) *100).toFixed(2);
		var fatPercent = parseFloat( ((9*totalFat)/SumOfCalories)*100).toFixed(2);
		var carbohydratePerent =  parseFloat(((4*totalCarbohydrates)/SumOfCalories) *100).toFixed(2);
			
		//  alert("totalCalories="+totalCalories+"  proteinPercent="+proteinPercent+" fatPercent="+fatPercent+" carbohydratePerent="+carbohydratePerent);
												   
		if(proteinPercent>0)
		{	jQuery("#"+id+"_overallProteinPercent").text("  "+parseInt(proteinPercent)+ " "); }
		else {jQuery("#"+id+"_overallProteinPercent").text("0");}																				   
		 if( fatPercent>0)
		 { jQuery("#"+id+"_overallFatPercent").text(" "+parseInt(fatPercent)+ " ");}
		 else {  jQuery("#"+id+"_overallFatPercent").text("0");}
		
		  if(carbohydratePerent>0)
		  { jQuery("#"+id+"_overallCarbohideratePercent").text("  "+parseInt(carbohydratePerent)+ " ");}
		  else
		  { jQuery("#"+id+"_overallCarbohideratePercent").text("0");}
		 
		if(totalFiber >0 )
		{ jQuery("#"+id+"_overallFiber").text(" "+totalFiber);}
		else
		{ jQuery("#"+id+"_overallFiber").text("0");}
		
		if(totalCalories>0){ jQuery("#"+id+"_overallCalories").text(" "+parseInt(totalCalories)); }
		else{  jQuery("#"+id+"_overallCalories").text("0");}
		
		if(totalProtein>0){ jQuery("#"+id+"_overallProteinGram").text(" "+totalProtein); }
		else{  jQuery("#"+id+"_overallProteinGram").text("0");}
		
		if(totalFat>0){ jQuery("#"+id+"_overallFatGram").text(" "+totalFat); }
		else{  jQuery("#"+id+"_overallFatGram").text("0");}
		
		if(totalCarbohydrates>0){ jQuery("#"+id+"_overallCarbsGram").text(" "+totalCarbohydrates); }
		else{  jQuery("#"+id+"_overallCarbsGram").text("0");}
		
		
		 jQuery(".savemsg_"+id).html('<div class="msgdiv">Your changes has been saved</div>'); 
		 setTimeout(function() 
					 { jQuery(".savemsg_"+id).fadeOut('fast');
					 }, 1000);
		 
	}
																																			
    
    function saveSingleItemInfo(rowId,cuisine,productid,qty,proteinQty,fatQty,carbohydratesQty,fiberQty,caloriesQty){  
    jQuery.ajax({
                    url: baseUrl+'/heal/index/healitemupdate',
                    type: "POST",
                    data: {
                      orderid: rowId, 
                      cuisine:cuisine,
                      entityid: productid,
                      qty:qty,
                      proteinQty:proteinQty,
                      fatQty:fatQty,    
                      carbohydratesQty:carbohydratesQty,
                      fiberQty:fiberQty,
                      caloriesQty:caloriesQty

                    },
                    dataType: 'JSON',
                    success: function(response) {  
                        //alert(response)   ;   
                    }
        });                             
    
 }
				 
				 
 function deleteItem(orderid,cuisine,entityId,itemCountNo)
 {
     // jQuery(".316-info-breakfast").hide();
						  
		if(confirm("Do you want to delete this item?"))
		 {
				jQuery.ajax({
				 url:baseUrl+'/heal/index/deleteitem',
				 type:"POST",
				 data:{
						 orderid:orderid,
						 cuisine:cuisine,
						 entityId:entityId
						

					  },
					  beforeSend: function(){
                        jQuery(".loader").css("display", "block"); 
					  },
				      success:function(response)
					  {
				           var itemElementClass = orderid+"_"+cuisine+"_"+entityId;
						   																					
							jQuery("."+itemElementClass).remove();
									   
				            doFinalCalculationAfterDelete(orderid,cuisine,itemCountNo);
					 },
					   complete:function(data)
					   {
					     jQuery(".loader").css("display", "none"); 
					   }
					 
			 });			

		 }
		 else
		 {
			return false;
		 }
			 	 
 }
 
 function addNewMenuItem(orderid,cuisine,itemcount)
{
     var DinnerCountElement = 0;
	 var BreakfastCountElement =0;
	 var LunchCountElement  =0;
	 var HighteaCountElement  =0;
	 var newItemCount=0;
	 
	 if(cuisine=='dinner')   { 
	   DinnerCountElement = jQuery("."+orderid+"_numberofrows_dinner_items_desc").val(); 
	  
	   newItemCount =parseInt(DinnerCountElement)+1;
	   jQuery("."+orderid+"_numberofrows_dinner_items_desc").val(newItemCount); 
	  
	 }
	 
	 if(cuisine=='breakfast'){
	   BreakfastCountElement = jQuery("."+orderid+"_numberofrows_breakfast_items_desc").val(); 
	   newItemCount =parseInt(BreakfastCountElement)+1;
	   jQuery("."+orderid+"_numberofrows_breakfast_items_desc").val(newItemCount);
	 }
	 
	 if(cuisine=='lunch')    {
	   LunchCountElement = jQuery("."+orderid+"_numberofrows_lunch_items_desc").val(); 
	   newItemCount =parseInt(LunchCountElement)+1;
	   jQuery("."+orderid+"_numberofrows_lunch_items_desc").val(newItemCount);
	 }
	 
	 if(cuisine=='hightea')  {
	   HighteaCountElement = jQuery("."+orderid+"_numberofrows_hightea_items_desc").val();  
	   newItemCount =parseInt(HighteaCountElement)+1;
	   jQuery("."+orderid+"_numberofrows_hightea_items_desc").val(newItemCount);
	 }
	 
	
	 jQuery.ajax({
                    url: baseUrl+'/heal/index/addnewitem',
                    type: "POST",
                    data: {
                      orderid: orderid, 
                      cuisine:cuisine,
                      itemcount:newItemCount
                    }, 
					dataType: 'JSON',
                    success: function(response)
					{  
						//alert("column number="+response.columnNumber);
						
						
						
						var checkClass = "."+response.orderid+"-info-"+response.cuisine;
						
						//alert("checkClass="+checkClass);
						
						
						var itemcount = response.itemcount;
						
						if(itemcount>0)
						{  //alert('greater than zero');
						 jQuery("li[data-dt-column='"+response.columnNumber+"'] .dtr-data "+checkClass).before(response.dropdown); 
						}
						else
						{
						// alert('less than zero');
						  jQuery("li[data-dt-column='"+response.columnNumber+"'] .dtr-data").before(response.dropdown);
						}
                    }
        }); 
}
				 
	function saveorcancel(orderid,newDivId,operationDivId,columnNumber,cuisine,selectId,entityId,removeCancelDivId)
	{
	    var operation ='';
		//alert("dropdown id="+selectId);
		jQuery("."+removeCancelDivId).remove();
		
		var plusOperation='<input type="button" class="saveItem" value="Apply"';
		plusOperation+=' onclick="saveNewOperationForNewItem(\''+orderid+'\',\''+newDivId+'\',\''+operationDivId+'\',\''+columnNumber+'\',\''+cuisine+'\',\''+selectId+'\',\''+entityId+'\');"';
		plusOperation+=' />';
		
		
		var cancelOperation='<input type="button" class="cancelItem" value="Cancel"';
		cancelOperation+=' onclick="cancelNewOperationForNewItem(\''+orderid+'\',\''+newDivId+'\',\''+cuisine+'\');"';
		cancelOperation+=' />';
		
		operation = plusOperation+"&nbsp;"+cancelOperation;
		jQuery("."+operationDivId).html(operation);
	   
	}
	
	function saveNewOperationForNewItem(orderid,newDivId,operationDivId,columnNumber,cuisine,selectId,entityId)
	{
	  
	     var newItemCount=0;

		 if(cuisine=='dinner')   { 
		   DinnerCountElement = jQuery("."+orderid+"_numberofrows_dinner_items_desc").val(); 
		   newItemCount =parseInt(DinnerCountElement);
		 }

		 if(cuisine=='breakfast'){
		   BreakfastCountElement = jQuery("."+orderid+"_numberofrows_breakfast_items_desc").val(); 
		   newItemCount =parseInt(BreakfastCountElement);
		 }

		 if(cuisine=='lunch')    {
		   LunchCountElement = jQuery("."+orderid+"_numberofrows_lunch_items_desc").val(); 
		   newItemCount =parseInt(LunchCountElement);
		 }

		 if(cuisine=='hightea')  {
		   HighteaCountElement = jQuery("."+orderid+"_numberofrows_hightea_items_desc").val();  
		   newItemCount =parseInt(HighteaCountElement);
		 }
	  
	  
	  jQuery.ajax({
                    url: baseUrl+'/heal/index/savenewitem',
                    type: "POST",
                    data: {
                      orderid: orderid,
					  newDivId:newDivId,
					  operationDivId:operationDivId,
					  columnNumber:columnNumber,
					  cuisine:cuisine,
					  dropdownId:selectId,
					  entityId:entityId,
					  newItemCount:newItemCount
                      
                    }, 
					
                    success: function(response)
					{ 
					    if(response!='already')
					    {
						      jQuery("."+newDivId).remove();
							  var checkClass = "."+orderid+"-info-"+cuisine;
							  jQuery("li[data-dt-column='"+columnNumber+"'] .dtr-data "+checkClass).before(response); 
							  doFinalCalculation(orderid,'no','no','no');
					     
						}
						else
						{
						   alert("This item already exists.");
						   jQuery("."+newDivId).remove();
						   doFinalCalculation(orderid,'no','no','no');
						}
						
						
						
                    }
        }); 
	}
	
	function cancelNewOperationForNewItem(orderid,newDivId,cuisine)
	{
		
		
		var DinnerCountElement = 0;
		 var BreakfastCountElement =0;
		 var LunchCountElement  =0;
		 var HighteaCountElement  =0;
		 var newItemCount=0;

		 if(cuisine=='dinner')   { 
		   DinnerCountElement = jQuery("."+orderid+"_numberofrows_dinner_items_desc").val(); 
		   newItemCount =parseInt(DinnerCountElement)-1;
		   jQuery("."+orderid+"_numberofrows_dinner_items_desc").val(newItemCount); 
			
		 }

		 if(cuisine=='breakfast'){
		   BreakfastCountElement = jQuery("."+orderid+"_numberofrows_breakfast_items_desc").val(); 
		   newItemCount =parseInt(BreakfastCountElement)-1;
		   jQuery("."+orderid+"_numberofrows_breakfast_items_desc").val(newItemCount);
		 }

		 if(cuisine=='lunch')    {
		   LunchCountElement = jQuery("."+orderid+"_numberofrows_lunch_items_desc").val(); 
		   newItemCount =parseInt(LunchCountElement)-1;
		   jQuery("."+orderid+"_numberofrows_lunch_items_desc").val(newItemCount);
		 }

		 if(cuisine=='hightea')  {
		   HighteaCountElement = jQuery("."+orderid+"_numberofrows_hightea_items_desc").val();  
		   newItemCount =parseInt(HighteaCountElement)-1;
		   jQuery("."+orderid+"_numberofrows_hightea_items_desc").val(newItemCount);
		 }

		 jQuery("."+newDivId).remove();
	}
	
	function cancelAddNewItem(newDivId)
	{
	   jQuery("."+newDivId).remove();
	}