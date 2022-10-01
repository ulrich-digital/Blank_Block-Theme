<?php 
/* =============================================================== *\ 

 	 ACF - Block Neufahrzeug 
     - Bei diesem Block ist der Block acf_contact_form angehängt

\* =============================================================== */ 
$watermarks_bei_illustrativen_bildern = false;
$watermarks_bei_modell_bilder = false;



/* =============================================================== *\ 

 	 Farben von acf/model-images holen 

\* =============================================================== */ 
$model_colors = array(); // enthält alle Farben
$blocks = parse_blocks(get_the_content(null,false,get_the_ID()));
foreach($blocks as $block):
    if(!array_key_exists('id', $block)):
		$block['id'] = 1;
		if(array_key_exists('id', $block['attrs'])):
			$block['id'] = $block['attrs']['id'];
		endif;
	endif;
    
    if("acf/model-images" == $block['blockName']):
        $post_id = get_the_ID();

        $colors = get_acf_block_repeater_with_id("acf/model-images","modell_bilder", array("farbe", "an_lager"), $post_id);
        if($colors != NULL): // keine Farben hinterlegt
            $temp_arr= array();
            foreach($colors as $color):
                if($color['farbe']!=""):
                    $temp_arr['farbe'] = $color['farbe'];
                    $temp_arr['an_lager'] = $color['an_lager'];
                array_push($model_colors, $temp_arr);
            endif;
            endforeach;
        endif;
    endif;
endforeach;
/*
$model_colors = array_filter($model_colors);
$model_colors = array_unique($model_colors);
$model_colors = array_values($model_colors);
*/
?>

    
    



<?php
//$merkmale_arr = array("marke", "modell", "kategorie", "hubraum", "ausweiskategorie", "leistung", "zustand", "garantie", "preis", "beschreibung");
$listen_html = '<div class="neufahrzeug_properties">';

/* =============================================================== *\ 
   Sale-Hinweis
\* =============================================================== */ 
if(get_field("reduzierter_preis")):
    $listen_html .= '<div class="sale_container"><div class="sale"><span>Sale</span></div></div>';
endif;

/* =============================================================== *\ 
   Yamaha-Kategorie Corner 
\* =============================================================== */ 
$y_kat_class = "";
$y_kat_text = "";
if(get_field("y_kategorie")):
    $y_kat = get_field("y_kategorie");
    if(isset($y_kat['value'])):
        $y_kat_class = $y_kat['value'];
    endif;
    $listen_html .='<div class="cat_corner_container"><div class="cat_corner ' . $y_kat_class . '"><div class="cat_corner_content">' . $y_kat_class . '</div></div></div>';								
endif;
    
/* =============================================================== *\ 
   Properties List 
\* =============================================================== */ 
$listen_html .= '<ul class="neufahrzeug_properties_list ' . $y_kat_class. '">';

// Marke
if(get_field("marke")):
	$item = get_field_object("marke");
	$listen_html .= '<li class="list_item">';
	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
	$listen_html .= '<div class="value">' . ucfirst($item['value']) . '</div>';
	$listen_html .= '</li>';
endif;

// Modell
if(get_field("modell")):
	$item = get_field_object("modell");
	$listen_html .= '<li class="list_item modell">';
	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
	$listen_html .= '<div class="value">' . ucfirst($item['value']) . '</div>';
	$listen_html .= '</li>';
endif;

// Hubraum
if(get_field("hubraum")):
	$item = get_field_object("hubraum");
	$listen_html .= '<li class="list_item">';
	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
	$listen_html .= '<div class="value">' . ucfirst($item['value']) . ' ccm</div>';
	$listen_html .= '</li>';
endif;
 
// Ausweiskategorien
if( (get_field("ausweiskategorie")) && (get_field("zusatzliche_ausweiskategorie"))):
   $item_ausweiskategorie = get_field_object("ausweiskategorie");
   $listen_html .= '<li class="list_item">';
   $listen_html .= '<div class="label">' . ucfirst($item_ausweiskategorie['label']) . ':</div>';
   $listen_html .= '<div class="value">';
   $listen_html .= '<span>' . ucfirst($item_ausweiskategorie['value']) . '</span>';

   $zusatzliche_kategorien = get_field("zusatzliche_ausweiskategorie");
   foreach($zusatzliche_kategorien as $zusatzliche_kategorie):
       $listen_html .=   '<span> / '  . $zusatzliche_kategorie . '</span>';  
   endforeach;
   
   $listen_html .= '</div>';
   $listen_html .= '</li>';
      
elseif(get_field("ausweiskategorie")):
	$item = get_field_object("ausweiskategorie");
    $ausweis_kategorie = ucfirst($item['value']);
	$listen_html .= '<li class="list_item">';
	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
    $listen_html .= '<div class="value">' . $ausweis_kategorie . '</div>';
	$listen_html .= '</li>';
endif;




// Zusätzlicher Hinweis
if(get_field("ausweiskategorie_hinweis")):
    $item = get_field_object("ausweiskategorie_hinweis");
    $listen_html .= '<li class="list_item">';
    $listen_html .= '<div class="label"> </div>';
    $listen_html .= '<div class="value note">' . ucfirst($item['value']) . '</div>';
    $listen_html .= '</li>';
endif;

// Leistung
if(get_field("leistung") && (get_field("gedrosselte_leistung"))):
    $item_leistung = get_field_object("leistung");
    $item_leistung_gedrosselt = get_field_object("gedrosselte_leistung");
    $listen_html .= '<li class="list_item">';
    $listen_html .= '<div class="label">' . ucfirst($item_leistung['label']) . ':</div>';
    $listen_html .= '<div class="value">' . ucfirst($item_leistung['value']) . ' / ' . ucfirst($item_leistung_gedrosselt['value']) . ' kW</div>';
    $listen_html .= '</li>';
elseif(get_field("leistung")):
    	$item = get_field_object("leistung");
    	$listen_html .= '<li class="list_item">';
    	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
    	$listen_html .= '<div class="value">' . ucfirst($item['value']) . ' kW</div>';
    	$listen_html .= '</li>';
elseif(get_field("gedrosselte_leistung")):
    	$item = get_field_object("leistung");
    	$listen_html .= '<li class="list_item">';
    	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
    	$listen_html .= '<div class="value">' . ucfirst($item['value']) . ' kW</div>';
    	$listen_html .= '</li>';
endif;

// Zustand
if(get_field("zustand")):
	$item = get_field_object("zustand");
	$listen_html .= '<li class="list_item">';
	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
	$listen_html .= '<div class="value">' . ucfirst($item['value']) . '</div>';
	$listen_html .= '</li>';
endif;

// Farben 
// Labeltext
$label_text = "Farbe";
if(count($model_colors)>1):
    $label_text = "Farben:";    
endif;

if(count($model_colors)>0):
    $listen_html .= '<li class="list_item colors">';
    $listen_html .= '<div class="label color_label">' . $label_text . '</div>';
    $listen_html .= '<div class="value">';

    foreach($model_colors as $color):
        if($color['farbe'] != ""):
        $my_color_html = ucfirst($color['farbe']);
        $listen_html .= '<div class="value single_color" >' . $my_color_html . " ";
        if($color['an_lager']== 1):
            $listen_html .= '<small>an Lager</small>';
        endif;
        $listen_html .= '</div>';
    endif;
    endforeach;

    $listen_html .= "</div>";
    $listen_html .= "</li>";
endif;

// Garantie
if(get_field("garantie")):
	$item = get_field_object("garantie");
	$listen_html .= '<li class="list_item">';
	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
	$listen_html .= '<div class="value">' . ucfirst($item['value']) . ' Monate</div>';
	$listen_html .= '</li>';
endif;
    
// Preis + reduzierter Preis
if( (get_field("reduzierter_preis")) && (get_field("preis")) ):
    $item_reduzierter_preis = get_field_object("reduzierter_preis");
    $reduzierter_preis_formatiert = number_format($item_reduzierter_preis['value'], 0, '', "'");

    $item_preis = get_field_object("preis");
    $preis_formatiert = number_format($item_preis['value'], 0, '', "'");

    $listen_html .= '<li class="list_item old_price">';
    $listen_html .= '<div class="label">' . ucfirst($item_preis['label']) . ': </div>';
    $listen_html .= '<div class="value ">CHF ' . ucfirst($reduzierter_preis_formatiert) . '.–</div>';
    $listen_html .= '</li>';
    
    $listen_html .= '<li class="list_item sale_price">';
    $listen_html .= '<div class="label"></div>';
    $listen_html .= '<div class="value">ab CHF ' . ucfirst($preis_formatiert) . '.–</div>';
    $listen_html .= '</li>';
    
elseif(get_field("preis")):
    	$item = get_field_object("preis");
        $preis_formatiert = number_format($item['value'], 0, '', "'");
    	$listen_html .= '<li class="list_item">';
    	$listen_html .= '<div class="label">' . ucfirst($item['label']) . ':</div>';
    	$listen_html .= '<div class="value">ab CHF ' . ucfirst($preis_formatiert) . '.–</div>';
    	$listen_html .= '</li>';
endif;
     
$listen_html .= "</ul>";
$listen_html .= "</div>";


/* =============================================================== *\ 
   HTML-Ausgabe
\* =============================================================== */ 
echo $listen_html;

?>