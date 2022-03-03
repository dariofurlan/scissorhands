<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/meta_index.php';
require_once '../services/public/service.php';
require_once '../services/staff/service.php';

$pagina = page('Modifica Servizio - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$paths = array(
    "Modifica Servizi" => "edit_servizi.php",
    "Modifica Servizio" => "edit_servizio.php"
);
$header = _header($paths);

$main = file_get_contents('../views/edit_servizio.html');

if (!isset($_GET["id"]) || empty($_GET["id"]) || !preg_match('/^[0-9]+$/', $_GET["id"])) {
    header("Location: edit_servizi.php");
	die();
}

$service = PublicServiceService::get($_GET["id"]);
if (!$service) {
    header("Location: edit_servizi.php");
	die();
}

function update() {
    $book = array(
        "_id" => NULL,
        "name" => NULL,
        "duration" => NULL,
        "price" => NULL,
        "description" => NULL,
    );
    $err = "";
    if (isset($_POST["_id"]) && preg_match('/^[0-9]+$/', $_POST["_id"])) {
        $book["_id"] = $_POST["_id"];
    } else {$err = "_id"; return $err; }
    if (isset($_POST["name"]) && preg_match('/^[a-zA-Z ]+$/', $_POST["name"])) {
        $book["name"] = $_POST["name"];
    } else {$err = "name"; return $err; }
    if (isset($_POST["duration"]) && preg_match('/^[0-9]+$/', $_POST["duration"])) {
        $book["duration"] = $_POST["duration"]*60;
    } else {$err = "duration"; return $err; }
    if (isset($_POST["price"]) && preg_match('/^[0-9]{1,5}(,[0-9]{1,2})?$/', $_POST["price"])) {
        $book["price"] = $_POST["price"];
    } else {$err = "price"; return $err; }
    if (isset($_POST["description"]) && preg_match('/^[a-zA-Z \.\,]+$/', $_POST["description"])) {
        $book["description"] = $_POST["description"];
    } else {$err = "description"; return $err; }

    StaffServiceService::update($book["_id"], $book["name"], $book["price"], $book["duration"], $book["description"]); 
}

if (isset($_POST) && !empty($_POST)) {
    update();
    $service = PublicServiceService::get($_GET["id"]);
}


$main = str_replace('%ID%', $service["_id"], $main);
$main = str_replace('%TYPE%', $service["type"], $main);
$main = str_replace('%NOME%', $service["name"], $main);
$main = str_replace('%PREZZO%', number_format($service["price"], 2, ",", " "), $main);
$main = str_replace('%DURATA%', floor($service["duration"] / 60), $main);
$main = str_replace('%DESCRIZIONE%', $service["description"], $main);


$pagina = str_replace('%DESCRIPTION%', "Eseguiamo servizi su capelli e barbe, usando forbici, macchinetta o lama a mano libera, per garantirti il risultato migliore." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "servizi, capelli, barba, forbici, lama a mano libera, macchinetta, anallergici, ecosostenibili, scissorhands, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;