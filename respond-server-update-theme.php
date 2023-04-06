<?php

$response = array(
	'theme'        => 'theme-name',
  'new_version'  => '1.1',
  'url'          => 'https://neon.web.id/produk/theme-name',
  'package'      => 'https://neon.web.id/produk/theme-name-1.zip',
  'requires'     => '',
  'requires_php' => '',
);

header('Content-Type: application/json');
echo json_encode($response, 128);
