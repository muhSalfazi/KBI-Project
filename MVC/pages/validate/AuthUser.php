<?php
	if (!isset ($_SESSION["Login"]) || $_SESSION ["Login"] != true){
		?>
		<script language="javascript">
		    window.location.href = "Login.php"
		</script>
		<?php
	}
	else if ($_SESSION["Login"] == true){
		$_SESSION ["Login"] = true;
	}
	else{
		?>
		<script language="javascript">
		    window.location.href = "Login.php"
		</script>
		<?php
	}

?>