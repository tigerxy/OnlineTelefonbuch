<?php
defined('INC') or die(header('HTTP/1.0 403 Forbidden'));
require_once('provider.php');

class oertliche extends provider
{
    public function query($params)
    {
        $phone_number = 0;
        if (array_key_exists('hm', $params) && $params['hm'] != '*') {
            $phone_number = $params['hm'];
            $this->normalizePhoneNumber($phone_number);

            $url = "http://www.dasoertliche.de/Controller?form_name=search_inv&ph=$phone_number";
        } else {
            $urlParams = "";
            foreach (array('fn' => 'fn', 'ln' => 'kw', 'cpn' => 'kw', 'ct' => 'ci', 'st' => 'st') as $key => $val) {
                if (array_key_exists($key, $params) && strlen($params[$key]) > 2)
                    $urlParams .= '&' . $val . '=' . $params[$key];
            }
            $url = "https://www.dasoertliche.de/?form_name=search_nat_ext$urlParams";
        }
        $matches = $this->QueryDasOertlicheDe($url);
        if ($matches != NULL) {
            foreach ($matches as $match) {
                $contact = new contact();
                $contact->setUrl($match[4]);
                $contact->setCity($match[5]);
                $contact->setZipcode($match[9]);
                $contact->setStreet($match[10]);
                $contact->setHouseNumber($match[11]);
                $contact->setLastName(explode(' ', $match[14], 2)[0]);
                $contact->setFirstName(explode(' ', $match[14], 2)[1]);
                $contact->setHomeNumber($phone_number);
                $this->addContact($contact);
            }
        }
    }

    private function QueryDasOertlicheDe($url)
    {
        $data = file_get_contents($url);
        preg_match(
            '/var\shandlerData\s=\s*(?P<v>(?>\[(?&v)?(?>\,\s*(?&v))*\])|(?>\"(\\\"|[^\"])*\")|(?>null));/mx',
            $data,
            $entry
        );
        return json_decode($entry[1]);
    }
}
