<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('auths');
        $this->load->model('dbconfig');
        $this->db = $this->dbconfig->db();
    }

    private function check(){
    }

    private function queryVar($query_string, $get_variables) {
        // Regular expression to find placeholders in the format ${something}
        $pattern = '/\$\{([a-zA-Z0-9_]+)\}/';
    
        // Callback function to replace placeholders with $_GET values
        $callback = function($matches) use ($get_variables) {
            $key = $matches[1]; // Get the key inside ${}
            if (isset($get_variables[$key])) {
                $value = $get_variables[$key];
                // Decode the value and check if it is numeric
                $decoded_value = urldecode($value);
                // Return the value without quotes if it's numeric; escape otherwise
                return is_numeric($decoded_value) ? $decoded_value : $this->db->escape($decoded_value);
            }
            return $matches[0];
        };
    
        // Replace placeholders in the query string
        $replaced_query = preg_replace_callback($pattern, $callback, $query_string);
    
        // Return the modified query string
        return $replaced_query;
    }

    public function delete($table, $id) {
        // if(!$this->auths->admin()) die;
        $this->db->where('id', $id)->delete($table);
        echo "done";
    }

    // public function insert($table) {
    //     if(!$this->auths->admin()) die;

    //     $data = $this->input->post();
    //     if($table == "users"){
    //         if(!isset($data['username']))die;
    //         if(!isset($data['password']))die;
    //         $us = $this->db->where('username', $data['username'])->get('users')->result();

    //         if(isset($us[0])){
    //             echo 'OOPS, Username has been used by another user!';
    //             die;
    //         }
    //     }
    //     foreach($data as $key => $val ){
    //         if($key == "password"){
    //             $data[$key] = password_hash($val,PASSWORD_DEFAULT);
    //         } else {
    //             $data[$key] = htmlspecialchars($val);
    //         }
    //     }
    //     $this->db->insert($table, $data);
    //     echo "done";
    // }
    
    public function insert($table) {
        if($table == 'databases'){
            $config = array(
                'dsn' => '',
                'hostname' => 'localhost',
                'username' => 'default_user',
                'password' => 'default_password',
                'database' => 'default_database',
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => FALSE,
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );
    
            $payload = $this->input->post();
            foreach ($config as $key => $value) {
                if (array_key_exists($key, $payload)) {
                    if($payload[$key] === "true"){
                        $payload[$key] = true;
                    }
                    if($payload[$key] === "false"){
                        $payload[$key] = false;
                    }
                    $config[$key] = $payload[$key];
                }
            }
            
            $check = $this->dbconfig->check($config);
            if($check['error']){
                // $check['reason'] =
                echo json_encode($check);
            } else {
                $insert = $this->dbconfig->toDB($config);
                unset($insert['failover']);
                
                $this->db->insert("databases",$insert);
                echo "done";
            }
        } else if($table == 'query'){
            $data = $this->input->post();
            if($this->db->insert('query', $data)){
                echo"done";
            } else {
                $data = ['reason' => ['Name is Used!']];
                echo json_encode($data);
            }
        } else if($table == 'array'){
            $data = $this->input->post();

            if($data['query'] == "") $data["query"] = "[]";

            if($this->db->insert('array', $data)){
                echo"done";
            } else {
                $data = ['reason' => ['Name is Used!']];
                echo json_encode($data);
            }
        } else if($table == 'template'){
            $config['allowed_types']        = 'xlsx|XLSX';
            $config['max_size']             = 8000;
            $config['upload_path']          = './template/upload/';
            $this->load->library('upload', $config);
            if ( $this->upload->do_upload("template")){
                $insert = $this->input->post();
                $insert['file'] = $this->upload->data('file_name');
                
                $this->load->library('PhpSpreadsheetLibrary');
                
                $filePath = './template/upload/' . $insert['file'];
                $spreadsheet = $this->phpspreadsheetlibrary->load($filePath);
                $sheetNames = $this->phpspreadsheetlibrary->getSheetNames($spreadsheet);
                $insert['sheets'] = json_encode($sheetNames);

                $this->db->insert("template",$insert);
                echo "done";
            } else {
                $err = $this->upload->display_errors();
                $data = ['reason' => [$err]];
                echo json_encode($data);
            }
            
        } else if($table == "report") {
            $data = $this->input->post();
            if($this->db->insert('report', $data)){
                echo"done";
            } else {
                $data = ['reason' => ['URL is Used!']];
                echo json_encode($data);
            }
        } else if($table == "itterate") {
            $data = $this->input->post();
            $where = [
                'col' => $data['col'],
                'row' => $data['row'],
                'sheet' => $data['sheet'],
                'report_id' => $data['report_id'],
            ];

            $data['style'] = json_encode($data['style']);

            if(($data['array_id'] != '') && ($data['direction'] != '')){
                $check = $this->db->where($where)->count_all_results('itterate');
                if($check != 0){
                    $this->db->set($data)->where($where)->update('itterate');
                } else {
                    $this->db->insert('itterate', $data);
                }
            } else {
                $this->db->where($where)->delete('itterate');
            }
            echo"done";
            
        }
    }

    public function update($table, $id) {
        if($table == 'databases'){
            $config = array(
                'dsn' => '',
                'hostname' => 'localhost',
                'username' => 'default_user',
                'password' => 'default_password',
                'database' => 'default_database',
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => FALSE,
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );
    
            $payload = $this->input->post();
            foreach ($config as $key => $value) {
                if (array_key_exists($key, $payload)) {
                    if($payload[$key] === "true"){
                        $payload[$key] = true;
                    }
                    if($payload[$key] === "false"){
                        $payload[$key] = false;
                    }
                    $config[$key] = $payload[$key];
                }
            }
            
            $check = $this->dbconfig->check($config);
            if($check['error']){
                // $check['reason'] =
                echo json_encode($check);
            } else {
                $insert = $this->dbconfig->toDB($config);
                unset($insert['failover']);
                
                $this->db->set($insert)->where('id',$id)->update("databases");
                echo "done";
            }
        } else if($table == 'query'){
            $data = $this->input->post();

            if($data['query'] == "") $data["query"] = "[]";

            if($this->db->set($data)->where('id',$id)->update('query')){
                echo"done";
            } else {
                $data = ['reason' => ['Name is Used!']];
                echo json_encode($data);
            }
        } else if($table == 'array'){
            $data = $this->input->post();
            if($this->db->set($data)->where('id',$id)->update('array')){
                echo"done";
            } else {
                // $data = ['reason' => ['Name is Used!']];
                echo json_encode($data);
            }
        } else if($table == 'template'){
            $config['allowed_types']        = 'xlsx|XLSX';
            $config['max_size']             = 8000;
            $config['upload_path']          = './template/upload/';
            $this->load->library('upload', $config);
            $insert = $this->input->post();

            if ( $this->upload->do_upload("template")){
                $insert['file'] = $this->upload->data('file_name');
                
                $this->load->library('PhpSpreadsheetLibrary');
                
                $filePath = './template/upload/' . $insert['file'];
                $spreadsheet = $this->phpspreadsheetlibrary->load($filePath);
                $sheetNames = $this->phpspreadsheetlibrary->getSheetNames($spreadsheet);
                $insert['sheets'] = json_encode($sheetNames);
            }
            $this->db->set($insert)->where('id',$id)->update("template");
            echo "done";
            
        } else if($table == "report") {
            $data = $this->input->post();
            if($this->db->set($data)->where('id',$id)->update('report')){
                echo"done";
            } else {
                $data = ['reason' => ['URL is Used!']];
                echo json_encode($data);
            }
        } else if($table == "itterate") {
            $data = $this->input->post();
            $where = [
                'col' => $data['col'],
                'row' => $data['row'],
                'sheet' => $data['sheet'],
                'report_id' => $data['report_id'],
            ];
            
            if(($data['array_id'] != '') && ($data['direction'] != '')){
                $check = $this->db->where($where)->count_all_results('itterate');
                if($check != 0){
                    $this->db->set($data)->where($where)->update('itterate');
                } else {
                    $this->db->insert('itterate', $data);
                }
            } else {
                $this->db->where($where)->delete('itterate');
            }
            echo"done";
            
        }
    }

    public function testQuery($id) {
        $query = $this->input->post('query');
        $database = $this->db->where('id',$id)->get('databases')->result()[0];

        $database = json_decode(json_encode($database),true);
        $database['database'] = $database['database_name'];
        unset($database['database_name']);
        $db = $this->dbconfig->db($database);
        
        if($db->conn_id) {
            $query = $this->queryVar($query, $_GET);
            $query = "with test as ($query) select * from test limit 10";
            $result = $db->query($query);
            $return['query'] = $query;
            if($result){
                $return['error'] = false;
                $return['data'] = $result->result();
            } else {
                $return['error'] = true;
                $return['reason'][] = 'Invalid Query'; 
            }
        } else {
            $return['reason'][] = 'Unable connect to database';
        }

        echo json_encode($return);
    }

    public function getQuery(){
        $id = $this->input->post('id');
        $limit = $this->input->post('limit');
        $offset = $this->input->post('offset');
        $query = $this->db->where('id', $id)->get('query')->result()[0];
        $database = $this->db->where('id',$query->database_id)->get('databases')->result()[0];
        $query = $query->code;
        
        $database = json_decode(json_encode($database),true);
        $database['database'] = $database['database_name'];
        unset($database['database_name']);
        $db = $this->dbconfig->db($database);

        if($db->conn_id) {
            $query = $this->queryVar($query, $_GET);
            $query = "with test as ($query) select * from test limit $limit offset $offset";
            $result = $db->query($query);
            if($result){
                $return['error'] = false;
                $return['data'] = $result->result();
            } else {
                $return['error'] = true;
                $return['reason'][] = 'Invalid Query'; 
                $return['reason'][] = $query; 
            }
        } else {
            $return['reason'][] = 'Unable connect to database';
        }

        echo json_encode($return);
    }

    public function countQuery(){
        $id = $this->input->post('id');
        $query = $this->db->where('id', $id)->get('query')->result()[0];
        $database = $this->db->where('id',$query->database_id)->get('databases')->result()[0];
        $query = $query->code;
        
        $database = json_decode(json_encode($database),true);
        $database['database'] = $database['database_name'];
        unset($database['database_name']);
        $db = $this->dbconfig->db($database);

        if($db->conn_id) {
            $query = $this->queryVar($query, $_GET);
            $query = "with test as ($query) select count(*) as count from test";
            $result = $db->query($query);
            if($result){
                $return['error'] = false;
                $return['data'] = $result->result();
            } else {
                $return['error'] = true;
                $return['reason'][] = 'Invalid Query'; 
            }
        } else {
            $return['reason'][] = 'Unable connect to database';
        }

        echo json_encode($return);
    }

    public function testFunction(){
        $data['function'] = $this->input->post('function');
        $this->load->view('editor/function', $data);
    }
    
    public function edit($table, $id) {
        $data = $this->input->post();
        if($table == "users"){
            if($id != $_SESSION['id']){
                if(!$this->auths->admin()) die;
            }

            if(!isset($data['username']))die;

            $us = $this->db->where([
                'username' => $data['username'],
                'id !='    => $id 
                ])->get('users')->result();

                if(isset($us[0])){
                echo 'OOPS, Username has been used by another user!';
                die;
            }
        } else {
            if(!$this->auths->admin()) die;
        }
        foreach($data as $key => $val ){
            if($key == "password"){
                if($val == ""){
                    unset($data[$key]);
                } else {
                    $data[$key] = password_hash($val,PASSWORD_DEFAULT);
                }
            } else {
                $data[$key] = htmlspecialchars($val);
            }
        }
        $this->db->set($data)->where('id', $id)->update($table);
        echo "done";
    }

    public function style($id){
        $style = $this->db->select('style')->where('id',$id)->get('itterate')->result()[0]->style;
        echo $style;
    }
} 