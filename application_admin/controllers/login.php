<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
    }

    function index() {
        if($this->session->userdata('usermail'))
                        redirect(base_url().'consumer');
        $data = array();
        if ($this->input->post('submit')) {
            $usermail = $this->input->post('usermail');
            $password = $this->input->post('password');
            if ($this->login_model->is_valid_usr($usermail, $password)) {
                $this->session->set_userdata('usermail', $usermail);
                
                //insert login tbl
                $array= array();
                $array['user_id'] = $usermail;
                $array['login_time'] = date('Y-m-d H:i:s');
                $array['ip'] = getenv('REMOTE_ADDR');
                
                $this->login_model->insert_login($array);
                redirect(base_url()."consumer");
            } else {
                $this->session->set_userdata('errormsg', 'Invalid Login credential');
            }
        }
        $this->load->view('login/login.php', $data);
    }
    
    function logout() {
        $this->session->unset_userdata('usermail');
        $this->session->sess_destroy();
        
        $this->session->set_userdata('succmsg','Logged Out Successfully');
        redirect(base_url());
    }

}
?>

