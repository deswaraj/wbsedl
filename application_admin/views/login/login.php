<?php $this->load->view('include/header'); ?>
</head>
<body>
<div id="wrap">
<div class="container">
  <form action="" method="post" class="form-signin">
    <h2 class="form-signin-heading">WBSEDL Login</h2>
    <div class="message" >
      <p class="success" style="display: <?php echo($this->session->userdata('errormsg')?'block':'none'); ?>"><?php echo $this->session->userdata('errormsg'); $this->session->unset_userdata('errormsg'); ?></p>
      <p class="danger" style="display: <?php echo($this->session->userdata('succmsg')?'block':'none'); ?>" ><?php echo $this->session->userdata('succmsg'); $this->session->unset_userdata('succmsg'); ?></p>
    </div>
    <input type="text" class="form-control" placeholder="Username" required id="usermail" name="usermail" >
    <input type="password" class="form-control" placeholder="Password" required id="password" name="password">
    <input type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="Log in">
  </form>
</div>
</div>
<?php $this->load->view('include/footer'); ?>
