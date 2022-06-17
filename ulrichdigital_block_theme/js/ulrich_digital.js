jQuery(document).ready(function ($) {





/* =============================================================== *\ 

 	 Big button 

\* =============================================================== */ 
  
//var big_button_animated = document.getElementsByClassName('big_button').innerHTML('<i class="fa fa-trash-o"></i>');
/*
let div = document.querySelector('.big_button a');
div.innerHTML += '<i class="fa-regular fa-chevron-right"></i>';
*/
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
   @single-projekte
   add Icon to Block-Variation: Goodie List 
\* =============================================================== */ 

$(".group_goodie_list li").each(function(){
    $(this).prepend('<span class="fa-li"><i class="fa-solid fa-circle-dot"></i></span>');
});



/* =============================================================== *\ 
 	 HACK: Aus einem nicht herausgefundenen Grund 
     werden die untent aufgeführten Titel nicht getrennt.
     Hier eine schlechte Lösung
\* =============================================================== */ 
  
$('h2').each(function() {
    var text = $(this).html();
    /*
    if(text == "Informationen, die ankommen"){
        text = text.replace('Informationen', 'Infor&shy;mationen');
        $(this).html(text);        
    };

    if(text == "Kundenzufriedenheit"){
        text = text.replace('Kundenzufriedenheit', 'Kunden&shy;zufriedenheit');
        $(this).html(text);        
    };
    
    if(text == "Datensicherheit"){
        text = text.replace('Datensicherheit', 'Daten&shy;sicherheit');
        $(this).html(text);        
    };
    
    if(text == "Nachhaltigkeit"){
        text = text.replace('Nachhaltigkeit', 'Nach&shy;haltigkeit');
        $(this).html(text);        
    };
        
    if(text == "Beratung, Design, Webentwicklung"){
        text = text.replace('Webentwicklung', 'Web&shy;entwicklung');
        $(this).html(text);        
    };
    
    if(text == "Webentwicklung, Design"){
        text = text.replace('Webentwicklung', 'Web&shy;entwicklung');
        $(this).html(text);        
    };
*/
});


/* =============================================================== *\ 
 	 Add Browser Bar
\* =============================================================== */ 

// @page Projekte-Archiv
// to .wp-block-query

$(".page-template-projekte .wp-block-query img").each(function(){
    $(this).wrap('<div class="image_container_with_browser_bar"></div>');
});

// @ archive.php
$(".post-type-archive .wp-block-query img").each(function(){
    $(this).wrap('<div class="image_container_with_browser_bar"></div>');
});

// @single-projekte
// to .has_browser_bar img
// add Container
// manipulate max-width for resised images

$(".has_browser_bar img").each(function(){
    $(this).wrap('<div class="image_container_with_browser_bar"></div>');
});

$(".image_container_with_browser_bar img").each(function(){
    $('<div class="browser_bar"><div class="dot_1"></div><div class="dot_2"> </div><div class="dot_3"></div></div>').insertBefore($(this));
});

$(".is-resized .image_container_with_browser_bar img").each(function(){
    var $my_image_width = $(this).attr("width") + "px";
    //$(this).closest(".image_container_with_browser_bar").css("max-width", $my_image_width);    
});
 
 
// @page-template projekte
// manipulate Image-Container-Height
/*
$(window).on("load resize",function(e){
   $(".page-template-projekte .wp-block-post img").each(function(){   
       $my_height = $(this).height() + 40;
       $(this).closest(".wp-block-post").css("height", $my_height );
   });
});
 */
/* =============================================================== *\ 
    HACK
 	@Archive Post-Type: Projekt 
\* =============================================================== */ 
 $(".post-type-archive-projekt").removeClass("color_scheme_grey").addClass("color_scheme_sky").append('<div class="sky"></div>');


/* =============================================================== *\ 
 	 HACK
     @Page: Projekte
     @Post-Type-Archive: Projekt 
\* =============================================================== */ 
$(".page-template-projekte .wp-block-query .wp-block-post-title a, .post-type-archive-projekt .wp-block-query .wp-block-post-title a").each(function(){
    var $target = $(this).attr("href");
    var $title = $(this).text();
    $(this).closest("li").append('<a class="h2_container" href="' + $target + '"><span class="pseudo_h2">' + $title + '</a>');
    $(this).closest("h2").remove();
});


/* =============================================================== *\ 
   @Single Post (Blog)
   Core: Move Comment-Note
\* =============================================================== */ 

$my_note = $(".comment-notes").html();
if($(".comment-notes").length > 0){
    $("<p class='custom-comment-notes'> " + $my_note + "</p>").insertBefore($("#commentform .form-submit"));
}

/* =============================================================== *\ 
   @Single Post (Blog)
   Core: Comment-Form Valdiate 
   Validate the comment form on the same site
\* =============================================================== */ 
function webshapedValidateCommentForm() {
  $('#commentform').validate({
    rules: {
      author: {
        required: true,
        minlength: 0,
      },
      email: {
        required: true,
        email: true,
      },
      comment: {
        required: true,
        minlength: 20,
      },
      datenschutz: {
        required: false,
      },
    },

    messages: {
      author: {
        required: 'Bitte trage Deinen Namen ein.',
        minlength: jQuery.validator.format(
          'Es sind {0} Zeichen erforderlich!'
        ),
      },
      email: {
        required: 'Bitte trage Deine E-Mail-Adresse ein.',
        email:
          'Deine E-Mail-Adresse sollte folgendes Format haben: name@adresse.com',
      },
      comment: {
        required: 'Bitte schreibe einen Kommentar.',
        minlength: jQuery.validator.format(
          'Es sind {0} Zeichen erforderlich!'
        ),
      },
    },

    errorClass: 'invalid alert alert-warning',
    validClass: 'valid is-valid was-validated form-control:valid',

    success: function(label) {
      label.removeClass('is-invalid was-validated form-control:invalid');
    },

    highlight: function(element, errorClass) {
      $(element).addClass('is-invalid was-validated form-control:invalid');
    },

    errorElement: 'div',
    errorPlacement: function(error, element) {
      element.after(error);
    },
  });
}

$(document.body).on('click', '#commentform #submit', function(){
    webshapedValidateCommentForm();
});
    

/* =============================================================== *\ 
 	 GSAP Config 
\* =============================================================== */ 
gsap.config({
    nullTargetWarn: false,
});


    


/* =============================================================== *\ 

 	 Home einblenden
     @ page-template-three.js.php
     param $geladen = true 
\* =============================================================== */ 
  
let nIntervId;

function showHome() {
    if (!nIntervId) {
        nIntervId = setInterval(startHomeInterval, 1);
    }
}

function startHomeInterval() {

    /* =============================================================== *\ 
 	   Wenn $geladen undefiniert ist (== kein threejs vorhanden bei mobile) 
       oder dann geladen
       -> home elemente einblenden
    \* =============================================================== */ 

    if(typeof($papageien_laden_js)=="undefined"){
        $papageien_laden_js = false;
    }
    
    if(typeof($geladen)=="undefined"){
        $geladen = false;
    }

    if((($papageien_laden_js == true) &&( $geladen == true)) || ($papageien_laden_js == false)){

        gsap.to("#menu",{
            opacity:1,
        });
                
        gsap.set(".home #container",{
            opacity:1,
        });
        gsap.set(".home .colored_box_container", {
            opacity:0,
            y: 350,
        });
        
        gsap.to(".home .colored_box_container", {
            duration: 1.5, 
            y: 0,
            opacity: 1,
            ease: "elastic.out(1, 1)",
        });
        clearHomeInterval();
        
        gsap.registerPlugin(SplitText);
    	
        
        $myStart = "top 90%";
        $myEnd = "bottom 10%";
        $myMarkers = false;
        

        /* =============================================================== *\ 
           Text-Animation Group 
        \* =============================================================== */ 

        var group_childs = document.querySelectorAll(".animation_group > *");
        var i = 0;

        var anim = gsap.timeline({paused: true, repeat: -1, delay:0});
    
        for (let i = 0; i < group_childs.length; i++) {
        	var splitTextItem = new SplitText(group_childs[i], { type: "words,chars" });
        	var chars = splitTextItem.chars;
            var	words = splitTextItem.words; 

            anim.set(group_childs, { perspective: 400, autoAlpha: 1});	
            anim.set(group_childs[i], { display:"block" });
            anim.from(chars,{
                duration: 0.3,
                opacity: 0,
                scale: 0,
                y: 80,
                rotationX: 90,
                transformOrigin: "0% 50% -50",
                ease: "back",
                stagger: 0.1,
            })
            .to(chars,{
                delay:0.2,
                opacity: 1,
                rotationX: 0,
                scale:1,
                stagger: 0.05,
            });
            anim.set(group_childs[i], { autoAlpha: 0, display: "none", delay: 2 });
        }

        anim.play();
        
        
        

    	/* =============================================================== *\ 
     	   Text-Animation V1 
    	\* =============================================================== */ 
      
        $( ".animation_v1" ).each(function( index ) {

            /* =============================================================== *\ 
 	          Loop 
            \* =============================================================== */ 
            if($(this).hasClass("loop")==true){
                
                var	mySplitText = new SplitText($(this), { type: "words,chars" });
            	var	chars = mySplitText.chars; //an array of all the divs that wrap each character
            	var	words = mySplitText.words; //an array of all the divs that wrap each words
            	var numChars = mySplitText.chars.length;
                
                
                
                var timeline_01 = gsap.timeline({
                    //repeat:-1,
                    scrollTrigger: {
                        toggleActions: "play none none none",
                        trigger:$(this),
                        start: $myStart,
                        end: $myEnd,
                        markers: $myMarkers,
                    },	
                });
                
                timeline_01.set($(this), { perspective: 400, opacity:1 });	
                
                timeline_01.from(chars,{
                    duration: 0.2,
                    opacity: 0,
                    scale: 0,
                    y: 80,
                    rotationX: 90,
                    transformOrigin: "0% 50% -50",
                    ease: "back",
                    stagger: 0.1,
                })
                .to(chars,{
                    delay:0.2,
                    opacity: 1,
                    rotationX: 0,
                    scale:1,
                    stagger: 0.1,
                })
                

            /* =============================================================== *\ 
 	          ScrollInOut 
            \* =============================================================== */           
            } else if($(this).hasClass("scroll_in_out")==true){
                var	mySplitText = new SplitText($(this), { type: "words,chars" });
                var	chars = mySplitText.chars; //an array of all the divs that wrap each character
                var	words = mySplitText.words; //an array of all the divs that wrap each words
                var numChars = mySplitText.chars.length;
            
                var timeline_01 = gsap.timeline({
                    repeat:0,
                    scrollTrigger: {
                        toggleActions: 'restart reset resume reset',
                        trigger:$(this),
                        start: $myStart,
                        end: $myEnd,
                        markers: $myMarkers,
                    },	
                });
                
                timeline_01.set($(this), { perspective: 400, opacity:1 });	
                timeline_01.from(chars,{
                    duration: 0.2,
                    opacity: 0,
                    scale: 0,
                    y: 80,
                    rotationX: 90,
                    transformOrigin: "0% 50% -50",
                    ease: "back",
                    stagger: 0.1,
                })
                .to(chars,{
                    opacity: 1,
                    rotationX: 0,
                    scale:1,
                    stagger: 0.1,
                })
                
            /* =============================================================== *\ 
 	           Once 
            \* =============================================================== */ 
            }else{
                var	mySplitText = new SplitText($(this), { type: "words,chars" });
            	var	chars = mySplitText.chars; //an array of all the divs that wrap each character
            	var	words = mySplitText.words; //an array of all the divs that wrap each words
            	var numChars = mySplitText.chars.length;
                var timeline_01 = gsap.timeline({
                    paused:true,
                    repeat:0,            		
                    scrollTrigger: {
                        toggleActions: 'play none none none',
                        trigger:$(this),
                        start: $myStart,
                        end: $myEnd,
                        markers: $myMarkers,
                    },	
            	});
                            
                timeline_01.set($(this), { perspective: 400 });	
                timeline_01.from(chars,{
                    duration: 0.2,
                    opacity: 0,
                    scale: 0,
                    y: 80,
                    rotationX: 90,
                    transformOrigin: "0% 50% -50",
                    ease: "back",
                    stagger: 0.1,                    
                })
                .to(chars,{
                    opacity: 1,
                    rotationX: 0,
                    scale:1,
                    stagger: 0.1,
                    onComplete: myfunction,
                })
            } //if/else
        });
    	    	
    }
}
function myfunction(){
    
}
function clearHomeInterval() {
    clearInterval(nIntervId);
    nIntervId = null; 
}

showHome();


/* =============================================================== *\ 

 	 @ Single projekt 
     rotate Goodie-Icon
     show and hide Goodie-List
     
\* =============================================================== */ 

var goodie_container_icon = document.querySelector('.goodie_container_icon');
var goodie_container_list = document.querySelector(".goodie_container_list");

if(goodie_container_icon !== null){
    document.querySelector('.goodie_container_icon').addEventListener("click", function(){
        gsap.set(goodie_container_list, {display: "flex"}); // per css auf none
        document.querySelector('.goodie_container_list').classList.toggle("bounceOutRight"); //animate.css
        document.querySelector('.goodie_container_list').classList.toggle("bounceInRight");
    });

    // Rotieren
    var rotate = gsap.timeline({
      scrollTrigger:{
        trigger: "#wrapper",
        scrub:0.2,
        start: 'top bottom',
        end:'bottom bottom',
        markers:false,
        onUpdate: slideInOutClasses, // Funktionsaufruf 
      }
    })
    .to('.goodie_container_icon > .svg_container', {
      rotation:360*5,
      duration:1, ease:'none',
    });

    function slideInOutClasses(){
        document.querySelector('.goodie_container_list').classList.remove("bounceInRight");
        document.querySelector('.goodie_container_list').classList.add("bounceOutRight");
    }
}

/* =============================================================== *\ 
   @Schaufenster
   remove head and footer
   custom class: schaufenster_container
\* =============================================================== */ 
  
if($(".schaufenster_container").length ){
    $(".header-wrapper").css("opacity", "0");
    $("#footer").css("display", "none");
    $("body").css("cursor", "none");
}

/* =============================================================== *\ 
 	@CF7
    // Prevent repeated submission of the form
    https://www.birdhousewebsites.com/finally-a-solution-to-that-pesky-double-submission-on-contact-form-7/
\* =============================================================== */ 

$(".wpcf7").on('.wpcf7-submit', function(){
    if ($(".ajax-loader").hasClass("is-active")){
        $('input[type="submit"]').attr('disabled', 'disabled');
        setTimeout(function() {
             $('input[type="submit"]').removeAttr('disabled');
        },3000);
    }
});



});