<?php

return [
    'dbname' => env("DB_DATABASE"),
    "datarootpath" => env("DATA_FILE_PATH"),
    "imagesrootpath" => env("IMAGES_ROOT_PATH"),
    "titleimagesrootpath" => env("TITLE_IMAGES_ROOT_PATH"),
    "noimagepath" => env("NO_IMAGE_PATH"),
    "marc_records_path" => env("MARC_RECORDS_PATH", "\\CPSERVER\Data\Easynet\WEBNET\CP_INFO\CP_Marc\MRC_Files"),
	"serverimagerootpath" => env("SERVER_IMAGE_ROOT_PATH"),
	"promotionspath" => env("PROMOTIONS_PATH"),
    "GRAPHQL_URL"=> env("GRAPHQL_URL","/graphql"),
    "files" => [
      "vendor"=> env("DBF_ROOT_PATH_RW") . "/vendor.DBF",
      "inventory"=> env("DBF_ROOT_PATH_RW") . "/invent.DBF",
      "users"=> env("DBF_ROOT_PATH_RW") . "/password.dbf",
      "alldetail"=> env("DBF_ROOT_PATH_R") . "/alldetail.DBF",
      "allhead"=> env("DBF_ROOT_PATH_R") . "/allhead.DBF",
      "ancientdetail"=> env("DBF_ROOT_PATH_R") . "/ancientdetail.dbf",
      "ancienthead"=> env("DBF_ROOT_PATH_R") . "/ancienthead.DBF",
      "backdetail"=> env("DBF_ROOT_PATH_R") . "/backdetail.DBF",
      "backhead"=> env("DBF_ROOT_PATH_R") . "/backhead.DBF",
      "booktext"=> env("DBF_ROOT_PATH_R") . "/booktext.dbf",
      "brodetail"=> env("DBF_ROOT_PATH_R") . "/brodetail.DBF",
      "brohead"=> env("DBF_ROOT_PATH_R") . "/brohead.dbf",
      "passfile"=> env("DBF_ROOT_PATH_R") . "/passfile.DBF",
      "standing_order"=> env("DBF_ROOT_PATH_R") . "/standing.DBF",
      "webhead"=> env("DBF_ROOT_PATH_RW") . "/webhead.DBF",
      "webdetail"=> env("DBF_ROOT_PATH_RW") . "/webdetail.DBF"   
    ],
    "tables" => [
       
      ["\App\Cache","This is for the application cache drivers use."],
       ["\App\Dbf","a table for tracking table statuses."],
       ["\App\Vendor", "This table lists all our customers."],
       ["\App\Inventory","This table lists our entire current inventory"],
      ["\App\User","This table lists customer credentials and preferences."],
       ["\App\Alldetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\Allhead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\Ancientdetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\Ancienthead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
      ["\App\Backdetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\Backhead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
      ["\App\Booktext","This file holds the book copy associated with inventory records. ID Key is KEY (ISBN)"],
       ["\App\Brodetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\Brohead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\Command",""],
       ["\App\Company",""],
       //["\App\Order","This is a log of all titles purchased by vendor."],
       //["\App\OrderItem","This is a log of all titles purchased by vendor."],
       ["\App\Passfile","This holds basically pairs of name/value for drop down choices in programming. It also holds the discounts for wholesaler accounts."],
       ["\App\Role",''],
       ["\App\RoleUser",""],
       ["\App\StandingOrder","This file holds info on our standing orders and choice customers. ID KEY IS KEY (Customer Key)"],
       ["\App\Webhead","This is where HEADER information of the customer’s order is kept. These are orders coming off the website only. The key is field: remoteaddr  Orders are stored here until processed and then sent to files broHead.dbf and broDetail.dbf on RDATA."],
       ["\App\Webdetail","This is where the DETAILS of a customer’s order is kept. These are orders coming off the website only. The key is field: remoteaddr  Orders are stored here until processed and then sent to files broHead.dbf and broDetail.dbf on RDATA."],
       ["\App\WebSocketStatistic","This is a log for the Websocket server."]
	],

"commands" => [
		"DROP_TABLE",
		"CREATE_TABLE",
		"SEED_TABLE",
		"TRUNCATE_TABLE",
		"REBUILD_TABLE",
    "REBUILD_ALL_DBF_TABLES",
    "BUILD_ORDER_TABLES"
      ],

    "users" => [
		["INDEX"=>9999999999,"KEY"=>"0484900000044", "FIRST"=>"Stephen", "MIDNAME"=>"Gordon", "LAST"=>"Reynods","ARTICLE"=>"Mr.","EMAIL"=>"sgrjr@deliverance.me", "UPASS"=>"1230happy","ORGNAME"=>"FAKE ORGANIZATION","COMPANY"=>"FAKE COMPANY"]
      ],

    "role_user" => [
        ["role_id"=>1,"user_id"=>1]
    ],

"roles" => [
		["name"=>"SUPER"],
		["name"=>"ADMIN"],
		["name"=>"VENDOR"],
		["name"=>"EMPLOYEE"]
      ],

"company" => [[
	"name" => "Center Point Large Print",
	"email" => "contact@centerpointlargeprint.com",
	"telephone" => "(800) 929-9108",
	"city" => "Thorndike",
	"state" => "Maine",
	"address" => "PO Box 1 Thorndike, Maine 04986",
	"website" => "www.centerpointlargeprint.com",
	"fax" => "(207) 568-3727",
	"logo" => "/img/logo.png"
    ]],

    "image_extensions" => [
      ".png",".PNG",".jpg",".JPG",".jpeg",".bmp",".BMP",".txt"
    ]

];