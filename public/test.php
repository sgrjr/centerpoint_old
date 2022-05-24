<?php
	
	ini_set('display_errors', 1);
	ini_set("display_startup_errors",1);
	error_reporting(E_ALL);


  $user="root";
  $password="";
  $server = "localhost";
  $driver = "Microsoft Visual FoxPro Driver";
  $database = "Visual FoxPro Tables";
  $dsn = "WebDBFs";

  $connection = "DSN=$dsn; DRIVER=$driver; SERVER=$server; DATABASE=$database; SourceType=DBF;SourceDB=C:\\resources\\data\\Stephen_Reynolds\\WEBINFO\\RWDATA;Exclusive=No;Collate=Machine;NULL=NO;DELETED=NO;BACKGROUNDFETCH=NO";

  $conn = \odbc_connect($connection, $user, $password);
   echo 'hi';
  //Checking connection id or reference
  if (!$conn)
   {
   echo (die(odbc_error()));
   }
   else
  {
      echo "Connection Successful !";
  }
  //Resource releasing
  odbc_close($conn);

  ?>