<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('auths'); 
		
        $this->load->model('dbconfig');
        $this->db = $this->dbconfig->db(); 
    }
	
	public function index(){
	}

	private function check(){
        $udata = $this->session->userdata();
        if((isset($udata['username'])) && (isset($udata['id']))){
            return true;
        } else {
            return false;
        }
    }
	
	public function modal($data){
		if(!$this->check()){
			die;
		}
		$data = explode("~~", $data);
		
		switch ($data[0]) {
			case 'newDashboard':
				if(!$this->auths->admin()) die;
				$return['company'] = $this->db->get('company')->result();
				$this->load->view('modal/newDashboard', $return);
				break;
			case 'editDashboard':
				if(!$this->auths->admin()) die;
				$return['company'] = $this->db->get('company')->result();
				$return['data'] = $this->db->where('id', $data[1])->get('dashboard')->result()[0];
				$this->load->view('modal/editDashboard', $return);
			  	break;
			case 'databases':
				if(isset($data[1])){
					$return['config'] = $this->db->where('id', $data[1])->get($data[0])->result()[0];
					$this->load->view('modal/editDB', $return);
				} else {
					$this->load->view('modal/newDB');
				}
			  	break;
			case 'query':
				if(isset($data[1])){
					$return['db'] = $this->db->select('database_name as db_name, id')->get('databases')->result();
					$return['query'] = $this->db->where('id', $data[1])->get($data[0])->result()[0];
					$this->load->view('modal/editQuery', $return);
				} else {
					$return['db'] = $this->db->select('database_name as db_name, id')->get('databases')->result();
					$this->load->view('modal/newQuery', $return);
				}
			  	break;
			case 'array':
				if(isset($data[1])){
					$return['array'] = $this->db->where('id', $data[1])->get($data[0])->result()[0];
					$return['query'] = $this->db->select('name, id, get')->get('query')->result();
					$this->load->view('modal/editArray', $return);
				} else {
					$return['query'] = $this->db->select('name, id, get')->get('query')->result();
					$this->load->view('modal/newArray', $return);
				}
			  	break;
			case 'template':
				if(isset($data[1])){
					$return['template'] = $this->db->where('id', $data[1])->get($data[0])->result()[0];
					$this->load->view('modal/editTemplate',$return);
				} else {
					$this->load->view('modal/newTemplate');
				}
			  	break;
			case 'report':
				if(isset($data[1])){
					$return['report'] = $this->db->where('id', $data[1])->get($data[0])->result()[0];
					$return['template'] = $this->db->get('template')->result();
					$this->load->view('modal/editReport', $return);
				} else {
					$return['template'] = $this->db->get('template')->result();
					$this->load->view('modal/newReport', $return);
				}
			  	break;
			case 'editor':
				if($data[1] != ""){
					$return['editor'] = $this->db->select("report.*, template.sheets")->from('report')->join('template', "template.id = report.template_id")->where('report.id', $data[1])->get()->result()[0];
					$return['itterate'] = $this->db->where('report_id', $return['editor']->id)->get('itterate')->result();
					// var_dump($return);
					$this->load->view('modal/editor', $return);
				}
			  	break;
			default:
			  	echo $data[0];
		}

	}
}
