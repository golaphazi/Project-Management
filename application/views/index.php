
 <?php require('include/header.php');?>


 <div class="card mb-3" style="margin:10px;">
 	<div class="card-header">
 		<i class="fa fa-table"></i> My Dashboard</div>
 		<div class="card-body">
 			<?php
 			$userName = $this->session->userdata('userName');
 			?>
 		</div> <!-- end of card-body -->
 		<!-- <div class="notification">
 			<img src="https://cdn4.iconfinder.com/data/icons/colicon/24/close_delete-24.png" class="close" alt=""/>
 			<article>
	 			</p>Welcome to <b><?= $userName;?></b> ! Let’s get your project uderway </p>
	 			<a href="<?= SITE_URL; ?>dashboard/view_project/">Go to View Projest</a> 
	 			<span class="btn-pmt-tour" href="javascript:void(0);" onclick="javascript:introJs().start();">Click to tour about the software </span>
 			</article>  
 		</div> -->



 		<!--Start modal -->
 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-dialog">
 				<div class="modal-content ">
 					<div class="modal-header">
 						<h4 class="modal-title pmt-modal-title" id="myModalLabel">Underway Project Management Tools...</h4>
 						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
 					</div>
 					<div class="modal-body pmt-modal-body text-center">
 						<p class="login-welcome-msg">Welcome to <b><?= $userName;?></b> ! Let’s get your project uderway </p>
 						<span class="btn-pmt-tour" href="javascript:void(0);" onclick="javascript:introJs().start();" data-dismiss="modal">Click to tour about the software </span>
 					</div>
 					<div class="modal-footer">
 						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 						<a class="btn btn-primary" href="<?= SITE_URL; ?>dashboard/view_project/">Go to View Projest</a>
 					</div>
 				</div>
 			</div>
 		</div><!-- End of modal -->

 	</div> <!-- end of card -->

<?php require('include/footer.php');?>



  