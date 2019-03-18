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
   $record = false;
   $url = "http://www.dasoertliche.de/Controller?form_name=search_inv&ph=$Rufnummer";
   # Create a DOM parser object
   $dom = new DOMDocument();
   # Parse the HTML from dasoertliche
   # The @ before the method call suppresses any warnings that
   # loadHTMLFile might throw because of invalid HTML or URL.
   @$dom->loadHTMLFile($url);
   if ($dom->documentURI == null)
   {
      die ('Timeout bei Abruf der Webseite '.$url);
      return false;
   }
   $finder = new DomXPath($dom);
   $classname="hit clearfix ";
   $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), '$classname')]");
   if ($nodes->length == 0) return false;
   $cNode = $nodes->item(0); //div left
   if ($cNode->nodeName != 'div') return false;
   if (!$cNode->hasChildNodes()) return false;
   $ahref = $cNode->childNodes->item(1);
   if (!$ahref->hasChildNodes()) return false;
   foreach ($ahref->childNodes as $div)
   {
      if ($div->nodeName == "a" ) break;
   }
    return utf8_encode(trim(utf8_decode($div->nodeValue), " \t\n\r\0\xa0"));
}  

$hm = $_GET["hm"];

# Add area code if phone number does not start with 0
if ($addAreaCode && strncmp($hm,"0",1) != 0) {
    $hm = $areaCode.$hm;
}

$name = QueryDasOertlicheDe($hm);

$xml = '';
if ($name == "") {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<list response="get_list" type="pb" notfound="hm" total="0"/>';
} else {
    $name = explode(' ',$name,2);
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<list response="get_list" type="pb" total="1" first="1" last="1">
    <entry>
        <ln>'.$name[0].'</ln>
        <fn>'.$name[1].'</fn>
        <hm>'.$hm.'</hm>
    </entry>
</list>';
}

header('Content-Type: text/xml; charset=utf-8');
print ($xml);
?>
