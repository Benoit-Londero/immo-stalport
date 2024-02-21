<?php

remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

// Menu 
register_nav_menus( array(
    'megamenu' => 'Mega Menu',
	  'main' => 'Menu Principal',
	  'footer' => 'Bas de page',
    'topheader' => 'Top menu'
) );

add_theme_support( 'post-thumbnails' ); 

//SVG Files
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
       return $data;
    }
  
    $filetype = wp_check_filetype( $filename, $mimes );
  
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4 );
  
function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
  
function fix_svg() {
    echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
}
  add_filter( 'upload_mimes', 'cc_mime_types' );
  add_action( 'admin_head', 'fix_svg' );

// WHISE

function getWhiseLanguageCode(){
    //fr-BE ou nl-BE
    if ( function_exists( 'pll' ) ) {
      if(pll_current_language() == 'fr'){
        return 'fr-BE';
      }else if(pll_current_language() == 'nl'){
        return 'nl-BE';
      }else{
        return 'fr-BE';
      }
    }else{
      return 'fr-BE';
    }
}

function getUrlFromFr($id){
  if ( function_exists( 'pll' ) ) {
    $urls = pll_the_languages( array( 'show_flags' => 0,'show_names' => 0, 'display_names_as' => 'slug', 'echo' => 0, 'raw' => 1, 'post_id' => $id ) );
    if(pll_current_language() == 'nl'){
      return $urls['nl']['url'];
    }else if(pll_current_language() == 'fr'){
      return $urls['fr']['url'];
    }else{
      return $urls['fr']['url'];
    }
  }
}