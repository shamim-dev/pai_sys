<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payrolls extends CI_Model {

	public function __construct()
	{

		parent::__construct();
		$this->load->database();

	}
public function get_search($limit, $start,$search_term)
	{
	   $this->db->limit($limit, $start);
	   $this ->db->select('*');
	   $this ->db->from('account');
	   $this->db->like('L_name',$search_term);
	   $this->db->or_like('F_name',$search_term);
	   $query = $this->db->get();
	   if ($query->num_rows() > 0) {
		foreach ($query->result() as $row) {
		$data[] = $row;
		}

		return $data;
		}
		return false;
	}

	public function search_count($search_term)
	{					
			
			   $this->db->from('account');
			   $this->db->like('L_name',$search_term); 
			   $this->db->or_like('F_name',$search_term);
	   		return $this->db->count_all_results();
	}

	public function save($pay_record)
	{
		$this->db->insert('payroll',$pay_record);
	}
	public function pay_history($id)
	{
		$this->db->select('*');
		$this->db->from('payroll');
		$this->db->where('account_id',$id);
		$this->db->order_by('date');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
		foreach ($query->result() as $row) {
		$data[] = $row;
		}

		return $data;
		}
		return false;
	}
}