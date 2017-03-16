jQuery( document ).ready(function() {

	// add submenu icons class in main menu (only for large resolution)
	if (finteriordesign_IsLargeResolution()) {
	
		jQuery('#navmain > div > ul > li:has("ul")').addClass('level-one-sub-menu');
		jQuery('#navmain > div > ul li ul li:has("ul")').addClass('level-two-sub-menu');

	} else {

		if ( jQuery('#navmain li').length > 10 ) {

			jQuery('#navmain ul.menu').css('height', '300px').css('overflow-y', 'scroll').css('margin-left', '5%');
		}
	}

	jQuery('#header-spacer').height(jQuery('#header-main').height());

	jQuery('#navmain > div').on('click', function(e) {

		e.stopPropagation();

		// toggle main menu
		if (finteriordesign_IsSmallResolution() || finteriordesign_IsMediumResolution()) {

			var parentOffset = jQuery(this).parent().offset(); 
			
			var relY = e.pageY - parentOffset.top;
		
			jQuery('ul:first-child', this).toggle(400);
		}
	});
});

function finteriordesign_IsSmallResolution() {

	return (jQuery(window).width() <= 360);
}

function finteriordesign_IsMediumResolution() {
	
	var browserWidth = jQuery(window).width();

	return (browserWidth > 360 && browserWidth < 800);
}

function finteriordesign_IsLargeResolution() {

	return (jQuery(window).width() >= 800);
}

jQuery(document).ready(function () {

  jQuery(window).scroll(function () {
	  if (jQuery(this).scrollTop() > 100) {
		  jQuery('.scrollup').fadeIn();
	  } else {
		  jQuery('.scrollup').fadeOut();
	  }
  });

  jQuery('.scrollup').click(function () {
	  jQuery("html, body").animate({
		  scrollTop: 0
	  }, 600);
	  return false;
  });

});

jQuery(function() {
	if (jQuery('#rm_container').length == 0) {
		return;
	}
	var $listItems 		= jQuery('#rm_container > ul > li'),
		totalItems		= $listItems.length,
		$rm_next		= jQuery('#rm_next'),
		$rm_prev		= jQuery('#rm_prev'),
		$rm_play		= jQuery('#rm_play'),
		$rm_pause		= jQuery('#rm_pause'),
		$rm_mask_left	= jQuery('#rm_mask_left'),
		$rm_mask_right	= jQuery('#rm_mask_right'),
		$rm_corner_left	= jQuery('#rm_corner_left'),
		$rm_corner_right= jQuery('#rm_corner_right'),
		
		RotateImageMenu	= (function() {
				//difference of animation time between the items
			var	timeDiff			= 300,
				//time between each image animation (slideshow)
				slideshowTime		= 3000,
				slideshowInterval,	
				//checks if the images are rotating
				isRotating			= false,
				//how many images completed each slideshow iteration
				completed			= 0,
				origin				= ['155px', '930px'],
				init				= function() {
					configure();
					initEventsHandler();
				},
				//initialize some events
				initEventsHandler	= function() {
					$rm_next.bind('click', function(e) {
						stopSlideshow();
						rotateImages(1);
						return false;
					});
					$rm_prev.bind('click', function(e) {
						stopSlideshow();
						rotateImages(-1);
						return false;
					});
					/*
					start and stop the slideshow
					*/
					$rm_play.bind('click', function(e) {
						startSlideshow();
						return false;
					});
					$rm_pause.bind('click', function(e) {
						stopSlideshow();
						return false;
					});

					jQuery(document).keydown(function(e){
						switch(e.which){
							case 37:
								stopSlideshow();
								rotateImages(0);
								break;
							case 39:
								stopSlideshow();
								rotateImages(1);
								break;
						}
					});
				},
				/*
				rotates each items images.
				we set a delay between each item animation
				*/
				rotateImages		= function(dir) {
					//if the animation is in progress return
					if(isRotating) return false;
					
					isRotating = true;
					
					$listItems.each(function(i) {

						var $item 				= jQuery(this),
							interval			= (dir === 1) ? i * timeDiff : (totalItems - 1 - i) * timeDiff;

							var	$otherImages		= jQuery('#' + $item.data('images')).children('img'),
								totalOtherImages	= $otherImages.length;
								
								//the current one
								$img				= $item.children('img:last'),
								//keep track of each items current image
								current				= $item.data('current');
								//out of bounds 
								if(current > totalOtherImages - 1)
									current = 0;
								else if(current < 0)
									current = totalOtherImages - 1;
								
								//the next image to show and its initial rotation (depends on dir)
								var otherRotation	= (dir === 1) ? '-30deg' : '30deg',
									$other			= $otherImages.eq(current).clone();
									
								$other.css({
									'rotate'	: otherRotation,
									'transform-origin'	: '155px 930px 0'
								});
								
								(dir === 1) ? ++current : --current;
								
								//prepend the next image to the <li>
								$item.data('current', current).prepend($other);
								
								//the final rotation for the current image 
								var rotateTo		= (dir === 1) ? '80deg' : '-80deg';

								$img.css({'transform':'rotate(' + rotateTo + ')','transition':'all ease 3s',});

								$img.delay(2000).queue(function() {
								    jQuery(this).remove();

								    ++completed;
										if(completed === 4) {
											completed = 0;
											isRotating = false;
										}

								$other.css({'transform':'rotate(0deg)','transition':'all ease 2s',});
								});	
					});

				},
				//set initial rotations
				configure			= function() {
						
					$listItems.each(function(i) {
						//the initial current is 1 
						//since we already showing the first image
						var $item = jQuery(this).data('current', 1);

						var rotateTo = $item.data('rotation') + 'deg';
						$item.css({'transform':'rotate(' + rotateTo + ')'});

						$item.find('img').css({'transform-origin' : '155px 930px 0'});
					});
				},
				//rotates the masks and corners
				rotateMaskCorners	= function() {
					$rm_mask_left.css({'transform':'rotate(-3deg)'});
					$rm_mask_right.css({'transform':'rotate(3deg)'});
					$rm_corner_left.css({'transform':'rotate(45deg)'});
					$rm_corner_right.css({'transform':'rotate(-45deg)'});
				},
				//hides the masks and corners
				hideMaskCorners		= function() {
					$rm_mask_left.hide();
					$rm_mask_right.hide();
					$rm_corner_left.hide();
					$rm_corner_right.hide();
				},
				startSlideshow		= function() {
					clearInterval(slideshowInterval);
					rotateImages(1);
					slideshowInterval	= setInterval(function() {
						rotateImages(1);
					}, slideshowTime);
					//show the pause button and hide the play button
					$rm_play.hide();
					$rm_pause.show();
				},
				stopSlideshow		= function() {
					clearInterval(slideshowInterval);
					//show the play button and hide the pause button
					$rm_pause.hide();
					$rm_play.show();
				};
			
			return {init : init};
		})();
		
	RotateImageMenu.init();
});
