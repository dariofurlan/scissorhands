<?php

function listino_servizi($services) {
    if (count($services) === 0) return "";

    $out = file_get_contents(__DIR__ . '/../../views/components/listino_servizi.html');    
    $listaServizi = "";
    foreach ($services as $service) {
        $listaServizi .= _servizio($service["name"],$service["price"],$service["duration"],$service["description"]);
    }

    $out = str_replace('%LISTA_SERVIZI%', $listaServizi, $out);

    return $out;
}
