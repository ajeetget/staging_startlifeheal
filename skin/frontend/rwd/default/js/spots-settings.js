/*===========================================================================*/
/*===== In the following section you can add/remove/modify the spots  =======*/
/*===========================================================================*/

var spotsconfiga ='x';
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() { 
  if (this.readyState == 4 && this.status == 200) {
	  
	 // alert(this.readyState +"----"+this.status);
	 // alert(this.responseText);
	  
	   spotsconfiga = JSON.parse(this.responseText); 
	   function isTouchEnabled() {
  return (("ontouchstart" in window)
    || (navigator.MaxTouchPoints > 0)
    || (navigator.msMaxTouchPoints > 0));
}
jQuery(function () {
  var pins_len = spotsconfiga.pins.length;
  if(pins_len > 0) {
    var xmlns = "http://www.w3.org/2000/svg";
    var tsvg_obj = document.getElementById("anaspotsa");
    var svg_circle;
    for (var i = 0; i < pins_len; i++) {
      svg_circle = document.createElementNS(xmlns, "circle");
      svg_circle.setAttributeNS(null, "cx", spotsconfiga.pins[i].pos_X);
      svg_circle.setAttributeNS(null, "cy", spotsconfiga.pins[i].pos_Y);
      svg_circle.setAttributeNS(null, "r", spotsconfiga.pins[i].size / 2);
      svg_circle.setAttributeNS(null, "fill", spotsconfiga.pins[i].upColor);
      svg_circle.setAttributeNS(null, "stroke", spotsconfiga.pins[i].outline);
      svg_circle.setAttributeNS(null, "stroke-width", 1);
      svg_circle.setAttributeNS(null, "id", "anaspotsa_" + i);
      tsvg_obj.appendChild(svg_circle);
      anaspotsaAddEvent(i);
    }
  }
});
function anaspotsaAddEvent(id) {
  var obj = jQuery("#anaspotsa_" + id);
  if(spotsconfiga.pins[id].enable == !0){
    obj.attr({"cursor": "pointer"});
    obj.hover(function () {
      jQuery("#anatip").show().html(spotsconfiga.pins[id].hover);
      obj.css({"fill":spotsconfiga.pins[id].overColor});
    }, function () {
      jQuery("#anatip").hide();
      obj.css({"fill":spotsconfiga.pins[id].upColor});
    });
    obj.mouseup(function(){
      obj.css({"fill":spotsconfiga.pins[id].overColor});
      if (spotsconfiga.pins[id].target === "new_window"){
        window.open(spotsconfiga.pins[id].url);  
      } else if (spotsconfiga.pins[id].target === "same_window") {
        window.parent.location.href = spotsconfiga.pins[id].url;
      } else if (spotsconfiga.pins[id].target === "modal") {
        jQuery(spotsconfiga.pins[id].url).modal("show");
      }
    });
    obj.mousemove(function (e) {
      var x = e.pageX + 10, y = e.pageY + 15;
      var tipw =jQuery("#anatip").outerWidth(), tiph =jQuery("#anatip").outerHeight(),
      x = (x + tipw >jQuery(document).scrollLeft() +jQuery(window).width())? x - tipw - (20 * 2) : x ;
      y = (y + tiph >jQuery(document).scrollTop() +jQuery(window).height())? jQuery(document).scrollTop() +jQuery(window).height() - tiph - 10 : y ;
      jQuery("#anatip").css({left: x, top: y});
		 jQuery("#anatip").css({"position": "absolute"});
		  jQuery("#anatip").css({"z-index": "2", "border": "1px solid rgba(56, 204, 51, 0.8)", "padding": "10px", "background": "rgba(56, 204, 51, 0.8)", "color": "white", "border-radius": "5px", "width": "150px"});
    });
    if (isTouchEnabled()) {
      obj.on("touchstart", function (e) {
        var touch = e.originalEvent.touches[0];
        var x = touch.pageX + 10, y = touch.pageY + 15;
        var tipw=jQuery("#anatip").outerWidth(), tiph=jQuery("#anatip").outerHeight(),
        x = (x + tipw >jQuery(document).scrollLeft() +jQuery(window).width())? x - tipw -(20 * 2) : x ;
        y =(y + tiph >jQuery(document).scrollTop() +jQuery(window).height())? jQuery(document).scrollTop() +jQuery(window).height() -tiph - 10 : y ;
        jQuery("#anatip").show().html(spotsconfiga.pins[id].hover);
        jQuery("#anatip").css({left:x, top:y});
		   jQuery("#anatip").css({"position": "absolute"});
		  jQuery("#anatip").css({"z-index": "2", "border": "1px solid rgba(56, 204, 51, 0.8)", "padding": "10px", "background": "rgba(56, 204, 51, 0.8)", "color": "white", "border-radius": "5px", "width": "150px"});
      });
      obj.on("touchend", function () {
        jQuery("#" + id).css({"fill":spotsconfiga.pins[id].upColor});
        if (spotsconfiga.pins[id].target === "new_window") {
          window.open(spotsconfiga.pins[id].url);
        } else if (spotsconfiga.pins[id].target === "same_window") {
          window.parent.location.href = spotsconfiga.pins[id].url;
        } else if (spotsconfiga.pins[id].target === "modal") {
          jQuery(spotsconfiga.pins[id].url).modal("show");
        }
      });
    }
  }
}
       
  }
};
var screenWidth = jQuery(window).width();
var screenHeight= jQuery(window).height();
var Url =  "https://lifeheal.in/override/index/getbodyjson?width="+screenWidth+"&height="+screenHeight;
//alert(Url);
xmlhttp.open("GET", Url, true);
xmlhttp.send();

