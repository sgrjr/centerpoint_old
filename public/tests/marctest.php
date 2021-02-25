<?php
$file_name_1 = "\\CPSERVER\Data\Easynet\WEBNET\CP_INFO\CP_Marc\MRC_Files\9781628994100.mrc";
$file_name_2 = "C:\inetpub\wwwroot\dev\public\marcs\MRC_Files\9781628994100.mrc";

$file1 = file_exists($file_name_1);
$file2 = file_exists($file_name_2);

echo("<h2>" . $file_name_1 . " - " . json_encode($file1 ) . "</h2>") ;
echo("<h2>" . $file_name_2 . " - " . json_encode($file2 ) . "</h2>");

?>