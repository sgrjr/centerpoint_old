<b>Date:</b> {{$order->date}} 
<b>Transaction #:</b> {{$order->transno}} 
<b>Source:</b>   {{$order->osource}}
<b>PO #:</b>   {{$order->po_number}}
<a href={{"/dashboard/orders/" . $order->transno }}>View</a>