<?php

class GoogleRecaptcha 
{

    private $google_url = "https://www.google.com/recaptcha/api/siteverify";
    private $secret = '6LcMIAUTAAAAAK6N0fYteWV53vNab_t4v2uk9e5D';
 
    public function VerifyCaptcha($response)
    {
        $url = $this->google_url."?secret=".$this->secret.
               "&response=".$response;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true); 
        $curlData = curl_exec($curl);
        curl_close($curl); 
        $res = json_decode($curlData, true);
        return ($res['success'] == 'true'); 
    }
}

?>
