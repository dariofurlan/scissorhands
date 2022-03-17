<?php

function listino_servizi_edit($services) {
    if (count($services) === 0) return "";

    $out = file_get_contents(__DIR__ . '/../../views/components/listino_servizi_edit.html');    
    $listaServizi = "";
    foreach ($services as $service) {
        $listaServizi .= edit_servizio($service["_id"], $service["type"], $service["name"], $service["price"], $service["duration"], $service["description"]);
    }

    $out = str_replace('%LISTA_SERVIZI%', $listaServizi, $out);

    return $out;
}
