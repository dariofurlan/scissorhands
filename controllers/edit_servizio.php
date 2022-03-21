<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/meta_index.php';
require_once '../services/public/service.php';
require_once '../services/staff/service.php';

$pagina = page('Modifica servizio - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$main = file_get_contents('../views/edit_servizio.html');

if(session_status() !== PHP_SESSION_ACTIVE)
    session_start();

if (empty($_SESSION["type"]) || !isset($_SESSION["type"]) || $_SESSION["type"] != "OWNER") {
	header("Location: servizi.php");
	die();
}

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
    } else {$err = "_id"; return $err;}
    if (isset($_POST["name"]) && preg_match('/^[a-zA-Z áéíóúàèìòù\']+$/', $_POST["name"])) {
        $book["name"] = $_POST["name"];
    } else {$err = "Nome del servizio non valido"; return $err; $currentName = $_POST["name"];}
    if (isset($_POST["duration"]) && preg_match('/^[0-9]+$/', $_POST["duration"])) {
        $book["duration"] = $_POST["duration"]*60;
    } else {$err = "Formato durata non valido"; return $err; $currentDuration = $_POST["duration"];}
    if (isset($_POST["price"]) && preg_match('/^[0-9]{1,5}(,[0-9]{1,2})?$/', $_POST["price"])) {
        $book["price"] = $_POST["price"];
    } else {$err = "Formato del prezzo non valido (serve la virgola)."; return $err; $currentPrice = $_POST["price"];}
    if (isset($_POST["description"]) && preg_match('/^[a-zA-Z \.\,\;áéíóúàèìòù\']+$/', $_POST["description"])) {
        $book["description"] = $_POST["description"];
    } else {$err = "Caratteri non validi nella descrizione"; return $err; $currentDescription = $_POST["description"];}

    StaffServiceService::update($book["_id"], $book["name"], $book["price"], $book["duration"], $book["description"]); 
}

if (isset($_POST) && !empty($_POST)) {
    $res = update();
	if(!empty($res))
	{
		$main = str_replace('%MESSAGGIO%', "<em><span role=\"alert\" id=\"cpw-error\"> $res </span></em>", $main);	
		
		//$main = str_replace('%NOME%', $currentName, $main);
		//$main = str_replace('%PREZZO%', $currentPrice, $main);
		//$main = str_replace('%DURATA%', $currentDuration, $main);
		//$main = str_replace('%DESCRIZIONE%', $currentDescription, $main);
	}
	else
	{
		$main = str_replace('%MESSAGGIO%', "<em><span role=\"alert\" id=\"cpw-success\"> Servizio modificato correttamente. </span></em>", $main);
	}
    $service = PublicServiceService::get($_GET["id"]);
}


$main = str_replace('%MESSAGGIO%', '', $main);
$main = str_replace('%ID%', $service["_id"], $main);
$main = str_replace('%TYPE%', $service["type"], $main);
$main = str_replace('%NOME%', $service["name"], $main);
$main = str_replace('%PREZZO%', number_format($service["price"], 2, ",", " "), $main);
$main = str_replace('%DURATA%', floor($service["duration"] / 60), $main);
$main = str_replace('%DESCRIZIONE%', $service["description"], $main);

$back_name = $service["type"] === "capelli"? "Modifica listino per i capelli": "Modifica listino per la barba";
$back_link = $service["type"] === "capelli"? "edit_listino_capelli.php": "edit_listino_barba.php";

$paths = array(
    "Modifica servizi" => "edit_servizi.php",
    $back_name => $back_link,
    "Modifica servizio" => "edit_servizio.php",
);
$header = _header($paths);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;