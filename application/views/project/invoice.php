 <?php 
 if($pdf != 'pdf'){
	require('include/header.php');
 }
 ?>  
  <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Invoice of project 
		  <a href="<?= SITE_URL;?>dashboard/invoice/<?= $projectId;?>/<?php if($miles > 0){echo$miles.'/';}?>?get=pdf" target="_blank" style="color:#fff; float:right;"> <span class="fa fa-file-pdf-o"></span> </a>
		  <a href="<?= SITE_URL;?>dashboard/invoice/<?= $projectId;?>/<?php if($miles > 0){echo$miles.'/';}?>?get=pdf&save=download" target="_blank" style="color:#fff; float:right; margin-right:20px;"> <span class="fa fa-download"></span> </a>
			
		</div>
        <div class="card-body">
			<div class="row">
				<div class="col-md-12">
				<header>
						<h1 class="header">INVOICE</h1>
					</header>
					
				</div>
				 
				<?php
				$company = $this->user_model->companyInfo();
				?>
				
				
				<div class="col-md-8" style="padding-top:15px;">
					<span class="project_name_invoice"><?= $dataArray[0]->PROJECT_NAME;?> </span>
				</div>
				 <div class="col-md-4" style="padding-top:15px;">
					<p> <b>Invoice : </b> <?= $dataArray[0]->REF;?></p>
					<p> <b>Date : </b> <?= $this->user_model->date_format_orginal($dataArray[0]->ENT_DATE);?></p>
					<p> <b>Paid Amount : </b> &euro; <?= number_format($dataArray[0]->PRICE);?></p>
				 </div>
				<div class="col-md-12" style="padding-top:25px;" >
					<div class="table-responsive">
						<table class="table table-bordered" width="100%" cellspacing="0">
						  <thead>
							<tr>
							  <th><?php  $projectType = $dataArray[0]->BID_TYPE; if($projectType == 'Milestone'){ echo 'Milestone Name';}else{echo 'Project Name';}?></th>
							  <th>Rate</th>
							  <th>Quantity</th>
							  <th>Date</th>
							  <th>Payment</th>
							  <th>Price</th>
							  
							</tr>
						  </thead>
						  
						  <tbody>
						  <?php
						  $Net_price = 0;
						 
						  if($projectType == 'Milestone'){
							$milses = $this->user_model->milestoneInfo($dataArray[0]->PROJECT_ID, $miles);
							foreach($milses AS $values):
							 $Net_price1 = $values->PRICE;
						?>

						<tr>
								<td> <?= $values->MILESTONE_DETAILS; ?>  </td>
								<td> &euro; <?= number_format($values->PRICE);?>  </td>
								<td> <center>1 </center> </td>
								<td> <?= $this->user_model->date_format_orginal($values->ENT_DATE);?>  </td>
								<td> <?= $values->PAYMENT_STATUS; ?>  </td>
								<td> &euro; <?= number_format($Net_price1);?>  </td>
							</tr>
							
						<?php
							$Net_price += $Net_price1;
							endforeach;
						  }else{
						  $Net_price = $dataArray[0]->PRICE;
						  ?>
							<tr>
								<td> <?= $dataArray[0]->PROJECT_NAME; ?>  </td>
								<td> &euro; <?= number_format($dataArray[0]->PRICE);?>  </td>
								<td> <center>1 </center> </td>
								<td> <?= $this->user_model->date_format_orginal($dataArray[0]->ENT_DATE);?>  </td>
								<td> &euro; <?= number_format($Net_price);?>  </td>
							</tr>
						  <?php }?>
						  </tbody>
					 </table>
				</div>
				</div>
				<div class="col-md-6" style="padding-top:15px;"></div>
				<div class="col-md-6" style="padding-top:15px; ">
					<div class="table-responsive">
						<table class="table table-bordered" width="100%" cellspacing="0">
							<tr>
								<td><b>Sub Total : </b> </td> <td> &euro; <?= number_format($Net_price);?> </td></tr>
							<tr>	
								<td><b>VAT @ <?= $company[0]->C_VAT;?>% : </b> </td> <td> &euro; <?php $vat = ($Net_price / 100) * $company[0]->C_VAT; echo number_format($vat);?> </td></tr>
							<tr>	
								<td><b>Total : </b> </td> <td> &euro; <?= number_format($Net_price + $vat);?> </td></tr>
							<tr>	
								<td><b>Due Amount : </b> </td> <td> &euro; 0 </td>
							</tr>
						</table>
					</div>
					
				 </div>
				 <div class="col-md-12" style="padding-top:25px;">
					<h3> <?= $company[0]->C_COMPANY_NAME;?><span style="font-size:13px;"> <?= $company[0]->C_SUB_TITLE;?></span></h3>
					
				</div>
				<div class="col-md-12" style="padding-top:5px;">
					<?php if(strlen($company[0]->C_PHONE_NUM) > 2){?><p><b>Phone: </b><?= $company[0]->C_PHONE_NUM;?></p> <?php }?>
					<?php if(strlen($company[0]->C_EMAIL) > 2){?><p><b>Email: </b><?= $company[0]->C_EMAIL;?></p> <?php }?>
					<?php if(strlen($company[0]->C_ADDRESS) > 5){?><p><b>Address: </b> <i><?= $company[0]->C_ADDRESS;?> </i></p> <?php }?>
				</div>
				
			</div>
			
			</div>
			
			
	</div>
	
		
 <?php 
  if($pdf != 'pdf'){
	require('include/footer.php');
 }
?>