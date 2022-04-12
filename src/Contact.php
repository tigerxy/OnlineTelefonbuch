<?php declare(strict_types=1);

class Contact
{
    private array $attributes = array();

    private function getAttribute($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
        return null;
    }

    private function setAttribute($key, $val)
    {
        if ($val != null) {
            $this->attributes[$key] = $val;
        }
    }

    public function getLastName()
    {
        return $this->getAttribute('ln');
    }

    public function setLastName($s): Contact
    {
        $this->setAttribute('ln', $s);
        return $this;
    }

    public function getFirstName()
    {
        return $this->getAttribute('fn');
    }

    public function setFirstName($s): Contact
    {
        $this->setAttribute('fn', $s);
        return $this;
    }

    public function setNickname($s): Contact
    {
        $this->setAttribute('nn', $s);
        return $this;
    }

    public function setCity($s): Contact
    {
        $this->setAttribute('ct', $s);
        return $this;
    }

    public function setZipcode($s): Contact
    {
        $this->setAttribute('zc', $s);
        return $this;
    }

    public function setStreet($s): Contact
    {
        $this->setAttribute('st', $s);
        return $this;
    }

    public function setHouseNumber($s): Contact
    {
        $this->setAttribute('nr', $s);
        return $this;
    }

    public function setCountry($s): Contact
    {
        $this->setAttribute('co', $s);
        return $this;
    }

    public function getHomeNumber()
    {
        return $this->getAttribute('hm');
    }

    public function setHomeNumber($s): Contact
    {
        $this->setAttribute('hm', $s);
        return $this;
    }

    public function setFaxNumber($s): Contact
    {
        $this->setAttribute('fx', $s);
        return $this;
    }

    public function setMobileNumber($s): Contact
    {
        $this->setAttribute('mb', $s);
        return $this;
    }

    public function setSipNumber($s): Contact
    {
        $this->setAttribute('sip', $s);
        return $this;
    }

    /*
    Prefix                      pf
    Intprefix                   ipf
    Residence Name              rn
    Coordinates ( geograph. )   cd
    */

    public function setEmail($s): Contact
    {
        $this->setAttribute('em', $s);
        return $this;
    }

    public function setUrl($s): Contact
    {
        $this->setAttribute('url', $s);
        return $this;
    }

    /*
    Additional_info             ai
    Province_name               pn
    Subscriber                  sc
    */

    public function setCategory($s): Contact
    {
        $this->setAttribute('cat', $s);
        return $this;
    }

    public function setWhat($s): Contact
    {
        $this->setAttribute('wh', $s);
        return $this;
    }

    public function setBirthday($s): Contact
    {
        $this->setAttribute('bi', $s);
        return $this;
    }

    public function setJabber($s): Contact
    {
        $this->setAttribute('jid', $s);
        return $this;
    }

    public function setCompanyName($s): Contact
    {
        $this->setAttribute('cpn', $s);
        return $this;
    }

    /*
    Presence state              prs
    Availability Picture Clip   apc
    Picture Clip Format         pcf
    Internal Number             in
    Business number             bp
    */

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
