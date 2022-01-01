<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Contatti - Scissorhands');
$header = _header('Contatti');

$main = file_get_contents('../views/contatti.html');


$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;