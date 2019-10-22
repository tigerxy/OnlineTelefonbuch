<?php
$addAreaCode = false;

#-----------------------------------------#
# Settings / Einstellungen                #
#-----------------------------------------#

# Add area code true/false (remove #)
# Vorwahl ergänzen ja/nein (# entfernen)
#$addAreaCode = true;

# Insert your area code here
# Eigene Vorwahl hier eingeben
$areaCode = "030";

#-----------------------------------------#

function QueryDasOertlicheDe($Rufnummer) {
   $url = "http://www.dasoertliche.de/Controller?form_name=search_inv&ph=$Rufnummer";
    $data = file_get_contents($url);
    preg_match('/var handlerData = \[\[\'.*\',\'.*\',\'.*\',\'.*\',\'.*\',\'(.*)\',\'.*\', \'.*\', \'.*\', \'(.*)\', \'(.*)\', \'(.*)\', \'.*\', \'.*\', \'(\S*) (.*)\', \'.*\'\]\];/m', $data, $entry);
    return $entry;
}

function addTagIfNotZero($tag,$str) {
    return $str != '0' ? '<'.$tag.'>'.$str.'</'.$tag.'>' : '';
}

$hm = $_GET["hm"];

# Add area code if phone number does not start with 0
if ($addAreaCode && strncmp($hm,"0",1) != 0) {
    $hm = $areaCode.$hm;
}

$name = QueryDasOertlicheDe($hm);

$xml = '';
if (count($name) == 0) {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<list response="get_list" type="pb" notfound="hm" total="0"/>';
} else {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<list response="get_list" type="pb" total="1" first="1" last="1">
    <entry>
        '.addTagIfNotZero('ln',$name[5]).'
        '.addTagIfNotZero('fn',$name[6]).'
        '.addTagIfNotZero('ct',$name[1]).'
        '.addTagIfNotZero('st',$name[3]).'
        '.addTagIfNotZero('nr',$name[4]).'
        <hm>'.$hm.'</hm>
    </entry>
</list>';
}

header('Content-Type: text/xml; charset=utf-8');
print ($xml);
?>
