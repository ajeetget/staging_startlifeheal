$( function() {

    $( '#popup' ).each( function(){
        new JqueryPopup($(this));
    } );

} );

var JqueryPopup = function( obj ){

    //private properties
    var _self = this,
        _btnShow =  $( '.js-popup-open' ),
        _obj = obj,
        _popupWrap = _obj.find( '.popup__wrap' ),
        _popupContents = _obj.find( '.popup__content' ),
        _btnClose = _obj.find( '.popup__close, .popup__cancel' ),
        _videoFile,
        _scrollConteiner = $( 'html' ),
        _body = $( 'body' ),
        _site = _body.find( '.site' ),
        _position = 0, _isOpen = false,
        _window = $( window );

    //private methods
    var _getScrollWidth = function (){
            var scrollDiv = document.createElement( 'div'),
                scrollBarWidth;

            scrollDiv.className = 'popup__scrollbar-measure';

            document.body.appendChild( scrollDiv );

            scrollBarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;

            document.body.removeChild(scrollDiv);

            return scrollBarWidth;

        },
        _hidePopup = function(){

            _isOpen = false;

            _obj.addClass( 'is-hide' ).removeClass( 'is-opened' );

            _obj.on( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {

                _scrollConteiner.removeAttr( 'style' );
                _body.removeAttr( 'style' );
                _site.removeAttr( 'style' );
                _obj.removeAttr( 'style' );

                _window.scrollTop( _position );
                _position = 0;

                _obj.removeClass( 'is-hide' );

                if ( _videoFile != null ) {
                    _videoFile.remove();
                    _videoFile = null;
                }

                _obj.addClass( 'is-loading' );

                _obj.off( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend' );

            } );

        },
        _onEvents = function(){

            _obj.on( 'click', function ( e ) {

                if ( $( e.target ).closest( _popupContents ).length == 0 ){
                    _hidePopup();
                };

            } );

            _btnShow.on( 'click', function() {

                var curBtn = $( this );

                _showPopup( curBtn );
                return false;

            } );

            _btnClose.on( 'click', function(){
                _hidePopup();
                return false;
            } );

        },
        _showPopup = function( btn ){

            _isOpen = true;

            _setPopupContent( btn );

            if ( _window.scrollTop() !== 0 ){
                _position = _window.scrollTop();
            }

            _scrollConteiner.css( {
                overflowY: 'hidden',
                paddingRight: _getScrollWidth()
            } );

            _body.css( 'overflow-y', 'hidden' );

            _site.css( {
                'position': 'relative',
                'top': _position * -1
            } );

            if ( _popupWrap.outerHeight() <= _window.outerHeight() ) {
                _obj.css( {
                    paddingRight: _getScrollWidth()
                } );
            }

            _obj.addClass( 'is-opened' );

        },
        _setPopupContent = function( btn ){

            var curBtn = btn,
                className = curBtn.data( 'option' )[ 'popup' ],
                curContent = _popupContents.filter( '.popup_' + className );

            _popupContents.css( { display: 'none' } );
            curContent.css( { display: 'block' } );

            if ( className === 'video' ) { _setVideoFile( curBtn.data( 'option' )[ 'content' ], curContent ) }
            if ( className === 'passage' ) { _setPassageLink( curBtn.data( 'option' )[ 'link' ], curContent ) }
            if ( className === 'sbergraduate' ) { _setPassageLink( curBtn.data( 'option' )[ 'link' ], curContent ) }

        },
        _setPassageLink = function( link, obj ) {

            var curBtn = obj.find( '.passage-link' );

            curBtn.attr( 'href', link );

            curBtn.on( 'click', function(){
                _hidePopup();
            } );

        },
        _setVideoFile = function ( id, obj ) {

            var curContent = obj;

            curContent.append( '<iframe src="https://www.youtube.com/embed/'+ id +'?rel=0&amp;showinfo=0&amp;autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>' );

            _videoFile = curContent.find( 'iframe' );

            _videoFile.on( 'load', function () {
                _setVideoSize();
                _obj.removeClass( 'is-loading' );
            } );

            _window.on( 'resize', function () {
                _setVideoSize();
            } );

        },
        _setVideoSize = function () {

            var videoWidth = _videoFile.outerWidth();

            _videoFile.css( 'height', videoWidth / 1.7777 + 'px' );

        },
        _construct = function(){

            _onEvents();
            _obj[ 0 ].obj = _self;

        };

    //public properties

    //public methods
    _self.openPopup = function ( obj ) {

        var curBtn = obj;

        _showPopup( curBtn );

    };
    _self.closePopup = function () {
        if ( _isOpen ){
            _hidePopup();
        }
    };
    _self.initNewButton = function ( obj ) {

        obj.on( 'click', function() {

            var curBtn = $( this );

            _showPopup( curBtn );
            return false;

        } );

    };

    _construct();

};
( function(){

    "use strict";

    $( function () {

        $.each( $( '.intro-text' ), function() {
            new IntroMobileText ( $( this ) );
        } );

        $.each( $( '.about-us-tile__slider' ), function() {
            new InitAboutUsTileSlider ( $( this ) );
        } );

        $.each( $( '.team' ), function() {
            new TeamSlider ( $( this ) );
        } );

        $.each( $( '.customers' ), function() {
            new CustomersSlider ( $( this ) );
        } );

        $.each( $( '.magazine' ), function() {
            new MagazineSlider ( $( this ) );
        } );

        $.each( $( '.stand-out__slider' ), function() {
            new StandOut ( $( this ) );
        } );

        $.each( $( '#testimonials-columns' ), function() {
            new TestimonialsColumns ( $( this ) );
        } );

        $.each( $( '#testimonials-slider' ), function() {
            new TestimonialsSlider ( $( this ) );
        } );

        $.each( $( '.tabs' ), function() {
            new Tabs( $( this ) );
        } );

        $.each( $( '.how-to-sell' ), function() {
            new HowToSellMobile( $( this ) );
        } );

        $.each( $( '.product-promo-slider__swiper' ), function() {
            new ProductPromoSlider( $( this ) );
        } );

    } );

    var CustomersSlider = function( obj ) {

        //private properties
        var _obj = obj,
            _swiperSliders = _obj.find( '.customers__item' ),
            _swiper = null,
            _isMobileSize = false,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _updateSlider();
                } );

            },
            _updateSlider = function() {

                if ( _swiperSliders.length <= 1 ){
                    return false;
                }

                if ( _window.outerWidth() >= 992 && _isMobileSize ) {

                    _isMobileSize = false;

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                } else if ( _window.outerWidth() < 992 && !_isMobileSize ) {

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                }

            },
            _initSlider = function() {

                if ( _window.outerWidth() >= 992 ) {

                    _isMobileSize = false;

                } else if ( _window.outerWidth() < 992 ) {

                    _isMobileSize = true;

                    _swiper = new Swiper( _obj, {
                        effect: 'slide',
                        centeredSlides: true,
                        autoplay: false,
                        loop: true,
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        speed: 500
                    } );

                }

            },
            _construct = function() {
                _initSlider();
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var InitAboutUsTileSlider = function( obj ) {

        //private properties
        var _obj = obj,
            _swiperSliders = _obj.find( '.about-us-tile__slide' ),
            _swiper = null,
            _isMobileSize = false,
            _nextBtn = _obj.find( '.about-us-tile__btn-next' ),
            _prevBtn = _obj.find( '.about-us-tile__btn-prev' ),
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _updateSlider();
                } );

            },
            _updateSlider = function() {

                if ( _swiperSliders.length <= 1 ){
                    return false;
                }

                if ( _window.outerWidth() >= 992 && _isMobileSize ) {

                    _isMobileSize = false;

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                } else if ( _window.outerWidth() < 992 && !_isMobileSize ) {

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                }

            },
            _initSlider = function() {

                if ( _window.outerWidth() >= 992 ) {

                    _isMobileSize = false;

                    _swiper = new Swiper( _obj, {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        speed: 500,
                        threshold: 10,
                        loop: true,
                        navigation: {
                            nextEl: _nextBtn,
                            prevEl: _prevBtn
                        },
                    } );

                } else if ( _window.outerWidth() < 992 ) {

                    _isMobileSize = true;

                    _swiper = new Swiper( _obj, {
                        slidesPerView: 'auto',
                        centeredSlides: true,
                        loop: true,
                        spaceBetween: 30,
                        threshold: 10
                    } );

                }

            },
            _construct = function() {
                _initSlider();
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var IntroMobileText = function( obj ) {

        //private properties
        var _obj = obj,
            _textWrap = _obj.find( '.intro-text__wrap' ),
            _textFrame = _obj.find( '.intro-text__frame' ),
            _btn = _obj.find( '.intro-text__more' );

        //private methods
        var _onEvent = function() {

                _btn.on( 'click', function () {

                    if ( _textWrap.hasClass( 'is-show' ) ) {

                        _textWrap.removeClass( 'is-show' );
                        _btn.text( 'show more' );
                        _textWrap.css( 'height', 120 )

                    } else {

                        _textWrap.addClass( 'is-show' );
                        _btn.text( 'less' );
                        _textWrap.css( 'height', _textFrame.outerHeight() );

                    }

                    return false;

                } )

            },
            _construct = function() {
                _onEvent();
            };

        //public properties

        //public methods

        _construct();
    };

    var MagazineSlider = function( obj ) {

        //private properties
        var _obj = obj,
            _swiperSliders = _obj.find( '.magazine__item' ),
            _swiper = null,
            _isMobileSize = false,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _updateSlider();
                } );

            },
            _updateSlider = function() {

                if ( _swiperSliders.length <= 1 ){
                    return false;
                }

                if ( _window.outerWidth() >= 992 && _isMobileSize ) {

                    _isMobileSize = false;

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                } else if ( _window.outerWidth() < 992 && !_isMobileSize ) {

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                }

            },
            _initSlider = function() {

                if ( _window.outerWidth() >= 992 ) {

                    _isMobileSize = false;

                } else if ( _window.outerWidth() < 992 ) {

                    _isMobileSize = true;

                    _swiper = new Swiper( _obj, {
                        effect: 'slide',
                        centeredSlides: true,
                        autoplay: false,
                        loop: true,
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        speed: 500
                    } );

                }

            },
            _construct = function() {
                _initSlider();
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var StandOut = function( obj ) {

        //private properties
        var _obj = obj,
            _swiper = null,
            _isMobileSize = false,
            _nextBtn = $( '.stand-out__slider-next' ),
            _prevBtn = $( '.stand-out__slider-prev' ),
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _updateSlider();
                } );

            },
            _updateSlider = function() {

                if ( _swiperSliders.length <= 1 ){
                    return false;
                }

                if ( _window.outerWidth() >= 992 && _isMobileSize ) {

                    _isMobileSize = false;

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                } else if ( _window.outerWidth() < 992 && !_isMobileSize ) {

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                }

            },
            _initSlider = function() {

                if ( _window.outerWidth() >= 992 ) {

                    _isMobileSize = false;

                    _swiper = new Swiper( _obj, {
                        effect: 'slide',
                        centeredSlides: false,
                        autoplay: false,
                        loop: false,
                        slidesPerView: '3',
                        spaceBetween: 66,
                        speed: 500,
                        navigation: {
                            nextEl: _nextBtn,
                            prevEl: _prevBtn
                        }
                    } );

                } else if ( _window.outerWidth() < 992 ) {

                    _isMobileSize = true;

                    _swiper = new Swiper( _obj, {
                        effect: 'slide',
                        centeredSlides: false,
                        autoplay: false,						
                        loop: false,
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        speed: 500
                    } );

                }

            },
            _construct = function() {
                _initSlider();
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var ProductPromoSlider = function( obj ) {

        //private properties
        var _obj = obj,
            _swiper = null,
            _isMobileSize = false,
            _nextBtn = $( '.product-promo-slider__next' ),
            _prevBtn = $( '.product-promo-slider__prev' ),
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _updateSlider();
                } );

            },
            _updateSlider = function() {

                if ( _swiperSliders.length <= 1 ){
                    return false;
                }

                if ( _window.outerWidth() >= 992 && _isMobileSize ) {

                    _isMobileSize = false;

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                } else if ( _window.outerWidth() < 992 && !_isMobileSize ) {

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                }

            },
            _initSlider = function() {

                if ( _window.outerWidth() >= 992 ) {

                    _isMobileSize = false;

                    _swiper = new Swiper( _obj, {
                      effect: 'slide',
                        centeredSlides: false,
                        autoplay: false,						
                        loop: false,
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        speed: 500,
                        navigation: {
                            nextEl: _nextBtn,
                            prevEl: _prevBtn
                        }
                    } );

                } else if ( _window.outerWidth() < 992 ) {

                    _isMobileSize = true;

                    _swiper = new Swiper( _obj, {
                       effect: 'slide',
                        centeredSlides: false,
                        autoplay: false,						
                        loop: false,
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        speed: 500
                    } );

                }

            },
            _construct = function() {
                _initSlider();
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var TestimonialsColumns = function( obj ) {

        //private properties
        var _obj = obj,
		
            _swiperSliders = _obj.find( '.testimonials-slider__item' ),
			
            _swiperWrap = _obj.find( '.swiper-wrapper' ),
            _item = _obj.find( '.testimonials-slider__item' ),
            _swiper = null,
            _isMobileSize = false,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _updateSlider();
                } );

            },
            _updateSlider = function() {

                if ( _swiperSliders.length <= 1 ){
                    return false;
                }

                if ( _window.outerWidth() >= 992 && _isMobileSize ) {

                    _isMobileSize = false;

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                } else if ( _window.outerWidth() < 992 && !_isMobileSize ) {

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                }

            },
            _initSlider = function() {

                if ( _window.outerWidth() >= 992 ) {

                    _isMobileSize = false;

                    _swiperWrap.append( '<ul/><ul/>' );

                    var column = _swiperWrap.find( 'ul' );

                    _item.each( function () {

                        var curItem = $( this );
console.log( column.eq(0).outerHeight() +' --- '+ column.eq(1).outerHeight() +' --- '+ curItem )
                        if ( column.eq(0).outerHeight() <= column.eq(1).outerHeight() ){
                            column.eq(0).append( curItem );
                        } else {
                            column.eq(1).append( curItem );
                        }

                    } )

                } else if ( _window.outerWidth() < 992 ) {

                    _isMobileSize = true;

                    _item.unwrap( 'ul' );

                    _swiper = new Swiper( _obj, {
                       effect: 'slide',
                        centeredSlides: false,
                        autoplay: false,						
                        loop: false,
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        speed: 500
                    } );

                }

            },
            _construct = function() {
                _initSlider();
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var TestimonialsSlider = function( obj ) {

        //private properties
        var _obj = obj,
            _swiperSliders = _obj.find( '.testimonials-slider__item' ),
            _sliderText = _swiperSliders.find( '.testimonials-slider__text' ),
            _swiper = null,
            _isMobileSize = false,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _updateSlider();
                } );

            },
            _updateSlider = function() {

                if ( _swiperSliders.length <= 1 ){
                    return false;
                }

                if ( _window.outerWidth() >= 992 && _isMobileSize ) {

                    _isMobileSize = false;

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                } else if ( _window.outerWidth() < 992 && !_isMobileSize ) {

                    _cutText();

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                }

            },
            _initSlider = function() {

                if ( _window.outerWidth() >= 992 ) {

                    _isMobileSize = false;

                    _swiper = new Swiper( _obj, {
                        effect: 'slide',
                        centeredSlides: true,
                        autoplay: false,
                        loop: false,
                        slidesPerView: 'auto',
                        spaceBetween: 50,
                        speed: 500
                    } );

                } else if ( _window.outerWidth() < 992 ) {

                    _isMobileSize = true;

                    _swiper = new Swiper( _obj, {
                       effect: 'slide',
                        centeredSlides: false,
                        autoplay: false,						
                        loop: false,
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        speed: 500
                    } );

                }

            },
            _cutText = function() {

                _sliderText.each( function () {

                    var curItem = $( this ),
                        text = curItem.text(),
                        height = curItem.height(),
                        clone = curItem.clone();

                    clone.css( {
                        position: 'absolute',
                        visibility: 'hidden',
                        height: 'auto'
                    } );

                    curItem.after(clone);

                    var l = text.length - 1;

                    for (; l >= 0 && clone.height() > height; --l ) {
                        clone.text( text.substring( 0, l ) );
                    }

                    curItem.text( clone.text() );
                    clone.remove();

                } );

            },
            _construct = function() {
                _initSlider();
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var TeamSlider = function( obj ) {

        //private properties
        var _obj = obj,
            _swiperSliders = _obj.find( '.team__person' ),
            _swiper = null,
            _isMobileSize = false,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _updateSlider();
                } );

                _swiperSliders.on( 'click', function () {
                    SwiperPopup( _obj, $( this ).index() );
                    return false;
                } );

            },
            _updateSlider = function() {

                if ( _swiperSliders.length <= 1 ){
                    return false;
                }

                if ( _window.outerWidth() >= 992 && _isMobileSize ) {

                    _isMobileSize = false;

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                } else if ( _window.outerWidth() < 992 && !_isMobileSize ) {

                    if ( _swiper != null ) {

                        _swiper.destroy( true, true );
                        _swiper = null;

                    }

                    _initSlider();

                }

            },
            _initSlider = function() {

                if ( _window.outerWidth() >= 992 ) {

                    _isMobileSize = false;

                } else if ( _window.outerWidth() < 992 ) {

                    _isMobileSize = true;

                    _swiper = new Swiper( _obj, {
                       effect: 'slide',
                        centeredSlides: false,
                        autoplay: false,						
                        loop: false,
                        slidesPerView: 'auto',
                        spaceBetween: 30,
                        speed: 500
                    } );

                }

            },
            _construct = function() {
                _initSlider();
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var Tabs = function( obj ) {

        //private properties
        var _obj = obj,
            _self = this,
            _tabBtnWrap = _obj.find( '.tabs__items-wrap' ),
            _tabScrollContent = _tabBtnWrap.find( '.tabs__items-scroll' ),
            _tabBtn = _tabBtnWrap.find( '.tabs__item' ),
            _tabWrap = _obj.find( '.tabs__wrap' ),
            _tabContent = _tabWrap.find( '.tabs__content' ),
            _trolley = _obj.find( '.tabs__trolley' ),
            _scrollWrap,
            _ps = null,
            _swiper = null,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _tabBtn.on( {
                    'click': function () {
                        var curBtn = $( this ),
                            curBtnIndex = curBtn.index();

                        _showTabWrap( curBtnIndex );

                    },
                    'mouseover': function () {

                        var curItem = $(this);

                        _trolley.css( {
                            'left': curItem.offset().left - _tabScrollContent.offset().left,
                            'width': curItem.outerWidth()
                        } );

                    },
                    'mouseout': function () {

                        _moveTrolley();

                    }
                } );

                _window.on( 'resize', function () {
                    _setContentHeight();
                } );

            },
            _moveTrolley = function () {

                var active = _tabBtn.filter( '.is-active' );

                _trolley.css( {
                    left: active.offset().left - _tabScrollContent.offset().left,
                    width: active.outerWidth()
                } )

            },
            _showTabWrap = function ( num ) {

                var curTabIndex = num,
                    curTabBtn = _tabBtn.eq( curTabIndex ),
                    activeContent = _tabContent.eq( curTabIndex );

                _tabBtn.removeClass( 'is-active' );
                curTabBtn.addClass( 'is-active' );

                _tabContent.removeClass( 'is-show' );
                activeContent.addClass( 'is-show' );

                _setContentHeight();
                _moveTrolley();

            },
            _setContentHeight = function () {

                var activeContent = _tabContent.filter( '.is-show' );

                _tabWrap.css( 'height', activeContent.outerHeight() );

            },
            _initScroll = function () {

                if ( _ps !== null ) {
                    _ps.destroy();
                    _ps = null;
                }

                _scrollWrap = document.querySelector( '.tabs__items-scroll' );

                if ( _tabScrollContent.outerWidth() > _window.outerWidth() ) {

                    _ps = new PerfectScrollbar( _scrollWrap, {
                        suppressScrollY: true
                    } );

                    _scrollToActive();

                }

            },
            _scrollToActive = function () {

                var activeItem = _tabBtnWrap.find( '.is-active' );

                if ( activeItem.length > 0 ){

                    var windowWidth = _window.outerWidth(),
                        wrapWidth = activeItem.offset().left;

                    _scrollWrap.scrollLeft = wrapWidth/2 - windowWidth/2 + wrapWidth;

                }

            },
            _checkActive = function () {

                var activeTabBtn = _tabBtn.filter( '.is-active' );

                if ( activeTabBtn.length > 0 ) {
                    activeTabBtn.trigger( 'click' )
                } else {
                    _tabBtn.eq( 0 ).trigger( 'click' );
                }

            },
            _construct = function() {
                _onEvent();
                _initScroll();
                _checkActive();
                _moveTrolley();

                _obj[0].obj = _self

            };

        //public properties

        //public methods
        _self.setHeight = function () {
            _setContentHeight();
        };

        _construct();
    };

    var HowToSellMobile = function( obj ) {

        //private properties
        var _obj = obj,
            _tabBtnWrap = _obj.find( '.how-to-sell__pagination' ),
            _tabBtn = _tabBtnWrap.find( 'span' ),
            _tabWrap = _obj.find( '.how-to-sell__content' ),
            _tabContent = _tabWrap.find( 'li' ),
            _trolley = _obj.find( '.how-to-sell__trolley' ),
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _tabBtn.on( {
                    'click': function () {
                        var curBtn = $( this ),
                            curBtnIndex = curBtn.index();

                        _showTabWrap( curBtnIndex );

                    }
                } );

                _window.on( 'resize', function () {
                    _setContentHeight();
                } );

            },
            _moveTrolley = function () {

                var active = _tabBtn.filter( '.is-active' );

                _trolley.css( {
                    left: active.offset().left - _tabBtnWrap.offset().left,
                    width: active.outerWidth()
                } )

            },
            _showTabWrap = function ( num ) {

                var curTabIndex = num,
                    curTabBtn = _tabBtn.eq( curTabIndex ),
                    activeContent = _tabContent.eq( curTabIndex );

                _tabBtn.removeClass( 'is-active' );
                curTabBtn.addClass( 'is-active' );

                _tabContent.removeClass( 'is-show' );
                activeContent.addClass( 'is-show' );

                _setContentHeight();
                _moveTrolley();

            },
            _setContentHeight = function () {

                var activeContent = _tabContent.filter( '.is-show' );

                _tabWrap.css( 'height', activeContent.outerHeight() );

            },
            _checkActive = function () {

                var activeTabBtn = _tabBtn.filter( '.is-active' );

                if ( activeTabBtn.length > 0 ) {
                    activeTabBtn.trigger( 'click' )
                } else {
                    _tabBtn.eq( 0 ).trigger( 'click' );
                }

            },
            _construct = function() {
                _onEvent();
                _checkActive();
            };

        //public properties

        //public methods

        _construct();
    };

    var SwiperPopup = function ( obj, index ) {

        var _obj = obj,
            _html = $( 'html' ),
            _body = $( 'body' ),
            _site = $( '.site' ),
            _links = _obj.find( '.swiper-slide' ),
            _window = $( window ),
            _popup = null,
            _popupInner = null,
            _popupClose = null,
            _swiperWrapper = null,
            _swiperContainer = null,
            _swiperBtnNext = null,
            _swiperBtnPrev = null,
            _swiper = null,
            _position = 0;

        var _addEvents = function(){

                _popupInner.parent().on( 'click', function() {
                    _closePopup();
                } );

                _popupInner.on( 'click', function( event ) {
                    event.stopPropagation();
                } );

            },
            _addingVariables = function(){

                _popup = $( '<div class="swiper-popup">\
                                    <div class="swiper-container">\
                                        <div class="swiper-wrapper"></div>\
                                    </div>\
                                </div>' );
                _swiperWrapper = _popup.find( '.swiper-wrapper' );
                _swiperContainer = _popup.find( '.swiper-container' );

            },
            _buildPopup = function(){

                _addingVariables();
                _contentFilling();
                _initSwiper();
                _swiper.slideTo( index + 1, 0 );
                _popup.addClass( 'is-active' );
                _setStyles();

            },
            _closePopup = function(){

                _popup.removeClass( 'is-active' );

                _popup.on( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {

                    _html.removeAttr( 'style' );
                    _body.removeAttr( 'style' );
                    _site.removeAttr( 'style' );

                    _window.scrollTop( _position );
                    _position = 0;

                    _popup.remove();

                } );

            },
            _contentFilling = function(){

                $.each( _links, function(){

                    var curItem = $( this ),
                        curData = JSON.parse( curItem.attr( 'data-person' ) );

                    var newItem = $( '<div class="swiper-slide"><div class="swiper-popup__inner">' +
                        '<div class="swiper-popup__photo"><img src="'+ curData.photo +'" alt="'+ curData.name +'"></div>' +
                        '<div class="swiper-popup__content"><h3>'+ curData.name +'<i>'+ curData.post +'</i></h3><p>'+ curData.info +'</p>' +
                        '<div class="swiper-popup__social"><a href="'+ curData.twitter +'"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 41">' +
                        '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                        '<g transform="translate(-91.000000, -594.000000)" fill="#000000" fill-rule="nonzero">' +
                        '<g transform="translate(91.000000, 591.000000)"><g transform="translate(0.000000, 3.000000)">' +
                        '<path d="M50,4.85094515 C48.1597192,5.67413034 46.1851245,6.23240512 44.1104479,6.48164524 C46.2288337,5.20105246 47.850405,3.16985269 48.618952,0.75695759 C46.6318572,1.94286881 44.4384713,2.80399261 42.101376,3.27080236 C40.229886,1.25535536 37.5678718,0 34.6152526,0 C28.9507009,0 24.3578012,4.63650957 24.3578012,10.3517126 C24.3578012,11.1622791 24.448406,11.9539587 24.6234062,12.7109988 C16.1000263,12.2788286 8.54208912,8.15646958 3.48366582,1.89239397 C2.59943235,3.41901034 2.09640865,5.19783593 2.09640865,7.09666297 C2.09640865,10.6892012 3.90858482,13.8590539 6.65809911,15.7135917 C4.97713232,15.6568488 3.39616568,15.190039 2.01209479,14.4141121 L2.01209479,14.5434333 C2.01209479,19.5584216 5.54894698,23.7438742 10.2386605,24.696463 C9.37942709,24.9298679 8.47337986,25.059189 7.53604173,25.059189 C6.87370404,25.059189 6.23318012,24.9929614 5.60515622,24.8667744 C6.9111224,28.9828653 10.697975,31.976056 15.1846653,32.0581189 C11.6759178,34.83374 7.25172754,36.4833269 2.44640923,36.4833269 C1.6184667,36.4833269 0.802942488,36.4328521 0,36.3413871 C4.539795,39.2841855 9.92942799,41 15.7220845,41 C34.590416,41 44.9041583,25.2232323 44.9041583,11.5408403 L44.8697629,10.2003705 C46.8849622,8.74938395 48.6283474,6.92635164 50,4.85094515 Z" />' +
                        '</g></g></g></g></svg></a><a href="'+ curData.facebook +'"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 22 41">' +
                        '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                        '<g transform="translate(-181.000000, -594.000000)" fill="#000000" fill-rule="nonzero">' +
                        '<g transform="translate(91.000000, 591.000000)"><g transform="translate(90.000000, 3.000000)">' +
                        '<path d="M21,0 L16,0 C9.96644153,0 6.13531144,3.96039449 6,10 L6,15 L1,15 C0.371259789,14.7423926 0,15.1168919 0,16 L0,22 C0,22.7813323 0.371683119,23.1554051 1,23 L6,23 L6,40 C6.13531144,40.6259272 6.50657123,41 7,41 L14,41 C14.3457831,41 14.7170429,40.6255007 15,40 L15,23 L21,23 C21.3789759,23.1554051 21.7502357,22.7813323 22,22 L22,16 C21.7527757,15.3570321 21.6651465,15.1446168 22,15 C21.3544228,14.8306857 21.1427582,14.7423926 21,15 L15,15 L15,11 C14.7170429,8.90310332 15.1653486,7.94083622 18,8 L21,8 C21.6287402,7.93955661 22,7.56505727 22,7 L22,1 C22,0.383456613 21.6291635,0.00938381033 21,0 Z" />\n' +
                        '</g></g></g></g></svg></a><a href="'+ curData.linkedin +'"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 41 41">' +
                        '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-243.000000, -591.000000)" fill="#000000" fill-rule="nonzero">' +
                        '<g transform="translate(91.000000, 591.000000)">' +
                        '<path d="M161.395833,13.6666667 C161.908333,13.6666667 162.25,14.0083333 162.25,14.5208333 L162.25,40.1458333 C162.25,40.6583333 161.908333,41 161.395833,41 L152.854167,41 C152.341667,41 152,40.6583333 152,40.1458333 L152,14.5208333 C152,14.0083333 152.341667,13.6666667 152.854167,13.6666667 L161.395833,13.6666667 Z M157.466667,0 C160.541667,0 162.933333,2.39166667 162.933333,5.46666667 C162.933333,8.54166667 160.370833,11.1041667 157.466667,11.1041667 C154.5625,11.1041667 152,8.54166667 152,5.46666667 C152,2.39166667 154.5625,0 157.466667,0 Z M182.75,13.4958333 C188.3875,13.4958333 193,18.1083333 193,23.7458333 L193,40.1458333 C193,40.6583333 192.658333,41 192.145833,41 L183.604167,41 C183.091667,41 182.75,40.6583333 182.75,40.1458333 L182.75,26.1375 C182.75,24.0875 180.529167,22.3791667 178.479167,22.3791667 C176.429167,22.3791667 174.208333,23.9166667 174.208333,26.1375 L174.208333,40.1458333 C174.208333,40.6583333 173.866667,41 173.354167,41 L166.520833,41 C166.008333,41 165.666667,40.6583333 165.666667,40.1458333 L165.666667,14.5208333 C165.666667,14.0083333 166.008333,13.6666667 166.520833,13.6666667 L173.354167,13.6666667 C173.866667,13.6666667 174.208333,14.0083333 174.208333,14.5208333 L174.208333,15.375 C175.745833,14.5208333 178.65,13.4958333 182.75,13.4958333 Z"/>' +
                        '</g></g></g></svg></a></div>' +
                        '<div class="swiper-popup__close"><a href="#">Back</a></div></div>' +
                        '<span class="swiper-popup__prev"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 25 46">' +
                        '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">' +
                        '<g transform="translate(-49.000000, -684.000000)" stroke="#979797" stroke-width="2">' +
                        '<path d="M50.2902031,706.29968 L71.3085723,685.290082 C71.6955098,684.903306 72.3228594,684.903306 72.7097969,685.290082 C73.0967344,685.676858 73.0967344,686.303946 72.7097969,686.690722 L52.39204,707 L72.7097969,727.309278 C73.0967344,727.696054 73.0967344,728.323142 72.7097969,728.709918 C72.3228594,729.096694 71.6955098,729.096694 71.3085723,728.709918 L50.2902031,707.70032 C49.9032656,707.313544 49.9032656,706.686456 50.2902031,706.29968 Z" id="arrow-left"/>' +
                        '</g></g></svg></span>' +
                        '<span class="swiper-popup__next"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 25 46">' +
                        '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">' +
                        '<g transform="translate(-300.000000, -684.000000)" stroke="#979797" stroke-width="2">' +
                        '<path d="M301.290203,706.29968 L322.308572,685.290082 C322.69551,684.903306 323.322859,684.903306 323.709797,685.290082 C324.096734,685.676858 324.096734,686.303946 323.709797,686.690722 L303.39204,707 L323.709797,727.309278 C324.096734,727.696054 324.096734,728.323142 323.709797,728.709918 C323.322859,729.096694 322.69551,729.096694 322.308572,728.709918 L301.290203,707.70032 C300.903266,707.313544 300.903266,706.686456 301.290203,706.29968 Z" id="arrow-right" transform="translate(312.500000, 707.000000) rotate(-180.000000) translate(-312.500000, -707.000000) "/>' +
                        '</g></g></svg></span>' +
                        '</div></div>' );

                    _swiperWrapper.append( newItem );

                } );

                _body.append( _popup );

                _popupInner = _popup.find( '.swiper-popup__inner' );

            },
            _getScrollWidth = function (){

                var scrollDiv = document.createElement( 'div'),
                    scrollBarWidth;

                scrollDiv.className = 'popup__scrollbar-measure';

                document.body.appendChild( scrollDiv );

                scrollBarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;

                document.body.removeChild(scrollDiv);

                return scrollBarWidth;

            },
            _initSwiper = function(){

                _swiperBtnNext = _popup.find( '.swiper-popup__next' );
                _swiperBtnPrev = _popup.find( '.swiper-popup__prev' );
                _popupClose = _popup.find( '.swiper-popup__close a' );

                _popupClose.on( 'click', function() {
                    _closePopup();
                    return false;
                } );

                _swiper = new Swiper( _swiperContainer, {
                    slidesPerView: 1,
                    threshold: 10,
                    loop: true,
                    navigation: {
                        nextEl: _swiperBtnNext,
                        prevEl: _swiperBtnPrev
                    }
                });

            },
            _construct = function () {
                _buildPopup();
                _addEvents();
            },
            _setStyles = function(){

                if ( _window.scrollTop() !== 0 ){
                    _position = _window.scrollTop();
                }

                _html.css( {
                    overflowY: 'hidden',
                    paddingRight: _getScrollWidth()
                } );

                _body.css( 'overflow-y', 'hidden' );

                _site.css( {
                    'position': 'relative',
                    'top': _position * -1
                } );

            };

        _construct();

    };

} )();
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImpxdWVyeS5wb3B1cC5qcyIsImpxdWVyeS53aG9sZXNhbGUtcGFnZXMuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUNyTkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoid2hvbGVzYWxlLXBhZ2UubWluLmpzIiwic291cmNlc0NvbnRlbnQiOlsiJCggZnVuY3Rpb24oKSB7XG5cbiAgICAkKCAnI3BvcHVwJyApLmVhY2goIGZ1bmN0aW9uKCl7XG4gICAgICAgIG5ldyBKcXVlcnlQb3B1cCgkKHRoaXMpKTtcbiAgICB9ICk7XG5cbn0gKTtcblxudmFyIEpxdWVyeVBvcHVwID0gZnVuY3Rpb24oIG9iaiApe1xuXG4gICAgLy9wcml2YXRlIHByb3BlcnRpZXNcbiAgICB2YXIgX3NlbGYgPSB0aGlzLFxuICAgICAgICBfYnRuU2hvdyA9ICAkKCAnLmpzLXBvcHVwLW9wZW4nICksXG4gICAgICAgIF9vYmogPSBvYmosXG4gICAgICAgIF9wb3B1cFdyYXAgPSBfb2JqLmZpbmQoICcucG9wdXBfX3dyYXAnICksXG4gICAgICAgIF9wb3B1cENvbnRlbnRzID0gX29iai5maW5kKCAnLnBvcHVwX19jb250ZW50JyApLFxuICAgICAgICBfYnRuQ2xvc2UgPSBfb2JqLmZpbmQoICcucG9wdXBfX2Nsb3NlLCAucG9wdXBfX2NhbmNlbCcgKSxcbiAgICAgICAgX3ZpZGVvRmlsZSxcbiAgICAgICAgX3Njcm9sbENvbnRlaW5lciA9ICQoICdodG1sJyApLFxuICAgICAgICBfYm9keSA9ICQoICdib2R5JyApLFxuICAgICAgICBfc2l0ZSA9IF9ib2R5LmZpbmQoICcuc2l0ZScgKSxcbiAgICAgICAgX3Bvc2l0aW9uID0gMCwgX2lzT3BlbiA9IGZhbHNlLFxuICAgICAgICBfd2luZG93ID0gJCggd2luZG93ICk7XG5cbiAgICAvL3ByaXZhdGUgbWV0aG9kc1xuICAgIHZhciBfZ2V0U2Nyb2xsV2lkdGggPSBmdW5jdGlvbiAoKXtcbiAgICAgICAgICAgIHZhciBzY3JvbGxEaXYgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCAnZGl2JyksXG4gICAgICAgICAgICAgICAgc2Nyb2xsQmFyV2lkdGg7XG5cbiAgICAgICAgICAgIHNjcm9sbERpdi5jbGFzc05hbWUgPSAncG9wdXBfX3Njcm9sbGJhci1tZWFzdXJlJztcblxuICAgICAgICAgICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZCggc2Nyb2xsRGl2ICk7XG5cbiAgICAgICAgICAgIHNjcm9sbEJhcldpZHRoID0gc2Nyb2xsRGl2Lm9mZnNldFdpZHRoIC0gc2Nyb2xsRGl2LmNsaWVudFdpZHRoO1xuXG4gICAgICAgICAgICBkb2N1bWVudC5ib2R5LnJlbW92ZUNoaWxkKHNjcm9sbERpdik7XG5cbiAgICAgICAgICAgIHJldHVybiBzY3JvbGxCYXJXaWR0aDtcblxuICAgICAgICB9LFxuICAgICAgICBfaGlkZVBvcHVwID0gZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgX2lzT3BlbiA9IGZhbHNlO1xuXG4gICAgICAgICAgICBfb2JqLmFkZENsYXNzKCAnaXMtaGlkZScgKS5yZW1vdmVDbGFzcyggJ2lzLW9wZW5lZCcgKTtcblxuICAgICAgICAgICAgX29iai5vbiggJ3dlYmtpdFRyYW5zaXRpb25FbmQgb3RyYW5zaXRpb25lbmQgb1RyYW5zaXRpb25FbmQgbXNUcmFuc2l0aW9uRW5kIHRyYW5zaXRpb25lbmQnLCBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIF9zY3JvbGxDb250ZWluZXIucmVtb3ZlQXR0ciggJ3N0eWxlJyApO1xuICAgICAgICAgICAgICAgIF9ib2R5LnJlbW92ZUF0dHIoICdzdHlsZScgKTtcbiAgICAgICAgICAgICAgICBfc2l0ZS5yZW1vdmVBdHRyKCAnc3R5bGUnICk7XG4gICAgICAgICAgICAgICAgX29iai5yZW1vdmVBdHRyKCAnc3R5bGUnICk7XG5cbiAgICAgICAgICAgICAgICBfd2luZG93LnNjcm9sbFRvcCggX3Bvc2l0aW9uICk7XG4gICAgICAgICAgICAgICAgX3Bvc2l0aW9uID0gMDtcblxuICAgICAgICAgICAgICAgIF9vYmoucmVtb3ZlQ2xhc3MoICdpcy1oaWRlJyApO1xuXG4gICAgICAgICAgICAgICAgaWYgKCBfdmlkZW9GaWxlICE9IG51bGwgKSB7XG4gICAgICAgICAgICAgICAgICAgIF92aWRlb0ZpbGUucmVtb3ZlKCk7XG4gICAgICAgICAgICAgICAgICAgIF92aWRlb0ZpbGUgPSBudWxsO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIF9vYmouYWRkQ2xhc3MoICdpcy1sb2FkaW5nJyApO1xuXG4gICAgICAgICAgICAgICAgX29iai5vZmYoICd3ZWJraXRUcmFuc2l0aW9uRW5kIG90cmFuc2l0aW9uZW5kIG9UcmFuc2l0aW9uRW5kIG1zVHJhbnNpdGlvbkVuZCB0cmFuc2l0aW9uZW5kJyApO1xuXG4gICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgfSxcbiAgICAgICAgX29uRXZlbnRzID0gZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgX29iai5vbiggJ2NsaWNrJywgZnVuY3Rpb24gKCBlICkge1xuXG4gICAgICAgICAgICAgICAgaWYgKCAkKCBlLnRhcmdldCApLmNsb3Nlc3QoIF9wb3B1cENvbnRlbnRzICkubGVuZ3RoID09IDAgKXtcbiAgICAgICAgICAgICAgICAgICAgX2hpZGVQb3B1cCgpO1xuICAgICAgICAgICAgICAgIH07XG5cbiAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgX2J0blNob3cub24oICdjbGljaycsIGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgdmFyIGN1ckJ0biA9ICQoIHRoaXMgKTtcblxuICAgICAgICAgICAgICAgIF9zaG93UG9wdXAoIGN1ckJ0biApO1xuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcblxuICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICBfYnRuQ2xvc2Uub24oICdjbGljaycsIGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgICAgX2hpZGVQb3B1cCgpO1xuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgICAgIH0gKTtcblxuICAgICAgICB9LFxuICAgICAgICBfc2hvd1BvcHVwID0gZnVuY3Rpb24oIGJ0biApe1xuXG4gICAgICAgICAgICBfaXNPcGVuID0gdHJ1ZTtcblxuICAgICAgICAgICAgX3NldFBvcHVwQ29udGVudCggYnRuICk7XG5cbiAgICAgICAgICAgIGlmICggX3dpbmRvdy5zY3JvbGxUb3AoKSAhPT0gMCApe1xuICAgICAgICAgICAgICAgIF9wb3NpdGlvbiA9IF93aW5kb3cuc2Nyb2xsVG9wKCk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIF9zY3JvbGxDb250ZWluZXIuY3NzKCB7XG4gICAgICAgICAgICAgICAgb3ZlcmZsb3dZOiAnaGlkZGVuJyxcbiAgICAgICAgICAgICAgICBwYWRkaW5nUmlnaHQ6IF9nZXRTY3JvbGxXaWR0aCgpXG4gICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgIF9ib2R5LmNzcyggJ292ZXJmbG93LXknLCAnaGlkZGVuJyApO1xuXG4gICAgICAgICAgICBfc2l0ZS5jc3MoIHtcbiAgICAgICAgICAgICAgICAncG9zaXRpb24nOiAncmVsYXRpdmUnLFxuICAgICAgICAgICAgICAgICd0b3AnOiBfcG9zaXRpb24gKiAtMVxuICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICBpZiAoIF9wb3B1cFdyYXAub3V0ZXJIZWlnaHQoKSA8PSBfd2luZG93Lm91dGVySGVpZ2h0KCkgKSB7XG4gICAgICAgICAgICAgICAgX29iai5jc3MoIHtcbiAgICAgICAgICAgICAgICAgICAgcGFkZGluZ1JpZ2h0OiBfZ2V0U2Nyb2xsV2lkdGgoKVxuICAgICAgICAgICAgICAgIH0gKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgX29iai5hZGRDbGFzcyggJ2lzLW9wZW5lZCcgKTtcblxuICAgICAgICB9LFxuICAgICAgICBfc2V0UG9wdXBDb250ZW50ID0gZnVuY3Rpb24oIGJ0biApe1xuXG4gICAgICAgICAgICB2YXIgY3VyQnRuID0gYnRuLFxuICAgICAgICAgICAgICAgIGNsYXNzTmFtZSA9IGN1ckJ0bi5kYXRhKCAnb3B0aW9uJyApWyAncG9wdXAnIF0sXG4gICAgICAgICAgICAgICAgY3VyQ29udGVudCA9IF9wb3B1cENvbnRlbnRzLmZpbHRlciggJy5wb3B1cF8nICsgY2xhc3NOYW1lICk7XG5cbiAgICAgICAgICAgIF9wb3B1cENvbnRlbnRzLmNzcyggeyBkaXNwbGF5OiAnbm9uZScgfSApO1xuICAgICAgICAgICAgY3VyQ29udGVudC5jc3MoIHsgZGlzcGxheTogJ2Jsb2NrJyB9ICk7XG5cbiAgICAgICAgICAgIGlmICggY2xhc3NOYW1lID09PSAndmlkZW8nICkgeyBfc2V0VmlkZW9GaWxlKCBjdXJCdG4uZGF0YSggJ29wdGlvbicgKVsgJ2NvbnRlbnQnIF0sIGN1ckNvbnRlbnQgKSB9XG4gICAgICAgICAgICBpZiAoIGNsYXNzTmFtZSA9PT0gJ3Bhc3NhZ2UnICkgeyBfc2V0UGFzc2FnZUxpbmsoIGN1ckJ0bi5kYXRhKCAnb3B0aW9uJyApWyAnbGluaycgXSwgY3VyQ29udGVudCApIH1cbiAgICAgICAgICAgIGlmICggY2xhc3NOYW1lID09PSAnc2JlcmdyYWR1YXRlJyApIHsgX3NldFBhc3NhZ2VMaW5rKCBjdXJCdG4uZGF0YSggJ29wdGlvbicgKVsgJ2xpbmsnIF0sIGN1ckNvbnRlbnQgKSB9XG5cbiAgICAgICAgfSxcbiAgICAgICAgX3NldFBhc3NhZ2VMaW5rID0gZnVuY3Rpb24oIGxpbmssIG9iaiApIHtcblxuICAgICAgICAgICAgdmFyIGN1ckJ0biA9IG9iai5maW5kKCAnLnBhc3NhZ2UtbGluaycgKTtcblxuICAgICAgICAgICAgY3VyQnRuLmF0dHIoICdocmVmJywgbGluayApO1xuXG4gICAgICAgICAgICBjdXJCdG4ub24oICdjbGljaycsIGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgICAgX2hpZGVQb3B1cCgpO1xuICAgICAgICAgICAgfSApO1xuXG4gICAgICAgIH0sXG4gICAgICAgIF9zZXRWaWRlb0ZpbGUgPSBmdW5jdGlvbiAoIGlkLCBvYmogKSB7XG5cbiAgICAgICAgICAgIHZhciBjdXJDb250ZW50ID0gb2JqO1xuXG4gICAgICAgICAgICBjdXJDb250ZW50LmFwcGVuZCggJzxpZnJhbWUgc3JjPVwiaHR0cHM6Ly93d3cueW91dHViZS5jb20vZW1iZWQvJysgaWQgKyc/cmVsPTAmYW1wO3Nob3dpbmZvPTAmYW1wO2F1dG9wbGF5PTFcIiBmcmFtZWJvcmRlcj1cIjBcIiBhbGxvdz1cImF1dG9wbGF5OyBlbmNyeXB0ZWQtbWVkaWFcIiBhbGxvd2Z1bGxzY3JlZW4+PC9pZnJhbWU+JyApO1xuXG4gICAgICAgICAgICBfdmlkZW9GaWxlID0gY3VyQ29udGVudC5maW5kKCAnaWZyYW1lJyApO1xuXG4gICAgICAgICAgICBfdmlkZW9GaWxlLm9uKCAnbG9hZCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICBfc2V0VmlkZW9TaXplKCk7XG4gICAgICAgICAgICAgICAgX29iai5yZW1vdmVDbGFzcyggJ2lzLWxvYWRpbmcnICk7XG4gICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgIF93aW5kb3cub24oICdyZXNpemUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgX3NldFZpZGVvU2l6ZSgpO1xuICAgICAgICAgICAgfSApO1xuXG4gICAgICAgIH0sXG4gICAgICAgIF9zZXRWaWRlb1NpemUgPSBmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgICAgIHZhciB2aWRlb1dpZHRoID0gX3ZpZGVvRmlsZS5vdXRlcldpZHRoKCk7XG5cbiAgICAgICAgICAgIF92aWRlb0ZpbGUuY3NzKCAnaGVpZ2h0JywgdmlkZW9XaWR0aCAvIDEuNzc3NyArICdweCcgKTtcblxuICAgICAgICB9LFxuICAgICAgICBfY29uc3RydWN0ID0gZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgX29uRXZlbnRzKCk7XG4gICAgICAgICAgICBfb2JqWyAwIF0ub2JqID0gX3NlbGY7XG5cbiAgICAgICAgfTtcblxuICAgIC8vcHVibGljIHByb3BlcnRpZXNcblxuICAgIC8vcHVibGljIG1ldGhvZHNcbiAgICBfc2VsZi5vcGVuUG9wdXAgPSBmdW5jdGlvbiAoIG9iaiApIHtcblxuICAgICAgICB2YXIgY3VyQnRuID0gb2JqO1xuXG4gICAgICAgIF9zaG93UG9wdXAoIGN1ckJ0biApO1xuXG4gICAgfTtcbiAgICBfc2VsZi5jbG9zZVBvcHVwID0gZnVuY3Rpb24gKCkge1xuICAgICAgICBpZiAoIF9pc09wZW4gKXtcbiAgICAgICAgICAgIF9oaWRlUG9wdXAoKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgX3NlbGYuaW5pdE5ld0J1dHRvbiA9IGZ1bmN0aW9uICggb2JqICkge1xuXG4gICAgICAgIG9iai5vbiggJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgIHZhciBjdXJCdG4gPSAkKCB0aGlzICk7XG5cbiAgICAgICAgICAgIF9zaG93UG9wdXAoIGN1ckJ0biApO1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuXG4gICAgICAgIH0gKTtcblxuICAgIH07XG5cbiAgICBfY29uc3RydWN0KCk7XG5cbn07IiwiKCBmdW5jdGlvbigpe1xuXG4gICAgXCJ1c2Ugc3RyaWN0XCI7XG5cbiAgICAkKCBmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgJC5lYWNoKCAkKCAnLmludHJvLXRleHQnICksIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbmV3IEludHJvTW9iaWxlVGV4dCAoICQoIHRoaXMgKSApO1xuICAgICAgICB9ICk7XG5cbiAgICAgICAgJC5lYWNoKCAkKCAnLmFib3V0LXVzLXRpbGVfX3NsaWRlcicgKSwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBuZXcgSW5pdEFib3V0VXNUaWxlU2xpZGVyICggJCggdGhpcyApICk7XG4gICAgICAgIH0gKTtcblxuICAgICAgICAkLmVhY2goICQoICcudGVhbScgKSwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBuZXcgVGVhbVNsaWRlciAoICQoIHRoaXMgKSApO1xuICAgICAgICB9ICk7XG5cbiAgICAgICAgJC5lYWNoKCAkKCAnLmN1c3RvbWVycycgKSwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBuZXcgQ3VzdG9tZXJzU2xpZGVyICggJCggdGhpcyApICk7XG4gICAgICAgIH0gKTtcblxuICAgICAgICAkLmVhY2goICQoICcubWFnYXppbmUnICksIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbmV3IE1hZ2F6aW5lU2xpZGVyICggJCggdGhpcyApICk7XG4gICAgICAgIH0gKTtcblxuICAgICAgICAkLmVhY2goICQoICcuc3RhbmQtb3V0X19zbGlkZXInICksIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbmV3IFN0YW5kT3V0ICggJCggdGhpcyApICk7XG4gICAgICAgIH0gKTtcblxuICAgICAgICAkLmVhY2goICQoICcjdGVzdGltb25pYWxzLWNvbHVtbnMnICksIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbmV3IFRlc3RpbW9uaWFsc0NvbHVtbnMgKCAkKCB0aGlzICkgKTtcbiAgICAgICAgfSApO1xuXG4gICAgICAgICQuZWFjaCggJCggJyN0ZXN0aW1vbmlhbHMtc2xpZGVyJyApLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIG5ldyBUZXN0aW1vbmlhbHNTbGlkZXIgKCAkKCB0aGlzICkgKTtcbiAgICAgICAgfSApO1xuXG4gICAgICAgICQuZWFjaCggJCggJy50YWJzJyApLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIG5ldyBUYWJzKCAkKCB0aGlzICkgKTtcbiAgICAgICAgfSApO1xuXG4gICAgICAgICQuZWFjaCggJCggJy5ob3ctdG8tc2VsbCcgKSwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBuZXcgSG93VG9TZWxsTW9iaWxlKCAkKCB0aGlzICkgKTtcbiAgICAgICAgfSApO1xuXG4gICAgICAgICQuZWFjaCggJCggJy5wcm9kdWN0LXByb21vLXNsaWRlcl9fc3dpcGVyJyApLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIG5ldyBQcm9kdWN0UHJvbW9TbGlkZXIoICQoIHRoaXMgKSApO1xuICAgICAgICB9ICk7XG5cbiAgICB9ICk7XG5cbiAgICB2YXIgQ3VzdG9tZXJzU2xpZGVyID0gZnVuY3Rpb24oIG9iaiApIHtcblxuICAgICAgICAvL3ByaXZhdGUgcHJvcGVydGllc1xuICAgICAgICB2YXIgX29iaiA9IG9iaixcbiAgICAgICAgICAgIF9zd2lwZXJTbGlkZXJzID0gX29iai5maW5kKCAnLmN1c3RvbWVyc19faXRlbScgKSxcbiAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsLFxuICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlLFxuICAgICAgICAgICAgX3dpbmRvdyA9ICQoIHdpbmRvdyApO1xuXG4gICAgICAgIC8vcHJpdmF0ZSBtZXRob2RzXG4gICAgICAgIHZhciBfb25FdmVudCA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgX3dpbmRvdy5vbiggJ3Jlc2l6ZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAgICAgX3VwZGF0ZVNsaWRlcigpO1xuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF91cGRhdGVTbGlkZXIgPSBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIGlmICggX3N3aXBlclNsaWRlcnMubGVuZ3RoIDw9IDEgKXtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPj0gOTkyICYmIF9pc01vYmlsZVNpemUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmICggX3N3aXBlciAhPSBudWxsICkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyLmRlc3Ryb3koIHRydWUsIHRydWUgKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsO1xuXG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBfaW5pdFNsaWRlcigpO1xuXG4gICAgICAgICAgICAgICAgfSBlbHNlIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPCA5OTIgJiYgIV9pc01vYmlsZVNpemUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyICE9IG51bGwgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIuZGVzdHJveSggdHJ1ZSwgdHJ1ZSApO1xuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG51bGw7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIF9pbml0U2xpZGVyKCk7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfaW5pdFNsaWRlciA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA+PSA5OTIgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgfSBlbHNlIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPCA5OTIgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IHRydWU7XG5cbiAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG5ldyBTd2lwZXIoIF9vYmosIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGVmZmVjdDogJ3NsaWRlJyxcbiAgICAgICAgICAgICAgICAgICAgICAgIGNlbnRlcmVkU2xpZGVzOiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICAgICAgYXV0b3BsYXk6IGZhbHNlLFxuICAgICAgICAgICAgICAgICAgICAgICAgbG9vcDogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlc1BlclZpZXc6ICdhdXRvJyxcbiAgICAgICAgICAgICAgICAgICAgICAgIHNwYWNlQmV0d2VlbjogMzAsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGVlZDogNTAwXG4gICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9jb25zdHJ1Y3QgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBfaW5pdFNsaWRlcigpO1xuICAgICAgICAgICAgICAgIF9vbkV2ZW50KCk7XG4gICAgICAgICAgICB9O1xuXG4gICAgICAgIC8vcHVibGljIHByb3BlcnRpZXNcblxuICAgICAgICAvL3B1YmxpYyBtZXRob2RzXG5cbiAgICAgICAgX2NvbnN0cnVjdCgpO1xuXG4gICAgfTtcblxuICAgIHZhciBJbml0QWJvdXRVc1RpbGVTbGlkZXIgPSBmdW5jdGlvbiggb2JqICkge1xuXG4gICAgICAgIC8vcHJpdmF0ZSBwcm9wZXJ0aWVzXG4gICAgICAgIHZhciBfb2JqID0gb2JqLFxuICAgICAgICAgICAgX3N3aXBlclNsaWRlcnMgPSBfb2JqLmZpbmQoICcuYWJvdXQtdXMtdGlsZV9fc2xpZGUnICksXG4gICAgICAgICAgICBfc3dpcGVyID0gbnVsbCxcbiAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSBmYWxzZSxcbiAgICAgICAgICAgIF9uZXh0QnRuID0gX29iai5maW5kKCAnLmFib3V0LXVzLXRpbGVfX2J0bi1uZXh0JyApLFxuICAgICAgICAgICAgX3ByZXZCdG4gPSBfb2JqLmZpbmQoICcuYWJvdXQtdXMtdGlsZV9fYnRuLXByZXYnICksXG4gICAgICAgICAgICBfd2luZG93ID0gJCggd2luZG93ICk7XG5cbiAgICAgICAgLy9wcml2YXRlIG1ldGhvZHNcbiAgICAgICAgdmFyIF9vbkV2ZW50ID0gZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICBfd2luZG93Lm9uKCAncmVzaXplJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICAgICBfdXBkYXRlU2xpZGVyKCk7XG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX3VwZGF0ZVNsaWRlciA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyU2xpZGVycy5sZW5ndGggPD0gMSApe1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA+PSA5OTIgJiYgX2lzTW9iaWxlU2l6ZSApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2U7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyICE9IG51bGwgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIuZGVzdHJveSggdHJ1ZSwgdHJ1ZSApO1xuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG51bGw7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIF9pbml0U2xpZGVyKCk7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA8IDk5MiAmJiAhX2lzTW9iaWxlU2l6ZSApIHtcblxuICAgICAgICAgICAgICAgICAgICBpZiAoIF9zd2lwZXIgIT0gbnVsbCApIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlci5kZXN0cm95KCB0cnVlLCB0cnVlICk7XG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyID0gbnVsbDtcblxuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcblxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9pbml0U2xpZGVyID0gZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpID49IDk5MiApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2U7XG5cbiAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG5ldyBTd2lwZXIoIF9vYmosIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlc1BlclZpZXc6IDEsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGFjZUJldHdlZW46IDAsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGVlZDogNTAwLFxuICAgICAgICAgICAgICAgICAgICAgICAgdGhyZXNob2xkOiAxMCxcbiAgICAgICAgICAgICAgICAgICAgICAgIGxvb3A6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBuYXZpZ2F0aW9uOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbmV4dEVsOiBfbmV4dEJ0bixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBwcmV2RWw6IF9wcmV2QnRuXG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA8IDk5MiApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gdHJ1ZTtcblxuICAgICAgICAgICAgICAgICAgICBfc3dpcGVyID0gbmV3IFN3aXBlciggX29iaiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVzUGVyVmlldzogJ2F1dG8nLFxuICAgICAgICAgICAgICAgICAgICAgICAgY2VudGVyZWRTbGlkZXM6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBsb29wOiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BhY2VCZXR3ZWVuOiAzMCxcbiAgICAgICAgICAgICAgICAgICAgICAgIHRocmVzaG9sZDogMTBcbiAgICAgICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2NvbnN0cnVjdCA9IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIF9pbml0U2xpZGVyKCk7XG4gICAgICAgICAgICAgICAgX29uRXZlbnQoKTtcbiAgICAgICAgICAgIH07XG5cbiAgICAgICAgLy9wdWJsaWMgcHJvcGVydGllc1xuXG4gICAgICAgIC8vcHVibGljIG1ldGhvZHNcblxuICAgICAgICBfY29uc3RydWN0KCk7XG5cbiAgICB9O1xuXG4gICAgdmFyIEludHJvTW9iaWxlVGV4dCA9IGZ1bmN0aW9uKCBvYmogKSB7XG5cbiAgICAgICAgLy9wcml2YXRlIHByb3BlcnRpZXNcbiAgICAgICAgdmFyIF9vYmogPSBvYmosXG4gICAgICAgICAgICBfdGV4dFdyYXAgPSBfb2JqLmZpbmQoICcuaW50cm8tdGV4dF9fd3JhcCcgKSxcbiAgICAgICAgICAgIF90ZXh0RnJhbWUgPSBfb2JqLmZpbmQoICcuaW50cm8tdGV4dF9fZnJhbWUnICksXG4gICAgICAgICAgICBfYnRuID0gX29iai5maW5kKCAnLmludHJvLXRleHRfX21vcmUnICk7XG5cbiAgICAgICAgLy9wcml2YXRlIG1ldGhvZHNcbiAgICAgICAgdmFyIF9vbkV2ZW50ID0gZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICBfYnRuLm9uKCAnY2xpY2snLCBmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKCBfdGV4dFdyYXAuaGFzQ2xhc3MoICdpcy1zaG93JyApICkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBfdGV4dFdyYXAucmVtb3ZlQ2xhc3MoICdpcy1zaG93JyApO1xuICAgICAgICAgICAgICAgICAgICAgICAgX2J0bi50ZXh0KCAnc2hvdyBtb3JlJyApO1xuICAgICAgICAgICAgICAgICAgICAgICAgX3RleHRXcmFwLmNzcyggJ2hlaWdodCcsIDEyMCApXG5cbiAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgX3RleHRXcmFwLmFkZENsYXNzKCAnaXMtc2hvdycgKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9idG4udGV4dCggJ2xlc3MnICk7XG4gICAgICAgICAgICAgICAgICAgICAgICBfdGV4dFdyYXAuY3NzKCAnaGVpZ2h0JywgX3RleHRGcmFtZS5vdXRlckhlaWdodCgpICk7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcblxuICAgICAgICAgICAgICAgIH0gKVxuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2NvbnN0cnVjdCA9IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIF9vbkV2ZW50KCk7XG4gICAgICAgICAgICB9O1xuXG4gICAgICAgIC8vcHVibGljIHByb3BlcnRpZXNcblxuICAgICAgICAvL3B1YmxpYyBtZXRob2RzXG5cbiAgICAgICAgX2NvbnN0cnVjdCgpO1xuICAgIH07XG5cbiAgICB2YXIgTWFnYXppbmVTbGlkZXIgPSBmdW5jdGlvbiggb2JqICkge1xuXG4gICAgICAgIC8vcHJpdmF0ZSBwcm9wZXJ0aWVzXG4gICAgICAgIHZhciBfb2JqID0gb2JqLFxuICAgICAgICAgICAgX3N3aXBlclNsaWRlcnMgPSBfb2JqLmZpbmQoICcubWFnYXppbmVfX2l0ZW0nICksXG4gICAgICAgICAgICBfc3dpcGVyID0gbnVsbCxcbiAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSBmYWxzZSxcbiAgICAgICAgICAgIF93aW5kb3cgPSAkKCB3aW5kb3cgKTtcblxuICAgICAgICAvL3ByaXZhdGUgbWV0aG9kc1xuICAgICAgICB2YXIgX29uRXZlbnQgPSBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIF93aW5kb3cub24oICdyZXNpemUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICAgIF91cGRhdGVTbGlkZXIoKTtcbiAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfdXBkYXRlU2xpZGVyID0gZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICBpZiAoIF9zd2lwZXJTbGlkZXJzLmxlbmd0aCA8PSAxICl7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpID49IDk5MiAmJiBfaXNNb2JpbGVTaXplICkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSBmYWxzZTtcblxuICAgICAgICAgICAgICAgICAgICBpZiAoIF9zd2lwZXIgIT0gbnVsbCApIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlci5kZXN0cm95KCB0cnVlLCB0cnVlICk7XG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyID0gbnVsbDtcblxuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcblxuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpIDwgOTkyICYmICFfaXNNb2JpbGVTaXplICkge1xuXG4gICAgICAgICAgICAgICAgICAgIGlmICggX3N3aXBlciAhPSBudWxsICkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyLmRlc3Ryb3koIHRydWUsIHRydWUgKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsO1xuXG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBfaW5pdFNsaWRlcigpO1xuXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2luaXRTbGlkZXIgPSBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPj0gOTkyICkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSBmYWxzZTtcblxuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpIDwgOTkyICkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSB0cnVlO1xuXG4gICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBuZXcgU3dpcGVyKCBfb2JqLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBlZmZlY3Q6ICdzbGlkZScsXG4gICAgICAgICAgICAgICAgICAgICAgICBjZW50ZXJlZFNsaWRlczogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGF1dG9wbGF5OiBmYWxzZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGxvb3A6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXNQZXJWaWV3OiAnYXV0bycsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGFjZUJldHdlZW46IDMwLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BlZWQ6IDUwMFxuICAgICAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfY29uc3RydWN0ID0gZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcbiAgICAgICAgICAgICAgICBfb25FdmVudCgpO1xuICAgICAgICAgICAgfTtcblxuICAgICAgICAvL3B1YmxpYyBwcm9wZXJ0aWVzXG5cbiAgICAgICAgLy9wdWJsaWMgbWV0aG9kc1xuXG4gICAgICAgIF9jb25zdHJ1Y3QoKTtcblxuICAgIH07XG5cbiAgICB2YXIgU3RhbmRPdXQgPSBmdW5jdGlvbiggb2JqICkge1xuXG4gICAgICAgIC8vcHJpdmF0ZSBwcm9wZXJ0aWVzXG4gICAgICAgIHZhciBfb2JqID0gb2JqLFxuICAgICAgICAgICAgX3N3aXBlciA9IG51bGwsXG4gICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2UsXG4gICAgICAgICAgICBfbmV4dEJ0biA9ICQoICcuc3RhbmQtb3V0X19zbGlkZXItbmV4dCcgKSxcbiAgICAgICAgICAgIF9wcmV2QnRuID0gJCggJy5zdGFuZC1vdXRfX3NsaWRlci1wcmV2JyApLFxuICAgICAgICAgICAgX3dpbmRvdyA9ICQoIHdpbmRvdyApO1xuXG4gICAgICAgIC8vcHJpdmF0ZSBtZXRob2RzXG4gICAgICAgIHZhciBfb25FdmVudCA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgX3dpbmRvdy5vbiggJ3Jlc2l6ZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAgICAgX3VwZGF0ZVNsaWRlcigpO1xuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF91cGRhdGVTbGlkZXIgPSBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIGlmICggX3N3aXBlclNsaWRlcnMubGVuZ3RoIDw9IDEgKXtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPj0gOTkyICYmIF9pc01vYmlsZVNpemUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmICggX3N3aXBlciAhPSBudWxsICkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyLmRlc3Ryb3koIHRydWUsIHRydWUgKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsO1xuXG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBfaW5pdFNsaWRlcigpO1xuXG4gICAgICAgICAgICAgICAgfSBlbHNlIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPCA5OTIgJiYgIV9pc01vYmlsZVNpemUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyICE9IG51bGwgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIuZGVzdHJveSggdHJ1ZSwgdHJ1ZSApO1xuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG51bGw7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIF9pbml0U2xpZGVyKCk7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfaW5pdFNsaWRlciA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA+PSA5OTIgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBuZXcgU3dpcGVyKCBfb2JqLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBlZmZlY3Q6ICdzbGlkZScsXG4gICAgICAgICAgICAgICAgICAgICAgICBjZW50ZXJlZFNsaWRlczogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICBhdXRvcGxheTogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICBsb29wOiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVzUGVyVmlldzogJ2F1dG8nLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BhY2VCZXR3ZWVuOiA2NixcbiAgICAgICAgICAgICAgICAgICAgICAgIHNwZWVkOiA1MDAsXG4gICAgICAgICAgICAgICAgICAgICAgICBuYXZpZ2F0aW9uOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbmV4dEVsOiBfbmV4dEJ0bixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBwcmV2RWw6IF9wcmV2QnRuXG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpIDwgOTkyICkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSB0cnVlO1xuXG4gICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBuZXcgU3dpcGVyKCBfb2JqLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBlZmZlY3Q6ICdzbGlkZScsXG4gICAgICAgICAgICAgICAgICAgICAgICBjZW50ZXJlZFNsaWRlczogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGF1dG9wbGF5OiBmYWxzZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGxvb3A6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXNQZXJWaWV3OiAnYXV0bycsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGFjZUJldHdlZW46IDMwLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BlZWQ6IDUwMFxuICAgICAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfY29uc3RydWN0ID0gZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcbiAgICAgICAgICAgICAgICBfb25FdmVudCgpO1xuICAgICAgICAgICAgfTtcblxuICAgICAgICAvL3B1YmxpYyBwcm9wZXJ0aWVzXG5cbiAgICAgICAgLy9wdWJsaWMgbWV0aG9kc1xuXG4gICAgICAgIF9jb25zdHJ1Y3QoKTtcblxuICAgIH07XG5cbiAgICB2YXIgUHJvZHVjdFByb21vU2xpZGVyID0gZnVuY3Rpb24oIG9iaiApIHtcblxuICAgICAgICAvL3ByaXZhdGUgcHJvcGVydGllc1xuICAgICAgICB2YXIgX29iaiA9IG9iaixcbiAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsLFxuICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlLFxuICAgICAgICAgICAgX25leHRCdG4gPSAkKCAnLnByb2R1Y3QtcHJvbW8tc2xpZGVyX19uZXh0JyApLFxuICAgICAgICAgICAgX3ByZXZCdG4gPSAkKCAnLnByb2R1Y3QtcHJvbW8tc2xpZGVyX19wcmV2JyApLFxuICAgICAgICAgICAgX3dpbmRvdyA9ICQoIHdpbmRvdyApO1xuXG4gICAgICAgIC8vcHJpdmF0ZSBtZXRob2RzXG4gICAgICAgIHZhciBfb25FdmVudCA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgX3dpbmRvdy5vbiggJ3Jlc2l6ZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAgICAgX3VwZGF0ZVNsaWRlcigpO1xuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF91cGRhdGVTbGlkZXIgPSBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIGlmICggX3N3aXBlclNsaWRlcnMubGVuZ3RoIDw9IDEgKXtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPj0gOTkyICYmIF9pc01vYmlsZVNpemUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmICggX3N3aXBlciAhPSBudWxsICkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyLmRlc3Ryb3koIHRydWUsIHRydWUgKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsO1xuXG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBfaW5pdFNsaWRlcigpO1xuXG4gICAgICAgICAgICAgICAgfSBlbHNlIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPCA5OTIgJiYgIV9pc01vYmlsZVNpemUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyICE9IG51bGwgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIuZGVzdHJveSggdHJ1ZSwgdHJ1ZSApO1xuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG51bGw7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIF9pbml0U2xpZGVyKCk7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfaW5pdFNsaWRlciA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA+PSA5OTIgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBuZXcgU3dpcGVyKCBfb2JqLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBlZmZlY3Q6ICdzbGlkZScsXG4gICAgICAgICAgICAgICAgICAgICAgICBjZW50ZXJlZFNsaWRlczogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGF1dG9wbGF5OiBmYWxzZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGxvb3A6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXNQZXJWaWV3OiAzLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BhY2VCZXR3ZWVuOiAzMCxcbiAgICAgICAgICAgICAgICAgICAgICAgIHNwZWVkOiA1MDAsXG4gICAgICAgICAgICAgICAgICAgICAgICBuYXZpZ2F0aW9uOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbmV4dEVsOiBfbmV4dEJ0bixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBwcmV2RWw6IF9wcmV2QnRuXG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpIDwgOTkyICkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSB0cnVlO1xuXG4gICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBuZXcgU3dpcGVyKCBfb2JqLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBlZmZlY3Q6ICdzbGlkZScsXG4gICAgICAgICAgICAgICAgICAgICAgICBjZW50ZXJlZFNsaWRlczogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGF1dG9wbGF5OiBmYWxzZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGxvb3A6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXNQZXJWaWV3OiAnYXV0bycsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGFjZUJldHdlZW46IDMwLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BlZWQ6IDUwMFxuICAgICAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfY29uc3RydWN0ID0gZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcbiAgICAgICAgICAgICAgICBfb25FdmVudCgpO1xuICAgICAgICAgICAgfTtcblxuICAgICAgICAvL3B1YmxpYyBwcm9wZXJ0aWVzXG5cbiAgICAgICAgLy9wdWJsaWMgbWV0aG9kc1xuXG4gICAgICAgIF9jb25zdHJ1Y3QoKTtcblxuICAgIH07XG5cbiAgICB2YXIgVGVzdGltb25pYWxzQ29sdW1ucyA9IGZ1bmN0aW9uKCBvYmogKSB7XG5cbiAgICAgICAgLy9wcml2YXRlIHByb3BlcnRpZXNcbiAgICAgICAgdmFyIF9vYmogPSBvYmosXG4gICAgICAgICAgICBfc3dpcGVyU2xpZGVycyA9IF9vYmouZmluZCggJy50ZXN0aW1vbmlhbHMtc2xpZGVyX19pdGVtJyApLFxuICAgICAgICAgICAgX3N3aXBlcldyYXAgPSBfb2JqLmZpbmQoICcuc3dpcGVyLXdyYXBwZXInICksXG4gICAgICAgICAgICBfaXRlbSA9IF9vYmouZmluZCggJy50ZXN0aW1vbmlhbHMtc2xpZGVyX19pdGVtJyApLFxuICAgICAgICAgICAgX3N3aXBlciA9IG51bGwsXG4gICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2UsXG4gICAgICAgICAgICBfd2luZG93ID0gJCggd2luZG93ICk7XG5cbiAgICAgICAgLy9wcml2YXRlIG1ldGhvZHNcbiAgICAgICAgdmFyIF9vbkV2ZW50ID0gZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICBfd2luZG93Lm9uKCAncmVzaXplJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICAgICBfdXBkYXRlU2xpZGVyKCk7XG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX3VwZGF0ZVNsaWRlciA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyU2xpZGVycy5sZW5ndGggPD0gMSApe1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA+PSA5OTIgJiYgX2lzTW9iaWxlU2l6ZSApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2U7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyICE9IG51bGwgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIuZGVzdHJveSggdHJ1ZSwgdHJ1ZSApO1xuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG51bGw7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIF9pbml0U2xpZGVyKCk7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA8IDk5MiAmJiAhX2lzTW9iaWxlU2l6ZSApIHtcblxuICAgICAgICAgICAgICAgICAgICBpZiAoIF9zd2lwZXIgIT0gbnVsbCApIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlci5kZXN0cm95KCB0cnVlLCB0cnVlICk7XG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyID0gbnVsbDtcblxuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcblxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9pbml0U2xpZGVyID0gZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpID49IDk5MiApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2U7XG5cbiAgICAgICAgICAgICAgICAgICAgX3N3aXBlcldyYXAuYXBwZW5kKCAnPHVsLz48dWwvPicgKTtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgY29sdW1uID0gX3N3aXBlcldyYXAuZmluZCggJ3VsJyApO1xuXG4gICAgICAgICAgICAgICAgICAgIF9pdGVtLmVhY2goIGZ1bmN0aW9uICgpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGN1ckl0ZW0gPSAkKCB0aGlzICk7XG5jb25zb2xlLmxvZyggY29sdW1uLmVxKDApLm91dGVySGVpZ2h0KCkgKycgLS0tICcrIGNvbHVtbi5lcSgxKS5vdXRlckhlaWdodCgpICsnIC0tLSAnKyBjdXJJdGVtIClcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmICggY29sdW1uLmVxKDApLm91dGVySGVpZ2h0KCkgPD0gY29sdW1uLmVxKDEpLm91dGVySGVpZ2h0KCkgKXtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb2x1bW4uZXEoMCkuYXBwZW5kKCBjdXJJdGVtICk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvbHVtbi5lcSgxKS5hcHBlbmQoIGN1ckl0ZW0gKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICB9IClcblxuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpIDwgOTkyICkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSB0cnVlO1xuXG4gICAgICAgICAgICAgICAgICAgIF9pdGVtLnVud3JhcCggJ3VsJyApO1xuXG4gICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBuZXcgU3dpcGVyKCBfb2JqLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBlZmZlY3Q6ICdzbGlkZScsXG4gICAgICAgICAgICAgICAgICAgICAgICBjZW50ZXJlZFNsaWRlczogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGF1dG9wbGF5OiBmYWxzZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGxvb3A6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXNQZXJWaWV3OiAnYXV0bycsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGFjZUJldHdlZW46IDMwLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BlZWQ6IDUwMFxuICAgICAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfY29uc3RydWN0ID0gZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcbiAgICAgICAgICAgICAgICBfb25FdmVudCgpO1xuICAgICAgICAgICAgfTtcblxuICAgICAgICAvL3B1YmxpYyBwcm9wZXJ0aWVzXG5cbiAgICAgICAgLy9wdWJsaWMgbWV0aG9kc1xuXG4gICAgICAgIF9jb25zdHJ1Y3QoKTtcblxuICAgIH07XG5cbiAgICB2YXIgVGVzdGltb25pYWxzU2xpZGVyID0gZnVuY3Rpb24oIG9iaiApIHtcblxuICAgICAgICAvL3ByaXZhdGUgcHJvcGVydGllc1xuICAgICAgICB2YXIgX29iaiA9IG9iaixcbiAgICAgICAgICAgIF9zd2lwZXJTbGlkZXJzID0gX29iai5maW5kKCAnLnRlc3RpbW9uaWFscy1zbGlkZXJfX2l0ZW0nICksXG4gICAgICAgICAgICBfc2xpZGVyVGV4dCA9IF9zd2lwZXJTbGlkZXJzLmZpbmQoICcudGVzdGltb25pYWxzLXNsaWRlcl9fdGV4dCcgKSxcbiAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsLFxuICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlLFxuICAgICAgICAgICAgX3dpbmRvdyA9ICQoIHdpbmRvdyApO1xuXG4gICAgICAgIC8vcHJpdmF0ZSBtZXRob2RzXG4gICAgICAgIHZhciBfb25FdmVudCA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgX3dpbmRvdy5vbiggJ3Jlc2l6ZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAgICAgX3VwZGF0ZVNsaWRlcigpO1xuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF91cGRhdGVTbGlkZXIgPSBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIGlmICggX3N3aXBlclNsaWRlcnMubGVuZ3RoIDw9IDEgKXtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPj0gOTkyICYmIF9pc01vYmlsZVNpemUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmICggX3N3aXBlciAhPSBudWxsICkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyLmRlc3Ryb3koIHRydWUsIHRydWUgKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsO1xuXG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBfaW5pdFNsaWRlcigpO1xuXG4gICAgICAgICAgICAgICAgfSBlbHNlIGlmICggX3dpbmRvdy5vdXRlcldpZHRoKCkgPCA5OTIgJiYgIV9pc01vYmlsZVNpemUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgX2N1dFRleHQoKTtcblxuICAgICAgICAgICAgICAgICAgICBpZiAoIF9zd2lwZXIgIT0gbnVsbCApIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlci5kZXN0cm95KCB0cnVlLCB0cnVlICk7XG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyID0gbnVsbDtcblxuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcblxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9pbml0U2xpZGVyID0gZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpID49IDk5MiApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2U7XG5cbiAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG5ldyBTd2lwZXIoIF9vYmosIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGVmZmVjdDogJ3NsaWRlJyxcbiAgICAgICAgICAgICAgICAgICAgICAgIGNlbnRlcmVkU2xpZGVzOiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICAgICAgYXV0b3BsYXk6IGZhbHNlLFxuICAgICAgICAgICAgICAgICAgICAgICAgbG9vcDogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlc1BlclZpZXc6ICdhdXRvJyxcbiAgICAgICAgICAgICAgICAgICAgICAgIHNwYWNlQmV0d2VlbjogNTAsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGVlZDogNTAwXG4gICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpIDwgOTkyICkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9pc01vYmlsZVNpemUgPSB0cnVlO1xuXG4gICAgICAgICAgICAgICAgICAgIF9zd2lwZXIgPSBuZXcgU3dpcGVyKCBfb2JqLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBlZmZlY3Q6ICdzbGlkZScsXG4gICAgICAgICAgICAgICAgICAgICAgICBjZW50ZXJlZFNsaWRlczogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGF1dG9wbGF5OiBmYWxzZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGxvb3A6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXNQZXJWaWV3OiAnYXV0bycsXG4gICAgICAgICAgICAgICAgICAgICAgICBzcGFjZUJldHdlZW46IDMwLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BlZWQ6IDUwMFxuICAgICAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfY3V0VGV4dCA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgX3NsaWRlclRleHQuZWFjaCggZnVuY3Rpb24gKCkge1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciBjdXJJdGVtID0gJCggdGhpcyApLFxuICAgICAgICAgICAgICAgICAgICAgICAgdGV4dCA9IGN1ckl0ZW0udGV4dCgpLFxuICAgICAgICAgICAgICAgICAgICAgICAgaGVpZ2h0ID0gY3VySXRlbS5oZWlnaHQoKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGNsb25lID0gY3VySXRlbS5jbG9uZSgpO1xuXG4gICAgICAgICAgICAgICAgICAgIGNsb25lLmNzcygge1xuICAgICAgICAgICAgICAgICAgICAgICAgcG9zaXRpb246ICdhYnNvbHV0ZScsXG4gICAgICAgICAgICAgICAgICAgICAgICB2aXNpYmlsaXR5OiAnaGlkZGVuJyxcbiAgICAgICAgICAgICAgICAgICAgICAgIGhlaWdodDogJ2F1dG8nXG4gICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgICAgICBjdXJJdGVtLmFmdGVyKGNsb25lKTtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgbCA9IHRleHQubGVuZ3RoIC0gMTtcblxuICAgICAgICAgICAgICAgICAgICBmb3IgKDsgbCA+PSAwICYmIGNsb25lLmhlaWdodCgpID4gaGVpZ2h0OyAtLWwgKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBjbG9uZS50ZXh0KCB0ZXh0LnN1YnN0cmluZyggMCwgbCApICk7XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBjdXJJdGVtLnRleHQoIGNsb25lLnRleHQoKSApO1xuICAgICAgICAgICAgICAgICAgICBjbG9uZS5yZW1vdmUoKTtcblxuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9jb25zdHJ1Y3QgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBfaW5pdFNsaWRlcigpO1xuICAgICAgICAgICAgICAgIF9vbkV2ZW50KCk7XG4gICAgICAgICAgICB9O1xuXG4gICAgICAgIC8vcHVibGljIHByb3BlcnRpZXNcblxuICAgICAgICAvL3B1YmxpYyBtZXRob2RzXG5cbiAgICAgICAgX2NvbnN0cnVjdCgpO1xuXG4gICAgfTtcblxuICAgIHZhciBUZWFtU2xpZGVyID0gZnVuY3Rpb24oIG9iaiApIHtcblxuICAgICAgICAvL3ByaXZhdGUgcHJvcGVydGllc1xuICAgICAgICB2YXIgX29iaiA9IG9iaixcbiAgICAgICAgICAgIF9zd2lwZXJTbGlkZXJzID0gX29iai5maW5kKCAnLnRlYW1fX3BlcnNvbicgKSxcbiAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsLFxuICAgICAgICAgICAgX2lzTW9iaWxlU2l6ZSA9IGZhbHNlLFxuICAgICAgICAgICAgX3dpbmRvdyA9ICQoIHdpbmRvdyApO1xuXG4gICAgICAgIC8vcHJpdmF0ZSBtZXRob2RzXG4gICAgICAgIHZhciBfb25FdmVudCA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgX3dpbmRvdy5vbiggJ3Jlc2l6ZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAgICAgX3VwZGF0ZVNsaWRlcigpO1xuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIF9zd2lwZXJTbGlkZXJzLm9uKCAnY2xpY2snLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICAgIFN3aXBlclBvcHVwKCBfb2JqLCAkKCB0aGlzICkuaW5kZXgoKSApO1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX3VwZGF0ZVNsaWRlciA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyU2xpZGVycy5sZW5ndGggPD0gMSApe1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA+PSA5OTIgJiYgX2lzTW9iaWxlU2l6ZSApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2U7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKCBfc3dpcGVyICE9IG51bGwgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIF9zd2lwZXIuZGVzdHJveSggdHJ1ZSwgdHJ1ZSApO1xuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlciA9IG51bGw7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIF9pbml0U2xpZGVyKCk7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA8IDk5MiAmJiAhX2lzTW9iaWxlU2l6ZSApIHtcblxuICAgICAgICAgICAgICAgICAgICBpZiAoIF9zd2lwZXIgIT0gbnVsbCApIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgX3N3aXBlci5kZXN0cm95KCB0cnVlLCB0cnVlICk7XG4gICAgICAgICAgICAgICAgICAgICAgICBfc3dpcGVyID0gbnVsbDtcblxuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgX2luaXRTbGlkZXIoKTtcblxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9pbml0U2xpZGVyID0gZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICBpZiAoIF93aW5kb3cub3V0ZXJXaWR0aCgpID49IDk5MiApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gZmFsc2U7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKCBfd2luZG93Lm91dGVyV2lkdGgoKSA8IDk5MiApIHtcblxuICAgICAgICAgICAgICAgICAgICBfaXNNb2JpbGVTaXplID0gdHJ1ZTtcblxuICAgICAgICAgICAgICAgICAgICBfc3dpcGVyID0gbmV3IFN3aXBlciggX29iaiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgZWZmZWN0OiAnc2xpZGUnLFxuICAgICAgICAgICAgICAgICAgICAgICAgY2VudGVyZWRTbGlkZXM6IHRydWUsXG4gICAgICAgICAgICAgICAgICAgICAgICBhdXRvcGxheTogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICBsb29wOiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVzUGVyVmlldzogJ2F1dG8nLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BhY2VCZXR3ZWVuOiAzMCxcbiAgICAgICAgICAgICAgICAgICAgICAgIHNwZWVkOiA1MDBcbiAgICAgICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2NvbnN0cnVjdCA9IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIF9pbml0U2xpZGVyKCk7XG4gICAgICAgICAgICAgICAgX29uRXZlbnQoKTtcbiAgICAgICAgICAgIH07XG5cbiAgICAgICAgLy9wdWJsaWMgcHJvcGVydGllc1xuXG4gICAgICAgIC8vcHVibGljIG1ldGhvZHNcblxuICAgICAgICBfY29uc3RydWN0KCk7XG5cbiAgICB9O1xuXG4gICAgdmFyIFRhYnMgPSBmdW5jdGlvbiggb2JqICkge1xuXG4gICAgICAgIC8vcHJpdmF0ZSBwcm9wZXJ0aWVzXG4gICAgICAgIHZhciBfb2JqID0gb2JqLFxuICAgICAgICAgICAgX3NlbGYgPSB0aGlzLFxuICAgICAgICAgICAgX3RhYkJ0bldyYXAgPSBfb2JqLmZpbmQoICcudGFic19faXRlbXMtd3JhcCcgKSxcbiAgICAgICAgICAgIF90YWJTY3JvbGxDb250ZW50ID0gX3RhYkJ0bldyYXAuZmluZCggJy50YWJzX19pdGVtcy1zY3JvbGwnICksXG4gICAgICAgICAgICBfdGFiQnRuID0gX3RhYkJ0bldyYXAuZmluZCggJy50YWJzX19pdGVtJyApLFxuICAgICAgICAgICAgX3RhYldyYXAgPSBfb2JqLmZpbmQoICcudGFic19fd3JhcCcgKSxcbiAgICAgICAgICAgIF90YWJDb250ZW50ID0gX3RhYldyYXAuZmluZCggJy50YWJzX19jb250ZW50JyApLFxuICAgICAgICAgICAgX3Ryb2xsZXkgPSBfb2JqLmZpbmQoICcudGFic19fdHJvbGxleScgKSxcbiAgICAgICAgICAgIF9zY3JvbGxXcmFwLFxuICAgICAgICAgICAgX3BzID0gbnVsbCxcbiAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsLFxuICAgICAgICAgICAgX3dpbmRvdyA9ICQoIHdpbmRvdyApO1xuXG4gICAgICAgIC8vcHJpdmF0ZSBtZXRob2RzXG4gICAgICAgIHZhciBfb25FdmVudCA9IGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgX3RhYkJ0bi5vbigge1xuICAgICAgICAgICAgICAgICAgICAnY2xpY2snOiBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgY3VyQnRuID0gJCggdGhpcyApLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGN1ckJ0bkluZGV4ID0gY3VyQnRuLmluZGV4KCk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIF9zaG93VGFiV3JhcCggY3VyQnRuSW5kZXggKTtcblxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAnbW91c2VvdmVyJzogZnVuY3Rpb24gKCkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgY3VySXRlbSA9ICQodGhpcyk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIF90cm9sbGV5LmNzcygge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICdsZWZ0JzogY3VySXRlbS5vZmZzZXQoKS5sZWZ0IC0gX3RhYlNjcm9sbENvbnRlbnQub2Zmc2V0KCkubGVmdCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnd2lkdGgnOiBjdXJJdGVtLm91dGVyV2lkdGgoKVxuICAgICAgICAgICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICdtb3VzZW91dCc6IGZ1bmN0aW9uICgpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgX21vdmVUcm9sbGV5KCk7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIF93aW5kb3cub24oICdyZXNpemUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICAgIF9zZXRDb250ZW50SGVpZ2h0KCk7XG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX21vdmVUcm9sbGV5ID0gZnVuY3Rpb24gKCkge1xuXG4gICAgICAgICAgICAgICAgdmFyIGFjdGl2ZSA9IF90YWJCdG4uZmlsdGVyKCAnLmlzLWFjdGl2ZScgKTtcblxuICAgICAgICAgICAgICAgIF90cm9sbGV5LmNzcygge1xuICAgICAgICAgICAgICAgICAgICBsZWZ0OiBhY3RpdmUub2Zmc2V0KCkubGVmdCAtIF90YWJTY3JvbGxDb250ZW50Lm9mZnNldCgpLmxlZnQsXG4gICAgICAgICAgICAgICAgICAgIHdpZHRoOiBhY3RpdmUub3V0ZXJXaWR0aCgpXG4gICAgICAgICAgICAgICAgfSApXG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfc2hvd1RhYldyYXAgPSBmdW5jdGlvbiAoIG51bSApIHtcblxuICAgICAgICAgICAgICAgIHZhciBjdXJUYWJJbmRleCA9IG51bSxcbiAgICAgICAgICAgICAgICAgICAgY3VyVGFiQnRuID0gX3RhYkJ0bi5lcSggY3VyVGFiSW5kZXggKSxcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlQ29udGVudCA9IF90YWJDb250ZW50LmVxKCBjdXJUYWJJbmRleCApO1xuXG4gICAgICAgICAgICAgICAgX3RhYkJ0bi5yZW1vdmVDbGFzcyggJ2lzLWFjdGl2ZScgKTtcbiAgICAgICAgICAgICAgICBjdXJUYWJCdG4uYWRkQ2xhc3MoICdpcy1hY3RpdmUnICk7XG5cbiAgICAgICAgICAgICAgICBfdGFiQ29udGVudC5yZW1vdmVDbGFzcyggJ2lzLXNob3cnICk7XG4gICAgICAgICAgICAgICAgYWN0aXZlQ29udGVudC5hZGRDbGFzcyggJ2lzLXNob3cnICk7XG5cbiAgICAgICAgICAgICAgICBfc2V0Q29udGVudEhlaWdodCgpO1xuICAgICAgICAgICAgICAgIF9tb3ZlVHJvbGxleSgpO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX3NldENvbnRlbnRIZWlnaHQgPSBmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgICAgICAgICB2YXIgYWN0aXZlQ29udGVudCA9IF90YWJDb250ZW50LmZpbHRlciggJy5pcy1zaG93JyApO1xuXG4gICAgICAgICAgICAgICAgX3RhYldyYXAuY3NzKCAnaGVpZ2h0JywgYWN0aXZlQ29udGVudC5vdXRlckhlaWdodCgpICk7XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfaW5pdFNjcm9sbCA9IGZ1bmN0aW9uICgpIHtcblxuICAgICAgICAgICAgICAgIGlmICggX3BzICE9PSBudWxsICkge1xuICAgICAgICAgICAgICAgICAgICBfcHMuZGVzdHJveSgpO1xuICAgICAgICAgICAgICAgICAgICBfcHMgPSBudWxsO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIF9zY3JvbGxXcmFwID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvciggJy50YWJzX19pdGVtcy1zY3JvbGwnICk7XG5cbiAgICAgICAgICAgICAgICBpZiAoIF90YWJTY3JvbGxDb250ZW50Lm91dGVyV2lkdGgoKSA+IF93aW5kb3cub3V0ZXJXaWR0aCgpICkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9wcyA9IG5ldyBQZXJmZWN0U2Nyb2xsYmFyKCBfc2Nyb2xsV3JhcCwge1xuICAgICAgICAgICAgICAgICAgICAgICAgc3VwcHJlc3NTY3JvbGxZOiB0cnVlXG4gICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgICAgICBfc2Nyb2xsVG9BY3RpdmUoKTtcblxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9zY3JvbGxUb0FjdGl2ZSA9IGZ1bmN0aW9uICgpIHtcblxuICAgICAgICAgICAgICAgIHZhciBhY3RpdmVJdGVtID0gX3RhYkJ0bldyYXAuZmluZCggJy5pcy1hY3RpdmUnICk7XG5cbiAgICAgICAgICAgICAgICBpZiAoIGFjdGl2ZUl0ZW0ubGVuZ3RoID4gMCApe1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciB3aW5kb3dXaWR0aCA9IF93aW5kb3cub3V0ZXJXaWR0aCgpLFxuICAgICAgICAgICAgICAgICAgICAgICAgd3JhcFdpZHRoID0gYWN0aXZlSXRlbS5vZmZzZXQoKS5sZWZ0O1xuXG4gICAgICAgICAgICAgICAgICAgIF9zY3JvbGxXcmFwLnNjcm9sbExlZnQgPSB3cmFwV2lkdGgvMiAtIHdpbmRvd1dpZHRoLzIgKyB3cmFwV2lkdGg7XG5cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfY2hlY2tBY3RpdmUgPSBmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgICAgICAgICB2YXIgYWN0aXZlVGFiQnRuID0gX3RhYkJ0bi5maWx0ZXIoICcuaXMtYWN0aXZlJyApO1xuXG4gICAgICAgICAgICAgICAgaWYgKCBhY3RpdmVUYWJCdG4ubGVuZ3RoID4gMCApIHtcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlVGFiQnRuLnRyaWdnZXIoICdjbGljaycgKVxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIF90YWJCdG4uZXEoIDAgKS50cmlnZ2VyKCAnY2xpY2snICk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2NvbnN0cnVjdCA9IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIF9vbkV2ZW50KCk7XG4gICAgICAgICAgICAgICAgX2luaXRTY3JvbGwoKTtcbiAgICAgICAgICAgICAgICBfY2hlY2tBY3RpdmUoKTtcbiAgICAgICAgICAgICAgICBfbW92ZVRyb2xsZXkoKTtcblxuICAgICAgICAgICAgICAgIF9vYmpbMF0ub2JqID0gX3NlbGZcblxuICAgICAgICAgICAgfTtcblxuICAgICAgICAvL3B1YmxpYyBwcm9wZXJ0aWVzXG5cbiAgICAgICAgLy9wdWJsaWMgbWV0aG9kc1xuICAgICAgICBfc2VsZi5zZXRIZWlnaHQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBfc2V0Q29udGVudEhlaWdodCgpO1xuICAgICAgICB9O1xuXG4gICAgICAgIF9jb25zdHJ1Y3QoKTtcbiAgICB9O1xuXG4gICAgdmFyIEhvd1RvU2VsbE1vYmlsZSA9IGZ1bmN0aW9uKCBvYmogKSB7XG5cbiAgICAgICAgLy9wcml2YXRlIHByb3BlcnRpZXNcbiAgICAgICAgdmFyIF9vYmogPSBvYmosXG4gICAgICAgICAgICBfdGFiQnRuV3JhcCA9IF9vYmouZmluZCggJy5ob3ctdG8tc2VsbF9fcGFnaW5hdGlvbicgKSxcbiAgICAgICAgICAgIF90YWJCdG4gPSBfdGFiQnRuV3JhcC5maW5kKCAnc3BhbicgKSxcbiAgICAgICAgICAgIF90YWJXcmFwID0gX29iai5maW5kKCAnLmhvdy10by1zZWxsX19jb250ZW50JyApLFxuICAgICAgICAgICAgX3RhYkNvbnRlbnQgPSBfdGFiV3JhcC5maW5kKCAnbGknICksXG4gICAgICAgICAgICBfdHJvbGxleSA9IF9vYmouZmluZCggJy5ob3ctdG8tc2VsbF9fdHJvbGxleScgKSxcbiAgICAgICAgICAgIF93aW5kb3cgPSAkKCB3aW5kb3cgKTtcblxuICAgICAgICAvL3ByaXZhdGUgbWV0aG9kc1xuICAgICAgICB2YXIgX29uRXZlbnQgPSBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIF90YWJCdG4ub24oIHtcbiAgICAgICAgICAgICAgICAgICAgJ2NsaWNrJzogZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGN1ckJ0biA9ICQoIHRoaXMgKSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjdXJCdG5JbmRleCA9IGN1ckJ0bi5pbmRleCgpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBfc2hvd1RhYldyYXAoIGN1ckJ0bkluZGV4ICk7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIF93aW5kb3cub24oICdyZXNpemUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICAgIF9zZXRDb250ZW50SGVpZ2h0KCk7XG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX21vdmVUcm9sbGV5ID0gZnVuY3Rpb24gKCkge1xuXG4gICAgICAgICAgICAgICAgdmFyIGFjdGl2ZSA9IF90YWJCdG4uZmlsdGVyKCAnLmlzLWFjdGl2ZScgKTtcblxuICAgICAgICAgICAgICAgIF90cm9sbGV5LmNzcygge1xuICAgICAgICAgICAgICAgICAgICBsZWZ0OiBhY3RpdmUub2Zmc2V0KCkubGVmdCAtIF90YWJCdG5XcmFwLm9mZnNldCgpLmxlZnQsXG4gICAgICAgICAgICAgICAgICAgIHdpZHRoOiBhY3RpdmUub3V0ZXJXaWR0aCgpXG4gICAgICAgICAgICAgICAgfSApXG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfc2hvd1RhYldyYXAgPSBmdW5jdGlvbiAoIG51bSApIHtcblxuICAgICAgICAgICAgICAgIHZhciBjdXJUYWJJbmRleCA9IG51bSxcbiAgICAgICAgICAgICAgICAgICAgY3VyVGFiQnRuID0gX3RhYkJ0bi5lcSggY3VyVGFiSW5kZXggKSxcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlQ29udGVudCA9IF90YWJDb250ZW50LmVxKCBjdXJUYWJJbmRleCApO1xuXG4gICAgICAgICAgICAgICAgX3RhYkJ0bi5yZW1vdmVDbGFzcyggJ2lzLWFjdGl2ZScgKTtcbiAgICAgICAgICAgICAgICBjdXJUYWJCdG4uYWRkQ2xhc3MoICdpcy1hY3RpdmUnICk7XG5cbiAgICAgICAgICAgICAgICBfdGFiQ29udGVudC5yZW1vdmVDbGFzcyggJ2lzLXNob3cnICk7XG4gICAgICAgICAgICAgICAgYWN0aXZlQ29udGVudC5hZGRDbGFzcyggJ2lzLXNob3cnICk7XG5cbiAgICAgICAgICAgICAgICBfc2V0Q29udGVudEhlaWdodCgpO1xuICAgICAgICAgICAgICAgIF9tb3ZlVHJvbGxleSgpO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX3NldENvbnRlbnRIZWlnaHQgPSBmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgICAgICAgICB2YXIgYWN0aXZlQ29udGVudCA9IF90YWJDb250ZW50LmZpbHRlciggJy5pcy1zaG93JyApO1xuXG4gICAgICAgICAgICAgICAgX3RhYldyYXAuY3NzKCAnaGVpZ2h0JywgYWN0aXZlQ29udGVudC5vdXRlckhlaWdodCgpICk7XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfY2hlY2tBY3RpdmUgPSBmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgICAgICAgICB2YXIgYWN0aXZlVGFiQnRuID0gX3RhYkJ0bi5maWx0ZXIoICcuaXMtYWN0aXZlJyApO1xuXG4gICAgICAgICAgICAgICAgaWYgKCBhY3RpdmVUYWJCdG4ubGVuZ3RoID4gMCApIHtcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlVGFiQnRuLnRyaWdnZXIoICdjbGljaycgKVxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIF90YWJCdG4uZXEoIDAgKS50cmlnZ2VyKCAnY2xpY2snICk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2NvbnN0cnVjdCA9IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIF9vbkV2ZW50KCk7XG4gICAgICAgICAgICAgICAgX2NoZWNrQWN0aXZlKCk7XG4gICAgICAgICAgICB9O1xuXG4gICAgICAgIC8vcHVibGljIHByb3BlcnRpZXNcblxuICAgICAgICAvL3B1YmxpYyBtZXRob2RzXG5cbiAgICAgICAgX2NvbnN0cnVjdCgpO1xuICAgIH07XG5cbiAgICB2YXIgU3dpcGVyUG9wdXAgPSBmdW5jdGlvbiAoIG9iaiwgaW5kZXggKSB7XG5cbiAgICAgICAgdmFyIF9vYmogPSBvYmosXG4gICAgICAgICAgICBfaHRtbCA9ICQoICdodG1sJyApLFxuICAgICAgICAgICAgX2JvZHkgPSAkKCAnYm9keScgKSxcbiAgICAgICAgICAgIF9zaXRlID0gJCggJy5zaXRlJyApLFxuICAgICAgICAgICAgX2xpbmtzID0gX29iai5maW5kKCAnLnN3aXBlci1zbGlkZScgKSxcbiAgICAgICAgICAgIF93aW5kb3cgPSAkKCB3aW5kb3cgKSxcbiAgICAgICAgICAgIF9wb3B1cCA9IG51bGwsXG4gICAgICAgICAgICBfcG9wdXBJbm5lciA9IG51bGwsXG4gICAgICAgICAgICBfcG9wdXBDbG9zZSA9IG51bGwsXG4gICAgICAgICAgICBfc3dpcGVyV3JhcHBlciA9IG51bGwsXG4gICAgICAgICAgICBfc3dpcGVyQ29udGFpbmVyID0gbnVsbCxcbiAgICAgICAgICAgIF9zd2lwZXJCdG5OZXh0ID0gbnVsbCxcbiAgICAgICAgICAgIF9zd2lwZXJCdG5QcmV2ID0gbnVsbCxcbiAgICAgICAgICAgIF9zd2lwZXIgPSBudWxsLFxuICAgICAgICAgICAgX3Bvc2l0aW9uID0gMDtcblxuICAgICAgICB2YXIgX2FkZEV2ZW50cyA9IGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgICAgICBfcG9wdXBJbm5lci5wYXJlbnQoKS5vbiggJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIF9jbG9zZVBvcHVwKCk7XG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgX3BvcHVwSW5uZXIub24oICdjbGljaycsIGZ1bmN0aW9uKCBldmVudCApIHtcbiAgICAgICAgICAgICAgICAgICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2FkZGluZ1ZhcmlhYmxlcyA9IGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgICAgICBfcG9wdXAgPSAkKCAnPGRpdiBjbGFzcz1cInN3aXBlci1wb3B1cFwiPlxcXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwic3dpcGVyLWNvbnRhaW5lclwiPlxcXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cInN3aXBlci13cmFwcGVyXCI+PC9kaXY+XFxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxcXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PicgKTtcbiAgICAgICAgICAgICAgICBfc3dpcGVyV3JhcHBlciA9IF9wb3B1cC5maW5kKCAnLnN3aXBlci13cmFwcGVyJyApO1xuICAgICAgICAgICAgICAgIF9zd2lwZXJDb250YWluZXIgPSBfcG9wdXAuZmluZCggJy5zd2lwZXItY29udGFpbmVyJyApO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2J1aWxkUG9wdXAgPSBmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICAgICAgX2FkZGluZ1ZhcmlhYmxlcygpO1xuICAgICAgICAgICAgICAgIF9jb250ZW50RmlsbGluZygpO1xuICAgICAgICAgICAgICAgIF9pbml0U3dpcGVyKCk7XG4gICAgICAgICAgICAgICAgX3N3aXBlci5zbGlkZVRvKCBpbmRleCArIDEsIDAgKTtcbiAgICAgICAgICAgICAgICBfcG9wdXAuYWRkQ2xhc3MoICdpcy1hY3RpdmUnICk7XG4gICAgICAgICAgICAgICAgX3NldFN0eWxlcygpO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2Nsb3NlUG9wdXAgPSBmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICAgICAgX3BvcHVwLnJlbW92ZUNsYXNzKCAnaXMtYWN0aXZlJyApO1xuXG4gICAgICAgICAgICAgICAgX3BvcHVwLm9uKCAnd2Via2l0VHJhbnNpdGlvbkVuZCBvdHJhbnNpdGlvbmVuZCBvVHJhbnNpdGlvbkVuZCBtc1RyYW5zaXRpb25FbmQgdHJhbnNpdGlvbmVuZCcsIGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgICAgIF9odG1sLnJlbW92ZUF0dHIoICdzdHlsZScgKTtcbiAgICAgICAgICAgICAgICAgICAgX2JvZHkucmVtb3ZlQXR0ciggJ3N0eWxlJyApO1xuICAgICAgICAgICAgICAgICAgICBfc2l0ZS5yZW1vdmVBdHRyKCAnc3R5bGUnICk7XG5cbiAgICAgICAgICAgICAgICAgICAgX3dpbmRvdy5zY3JvbGxUb3AoIF9wb3NpdGlvbiApO1xuICAgICAgICAgICAgICAgICAgICBfcG9zaXRpb24gPSAwO1xuXG4gICAgICAgICAgICAgICAgICAgIF9wb3B1cC5yZW1vdmUoKTtcblxuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9jb250ZW50RmlsbGluZyA9IGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgICAgICAkLmVhY2goIF9saW5rcywgZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgY3VySXRlbSA9ICQoIHRoaXMgKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGN1ckRhdGEgPSBKU09OLnBhcnNlKCBjdXJJdGVtLmF0dHIoICdkYXRhLXBlcnNvbicgKSApO1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciBuZXdJdGVtID0gJCggJzxkaXYgY2xhc3M9XCJzd2lwZXItc2xpZGVcIj48ZGl2IGNsYXNzPVwic3dpcGVyLXBvcHVwX19pbm5lclwiPicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzxkaXYgY2xhc3M9XCJzd2lwZXItcG9wdXBfX3Bob3RvXCI+PGltZyBzcmM9XCInKyBjdXJEYXRhLnBob3RvICsnXCIgYWx0PVwiJysgY3VyRGF0YS5uYW1lICsnXCI+PC9kaXY+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGRpdiBjbGFzcz1cInN3aXBlci1wb3B1cF9fY29udGVudFwiPjxoMz4nKyBjdXJEYXRhLm5hbWUgKyc8aT4nKyBjdXJEYXRhLnBvc3QgKyc8L2k+PC9oMz48cD4nKyBjdXJEYXRhLmluZm8gKyc8L3A+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGRpdiBjbGFzcz1cInN3aXBlci1wb3B1cF9fc29jaWFsXCI+PGEgaHJlZj1cIicrIGN1ckRhdGEudHdpdHRlciArJ1wiPjxzdmcgeG1sbnM9XCJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2Z1wiIHhtbG5zOnhsaW5rPVwiaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGlua1wiIHZpZXdCb3g9XCIwIDAgNTAgNDFcIj4nICtcbiAgICAgICAgICAgICAgICAgICAgICAgICc8ZyBzdHJva2U9XCJub25lXCIgc3Ryb2tlLXdpZHRoPVwiMVwiIGZpbGw9XCJub25lXCIgZmlsbC1ydWxlPVwiZXZlbm9kZFwiPicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzxnIHRyYW5zZm9ybT1cInRyYW5zbGF0ZSgtOTEuMDAwMDAwLCAtNTk0LjAwMDAwMClcIiBmaWxsPVwiIzAwMDAwMFwiIGZpbGwtcnVsZT1cIm5vbnplcm9cIj4nICtcbiAgICAgICAgICAgICAgICAgICAgICAgICc8ZyB0cmFuc2Zvcm09XCJ0cmFuc2xhdGUoOTEuMDAwMDAwLCA1OTEuMDAwMDAwKVwiPjxnIHRyYW5zZm9ybT1cInRyYW5zbGF0ZSgwLjAwMDAwMCwgMy4wMDAwMDApXCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPHBhdGggZD1cIk01MCw0Ljg1MDk0NTE1IEM0OC4xNTk3MTkyLDUuNjc0MTMwMzQgNDYuMTg1MTI0NSw2LjIzMjQwNTEyIDQ0LjExMDQ0NzksNi40ODE2NDUyNCBDNDYuMjI4ODMzNyw1LjIwMTA1MjQ2IDQ3Ljg1MDQwNSwzLjE2OTg1MjY5IDQ4LjYxODk1MiwwLjc1Njk1NzU5IEM0Ni42MzE4NTcyLDEuOTQyODY4ODEgNDQuNDM4NDcxMywyLjgwMzk5MjYxIDQyLjEwMTM3NiwzLjI3MDgwMjM2IEM0MC4yMjk4ODYsMS4yNTUzNTUzNiAzNy41Njc4NzE4LDAgMzQuNjE1MjUyNiwwIEMyOC45NTA3MDA5LDAgMjQuMzU3ODAxMiw0LjYzNjUwOTU3IDI0LjM1NzgwMTIsMTAuMzUxNzEyNiBDMjQuMzU3ODAxMiwxMS4xNjIyNzkxIDI0LjQ0ODQwNiwxMS45NTM5NTg3IDI0LjYyMzQwNjIsMTIuNzEwOTk4OCBDMTYuMTAwMDI2MywxMi4yNzg4Mjg2IDguNTQyMDg5MTIsOC4xNTY0Njk1OCAzLjQ4MzY2NTgyLDEuODkyMzkzOTcgQzIuNTk5NDMyMzUsMy40MTkwMTAzNCAyLjA5NjQwODY1LDUuMTk3ODM1OTMgMi4wOTY0MDg2NSw3LjA5NjY2Mjk3IEMyLjA5NjQwODY1LDEwLjY4OTIwMTIgMy45MDg1ODQ4MiwxMy44NTkwNTM5IDYuNjU4MDk5MTEsMTUuNzEzNTkxNyBDNC45NzcxMzIzMiwxNS42NTY4NDg4IDMuMzk2MTY1NjgsMTUuMTkwMDM5IDIuMDEyMDk0NzksMTQuNDE0MTEyMSBMMi4wMTIwOTQ3OSwxNC41NDM0MzMzIEMyLjAxMjA5NDc5LDE5LjU1ODQyMTYgNS41NDg5NDY5OCwyMy43NDM4NzQyIDEwLjIzODY2MDUsMjQuNjk2NDYzIEM5LjM3OTQyNzA5LDI0LjkyOTg2NzkgOC40NzMzNzk4NiwyNS4wNTkxODkgNy41MzYwNDE3MywyNS4wNTkxODkgQzYuODczNzA0MDQsMjUuMDU5MTg5IDYuMjMzMTgwMTIsMjQuOTkyOTYxNCA1LjYwNTE1NjIyLDI0Ljg2Njc3NDQgQzYuOTExMTIyNCwyOC45ODI4NjUzIDEwLjY5Nzk3NSwzMS45NzYwNTYgMTUuMTg0NjY1MywzMi4wNTgxMTg5IEMxMS42NzU5MTc4LDM0LjgzMzc0IDcuMjUxNzI3NTQsMzYuNDgzMzI2OSAyLjQ0NjQwOTIzLDM2LjQ4MzMyNjkgQzEuNjE4NDY2NywzNi40ODMzMjY5IDAuODAyOTQyNDg4LDM2LjQzMjg1MjEgMCwzNi4zNDEzODcxIEM0LjUzOTc5NSwzOS4yODQxODU1IDkuOTI5NDI3OTksNDEgMTUuNzIyMDg0NSw0MSBDMzQuNTkwNDE2LDQxIDQ0LjkwNDE1ODMsMjUuMjIzMjMyMyA0NC45MDQxNTgzLDExLjU0MDg0MDMgTDQ0Ljg2OTc2MjksMTAuMjAwMzcwNSBDNDYuODg0OTYyMiw4Ljc0OTM4Mzk1IDQ4LjYyODM0NzQsNi45MjYzNTE2NCA1MCw0Ljg1MDk0NTE1IFpcIiAvPicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzwvZz48L2c+PC9nPjwvZz48L3N2Zz48L2E+PGEgaHJlZj1cIicrIGN1ckRhdGEuZmFjZWJvb2sgKydcIj48c3ZnIHhtbG5zPVwiaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmdcIiB4bWxuczp4bGluaz1cImh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmtcIiB2aWV3Qm94PVwiMCAwIDIyIDQxXCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGcgc3Ryb2tlPVwibm9uZVwiIHN0cm9rZS13aWR0aD1cIjFcIiBmaWxsPVwibm9uZVwiIGZpbGwtcnVsZT1cImV2ZW5vZGRcIj4nICtcbiAgICAgICAgICAgICAgICAgICAgICAgICc8ZyB0cmFuc2Zvcm09XCJ0cmFuc2xhdGUoLTE4MS4wMDAwMDAsIC01OTQuMDAwMDAwKVwiIGZpbGw9XCIjMDAwMDAwXCIgZmlsbC1ydWxlPVwibm9uemVyb1wiPicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzxnIHRyYW5zZm9ybT1cInRyYW5zbGF0ZSg5MS4wMDAwMDAsIDU5MS4wMDAwMDApXCI+PGcgdHJhbnNmb3JtPVwidHJhbnNsYXRlKDkwLjAwMDAwMCwgMy4wMDAwMDApXCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPHBhdGggZD1cIk0yMSwwIEwxNiwwIEM5Ljk2NjQ0MTUzLDAgNi4xMzUzMTE0NCwzLjk2MDM5NDQ5IDYsMTAgTDYsMTUgTDEsMTUgQzAuMzcxMjU5Nzg5LDE0Ljc0MjM5MjYgMCwxNS4xMTY4OTE5IDAsMTYgTDAsMjIgQzAsMjIuNzgxMzMyMyAwLjM3MTY4MzExOSwyMy4xNTU0MDUxIDEsMjMgTDYsMjMgTDYsNDAgQzYuMTM1MzExNDQsNDAuNjI1OTI3MiA2LjUwNjU3MTIzLDQxIDcsNDEgTDE0LDQxIEMxNC4zNDU3ODMxLDQxIDE0LjcxNzA0MjksNDAuNjI1NTAwNyAxNSw0MCBMMTUsMjMgTDIxLDIzIEMyMS4zNzg5NzU5LDIzLjE1NTQwNTEgMjEuNzUwMjM1NywyMi43ODEzMzIzIDIyLDIyIEwyMiwxNiBDMjEuNzUyNzc1NywxNS4zNTcwMzIxIDIxLjY2NTE0NjUsMTUuMTQ0NjE2OCAyMiwxNSBDMjEuMzU0NDIyOCwxNC44MzA2ODU3IDIxLjE0Mjc1ODIsMTQuNzQyMzkyNiAyMSwxNSBMMTUsMTUgTDE1LDExIEMxNC43MTcwNDI5LDguOTAzMTAzMzIgMTUuMTY1MzQ4Niw3Ljk0MDgzNjIyIDE4LDggTDIxLDggQzIxLjYyODc0MDIsNy45Mzk1NTY2MSAyMiw3LjU2NTA1NzI3IDIyLDcgTDIyLDEgQzIyLDAuMzgzNDU2NjEzIDIxLjYyOTE2MzUsMC4wMDkzODM4MTAzMyAyMSwwIFpcIiAvPlxcbicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzwvZz48L2c+PC9nPjwvZz48L3N2Zz48L2E+PGEgaHJlZj1cIicrIGN1ckRhdGEubGlua2VkaW4gKydcIj48c3ZnIHhtbG5zPVwiaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmdcIiB4bWxuczp4bGluaz1cImh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmtcIiB2aWV3Qm94PVwiMCAwIDQxIDQxXCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGcgc3Ryb2tlPVwibm9uZVwiIHN0cm9rZS13aWR0aD1cIjFcIiBmaWxsPVwibm9uZVwiIGZpbGwtcnVsZT1cImV2ZW5vZGRcIj48ZyB0cmFuc2Zvcm09XCJ0cmFuc2xhdGUoLTI0My4wMDAwMDAsIC01OTEuMDAwMDAwKVwiIGZpbGw9XCIjMDAwMDAwXCIgZmlsbC1ydWxlPVwibm9uemVyb1wiPicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzxnIHRyYW5zZm9ybT1cInRyYW5zbGF0ZSg5MS4wMDAwMDAsIDU5MS4wMDAwMDApXCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPHBhdGggZD1cIk0xNjEuMzk1ODMzLDEzLjY2NjY2NjcgQzE2MS45MDgzMzMsMTMuNjY2NjY2NyAxNjIuMjUsMTQuMDA4MzMzMyAxNjIuMjUsMTQuNTIwODMzMyBMMTYyLjI1LDQwLjE0NTgzMzMgQzE2Mi4yNSw0MC42NTgzMzMzIDE2MS45MDgzMzMsNDEgMTYxLjM5NTgzMyw0MSBMMTUyLjg1NDE2Nyw0MSBDMTUyLjM0MTY2Nyw0MSAxNTIsNDAuNjU4MzMzMyAxNTIsNDAuMTQ1ODMzMyBMMTUyLDE0LjUyMDgzMzMgQzE1MiwxNC4wMDgzMzMzIDE1Mi4zNDE2NjcsMTMuNjY2NjY2NyAxNTIuODU0MTY3LDEzLjY2NjY2NjcgTDE2MS4zOTU4MzMsMTMuNjY2NjY2NyBaIE0xNTcuNDY2NjY3LDAgQzE2MC41NDE2NjcsMCAxNjIuOTMzMzMzLDIuMzkxNjY2NjcgMTYyLjkzMzMzMyw1LjQ2NjY2NjY3IEMxNjIuOTMzMzMzLDguNTQxNjY2NjcgMTYwLjM3MDgzMywxMS4xMDQxNjY3IDE1Ny40NjY2NjcsMTEuMTA0MTY2NyBDMTU0LjU2MjUsMTEuMTA0MTY2NyAxNTIsOC41NDE2NjY2NyAxNTIsNS40NjY2NjY2NyBDMTUyLDIuMzkxNjY2NjcgMTU0LjU2MjUsMCAxNTcuNDY2NjY3LDAgWiBNMTgyLjc1LDEzLjQ5NTgzMzMgQzE4OC4zODc1LDEzLjQ5NTgzMzMgMTkzLDE4LjEwODMzMzMgMTkzLDIzLjc0NTgzMzMgTDE5Myw0MC4xNDU4MzMzIEMxOTMsNDAuNjU4MzMzMyAxOTIuNjU4MzMzLDQxIDE5Mi4xNDU4MzMsNDEgTDE4My42MDQxNjcsNDEgQzE4My4wOTE2NjcsNDEgMTgyLjc1LDQwLjY1ODMzMzMgMTgyLjc1LDQwLjE0NTgzMzMgTDE4Mi43NSwyNi4xMzc1IEMxODIuNzUsMjQuMDg3NSAxODAuNTI5MTY3LDIyLjM3OTE2NjcgMTc4LjQ3OTE2NywyMi4zNzkxNjY3IEMxNzYuNDI5MTY3LDIyLjM3OTE2NjcgMTc0LjIwODMzMywyMy45MTY2NjY3IDE3NC4yMDgzMzMsMjYuMTM3NSBMMTc0LjIwODMzMyw0MC4xNDU4MzMzIEMxNzQuMjA4MzMzLDQwLjY1ODMzMzMgMTczLjg2NjY2Nyw0MSAxNzMuMzU0MTY3LDQxIEwxNjYuNTIwODMzLDQxIEMxNjYuMDA4MzMzLDQxIDE2NS42NjY2NjcsNDAuNjU4MzMzMyAxNjUuNjY2NjY3LDQwLjE0NTgzMzMgTDE2NS42NjY2NjcsMTQuNTIwODMzMyBDMTY1LjY2NjY2NywxNC4wMDgzMzMzIDE2Ni4wMDgzMzMsMTMuNjY2NjY2NyAxNjYuNTIwODMzLDEzLjY2NjY2NjcgTDE3My4zNTQxNjcsMTMuNjY2NjY2NyBDMTczLjg2NjY2NywxMy42NjY2NjY3IDE3NC4yMDgzMzMsMTQuMDA4MzMzMyAxNzQuMjA4MzMzLDE0LjUyMDgzMzMgTDE3NC4yMDgzMzMsMTUuMzc1IEMxNzUuNzQ1ODMzLDE0LjUyMDgzMzMgMTc4LjY1LDEzLjQ5NTgzMzMgMTgyLjc1LDEzLjQ5NTgzMzMgWlwiLz4nICtcbiAgICAgICAgICAgICAgICAgICAgICAgICc8L2c+PC9nPjwvZz48L3N2Zz48L2E+PC9kaXY+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGRpdiBjbGFzcz1cInN3aXBlci1wb3B1cF9fY2xvc2VcIj48YSBocmVmPVwiI1wiPkJhY2s8L2E+PC9kaXY+PC9kaXY+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPHNwYW4gY2xhc3M9XCJzd2lwZXItcG9wdXBfX3ByZXZcIj48c3ZnIHhtbG5zPVwiaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmdcIiB4bWxuczp4bGluaz1cImh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmtcIiB2aWV3Qm94PVwiMCAwIDI1IDQ2XCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGcgc3Ryb2tlPVwibm9uZVwiIHN0cm9rZS13aWR0aD1cIjFcIiBmaWxsPVwibm9uZVwiIGZpbGwtcnVsZT1cImV2ZW5vZGRcIiBzdHJva2UtbGluZWNhcD1cInJvdW5kXCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGcgdHJhbnNmb3JtPVwidHJhbnNsYXRlKC00OS4wMDAwMDAsIC02ODQuMDAwMDAwKVwiIHN0cm9rZT1cIiM5Nzk3OTdcIiBzdHJva2Utd2lkdGg9XCIyXCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPHBhdGggZD1cIk01MC4yOTAyMDMxLDcwNi4yOTk2OCBMNzEuMzA4NTcyMyw2ODUuMjkwMDgyIEM3MS42OTU1MDk4LDY4NC45MDMzMDYgNzIuMzIyODU5NCw2ODQuOTAzMzA2IDcyLjcwOTc5NjksNjg1LjI5MDA4MiBDNzMuMDk2NzM0NCw2ODUuNjc2ODU4IDczLjA5NjczNDQsNjg2LjMwMzk0NiA3Mi43MDk3OTY5LDY4Ni42OTA3MjIgTDUyLjM5MjA0LDcwNyBMNzIuNzA5Nzk2OSw3MjcuMzA5Mjc4IEM3My4wOTY3MzQ0LDcyNy42OTYwNTQgNzMuMDk2NzM0NCw3MjguMzIzMTQyIDcyLjcwOTc5NjksNzI4LjcwOTkxOCBDNzIuMzIyODU5NCw3MjkuMDk2Njk0IDcxLjY5NTUwOTgsNzI5LjA5NjY5NCA3MS4zMDg1NzIzLDcyOC43MDk5MTggTDUwLjI5MDIwMzEsNzA3LjcwMDMyIEM0OS45MDMyNjU2LDcwNy4zMTM1NDQgNDkuOTAzMjY1Niw3MDYuNjg2NDU2IDUwLjI5MDIwMzEsNzA2LjI5OTY4IFpcIiBpZD1cImFycm93LWxlZnRcIi8+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPC9nPjwvZz48L3N2Zz48L3NwYW4+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPHNwYW4gY2xhc3M9XCJzd2lwZXItcG9wdXBfX25leHRcIj48c3ZnIHhtbG5zPVwiaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmdcIiB4bWxuczp4bGluaz1cImh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmtcIiB2aWV3Qm94PVwiMCAwIDI1IDQ2XCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGcgc3Ryb2tlPVwibm9uZVwiIHN0cm9rZS13aWR0aD1cIjFcIiBmaWxsPVwibm9uZVwiIGZpbGwtcnVsZT1cImV2ZW5vZGRcIiBzdHJva2UtbGluZWNhcD1cInJvdW5kXCI+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPGcgdHJhbnNmb3JtPVwidHJhbnNsYXRlKC0zMDAuMDAwMDAwLCAtNjg0LjAwMDAwMClcIiBzdHJva2U9XCIjOTc5Nzk3XCIgc3Ryb2tlLXdpZHRoPVwiMlwiPicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzxwYXRoIGQ9XCJNMzAxLjI5MDIwMyw3MDYuMjk5NjggTDMyMi4zMDg1NzIsNjg1LjI5MDA4MiBDMzIyLjY5NTUxLDY4NC45MDMzMDYgMzIzLjMyMjg1OSw2ODQuOTAzMzA2IDMyMy43MDk3OTcsNjg1LjI5MDA4MiBDMzI0LjA5NjczNCw2ODUuNjc2ODU4IDMyNC4wOTY3MzQsNjg2LjMwMzk0NiAzMjMuNzA5Nzk3LDY4Ni42OTA3MjIgTDMwMy4zOTIwNCw3MDcgTDMyMy43MDk3OTcsNzI3LjMwOTI3OCBDMzI0LjA5NjczNCw3MjcuNjk2MDU0IDMyNC4wOTY3MzQsNzI4LjMyMzE0MiAzMjMuNzA5Nzk3LDcyOC43MDk5MTggQzMyMy4zMjI4NTksNzI5LjA5NjY5NCAzMjIuNjk1NTEsNzI5LjA5NjY5NCAzMjIuMzA4NTcyLDcyOC43MDk5MTggTDMwMS4yOTAyMDMsNzA3LjcwMDMyIEMzMDAuOTAzMjY2LDcwNy4zMTM1NDQgMzAwLjkwMzI2Niw3MDYuNjg2NDU2IDMwMS4yOTAyMDMsNzA2LjI5OTY4IFpcIiBpZD1cImFycm93LXJpZ2h0XCIgdHJhbnNmb3JtPVwidHJhbnNsYXRlKDMxMi41MDAwMDAsIDcwNy4wMDAwMDApIHJvdGF0ZSgtMTgwLjAwMDAwMCkgdHJhbnNsYXRlKC0zMTIuNTAwMDAwLCAtNzA3LjAwMDAwMCkgXCIvPicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzwvZz48L2c+PC9zdmc+PC9zcGFuPicgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzwvZGl2PjwvZGl2PicgKTtcblxuICAgICAgICAgICAgICAgICAgICBfc3dpcGVyV3JhcHBlci5hcHBlbmQoIG5ld0l0ZW0gKTtcblxuICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIF9ib2R5LmFwcGVuZCggX3BvcHVwICk7XG5cbiAgICAgICAgICAgICAgICBfcG9wdXBJbm5lciA9IF9wb3B1cC5maW5kKCAnLnN3aXBlci1wb3B1cF9faW5uZXInICk7XG5cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfZ2V0U2Nyb2xsV2lkdGggPSBmdW5jdGlvbiAoKXtcblxuICAgICAgICAgICAgICAgIHZhciBzY3JvbGxEaXYgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCAnZGl2JyksXG4gICAgICAgICAgICAgICAgICAgIHNjcm9sbEJhcldpZHRoO1xuXG4gICAgICAgICAgICAgICAgc2Nyb2xsRGl2LmNsYXNzTmFtZSA9ICdwb3B1cF9fc2Nyb2xsYmFyLW1lYXN1cmUnO1xuXG4gICAgICAgICAgICAgICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZCggc2Nyb2xsRGl2ICk7XG5cbiAgICAgICAgICAgICAgICBzY3JvbGxCYXJXaWR0aCA9IHNjcm9sbERpdi5vZmZzZXRXaWR0aCAtIHNjcm9sbERpdi5jbGllbnRXaWR0aDtcblxuICAgICAgICAgICAgICAgIGRvY3VtZW50LmJvZHkucmVtb3ZlQ2hpbGQoc2Nyb2xsRGl2KTtcblxuICAgICAgICAgICAgICAgIHJldHVybiBzY3JvbGxCYXJXaWR0aDtcblxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIF9pbml0U3dpcGVyID0gZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgIF9zd2lwZXJCdG5OZXh0ID0gX3BvcHVwLmZpbmQoICcuc3dpcGVyLXBvcHVwX19uZXh0JyApO1xuICAgICAgICAgICAgICAgIF9zd2lwZXJCdG5QcmV2ID0gX3BvcHVwLmZpbmQoICcuc3dpcGVyLXBvcHVwX19wcmV2JyApO1xuICAgICAgICAgICAgICAgIF9wb3B1cENsb3NlID0gX3BvcHVwLmZpbmQoICcuc3dpcGVyLXBvcHVwX19jbG9zZSBhJyApO1xuXG4gICAgICAgICAgICAgICAgX3BvcHVwQ2xvc2Uub24oICdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBfY2xvc2VQb3B1cCgpO1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgX3N3aXBlciA9IG5ldyBTd2lwZXIoIF9zd2lwZXJDb250YWluZXIsIHtcbiAgICAgICAgICAgICAgICAgICAgc2xpZGVzUGVyVmlldzogMSxcbiAgICAgICAgICAgICAgICAgICAgdGhyZXNob2xkOiAxMCxcbiAgICAgICAgICAgICAgICAgICAgbG9vcDogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgbmF2aWdhdGlvbjoge1xuICAgICAgICAgICAgICAgICAgICAgICAgbmV4dEVsOiBfc3dpcGVyQnRuTmV4dCxcbiAgICAgICAgICAgICAgICAgICAgICAgIHByZXZFbDogX3N3aXBlckJ0blByZXZcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgX2NvbnN0cnVjdCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICBfYnVpbGRQb3B1cCgpO1xuICAgICAgICAgICAgICAgIF9hZGRFdmVudHMoKTtcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBfc2V0U3R5bGVzID0gZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgIGlmICggX3dpbmRvdy5zY3JvbGxUb3AoKSAhPT0gMCApe1xuICAgICAgICAgICAgICAgICAgICBfcG9zaXRpb24gPSBfd2luZG93LnNjcm9sbFRvcCgpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIF9odG1sLmNzcygge1xuICAgICAgICAgICAgICAgICAgICBvdmVyZmxvd1k6ICdoaWRkZW4nLFxuICAgICAgICAgICAgICAgICAgICBwYWRkaW5nUmlnaHQ6IF9nZXRTY3JvbGxXaWR0aCgpXG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgX2JvZHkuY3NzKCAnb3ZlcmZsb3cteScsICdoaWRkZW4nICk7XG5cbiAgICAgICAgICAgICAgICBfc2l0ZS5jc3MoIHtcbiAgICAgICAgICAgICAgICAgICAgJ3Bvc2l0aW9uJzogJ3JlbGF0aXZlJyxcbiAgICAgICAgICAgICAgICAgICAgJ3RvcCc6IF9wb3NpdGlvbiAqIC0xXG4gICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICB9O1xuXG4gICAgICAgIF9jb25zdHJ1Y3QoKTtcblxuICAgIH07XG5cbn0gKSgpOyJdfQ==
