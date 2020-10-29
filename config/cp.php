<?php

return [
    'dbname' => env("DB_DATABASE"),
    "datarootpath" => env("DATA_FILE_PATH"),
    "imagesrootpath" => env("IMAGES_ROOT_PATH"),
    "titleimagesrootpath" => env("TITLE_IMAGES_ROOT_PATH"),
    "noimagepath" => env("NO_IMAGE_PATH"),
	"serverimagerootpath" => env("SERVER_IMAGE_ROOT_PATH"),
	"promotionspath" => env("PROMOTIONS_PATH"),
    "GRAPHQL_URL"=> env("GRAPHQL_URL","/graphql"),
<<<<<<< HEAD
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
       ["\App\AllDetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\AllHead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\AncientDetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\AncientHead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\BackDetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\BackHead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\TitleText","This file holds the book copy associated with inventory records. ID Key is KEY (ISBN)"],
       ["\App\BroDetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\BroHead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
       ["\App\Command",""],
       ["\App\Company",""],
       ["\App\Order","This is a log of all titles purchased by vendor."],
       ["\App\OrderItem","This is a log of all titles purchased by vendor."],
       ["\App\Passfile","This holds basically pairs of name/value for drop down choices in programming. It also holds the discounts for wholesaler accounts."],
       ["\App\Request",""],
       ["\App\Role",''],
       ["\App\RoleUser",""],
       ["\App\StandingOrder","This file holds info on our standing orders and choice customers. ID KEY IS KEY (Customer Key)"],
       ["\App\WebHead","This is where HEADER information of the customer’s order is kept. These are orders coming off the website only. The key is field: remoteaddr  Orders are stored here until processed and then sent to files broHead.dbf and broDetail.dbf on RDATA."],
       ["\App\WebDetail","This is where the DETAILS of a customer’s order is kept. These are orders coming off the website only. The key is field: remoteaddr  Orders are stored here until processed and then sent to files broHead.dbf and broDetail.dbf on RDATA."],
       ["\App\WebSocketStatistic","This is a log for the Websocket server."]
=======
    'tables' => [
    	"users" => ["class"=>"\App\User","seed"=>"CONFIG", "memo"=>"User needs a Memo","urlroot"=>""],
    	"vendors" => ["class"=>"\App\Vendor","table"=>"vendors","seed"=> env("DBF_ROOT_PATH_RW") . "/vendor.DBF", "memo"=>"This table lists all our customers.","urlroot"=>""],
    	"inventories" => ["class"=>"\App\Inventory","seed"=> env("DBF_ROOT_PATH_RW_2") . "/invent.DBF", "memo"=>"This table lists our entire current inventory","urlroot"=>""],
    	"passwords" => ["class"=>"\App\Password","seed"=> env("DBF_ROOT_PATH_RW"). "/password.dbf", "memo"=>"This table lists customer credentials and preferences.","urlroot"=>""],
    	"passfiles" => ["class"=>"\App\Passfile","seed"=> env("DBF_ROOT_PATH_R") . "/passfile.DBF", "memo"=>"This holds basically pairs of name/value for drop down choices in programming. It also holds the discounts for wholesaler accounts.","urlroot"=>""],
    	"standingorders" => ["class"=>"\App\StandingOrder","seed"=> env("DBF_ROOT_PATH_R") . "/standing.DBF", "memo"=>"This file holds info on our standing orders and choice customers. ID KEY IS KEY (Customer Key)","urlroot"=>"/dashboard/orders/standing-orders/"],
    	"allheads" => ["class"=>"\App\Allhead","seed"=> env("DBF_ROOT_PATH_R"). "/allhead.DBF", "memo"=>"These are basically the same header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: brohead.dbf, brodetail.dbf, allhead.dbf,alldetail.dbf,oldallhead.dbf,oldalldetail.dbf,ancienthead.dbf ancientdetail.dbf","urlroot"=>"/dashboard/orders/history/"],
    	"ancientheads" => ["class"=>"\App\Ancienthead","seed"=> env("DBF_ROOT_PATH_R") . "/ancienthead.DBF", "memo"=>"These are basically the same header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: brohead.dbf, brodetail.dbf, allhead.dbf,alldetail.dbf,oldallhead.dbf,oldalldetail.dbf,ancienthead.dbf ancientdetail.dbf","urlroot"=>"/dashboard/orders/archived-history/"],
    	"backheads" => ["class"=>"\App\Backhead","seed"=> env("DBF_ROOT_PATH_R_2") . "/backhead.DBF", "memo"=>"These are basically the same header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: brohead.dbf, brodetail.dbf, allhead.dbf,alldetail.dbf,oldallhead.dbf,oldalldetail.dbf,ancienthead.dbf ancientdetail.dbf","urlroot"=>"/dashboard/orders/back-ordered/"],
    	"broheads" => ["class"=>"\App\Brohead","seed"=> env("DBF_ROOT_PATH_R") . "/brohead.DBF", "memo"=>"These are basically the same header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13).Similar to: brohead.dbf, brodetail.dbf, allhead.dbf,alldetail.dbf,oldallhead.dbf,oldalldetail.dbf,ancienthead.dbf ancientdetail.dbf","urlroot"=>"/dashboard/orders/bro/"],
    	"webheads" => ["class"=>"\App\Webhead","seed"=> env("DBF_ROOT_PATH_RW_2") . "/webhead.DBF", "memo"=>"This is where HEADER information of the customer’s order is kept. These are orders coming off the website only. The key is field: remoteaddr  Orders are stored here until processed and then sent to files brohead.dbf and brodetail.dbf on RDATA.","urlroot"=>"/dashboard/orders/processing/"],
    	"alldetails" => ["class"=>"\App\Alldetail","seed"=> env("DBF_ROOT_PATH_R") . "/alldetail.DBF", "memo"=>"These are basically the same header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: brohead.dbf, brodetail.dbf, allhead.dbf,alldetail.dbf,oldallhead.dbf,oldalldetail.dbf,ancienthead.dbf ancientdetail.dbf","urlroot"=>""],
    	"ancientdetails" => ["class"=>"\App\Ancientdetail","seed"=> env("DBF_ROOT_PATH_R") . "/ancientdetail.dbf", "memo"=>"These are basically the same header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: brohead.dbf, brodetail.dbf, allhead.dbf,alldetail.dbf,oldallhead.dbf,oldalldetail.dbf,ancienthead.dbf ancientdetail.dbf","urlroot"=>""],
    	"backdetails" => ["class"=>"\App\Backdetail","table"=>"backdetails","seed"=> env("DBF_ROOT_PATH_R_2") . "/backdetail.DBF", "memo"=>"These are basically the same header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: brohead.dbf, brodetail.dbf, allhead.dbf,alldetail.dbf,oldallhead.dbf,oldalldetail.dbf,ancienthead.dbf ancientdetail.dbf","urlroot"=>""],
    	"brodetails" => ["class"=>"\App\Brodetail","seed"=> env("DBF_ROOT_PATH_R") . "/brodetail.DBF", "memo"=>"These are basically the same header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13).Similar to: brohead.dbf, brodetail.dbf, allhead.dbf,alldetail.dbf,oldallhead.dbf,oldalldetail.dbf,ancienthead.dbf ancientdetail.dbf","urlroot"=>""],
    	"webdetails" => ["class"=>"\App\Webdetail","seed"=> env("DBF_ROOT_PATH_RW_2") . "/webdetail.DBF", "memo"=>"This is where the DETAILS of a customer’s order is kept. These are orders coming off the website only. The key is field: remoteaddr  Orders are stored here until processed and then sent to files brohead.dbf and brodetail.dbf on RDATA.","urlroot"=>""],
    	"booktexts" => ["class"=>"\App\Booktext","seed"=> env("DBF_ROOT_PATH_R") . "/booktext.dbf", "memo"=>"This file holds the book copy associated with inventory records. ID Key is KEY (ISBN)","urlroot"=>""],
    	"dbfs" => ["class"=>"\App\Dbf","seed"=>"", "memo"=>"a table for tracking table statuses.","urlroot"=>""],
    	"commands" => ["class"=>"\App\Command","seed"=>false, "memo"=>"","urlroot"=>""],
    	"password_resets" => ["class"=>"\App\PasswordReset","seed"=>false, "memo"=>"This table handles user password resets.","urlroot"=>""],
    	"roles" => ["class"=>"\App\Role","seed"=>"CONFIG", "memo"=>"add memo","urlroot"=>""],
    	"role_user" => ["class"=>"\App\RoleUser","seed"=>"", "memo"=>"add memo","urlroot"=>""],
        "orders" => ["class"=>"\App\Order","seed"=>[], "memo"=>"This is a log of all titles purchased by vendor.","urlroot"=>""],
        "order_items" => ["class"=>"\App\OrderItem","seed"=>[], "memo"=>"This is a log of all titles purchased by vendor.","urlroot"=>""]
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
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
        [1,1]
    ],

"roles" => [
		"SUPER",
		"ADMIN",
		"VENDOR",
		"EMPLOYEE"
      ],

"company" => [
	"name" => "Center Point Large Print",
	"email" => "contact@centerpointlargeprint.com",
	"telephone" => "(800) 929-9108",
	"city" => "Thorndike",
	"state" => "Maine",
	"address" => "PO Box 1 Thorndike, Maine 04986",
	"website" => "www.centerpointlargeprint.com",
	"fax" => "(207) 568-3727",
	"logo" => "/img/logo.png"
    ],

    "image_extensions" => [
      ".png",".PNG",".jpg",".JPG",".jpeg",".bmp",".BMP",".txt"
    ]

];