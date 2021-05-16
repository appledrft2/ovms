<!-- jQuery 3 -->
<script src="<?php echo $baseurl ?>template/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $baseurl ?>template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- PACE -->
<script src="<?php echo $baseurl ?>template/bower_components/PACE/pace.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $baseurl ?>template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $baseurl ?>template/bower_components/fastclick/lib/fastclick.js"></script>
<!-- DataTables -->
<script src="<?php echo $baseurl ?>template/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $baseurl ?>template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $baseurl ?>template/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $baseurl ?>template/dist/js/demo.js"></script>

<!-- fullCalendar -->
<script src="<?php echo $baseurl ?>template/bower_components/moment/moment.js"></script>
<script src="<?php echo $baseurl ?>template/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>


<!-- page script -->
<script type="text/javascript">
  // To make Pace works on Ajax calls
  $(document).ajaxStart(function () {
    Pace.restart()
  })
  $('.ajax').click(function () {
    $.ajax({
      url: '#', success: function (result) {
        $('.ajax-content').html('<hr>Ajax Request Completed !')
      }
    })
  })


  $('#calendar').fullCalendar({
        header    : {
          left  : 'prev,next today',
          center: 'title',
          right : 'month,agendaWeek'
        },
        buttonText: {
          today: 'today',
          month: 'month',
          week : 'week',
          day  : 'day'
        },

        //Random default events
        events    : [
          <?php 


            if($_SESSION['dbet'] == 'Veterinarian'){
              $sql = "SELECT a.id,c.firstname,c.lastname,s.schedule_date,c.gender,a.status FROM tbl_appointment AS a INNER JOIN tbl_client AS c ON c.id = a.client_id INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id WHERE a.veterinarian_id = ?";
                $qry = $connection->prepare($sql);
                $qry->bind_param('i',$_SESSION['dbu']);
                $qry->execute();
            }else{
              $sql = "SELECT a.id,c.firstname,c.lastname,s.schedule_date,c.gender,a.status FROM tbl_appointment AS a INNER JOIN tbl_client AS c ON c.id = a.client_id INNER JOIN tbl_schedule AS s ON s.id = a.schedule_id";
              $qry = $connection->prepare($sql);
              $qry->execute();
            }


            $qry->bind_result($id,$dbefn,$dbeln,$dbs,$dbg,$dbst);
            $qry->store_result();
            while($qry->fetch ()) {

            $dbg = ($dbg == 'Male') ? 'Mr.' : 'Ms.';

          ?>
          {
            title          : <?= "'$dbg {$dbefn} {$dbeln} - {$dbst}'" ?>,
            start          : new Date(<?php echo date_format (new DateTime($dbs), 'Y,m - 1,d'); ?>),
            backgroundColor: '#1295ad', //red
            borderColor    : '#1295ad', //red
            description: 'second description'
          },

        <?php } ?>
          
        ],

        editable  : false,
        droppable : false,
        displayEventTime: false,
      });
  
  $(function () {
    $('#table1').DataTable();
    $('#table1').DataTable();
    $('#table12').DataTable();
    $('#table13').DataTable();

    $('#table2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    })
    $('#table3').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      "order": [[ 3, 'asc' ]]
    })
    $('#table4').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    })
  })
</script>

</body>
</html>