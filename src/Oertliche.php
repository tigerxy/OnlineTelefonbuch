<?php declare(strict_types=1);

class Oertliche extends Provider
{
    private HTTPClient $network;

    public function __construct(HTTPClient $network = null)
    {
        if ($network != null) {
            $this->network = $network;
        } else {
            $this->network = new HTTPClient();
        }
    }

    /** @return Contact[] */
    public function queryByHomeNumber(string $phoneNumber): array
    {
        $phoneNumber = $this->normalizePhoneNumber($phoneNumber);

        $url = "https://www.dasoertliche.de/Controller?form_name=search_inv&ph=$phoneNumber";

        $matches = $this->queryDasOertlicheDe($url);

        return array_map(function ($match) use ($phoneNumber) {
            return $this->toContact($match)->setHomeNumber($phoneNumber);
        }, $matches);
    }

    /** @return Contact[] */
    public function queryByAttributes(array $params): array
    {
        $urlParams = "";
        foreach (array('fn' => 'fn', 'ln' => 'kw', 'cpn' => 'kw', 'ct' => 'ci', 'st' => 'st') as $key => $val) {
            if (array_key_exists($key, $params) && strlen($params[$key]) > 2)
                $urlParams .= '&' . $val . '=' . $params[$key];
        }
        $url = "https://www.dasoertliche.de/?form_name=search_nat_ext$urlParams";

        $matches = $this->queryDasOertlicheDe($url);

        return array_map(function ($match) {
            return $this->toContact($match);
        }, $matches);
    }

    /**
     * @param string $url
     * @return mixed
     */
    private function queryDasOertlicheDe(string $url)
    {
        $data = $this->network->get($url);
        preg_match(
            '/var\shandlerData\s=\s*(?P<v>(?>\[(?&v)?(?>\,\s*(?&v))*\])|(?>\"(\\\"|[^\"])*\")|(?>null));/mx',
            $data,
            $entry
        );
        return json_decode($entry[1]);
    }

    /**
     * @param $match
     * @return Contact
     */
    public function toContact($match): Contact
    {
        $contact = new Contact();
        $contact->setUrl($match[4]);
        $contact->setCity($match[5]);
        $contact->setZipcode($match[9]);
        $contact->setStreet($match[10]);
        $contact->setHouseNumber($match[11]);
        $contact->setLastName(explode(' ', $match[14], 2)[0]);
        $contact->setFirstName(explode(' ', $match[14], 2)[1]);
        return $contact;
    }
}
