<style>
    #invoice-POS{
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding:2mm;
  margin: 0 auto;
  width: 88mm;
  background: #FFF;
  
  
::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
}
 
#top, #mid,#bot{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}

#top{min-height: 100px;}
#mid{min-height: 80px;} 
#bot{ min-height: 50px;}

#top .logo{
    float: left;
	height: 60px;
	width: 60px;
	background: url(https://michaeltruong.ca/images/logo1.png) no-repeat;
	background-size: 60px 60px;
}
.clientlogo{
    float: left;
	height: 60px;
	width: 60px;
	background: url(https://michaeltruong.ca/images/client.jpg) no-repeat;
	background-size: 60px 60px;
  border-radius: 50px;
}
.info{
  display: block;
  float:left;
  margin-left: 0;
}
.title{
  float: right;
}
.title p{text-align: right;} 
table{
  width: 100%;
  border-collapse: collapse;
}
td{
  padding: 5px 0 5px 15px;
  border: 1px solid #EEE
}
.tabletitle{
  padding: 5px;
  font-size: .5em;
  background: #EEE;
}
.service{border-bottom: 1px solid #EEE;}
.item{width: 24mm;}
.itemtext{font-size: .5em;}

#legalcopy{
  margin-top: 5mm;
}

  
  
}
    </style>
    <div id="editor"></div>
  <div id="invoice-POS" style="padding-left: 38px;padding-right: 0px;padding-bottom: 190px;position: relative;">
    
    <center id="top">
      <div class="logo"></div>
      <div class="info"> 
        <h2>{{$staff->name}}</h2>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        {{-- <h2>Contact Info</h2> --}}
        <p> 
            OrderId : {{$order->id}}</br>
            OrderAt : {{$order->created_at}}</br>
            {{-- Phone   : 555-555-5555</br> --}}
        </p>
      </div>
    </div><!--End Invoice Mid-->
    
    <div id="bot">

					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="item"><h4>Item</h4></td>
								<td class="Hours"><h4>Qty</h4></td>
								<td class="Rate"><h4>Price</h4></td>
							</tr>
                             @foreach($order_item as $item)
							<tr class="service">
								<td class="tableitem"><p class="itemtext">{{$item->menu_item_name}}</p></td>
								<td class="tableitem"><p class="itemtext">{{$item->count}}</p></td>
								<td class="tableitem"><p class="itemtext">€  {{number_format($item->total_price,2)}}</p></td>
							</tr>
                              @endforeach

							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h4>Total: </h4></td>
								<td class="payment"><h4>€ {{number_format($order->total_payment,2)}}</h4></td>
							</tr>

						</table>
					</div><!--End Table-->

					<div id="legalcopy">
						<p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices. 
						</p>
					</div>
          {{-- <button id="btnPrint" class="hidden-print" >Print</button> --}}
				</div><!--End InvoiceBot-->
  </div><!--End Invoice-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
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
      window.print();
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
  {{-- <script>
    const $listaDeImpresoras = document.querySelector("#listaDeImpresoras"),
    $btnImprimir = document.querySelector("#btnPrint");
    // alert($btnImprimir);


const obtenerListaDeImpresoras = () => {
    console.log("Cargando lista...");
    Impresora.getImpresoras()
        .then(listaDeImpresoras => {
            console.log("Lista cargada");
            listaDeImpresoras.forEach(nombreImpresora => {
                const option = document.createElement('option');
                option.value = option.text = nombreImpresora;
                $listaDeImpresoras.appendChild(option);
            })
        });
}

$btnImprimir.addEventListener("click", () => {
  // alert('hh');
    let impresora = new Impresora();
    impresora.setFontSize(1, 1);
    impresora.write("Fuente 1,1\n");
    impresora.setFontSize(1, 2);
    impresora.write("Fuente 1,2\n");
    impresora.setFontSize(2, 2);
    impresora.write("Fuente 2,2\n");
    impresora.setFontSize(2, 1);
    impresora.write("Fuente 2,1\n");
    impresora.setFontSize(1, 1);
    impresora.setEmphasize(1);
    impresora.write("Emphasize 1\n");
    impresora.setEmphasize(0);
    impresora.write("Emphasize 0\n");
    impresora.setAlign("center");
    impresora.write("Centrado\n");
    impresora.setAlign("left");
    impresora.write("Izquierda\n");
    impresora.setAlign("right");
    impresora.write("Derecha\n");
    impresora.setFont("A");
    impresora.write("Fuente A\n");
    impresora.setFont("B");
    impresora.write("Fuente B\n");
    impresora.feed(2);
    impresora.write("Separado por 2\n");
    impresora.setAlign("center");
    impresora.write("QR:\n");
    impresora.qr("https://parzibyte.me/blog");
    impresora.write("Barcode:\n");
    impresora.barcode("123456", 80, "barcode128");
    impresora.cut();
    impresora.cutPartial(); // Pongo este y también cut porque en ocasiones no funciona con cut, solo con cutPartial
    impresora.cash();
    impresora.imprimirEnImpresora($listaDeImpresoras.value);
});

// En el init, obtenemos la lista
obtenerListaDeImpresoras();

    </script>
    <script>
      /**
 * Una clase para interactuar con el plugin
 * 
 * @author parzibyte
 * @see https://parzibyte.me/blog
 */
const C = {
    AccionWrite: "write",
    AccionCut: "cut",
    AccionCash: "cash",
    AccionCutPartial: "cutpartial",
    AccionAlign: "align",
    AccionFontSize: "fontsize",
    AccionFont: "font",
    AccionEmphasize: "emphasize",
    AccionFeed: "feed",
    AccionQr: "qr",
    AlineacionCentro: "center",
    AlineacionDerecha: "right",
    AlineacionIzquierda: "left",
    FuenteA: "A",
    FuenteB: "B",
    AccionBarcode128: "barcode128",
    AccionBarcode39: "barcode39",
    AccionBarcode93: "barcode93",
    AccionBarcodeEAN: "barcodeEAN",
    AccionBarcodeTwoOfFiveSinInterleaved: "barcodeTwoOfFive",
    AccionBarcodeTwoOfFiveInterleaved: "barcodeTwoOfFiveInterleaved",
    AccionBarcodeCodabar: "barcodeCodabar",
    AccionBarcodeUPCA: "barcodeUPCA",
    AccionBarcodeUPCE: "barcodeUPCE",
    Medida80: 80,
    Medida100: 100,
    Medida156: 156,
    Medida200: 200,
    Medida300: 300,
    Medida350: 350,
};

const URL_PLUGIN = "http://localhost:8000";

class OperacionTicket {
    constructor(accion, datos) {
        this.accion = accion + "";
        this.datos = datos + "";
    }
}
class Impresora {
    constructor(ruta) {
        if (!ruta) ruta = URL_PLUGIN;
        this.ruta = ruta;
        this.operaciones = [];
    }

    static setImpresora(nombreImpresora, ruta) {
        if (ruta) URL_PLUGIN = ruta;
        return fetch(URL_PLUGIN + "/impresora", {
                method: "PUT",
                body: JSON.stringify(nombreImpresora),
            })
            .then(r => r.json())
            .then(respuestaDecodificada => respuestaDecodificada === nombreImpresora);
    }
    static setImpresoraSilencioso(nombreImpresora, ruta) {
        if (ruta) URL_PLUGIN = ruta;
        return fetch(URL_PLUGIN + "/impresora_silencioso", {
                method: "PUT",
                body: JSON.stringify(nombreImpresora),
            })
            .then(r => r.json())
            .then(respuestaDecodificada => respuestaDecodificada === nombreImpresora);
        }
    

    static getImpresora(ruta) {
        if (ruta) URL_PLUGIN = ruta;
        return fetch(URL_PLUGIN + "/impresora")
            .then(r => r.json());
    }

    static getImpresoras(ruta) {
        if (ruta) URL_PLUGIN = ruta;
        return fetch(URL_PLUGIN + "/impresoras")
            .then(r => r.json());
    }

    static getImpresorasRemotas(ip) {
        return fetch(URL_PLUGIN + "/impresoras_remotas?ip=" + ip)
            .then(r => r.json());
    }

    cut() {
        this.operaciones.push(new OperacionTicket(C.AccionCut, ""));
    }

    cash() {
        this.operaciones.push(new OperacionTicket(C.AccionCash, ""));
    }

    cutPartial() {
        this.operaciones.push(new OperacionTicket(C.AccionCutPartial, ""));
    }

    setFontSize(a, b) {
        this.operaciones.push(new OperacionTicket(C.AccionFontSize, `${a},${b}`));
    }

    setFont(font) {
        if (font !== C.FuenteA && font !== C.FuenteB) throw Error("Fuente inválida");
        this.operaciones.push(new OperacionTicket(C.AccionFont, font));
    }
    setEmphasize(val) {
        if (isNaN(parseInt(val)) || parseInt(val) < 0) throw Error("Valor inválido");
        this.operaciones.push(new OperacionTicket(C.AccionEmphasize, val));
    }
    setAlign(align) {
        if (align !== C.AlineacionCentro && align !== C.AlineacionDerecha && align !== C.AlineacionIzquierda) {
            throw Error(`Alineación ${align} inválida`);
        }
        this.operaciones.push(new OperacionTicket(C.AccionAlign, align));
    }

    write(text) {
        this.operaciones.push(new OperacionTicket(C.AccionWrite, text));
    }

    feed(n) {
        if (!parseInt(n) || parseInt(n) < 0) {
            throw Error("Valor para feed inválido");
        }
        this.operaciones.push(new OperacionTicket(C.AccionFeed, n));
    }

    end() {
        return fetch(this.ruta + "/imprimir", {
                method: "POST",
                body: JSON.stringify(this.operaciones),
            })
            .then(r => r.json());
    }

    imprimirEnImpresora(nombreImpresora) {
        const payload = {
            operaciones: this.operaciones,
            impresora: nombreImpresora,
        };
        return fetch(this.ruta + "/imprimir_en", {
                method: "POST",
                body: JSON.stringify(payload),
            })
            .then(r => r.json());
    }

    qr(contenido) {
        this.operaciones.push(new OperacionTicket(C.AccionQr, contenido));
    }

    validarMedida(medida) {
        medida = parseInt(medida);
        if (medida !== C.Medida80 &&
            medida !== C.Medida100 &&
            medida !== C.Medida156 &&
            medida !== C.Medida200 &&
            medida !== C.Medida300 &&
            medida !== C.Medida350) {
            throw Error("Valor para medida del barcode inválido");
        }
    }

    validarTipo(tipo) {
        if (
            [C.AccionBarcode128,
                C.AccionBarcode39,
                C.AccionBarcode93,
                C.AccionBarcodeEAN,
                C.AccionBarcodeTwoOfFiveInterleaved,
                C.AccionBarcodeTwoOfFiveSinInterleaved,
                C.AccionBarcodeCodabar,
                C.AccionBarcodeUPCA,
                C.AccionBarcodeUPCE,
            ]
            .indexOf(tipo) === -1
        ) throw Error("Tipo de código de barras no soportado");
    }

    barcode(contenido, medida, tipo) {
        this.validarMedida(medida);
        this.validarTipo(tipo);
        let payload = contenido.concat(",").concat(medida.toString());
        this.operaciones.push(new OperacionTicket(tipo, payload));
    }
    imprimirEnImpresoraConNombreEIp(nombreImpresora, ip) {
        const payload = {
            operaciones: this.operaciones,
            impresora: nombreImpresora,
            ip: ip,
        };
        return fetch(this.ruta + "/imprimir_y_reenviar", {
            method: "POST",
            body: JSON.stringify(payload),
        })
            .then(r => r.json());
    }

}
    </script> --}}