 <?php require('include/header.php');?>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <a href="<?= SITE_URL;?>setup/company_setting/" style="float:left; color:#fff;"><i class="fa fa-table"></i> Your Details </a> <a href="<?= SITE_URL;?>setup/company_setting/?edit=per" style="float:right; color:#fff;"><span class="fa fa-edit"></span> </a></div>
        <div class="card-body">
		 <?php if($edit == 'per'){ ?><?= $MSG;?> <?php }?>
         <form action="" method="POST" enctype="multipart/form-data">
         
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Company name : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="BusinessName" name="BusinessName" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->C_COMPANY_NAME; ?>" required="" placeholder="Enter company name">
				<?php }else{
					echo  $dataArray[0]->C_COMPANY_NAME; 
				}?>
			  </div>
              
            </div>
          </div>
		  
		   <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Sub title of company : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="FirstName" name="FirstName" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->C_SUB_TITLE; ?>" required="" placeholder="Enter sub title name">
				<?php }else{
					echo  $dataArray[0]->C_SUB_TITLE; 
				}?>
			  </div>
              
            </div>
          </div>
		  
		  
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Email Address : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="emailAddress" name="emailAddress" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->C_EMAIL; ?>" required="" placeholder="Enter Email Address">
				<?php }else{
					echo  $dataArray[0]->C_EMAIL; 
				}?>
			  </div>
              
            </div>
          </div>
		  
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Phone No : </label>
                <?php if($edit == 'per'){ ?>
					<input class="form-control" id="phoneNo" name="phoneNo" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->C_PHONE_NUM; ?>" required="" placeholder="Enter phone No">
				<?php }else{
					echo  $dataArray[0]->C_PHONE_NUM; 
				}?>
			  </div>
              
            </div>
          </div>
		  <div class="form-group">
				<div class="form-row">
				  <div class="col-md-8">
					<label for="exampleInputName">Address : </label>
					<?php if($edit == 'per'){ ?>
						<textarea class="form-control" id="address" name="address" type="text" aria-describedby="nameHelp" value="" placeholder="Enter Address"><?= $dataArray[0]->C_ADDRESS; ?> </textarea>
					<?php }else{
						echo  $dataArray[0]->C_ADDRESS; 
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
          <a href="<?= SITE_URL;?>setup/company_setting/" style="float:left; color:#fff;"><i class="fa fa-table"></i> Logo for company </a> <a href="<?= SITE_URL;?>setup/company_setting/?edit=add&#address" style="float:right; color:#fff;"><span class="fa fa-edit"></span> </a></div>
        <div class="card-body">
			<?php if($edit == 'add'){ ?><?= $MSG;?> <?php }?>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<div class="form-row">
				  <div class="col-md-8">
					<label for="exampleInputName">Logo : </label>
					<?php if($edit == 'add'){ ?>
						
						<input class="form-control" id="logo" name="logo" type="file" required="" placeholder="Enter phone No">
					<?php }else{
						echo  '<div style="background:#ccc;"><img src="'.SITE_URL.'image/'.$dataArray[0]->C_LOGO.'" alt="'.$dataArray[0]->C_COMPANY_NAME.'"> </div>' ;
					}?>
				  </div>
				  
				</div>
			  </div>
			  
			 
			   <?php if($edit == 'add'){ ?>
				<button class="btn btn-primary" name="submit_add" type="submit" id="button">Update</button>
			  <?php }?>
			  </form>
			</div>
		</div>
	  
	  <div class="card mb-3" style="margin:10px;"  id="account">
        <div class="card-header">
          <a href="<?= SITE_URL;?>setup/company_setting/" style="float:left; color:#fff;"><i class="fa fa-table"></i> Other Setting </a> <a href="<?= SITE_URL;?>setup/company_setting/?edit=acc&#account" style="float:right; color:#fff;"><span class="fa fa-edit"></span> </a></div>
			<div class="card-body">
				 <?php if($edit == 'acc'){ ?><?= $MSG;?> <?php }?>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<div class="form-row">
						  <div class="col-md-8">
							<label for="exampleInputName"> % Vat : </label>
							<?php if($edit == 'acc'){ ?>
								<input class="form-control" id="vat" name="vat" type="text" aria-describedby="nameHelp" value="<?= $dataArray[0]->C_VAT; ?>" required="" placeholder="Enter % of vat">
							<?php }else{
								echo  $dataArray[0]->C_VAT. '%'; 
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