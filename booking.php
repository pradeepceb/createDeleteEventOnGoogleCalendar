

<?php

/* 
* YOU WILL NEED YOUR GOOGLE API KEY FOR THIS TO WORK
*
* You will also notice many areas that are commented out which can be used for debugging by uncommenting them.
*
*/

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
 
function sendGetRequest($token,$request){
        $APIKEY = 'AIzaSyCBgCHben7bTtLRf3TA0bAhBtGnBUtRI5Q';
        //$request = 'https://www.googleapis.com/calendar/v3/calendars/' . $CAL . '/events?pp=1&key=' . $APIKEY;
 
        //$auth = json_decode($_SESSION['oauth_access_token'],true);
 
        //var_dump($auth);
 
        $session = curl_init($request);
 
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_HTTPGET, true);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLINFO_HEADER_OUT, false);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization:  Bearer ' . $token,'X-JavaScript-User-Agent:  Mount Pearl Tennis Club Bookings'));
 
        $response = curl_exec($session);
 
        //echo '<pre>';
        //var_dump(curl_getinfo($session, CURLINFO_HEADER_OUT)); 
        //echo '</pre>';
 
        curl_close($session);
        return $response;
}
 
function createPostArgsJSON($date,$starttime,$endtime,$title,$where,$request){
        $arg_list = func_get_args();
        foreach($arg_list as $key => $arg){
                $arg_list[$key] = urlencode($arg);
        }
        $postargs = <<<JSON
{
 "start": {
  "dateTime": "{$date}T{$starttime}:00.000-08:00"
 },
 "end": {
  "dateTime": "{$date}T{$endtime}:00.000-08:00"
 },
 "summary": "$title",
 "description": "$request",
 "location": "$where"
}
JSON;
        return $postargs;
}
 
/*
*  ----- INSTRUCTIONS FOR THIS SECTION -----
*
* Go to http://enarion.net/programming/php/google-client-api/google-client-api-php/<br>
* Follow the tutorial step by step and then come back and fill in the information below. 
*
*/ 
function getAccessToken(){
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
        return $accessToken;
}
 
function isTimeBooked($date,$starttime,$endtime,$cal){
        $APIKEY = 'AIzaSyCBgCHben7bTtLRf3TA0bAhBtGnBUtRI5Q';
        $start = $date . 'T' . '09:00:00.000-08:00';
        $end = $date . 'T' . '20:00:00.000-08:00';
        $token = getAccessToken();
        $result = sendGetRequest($token, 'https://www.googleapis.com/calendar/v3/calendars/' . $cal . '/events?timeMax=' . $end . '&timeMin=' . $start . '&fields=items(end%2Cstart)&key=' . $APIKEY);
		//var_dump($result);
		
		$json_obj = json_decode( $result );
		//var_dump($json_obj);
		foreach($json_obj as $obj)
			{	
			  //echo '<br>';
			  //print_r($obj);
			  //echo '<br>';
			  //echo '<br>';
			  
			  $count = count($obj); 
			}
		//echo $count;	
        if($count >= 1){
                return $obj; 
        }
        else{
                return false;
        }
}


function getEndLocation($date,$starttime,$endtime,$cal){
        $APIKEY = 'AIzaSyCBgCHben7bTtLRf3TA0bAhBtGnBUtRI5Q';
        $start = $date . 'T' . $starttime . ':00.000-08:00';
        $end = $date . 'T' . $endtime . ':00.000-08:00';
        $token = getAccessToken();
        $result = sendGetRequest($token, 'https://www.googleapis.com/calendar/v3/calendars/' . $cal . '/events?timeMax=' . $end . '&timeMin=' . $start . '&fields=items%2Flocation&key=' . $APIKEY);
		//var_dump($result);
		
		$json_obj = json_decode( $result );
		
	
		foreach($json_obj as $obj )
			{	
			  echo '<br>';
			  //print_r($obj);
			  echo '<br>';
			  //var_dump($obj);
			  //echo '<br>';
			  //echo $obj[0]->location;
			  $endLocation = $obj[0]->location;
			  //echo '<br>';
			  //echo '<br>';
			  $count = count($obj); 
			}
		//echo $count;	
        if($count >= 1){
				return $endLocation;
        }
        else{
                return false;
        }
}


   
function checkCourtRegistrations($startdate,$starttime,$enddate,$endtime,$cal){
       $APIKEY = 'AIzaSyCBgCHben7bTtLRf3TA0bAhBtGnBUtRI5Q';
        $start = $startdate . 'T' . $starttime . ':00-08:00';
        $end = $enddate . 'T' . $endtime . ':00-08:00';
        $token = getAccessToken();
        $result = sendGetRequest($token, 'https://www.googleapis.com/calendar/v3/calendars/' . $cal . '/events?timeMax=' . $end . '&timeMin=' . $start . '&fields=items(end%2Cstart%2Csummary)%2Csummary&pp=1&key=' . $APIKEY);
        if(strlen($result) > 5){
            $result = json_decode($result,true);
            //return array($result['summary'] => $result['items']);
            return array('items' => $result['items'], 'court' => $result['summary']);
        }
        else{
            return '';
        }
}


// Haversine formula
function Haversine($start, $finish) {
	
	$theta = $start[1] - $finish[1]; 
	$distance = (sin(deg2rad($start[0])) * sin(deg2rad($finish[0]))) + (cos(deg2rad($start[0])) * cos(deg2rad($finish[0])) * cos(deg2rad($theta))); 
	$distance = acos($distance); 
	$distance = rad2deg($distance); 
	$distance = $distance * 60 * 1.1515; 
	
	return round($distance, 2);

}

// Get lat/long co-ords
function getLatLong($address) {
		
	$address = str_replace(' ', '+', $address);
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&sensor=false';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$geoloc = curl_exec($ch);
	
	$json = json_decode($geoloc);
	return array($json->results[0]->geometry->location->lat, $json->results[0]->geometry->location->lng);
	
}
/* 
 * End Core Calendar Functions (contents of the corecal.php file above)
 */
 
 
 ?>
<?php
//require_once('libs/cal/corecal.php');

$thecal = 'court1';



/*
 * Advance is the amount of time in the future someone can book something.
 * days
 * weeks
 * months
 * If it is 0, it will allow unlimited future booking
 */
 
/* 
 * ------ Instructions ------
 * Fill in where is says put calendar id with the id of your calendar which can be found by doing the following. 
 * 
 * 1. Access your Google Calendar at https://www.calendar.google.com.
 * 2. Click on the drop down arrow next to the affected calendar and select 'Calendar settings'
 * 3. Copy the string beside 'Calendar ID' and paste it in.
 *
 * You will also need the API Key for Google Calendar as well.
 */ 
 
 $calendarId = "7bs4tiq9ncd68j3mcgk5vea788@group.calendar.google.com";
 
$courts = array(
        'court1' => array('cid' => 'court1', 'name' => 'court1', 'id' => '7bs4tiq9ncd68j3mcgk5vea788@group.calendar.google.com', 'starttime' => '10:00:00', 'endtime' => '20:00:00', 'advance' => '52 weeks'),
        
);
 
$APIKEY = 'AIzaSyCBgCHben7bTtLRf3TA0bAhBtGnBUtRI5Q';
 
$message = "";
 
if(isset($_POST['submit']) && $_POST['submit'] == 'Book Court'){
        
	  /* This section is to set the date in the correct format 
	   * and to set the ending time to 15 minutes past the time
	   * that they selected and set time to 15 minuts prior
	   * to the time they selected which is used to determine
	   * information about the location of each booking and if
	   * the driver can get to the two places within one trip. 
	   */
	  
				$date = $_POST['startdate'];
				$startdate = date("Y-m-d", strtotime($date));
				$From = $_POST['starttime'];
				$Minutes = 15;
				$endtime1 = date("H:i", strtotime($From)+($Minutes*60));
				$locationStartTime = date("H:i", strtotime($From)-($Minutes*60));
				$endtime;
				
		/* This section gets the location that the user wants to be picked up
		 * and gets the location of any booking that is 15 minutes before or 
		 * 15 minutes after the time that they selected. It then will get the
		 * distance between the two points in miles. 
		 */	
				//$startlocation = $_POST['location'];
        		//$endlocation = getEndLocation($startdate,$locationStartTime,$endtime1,$courts[$_POST['calendar']]['id']);
				//$startLoc = $startlocation;
				//$endLoc = $endlocation;
				//if ($endlocation != ""){
					//$start = getLatLong($startLoc);
					//$finish = getLatLong($endLoc);
					//$distance = Haversine($start, $finish);
				//}else{
					//$distance = 0;
				//}
				
				
		if ($_POST['passengers'] == '1'){
			$titleDetails = $_POST['title'] .';'. $_POST['passengers'] .'per';
		}else{
			$titleDetails = $_POST['title'] .';'. $_POST['passengers'] .'ppl';
		}
				
		/*
         * Check to see if everything was filled out properly.
         */
      
		
        if(date('Ymd') > date('Ymd',strtotime($_POST['startdate']))){
                $message = 'You cannot make a booking in the past.  Please check your date.';
        }
        elseif($_POST['starttime'] == ''){
                $message = 'You must enter a start time.';
							?> 
                <script type="text/javascript"> 
<!--
window.document.write('<h2><span style="color: #ff0000;">Unfortunately, that time is already booked. &nbsp;<br></span></h2><p><em><strong>Please give us a call at (702) 485-3232 and we\'ll get you on the schedule...</strong></em> &nbsp;</p><p>&nbsp;</p><p>Thank you!</p><div style="width:100%; text-align: center;"><a href="https://www.therange702.com/parallax/busbooking.php" >Click Here to Start Over</a></div>');
//-->
</script> 
<?php
        
				
        }
		elseif ($_POST['title'] == '') {
				$message = 'You must enter your name';
					?> 
                <script type="text/javascript"> 
<!--
window.document.write('<h2><span style="color: #ff0000;">There was an error in your submission please be sure to fill out all the required fields. <br>-Thank You</span></h2>');
//-->
</script> 
<?php
		}
		elseif ($_POST['passengers'] == '') {
				$message = 'You must enter your name';
					?> 
                <script type="text/javascript"> 
<!--
window.document.write('<h2><span style="color: #ff0000;">There was an error in your submission please be sure to fill out all the required fields. <br>-Thank You</span></h2>');
//-->
</script> 
<?php
		}
     	elseif ($_POST['email'] == '') {
				$message = 'You must enter your email address';
					?> 
                <script type="text/javascript"> 
<!--
window.document.write('<h2><span style="color: #ff0000;">There was an error in your submission please be sure to fill out all the required fields. <br>-Thank You</span></h2>');
//-->
</script> 
<?php
		}
		elseif ($_POST['phone'] == '') {
				$message = 'You must enter your phone number';
					?> 
                <script type="text/javascript"> 
<!--
window.document.write('<h2><span style="color: #ff0000;">There was an error in your submission please be sure to fill out all the required fields. <br>-Thank You</span></h2>');
//-->
</script> 
<?php

		}else{
                $postargs = createPostArgsJSON($startdate,$_POST['starttime'],$endtime1,$titleDetails,$_POST['location'],$_POST['requests']);
                $token = getAccessToken();
                $result = sendPostRequest($postargs,$token,$courts[$_POST['calendar']]['id']);
                echo '<pre>' . $result . '</pre>';
				$emailaddress = "info@youremail.com";
				$customeremail = $_POST['email'];
				$subject = "New Online Bus Booking from The Range 702";
				$email = $_POST['email'];
				$military_time = $_POST['starttime'];
				$standard_time = date('h:i A', strtotime($military_time));
				$message="";
				$message.="Name: ".$_POST['title']."\r\n";
				$message.="E-Mail: ".$_POST['email']."\r\n";
				$message.="Phone Number: ".$_POST['phone']."\r\n\r\n";
				$message.="\r\n Booking Information:\r\n\r\n";
				$message.="Passengers: ".$_POST['passengers']."\r\n";
				$message.="Pick Up Date: ".$date."\r\n";
				$message.="Pick Up Time: ".$standard_time."\r\n";
				$message.="Pick Up Location: ".$_POST['location']."\r\n";
				
				
				$message=$message."\r\nMessage:\r\n".$_POST['requests'];
				//mail($emailaddress,$subject,$message,"From: $email" );
				//mail($customeremail,$subject,$message,"From: info@youremail.com" );
							
				
				
				
			?> 
                <script type="text/javascript"> 
<!--
window.document.write('<h2><span style="color: #339966;">The shuttle was booked. You will recieve an email confirmation shortly. &nbsp;<br>-Thank You</span></h2>');
//-->
</script> 
<?php
        }
		}
?>