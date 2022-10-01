jQuery(document).ready(function ($) {
/* =============================================================== *\ 
   Slick-Slider for Model Images 
\* =============================================================== */ 


/* =============================================================== *\ 
   Watermark Opacity
\* =============================================================== */ 
$('.model_image_slider_big').on('init', function(event, slick){
	$(this).find(".watermark").css("opacity", "1");
});

/* =============================================================== *\ 
   Hack: 
   Slider-Bilder hatten width:0 + height:0 
   wenn Slider beim Pageload nicht im Viewport war 
\* =============================================================== */ 
$(window).scroll(function(){
	$model_image_slider_big_height = $(".model_image_slider_big").height();
	if($model_image_slider_big_height<50){
		$(".model_image_slider_big").slick("refresh");
	}
});

/* =============================================================== *\ 
 	 Slick Init 
\* =============================================================== */ 
$('.model_image_slider_big').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: true,
	fade: true,
	lazyload: "ondemand",
	//asNavFor: '.slider_nav',
	prevArrow:'<div class="slick_left"><i class="a-left control-c prev slick-prev fa-solid fa-circle-chevron-left"></i></div',
	nextArrow:'<div class="slick_right"><i class="a-right control-c next slick-next fa-solid fa-circle-chevron-right"></i></div>',
});

/* =============================================================== *\ 
   Second-Image Slider as Navigation
\* =============================================================== */ 	
/*$('.slider_nav').slick({
	slidesToShow: 5,
	slidesToScroll: 1,
	asNavFor: '.model_image_slider_big',
	dots: false,
	arrows:true,
	centerMode: true,
	focusOnSelect: true,
	prevArrow:'<div class="slick_left"><i class="a-left control-c prev slick-prev fa-solid fa-circle-chevron-left"></i></div',
	nextArrow:'<div class="slick_right"><i class="a-right control-c next slick-next fa-solid fa-circle-chevron-right"></i></div>',
	responsive: [
		{
		breakpoint: 1000,
		settings: {
			slidesToShow: 4,
			centerMode:true,
		}
	},{
		breakpoint: 800,
		settings: {
			slidesToShow: 3,
			centerMode:true,
		}
	},{
		breakpoint: 600,
		settings: {
			slidesToShow: 2,
			centerMode:true,
		}
	}
	]
});
*/

/* =============================================================== *\ 
 	 Color Chips below Slider as Navigation for Slick-Slide
\* =============================================================== */ 
$(".color_chips_below_slider .single_color.as_link").first().addClass("active");  

var resumeIndex;
$(".color_chips_below_slider .single_color.as_link").on("click", function() {
	$(this).closest(".color_chips_below_slider").find(".as_link").removeClass("active");
	$(this).addClass("active");
	$(".model_image_slider_big").slick("refresh");
	resumeIndex = $(".model_image_slider_big").slick("getSlick").currentSlide;
	var artworkId = $(this).data("color-nav");
	var artIndex = $(".model_image_slider_big").find("[data-color-big="+artworkId+"]").closest(".slick-slide").data("slick-index");
	$(".model_image_slider_big").slick("pause").slick("slickGoTo", artIndex);
});


/* =============================================================== *\ 
   Slick-Slider-Arrows 
   > When clicking on the Slick-Slider-Arrows, 
     the .active class in the Color-Chips should also be updated
\* =============================================================== */ 
$(".model_image_slider_big .slick-arrow").on("click", function(){
	// Detect the active Slider
	$current_color_big = $(this).closest(".neuheiten_slider").find(".slick-current .slider_item").data("color-big");
	if($current_color_big!=""){
		$(".color_chips_below_slider .single_color").each(function(){
			$(this).removeClass("active");
			$current_data_color_nav = $(this).data('color-nav');
			if($current_color_big == $current_data_color_nav){
				$(this).addClass("active");
			}
		});
	}
});


/* =============================================================== *\ 
   Hack:
   Update Size for Slider
\* =============================================================== */ 
function refresh_slick_02(){
    var hoehe = $(".model_image_slider_big").height();
    if(hoehe <= 10){
        $('.model_image_slider_big').slick("refresh");    
    }else{
        clearInterval(my_slick_handle_02);
    }
}
var my_slick_handle_02 = setInterval(refresh_slick_02, 500);

}); // document ready