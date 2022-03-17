<?php
require_once  __DIR__ . '/components/page.php';
require_once  __DIR__ . '/components/header.php';
require_once  __DIR__ . '/components/booked_pending_staff.php';
require_once  __DIR__ . '/components/breadcrumb.php';
require_once  __DIR__ . '/components/meta_index.php';

if (session_status() === PHP_SESSION_NONE)
	session_start();

if(!isset($_SESSION["sessionid"]))
{
	header("Location: accedi.php");
	die();
}
if($_SESSION["type"] != "OWNER")
{
	header("Location: user_prenotazioni.php");
	die();
}
	
$user_id = $_SESSION["sessionid"];

$pagina = page('Prenotazioni - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$header = _header(array("Prenotazioni" => "staff_prenotazioni.php", "In attesa di conferma" => "pending.php"));
$main = file_get_contents( __DIR__ . '/../views/staff/pending.html');

require_once __DIR__ . '/../services/staff/book.php';
require_once __DIR__ . '/../services/public/staff.php';
require_once __DIR__ . '/../services/helpers.php';

if (isset($_POST) && !empty($_POST)) {
    $book = array(
        "reservation" => NULL,
        "action" => NULL,
    );
    if (isset($_POST["reservation"]) && preg_match('/^[0-9]+$/', $_POST["reservation"])) {
        $book["reservation"] = $_POST["reservation"];
    } else return;
    if (isset($_POST["action"]) && preg_match('/^(ACCEPT)|(REJECT)$/', $_POST["action"])) {
        $book["action"] = $_POST["action"];
    } else return;

    if ($book["reservation"] !== NULL && $book["action"] !== NULL) {
        if ($book["action"] === "ACCEPT") {
            StaffReservationService::confirm($book["reservation"]);
        }else if ($book["action"] === "REJECT") {
            StaffReservationService::reject($book["reservation"]);
        }
    }
}

$unconf = StaffReservationService::getAllUnconfirmed();
$strunconf = "";
foreach($unconf as $r) {
    $strunconf .= booked_pending_staff($r["_id"], $r["start_at"], $r["end_at"], $r["service"], $r["staff"], $r["price"], $r["customer_name"], $r["customer_surname"]);
}
$main = str_replace("%UNCONFIRMED%", $strunconf, $main);

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;