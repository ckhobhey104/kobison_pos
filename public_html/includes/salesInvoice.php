<?php
session_start();
include_once("../fpdf/fpdf.php");
// $receiveJson = file_get_contents("php://input");
$product = json_decode($_GET['product_data'],true);
$invoice = json_decode($_GET['invoice_data'],true);
if(isset($_GET['product_data']) && isset($_GET['invoice_data'])){
    // print_r(json_decode($_GET['product_data']));
    $pdf = new FPDF('P','mm',array(85,61));
    $pdf->SetFillColor(230,230,230);
    $pdf->SetMargins(2,2,2.5,10.5);
	$pdf->AddPage();
    $pdf->SetFont("Times","B",9);
    $pdf->Cell(50,4,"JOHN DOE ENTERPRISE",0,1,"C");
    $pdf->Cell(52,4,"Location: First Love Montessori, Kasoa",0,1,"C");

    $pdf->SetFont("Times",null,7);
    $pdf->Cell(20,5,"Order Date",0,0);
    $pdf->Cell(10,5,":".date('d-m-Y'),0,1);

    $pdf->Cell(16,3,"Product Name",1,0,"C");
    $pdf->Cell(14,3,"Quantity",1,0,"C");
    $pdf->Cell(13,3,"Price",1,0,"C");
    $pdf->Cell(14,3,"Total (GHC)",1,1,"C");
    
    foreach ($product as $value){
        $pdf->Cell(16,4,$value["pname"],1,0,"C");
        $pdf->Cell(14,4,$value["qty"],1,0,"C");
		$pdf->Cell(13,4,$value["price"],1,0,"C");
	 	$pdf->Cell(14,4,$value["qty"] * $value["price"],1,1,"C");
    }
    
	 $pdf->Cell(22,3,"",0,1);

    
      $pdf->Cell(20,3,"Sub Total : ",0,0);
      $pdf->Cell(15,3,$invoice[0]["sub"],0,0);
 
      $pdf->Cell(15,3,"Discount : ",0,0);
      $pdf->Cell(20,3,$invoice[0]["disc"],0,1);
 
      $pdf->Cell(20,3,"Net Total : ",0,0);
      $pdf->Cell(15,3,$invoice[0]["net_tot"],0,0);
 
      $pdf->Cell(15,3,"Amount Paid : ",0,0);
      $pdf->Cell(20,3,floatval($invoice[0]["amt_pd"]),0,1);
 
      $pdf->Cell(20,3,"Change:",0,0);
      $pdf->Cell(15,3,$invoice[0]["change"],0,1);
 
      $pdf->Cell(20,3,"Payment Method : ",0,0);
      $pdf->Cell(20,3,$invoice[0]["pmt_mthd"],0,1);

      $pdf->SetY(58);
      $pdf->SetFont("Arial",null,7);
      $pdf->Cell(50,3, chr(169)."Kobison Technologies (Kobby 104)",0,1,"C");
      $pdf->SetFont("Times",null,7);
      $pdf->Cell(55,3, "Tel: 0200249764. Email: kobinaafful27@gmail.com",0,1,"C");

    $pdf->Output();
}