<?php 

    class PDF extends FPDF{
        // Cabecera de página
        function Header(){
            // Logo
            $this->Image('../public/src/barber1.png',22,5,60);
            // Arial bold 15
            $this->SetFont('Arial','B',25);
            // Movernos a la derecha
            $this->Cell(90);
            // Título
            $this->Cell(30,25,'TONSORES',0,0,'C');
            // Salto de línea
            $this->Ln(20);
        }

        // Pie de página
        function Footer(){
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

?>

