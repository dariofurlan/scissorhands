<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Galleria - Scissorhands');

$path = array(
    "Galleria" => "/galleria.php"
);
$header = _header($path);

$main = file_get_contents('../views/galleria.html');

$pagina = str_replace('%DESCRIPTION%', "Foto dei lavori e del negozio Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "galleria, foto, tagli, capelli, barba, acconciature, scissorhands, barbiere, parrucchiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;