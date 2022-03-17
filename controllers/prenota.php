<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/radio_book.php';
require_once 'components/meta_index.php';

$pagina = page('Prenota - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$header = _header(array("Prenotazioni" => "user_prenotazioni.php", "Nuova prenotazione" => "prenota.php"));

$main = file_get_contents('../views/user/prenota.html');

require_once __DIR__ . '/../services/user/book.php';
require_once __DIR__ . '/../services/public/company.php';
require_once __DIR__ . '/../services/public/service.php';
require_once __DIR__ . '/../services/public/staff.php';
require_once __DIR__ . '/../services/helpers.php';

if (session_status() === PHP_SESSION_NONE)
	session_start();

if(!isset($_SESSION["sessionid"])) {
	header("Location: accedi.php");
	die();
}
if($_SESSION["type"] != "USER") {
	header("Location: staff_prenotazioni.php"); 
	die();
}

$user_id = $_SESSION["sessionid"];

if (!UserBookingService::canBook($user_id)) {
    header("Location: user_prenotazioni.php");
	die();
}

$services = PublicServiceService::getAll();
$staff = PublicStaffService::getAll();

$selected_service = "";
if (isset($_GET["service"]) && preg_match('/^[0-9]+$/', $_GET["service"])) {
    $selected_service = $_GET["service"];
}

$selected_staff = "";
if (isset($_GET["staff"]) && preg_match('/^[0-9]+$/', $_GET["staff"])) {
    $selected_staff = $_GET["staff"];
}

$selected_day = "";
if (isset($_GET["day"]) && preg_match('/^[0-9]+$/', $_GET["day"])) {
    $selected_day = $_GET["day"];
}

$radios_services = "";
foreach ($services as $service) {
    $radios_services .= radio_book($service["name"], "service", $service["_id"], "service-" . $service["_id"], boolval($selected_service == $service["_id"]));
}

$radios_staff = "";
foreach ($staff as $member) {
    $radios_staff .= radio_book($member["name"] . " " . $member["surname"], "staff", $member["_id"], "staff-" . $member["_id"], boolval($selected_staff == $member["_id"]));
}

$radios_giorno = "";
$today = floorDay(time()) / 86400;
$opendays = parseDaysSet(PublicCompanyService::get()["days"]);
for ($i = $today; $i < $today + 7; $i++) {
    $name = getDayOfWeekSTR($i * 86400);
    $dow = getDayOfWeek($i * 86400);
    if ($i == $today) $name = "Oggi ($name)";
    elseif ($i == $today + 1) $name = "Domani ($name)";
    $radios_giorno .= radio_book($name, "day", $i, "day-" . $i, boolval($selected_day == $i), !$opendays[$dow]);
}

$main = str_replace("%RADIOS_SERVICE%", $radios_services, $main);
$main = str_replace("%RADIOS_STAFF%", $radios_staff, $main);
$main = str_replace("%RADIOS_GIORNO%", $radios_giorno, $main);

$main = str_replace("%SELECTED_SERVICE%", $selected_service, $main);
$main = str_replace("%SELECTED_STAFF%", $selected_staff, $main);
$main = str_replace("%SELECTED_DAY%", $selected_day, $main);

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;