<?php
function getAccessToken(){
        $tokenURL = 'https://accounts.google.com/o/oauth2/v4/token';
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



//$calendarId =$_GET['cID'];
$calendarId ="7bs4tiq9ncd68j3mcgk5vea788@group.calendar.google.com";

$startdate =date('Y-m-d');
$date =date('Y-m-d');
        $APIKEY = 'AIzaSyCBgCHben7bTtLRf3TA0bAhBtGnBUtRI5Q';
        $start = $date . 'T' . '09:00:00.000-08:00';
        $end = $date . 'T' . '20:00:00.000-08:00';
        
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
        $request = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendarId . '/events?location=11&key=' . $APIKEY;
        $session = curl_init($request);
 
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_HTTPGET, true);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLINFO_HEADER_OUT, false);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization:  Bearer ' . $accessToken,'X-JavaScript-User-Agent:  Mount Pearl Tennis Club Bookings'));
 
        $response = curl_exec($session);
 
        
       $results =json_decode($response); 
       
       echo '<pre>';
       print_r($results); 
                
                
                $disdates=array();
                $format = 'Y-m-d';
		$count = count($results->items);
		for( $i = 0; $i < $count; $i ++)
                {
                   $startTime =$results->items[$i]->start->dateTime;
                   $startDate = substr($startTime, 0, 10);
                   $startFormat = date('d-m-Y',strtotime($startDate));
                   
                   $endTime =$results->items[$i]->end->dateTime;
                   $endDate = substr($endTime, 0, 10);
                   $endFormat = date('d-m-Y',strtotime($endDate));
                   
                   //getDatesFromRange($start, $end);
                    //array_push($disdates,$startFormat);
                    $between =getDatesFromRange($startFormat,$endFormat); 
                    foreach($between as $value)
                    {
                        array_push($disdates,$value);
                    }
                    
                }
                
        print_r($disdates);

//print_r(getDatesFromRange("2017-01-20","2017-01-25"));
function getDatesFromRange($startDate, $endDate)
{
    $return = array($startDate);
    $start = $startDate;
    $i=1;
    if (strtotime($startDate) < strtotime($endDate))
    {
       while (strtotime($start) < strtotime($endDate))
        {
            $start = date('d-m-Y', strtotime($startDate.'+'.$i.' days'));
            $return[] = $start;
            $i++;
        }
    }

    return $return;
}
?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" language="javascript">
    var disableddates = new Array();
    <?php foreach($disdates as $key => $val){ ?>
        disableddates.push('<?php echo $val; ?>');
    <?php } ?>

    function DisableSpecificDates(date) {
        
        var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
        return [disableddates.indexOf(string) == -1];
      }

    $(function() {
      $("#date").datepicker({
        minDate: 0,
        beforeShowDay: DisableSpecificDates
      });
    });
  </script>

<p>Date: <input type="text" id="date"></p>
