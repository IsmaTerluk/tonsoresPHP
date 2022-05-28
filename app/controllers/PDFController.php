<?php 

    class PDFController extends Controller {

        function __construct(){
            $userSession = new UserSession();
        }

        public function generarPDF(){
            //Capturamos el id
            $id_turno = $_GET['id_turno'];
            $this->loadModel('PDFModel');
            //Capturamos algunos datos
            $turno = $this->model->getTurnoSolicitado($id_turno);
           
            if($turno['id_turno']==1)
                $horarios = $this->model->getAllHorarios('turnos_mañana');
            else
                $horarios = $this->model->getAllHorarios('turnos_tarde');

            $servicios = $this->model->getAllServicios();
            
            //Crea el objeto que extiende de fpdf -- para generar una plantilla

            $pdf = new PDF();
            //Para mostrar la numeracion del pie de pagina
            $pdf->AliasNbPages();
            //Añade una page
            $pdf->AddPage();
            //Especifica la tipografia
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(80);
            //Genera una celda, una fila para escribir
            $pdf->Cell(80,10,utf8_decode('ENCUENTRA TU ESTILO'));
            //Salto de linea

            $pdf->SetFont('Arial','B',15);
            $pdf->Ln(35);
            $pdf->Cell(190, 10, 'Comprobante de solicitud de turno', 1,0,'C',0);
            $pdf->SetFont('Arial','B',10);
            $pdf->Ln(15);
            $pdf->Cell(190,10, '    Barbero: ' .$turno['name'] . $turno['lastname'],0,0,'L',0);
            $pdf->Ln(10);
            $pdf->Cell(190,10, '    Fecha: ' .$this->obtenerFechaEnLetra($turno['fecha']), 0,0,'l',0);
            $pdf->Ln(10);
            $pdf->Cell(190,10, '    Hora: ' .$horarios[$turno['id_horario']-1]['horario']."hs.", 0,0,'l',0);
            $pdf->Ln(10);
            $pdf->Cell(190,10, '    Servicios: '. $this->convertirServiciosaString($turno['servicios'],$servicios), 0,0,'l',0);
            $pdf->Ln(10);
            $pdf->Cell(190,10, '    Puntos acumulados: ' . $turno['puntos'], 0,0,'l',0);
            $pdf->Ln(10);
            $pdf->Cell(190,10, '    Precio: ' .'$'.$turno['precio'], 0,0,'l',0);
            $pdf->Ln(10);
            $pdf->Cell(190,10, '    Descuento obtenido: ' .$turno['descuento_aplicado'] ."%", 0,0,'l',0);
            $pdf->Ln(10);
            if($turno['saldoafavor']!=0){
                $pdf->Cell(190,10, '    Utilizo el saldo a favor del que disponia: $' .$turno['saldoafavor'], 0,0,'l',0);
                $pdf->Ln(10);
            }
        
            $pdf->Cell(190,10, '    Total a pagar: ' .'$'. $turno['total_pagar'], 0,0,'l',0);
            

            $pdf->Output();
        }

        public function obtenerFechaEnLetra($fecha){
            $dia= $this->conocerDiaSemanaFecha($fecha);
            $num = date("j", strtotime($fecha));
            $anno = date("Y", strtotime($fecha));
            $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
            $mes = $mes[(date('m', strtotime($fecha))*1)-1];
            return $dia.' '.$num.' de '.$mes; //del '.$anno;
        }

        public function conocerDiaSemanaFecha($fecha) {
            $dias = array('Domingo', 'Lunes', 'Martes', 'Miérccoles', 'Jueves', 'Viernes', 'Sabado');
            $dia = $dias[date('w', strtotime($fecha))];
            return $dia;
        }

        function convertirServiciosaString($lista_servicios, $all_servicios){
            //Descomponemos los servicios
            $lista_servicios = explode(',', $lista_servicios);
            
            $servicios = '';
            foreach($lista_servicios as $servicio){
                $servicios = $servicios . $all_servicios[$servicio-1]['servicio'].",";
            }
            //Saca el ultimo caracter
            $servicios = trim($servicios, ',');
            return $servicios;
        }

        

        

    }

?>