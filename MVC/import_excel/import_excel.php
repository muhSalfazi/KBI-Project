<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<?php
//tambahan kode untuk kembali kehalaman index
$linkkembali = " <hr> <a class='btn btn-danger' href='index.php'>Kembali</a>";

//kedua baris kode dibawah untuk membaca file excel jangan dihapus
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

//kedua baris dibawah untuk menghubungkan kedatabase dan melakukan autoload
require_once ('koneksi.php');
require_once ('Spout/Autoloader/autoload.php');

if(!empty($_FILES['excelfile']['name']))
{
    // Get File extension eg. 'xlsx' to check file is excel sheet
    $pathinfo = pathinfo($_FILES['excelfile']['name']);

    // check file has extension xlsx, xls and also check
    // file is not empty
    if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
        && $_FILES['excelfile']['size'] > 0 )
    {
        $file = $_FILES['excelfile']['tmp_name'];

        // Read excel file by using ReadFactory object.
        $reader = ReaderFactory::create(Type::XLSX);

        // Open file
        $reader->open($file);
        $count = 0;

        // Number of sheet in excel file
        foreach ($reader->getSheetIterator() as $sheet)
        {

            // Number of Rows in Excel sheet
            foreach ($sheet->getRowIterator() as $row)
            {

                // It reads data after header. In the my excel sheet,
                // header is in the first row.
                if ($count > 0) { //lebih dari nol agar bagian header tidak ikut tersimpan

                    // Data of excel sheet
					$id_soal    = $row[0];
                    $id_mp    = $row[1];
                    $rincian_1   = $row[2];
                    $pg_1 = $row[3];
                    $pg_2  = $row[4];
					$pg_3  = $row[5];
					$pg_4  = $row[6];
					$pg_5  = $row[7];
					$jawaban  = $row[8];
					
                    //insert data setiap baris kedalam database
                    $sql = "INSERT INTO soal_1 (id_soal,id_mp, rincian_1, pg_1, pg_2, pg_3, pg_4, pg_5, jawaban) 
                                VALUES ('$id_soal','$id_mp', '$rincian_1', '$pg_1', '$pg_2', '$pg_3', '$pg_4', '$pg_5', '$jawaban' )";
                    $query = mysqli_query($connect,$sql);

                }
                $count++;
            }
        }

        if($query)
        {
            echo "File berhasil diupload";
            echo $linkkembali;
        }
        else
        {
            echo "File gagal diupload";
            echo $linkkembali;
        }

        // Close excel file
        $reader->close();
    }
    else
    {
        echo "Hanya file excel yang dapat diupload";
        echo $linkkembali;
    }
}
else
{
    echo "File kosong"."<br>";
    echo "Silahkan masukan/upload file excel";
    echo $linkkembali;
}

?>
