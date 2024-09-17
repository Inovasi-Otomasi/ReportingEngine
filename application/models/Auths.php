<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auths extends CI_Model {
    public function logout () {
        $this->session->sess_destroy();
        redirect(base_url('index.php/auth'));
        die;
    }

    public function check() {
        $udata = $this->session->userdata();
        if(!isset($udata['username'])) $this->logout();
        if(!isset($udata['id'])) $this->logout();
        if(!isset($udata['company_id'])) $this->logout();
    }
    
    public function admin(){
        $id = $this->session->userdata('company_id');

        if($id == 2) {
            return true;
        } else {
            return false;
        }
    }
}