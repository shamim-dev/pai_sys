<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('accounts','payrolls'),'',TRUE);
}

	public function index()
	{

		if($this->session->userdata('logged_in'))
		{
			$this->load->view('CP/payroll_home');
 		}else{
			redirect(base_url(''));
		}
	}

	public function search()
	{	
		if($this->session->userdata('logged_in')){

		 $delimiters['keyword'] = $this->input->get('keyword');


		if($delimiters['keyword']!=null){
			$config = array();
		        $delimiters['keyword'] = $this->input->get('keyword');
		        $config['first_url'] = base_url() . 'payroll/search?keyword=' . $delimiters['keyword'];
		        $config["base_url"] = base_url() . 'payroll/search';
       			$config['suffix']      = '?keyword=' . $delimiters['keyword'];
				$config["total_rows"] = $this->payrolls->search_count($delimiters['keyword']);
				        

				include APPPATH.'config/pagination.php';
		       
		        $this->pagination->initialize($config);
		 
		        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$data['accounts'] = $this->payrolls->get_search($config["per_page"], $page,$delimiters['keyword']);
				$data["links"] = $this->pagination->create_links();
		 
					
				
		}else{
			$data['accounts'] = array();
			$data['links'] = NULL;
			
		}

		$this->load->view('payroll/search',$data);

		}else{
				redirect(base_url(''));
			}	
	}

	public function view($id)
	{
		$data["records"] = $this->accounts->profile($id);
		$data["payrolls"] = $this->payrolls->pay_history($id);
		$this->load->view('payroll/view',$data);
	}

	function upload()
	{
		$config['upload_path']   = './assets/imports/';
		$config['allowed_types'] = 'xlsx|xls';
		$config['file_name']     = date('Y - M');
		$config['overwrite']     = FALSE;
		$config['max_size']      = 100;

		$this->load->library('upload', $config);
			if ($this->upload->do_upload())
		{
			
			      //here i used microsoft excel 2007
				  $this->load->library('excel');
			      $objReader = PHPExcel_IOFactory::createReader('Excel2007');

			      //set to read only

			      $objReader->setReadDataOnly(true);

			      //load excel file
			      $objPHPExcel = $objReader->load($this->upload->data()['full_path']);

			      $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
			     
			      //loop from first data until last data
			      for($i=2; $i<=77; $i++){
			       $check_id = $this->accounts->find($objWorksheet->getCellByColumnAndRow(0,$i)->getValue());
			       if($check_id){
			              $id = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
			              $date = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
			              $pay = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
			              $daywrk = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
			              $otrate = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
			              $othrs = $objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
			              $allow = $objWorksheet->getCellByColumnAndRow(7,$i)->getValue();
			              $advance = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue();
			              $insurance = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue();
			              $data_user = array(
			               "account_ID" => $id,
			               "date" => $date,
			               "Pay" => $pay,
			               "dayswork" => $daywrk,
			               "otrate" => $otrate,
			               "othrs" => $othrs,
			               "allow" => $allow,
			               "advance" => $advance,
			               "insurance" => $insurance
			               );
			              $this->payrolls->save($data_user);
	
			          }
				}
					$this->session->set_flashdata('message','Payroll upload is done! you can view them by searching an employee');
					redirect(base_url('payroll'));
		
	}
}
	 
}