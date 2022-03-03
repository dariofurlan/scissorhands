<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/meta_index.php';

$pagina = page('Modifca Servizi - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$paths = array(
    "Modifica Servizi" => "edit_servizi.php"
);
$header = _header($paths);

$main = file_get_contents('../views/edit_servizi.html');

$pagina = str_replace('%DESCRIPTION%', "Eseguiamo servizi su capelli e barbe, usando forbici, macchinetta o lama a mano libera, per garantirti il risultato migliore." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "servizi, capelli, barba, forbici, lama a mano libera, macchinetta, anallergici, ecosostenibili, scissorhands, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;