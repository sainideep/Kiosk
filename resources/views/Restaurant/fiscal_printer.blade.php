<!DOCTYPE html>
<HTML lang="it">
<head>
<meta charset="utf-8" /> 
   <TITLE>Epson</TITLE>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1" />	       
    <!--  <link rel="stylesheet" type="text/css" href="styles.css"> -->
        
    <link rel="stylesheet" href="{{url('fiscal_test/assets/bootstrap/css/bootstrap.min.css') }}"  media="screen">
    <link rel="stylesheet" href="{{url('fiscal_test/assets/font-awesome/font-awesome.min.css')}}">    
    <script src="{{url('fiscal_test/assets/jquery-1.9.1.min.js')}}"></script>    
    <script src="{{url('fiscal_test/assets/modernizr-2.6.2-respond-1.1.0.min.js')}}"></script>
    <script src="{{url('fiscal_test/assets/bootstrap/js/bootstrap.min.js')}}"></script>
       
    <link rel="stylesheet" type="text/css" href="{{url('fiscal_test/assets/styles.css')}} ">
	<script type="text/javascript" src="{{url('fiscal_test/fiscalprint.js')}}"></script>
	<script type="text/javascript" src="{{url('fiscal_test/fp_eposdevice.js')}}"></script>	
	<script type="text/javascript" src="{{url('fiscal_test/json2.js')}}"></script>	
	<script type="text/javascript" src="{{url('fiscal_test/assets/pos.js')}}"></script>

<style>
    #invoice-POS {
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding: 12mm;
        margin: 0 auto;
        width: 88mm;
        background: #FFF;


        ::selection {
            background: #f31544;
            color: #FFF;
        }
		.payment{
			float:right;
		}

        ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        h1 {
            font-size: 1.5em;
            color: #222;
        }

        h2 {
            font-size: .9em;
        }

        h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        p {
            font-size: .7em;
            color: #666;
            line-height: 1.2em;
        }

        #top,
        #mid,
        #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }

        #top {
            min-height: 100px;
        }

        #mid {
            min-height: 80px;
        }

        #bot {
            min-height: 50px;
        }
	

        #top .logo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(https://michaeltruong.ca/images/logo1.png) no-repeat;
            background-size: 60px 60px;
        }

        .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(https://michaeltruong.ca/images/client.jpg) no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        }

        .info {
            display: block;
            float: left;
            margin-left: 0;
        }

        .title {
            float: right;
        }

        .title p {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px 0 5px 15px;
            border: 1px solid #EEE
        }

        .tabletitle {
            padding: 5px;
            font-size: .5em;
            background: #EEE;
        }

        .service {
            border-bottom: 1px solid #EEE;
        }

        .item {
            width: 24mm;
        }

        .itemtext {
            font-size: .5em;
        }

       


    }
</style>
</head>
<body onLoad="preparePage()">

   <!-- first part -->
<div class="navbar  navbar-fixed-top">
	    <div class="navbar-inner">
	    	<div class=" container">
	    		<a class="brand" href="#">Epson</a>
			<button id="use_scanner" style="color:white;    margin-top: 8px;">use scanner</button>
			<button id="reset_printer" style="    margin-top: 8px;">reset printer</button>
	    		<form class="navbar-search pull-right">
	    			<div class="input-prepend input-append">
						<span class="add-on">ID Cliente</span>
	    				<input type="text" name="customer_id" id="customer_id" placeholder="codice tessera" class="span4 text-center" />
	    			</div>
	    		</form>	    		
	    	</div>	    		    		  
	    </div>
    </div> 

    <!-- end first part -->
    <div id="cassa_outer" class="container" style="display:none;">
		<div id="blocco_alto" class="row">
			<div id="menu" class="span8">
            @foreach($order_item as $item)
            <input type='hidden' /> <script> doAddSellItem('{{$item->menu_item_name}}',{{number_format($item->total_price,2)}}, 0); </script> <div id='myDiv'> </div>
            <!-- <img src="{{url('fiscal_test/images/primo.jpg')}}" alt="Primo" onClick="doAddSellItem('{{$item->menu_item_name}}',{{number_format($item->total_price,2)}}, 0)" class="square" /> -->
            @endforeach
				<!-- <img src="{{url('fiscal_test/images/primo.jpg')}}" alt="Primo" onClick="doAddSellItem('Primo',7, 0)" class="square" />
				<img src="{{url('fiscal_test/images/secondo.jpg')}}" alt="Secondo" onClick="doAddSellItem('Secondo',9, 0)" class="square" />
				<img src="{{url('fiscal_test/images/pizza.jpg')}}" alt="Pizza" onClick="doAddSellItem('Pizza',6, 0)" class="square" />
				<img src="{{url('fiscal_test/images/panino.jpg')}}" alt="Panino" onClick="doAddSellItem('Panino',4, 0)" class="square" />
				<img src="{{url('fiscal_test/images/patatine.jpg')}}" alt="Patatine" onClick="doAddSellItem('Patatine',3, 0)" class="square" />
				<img src="{{url('fiscal_test/images/contorno.jpg')}}" alt="Contorno" onClick="doAddSellItem('Contorno',2, 0)"  class="square"/>
				<img src="{{url('fiscal_test/images/cocacola.jpg')}}" alt="Coca Cola" onClick="doAddSellItem('Coca Cola',2, 0)" class="square" />
				<img src="{{url('fiscal_test/images/caffe.jpg')}}" alt="Caff&egrave;" onClick="doAddSellItem('Caff&egrave;',1, 0)"  class="square" />
				<img src="{{url('fiscal_test/images/acqua.jpg')}}" alt="Acqua" onClick="doAddSellItem('Acqua',1, 0)" class="square" /> -->
			</div>
			<div id="vendite_in_corso" class="offset8 span4">
				<table style="width: 100%" class="table table-striped">
					<tr>
						<th>Vendita</th>
						<th>Prezzo</th>
					</tr>
					<tr>
						<td id="vend1desc">&nbsp;</td>
						<td id="vend1prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend2desc">&nbsp;</td>
						<td id="vend2prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend3desc">&nbsp;</td>
						<td id="vend3prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend4desc">&nbsp;</td>
						<td id="vend4prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend5desc">&nbsp;</td>
						<td id="vend5prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend6desc">&nbsp;</td>
						<td id="vend6prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend7desc">&nbsp;</td>
						<td id="vend7prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend8desc">&nbsp;</td>
						<td id="vend8prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend9desc">&nbsp;</td>
						<td id="vend9prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend10desc">&nbsp;</td>
						<td id="vend10prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend11desc">&nbsp;</td>
						<td id="vend11prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend12desc">&nbsp;</td>
						<td id="vend12prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend13desc">&nbsp;</td>
						<td id="vend13prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend14desc">&nbsp;</td>
						<td id="vend14prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend15desc">&nbsp;</td>
						<td id="vend15prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend16desc">&nbsp;</td>
						<td id="vend16prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend17desc">&nbsp;</td>
						<td id="vend17prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend18desc">&nbsp;</td>
						<td id="vend18prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend19desc">&nbsp;</td>
						<td id="vend19prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend20desc">&nbsp;</td>
						<td id="vend20prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend21desc">&nbsp;</td>
						<td id="vend21prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend22desc">&nbsp;</td>
						<td id="vend22prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend23desc">&nbsp;</td>
						<td id="vend23prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend24desc">&nbsp;</td>
						<td id="vend24prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend25desc">&nbsp;</td>
						<td id="vend25prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend26desc">&nbsp;</td>
						<td id="vend26prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend27desc">&nbsp;</td>
						<td id="vend27prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend28desc">&nbsp;</td>
						<td id="vend28prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend29desc">&nbsp;</td>
						<td id="vend29prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend30desc">&nbsp;</td>
						<td id="vend30prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend31desc">&nbsp;</td>
						<td id="vend31prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend32desc">&nbsp;</td>
						<td id="vend32prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend33desc">&nbsp;</td>
						<td id="vend33prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend34desc">&nbsp;</td>
						<td id="vend34prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend35desc">&nbsp;</td>
						<td id="vend35prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend36desc">&nbsp;</td>
						<td id="vend36prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend37desc">&nbsp;</td>
						<td id="vend37prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend38desc">&nbsp;</td>
						<td id="vend38prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend39desc">&nbsp;</td>
						<td id="vend39prez">&nbsp;</td>
					</tr>
					<tr>
						<td id="vend40desc">&nbsp;</td>
						<td id="vend40prez">&nbsp;</td>
					</tr>
				</table>
			</div>
		  </div>		
	    </div> 
    
    <!-- here is your invoice  -->
    <div id="editor"></div>
    <div id="invoice-POS"> 
	<!-- style="padding-left: 38px;padding-right: 0px;padding-bottom: 190px;position: relative;" -->
        <center id="top">
            <div class="logo"></div>
            <div class="info">
                <h2>{{$staff->name}}</h2>
            </div>
            <!--End Info-->
        </center>
        <!--End InvoiceTop-->

        <div id="mid">
            <div class="info">
                {{-- <h2>Contact Info</h2> --}}
                <p>
                    OrderId : {{$order->id}}</br>
                    OrderAt : {{$order->created_at}}</br>
                    {{-- Phone   : 555-555-5555</br> --}}
                </p>
            </div>
        </div>
        <!--End Invoice Mid-->

    <div id="bot">

        <div id="table">
            <table style="width:100%;">
                <tr class="tabletitle">
                    <td class="item">
                        <h4>Item</h4>
                    </td>
                    <td class="Hours" style="text-align:center;">
                        <h4>Qty</h4>
                    </td>
                    <td class="Rate" style="float:right;">
                        <h4>Price</h4>
                    </td>
                </tr>
                @foreach($order_item as $item)
                <tr class="service">
                    <td class="tableitem">
                        <div class="item_name" id="item_name">{{$item->menu_item_name}}</div>
                    </td>
                    <td class="tableitem">
                        <p class="itemt_quantity" style="text-align:center;">{{$item->count}}</p>
                    </td>
                    <td class="tableitem">
                        <p class="item_price" style="float:right;">€ {{number_format($item->total_price,2)}}</p>
                    </td>
                </tr>
                @endforeach

                <tr class="tabletitle">
                    <td class="Rate">
                        <h4>Total: </h4>
                    </td>
                    <td></td>

                    <td class="payment">
                        <h4>€ {{number_format($order->total_payment,2)}}</h4>
                    </td>
                </tr>

            </table>
        </div>
        <!--End Table-->

        {{-- <div id="legalcopy">
						<p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices. 
						</p>
					</div> --}}

        <div id="legalcopy" style="margin-top:20px;">

            <p style="text-align:center;">{{ $rec_data[0] }} {{ $rec_data[19] }} </p>
            <!-- <p style="text-align:center;"></p> -->
            <p style="text-align:center;">{{ $rec_data[37] }} {{ $rec_data[48] }}</p>
            <p style="text-align:center;">{{ $rec_data[49] }} {{ $rec_data[55] }}</p>
            <p style="text-align:center;">{{ $rec_data[56] }} </p>
            <!-- 92 => "Eserc."96 => "000102435130426A.I.I.C." -->
            <p style="text-align:center;">{{ $rec_data[83] }} {{ substr_replace($rec_data[86], "", -8) }} </p>
            <p style="text-align:center;"> {{ substr($rec_data[86],-8) }} {{ substr_replace($rec_data[91], "", -4) }}
            </p>
            <p style="text-align:center;"> {{ substr($rec_data[91],-4) }} {{ $rec_data[92] }} {{ $rec_data[96] }}
                {{ substr_replace($rec_data[96], "", -3) }} </p>




            <p style="text-align:center;">{{ substr($rec_data[96],-3) }} {{ $rec_data[96] }} {{ $rec_data[97] }}
            {{ substr($rec_data[98],-3) }}.{{ $rec_data[99] }}</p>


            <p style="text-align:center;"> {{ $rec_data[104] }} {{ substr_replace($rec_data[105], "", -4) }}
            {{ substr($rec_data[105],-3) }}.{{ $rec_data[106] }}</p>

			<!-- upper com -->
            <p style="text-align:center;"> {{ $rec_data[107] }} {{ $rec_data[108] }} </p>

            <p style="text-align:center;"> {{ substr($rec_data[108],-4) }} {{ substr_replace($rec_data[116], "", -3) }}
                {{ substr($rec_data[116],-3) }} {{ substr_replace($rec_data[121], "", -4) }} </p>



            <p style="text-align:center;"> {{ substr($rec_data[121],-4) }} {{ substr_replace($rec_data[137], "", -4) }}
                </p>



                <p style="text-align:center;"> {{ substr($rec_data[137],-4) }} {{ substr_replace($rec_data[143], "", -4) }} 
                </p>

                <p style="text-align:center;"> {{ substr($rec_data[143],-4) }} {{ $rec_data[152] }} {{ substr_replace($rec_data[153], "", -3) }} //comp
                </p>

                <p style="text-align:center;"> {{ substr($rec_data[153],-3) }} {{$rec_data[154] }}  {{$rec_data[156] }} {{$rec_data[157] }}
                {{$rec_data[159] }} {{ substr_replace($rec_data[160], "", -4) }} 
                </p>

                <p style="text-align:center;"> {{ substr($rec_data[160],-4) }} {{ $rec_data[161] }}  &nbsp;{{ $rec_data[166] }} {{ substr_replace($rec_data[167], "", -3) }}
                </p> //competee

                <p style="text-align:center;"> {{ substr($rec_data[167],-3) }} {{ substr_replace($rec_data[178], "", -4) }} //comp
                </p>

                <p style="text-align:center;"> {{ substr($rec_data[178],-4) }}  {{ substr_replace($rec_data[182], "", -3) }} 
                </p>

                <p style="text-align:center;"> {{ substr($rec_data[182],-3) }}  {{ substr_replace($rec_data[189], "", -3) }} 
                </p>

                <p style="text-align:center;"> {{ substr($rec_data[189],-3) }}  {{ $rec_data[190] }} 
                </p>
                <p style="text-align:center;"> {{ $rec_data[229]}}  {{ $rec_data[230] }}  {{ $rec_data[239] ?? '' }}
                </p>//com
				
				<p style="text-align:center;"> {{ $rec_data[240] ?? ''}}
                </p>
				
				
				<p style="text-align:center;"> {{ $rec_data[264 ] ?? ''}}
                </p>
			
                <p style="text-align:center;"> {{ $rec_data[265] ?? '' }}  &nbsp;{{ $rec_data[266] ?? '' }} &nbsp;{{ $rec_data[267] ?? $rec_data[268] }} //com
                </p>

                <p style="text-align:center;">  {{ $rec_data[293] ?? '' }}  {{ $rec_data[294] ?? '' }} //com
                </p>

				<p style="text-align:center;">  {{ $rec_data[295] ?? '' }} //com
                </p>

                <p style="text-align:center;">{{ $rec_data[318] ?? '' }}&nbsp;{{ $rec_data[319] ?? ''}} </p>

            <p style="text-align:center;">{{ $rec_data[347] ?? '' }} &nbsp; {{ $rec_data[347] ?? '' }} </p>

            <p style="text-align:center;">{{ $rec_data[348] ?? '' }}&nbsp;{{ $rec_data[349] ?? '' }} </p>
            <p style="text-align:center;">{{ $rec_data[351] ?? '' }}&nbsp;{{ $rec_data[352] ?? '' }} </p>

           

        </div>
        {{-- <button id="btnPrint" class="hidden-print" >Print</button> --}}
     </div>
    <!--End InvoiceBot-->
    </div>

    <!-- end our invoice -->

  <!-- three button section here -->
  <div id="stato_stampante_logo" class="navbar-fixed-bottom">
		<div class="navbar-inner">
			<div class="container">
				<div id="blocco_basso" class="row">
					<div id="pagamento" class="span8">
                        <!-- recipt -->
						<a class="btn btn-large btn-primary" alt="Scontrino" title="Scontrino" href="javascript:doSendData('scontrino','PAGAMENTO',{{number_format($order->total_payment,2)}} );"> Scontrino</a>
						<!-- invoice -->
                         <!-- <a class="btn btn-large btn-info" alt="Fattura" title="Fattura" href="javascript:doSendData('fattura','PAGAMENTO',{{number_format($order->total_payment,2)}} );"> Fattura</a>		 -->
						<!-- paper button -->
                        <!-- <a class="btn btn-large btn-info" alt="Carta" title="Carta" href="javascript:doSendDataCarta('scontrino','PAGAMENTO',0);"> Carta</a> -->
					
					</div>
					<div id="totale_aggiornato" class="span4">
                        <!-- latest change -->
						<h1 id="totale_aggiornato_importo" class="badge badge-success">&nbsp;€{{number_format($order->total_payment,2)}}</h1>
                        <!-- end latest change -->
					</div>			
				</div>
				<div class="row">
					<div id="stato_stampante" class="span10"></div>
					<div class="span2"><img class="logo_epson" src="images/epson_logo_exceed.jpg" alt="EPSON EXCEED YOUR VISION" title="EPSON EXCEED YOUR VISION" /></div>									
				</div>
			</div>
		</div>
	</div>
    <!-- end three button -->

    <div id="blocco_configure" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Configurazione</h3>			    
		</div>
		<div class="modal-body">
			<ul class="nav nav-tabs">
				    <li><a href="#configureMain" data-toggle="tab">Main</a></li>
				    <li><a href="#configureSecondaria" data-toggle="tab">Secondaria</a></li>			    
			</ul>
			<div class="tab-content">
				<div id="configureMain" class="tab-pane active">
					<form method="post" name="printerSelectionFormMain" id="printerSelectionFormMain" class="form-horizontal">					
						<div class="control-group">
							 <label class="control-label" for="localPrinterCheckBoxMain">Local Printer</label>
							 <div class="controls">
							 	<input name="localPrinterCheckBoxMain" id="localPrinterCheckBoxMain" type="checkbox" checked="true" onclick="MainDevidTimeoutVisibility()" />
							 </div>
						</div>
						<div id="devidTimeoutMain">
							<div class="control-group">
								<label class="control-label" for="devidMain">Device Id</label>
								<div class="controls">
									<input name="devidMain" id="devidMain" type="text" style="width: 55px" value=“” />
								</div>
							</div>
							<div class="control-group" >
								<label class="control-label" for="timeoutMain">Timeout</label>
								<div class="controls">
									<input name="timeoutMain" id="timeoutMain" type="text" style="width: 55px" value="10000" />
								</div>
							</div>
						</div>
					</form>
		
					<form method="post" name="crossDomainForm" id="crossDomainForm" class="form-horizontal">
					
						<div class="control-group" >
							<label class="control-label" for="crossDomainCheckBox">Cross Domain</label>
							<div class="controls">
								<input name="crossDomainCheckBox" id="crossDomainCheckBox" type="checkbox" onclick="crossDomain()" />
							</div>
						</div>
					
						<div id="ipAddresses" class="control-group" >
							<label class="control-label" for="ipAddress1">IP Address</label>
							<div class="controls">
								<input name="ipAddress1" id="ipAddress1" type="text" style="width: 30px" value="192.168.18.106" /> . 
								<!-- <input name="ipAddress2" id="ipAddress2" type="text" style="width: 30px"value="192.168.18.100" /> . 
								<input name="ipAddress3" id="ipAddress3" type="text"style="width: 30px" value="192.168.18.100" /> . 
								<input name="ipAddress4" id="ipAddress4" type="text" style="width: 30px" value="192.168.18.100" /> -->
							</div>
						</div>
											
						<div id="displayURL" class="control-group" > </div>
					</form>
				</div>
		
				<div id="configureSecondaria" class="tab-pane">
					<form method="post" name="printerSelectionFormSecondaria" id="printerSelectionFormSecondaria" class="form-horizontal">		
	
						<div id="devidTimeoutSecondaria">
						
							<div class="control-group" >
								<label class="control-label" for="devidSecondaria">Device Id (devid)</label>
								<div class="controls">
									<input name="devidSecondaria" id="devidSecondaria" type="text" style="width: 55px" value="" />
								</div>
							</div>
						
							<div class="control-group" >
								<label class="control-label" for="timeoutSecondaria">Timeout</label>
								<div class="controls">
									<input name="timeoutSecondaria" id="timeoutSecondaria" type="text" style="width: 55px" value="10000" />
								</div>
							</div>
														
						</div>
					</form>
			
			
					<div id="displayURL"></div>
		
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<input name="setButton" id="setButton" type="button" value="Conferma" onclick="setDestStamp()" class="btn btn-primary" />
		</div>
	</div>


    <!-- Modal section here -->

    <div id="printerResponse" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">&times;</button>
			<h3>Esito stampa</h3>
		</div>
		<div class="modal-body">
			<dl class="dl-horizontal">
				<dt>Data</dt>
				<dd id="printerResponseDate"></dd>
				<dt>Esito</dt>
				<dd id="printerResponseResult"></dd>
				<dt>Codice</dt>
				<dd id="printerResponseCode"></dd>
				<dt>Stato</dt>
				<dd id="printerResponseStatus"></dd>
			</dl>
		</div>
	</div>

    <!-- end Modal here  -->


</body>
<!--End Invoice-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>
    var rec_data0 = @json($rec_data[0]);
    var payment_transactions = @json($payment_transactions->Receipt);
	var sites = {!! json_encode($payment_transactions->Receipt) !!};

     console.log(sites);
	
</script>
<script type="text/javascript">
    $(document).ready(function() {

		
        // doAddSellItem(item, cost,0);
        // alert('hh');
        // var doc = new jsPDF();
        // doc.fromHTML($('#invoice-POS').html(), 15, 15, {
        //         'width': 170,
        //         'elementHandlers': specialElementHandlers
        //     });
        //     doc.save('Reciept.pdf');
        // var specialElementHandlers = {
        //     '#editor': function (element, renderer) {
        //         return true;
        //     }
        // window.print();
        // };
        //   setInterval(function () {
        //           location.href = "{{url('App',$staff->id)}}";
        //         }, 3000);
        // });
        //     const $btnPrint = document.querySelector("#btnPrint");
        // $btnPrint.addEventListener("click", () => {
        //     window.print();
    });
</script>
<script type="text/javascript" src="{{url('fiscal_test/assets/pos.js')}}"></script>


