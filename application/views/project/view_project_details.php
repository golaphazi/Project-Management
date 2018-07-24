 <?php require('include/header.php');?>

     <div class="card mb-3" style="margin:10px;">

     	<div class="card-header">
     		<i class="fa fa-table"></i> Project Details
     	</div>
     	<div class="card-body row">
     		<div class="col-md-6">
     			<div class="form-group">
     				<div class="form-row">
     					<label for="exampleInputName"> Project Name :  </label>
     					<?= $dataArray[0]->PROJECT_NAME;?>
     				</div>
     			</div>
     		</div>

     		<div class="col-md-6">
     			<div class="form-group">
     				<div class="form-row">
     					<label for="exampleInputName">Website Address :  </label>
     					<?= $dataArray[0]->WEBSITE_URL;?>
     				</div>
     			</div>
     		</div>
     		<?php
     		$dynai = $this->user_model->showDynamicFiled($dataArray[0]->PROJECT_TYPE);
     		if(is_array($dynai) AND sizeof($dynai) > 0){
     			foreach($dynai as $value):
     				$filed = $value->FILED_NAME;
     				$title = $value->FIELD_TITLE;
     				?>
     				<?php if(strlen($dataArray[0]->$filed) > 1){?>	
     				<div class="col-md-6">
     					<div class="form-group">
     						<div class="form-row">
     							<label for="exampleInputName"> <?= $title;?> :  </label>
     							<?= $dataArray[0]->$filed;?>
     						</div>
     					</div>
     				</div>
     				<?php }?>
     				<?php 
     			endforeach;
     		}
     		?>

     		<?php if($dataArray[0]->START_DATE_PRO != '0000-00-00'){?>	
     		<div class="col-md-6">
     			<div class="form-group">
     				<div class="form-row">
     					<label for="exampleInputName">Start Date :  </label>
     					<?= $this->user_model->date_format_orginal($dataArray[0]->START_DATE_PRO); ?>
     				</div>
     			</div>
     		</div>
     		<?php }?>

     		<?php if($dataArray[0]->END_DATE_PRO != '0000-00-00'){?>	
     		<div class="col-md-6">
     			<div class="form-group">
     				<div class="form-row">
     					<label for="exampleInputName">Estimated Due Date :  </label>
     					<?= $this->user_model->date_format_orginal($dataArray[0]->END_DATE_PRO); ?>
     				</div>
     			</div>
     		</div>
     		<?php }?>

     		<?php if(strlen($dataArray[0]->FILE_UPLOAD) > 1){?>	
     		<div class="col-md-6">
     			<div class="form-group">
     				<div class="form-row">
     					<label for="exampleInputName">Uploaded Files :  </label>
     					<a href="<?= SITE_URL;?>dashboard/download/?file=<?= $dataArray[0]->FILE_UPLOAD;?>" target="_blank"> <?= substr($dataArray[0]->FILE_UPLOAD, 26, 100); ?> </a>
     				</div>
     			</div>
     		</div>
     		<?php }?>
     		<?php if(strlen($dataArray[0]->DETAILS_OF_VIDEO) > 1){?>	
     		<div class="col-md-12">
     			<div class="form-group">
     				<div class="form-row">
     					<label for="exampleInputName">Details of project :  </label>
     					<?= $dataArray[0]->DETAILS_OF_VIDEO;?>
     				</div>
     			</div>
     		</div>
     		<?php }?>
     	</div>

     </div>

     <div class="card mb-3" style="margin:10px;">
     	<div class="card-header">
     		<i class="fa fa-table"></i> Payment Description  - <?= $dataArray[0]->BID_TYPE;?>
     	</div>
     	<div class="card-body row">
     		<div class="col-md-7">
     			<div class="form-group">
     				<div class="form-row">
     					&nbsp; <?= $dataArray[0]->PROJECT_NAME;?>
     				</div>
     			</div>
     		</div>
     		<div class="col-md-3">
     			<div class="form-group">
     				<div class="form-row"> <b>Amount : </b>
     					&nbsp; &euro;  <?= $dataArray[0]->PRICE;?>
     				</div>
     			</div>
     		</div>
     		<div class="col-md-2">
     			<div class="form-group">
     				<div class="form-row" style="text-align: right;display: inherit;"> 
     					<a type="submit" href="<?= SITE_URL;?>dashboard/invoice/<?= $dataArray[0]->PROJECT_ID; ?>/" name="invoice" class="btn btn-primary" id="invoice"> Invoice </a>
     				</div>
     			</div>
     		</div>
     	</div>
     </div>

     <?php if($dataArray[0]->BID_TYPE == 'Milestone') { ?>
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
     						<th>Status</th>

     					</tr>
     				</thead>

     				<tbody>
     					<?php

     					if(is_array($dataArrayMile) AND sizeof($dataArrayMile) > 0){
     						$i = 1;
     						foreach($dataArrayMile AS $data){
     							$css = '';
     							if($data->MILESTONE_STAUTS == 'Active'){
     								$css = 'style="background:#333; color:#fff;"';
     							}
     							?>
     							<tr <?= $css;?>>
     								<td align="center"><?= $i; ?></td>
     								<td><?= $data->MILESTONE_DETAILS; ?></td>
     								<td><?= $this->user_model->date_format_orginal($data->ENT_DATE); ?></td>
     								<td>&euro; <?= $data->PRICE; ?></td>
     								<td><?= $data->MILESTONE_STAUTS; ?></td>

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
     <?php } ?>


     <div class="card mb-3" style="margin:10px;">
     	<div class="card-header" id="massage">
     		<i class="fa fa-inbox"></i> Latest Activity <?php if($dataArray[0]->BID_TYPE == 'Milestone'){?> for Active Mileston <?php }?>
     		<a href="#leaveComment" class="latest-comment">See latest comment &amp; reply &gt;&gt;</a>
     	</div>

     	<!-- Accordion -->
     	<div class="panel-group pmt-panel-group" id="accordion">

			<?php
				$userID = $this->session->userdata('userID');
				//print_r($dataArrayMassageDis); exit;
				if(is_array($dataArrayMassageDis) AND sizeof($dataArrayMassageDis) > 0) { 
					$j = 0;
					foreach($dataArrayMassageDis AS $disData) { $j++;
						$date =  $disData->ENT_DATE;
						$dateToday = date("Y-m-d");

						$getDate = isset($_GET['getdate']) ? $_GET['getdate'] : $dateToday;

						$dateID = str_replace('-', '', $date);

						if( $date != $getDate ) {
							// echo '
							// 		<div class="col-md-12" style="margin-top:10px;"><div class="form-group"><p onclick="toggle('.$dateID.');"> <a href="'.SITE_URL.'dashboard/view_project/'.$getID.'/'.$milestonID.'/?getdate='.$date.'#massage'.$dateID.'">'.$this->user_model->date_format_orginal($date).'</a></p> </div> </div>';

							echo '<div class="panel panel-default"><div class="panel-heading pmt-collapse-heading"><h4 class="panel-title pmt-collapse-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$j.'"><span class="glyphicon fa fa-plus"></span>'.$this->user_model->date_format_orginal($date).'</a></h4></div>';
							echo '<div id="collapse'.$j.'" class="panel-collapse collapse "><div class="panel-body">';
						} else {
							echo '<div class="panel panel-default"><div class="panel-heading pmt-collapse-heading"><h4 class="panel-title pmt-collapse-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$j.'"><span class="glyphicon fa fa-plus"></span>'.$this->user_model->date_format_orginal($date).'</a></h4></div>';
							echo '<div id="collapse'.$j.'" class="panel-collapse collapse show"><div class="panel-body">';
						}

						$dataArrayMassage = $this->user_model->massageInfo($getID,$milestonID,$date);

						if(is_array($dataArrayMassage) AND sizeof($dataArrayMassage) > 0){
							$i = 1;
							foreach($dataArrayMassage AS $dataMass) {

								$checkUser = $dataMass->ENT_USER;

								$checkDate = $date;

								if($getDate != $checkDate){
									$style='style="display:none;" id="massage'.$dateID.'" ';
									$event = '';
								}else{
									$style='style="display:block;" id="massage'.$dateID.'" ';
									$event = '';
								}


								if($userID == $checkUser){
									$userClass = 'main_background';
								}else{
									$userClass = 'sub_background';
								}

								?>

								<div class="col-md-12 close_div_for_massage <?= $userClass;?> " id="massage<?= $dataMass->MASSAGE_ID;?>"  >
									<div class="row card-body pad-adjust">
										<div class="col-md-12">
											<div class="form-group mb0">
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
													<div class="pmt-message-user">
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
														<span class="pmt-user-name"> <?= $info[0]->ADMIN_NAME;?> </span>
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
										</div> <!-- end of col-md-12 -->


										<div class="col-md-12">
											<div class="row form-group">
													<?php if($info[0]->ADMIN_TYPE == 'Admin') {
															echo '<pre class="massage_body">'.$dataMass->MASSAGE_BODY.'</pre>';
														 }else{
															  echo '<pre class="massage_body_user">'.$dataMass->MASSAGE_BODY.'</pre>';
														 }    
													?>
											</div>
											<div class="form-group"><?php if(strlen($dataMass->ATTACH_FILE) > 15){?>
												<p><a href="<?= SITE_URL;?>dashboard/download/?file=<?= $dataMass->ATTACH_FILE;?>" target="_blank"> <?= substr($dataMass->ATTACH_FILE, 26, 100); ?> </a> </p>
												<?php } ?>
											</div>
										</div> <!-- end of col-md-12 -->


									</div> <!-- end of row  -->

								</div> <!-- end of close_div_for_massage -->


								<?php

								$i++;
							} //end inner foreach...

						} // end inner is_array....

                              //Check current Date...
                              if( $date != $getDate ) {
						   echo '</div> <!-- panel-body --></div> <!-- panel-collapse --> </div> <!-- end of panel-default -->';
                              }else{
                              echo '</div> <!-- panel-body --></div> <!-- panel-collapse --> </div> <!-- end of panel-default -->';
                              }


					} //end foreach...

				} //end of is_array($dataArrayMassageDis)..
			?>

			</div> <!-- end of panel -->
		</div> <!-- end of accordion -->


		<div class="card mb-3" style="margin:10px;" id="leaveComment">
			<div class="card-header">
				<i class="fa fa-inbox"></i> Leave A Comment  <?php if($dataArray[0]->BID_TYPE == 'Milestone'){?> for Active Mileston <?php }?>
			</div>
			<div class="row card-body" style="">
				<div class="col-md-12">
					<div class="form-group"><?= $MSG;?> </div>
				</div>
				<form action="" method="post" enctype="multipart/form-data" accept-charset="UTF-8">

					<div class="comment-block">
						<textarea name="comment" class="Textarea" style="resize: none;"></textarea>
						<div class="upload-block">
							<div class="text-block">
								<strong>Upload a file? 10MB Max</strong>
								<span>Attach a file to your comment?</span>
							</div>
							<div class="file-holder">
								<div class="file file-input-js-active">
									<input name="file" class="file-input-area" value="Browse..." style="opacity: 1;" type="file">

								</div>
							</div>
						</div>
					</div>

					<input class="btn btn-primary" value="Post Comment" name="comments_post" type="submit">
				</form>
			</div>
		</div>


<?php require('include/footer.php');?>
