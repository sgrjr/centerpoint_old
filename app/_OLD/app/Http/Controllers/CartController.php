<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth, Session;
use App\Jobs\AddToCart;

class CartController extends Controller
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
    public function index()
    {

      //email: jmonnin@pcdl.org
      // password: jjocrcjy
      $viewer = new \App\Viewer();
      $carts = $viewer->user->getCarts();

        return view('cart', [
            "webHead" => $carts->webhead,
            "company" => $carts->company,
            "remoteaddr" => $carts->remoteaddr,
            "totals" => $carts->totals
        ]);
    }

    public function reviewOrder(Request $request, $remoteaddr)
    {

      $order = \App\Webhead::ask()
          ->where("REMOTEADDR","==",  $remoteaddr)
          ->first();
 
        $order->updateShipping();

        $invoiceVars = \App\Helpers\Misc::invoiceVars(
          $order, $invoiceTitle="For Review - Not Submitted", $thanks=false, $invoiceMemo=false, $footerMemo=false, $remoteaddr
        );
    
        return view('review_order', $invoiceVars);
    }


      public function addToCart(Request $request, $isbn, $quantity)
    {
        $user = \App\User::getViewer();
        AddToCart::dispatch($user, $isbn, $quantity);

        return $this->attempt($request, true);
    }

    public function useCart(Request $request)
    {
      Session::put("use_cart", $request->input('remoteaddr'));
      return $this->attempt($request, true);
    }

    public function postAddToCart(Request $request)
    {
        $user = \App\User::getViewer();
        $isbn = $request->input('isbn');
        $quantity = $request->input('qty');

        AddToCart::dispatch($user, $isbn, $quantity);

        return $this->attempt($request, true);

    }
  
  public function postUpdateCart(Request $request)
    {
        $user = \App\User::getViewer();
        $action = $request->input('action');
        $redirect = false;

        switch($action){
          case "change_title_quantity":
            $record = \App\Webdetail::ask(true)->setIndex($request->input('index'))->first(["REQUESTED"]);
            $record->REQUESTED = $request->input('qty');
            $record->saveChanges();

            break;

          case "remove_title":
            $record = \App\Webdetail::ask(true)->setIndex($request->input('index'))->first();
            $record->deleteRecord();

            break;

          case "delete_cart":

            $record = \App\Webhead::ask(true)->setIndex($request->input('index'))->first(["REMOTEADDR"]);

            $REMOTEADDR = $record->REMOTEADDR;

            if(Session::get("use_cart") === $REMOTEADDR){Session::forget("use_cart");}

            $details = \App\WebHead::ask(true)->where("REMOTEADDR","===",$REMOTEADDR)->setPerPage(999)->get(["index"]);

            foreach($details->records AS $r){
              $r->deleteRecord();
            }

            $record->deleteRecord();
            
            break;

          case "submit_cart":
            $record = \App\Webhead::ask(true)->setIndex($request->input('index'))->first();
            $record->processOrder();
            Session::forget("use_cart");
            $redirect = "/?success=true";
          case "update_po":
            $record = \App\Webhead::ask(true)->setIndex($request->input('index'))->first(["PO_NUMBER"]);
            $record->PO_NUMBER = $request->input('po');
            $record->saveChanges();

            break;

          case "add_to_cart":
           ///move add to cart here

            break;

          case "update_billing":
              /* BILL_1",,"BILL_2","BILL_3","BILL_4","BILL_5" */
            break;

          case "update_attribute":
            $name = $request->input('attribute_name');
            $record = \App\Webhead::ask(true)->setIndex($request->input('index'))->first([$name]);
            $record->$name = $request->input('attribute_value');
            $record->saveChanges();
            break;

        }
        
        return $this->attempt($request, true, $redirect);
    }
  
  

    private function attempt($request, $successFail, $redirect=false){
        if($successFail){
            $request->session()->flash('message', 'Your <a href="/cart">SHOPPING CART</a> was updated.');
        }else{
            $request->session()->flash('error', 'Your <a href="/cart">SHOPPING CART</a> could not be updated.');
        }
        
        if($successFail && $redirect !== false){
          return redirect()->to($redirect);
        }else{
          return redirect()->back();
        }
        

    }

    public function postCreateCart(Request $request)
    {
      $user = \App\User::getViewer();
      $newCart = \App\Webhead::newCart($user->key);
      \Cache::forget("open_carts_count");
      return redirect()->back();
    }
    


}
