<?php

function neon_fetch_new_plugin($plugin_name) {
  $server_update = 'https://app.neon.web.id/json/update-plugin/' . $plugin_name;
  
  $response = wp_remote_get($server_update);
  if ( is_array( $response ) && ! is_wp_error( $response ) ) {
      $object_response = json_decode( $response['body'] );
			if ( json_last_error() === JSON_ERROR_NONE ) {
				return $object_response;
			}         
  }
  
  return new StdClass();
}


function neon_update_plugin( $transient ) {
  
    $plugin_name = 'my-plugin';
    $current_version = '1.0';
  
    // Query premium/private repo for updates.
    $update = neon_fetch_new_plugin( $plugin_name );
  
    if ( $update ) {
        // Update is available.
        $transient->response["$plugin_name/$plugin_name.php"] = $update;
    } else {
        // No update is available.
        $item = (object) array(
            'id'            => "$plugin_name/$plugin_name.php",
            'slug'          => $plugin_name,
            'plugin'        => "$plugin_name/$plugin_name.php",
            'new_version'   => $current_version,
            'url'           => '',
            'package'       => '',
            'icons'         => array(),
            'banners'       => array(),
            'banners_rtl'   => array(),
            'tested'        => '',
            'requires_php'  => '',
            'compatibility' => new stdClass(),
        );
        // set to no update available
        $transient->no_update["$plugin_name/$plugin_name.php"] = $item;
    }
 
    return $transient;
}
 
add_filter( 'pre_set_site_transient_update_plugins', 'neon_update_plugin' );
