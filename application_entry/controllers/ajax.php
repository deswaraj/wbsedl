<?php

class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('consumer_model');
    }

    function get_supplies() {
        $response = $this->consumer_model->get_supplies($this->input->get('town'));
        echo json_encode($response);
    }

}
?>

