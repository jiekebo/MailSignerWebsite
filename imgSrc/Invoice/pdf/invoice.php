<?php
define ('FPDF_FONTPATH','font/');
define ('EURO', chr(128) );
require('fpdf.php');

class Invoice extends FPDF
{
  var $colonnes;
  var $format;

  function maxX()
  {
    return $this->w;
  }

  function maxY()
  {
  	return $this->h;
  }

  function RoundedRect($x, $y, $w, $h,$r, $style = '')
  {
     $k = $this->k;
     $hp = $this->h;
     if($style=='F')
        $op='f';
     elseif($style=='FD' or $style=='DF')
        $op='B';
    else
        $op='S';
    $MyArc = 4/3 * (sqrt(2) - 1);
    $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));
    $xc = $x+$w-$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));

    $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
    $xc = $x+$w-$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
    $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
    $xc = $x+$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
    $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
    $xc = $x+$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
    $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
    $this->_out($op);
  }

  function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
  {
    $h = $this->h;
    $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
        $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
  }

  function SizeOfText( $texte, $larg )
  {
      $index    = 0;
      $nb_lines = 0;
      $loop     = TRUE;
      while ( $loop )
      {
         $pos = strpos($texte, "\n");
         if (!$pos)
         {
                $loop  = FALSE;
                $ligne = $texte;
         }
         else
         {
            $ligne  = substr( $texte, $index, $pos);
            $texte = substr( $texte, $pos+1 );
         }
         $length = floor( $this->GetStringWidth( $ligne ) );
         $res = 1 + floor( $length / $larg) ;
         $nb_lines += 5 * $res;
      }

      return $nb_lines;
  }

  function addSociete( $nom, $adresse )
  {
    $x1 = 10;
    $y1 = 8;
    //Positionnement en bas
    $this->SetXY( $x1, $y1 );
    $this->SetFont('Arial','B',12);
    $length = $this->GetStringWidth( $nom );
    $this->Cell( $length, 2, $nom);
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','',10);
    $length = $this->GetStringWidth( $adresse );
    //Coordonnées de la société
    $lignes = $this->SizeOfText( $adresse, $length) ;
    $this->MultiCell($length, $lignes/5, $adresse);
  }

  function addFacture( $numfact )
  {
    $maxX=$this->maxX();
    $r1  = $maxX - 80;
    $r2  = $r1 + 68;
    $y1  = 6;
    $y2  = $y1 + 2;
    $mid = $y1 + ($y2 / 2);
    $this->SetLineWidth(0.1);
    $this->SetFillColor(192);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
    $this->SetXY( $r1+2, $y1+2);
    $this->SetFont( "Helvetica", "B", 12);
    $string = sprintf("FA%04d",$numfact);
    $this->Cell(30,5, "FACTURE EN ".EURO );
    $this->SetXY( $r1 + 35, $y1+2);
    $this->Cell(20,5,"Num : " . $string);
  }

  function addDate( $date )
  {
    $maxX=$this->maxX();
    $r1  = $maxX - 61;
    $r2  = $r1 + 30;
    $y1  = 17;
    $y2  = $y1 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
    $this->SetFont( "Helvetica", "B", 10);
    $this->Cell(10,5, "DATE", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
    $this->SetFont( "Helvetica", "", 10);
    $this->Cell(10,5,$date, 0,0, "C");
  }

  function addClient( $ref )
  {
    $maxX=$this->maxX();
    $r1  = $maxX - 31;
    $r2  = $r1 + 19;
    $y1  = 17;
    $y2  = $y1;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
    $this->SetFont( "Helvetica", "B", 10);
    $this->Cell(10,5, "CLIENT", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
    $this->SetFont( "Helvetica", "", 10);
    $this->Cell(10,5,$ref, 0,0, "C");
  }

  function addPageNumber( $page )
  {
    $maxX=$this->maxX();
    $r1  = $maxX - 80;
    $r2  = $r1 + 19;
    $y1  = 17;
    $y2  = $y1;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
    $this->SetFont( "Helvetica", "B", 10);
    $this->Cell(10,5, "PAGE", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
    $this->SetFont( "Helvetica", "", 10);
    $this->Cell(10,5,$page, 0,0, "C");
  }

  function addClientAdresse( $adresse )
  {
    $maxX   = $this->maxX();
    $r1     = $maxX - 80;
    $r2     = $r1 + 68;
    $y1     = 40;
    $y2     = $y1 + 3;
    $this->SetXY( $r1, $y1);
    $lignes = $this->SizeOfText ($adresse, $r2-$r1);
    $this->MultiCell( ($r2 - $r1), $lignes/5, $adresse);
  }

  function addReglement( $mode )
  {
    $maxX=$this->maxX();
    $r1  = 10;
    $r2  = $r1 + 60;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1+1 );
    $this->SetFont( "Helvetica", "B", 10);
    $this->Cell(10,5, "MODE DE REGLEMENT", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1 + 5 );
    $this->SetFont( "Helvetica", "", 10);
    $this->Cell(10,5,$mode, 0,0, "C");
  }

  function addEcheance( $date )
  {
    $maxX=$this->maxX();
    $r1  = 80;
    $r2  = $r1 + 40;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2 - $r1)/2 - 5 , $y1+1 );
    $this->SetFont( "Helvetica", "B", 10);
    $this->Cell(10,5, "DATE D'ECHEANCE", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5 , $y1 + 5 );
    $this->SetFont( "Helvetica", "", 10);
    $this->Cell(10,5,$date, 0,0, "C");
  }

  function addNumTVA($tva_fr, $tva_cee)
  {
    $this->SetFont( "Helvetica", "", 10);
    $length = $this->GetStringWidth( "N/ld CEE : " . $tva_fr ) + 4;
    $maxX=$this->maxX();
    $r1  = $maxX - 80;
    $r2  = $r1 + 60;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    // $this->SetXY( $r1 + ($r2-$r1)/2 -2 , $y1+1 );
    $this->SetXY( $r1 + 2, $y1 + 1 );
    $this->Cell($length,4, "N/ld CEE : " . $tva_fr);
    $this->SetXY( $r1 + 2, $y1 + 6 );
    $this->Cell($length,4,"V/ld CEE : " . $tva_cee);
  }

  function addReference($ref)
  {
    $this->SetFont( "Helvetica", "", 10);
    $length = $this->GetStringWidth( "References : " . $ref );
    $r1  = 10;
    $r2  = $r1 + $length;
    $y1  = 92;
    $y2  = $y1+5;
    $this->SetXY( $r1 , $y1 );
    $this->Cell($length,4, "References : " . $ref);
  }

  function addCols( $tab )
  {
    global $colonnes;
    $maxX=$this->maxX();
    $r1  = 10;
    $r2  = $maxX - ($r1 * 2) ;
    $y1  = 100;
    $y2  = $this->maxY() - 50 - $y1;
    $this->SetXY( $r1, $y1 );
    $this->Rect( $r1, $y1, $r2, $y2, "D");
    $this->Line( $r1, $y1+6, $r1+$r2, $y1+6);
    $colX = $r1;
    $colonnes = $tab;
    while ( list( $lib, $pos ) = each ($tab) )
    {
       $this->SetXY( $colX, $y1+2 );
       $this->Cell( $pos, 1, $lib, 0, 0, "C");
       $colX += $pos;
       $this->Line( $colX, $y1, $colX, $y1+$y2);
    }
  }

  function addLineFormat( $tab )
  {
     global $format, $colonnes;
     while ( list( $lib, $pos ) = each ($colonnes) )
     {
        if ( isset( $tab["$lib"] ) )
           $format[ $lib ] = $tab["$lib"];
     }
  }

  function LineVert( $tab )
  {
    global $colonnes;

    reset( $colonnes );
    $maxSize=0;
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        $texte = $tab[ $lib ];
        $longCell  = $pos -2;
        $size = $this->SizeOfText( $texte, $longCell );
        if ($size > $maxSize)
           $maxSize = $size;
    }
    return $maxSize;
  }

  function addLine( $ligne, $tab )
  {
    global $colonnes, $format;

    $ordonnee = 10;
    $maxSize  = $this->LineVert( $tab );

    reset( $colonnes );
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        $longCell  = $pos -2;
        $texte     = $tab[ $lib ];
        $formText  = $format[ $lib ];
        $this->SetXY( $ordonnee+1, $ligne-1);
        $this->MultiCell( $longCell, $maxSize/5 , $texte, 0, $formText);
        $ordonnee += $pos;
    }
    return $maxSize;
  }

  function addRemarque($remarque)
  {
    $this->SetFont( "Helvetica", "", 10);
    $length = $this->GetStringWidth( "Remarque : " . $remarque );
    $r1  = 10;
    $r2  = $r1 + $length;
    $y1  = $this->maxY() - 45;
    $y2  = $y1+5;
    $this->SetXY( $r1 , $y1 );
    $this->Cell($length,4, "Remarque : " . $remarque);

  }

  function addCadreTVAs()
  {
    $this->SetFont( "Arial", "B", 8);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->maxY() - 40;
    $y2  = $y1+20;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $y1+4, $r2, $y1+4);
    $this->Line( $r1+5,  $y1+4, $r1+5, $y2); // avant BASES HT
    $this->Line( $r1+27, $y1, $r1+27, $y2);  // avant REMISE
    $this->Line( $r1+43, $y1, $r1+43, $y2);  // avant MT TVA
    $this->Line( $r1+63, $y1, $r1+63, $y2);  // avant % TVA
    $this->Line( $r1+75, $y1, $r1+75, $y2);  // avant PORT
    $this->Line( $r1+91, $y1, $r1+91, $y2);  // avant TOTAUX
    $this->SetXY( $r1+9, $y1);
    $this->Cell(10,4, "BASES HT");
    $this->SetX( $r1+29 );
    $this->Cell(10,4, "REMISE");
    $this->SetX( $r1+48 );
    $this->Cell(10,4, "MT TVA");
    $this->SetX( $r1+63 );
    $this->Cell(10,4, "% TVA");
    $this->SetX( $r1+78 );
    $this->Cell(10,4, "PORT");
    $this->SetX( $r1+100 );
    $this->Cell(10,4, "TOTAUX");
    $this->SetFont( "Arial", "B", 6);
    $this->SetXY( $r1+93, $y2 - 3 );
    $this->Cell(6,0, "T.V.A.  :");
  }

  function addCadreEurosFrancs()
  {
    $r1  = $this->maxX() - 70;
    $r2  = $r1 + 60;
    $y1  = $this->maxY() - 40;
    $y2  = $y1+20;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+20,  $y1, $r1+20, $y2); // avant EUROS
    $this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
    $this->Line( $r1+35,  $y1, $r1+35, $y2); // Entre Euros & Francs
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+20, $y1 );
    $this->Cell(15,4, "EUROS",0,0,"C");
    $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+35, $y1 );
    $this->Cell(15,4, "FRANCS",0,0,"C");
    $this->SetFont( "Arial", "B", 6);
    $this->SetXY( $r1, $y1+5 );
    $this->Cell(20,4, "TOTAL TTC", 0, 0, "C");
    $this->SetXY( $r1, $y1+10 );
    $this->Cell(20,4, "ACCOMPTE", 0, 0, "C");
    $this->SetXY( $r1, $y1+15 );
    $this->Cell(20,4, "NET A PAYER", 0, 0, "C");
  }
}

   $facture=1;
   $devis=-1;
   if ( isset($_GET) )
   {
     if ( isset($_GET["facture"]) )
     {
         $facture=$_GET["facture"];
     }
   }

   $pdf=new Invoice('P','mm','A4');
   $pdf->Open();
   $pdf->AddPage();
   $pdf->SetMargins( 0.5, 0.5, 0.5 );
   $pdf->addSociete( "MailSigner inc." ,
                     "Kronetorpsgatan 70D\n" .
                     "21227 Malmö\n".
                     "Sweden\n" );
   $pdf->addFacture($facture);
   $pdf->addDate("03/12/2003");
   $pdf->addClient("CL01");
   $pdf->addPageNumber("1");
   $pdf->addClientAdresse("Ste\nMr XXXX\n3eme etage\n33, rue d'ailleurs\n75000 PARIS");

   $pdf->addReglement("Cheque a reception de facture");
   $pdf->addEcheance("03/12/2003");
   $pdf->addNumTVA("tva1", "tva2");
   $pdf->addReference("Devis ... du ....");
   $cols=array( "REFERENCE"    => 23,
                "DESIGNATION"  => 78,
                "QUANTITE"     => 22,
                "P.U. HT"      => 26,
                "MONTANT H.T." => 30,
                "TVA"          => 11 );
   $pdf->addCols( $cols);
   $cols=array( "REFERENCE"    => "L",
                "DESIGNATION"  => "L",
                "QUANTITE"     => "C",
                "P.U. HT"      => "R",
                "MONTANT H.T." => "R",
                "TVA"          => "C" );
   $pdf->addLineFormat( $cols);

   $y    = 108;
   $line = array( "REFERENCE"    => "TEST1",
                  "DESIGNATION"  => "Carte Mere MSI 6378\n" .
                                    "Processeur AMD 1Ghz\n" .
                                    "128Mo SDRAM, 30 Go Disque, Cdrom, Floppy, Carte video",
                  "QUANTITE"     => "1",
                  "P.U. HT"      => "60.00",
                  "MONTANT H.T." => "60.00",
                  "TVA"          => "1" );
   $size = $pdf->addLine( $y, $line );
   $y   += $size ;
   $line = array( "REFERENCE"    => "$y",
                  "DESIGNATION"  => "$size",
                  "QUANTITE"     => "1",
                  "P.U. HT"      => "60.00",
                  "MONTANT H.T." => "60.00",
                  "TVA"          => "1" );

   $size = $pdf->addLine( $y, $line );
   $y   += $size;
   $line =array( "REFERENCE"    => "$y",
                "DESIGNATION"  => "$size",
                "QUANTITE"     => "1",
                "P.U. HT"      => "60.00",
                "MONTANT H.T." => "60.00",
                "TVA"          => "1" );

   $size = $pdf->addLine( $y, $line );
   $y   += $size;
   $line = array( "REFERENCE"    => "$y",
                  "DESIGNATION"  => "$size",
                  "QUANTITE"     => "1",
                  "P.U. HT"      => "60.00",
                  "MONTANT H.T." => "60.00",
                  "TVA"          => "1" );
   $size = $pdf->addLine( $y, $line );

   $pdf->addRemarque( "remarque");
   $pdf->addCadreTVAs();
   $pdf->addCadreEurosFrancs();

   $pdf->Output();
?>
