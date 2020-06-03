<?php
defined( 'INC' ) or die( header( 'HTTP/1.0 403 Forbidden' ) );

//-----------------------------------------
// Settings / Einstellungen
//-----------------------------------------

// Add area code true/false ( remove # )
// Vorwahl ergänzen ja/nein ( # entfernen )
$addAreaCode = false;

// Insert your area code here
// Eigene Vorwahl hier eingeben
// Beispiel 030 für Berlin
$areaCode = '030';

//-----------------------------------------
putenv( "ADD_AREA_CODE=$addAreaCode" );
putenv( "AREA_CODE=$areaCode" );

?>