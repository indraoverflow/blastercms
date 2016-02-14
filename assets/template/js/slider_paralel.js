/*
 NAME: Paralel Slider;
 AUTHOR: Freshface;
 WEBSITE: http://www.freshface.net
 */
jQuery(document).ready(function($) {
	////////////////////////////////////////////////////////////////////////////////
	// INIT FUNCTION - here we set positions of the elements
	////////////////////////////////////////////////////////////////////////////////
	var elements_count = $('#slider_paralel').find('div').size();
	$('#slider_paralel').css({
		'MozUserSelect' : 'none'
	}).bind('selectstart', function() {
		return false;
	}).mousedown(function() {
		return false;
	});
	
	var wi = $('.slider_shadow').width();
	var wp = $('#slider_paralel').width();
	
	var min_space = 0;
	if(wi==1140){
		min_space = 115;
	}else{
		min_space = 45;
	}
	
	//var space = 960 / elements_count;
	var space = wi / elements_count;
	//var min_space = 45;
	var slided_trigger = 0;
	var slided_holder = 50;
	var actual_item = 0;

	if (autoslide_time != 0) {
		var auto_slide = setInterval(function() {
			actual_item++;
			if (actual_item == elements_count) {
				actual_item = 0;
			}
			/*          if($.browser.msie)
			 {

			 $('#slider_paralel').find('div').eq(actual_item).find('.paralel_s').css('display','block');
			 $('#slider_paralel').find('div').eq(actual_item).find('.paralel_b').css('display','none');
			 }
			 else
			 {
			 $('#slider_paralel').find('div').eq(actual_item).find('.paralel_s').stop().animate({opacity:1},500);
			 $('#slider_paralel').find('div').eq(actual_item).find('.paralel_b').stop().animate({opacity:0},500);
			 }      */

			$('#slider_paralel').find('div').eq(actual_item).find('img').stop().animate({
				opacity : 1
			}, 500);
			//$('#slider_paralel').find('div[rel!=animating]').find('.paralel_s').stop().animate({opacity:1}, 500);

			$('#slider_paralel').find('div').attr('rel', '');
			$('#slider_paralel').find('div').stop();
			$('#slider_paralel').find('div').eq(actual_item).attr('rel', 'animating');
			slided_trigger = 0;
			slided_holder = 50;
			$('#slider_paralel').find('div[rel!=animating]').find('img').stop().animate({
				opacity : 0.33
			}, 500);
			$('#slider_paralel').find('div[rel!=animating]').find('.paralel_s').stop().animate({
				opacity : 0.33
			}, 500);
			$('#slider_paralel').find('div[rel!=animating]').find('.paralel_b').animate({
				opacity : 0.0
			}, 500);

			if ($.browser.msie) {

				$('#slider_paralel').find('div').eq(actual_item).find('.paralel_s').css('display', 'none');
				$('#slider_paralel').find('div').eq(actual_item).find('.paralel_b').css('display', 'block');
			} else {
				$('#slider_paralel').find('div').eq(actual_item).find('.paralel_s').stop().animate({
					opacity : 0
				}, 500);
				$('#slider_paralel').find('div').eq(actual_item).find('.paralel_b').stop().animate({
					opacity : 1
				}, 500);
			}

			for (var j = 0; j < elements_count; j++) {

				var left_pos = 0;
				var s_width = min_space;
				if ($('#slider_paralel').find('div').eq(j).attr('rel') == 'animating') {
					s_width = wi - (elements_count - 1) * min_space;
					//s_width = 960 - (elements_count - 1) * min_space;
				}
				if (slided_trigger == 0) {
					left_pos = j * min_space;
					// s_width = 960-(elements_count - 1)*min_space;
				} else {

					left_pos = wi - (elements_count - j) * min_space;
					//left_pos = 960 - (elements_count - j) * min_space;
					//  slided_holder = slided_holder + 50;
				}
				//  if($('#slider_paralel').find('div').eq(j).attr('rel')!='animating')
				{
					$('#slider_paralel').find('div').eq(j).animate({
						left : left_pos,
						width : s_width + 10
					}, 500);
					//.css('left', 0);

				}
				if ($('#slider_paralel').find('div').eq(j).attr('rel') == 'animating') {
					slided_trigger = 1;
				}
			}

		}, autoslide_time);
	}

	$('.paralel_s').css('width', space - 40);
	$('.paralel_b').css('width', wi - min_space * (elements_count - 1));
	//$('.paralel_b').css('width', 960 - min_space * (elements_count - 1));
	if ($.browser.msie) {
		$('.paralel_b').css('display', 'none');
	} else {
		$('.paralel_b').animate({
			opacity : 0
		}, 0);
	}

	for (var i = 0; i < elements_count; i++) {
		$('#slider_paralel').find('div').eq(i).css('left', i * space);
		$('#slider_paralel').find('div').eq(i).css('z-index', i);
	}
	$('#slider_paralel .paralel_item').click(function() {
		var is_lightbox = $(this).find('.paralel_link').attr('title');

		var link_url = $(this).find('.paralel_link').html();
		if (link_url != '') {
			if (is_lightbox == "true") {
				$.prettyPhoto.open(link_url, '', $(this).find('.paralel_s').html());
			} else {
				window.location = link_url;
			}
		}
	});
	$('#slider_paralel .paralel_item').hover(function() {
		clearInterval(auto_slide);
		$('#slider_paralel').find('div').stop();
		$(this).attr('rel', 'animating');
		slided_trigger = 0;
		slided_holder = 50;
		$('#slider_paralel').find('div[rel!=animating]').find('img').stop().animate({
			opacity : 0.33
		}, 500);
		$('#slider_paralel').find('div[rel!=animating]').find('.paralel_s').stop().animate({
			opacity : 0.33
		}, 500);
		if ($.browser.msie) {

			$(this).find('.paralel_s').css('display', 'none');
			$(this).find('.paralel_b').css('display', 'block');
		} else {
			$(this).find('.paralel_s').stop().animate({
				opacity : 0
			}, 500);
			$(this).find('.paralel_b').stop().animate({
				opacity : 1
			}, 500);
		}

		for (var j = 0; j < elements_count; j++) {

			var left_pos = 0;
			var s_width = min_space;
			if ($('#slider_paralel').find('div').eq(j).attr('rel') == 'animating') {
				s_width = wi - (elements_count - 1) * min_space;
				//s_width = 960 - (elements_count - 1) * min_space;
			}
			if (slided_trigger == 0) {
				left_pos = j * min_space;
				// s_width = 960-(elements_count - 1)*min_space;
			} else {

				left_pos = wi - (elements_count - j) * min_space;
				//left_pos = 960 - (elements_count - j) * min_space;
				//  slided_holder = slided_holder + 50;
			}
			//  if($('#slider_paralel').find('div').eq(j).attr('rel')!='animating')
			{
				$('#slider_paralel').find('div').eq(j).animate({
					left : left_pos,
					width : s_width + 10
				}, 500);
				//.css('left', 0);

			}
			if ($('#slider_paralel').find('div').eq(j).attr('rel') == 'animating') {
				slided_trigger = 1;
			}
		}
	}, function() {

		if ($.browser.msie) {

			$(this).find('.paralel_s').css('display', 'block');
			$(this).find('.paralel_b').css('display', 'none');
		} else {
			$(this).find('.paralel_s').stop().animate({
				opacity : 1
			}, 500);
			$(this).find('.paralel_b').stop().animate({
				opacity : 0
			}, 500);
		}

		$('#slider_paralel').find('div[rel!=animating]').find('img').stop().animate({
			opacity : 1
		}, 500);
		$('#slider_paralel').find('div[rel!=animating]').find('.paralel_s').stop().animate({
			opacity : 1
		}, 500);
		$(this).attr('rel', '');
		$('#slider_paralel').find('div').stop();
		for (var n = 0; n < elements_count; n++) {

			$('#slider_paralel').find('div').eq(n).animate({
				left : n * space,
				width : space + 10
			}, 500);
		}
	});
});
