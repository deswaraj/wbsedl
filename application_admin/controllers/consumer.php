<?php

class Consumer extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('consumer_model');
    }

    function index() {
        if (!$this->session->userdata('usermail'))
            redirect(base_url());
        $data = array();
        if ($this->input->post('search')) {
//            print_r($_POST);
            if($this->session->userdata('town')){
                $this->consumer_model->TownName = $this->session->userdata('town');
            }else if ($this->input->post('town'))
            {
                if(!$this->session->userdata('town'))
                $this->session->set_userdata('town',$this->input->post('town'));    
                 $this->consumer_model->TownName = $this->session->userdata('town');
            }else
            
                $this->session->userdata('supp_name');
            if($this->session->userdata('supp_name')){
                $this->consumer_model->SupplyName = $this->session->userdata('supp_name');
            }
            else if ($this->input->post('supp_name'))
            {
                 if(!$this->session->userdata('supp_name'))
                $this->session->set_userdata('supp_name',$this->input->post('supp_name'));
                $this->consumer_model->SupplyName = $this->session->userdata('supp_name');
            }
            
            if ($this->input->post('conid'))
                $data['conid'] = $this->consumer_model->ConID = $this->input->post('conid');

            if ($this->input->post('consum_no'))
               $data['ConsumerNo'] =  $this->consumer_model->ConsumerNo = $this->input->post('ConsumerNo');

             if ($this->input->post('MeterNo'))
             { 
                 $data['MeterNo'] = $this->consumer_model->MeterNo = $this->input->post('MeterNo');
                 
             }
            //search index table
//            echo '<pre>';
            $result_index = $this->consumer_model->get_consumer_from_index();
//            print_r($result);
            if ($result_index->num_rows()) {
                $result = $result_index->result_array();
                $data['record'] = $result[0];
                $data['mode'] = 'display';
                $data['displayResult'] = 1;
            } else {
                $result_master = $this->consumer_model->get_consumer_from_master();
                if ($result_master->num_rows()) {
                    $result = $result_master->result_array();
                    $data['record'] = $result[0];
                    $data['mode'] = 'edit';
                    $data['displayResult'] = 1;
                } else {
                    $data['displayResult'] = 0;
                }
            }
            $data['search'] = TRUE;
        }
        $this->load->view('consumer/search.php', $data);
    }

    function update() {
        if (!$this->session->userdata('usermail'))
            redirect(base_url());
        
        if ($this->input->post('update')) {
            $this->load->library('form_validation');
//            print_r($this->input->post());
            $TownName = $this->session->userdata('town');
            $SupplyName = $this->session->userdata('supp_name');
            $DTRCode = $this->input->post('DTRCode');
            $PoleNo = $this->input->post('PoleNo');
            $Phase = $this->input->post('Phase');
            $ConID = $this->input->post('ConID');
            $ConsumerNo = $this->input->post('ConsumerNo');
            $ServiceConNo = $this->input->post('ServiceConNo');
            $ConsumerName = $this->input->post('ConsumerName');
            $PhoneNo = $this->input->post('PhoneNo');
            $address = $this->input->post('Apartment/Landmark/Locality');
            $MeterNo = $this->input->post('MeterNo');
            $MeterMake = $this->input->post('MeterMake');
            $MeterType = $this->input->post('MeterType');
            $MeterLocation = $this->input->post('MeterLocation');
            $SurveyComments = $this->input->post('SurveyComments');
            $ConsumerUniqueCode = $this->input->post('ConsumerUniqueCode');
            $mru = $this->input->post('mru');
            $SurveyorName = $this->input->post('SurveyorName');
            $SurveyorCode = $this->input->post('SurveyorCode');
            $CSSName = $this->input->post('CSSName');
            $DataRetrivingDate = $this->input->post('DataRetrivingDate');

            $error_msg = '';
            //validation 
            if (!$this->form_validation->required($TownName))
                echo $error_msg = 'Town Name Required';
            elseif (!$this->form_validation->required($SupplyName))
                echo $error_msg = 'Supply Name Required';
            elseif (!$this->form_validation->required($DTRCode))
                $error_msg = 'DTR Code Required';
            elseif (!$this->form_validation->required($TownName))
                $error_msg = 'Pole No Required';
                
//            echo $error_msg;
//            print_r($this->form_validation->required($SupplyName));
                if (empty($error_msg)) {
                    $array['TownName'] = $TownName;
                    $array['SupplyName'] = $SupplyName;
                    $array['DTRCode'] = $DTRCode;
                    $array['PoleNo'] = $PoleNo;
                    $array['Phase'] = $Phase;
                    $array['ConID'] = $ConID;
                    $array['ConsumerNo'] = $ConsumerNo;
                    $array['ServiceConNo'] = $ServiceConNo;
                    $array['ConsumerName'] = $ConsumerName;
                    $array['PhoneNo'] = $PhoneNo;
                    $array['address'] = $address;
                    $array['MeterNo'] = $MeterNo;
                    $array['MeterMake'] = $MeterMake;
                    $array['MeterType'] = $MeterType;
                    $array['MeterLocation'] = $MeterLocation;
                    $array['SurveyComments'] = $SurveyComments;
                    $array['ConsumerUniqueCode'] = $ConsumerUniqueCode;
                    $array['MRU'] = $mru;
                    $array['SurveyorName'] = $SurveyorName;
                    $array['SurveyorCode'] = $SurveyorCode;
                    $array['CSSName'] = $CSSName;
                    $array['DataRetrivingDate'] = $DataRetrivingDate;
                    $array['EntryOperatorID'] = $this->session->userdata('usermail');
                    $array['EntryTime'] = date("Y-m-d H:i:s");

                    $this->consumer_model->insert_consumer_index($array);
                    $this->session->set_userdata('succmsg', 'Data Inserted Successfully');
                    redirect(base_url());
                } else {
                    
                }
        }
    }

}
?>

