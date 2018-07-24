
 <?php require('include/header.php');?>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> My Dashboard</div>
        <div class="card-body">
		<?php
			$userName = $this->session->userdata('userName');
		?>
          <p>Welcome to <b><?= $userName;?></b> ! Let’s get your project uderway </p>
        </div>
       
      </div>
	  	 <?php require('include/footer.php');?>