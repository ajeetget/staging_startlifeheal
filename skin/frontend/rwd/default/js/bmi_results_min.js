$(document).ready(function(){if(window.matchMedia("(max-width: 767px)").matches){var a=$("#bmiValue").val(),e=(a-14.6)/21*100;a<18.5?$("div.underweight").addClass("selected"):a<25?$("div.normal").addClass("selected"):a<30?$("div.overweight").addClass("selected"):$("div.obese").addClass("selected"),a<=14.09&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"0%"},500),a>=14.1&&a<=16.09&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+3+"%"},500),a>=16.1&&a<=18.45&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+.5+"%"},500),a>=18.46&&a<=18.53&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"16%"},500),a>=18.54&&a<=21.9&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+1.5+"%"},500),a>=21.91&&a<=24.94&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+"%"},500),a>=24.95&&a<=25.45&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"53%"},500),a>=25.46&&a<=27.49&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+"%"},500),a>=27.5&&a<=29.94&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e-1+"%"},500),a>=29.95&&a<=30.45&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"70%"},500),a>=30.46&&a<=34.89&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e-3+"%"},500),a>=34.9&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"89%"},500)}else{var a=$("#bmiValue").val(),e=(a-14.6)/21*100;a<18.5?$("div.underweight").addClass("selected"):a<25?$("div.normal").addClass("selected"):a<30?$("div.overweight").addClass("selected"):$("div.obese").addClass("selected"),a<=14.09&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"0%"},500),a>=14.1&&a<=16.09&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+3+"%"},500),a>=16.1&&a<=18.45&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+.5+"%"},500),a>=18.46&&a<=18.53&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"17%"},500),a>=18.54&&a<=21.9&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+1.5+"%"},500),a>=21.91&&a<=24.94&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+"%"},500),a>=24.95&&a<=25.45&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"55%"},500),a>=25.46&&a<=27.49&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e+"%"},500),a>=27.5&&a<=29.94&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e-1+"%"},500),a>=29.95&&a<=30.45&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"72%"},500),a>=30.46&&a<=34.89&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:e-3+"%"},500),a>=34.9&&$(".scale_pointer").css({opacity:0}).animate({opacity:1,left:"89%"},500)}$(".alert").length&&($(".details").removeClass("col-sm-8 col-sm-push-4 col-md-7 col-md-push-4 col-md-offset-1"),$(".description").removeClass("col-xs-12 col-sm-7"),$(".details").addClass("under-max"))});