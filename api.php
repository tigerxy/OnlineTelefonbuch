<?php
define( 'INC', true );
if ( !getenv( 'DOCKER' ) ) {
    include_once('config.php');
}
require( 'src/Oertliche.php' );

$o = new Oertliche();
$o->query( $_GET );

header( 'Content-Type: text/xml; charset=utf-8' );
print( $o->getXML() );

?>