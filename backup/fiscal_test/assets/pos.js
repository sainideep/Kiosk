var websocket;
var ws_connected = 0;
var list = "";
var item = "";
var tipo = ""; // scontrino o fattura
var metodo_pag = "";
var cost = 0;
var mostra_cost = "";
var max_item_desc_len = 32;
var max_metodo_pag_desc_len = 32;
var numvendita = 0;
var totale_aggiornato_importo = 0;
var mostra_tot = "";
var importo = 0;
var stato_stampante_prefisso = "<a id=\"printerResponseOpen\" href=\"#printerResponse\" role=\"button\" class=\"\" data-toggle=\"modal\"><i class=\"icon-print\"></i></a> ";
var stato_stampante = "OK";
var itemlistpos = "";
var indent = "     ";
var send_secondaria = false;
var carta_di_credito_ok = 0;

var queryStringMain = "";
var queryStringSecondaria = "";
var xmlHTTPRequestURLMain = "";
var xmlHTTPRequestURLMain = window.location.protocol + "//" + window.location.hostname + "/cgi-bin/fpmate.cgi";
// var xmlHTTPRequestURLSecondaria = "";

var pos_feed = '<feed type = "1" />\n';
var pos_cut = '<cut type = "feed"/>\n';
var pos_text_prefix_normal = '<text dw="0" dh="0" description= "';
var pos_text_prefix_big = '<text dw="1" dh="1" description= "';
var pos_text_suffix = '" />\n';
var pos_barcode_prefix = '<barcode description= "';
var pos_barcode_prefix = pos_text_suffix;
var numero_fattura = 1;
var STR_PAD_LEFT = 1;
var STR_PAD_RIGHT = 2;
var STR_PAD_BOTH = 3;
var print_final_image = 0;

var using_scanner = false;

var TNT = 999;
var TCL = 12;
var TCONT = 0x0d;    // replaced from Francesco to 0D (2014_03_09)
var TENTER = TCONT;


var eposdevice = new epsonlib.ePOSDevice();


var tab_scan_code_lower_case = [
TNT, TNT, '1', '2', '3', '4', '5', '6', '7', '8', // 00
'9', '0', '\'', TNT, TNT, TNT, 'q', 'w', 'e', 'r', // 10
't', 'y', 'u', 'i', 'o', 'p', TNT, '*', TENTER, TNT, // 20
'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', '@', // 30
TNT, TNT, TNT, '>', 'z', 'x', 'c', 'v', 'b', 'n', // 40
'm', ';', '.', '-', TNT, '*', TNT, ' ', TNT, TNT, // 50
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, // 60
TNT, '7', '8', '9', '-', '4', '5', '6', '+', '1', // 70
'2', '3', '0', '.', TNT, TNT, TNT, TNT, TNT, TNT, // 80
TNT, TNT, TNT, TNT, TNT, TNT, TENTER, TNT, TNT, TNT, // 90
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //100
TNT, TCL, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //110
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //120
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //130
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //140
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //150
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //160
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //170
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //180
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //190
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //200
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //210
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //220
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //230
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //240
TNT, TNT, TNT, TNT, TNT, TNT, //250
];

var tab_scan_code_upper_case = [
TNT, TNT, '!', '"', '#', '$', '%', '&', '/', '(', // 00
')', '=', '?', TNT, TNT, TNT, 'Q', 'W', 'E', 'R', // 10
'T', 'Y', 'U', 'I', 'O', 'P', TNT, '+', TENTER, TNT, // 20
'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', '@', // 30
TNT, TNT, TNT, '<', 'Z', 'X', 'C', 'V', 'B', 'N', // 40
'M', ',', ':', '_', TNT, '*', TNT, ' ', TNT, TNT, // 50
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, // 60
TNT, '7', '8', '9', '-', '4', '5', '6', '+', '1', // 70
'2', '3', '0', '.', TNT, TNT, TNT, TNT, TNT, TNT, // 80
TNT, TNT, TNT, TNT, TNT, TNT, TENTER, TNT, TNT, TNT, // 90
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //100
TNT, TCL, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //110
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //120
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //130
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //140
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //150
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //160
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //170
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //180
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //190
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //200
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //210
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //220
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //230
TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, TNT, //240
TNT, TNT, TNT, TNT, TNT, TNT, //250
];


var stringa = "";
function filter_key(car) {
    //if (car == "\r") {
    if (car == 13) {
        console.log(stringa);
        console.log("CR");
        if ( (stringa == "=pri") || (stringa == "=PRI") || (stringa == ")pri") || (stringa == ")PRI")){
            doAddSellItem('Primo',7, 1);
            stringa = "";
        }
        if ( (stringa == "=sec") || (stringa == "=SEC") || (stringa == ")sec") || (stringa == ")SEC")){
            doAddSellItem('Secondo',9, 1);
            stringa = "";
        }
        if ( (stringa == "=piz") || (stringa == "=PIZ") || (stringa == ")piz") || (stringa == ")PIZ")){
            doAddSellItem('Pizza',6, 1);
            stringa = "";
        }
        if ( (stringa == "=pan") || (stringa == "=PAN") || (stringa == ")pan") || (stringa == ")PAN")){
            doAddSellItem('Panino',4, 1);
            stringa = "";
        }
        if ( (stringa == "=pat") || (stringa == "=PAT") || (stringa == ")pat") || (stringa == ")PAT")){
            doAddSellItem('Patatine',3, 1);
            stringa = "";
        }
        if ( (stringa == "=con") || (stringa == "=CON") || (stringa == ")con") || (stringa == ")CON")){
            doAddSellItem('Contorno',2, 1);
            stringa = "";
        }
        if ( (stringa == "=coc") || (stringa == "=COC") || (stringa == ")coc") || (stringa == ")COC")){
            doAddSellItem('Coca Cola',2, 1);
            stringa = "";
        }
        if ( (stringa == "=caf") || (stringa == "=CAF") || (stringa == ")caf") || (stringa == ")CAF")){
        //  doAddSellItem('Caff&egrave;',1, 1);
            doAddSellItem('Caffè',1, 1);
            stringa = "";
        }
        if ( (stringa == "=acq") || (stringa == "=ACQ") || (stringa == ")acq") || (stringa == ")ACQ")){
            doAddSellItem('Acqua',1, 1);
            stringa = "";
        }
        var _return = stringa;
        stringa = "";
        return _return;
    } else {
        stringa = stringa + car;
        console.log(stringa);
        return "";
    }
}

function pad(str, len, pad, dir) {
 
	if (typeof(len) == "undefined") { var len = 0; }
	if (typeof(pad) == "undefined") { var pad = ' '; }
	if (typeof(dir) == "undefined") { var dir = STR_PAD_RIGHT; }
 
	if (len + 1 >= str.length) {
		switch (dir){
			case STR_PAD_LEFT:
				str = Array(len + 1 - str.length).join(pad) + str;
			break;
			case STR_PAD_BOTH:
				var right = Math.ceil((padlen = len - str.length) / 2);
				var left = padlen - right;
				str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
			break;
			default:
				str = str + Array(len + 1 - str.length).join(pad);
			break;
		} // switch
	}
	return str;
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function periodic_func()
{
	console.log('periodic function');
	setTimeout("periodic_func();", 3000);
	if (eposdevice.isConnected()) {
		console.log('eposdevice CONNECTED');
	} else {
		console.log('eposdevice DISCONNECTED');
	}
		
	if (using_scanner == false) {
		console.log('using_scanner false');
		eposdevice.disconnect();
	} else {
		console.log('using_scanner true');
		eposdevice.disconnect();		
	}
		
}

function try_eposdevice()
{
	console.log('try_eposdevice');
    var connCallback = function(code) {
        console.log('connCallback');
        if (code == "close") {
        	//setTimeout("try_eposdevice();", 2000);
        	document.getElementById('use_scanner').style.background='red';
        	using_scanner = false;
    		return;
        }

        var createDeviceCallback = function(driverObj, code) {
            console.log('createDeviceCallback');

        	if (code != "OK") {
        		setTimeout("try_eposdevice();", 2000);
        		document.getElementById('use_scanner').style.background='red';
        		eposdevice.disconnect();
        		using_scanner = false;
        		return;
        	}
        	using_scanner = true;
        	document.getElementById('use_scanner').style.background='lightgreen';

            // add the method to the driver object to handle device data
            driverObj.ondata = function (data) {
            	console.log("type = " + data.type +
            			    "  data1 = " + data.data1 +
            			    "  data2 = " + data.data2 +
            			    "  data3 = " + data.data3 +
            			    "  data4 = " + data.data4);

                var car;
                if (isNaN(data.data4)) {
                  console.log("not a number");
                } else {
                  if (data.data2 == 1) {
                    car = tab_scan_code_upper_case[data.data4];
                    console.log("shift pressed; car = " + car);
                  } else {
                    car = tab_scan_code_lower_case[data.data4];
                    console.log("shift not pressed; car = " + car);
                  }
                  var string_from_scanner = filter_key(car);
                  if (string_from_scanner != "")
                    document.getElementById('customer_id').value = string_from_scanner;
                }
            }
        }

        eposdevice.createDevice("local_scanner", "type_scanner", false, createDeviceCallback);
    }

    eposdevice.connect(window.location.host, 8008, connCallback);

    //sleep(10000);
    //console.log('slept');
    //setTimeout("deviceInfo.isExsitClientDeviceInfo('local_scanner');", 3000);
    
    //setTimeout("periodic_func();", 3000);
    
    //if (using_scanner == false)
    	//eposdevice.disconnect();
}

function preparePage()
{
    document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + stato_stampante;
    document.getElementById("customer_id").innerHTML = "";
    if (xmlHTTPRequestURLMain == "") {
        showDestStampWindow();
    }

	if (eposdevice.isConnected()) {
		console.log('eposdevice CONNECTED');
	} else {
		console.log('eposdevice DISCONNECTED');
	}

	try_eposdevice();

    document.getElementById('reset_printer').onclick = function () {
        var data_to_send = '<printerCommand>';
        data_to_send = data_to_send + '<directIO command="1088" data="01" />';  // operator
        data_to_send = data_to_send + '</printerCommand>';

        var epos = new epson.fiscalPrint();
        epos.onreceive = function (result, tag_names_array, add_info) {
            // alert("result: " + res.result + "\ncode: " + res.code + "\ndescription: " + res.description);
            stato_stampante = result.success?'Stampa riuscita':'Stampa non riuscita';
            console.log('result.success: ' + result.success);
            console.log('result.code: ' + result.code);
            console.log('result.status: ' + result.status);
            console.log('stato_stampante: ' + stato_stampante);
        };

        // alert (xml);
        epos.send(xmlHTTPRequestURLMain, data_to_send);
    }

    document.getElementById('use_scanner').style.background='red';
    document.getElementById('use_scanner').value='use scanner';
/*
    document.getElementById('reset_printer').onclick = function () {
    	eposdevice.disconnect();
    }
    
    var connCallback = function() {
        console.log('connCallback');
    }
    
    document.getElementById('use_scanner').onclick = function () {
    	eposdevice.connect(window.location.host, 8080, connCallback);
    }
*/
}

function setFattParam()
{
	var epos = new epson.fiscalPrint();
    epos.onreceive = function (result, tag_names_array, add_info) {	}
	var s = '<printerCommand>\n <directIO  command="4025" data="000199011Esente Art ...00" />\n </printerCommand>\n';
	alert (s);
    epos.send(xmlHTTPRequestURLMain, s);
}

function doAddSellItem(item, cost, via_scanner)
{
	if (item == 'Caffè' && ! print_final_image) {
//	if (item == 'Caff&egrave;' && ! print_final_image) {
		print_final_image = 1;
	}
        if (item.length < max_item_desc_len) // forzare la lunghezza di max_item_desc_len mettendo i spazi se necessario
        {
        item = item + "                                              "; // lunghezza massima della stampante è 46 caratteri
        item = item.substring(0,max_item_desc_len); // Troncare la stringa
        }
        itemlistpos = itemlistpos + pos_text_prefix_big + indent + item + pos_text_suffix + pos_feed;
        list = list + '<printRecItem operator="10" description="' + item + '" quantity="1" unitPrice="' + cost + '" department="1" justification="1" />';
	if (print_final_image) {
		list = list +
'<printGraphicCoupon  operator="10" data="base64Data" graphicFormat="R" >G2ExHThMyhYAADBwMAEBMc4A4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAACIqoiAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAqqqqqogAAAAAAAAAAAADAAAAAAAAAAAAAAARERERAAAAAAAAAAAAAAMAAAAAAAAAAAACqqqqqqqqogAAAAAAAAAAAwAAAAAAAAAAAAAARERERAAAAAAAAAAAAAADAAAAAAAAAAAACqqqqqqqqqiAAAAAAAAAAAMAAAAAAAAAAAABERERVREREAAAAAAAAAAAAwAAAAAAAAAAAqqqqqqqqqqqogAAAAAAAAADAAAAAAAAAAAAAERERERERAAAAAAAAAAAAAMAAAAAAAAAAAqqqqqqqqqqqqiAAAAAAAAAAwAAAAAAAAAAAREVVVVVVREREAAAAAAAAAADAAAAAAAAAAKqqqqqqqqqqqqqoAAAAAAAAAMAAAAAAAAAAABEREREVERERAAAAAAAAAAAAwAAAAAAAAAAqqqqqqqqqqqqqqgAAAAAAAADAAAAAAAAAAERFVVVVVVVURERAAAAAAAAAAMAAAAAAAAAKqqqqqqqqqqqqqqqAAAAAAAAAwAAAAAAAAAABERURVVVREREQAAAAAAAAAADAAAAAAAAACqqqqqqqqqqqqqqqoAAAAAAAAMAAAAAAAAAARFVVVVVVVUVUREQAAAAAAAAAwAAAAAAAAKqqqqrq7q6urqqqqqgAAAAAAADAAAAAAAAAABERVRVVVVVVVREAAAAAAAAAAMAAAAAAAAAqqqqrv6qrqruqqqqoAAAAAAAAwAAAAAAAAARUVVVVVVVVVUVUREAAAAAAAADAAAAAAAAAqqqq/q//7+qq7uqqqoAAAAAAAMAAAAAAAAABEVVVV3d1UVVVVRAAAAAAAAAAwAAAAAAAAqqqqrv///+qq7q6qqoAAAAAAADAAAAAAAAARFVVV939/9VVVVVEQAAAAAAAAMAAAAAAAAqqqu7////////6uqqqgAAAAAAAwAAAAAAAABEVVXdXd3d3d1VVUQAAAAAAAADAAAAAAAACqqu/////////q6uqqgAAAAAAAMAAAAAAAABERVXd3d3d3d9VVVVEAAAAAAAAwAAAAAAACqqu//////////7u6qqAAAAAAADAAAAAAAAAEVVXd3d3d3d3VVVUEAAAAAAAAMAAAAAAAAKqq7/////////7u7qqgAAAAAAAwAAAAAAAAFRVXd3d3d3d3VVVVUQAAAAAAADAAAAAAAAKqu7//////////+7u6ogAAAAAAMAAAAAAAAEVVVV3d3d3d3VVVVVQAAAAAAAAwAAAAAAAAqur////////+rq7uqqAAAAAAADAAAAAAAAAVVVd3d3d3d3VVVVVVAAAAAAAAMAAAAAACIqv7v/////////v/+/qiIiIgAAAwAAAAAAAAFVVVXVXd1dVVVVVVVAAAAAAAADAAAAAAAACq7v//////7u7+6r7ugAAAAAAAMAAAAAAAAFVVVVVVV3VVVVVVVVUAAAAAAAAwAAAAAiIiO7v7u/+///+7q7+r/qIiIiIAADAAAAAAAAAVVVVVVVVVVFVVVUVUAAAAAAAAMAAAAAAAACru7+6u7uqu7urqquoIAAAAAAAwAAAAAAAAFVVVVVVVVVVVVVVVUAAAAAAAADAAAAAiIiIru/+vurur+7q7///6IiIiIiAAMAAAAAAAAAVVVUVVVVVVVVVVVVAAAAAAAAAwAAAAAAAAiu7u6qqq6q6q6v/u6IiIiIAAADAAAAAAAAABVVUVFVVVVVFVV1VAAAAAAAAAMAAAAiIiIiO/u6uru767u7v//6KqoiIqIAAwAAAAAAAAAFVUVVVVVFVVVVVVAAAAAAAAADAAAAAAAACIrqrqqu6qqqqu/+6IioAAAIgAMAAAAAAAAAAVVVVVUVVVVVVXVAAAAAAAAAAwAAAiIiIiKiqru767ururu7/6KqoiIiKgADAAAAAAAAAABFVVVFVVVVVVVVAAAAAAAAAAMAAAAAAAAIiCvu7ururu7qrvoIiIAAAACAAwAAAAAAAAAABVVVVVVVVVVVcAAAAAAAAAADAAAiIiIiIioj+/u7u7u6+ruiqqoiIiIigAMAAAAAAAAAAABVRVVVVVRVVQAAAAAAAAAAAwAAAAAAAAiIiKrqruqqqq6qCIiIAAAACoADAAAAAAAAAAAABVVVUVVVVVAAAAAAAAAAAAMAACIiIiIiqqoiu7qru7u6oqqqqiIiIiqAAwAAAAAAAAAAAAAFVVVVVVAAAAAAAAAAAAADAAAAAAAACIiIiAqqqqqqgIqqiIgAAAiogAMAAAAAAAAAAAAAAAFVVRAAAAAAAAAAAAAAAwACIiIiIiKqqqqqIiqiAqqqqqqqIiIqqiADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAiIiKqoiIiKqqqqqIiAAIiqgAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAIiIiIiIqqqqqqqqqqqqqqqqqoiKqqiIAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAACIiIqqqqqqqqqqqoiIAIqogAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAIiIiIiIiKqqqqqqqqqqqqqqqoiKqoiIiAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAIiIiqqqqqqqqqqqiKgIqoAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAiIiIiIiIqqqqqqqqqqqqqqqqiKqIiIiIDAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAiIiIqqqqqqqqqqqIgIqAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADACIiIiIiIiqqqqqqqqqqqqqqqqqqIiIiIgMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAACIiIiIiqqqqqqqqqqoiKqIAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAMAIiIiIiIiIqqqqqqqqqqqqqqqqqoiIiIiAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAiIiIiIiKqqqqqqqqqIiqqIiACIiAMAAAAAAAAAAAAAAAAAAAAAAAABEAAAAAAAAwAiIiIiIiIqqqqqqqqqqqqqqqqqIiIiIiIDAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAIiIiIiIiIiIiqqqqqqqqIiqiIiIiIiIAwAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAAADACIiIiIiIiqqqqqqqqqqqqqqqqqqoiIiIgMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAiIiIiIiIqIiIiqqqqqiIiqqqqIiIiIgDAAAAAAAAAAAAAAAAAAAAAAABERAAAAAAAAMAIiIiIiIiqqqqqqqqqqqqqqqqqqqqIiIiAwAAAAAAAAAAAAAAAAAAAAAABEAAAAAAAAADAACIiIiIiIiqqIiIiIiIiIiqqqqoiIiIgAMAAAAAAAAAAAEAAAAAAAAAAVURAAAAAAAAAwAiIiIiIiKqqqqqqqqqqqqqqqqqqqoiIiADAAAAAAAAAAAAAAAAAAAAAABEAAAAAAAAAAMAAAiIiIiIiKqqqIiIiIiKqqqqqqiIiIiAAwAAAAAAAAAAAREAAAAAAAAVURAAAAAAAAADAAIiIiIiIqqqqqqqqqqqqqqqqqqqqiIiIAMAAAAAAAAAAAAEQAAAAAAEREAAAAAAAAAAAwAACIiIiIiIqqqqqqqqqqqqqqqIiIiIiAADAAAAAAAAAAABERVRAAARVVEQAAAAAAAAAAMAAiIiIiIiqqqqqrqqqquqqqqqqqqiIiIgAwAAAAAAAAAAAAREVURFVUREQAAAAAAAAAADAACAiIiIiIiqqqqqqqqqqqqqqIiIiIgIgAMAAAAAAAAAAAEREVVVVVVVERAAAAAAAAAAAwACIiIiIiKqqqqqqqqqqqqqqqqqoiIiIgADAAAAAAAAAAAAAEREREVEREAAAAAAAAAAAAMAAICIiIiIiIqqqqqqqqqqqqqIiIiIiIAAAwAAAAAAAAAAABERFVVVVVEQAAAAAAAAAAADAAIiIiIiIqqqqqqqqqqqqqqqqqoiIiIiAAMAAAAAAAAAAAAABEREREREAAAAAAAAAAAAAwAACIiIiIiIiqqqqqqqqqqqqIiIiIiICAADAAAAAAAAAAAAAREREREREQAAAAAAAAAAAAMAACoiIiIiqqqqqqqqqqqqqqqqIiIiIiIAAwAAAAAAAAAAAAAAAERERAAAAAAAAAAAAAADAAAKgIiIiIiIqqqqqqqqqqiIiIiIiIiAAAMAAAAAAAAAAAAAAREREREAAAAAAAAAAAAAAwAAIqIiIiIqqqqqqqqqqqqqqqIiIiIqoAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAACoiIiIiIiIqqqqqqqqiIiIiIiICIAAAwAAABAAAAAAAAAAAAAAAAAAAAAAAAAQAAADAAACKqIiIiKqqqqqqqqqqqqiIiIiIqoAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAIqoiIiIiIiIqqqqqIiIiIiIiIqoAAADAAAAARAAAAAAAAAAAAAAAAAAAAAAAQAAAAMAAAAqqiIiIiqqqqqqqqqqqiIiIiIqogAAAwAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAKqIiIiIiIiIiIiIiIiIiIiAqoAAAAMAAAAAEQAAAAAAAAAAAAAAAAAAAAEQAAAAAwAAACIqqiIiIiqqqqqqqqIiIiIiKqogAAADAAAAAABAAAAAAAAAAAAAAAAAAAAEAAAAAAMAAAAACqqIiIiIiIiIiIiIiIiIiKqIAAAAAwAAAAAAEQAAAAAAAAAAAAAAAAABEAAAAAADAAAAACKqqiIiIiKqqiIiIiIiIiqqoAAAAAMAAAAAAABAAAAAAAAAAAAAAAAABAAAAAAAAwAAAAAAqqqIiIiIiIiIiIiIiIiqqAAAAAADAAAAAAABERAAAAAAAAAAAAAAAREAAAAAAAMAAAAAAiqqqqIiIiIiIiIiIiKqqqIAAAAAAwAAAAAAAAREAAAAAAAAAAAAAEQAAAAAAAADAAAAAAAIqqqqiIiIiIiIiIiqqqiAAAAAAAMAAAAAAAABEVUAAAAAAAAAARURAAAAAAAAAwAAAAAAIiqqqqqqIiIiIiqqqqqiIAAAAAADAAAAAAAAAABEREAAAAAAAEREAAAAAAAAAAMAAAAAAAAIqqqqqqqqqqqqqqqogAAAAAAAAwAAAAAAAAABERVVVRERFVUREAAAAAAAAAADAAAAAAAAIiqqqqqqqqqqqqqqoiAAAAAAAAMAAAAAAAAAAAAEREREREREQAAAAAAAAAAAAwAAAAAAAAAAiqqqqqqqqqqqiIAAAAAAAAADAAAAAAAAAAAAAREREREREAAAAAAAAAAAAAMAAAAAAAAAAiKqqqqqqqqqqiIgAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAACIiqqqqoiIAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAACIiIiqiIiIgAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADHShMAgAwMg==</printGraphicCoupon>'
	}
        numvendita = ++numvendita;
        // document.getElementById("vend1").style.visibility="visible";
        document.getElementById("vend" + numvendita + "desc").innerHTML = item;
        mostra_cost = "&euro;" + cost.toFixed(2); // dopo il decimale mette sempre due digit
        document.getElementById("vend" + numvendita + "prez").innerHTML = mostra_cost.replace(".",",");
        // Aggiorna totale_aggiornato in tempo reale
        totale_aggiornato_importo = totale_aggiornato_importo + cost;
        totale_aggiornato_importo = totale_aggiornato_importo;
        mostra_tot = "&euro; " + totale_aggiornato_importo.toFixed(2); // dopo il decimale mette sempre due digit
        document.getElementById("totale_aggiornato_importo").innerHTML =  mostra_tot.replace(".",",");
        item = "";
        cost = "0";
        
        //scroll list        
    	if(numvendita>6 && (numvendita%5==0)){
    		//$(window).scrollTop($(window).scrollTop() + 185)
    		var top = $(window).scrollTop() + 185
    		$('html, body').animate({scrollTop: top}, 2000)
    	}        	        
}

function showDestStampWindow()
{
	alert ('Configurare le stampanti e cliccare "Conferma"');
	//document.getElementById('stato_stampante').style.visibility = 'hidden';
	$('#blocco_configure').modal('show')
}

function MainDevidTimeoutVisibility()
{
	if (document.printerSelectionFormMain.localPrinterCheckBoxMain.checked == true) {
		document.getElementById('devidTimeoutMain').style.visibility = 'hidden';	}
	else {
		document.getElementById('devidTimeoutMain').style.visibility = 'visible';
	}
}

function crossDomain()
{
	if (document.crossDomainForm.crossDomainCheckBox.checked == true) {
		document.getElementById('ipAddresses').style.visibility = 'visible';
	}
	else {
		document.getElementById('ipAddresses').style.visibility = 'hidden';
	}
}


function setDestStamp()
{
	if (document.printerSelectionFormMain.localPrinterCheckBoxMain.checked == false) {
		if (document.printerSelectionFormMain.devidMain.value.length == 0) {
			alert("Per favore compilare il campo Device ID - Main");
			return;
		}
		else if (document.printerSelectionFormMain.timeoutMain.value < 3000) {
			alert("Timeout Main sotto la soglia minima; deve essere almeno 3000");
			return;
		}
	}
	if (document.printerSelectionFormSecondaria.devidSecondaria.value.length == 0) {
		alert("Per favore compilare il campo Device ID - Secondaria");
		return;
	}
	if (document.printerSelectionFormSecondaria.timeoutSecondaria.value < 3000) {
		alert("Timeout Secondaria sotto la soglia minima; deve essere almeno 3000");
		return;
	}
	
	queryStringMain = "?" + "devid=" + document.printerSelectionFormMain.devidMain.value + "&" + "timeout=" + document.printerSelectionFormMain.timeoutMain.value;
	queryStringSecondaria = "?" + "devid=" + document.printerSelectionFormSecondaria.devidSecondaria.value + "&" + "timeout=" + document.printerSelectionFormSecondaria.timeoutSecondaria.value;
		
	if (document.crossDomainForm.crossDomainCheckBox.checked == false) {
		xmlHTTPRequestDestination = window.location.hostname;
	}
	else {
		xmlHTTPRequestDestination = document.crossDomainForm.ipAddress1.value + "." +
									document.crossDomainForm.ipAddress2.value + "." +
									document.crossDomainForm.ipAddress3.value + "." +
									document.crossDomainForm.ipAddress4.value;
									
	}
	xmlHTTPRequestURLMain = window.location.protocol + "//" + xmlHTTPRequestDestination +
	"/cgi-bin/fpmate.cgi" + queryStringMain;
	xmlHTTPRequestURLSecondaria = window.location.protocol + "//" + xmlHTTPRequestDestination +
	"/cgi-bin/fpmate.cgi" + queryStringSecondaria;
	// alert (xmlHTTPRequestURLMain + xmlHTTPRequestURLSecondaria);
	$('#blocco_configure').modal('hide')
	//document.getElementById('stato_stampante').style.visibility = 'visible';
	document.getElementById('ipAddresses').style.visibility = 'hidden';
	document.getElementById('devidTimeoutMain').style.visibility = 'hidden';
	setFattParam();
	alert ("La configurazione è stata salvata. Provare a stampare.");
}

function doSendData(tipo,metodo_pag,importo)
{
        if (list !='')
        {
        	if (xmlHTTPRequestURLMain != "") {
        		
        	// customer id
        	var tmp = "";
        	var customer_str = "";
        	tmp = document.getElementById("customer_id").value;
        	customer_str = tmp.replace("http://likella.com/star/","");
        	// customer id
        	
        	stato_stampante = "STAMPA IN CORSO";
        	document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + stato_stampante;
        	if (metodo_pag.length < max_metodo_pag_desc_len) // forzare la lunghezza di max_item_desc_len mettendo i spazi se necessario
        	{
		        metodo_pag = metodo_pag + "                                              "; // lunghezza massima della stampante è 46 caratteri
		        metodo_pag = metodo_pag.substring(0,max_metodo_pag_desc_len); // Troncare la stringa
		    }
		
			var data_to_send = "";
			if (tipo == "scontrino")
			{
				data_to_send = data_to_send + '<printerFiscalReceipt>';
			}
			else
			{
				data_to_send = data_to_send + '<printerFiscalDocument>';
			}
                        
			if (tipo == "scontrino")
			{
				data_to_send = data_to_send + '<beginFiscalReceipt operator="10" />';
			}
			else
			{
				data_to_send = data_to_send + '<beginFiscalDocument operator="10" documentNumber="' + numero_fattura + '" />';
				numero_fattura++;
			}
			
			// customer id
			var customer_str_direct = "";
			customer_str_direct = pad(customer_str, 64, ' ', STR_PAD_RIGHT);
			// customer id

			if (carta_di_credito_ok) {
				data_to_send = data_to_send + list +
				      // per stampare eventuale risultato carta di credito
				      '<directIO command="1078" data="1080000"/>';
			} else {
				data_to_send = data_to_send + list;
			}
			data_to_send = data_to_send +
			      // customer id
			      '<directIO command="1078" data="1070000' + customer_str_direct + '"/>' +
			      // customer id
                              '<printRecTotal operator="10" description="' +
                              metodo_pag.toUpperCase() +
                              '" payment="' + importo +
                              '" paymentType="2" index="0" justification = "1" />';
                        data_to_send = data_to_send + '<printRecMessage  operator="10" messageType="3" index="1" font="4" message="Arrivederci e Grazie" />';
                        if (tipo == "scontrino") {
                           data_to_send = data_to_send + '<endFiscalReceipt operator="10" />' + '</printerFiscalReceipt>';
                        } else {
                           data_to_send = data_to_send + '<endFiscalDocument operator="10" />' + '</printerFiscalDocument>';
                        }

                        // customer id
                        // customer_str.rpad(" ", 64);
                        // data_to_send = data_to_send + '<directIO command="1078" data="0070000' ;
                        // document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + customer_str;
                        // customer id
                        var epos = new epson.fiscalPrint();
                        epos.onreceive = function (result, tag_names_array, add_info) {
                            // alert("result: " + res.result + "\ncode: " + res.code + "\ndescription: " + res.description);
                            stato_stampante = result.success?'Stampa riuscita':'Stampa non riuscita';
                            document.getElementById('printerResponseDate').innerHTML = new Date();
                            document.getElementById('printerResponseResult').innerHTML = result.success;
                            document.getElementById('printerResponseCode').innerHTML = result.code;
                            document.getElementById('printerResponseStatus').innerHTML = result.status;				
                            document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + stato_stampante;

                            if (send_secondaria == true) {
                               //alert ("dosec");
                               doSendSecondaria();
                            }

			    if (carta_di_credito_ok)
			    {
			     	// per stampare risultato carta di credito
				data_to_send = '<printerNonFiscal>' +
					'<beginNonFiscal operator="10" />' +
						'<directIO command="1078" data="1080000"/>' +
					'<endNonFiscal operator="10" />' +
				'</printerNonFiscal>';

                                epos.onreceive = function (result, tag_names_array, add_info) {
                                  // alert("result: " + res.result + "\ncode: " + res.code + "\ndescription: " + res.description);
                                  stato_stampante = result.success?'Stampa riuscita':'Stampa non riuscita';
                                  document.getElementById('printerResponseDate').innerHTML = new Date();
                                  document.getElementById('printerResponseResult').innerHTML = result.success;
                                  document.getElementById('printerResponseCode').innerHTML = result.code;
                                  document.getElementById('printerResponseStatus').innerHTML = result.status;				
                                  document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + stato_stampante;
			        }
                                epos.send(xmlHTTPRequestURLMain, data_to_send);
			    }

                            puliscecassa();

//                            document.getElementById('customer_id').focus();
                        }
                        // alert (data_to_send);
                        epos.send(xmlHTTPRequestURLMain, data_to_send);
                    } // destmain
        	else {
        		showDestStampWindow();
                }
            }
            else
            {
                alert("Nessuna vendita");
            }
	print_final_image = 0;
}

function doSendDataCarta(tipo,metodo_pag,importo)
{
        if (list !='')
        {
        	if (xmlHTTPRequestURLMain != "") {
        		
        		// customer id
        		var tmp = "";
        		var customer_str = "";
        		tmp = document.getElementById("customer_id").value;
        		customer_str = tmp.replace("http://likella.com/star/","");
        		// customer id

        		stato_stampante = "TRANSAZIONE POS IN CORSO";
        		document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + stato_stampante;
        		if (metodo_pag.length < max_metodo_pag_desc_len) // forzare la lunghezza di max_item_desc_len mettendo i spazi se necessario
        		{
			        metodo_pag = metodo_pag + "                                              "; // lunghezza massima della stampante è 46 caratteri
			        metodo_pag = metodo_pag.substring(0,max_metodo_pag_desc_len); // Troncare la stringa
			}

			var x_carta_to_send = '<printerCommand>' +
				'<authorizeSales operator="10" amount="' + totale_aggiornato_importo + '" />' + '</printerCommand>';

                	var epos = new epson.fiscalPrint();
                	epos.onreceive = function (result, tag_names_array, add_info) {
                	    stato_stampante = result.success?'Transazione pos riuscita':'Transazione pos non riuscita';
                	    document.getElementById('printerResponseDate').innerHTML = new Date();
                	    document.getElementById('printerResponseResult').innerHTML = result.success;
                	    document.getElementById('printerResponseCode').innerHTML = result.code;
                	    document.getElementById('printerResponseStatus').innerHTML = result.status;				
                	   document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + stato_stampante;

			    if (result.success) {
				//alert("Transazione pos OK");
			    } else {
				//alert("Transazione pos FALLITA");
			    }

			    carta_di_credito_ok = 1;
                	}
                	//alert (x_carta_to_send);
                	epos.send(xmlHTTPRequestURLMain, x_carta_to_send);
                	//alert ("sent");
		}
	}
	else
	{
	    alert("Nessuna vendita");
	}
}



function puliscecassa()
{
	list = "";
	itemlistpos = "";
	for (numvendita = 1; numvendita < 41; numvendita++)
	{		
		document.getElementById("vend" + numvendita + "desc").innerHTML = "&nbsp;";
   		document.getElementById("vend" + numvendita + "prez").innerHTML = "&nbsp;";
	}
	document.getElementById("totale_aggiornato_importo").innerHTML = "&nbsp;";
	document.getElementById("customer_id").value = "";
	numvendita = 0;
	totale_aggiornato_importo = 0;
//	document.getElementById('green_tick').style.visibility = 'hidden';
	send_secondaria = false;
	$(function(){$(window).scrollTop(0)})
	carta_di_credito_ok = 0;
}

function doCommandi()
{
	if (document.getElementById('green_tick').style.visibility == 'visible')
	{
		document.getElementById('green_tick').style.visibility = 'hidden';
		send_secondaria = false;
	}
	else
	{
		document.getElementById('green_tick').style.visibility = 'visible';
		send_secondaria = true;
	}
}

function doSendSecondaria()
{
	
	var d = new Date();
	var pos_data_to_send = header_xml;
	
	pos_data_to_send = pos_data_to_send + '<epos-print>\n' +
	// pos_text_prefix_big + "Per cortesia preparare l'ordine come segue:" + pos_text_suffix +
	pos_text_prefix_big + "        Order" + pos_text_suffix +
	pos_feed +
	pos_feed +
	pos_text_prefix_normal + "Reparto: bar" + pos_text_suffix +
	pos_feed +
	pos_text_prefix_normal + "Tavolo: 1" + pos_text_suffix +
	pos_feed +
	pos_text_prefix_normal + "Data: " + d + pos_text_suffix +
	pos_feed +
	pos_text_prefix_normal + "-----------------------------------------" + pos_text_suffix +
	pos_feed +
	pos_feed +
	itemlistpos +
	pos_feed +
	pos_text_prefix_normal + "-----------------------------------------" + pos_text_suffix +
	pos_feed +
	pos_text_prefix_big + "       Grazie.\n" + pos_text_suffix +
	pos_feed +
	pos_text_prefix_normal + "-----------------------------------------" + pos_text_suffix +
	pos_feed +
	pos_feed +
	pos_feed +
	pos_feed +
	pos_feed +
	pos_feed +
	pos_cut + 
	"</epos-print>";
	
	stato_stampante = "STAMPA SECONDARIA";
	document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + stato_stampante;
	
	var epos2 = new epson.eFiscalPrint();
    epos2.onreceive = function (result, tag_names_array, add_info)
    {
		stato_stampante = result.success?'Stampa riuscita':'Stampa non riuscita';
		alert(stato_stampante)
		document.getElementById('printerResponseDate').innerHTML = new Date();
		document.getElementById('printerResponseResult').innerHTML = result.success;
		document.getElementById('printerResponseCode').innerHTML = result.code;
		document.getElementById('printerResponseStatus').innerHTML = result.status;		
		document.getElementById('stato_stampante').innerHTML = stato_stampante_prefisso + stato_stampante;
	}

	epos2.send(window.location.protocol + "//" + window.location.hostname + "/cgi-bin/fpmate.cgi", pos_data_to_send);

}

$(function(){
	
	$(window).scrollTop(0)

	$('#menu .square').click(function(){
		var product = $(this)
		var productX 		= product.offset().left;
		var productY 		= product.offset().top;
		var basketX 		= $("#vendite_in_corso").offset().left;
		var basketY 		= $("#vendite_in_corso").offset().top;
		var gotoX           = 660;
		var gotoY           = 200;
		var newImageWidth 	= 25;
		var newImageHeight	= 25;
		product
			.clone()
			.appendTo(product.parent())
			.css({'position' : 'absolute', 'left': product.position().left, 'top': product.position().top})
			.animate({opacity: 0.4}, 100 )
			.animate({opacity: 0.1, left: gotoX, width: newImageWidth, height: newImageHeight}, 
					1000,
					function(){ $(this).remove()  })
		
	})

})
