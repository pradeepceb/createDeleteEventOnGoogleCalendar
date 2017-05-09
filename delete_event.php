<?php

        $calendarId ="7bs4tiq9ncd68j3mcgk5vea788@group.calendar.google.com";
        $eventId = 'o37cuu56ac65bk1ucp95pciveg';


        $APIKEY = 'AIzaSyCBgCHben7bTtLRf3TA0bAhBtGnBUtRI5Q';    
        
        $tokenURL = 'https://accounts.google.com/o/oauth2/token';
        $postData = array(
			'client_secret'=>'TbsQWnKPRUkhCdjYFMjrMKRX',
			'grant_type'=>'refresh_token',
			'refresh_token'=>'1/kdKV10PnkM7y0WeAmC9fF1Lznwn5MBhn1P3CwvYd0a252YlhgT6hM3tTWan-5bYj',
			'client_id'=>'1096366798109-89j8o33jcnhb8id6hlcu51gvuhu6r0fd.apps.googleusercontent.com'
		);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        $tokenReturn = curl_exec($ch);
        $token = json_decode($tokenReturn);
        //var_dump($tokenReturn);
        $accessToken = $token->access_token;
        
        //$token = getAccessToken();
        //echo $token; exit;
        
        //var_dump($auth);
        $request = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendarId . '/events/'.$eventId.'?sendNotifications=true&key=' . $APIKEY;
               
        $ch = curl_init($request);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Authorization: Bearer '. $accessToken)
);
        $response = curl_exec($ch);
         $httpCode = curl_getinfo($response, CURLINFO_HTTP_CODE);
         echo $httpCode;exit; 
        $result = json_decode($response);       


       echo "<pre>";
       print_r($result);
       echo "PRADDDDD";

?>