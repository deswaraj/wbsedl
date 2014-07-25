<?php
class Login_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    function is_valid_usr($usermail,$password){
        $this->db->select('id')
                ->from('user')
                ->where("email ='".$usermail."' AND password='".$password."'")
                ;
        $res = $this->db->get();
        $row = $res->num_rows();
        return $row;
    }
    
    function insert_login($data) {
         $this->db->insert('user_login',$data);
    }
}