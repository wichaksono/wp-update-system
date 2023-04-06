<?php

function neon_fetch_new_theme($theme_name) {
  $server_update = 'https://app.neon.web.id/json/update-theme/' . $theme_name;
  
  $response = wp_remote_get($server_update);
  if ( is_array( $response ) && ! is_wp_error( $response ) ) {
      $object_response = json_decode( $response['body'] );
			if ( json_last_error() === JSON_ERROR_NONE ) {
				return $object_response;
			}         
  }
  
  return new StdClass();
}

function neon_update_theme( $transient ) {
    
    $theme_name = 'theme-name';
    $current_verion = '1.0';
  
    // Query premium/private repo for updates.
    $update = mytheme_check_for_updates( $theme_name );
    if ( $update ) {
        // Update is available.
      
        $transient->response[$theme_name] = $update;
    } else {
        // No update is available.
        $item = array(
            'theme'        => $theme_name,
            'new_version'  => $current_verion,
            'url'          => '',
            'package'      => '',
            'requires'     => '',
            'requires_php' => '',
        );
        
        // set to no update available
        $transient->no_update[$theme_name] = $item;
    }
 
    return $transient;
}
 
add_filter( 'pre_set_site_transient_update_themes', 'neon_update_theme' );
