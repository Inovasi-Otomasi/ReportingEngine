<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('dbconfig');
        $this->load->model('dbconfig');
        $this->db = $this->dbconfig->db();
    }
    

    public function index() {
        if(!$this->check()){
            redirect("auth");
        }

        $this->dbconfig->check()['error'] ? redirect(base_url('index.php/home/welcome')) : null;
        $this->dbconfig->loadQuery();

        //report data
        $data['report'] = $this->db->select("report.*, template.name as template_name")->from('report')->join('template', 'report.template_id = template.id')->get()->result();
        $null = $this->db->select("*, '**no template' as template_name")->from('report')->where('template_id', null)->get()->result();
        foreach($null as $nu){
            array_push($data['report'],$nu);
        }
        
        //template data
        $data['template'] = $this->db->select("*")->from('template')->get()->result();
        
        //array data
        $data['array'] = $this->db->select("*")->from('array')->get()->result();
        
        //report data
        $data['query'] = $this->db->select("query.*, databases.database_name as db_name")->from('query')->join('databases', 'query.database_id = databases.id')->get()->result();
        $null = $this->db->select("*, '**no DB' as db_name")->from('query')->where('database_id', null)->get()->result();
        foreach($null as $nu){
            array_push($data['query'],$nu);
        }
        
        //array data
        $data['databases'] = $this->db->select("*")->from('databases')->get()->result();

        $this->load->view('editor/index', $data);
    }
    
    public function welcome() {
        $this->dbconfig->check()['error'] ? $this->load->view('auth/welcome') : redirect(base_url('index.php/home/'));
    }

    public function read() {
        $this->dbconfig->read();
    }

    public function write(){
        $this->dbconfig->write();
    }
    
    private function check(){
        $udata = $this->session->userdata();
        if((isset($udata['username'])) && (isset($udata['id']))){
            return true;
        } else {
            return false;
        }
    }

    public function load(){
        $this->dbconfig->loadQuery();
    }
}