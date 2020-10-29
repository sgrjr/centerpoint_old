<div id="invoice">

    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info" onclick="printIt()"><i class="fa fa-print"></i> Print</button>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header class="printOnly">
                <div class="row">
                    <div class="col">
                        <a target="_blank" href={{$company_website}} >
                            <img class="logo" src={{$company_logo}} data-holder-rendered="true" />
                            </a>
                    </div>
                    <div class="col company-details">
                        <div class="name">
                            <a target="_blank" href={{$company_website}}>
                            {{$company_name}}
                            </a>
                        </div>
                        <div>{{$company_address}}</div>
                        <div>{{$company_telephone}}</div>
                        <div><a href={{"mailto:" . $company_email }}>{{$company_email}}</a></div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="to">{{$customer_name}}</h2>
                        <div class="address">{{$customer_address}}</div>
                        <div class="email"><a href={{"mailto:" . $customer_email }}>{{$customer_email}}</a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">{{$invoice_title}} 

                        @if (strpos($invoice_id, '.') !== false) 
                        
                        @else
                        ({{$invoice_id}}) 
                        @endif

                        </h1>

                        @foreach($invoice_dates AS $date)
                            <div class="date">{{$date}}</div>
                        @endforeach
          
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            @foreach($body_headings AS $h)
                                <th>{{$h}}</th>
                            @endforeach
                                <th>COST</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($items AS $item)

                        <tr>
                            @foreach($body_headings AS $h)
                                <td>{{$item->$h}}</td>
                            @endforeach

                            <td>{{$item->cost}}</td>
                        </tr>

                       @endforeach

                    </tbody>
                    <tfoot>

                        @foreach($totaling AS $total)
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">{{$total->title}}</td>
                            <td>$ {{$total->amount}}</td>
                        </tr>
                        @endforeach
                    </tfoot>
                </table>
                <div class="thanks">{{$thanks}}</div>
                <div class="notices">
                    {!! $invoice_memo !!}
                </div>
            </main>
            <footer>
                {{$footer_memo}}
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>

<script>

function printIt() {

    var printContents = document.getElementById("invoice").innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
      return true;
}

</script>