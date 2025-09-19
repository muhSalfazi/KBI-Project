<?php
  session_start();
  $ds = DIRECTORY_SEPARATOR;
  $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
  include_once("../connection.php");

  require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

  require_once("{$base_dir}pages{$ds}core{$ds}header.php");
  require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

  $IdUser = $_SESSION["id_user"];
?> 
	<head>
	
	<script type="text/javascript" src="../js/jquery.js"></script>
</head>
	<script src="../js/jquery.js"></script>
	<script src="../sweetalert/js/sweetalert.min.js"></script>
	<link rel="stylesheet" href="../sweetalert/css/sweetalert.css">
	<script type="text/javascript" src="../assets/DataTables/media/js/jquery.js"></script>
	<script type="text/javascript" src="../assets/DataTables/media/js/jquery.dataTables.js"></script>
	<!--<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">-->
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/media/css/dataTables.bootstrap.css">

	  <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-building fa-fw""></i>Data Delivery Open</h1>
      </div>
      <!-- End Title -->


      <br><br>

      <!-- Table -->
      <div class="row">
        <div class="col-lg-12">

          <br></br>
		  <div class="panel panel-default">
		  
            <div class="panel-heading">
            <?php 
            $Q = mysqli_query ($mysqli, "SELECT MAX(id) AS id_kbi FROM tbl_deliverynote");
    
            $R = mysqli_fetch_array ($Q);
            ?>
                List All Data Part&nbsp; (Last : <?php echo $R['id_kbi'];?>)
            </div>

            <div class="panel-body">
       
		Date : <input name="date1" type="date"> to : <input name="date2" type="date"> <a class="tampil btn btn-sm btn-warning" value="1" name="history">submit</a>	
	<div class="tampildata"></div>

	</div>

	 <script> 						
						 $(document).ready(function(){	
							  //Ajax modal menampilkan data
							  $('.tampil').click(function(){
								  //$("#simpan-data").show();								  
								 var date1   = $("input[name=date1]").val();
								 var date2   = $("input[name=date2]").val();
								
								 
								  $.ajax({
									url: "ajx/view_delivery_open.php",
									method: "POST",
									data: {date1:date1,date2:date2},
									dataType: "html",
									success: function(data){
									 $('.tampildata').html(data);
									}
								  });
							   });
							  });
					</script>
			  
  	        </div>
  			  </div>
  			</div>
  		</div>
  		<!-- End Table -->

    </div>
    <!-- End Content -->
<br>
        <footer class="main-footer">
            <div class="text-center">
                <strong>KBI teknologi-2024</strong>
				
            </div>
        </footer>

<?php
  //require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   
