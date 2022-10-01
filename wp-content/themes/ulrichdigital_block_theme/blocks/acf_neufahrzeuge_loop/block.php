<?php 
/* =============================================================== *\ 

 	 Neufahrzeuge-Loop 
	 
	 Isotope with Range-Slider (Bootstrap) and Buttons (native)
	 This block requires the following JS files: 
	 	- jquery
		- assets/js/isotope.pkgd.js
		- assets/js/bootstrap.min.js
		- assets/js/bootstrap-slider.js
		
	 -> https://codepen.io/lifeonlars/pen/yaaOey
	 
\* =============================================================== */ 

$args = array(
	'post_type'              => array( 'neufahrzeug' ),
	'posts_per_page'         => '-1',
    'post_status' => 'publish', 
    'orderby' => 'menu_order', 
    'order' => 'ASC', 
);

$neufahrzeuge = new WP_Query( $args );


/* =============================================================== *\ 
 	 
	 Populate Filters
	 First go through all the posts and get the properties for the filters
	 
\* =============================================================== */ 
if ( $neufahrzeuge->have_posts() ): 
	$hubraum_html = "";
	$y_kat_arr = array();
	$hubraum_arr = array();
	$leistung_arr = array();
	$leistung_gedrosselt_arr = array();
	
	$leistung_min_arr = array();
	$leistung_max_arr = array();
	
	$preis_arr = array();
	$ausweis_arr = array();
	$color_arr = array();
	
	
	$in_stock = false;
	$e_bike = false;
	$teeny_bike_15 = false;
	$teeny_bike_16 = false;
	
	while ( $neufahrzeuge->have_posts() ):
		$neufahrzeuge->the_post();

		$blocks = parse_blocks(get_the_content());
		foreach($blocks as $block):
			
			// Hack:
			if(!array_key_exists('id', $block)):
				$block['id'] = 1;
				if(array_key_exists('id', $block['attrs'])):
					$block['id'] = $block['attrs']['id'];
				endif;
			endif;
			
			/* =============================================================== *\ 
			   Colors
			   in Stock
			\* =============================================================== */ 
			if("acf/model-images" == $block['blockName']):
				$post_id = get_the_ID();
				$acf_colors_instock = get_acf_block_repeater_with_id("acf/model-images", "modell_bilder", array("bild", "farbe", "an_lager"), $post_id);	
				foreach($acf_colors_instock as $single_colors_instock):
					
					//Colors
					$my_color = "";
					if(isset($single_colors_instock['farbe'])):
						$my_color = $single_colors_instock['farbe'];
						if(!empty($my_color)):
							array_push($color_arr, $my_color);	
						endif;
					endif;
					
					//inStock
					if(isset($single_colors_instock['an_lager'])):
						if($single_colors_instock['an_lager'] == 1):
							$in_stock = true;
						endif;
					endif;

				endforeach;
			endif;						
			
			/* =============================================================== *\ 
 	 		   Properties 
			\* =============================================================== */ 
			if("acf/neufahrzeug-short-card" == $block['blockName']):
				/* =============================================================== *\ 
 	 			   Yamaha-Kategorie 
				\* =============================================================== */ 
                if(isset($block['attrs']['data']['y_kategorie'])):
                    array_push($y_kat_arr, $block['attrs']['data']['y_kategorie']);		
					/*if(""== $block['attrs']['data']['y_kategorie']):
						echo get_the_title(get_the_ID());
						echo "<br/>";
					endif;*/		
                endif;

  				/* =============================================================== *\ 
	 			   Ausweiskategorie 
  		   		\* =============================================================== */ 
				if(isset($block['attrs']['data']['ausweiskategorie'])):
					array_push($ausweis_arr, $block['attrs']['data']['ausweiskategorie']);				
				endif;
				
				/* =============================================================== *\ 
				   Zusätzliche Ausweiskategorie 
				\* =============================================================== */ 
				if(isset($block['attrs']['data']['zusatzliche_ausweiskategorie'])):
					if($block['attrs']['data']['zusatzliche_ausweiskategorie']!=""):
						$zusatzliche_ausweiskategorien = $block['attrs']['data']['zusatzliche_ausweiskategorie'];
						foreach($zusatzliche_ausweiskategorien as $item):
							array_push($ausweis_arr, $item);				
						endforeach;
					endif;
				endif;
				
				/* =============================================================== *\ 
 	 			   Slider - Filter
				\* =============================================================== */ 
				// Preis
				if(isset($block['attrs']['data']['preis'])):
					$preis = $block['attrs']['data']['preis'];
					$preis = intval($preis);
					array_push($preis_arr, $preis);  
				endif;

				// Hubraum 
				if(isset($block['attrs']['data']['hubraum'])):
					$hubraum = $block['attrs']['data']['hubraum'];
					$hubraum = intval($hubraum);
					array_push($hubraum_arr, $hubraum);  
				endif;

				//Leistung 
				if(isset($block['attrs']['data']['leistung'])):
					$leistung = $block['attrs']['data']['leistung'];
					$leistung = intval($leistung);
					array_push($leistung_arr, $leistung);
				endif;
					
				// Leistung min und max
				// Leistung max
				if(isset($block['attrs']['data']['leistung'])):
					$leistung = $block['attrs']['data']['leistung'];
					$leistung = intval($leistung);
					array_push($leistung_max_arr, $leistung);
				endif;
				
				if(isset($block['attrs']['data']['gedrosselte_leistung'])):
					$leistung = $block['attrs']['data']['gedrosselte_leistung'];
					$leistung = intval($leistung);
					array_push($leistung_max_arr, $leistung);
				endif;
				
				 // Leistung min
				if(isset($block['attrs']['data']['leistung'])):
					$leistung = $block['attrs']['data']['leistung'];
					$leistung = intval($leistung);
					array_push($leistung_min_arr, $leistung);
				endif;
				
				if(isset($block['attrs']['data']['gedrosselte_leistung'])):
					$leistung = $block['attrs']['data']['gedrosselte_leistung'];
					$leistung = intval($leistung);
					array_push($leistung_min_arr, $leistung);
				endif;
				
				
				/* =============================================================== *\ 
 	 			   Switches 
				\* =============================================================== */ 
				// An Lager
				// See above, in acf/model-images
		
			
				// E-Mobility
				if(isset($block['attrs']['data']['e_bike'])):
					if($block['attrs']['data']['e_bike']!=0):
						$e_bike = true;
					endif;
				endif;

				// Ab 15 Jahren
				if(isset($block['attrs']['data']['ab_15_jahren'])):
					if($block['attrs']['data']['ab_15_jahren']!=0):
						$teeny_bike_15 = true;
					endif;
				endif;
				
				// Ab 16 Jahren
				if(isset($block['attrs']['data']['ab_16_jahren'])):
					if($block['attrs']['data']['ab_16_jahren']!=0):
						$teeny_bike_16 = true;
					endif;
				endif;
			endif; // if("acf/neufahrzeug-short-card" == $block['blockName']):
	
		endforeach;

	endwhile;

	/* =============================================================== *\ 
	   	   Schema: Filter-HTML-Output
	\* =============================================================== */ 
	/*
	filters-section 							=> Filters und der zu filtende Inhalt
		filter_container						=> Die Slider- und Buttons-Filter
			
			sliders_container					=> Die Slider-Filter
				single_filter	
					bootstrap-slider
						filter_label_container
						filter_content filter_drop_down
							
			buttons_container					=> Die Button-Filter
				single_filter			
					filter_label_container
					filter_content filter_drop_down 	
	*/
	?>

	<section class="container neufahrzeuge_loop">
		<div class="filters filter-section">
			
			<h2 style="display:none">Filter</h2>
			<div class="filter_container">
				<div class="sliders_container">
					<?php
					/* =============================================================== *\ 
	 	 			   Slider 
					\* =============================================================== */ 
			
				
					// Preis
					$preis_arr = array_unique($preis_arr);
					$preis_min = min($preis_arr);
					$preis_max = max($preis_arr);
					
					$preis_slider = '';
					$preis_slider .= '<div class="single_filter">';
					$preis_slider .= '<span style="visibility:hidden; display:none;" class="my_min_preis">' . $preis_min. '</span>';
					$preis_slider .= '<span style="visibility:hidden; display:none;" class="my_max_preis">' . $preis_max. '</span>';
					$preis_slider .= '<div class="bootstrap-slider">';
					
					$preis_slider .= '<div class="filter_label_container">';
					$preis_slider .= '<div class="filter_label"><span class="label_text">Preis</span><i class="fa-solid fa-angle-right"></i> </div>';
					$preis_slider .= '<i class="fa-solid fa-circle-xmark"></i>';
					$preis_slider .= '</div>'; // .filter_label_container
					
					$preis_slider .= '<div class="filter_content filter_drop_down"><input id="filter-preis" type="text" class="bootstrap-slider" value="" data-filter-group="preis"><div class="min_max"><div class="filter-min">' . $preis_min . ' CHF</div> <div class="filter-max">' . $preis_max . ' CHF</div></div></div>';
					$preis_slider .= '</div>'; //.bootstrap-slider
					$preis_slider .= '</div>'; // .single_slider
					
					echo $preis_slider;


					// Hubraum
					$hubraum_arr = array_unique($hubraum_arr);
					$hubraum_min = min($hubraum_arr);
					$hubraum_max = max($hubraum_arr);
					
					$hubraum_slider = '';
					$hubraum_slider .= '<div class="single_filter">';
					$hubraum_slider .= '<span style="visibility:hidden; display:none;" class="my_min_hubraum">' . $hubraum_min . '</span>';
					$hubraum_slider .= '<span style="visibility:hidden; display:none;" class="my_max_hubraum">' . $hubraum_max . '</span>';
					$hubraum_slider .= '<div class="bootstrap-slider">';
					
					$hubraum_slider .= '<div class="filter_label_container">';
					$hubraum_slider .= '<div class="filter_label"><span class="label_text">Hubraum</span><i class="fa-solid fa-angle-right"></i> </div>';
					$hubraum_slider .= '<i class="fa-solid fa-circle-xmark"></i>';
					$hubraum_slider .= '</div>'; // .filter_label_container
					
					$hubraum_slider .= '<div class="filter_content filter_drop_down"><input id="filter-hubraum" type="text" class="bootstrap-slider" value="" data-filter-group="hubraum"><div class="min_max"><div class="filter-min">' . $hubraum_min . 'ccm</div><div class="filter-max">' . $hubraum_max . 'ccm</div></div></div>';
					$hubraum_slider .= '</div>';
					$hubraum_slider .= '</div>'; // .single_sliderrow
					
					echo $hubraum_slider;


					// Leistung
					$leistung_max_arr = array_unique($leistung_max_arr);			
					$leistung_min_arr = array_unique($leistung_min_arr);			

					$leistung_min = min($leistung_min_arr);
					$leistung_max = max($leistung_max_arr);
					
					$leistung_slider = '';
					$leistung_slider .= '<div class="single_filter">';
					$leistung_slider .= '<span style="visibility:hidden; display:none;" class="my_min_leistung">' . $leistung_min . '</span>';
					$leistung_slider .= '<span style="visibility:hidden; display:none;" class="my_max_leistung">' . $leistung_max . '</span>';
					$leistung_slider .= '<div class="bootstrap-slider">';
					
					$leistung_slider .= '<div class="filter_label_container">';
					$leistung_slider .= '<div class="filter_label"><span class="label_text">Leistung</span><i class="fa-solid fa-angle-right"></i> </div>';
					$leistung_slider .= '<i class="fa-solid fa-circle-xmark"></i>';
					$leistung_slider .= '</div>'; // .filter_label_container
					
					$leistung_slider .= '<div class="filter_content filter_drop_down"><input id="filter-leistung" type="text" class="bootstrap-slider" value="" data-filter-group="leistung"><div class="min_max"><div class="filter-min">' . $leistung_min . 'kW</div><div class="filter-max">' . $leistung_max . 'kW</div></div></div>';
					$leistung_slider .= '</div>';
					$leistung_slider .= '</div>'; // .single_slider
					
					echo $leistung_slider; ?>
				</div>
				
				<div class="buttons_container"> 
					<?php
					/* =============================================================== *\ 
					   Buttons 
					\* =============================================================== */ 
			
					/* =============================================================== *\ 
					   Buttons: Yamaha-Kategorie 
					\* =============================================================== */ 
					$y_kat_arr = array_unique($y_kat_arr);
					$y_kat_buttons = '';
					$y_kat_buttons .= '<div class="single_filter">';
					
					$y_kat_buttons .= '<div class="filter_label_container">';
					$y_kat_buttons .= '<div class="filter_label"><span class="label_text" data-label_text="Kategorie">Kategorie</span><i class="fa-solid fa-angle-right"></i> </div>';
					$y_kat_buttons .= '<i class="fa-solid fa-circle-xmark"></i>';
					$y_kat_buttons .= '</div>'; // .filter_label_container
										
					$y_kat_buttons .= '<div class="filter_content filter_drop_down" role="group" data-filter-group="y-cat">';
					//$y_kat_buttons .= '<span class="btn btn-sm btn-default btn-filter is-checked" data-filter="">Alle</span>';

					foreach($y_kat_arr as $item):						
						$y_kat_buttons .= '<span class="filter_button" data-filter-text="' . ucfirst($item) . '" data-filter=".' . $item . '">' . $item . '</span>';
					endforeach;
		
					$y_kat_buttons .= '</div>'; // div.btn-group
					$y_kat_buttons .= '</div>'; // .filter_buttons
					echo $y_kat_buttons;
					
					
					/* =============================================================== *\ 
					   Buttons: Ausweiskategorie 
					\* =============================================================== */ 
					$ausweis_arr = array_unique($ausweis_arr);
					$ausweis_buttons = '';
					$ausweis_buttons .= '<div class="single_filter">';

					$ausweis_buttons .= '<div class="filter_label_container">';
					$ausweis_buttons .= '<div class="filter_label"><span class="label_text" data-label_text="Ausweis">Ausweis</span><i class="fa-solid fa-angle-right"></i> </div>';
					$ausweis_buttons .= '<i class="fa-solid fa-circle-xmark"></i>';
					$ausweis_buttons .= '</div>'; // .filter_label_container
					
					$ausweis_buttons .= '<div class="filter_content filter_drop_down" role="group" data-filter-group="ausweis-kategorie">';
					//$ausweis_buttons .= '<span class="btn btn-sm btn-default btn-filter is-checked" data-filter="">alle</span>';

					foreach($ausweis_arr as $item):
						$ausweis_buttons .= '<span class="filter_button" data-filter-text="' . $item . '" data-filter=".' . $item . '">' . $item . '</span>';
					endforeach;
		
					$ausweis_buttons .= '</div>'; // div.btn-group
					$ausweis_buttons .= '</div>'; // .filter_buttons
					echo $ausweis_buttons;
					
					/* =============================================================== *\ 
 	 				   Buttons: Farbe 
					\* =============================================================== */ 
					$color_arr = array_unique($color_arr);
					$color_arr = array_filter($color_arr);
					$color_buttons = '';
					$color_buttons .= '<div class="single_filter colors" data-color-filter="">';
					//$color_buttons .= '<div class="filter-label">Farben <i class="fa-solid fa-angle-right"></i></div>';

					$color_buttons .= '<div class="filter_label_container">';
					$color_buttons .= '<div class="filter_label"><span class="label_text" data-label_text="Farben">Farben</span><i class="fa-solid fa-angle-right"></i> </div>';
					$color_buttons .= '<i class="fa-solid fa-circle-xmark"></i>';
					$color_buttons .= '</div>'; // .filter_label_container
										
					$color_buttons .= '<div class="filter_content filter_drop_down" role="group" data-filter-group="color-kategorie">';

					sort($color_arr); // Alphabetisch sortieren

					foreach($color_arr as $item):
						$item_class = str_replace(" ", "", strtolower($item));
						$color_buttons .= '<div class="filter_button" data-filter-text="' . $item . '" data-filter=".' . $item_class . '">' . $item . '</div>';
					endforeach;

					$color_buttons .= '</div>'; // div.btn-group
					$color_buttons .= '</div>'; // .filter_buttons
					echo $color_buttons; ?>
				</div>
								
			
			</div><!-- .filter_container-->
			
			<?php 
			/* =============================================================== *\ 
 	 		   Switches-HTML
			\* =============================================================== */ 
			
			?>
						
			<div class="switches_container">	
				<?php 
				
				if($in_stock == true): ?>
			
					<div class="single_switch in_stock">
						<div class="filter_content" role="group" data-filter-group="instock-toggle" checked="">
							<div class="switch_button_container" data-filter=".in_stock">		
								<label class="switch">
									<input type="checkbox">
<!--									<input type="checkbox" checked>. -->
									<span class="toggle round"></span>
								</label>
								<div class="switch_label_text">An Lager</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if($e_bike == true): ?>

					<div class="single_switch e_mobility">
						<div class="filter_content" role="group" data-filter-group="ebike-toggle">
							<div class="switch_button_container" data-filter=".e_bike">		
								<label class="switch">
									<input type="checkbox">
									<span class="toggle round"></span>
								</label>
								<div class="switch_label_text">E-Mobility</div>
							</div>
						</div>
					</div>	
				<?php endif; ?>

				<?php if($teeny_bike_15 == true): ?>
					<div class="single_switch ab_15_jahren">
						<div class="filter_content" role="group" data-filter-group="teeny_15_toggle">
							<div class="switch_button_container" data-filter=".ab_15_jahren">		
								<label class="switch">
									<input type="checkbox">
									<span class="toggle round"></span>
								</label>
								<div class="switch_label_text">ab 15 Jahren</div>
							</div>
						</div>
					</div>	
				<?php endif; ?>				
				
				<?php if($teeny_bike_16 == true): ?>
					<div class="single_switch ab_16_jahren">
						<div class="filter_content" role="group" data-filter-group="teeny_16_toggle">
							<div class="switch_button_container" data-filter=".ab_16_jahren">		
								<label class="switch">
									<input type="checkbox">
									<span class="toggle round"></span>
								</label>
								<div class="switch_label_text">ab 16 Jahren</div>
							</div>
						</div>
					</div>	
				<?php endif; ?>
			</div>
			
			
			<?php
			/* =============================================================== *\ 

			   Fahrzeuge-Output 

			\* =============================================================== */ 
			?>
			
			<div class="neufahrzeuge_container">
				
				<div class="neufahrzeuge grid">
					<div class="grid_sizer"></div>
					<div class="gutter_sizer"></div>
					<div class="no_results hide">Keine Fahrzeuge vorhanden :(</div>
					<?php 
					$neufahrzeug_html = "";

					/* =============================================================== *\ 
 	 				   
					   Single-Fahrzeug 
					 
					\* =============================================================== */ 

					while ( $neufahrzeuge->have_posts() ):
						$neufahrzeuge->the_post();
	
						$farben_an_lager = array();
						$farben_an_lager_html = "";
						$classes = "neufahrzeug_card item";
						$bild = "";
						$images_colors_instock_array = array();
									
						$blocks = parse_blocks(get_the_content(null, false, get_the_ID()));
						
						/* =============================================================== *\ 
						   da die Inhalte aus verschiedenen Blocks stammen, 
						   und die Reihenfolge theoretisch frei wählbar ist, 
						   werden die Inhalte der einzelnen Kacheln hier zuerst abgefüllt 
						\* =============================================================== */ 
						// Colors + inStock
						foreach($blocks as $block):
							// Hack:
							if(!array_key_exists('id', $block)):
								$block['id'] = 1;
								if(array_key_exists('id', $block['attrs'])):
									$block['id'] = $block['attrs']['id'];
								endif;
							endif;
							
							/* =============================================================== *\ 
							   Images
							   Colors
							   inStock 
							\* =============================================================== */ 
							if("acf/model-images" == $block['blockName']):
								$post_id = get_the_ID();
								$acf_colors_instock = get_acf_block_repeater_with_id("acf/model-images", "modell_bilder", array("bild", "farbe", "an_lager"), $post_id);	
								$temp_arr = array();

								foreach($acf_colors_instock as $single_colors_instock):
									// Images
									$temp_arr['bild_id'] = $single_colors_instock['bild'];
									$temp_arr['farbe'] = $single_colors_instock['farbe'];
									$temp_arr['an_lager'] = $single_colors_instock['an_lager'];									
									array_push($images_colors_instock_array, $temp_arr);


									//Colors
									$my_color = "";
									if(isset($single_colors_instock['farbe'])):
										$my_color = $single_colors_instock['farbe'];
										if(!empty($my_color)):
											array_push($color_arr, $my_color);	
											$my_color = strtolower(str_replace(" ", "", $my_color));
											$classes .= " " . $my_color; 	
										endif;
									endif;
									
									// Farben an Lager
									// data-in_stock:[ceramicice, bluevelvet];
									if(isset($single_colors_instock['farbe']) && isset($single_colors_instock['an_lager'])):
										if( ($single_colors_instock['farbe']!="") && ($single_colors_instock['an_lager'] == 1)):
											array_push($farben_an_lager, $single_colors_instock['farbe']);
											$color_in_stock = " " . strtolower(str_replace(" ", "", $single_colors_instock['farbe'])) . "_instock";
											$classes .= $color_in_stock;
											$classes .= " in_stock";
											
											// Farben für data-attribute data-colors_in_stock
											$farben_an_lager_html .= "[";					
											if(!empty($farben_an_lager)):
												foreach($farben_an_lager as $key => $item):
													$item = strtolower(str_replace(" ", "", $item));
													if(($key+1) < count($farben_an_lager)):
														$farben_an_lager_html .=  "\"" . $item . "\",";
													else:
														$farben_an_lager_html .=  "\"" . $item . "\"";
													endif;
												endforeach;

											endif;
											$farben_an_lager_html .= "]";									
										endif;
									endif;
																	
									//inStock
									if(isset($single_colors_instock['an_lager'])):
										if($single_colors_instock['an_lager'] == 1):
											$in_stock = true;
										endif;
									endif;

								endforeach;
							endif;			
			
						endforeach; // blocks as $block
						
						$farben_an_lager = array_unique($farben_an_lager);
						$farben_an_lager = array_filter($farben_an_lager);
						
						foreach($blocks as $block):
							// Hack:
							if(!array_key_exists('id', $block)):
								$block['id'] = 1;
								if(array_key_exists('id', $block['attrs'])):
									$block['id'] = $block['attrs']['id'];
								endif;
							endif;
							
			
							if("acf/neufahrzeug-short-card" == $block['blockName']):
								/* =============================================================== *\ 
			 	 				   Populate Data-Attribute 
								\* =============================================================== */ 
			  					// Hubraum
			  					if(isset($block['attrs']['data']['hubraum'])):
									$hubraum = $block['attrs']['data']['hubraum'];
									$classes .= " hubraum_" . $block['attrs']['data']['hubraum'];
								endif;
								
								// Leistung
								// Leistung min + max
								$leistung_min_arr_html = array();
								$leistung_max_arr_html = array();

								if(isset($block['attrs']['data']['leistung'])):
									array_push($leistung_min_arr_html, $block['attrs']['data']['leistung']);
									array_push($leistung_max_arr_html, $block['attrs']['data']['leistung']);
								endif;
								if(isset($block['attrs']['data']['gedrosselte_leistung'])):
									if(!empty($block['attrs']['data']['gedrosselte_leistung'])):
										array_push($leistung_min_arr_html, $block['attrs']['data']['gedrosselte_leistung']);
										array_push($leistung_max_arr_html, $block['attrs']['data']['gedrosselte_leistung']);
									endif;
								endif;
								
								$leistung_min = "";
								$leistung_max = "";

								if(!empty($leistung_min_arr_html)):
									$leistung_min = min($leistung_min_arr_html);
								endif;
								
								if(!empty($leistung_max_arr_html)):
									$leistung_max = max($leistung_max_arr_html);
								endif;
								
								// Yamaha-Kategorien
								if(isset($block['attrs']['data']['y_kategorie'])):
									$classes .= " " . $block['attrs']['data']['y_kategorie'];
								endif;
								
								// Ausweis-Kategorien
								if(isset($block['attrs']['data']['ausweiskategorie'])):
									$classes .= " " . $block['attrs']['data']['ausweiskategorie'];
								endif;
								
								// Zusätzliche Ausweis-Kategorien
								if(isset($block['attrs']['data']['zusatzliche_ausweiskategorie'])):
									if($block['attrs']['data']['zusatzliche_ausweiskategorie']!=""):
										$zusatzliche_ausweiskategorien = $block['attrs']['data']['zusatzliche_ausweiskategorie'];
										foreach($zusatzliche_ausweiskategorien as $item):
											$classes .= " " . $item;
										endforeach;
									endif;
								endif;
								
								// An Lager global, ohne farben
								/*if(isset($block['attrs']['data']['an_lager'])):
									if($block['attrs']['data']['an_lager']==1){
										$classes .= " in_stock";
									}
								endif;
								*/
								// E-Bike
								if(isset($block['attrs']['data']['e_bike'])):
									if($block['attrs']['data']['e_bike']==1){
										$classes .= " e_bike";										
									}
								endif;
								
								// Ab 15 Jahren 
								if(isset($block['attrs']['data']['ab_15_jahren'])):
									if($block['attrs']['data']['ab_15_jahren']==1){
										$classes .= " ab_15_jahren";										
									}
								endif;

								// Ab 16 Jahren 
								if(isset($block['attrs']['data']['ab_16_jahren'])):
									if($block['attrs']['data']['ab_16_jahren']==1){
										$classes .= " ab_16_jahren";										
									}
								endif;
								
								
								// Preis 
								$preis = 0;
								if(isset($block['attrs']['data']['preis'])):
									$preis = $block['attrs']['data']['preis'];
								endif; 
								
								if(isset($block['attrs']['data']['reduzierter_preis'])):
									if($block['attrs']['data']['reduzierter_preis']!=""):
									$preis = $block['attrs']['data']['reduzierter_preis'];
								endif;
								endif;

								$neufahrzeug_html .= '<div class="' . $classes . '"';
								//$neufahrzeug_html .=  "data-colors_in_stock='[\"eins\",\"zwei\"]'";
								$neufahrzeug_html .=  "data-colors_in_stock='" . $farben_an_lager_html . "'";
								$neufahrzeug_html .= ' data-preis="' . $preis . '" data-hubraum="' . $hubraum . '" data-leistung-min="' . $leistung_min . '" data-leistung-max="' . $leistung_max . '">';
								
								if(isset($block['attrs']['data']['reduzierter_preis'])):
									if($block['attrs']['data']['reduzierter_preis']!=""):
										$neufahrzeug_html .= '<div class="sale_container"><div class="sale"><span>Sale</span></div></div>';
									endif;
								endif;
								
								
								/* =============================================================== *\ 
								   
								   Populate Elements for Card 
								   
								\* =============================================================== */ 

								/* =============================================================== *\ 
								 	 Slick-slider 
								\* =============================================================== */ 
								if(count($images_colors_instock_array)>0):
									
									$neufahrzeug_html .= '<div class="slick_card_slider">';
									
									foreach($images_colors_instock_array as $item):
										$bild_id = $item['bild_id'];
										$an_lager = $item['an_lager'];
										$an_lager_output = "not_in_stock";
										if($an_lager == 1):
											$an_lager_output = "in_stock";
										else:
											$an_lager_output = "not_in_stock";
										endif;	
										
										$color_for_data_attr = $item['farbe'];
										$color_for_data_attr = str_replace(" ", "", strtolower($color_for_data_attr));

										$neufahrzeug_html .= '<a class="' . $an_lager_output . '" href="' . get_the_permalink($post_id) . '"data-in_stock="' . $an_lager_output . '" data-color="' . $color_for_data_attr . '">';
										$neufahrzeug_html .= wp_get_attachment_image( $bild_id, "neufahrzeuge_loop_medium", false, array('data-color'=>$color_for_data_attr) );
										$neufahrzeug_html .= '</a>';
									endforeach;
									
									$neufahrzeug_html .= "</div>";
								endif;

								/* =============================================================== *\ 
 	 							   Marke + Modell 
								\* =============================================================== */  
								if((isset($block['attrs']['data']['marke'])) || (isset($block['attrs']['modell']))):
									$post_id = get_the_ID();
									$neufahrzeug_html .= "<h3>";
									$neufahrzeug_html .= '<a href="' . get_the_permalink($post_id) . '">';
								endif;

								if(isset($block['attrs']['data']['marke'])):
									$neufahrzeug_html .= $block['attrs']['data']['marke'] . " ";
								endif;
								
								if(isset($block['attrs']['data']['modell'])):
									$neufahrzeug_html .= $block['attrs']['data']['modell'];
								endif;
								
								if((isset($block['attrs']['data']['marke'])) || (isset($block['attrs']['modell']))):
									$neufahrzeug_html .= '</a>';
									$neufahrzeug_html .= "</h3>";
								endif;
	
	
								/* =============================================================== *\ 
								   Card Properties Chips 
								\* =============================================================== */ 
  
  								$neufahrzeug_html .='<ul class="neufahrzeug_properties_list">';								
								

								
								//Ausweise
								$ausweise_arr = array();
								if(isset($block['attrs']['data']['ausweiskategorie'])):
									array_push($ausweise_arr, $block['attrs']['data']['ausweiskategorie']);
								endif;
								
								if(isset($block['attrs']['data']['zusatzliche_ausweiskategorie'])):
									if($block['attrs']['data']['zusatzliche_ausweiskategorie']!=""):
										$zusatzliche_ausweiskategorien = $block['attrs']['data']['zusatzliche_ausweiskategorie'];
										foreach($zusatzliche_ausweiskategorien as $item):
											array_push($ausweise_arr, $item);
										endforeach;
									endif;
								endif;
								
								if(!empty($ausweise_arr)):
									$ausweise_str = "";
									$counter = 0;
									foreach($ausweise_arr as $item):
										$counter++;
										if($counter<=1):
											$ausweise_str .= $item;
										else:
											$ausweise_str .= " / " . $item;
										endif;
									endforeach;
									$neufahrzeug_html .= '<li class="ausweiskategorie">';
									$neufahrzeug_html .= '<span class="card_list_value">' . $ausweise_str . '</span>';
									$neufahrzeug_html .= '</li>';
								endif;
								
								// E-Mobility
								if(isset($block['attrs']['data']['e_bike'])):
									if($block['attrs']['data']['e_bike']!=0):
										$neufahrzeug_html .= '<li class="e_mobility">';
										$neufahrzeug_html .= '<span class="card_list_value"><i class="fa-solid fa-plug"></i></span>';
										$neufahrzeug_html .= '</li>';
									endif;
								endif;
										
								// Hubraum
								if(isset($block['attrs']['data']['hubraum'])):
									if($block['attrs']['data']['hubraum']!=""):
										$neufahrzeug_html .= '<li class="hubraum">';
										$neufahrzeug_html .= '<span class="card_list_value">' . $block['attrs']['data']['hubraum'] . ' ccm</span>';
										$neufahrzeug_html .= '</li>';
									endif;
								endif;
								
								// Leistung
								if( (isset($block['attrs']['data']['leistung'])) &&( isset($block['attrs']['data']['gedrosselte_leistung'])) ):
									if( ($block['attrs']['data']['leistung']!="") && ($block['attrs']['data']['gedrosselte_leistung']!="") ):
										$neufahrzeug_html .= '<li class="leistung">';
										$neufahrzeug_html .= '<span class="card_list_value">' . $block['attrs']['data']['leistung'] . ' / ' . $block['attrs']['data']['gedrosselte_leistung'] . ' kW</span>';
										$neufahrzeug_html .= '</li>';
										
									elseif($block['attrs']['data']['leistung']!=""):
											$neufahrzeug_html .= '<li class="leistung">';
											$neufahrzeug_html .= '<span class="card_list_value">' . $block['attrs']['data']['leistung'] . ' kW</span>';
											$neufahrzeug_html .= '</li>';
									
									elseif($block['attrs']['data']['gedrosselte_leistung']!=""):
										$neufahrzeug_html .= '<li class="leistung">';
										$neufahrzeug_html .= '<span class="card_list_value">' . $block['attrs']['data']['gedrosselte_leistung'] . ' kW</span>';
										$neufahrzeug_html .= '</li>';
									endif;	
								endif;
								
								// Color
								if(count($images_colors_instock_array)>0):
									foreach($images_colors_instock_array as $item):
										if($item['farbe']!=""):
											$my_stock_class= "";
											if($item['an_lager'] == 1):
												$my_stcok_class = "in_stock";	
											else:
												$my_stock_class = "not_in_stock";
											endif;
											
											$color_for_data_attr = "";
											$color_for_html = "";
											if($item['farbe'] != ""):
												$color = $item['farbe'];
												$color_for_html = $color;
											endif;
											$color_for_data_attr = str_replace(" ", "", strtolower($color));

											$neufahrzeug_html .= '<li class="color ' .  $my_stock_class . '" data-color-nav="'. $color_for_data_attr . '">';
											$neufahrzeug_html .= '<span class="card_list_value">' .ucfirst($color_for_html) . '</span>';
											$neufahrzeug_html .= '</li>';
										endif;
									endforeach;
								endif;							
								

								// Ab 15 Jahren
								if(isset($block['attrs']['data']['ab_15_jahren'])):
									if($block['attrs']['data']['ab_15_jahren']!=0):
										$neufahrzeug_html .= '<li class="ab_15_jahren">';
										$neufahrzeug_html .= '<span class="card_list_value">ab 15 Jahren</span>';
										$neufahrzeug_html .= '</li>';
									endif;
								endif;

								// Ab 16 Jahren
								if(isset($block['attrs']['data']['ab_16_jahren'])):
									if($block['attrs']['data']['ab_16_jahren']!=0):
										$neufahrzeug_html .= '<li class="ab_16_jahren">';
										$neufahrzeug_html .= '<span class="card_list_value">ab 16 Jahren</span>';
										$neufahrzeug_html .= '</li>';
									endif;
								endif;
								
								$neufahrzeug_html .= '</ul>'; //ul.neufahrzeug_properties_list
								$neufahrzeug_html .= '<div class="preis_and_call_to_action">'; //ul.neufahrzeug_properties_list

								
								/* =============================================================== *\ 
 	 							   Price 
								\* =============================================================== */ 
								if(isset($block['attrs']['data']['reduzierter_preis'])):									
									if($block['attrs']['data']['reduzierter_preis']!=""):

										if(isset($block['attrs']['data']['preis'])):
											$preis = $block['attrs']['data']['preis'];
											$preis_formatiert = number_format($preis, 0, '', "'");

											$neufahrzeug_html .= '<div class="preis preis_original">';
											$neufahrzeug_html .= '<span class="card_list_label"></span>';
											$neufahrzeug_html .= '<span class="card_list_value">CHF ' . $preis_formatiert . '.–</span>';
											$neufahrzeug_html .= '</div>';
										endif;
										
										// Tausender-Trennzeichen
										$preis = intval($block['attrs']['data']['reduzierter_preis']);
										$preis_formatiert = number_format($preis, 0, '', "'");

										$neufahrzeug_html .= '<div class="preis reduzierter_preis">';
										$neufahrzeug_html .= '<span class="card_list_label">ab </span>';
										$neufahrzeug_html .= '<span class="card_list_value">CHF ' . $preis_formatiert . '.–</span>';
										$neufahrzeug_html .= '</div>';
										
									elseif(isset($block['attrs']['data']['preis'])):
										if(!empty($block['attrs']['data']['preis'])):
											$preis = $block['attrs']['data']['preis'];
											$preis_formatiert = number_format($preis, 0, '', "'");

											$neufahrzeug_html .= '<div class="preis">';
											$neufahrzeug_html .= '<span class="card_list_label">ab </span>';
											$neufahrzeug_html .= '<span class="card_list_value">CHF ' . $preis_formatiert . '.–</span>';
											$neufahrzeug_html .= '</div>';
										endif;
									endif;	
								endif;	
						
								//Call-to-Action
								$neufahrzeug_html .= '<div class="text_button">';
								$neufahrzeug_html .= '<a class="text_button_link" href="';
								$neufahrzeug_html .= get_the_permalink();
								$neufahrzeug_html .= '">Ansehen';
								$neufahrzeug_html .= '</a>';
								$neufahrzeug_html .= '</div>';

								$neufahrzeug_html .= '</div>'; // preis_and_call_to_action

								$neufahrzeug_html .= '</div>'; // div.neufahrzeug_card.item
							endif; // if("acf/neufahrzeug-short-card" == $block['blockName']):
							
							
						endforeach;
					endwhile;
					
					/* =============================================================== *\ 
 					   HTML-Output
					\* =============================================================== */ 
					echo $neufahrzeug_html; ?>
					
				</div><!-- .neufahrzeuge.grid -->
			</div><!-- .neufahrzeuge_container -->
		</div> <!-- filters.filter-section -->
		
		<?php if(is_admin()==true): ?>
			<div class="neufahrzeug_admin"><h3>Neufahrzeuge-Loop</h3><p>Mit diesem Block werden alle Neufahrzeuge inkl. Filterfunktion ausgegeben.</p></div>
		<?php endif; ?>
		
	</section> <!--section.container -->
<?php
endif; // have_posts()  
wp_reset_postdata();
?>