<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Home Page');

$header = _header('Home');

$main = file_get_contents('../views/index.html');

/**
 * Vari str_replace nella vista main
 */
$header = str_replace('%TITOLO%', 'Scissorhands', $header);

$pagina = str_replace('%HEADER%', $header, $pagina);

$pagina = str_replace('%MAIN%', $main, $pagina);



echo $pagina;
