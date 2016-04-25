<?php 
$path_to_rongFramework = __DIR__ . "/../";
set_include_path( get_include_path() .PATH_SEPARATOR . $path_to_rongFramework );

require_once __DIR__ . '/../PhpTokenizer.php';

$cnt = file_get_contents( __DIR__ . "/test_src.php" );

$pt = new PhpTokenizer();
$result = $pt->tokenize($cnt);
print_r( $result);
