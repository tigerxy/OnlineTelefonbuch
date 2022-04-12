<?php declare(strict_types=1);
const INC = true;

if (!getenv('DOCKER')) {
    include_once('config.php');
}

require('src/Oertliche.php');

$provider = new Oertliche();
if (array_key_exists("hm", $_GET)) {
    $contacts = $provider->queryByHomeNumber($_GET["hm"]);
} else {
    $contacts = $provider->queryByAttributes($_GET);
}

header('Content-Type: text/xml; charset=utf-8');
print($provider->getXML($contacts));