<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('auths');
        $this->load->model('dbconfig');

        $this->load->model('dbconfig');
        $this->db = $this->dbconfig->db();
    }

    public function welcome(){
        $data = $this->input->post();
        $config = $this->dbconfig->setConfig($data);
        echo json_encode($config);
    }

    public function index() {
        $this->dbconfig->check()['error'] ? redirect(base_url('index.php/home/welcome')) : null;
        
        if($this->check()){
            redirect(base_url());
        } else {
            $this->load->view("auth/login");
        }
    }

    private function check(){
        $udata = $this->session->userdata();
        if((isset($udata['username'])) && (isset($udata['id']))){
            return true;
        } else {
            return false;
        }
    }

    public function login() {
        if($this->check())die;
        $data = $this->input->post();
        if(!isset($data['username']))die;
        if(!isset($data['password']))die;
        if($data['username'] == "")die;
        if($data['password'] == "")die;

        $user = $this->db->where('username', $data['username'])->get('users')->result();
        if(!isset($user[0]))die;
        $user = $user[0];
        
        if(password_verify($data['password'],$user->password)){
            $udata = [
                'id' => $user->id,
                'username' => $user->username,
            ];
            $this->session->set_userdata($udata);
        } else {
            die;
        }
        
        echo "done";
    }

    public function logout () {
        $this->auths->logout();
    }
    
}