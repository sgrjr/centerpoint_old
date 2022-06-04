<div class="container @if($remoteaddr !== $cart["order"]->remoteaddr)dark @endif">

	@if($remoteaddr === $cart["order"]->remoteaddr) 
		<h2>Shopping Cart <span class="badge badge-primary">(open)</span> DATE: {{$cart["order"]->date}}</h2>
	@else
		<h2> Shopping Cart
		<form action="/cart/use-cart" method="post" style="display:inline;">
		  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		  <input type="hidden" name="_method" value="POST">
		  <input type="hidden" name="remoteaddr" value={{$cart["order"]->remoteaddr}}>
			  <button class="btn btn-success" type="submit" >Use This Cart <i class="fa fa-angle-right"></i></button>
		</form>

		DATE: {{$cart["order"]->date}}

		</h2>
	@endif

	<table id="cart" class="table table-hover table-condensed">

    				<thead>
						<tr>
							<th colspan="2">Product</th>
							<th>Invoice Type</th>
							<th>Price</th>
							<th>Quantity</th>
							<th class="text-center">Subtotal</th>
						</tr>
					</thead>
					<tbody>

@if($cart["items"] !== null)
					@foreach($cart["items"] AS $item)

						@if($item->qty > 0)
						<tr>
							<td data-th="Product" colspan="2">
								<div class="row">

								<form action="/cart/update" method="post">
								  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								  <input type="hidden" name="index" value={{$item->index}}>
								  <input type="hidden" name="_method" value="POST">
								  <input type="hidden" name="action" value="remove_title">
								  <input type="hidden" class="form-control text-center" id="qty" name="qty" value="0">
								  <button class="btn btn-danger btn-sm" type="submit" ><i class="fas fa-trash-alt"></i></button>
								</form> 

									<a href={{$item->url}}>
									<img src="{{$item->image}}" alt="..." class="cover-art" ALIGN="Left"/>
									<h4>{!!$item->description!!}</h4>
									</a>

								</div>
							</td>

							<td>{{$item->INVNATURE}}</td>
							<td data-th="Price" >$ {{ $item->SALEPRICE }} </td>
							<td data-th="Quantity">
								<form action="/cart/update" method="post">
								  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								  <input type="hidden" name="index" value={{$item->index}}>
								  <input type="hidden" name="_method" value="POST">
								  <input type="hidden" name="action" value="change_title_quantity">
								  <input type="number" class="text-center" style="width:55px;" id="qty" name="qty" placeholder="1" min="1" max="100" value={{$item->qty}}>
								  <button class="btn btn-primary btn-sm" type="submit" value="save changes"><i class="fas fa-save"></i></button>
								</form> 
								
							</td>
							<td data-th="Subtotal" class="text-center">$ {{$item->cost}}</td>
						</tr>
						@endif
                    @endforeach
@endif
					</tbody>
					<tfoot>
					
						@foreach($cart["totaling"] AS $total)
							<tr>
								<td colspan="3"></td>
								<td>{{$total->title}}</td>
								<td class="text-center"><strong> $ {{$total->amount}}</strong></td>
							</tr>
						@endforeach

						<tr>

							<td>
								<form action="/cart/update" method="post" onsubmit="return confirm('Are you sure you want to DELETE this cart?');">
								  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								  <input type="hidden" name="index" value={{$cart["order"]->index}}>
								  <input type="hidden" name="_method" value="POST">
								  <input type="hidden" name="action" value="delete_cart">
								  <input type="hidden" class="form-control text-center" id="qty" name="qty" value="0">
								  <button class="btn btn-danger btn-sm" type="submit" ><i class="fas fa-trash-alt"></i> DELETE CART</button>
								</form> 
							</td>
							<td></td><td></td><td></td>
							<td>

								<a href={{"/cart/review/" . $remoteaddr}} class="btn btn-success btn-sm" type="submit" >Review & Submit Order <i class="fa fa-angle-right"></i></a>
								
							</td>

						</tr>

			<tr><td colspan="5">
					PO#: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" name="index" value={{$cart["order"]->index}}>
			  <input type="hidden" name="action" value="update_po">
			   <input type="text" class="text-center" id="po" name="po" value={{$cart["order"]->PO_NUMBER}}>

				  <button class="btn btn-success btn-sm" type="submit" >Update PO <i class="fa fa-angle-right"></i></button>
			</form>

	</td>
</tr>
<tr>
	<td colspan="5">
							DATE: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" name="index" value={{$cart["order"]->index}}>
			  <input type="hidden" name="action" value="update_attribute">
			   <input type="text" class="text-center" id="attribute_value" name="attribute_value" value={{$cart["order"]->DATE}}>

			   <input type="hidden" name="attribute_name" value="DATE">

				  <button class="btn btn-success btn-sm" type="submit" >Update DATE <i class="fa fa-angle-right"></i></button>
			</form>

	</td>

			</tr>

			<!-- -->
			<tr><td colspan="5">
		Billing Line #1: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" name="index" value={{$cart["order"]->index}}>
			  <input type="hidden" name="action" value="update_attribute">
			   <input type="text" class="text-center" id="attribute_value" name="attribute_value" value={{$cart["order"]->BILL_1}}>

			   <input type="hidden" name="attribute_name" value="BILL_1">

				  <button class="btn btn-success btn-sm" type="submit" >Update <i class="fa fa-angle-right"></i></button>
			</form>

	</td></tr>

				<tr><td colspan="5">
		Billing Line #2: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" name="index" value={{$cart["order"]->index}}>
			  <input type="hidden" name="action" value="update_attribute">
			   <input type="text" class="text-center" id="attribute_value" name="attribute_value" value={{$cart["order"]->BILL_2}}>

			   <input type="hidden" name="attribute_name" value="BILL_2">

				  <button class="btn btn-success btn-sm" type="submit" >Update <i class="fa fa-angle-right"></i></button>
			</form>

	</td></tr>

				<tr><td colspan="5">
		Billing Line #3: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" name="index" value={{$cart["order"]->index}}>
			  <input type="hidden" name="action" value="update_attribute">
			   <input type="text" class="text-center" id="attribute_value" name="attribute_value" value={{$cart["order"]->BILL_3}}>

			   <input type="hidden" name="attribute_name" value="BILL_3">

				  <button class="btn btn-success btn-sm" type="submit" >Update <i class="fa fa-angle-right"></i></button>
			</form>

	</td></tr>

				<tr><td colspan="5">
		Billing Line #4: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" name="index" value={{$cart["order"]->index}}>
			  <input type="hidden" name="action" value="update_attribute">
			   <input type="text" class="text-center" id="attribute_value" name="attribute_value" value={{$cart["order"]->BILL_4}}>

			   <input type="hidden" name="attribute_name" value="BILL_4">

				  <button class="btn btn-success btn-sm" type="submit" >Update <i class="fa fa-angle-right"></i></button>
			</form>

	</td></tr>
			<!-- -->

					</tfoot>
				</table>

<!-- 
FROM CURRENT SITE:

ADD TO CART FORM POSTS THE FOLLOWING:

//////////////////////
x: 73
y: 31
ISBN9781683243601: 8 <---this is the quantity
bzp: TD_TITLE_WRITE
INVLMNT: 
z01: stephenreynolds
z02: sunshine
z03: 0498600000003
z04: 23607
HEADER_FILE: WEBHEAD
DETAIL_FILE: WEBDETAIL
RETURNPAGE: TD_TITLE_VIEW
PASSZREC: 
SEARCHBY: BYTITLE
SORTBY: BYAUTHORS
MULTIBUY: ON
FULLVIEW: ON
SKIPBOUGHT: ON
OUTOFPRINT: ON
OPROCESS: ON
OADDTL: ON
OVIEW: ON
ORHIST: ON
INSOS: OFF
INREG: OFF
OINVO: OFF
EXTZN: OFF
OBEST: ON
ADVERTISE: OFF
DEFAULTPER: 
////////////////////////


SUBMIT SHOPPING CART FORM POSTS THE FOLLOWING:

//////////////////////


 
////////////////////////


*************title search*********************************

<body onload="TD_TITLE_VIEW.ISBN9781643581767.focus()">
<form name="TD_TITLE_VIEW" action="http://centerpointlargeprint.com/foxisapi/foxisapi.dll/webnet.gate.startpoint" method="post" enctype="application/x-www-form-urlencoded">
<div id="site-container" style="padding-right:12px;width:1050px;"><div style="display: table-row;"><table style="text-align:left;">
<tbody><tr><td><img src="http://centerpointlargeprint.com/cp_info/icons/CP_Home_Menu.jpg" style="height:180px;width:1050px;" alt=""></td></tr>
</tbody></table>
</div>
<div style="display: table-row;"><div id="global-prime-menu-navigation" style="padding-left:6px;">
<div><a href="#" onclick="history.go(-1);return false;"><img src="http://centerpointlargeprint.com/cp_info/icons/A_Go_Back_Paw.png" height="18" width="18" alt=""></a>
</div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=MAINMENU%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26">Main Menu</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=GENERAL_VIEW%26WHATACTION=CHANGELI%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=GENERAL_VIEW%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER%5FFILE=WEBHEAD%26DETAIL%5FFILE=WEBDETAIL%26RETURNPAGE=TD%5FTITLE%5FVIEW%26PASSZREC=354%26SEARCHBY=BYTITLE%26SORTBY=BYAUTHORS%26MULTIBUY=ON%26FULLVIEW=ON%26SKIPBOUGHT=ON%26OUTOFPRINT=ON%26OPROCESS=ON%26OADDTL=ON%26OVIEW=ON%26ORHIST=ON%26INSOS=OFF%26INREG=OFF%26OINVO=OFF%26EXTZN=OFF%26OBEST=ON%26ADVERTISE=OFF%26DEFAULTPER=Stephen%2BReynolds%26LOGINS=11">Change Items</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=ORDER_DELETE%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=MAINMENU%26" onclick="return confirm ('Are you sure you want to delete this order?')" title="Delete Entire Order Contents and Order Information">Delete Order</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=GENERAL_VIEW%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=TD_TITLE_VIEW%26">View Order</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=GENERAL_VIEW%26WHATACTION=CHANGEMA%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER%5FFILE=WEBHEAD%26DETAIL%5FFILE=WEBDETAIL%26RETURNPAGE=TD%5FTITLE%5FVIEW%26PASSZREC=354%26SEARCHBY=BYTITLE%26SORTBY=BYAUTHORS%26MULTIBUY=ON%26FULLVIEW=ON%26SKIPBOUGHT=ON%26OUTOFPRINT=ON%26OPROCESS=ON%26OADDTL=ON%26OVIEW=ON%26ORHIST=ON%26INSOS=OFF%26INREG=OFF%26OINVO=OFF%26EXTZN=OFF%26OBEST=ON%26ADVERTISE=OFF%26DEFAULTPER=Stephen%2BReynolds%26LOGINS=11">Change Address, PO #</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=PRE_ORDER_CLOSE%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=PRE_ORDER_CLOSE%26" onclick="return confirm ('Are you finished ordering and are ready to place your order or store in a shopping cart?')" title="Complete Order Process. Save order in a cart for future use, or send to Center Point for shipping and billing."> Complete/Store In Cart</a></div>
</div>
</div>
<div style="display: table-row;"><div id="secondary-navigation">
<table><tbody><tr>
<td><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=MENU_SWITCH%26SWITCHWHAT=MULTIBUY%26SWITCHVALUE=OFF%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=TD_TITLE_VIEW%26INVQUERY=%26INVLMNT=%26">
&nbsp;&nbsp;Single Quantity Ordering</a></td>
<td><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=MENU_SWITCH%26SWITCHWHAT=ADVERTISE%26SWITCHVALUE=ON%26SEARCH_INPUT=%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=TD_TITLE_VIEW%26INVQUERY=%26INVLMNT=%26">
&nbsp;&nbsp;Quicken &amp; Show Sleek Website</a></td>
<td><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=MENU_SWITCH%26SWITCHWHAT=FULLVIEW%26SWITCHVALUE=OFF%26RETURNPAGE=TRADE_HOUSE_CUSTOMER_VIEW%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26"> &nbsp;&nbsp;Hide Pictures &amp; Copy</a></td>
</tr></tbody></table>
</div>
</div>
<table style="vertical-align:top;">
<tbody><tr>
<td style="text-align:left;vertical-align:top;">
<div style="display: table-row;"></div>
<table style="width:1050px;background:#B9D3EE;padding-top:6px;padding-bottom:8px;border-top:1px solid;border-left:1px solid;border-bottom:5px solid;border-right:4px solid;"><tbody><tr>
<td style="padding-left:12px;padding-right:12px;text-align:left;">&nbsp;</td>
<td style="padding-left:6px;padding-right:6px;text-align:left;padding-top:6px;vertical-align:top;"><input type="image" src="http://centerpointlargeprint.com/cp_info/icons/A_Quantity.png" style="height:60px;width:220px;" alt="">
</td>
<td style="padding-left:6px;padding-right:6px;text-align:left;padding-top:6px;">
<a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=TD_TITLE_VIEW%26%26SINGLEISBN=%26SEARCH_INPUT=%26INVQUERY=%26INVLMNT=%26PROMONAME=%26PROMOQUAN=%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26%26z04=23607%26%26HEADER_FILE=WEBHEAD%26%26DETAIL_FILE=WEBDETAIL%26%26"> <input type="image" src="http://centerpointlargeprint.com/cp_info/icons/A_Return_NoSave.png" style="height:60px;width:220px;" alt=""></a>
</td>
<td style="font-size:18px;padding-left:6px;padding-right:6px;text-align:left;padding-top:6px;">Large Print Titles — 25% Off </td>
</tr></tbody></table>

<table style="vertical-align:top;background:#F0F0F0;padding-left:6px;padding-right:4px;padding-top:4px;padding-top:2px;border-top:1px solid;border-left:1px solid;border-bottom:1px solid;border-right:1px solid;">
<tbody><tr><td style="vertical-align:top;">
<table style="text-align:top;vertical-align:top;background:#F0F0F0;width:750px;padding-left:8px;padding-right:4px;padding-top:2px;border-top:1px solid #F8F8FF;border-left:1px solid;border-bottom:1px solid #F8F8FF;border-right:1px solid #F8F8FF;">
<tbody><tr><td style="text-align:left;font-size:16px;display:inline;padding-left:2px;font-weight:bold;">
<div style="vertical-align:top;text-align:left;font-size:18px;display:inline;padding-left:2px;font-weight:bold;"><input type="text" maxlength="3" size="2" value="1" style="width:15px;height:16px;padding-right:4px;padding-top:3px;" name="ISBN9781643581767">
</div>
<div style="vertical-align:top;text-align:left;font-size:16px;display:inline;padding-left:2px;padding-right:4px;font-weight:bold;">
Crown Jewel</div>
<div style="vertical-align:top;text-align:left;font-size:16px;display:inline;padding-left:2px;padding-right:6px;font-weight:bold;">
 <i>by</i> Christopher Reich</div>
</td></tr>
<tr><td>
<div style="vertical-align:center;padding-left:2px;font-size:16px;;padding-top:6px;padding-bottom:6px;padding-right:6px;font-weight:bold;color:#800080;">
<i>New York Times</i> bestselling author                                                            </div>
<div style="font-size:14px;padding-top:8px;padding-bottom:2px;padding-left:6px;text-align:left;bold;color:#241882;">&nbsp;&nbsp;&nbsp;<i></i>“Likable, rascally, and suave, Riske is as distinctive as Reich’s other series lead, Jonathan Ransom.” — <b><span style="font-size:14px;font-weight:bold;"><i></i> <i>Publishers Weekly</i></span></b></div>
<div style="font-size:14px;padding-top:8px;padding-bottom:2px;padding-left:6px;text-align:left;color:black;">&nbsp;&nbsp;&nbsp;Monte Carlo’s most lavish casinos have become the targets of an efficient, brutal, and highly successful group of criminal gamblers; a casino dealer has been beaten to death; a German heiress’s son has been kidnapped. Who better to connect the crimes, and foil the brilliant plot, then Simon Riske, freelance industrial spy?
</div>
<div style="font-size:14px;padding-top:8px;padding-bottom:2px;padding-left:6px;text-align:left;color:black;">&nbsp;&nbsp;&nbsp;Riske — part Bond, and part Reacher — knows the area well: it’s where, as a young man, he himself was a thrill-seeking thief, robbing armored trucks through daring car chases, until he was double-crossed, served his time, and graduated as an investment genius from the Sorbonne.</div>
<div style="font-size:14px;padding-top:8px;padding-bottom:2px;padding-left:6px;text-align:left;color:black;">&nbsp;&nbsp;&nbsp;Now Riske is a man who solves problems, the bigger and the “riskier” the better. From the baccarat tables of the finest casinos to the yachts in the marina, to the private jet company that somehow ties these criminal enterprises together, Simon Riske will do what he does best: get in over his head, throw himself into danger, and find some way to out-think and out-maneuver villains of every stripe.</div>
</td></tr>
<tr><td style="padding-top:2px;padding-bottom:2px;padding-left:2px;text-align:left;font-size:14px;display:inline;font-weight:bold;">9781643581767&nbsp;—&nbsp;Hardcover&nbsp;—&nbsp;Fiction - Adventure&nbsp;—&nbsp;Coming: May 2019</td></tr>
<tr><td style="padding-top:2px;padding-bottom:2px;padding-left:2px;text-align:left;font-size:14px;display:inline;font-weight:bold;">List Price: $38.95&nbsp;—&nbsp;Your Price: $ 29.21&nbsp;—&nbsp;Save $&nbsp;9.74&nbsp;—&nbsp;Save 25%
</td></tr>
</tbody></table>
</td>
<td>
<table style="width:214px;font-size:11px;text-align:center;border-top:1px solid;border-left:1px solid;border-bottom:1px solid;border-right:1px solid;">
<tbody><tr><td><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=TD_TITLE_VIEW%26SINGLEISBN=9781643581767%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER%5FFILE=WEBHEAD%26DETAIL%5FFILE=WEBDETAIL%26RETURNPAGE=TD%5FTITLE%5FVIEW%26PASSZREC=354%26SEARCHBY=BYTITLE%26SORTBY=BYAUTHORS%26MULTIBUY=ON%26FULLVIEW=ON%26SKIPBOUGHT=ON%26OUTOFPRINT=ON%26OPROCESS=ON%26OADDTL=ON%26OVIEW=ON%26ORHIST=ON%26INSOS=OFF%26INREG=OFF%26OINVO=OFF%26EXTZN=OFF%26OBEST=ON%26ADVERTISE=OFF%26DEFAULTPER=Stephen%2BReynolds%26LOGINS=11">
<img src="http://centerpointlargeprint.com/cp_info/cp_pictures/158/9781643581767.JPG" style="width:140px;height:225px;" alt=""></a></td></tr>
</tbody></table>
</td>

</tr></tbody></table>

<input type="hidden" name="bzp" value="TD_TITLE_WRITE">
<input type="hidden" name="INVLMNT" value="">
<input type="hidden" name="z01" value="stephenreynolds">
<input type="hidden" name="z02" value="sunshine">
<input type="hidden" name="z03" value="0498600000003">
<input type="hidden" name="z04" value="23607">
<input type="hidden" name="HEADER_FILE" value="WEBHEAD">
<input type="hidden" name="DETAIL_FILE" value="WEBDETAIL">
<input type="hidden" name="RETURNPAGE" value="TD_TITLE_VIEW">
<input type="hidden" name="PASSZREC" value="">
<input type="hidden" name="SEARCHBY" value="BYTITLE">
<input type="hidden" name="SORTBY" value="BYAUTHORS">
<input type="hidden" name="MULTIBUY" value="ON">
<input type="hidden" name="FULLVIEW" value="ON">
<input type="hidden" name="SKIPBOUGHT" value="ON">
<input type="hidden" name="OUTOFPRINT" value="ON">
<input type="hidden" name="OPROCESS" value="ON">
<input type="hidden" name="OADDTL" value="ON">
<input type="hidden" name="OVIEW" value="ON">
<input type="hidden" name="ORHIST" value="ON">
<input type="hidden" name="INSOS" value="OFF">
<input type="hidden" name="INREG" value="OFF">
<input type="hidden" name="OINVO" value="OFF">
<input type="hidden" name="EXTZN" value="OFF">
<input type="hidden" name="OBEST" value="ON">
<input type="hidden" name="ADVERTISE" value="OFF">
<input type="hidden" name="DEFAULTPER" value="">

</td></tr></tbody></table></div></form></body>

****************ACTUAL SHOPPPING CART*************************************
- has "marc" & "view" links per item in cart that open with javascript in popup

<form name="GENERAL_VIEW" method="post" action="http://centerpointlargeprint.com/foxisapi/foxisapi.dll/webnet.gate.startpoint" enctype="application/x-www-form-urlencoded">
<div id="site-container" style="width:1160px;"> 
<table style="text-align:left;vertical-align:top;">
<tbody><tr><td>
<table style="text-align:left;">
<tbody><tr><td><img src="http://centerpointlargeprint.com/cp_info/icons/CP_Home_Menu.jpg" style="height:180px;width:1150px;" alt=""></td></tr>
</tbody></table>
</td></tr>

<tr><td>
<div id="global-prime-menu-navigation" style="padding-left:6px;">
<div><a href="#" onclick="history.go(-1);return false;"><img src="http://centerpointlargeprint.com/cp_info/icons/A_Go_Back_Paw.png" height="18" width="18" alt=""></a>
</div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=MAINMENU%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26">Main Menu</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=GENERAL_VIEW%26WHATACTION=CHANGELI%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=GENERAL_VIEW%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26PASSZREC=354%26SEARCHBY=BYTITLE%26SORTBY=BYAUTHORS%26MULTIBUY=ON%26FULLVIEW=ON%26SKIPBOUGHT=ON%26OUTOFPRINT=ON%26OPROCESS=ON%26OADDTL=ON%26OVIEW=ON%26ORHIST=ON%26INSOS=OFF%26INREG=OFF%26OINVO=OFF%26EXTZN=OFF%26OBEST=ON%26ADVERTISE=OFF%26DEFAULTPER=Stephen+Reynolds%26LOGINS=11RETURNPAGE=TD_TITLE_VIEW%26">Change Items</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=ORDER_DELETE%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=MAINMENU%26" onclick="return confirm ('Are you sure you want to delete this order?')" title="Delete Entire Order Contents and Order Information">Delete Order</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=TD_TITLE_VIEW%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=TD_TITLE_VIEW%26">Continue Ordering</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=GENERAL_VIEW%26WHATACTION=CHANGEMA%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26PASSZREC=354%26SEARCHBY=BYTITLE%26SORTBY=BYAUTHORS%26MULTIBUY=ON%26FULLVIEW=ON%26SKIPBOUGHT=ON%26OUTOFPRINT=ON%26OPROCESS=ON%26OADDTL=ON%26OVIEW=ON%26ORHIST=ON%26INSOS=OFF%26INREG=OFF%26OINVO=OFF%26EXTZN=OFF%26OBEST=ON%26ADVERTISE=OFF%26DEFAULTPER=Stephen+Reynolds%26LOGINS=11RETURNPAGE=TD_TITLE_VIEW%26">Change Address, PO #</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=PRE_ORDER_CLOSE%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=PRE_ORDER_CLOSE%26" onclick="return confirm ('Are you finished ordering and are ready to place your order or store in a shopping cart?')" title="Complete Order Process. Save order in a cart for future use, or send to Center Point for shipping and billing."> Complete/Store In Cart</a></div>
<div><a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=MY_PREFERENCES%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=MY_PREFERENCES%26">My Preferences</a></div>
</div>
</td></tr>
<tr><td>
<table style="padding-top:2px;padding-left:6px;padding-bottom:2px;">
<tbody><tr>
<td style="vertical-align:top;"><img src="http://centerpointlargeprint.com/cp_info/icons/AL_01.PNG" style="height:30px;width:60px;" alt=""></td>
<td style="color:#241882;padding-left:4px;padding-bottom:1px;font-size:14px;font-weight:bold;margin:8px 0px 0px 0px;color:#241882;">This Order Is In A Shopping Cart. Select Complete Order To Finish, Or Continue Ordering. . .</td>
</tr></tbody></table>

</td></tr>
<tr>
</tr>
</tbody></table>
<table style="text-align:left;vertical-align:top;">
<tbody><tr><td>
<table style="color:#241882;font-weight:bold;font-size:14px;padding-right:2px;">
<tbody><tr>
<td style="color:black;padding-left:6px;padding-right:8px;">Transaction #</td>
<td style="width:70px;">23607</td>
<td style="color:black;padding-left:16px;padding-right:2px;">Date:</td>
<td>February 27, 2019</td>
</tr></tbody></table>
</td></tr>
<tr><td>
<table style="color:#241882;padding-bottom:8px;font-weight:bold;font-size:14px;padding-right:2px;">
<tbody><tr><td style="vertical-align:top;text-align:left;">
<table style="width:200px;">
<tbody><tr><td style="padding-left:8px;70px;color:#800080;padding-top:8px;padding-bottom:8px;">BILL TO:</td></tr>
<tr><td>Sheil Land Associates, Limited</td></tr>
<tr><td>43 Doughty Street London ENG</td></tr>
<tr><td>Thorndike, ME 04986</td></tr>
</tbody></table>
</td><td style="padding-left:39px;vertical-align:top;">
<table><tbody><tr>
<td style="padding-left:8px;vertical-align:top;width:70px;color:#800080;padding-top:8px;padding-bottom:8px;">SHIP TO:</td><td></td>
</tr>
<tr><td style="color:black;padding-left:6px;padding-right:2px;">Account:</td>
<td>Sheil Land Associates, Limited</td></tr>
<tr><td style="color:black;padding-left:6px;padding-right:2px;">Street:</td>
<td>43 Doughty Street London ENG</td></tr>
<tr>
<td style="color:black;padding-left:6px;padding-right:2px;">Location:</td>
<td>Thorndike,&nbsp;&nbsp;ME&nbsp;&nbsp;04986</td>
</tr>
</tbody></table>
</td></tr></tbody></table>
</td></tr>
<tr><td>
<table style="padding-left:12px;font-size:14px;font-weight:bold;">
<tbody><tr>
<td style="border-bottom:1px solid;padding-right:6px;">Req</td>
<td style="border-bottom:1px solid;padding-right:6px;">Shp</td>
<td style="border-bottom:1px solid;padding-right:6px;">ISBN</td>
<td style="border-bottom:1px solid;padding-right:6px;">Author</td>
<td style="border-bottom:1px solid;padding-right:6px;">Title</td>
<td style="border-bottom:1px solid;padding-right:6px;">Fmt</td>
<td style="border-bottom:1px solid;padding-right:6px;"></td>
<td style="border-bottom:1px solid;padding-right:6px;">Disc.</td>
<td style="border-bottom:1px solid;padding-right:6px;text-align:right;">List</td>
<td style="border-bottom:1px solid;padding-right:6px;text-align:right;">Sale</td>
<td style="border-bottom:1px solid;padding-right:6px;">Status</td>
<td style="border-bottom:1px solid;padding-right:6px;">MARC</td>
<td style="border-bottom:1px solid;padding-right:6px;">View</td>
</tr>
<tr>
<td style="vertical-align:top;text-align:left;">1</td>
<td style="vertical-align:top;text-align:left;">0</td>
<td style="vertical-align:top;padding-right:6px;">9781643581422</td>
<td style="vertical-align:top;padding-right:6px;">Phillip Margolin</td>
<td style="vertical-align:top;padding-right:6px;">
The Perfect Alibi<div><span style="vertical-align:top;font-size:12px;font-weight:bold;color:#800080;">Coming:&nbsp;&nbsp;April&nbsp;2019</span></div>
</td>
<td style="vertical-align:top;padding-right:6px;">HC</td>
<td style="vertical-align:top;padding-right:6px;"></td>
<td style="vertical-align:top;padding-right:6px;">25%</td>
<td style="vertical-align:top;text-align:right;padding-right:6px;">$ 38.95</td>
<td style="vertical-align:top;text-align:right;padding-right:6px;">$ 29.21</td>
<td style="vertical-align:top;text-align:left;padding-right:6px;">Not Yet Published</td>
<td style="vertical-align:top;text-align:right;padding-right:6px;">
<a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=GENERAL_VIEW_ACCESS_MARC%26THISISBN=9781643581422%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26PASSZREC=354%26SEARCHBY=BYTITLE%26SORTBY=BYAUTHORS%26MULTIBUY=ON%26FULLVIEW=ON%26SKIPBOUGHT=ON%26OUTOFPRINT=ON%26OPROCESS=ON%26OADDTL=ON%26OVIEW=ON%26ORHIST=ON%26INSOS=OFF%26INREG=OFF%26OINVO=OFF%26EXTZN=OFF%26OBEST=ON%26ADVERTISE=OFF%26DEFAULTPER=Stephen+Reynolds%26LOGINS=11RETURNPAGE=TD_TITLE_VIEW%26" onclick="window['AwesomeChild'] = window.open(this.href, 'AwesomeChild','top=180,left=940,height=380,width=240,scrollbars=no,resizeable=no,copyhistory=no,toolbar=no,directories=no,status=no,menubar=Yes' ); return false;">
<img src="http://centerpointlargeprint.com/cp_info/icons/marc.gif" style="width:30px;height:20px;" alt="Access MARC records . . ."></a></td>
<td style="vertical-align:top;text-align:right;padding-right:6px;">
<a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=TD_TITLE_VIEW%26SINGLEISBN=9781643581422%26FULLVIEW=ON%26HIDEMENU=YES" target="AwesomeChild" onclick="window['AwesomeChild'] = window.open(this.href, 'AwesomeChild', 'top=330,left=70,height=400,width=1110,scrollbars=yes,resizeable=Yes,copyhistory=no,toolbar=no,directories=no,status=no,menubar=no' ); false;"><img src="http://centerpointlargeprint.com/cp_info/icons/look.ico" style="height:20px;width:20px;" alt=""></a>
</td>
</tr>
<tr>
<td style="text-align:left;border-top:1px solid;">1</td>
<td style="text-align:left;border-top:1px solid;">0</td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"><nobr>$ 38.95</nobr></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"><nobr>$ 29.21</nobr></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
<td style="padding-right:6px;text-align:right;border-top:1px solid;"></td>
</tr>
</tbody></table>
<table style="padding-left:12px;font-size:14px;font-weight:bold;">
<tbody><tr>
<td style="text-align:left;">On Back Order&nbsp;–&nbsp;Book Cost:&nbsp;$ 29.21&nbsp;&nbsp;—&nbsp;&nbsp;Shipping: Charges May Apply&nbsp;&nbsp;—&nbsp;&nbsp;Status:&nbsp;Not Yet Processed</td>
</tr>
</tbody></table>
</td></tr>
</tbody></table>
</div>
<input type="hidden" name="bzp" value="TD_TITLE_VIEW">
<input type="hidden" name="z01" value="stephenreynolds">
<input type="hidden" name="z02" value="sunshine">
<input type="hidden" name="z03" value="0498600000003">
<input type="hidden" name="z04" value="23607">
<input type="hidden" name="HEADER_FILE" value="WEBHEAD">
<input type="hidden" name="DETAIL_FILE" value="WEBDETAIL">
<input type="hidden" name="RETURNPAGE" value="TD_TITLE_VIEW">
</form>

SHOPPING CART NOTHING IS EDITABLE, yo complete by clicking a link on top of page "COMPLETE ORDER":

This Order Is In A Shopping Cart. Select Complete Order To Finish, Or Continue Ordering. . .
Transaction #	23607	Date:	February 27, 2019
BILL TO:
Sheil Land Associates, Limited
43 Doughty Street London ENG
Thorndike, ME 04986
SHIP TO:	
Account:	Sheil Land Associates, Limited
Street:	43 Doughty Street London ENG
Location:	Thorndike,  ME  04986
Req	Shp	ISBN	Author	Title	Fmt		Disc.	List	Sale	Ext.	Status	MARC	View
8	8	9781683243601	Davis Bunn	Miramar Bay	HC		25%	$ 37.95	$ 28.46	$ 227.68	Available	 Access MARC records . . .	
1	1	9781643580746	Davis Bunn	Moondust Lake	HC		25%	38.95	29.21	29.21	Available	 Access MARC records . . .	
1	0	9781628993714	Davis Bunn	The Patmos Deception	HC		25%	34.95	26.21	0.00	Back Ordered	 Access MARC records . . .	
1	0	9781643581422	Phillip Margolin	The Perfect Alibi
Coming:  April 2019
HC		25%	38.95	29.21	0.00	Not Yet Published	 Access MARC records . . .	
3	0	9781643581767	Christopher Reich	Crown Jewel
Coming:  May 2019
HC		25%	38.95	29.21	0.00	Not Yet Published		
14	9							$ 533.30	$ 399.94				
This Order  – Book Cost  $ 256.89  —  Shipping:No Charge  —  Total: $ 399.94
On Back Order – Book Cost: $ 143.05  —  Shipping:No Charge  —  Status: Not Yet Processed

clicking complete order:

- Submits:

bzp=PRE_ORDER_CLOSE%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=23607%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26RETURNPAGE=PRE_ORDER_CLOSE%26


- reidrects to a new page with

Almost Done. . .
To finish the Order Completion Process, just decide if you are ready to submit your order to Center Point for processing, or if you would like to place it in a Shopping Cart for future use.
If you have any comments, questions, or concerns to share with us in regard to your use and experience of the website we are anxious to hear from you. We incorporate suggestions, upgrading the website on a continual basis with the intent of making your experience as user friendly and enjoyable as we can.

	<button >COMPLETE<button > — Place Order With Center Point For Shipping
We have completed this order and are submitting it to Center Point for general processing.

	<button >STORE<button > — Place Order In A Shopping Cart For Future Use
Do not complete order. Leave order in a shopping cart for future use and purchasing.
Also. . .

	<button >ADD PURCHASE ORDER NUMBER<button >

Questions Or Comments, Please Call: (800) 929-9108

Clicking button "COMPLETE":

- gives popup "Are you sure you want to finalize this order and hand it off to Center Point for processing?" button: ok button:cancel

- clicking button:ok GETS the following:

<a href="/foxisapi/foxisapi.dll/webnet.gate.startpoint?bzp=ORDER_POST_FINAL
POSTSTATUS=SENDTOCENTER
bzp=DPRE_ORDER_CLOSE
z01=stephenreynolds
z02=sunshine
z03=0498600000003
z04=23608
HEADER_FILE=WEBHEAD
DETAIL_FILE=WEBDETAIL
ORDER_TRANSNO=
RETURNPAGE=PRE_ORDER_CLOSE

"><img src="http://centerpointlargeprint.com/cp_info/icons/FW_New.png" style="height:36px;width:40px;" onclick="return confirm ('Are you sure you want to finalize this order and hand it off to Center Point for processing?')"></a>

"><img src="http://centerpointlargeprint.com/cp_info/icons/FW_New.png" style="height:36px;width:40px;" onclick="return confirm ('Are you sure you want to finalize this order and hand it off to Center Point for processing?')"></a>

-->

								
			
	</div>

</div>

