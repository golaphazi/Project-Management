 <?php require('include/header.php');?>
  <script>
	function addMilestone(id){
		var row = id+1;
		var check = $("#milestone__"+id).val();
		var price = $("#price__"+id).val();
		if(check.length > 3){
			if(price.length > 0){
				var filed ='';
				filed += '<div class="form-group" id="table__'+row+'"> <div class="form-row"> <div class="col-md-6">';
					filed += '<label for="exampleInputName">Milestone '+row+': </label>';
					filed += '<input class="form-control" id="milestone__'+row+'" name="milestone[]" type="text" aria-describedby="nameHelp" value="" required="" placeholder="Enter milestone '+row+'">';
				filed += '</div> <div class="col-md-2" id="price_remove__'+row+'"> <label for="exampleInputName"> Price '+row+': </label><input class="form-control" id="price__'+row+'" name="price[]" onblur="removeChar(this);" type="text" aria-describedby="nameHelp" value="" required="" placeholder="Enter price "></div>';
				filed += '<div class="col-md-3" id="date_remove__'+row+'"> <label for="exampleInputName"> date '+row+': </label><input class="form-control" id="endDate" name="date[]"  type="date" value="" required="" placeholder="Enter date "></div>';
				filed += '<div class="col-md-1" id="button_remove__'+row+'"> <span class="fa fa-plus class_add" onclick="addMilestone('+row+')"></span> </div>';
				filed += '</div> </div>';
				var remove = '<span class="fa fa-close class_add class_remove" onclick="removeMilestone('+id+')"></span>';
				$("#button_remove__"+id).html(remove);
				
				$("#main_div").append(filed);
				$("#milestone__"+row).focus();
			}else{
				$("#price__"+id).focus();
			}
		}else{
			$("#milestone__"+id).focus();
		}
	}
	
	
	function removeMilestone(id){
		$("#table__"+id).html('');
	}
	
	
	
  </script>
  <style>
	.class_add {
		font-size: 15px;
		background: #222222;
		padding: 10px;
		color: #fff;
		border-radius: 6px;
		margin-top: 21px;
	}
	.class_remove{color:red;}
  </style>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> <?= $MSG;?></div>
        <div class="card-body">
          <form action="" method="POST" enctype="multipart/form-data">
			<div id="main_div">
			  <div class="form-group" id="table__1">
				<div class="form-row">
				  <div class="col-md-6">
					<label for="exampleInputName">Milestone 1: </label>
					<input class="form-control" id="milestone__1" name="milestone[]" type="text" aria-describedby="nameHelp" value="<?= $name?>" required="" placeholder="Enter milestone 1">
					
				  </div>
				  <div class="col-md-2" id="price_remove__1"> <label for="exampleInputName"> Price 1: </label><input class="form-control" id="price__1" name="price[]" onblur="removeChar(this);" type="text" aria-describedby="nameHelp" value="<?= $price?>" required="" placeholder="Enter price "></div>
				  <div class="col-md-3" id="date_remove__1"> <label for="exampleInputName"> Date 1: </label><input class="form-control" id="endDate" name="date[]" type="date" value="<?= $date?>" required="" placeholder="Enter date "></div>
				  <?php if($MILESTON_ID <= 0){ ?><div class="col-md-1" id="button_remove__1"> <span class="fa fa-plus class_add" onclick="addMilestone(1)"></span> </div><?php } ?>	
				</div>
			  </div>
			  <?php if($MILESTON_ID > 0){ ?>
				<div class="form-group" style="position:relative;">
				 <div class="form-row">
					<div class="col-md-4">
						<label for="exampleInputEmail1">Payment Status</label>
						<select id="status" name="PAYMENT_STATUS" >   
							<option value="Pending" <?php if($PAYMENT_STATUS == 'Pending'){ echo 'selected="selected"';}?>>Pending</option>
							<option value="Due" <?php if($PAYMENT_STATUS == 'Due'){ echo 'selected="selected"';}?>>Due</option>
							<option value="Paid" <?php if($PAYMENT_STATUS == 'Paid'){ echo 'selected="selected"';}?>>Paid</option>
							 
						</select>						
					  </div>
					  <div class="col-md-4">
						<label for="exampleInputEmail1">Milestone Status</label>
						<select id="status" name="status" >   
							 <option value="Active" <?php if($status == 'Active'){ echo 'selected="selected"';}?>>Active / Runing</option>
							 <option value="Upcoming" <?php if($status == 'Upcoming'){ echo 'selected="selected"';}?>>Upcoming</option>
							 <option value="Close" <?php if($status == 'Close'){ echo 'selected="selected"';}?>>Close</option>
							 <option value="Delete" <?php if($status == 'Delete'){ echo 'selected="selected"';}?>>Delete</option>
						</select>						
					  </div>
				  </div>
			  </div>
			<?php } ?>	
		  </div>
		  
		   <button class="btn btn-primary" name="submit" type="submit" id="button"><?= $BUTON;?></button>
		  </form>
        </div>
       
      </div>
	  
	   <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Milestone Name
		 </div>
        <div class="card-body row">
          <div class="table-responsive"  style="width:100%;">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL</th>
                  <th>Milestone Name</th>
                  <th>Date</th>
                  <th>Price</th>
                  <th>Payment</th>
                  <th>Status</th>
                  <th>Action</th>
                 
                </tr>
              </thead>
              
			  <tbody>
			   <?php
				$userID = $this->session->userdata('userID');
				if(is_array($dataArrayMile) AND sizeof($dataArrayMile) > 0){
					$i = 1;
					foreach($dataArrayMile AS $data1){
						$info = $this->user_model->userInfo($data1->ENT_USER);
				?>
					 <tr>
					  <td align="center"><?= $i; ?></td>
					  <td><?= $data1->MILESTONE_DETAILS; ?></td>
					   <td><?= $this->user_model->date_format_orginal($data1->ENT_DATE); ?></td>
					  <td>&euro; <?= $data1->PRICE; ?></td>
					  <td> <?= $data1->PAYMENT_STATUS; ?></td>
					  <td> <?= $data1->MILESTONE_STAUTS; ?></td>
					  <td><center>
					  <?php if($data1->ENT_USER == $userID){?><a href="<?= SITE_URL;?>dashboard/edit_milestone/<?= $data1->PROJECT_ID; ?>/<?= $data1->MILESTON_ID; ?>/" title="Add Milestone"> <span class="fa fa-edit"></span></a> <?php }else{echo $info[0]->ADMIN_NAME;}?></center></td>
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
	  	 <?php require('include/footer.php');?>
		 
		
		
		 
		 