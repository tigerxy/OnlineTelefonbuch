<?php
defined( 'INC' ) or die( header( 'HTTP/1.0 403 Forbidden' ) );

class contact {
    private $attributes;

    private function setattr( $key, $val ) {
        if ( $val != null ) {
            $this->attributes[$key] = $val;
        }
    }

    public function setLastName( $s ) {
        $this->setattr( 'ln', $s );
    }

    public function setFirstName( $s ) {
        $this->setattr( 'fn', $s );
    }

    public function setNickname( $s ) {
        $this->setattr( 'nn', $s );
    }

    public function setCity( $s ) {
        $this->setattr( 'ct', $s );
    }

    public function setZipcode( $s ) {
        $this->setattr( 'zc', $s );
    }

    public function setStreet( $s ) {
        $this->setattr( 'st', $s );
    }

    public function setHouseNumber( $s ) {
        $this->setattr( 'nr', $s );
    }

    public function setCountry( $s ) {
        $this->setattr( 'co', $s );
    }

    public function setHomeNumber( $s ) {
        $this->setattr( 'hm', $s );
    }

    public function setFaxNumber( $s ) {
        $this->setattr( 'fx', $s );
    }

    public function setMobileNumber( $s ) {
        $this->setattr( 'mb', $s );
    }

    public function setSipNumber( $s ) {
        $this->setattr( 'sip', $s );
    }

    /*
    Prefix                      pf
    Intprefix                   ipf
    Residence Name              rn
    Coordinates ( geograph. )   cd
    */

    public function setEmail( $s ) {
        $this->setattr( 'em', $s );
    }

    public function setUrl( $s ) {
        $this->setattr( 'url', $s );
    }

    /*
    Additional_info             ai
    Province_name               pn
    Subscriber                  sc
    */

    public function setCategory( $s ) {
        $this->setattr( 'cat', $s );
    }

    public function setWhat( $s ) {
        $this->setattr( 'wh', $s );
    }

    public function setBirthday( $s ) {
        $this->setattr( 'bi', $s );
    }

    public function setJabber( $s ) {
        $this->setattr( 'jid', $s );
    }

    public function setCompanyName( $s ) {
        $this->setattr( 'cpn', $s );
    }

    /*
    Presence state              prs
    Availability Picture Clip   apc
    Picture Clip Format         pcf
    Internal Number             in
    Business number             bp
    */

    public function getAttributes() {
        return $this->attributes;
    }
}

?>