<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/servizio.php';
require_once '../services/public/service.php';
require_once 'components/meta_index.php';
require_once "components/listino_servizi.php";


$pagina = page('Listino barba - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Servizi" => "servizi.php",
    "Listino per la barba" => "listino_barba.php",
);
$header = _header($path);

$main = file_get_contents('../views/listino_barba.html');

$services = PublicServiceService::getAllBarba();

$listinoServizi = listino_servizi($services);

$main = str_replace('%LISTINO_SERVIZI%' , $listinoServizi, $main);

$pagina = str_replace('%DESCRIPTION%', "Listino prezzi dei servizi per la barba di Scissorhands." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "listino, prezzi, servizi, barba, rasatura, modellatura, regolazione barba, trattamenti, barbiere, scissorhands", $pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;