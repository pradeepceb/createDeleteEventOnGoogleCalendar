
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" language="javascript">
    

    function DisableSpecificDates(date) {
            var disableddates='';
            $.ajax({
                           type:'GET',
                           url: "http://sooryalaya.com/booking/ajax_calendar.php",
                           data: "cID=7bs4tiq9ncd68j3mcgk5vea788@group.calendar.google.com",
                           success: function(e){
                               //alert(e);
                             disableddates= e;              
                           }                   
                    });            
            //wait(10000);
            alert(disableddates);
            //var disableddates=['26-01-2017'];
            //var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
            //return [disableddates.indexOf(string) == -1];
    }

    $(function() {
      $("#date").datepicker({
        minDate: 0,
        beforeShowDay: DisableSpecificDates
      });
    });
  </script>

<p>Date: <input type="text" id="date"></p>
