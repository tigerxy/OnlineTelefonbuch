<?php
defined( 'INC' ) or die( header( 'HTTP/1.0 403 Forbidden' ) );
require_once( 'contact.php' );

abstract class provider {
    /** @var \contact[] */
    private $results = [];

    protected $reqCommand = 'get_list';
    protected $reqType = 'pb';
    protected $reqReqid = '';
    protected $reqFirst = 0;
    protected $reqLast = 0;
    protected $reqCount = 0;
    protected $reqLimit = 0;
    protected $reqReqsrc = 'user';
    protected $reqLang = 2;
    protected $reqMac = 0x0;
    protected $reqId = '*';
    protected $reqPrid = 1;

    abstract protected function query( $params );

    public function count() {
        return count( $this->results );
    }

    public function getXML() {
        if ( $this->reqCommand == 'get_list' ) {
            return $this->getList();
        } else {
            return $this->errorXML( 2 );
        }
    }

    protected function addContact( $contact ) {
        if ( is_a( $contact, 'contact' ) ) {
            array_push( $this->results, $contact );
        }
    }

    protected function normalizePhoneNumber( &$number ) {
        $addAreaCode = getenv( 'ADD_AREA_CODE' );
        $areaCode = getenv( 'AREA_CODE' );
        # Add area code if phone number does not start with 0
        if ( $addAreaCode && strncmp( $number, '0', 1 ) != 0 ) {
            $number = $areaCode.$number;
        }
    }

    /**
    * Generate a error XML
    *
    * @param int $errorid 0-7
    * @param string $msg ( optional error message )
    * @return \SimpleXMLElement errorxml
    * @access private
    **/

    private function errorXML( $errorid, $msg = '' ) {
        $predeferrormsg = [
            'OK',
            'not allowed',
            'syntax error',
            'duplicate',
            'invalid',
            'imprecise',
            'service not available',
            'requested format not available'
        ];
        $xml = new SimpleXMLElement( '<error/>' );
        $xml->addAttribute( 'response', $this->reqCommand );
        $xml->addAttribute( 'type', $this->reqType );
        $xml->addChild( 'errorid', $errorid );
        if ( $msg != '' ) {
            $xml->addChild( 'message', $msg );
        } elseif ( $errorid >= 0 && $errorid <= 7 ) {
            $xml->addChild( 'message', $predeferrormsg[$errorid] );
        }
        return $xml;
    }

    private function getList() {
        if ( $this->reqId != '*' ) {
            return $this->errorXML( 2 );
        }
        if ( $this->reqFirst != 0 && $this->reqLast != 0 ) {
            return $this->errorXML( 4, 'first and last parameters not allowed' );
        }
        $xml = new SimpleXMLElement( '<list response="get_list"/>' );
        $xml->addAttribute( 'type', $this->reqType );
        if ( $this->count() == 0 ) {
            $xml->addAttribute( 'notfound', 'phonenumber' );
            $xml->addAttribute( 'total', 0 );
        } else {
            $from = $this->reqFirst-1;
            $to = $this->count()-1;
            if ( $this->reqLast > 0 ) {
                $from = $this->reqLast-1;
            }
            if ( $this->reqLast == -1 ) {
                $from = $to - $this->reqCount;
            }
            if ( $this->reqCount>0 ) {
                $to = $from + $this->reqCount;
            }
            if ( $from < 0 ) {
                $from = 0;
            }
            if ( $to > $this->count()-1 ) {
                $to = $this->count()-1;
            }

            $xml->addAttribute( 'total', $this->count() );
            $xml->addAttribute( 'first', $from+1 );
            $xml->addAttribute( 'last', $to+1 );

            for ( $i = $from; $i <= $to; $i++ ) {
                $contact = $this->results[$i];
                $entry = $xml->addChild( 'entry' );
                foreach ( $contact->getAttributes() AS $attr => $val ) {
                    $entry->addChild( $attr, htmlspecialchars($val) );
                }
            }
        }
        return $xml->asXML();
    }
}

?>