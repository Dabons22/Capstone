<?php 

    class TextMessage{
        
        public function sendSMS($number,$message){
            $apiCode = 'TR-ITVEN505307_KWLKQ';
            $apiPass = '}jj@cfwl6n';
            $ch = curl_init();
            $itexmo = array(
                '1'=>$number,
                '2'=>$message,
                '3'=>$apiCode,
                'passwd'=>$apiPass
            );

            curl_setopt($ch,CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($itexmo));
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            return curl_exec($ch);
            curl_close($ch);
        }
    }