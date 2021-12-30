
$(document).ready(function(){

	// Schedule Form
	/*$('#type-2-diabetes').change(function() {
        if($(this).is(":checked")) {
        	$("#diagnosis_year_div").slideDown();
        }else {
        	$("#diagnosis_year_div").slideUp();
        }
    });*/

    $('#hear_about').change(function() {
    	
        if($(this).val() == "Other") {
        	$("#hear_about_other_div").slideDown();
        }else {
        	$("#hear_about_other_div").slideUp();
        }
    });
});