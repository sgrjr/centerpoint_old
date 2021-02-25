<?php
$file_name_1 = 'Z:\Data\Easynet\WEBNET\CP_INFO\test.txt';//9781628994100.mrc';
$file_name_2 = 'C:\test.txt';
$file_name_3 = 'Z:\CPSERVER\Data\Easynet\RWDATA\family.DBF';

$file4 = file_get_contents('../../config/cp.php');

var_dump(json_decode($file4));
die;
$file1 = file_exists($file_name_1);
$file2 = file_exists($file_name_2);
$file3 = file_exists($file_name_3);

echo("<h2>" . $file_name_1 . " - " . json_encode($file1 ) . "</h2>") ;
echo("<h2>" . $file_name_2 . " - " . json_encode($file2 ) . "</h2>");
echo("<h2>" . $file_name_3 . " - " . json_encode($file3 ) . "</h2>");
?>