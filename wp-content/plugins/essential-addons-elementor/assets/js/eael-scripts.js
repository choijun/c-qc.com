(function ($) {
	"use strict";

	/**
	 * Essential Addons For Elementor
	 * 
	 * @use Frontend script file.
	 * @link https://essential-addons.com/elementor/
	 * --------------------------------------------------------
	 *  ================== Table Of Contents ==================
	 * --------------------------------------------------------
	 * //
	 * 01. Common Scripts
	 * 02. Toggle Handler
	 * 03. Counter Handler
	 * 04. Flip Carousel
	 * 05. Filterable Gallery
	 * 06. Dynamic Filterable Gallery
	 * 07. Instagram Gallery
	 * 08. Advance Accordion
	 * 09. Advance Google Map
	 * 10. Advance Tab
	 * 12. Post Block
	 * 13. Content Timeline
	 * 14. Post List
	 * 15. Data Table
	 * 16. Team member carousel
	 * 17. Image Hotspot
	 * 18. Logo Carousel Handler
	 * 19. Post Carousel
	 * 20. Facebook Carousel
	 * 21. Facebook Feed
	 * 22. Twitter Feed
	 * 23. Twitter Feed Carousel
	 * 24. Testimonial Slider
	 * 25. Content Ticker
	 * 26. Image Comparison
	 * 27. MailChimp
	 * 28. LightBox
	 * 29. CountDown
	 * 30. Fancy Text
	 * 31. Image Accordion
	 * 32. Interactive Card
	 * 33. Pricing Tooltip
	 * 34. ProgressBar
	 * 35. Pricing Tooltip
	 */

	/*=================================*/
	/* 01. Common Scripts
	/*=================================*/
	var isEditMode = false;
	window.eaelHasMapAPI = window.google ? window.google : undefined;

	function maybe_note_undefined($selector, $data_atts) {
		return ($selector.data($data_atts) !== undefined) ? $selector.data($data_atts) : '';
	}


	/*=================================*/
	/* 02. Toggle Handler
	/*=================================*/
	var ToggleHandler = function ( $scope, $ ) {
		var toggle_elem             = $scope.find('.eael-toggle-container').eq(0);
		$(toggle_elem).each(function () {
			var $toggle_target      = $(this).data('toggle-target');
			var $toggle_switch      = $($toggle_target).find('.eael-toggle-switch');
			$($toggle_target).find('.eael-primary-toggle-label').addClass("active");
			$($toggle_switch).toggle(
				function() {
					var $parent_container = $(this).closest('.eael-toggle-container');
					$($parent_container).find('.eael-toggle-content-wrap').removeClass("primary");
					$($parent_container).children('.eael-toggle-content-wrap').addClass("secondary");
					$($parent_container).find('.eael-toggle-switch-container').addClass("eael-toggle-switch-on");
					$(this).parent().parent().find('.eael-primary-toggle-label').removeClass("active");
					$(this).parent().parent().find('.eael-secondary-toggle-label').addClass("active");
				},
				function() {
					var $parent_container = $(this).closest('.eael-toggle-container');
					$($parent_container).children('.eael-toggle-content-wrap').addClass("primary");
					$($parent_container).children('.eael-toggle-content-wrap').removeClass("secondary");
					$($parent_container).find('.eael-toggle-switch-container').removeClass("eael-toggle-switch-on");
					$(this).parent().parent().find('.eael-primary-toggle-label').addClass("active");
					$(this).parent().parent().find('.eael-secondary-toggle-label').removeClass("active");
				}
			);
		});
	};

	/*=================================*/
	/* 03. Counter Handler
	/*=================================*/
	var CounterHandler = function ($scope, $) {
		var counter_elem                = $scope.find('.eael-counter').eq(0),
			$target                     = counter_elem.data('target');
		
		$(counter_elem).waypoint(function () {
			$($target).each(function () {
				var v                   = $(this).data("to"),
					speed               = $(this).data("speed"),
					od                  = new Odometer({
						el:             this,
						value:          0,
						duration:       speed
					});
				od.render();
				setInterval(function () {
					od.update(v);
				});
			});
		},
		{
			offset:             "80%",
			triggerOnce:        true
		});
	};

	/*=================================*/
	/* 04. Flip Carousel
	/*=================================*/
	var FlipCarousel = function( $scope, $ ) {
		var flipCarousel_elem = $scope.find('.eael-flip-carousel').eq(0);
		$(flipCarousel_elem).each(function() {
			var style        = $(this).data('style'),
			    start        = $(this).data('start'),
			    fadeIn       = $(this).data('fadein'),
			    loop         = $(this).data('loop'),
			    autoplay     = $(this).data('autoplay'),
			    pauseOnHover = $(this).data('pauseonhover'),
			    spacing      = $(this).data('spacing'),
			    click        = $(this).data('click'),
			    scrollwheel  = $(this).data('scrollwheel'),
			    touch        = $(this).data('touch'),
			    buttons      = $(this).data('buttons'),
			    buttonPrev   = $(this).data('buttonprev'),
			    buttonNext   = $(this).data('buttonnext');

			$(this).flipster({
				style       : style,
				start       : start,
				fadeIn      : fadeIn,
				loop        : loop,
				autoplay    : autoplay,
				pauseOnHover: pauseOnHover,
				spacing     : spacing,
				click       : click,
				scrollwheel : scrollwheel,
				tocuh       : touch,
				buttons     : buttons,
				buttonPrev  : '<i class="flip-custom-nav ' + buttonPrev + '"></i>',
				buttonNext  : '<i class="flip-custom-nav ' + buttonNext + '"></i>',
			});
		});
	}

	/*=================================*/
	/* 05. Filterable Gallery
	/*=================================*/
	function getGalleryItem($gallery_items, $scope, $render, $init_show) {
		var $rom     = [];
		var $counter = $init_show + $render;
		for(var i = $init_show; i < $counter; i++) {
			var $item = $($gallery_items[i]);
				$item = $item[0];
			$rom.push($item);
		}
		return $rom;
	}

	var filterableGalleryHandler = function( $scope, $ ) {

		var $gallery       = $scope.find('.eael-filter-gallery-container').eq(0),
		    $settings      = $gallery.data('settings'),
		    $gallery_items = $gallery.data('gallery-items'),
		    $init_show     = $gallery.data('init-show') ? $gallery.data('init-show') : 9;

		if( !isEditMode ) {
			var $layout_mode = 'fitRows';

			if( "masonry" == $settings.grid_style ) {
				$layout_mode = 'masonry';
			}

			var $isotope_args = {
				itemSelector      : '.eael-filterable-gallery-item-wrap',
				layoutMode        : $layout_mode,
				percentPosition   : true,
				stagger           : 30,
				transitionDuration: $settings.duration + 'ms',
			}

			var $isotope_gallery = {};
			
			$scope.imagesLoaded(function(e) {
				$isotope_gallery = $gallery.isotope($isotope_args);
			});
			
			$scope.on('click', '.control', function() {
				var $this = $(this),
					filterValue = $this.attr('data-filter');

				$this.siblings().removeClass('active');
				$this.addClass('active');
				$isotope_gallery.isotope({ filter: filterValue });
			});


			var $gallery_enabled = ($settings.gallery_enabled) == 'yes' ? true : false;
			$scope.find('.eael-magnific-link').magnificPopup({
				type: 'image',
				gallery:{
					enabled: $gallery_enabled,
				},
				callbacks: {
					close: function() {
						$( '#elementor-lightbox' ).hide();
					}
				}
			});

			$scope.find('.eael-magnific-video-link').magnificPopup({
				type: 'iframe',
				callbacks: {
					close: function() {
						$( '#elementor-lightbox' ).hide();
					}
				}
			});
		}

		
		// Load more button
		$scope.find('.eael-gallery-load-more').on('click', function(e) {
			e.preventDefault();

			var $this = $(this),
				$init_show = $scope
						.find('.eael-filter-gallery-container')
							.find('.eael-filterable-gallery-item-wrap')
								.length,
				total_items = $gallery.data('total-gallery-items'),
				images_per_page = $gallery.data('images-per-page'),
				nomore_text		= $gallery.data('nomore-item-text'),
				$items = getGalleryItem($gallery_items, $scope, images_per_page, $init_show);

				if( $init_show == total_items ) {
					$this.html('<div class="no-more-items-text">'+nomore_text+'</div>');
					setTimeout(function(){
						$this.fadeOut('slow');
					}, 600);
				}

			$scope.imagesLoaded(function(e) {
				$gallery.isotope('insert', $items).isotope('layout');

				setTimeout(function() {
					$gallery.isotope('layout')
				}, 250)
			});
		});

	}

	/*=================================*/
	/* 06. Dynamic Filterable Gallery
	/*=================================*/
	var DynamicFilterableGallery = function($scope, $) {
		var $gallery	= $scope.find('.eael-filter-gallery-container').eq(0),
			$galleryWrap = $scope.find('.eael-filter-gallery-wrapper').eq(0),
			$settings	= $gallery.data('settings');

			// if( !isEditMode ) {
			if( true ) {
				var $layout_mode = 'fitRows';

				if( 'masonry' == $settings.layout_mode ) {
					$layout_mode = 'masonry';
				}

				var $isotope_args = {
					itemSelector:   '.dynamic-gallery-item',
					layoutMode		: $layout_mode,
					percentPosition : true,
					stagger: 30,
					transitionDuration: $settings.duration + 'ms',
				}

				var $isotope_gallery = {};
				
				$scope.imagesLoaded(function(e) {
					$isotope_gallery = $gallery.isotope($isotope_args);
				});
				
				$scope.on('click', '.control', function() {
					var $this       = $(this),
					    filterValue = $this.attr('data-filter');

					$this.siblings().removeClass('active');
					$this.addClass('active');
					$isotope_gallery.isotope({ filter: filterValue });
				});

			var $gallery_id        = $galleryWrap.data('gallery_id'),
			    $gallery_by_id     = $('#eael-filter-gallery-wrapper-'+$gallery_id),
			    $post_style        = $galleryWrap.data('post_style'),
			    $grid_style        = $galleryWrap.data('grid_style'),
			    $grid_hover_style  = $galleryWrap.data('grid_hover_style'),
			    $show_popup        = $galleryWrap.data('show_popup'),
			    $show_popup_styles = $galleryWrap.data('show_popup_styles'),
			    $zoom_icon         = $galleryWrap.data('zoom_icon'),
			    $link_icon         = $galleryWrap.data('link_icon'),
			    $post_excerpt      = $galleryWrap.data('post_excerpt'),
			    $btn_text          = $galleryWrap.data('btn_text'),
			    $total_posts       = $galleryWrap.data('total_posts'),
			    $post_type         = $galleryWrap.data('post_type'),
			    $posts_per_page    = $galleryWrap.data('posts_per_page'),
			    $post_order        = $galleryWrap.data('post_order'),
			    $post_orderby      = $galleryWrap.data('post_orderby'),
			    $post_offset       = $galleryWrap.data('post_offset'),
			    $tax_query         = $galleryWrap.data('tax_query'),
			    $exclude_posts     = $galleryWrap.data('exclude_posts'),
			    $post__in          = $galleryWrap.data('post__in');

				var options = {
					totalPosts     : $total_posts,
					postStyle      : $post_style,
					loadMoreBtn    : $( '#eael-load-more-btn-' + $gallery_id ),
					postContainer  : $( '.eael-filter-gallery-appender-' + $gallery_id ),
					gridStyle      : $grid_style,
					hoverStyle     : $grid_hover_style,
					popUp          : $show_popup,
					showPopupStyles: $show_popup_styles,
					zoomIcon       : $zoom_icon,
					linkIcon       : $link_icon
				}

				var gallerySettings = {
					postType     : $post_type,
					perPage      : $posts_per_page,
					postOrder    : $post_order,
					orderBy      : $post_orderby,
					offset       : $post_offset,
					tax_query    : $tax_query,
					exclude_posts: $exclude_posts,
					post__in     : $post__in,
					postExcerpt  : $post_excerpt,
					btnText      : $btn_text
				}

				eaelDynamicGalleryLoadMore( options, gallerySettings, $gallery);
			}

	}

	/*=================================*/
	/* 07. Instagram Gallery
	/*=================================*/
	var InstagramGallery = function( $scope, $ ) {

		var instagramGallery = $scope.find('.eael-instagram-feed').eq(0),
		    caption          = (instagramGallery.find('.eael-insta-grid').data('caption') === 'show-caption') ? '<p class="insta-caption">{{caption}}</p>' : '',
		    likes            = (instagramGallery.find('.eael-insta-grid').data('likes') === 'yes') ? '<p class="eael-insta-post-likes"> <i class="fa fa-heart-o" aria-hidden="true"></i> {{likes}}</p>' : '',
		    comments         = (instagramGallery.find('.eael-insta-grid').data('comments') === 'yes') ? '<p class="eael-insta-post-comments"><i class="fa fa-comment-o" aria-hidden="true"></i> {{comments}}</p>' : '',
		    link_target      = (instagramGallery.find('.eael-insta-grid').data('link-target') === 'yes') ? 'target="_blank"' : '',
		    link             = (instagramGallery.find('.eael-insta-grid').data('link') === 'yes') ? '<a href=\"{{link}}\" ' +link_target+ '></a>' : '';

		$(instagramGallery).each(function() {
			var get         = $(this).find('.eael-insta-grid').data('get'),
			    tagName     = $(this).find('.eael-insta-grid').data('tag-name'),
			    userId      = $(this).find('.eael-insta-grid').data('user-id'),
			    clientId    = $(this).find('.eael-insta-grid').data('client-id'),
			    accessToken = $(this).find('.eael-insta-grid').data('access-token'),
			    limit       = $(this).find('.eael-insta-grid').data('limit'),
			    resolution  = $(this).find('.eael-insta-grid').data('resolution'),
			    sortBy      = $(this).find('.eael-insta-grid').data('sort-by'),
			    target      = $(this).find('.eael-insta-grid').data('target');

			var loadButton = $(this).find('.eael-load-more-button');
			var feed       = new Instafeed({
				get        : ''+get+'',
				tagName    : ''+tagName+'',
				userId     : userId,
				clientId   : ''+clientId+'',
				accessToken: ''+accessToken+'',
				limit      : ''+limit+'',
				resolution : ''+resolution+'',
				sortBy     : ''+sortBy+'',
				target     : ''+target+'',
				template   : '<div class="eael-insta-feed eael-insta-box"><div class="eael-insta-feed-inner"><div class="eael-insta-feed-wrap"><div class="eael-insta-img-wrap"><img src="{{image}}" /></div><div class="eael-insta-info-wrap"><div class="eael-insta-info-wrap-inner"><div class="eael-insta-likes-comments">' + likes + comments + '</div>' + caption + '</div></div>' + link + '</div></div></div>',
				after: function() {
					var el = $(this);
					if (el.classList)
						el.classList.add('show');
					else
						el.className += ' ' + 'show';

					// disable button if no more results to load
					if (!this.hasNext()) {
						$(loadButton).parent().addClass( 'no-pagination' );
						loadButton.attr('disabled', 'disabled');
					}
				},
				success: function() {
					$(this).find('.eael-insta-grid').masonry();
					$(loadButton).removeClass( 'button--loading' );
					$(loadButton).find( 'span' ).html( 'Load More' );
				}
			});

			// bind the load more button
			loadButton.on('click', function() {
				feed.next();
				$(loadButton).addClass( 'button--loading' );
				$(loadButton).find( 'span' ).html( 'Loading...' );
			});

			feed.run();

			$(window).load(function() {
				$(this).find('.eael-insta-grid').masonry({
					itemSelector: '.eael-insta-feed',
					percentPosition: true,
					columnWidth: '.eael-insta-box'
				});
			});
		});
	}

	/*=================================*/
	/* 08. Advance Accordion
	/*=================================*/
	var AdvAccordionHandler = function($scope, $) {
    	var $advanceAccordion = $scope.find(".eael-adv-accordion"),
        	$accordionHeader  = $scope.find(".eael-accordion-header"),
        	$accordionType    = $advanceAccordion.data("accordion-type"),
        	$accordionSpeed   = $advanceAccordion.data("toogle-speed");
			
			// Open default actived tab
			$accordionHeader.each(function(){
				if($(this).hasClass('active-default')){
					$(this).addClass('show active');
					$(this).next().slideDown($accordionSpeed)
				}
			})

		// Remove multiple click event for nested accordion
    	$accordionHeader.unbind("click");

		$accordionHeader.click(function(e) {
				e.preventDefault();
				
				var $this = $(this);
				
				if($accordionType === 'accordion') {
					if ($this.hasClass("show")) {
						$this.removeClass("show active");
						$this.next().slideUp($accordionSpeed);
					} else {
						$this.parent().parent().find(".eael-accordion-header").removeClass("show active");
						$this.parent().parent().find(".eael-accordion-content").slideUp($accordionSpeed);
						$this.toggleClass("show active");
						$this.next().slideToggle($accordionSpeed);
					}
				} else {
					// For acccordion type 'toggle'
					if ($this.hasClass("show")) {
						$this.removeClass("show active");
						$this.next().slideUp($accordionSpeed);
					} else {
						$this.addClass("show active");
						$this.next().slideDown($accordionSpeed);
					}
				}
		});
	}; // End of advance accordion
	

	/*=================================*/
	/* 09. Advance Google Map
	/*=================================*/
	var AdvGoogleMap = function($scope, $) {

		if(!window.eaelHasMapAPI ) {
			var $map_class  = $scope.find('.eael-google-map').eq(0),
			    $map_notice = $scope.find('.google-map-notice').eq(0);

			$map_class.css('display', 'none');

			$map_notice.html('Whoops! It\' seems like you didn\'t set Google Map API key. You can set from <b>Elementor > Essential Addons > Elements > Advanced Google Map (Settings)</b>');
			$map_notice.addClass('alert alert-warning');
			$map_notice.css({
				"background-color": "#f2dede",
				"color"           : "#a94442",
				"font-size"       : "85%",
				"padding"         : "15px",
				"border-radius"   : "3px"
			});
			
		}else {

			var $map                      = $scope.find('.eael-google-map'),
			    $thisMap                  = $('#' + $map.attr('id')),
			    $mapID                    = $thisMap.data('id'),
			    $mapType                  = $thisMap.data('map_type'),
			    $mapAddressType           = $thisMap.data('map_address_type'),
			    $mapLat                   = $thisMap.data('map_lat'),
			    $mapLng                   = $thisMap.data('map_lng'),
			    $mapAddr                  = $thisMap.data('map_addr'),
			    $mapBasicMarkerTitle      = $thisMap.data('map_basic_marker_title'),
			    $mapBasicMarkerContent    = $thisMap.data('map_basic_marker_content'),
			    $mapBasicMarkerIconEnable = $thisMap.data('map_basic_marker_icon_enable'),
			    $mapBasicMarkerIcon       = $thisMap.data('map_basic_marker_icon'),
			    $mapBasicMarkerIconWidth  = $thisMap.data('map_basic_marker_icon_width'),
			    $mapBasicMarkerIconHeight = $thisMap.data('map_basic_marker_icon_height'),
			    $mapZoom                  = $thisMap.data('map_zoom'),
			    $mapMarkerContent         = $thisMap.data('map_marker_content'),
			    $mapMarkers               = $thisMap.data('map_markers'),
			    $mapStaticWidth           = $thisMap.data('map_static_width'),
			    $mapStaticHeight          = $thisMap.data('map_static_height'),
			    $mapStaticLat             = $thisMap.data('map_static_lat'),
			    $mapStaticLng             = $thisMap.data('map_static_lng'),
			    $mapPolylines             = $thisMap.data('map_polylines'),
			    $mapStrokeColor           = $thisMap.data('map_stroke_color'),
			    $mapStrokeOpacity         = $thisMap.data('map_stroke_opacity'),
			    $mapStrokeWeight          = $thisMap.data('map_stroke_weight'),
			    $mapStrokeFillColor       = $thisMap.data('map_stroke_fill_color'),
			    $mapStrokeFillOpacity     = $thisMap.data('map_stroke_fill_opacity'),
			    $mapOverlayContent        = $thisMap.data('map_overlay_content'),
			    $mapRoutesOriginLat       = $thisMap.data('map_routes_origin_lat'),
			    $mapRoutesOriginLng       = $thisMap.data('map_routes_origin_lng'),
			    $mapRoutesDestLat         = $thisMap.data('map_routes_dest_lat'),
			    $mapRoutesDestLng         = $thisMap.data('map_routes_dest_lng'),
			    $mapRoutesTravelMode      = $thisMap.data('map_routes_travel_mode'),
			    $mapPanoramaLat           = $thisMap.data('map_panorama_lat'),
			    $mapPanoramaLng           = $thisMap.data('map_panorama_lng'),
			    $mapTheme                 = JSON.parse(decodeURIComponent(($thisMap.data('map_theme') + '').replace(/\+/g, '%20'))),
			    $map_streeview_control    = $thisMap.data('map_streeview_control'),
			    $map_type_control         = $thisMap.data('map_type_control'),
			    $map_zoom_control         = $thisMap.data('map_zoom_control'),
			    $map_fullscreen_control   = $thisMap.data('map_fullscreen_control'),
			    $map_scroll_zoom          = $thisMap.data('map_scroll_zoom');

			var eaelMapHeader = new GMaps({
				el               : "#eael-google-map-" + $mapID,
				lat              : $mapLat,
				lng              : $mapLng,
				zoom             : $mapZoom,
				streetViewControl: $map_streeview_control,
				mapTypeControl   : $map_type_control,
				zoomControl      : $map_zoom_control,
				fullscreenControl: $map_fullscreen_control,
				scrollwheel      : $map_scroll_zoom
			});

			if($mapTheme != '') {
				eaelMapHeader.addStyle({
					styledMapName: "Styled Map",
					styles       : JSON.parse($mapTheme),
					mapTypeId    : "map_style"
				});
				
				eaelMapHeader.setStyle("map_style");
			}

			if( 'basic' == $mapType ) {

				var infoWindowHolder = $mapBasicMarkerContent != '' ? { content: $mapBasicMarkerContent} : '';
					
				if($mapBasicMarkerIconEnable == 'yes') {
					var iconHolder = {
						url       : $mapBasicMarkerIcon,
						scaledSize: new google.maps.Size($mapBasicMarkerIconWidth, $mapBasicMarkerIconHeight),
					}
				} else { var iconHolder = null; }

				if($mapAddressType == 'address') {
					GMaps.geocode({
						address: $mapAddr,
						callback: function(results, status) {
							if (status == 'OK') {
								var latlng = results[0].geometry.location;
								eaelMapHeader.setCenter(latlng.lat(), latlng.lng());
								eaelMapHeader.addMarker({
									lat       : latlng.lat(),
									lng       : latlng.lng(),
									title     : $mapBasicMarkerTitle,
									infoWindow: infoWindowHolder,
									icon      : iconHolder
								});
							}
						}
					});
				}else if($mapAddressType == 'coordinates') {
					eaelMapHeader.addMarker({
						lat       : $mapLat,
						lng       : $mapLng,
						title     : $mapBasicMarkerTitle,
						infoWindow: infoWindowHolder,
						icon      : iconHolder
					});
				}
			
			} // end of basic map script


			if('marker' == $mapType) {

				var $data = JSON.parse(decodeURIComponent(($mapMarkers + '').replace(/\+/g, '%20')));

				if($data.length > 0) {
					$data.forEach(function($marker) {
						
						if($marker.eael_google_map_marker_content != '') {
							var infoWindowHolder = {
								content: $marker.eael_google_map_marker_content
							};
						}else {
							var infoWindowHolder = '';
						}

						if($marker.eael_google_map_marker_icon_enable == 'yes') {
							var iconHolder =  {
								url       : $marker.eael_google_map_marker_icon.url,
								scaledSize: new google.maps.Size($marker.eael_google_map_marker_icon_width, $marker.eael_google_map_marker_icon_height),   // scaled size
							};
						}else {
							var iconHolder = '';
						}


						eaelMapHeader.addMarker({
							lat       : parseFloat($marker.eael_google_map_marker_lat),
							lng       : parseFloat($marker.eael_google_map_marker_lng),
							title     : $marker.eael_google_map_marker_title,
							infoWindow: infoWindowHolder,
							icon      : iconHolder
						});

					});
				}
			}// end of multiple markers map


			if('static' == $mapType) {

				var $data         = JSON.parse(decodeURIComponent(($mapMarkers + '').replace(/\+/g, '%20'))),
				    markersHolder = [];

				if($data.length > 0) {
					$data.forEach(function($marker) {
						markersHolder.push(
							{
								lat  : parseFloat($marker.eael_google_map_marker_lat),
								lng  : parseFloat($marker.eael_google_map_marker_lng),
								color: $marker.eael_google_map_marker_icon_color
							},
						);
					});
				}

				var eaelStaticMapUrl = GMaps.staticMapURL({
					size   : [$mapStaticWidth, $mapStaticHeight],
					lat    : $mapStaticLat,
					lng    : $mapStaticLng,
					markers: markersHolder
				});

				$('<img />').attr('src', eaelStaticMapUrl).appendTo('#eael-google-map-' + $mapID);

			} // End of static map


			if('polyline' == $mapType) {

				var $polylines_data = JSON.parse(decodeURIComponent(($mapPolylines + '').replace(/\+/g, '%20'))),
				    $data           = JSON.parse(decodeURIComponent(($mapMarkers + '').replace(/\+/g, '%20'))),
				    $eael_polylines = [];


				var eaelPolylineMap = new GMaps({
					el    : '#eael-google-map-' + $mapID,
					lat   : $mapLat,
					lng   : $mapLng,
					zoom  : $mapZoom,
					center: {
						lat: -12.07635776902266,
						lng: -77.02792530422971,
					}
				});

				$polylines_data.forEach(function($polyline) {
					$eael_polylines.push(
						[
							parseFloat($polyline.eael_google_map_polyline_lat),
							parseFloat($polyline.eael_google_map_polyline_lng)
						]
					)
				});
				
				var path = JSON.parse(JSON.stringify($eael_polylines));

				eaelPolylineMap.drawPolyline({
					path         : path,
					strokeColor  : $mapStrokeColor.toString(),
					strokeOpacity: $mapStrokeOpacity,
					strokeWeight : $mapStrokeWeight
				});

				$data.forEach(function($marker) {
					if($marker.eael_google_map_marker_content != '') {
						var infoWindowHolder = {
							content: $marker.eael_google_map_marker_content
						};
					}else {
						var infoWindowHolder = '';
					}

					if($marker.eael_google_map_marker_icon_enable == 'yes') {
						var iconHolder =  {
							url       : $marker.eael_google_map_marker_icon.url,
							scaledSize: new google.maps.Size($marker.eael_google_map_marker_icon_width, $marker.eael_google_map_marker_icon_height),  // scaled size
						};
					}else {
						var iconHolder = '';
					}

					eaelPolylineMap.addMarker({
						lat       : $marker.eael_google_map_marker_lat,
						lng       : $marker.eael_google_map_marker_lng,
						title     : $marker.eael_google_map_marker_title,
						infoWindow: infoWindowHolder,
						icon      : iconHolder
					});
				});

				if($mapTheme != '') {
					eaelPolylineMap.addStyle({
						styledMapName: "Styled Map",
						styles       : JSON.parse($mapTheme),
						mapTypeId    : "polyline_map_style"
					});

					eaelPolylineMap.setStyle("polyline_map_style");
				}
				
			} // End of polyline map


			if('polygon' == $mapType) {

				var $polylines_data = JSON.parse(decodeURIComponent(($mapPolylines + '').replace(/\+/g, '%20'))),
					$eael_polylines = [];

				$polylines_data.forEach(function($polyline) {
					$eael_polylines.push(
						[
							parseFloat($polyline.eael_google_map_polyline_lat),
							parseFloat($polyline.eael_google_map_polyline_lng)
						]
					)
				});

				var path = JSON.parse(JSON.stringify($eael_polylines));
				eaelMapHeader.drawPolygon({
					paths        : path,
					strokeColor  : $mapStrokeColor.toString(),
					strokeOpacity: $mapStrokeOpacity,
					strokeWeight : $mapStrokeWeight,
					fillColor    : $mapStrokeFillColor.toString(),
					fillOpacity  : $mapStrokeFillOpacity
				});
			} // End of polygon map


			if('overlay' == $mapType) {

				if( $mapOverlayContent != '') {
					var contentHolder = '<div class="eael-gmap-overlay">'+$mapOverlayContent+'</div>';
				}else {
					var contentHolder = '';
				}

				eaelMapHeader.drawOverlay({
					lat    : $mapLat,
					lng    : $mapLng,
					content: contentHolder
				});
			} // End of overlay map


			if('routes' == $mapType) {
				eaelMapHeader.drawRoute({
					origin       : [$mapRoutesOriginLat, $mapRoutesOriginLng],
					destination  : [$mapRoutesDestLat, $mapRoutesDestLng],
					travelMode   : $mapRoutesTravelMode.toString(),
					strokeColor  : $mapStrokeColor.toString(),
					strokeOpacity: $mapStrokeOpacity,
					strokeWeight : $mapStrokeWeight,
				});

				var $data = JSON.parse(decodeURIComponent(($mapMarkers + '').replace(/\+/g, '%20')));

				if($data.length > 0) {
					$data.forEach(function($marker) {
					
						if($marker.eael_google_map_marker_content != '') {
							var infoWindowHolder = {
								content: $marker.eael_google_map_marker_content
							};
						}else {
							var infoWindowHolder = '';
						}

						if($marker.eael_google_map_marker_icon_enable == 'yes') {
							var iconHolder =  {
								url       : $marker.eael_google_map_marker_icon.url,
								scaledSize: new google.maps.Size($marker.eael_google_map_marker_icon_width, $marker.eael_google_map_marker_icon_height),   // scaled size
							};
						}else {
							var iconHolder = '';
						}

						eaelMapHeader.addMarker({
							lat       : $marker.eael_google_map_marker_lat,
							lng       : $marker.eael_google_map_marker_lng,
							title     : $marker.eael_google_map_marker_title,
							infoWindow: infoWindowHolder,
							icon      : iconHolder,
						});
					});
				}
			} // End of map routers


			if('panorama' == $mapType) {
				var eaelPanorama = GMaps.createPanorama({
					el : '#eael-google-map-'+$mapID,
					lat: $mapPanoramaLat,
					lng: $mapPanoramaLng,
				});
			} // end of map panorama
		}

	} // Advance google map


	/*=================================*/
	/* 10. Advance Tab
	/*=================================*/
	var AdvanceTabHandler = function ($scope, $) {

		jQuery(document).ready(function($) {
			var $currentTab   = $scope.find('.eael-advance-tabs'),
			    $currentTabId = '#' + $currentTab.attr('id').toString();

				$($currentTabId + ' .eael-tabs-nav ul li').each( function(index) {
					if( $(this).hasClass('active-default') ) {
						$($currentTabId + ' .eael-tabs-nav > ul li').removeClass('active').addClass('inactive');
						$(this).removeClass('inactive');
					}else {
						if( index == 0 ) {
							$(this).removeClass('inactive').addClass('active');
				
						}
					}
				} );

				$($currentTabId + ' .eael-tabs-content div').each( function(index) {
					if( $(this).hasClass('active-default') ) {
						$($currentTabId + ' .eael-tabs-content > div').removeClass('active');
					}else {
						if( index == 0 ) {
							$(this).removeClass('inactive').addClass('active');
						}
					}
				} );

				$($currentTabId + ' .eael-tabs-nav ul li').click(function(){
					var currentTabIndex = $(this).index(),
						tabsContainer   = $(this).closest('.eael-advance-tabs'),
						tabsNav         = $(tabsContainer).children('.eael-tabs-nav').children('ul').children('li'),
						tabsContent     = $(tabsContainer).children('.eael-tabs-content').children('div');
				
					$(this).parent('li').addClass('active');
				
					$(tabsNav).removeClass('active active-default').addClass('inactive');
					$(this).addClass('active').removeClass('inactive');
				
					$(tabsContent).removeClass('active').addClass('inactive');
					$(tabsContent).eq(currentTabIndex).addClass('active').removeClass('inactive');
				
					$(tabsContent).each( function(index) {
						$(this).removeClass('active-default');
				});
			});

		});
	}


	/*=================================*/
	/* 11. Post Timeline
	/*=================================*/
	var postTimelineHandler = function ($scope, $) {
		var $_this             = $scope.find('.eael-post-timeline'),
		    $currentTimelineId = '#' + $_this.attr('id'),
		    $total_posts       = parseInt( $_this.data('total_posts'), 10 ),
		    $timeline_id       = $_this.data('timeline_id'),
		    $post_type         = $_this.data('post_type'),
		    $posts_per_page    = parseInt( $_this.data('posts_per_page'), 10 ),
		    $post_order        = $_this.data('post_order'),
		    $post_orderby      = $_this.data('post_orderby'),
		    $post_offset       = parseInt( $_this.data('post_offset'), 10 ),
		    $show_images       = $_this.data('show_images'),
		    $image_size        = $_this.data('image_size'),
		    $show_title        = $_this.data('show_title'),
		    $show_excerpt      = $_this.data('show_excerpt'),
		    $excerpt_length    = parseInt( $_this.data('excerpt_length'), 10 ),
		    $btn_text          = $_this.data('btn_text'),
		    $tax_query         = $_this.data('tax_query'),
		    $exclude_posts     = $_this.data('exclude_posts'),
		    $post__in          = $_this.data('post__in');

		var options = {
			totalPosts   : $total_posts,
			loadMoreBtn  : $( '#eael-load-more-btn-' + $timeline_id ),
			postContainer: $( '.eael-post-appender-' + $timeline_id ),
			postStyle    : 'timeline',
		}
	
		var settings = {
			postType     : $post_type,
			perPage      : $posts_per_page,
			postOrder    : $post_order,
			orderBy      : $post_orderby,
			offset       : $post_offset,
			showImage    : $show_images,
			imageSize    : $image_size,
			showTitle    : $show_title,
			showExcerpt  : $show_excerpt,
			excerptLength: parseInt( $excerpt_length, 10 ),
			btnText      : $btn_text,
			tax_query    : $tax_query,
			exclude_posts: $exclude_posts,
			post__in     : $post__in,
		}

		eaelLoadMore( options, settings );
	}


	/*=================================*/
	/* 12. Post Block
	/*=================================*/
	var PostBlockHandler = function($scope, $) {
		
		var $_this    = $scope.find('.eael-post-block').eq(0),
		    $options  = $_this.data('post_grid_options'),
		    $settings = $_this.data('post_grid_settings');
		
		var options = {
			totalPosts   : parseInt($options.totalPosts),
			loadMoreBtn  : $( $options.loadMoreBtn ),
			postContainer: $( $options.postContainer ),
			postStyle    : 'block'
		}

		var exclude_posts = JSON.parse($settings.exclude_posts),
			tax_query     = JSON.parse($settings.tax_query),
			post__in      = JSON.parse($settings.post__in);

		var settings = {
			postType       : $settings.postType,
			perPage        : parseInt($settings.perPage),
			postOrder      : $settings.postOrder,
			orderBy        : $settings.orderBy,
			showImage      : parseInt($settings.showImage),
			imageSize      : $settings.imageSize,
			showTitle      : parseInt($settings.showTitle),
			showExcerpt    : parseInt($settings.showExcerpt),
			showMeta       : parseInt($settings.showMeta),
			offset         : $settings.offset,
			metaPosition   : $settings.metaPosition,
			excerptLength  : $settings.excerptLength,
			btnText        : $settings.btnText,
			tax_query      : tax_query,
			exclude_posts  : exclude_posts,
			post__in       : post__in,
			grid_style     : $settings.grid_style,
			hover_animation: $settings.hover_animation
		}

		eaelLoadMore( options, settings );
	}

	/*=================================*/
	/* 13. Content Timeline
	/*=================================*/
	var contentTimelineHandler = function($scope, $) {
		var contentBlock = $( '.eael-content-timeline-block' );

		$( window ).on( 'scroll', function() {

			contentBlock.each(function() {
				if( $(this).find( '.highlight' ) ) {

					// Calculate screen middle position, top offset and line height and
					// change line height dynamically 

					let lineEnd    = contentBlock.height() * 0.15 + window.innerHeight / 2;
					let topOffset  = $(this).offset().top;
					let lineHeight = window.scrollY + lineEnd * 1.3 - topOffset;

					$(this).find( '.eael-content-timeline-inner' ).css( 'height', lineHeight +'px' );
				}
			});

			if( this.oldScroll > this.scrollY == false ) {
				this.oldScroll = this.scrollY;
				// Scroll Down
				$( '.eael-content-timeline-block.highlight' ).prev().find('.eael-content-timeline-inner').removeClass( 'eael-muted' ).addClass( 'eael-highlighted' );

			}else if( this.oldScroll > this.scrollY == true ) {
				this.oldScroll = this.scrollY;
				// Scroll Up
				$( '.eael-content-timeline-block.highlight' ).find('.eael-content-timeline-inner').addClass( 'eael-prev-highlighted' );
				$( '.eael-content-timeline-block.highlight' ).next().find('.eael-content-timeline-inner').removeClass( 'eael-highlighted' ).removeClass( 'eael-prev-highlighted' ).addClass( 'eael-muted' );

			}
		});
	} // end of content timeline

	/*=================================*/
	/* 14. Post List
	/*=================================*/
	var postListHandler = function($scope, $) {
		var $_this = $scope.find('.eael-post-list-container');

		var eael_post_list_settings = {
			appender                              : $( $_this.data('appender') ),
			post_type                             : $_this.data('post_type'),
			posts_per_page                        : ( $_this.data('posts_per_page') !== '' ) ? parseInt( $_this.data('posts_per_page'), 10 ): 11,
			post__in                              : $_this.data('post__in'),
			orderby                               : $_this.data('orderby'),
			order                                 : $_this.data('order'),
			total_posts                           : $_this.data('total_posts'),
			offset                                : ( $_this.data('offset') !== '' ) ? parseInt( $_this.data('offset'), 10 )                : 0,
			eael_post_list_post_feature_image     : $_this.data('show_image'),
			eael_post_list_post_meta              : $_this.data('show_meta'),
			eael_post_list_post_title             : $_this.data('show_title'),
			eael_post_list_post_excerpt           : $_this.data('show_excerpt'),
			eael_post_list_post_excerpt_length    : $_this.data('excerpt_length'),
			eael_post_list_featured_area          : $_this.data('show_featured_area'),
			featured_posts                        : $_this.data('featured_posts'),
			eael_post_list_featured_meta          : $_this.data('show_featured_meta'),
			eael_post_list_featured_title         : $_this.data('show_featured_title'),
			eael_post_list_featured_excerpt       : $_this.data('show_featured_excerpt'),
			eael_post_list_featured_excerpt_length: $_this.data('featured_excerpt_length'),
			tax_query                             : $_this.data('tax_query'),
			excluded                              : $_this.data('excluded'),
			eael_post_list_pagination             : $_this.data('show_nav'),
			eael_post_list_pagination_next_icon   : $_this.data('next_icon'),
			eael_post_list_pagination_prev_icon   : $_this.data('prev_icon'),
			next_btn                              : $( $_this.data('next_btn') ),
			prev_btn                              : $( $_this.data('prev_btn') ),
		};
		eaelLoadMorePostList( eael_post_list_settings );
	} // end of Post List


	/*=================================*/
	/* 15. Data Table
	/*=================================*/
	var dataTable = function($scope, $) {
		var $_this        = $scope.find('.eael-data-table-wrap'),
		    $enable_table = $_this.data('table_enabled'),
		    $id           = $_this.data('table_id');
		
		if( true == $enable_table ) $("#eael-data-table-"+$id).tablesorter();
		if( $enable_table != true ) {
			$('table#eael-data-table-'+$id+' .sorting').addClass('sorting-none');
			$('table#eael-data-table-'+$id+' .sorting_desc').addClass('sorting-none');
			$('table#eael-data-table-'+$id+' .sorting_asc').addClass('sorting-none');
		}

		var responsive = $_this.data('custom_responsive');
		if( true == responsive ) {
			var $th    = $scope.find('.eael-data-table').find('th'),
			    $tbody = $scope.find('.eael-data-table').find('tbody');

			$tbody.find('tr').each(function(i, item) {
				$(item).find('td .td-content-wrapper').each(function(index, item){
				$(this)
					.prepend('<div class="th-mobile-screen">' + $th.eq(index).html() + '</div>');
				});
			});
		}
	} // end of Data Table


	/*=================================*/
	/* 16. Team member carousel
	/*=================================*/
	var TeamMemberCarouselHandler = function ($scope, $) {
	   var $carousel       = $scope.find('.eael-tm-carousel').eq(0),
	       $pagination     = ($carousel.data("pagination") !== undefined) ? $carousel.data("pagination") : '.swiper-pagination',
	       $arrow_next     = ($carousel.data("arrow-next") !== undefined) ? $carousel.data("arrow-next") : '.swiper-button-next',
	       $arrow_prev     = ($carousel.data("arrow-prev") !== undefined) ? $carousel.data("arrow-prev") : '.swiper-button-prev',
	       $items          = ($carousel.data("items") !== undefined) ? $carousel.data("items") : 3,
	       $items_tablet   = ($carousel.data("items-tablet") !== undefined) ? $carousel.data("items-tablet") : 3,
	       $items_mobile   = ($carousel.data("items-mobile") !== undefined) ? $carousel.data("items-mobile") : 3,
	       $margin         = ($carousel.data("margin") !== undefined) ? $carousel.data("margin") : 10,
	       $margin_tablet  = ($carousel.data("margin-tablet") !== undefined) ? $carousel.data("margin-tablet") : 10,
	       $margin_mobile  = ($carousel.data("margin-mobile") !== undefined) ? $carousel.data("margin-mobile") : 10,
	       $speed          = ($carousel.data("speed") !== undefined) ? $carousel.data("speed") : 400,
	       $autoplay       = ($carousel.data("autoplay") !== undefined) ? $carousel.data("autoplay") : 999999,
	       $loop           = ($carousel.data("loop") !== undefined) ? $carousel.data("loop") : 0,
	       $grab_cursor    = ($carousel.data("grab-cursor") !== undefined) ? $carousel.data("grab-cursor") : 0,
	       $data_id        = maybe_note_undefined($carousel, 'id'),
		   $pause_on_hover = maybe_note_undefined($carousel, 'pause-on-hover'),
		   $slider_options = {
				direction    : 'horizontal',
				speed        : $speed,
				slidesPerView: $items,
				spaceBetween : $margin,
				grabCursor   : $grab_cursor,
				loop         : $loop,
				autoplay: {
					delay: $autoplay,
				},
				pagination: {
					el       : $pagination,
					clickable: true,
				},
				navigation: {
					nextEl: $arrow_next,
					prevEl: $arrow_prev,
				},
				breakpoints: {
					// when window width is <= 480px
					480: {
						slidesPerView: $items_mobile,
						spaceBetween : $margin_mobile
					},
					// when window width is <= 640px
					768: {
						slidesPerView: $items_tablet,
						spaceBetween : $margin_tablet
					}
				}
			};

			var TeamSlider = new Swiper($carousel, $slider_options);
				if( 0 == $autoplay ) { TeamSlider.autoplay.stop(); }

			if($pause_on_hover && $autoplay !== 0) {
				$carousel.on('mouseenter', function() {
					TeamSlider.autoplay.stop();
				});
				$carousel.on('mouseleave', function() {
					TeamSlider.autoplay.start();
				});
			}
	};

	/*=================================*/
	/* 17. Image Hotspot
	/*=================================*/
	var ImageHotspotHandler = function ($scope, $) {
		$('.eael-hot-spot-tooptip').each(function () {
			var $position_local  = $(this).data('tooltip-position-local'),
			    $position_global = $(this).data('tooltip-position-global'),
			    $width           = $(this).data('tooltip-width'),
			    $size            = $(this).data('tooltip-size'),
			    $animation_in    = $(this).data('tooltip-animation-in'),
			    $animation_out   = $(this).data('tooltip-animation-out'),
			    $background      = $(this).data('tooltip-background'),
			    $text_color      = $(this).data('tooltip-text-color'),
			    $arrow           = ($(this).data('eael-tooltip-arrow') === 'yes') ? true : false,
			    $position        = $position_local;

			if (typeof $position_local === 'undefined' || $position_local === 'global') {
				$position = $position_global;
			}
			if (typeof $animation_out === 'undefined' || !$animation_out) {
				$animation_out = $animation_in;
			}
			
			$(this).tipso({
				speed       : 200,
				delay       : 200,
				width       : $width,
				background  : $background,
				color       : $text_color,
				size        : $size,
				position    : $position,
				animationIn : $animation_in,
				animationOut: $animation_out,
				showArrow   : $arrow
			});
		});
	};

	/*=================================*/
	/* 18. Logo Carousel Handler
	/*=================================*/
	var LogoCarouselHandler = function ($scope, $) {
		var $carousel         = $scope.find('.eael-logo-carousel').eq(0),
		    $items            = ($carousel.data("items") !== undefined) ? $carousel.data("items") : 3,
		    $items_tablet     = ($carousel.data("items-tablet") !== undefined) ? $carousel.data("items-tablet") : 3,
		    $items_mobile     = ($carousel.data("items-mobile") !== undefined) ? $carousel.data("items-mobile") : 3,
		    $margin           = ($carousel.data("margin") !== undefined) ? $carousel.data("margin") : 10,
		    $margin_tablet    = ($carousel.data("margin-tablet") !== undefined) ? $carousel.data("margin-tablet") : 10,
		    $margin_mobile    = ($carousel.data("margin-mobile") !== undefined) ? $carousel.data("margin-mobile") : 10,
		    $effect           = ($carousel.data("effect") !== undefined) ? $carousel.data("effect") : 'slide',
		    $speed            = ($carousel.data("speed") !== undefined) ? $carousel.data("speed") : 400,
		    $autoplay         = ($carousel.data("autoplay") !== undefined) ? $carousel.data("autoplay") : 999999,
		    $loop             = ($carousel.data("loop") !== undefined) ? $carousel.data("loop") : 0,
		    $grab_cursor      = ($carousel.data("grab-cursor") !== undefined) ? $carousel.data("grab-cursor") : 0,
		    $pagination       = ($carousel.data("pagination") !== undefined) ? $carousel.data("pagination") : '.swiper-pagination',
		    $arrow_next       = ($carousel.data("arrow-next") !== undefined) ? $carousel.data("arrow-next") : '.swiper-button-next',
		    $arrow_prev       = ($carousel.data("arrow-prev") !== undefined) ? $carousel.data("arrow-prev") : '.swiper-button-prev',
		    $pause_on_hover   = ($carousel.data('pause-on-hover') !== undefined ? $carousel.data('pause-on-hover') : ''),
		    $carousel_options = {
                direction          : 'horizontal',
                speed              : $speed,
                effect             : $effect,
                slidesPerView      : $items,
                spaceBetween       : $margin,
                grabCursor         : $grab_cursor,
                paginationClickable: true,
                autoHeight         : true,
                loop               : $loop,
                autoplay           : {
                    delay: $autoplay,
                },
                pagination: {
                    el       : $pagination,
                    clickable: true,
                },
                navigation: {
                    nextEl: $arrow_next,
                    prevEl: $arrow_prev,
                },
                breakpoints: {
                    // when window width is <= 480px
                    480: {
                        slidesPerView: $items_mobile,
                        spaceBetween : $margin_mobile
                    },
                    // when window width is <= 640px
                    768: {
                        slidesPerView: $items_tablet,
                        spaceBetween : $margin_tablet
                    }
                }
			};
			
			var LogoCarousel = new Swiper($carousel, $carousel_options);
				if($pause_on_hover) {
					$carousel.on('mouseenter', function() {
						LogoCarousel.autoplay.stop();
					});
					$carousel.on('mouseleave', function() {
						LogoCarousel.autoplay.start();
					});
				}
	};

	/*=================================*/
	/* 19. Post Carousel
	/*=================================*/
	var PostCarouselHandler = function ($scope, $) {
		var $postCarousel   = $scope.find('.eael-post-carousel').eq(0),
		    $autoplay       = ($postCarousel.data("autoplay") !== undefined) ? $postCarousel.data("autoplay") : 999999,
		    $pagination     = ($postCarousel.data("pagination") !== undefined) ? $postCarousel.data("pagination") : '.swiper-pagination',
		    $arrow_next     = ($postCarousel.data("arrow-next") !== undefined) ? $postCarousel.data("arrow-next") : '.swiper-button-next',
		    $arrow_prev     = ($postCarousel.data("arrow-prev") !== undefined) ? $postCarousel.data("arrow-prev") : '.swiper-button-prev',
		    $items          = ($postCarousel.data("items") !== undefined) ? $postCarousel.data("items") : 3,
		    $items_tablet   = ($postCarousel.data("items-tablet") !== undefined) ? $postCarousel.data("items-tablet") : 3,
		    $items_mobile   = ($postCarousel.data("items-mobile") !== undefined) ? $postCarousel.data("items-mobile") : 3,
		    $margin         = ($postCarousel.data("margin") !== undefined) ? $postCarousel.data("margin") : 10,
		    $margin_tablet  = ($postCarousel.data("margin-tablet") !== undefined) ? $postCarousel.data("margin-tablet") : 10,
		    $margin_mobile  = ($postCarousel.data("margin-mobile") !== undefined) ? $postCarousel.data("margin-mobile") : 10,
		    $effect         = ($postCarousel.data("effect") !== undefined) ? $postCarousel.data("effect") : 'slide',
		    $speed          = ($postCarousel.data("speed") !== undefined) ? $postCarousel.data("speed") : 400,
		    $loop           = ($postCarousel.data("loop") !== undefined) ? $postCarousel.data("loop") : 0,
		    $grab_cursor    = ($postCarousel.data("grab-cursor") !== undefined) ? $postCarousel.data("grab-cursor") : 0,
		    $pause_on_hover = ($postCarousel.data("pause-on-hover") !== undefined) ? $postCarousel.data("pause-on-hover") : '',
		    $centeredSlides = ($effect == 'coverflow')? true : false;

		var eaelPostCarousel = new Swiper($postCarousel, {
			direction     : 'horizontal',
			speed         : $speed,
			effect        : $effect,
			centeredSlides: $centeredSlides,
			slidesPerView : $items,
			spaceBetween  : $margin,
			grabCursor    : $grab_cursor,
			autoHeight    : true,
			loop          : $loop,
			autoplay: {
				delay: $autoplay,
			},
			pagination: {
				el       : $pagination,
				clickable: true,
			},
			navigation: {
				nextEl: $arrow_next,
				prevEl: $arrow_prev,
			},
			breakpoints: {
				480: {
					slidesPerView: $items_mobile,
					spaceBetween : $margin_mobile
				},
				768: {
					slidesPerView: $items_tablet,
					spaceBetween : $margin_tablet
				}
			}
		});

		if($autoplay === 0) {
			eaelPostCarousel.autoplay.stop();
		}

        if($pause_on_hover && $autoplay !== 0) {
            $postCarousel.on('mouseenter', function() {
                eaelPostCarousel.autoplay.stop();
            });
            $postCarousel.on('mouseleave', function() {
                eaelPostCarousel.autoplay.start();
            });
        }
	};
	
	/*=================================*/
	/* 20. Facebook Carousel
	/*=================================*/
	var FacebookCarouselHandler = function ($scope, $) {

		var loadingFeed = $scope.find( '.eael-loading-feed' ),
		    $fbCarousel = $scope.find('.eael-facebook-feed-carousel-wrapper').eq(0),
		    $name       = ($fbCarousel.data("facebook-feed-carousel-ac") !== undefined) ? $fbCarousel.data("facebook-feed-carousel-ac") : '',
		    $limit      = ($fbCarousel.data("facebook-feed-carousel-post-limit") !== undefined) ? $fbCarousel.data("facebook-feed-carousel-post-limit") : '',
		    $app_id     = ($fbCarousel.data("facebook-feed-carousel-app-id") !== undefined) ? $fbCarousel.data("facebook-feed-carousel-app-id") : '',
		    $app_secret = ($fbCarousel.data("facebook-feed-carousel-app-secret") !== undefined) ? $fbCarousel.data("facebook-feed-carousel-app-secret") : '',
		    $length     = ($fbCarousel.data("facebook-feed-carousel-length") !== undefined) ? $fbCarousel.data("facebook-feed-carousel-length") : 400,
		    $media      = ($fbCarousel.data("facebook-feed-carousel-media") !== undefined) ? $fbCarousel.data("facebook-feed-carousel-media") : false,
		    $carouselId = ($fbCarousel.data("facebook-feed-carousel-id") !== undefined) ? $fbCarousel.data("facebook-feed-carousel-id") : ' ';
		
		/**
		 * Facebook Feed Init
		 */
		function eael_facebook_feeds() {
			var $access_token = ($app_id+'|'+$app_secret).toString();
			var $id_name      = $name.toString();

			$('#eael-facebook-feed-'+ $carouselId +'.eael-facebook-feed-main-carousel-container').socialfeed({
				facebook:{
				   accounts    : [$id_name],
				   limit       : $limit,
				   access_token: $access_token
				},
				// GENERAL SETTINGS
				length       : $length,
				show_media   : $media,
				template_html: '<div class="swiper-slide"><div class="carousel-cell eael-social-feed-element {{?\ !it.moderation_passed}}hidden{{?}}" dt-create="{{=it.dt_create}}" social-feed-id = "{\{=it.id}}">\
				{{=it.attachment}}\
				<div class="eael-content">\
					<a class="pull-left auth-img" href="{{=it.author_link}}" target="_blank">\
						<img class="media-object" src="{{=it.author_picture}}">\
					</a>\
					<div class="media-body">\
						<p>\
							<i class="fa fa-{{=it.social_network}} social-feed-icon"></i>\
							<span class="author-title">{{=it.author_name}}</span>\
							<span class="muted pull-right social-feed-date"> {{=it.time_ago}}</span>\
						</p>\
						<div class="text-wrapper">\
							<p class="social-feed-text">{{=it.text}} </p>\
							<p><a href="{{=it.link}}" target="_blank" class="read-more-link">Read \</a></p>\
						</div>\
					</div>\
				</div>\
			</div></div>',
			});
		}

		/**
		 * Facebook Feed Carousel View
		 */
		 function eael_facebook_feed_carosuel() {
			var $carousel       = $scope.find('.eael-facebook-feed-carousel-nav').eq(0),
			    $pagination     = ($carousel.data("pagination") !== undefined) ? $carousel.data("pagination") : '.swiper-pagination',
			    $arrow_next     = ($carousel.data("arrow-next") !== undefined) ? $carousel.data("arrow-next") : '.swiper-button-next',
			    $arrow_prev     = ($carousel.data("arrow-prev") !== undefined) ? $carousel.data("arrow-prev") : '.swiper-button-prev',
			    $items          = ($carousel.data("items") !== undefined) ? $carousel.data("items") : 3,
			    $items_tablet   = ($carousel.data("items-tablet") !== undefined) ? $carousel.data("items-tablet") : 3,
			    $items_mobile   = ($carousel.data("items-mobile") !== undefined) ? $carousel.data("items-mobile") : 3,
			    $margin         = ($carousel.data("margin") !== undefined) ? $carousel.data("margin") : 10,
			    $margin_tablet  = ($carousel.data("margin-tablet") !== undefined) ? $carousel.data("margin-tablet") : 10,
			    $margin_mobile  = ($carousel.data("margin-mobile") !== undefined) ? $carousel.data("margin-mobile") : 10,
			    $effect         = ($carousel.data("effect") !== undefined) ? $carousel.data("effect") : 'slide',
			    $speed          = ($carousel.data("speed") !== undefined) ? $carousel.data("speed") : 400,
			    $autoplay       = ($carousel.data("autoplay") !== undefined) ? $carousel.data("autoplay") : 999999,
			    $loop           = ($carousel.data("loop") !== undefined) ? $carousel.data("loop") : 0,
			    $grab_cursor    = ($carousel.data("grab-cursor") !== undefined) ? $carousel.data("grab-cursor") : 0,
			    $centeredSlides = ($effect == 'coverflow')? true : false,

			mySwiper = new Swiper($carousel, {
				direction     : 'horizontal',
				speed         : $speed,
				effect        : $effect,
				centeredSlides: $centeredSlides,
				slidesPerView : $items,
				spaceBetween  : $margin,
				grabCursor    : $grab_cursor,
				autoHeight    : true,
				loop          : $loop,
				autoplay      : {
					delay: $autoplay,
				},
				pagination: {
					el       : $pagination,
					clickable: true,
				},
				navigation: {
					nextEl: $arrow_next,
					prevEl: $arrow_prev,
				},
				breakpoints: {
					// when window width is <= 480px
					480: {
						slidesPerView: $items_mobile,
						spaceBetween : $margin_mobile
					},
					// when window width is <= 640px
					768: {
						slidesPerView: $items_tablet,
						spaceBetween : $margin_tablet
					}
				}
			});
		}

		$.ajax({
			url: eael_facebook_feeds(),
			beforeSend: function() {
				loadingFeed.addClass( 'show-loading' );
			},
			success: function() {
				setTimeout(function() {
				eael_facebook_feed_carosuel();
					loadingFeed.removeClass( 'show-loading' );
				}, 2000);
			},
			error: function() {
				console.log('error loading');
			}
		});  
	};

	/*=================================*/
	/* 21. Facebook Feed
	/*=================================*/
	var FacebookFeedHandler = function ($scope, $) {
		var $feed_element  = $scope.find('.eael-facebook-feed-wrapper').eq(0),
		    $loading_feed  = $feed_element.find('.eael-loading-feed'),
			$feed_settings = $feed_element.data('settings');
		
		function get_feed_data() {
			$feed_element.find('.eael-social-feed-container').socialfeed({
				facebook: {
                    accounts    : [$feed_settings.accounts],
                    limit       : ($feed_settings.limit),
                    access_token: ($feed_settings.access_token),
                },
                length    : parseInt($feed_settings.length),
                show_media: $feed_settings.showMedia,
                template  : $feed_settings.template
			});
		}

		function facebook_masonry_grid() {
			var $masonry_container = $feed_element.find('.eael-social-feed-container');
			$( $masonry_container ).masonry({
				itemSelector: '.eael-social-feed-element-wrap',
				percentPosition: true
			});
		}

		$.ajax({
			url: get_feed_data(),
			beforeSend: function() {
				$loading_feed.addClass('show-loading');
			},
			success: function() {
				if($feed_settings.layout === 'grid-layout') {
					setTimeout(function() {
						facebook_masonry_grid();
					}, 1500);
				}
				$loading_feed.removeClass('show-loading');
			},
			error: function() {
				console.log('Error getting data from Facebook');
			}
		});

	};

	/*=================================*/
	/* 22. Twitter Feed
	/*=================================*/
	var TwitterFeedHandler = function ($scope, $) {
		var loadingFeed  = $scope.find( '.eael-loading-feed' ),
		    $twitterFeed = $scope.find('.eael-twitter-feed-layout-wrapper').eq(0),
		    $name        = ($twitterFeed.data("twitter-feed-ac-name") !== undefined) ? $twitterFeed.data("twitter-feed-ac-name") : '',
		    $limit       = ($twitterFeed.data("twitter-feed-post-limit") !== undefined) ? $twitterFeed.data("twitter-feed-post-limit") : '',
		    $hash_tag    = ($twitterFeed.data("twitter-feed-hashtag-name") !== undefined) ? $twitterFeed.data("twitter-feed-hashtag-name") : '',
		    $key         = ($twitterFeed.data("twitter-feed-consumer-key") !== undefined) ? $twitterFeed.data("twitter-feed-consumer-key") : '',
		    $app_secret  = ($twitterFeed.data("twitter-feed-consumer-secret") !== undefined) ? $twitterFeed.data("twitter-feed-consumer-secret") : '',
		    $length      = ($twitterFeed.data("twitter-feed-content-length") !== undefined) ? $twitterFeed.data("twitter-feed-content-length") : 400,
		    $media       = ($twitterFeed.data("twitter-feed-media") !== undefined) ? $twitterFeed.data("twitter-feed-media") : false,
		    $feed_type   = ($twitterFeed.data("twitter-feed-type") !== undefined) ? $twitterFeed.data("twitter-feed-type") : false,
		    $carouselId  = ($twitterFeed.data("twitter-feed-id") !== undefined) ? $twitterFeed.data("twitter-feed-id") : ' ';

		var $id_name       = $name.toString(),
		    $hash_tag_name = $hash_tag.toString(),
		    $key_name      = $key.toString(),
		    $app_secret    = $app_secret.toString();
		
		function eael_twitter_feeds() {
			$( '#eael-twitter-feed-'+ $carouselId +'.eael-twitter-feed-layout-container' ).socialfeed({
				// TWITTER
				twitter:{
				   accounts       : [ $id_name , $hash_tag_name ],
				   limit          : $limit,
				   consumer_key   : $key_name,
				   consumer_secret: $app_secret,
				},
				// GENERAL SETTINGS
				length       : $length,
				show_media   : $media,
				template_html: '<div class="eael-social-feed-element {{? !it.moderation_passed}}hidden{{?}}" dt-create="{{=it.dt_create}}" social-feed-id = "{{=it.id}}">\
				<div class="eael-content">\
					<a class="pull-left auth-img" href="{{=it.author_link}}" target="_blank">\
						<img class="media-object" src="{{=it.author_picture}}">\
					</a>\
					<div class="media-body">\
						<p>\
							<i class="fa fa-{{=it.social_network}} social-feed-icon"></i>\
							<span class="author-title">{{=it.author_name}}</span>\
							<span class="muted pull-right social-feed-date"> {{=it.time_ago}}</span>\
						</p>\
						<div class="text-wrapper">\
							<p class="social-feed-text">{{=it.text}} </p>\
							<p><a href="{{=it.link}}" target="_blank" class="read-more-link">Read More <i class="fa fa-angle-double-right"></i></a></p>\
						</div>\
					</div>\
				</div>\
				{{=it.attachment}}\
			</div>',
			});
		}

		
		//Twitter Feed masonry View
		function eael_twitter_feed_masonry() {
			$('.eael-twitter-feed-layout-container.masonry-view').masonry({
				itemSelector: '.eael-social-feed-element',
				percentPosition: true,
				columnWidth: '.eael-social-feed-element'
			});
		}

		$.ajax({
			url: eael_twitter_feeds(),
			beforeSend: function() {
				loadingFeed.addClass( 'show-loading' );
			},
			success: function() {
				if($feed_type == 'masonry') {
					setTimeout(function() {
						eael_twitter_feed_masonry();
					}, 2000);
					 
				}
				loadingFeed.removeClass( 'show-loading' );
			},
			error: function() {
				console.log('error loading');
			}
		});
				
	 }

	/*=================================*/
	/* 23. Twitter Feed Carousel
	/*=================================*/
	var TwitterFeedCarouselHandler = function ($scope, $) {
		var loadingFeed          = $scope.find( '.eael-loading-feed' ),
		    $twitterFeedCarousel = $scope.find('.eael-twitter-feed-carousel-wrapper').eq(0),
		    $name                = ($twitterFeedCarousel.data("twitter-feed-carousel-ac-name") !== undefined) ? $twitterFeedCarousel.data("twitter-feed-carousel-ac-name") : '',
		    $limit               = ($twitterFeedCarousel.data("twitter-feed-carousel-post-limit") !== undefined) ? $twitterFeedCarousel.data("twitter-feed-carousel-post-limit") : '',
		    $hash_tag            = ($twitterFeedCarousel.data("twitter-feed-carousel-hashtag-name") !== undefined) ? $twitterFeedCarousel.data("twitter-feed-carousel-hashtag-name") : '',
		    $key                 = ($twitterFeedCarousel.data("twitter-feed-carousel-consumer-key") !== undefined) ? $twitterFeedCarousel.data("twitter-feed-carousel-consumer-key") : '',
		    $app_secret          = ($twitterFeedCarousel.data("twitter-feed-carousel-consumer-secret") !== undefined) ? $twitterFeedCarousel.data("twitter-feed-carousel-consumer-secret") : '',
		    $length              = ($twitterFeedCarousel.data("twitter-feed-carousel-content-length") !== undefined) ? $twitterFeedCarousel.data("twitter-feed-carousel-content-length") : 400,
		    $media               = ($twitterFeedCarousel.data("twitter-feed-carousel-media") !== undefined) ? $twitterFeedCarousel.data("twitter-feed-carousel-media") : false,
			$carouselId          = ($twitterFeedCarousel.data("twitter-feed-carousel-id") !== undefined) ? $twitterFeedCarousel.data("twitter-feed-carousel-id") : ' ';
			
		var $id_name       = $name.toString(),
		    $hash_tag_name = $hash_tag.toString(),
		    $key_name      = $key.toString(),
		    $app_secret    = $app_secret.toString();
		
		function eael_twitter_feeds() {
			$( '#eael-twitter-feed-'+ $carouselId +'.eael-twitter-feed-main-carousel-container' ).socialfeed({
				// TWITTER
				twitter:{
				   accounts       : [ $id_name , $hash_tag_name ],
				   limit          : $limit,
				   consumer_key   : $key_name,
				   consumer_secret: $app_secret,
				},
				// GENERAL SETTINGS
				length       : $length,
				show_media   : $media,
				template_html: '<div class="swiper-slide"><div class="carousel-cell eael-social-feed-element {{? !it.moderation_passed}}hidden{{?}}" dt-create="{{=it.dt_create}}" social-feed-id = "{{=it.id}}">\
				<div class="eael-content">\
					<a class="pull-left auth-img" href="{{=it.author_link}}" target="_blank">\
						<img class="media-object" src="{{=it.author_picture}}">\
					</a>\
					<div class="media-body">\
						<p>\
							<i class="fa fa-{{=it.social_network}} social-feed-icon"></i>\
							<span class="author-title">{{=it.author_name}}</span>\
							<span class="muted pull-right social-feed-date"> {{=it.time_ago}}</span>\
						</p>\
						<div class="text-wrapper">\
							<p class="social-feed-text">{{=it.text}} </p>\
							<p><a href="{{=it.link}}" target="_blank" class="read-more-link">Read More <i class="fa fa-angle-double-right"></i></a></p>\
						</div>\
					</div>\
				</div>\
				{{=it.attachment}}\
			</div></div>',
			});
		}

				
		/**
		 * Twitter Feed Carousel View
		 */
		 function eael_twitter_feed_carosuel() {
			var $carousel       = $scope.find('.eael-twitter-feed-carousel-nav').eq(0),
			    $pagination     = ($carousel.data("pagination") !== undefined) ? $carousel.data("pagination") : '.swiper-pagination',
			    $arrow_next     = ($carousel.data("arrow-next") !== undefined) ? $carousel.data("arrow-next") : '.swiper-button-next',
			    $arrow_prev     = ($carousel.data("arrow-prev") !== undefined) ? $carousel.data("arrow-prev") : '.swiper-button-prev',
			    $items          = ($carousel.data("items") !== undefined) ? $carousel.data("items") : 3,
			    $items_tablet   = ($carousel.data("items-tablet") !== undefined) ? $carousel.data("items-tablet") : 3,
			    $items_mobile   = ($carousel.data("items-mobile") !== undefined) ? $carousel.data("items-mobile") : 3,
			    $margin         = ($carousel.data("margin") !== undefined) ? $carousel.data("margin") : 10,
			    $margin_tablet  = ($carousel.data("margin-tablet") !== undefined) ? $carousel.data("margin-tablet") : 10,
			    $margin_mobile  = ($carousel.data("margin-mobile") !== undefined) ? $carousel.data("margin-mobile") : 10,
			    $effect         = ($carousel.data("effect") !== undefined) ? $carousel.data("effect") : 'slide',
			    $speed          = ($carousel.data("speed") !== undefined) ? $carousel.data("speed") : 400,
			    $autoplay       = ($carousel.data("autoplay") !== undefined) ? $carousel.data("autoplay") : 999999,
			    $loop           = ($carousel.data("loop") !== undefined) ? $carousel.data("loop") : 0,
			    $grab_cursor    = ($carousel.data("grab-cursor") !== undefined) ? $carousel.data("grab-cursor") : 0,
			    $centeredSlides = ($effect == 'coverflow')? true : false,
			    $pause_on_hover = ($carousel.data('pause-on-hover') !== undefined ? $carousel.data('pause-on-hover') : ''),
			    $twitterCarouselOptions = {
					direction     : 'horizontal',
					speed         : $speed,
					effect        : $effect,
					centeredSlides: $centeredSlides,
					slidesPerView : $items,
					spaceBetween  : $margin,
					grabCursor    : $grab_cursor,
					autoHeight    : true,
					loop          : $loop,
					autoplay: {
						delay: $autoplay,
					},
					pagination: {
						el: $pagination,
						clickable: true,
					},
					navigation: {
						nextEl: $arrow_next,
						prevEl: $arrow_prev,
					},
					breakpoints: {
						// when window width is <= 480px
						480: {
							slidesPerView: $items_mobile,
							spaceBetween : $margin_mobile
						},
						// when window width is <= 640px
						768: {
							slidesPerView: $items_tablet,
							spaceBetween : $margin_tablet
						}
					}
			};
			
			var twitterCarousel = new Swiper($carousel, $twitterCarouselOptions);
			if($autoplay === 0) {
				twitterCarousel.autoplay.stop();
			}

            if($pause_on_hover && $autoplay !== 0) {
                $carousel.on('mouseenter', function() {
                    twitterCarousel.autoplay.stop();
                });
                $carousel.on('mouseleave', function() {
                    twitterCarousel.autoplay.start();
                });
            }
		}

		$.ajax({
			url: eael_twitter_feeds(),
			beforeSend: function() {
				loadingFeed.addClass( 'show-loading' );
			},
			success: function() {
				setTimeout( function() {
					eael_twitter_feed_carosuel();
					loadingFeed.removeClass( 'show-loading' );							
				}, 6000 );
			},
			error: function() {
				console.log('error loading');
			}
		});
	 }
	
	/*=================================*/
	/* 24. Testimonial Slider
	/*=================================*/
	 var TestimonialSliderHandler = function ( $scope, $ ) {
		var $testimonialSlider = $scope.find('.eael-testimonial-slider-main').eq(0),
		    $pagination        = ($testimonialSlider.data("pagination") !== undefined) ? $testimonialSlider.data("pagination") : '.swiper-pagination',
		    $arrow_next        = ($testimonialSlider.data("arrow-next") !== undefined) ? $testimonialSlider.data("arrow-next") : '.swiper-button-next',
		    $arrow_prev        = ($testimonialSlider.data("arrow-prev") !== undefined) ? $testimonialSlider.data("arrow-prev") : '.swiper-button-prev',
		    $items             = ($testimonialSlider.data("items") !== undefined) ? $testimonialSlider.data("items") : 3,
		    $items_tablet      = ($testimonialSlider.data("items-tablet") !== undefined) ? $testimonialSlider.data("items-tablet") : 3,
		    $items_mobile      = ($testimonialSlider.data("items-mobile") !== undefined) ? $testimonialSlider.data("items-mobile") : 3,
		    $margin            = ($testimonialSlider.data("margin") !== undefined) ? $testimonialSlider.data("margin") : 10,
		    $margin_tablet     = ($testimonialSlider.data("margin-tablet") !== undefined) ? $testimonialSlider.data("margin-tablet") : 10,
		    $margin_mobile     = ($testimonialSlider.data("margin-mobile") !== undefined) ? $testimonialSlider.data("margin-mobile") : 10,
		    $effect            = ($testimonialSlider.data("effect") !== undefined) ? $testimonialSlider.data("effect") : 'slide',
		    $speed             = ($testimonialSlider.data("speed") !== undefined) ? $testimonialSlider.data("speed") : 400,
		    $autoplay          = ($testimonialSlider.data("autoplay_speed") !== undefined) ? $testimonialSlider.data("autoplay_speed") : 999999,
		    $loop              = ($testimonialSlider.data("loop") !== undefined) ? $testimonialSlider.data("loop") : 0,
		    $grab_cursor       = ($testimonialSlider.data("grab-cursor") !== undefined) ? $testimonialSlider.data("grab-cursor") : 0,
		    $centeredSlides    = ($effect == 'coverflow')? true : false,
		    $pause_on_hover    = ($testimonialSlider.data('pause-on-hover') !== undefined ? $testimonialSlider.data('pause-on-hover') : ''),

			$testimonialSliderOptions = {
                direction     : 'horizontal',
                speed         : $speed,
                effect        : $effect,
                centeredSlides: $centeredSlides,
                slidesPerView : $items,
                spaceBetween  : $margin,
                grabCursor    : $grab_cursor,
                autoHeight    : true,
                loop          : $loop,
                autoplay: {
                    delay: $autoplay,
                },
                pagination: {
                    el: $pagination,
                    clickable: true,
                },
                navigation: {
                    nextEl: $arrow_next,
                    prevEl: $arrow_prev,
                },
                breakpoints: {
                    // when window width is <= 480px
                    480: {
                        slidesPerView: $items_mobile,
                        spaceBetween : $margin_mobile
                    },
                    // when window width is <= 640px
                    768: {
                        slidesPerView: $items_tablet,
                        spaceBetween : $margin_tablet
                    }
                }
            };

		var $testimonialSliderObj = new Swiper($testimonialSlider, $testimonialSliderOptions);
		if($autoplay === 0) {
			$testimonialSliderObj.autoplay.stop();
		}

		if($pause_on_hover && $autoplay !== 0) {
			$testimonialSlider.on('mouseenter', function() {
				$testimonialSliderObj.autoplay.stop();
			});
			$testimonialSlider.on('mouseleave', function() {
				$testimonialSliderObj.autoplay.start();
			});
		}

	}
	
	/*=================================*/
	/* 25. Content Ticker
	/*=================================*/
	var ContentTicker = function ($scope, $) {
		var $contentTicker  = $scope.find('.eael-content-ticker').eq(0),
		    $items          = ($contentTicker.data("items") !== undefined) ? $contentTicker.data("items") : 1,
		    $items_tablet   = ($contentTicker.data("items-tablet") !== undefined) ? $contentTicker.data("items-tablet") : 1,
		    $items_mobile   = ($contentTicker.data("items-mobile") !== undefined) ? $contentTicker.data("items-mobile") : 1,
		    $margin         = ($contentTicker.data("margin") !== undefined) ? $contentTicker.data("margin") : 10,
		    $margin_tablet  = ($contentTicker.data("margin-tablet") !== undefined) ? $contentTicker.data("margin-tablet") : 10,
		    $margin_mobile  = ($contentTicker.data("margin-mobile") !== undefined) ? $contentTicker.data("margin-mobile") : 10,
		    $effect         = ($contentTicker.data("effect") !== undefined) ? $contentTicker.data("effect") : 'slide',
		    $speed          = ($contentTicker.data("speed") !== undefined) ? $contentTicker.data("speed") : 400,
		    $autoplay       = ($contentTicker.data("autoplay") !== undefined) ? $contentTicker.data("autoplay") : 5000,
		    $loop           = ($contentTicker.data("loop") !== undefined) ? $contentTicker.data("loop") : false,
		    $grab_cursor    = ($contentTicker.data("grab-cursor") !== undefined) ? $contentTicker.data("grab-cursor") : false,
		    $pagination     = ($contentTicker.data("pagination") !== undefined) ? $contentTicker.data("pagination") : '.swiper-pagination',
		    $arrow_next     = ($contentTicker.data("arrow-next") !== undefined) ? $contentTicker.data("arrow-next") : '.swiper-button-next',
		    $arrow_prev     = ($contentTicker.data("arrow-prev") !== undefined) ? $contentTicker.data("arrow-prev") : '.swiper-button-prev',
		    $pause_on_hover = ($contentTicker.data('pause-on-hover') !== undefined ? $contentTicker.data('pause-on-hover') : ''),
			$contentTickerOptions = {
				direction          : 'horizontal',
				loop               : $loop,
				speed              : $speed,
				effect             : $effect,
				slidesPerView      : $items,
				spaceBetween       : $margin,
				grabCursor         : $grab_cursor,
				paginationClickable: true,
				autoHeight         : true,
				autoplay: {
					delay: $autoplay,
				},
				pagination: {
					el: $pagination,
					clickable: true,
				},
				navigation: {
					nextEl: $arrow_next,
					prevEl: $arrow_prev,
				},
				breakpoints: {
					// when window width is <= 480px
					480: {
						slidesPerView: $items_mobile,
						spaceBetween : $margin_mobile
					},
					// when window width is <= 640px
					768: {
						slidesPerView: $items_tablet,
						spaceBetween : $margin_tablet
					}
				}
			};

		var $contentTickerSlider = new Swiper($contentTicker, $contentTickerOptions);
		if($autoplay === 0) {
			$contentTickerSlider.autoplay.stop();
		}
		if($pause_on_hover && $autoplay !== 0) {
			$contentTicker.on('mouseenter', function() {
				$contentTickerSlider.autoplay.stop();
			});
			$contentTicker.on('mouseleave', function() {
				$contentTickerSlider.autoplay.start();
			});
		}
	};

	/*=================================*/
	/* 26. Image Comparison
	/*=================================*/
	var ImageComparisonHandler = function( $scope, $ ){
		var $containerID  = $scope.find( '.eael-img-comp-container' ).eq(0),
		    $offset       = $containerID.data('offset'),
		    $orientation  = $containerID.data('orientation'),
		    $beforeLabel  = $containerID.data('before_label'),
		    $afterLabel   = $containerID.data('after_label'),
		    $overlay      = $containerID.data('overlay'),
		    $slideOnHover = $containerID.data('onhover'),
		    $slideOnClick = $containerID.data('onclick');
		$containerID.twentytwenty( {
			default_offset_pct   : $offset || 0.7,
			orientation          : $orientation || 'horizontal',
			before_label         : $beforeLabel || 'Before',
			after_label          : $afterLabel || 'After',
			no_overlay           : $overlay == 'yes' ? false    : true,
			move_slider_on_hover : $slideOnHover == 'yes' ? true: false,
			move_with_handle_only: true,
			click_to_move        : $slideOnClick == 'yes' ? true: false
		} );
	};

	/*=================================*/
	/* 27. MailChimp
	/*=================================*/
	var MailChimp = function ($scope, $) {
		var $mailChimp    = $scope.find('.eael-mailchimp-wrap').eq(0),
		    $mailchimp_id = ($mailChimp.data("mailchimp-id") !== undefined) ? $mailChimp.data("mailchimp-id") : '',
		    $api_key      = ($mailChimp.data("api-key") !== undefined) ? $mailChimp.data("api-key") : '',
		    $list_id      = ($mailChimp.data("list-id") !== undefined) ? $mailChimp.data("list-id") : '',
		    $button_text  = ($mailChimp.data("button-text") !== undefined) ? $mailChimp.data("button-text") : '',
		    $success_text = ($mailChimp.data("success-text") !== undefined) ? $mailChimp.data("success-text") : '',
		    $loading_text = ($mailChimp.data("loading-text") !== undefined) ? $mailChimp.data("loading-text") : '';

		eael_mailchimp_subscribe( 'eael-mailchimp-form-'+ $mailchimp_id +'', $api_key , $list_id , $button_text , $success_text , $loading_text );
	}

	/*=================================*/
	/* 28. LightBox
	/*=================================*/
	var LightBox = function ($scope, $) {
		var $lightBox         = $scope.find('.eael-lightbox-wrapper').eq(0),
		    $main_class       = maybe_note_undefined($lightBox, 'main-class'),
		    $popup_layout     = maybe_note_undefined($lightBox, 'popup-layout'),
		    $close_button     = ($lightBox.data('close_button') === 'yes') ? true : false,
		    $effect           = maybe_note_undefined($lightBox, 'effect'),
		    $type             = maybe_note_undefined($lightBox, 'type'),
		    $iframe_class     = maybe_note_undefined($lightBox, 'iframe-class'),
		    $src              = maybe_note_undefined($lightBox, 'src'),
		    $trigger_element  = maybe_note_undefined($lightBox, 'trigger-element'),
		    $delay            = ($lightBox.data('delay') != '' ) ? $lightBox.data('delay') : 0,
		    $trigger          = maybe_note_undefined($lightBox, 'trigger'),
		    $popup_id         = maybe_note_undefined($lightBox, 'lightbox-id'),
		    $display_after    = maybe_note_undefined($lightBox, 'display-after'),
		    $esc_exit         = ($lightBox.data('esc_exit') === 'yes') ? true : false,
		    $click_exit       = ($lightBox.data('click_exit') === 'yes') ? true : false;
		    $main_class      += ' ' + $popup_layout + ' ' + $effect;

			if('eael-lightbox-popup-fullscreen' == $popup_layout) {
				var win_height = ($(window).height() - 20);
				$('.eael-lightbox-container.content-type-image-now').css({
					'max-height': win_height + 'px',
					'margin-top': '10px'
				});
			}
			
		if('eael_lightbox_trigger_exit_intent' == $trigger) {
			var flag     = true,
			    mouseY   = 0,
			    topValue = 0;

			if ( $display_after === 0 ) {
				$.removeCookie($popup_id, { path: '/' });
			}
			window.addEventListener("mouseout", function (e) {
				mouseY = e.clientY;
				if (mouseY < topValue && !$.cookie($popup_id) ) {
					$.magnificPopup.open({
						items: {
							src: $src, //ID of inline element
						},
						iframe: {
							markup: '<div class="' + $iframe_class + '">'+
									'<div class="modal-popup-window-inner">'+
									'<div class="mfp-iframe-scaler">'+
										'<div class="mfp-close"></div>'+
										'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
									'</div>'+
									'</div>'+
									'</div>',
						},
						type           : $type,
						showCloseBtn   : $close_button,
						enableEscapeKey: $esc_exit,
						closeOnBgClick : $click_exit,
						removalDelay   : 500,             //Delaying the removal in order to fit in the animation of the popup
						mainClass      : $main_class,
					});

					if ( $display_after > 0 ) {
						$.cookie($popup_id, $display_after, { expires: $display_after, path: '/' });
					} else {
						$.removeCookie( $popup_id );
					}
				}
			},
			false);

		}else if ('eael_lightbox_trigger_pageload' == $trigger){
			if ( $display_after === 0 ) {
				$.removeCookie($popup_id, { path: '/' });
			}
			if ( !$.cookie($popup_id) ) {
				setTimeout(function() {
					$.magnificPopup.open({
						items: {
							src: $src, 
						},
						iframe: {
							markup: '<div class="' + $iframe_class + '">'+
									'<div class="modal-popup-window-inner">'+
									'<div class="mfp-iframe-scaler">'+
										'<div class="mfp-close"></div>'+
										'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
									'</div>'+
									'</div>'+
									'</div>',
						},
						type           : $type,
						showCloseBtn   : $close_button,
						enableEscapeKey: $esc_exit,
						closeOnBgClick : $click_exit,
						mainClass      : $main_class,
					});

					if ( $display_after > 0 ) {
						$.cookie($popup_id, $display_after, { expires: $display_after, path: '/' });
					} else {
						$.removeCookie( $popup_id );
					}
				}, $delay);
			}

		}else {
			if (typeof $trigger_element === 'undefined' || $trigger_element === '') {
				$trigger_element = '.eael-modal-popup-link';
			}

			$( $trigger_element ).magnificPopup({
				image: {
					markup: '<div class="' + $iframe_class + '">'+
							'<div class="modal-popup-window-inner">'+
							'<div class="mfp-figure">'+
							'<div class="mfp-close"></div>'+
							'<div class="mfp-img"></div>'+
							'<div class="mfp-bottom-bar">'+
								'<div class="mfp-title"></div>'+
								'<div class="mfp-counter"></div>'+
							'</div>'+
							'</div>'+
							'</div>'+
							'</div>',
				},
				iframe: {
					markup: '<div class="' + $iframe_class + '">'+
							'<div class="modal-popup-window-inner">'+
							'<div class="mfp-iframe-scaler">'+
								'<div class="mfp-close"></div>'+
								'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
							'</div>'+
							'</div>'+
							'</div>',
				},
				items: {
					src : $src,
					type: $type,
				},
				removalDelay   : 500,
				showCloseBtn   : $close_button,
				enableEscapeKey: $esc_exit,
				closeOnBgClick : $click_exit,
				mainClass      : $main_class,
			});
		}

		$.extend(true, $.magnificPopup.defaults, {
			tClose: 'Close',
		});

	}

	/*=================================*/
	/* 29. CountDown
	/*=================================*/
	var CountDown = function ($scope, $) {
		var $coundDown    = $scope.find('.eael-countdown-wrapper').eq(0),
		    $countdown_id = ($coundDown.data("countdown-id") !== undefined) ? $coundDown.data("countdown-id") : '',
		    $expire_type  = ($coundDown.data("expire-type")  !== undefined) ? $coundDown.data("expire-type") : '',
		    $expiry_text  = ($coundDown.data("expiry-text")  !== undefined) ? $coundDown.data("expiry-text") : '',
		    $expiry_title = ($coundDown.data("expiry-title") !== undefined) ? $coundDown.data('expiry-title') : '',
		    $redirect_url = ($coundDown.data("redirect-url") !== undefined) ? $coundDown.data("redirect-url") : '',
		    $template     = ($coundDown.data("template")     !== undefined) ? $coundDown.data("template") : '';
		
		jQuery(document).ready(function($) {
			'use strict';

			var countDown = $("#eael-countdown-" + $countdown_id);
			countDown.countdown({
				end: function() {
					if( $expire_type == 'text'){
						countDown.html( '<div class="eael-countdown-finish-message"><h4 class="expiry-title">' + $expiry_title + '</h4>' + '<div class="eael-countdown-finish-text">' + $expiry_text + '</div></div>');
					}
					else if ( $expire_type === 'url'){
						var editMode = $('body').find('#elementor').length;
						if( editMode > 0 ) {
							countDown.html("Your Page will be redirected to given URL (only on Frontend).");
						} else {
							window.location.href = $redirect_url;
						}	
					}
					else if ( $expire_type === 'template'){
						countDown.html( $template );
					} else {
						//do nothing!
					}
				}
			});
		});
	}

	/*=================================*/
	/* 30. Fancy Text
	/*=================================*/
	var FancyText = function ($scope, $) { 
		var $fancyText         = $scope.find('.eael-fancy-text-container').eq(0),
		    $id                = ($fancyText.data("fancy-text-id") !== undefined) ? $fancyText.data("fancy-text-id") : '',
		    $fancy_text        = ($fancyText.data("fancy-text")  !== undefined) ? $fancyText.data("fancy-text") : '',
		    $transition_type   = ($fancyText.data("fancy-text-transition-type")  !== undefined) ? $fancyText.data("fancy-text-transition-type") : '',
		    $fancy_text_speed  = ($fancyText.data("fancy-text-speed") !== undefined) ? $fancyText.data("fancy-text-speed") : '',
		    $fancy_text_delay  = ($fancyText.data("fancy-text-delay")     !== undefined) ? $fancyText.data("fancy-text-delay") : '',
		    $fancy_text_cursor = ($fancyText.data("fancy-text-cursor")     !== undefined) ? true : false,
		    $fancy_text_loop   = ($fancyText.data("fancy-text-loop")     !== undefined) ? true : false;
		    $fancy_text        = $fancy_text.split("|");
			
		if ( $transition_type  == 'typing' ) {
			$("#eael-fancy-text-" + $id).typed({
				strings   : $fancy_text,
				typeSpeed : $fancy_text_speed,
				backSpeed : 0,
				startDelay: 300,
				backDelay : $fancy_text_delay,
				showCursor: $fancy_text_cursor,
				loop      : $fancy_text_loop,
			});
		}

		if ( $transition_type  != 'typing' ) {
			$("#eael-fancy-text-" + $id).Morphext({
				animation: $transition_type,
				separator: ", ",
				speed    : $fancy_text_delay,
				complete : function () {
					// Overrides default empty function
				}
			});
		}
	}

	/*=================================*/
	/* 31. Image Accordion
	/*=================================*/
	var ImageAccordion = function ($scope, $) {
		var $imageAccordion = $scope.find('.eael-img-accordion').eq(0),
		    $id             = ($imageAccordion.data("img-accordion-id") !== undefined) ? $imageAccordion.data("img-accordion-id") : '',
		    $type           = ($imageAccordion.data("img-accordion-type")  !== undefined) ? $imageAccordion.data("img-accordion-type") : '';
		   
		if( 'on-click' === $type ) {
			$('#eael-img-accordion-'+ $id +' a').on('click', function(e) {
				e.preventDefault();
				$('#eael-img-accordion-'+ $id +' a').css('flex', '1');
				$(this).find('.overlay').parent('a').addClass('overlay-active');
				$('#eael-img-accordion-'+ $id +' a').find('.overlay-inner').removeClass('overlay-inner-show');
				$(this).find('.overlay-inner').addClass('overlay-inner-show');
				$(this).css('flex', '3');
			});
			$('#eael-img-accordion-'+ $id +' a').on('blur', function(e) {
				$('#eael-img-accordion-'+ $id +' a').css('flex', '1');
				$('#eael-img-accordion-'+ $id +' a').find('.overlay-inner').removeClass('overlay-inner-show');
				$(this).find('.overlay').parent('a').removeClass('overlay-active');
			});
		}
	}
	
	/*=================================*/
	/* 32. Interactive Card
	/*=================================*/
	var InteractiveCard = function ($scope, $) {
		var $interactiveCard = $scope.find('.interactive-card').eq(0),
		    $id              = ($interactiveCard.data("interactive-card-id") !== undefined) ? $interactiveCard.data("interactive-card-id") : '',
		    $animation       = ($interactiveCard.data("animation")  !== undefined) ? $interactiveCard.data("animation") : '',
		    $animation_time  = ($interactiveCard.data("animation-time")  !== undefined) ? $interactiveCard.data("animation-time") : '';
		
		var options = {
			containerId   : 'interactive-card-' + $id,
			frontAnimation: {
				start: 'fade-out',
				end  : 'fade-in'
			},
			rearAnimation: {
				start: 'zoom-out',
				end  : 'zoom-in'
			},
			contentAnimation: $animation.toString(),
			revealTime      : $animation_time
		}
		interactiveCards( options );          
	}

	/*=================================*/
	/* 33. Pricing Tooltip
	/*=================================*/
	var PricingTooltip = function($scope, $) {
		if( $.fn.tooltipster ) {
			var $tooltip = $scope.find('.tooltip'), i;

			for( i = 0; i < $tooltip.length; i++) {
				var $currentTooltip = $( '#' + $($tooltip[i]).attr('id') ),
				    $tooltipSide    = ( $currentTooltip.data('side') !== undefined ) ? $currentTooltip.data('side') : false,
				    $tooltipTrigger = ( $currentTooltip.data('trigger') !== undefined ) ? $currentTooltip.data('trigger') : 'hover',
				    $animation      = ( $currentTooltip.data('animation') !== undefined ) ? $currentTooltip.data('animation') : 'fade',
				    $anim_duration  = ( $currentTooltip.data('animation_duration') !== undefined ) ? $currentTooltip.data('animation_duration') : 300,
				    $theme          = ( $currentTooltip.data('theme') !== undefined ) ? $currentTooltip.data('theme') : 'default',
				    $arrow          = ( 'yes' == $currentTooltip.data('arrow') ) ? true : false;

				$currentTooltip.tooltipster({
					animation: $animation,
					trigger  : $tooltipTrigger,
					side     : $tooltipSide,
					delay    : $anim_duration,
					arrow    : $arrow,
					theme    : 'tooltipster-' + $theme
				});

			}
		}
	};

	/*=================================*/
	/* 34. ProgressBar
	/*=================================*/
    var ProgressBar = function ($scope, $) {
        jQuery('.eael-progressbar', $scope).eaelProgressBar()
    }
	
	/*=================================*/
	/* 35. Pricing Tooltip
	/*=================================*/
	var EaelOffcanvas = function ($scope, $) {
		new EAELOffcanvasContent( $scope );
	}

	$(window).on('elementor/frontend/init', function () {
		if ( elementorFrontend.isEditMode() ) { isEditMode = true; }

		elementorFrontend.hooks.addAction('frontend/element_ready/eael-toggle.default', ToggleHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-counter.default', CounterHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-flip-carousel.default', FlipCarousel);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-filterable-gallery.default', filterableGalleryHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-dynamic-filterable-gallery.default', DynamicFilterableGallery);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-instafeed.default', InstagramGallery);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-adv-accordion.default', AdvAccordionHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-google-map.default', AdvGoogleMap);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-adv-tabs.default', AdvanceTabHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-post-timeline.default', postTimelineHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-post-list.default', postListHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-data-table.default', dataTable);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-content-timeline.default', contentTimelineHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-team-member-carousel.default', TeamMemberCarouselHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-image-hotspots.default', ImageHotspotHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-logo-carousel.default', LogoCarouselHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-post-carousel.default', PostCarouselHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-post-block.default', PostBlockHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-facebook-feed-carousel.default', FacebookCarouselHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-facebook-feed.default', FacebookFeedHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-twitter-feed.default', TwitterFeedHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-twitter-feed-carousel.default', TwitterFeedCarouselHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-testimonial-slider.default', TestimonialSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-content-ticker.default', ContentTicker);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-image-comparison.default', ImageComparisonHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-mailchimp.default', MailChimp);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-lightbox.default', LightBox);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-countdown.default', CountDown);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-fancy-text.default', FancyText);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-image-accordion.default', ImageAccordion);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-interactive-card.default', InteractiveCard);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-pricing-table.default', PricingTooltip);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-progress-bar.default', ProgressBar);
		elementorFrontend.hooks.addAction('frontend/element_ready/eael-offcanvas.default', EaelOffcanvas);
	});

}(jQuery));