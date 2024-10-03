<?php

    namespace App\Controllers;

    use App\Models\ProveedorModel;
    use App\Vendor\Fpdf\FPDF;

    class ProveedorController extends Controller {
        protected $modelo;

        public function __construct() {
            $this->modelo = new ProveedorModel();
        }

        public function index() {
            return $this->view('proveedor');
        }

        public function obtener_proveedores() {
            // Colocar el código PHP para realizar la preparación de los datos de la tabla dinámica
            // Variables enviadas por jqGrid
            $page = $_POST['page'];
            $limit = $_POST['rows'];
            $sidx = $_POST['sidx'];
            $sord = $_POST['sord'];
            
            if (!$sidx) $sidx = 1;

            // Consulta para obtener y contar la cantidad de registro de la tabla pacientes
            $registros = $this->modelo->all();
            $count = count($registros);


            // Formula para determinar la cantidad de páginas
            $total_pages = $count > 0 ? ceil($count/$limit) : 0;

            // Condición para verificar si no hay más de 1 página
            if ($page > $total_pages) $page=$total_pages;
            $start = $limit * $page - $limit;
            if($start<0) $start = 0;

            // Creación de un objeto utilizando el método stdClass()
            $responce = new \stdClass();

            // Agregamos las siguientes propiedades al objeto $responce
            // valores necesarios en el jqGrid
            $responce->page = $page;
            $responce->total = $total_pages;
            $responce->records = $count;

            // Preparamos los datos que se mostraran en la tabla dinámica
            $i = 0;
            foreach($registros as $proveedor) {
                $responce->rows[$i]['id'] = $proveedor->nrc;
                $responce->rows[$i]['cell'] = [
                    $proveedor->nrc,
                    $proveedor->nombre_empresa,
                    $proveedor->razon_social,
                    $proveedor->persona_contacto,
                    $proveedor->telefono_contacto,
                    $proveedor->correo_electronico
                ];
                $i++;
            };

            // Se envía la respuesta en formato JSON
            echo json_encode($responce);
        }

        // Método para la persistencia de datos en la tabla proveedores
        public function guardar() {
            $accion = $_POST['accion'];
            $data = [
                'nrc' => $_POST['nrc'],
                'nombre_empresa' => $_POST['nombre_empresa'],
                'razon_social' => $_POST['razon_social'],
                'persona_contacto' => $_POST['persona_contacto'],
                'telefono_contacto' => $_POST['telefono_contacto'],
                'direccion' => $_POST['direccion'],
                'correo_electronico' => $_POST['correo_electronico']
            ];

            if($accion == '0')
                $this->modelo->insert($data);
            else {
                unset($data['nrc']);
                $where = [
                    'nrc' => $_POST['nrc']
                ];
                $this->modelo->update($data, $where);
            }

            echo json_encode(['res'=>true]);
        }

        // Método para obtener el registro seleccionado de la tabla dinámica
        public function editar() {
            $nrc = $_POST['id'];
            echo json_encode($this->modelo->where('nrc',$nrc)->first());
        }

        // Método para eliminar el registro seleccionado de la tabla dinámica
        public function eliminar() {
            $nrc = $_POST['id'];
            $where = [
                'nrc' => $nrc
            ];
            $this->modelo->delete($where);
            echo json_encode(['res'=>true]);
        }

        // Método para verificar si el NRC ya existe en la tabla proveedores
        public function verificarNrc() {
            $nrc = $_POST['nrc'];
            $rec = $this->modelo->where('nrc',$nrc)->first();
            if($rec)
                echo json_encode(['valid'=>false]);
            else
                echo json_encode(['valid'=>true]);
        }

        public function informe() {
            $pdf = new FPDF('P','mm','Letter');
            $pdf->SetFont('Arial','',8);
            $pdf->AddPage();

            $pdf->Cell(15,5,'Nombres:',0);
            $pdf->Cell(60,5,'Hugo Manuel','B');
            $pdf->Cell(15);
            $pdf->Cell(15,5,'Apellidos:',0);
            $pdf->Cell(60,5,utf8_decode('Canjura Ramirez'),'B',1);

            $pdf->Cell(15,5,'Nombres:',0);
            $pdf->Cell(60,5,'Hugo Manuel','B');

            $pdf->Output('I','informe.pdf');
        }

        public function informetabla() {

            $proveedores = $this->modelo->all();

            $pdf = new FPDF('L','mm','Letter');
            $pdf->SetFont('Arial','B',12);
            $pdf->AddPage();

            $ancho = $pdf->GetPageWidth()-20;

            $pdf->Image('../public/img/OIP.png',10,10,-770);

            $pdf->Cell($ancho,7,'LISTA DE PROVEEDORES',0,0,'C');
            $pdf->SetFont('Arial','',8);

            $pdf->Ln(14);
            $pdf->Cell($ancho*0.25,5,'nombre de la enpresa',1,0,'C');
            $pdf->Cell($ancho*0.25,5,utf8_decode('Razon social'),1,0,'C');
            $pdf->Cell($ancho*0.1,5,utf8_decode('Telefono'),1,0,'C');
            $pdf->Cell($ancho*0.2,5,'persona de contacto',1,0,'C');
            $pdf->Cell($ancho*0.2,5,utf8_decode('Correo electronico'),1,1,'C');

            foreach($proveedores as $proveedor) {
                $pdf->Cell($ancho*0.25,5,utf8_decode($proveedor->nombre_empresa),1,0);
                $pdf->Cell($ancho*0.25,5,utf8_decode($proveedor->razon_social),1,0);
                $pdf->Cell($ancho*0.1,5,$proveedor->telefono_contacto,1,0);
                $pdf->Cell($ancho*0.2,5,utf8_decode($proveedor->persona_contacto),1,0);
                $pdf->Cell($ancho*0.2,5,$proveedor->correo_electronico,1,1);
            }

            $pdf->Output('I','proveedores.pdf');
        }
    }
