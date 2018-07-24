<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Project Management System...</title>
  <!-- Bootstrap core CSS-->
  <link href="<?= CSS_URL;?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= CSS_URL;?>vendor/bootstrap/css/bootstrap-theme.css" rel="stylesheet">

  <!-- intro Tour Style -->
  <link href="<?= CSS_URL;?>vendor/intro/css/introjs.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="<?= CSS_URL;?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="<?= CSS_URL;?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?= CSS_URL;?>css/sb-admin.css" rel="stylesheet">
  
  <script src="<?= CSS_URL;?>vendor/jquery/jquery.js"></script>
  <!--search for select box-->
  <link rel="stylesheet" href="<?= CSS_URL;?>search/sol.css">
  <link rel="stylesheet" href="<?= CSS_URL;?>style.css">
  <link rel="stylesheet" href="<?= CSS_URL;?>responsive.css">
  <script>
  var SCRIPT_URL = "<?= SITE_URL;?>";
  </script>
  
  <style>
/*.bg-dark{
	background:url(<?= SITE_URL;?>image/full_1.jpg);
}*/
</style>
  
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <?php
  $companyID = $this->session->userdata('companyID');
  $info = $this->user_model->companyInfo($companyID);
  $head = '<h3>Tool tip header is here... </h3>';
  $lorem = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s <br/> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s';
  ?>
  <div class="main_content" id="wrapper">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="body_content">
	<a class="navbar-brand" href="#"> <img src="<?= SITE_URL;?>image/<?= $info[0]->C_LOGO;?>" alt="<?= $info[0]->C_COMPANY_NAME;?>"/></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive1">
      <?php $userType = $this->session->userData('userType'); ?>
	  
     <!-- <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>-->
      <ul class="navbar-nav ml-auto">
       
        <!--<li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>-->
		<?php
		$userName = $_SESSION['userName'];
		$adminName = $_SESSION['adminName'];
		
		?>
		<li class="nav-item">
         <h6 class="dropdown-header"><i class="fa fa-fw fa-user"></i> <?= $userName;?> </h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
    </div>
  </nav>
  <div class="content-wrapper">
	<div class="body_content">
	<div class="row">
	<div class="col-md-3">
	<nav class=" navbar-expand-lg navbar-dark bg-dark fixed-bottom1" id="mainNav">
	<div class="collapse navbar-collapse" id="navbarResponsive">
	<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="<?= SITE_URL;?>dashboard/">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text"><?= $userType;?> Dashboard</span>
          </a>
        </li>
		
		 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="1" data-intro=" <?= $head;?> Press/Click For View All Projes Here..! <?= $lorem;?>" >
          <a class="nav-link" href="<?= SITE_URL;?>dashboard/view_project/">
            <i class="fa fa-fw fa-files-o"></i>
            <span class="nav-link-text">View Project</span>
          </a>
        </li>
		<?php
		if($userType == 'Admin'){
		?>
        <li id="panel2" class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="2" data-intro=" <?= $head;?> You May Satrt New Project Click by Link.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>dashboard/add_project/">
            <i class="fa fa-fw fa-plus"></i>
            <span class="nav-link-text">New Project</span>
          </a>
        </li>
		<?php } ?>
		
		<li id="panel3" class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="3" data-intro="<?= $head;?> You May View And Satrt Milestones Click by Link.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>dashboard/milestones/">
            <i class="fa fa-fw fa-file-text"></i>
            <span class="nav-link-text">Milestones</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="4" data-intro="<?= $head;?> You May View All Documents Click by Link.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>dashboard/documents/">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Documents</span>
          </a>
        </li>
		<?php
		if($userType == 'Client'){
		?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="5" data-intro="<?= $head;?> You May View Team Details Click by Link.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>setup/team_details/">
            <i class="fa fa-fw fa-building-o"></i>
            <span class="nav-link-text">Team Details</span>
          </a>
        </li>
		<?php } 
		if($userType != 'Member'){
		?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="6" data-intro="<?= $head;?> You May View your personal Details Click by Link.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>dashboard/your_details/">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Your Details</span>
          </a>
        </li>
		<?php
		}
		if($userType == 'Admin'){
		?>
       <li class="nav-item devidated" data-toggle="tooltip" data-placement="right" title="Charts"></li>
	   <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="7" data-intro="<?= $head;?> You May Add New Project Type here.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>setup/project_type/">
            <i class="fa fa-fw fa fa-product-hunt"></i>
            <span class="nav-link-text">Add Project Type</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="8" data-intro="<?= $head;?> You May Add New Field Type here.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>setup/filed_item/">
            <i class="fa fa-fw fa-files-o"></i>
            <span class="nav-link-text">Add Filed Item</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="9" data-intro="<?= $head;?> You May Add New Client here.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>setup/add_user/">
            <i class="fa fa-fw fa-plus"></i>
            <span class="nav-link-text">Add Client</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts" data-step="10" data-intro="<?= $head;?> You May Set Company here.! <?= $lorem;?>">
          <a class="nav-link" href="<?= SITE_URL;?>setup/company_setting/">
            <i class="fa fa-fw fa-eye"></i>
            <span class="nav-link-text">Company Setting</span>
          </a>
        </li>
        <?php }?>
		
		 <li class="nav-item responsive_logout">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
       <!-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Report</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseExamplePages">
            <li>
              <a href="<?= SITE_URL;?>report/active_domain/">Active Domain</a>
            </li>
            
          </ul>
        </li>-->

      </ul>
	  </div>
	  </nav>
	  </div>
	  <div class="col-md-9">