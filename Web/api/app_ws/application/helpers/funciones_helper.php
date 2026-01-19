<?php
function contiene($pajar, $aguja)
{
    if ($aguja == '') {
        return true;
    }
    return strpos($pajar, $aguja) !== false;
}
function randomPassword()
{
    $alphabet = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function autoload($path)
{
    $items = glob($path . DIRECTORY_SEPARATOR . "*");

    foreach ($items as $item) {
        $isPhp = pathinfo($item, PATHINFO_EXTENSION) === "php";

        if (is_file($item) && $isPhp) {
            require_once $item;
        } elseif (is_dir($item)) {
            autoload($item);
        }
    }
}
function datoToBoolean($valor) {
    return filter_var($valor, FILTER_VALIDATE_BOOLEAN);
}
function chrToStr($chr)
{
    $strTC = explode(',', $chr);
    $result = array();
    foreach ($strTC as $tc) {
        if ($tc == 'E') {
            $result[] = 'EMPRESA';
        } elseif ($tc == 'G') {
            $result[] = 'GESTOR';
        } elseif ($tc == 'F') {
            $result[] = 'FACTURADOR';
        } else {
            $result[] = '';
        }
    }
    return implode(' ', $result);
}
