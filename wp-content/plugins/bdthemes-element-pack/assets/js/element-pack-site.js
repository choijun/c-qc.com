( function( $, elementor ) {

	"use strict";

	var ElementPack = {

		init: function() {

			var widgets = {
				'bdt-advanced-gmap.default' 	: ElementPack.widgetAvdGoogleMap,
				'bdt-animated-heading.default'  : ElementPack.widgetAnimatedHeading,
				'bdt-audio-player.default' 		: ElementPack.widgetAudioPlayer,
				'bdt-carousel.default' 			: ElementPack.widgetCarousel,
				'bdt-carousel.bdt-alice' 		: ElementPack.widgetCarousel,
				'bdt-carousel.bdt-vertical' 	: ElementPack.widgetCarousel,
				'bdt-slider.default' 			: ElementPack.widgetSlider,
				'bdt-circle-menu.default' 		: ElementPack.widgetCircleMenu,
				'bdt-contact-form.default' 		: ElementPack.widgetSimpleContactForm,
				'bdt-iconnav.default' 			: ElementPack.widgetIconNav,
				'bdt-iframe.default' 			: ElementPack.widgetIframe,
				'bdt-image-compare.default' 	: ElementPack.widgetImageCompare,
				'bdt-image-magnifier.default' 	: ElementPack.widgetImageMagnifier,
				//'bdt-image-magnifier.bdt-thumbnail' : ElementPack.widgetImageMagnifierThumb,
				'bdt-instagram.default' 		: ElementPack.widgetInstagram,
				'bdt-marker.default' 			: ElementPack.widgetMarker,
				'bdt-scrollnav.default' 		: ElementPack.widgetScrollNav,
				'bdt-post-grid-tab.default' 	: ElementPack.widgetPostGridTab,
				'bdt-price-table.default' 		: ElementPack.widgetPriceTable,
				'bdt-price-table.bdt-partait' 	: ElementPack.widgetPriceTable,
				'bdt-progress-pie.default' 		: ElementPack.widgetProgressPie,
				'bdt-qrcode.default' 			: ElementPack.widgetQRCode,
				'bdt-weather.default' 			: ElementPack.widgetWeather,
			};

			$.each( widgets, function( widget, callback ) {
				elementor.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});

			elementor.hooks.addAction( 'frontend/element_ready/section', ElementPack.elementorSection );
		},		
		
		//Animated Heading object
		widgetAnimatedHeading: function( $scope ) {
			var $animatedHeading = $scope.find( '.bdt-heading > * > .bdt-animated-heading' );
				
			if ( ! $animatedHeading.length ) {
				return;
			}

    		if ( $animatedHeading.data('heading_layout') == 'animated' ) {
				$($animatedHeading).Morphext({
				    animation : $animatedHeading.data('heading_animation'), 
				    speed     : $animatedHeading.data('heading_animation_delay'),
				});
			} else if ( $animatedHeading.data('heading_layout') == 'typed' ) {
				var animateSelector = $($animatedHeading).attr('id');
				var typed = new Typed('#'+animateSelector, {
				  strings    : $animatedHeading.data('animate_text'),
				  typeSpeed  : $animatedHeading.data('type_speed'),
				  startDelay : $animatedHeading.data('start_delay'),
				  backSpeed  : $animatedHeading.data('back_speed'),
				  backDelay  : $animatedHeading.data('back_delay'),
				  loop       : $animatedHeading.data('type_loop'),
				  loopCount  : $animatedHeading.data('type_loop_count'),
				});
			}

		},

		//Audio Player object
		widgetAudioPlayer: function( $scope ) {

			var $audioPlayer         = $scope.find( '.bdt-audio-player > .jp-jplayer' ),
				audioPlayerContainer = $scope.find( '.bdt-audio-player > .jp-audio' ).attr('id'),
				$container 			 = $audioPlayer.next('.jp-audio').attr('id');
				

			if ( ! $audioPlayer.length ) {
				return;
			}

			$($audioPlayer).jPlayer({
				ready: function (event) {
					$(this).jPlayer("setMedia", {
						title : $audioPlayer.data('audio_title'),
						mp3   : $audioPlayer.data('audio_source'),
					});
					if($audioPlayer.data('autoplay')) {
						$(this).jPlayer("play", 1);
					}
				},
				play: function() {
					$(this).next('.jp-audio').removeClass('bdt-player-played');
					$(this).jPlayer("pauseOthers");
				},
				ended: function() {
			    	$(this).next('.jp-audio').addClass('bdt-player-played');
			  	},

				timeupdate: function(event) {
					if($audioPlayer.data('time_restrict')) {
						if ( event.jPlayer.status.currentTime > $audioPlayer.data('restrict_duration') ) {
							$(this).jPlayer('stop');
						}
					}
				},

				cssSelectorAncestor : '#' + $container,
				useStateClassSkin   : true,
				autoBlur            : $audioPlayer.data('smooth_show'),
				smoothPlayBar       : true,
				keyEnabled          : $audioPlayer.data('keyboard_enable'),
				remainingDuration   : true,
				toggleDuration      : true,
				volume              : $audioPlayer.data('volume_level')
			});

		},

		//Advanced Google Map object
		widgetAvdGoogleMap: function( $scope ) {

			var $advancedGoogleMap = $scope.find( '.bdt-advanced-gmap' ),
				map_settings       = $advancedGoogleMap.data('map_settings'),
				markers            = $advancedGoogleMap.data('map_markers'),
				map_form           = $scope.find('.bdt-gmap-search-wrapper > form');				

			if ( ! $advancedGoogleMap.length ) {
				return;
			}
			
			var avdGoogleMap = new GMaps( map_settings );

			for (var i in markers) {
				avdGoogleMap.addMarker(markers[i]);
			}

			if($advancedGoogleMap.data('map_geocode')) {
				$(map_form).submit(function(e){
					e.preventDefault();
					GMaps.geocode({
						address: $(this).find('.bdt-search-input').val().trim(),
						callback: function(results, status){
							if(status=='OK'){
								var latlng = results[0].geometry.location;
								avdGoogleMap.setCenter(latlng.lat(), latlng.lng());
								avdGoogleMap.addMarker({
									lat: latlng.lat(),
									lng: latlng.lng()
								});
							}	
						}
					});
				});
			}

			if($advancedGoogleMap.data('map_style')) {
		        avdGoogleMap.addStyle({
		            styledMapName:"Custom Map",
		            styles: $advancedGoogleMap.data('map_style'),
		            mapTypeId: "map_style"  
		        });
		        avdGoogleMap.setStyle("map_style");
	        }
			

		},

		//Carousel object
		widgetCarousel: function( $scope ) {

			var $carousel 		   = $scope.find( '.bdt-carousel' );
				
			if ( ! $carousel.length ) {
				return;
			}

			ElementPack.swiperSlider($carousel);
			
		    
		},

		//Carousel object
		widgetSlider: function( $scope ) {

			var $slider = $scope.find( '.bdt-slider' );
				
			if ( ! $slider.length ) {
				return;
			}

			ElementPack.swiperSlider($slider);
			
		    
		},

		swiperSlider: function( $slider ) {

			var $sliderContainer = $slider.find('.swiper-container'),
				$settings 		 = $slider.data('settings');

		    var swiper = new Swiper($sliderContainer, $settings);

		    console.log($settings);

		    if ($settings['pauseOnHover']) {
			 	$($sliderContainer).hover(function() {
				    (this).swiper.autoplay.stop();
				}, function() {
				    (this).swiper.autoplay.start();
				});
			}
		},

		//Image Compare object
		widgetImageCompare: function( $scope ) {

			var $imageCompare         = $scope.find( '.bdt-image-compare > .twentytwenty-container' ),
				default_offset_pct    = $imageCompare.data('default_offset_pct'),
				orientation           = $imageCompare.data('orientation'),
				before_label          = $imageCompare.data('before_label'),
				after_label           = $imageCompare.data('after_label'),
				no_overlay            = $imageCompare.data('no_overlay'),
				move_slider_on_hover  = $imageCompare.data('move_slider_on_hover'),
				move_with_handle_only = $imageCompare.data('move_with_handle_only'),
				click_to_move         = $imageCompare.data('click_to_move');

			if ( ! $imageCompare.length ) {
				return;
			}

			$($imageCompare).twentytwenty({
			    default_offset_pct: default_offset_pct,
			    orientation: orientation,
			    before_label: before_label,
			    after_label: after_label,
			    no_overlay: no_overlay,
			    move_slider_on_hover: move_slider_on_hover,
			    move_with_handle_only: move_with_handle_only,
			    click_to_move: click_to_move
		  	});

		},

		widgetQRCode: function($scope) {
			var $qrcode = $scope.find( '.bdt-qrcode' ),
				image   = $scope.find('.bdt-qrcode-image');

			if ( ! $qrcode.length ) {
				return;
			}
			var settings=$qrcode.data('settings');
				settings.image=image[0];

		   $($qrcode).qrcode(settings);
		},

		//Progress Iframe object
		widgetIframe: function( $scope ) {

			var $iframe        = $scope.find( '.bdt-iframe' );

			if ( ! $iframe.length ) {
				return;
			}

			ElementPack.lazyLoader($iframe);
		},


		lazyLoader:function( $scope ) {
			var $lazyload = $scope.find('.bdt-lazyload');

			$($lazyload).recliner({
				throttle : $lazyload.data('throttle'),
				threshold : $lazyload.data('threshold'),
				live : $lazyload.data('live')
			});
		},

		//Iconnav object
		widgetIconNav: function( $scope ) {

			var $iconnav        = $scope.find( 'div.bdt-icon-nav' ),
				$iconnavTooltip = $iconnav.find( '.bdt-icon-nav' );

			if ( ! $iconnav.length ) {
				return;
			}

			ElementPack.tippyTooltip($iconnavTooltip, $scope);
		},

		widgetMarker: function( $scope ) {

			var $marker = $scope.find( '.bdt-marker-wrapper' );

			if ( ! $marker.length ) {
				return;
			}

			ElementPack.tippyTooltip($marker, $scope);
		},

		widgetScrollNav: function( $scope ) {

			var $scrollnav = $scope.find( '.bdt-dotnav > li' );

			if ( ! $scrollnav.length ) {
				return;
			}

			ElementPack.tippyTooltip($scrollnav, $scope);
		},

		widgetPriceTable: function( $scope ) {

			var $priceTable = $scope.find( '.bdt-price-table' ),
				$featuresList = $priceTable.find( '.bdt-price-table-feature-inner' );

			if ( ! $priceTable.length ) {
				return;
			}

			ElementPack.tippyTooltip($featuresList, $scope);
		},

		tippyTooltip:function( $selector, $appendIn ) {
			var $tooltip = $selector.find('> .bdt-tippy-tooltip');
			
			$tooltip.each( function( index ) {
				tippy( this, {
					appendTo: $appendIn[0]
				});				
			});

		},

		// Circle Menu object
		widgetCircleMenu: function( $scope ) {
			var $circleMenu = $scope.find('.bdt-circle-menu'),
				$settings = $circleMenu.data('settings');

			if ( ! $circleMenu.length ) {
				return;
			}

            $($circleMenu[0]).circleMenu({
				direction           : $settings['direction'],
				item_diameter       : $settings['item_diameter'],
				circle_radius       : $settings['circle_radius'],
				speed               : $settings['speed'],
				delay               : $settings['delay'],
				step_out            : $settings['step_out'],
				step_in             : $settings['step_in'],
				trigger             : $settings['trigger'],
				transition_function : $settings['transition_function']
            });
		},

		// Contact Form object
		widgetSimpleContactForm: function( $scope ) {
			var $contactForm = $scope.find('.bdt-contact-form form');
			
			if ( ! $contactForm.length ) {
				return;
			}


			$contactForm.submit(function(){
				ElementPack.sendContactForm($contactForm);
				return false;
			});

			
        	

        	return false;
            
		},

		elementPackGIC: function(token) {         		
			return new Promise(function(resolve, reject) {  
				if (grecaptcha === undefined) {
					bdtUIkit.notification({message: '<div bdt-spinner></div> Invisible captcha not defined!', timeout: false, status: 'warning'});
					reject();
				}

				var response = grecaptcha.getResponse();

				if (!response) {
					bdtUIkit.notification({message: '<div bdt-spinner></div> Could not get invisible captcha response!', timeout: false, status: 'warning'});
					reject();
				}

				var $contactForm=$('textarea.g-recaptcha-response').filter(function () {
					return $(this).val() === response;
					}).closest('form.bdt-contact-form-form');
				var contactFormAction = $contactForm.attr('action');
				if(contactFormAction && contactFormAction!=""){					
					ElementPack.sendContactForm($contactForm);
				} else {
					console.log($contactForm);
				}
				
				grecaptcha.reset();

			}); //end promise
		},

		sendContactForm: function($contactForm) {
			$.ajax({
				url:$contactForm.attr('action'),
				type:'POST',
				data:$contactForm.serialize(),
				beforeSend:function(){
					bdtUIkit.notification({message: '<div bdt-spinner></div> Sending message please wait...', timeout: false, status: 'primary'});
				},
				success:function(data){
					bdtUIkit.notification.closeAll();
					bdtUIkit.notification({message: data});
					$contactForm[0].reset();
				}
			});
			return false;
		},



		//Post Grid Tab object
		widgetPostGridTab: function( $scope ) {

			var $postGridTab = $scope.find( '.bdt-post-grid-tab' ),
			    gridTab      = $postGridTab.find('> .gridtab');

			if ( ! $postGridTab.length ) {
				return;
			}

			$(gridTab).gridtab($postGridTab.data('settings'));

			ElementPack.lazyLoader($postGridTab);

			console.log($postGridTab.data('settings'));

		},

		//Progress pie object
		widgetProgressPie: function( $scope ) {

			var $progressPie = $scope.find( '.bdt-progress-pie' );

			if ( ! $progressPie.length ) {
				return;
			}

			elementorFrontend.waypoint( $progressPie, function() {
				var $this = $( this );
				
					$this.asPieProgress({
					  namespace: "pieProgress",
					  classes: {
					      svg     : "bdt-progress-pie-svg",
					      number  : "bdt-progress-pie-number",
					      content : "bdt-progress-pie-content"
					  }
					});
					
					$this.asPieProgress("start");

			}, {
				offset: 'bottom-in-view'
			} );

		},

		//Image Magnifier widget
		widgetImageMagnifier: function( $scope ) {

			var $imageMagnifier     = $scope.find( '.bdt-image-magnifier > .bdt-image-magnifier-image' ),
				type                = $imageMagnifier.data('type'),
				smoothMove          = $imageMagnifier.data('smooth_move'),
				preload             = $imageMagnifier.data('preload'),
				zoomSize            = $imageMagnifier.data('zoom_size'),
				offset              = $imageMagnifier.data('offset'),
				position            = $imageMagnifier.data('position');

			if ( ! $imageMagnifier.length ) {
				return;
			}

			$($imageMagnifier).ImageZoom({
				type       : type,
				smoothMove : smoothMove,
				preload    : preload,
				zoomSize   : zoomSize,
				offset     : offset,
				position   : position	
			});

		},

		//Image Magnifier widget
		widgetImageMagnifierThumb: function( $scope ) {

			var $imageMagnifier     = $scope.find( '.bdt-image-magnifier > .bdt-image-magnifier-image' ),
				type                = $imageMagnifier.data('type'),
				smoothMove          = $imageMagnifier.data('smooth_move'),
				preload             = $imageMagnifier.data('preload'),
				zoomSize            = $imageMagnifier.data('zoom_size'),
				offset              = $imageMagnifier.data('offset'),
				position            = $imageMagnifier.data('position');

			if ( ! $imageMagnifier.length ) {
				return;
			}

			$($imageMagnifier).ImageZoom({
				type       : type,
				smoothMove : smoothMove,
				preload    : preload,
				zoomSize   : zoomSize,
				offset     : offset,
				position   : position	
			});

		},

		//Instagram widget
		widgetInstagram: function( $scope ) {

			var $instagram 		  = $scope.find( '.bdt-instagram' ),
				container         = $instagram.data('container'),
				username          = $instagram.data('username'),
				layout            = $instagram.data('layout'),
				show_profile      = $instagram.data('show_profile'),
				show_biography    = $instagram.data('show_biography'),
				show_lightbox     = $instagram.data('show_lightbox'),
				items             = $instagram.data('items'),
				columns           = $instagram.data('columns'),
				columns_tablet    = $instagram.data('columns_tablet'),
				columns_mobile    = $instagram.data('columns_mobile'),
				column_gap        = $instagram.data('column_gap'),
				comment_count     = $instagram.data('comment_count'),
				like_count        = $instagram.data('like_count'),
				loading_animation = $instagram.data('loading_animation');

			if ( ! $instagram.length ) {
				return;
			}

			$.instagramFeed({
			  'container'         : $instagram,
			  'username'          : username,
			  'layout'            : layout,
			  'show_profile'      : show_profile,
			  'show_biography'    : show_biography,
			  'show_lightbox'     : show_lightbox,
			  'items'             : items,
			  'columns'           : columns,
			  'columns_tablet'    : columns_tablet,
			  'columns_mobile'    : columns_mobile,
			  'column_gap'        : column_gap,
			  'comment_count'     : comment_count,
			  'like_count'        : like_count,
			  'loading_animation' : loading_animation,
			});
		},

		//Instagram widget
		widgetWeather: function( $scope ) {

			var $weather = $scope.find( '.bdt-weather' );				

			if ( ! $weather.length ) {
				return;
			}

			var bdt_weather = $weather.flatWeatherPlugin({
				location 			: $weather.data('location'),
				country 			: $weather.data('country'),
				api 				: $weather.data('api_type'),		
				view                : $weather.data('layout'),
				timeformat          : $weather.data('timeformat'),
				displayCityNameOnly : $weather.data('city_only') ? true : false,
				forecast            : $weather.data('forecast') + 1,
				units               : $weather.data('units'),
				lang                : $weather.data('lang'),
				apikey 				: ($weather.data('apikey')) ? $weather.data('apikey') : false,
				render              : ('tiny' == $weather.data('layout')) ? false : true,
			});

			if ('tiny' == $weather.data('layout')) {
				bdt_weather.flatWeatherPlugin('fetchWeather').then(function(data){

					var temparature_unit = $weather.data('units') == "metric"?"&#176;C":"&#176;F";

					$("<span />", {"class" : "wi wi" + data.today.code}).appendTo(bdt_weather);
					
					if ('yes' == $weather.data('show_city')) {
						$("<span />", {"class" : "bdt-weather-city"}).text(data.city).appendTo(bdt_weather);
					}

					if ('yes' == $weather.data('show_temperature')) {
						$("<span />", {"class" : "bdt-weather-temperature"}).html(data.today.temp.now + temparature_unit).appendTo(bdt_weather);
					}
					
					if ('yes' == $weather.data('show_weather_desc')) {
						$("<span />", {"class" : "bdt-weather-desc"}).html(data.today.desc).appendTo(bdt_weather);
					}

				});
			}
			
		},

		elementorSection: function( $scope ) {
			var $target   = $scope,
				instance  = null,
				editMode  = Boolean( elementor.isEditMode() );

			instance = new bdtWidgetTooltip( $target );
			instance.init();
		},
	};

	$( window ).on( 'elementor/frontend/init', ElementPack.init );
	//Contact form recaptcha callback, if needed
	window.elementPackGICCB = ElementPack.elementPackGIC;

	window.bdtWidgetTooltip = function ( $selector ) {

		var self = this,
			$tooltip = $selector.find('.elementor-widget.bdt-tippy-tooltip');


		self.init = function() {
			
			if ( ! $tooltip.length ) {
				return;
			}

			$tooltip.each( function( index ) {
				tippy( this, {
					appendTo: $tooltip[0]
				});				
			});

		};
		
	}

}( jQuery, window.elementorFrontend ) );
