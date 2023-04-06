<?php

$response = array(
	'id'            => 'plugin-name',
	'slug'          => 'plugin-slug',
	'plugin'        => 'plugin-folder/plugin-file.php',
	'new_version'   => '1.1',
	'url'           => 'https://neon.web.id/produk/plugin-name',
	'package'       => 'https://neon.web.id/produk/plugin-name-1.1.zip', // file zip for download
	'icons'         => array(), // ['1x'] => 'https://', ['2x'] => 'https://', ['svg'] => 'https://'
	'banners'       => array(),
	'banners_rtl'   => array(),
	'tested'        => '',
	'requires_php'  => '7.4',
	'compatibility' => new stdClass(),
	'headers' => $_SERVER
);

header('Content-Type: application/json');
echo json_encode($response, 128);
