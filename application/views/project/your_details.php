 <?php require('include/header.php');?>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <a href="<?= SITE_URL;?>dashboard/your_details/" style="float:left; color:#fff;"><i class="fa fa-table"></i> Your Details </a> <a href="<?= SITE_URL;?>dashboard/your_details/?edit=per" style="float:right; color:#fff;"><span class="fa fa-edit"></span> </a></div>
        <div class="card-body">
		 <?php if($edit == 'per'){ ?><?= $MSG;?> <?php }?>
         <form action="" method="POST" enctype="multipart/form-data">
         
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Business name : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="BusinessName" name="BusinessName" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->BUSINESS_NAME; ?>" required="" placeholder="Enter Business name">
				<?php }else{
					echo  $dataArray[0]->BUSINESS_NAME; 
				}?>
			  </div>
              
            </div>
          </div>
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Job title : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="jobTitle" name="jobTitle" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->JOB_TITLE; ?>" required="" placeholder="Enter job title">
				<?php }else{
					echo  $dataArray[0]->JOB_TITLE; 
				}?>
			  </div>
              
            </div>
          </div>
		   <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">First name : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="FirstName" name="FirstName" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->FIRST_NAME; ?>" required="" placeholder="Enter first name">
				<?php }else{
					echo  $dataArray[0]->FIRST_NAME; 
				}?>
			  </div>
              
            </div>
          </div>
		  
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Surname : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="surName" name="surName" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->SURNAME; ?>" required="" placeholder="Enter surName">
				<?php }else{
					echo  $dataArray[0]->SURNAME; 
				}?>
			  </div>
              
            </div>
          </div>
		  
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Email Address : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="emailAddress" name="emailAddress" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->EMAIL_ADDRESS; ?>" required="" placeholder="Enter Email Address">
				<?php }else{
					echo  $dataArray[0]->EMAIL_ADDRESS; 
				}?>
			  </div>
              
            </div>
          </div>
		  
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Phone No : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="phoneNo" name="phoneNo" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->PHONE_NUMBER; ?>" required="" placeholder="Enter phone No">
				<?php }else{
					echo  $dataArray[0]->PHONE_NUMBER; 
				}?>
			  </div>
              
            </div>
          </div>
		  
		  <?php if($edit == 'per'){ ?>
			<button class="btn btn-primary" name="submit_per" type="submit" id="button">Update</button>
		  <?php }?>
		  </form>
        </div>
       
      </div>
	  
	  
	  <div class="card mb-3" style="margin:10px;" id="address">
        <div class="card-header">
          <a href="<?= SITE_URL;?>dashboard/your_details/" style="float:left; color:#fff;"><i class="fa fa-table"></i> Address </a> <a href="<?= SITE_URL;?>dashboard/your_details/?edit=add&#address" style="float:right; color:#fff;"><span class="fa fa-edit"></span> </a></div>
        <div class="card-body">
			<?php if($edit == 'add'){ ?><?= $MSG;?> <?php }?>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<div class="form-row">
				  <div class="col-md-8">
					<label for="exampleInputName">Address : </label>
					<?php if($edit == 'add'){ ?>
						<textarea class="form-control" id="address" name="address" type="text" aria-describedby="nameHelp" value="" placeholder="Enter Address"><?= $dataArray[0]->ADDRESS; ?> </textarea>
					<?php }else{
						echo  $dataArray[0]->ADDRESS; 
					}?>
				  </div>
				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<div class="form-row">
				  <div class="col-md-8">
					<label for="exampleInputName">City : </label>
					<?php if($edit == 'add'){ ?>
						<input class="form-control" id="cityName" name="cityName" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->CITY; ?>" required="" placeholder="Enter city Name">
					<?php }else{
						echo  $dataArray[0]->CITY; 
					}?>
				  </div>
				  
				</div>
			  </div>
			  
			   <div class="form-group">
					<div class="form-row">
					  <div class="col-md-8">
						<label for="exampleInputName">Post code / Zip code : </label>
						<?php if($edit == 'add'){ ?>
							<input class="form-control" id="postCode" name="postCode" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->POSTCODE_ZIP; ?>" required="" placeholder="Enter post code">
						<?php }else{
							echo  $dataArray[0]->POSTCODE_ZIP; 
						}?>
					  </div>
					  
					</div>
				 </div>
				 
				 <div class="form-group">
					<div class="form-row">
					  <div class="col-md-8">
						<label for="exampleInputName">Country : </label>
						<?php if($edit == 'add'){ ?>
							<input class="form-control" id="Country" name="Country" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->COUNTRY; ?>" required="" placeholder="Enter Country">
						<?php }else{
							echo  $dataArray[0]->COUNTRY; 
						}?>
					  </div>
					  
					</div>
				 </div>
				 
				<!-- <div class="form-group">
					<div class="form-row">
					  <div class="col-md-8">
						<label for="exampleInputName">State (for U.S. customers only) : </label>
						<?php if($edit == 'add'){ ?>
							<input class="form-control" id="state" name="state" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->STATE; ?>" placeholder="Enter state">
						<?php }else{
							echo  $dataArray[0]->STATE; 
						}?>
					  </div>
					  
					</div>
				 </div>-->
			   <?php if($edit == 'add'){ ?>
				<button class="btn btn-primary" name="submit_add" type="submit" id="button">Update</button>
			  <?php }?>
			  </form>
			</div>
		</div>
		
		
		<div class="card mb-3" style="margin:10px;"  id="account">
        <div class="card-header">
          <a href="<?= SITE_URL;?>dashboard/your_details/" style="float:left; color:#fff;"><i class="fa fa-table"></i> Account Info </a> <a href="<?= SITE_URL;?>dashboard/your_details/?edit=acc&#account" style="float:right; color:#fff;"><span class="fa fa-edit"></span> </a></div>
			<div class="card-body">
				 <?php if($edit == 'acc'){ ?><?= $MSG;?> <?php }?>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<div class="form-row">
						  <div class="col-md-8">
							<label for="exampleInputName">Old Password : </label>
							<?php if($edit == 'acc'){ ?>
								<input class="form-control" id="oldPassword" name="oldPassword" type="password" aria-describedby="nameHelp" value="" required="" placeholder="Enter old password">
							<?php }else{
								echo  str_repeat('*', strlen($dataArray[0]->ADMIN_PASSWORD)); 
							}?>
						  </div>
						  
						</div>
					 </div>
					
					<div class="form-group">
						<div class="form-row">
						  <div class="col-md-8">
							<label for="exampleInputName">New Password : </label>
							<?php if($edit == 'acc'){ ?>
								<input class="form-control" id="Password" name="Password" type="password" aria-describedby="nameHelp" value="" required="" placeholder="Enter password">
							<?php }else{
								echo  str_repeat('*', strlen($dataArray[0]->ADMIN_PASSWORD)); 
							}?>
						  </div>
						  
						</div>
					 </div>
					 <div class="form-group">
						<div class="form-row">
						  <div class="col-md-8">
							<label for="exampleInputName">Confirm Password : </label>
							<?php if($edit == 'acc'){ ?>
								<input class="form-control" id="confirm_Password" name="confirm_Password" type="password" aria-describedby="nameHelp" value="" required="" placeholder="Enter confirm password">
							<?php }else{
								echo  str_repeat('*', strlen($dataArray[0]->ADMIN_PASSWORD)); 
							}?>
						  </div>
						  
						</div>
					 </div>
					 <?php if($edit == 'acc'){ ?>
						<button class="btn btn-primary" name="submit_acc" type="submit" id="button">Update</button>
					  <?php }?>
				</form>
			</div>
		</div>
	  	 <?php require('include/footer.php');?>