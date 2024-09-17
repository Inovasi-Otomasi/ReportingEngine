<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('dbconfig');
        $this->load->model('dbconfig');
        $this->db = $this->dbconfig->db();
    }

    public function index() {
        $this->download();
    }

    public function download($method = null) {
        if($method == null){
            echo "Ups, Unrecognized Report!";
        } else {
            $route = urldecode($method);
            $data = $this->db->where('url', $route)->get('report')->result();
            if(isset($data[0])){
                $template = $this->db->where('id',$data[0]->template_id)->get('template')->result();
                if(!isset($template[0])){
                    echo "Ups, Unrecognized Report!";
                    die;
                }

                $id = $data[0]->id;
                $itterate = $this->db->where('report_id', $id)->get('itterate')->result();

                $arr = [];
                foreach($itterate as $itt){
                    if(!in_array($itt->array_id, $arr) && $itt->array_id != null){
                        array_push($arr, $itt->array_id);
                    }
                }

                $array = $this->db->where_in('id', $arr)->get('array')->result();
                $que = [];
                foreach($array as $ar){
                    if($ar->query != null){
                        $queries_id = json_decode($ar->query);
                        foreach($queries_id as $queid){
                            if(!in_array($queid, $que)){
                                array_push($que, $queid);
                            }
                        }

                    }
                }

                $return['array'] = $array;
                $return['itterate'] = $itterate;
                $return['queries'] = json_encode($que);
                $return['query'] = $this->db->select('name, id, get')->get('query')->result();
                $return['template'] = $template[0];
                $return['report'] = $data[0]->name;

                $this->load->view('editor/download',$return);
            } else {
                echo "Ups, Unrecognized Report!";
            }
        }
    }
}