<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/edit_servizio.php';
require_once '../services/public/service.php';
require_once '../services/staff/service.php';
require_once 'components/meta_index.php';

$pagina = page('Modifica Listino capelli - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Modifica Servizi" => "edit_servizi.php",
    "Modifica Listino per i capelli" => "edit_listino_capelli.php",
);
$header = _header($path);

$main = file_get_contents('../views/edit_listino_capelli.html');


if (isset($_POST) && !empty($_POST) && isset($_POST["action"]) && $_POST["action"] === "CREATE") {
    StaffServiceService::createCapelli("Nuovo Servizio Capelli", 0.0, 0, "");
}

if (isset($_POST) && !empty($_POST) && isset($_POST["action"]) && $_POST["action"] === "DELETE" && isset($_POST["servizio"]) && preg_match('/^[0-9]+$/', $_POST["servizio"])) {
    StaffServiceService::delete($_POST["servizio"]);
}


$services = PublicServiceService::getAllCapelli();

$listaServizi = "";
foreach($services as $service) {      
    $listaServizi .= edit_servizio($service["_id"], $service["type"], $service["name"], $service["price"], $service["duration"], $service["description"]);  
}

$main = str_replace('%LISTA_SERVIZI%' , $listaServizi, $main);

$pagina = str_replace('%DESCRIPTION%', "Listino prezzi dei servizi per i capelli di Scissorhands." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "listino, prezzi, servizi, capelli, taglio, tinta, lavaggio, piega, trattamento, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;