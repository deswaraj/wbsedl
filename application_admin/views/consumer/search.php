<?php $this->load->view('include/header'); ?>
<script>
            $(function() {
                var Phases = ["B", "R", "Y", "RYB"];
                var MeterType = ["ELECTRO MAGNETIC", "HYBRID", "STATIC"];
                var MeterLocation = ["INSIDE", "OUTSIDE", "UNDER STAIRCASE"];
                var SurveyComments = ["BILL NOT FOUND", "DISCONNECTED", "DOOR CLOSED","YELLOW CARD"];
                $("#Phase").autocomplete({source: Phases, minLength: 0});
                $("#MeterType").autocomplete({source: MeterType});
                $("#MeterLocation").autocomplete({source: MeterLocation});
                $("#SurveyComments").autocomplete({source: SurveyComments});
            });
        </script>
<script>
    var selectedSupply = "<?php echo $this->session->userdata('supp_name'); ?>";
    var selectedTown = "<?php echo $this->session->userdata('town'); ?>";
    var baseURL = "<?= base_url(); ?>";


    function updateSupply() {
        var town = $('#town').val();
        $.get(baseURL + "ajax/get-supplies/", {"town": town}, function(data) {
            if ($.isEmptyObject(data)) {
                alert('No Supply Name Found')
            } else {
                $("#supp_name").html('');
                $.each(data, function(index, elem) {
                    $("#supp_name").append('<option value="' + elem.ID + '" >' + elem.supplyName + '</option>')
                });
                $("#supp_name").prepend('<option value="" >Supply Name</option>');
            
            if(selectedSupply != '')
            {
                $('select').val(selectedSupply);
                $('select').attr('disabled','true');
            }
            }
        }, 'json')
    }
    function validate_search() {
        
        if ($('#town').val() == '') {
            alert('Please Enter Town Name');
            return false;
        }
        if ($('#supp_name').val() == '') {
            alert('Please Select Supply Name');
            return false;
        }
        return true;
//
//        if ($('#conid').val() == '' && $('#consum_no').val() == '' && $('#MeterNo').val() == '') {
//            alert('Please Enter Consumer no or Meter no ConID');
//            return false;
//        }

    }

    function validate_consumer_entry() {
        if ($('#PoleNo').val() == '' || $('#DTRCode').val() == '' || $('#SupplyName').val() == '' || $('#TownName').val() == '') {
            alert('Please Enter Mandatary Fields');
            return false;
        }
    }
    $(document).ready(function() {
        if ($('#town').val() != '') {
            $('#town').attr('disabled','true')
            updateSupply();
        }

    })
</script>
</head>
<body>
    <?php if(!isset($mode))$mode='add' ?>
<div id="wrap">
    <header class="white-bg">
        <div class="container">
            <div class="row"> 
                <div class="col-md-6"><a href="#" class="logo">Data Management System</a></div>
                <div class="col-md-6"> <a href="<?php echo base_url() . 'logout'; ?>" class="logout" title="Logout">
                        <button class="btn btn-link logout_btn">Log Out</button>
                    </a></div>
            </div>
        </div>
    </header>
    <div class="container bs-docs-container">
        <div class="message" >
            <p class="alert alert-success" style="display: <?php echo($this->session->userdata('errormsg') ? 'block' : 'none'); ?>"><?php echo $this->session->userdata('errormsg'); $this->session->unset_userdata('errormsg');  ?></p>
            <p class="alert alert-info" style="display: <?php echo($this->session->userdata('succmsg') ? 'block' : 'none'); ?>" ><?php echo $this->session->userdata('succmsg'); $this->session->unset_userdata('succmsg'); ?></p>
        </div>
        <div class="container">
            <form action="" method="post" onSubmit="return validate_search();" >
                <div class="row">
                    <div class="col-md-2 form-group">
                        <input class="form-control" placeholder="Town Name" type="text" id="town" name="town" value="<?php echo $this->session->userdata('town'); ?>" onChange="updateSupply();"/>
                    </div>
                    <div class="col-md-2 form-group">
                        <select class="form-control" name="supp_name" id="supp_name">
                            <option value="" >Supply Name</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <input placeholder="Con ID" value="<?php echo (isset($conid) ? $conid : ''); ?>" class="form-control" type="text" name="conid" id="conid" maxlength="9" />
                    </div>
                    <div class="col-md-2 form-group">
                        <input placeholder="Consumer No" value="<?php echo (isset($ConsumerNo) ? $ConsumerNo : ''); ?>" class="form-control" type="text" name="consum_no" id="consum_no" />
                    </div>
                    <div class="col-md-2 form-group">
                        <input placeholder="Meter No" value="<?php echo (isset($MeterNo) ? $MeterNo : ''); ?>" class="form-control" type="text" name="MeterNo" id="MeterNo" />
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="submit" class="btn btn-primary" name="search" value="Search" />
                    </div>
                </div>

            </form>
        </div>
        <p class="alert alert-danger" style="display: <?php if (empty($displayResult) || $mode == 'edit') echo 'none;'; ?>">
            <?php             if (isset($mode)) {                if ($mode == 'display')                    echo 'Data already entered';            }            ?>
        </p>
        <?php if (isset($search)): ?>
            <?php if (empty($displayResult)): ?>
                <div class="alert alert-warning" style="display: block">No record Found</div>
                 <form action="<?php  echo base_url() . 'consumer/update'; ?>" method="post" name="edit" class="" onSubmit="return validate_consumer_entry();" data-toggle="validator" >
                    <div class="">
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Town Name:<b style="color: red">*</b></label>
                            <input class="form-control" type="text" name="TownName" id="TownName" value="<?php  echo $this->session->userdata('town'); ?>" disabled="true" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Supply Name:<b style="color: red">*</b></label>
                            <input class="form-control" type="text" name="SupplyName" id="SupplyName" value="<?php  echo $this->consumer_model->get_supply_name_by_id($this->session->userdata('supp_name')); ?>" disabled="true" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Dtr Code:<b style="color: red">*</b></label>
                            <input class="form-control" type="text" name="DTRCode" id="DTRCode" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Pole No:<b style="color: red">*</b></label>
                            <input class="form-control" type="text" name="PoleNo" id="PoleNo" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Phase:</label>
                            <input class="form-control" type="text" name="Phase" id="Phase" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Con ID:</label>
                            <input class="form-control" type="text" name="ConID" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Consumer No.</label>
                            <input class="form-control" type="text" name="ConsumerNo" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Service Con No.</label>
                            <input class="form-control" type="text" name="ServiceConNo" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Consumer Name:</label>
                            <input class="form-control" type="text" name="ConsumerName" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Phone No.</label>
                            <input class="form-control" type="text" name="PhoneNo" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Apartment/Landmark/Locality:</label>
                            <input class="form-control" type="text" name="Apartment/Landmark/Locality" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Meter No.</label>
                            <input class="form-control" type="text" name="MeterNo" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Meter Make.</label>
                            <input class="form-control" type="text" name="MeterMake" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Meter Type:</label>
                            <input class="form-control" type="text" name="MeterType" id="MeterType" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Meter Location:</label>
                            <input class="form-control" type="text" name="MeterLocation" id="MeterLocation" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Survey Comments:</label>
                            <input class="form-control" type="text" id="SurveyComments" name="SurveyComments" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Customer Unique Code:</label>
                            <input class="form-control" type="text" name="ConsumerUniqueCode" value="" />
                        </div>
                         <div class="col-md-3 form-group" >
                            <label class="control-label" >MRU:</label>
                            <input class="form-control" type="text" name="mru" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Surveyor Name:</label>
                            <input class="form-control" type="text" name="SurveyorName" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Surveyor Code:</label>
                            <input class="form-control" type="text" name="SurveyorCode" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >CSS Name:</label>
                            <input class="form-control" type="text" name="CSSName" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Data Receiving Date:</label>
                            <input class="form-control" type="text" name="DataRetrivingDate" value="" />
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php  if ($mode == 'add'): ?><input  type="submit" class="btn btn-info" name="update" value="ADD" /><?php  endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php else : ?>

                <form action="<?php  echo base_url() . 'consumer/update'; ?>" method="post" name="edit" class="" onSubmit="return validate_consumer_entry();" data-toggle="validator" >
                    <div class="">
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Town Name:<b style="color: red">*</b></label>
                            <input class="form-control" type="text" name="TownName" id="TownName" value="<?php  echo $record['TownName']; ?>" disabled="true" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Supply Name:<b style="color: red">*</b></label>
                            <input class="form-control" type="text" name="SupplyName" id="SupplyName" value="<?php  echo $record['SupplyName']; ?>" disabled="true" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Dtr Code:<b style="color: red">*</b></label>
                            <input class="form-control" type="text" name="DTRCode" id="DTRCode" value="<?php  echo $record['DTRCode']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Pole No:<b style="color: red">*</b></label>
                            <input class="form-control" type="text" name="PoleNo" id="PoleNo" value="<?php  echo $record['PoleNo']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Phase:</label>
                            <input class="form-control" type="text" name="Phase" id="Phase" value="<?php  echo $record['Phase']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Con ID:</label>
                            <input class="form-control" type="text" name="ConID" value="<?php  echo $record['ConID']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Consumer No.</label>
                            <input class="form-control" type="text" name="ConsumerNo" value="<?php  echo $record['ConsumerNo']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Service Con No.</label>
                            <input class="form-control" type="text" name="ServiceConNo" value="<?php  echo $record['ServiceConNo']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Consumer Name:</label>
                            <input class="form-control" type="text" name="ConsumerName" value="<?php  echo $record['ConsumerName']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Phone No.</label>
                            <input class="form-control" type="text" name="PhoneNo" value="<?php  echo $record['PhoneNo']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Apartment/Landmark/Locality:</label>
                            <input class="form-control" type="text" name="Apartment/Landmark/Locality" value="<?php  echo $record['address']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Meter No.</label>
                            <input class="form-control" type="text" name="MeterNo" value="<?php  echo $record['MeterNo']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Meter Make.</label>
                            <input class="form-control" type="text" name="MeterMake" value="" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Meter Type:</label>
                            <input class="form-control" type="text" name="MeterType" id="MeterType" value="<?php  echo $record['MeterType']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Meter Location:</label>
                            <input class="form-control" type="text" name="MeterLocation" id="MeterLocation" value="<?php  echo $record['MeterLocation']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Survey Comments:</label>
                            <input class="form-control" type="text" id="SurveyComments" name="SurveyComments" value="<?php  echo $record['SurveyComments']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Customer Unique Code:</label>
                            <input class="form-control" type="text" name="ConsumerUniqueCode" value="<?php  echo $record['ConsumerUniqueCode']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >MRU:</label>
                            <input class="form-control" type="text" name="mru" value="<?php  echo (isset($record['mru'])?$record['mru']:''); ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Surveyor Name:</label>
                            <input class="form-control" type="text" name="SurveyorName" value="<?php  echo $record['SurveyorName']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Surveyor Code:</label>
                            <input class="form-control" type="text" name="SurveyorCode" value="<?php  echo $record['SurveyorCode']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >CSS Name:</label>
                            <input class="form-control" type="text" name="CSSName" value="<?php  echo $record['CSSName']; ?>" />
                        </div>
                        <div class="col-md-3 form-group" >
                            <label class="control-label" >Data Receiving Date:</label>
                            <input class="form-control" type="text" name="DataRetrivingDate" value="<?php  echo $record['DataRetrivingDate']; ?>" />
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php  if ($mode == 'edit'): ?><input  type="submit" class="btn btn-info" name="update" value="Update" /><?php  endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
            <div class="row">
                <div class="text-center" style="display: <?php  if ($mode != 'edit') echo 'none;'; ?>"><strong><span style="color:red;">*</span>Mandatory Field</strong></div>
            </div>
                    <?php endif; ?>

        </div>

</div>

    <?php $this->load->view('include/footer'); ?>
