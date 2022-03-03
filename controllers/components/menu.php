<?php

function menulink($name, $ref, $current, $lang) {
    if (!$lang) $lang="";
    else $lang = 'lang="en"';
    $current_li = 'class=""';
    if ($current) {
        $current = 'aria-current="page"';
        $current_li = 'class="current"';
    }
        
    return "<li $current_li><a $current $lang href=\"$ref\">$name</a></li>";
}

function _menu($sess_type = "GUEST"){
    $template = file_get_contents(__DIR__.'/../../views/components/nav_menu.html');
    $out = $template;

    $pagine = array(
        "OWNER" => array (
            'Home' => 'index.php',
            'Servizi' => 'edit_servizi.php',
            'Staff' => 'staff.php',
            'Galleria' => 'galleria.php',
            'Contatti' => 'contatti.php',
            'Prenotazioni' => 'staff_prenotazioni.php',
            'Orari' => 'orari.php',
            'Esci' => 'logout.php'
        ),
        "USER" => array (
            'Home' => 'index.php',
            'Servizi' => 'servizi.php',
            'Staff' => 'staff.php',
            'Galleria' => 'galleria.php',
            'Contatti' => 'contatti.php',
            'Prenotazioni' => 'user_prenotazioni.php',
            'Profilo' => 'profilo.php',
            'Esci' => 'logout.php',
        ),
        "GUEST" => array (
            'Home' => 'index.php',
            'Servizi' => 'servizi.php',
            'Staff' => 'staff.php',
            'Galleria' => 'galleria.php',
            'Contatti' => 'contatti.php',
            'Prenota' => 'guest_prenota.php',
            'Accedi' => 'accedi.php',
            'Registrati' => 'registrati.php'
        )
    );

    $langs = array(
        "Home" => "en",
    );

    $current = strtok($_SERVER["REQUEST_URI"], '?');
    $url_els = explode("/",$current);
    $current = $url_els[count($url_els)-1];
    if ($current === "") $current = "index.php";

    $str = "";
    foreach($pagine[$sess_type] as $name => $ref){  
        $str .= menulink($name, $ref, $current == $ref, $langs[$name] ?? false);
    }
    
    $out=str_replace("%MENU_ELEMENTS%",$str,$out);

    return $out;
}

?>