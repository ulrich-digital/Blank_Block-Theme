<?php 
/* =============================================================== *\ 

 	 Slider for Model Image Slider
     + watermarks
     + color chips as navigation
     + (second slider as navigation)

\* =============================================================== */ 

/* =============================================================== *\ 
   Watermarks 
\* =============================================================== */ 
$watermarks = false;
if(get_field("watermark_anzeigen")):
    $watermarks = true;
endif;

/* =============================================================== *\ 
   Colorfields 
\* =============================================================== */ 
$color_fields_for_data_attributes = array(); 
$color_fields_for_html = array(); 
$color_chips_below_slider = "";

/* =============================================================== *\ 
   HTML-Output 
\* =============================================================== */ 
$slick_slider_html = "";
?>

<div class="slick_model_image_container">
    <?php 
    // Modell-Bilder Gross
    if( have_rows('modell_bilder')):
        $slick_slider_html .= '<div class="is_slick_slider_gallery model_image_slider_big">';
    
        while ( have_rows('modell_bilder') ) : 
            the_row();
            $bild = get_sub_field('bild');
            if(isset($bild['id'])):
                if(!empty($bild['id'])):
                    $bild_id = $bild['id'];
                    $farbe = get_sub_field('farbe');
                    $farbe = str_replace(" ", "", $farbe);
                    $slick_slider_html .='<div class="slider_item" data-color-big="' .  $farbe . '">';
                    
                    if($watermarks == true):
		                if(get_field("watermark")):
		                    $slick_slider_html .= wp_get_attachment_image(get_field("watermark"), 'medium', false, array('class' => "watermark"));
		                endif;
		            endif;
                    
                    $my_image = wp_get_attachment_image($bild_id,"full", false,array('class' => 'big_image'));
                    $slick_slider_html .= $my_image;
                    $slick_slider_html .= '</div>';
                endif;
            endif;
			
			$farbe = get_sub_field('farbe');
			if($farbe):
				$my_color = $farbe;
                $my_color_html = ucfirst($my_color);
                $my_color_data = str_replace(" ", "", $my_color);     
				$color_chips_below_slider .= '<div class="value single_color  as_link" data-color-nav="' . $my_color_data . '">' . $my_color_html . "</div>";
			endif;
        endwhile;        
        $slick_slider_html .= '</div>';
    endif;  
	
    /*
    //Modell-Bilder klein
    if( have_rows('modell_bilder')): 
        $slick_slider_html .= '<div class="is_slick_slider_gallery neuheiten_slider slider_nav">';
        while ( have_rows('modell_bilder') ) : 
            the_row();
            $bild = get_sub_field('bild');
            if($bild):
                $bild_id = $bild['id'];
                $slick_slider_html .= '<div class="slider_item">';
                $my_image = wp_get_attachment_image($bild_id,"thumbnail", false,array('class' => 'my_class'));
                $slick_slider_html .= $my_image;
                $slick_slider_html .= '</div>';
            endif;
        endwhile;
        $slick_slider_html .= '</div>';
    endif;  
    */
    
	echo  $slick_slider_html;
	?>
	<div class="color_chips_below_slider"><?php echo $color_chips_below_slider;?></div>
</div>