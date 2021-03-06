<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/edit_servizio.php';
require_once '../services/public/service.php';
require_once '../services/staff/service.php';
require_once 'components/meta_index.php';
require_once "components/listino_servizi_edit.php";

$pagina = page('Modifica listino capelli - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Modifica servizi" => "edit_servizi.php",
    "Modifica listino per i capelli" => "edit_listino_capelli.php",
);
$header = _header($path);

if (empty($_SESSION["type"]) || !isset($_SESSION["type"]) || $_SESSION["type"] != "OWNER") {
    header("Location: servizi.php");
    die();
}

$main = file_get_contents('../views/edit_listino_capelli.html');


if (isset($_POST) && !empty($_POST) && isset($_POST["action"]) && $_POST["action"] === "CREATE") {
    StaffServiceService::createCapelli("Nuovo servizio capelli", 1.0, 60, "Descrizione.");
}

if (isset($_POST) && !empty($_POST) && isset($_POST["action"]) && $_POST["action"] === "DELETE" && isset($_POST["servizio"]) && preg_match('/^[0-9]+$/', $_POST["servizio"])) {
    StaffServiceService::delete($_POST["servizio"]);
}


$services = PublicServiceService::getAllCapelli();

$listinoServizi = listino_servizi_edit($services);

$main = str_replace('%LISTINO_SERVIZI%', $listinoServizi, $main);

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
