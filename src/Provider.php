<?php declare(strict_types=1);

abstract class Provider
{
    protected string $reqCommand = 'get_list';
    protected string $reqType = 'pb';
    protected string $reqReqid = '';
    protected int $reqFirst = 0;
    protected int $reqLast = 0;
    protected int $reqCount = 0;
    protected int $reqLimit = 0;
    protected string $reqReqsrc = 'user';
    protected int $reqLang = 2;
    protected int $reqMac = 0x0;
    protected string $reqId = '*';
    protected int $reqPrid = 1;

    /** @return Contact[] */
    abstract protected function queryByHomeNumber(string $phoneNumber): array;

    /** @return Contact[] */
    abstract protected function queryByAttributes(array $params): array;

    /**
     * @param Contact[] $contacts
     * @return bool|SimpleXMLElement|string
     */
    public function getXML(array $contacts)
    {
        if ($this->reqCommand == 'get_list') {
            return $this->toXML($contacts);
        } else {
            return $this->errorXML(2);
        }
    }

    public static function normalizePhoneNumber(string $number): string
    {
        $addAreaCode = getenv('ADD_AREA_CODE');
        $areaCode = getenv('AREA_CODE');
        # Add area code if phone number does not start with 0
        if ($addAreaCode && strncmp($number, '0', 1) != 0) {
            $number = $areaCode . $number;
        }
        return $number;
    }

    /**
     * Generate a error XML
     *
     * @param int $errorId 0-7
     * @param string $msg ( optional error message )
     * @return SimpleXMLElement errorxml
     * @access private
     **/
    private function errorXML(int $errorId, string $msg = ''): SimpleXMLElement
    {
        $errorMessages = [
            'OK',
            'not allowed',
            'syntax error',
            'duplicate',
            'invalid',
            'imprecise',
            'service not available',
            'requested format not available'
        ];
        $xml = new SimpleXMLElement('<error/>');
        $xml->addAttribute('response', $this->reqCommand);
        $xml->addAttribute('type', $this->reqType);
        $xml->addChild('errorid', $errorId);
        if ($msg != '') {
            $xml->addChild('message', $msg);
        } elseif ($errorId >= 0 && $errorId <= 7) {
            $xml->addChild('message', $errorMessages[$errorId]);
        }
        return $xml;
    }

    /**
     * @param Contact[] $contacts
     * @return SimpleXMLElement
     */
    private function toXML(array $contacts): SimpleXMLElement
    {
        if ($this->reqId != '*') {
            return $this->errorXML(2);
        }
        if ($this->reqFirst != 0 && $this->reqLast != 0) {
            return $this->errorXML(4, 'first and last parameters not allowed');
        }
        $xml = new SimpleXMLElement('<list response="get_list"/>');
        $xml->addAttribute('type', $this->reqType);
        $count = count($contacts);
        if ($count == 0) {
            $xml->addAttribute('notfound', 'phonenumber');
            $xml->addAttribute('total', strval(0));
        } else {
            $from = $this->reqFirst - 1;
            $to = $count - 1;
            if ($this->reqLast > 0) {
                $from = $this->reqLast - 1;
            }
            if ($this->reqLast == -1) {
                $from = $to - $this->reqCount;
            }
            if ($this->reqCount > 0) {
                $to = $from + $this->reqCount;
            }
            if ($from < 0) {
                $from = 0;
            }
            if ($to > $count - 1) {
                $to = $count - 1;
            }

            $xml->addAttribute('total', strval($count));
            $xml->addAttribute('first', strval($from + 1));
            $xml->addAttribute('last', strval($to + 1));

            for ($i = $from; $i <= $to; $i++) {
                $contact = $contacts[$i];
                $entry = $xml->addChild('entry');
                foreach ($contact->getAttributes() as $attr => $val) {
                    $entry->addChild($attr, $val);
                }
            }
        }
        return $xml;
    }
}