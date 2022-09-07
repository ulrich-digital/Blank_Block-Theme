jQuery(document).ready(function ($) {

/* =============================================================== *\ 
 	 Main-Menu 
\* =============================================================== */ 

$(window).on("load resize",function(e){
    var $body_width = $("body").width();
    if($body_width <= 840){
        $("#main_menu").addClass("animate__animated");    
        $("#main_menu").addClass("mobile");    
    }else{
        $("#main_menu").removeClass("animate__animated");    
        $("#main_menu").removeClass("mobile");    
    }
});

$(".hamburger").on("click", function(){
    $(this).toggleClass("is-active");
    $("#main_menu").toggleClass("animate__slideOutRight").toggleClass("animate__slideInRight");
});



/* =============================================================== *\ 
 	 GSAP Config 
\* =============================================================== */ 
/*
gsap.config({
    nullTargetWarn: false,
});
*/

    


}); //jQuery(document).ready
