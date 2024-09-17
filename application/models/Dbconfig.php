<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbconfig extends CI_Model {

    private function read() {
        $path = "./conf/.conf";

        if(file_exists($path)){
            $file = fopen($path, "r");
            $line = fgets($file);
        } else {
            $file = fopen($path, "w");
        }
        
        if($line == ""){
            $line = '{"dsn":"","hostname":"","username":"","password":"","database":"","dbdriver":"mysqli","dbprefix":"","pconnect":false,"db_debug":false,"cache_on":false,"cachedir":"","char_set":"utf8","dbcollat":"utf8_general_ci","swap_pre":"","encrypt":false,"compress":false,"stricton":false,"failover":[],"save_queries":true}';
            fwrite($file, $line);
        }

        fclose($file);
        
        return json_decode($line, true);

    }

    public function setConfig($postData){
        $config = $this->read();
    
        if (isset($postData['dbhost'])) {
            $config['hostname'] = $postData['dbhost'];
            if (!empty($postData['dbport'])) {
                $config['hostname'] .= ':' . $postData['dbport'];
            }
        }
        if (isset($postData['dbuser'])) {
            $config['username'] = $postData['dbuser'];
        }
        if (isset($postData['dbpass'])) {
            $config['password'] = $postData['dbpass'];
        }
        if (isset($postData['dbname'])) {
            $config['database'] = $postData['dbname'];
        }
        
        $txt = json_encode($config);
        $myfile = fopen("./conf/.conf", "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);

        $check = $this->check();
        if($check['error']){
            return 'err';
        } else {
            $this->loadQuery();
            return 'done';
        }

        // return $this->check();
        
    }

    private function validate($config){
        $errors = [];
        $requiredFields = [
            'dsn' => 'string',
            'hostname' => 'string',
            'username' => 'string',
            'password' => 'string',
            'database' => 'string',
            'dbdriver' => 'string',
            'dbprefix' => 'string',
            'pconnect' => 'boolean',
            'db_debug' => 'boolean',
            'cache_on' => 'boolean',
            'cachedir' => 'string',
            'char_set' => 'string',
            'dbcollat' => 'string',
            'swap_pre' => 'string',
            'encrypt' => 'boolean',
            'compress' => 'boolean',
            'stricton' => 'boolean',
            'failover' => 'array',
            'save_queries' => 'boolean'
        ];

        $mandatoryNonEmptyFields = ['hostname', 'username', 'password', 'database'];

        // Check if all required fields are present and validate their types
        foreach ($requiredFields as $field => $type) {
            if (!array_key_exists($field, $config)) {
                $errors[] = "Missing required config field: $field";
            } else {
                if (gettype($config[$field]) !== $type) {
                    $errors[] = "Field '$field' should be of type $type";
                }
                if (in_array($field, $mandatoryNonEmptyFields) && empty($config[$field])) {
                    $errors[] = "Field '$field' cannot be empty";
                }
            }
        }

        return $errors;
    }

    public function toDB($config){
        $db_column_mapping = array(
            'dsn' => 'dsn',
            'hostname' => 'hostname',
            'username' => 'username',
            'password' => 'password',
            'database' => 'database_name',
            'dbdriver' => 'dbdriver',
            'dbprefix' => 'dbprefix',
            'pconnect' => 'pconnect',
            'db_debug' => 'db_debug',
            'cache_on' => 'cache_on',
            'cachedir' => 'cachedir',
            'char_set' => 'char_set',
            'dbcollat' => 'dbcollat',
            'swap_pre' => 'swap_pre',
            'encrypt' => 'encrypt',
            'compress' => 'compress',
            'stricton' => 'stricton',
            'failover' => 'failover',
            'save_queries' => 'save_queries'
        );

        // Initialize transformed config array
        $transformed_config = array();

        // Transform keys according to mapping
        foreach ($config as $key => $value) {
            if (isset($db_column_mapping[$key])) {
                $transformed_config[$db_column_mapping[$key]] = $value;
            }
        }

        // Return the transformed config array
        return $transformed_config;
    }

    public function db($config = ""){
        if($config == ""){
            $config = $this->read();
        }
        $db = $this->load->database($config, TRUE);
        return $db;
    }

    public function check($config = ""){
        if($config == ""){
            $config = $this->read();
        }

        if($config['hostname'] == "" || $config['username'] == "" || $config['database'] == ""){
            $return['error'] = true;
            $return['reason'][] = "no database";
        } else {
            $err = $this->validate($config);
            $return = [];
            $return['error'] = true;
    
            if (!empty($err)) {
                $return['reason'] = $err;
            } else {
                $db = $this->db($config);
                if($db->conn_id) {
                    $return['error'] = false;
                } else {
                    $return['reason'][] = 'Unable connect to database';
                }
            }
        }
        return $return;

    }

    public function loadQuery(){
        $sql = file_get_contents("./conf/.sql");
        
        $sqls = explode(';', $sql);
        foreach($sqls as $statement){
            $this->db()->query($statement);
        }
    }
}