(function(jQuery){jQuery.fn.countTo=function(options){options=options||{};return jQuery(this).each(function(){var settings=jQuery.extend({},jQuery.fn.countTo.defaults,{from:jQuery(this).data('from'),to:jQuery(this).data('to'),speed:jQuery(this).data('speed'),refreshInterval:jQuery(this).data('refresh-interval'),decimals:jQuery(this).data('decimals')},options);var loops=Math.ceil(settings.speed/settings.refreshInterval),increment=(settings.to-settings.from)/loops;var self=this,jQueryself=jQuery(this),loopCount=0,value=settings.from,data=jQueryself.data('countTo')||{};jQueryself.data('countTo',data);if(data.interval){clearInterval(data.interval);}data.interval=setInterval(updateTimer,settings.refreshInterval);render(value);function updateTimer(){value+=increment;loopCount++;render(value);if(typeof(settings.onUpdate)=='function'){settings.onUpdate.call(self,value);}if(loopCount>=loops){jQueryself.removeData('countTo');clearInterval(data.interval);value=settings.to;if(typeof(settings.onComplete)=='function'){settings.onComplete.call(self,value);}}}function render(value){var formattedValue=settings.formatter.call(self,value,settings);jQueryself.html(formattedValue);}});};jQuery.fn.countTo.defaults={from:0,to:0,speed:3000,refreshInterval:100,decimals:0,formatter:formatter,onUpdate:null,onComplete:null};function formatter(value,settings){return value.toFixed(settings.decimals);}}(jQuery));jQuery(function(jQuery){jQuery('.count-number').data('countToOptions',{formatter:function(value,options){return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g,',');}});});function count(options){var jQuerythis=jQuery(this);options=jQuery.extend({},options||{},jQuerythis.data('countToOptions')||{});jQuerythis.countTo(options);}var initCount=0;jQuery(window).scroll(function(){var metrixPos=jQuery('.program-sec').position().top;var scrollPos=jQuery(document).scrollTop()+jQuery(window).height()-400;if(scrollPos>metrixPos&&initCount==0){jQuery('.timer').each(count);initCount=1;}});