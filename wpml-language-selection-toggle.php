<?php
/*
 * Plugin Name: WPML language selector toggle test
 * Version: 1.0
 * Plugin URI: http://mathieuforest.ca/
 * Description: This was develop for custom needs.
 * Author: Mathieu Forest
 * Author URI: http://mathieuforest.ca/
 Put the language toggle in a menu or add shortcode [wpml-switcher]
 */

//Add in a menu

function your_custom_menu_item ( $items, $args ) {

    if ( $args->theme_location == 'header_custom_menu' ) {
 		
    {
        $items_array = array();
        while ( false !== ( $item_pos = strpos ( $items, '<li', 3 ) ) )
        {
            $items_array[] = substr($items, 0, $item_pos);
            $items = substr($items, $item_pos);
        }
        $items_array[] = $items;
       
        $languages = icl_get_languages('skip_missing=0&orderby=code');
            if(!empty($languages)){
                foreach($languages as $l){
                    if(!$l['active']){
                        $wpml_item =  '<li class=""> <a href="'.$l['url'].'">' . $l['native_name'] . '</a></li>';
                    }
                }
            }
           
        array_splice($items_array, 10, 0, $wpml_item); // insert custom item after 2nd one

        $items = implode('', $items_array);
    }
   
    }
   
    return $items;

}

add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );

// With shortcode

function wpml_switcher_shortcode_function(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        foreach($languages as $l){
            if(!$l['active']){ 
				if(ICL_LANGUAGE_CODE == 'en') {
               		return '<span class="language-switcher"><a href="'.$l['url'].'"><strong>FR</strong></a>';
				}elseif(ICL_LANGUAGE_CODE == 'fr') {
               		return '<span class="language-switcher"><a href="'.$l['url'].'"><strong>EN</strong></a>';
				}
            }
        }
    }
}

add_shortcode( 'wpml-switcher', 'wpml_switcher_shortcode_function' );

?>