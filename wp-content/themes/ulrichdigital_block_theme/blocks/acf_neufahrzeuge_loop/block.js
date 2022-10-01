/* =============================================================== *\ 

   Isotope with 
   - Range-Slider from Bootstrap 
   - Buttons (native)
   - Switches (native)
   
   This block requires the following JS files: 
      - jquery
      - assets/js/isotope.pkgd.js
      - assets/js/bootstrap.min.js
      - assets/js/bootstrap-slider.js
    
   For more information, see:
   -> https://codepen.io/lifeonlars/pen/yaaOey
   
\* =============================================================== */ 
  
jQuery(document).ready( function($) {
	 
/* =============================================================== *\ 
   Filters 
   Isotope-Fitler width:
   - Bootstrap-Sliders
   - Button-Filter
   - Switches
   
   Wichtige Funktionen
   reinit_slick() 
\* =============================================================== */ 

/*
$("div").on("click", function(){
    console.log(buttonFilters);
});
*/

// Create object to store filter for each group
var buttonFilters = {};
var buttonFilter = '*';
//var $buttonGroup_new 
// Create new object for the range filters and set default values,
// The default values should correspond to the default values from the slider
var rangeFilters = {
	'preis' : {'min':0, 'max': 100000},
	'hubraum' : {'min':0, 'max': 10000},
    'leistung-min' : {'min':0, 'max': 10000},
    'leistung-max' : {'min':0, 'max': 10000},
    'leistung' : {'min':0, 'max' : 100000}
};

$(".grid").css('opacity', '1');


/* =============================================================== *\ 
   Isotope 
\* =============================================================== */ 
var $grid = $('.grid').isotope({
	itemSelector: '.item',
	masonry: {
	  columnWidth: '.grid_sizer',
	  gutter: '.gutter_sizer'
	},
	filter: function() {
		var $this = $(this);
	
		// preis
		var preis = $this.attr('data-preis');
		var isInpreisRange = (rangeFilters['preis'].min <= preis && rangeFilters['preis'].max >= preis);

		// Hubraum 
		var hubraum = $this.attr('data-hubraum');
		var isInHubraumRange = (rangeFilters['hubraum'].min <= hubraum && rangeFilters['hubraum'].max >= hubraum);

        // leistung
        var leistung_min = $this.attr('data-leistung-min');
        var leistung_max = $this.attr('data-leistung-max');
        var isInLeistungRange = ((rangeFilters['leistung'].min <= leistung_min ||(rangeFilters['leistung'].min <= leistung_max)) && (rangeFilters['leistung'].max >= leistung_max || rangeFilters['leistung'].max >= leistung_min));

        return $this.is( buttonFilter ) && (isInpreisRange && isInHubraumRange && isInLeistungRange);
	}
});

// Rearrange Isotope on load and window resize 
$(window).on("resize load",function(event){
	$grid.isotope();
}).resize(function(){});


/* =============================================================== *\ 
   Sliders 
\* =============================================================== */ 
  
// Set min/max range on sliders as well as default values

//Preis
var $my_min_preis = $(".my_min_preis").html();
var $my_max_preis = $(".my_max_preis").html();
$my_min_preis = parseInt($my_min_preis);
$my_max_preis = parseInt($my_max_preis);
var $preisSlider = $('#filter-preis').bootstrapSlider({ tooltip_split: true, min: $my_min_preis,  max: $my_max_preis, range: true, value: [$my_min_preis, $my_max_preis] });

//Hubraum
var $my_min_hubraum = $(".my_min_hubraum").html();
var $my_max_hubraum = $(".my_max_hubraum").html();
$my_min_hubraum = parseInt($my_min_hubraum);
$my_max_hubraum = parseInt($my_max_hubraum);
var $hubraumSlider = $('#filter-hubraum').bootstrapSlider({ tooltip_split: true, min: $my_min_hubraum,  max: $my_max_hubraum, range: true, value: [$my_min_hubraum, $my_max_hubraum] });

//Leistung
var $my_min_leistung = $(".my_min_leistung").html();
var $my_max_leistung = $(".my_max_leistung").html();
$my_min_leistung = parseInt($my_min_leistung);
$my_max_leistung = parseInt($my_max_leistung);
var $leistungSlider = $('#filter-leistung').bootstrapSlider({ tooltip_split: true, min: $my_min_leistung,  max: $my_max_leistung, range: true, value: [$my_min_leistung, $my_max_leistung] });

function updateRangeSlider(bootstrapSlider, slideEvt) {
	var sldmin = +slideEvt.value[0],
	sldmax = +slideEvt.value[1],
	filterGroup = bootstrapSlider.attr('data-filter-group'),
	currentSelection = sldmin + ' bis ' + sldmax;

	if(filterGroup == "preis"){
		my_min = sldmin + ' CHF';
		my_max = sldmax + ' CHF';
	}else if(filterGroup == "leistung"){
		my_min = sldmin + ' kW';
		my_max = sldmax + ' kW';
	}else if(filterGroup == "hubraum"){
		my_min = sldmin + ' ccm';
		my_max = sldmax + ' ccm';
	}

	// Update filter label with new range selection
	bootstrapSlider.siblings('.min_max').find(".filter-min").text(my_min);
	bootstrapSlider.siblings('.min_max').find(".filter-max").text(my_max);

	rangeFilters[filterGroup] = {
		min: sldmin || 0,
		max: sldmax || 100000
	};

	$grid.isotope();
    if($grid.data('isotope').filteredItems == 0){
        $(".neufahrzeuge_loop").find(".no_results").removeClass("hide");
    }else{
        $(".neufahrzeuge_loop").find(".no_results").addClass("hide");
    }
} // end updateRangeSlider

// Trigger Isotope Filter when slider drag has stopped
$preisSlider.on('slideStop', function(slideEvt){
	var $this = $(this);
	updateRangeSlider($this, slideEvt);
	nach_update_slider_ausblenden($this);
});

$hubraumSlider.on('slideStop', function(slideEvt){
	var $this = $(this);
	updateRangeSlider($this, slideEvt);
	nach_update_slider_ausblenden($this);
});

$leistungSlider.on('slideStop', function(slideEvt){
	var $this = $(this);
	updateRangeSlider($this, slideEvt);
	nach_update_slider_ausblenden($this);
});


/* =============================================================== *\ 

 	 Filter-Buttons 

\* =============================================================== */ 
  
// Look inside element with .filters class for any clicks on elements with .filter_button
$('.filters').on( 'click', '.filter_button', function() {
	var $this = $(this);
	var $buttonGroup = $this.parents('.filter_content');
	var filterGroup = $buttonGroup.attr('data-filter-group');
    
    
    $my_color_filter = $(this).attr("data-filter");
    
    $(this).closest(".single_filter").attr("data-color-filter", $this.attr('data-filter'));
    
    // Wenn bei Farben geklickt wird + der An-Lager-Switch auf ON ist, dann dem Suchstring _instock anhängen
    if(filterGroup == "color-kategorie"){
        if($(".single_switch.in_stock").find(".filter_content").hasClass("checked")){
            buttonFilters[ filterGroup ] = $this.attr('data-filter') + "_instock";
        }else{
            buttonFilters[ filterGroup ] = $this.attr('data-filter');
        }
    }else{
        buttonFilters[ filterGroup ] = $this.attr('data-filter');
    }

	buttonFilter = concatValues( buttonFilters ) || '*';
	
    
    $grid.isotope();
    reinit_slick();

    if($grid.data('isotope').filteredItems == 0){
        $(".neufahrzeuge_loop").find(".no_results").removeClass("hide");
    }else{
        $(".neufahrzeuge_loop").find(".no_results").addClass("hide");
    }
});

// Toggle .is-checked on .filter_button
$('.buttons_container .filter_content').each( function( i, buttonGroup ) {
    //removeInStock()
	var $buttonGroup = $( buttonGroup );
	$buttonGroup.on( 'click', '.filter_button', function() {
		$buttonGroup.find('.is-checked').removeClass('is-checked');
		$(this).addClass('is-checked');
	});
});

function removeInStock(){
    if($(".single_switch.in_stock").find(".filter_content").hasClass("checked")){
        
    }else{
        $(".single_switch.in_stock").find(".switch_button_container").attr("data-filter", ".in_stock");
    }
};


function slider_ein_ausblenden($this){
	var ein_ausblenden = "false";
	// Wenn .filter_label.current_filter + xmark css.block = ausblenden
	// Wenn .filter_label.open + xmark css.block = ausblenden
	// Wenn .filter_label.open + xmark css.none = ausblenden		
	// Wenn .filter_label:not.open + xmark css.none = einblenden
	// Wenn .filter_label:not.open + xmark css.block = ausblenden
	
	$filter_label_container = $this.closest(".filter_label_container");	
	$filter_label_container.closest(".bootstrap-slider").toggleClass("open");
	
	if(ein_ausblenden == "ausblenden"){
		$filter_label_container.closest('.bootstrap-slider').find('.filter_drop_down').addClass('hidden');

	}else if(ein_ausblenden == "einblenden"){
		$filter_label_container.closest('.bootstrap-slider').find('.filter_drop_down').removeClass('hidden');
	}
}

function nach_update_slider_ausblenden($this){
	$this.closest(".filter_drop_down").closest(".bootstrap-slider").removeClass("open");
}

function buttons_ein_ausblenden($this){
	var ein_ausblenden = "false";
	$filter_label_container = $this.closest(".filter_label_container");	
	$filter_label_container.closest(".single_filter").toggleClass("open");
	
	if(ein_ausblenden == "ausblenden"){
		$filter_label_container.closest('.single_filter').find('.filter_drop_down').addClass('hidden');

	}else if(ein_ausblenden == "einblenden"){
		$filter_label_container.closest('.single_filter').find('.filter_drop_down').removeClass('hidden');
	}	
}

// Slider: toggle .open on .single_filter
$(".bootstrap-slider .filter_label").on("click", function(){
	$current_single_filter = $(this).closest(".single_filter");
	$(".sliders_container, .buttons_container").find(".single_filter").not($current_single_filter).removeClass("open");	
	$(this).closest(".single_filter").toggleClass("open");
});

// Button: toggle .open on .single_filter
$(".buttons_container .single_filter .filter_label").on("click", function(){
	$current_single_filter = $(this).closest(".single_filter");
	$(".buttons_container, .sliders_container").find(".single_filter").not($current_single_filter).removeClass("open");	
	$(this).closest(".single_filter").toggleClass("open");
});

// Slider: Remove Filter 
$(".bootstrap-slider .fa-circle-xmark").on("click", function(){
	$this = $(this);
	slider_filter_loeschen($this);
});

// Button: Remove Filter 
$(".single_filter .fa-circle-xmark").on("click", function(){
	$this = $(this);
	button_filter_loeschen($this);
});



// Button: Close DropDown when button was clicked
$(".filter_button").on("click", function(){	
	$(this).closest(".single_filter").removeClass("open");
	$(this).closest(".single_filter").find(".filter_label_container").addClass("current_filter");
	$new_label_text = $(this).data("filter-text");
	$(this).closest(".single_filter").find(".label_text").text($new_label_text);
});

function slider_filter_loeschen($this){
	var $global_label_text = $this.closest(".bootstrap-slider").find("input.bootstrap-slider").data("filter-group");
	var $this_bootstrap_slider = $this.closest(".bootstrap-slider");

	$this_bootstrap_slider.removeClass("open");
	$this_bootstrap_slider.find(".label_text").html($global_label_text);
	$this_bootstrap_slider.find(".filter_label_container").removeClass("current_filter");	

	//  Globalen Min- + Max-Werte holen
	var $my_min = parseInt($this.closest(".single_filter").find(".slider-handle").attr('aria-valuemin'));
	var $my_max = parseInt($this.closest(".single_filter").find(".slider-handle").attr('aria-valuemax'));

	var mySlider = $this_bootstrap_slider.find('input.bootstrap-slider').bootstrapSlider();
	mySlider.bootstrapSlider('setValue', [$my_min, $my_max]);

	// Update the Slider
	var slideEvt2 = {value : [$my_min, $my_max]};
	var $this_input = $this_bootstrap_slider.find("input.bootstrap-slider");
	updateRangeSlider($this_input, slideEvt2);
}

function button_filter_loeschen($this){
	$label_text = $this.closest(".single_filter").find(".label_text").data("label_text");
	$this.closest(".single_filter").find(".label_text").text($label_text);
	$this.closest(".single_filter").removeClass("open");
	$this.closest(".single_filter").find(".filter_label_container").removeClass("current_filter");
	$this.closest(".single_filter").find(".filter_button").removeClass("is-checked");
    $this.closest(".single_filter").attr("data-color-filter", "");
        
    
    
	var $buttonGroup = $this.closest(".single_filter").find(".filter_content");
	var filterGroup = $buttonGroup.attr('data-filter-group');
	buttonFilters[ filterGroup ] = '*';
	buttonFilter = concatValues( buttonFilters ) || '*';
	$grid.isotope();
    if($grid.data('isotope').filteredItems == 0){
        $(".neufahrzeuge_loop").find(".no_results").removeClass("hide");
    }else{
        $(".neufahrzeuge_loop").find(".no_results").addClass("hide");
    }
    // Wenn 
    $filter = ""
    if($this.closest(".single_filter").hasClass("colors")){
        $filter = "colors";
    }
    reinit_slick($filter);
}

/* =============================================================== *\ 
   Slider: Slide-Stop handle 
\* =============================================================== */ 
$('input.bootstrap-slider').on('slideStop', function(val) {
	var $global_label_text = $(this).data("filter-group");
	var $current_leistung_min = val.value[0];
	var $current_leistung_max = val.value[1];
    
    $current_leistung_min_html = tausender_trennzeichen($current_leistung_min);
    $current_leistung_max_html = tausender_trennzeichen($current_leistung_max);
	
    var $global_leistung_min = $(this).closest(".filter_content").find(".slider-handle").attr('aria-valuemin');
	var $global_leistung_max = $(this).closest(".filter_content").find(".slider-handle").attr('aria-valuemax');

	var $data_filter_group = $(this).data("filter-group");
	var my_masseinheit = "";
	if($data_filter_group == "preis"){
	 my_masseinheit = ' CHF';
	}else if($data_filter_group == "leistung"){
		my_masseinheit = ' kW';
	}else if($data_filter_group == "hubraum"){
		my_masseinheit = ' ccm';
	}
	
	if(($global_leistung_min != $current_leistung_min)||($current_leistung_max != $global_leistung_max)){
		$(this).closest(".single_filter").find(".filter_label_container").addClass('current_filter');
		$(this).closest(".single_filter").find(".label_text").html($current_leistung_min_html + " – " + $current_leistung_max_html + my_masseinheit);
	}
});




/* =============================================================== *\ 
 	 
   Switches
    
\* =============================================================== */ 
$(".switch").on("click", ".toggle", function(){
    if($(this).closest(".filter_content").hasClass("checked") ){
        $(this).closest(".filter_content").removeClass("checked");
    }else{
        $(this).closest(".filter_content").addClass("checked");
    }
    
    var $this = $(this).closest(".switch_button_container");
    var $buttonGroup = $this.parents('.filter_content');
    var filterGroup = $buttonGroup.attr('data-filter-group');
    
    if (filterGroup in buttonFilters){
        delete buttonFilters[ filterGroup ];
    }else{
        buttonFilters[ filterGroup ] = $this.attr('data-filter');
    }

    // Gewählte Farbe
    //var $gewahlte_farbe = $(".single_filter.colors").attr('data-color-filter');
//console.log($gewahlte_farbe);
    //switch einschalten
    if($(".single_switch.in_stock").find(".filter_content").hasClass("checked") ){
        if($(".single_filter.colors").attr('data-color-filter')!=""){
            buttonFilters["color-kategorie"] = $(".single_filter.colors").attr("data-color-filter") + "_instock";
        }else{
            delete buttonFilters["color-kategorie"];
        }
    
    //switch ausschalten
    }else{
        if($(".single_filter.colors").attr('data-color-filter')!=""){
        
        if(buttonFilters["color-kategorie"]!=""){
            var $my_color = buttonFilters["color-kategorie"];
            if($my_color!=undefined){
                if($my_color.indexOf("_instock")!=undefined){
                    if ($my_color.indexOf("_instock") >= 0){
                        $my_color = $my_color.replace("_instock", "");
                        buttonFilters['color-kategorie'] = $my_color;
                    }
                }
            }
        }
    }
    }
 
 	buttonFilter = concatValues( buttonFilters ) || '*';
    $grid.isotope();
    reinit_slick();
      
    if($grid.data('isotope').filteredItems == 0){
        $(".neufahrzeuge_loop").find(".no_results").removeClass("hide");
    }else{
        $(".neufahrzeuge_loop").find(".no_results").addClass("hide");
    }
 });
 



/* =============================================================== *\ 
   
   Slick-Slider
   - neufahrzeug_card
   
\* =============================================================== */ 

var slickIsLoaded = false;
if(typeof $.fn.slick == "function"){
	slickIsLoaded = true;
};

function waitForElm(selector) {
	return new Promise(resolve => {
		if (document.querySelector(selector)) {
			return resolve(document.querySelector(selector));
		}
		const observer = new MutationObserver(mutations => {
			if (document.querySelector(selector)) {
				resolve(document.querySelector(selector));
				observer.disconnect();
			}
		});
		observer.observe(document.body, {
			childList: true,
			subtree: true
		});
	});
}

// dynamische Anzahl slidesToShow
// max 3, wenn weniger, dann weniger
  
  
if (slickIsLoaded){	
	waitForElm('.slick_card_slider').then((elm) => {
		$('.slick_card_slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			//lazyload: "ondemand",
			adaptiveHeight: false,
			variableWidth: false,
			dots: false,
			infinite: true,
			speed: 300,
			centerMode: false,
			prevArrow:'<div class="slick_left"><i class="a-left control-c prev slick-prev fa-solid fa-chevron-left"></i></div>',
			nextArrow:'<div class="slick_right"><i class="a-right control-c next slick-next fa-solid fa-chevron-right"></i></div>'
		});	
	});	
} // if(slickIsLoaded)


/* =============================================================== *\ 

 	 Bilder bei Slickslider herausfiltern 

\* =============================================================== */ 

// ist inLager-Switch per default gesetzt
var inStockisChecked = true;
if($(".single_switch.in_stock").find("input").is(":checked")){
    inStockisChecked = true;
}else{
    inStockisChecked = false;
}

if (slickIsLoaded){	
	waitForElm('.slick_card_slider').then((elm) => {
        if(inStockisChecked == true){        
            $(".neufahrzeuge_container").addClass("switch_in_stock_checked");
            //$(".single_switch.in_stock").find(".switch_label_text").text("An Lager");
            $('.neufahrzeug_card').each(function(index){
                $(this).find('.slick_card_slider').slick('slickFilter',':not(.not_in_stock)');
            });
        }else{
            //$(".single_switch.in_stock").find(".switch_label_text").text("Alle Fahrzeuge");
            
        }
	});	
} // if(slickIsLoaded)


/*
var filtered = false;
$(".single_switch.in_stock").on("click", ".toggle", function(){
    /*
    // bei jedem click inStockisChecked status ändern
    if($(".single_switch.in_stock").find("input").is(":checked")){
        inStockisChecked = false; // sieht unlogisch aus, stimmt aber
    }else{
        inStockisChecked = true;
    }    
    
    if(inStockisChecked == true){  
        $(".neufahrzeuge_container").addClass("switch_in_stock_checked");
        //$(".single_switch.in_stock").find(".switch_label_text").text("An Lager");
        $('.neufahrzeug_card').each(function(index){
            $(this).find('.slick_card_slider').slick('slickFilter',':not(.not_in_stock)');
        });
    }else{
        $(".neufahrzeuge_container").removeClass("switch_in_stock_checked");
        //$(".single_switch.in_stock").find(".switch_label_text").text("Alle Fahrzeuge");
        $('.neufahrzeug_card').each(function(index){
            $(this).find('.slick_card_slider').slick('slickUnfilter');
        });
    }

});
*/
/* =============================================================== *\ 
   Properties-List: Color as Navigation for Slick-Slide
\* =============================================================== */ 
var resumeIndex;
$(".neufahrzeug_properties_list .color").on("click", function() {
    $(this).closest(".neufahrzeug_properties_list").find(".color").removeClass("active");
    $(this).addClass("active");
    var $card_slider = $(this).closest(".neufahrzeug_card").find(".slick-slider");
    resumeIndex = $card_slider.slick("getSlick").currentSlide;
    var artworkId = $(this).data("color-nav");
    var artIndex = $card_slider.find("[data-color="+artworkId+"]").closest(".slick-slide").data("slick-index");
    $card_slider.slick("pause").slick("slickGoTo", artIndex);
});

/* =============================================================== *\ 
   Add .active to all first Color-Nav-Chips 
\* =============================================================== */ 
$(".neufahrzeuge_container").find(".neufahrzeug_card").each(function(){
    $(this).find("li.color").first().addClass("active");
});



/* =============================================================== *\ 

 	 Filter:
     > Color-Button 
     > When clicking the color button
     > the Slick-Slider should show the Image with the selected color
     > the corresponding Color-Nav-Chip should have the Class .active

\* =============================================================== */ 
// Button
//data-filter-text
// Gross geschrieben mit Leerzeichen

// Image 
// data-color
// klein geschrieben, aneinander

// Chips
// data-color-nav
// klein geschrieben, aneinander

$('.filters').on( 'click', '.filter_button', function() {
    var $this = $(this);
	var $buttonGroup = $this.parents('.filter_content');
	var filterGroup = $buttonGroup.attr('data-filter-group');
    var $current_color = "";
    if(filterGroup=="color-kategorie"){
        $current_button_color = $(this).data("filter-text");
        $current_button_color = $current_button_color.replace(" ", "").toLowerCase();

        $(".neufahrzeuge_container").find(".neufahrzeug_card").each(function(){
            $(this).find(".slick-slide:not(.slick-cloned) a").each(function(){
                $current_slide_color = $(this).attr('data-color');
                if($current_button_color == $current_slide_color){
                    $current_slick_index = $(this).closest(".slick-slide").data("slick-index");
                    $(this).closest(".slick_card_slider").slick("slickGoTo", $current_slick_index, false);
                }    
            });
            $(this).find("li.color").each(function(){
                $(this).removeClass("active");
                $current_color_nav = $(this).attr("data-color-nav");
                if($current_button_color == $current_color_nav){
                    $(this).addClass("active");
                }
            });
        });
    }
});

function reinit_slick($filter){
    $(".slick_card_slider").each(function(){
        var currentSlide = $(this).slick('slickCurrentSlide');
        
        /*
        Wenn Farben-Filter gelöscht wird, 
        SlickSliders auf Index 0
        Color-Chips Klassen anpassen
        */
        if($filter=="colors"){
            currentSlide = 0;
            $(".neufahrzeuge_container").find(".neufahrzeug_card").each(function(){            
                $(this).find("li.color").removeClass("active");
                $(this).find("li.color").first().addClass("active");
            });
        }

        $(this).slick('destroy').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            initialSlide: currentSlide,
            //lazyload: "ondemand",
            adaptiveHeight: false,
            variableWidth: false,
            dots: false,
            infinite: true,
            speed: 300,
            centerMode: false,
            prevArrow:'<div class="slick_left"><i class="a-left control-c prev slick-prev fa-solid fa-chevron-left"></i></div>',
            nextArrow:'<div class="slick_right"><i class="a-right control-c next slick-next fa-solid fa-chevron-right"></i></div>'
        });
    });    
}


/* =============================================================== *\ 
   Tausender-Trennzeichen 
\* =============================================================== */ 
function tausender_trennzeichen(number) {
    number = '' + number;
    if (number.length > 3) {
        var mod = number.length % 3;
        var output = (mod > 0 ? (number.substring(0,mod)) : '');
        for (i=0 ; i < Math.floor(number.length / 3); i++) {
            if ((mod == 0) && (i == 0)){
            output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
        }else{
            output+= "'" + number.substring(mod + 3 * i, mod + 3 * i + 3);
            }
        }
        return (output);
    }
    else return number;
}

}); // jQuery(document).ready( function($) {

// Flatten object by concatting values
function concatValues( obj ) {
	var value = '';
  	for ( var prop in obj ) {
    	value += obj[ prop ];
  	}
  	return value;
}