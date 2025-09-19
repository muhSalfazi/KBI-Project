<html>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="qrcode.js"></script>
<?php echo $_GET['var'].'</br>';?>
<?php echo $_GET['seq'];?>
<style>
div {float:left;  margin-left:15px; margin-top:15px; }

</style>
<?php
  $ds = DIRECTORY_SEPARATOR;
  $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
  include_once("../connection.php");
  session_start();
  require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");


  $IdUser = $_SESSION["id_user"];


	include('phpqrcode/qrlib.php');
	if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
    
	
	
    //html PNG location prefix
    $PNG_WEB_DIR = 'uploads/';
	
	if(!file_exists($PNG_TEMP_DIR)){
    	mkdir($PNG_TEMP_DIR);
	}
	
	
	
	$filename	=	$PNG_WEB_DIR.time().uniqid('-QR-').'.png';
	
	//processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = $_REQUEST['level'];
    $matrixPointSize = $_REQUEST['size'];
    //default data	
	
	$jobno	=	$_REQUEST['jobno'];
	$modelno	= $_REQUEST['modelno'];
	$partno	=	$_REQUEST['partno'];
	$invid	=	$_REQUEST['invid'];
	$qtyperkbn	= $_REQUEST['qtyperkbn'];
	$partname	= $_REQUEST['partname'];
	$sequence	= $_REQUEST['sequence'];
	$partnokiri = SUBSTR($partno, 6);
	


?> 
<style>.qr{position:absolute; }</style>
<div id="qrcode1" class="qr" style="width:100px; height:100px; margin-top:250px; margin-left:235px;"></div>
<div id="qrcode2" class="qr" style="width:100px; height:100px; margin-top:680px; margin-left:235px;"></div>
<div id="qrcode3" class="qr" style="width:100px; height:100px; margin-top:1150px; margin-left:235px;"></div>
<div id="qrcode4" class="qr" style="width:100px; height:100px; margin-top:1540px; margin-left:235px;"></div>
<div id="qrcode5" class="qr" style="width:100px; height:100px; margin-top:15px; margin-left:235px;"></div>
<?php 
for ($i=1; $i <= $sequence; $i++)
{
	include 'print_kanban.php';
}?>
<?php

	}
	?>
<?php
  //require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?> 
</html>

  
