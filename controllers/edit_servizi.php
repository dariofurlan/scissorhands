<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/meta_index.php';

$pagina = page('Modifica Servizi - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$paths = array(
    "Modifica servizi" => "edit_servizi.php"
);
$header = _header($paths);

if(empty($_SESSION["type"]) || !isset($_SESSION["type"]) ||$_SESSION["type"] != "OWNER")
{
	header("Location: servizi.php");
	die();
}

$main = file_get_contents('../views/edit_servizi.html');

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;