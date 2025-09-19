<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View-WH</title>
    <link rel="icon" type="image/png" sizes="100px" href="kbi.png">
    <script src="vendor/js/jquery.214.js"></script>
    <link href="vendor/css/jquimin.css" rel='stylesheet' type='text/css'>
    <script src="vendor/js/jquery-ui.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="vendor/js/bootstrap.min.js"></script>
    <script src="vendor/js/bootstrap-datepicker.min.js"></script>
    <link href="vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css/datepicker.min.css" rel="stylesheet">
    <!-- icon dan fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body style="background-image: url('gambar/bg-grafik.jpg'); height: 70%;">
    <div class="col">
    <div class="form-group">
        <h3 style="color: white;" class="text-center">
        <img src="gambar/KBI-1.png" style="height: 45px; ">TABEL CONTROL</h3>
    </div>
    
    <div class="col-lg-6">
    <h5 style="color: orange;">Date time now : 22 Februari 2021</h5> Noted: tabel All customer
    <table class="table table-bordered mb-0" style="background-color: black; font-size:small" >
        <tr style="color: white;">
            <th class="text-center">Customer</th>
            <th class="text-center">Cycle</th>
            <th class="text-center">Status</th>
            <th class="text-center">Time Scan</th> 
            <th class="text-center">Acuan Scan</th>          
            <th class="text-center">Actual scan</th>          
            <!-- <th>Cycle</th> -->
        </tr>
        <tr style="color: white;">
            <td>TMMIN</td>
            <td class="text-center" style="color: orange;">1</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: red; background:transparent; border-color: red'>Close</a>
            </td>
            <td class="text-center" style="color: cyan;">07:00:00</td>
            <td style="color: cyan;">3</td>          
            <td style="color: red;">3</td>           
        </tr>
        <tr style="color: white;">
            <td>TMMIN</td>
            <td class="text-center" style="color: orange;">2</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: red; background:transparent; border-color: red'>Close</a>
            </td>
            <td class="text-center" style="color: cyan;">08:00:00</td> 
            <td style="color: cyan;">3</td>          
            <td style="color: red;">3</td>          
        </tr>
        <tr style="color: white;">
            <td>TMMIN</td>
            <td class="text-center" style="color: orange;">3</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: green; background:transparent; border-color: green'>Open</a>
            </td>
            <td class="text-center" style="color: green;">Prosess</td> 
            <td style="color: cyan;">3</td>          
            <td style="color: green;">1</td>          
        </tr>
        <tr style="color: white;">
            <td>ADM</td>
            <td class="text-center" style="color: orange;">1</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: red; background:transparent; border-color: red'>Close</a>
            </td>
            <td class="text-center" style="color: cyan;">07:30:00</td>  
            <td style="color: cyan;">3</td>          
            <td style="color: red;">3</td>         
        </tr>
        <tr style="color: white;">
            <td>ADM</td>
            <td class="text-center" style="color: orange;">2</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: green; background:transparent; border-color: green'>Open</a>
            </td>
            <td class="text-center" style="color: orange;">Belum Preparation</td>  
            <td style="color: cyan;">3</td>          
            <td style="color: orange;">0</td>         
        </tr>
     </table>
    </div>

    <div class="col-lg-6">
    <h5 style="color: orange;">Manifest-TMMIN</h5>Noted: tabel hanya data TMMIN
    <table class="table table-bordered mb-0" style="background-color: black; font-size:small" >
        <tr style="color: white;">
            <th class="text-center">Customer</th>
            <th class="text-center">Manifest/DN</th>
            <th class="text-center">Date</th>
            <th class="text-center" colspan="2">Status</th>          
            <th class="text-center">Acuan Scan</th>          
            <th class="text-center">Actual scan</th>   
            <th>Action</th>       
            <!-- <th>Cycle</th> -->
        </tr>
        <tr style="color: white;">
            <td>TMMIN</td>
            <td>021000000001</td>
            <td style="color: orange;">22-02-2021</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: red; background:transparent; border-color: red'>Close</a>
            </td>          
            <td style="color: red;">Finish</td>          
            <td style="color: cyan;">3</td>          
            <td style="color: red;">3</td>          
        </tr>
        <tr style="color: white;">
            <td>TMMIN</td>
            <td>021000000002</td>
            <td style="color: orange;">22-02-2021</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: red; background:transparent; border-color: red'>Close</a>
            </td>  
            <td style="color: red;">Finish</td>  
            <td style="color: cyan;">2</td>          
            <td style="color: red;">2</td>        
        </tr>
        <tr style="color: white;">
            <td>TMMIN</td>
            <td>021000000003</td>
            <td style="color: orange;">22-02-2021</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: red; background:transparent; border-color: red'>Close</a>
            </td> 
            <td style="color: red;">Finish</td>  
            <td style="color: cyan;">6</td>          
            <td style="color: red;">6</td>        
        </tr>
        <tr style="color: white;">
            <td>TMMIN</td>
            <td>021000000004</td>
            <td style="color: orange;">22-02-2021</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: green; background:transparent; border-color: green'>Open</a>
            </td>  
            <td style="color: green;">Prosess</td>  
            <td style="color: cyan;">5</td>          
            <td style="color: green;">2</td>        
        </tr>
        <tr style="color: white;">
            <td>TMMIN</td>
            <td>021000000005</td>
            <td style="color: orange;">22-02-2021</td>
            <td class="text-center" style="color: red;">
                <a class='btn btn-sm' style='color: green; background:transparent; border-color: green'>Open</a>
            </td>
            <td style="color: orange;">Belum preparation</td>
            <td style="color: cyan;">8</td>          
            <td style="color: green;">0</td>          
        </tr>
     </table>
    </div>
    
    </div>
    <!-- <h5 style="color: orange;">Untuk table all customer data yang di tampilkan hanya 10 row</h5>
    <h5 style="color: orange;">setiap ada scan data ada di bagian atas menggunakan slide menurun setiap data row ada yang close</h5>
    <h5 style="color: orange;">Untuk table TMMIN aturannya sama seperti tabel all customer hanya data yang di tampilkan per hari saja</h5> -->
</body>
</html>