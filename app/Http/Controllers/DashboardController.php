<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth, Session;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$user = \App\User::getViewer();

        //$data = new \stdclass;


        //$data->vendor = \App\Vendor::ask()->where("KEY","===", $user->KEY)->first();

        /*$data->processing_carts = \App\BroHead::ask()
            ->setPerPage(1000)
            ->where("KEY","===", $user->KEY )

            ->get();

        $profileLinks = [
          ["/cart","Shopping Cart ->"],
          ["/dashboard/my-titles","My Purchased Titles ->"],
          ["/dashboard/settings","Account Settings ->"],
          ["/dashboard/orders/standing-orders","Standing Orders ->"],
          ["/dashboard/orders/back-ordered","Back Orders ->"],
          ["/dashboard/orders/history","Recent Order History ->"],
          ["/dashboard/orders/bro","Bro? Order History ->"],
          ["/dashboard/orders/archived-history","Archived Order History ->"]
        ];
            
      $activeSo = $data->vendor? $data->vendor->activeStandingOrders->records : [];

      $titlesList = collect([]);

      foreach($activeSo AS $so){
        $titles = \App\Inventory::ask()->setPerPage(5)->where("SOPLAN","=ci", $so->SOSERIES)->where("STATUS","==","Available")->get()->records;
        $titlesList->add( $titles );
      }
      $titlesList = $titlesList->collapse();
      $list = collect([]);

      foreach($titlesList AS $title){
        $x = new \stdclass;
        $x->book = $title;
        $x->so =  $title->referenceStandingOrderList($activeSo);
        $list = $list->push($x);
      }
*/
        return view('profile', [
           // "vendor" => $data->vendor,
           // "user" => $user,
            //"processing_carts" => $data->processing_carts,
            //"profileLinks" => $profileLinks,
            //"titles" =>  $list,
            //"standingOrders" => $activeSo
        ]);
    }

    public function standingOrders()
    {

    //Standing Orders
        $q = \App\StandingOrder::ask()
            ->where("KEY","===", \App\User::getViewer()->key)
            ->get();

        return view('standingOrders', [
            'standingOrders' =>  $q->records,
            'standingOrdersPaginator' =>  $q->paginator,
            "user" => \App\User::getViewer()
        ]);
    }

    public function myTitles()
    {

    //My Titles Purchased
      $user = \App\User::getViewer();

        return view('my-titles', [
            'titles' =>  $user->titles,
            "user" => \App\User::getViewer()
        ]);
    }

    public function settings()
    {
        //CREDENTIALS FOR AUTHORIZED USER
        $q = \App\Password::ask()
            ->where("KEY","===", \App\User::getViewer()->KEY)
            ->where("EMAIL","===", \App\User::getViewer()->EMAIL)
            ->first();
        
        $viewer = \App\User::getViewer();

        return view('credentials', [
            'credentials' =>  $q,
            "user" => $viewer,
            "vendor" => \App\Vendor::ask()->where("KEY","===", $viewer->KEY)->first()
        ]);
    }

    public function allHead()
    {

     //allhead
        $q = \App\AllHead::ask()
            ->where("KEY","===", \App\User::getViewer()->key)
            ->get(["DATE","TRANSNO","ORDEREDBY","PO_NUMBER", "OSOURCE","ITEMS", "REMOTEADDR"]);
        return view('history', [
            'history' =>  $q->records,
            "user" => \App\User::getViewer()
        ]);
    }

    public function ancientHead()
    {

     //ancienthead
        $q = \App\AncientHead::ask()
            ->where("KEY","===", \App\User::getViewer()->key)
            ->get(["DATE","TRANSNO","ORDEREDBY","PO_NUMBER", "OSOURCE","ITEMS", "REMOTEADDR"]);

        return view('history', [
            'history' =>  $q->records,
            "user" => \App\User::getViewer()
        ]);
    }

    public function backHead()
    {

     //backhead
        $backhead = \App\BackHead::ask()
            ->where("KEY","===", \App\User::getViewer()->key)
            ->get(["DATE","TRANSNO","ORDEREDBY","PO_NUMBER", "OSOURCE","ITEMS", "REMOTEADDR"]);

        return view('history', [
            'history' =>  $backhead->records,
            "user" => \App\User::getViewer()
        ]);
    }

    public function broHead()
    {

      //brohead
        $q = \App\BroHead::ask()
            ->where("KEY","===", \App\User::getViewer()->key )
            ->get( ["DATE","TRANSNO","ORDEREDBY","PO_NUMBER", "OSOURCE","ITEMS", "REMOTEADDR"] );

        return view('history', [
            'history' =>  $q->records,
            "user" => \App\User::getViewer()
        ]);
    }

//////////////////////////////////////////////////////
//////////////////////////////////////////////////

    public function allDetail(Request $request, $transactionNumber)
    {

      $order = \App\AllHead::ask()
            ->where("KEY","===", \App\User::getViewer()->key)
            ->where("TRANSNO","===", $transactionNumber)
            ->first();

        return $this->ordersView($transactionNumber, "\App\AllHead","Invoice", $order);
    }

    public function ancientDetail(Request $request, $transactionNumber)
    {
          $order = \App\AncientHead::ask()
            ->where("KEY","===", \App\User::getViewer()->key)
            ->where("TRANSNO","===", $transactionNumber)
            ->first();
            //["DATE","TRANSNO","ORDEREDBY","PO_NUMBER", "OSOURCE"]
        return $this->ordersView($transactionNumber, "\App\AncientHead","Invoice", $order);
    }

    public function broDetail(Request $request, $transactionNumber)
    {
          $order = \App\BroHead::ask()
            ->where("KEY","===", \App\User::getViewer()->key)
            ->where("TRANSNO","===", $transactionNumber)
            ->first();


        return $this->ordersView($transactionNumber, "\App\BroHead","Processing", $order);
    }

     public function backOrder(Request $request, $transactionNumber)
    {
            $order = \App\BackHead::ask()
            ->where("KEY","===", \App\User::getViewer()->key)
            ->where("TRANSNO","===", $transactionNumber)
            ->first();

        return $this->ordersView($transactionNumber, "\App\BackHead","Back Ordered (Not an Invoice)", $order);
    }

    public function processing(Request $request, $remoteaddr)
    {
        $order = \App\WebHead::ask()
            ->where("REMOTEADDR","LIKE", $remoteaddr)
            ->first(["KEY","DATE","BILL_1","PSHIP","ORDEREDBY","SHIPPING","OTHERDESC","BILL_2","BILL_3","BILL_4","BILL_5","COMPANY","ATTENTION","STREET","ROOM","DEPT","CITY","STATE","POSTCODE","COUNTRY","VOICEPHONE","FAXPHONE","EMAIL","SENDEMCONF","PO_NUMBER","TIMESTAMP","DATESTAMP","UPS_KEY","UPSDATE","COMMCODE","TERMS","OSOURCE","OSOURCE2","OSOURCE3","OSOURCE4","CINOTE","CXNOTE","CPHOLD","TRANSNO", "DETAILS","REMOTEADDR"]); 



        return $this->ordersView($remoteaddr, "\App\WebHead","Invoice (Order Not Processed)", $order);
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////

    private function ordersView($remoteaddr, $headClass, $title, $order = false){

      if(!$order){
          $order = $headClass::ask()
            ->where("TRANSNO","===",(int) $remoteaddr)
            ->first(); 
      }

      $invoiceVars = \App\Helpers\Misc::invoiceVars(
          $order, $invoiceTitle="Invoice - Processing", $thanks=false, $invoiceMemo=false, $footerMemo=false, $remoteaddr
        );

        return view('order', $invoiceVars);
    }
     
     private function allHeadData(){
       $orderColumns = ["DATE","TRANSNO","ORDEREDBY","PO_NUMBER", "OSOURCE","ITEMS", "REMOTEADDR"];
        $vendorKey = \App\User::getViewer()->key;

      //allhead
        $allhead = \App\Model\AllHead::make("allHead")
            ->setTests([["KEY","===", $vendorKey ]])
            ->setColumns($orderColumns);

        return Database::get([
            $allhead
        ]);
    }



     private function ancientHeadData(){
       $orderColumns = ["DATE","TRANSNO","ORDEREDBY","PO_NUMBER", "OSOURCE","ITEMS", "REMOTEADDR"];
        $vendorKey = \App\User::getViewer()->key;
 
      //ancienthead
        $ancienthead = \App\Model\AncientHead::make("ancientHead")
            ->setTests([["KEY","===", $vendorKey ]])
            ->setColumns($orderColumns);

        return Database::get([
            $ancienthead
        ]);
    }

   public function updateProp(Request $request, $prop){

        switch($prop){

          case 'avatar':
             $file = $request->file('file');
   
              //File Name
              //$file->getClientOriginalName();

              //File Extension
              //$file->getClientOriginalExtension();
           
              //File Real Path
              //$file->getRealPath();
           
            //File Size
            //$file->getSize();

              //File Mime Type
              //$file->getMimeType();
           
              //Move Uploaded File
              $destinationPath = public_path() . '/uploads/avatar';
              $file->move($destinationPath, $request->input('userkey') . "." . $file->getClientOriginalExtension());

            break;

          default:

            //
        }

        return redirect()->back();
    }
}
