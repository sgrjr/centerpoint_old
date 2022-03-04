<?php

return [
    "dbname" => env("DB_DATABASE"),
    "datarootpath" => env("DATA_FILE_PATH"),
    "imagesrootpath" => env("IMAGES_ROOT_PATH"),
    "titleimagesrootpath" => env("TITLE_IMAGES_ROOT_PATH"),
    "noimagepath" => env("NO_IMAGE_PATH"),
    "marc_records_path" => env("MARC_RECORDS_PATH"),
    "serverimagerootpath" => env("SERVER_IMAGE_ROOT_PATH"),
    "dbfrootpathr" => env("DBF_ROOT_PATH_R"),
    "promotionspath" => env("PROMOTIONS_PATH"),
    "GRAPHQL_URL"=> env("GRAPHQL_URL","/graphql"),
    "files" => [
      "vendor"=> env("DBF_ROOT_PATH_RW") . "/VENDOR.DBF",
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
      "webhead"=> env("DBF_ROOT_PATH_RW") . "/WEBHEAD.DBF",
      "webdetail"=> env("DBF_ROOT_PATH_RW") . "/webdetail.DBF"   
    ],
    "tables" => [
      ["\App\Models\Cache","This is for the application cache drivers use."],
      ["\App\Models\Dbf","a table for tracking table statuses."],
      ["\App\Models\Passfile","This holds basically pairs of name/value for drop down choices in programming. It also holds the discounts for wholesaler accounts."],
      ["\App\Models\Vendor", "This table lists all our customers."],
      ["\App\Models\Inventory","This table lists our entire current inventory"],
      ["\App\Models\Booktext","This file holds the book copy associated with inventory records. ID Key is KEY (ISBN)"],
      ["\App\Models\User","This table lists customer credentials and preferences."],
      ["\App\Models\Role",''],
      ["\App\Models\RoleUser",""],
      ["\App\Models\Permission",''],
      ["\App\Models\PermissionRole",''],
      ["\App\Models\StandingOrder","This file holds info on our standing orders and choice customers. ID KEY IS KEY (Customer Key)"],
      
      ["\App\Models\Webhead","This is where HEADER information of the customer’s order is kept. These are orders coming off the website only. The key is field: remoteaddr  Orders are stored here until processed and then sent to files broHead.dbf and broDetail.dbf on RDATA."],
      ["\App\Models\Backhead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
      ["\App\Models\Brohead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
      ["\App\Models\Ancienthead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
      ["\App\Models\Allhead","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],

      ["\App\Models\Webdetail","This is where the DETAILS of a customer’s order is kept. These are orders coming off the website only. The key is field: remoteaddr  Orders are stored here until processed and then sent to files broHead.dbf and broDetail.dbf on RDATA."],
      ["\App\Models\Backdetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"], 
      ["\App\Models\Brodetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
      ["\App\Models\Command",""],
      ["\App\Models\Ancientdetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"],
      ["\App\Models\Alldetail","These are basically the same Header and lineitem orders file, just different states, like inprocess, or processed and archived, or backordered,The ID Key to all these files is Transno (N 13). Similar to: broHead.dbf, broDetail.dbf, allHead.dbf,allDetail.dbf,oldallHead.dbf,oldallDetail.dbf,ancientHead.dbf ancientDetail.dbf"]
       //["\App\Order","This is a log of all titles purchased by vendor."],
       //["\App\OrderItem","This is a log of all titles purchased by vendor."],
       
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
		["INDEX"=>9999999999,"KEY"=>"0106000000001", "FIRST"=>"Stephen", "MIDNAME"=>"Gordon", "LAST"=>"Reynolds","ARTICLE"=>"Mr.","EMAIL"=>"sgrjr@deliverance.me", "UPASS"=>"1230happy","ORGNAME"=>"FAKE ORGANIZATION","COMPANY"=>"FAKE COMPANY"]
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

  "permissions" => [
    ["name"=>"VIEW_REGISTER_USER","description"=>""],
    ["name"=>"VIEW_DASHBOARD","description"=>""],
    ["name"=>"VIEW_VENDORS","description"=>""],
    ["name"=>"MODIFY_ADMIN_RESOURCE","description"=>""],
    ["name"=>"ADMIN_APP","description"=>""],
    ["name"=>"LIST_ALL_USERS","description"=>""]
  ],

  "permission_role" => [
    ["role_id"=>1, "permission_id"=>1],
    ["role_id"=>1, "permission_id"=>2],
    ["role_id"=>1, "permission_id"=>3],
    ["role_id"=>1, "permission_id"=>4],
    ["role_id"=>1, "permission_id"=>5],
    ["role_id"=>1, "permission_id"=>6],
    ["role_id"=>2, "permission_id"=>1],
    ["role_id"=>2, "permission_id"=>2],
    ["role_id"=>2, "permission_id"=>3],
    ["role_id"=>2, "permission_id"=>4],
    ["role_id"=>2, "permission_id"=>5],
    ["role_id"=>2, "permission_id"=>6],
    ["role_id"=>4, "permission_id"=>1],
    ["role_id"=>4, "permission_id"=>2],
    ["role_id"=>4, "permission_id"=>3],
    ["role_id"=>3, "permission_id"=>2]
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
	"logo" => "/img/original/logo.png"
    ],

    "image_extensions" => [
      ".png",".PNG",".jpg",".JPG",".jpeg",".bmp",".BMP",".txt"
    ],

  "search_suggestions"=>[
      
      ["id"=>1, "coverArt"=>"https://www.faithwords.com/wp-content/uploads/2017/09/Mystery-Thriller-Genre-Category-Featured-Image.png?fit=1200%2C628", "TITLE"=>"Thriller, genre", "AUTHOR"=>"Thriller", "url"=>"/search/thriller/genre","featured"=>true],
      ["id"=>2, "coverArt"=>"https://jcproductionstorage.blob.core.windows.net/jc-image-storage/1.148191-24112016-GuitarJPEG.jpg?w=1440&h=768&fit=fill&f=faces&q=50", "TITLE"=>"Elissa Altman, Author", "AUTHOR"=>"Elissa Altman", "url"=>"/search/altman/author","featured"=>false],
      ["id"=>3, "coverArt"=>"https://www.babelio.com/users/AVT_Douglas-Preston_3020.jpeg", "TITLE"=>"Preston Douglas, author", "AUTHOR"=>"Preston Douglas", "url"=>"/search/prestondouglas/author","featured"=>false],
      ["id"=>4, "coverArt"=>"https://www.organicauthority.com/.image/t_share/MTU5MzMwMTc1NDkwNzI5NTY4/save-money.jpg", "TITLE"=>"Less than $20, Great Price", "AUTHOR"=>"List Price", "url"=>"/search/20/price","featured"=>false],
      ["id"=>5, "coverArt"=>"https://lindsaygodfree.com/wp-content/uploads/2019/01/twin-flames-lindsaygodfree.jpg", "TITLE"=>"Romance, genre", "AUTHOR"=>"Romance", "url"=>"/search/romance/genre","featured"=>true],
      ["id"=>6, "coverArt"=>"https://images.unsplash.com/photo-1558642452-9d2a7deb7f62", "TITLE"=>"Honey", "AUTHOR"=>"@helloimnik", "url"=>"/search/honey/title","featured"=>false],
      ["id"=>7, "coverArt"=>"https://images.unsplash.com/photo-1516802273409-68526ee1bdd6", "TITLE"=>"Basketball", "AUTHOR"=>"@helloimnik", "url"=>"/search/ball/title","featured"=>false],
      ["id"=>8, "coverArt"=>"https://static.fdocuments.in/img/1200x630/reader011/image/20181230/5564792cd8b42ae57c8b5789.png?t=1607972552", "TITLE"=>"Western, genre", "AUTHOR"=>"Western", "url"=>"/search/western/genre","featured"=>true],
      ["id"=>9, "coverArt"=>"https://images.unsplash.com/photo-1597645587822-e99fa5d45d25", "TITLE"=>"Mushrooms", "AUTHOR"=>"@helloimnik", "url"=>"/search/mushroom/title","featured"=>false],
      ["id"=>10, "coverArt"=>"https://images.unsplash.com/photo-1567306301408-9b74779a11af", "TITLE"=>"Tomato", "AUTHOR"=>"@helloimnik", "url"=>"/search/tomato/title","featured"=>false],
      ["id"=>11, "coverArt"=>"https://images.unsplash.com/photo-1471357674240-e1a485acb3e1", "TITLE"=>"Sea Star", "AUTHOR"=>"@helloimnik", "url"=>"/search/sea/title","featured"=>false],
      ["id"=>12, "coverArt"=>"/img/original/9781628999266.jpg", "TITLE"=>"Poor Man's Feast, book", "AUTHOR"=>"Elissa Altman", "url"=>"/isbn/9781628999266","featured"=>true],
    ]

];