function subscribe_newsletter_clear_message() {
	$("#form-subscribe-newsletter div.notif").removeClass("is-success is-fail").html("")
}

function subscribe_newsletter_show_message(e, t) {
	var s = "success" === e ? "check" : "cross";
	return subscribe_newsletter_clear_message(), $("#form-subscribe-newsletter div.notif").addClass("is-" + e).html('<i class="ir ico-' + s + '"></i>' + t), "fail" === e ? !1 : !0
}

function subscribe_newsletter_finish_submit() {
	$('#form-subscribe-newsletter btn[type="submit"]').removeAttr("disabled").removeClass("isDisabled")
}

function subscribe_newsletter_start_submit() {
	$('#form-subscribe-newsletter btn[type="submit"]').attr("disabled", "disabled").addClass("isDisabled")
}

function subscribe_newsletter_reloading_captcha() {
	return subscribe_newsletter_start_submit(), Captcha.create("subscribe-newsletter-captcha-container", function() {
		subscribe_newsletter_finish_submit(), "" !== $('#form-subscribe-newsletter input[name="email"]').val() ? $('#form-subscribe-newsletter input[name="captcha_response"]').focus() : $('#form-subscribe-newsletter input[name="email"]').focus()
	}), !1
}

var animate_to_cp_register = function() {
	return $("body,html").animate({
		scrollTop : $(".cp__register").offset().top
	}, 800), !1
};
$(function() {
	$(".responsiveVideo").fitVids(), $("#back-top").hide(), $(function() {
		$(window).scroll(function() {
			$(this).scrollTop() > 300 ? $("#back-top").fadeIn() : $("#back-top").fadeOut()
		}), $("#back-top a").click(function() {
			return $("body,html").animate({
				scrollTop : 0
			}, 800), !1
		})
	}), $(".sidebar-open").click(function() {
		return $(".sideBar").addClass("active"), !1
	}), $(".sidebar-close").click(function() {
		return $(".sideBar").removeClass("active"), !1
	}), $("a.goto-anchor").click(function() {
		return $("html,body").animate({
			scrollTop : $($(this).attr("href")).offset().top
		}, "slow"), !1
	}), $(".tabNavList:nth-child(1)").addClass("isActive"), $(".tabContentList:nth-child(1)").removeClass("visuallyhidden"), $(".tabNavList").click(function() {
		var e = $(this).attr("href");
		return $(this).parent().find(".isActive").removeClass("isActive"), $(this).addClass("isActive"), $(this).parents(".tabNav").next().find(".tabContentList").addClass("visuallyhidden"), $(e + "-content").removeClass("visuallyhidden"), !1
	}), $(".radioList").click(function() {
		"disabled" != $(this).find("input[type=radio]").attr("disabled") && ($(this).parent().find(".isActive").removeClass("isActive"), $(this).addClass("isActive"))
	}), $(".datepicker").glDatePicker(), $(".subscribeButton").click(function() {
		return $(this).attr("disabled", "disabled"), $("#form-subscribe-newsletter div.subscribeCaptcha").removeClass("visuallyhidden"), subscribe_newsletter_reloading_captcha(), !1
	}), $("#form-subscribe-newsletter").ajaxForm({
		beforeSubmit : function(e, t, s) {
			return "" === $('#form-subscribe-newsletter input[name="email"]').val() ? ($('#form-subscribe-newsletter input[name="email"]').focus(), subscribe_newsletter_show_message("fail", "Anda belum mengisi email.")) : "" === $('#form-subscribe-newsletter input[name="captcha_response"]').val() ? ($('#form-subscribe-newsletter input[name="captcha_response"]').focus(), subscribe_newsletter_show_message("fail", "Anda belum mengisi captcha.")) : $('#form-subscribe-newsletter input[name="captcha_response"]').val().length != $('#form-subscribe-newsletter input[name="captcha_response"]').attr("maxlength") ? ($('#form-subscribe-newsletter input[name="captcha_response"]').focus(), subscribe_newsletter_show_message("fail", "Jumlah huruf captcha tidak sesuai.")) : (subscribe_newsletter_start_submit(), !0)
		},
		clearForm : !1,
		dataType : "json",
		error : function() {
			subscribe_newsletter_show_message("fail", "Maaf terjadi kesalahan fatal pada system kami, silahkan coba lagi beberapa saat lagi."), subscribe_newsletter_finish_submit(), subscribe_newsletter_reloading_captcha()
		},
		resetForm : !1,
		success : function(e) {
			null !== e ? e.success ? subscribe_newsletter_show_message("success", e.message) : (subscribe_newsletter_show_message("fail", e.message), subscribe_newsletter_reloading_captcha()) : (subscribe_newsletter_show_message("fail", "Maaf terjadi kesalahan fatal pada sistem kami, silahkan coba lagi beberapa saat lagi."), subscribe_newsletter_reloading_captcha()), subscribe_newsletter_finish_submit()
		}
	});
	var e = $(window).width();
	e > 600 ? $(".mainNavCol .toggle").click(function() {
		if ($(this).hasClass("active"))
			$(this).removeClass("active"), $(".mainNavCol").removeAttr("style"), $(this).parent().find(".subNav").toggleClass("active");
		else {
			$(".toggle").removeClass("active"), $(".subNav").removeClass("active"), $(".mainNavCol").removeAttr("style"), $(this).toggleClass("active");
			var e = $(this).parent().find(".subNav").toggleClass("active");
			$(this).parent().attr("style", "margin-bottom:" + e.outerHeight() + "px")
		}
	}) : $(".mainNavCol .toggle").swipe({
		tap : function(e, t) {
			$(this).hasClass("active") ? ($(this).removeClass("active"), $(this).parent().find(".subNav").toggleClass("active")) : ($(".toggle").removeClass("active"), $(this).toggleClass("active"), $(".subNav").removeClass("active"), $(this).parent().find(".subNav").toggleClass("active"))
		}
	}), 980 > e && ($(".membership-content span").click(function() {
		return $(this).next().toggle(), !1
	}), $(".myCart").click(function() {
		$(this).parent().find(".subMyCart").toggle()
	})), $("#mainBanner").bxSlider({
		onSlideBefore : function(e) {
			"" == e.find("img").attr("src") && e.find("img").attr("src", e.find("img").attr("dataimage")), 0 == e.find("img").is(":visible") && e.find("img").show()
		},
		auto : !0,
		pause : 7500,
		pager : !0
	}), $(".addressSlider").bxSlider({
		pagerCustom : ".addressPager",
		controls : !1,
		auto : !0
	}), $(".suggestSubmit").click(function() {
		return $(".suggestForm").removeClass("visuallyhidden"), $("html,body").animate({
			scrollTop : $(".suggestBox").offset().top
		}, "slow"), $(".suggestForm input").focus(), !1
	}), $(".searchCategory").selecter({
		cover : !0,
		customClass : "searchCategory"
	}), $(".customSelect").selecter({
		cover : !0
	}), $(".searchCategory .selecter-item").click(function() {
		$(".search input").focus()
	}), $(".toggleNav").swipe({
		tap : function(e, t) {
			$(".mainNav").toggleClass("showNav"), $(".toggleNav").toggleClass("isFloating")
		}
	}), $(".button").tipsy({
		delayIn : 200,
		delayOut : 300
	}), $(".tooltipe").tipsy({
		gravity : "e"
	}), $(".tooltipw").tipsy({
		gravity : "w"
	}), $(".tooltips").tipsy({
		gravity : "s"
	}), $(".tooltipn").tipsy({
		gravity : "n"
	}), $(".topBranchNav a.topBranchToggle").click(function() {
		return $(this).parent().toggleClass("is-active"), $(".topBranchContent").toggleClass("visuallyhidden"), !1
	}), $(".inline-do").click(function() {
		selector = $(this).parents(".inline-edit"), selector.find(".inline-text").hide(), selector.find(".inline-do").hide(), selector.find(".editForm").show(), selector.find(".editForm input").focus()
	}), $(".inline-cancel").click(function() {
		selector = $(this).parents(".inline-edit"), selector.find(".inline-text").show(), selector.find(".inline-do").show(), selector.find(".editForm").hide()
	}), $(".ticket-respond-nav li").click(function() {
		return $(".ticket-respond-nav li").addClass("is-inactive"), $(this).removeClass("is-inactive"), !1
	}), $(".edit-popup").magnificPopup({
		type : "inline",
		preloader : !1,
		focus : "#name",
		gallery : {
			enabled : !0,
			navigateByImgClick : !0,
			preload : [0, 1]
		},
		callbacks : {
			beforeOpen : function() {
				this.st.focus = $(window).width() < 700 ? !1 : "input:first"
			}
		}
	}), $(".edit-popup-no-gallery").magnificPopup({
		type : "inline",
		preloader : !1,
		focus : "#name",
		callbacks : {
			beforeOpen : function() {
				this.st.focus = $(window).width() < 700 ? !1 : "input:first"
			}
		}
	});
	var t = $.magnificPopup.instance;
	$("#close-popup").click(function() {
		return t.close(), !1
	}), $(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
		disableOn : 700,
		type : "iframe",
		mainClass : "mfp-fade",
		removalDelay : 160,
		preloader : !1,
		fixedContentPos : !1
	}), $(".image-popup").magnificPopup({
		type : "image",
		closeOnContentClick : !0,
		mainClass : "mfp-img-mobile",
		gallery : {
			enabled : !0,
			navigateByImgClick : !0,
			preload : [0, 1]
		},
		image : {
			verticalFit : !0
		}
	}), $(".boom__slider ul").bxSlider({
		auto : !0
	}), $(".apple__slider__wrapper").bxSlider({
		auto : !0,
		slideWidth : 1300,
		pagerCustom : $(".apple__pager")
	}), $(".wm__tab a").click(function() {
		return $(".wm__tab a").parent().removeClass("wm__tab--active"), $(this).parent().addClass("wm__tab--active"), $(".isotope").hide(), $(".isotope").infinitescroll("pause"), $($(this).attr("href")).show(), $($(this).attr("href")).isotope(), $($(this).attr("href")).infinitescroll("resume"), !1
	}), $(".xtreamer__feature ul").bxSlider({
		minSlides : 1,
		maxSlides : 3,
		slideWidth : 500,
		slideMargin : 50,
		pager : !1,
		auto : !0
	});
	var s = window.matchMedia("(min-width: 980px)");
	s.matches ? (window.$zopim || function(e, t) {
		var s = $zopim = function(e) {
			s._.push(e)
		}, i = s.s = e.createElement(t), a = e.getElementsByTagName(t)[0];
		s.set = function(e) {
			s.set._.push(e)
		}, s._ = [], s.set._ = [], i.async = !0, i.setAttribute("charset", "utf-8"), i.src = "//v2.zopim.com/?Xkc4JGp7CC4BKlncHDVNoKrsO9FZjZpN", s.t = +new Date, i.type = "text/javascript", a.parentNode.insertBefore(i, a)
	}(document, "script"), window.fbAsyncInit = function() {
		FB.init({
			appId : "124627837618926",
			status : !0,
			xfbml : !0
		})
	}, function(e, t, s) {
		var i, a = e.getElementsByTagName(t)[0];
		e.getElementById(s) || ( i = e.createElement(t), i.id = s, i.src = "//connect.facebook.net/en_US/all.js", a.parentNode.insertBefore(i, a))
	}(document, "script", "facebook-jssdk"), ! function(e, t, s) {
		var i, a = e.getElementsByTagName(t)[0];
		e.getElementById(s) || ( i = e.createElement(t), i.id = s, i.src = "//platform.twitter.com/widgets.js", a.parentNode.insertBefore(i, a))
	}(document, "script", "twitter-wjs"), console.log("desktop mode")) : console.log("mobile mode");
	var i = $(window), a = function(e) {
		var t = i.scrollTop(), s = i.scrollTop() + i.height();
		$(".cp__feature__animate").each(function() {
			var e = $(this), i = e.offset().top + 300, a = i + e.height(), r = i >= t && s >= i, n = a >= t && s >= a, o = r || n;
			e.toggleClass("cp__feature__animate--active", o)
		})
	};
	i.scroll(a), a(), $("#cp_button_register").click(animate_to_cp_register), $(".cp__form").validate({
		errorElement : "span",
		rules : {
			caname : "required",
			catax : {
				required : !0,
				digits : !0
			},
			caaddr : "required",
			catel : {
				required : !0,
				digits : !0
			},
			cacp : "required",
			cacpemail : {
				required : !0,
				email : !0
			},
			cacptel : {
				required : !0,
				digits : !0
			},
			captcha_response : "required"
		},
		messages : {
			caname : {
				required : "Nama Perusahaan harus diisi."
			},
			catax : {
				required : "NPWP Perusahaan harus diisi.",
				digits : "NPWP Perusahaan hanya boleh berupa angka."
			},
			caaddr : {
				required : "Alamat Perusahaan harus diisi."
			},
			catel : {
				required : "Telepon Perusahaan harus diisi.",
				digits : "Telepon Perusahaan hanya boleh berupa angka."
			},
			cacp : {
				required : "Contact Person harus diisi."
			},
			cacpemail : {
				required : "Email Contact Person harus diisi.",
				email : "Gunakan format email yang valid, contoh : name@company.com"
			},
			cacptel : {
				required : "Telepon Contact Person harus diisi.",
				digits : "Telepon Contact Person hanya boleh berupa angka."
			},
			captcha_response : {
				required : "Captcha harus diisi."
			}
		}
	})
}), $(window).load(function() {
	$(".tt__person").addClass("tt__person--active")
}); 