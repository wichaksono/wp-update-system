<?php

const THEME_NAME = 'gpinfo';
const THEME_VERSION = '1.0';
const THEME_REPOSITORY = 'https://gpblog.skydia.com/update/theme';

function neon_fetch_new_theme() {
  $server_update = THEME_REPOSITORY . '/update.php?slug=' . THEME_NAME;
  
  $response = wp_remote_get($server_update);
  
  if ( is_array( $response ) && ! is_wp_error( $response ) ) {
      $object_response = json_decode( $response['body'], true );
      
      if ( json_last_error() === JSON_ERROR_NONE ) {
           return $object_response;
      }         
  }
  
  return [];
}

function neon_update_theme( $transient ) {
    

    // Query premium/private repo for updates.
    $update = neon_fetch_new_theme();
    if ( $update ) {
        // Update is available.
      
        $transient->response[THEME_NAME] = $update;
    } else {
        // No update is available.
        $item = array(
            'theme'        => THEME_NAME,
            'new_version'  => $current_verion,
            'url'          => '',
            'package'      => '',
            'requires'     => '',
            'requires_php' => '',
        );
        
        // set to no update available
        $transient->no_update[THEME_NAME] = $item;
    }
 
    return $transient;
}
 
add_filter( 'pre_set_site_transient_update_themes', 'neon_update_theme' );
