<?php
class Consumer_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    public $TownName = '';
    public $SupplyName = '';
    public $ConID = null;
    public $ConsumerNo = '';
//    public $ServiceConnNo = '';
    public $MeterNo = '';
            
    function is_valid_usr($usermail,$password){
        $this->db->select('id')
                ->from('user')
                ->where("email ='".$usermail."' AND password='".$password."'")
                ;
        $res = $this->db->get();
        $row = $res->num_rows();
        return $row;
    }
    
    function get_consumer_from_master() {
        $this->db->select("cm.TownName as TownName,cm.supplyName as SupplyName,cm.DTRCode as DTRCode,cm.PoleNo as PoleNo,cm.Phase as Phase,cm.ConID as ConID,cm.ConsumerNo as ConsumerNo,cm.ServiceConNo as ServiceConNo,cm.ConsumerName as ConsumerName,cm.PhoneNo PhoneNo,cm.address as address,cm.MeterNo as MeterNo,cm.MeterType as MeterType,cm.MeterLocation as MeterLocation,cm.SurveyComments as SurveyComments,cm.ConsumerUniqueCode as ConsumerUniqueCode,cm.SurveyorName as SurveyorName,cm.SurveyorCode as SurveyorCode,cm.CSSName as CSSName,cm.DataRetrivingDate as DataRetrivingDate")
                 ->from('consumer_master as cm')
                ->join('supplyname as sn',"cm.SupplyName=sn.supplyName");
        if($this->TownName != '')
        {
            $this->db->where("cm.TownName = '".$this->TownName."'");
        }
        if($this->SupplyName != '')
        {
            $this->db->where("sn.ID = ".$this->SupplyName."");
        }
        if($this->ConID != '')
        {
            $this->db->where("cm.ConID = '".$this->ConID."'");
        }else {
             $this->db->where("cm.ConID = null");
        }
        if($this->ConsumerNo != '')
        {
            $this->db->where("cm.ConsumerNo = '".$this->ConsumerNo."'");
        }
//        if($this->ServiceConnNo != '')
//        {
//            $this->db->where("ServiceConNo = '".$this->ServiceConnNo."'");
//        }
         if($this->MeterNo != '')
        {
            $this->db->where("cm.MeterNo = '".$this->MeterNo."'");
        }
        $res = $this->db->get();
//        $res->num_rows();
//        echo $this->db->last_query();   
        return $res;
    }
    
    
      function get_consumer_from_index() {
        $this->db->select("ci.TownName as TownName,sn.supplyName as SupplyName,ci.DTRCode as DTRCode,ci.PoleNo as PoleNo,ci.Phase as Phase,ci.ConID as ConID,ci.ConsumerNo as ConsumerNo,ci.ServiceConNo as ServiceConNo,ci.ConsumerName as ConsumerName,ci.PhoneNo PhoneNo,ci.address as address,ci.MeterNo as MeterNo,ci.MeterType as MeterType,ci.MeterLocation as MeterLocation,ci.SurveyComments as SurveyComments,ci.ConsumerUniqueCode as ConsumerUniqueCode,ci.mru as mru,ci.SurveyorName as SurveyorName,ci.SurveyorCode as SurveyorCode,ci.CSSName as CSSName,ci.DataRetrivingDate as DataRetrivingDate,ci.EntryOperatorID as EntryOperatorID,ci.EntryTime as EntryTime  ")
                ->from('consumer_index as ci')
                ->join("supplyname as sn","ci.SupplyName=sn.ID");
        if($this->TownName != '')
        {
            $this->db->where("ci.TownName = '".$this->TownName."'");
        }
        if($this->SupplyName != '')
        {
            $this->db->where("sn.ID = ".$this->SupplyName."");
        }
        if($this->ConID != '')
        {
            $this->db->where("ci.ConID = '".$this->ConID."'");
        }  else {
             $this->db->where("ci.ConID = null");
        }
        if($this->ConsumerNo != '')
        {
            $this->db->where("ci.ConsumerNo = '".$this->ConsumerNo."'");
        }
        
         if($this->MeterNo != '')
        {
            $this->db->where("ci.MeterNo = '".$this->MeterNo."'");
        }
//        if($this->ServiceConnNo != '')
//        {
//            $this->db->where("ServiceConNo = '".$this->ServiceConnNo."'");
//        }
        
        $res = $this->db->get();
//        echo $res->num_rows();
//        echo '<br />'.$this->db->last_query().'<br />';
        return $res;
    }
    
    
    function get_supplies($town) {
        $this->db->select("supplyName,ID")
                ->from('supplyname')
                ->where("town",$town);
        $res = $this->db->get();
        return $res->result();
    }
    
    function get_supply_name_by_id($id){
         $this->db->select("supplyName")
                ->from('supplyname')
                ->where("id",$id);
        $res = $this->db->get();
        return $res->row()->supplyName;
    }
    
    
    
    function insert_consumer_index($data){
        $this->db->insert('consumer_index',$data);
    }
    
}