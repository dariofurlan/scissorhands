<?php

require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/radio_book.php';
require_once 'components/meta_index.php';
require_once 'components/confirm_form.php';

$pagina = page('Disponibilità - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$main = file_get_contents('../views/user/conferma.html');

require_once __DIR__ . '/../services/user/book.php';
require_once __DIR__ . '/../services/public/service.php';
require_once __DIR__ . '/../services/public/staff.php';

if (session_status() === PHP_SESSION_NONE)
	session_start();

if(!isset($_SESSION["sessionid"])) {
	header("Location: accedi.php");
	die();
}

if($_SESSION["type"] != "USER") {
	header("Location: prenotazioni.php"); 
	die();
}

$user_id = $_SESSION["sessionid"];

if (!UserBookingService::canBook($user_id)) {
    header("Location: prenotazioni.php");
	die();
}

$services = PublicServiceService::getAll();
$staff = PublicStaffService::getAll();

$selected_service = "";
if (isset($_GET["service"]) && preg_match('/^[0-9]+$/', $_GET["service"])) {
    $selected_service = $_GET["service"];
    $selected_service_name = PublicServiceService::get($selected_service)["name"];
}

$selected_staff = "";
if (isset($_GET["staff"]) && preg_match('/^[0-9]+$/', $_GET["staff"])) {
    $selected_staff = $_GET["staff"];
    $barber = PublicStaffService::get($selected_staff);
    $selected_staff_name = $barber["name"]." ".$barber["surname"];
}

$today = floor(time()/86400);
$selected_day = $today;
if (isset($_GET["day"]) && preg_match('/^[0-9]+$/', $_GET["day"])) {
    $selected_day = (int) $_GET["day"];
    $selected_day_ext = date("d/m", $selected_day*86400);
}
$selected_day_ext = date("d/m", $selected_day*86400);
$extended_date = "";
switch ($selected_day) {
    case $today:
        $extended_date = "di Oggi";
        break;
    case $today + 1:
        $extended_date = "di Domani";
        break;
    case $today - 1:
        $extended_date = "di Ieri";
        break;
    default:
        $extended_date = "del " . date("d/m", $selected_day * 86400);
}
$selected_day_ext = $extended_date;

$query = array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day
);
$prev_day = "conferma.php?" . http_build_query(array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day-1
));
$next_day = "conferma.php?" . http_build_query(array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day+1
));
$today_day = "conferma.php?" . http_build_query(array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => floor(time()/86400)
));

$main = str_replace("%PREV_DAY%", $prev_day, $main);
$main = str_replace("%NEXT_DAY%", $next_day, $main);
$main = str_replace("%TODAY_DAY%", $today_day, $main);


$backlink = "prenota.php?" . http_build_query(array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day
));

$confirm_form = "";
if (!empty($selected_service) && !empty($selected_staff) && !empty($selected_day)) {
    $slots = UserBookingService::getAvailableOfDay($selected_service, $selected_staff, $selected_day * 86400);
    if (!$slots || count($slots) === 0) {
        $confirm_form = "<p>Nessun orario disponibile.</p>";
    } else {
        $confirm_form = confirm_form($selected_service, $selected_staff, $selected_day, $slots);
    }
} else {
    header("Location: $backlink");
	die();
}

$header = _header(array("Prenotazioni" => "prenotazioni.php",  "Nuova prenotazione" => $backlink, "Orario" => "conferma.php"));

$main = str_replace("%CONFIRM_FORM%", $confirm_form, $main);
$main = str_replace("%SELECTED_DAY_EXT%", $selected_day_ext, $main);
$main = str_replace("%SELECTED_SERVICE_NAME%", $selected_service_name, $main);
$main = str_replace("%SELECTED_STAFF_NAME%", $selected_staff_name, $main);

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;