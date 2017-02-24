<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Print_pdf extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('accounts','product','brand','category','billings','payrolls'),'',TRUE);
	}


function reciept_pdf($oid)
	{
		if($this->session->userdata('logged_in'))
		{	
				$data['details'] = $this->billings->fetch_order_details($oid);
				$data['customer'] = $this->billings->fetch_customer_details($oid);
				$amount=0;
				$quantity=0;
				$vat=0;
				$dif=0;
		
		
		
				require APPPATH . 'plugins/fpdf.php';
		
		       	$pdf = new FPDF('p', 'mm', 'A4');
		        $pdf->AddPage();
				$pdf->SetFont('Arial','b',13); 
		        $pdf->Cell(0,5, 'Company Name', 0, 1, 'C');
		        $pdf->Ln(1);
		        $pdf->SetFont('Arial','',12);
		        $pdf->Cell(0,5, 'Company Address and Contact', 0, 1, 'C');
		        $pdf->Line(43,31,100,31);
		       	$pdf->Line(150,31,180,31);
		        $pdf->Line(42,41,100,41);
		        $pdf->Ln(5);
		        foreach($data['customer'] as $cust){
		                $pdf->Cell(125,5,'Customer Name:  '. $cust->customer_name, 0, 0, 'J');
		                $pdf->Cell(45,5,'Date :  '. $cust->date, 0,1, 'J');
		                $pdf->Ln(5);
		                $pdf->Cell(125,5,'Payment Type:  '. $cust->payment, 0, 0, 'J');
		                 $pdf->Ln(7);
		        }
		        	$pdf->Cell(10,7,'Qty',1,0,'C');
				    $pdf->Cell(10,7,'Unit',1,0,'C');
		      		$pdf->Cell(100,7,'Description',1,0,'C');
		      		$pdf->Cell(40,7,'Unit Price',1,0,'C');
					$pdf->Cell(30,7,'Amount',1,0,'C');
				
				 $pdf->Ln(7);
				foreach($data['details']  as $pdt)
				{	$pdf->Cell(10,7,$pdt->qty,1,0,'C');
					$pdf->Cell(10,7,' ',1,0,'C');
					$pdf->Cell(100,7,$pdt->product_name,1,0,'C');
					$pdf->Cell(40,7,number_format($pdt->price,2),1,0,'C');
					$pdf->Cell(30,7,"Php ".number_format($total = $pdt->qty * $pdt->price,2),1,0,'C');
					$pdf->Ln(7);
					$amount+=$total;
					$quantity+=$pdt->qty;
					$vat= 0.12 * $amount;
					$dif = $amount-$vat;
		
				}
					$pdf->Cell(50,7,'',1,0,'C');
				    $pdf->Cell(30,7,'',1,0,'C');
		      		$pdf->Cell(80,7,'',1,0,'C');
					$pdf->Cell(30,7,"",1,0,'C');
					$pdf->Ln(7);
		
					$pdf->Cell(50,7,'',1,0,'C');
				    $pdf->Cell(30,7,'',1,0,'C');
		      		$pdf->Cell(80,7,'Total Sale(Vat Inclusive)',1,0,'C');
					$pdf->Cell(30,7,"Php ".number_format($total = $pdt->qty * $pdt->price,2),1,0,'C');
					$pdf->Ln(7);
		
					$pdf->Cell(50,7,'',1,0,'C');
				    $pdf->Cell(30,7,'',1,0,'C');
		      		$pdf->Cell(80,7,'Less:VAT',1,0,'C');
					$pdf->Cell(30,7,"Php ".number_format($vat,2),1,0,'C');
					$pdf->Ln(7);
		
					$pdf->Cell(50,7,'VATable',1,0,'C');
				    $pdf->Cell(30,7,"Php ".number_format($vat,2),1,0,'C');
		      		$pdf->Cell(80,7,'Amount Net of VAT',1,0,'C');
					$pdf->Cell(30,7,"Php ".number_format($dif,2),1,0,'C');
					$pdf->Ln(7);
		
					$pdf->Cell(50,7,'VAT Zero Rated',1,0,'C');
				    $pdf->Cell(30,7,'',1,0,'C');
		      		$pdf->Cell(80,7,'Amount Due',1,0,'C');
					$pdf->Cell(30,7,"",1,0,'C');
					$pdf->Ln(7);
		
					$pdf->Cell(50,7,'VAT - 12%',1,0,'C');
				    $pdf->Cell(30,7,"Php ".number_format($vat,2),1,0,'C');
		      		$pdf->Cell(80,7,'Add: VAT',1,0,'C');
					$pdf->Cell(30,7,'',1,0,'C');
					$pdf->Ln(7);
		
					$pdf->Cell(50,7,'',1,0,'C');
				    $pdf->Cell(30,7,'',1,0,'C');
		      		$pdf->Cell(80,7,'Total Amount Due',1,0,'C');
					$pdf->Cell(30,7,"Php ".number_format($amount,2),1,0,'C');
					$pdf->Ln(7);
		
		
				$pdf->Cell(125,5,'Delivered By:  '.$pdt->L_name.','. $pdt->F_name." ".$pdt->M_name, 0, 0, 'J');
			
		        $pdf->Ln(5);
		
				$pdf->Output();
		        }else{
		        	redirect(base_url(''));
		        }

        
	}

	function download_pdf($oid)
	{

		if($this->session->userdata('logged_in'))
		{	
		$data['details'] = $this->billings->fetch_order_details($oid);
		$data['customer'] = $this->billings->fetch_customer_details($oid);
		$amount=0;
		$quantity=0;
		$vat=0;
		$dif=0;



		require APPPATH . 'plugins/fpdf.php';

       	$pdf = new FPDF('p', 'mm', 'A4');
        $pdf->AddPage();
		$pdf->SetFont('Arial','b',13); 
        $pdf->Cell(0,5, 'Company Name', 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,5, 'Company Address and Contact', 0, 1, 'C');
        $pdf->Line(43,31,100,31);
       	$pdf->Line(150,31,180,31);
        $pdf->Line(42,41,100,41);
        $pdf->Ln(5);
        foreach($data['customer'] as $cust){
                $pdf->Cell(125,5,'Customer Name:  '. $cust->customer_name, 0, 0, 'J');
                $pdf->Cell(45,5,'Date :  '. $cust->date, 0,1, 'J');
                $pdf->Ln(5);
                $pdf->Cell(125,5,'Payment Type:  '. $cust->payment, 0, 0, 'J');
                 $pdf->Ln(7);
        }
        	$pdf->Cell(10,7,'Qty',1,0,'C');
		    $pdf->Cell(10,7,'Unit',1,0,'C');
      		$pdf->Cell(100,7,'Description',1,0,'C');
      		$pdf->Cell(40,7,'Unit Price',1,0,'C');
			$pdf->Cell(30,7,'Amount',1,0,'C');
		
		 $pdf->Ln(7);
		foreach($data['details']  as $pdt)
		{	$pdf->Cell(10,7,$pdt->qty,1,0,'C');
			$pdf->Cell(10,7,' ',1,0,'C');
			$pdf->Cell(100,7,$pdt->product_name,1,0,'C');
			$pdf->Cell(40,7,number_format($pdt->price,2),1,0,'C');
			$pdf->Cell(30,7,"Php ".number_format($total = $pdt->qty * $pdt->price,2),1,0,'C');
			$pdf->Ln(7);
			$amount+=$total;
			$quantity+=$pdt->qty;
			$vat= 0.12 * $amount;
			$dif = $amount-$vat;

		}
			$pdf->Cell(50,7,'',1,0,'C');
		    $pdf->Cell(30,7,'',1,0,'C');
      		$pdf->Cell(80,7,'',1,0,'C');
			$pdf->Cell(30,7,"",1,0,'C');
			$pdf->Ln(7);

			$pdf->Cell(50,7,'',1,0,'C');
		    $pdf->Cell(30,7,'',1,0,'C');
      		$pdf->Cell(80,7,'Total Sale(Vat Inclusive)',1,0,'C');
			$pdf->Cell(30,7,"Php ".number_format($total = $pdt->qty * $pdt->price,2),1,0,'C');
			$pdf->Ln(7);

			$pdf->Cell(50,7,'',1,0,'C');
		    $pdf->Cell(30,7,'',1,0,'C');
      		$pdf->Cell(80,7,'Less:VAT',1,0,'C');
			$pdf->Cell(30,7,"Php ".number_format($vat,2),1,0,'C');
			$pdf->Ln(7);

			$pdf->Cell(50,7,'VATable',1,0,'C');
		    $pdf->Cell(30,7,"Php ".number_format($vat,2),1,0,'C');
      		$pdf->Cell(80,7,'Amount Net of VAT',1,0,'C');
			$pdf->Cell(30,7,"Php ".number_format($dif,2),1,0,'C');
			$pdf->Ln(7);

			$pdf->Cell(50,7,'VAT Zero Rated',1,0,'C');
		    $pdf->Cell(30,7,'',1,0,'C');
      		$pdf->Cell(80,7,'Amount Due',1,0,'C');
			$pdf->Cell(30,7,"",1,0,'C');
			$pdf->Ln(7);

			$pdf->Cell(50,7,'VAT - 12%',1,0,'C');
		    $pdf->Cell(30,7,"Php ".number_format($vat,2),1,0,'C');
      		$pdf->Cell(80,7,'Add: VAT',1,0,'C');
			$pdf->Cell(30,7,'',1,0,'C');
			$pdf->Ln(7);

			$pdf->Cell(50,7,'',1,0,'C');
		    $pdf->Cell(30,7,'',1,0,'C');
      		$pdf->Cell(80,7,'Total Amount Due',1,0,'C');
			$pdf->Cell(30,7,"Php ".number_format($amount,2),1,0,'C');
			$pdf->Ln(7);


		$pdf->Cell(125,5,'Delivered By:  '.$pdt->L_name.','. $pdt->F_name." ".$pdt->M_name, 0, 0, 'J');
	
        $pdf->Ln(5);

		$pdf->Output('('.$cust->customer_name.')'.$cust->date.'.pdf','D');

		 }else{
		        	redirect(base_url(''));
		        }
       
	}

	public function payroll_pdf($id)
	{
		if($this->session->userdata('logged_in'))
		{	
		$data["records"] = $this->accounts->profile($id);
		$data["payrolls"] = $this->payrolls->pay_history($id);
		$amount=0;
		$quantity=0;
		$vat=0;
		$dif=0;



		require APPPATH . 'plugins/fpdf.php';

       	$pdf = new FPDF('L', 'mm', 'A3');
        $pdf->AddPage();
		$pdf->SetFont('Arial','b',13); 
        $pdf->Cell(0,5, 'Company Name', 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,5, 'Company Address and Contact', 0, 1, 'C');
      
        $pdf->Ln(10);
        foreach($data['records'] as $cust){
                $pdf->Cell(125,5,'Name:  '. $cust->L_name.','.$cust->F_name, 0, 1, 'J');
               
        }
        	$pdf->Cell(30,7,'Date',1,0,'C');
		    $pdf->Cell(30,7,'Basic Pay',1,0,'C');
      		$pdf->Cell(30,7,'Worked(days)',1,0,'C');
      		$pdf->Cell(30,7,'OT Rate',1,0,'C');
			$pdf->Cell(30,7,'OT hrs',1,0,'C');
			$pdf->Cell(30,7,'Allowance',1,0,'C');
      		$pdf->Cell(30,7,'Gross pay',1,0,'C');
      		$pdf->Cell(30,7,'TAX',1,0,'C');
			$pdf->Cell(30,7,'Advance',1,0,'C');
			$pdf->Cell(30,7,'Insurance',1,0,'C');
			$pdf->Cell(30,7,'Deduction',1,0,'C');
			$pdf->Cell(30,7,'Net pay',1,0,'C');
		
		
		 $pdf->Ln(7);
		 foreach($data['payrolls']  as $pay)
		{	
			
			 $gross= ($pay->Pay * $pay->dayswork) + ($pay->otrate * $pay->othrs) + $pay->allow;


					  if ($gross>=50000)
					   $tax = $gross * .15;
					  if ($gross>=30000 && $gross <=49999)
					   $tax = $gross * .10;
					  if ($gross>=10000 && $gross <=29999)
					   $tax = $gross * .05;
					  if ($gross>=5000 && $gross <=9999)
					   $tax = $gross * .03;
					  if ($gross < 5000)
						$tax = 0;
						
					  $totdeduct = $tax + $pay->advance + $pay->insurance; 
					  $netpay = $gross - $totdeduct;

			$pdf->Cell(30,7,$pay->date,1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($pay->Pay,2),1,0,'C');
			$pdf->Cell(30,7,number_format($pay->dayswork,2),1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($pay->otrate,2),1,0,'C');
			$pdf->Cell(30,7,number_format($pay->othrs,2),1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($pay->allow,2),1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($gross,2),1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($tax,2),1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($pay->advance,2),1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($pay->insurance,2),1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($totdeduct,2),1,0,'C');
			$pdf->Cell(30,7,'Php '.number_format($netpay,2),1,0,'C');
			
			$pdf->Ln(7);

		}
			
		


		//$pdf->Cell(125,5,'Organized By:  '.$pdt->L_name.','. $pdt->F_name." ".$pdt->M_name, 0, 0, 'J');
	
        $pdf->Ln(5);

		$pdf->Output('('.$cust->L_name.','.$cust->F_name.') - '.date('M - j - Y').'.pdf','D');

		 }else{
		        	redirect(base_url(''));
		        }
     
	}


}