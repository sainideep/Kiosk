<!DOCTYPE html>
<HTML lang="it">
<head>
   <meta charset="utf-8" /> 
   <TITLE>Epson Demo Retail</TITLE>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1" />	       
    <!--  <link rel="stylesheet" type="text/css" href="styles.css"> -->
        
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"  media="screen">
    <link rel="stylesheet" href="assets/font-awesome/font-awesome.min.css">    
    <script src="assets/jquery-1.9.1.min.js"></script>    
    <script src="assets/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
       
    <link rel="stylesheet" type="text/css" href="assets/styles.css">
	<script type="text/javascript" src="fiscalprint.js"></script>
	<script type="text/javascript" src="fp_eposdevice.js"></script>	
	<script type="text/javascript" src="json2.js"></script>	
	<script type="text/javascript" src="assets/pos.js"></script>	
</head>
<body onLoad="preparePage()">
	
	<div class="navbar  navbar-fixed-top">
	    <div class="navbar-inner">
	    	<div class=" container">
	    		<a class="brand" href="#">Epson Demo Retail</a>
			<button id="use_scanner">use scanner</button>
			<button id="reset_printer">reset printer</button>
	    		<form class="navbar-search pull-right">
	    			<div class="input-prepend input-append">
						<span class="add-on">ID Cliente</span>
	    				<input type="text" name="customer_id" id="customer_id" placeholder="codice tessera" class="span4 text-center" />
	    			</div>
	    		</form>	    		
	    	</div>	    		    		  
	    </div>
    </div>
	
	<div id="cassa_outer" class="container">
		<div id="blocco_alto" class="row">
			<div id="menu" class="span8">
				<img src="images/primo.jpg" alt="Primo" onClick="doAddSellItem('Primo',7, 0)" class="square" />
				<img src="images/secondo.jpg" alt="Secondo" onClick="doAddSellItem('Secondo',9, 0)" class="square" />
				<img src="images/pizza.jpg" alt="Pizza" onClick="doAddSellItem('Pizza',6, 0)" class="square" />
				<img src="images/panino.jpg" alt="Panino" onClick="doAddSellItem('Panino',4, 0)" class="square" />
				<img src="images/patatine.jpg" alt="Patatine" onClick="doAddSellItem('Patatine',3, 0)" class="square" />
				<img src="images/contorno.jpg" alt="Contorno" onClick="doAddSellItem('Contorno',2, 0)"  class="square"/>
				<img src="images/cocacola.jpg" alt="Coca Cola" onClick="doAddSellItem('Coca Cola',2, 0)" class="square" />
				<img src="images/caffe.jpg" alt="Caff&egrave;" onClick="doAddSellItem('Caff&egrave;',1, 0)"  class="square" />
				<img src="images/acqua.jpg" alt="Acqua" onClick="doAddSellItem('Acqua',1, 0)" class="square" />
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

	<div id="stato_stampante_logo" class="navbar-fixed-bottom">
		<div class="navbar-inner">
			<div class="container">
				<div id="blocco_basso" class="row">
					<div id="pagamento" class="span8">
						<a class="btn btn-large btn-primary" alt="Scontrino" title="Scontrino" href="javascript:doSendData('scontrino','PAGAMENTO',0);"> Scontrino</a>
						<a class="btn btn-large btn-info" alt="Fattura" title="Fattura" href="javascript:doSendData('fattura','PAGAMENTO',0);"> Fattura</a>						
						<a class="btn btn-large btn-info" alt="Carta" title="Carta" href="javascript:doSendDataCarta('scontrino','PAGAMENTO',0);"> Carta</a>
						<!-- <img src="images/cucina.jpg" alt="Commandi" title="Commandi" onClick="doCommandi()"> -->
						<!-- <img id="green_tick" src="images/green_tick.png" style="visibility:hidden;margin-left:-133px;vertical-align:17px;height:95px;width:95px;border:0px" alt="Commandi" title="Commandi" onClick="doCommandi()"> -->
					</div>
					<div id="totale_aggiornato" class="span4">
						<h1 id="totale_aggiornato_importo" class="badge badge-success">&nbsp;</h1>
					</div>			
				</div>
				<div class="row">
					<div id="stato_stampante" class="span10"></div>
					<div class="span2"><img class="logo_epson" src="images/epson_logo_exceed.jpg" alt="EPSON EXCEED YOUR VISION" title="EPSON EXCEED YOUR VISION" /></div>									
				</div>
			</div>
		</div>
	</div>

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
									<input name="devidMain" id="devidMain" type="text" style="width: 55px" value="" />
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
								<input name="ipAddress1" id="ipAddress1" type="text" style="width: 30px" value="" /> . 
								<input name="ipAddress2" id="ipAddress2" type="text" style="width: 30px"value="" /> . 
								<input name="ipAddress3" id="ipAddress3" type="text"style="width: 30px" value="" /> . 
								<input name="ipAddress4" id="ipAddress4" type="text" style="width: 30px" value="" />
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

</body>
</HTML>
