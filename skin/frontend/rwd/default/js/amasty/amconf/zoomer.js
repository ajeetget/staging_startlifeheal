if('undefined' != typeof(jQuery))  {
    jQuery.noConflict();
}
var AmZoomer  = Class.create();
AmZoomer.prototype = ({
    zoomSettings: [],
    generalSettings: [],
    carouselSettings: [],
    lightboxSettings: [],
    
    initialize: function (settings) {
            if(settings['zoom'] || settings['general']) {
                this.zoomSettings = settings['zoom'];
                this.generalSettings = settings['general'];
                this.carouselSettings = settings['carousel'];
                this.lightboxSettings = settings['lightbox'];
                if (this.isMobileAndTablet()) {
                    if (this.generalSettings['lightbox_enable'] === '0') {
                        this.zoomSettings['zoomWindowPosition'] = 6;//th best position on the bottom of image
                        this.zoomSettings['zoomWindowWidth'] = 270;//the best choise for mobile
                        this.zoomSettings['zoomWindowHeight'] = 270;
                        this.zoomSettings['lensShape'] = this.zoomSettings['mobile']['lensShape'];
                        this.zoomSettings['lensSize'] = this.zoomSettings['mobile']['lensSize'];
                        this.zoomSettings['borderSize'] = this.zoomSettings['mobile']['borderSize'];
                        this.zoomSettings['zoomType'] = 'lens';
                        this.zoomSettings['tint'] = false;
                    } else {
                        this.generalSettings['zoom_enable'] = 0;
                    }
                }
            }
    },
    
    loadZoom: function() {
        // zoom already defined
        if (jQuery('#amasty_zoom').data('elevateZoom')) {
            return null;
        }
        if(this.generalSettings['zoom_enable'] === "1" || this.generalSettings['lightbox_enable'] === "1") {
            jQuery("#amasty_zoom").elevateZoom(this.zoomSettings);            
        }
        var self = this;
        //jQuery("#amasty_zoom").data('elevateZoom', this.zoomSettings);/*
        if(this.generalSettings['change_image'] != "0" && $("amasty_zoom") && $("amasty_gallery")) {
            jQuery("#amasty_gallery a").bind(self.generalSettings['change_image'], function(e) {  
                 // Example of using Active Gallery
                 jQuery('#amasty_gallery a').removeClass('active');
                 jQuery(this).addClass('active'); 
                 var ez = jQuery('#amasty_zoom').data('elevateZoom');
                 ez.swaptheimage(jQuery(this).attr("data-image"), jQuery(this).attr("data-zoom-image"));
                 if(!self.generalSettings['thumbnail_lignhtbox'] === "1") {
                    return false;   
                 } 
            });
            jQuery("#amasty_gallery a").bind('touchstart', function(){
                // Example of using Active Gallery
                jQuery('#amasty_gallery a').removeClass('active');
                jQuery(this).addClass('active');
                var ez = jQuery('#amasty_zoom').data('elevateZoom');
                ez.swaptheimage(jQuery(this).attr("data-image"), jQuery(this).attr("data-zoom-image"));
                if(!self.generalSettings['thumbnail_lignhtbox'] === "1") {
                    return false;
                }
            })
        }
        jQuery("#amasty_gallery a").bind('click', function(e) {
            var ez = jQuery('#amasty_zoom').data('elevateZoom');
            ez.mainImage = jQuery(this).attr("data-zoom-image");
        });

        var fancyboxVersion = jQuery.fancybox ? parseInt(jQuery.fancybox.version.split('.')[0]) : 0;
        if(this.generalSettings['lightbox_enable'] === "1"  && $("amasty_zoom")) {
            jQuery("#amasty_zoom").bind("click", function(fancyboxVersion, e) {
                var ez = jQuery("#amasty_zoom").data('elevateZoom'),
                    galleryList = ez.getGalleryList(fancyboxVersion);
                switch (fancyboxVersion) {
                    case 2:
                        if (AmZoomerObj.lightboxSettings.prevEffect == 'slide') {
                            AmZoomerObj.lightboxSettings.prevEffect = 'elastic';
                            AmZoomerObj.lightboxSettings.nextEffect = 'elastic';
                        }
                        AmZoomerObj.lightboxSettings.index = 0;
                        AmZoomerObj.lightboxSettings.autoCenter = true;
                        jQuery.fancybox(galleryList, AmZoomerObj.lightboxSettings);
                        break;
                    case 0:
                        console.log('Fancybox library is not loaded');
                        break;
                    case 3:
                    default:
                        jQuery.fancybox.open(galleryList, AmZoomerObj.lightboxSettings);
                        break;
                }

                return false;
            }.bind(this, fancyboxVersion));
            if(this.isMobileAndTablet()){
                var width = jQuery("#amasty_zoom").width();
                var height = jQuery("#amasty_zoom").height();
                jQuery("#amasty_zoom").parent().append('<div id="amasty_zoom_fix" style="position: absolute;top:0; background-color: transparent; z-index: 8000; width: ' + width + 'px; height: ' + height + 'px;"></div>')
                jQuery("#amasty_zoom_fix").click(function() {
                    jQuery( "#amasty_zoom" ).trigger( "click" );
                });
            }
        }

        if(this.generalSettings['thumbnail_lignhtbox'] === "1") {
            switch (fancyboxVersion) {
                case 2:
                    if (AmZoomerObj.lightboxSettings.prevEffect == 'slide') {
                        AmZoomerObj.lightboxSettings.prevEffect = 'elastic';
                        AmZoomerObj.lightboxSettings.nextEffect = 'elastic';
                    }
                    jQuery('.fancybox').fancybox(AmZoomerObj.lightboxSettings);
                    break;
                case 0:
                    console.log('Fancybox library not loaded');
                    break;
                case 3:
                default:
                    jQuery('.fancybox').bind('click', function(fancyboxVersion, e) {
                        e.preventDefault();
                        var ez = jQuery("#amasty_zoom").data('elevateZoom');
                        jQuery.fancybox.open(ez.getGalleryList(fancyboxVersion), AmZoomerObj.lightboxSettings);
                    }.bind(this, fancyboxVersion));
                    break;
            }
        }
        this.loadCarousel();
    },
    
    loadCarousel: function() {
        if(this.generalSettings['carousel_enable'] === "1"  && $("amasty_zoom")  && $("amasty_gallery")) {
            AmcarouFredSelObject.load();
            jQuery("#amasty_gallery").carouFredSel(this.carouselSettings);    
        }
    },

    isMobileAndTablet: function () {
        var check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    }
});

Event.observe(window, 'load', function(){
    if('undefined' != typeof(AmZoomerObj)) {
        AmZoomerObj.loadZoom();
    }
    if ('undefined' != typeof(ProductMediaManager) && 'undefined' != typeof(ProductMediaManager.initZoom)) {
        ProductMediaManager.initZoom = function () {
            return;
        }
    }
});
