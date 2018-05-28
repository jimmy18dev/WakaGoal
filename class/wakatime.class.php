<?php
class WakaTime{
    
    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
    }

    public function summaries($start,$end,$access_token){
        
        if(empty($access_token) || empty($start) || empty($end)) return false;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://wakatime.com/api/v1/users/current/summaries?start=".$start."&end=".$end,
            // CURLOPT_URL => "http://wakatime.local/summaries.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$access_token
            )
        ));

        $err = curl_error($curl);
        $summaries = json_decode(curl_exec($curl));

        return $summaries;
    }
}
?>