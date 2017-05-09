<?php 

function sendPostRequest($postargs,$token, $cal){
        $APIKEY = 'AIzaSyCBgCHben7bTtLRf3TA0bAhBtGnBUtRI5Q';
        $request = 'https://www.googleapis.com/calendar/v3/calendars/' . $cal . '/events?pp=1&key=' . $APIKEY;
 
        //$auth = json_decode($_SESSION['oauth_access_token'],true);
 
        //var_dump($auth);
 
        $session = curl_init($request);
 
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, true);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session, CURLINFO_HEADER_OUT, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:  application/json','Authorization:  Bearer ' . $token,'X-JavaScript-User-Agent:  Mount Pearl Tennis Club Bookings'));
     
        $response = curl_exec($session);
    
        //echo '<pre>';
        //var_dump(curl_getinfo($session, CURLINFO_HEADER_OUT)); 
        //echo '</pre>';
         
        curl_close($session);
        return $response;
}
 
 
function createPostArgsJSON($sdate,$edate,$starttime,$endtime,$title,$where,$request){
        $arg_list = func_get_args();
        foreach($arg_list as $key => $arg){
                $arg_list[$key] = urlencode($arg);
        }
        $postargs = <<<JSON
{
 "start": {
  "dateTime": "{$sdate}T{$starttime}:00.000+05:30"
 },
 "end": {
  "dateTime": "{$edate}T{$endtime}:00.000+05:30"
 },
 "summary": "$title",
 "description": "$request",
 "location": "$where"
}
JSON;
        return $postargs;
}
// 
//-Post value to calender
//
$date = "01/26/2017";
$enddate =$startdate = date("Y-m-d", strtotime($date));
$starttime = '05:00';
$endtime ='18:00';
$calendarId ="7bs4tiq9ncd68j3mcgk5vea788@group.calendar.google.com";

$postargs = createPostArgsJSON($startdate,$enddate,$starttime,$endtime,"Test Calender","Mangalur","Hi");
//print_r($postargs);

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
        
        
        
$token = $accessToken;

$result = sendPostRequest($postargs,$token,$calendarId);
echo '<pre>' . $result . '</pre>';

?>