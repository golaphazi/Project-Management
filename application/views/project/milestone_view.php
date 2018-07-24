 <?php require('include/header.php');?>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Milestone List
		 </div>
        <div class="card-body row">
          <div class="table-responsive" style="width:100%;">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL</th>
                  <th>Milestone Name</th>
                  <th>Date</th>
                  <th>Price</th>
                  <th>Payment</th>
                  <th>Status</th>
                  <th>Invoice</th>
                 
                </tr>
              </thead>
              
			  <tbody>
			   <?php
				
				if(is_array($dataArrayMile) AND sizeof($dataArrayMile) > 0){
					$i = 1;
					foreach($dataArrayMile AS $data){
						
				?>
					 <tr>
					  <td align="center"><?= $i; ?></td>
					  <td> <a href="<?= SITE_URL;?>dashboard/milestones/<?= $data->PROJECT_ID; ?>/<?= $data->MILESTON_ID; ?>/" title="View Massage"><?= $data->MILESTONE_DETAILS; ?> </a></td>
					   <td><?= $this->user_model->date_format_orginal($data->ENT_DATE); ?></td>
					  <td>&euro; <?= $data->PRICE; ?></td>
					  <td><?= $data->PAYMENT_STATUS; ?></td>
					  <td><?= $data->MILESTONE_STAUTS; ?></td>
					  <td align="center"><a href="<?= SITE_URL;?>dashboard/invoice/<?= $data->PROJECT_ID; ?>/<?= $data->MILESTON_ID; ?>/" title="View Invoice"> <i class="fa fa-file"> </a></td>
					  
					</tr>
				<?php
					$i++;
					}
				}else{
					echo '<tr><td colspan="6"> No Milestone found</td></tr>';
				}
			  ?>
              </tbody>
               
                
            </table>
          </div>
        </div>
  </div>
  <?php if($milestonID > 0){
	$miles = $this->user_model->milestoneInfo($getID,$milestonID);  
	if(is_array($miles) AND sizeof($miles) > 0){
	?>
  <div class="card mb-3" style="margin:10px;">
		<div class="card-header" id="massage">
			 Milestone No:  <?= substr($miles[0]->MILESTONE_DETAILS, 0, 50)?> 
			  
		</div>
			<?php
				$userID = $this->session->userdata('userID');
				if(is_array($dataArrayMassage) AND sizeof($dataArrayMassage) > 0){
					$i = 1;
					foreach($dataArrayMassage AS $dataMass){
					$checkUser = $dataMass->ENT_USER;
					
					if($userID == $checkUser){
						$userClass = 'main_background';
					}else{
						$userClass = 'sub_background';
					}
				?>
				<div class="col-md-12 close_div_for_massage <?= $userClass;?> " id="massage<?= $dataMass->MASSAGE_ID;?>">
					<div class="row card-body" style="padding-bottom:0px;">
						<div class="col-md-12">
							<div class="form-group">
								 <div class="form-row" style="display: block;">
								 <?php
								 $info =	$this->user_model->userInfo($dataMass->ENT_USER); 
								 
								 
								$date1 = new DateTime($dataMass->ENT_DATE.' '.$dataMass->ENT_TIME);
								$date2 = new DateTime(date("Y-m-d h:i:s"));
								$interval = $date1->diff($date2);
								
								//echo $dataMass->ENT_DATE.' '.$dataMass->ENT_TIME .' - '.date("Y-m-d h:i:s");
								
								
								$year = $interval->y;
								$month = $interval->m;
								$days = $interval->d;
								$hours = $interval->h;
								$minute = $interval->i;
								$seceond = $interval->s;
									
									
								 ?>
								 <div style="float:left;font-weight:bold;">
									<?php
									if($info[0]->ADMIN_TYPE == 'Admin'){
									?>
									<img src="<?= SITE_URL;?>image/ico22.png" alt="Admin">
									<?php
									}else if($info[0]->ADMIN_TYPE == 'Member'){
									?>
									<img src="<?= SITE_URL;?>image/ico21.png" alt="Member">
									<?php
									}else{
									?>
									<img src="<?= SITE_URL;?>image/ico23.png" alt="Client">
									<?php
									}
									?>
									<?= $info[0]->ADMIN_NAME;?>  &nbsp;
								 </div>
								
								 <div style="float:right;font-weight:bold; font-size:11px; line-height: 4em;"> 
									<?php
										if($year > 0){
											echo $year. ' years, ';
										}
									?>
									<?php
										if($month > 0){
											echo $month. ' months, ';
										}
									?>
									
									<?php
										if($days > 0 AND $year <= 0){
											echo ''.$days. ' days, ';
										}
									?>
									<?php
										if($hours > 0 AND $year <= 0 AND $month <= 0){
											echo ''.$hours. ' hours, ';
										}
									?>
									<?php
										if($minute > 0 AND $year <= 0 AND $month <= 0){
											echo ''.$minute. ' minutes, ';
										}
									?>
									
									<?php
										if($seceond >= 0 AND $year <= 0 AND $month <= 0 AND $days <= 0){
											echo ''.$seceond. ' sec ';
										}
										
										echo 'ago';
									?>
								 </div>
								 </div>
							</div>
						
						</div>
						
						<div class="col-md-12">
							 <div class="form-group">
								<pre class="massage_body"  style="display: block;margin-top:10px;"><?= $dataMass->MASSAGE_BODY; ?></pre>
								<?php if(strlen($dataMass->ATTACH_FILE) > 15){?>
								<a href="<?= SITE_URL;?>dashboard/download/?file=<?= $dataMass->ATTACH_FILE;?>" target="_blank"> <?= substr($dataMass->ATTACH_FILE, 26, 100); ?> </a>
								<?php }?>
							</div>
						</div>
					</div>
				</div>
				
				<?php
						$i++;
					}
				}else{
					echo '<span style="padding:20px;">No massage </span>';
				}
				?>
	</div>	
  <?php }
  }
  ?>
	  	 <?php require('include/footer.php');?>