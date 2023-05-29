<?php
require_once 'auth.php';
if (!checkAuth()) exit;

// Imposto l'header della risposta
header('Content-Type: application/json');

edamam();

function edamam() {
    $app_id =     "d3f006f7";
    $app_key = "e72972aae51a6a808e4c3ad0517bd307";  

    $query = urlencode($_GET["q"]);
    $url = 'https://api.edamam.com/api/recipes/v2?type=public&q='.$query.'&app_id='.$app_id.'&app_key='.$app_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json",
        "Accept-Language: it"
    ));
    $res=curl_exec($ch);
    curl_close($ch);

    echo $res;
}
?>