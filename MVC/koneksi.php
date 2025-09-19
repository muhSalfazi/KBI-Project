<?php

/* Specify the server and connection string attributes. */
//$serverName = "user-PC";
$serverName = "192.168.0.18";
 
/* Get UID and PWD from application-specific files.  */
$uid = "numazu";
$pwd = "Numazu16";
$connectionInfo = array( "UID"=>$uid,
                         "PWD"=>$pwd,
                         "Database"=>"KyorakuData");
 
/* Connect using SQL Server Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
   if( $conn === false )
    {
        echo "Could not connect.\n";
        die( print_r( sqlsrv_errors(), true));
    }
    else {
        echo "koneksi berhasil..!";
        echo "Data Tabel Pemakai :";
		
		   
        $tsql = "select * from [Activity]";
        $result = sqlsrv_query($conn, $tsql);
       
        while($row = sqlsrv_fetch_array($result))
        {
        echo"<hr><p></p><table border=1 cellpadding=4 cellspacing=0>
	    <tr bgcolor='#ccc'><td>Id</td><td>Nama</td><td>Email</td></tr>";
	    echo"<tr><td>$row[ActID]</td><td>$row[Activity]</td><td>$row[Status]</td></tr>";
		
        }
	
		sqlsrv_close( $conn);       
    }
 

?>