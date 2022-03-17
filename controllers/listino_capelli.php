<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/servizio.php';
require_once '../services/public/service.php';
require_once 'components/meta_index.php';
require_once "components/listino_servizi.php";


$pagina = page('Listino capelli - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Servizi" => "servizi.php",
    "Listino per i capelli" => "listino_capelli.php",
);
$header = _header($path);

$main = file_get_contents('../views/listino_capelli.html');


$services = PublicServiceService::getAllCapelli();

$listinoServizi = listino_servizi($services);

$main = str_replace('%LISTINO_SERVIZI%' , $listinoServizi, $main);

$pagina = str_replace('%DESCRIPTION%', "Listino prezzi dei servizi per i capelli di Scissorhands." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "listino, prezzi, servizi, capelli, taglio, tinta, lavaggio, piega, trattamento, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;