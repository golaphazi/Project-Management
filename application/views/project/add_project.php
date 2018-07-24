<?php require('include/header.php');?>
	 <div class="card mb-3" style="margin:10px;">
      <div class="card-header"><?= $MSG;?> <span style="float:right; color:#ffffff;"><?= $type_category;?> </span></div>
      <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Project name</label>
                <input class="form-control" id="ProjectName" name="ProjectName" type="text" aria-describedby="nameHelp" value="<?= $PROJECT_NAME;?>" required="" placeholder="Enter project name">
              </div>
              
            </div>
          </div>
		   <div class="form-group">
            <div class="form-row">
              <div class="col-md-4">
                <label for="exampleInputName">Project Price</label>
                <input class="form-control" id="PRICE" onblur="removeChar(this);" name="PRICE" type="text" min="1" aria-describedby="nameHelp" value="<?= $PRICE;?>" required="" placeholder="Enter project price &euro;">
              </div>
              <div class="col-md-8" style="padding-top:30px;">
                <label for="exampleInputName">Payment Category : </label> 
                <label> <input id="category" name="category" type="radio" <?php if($BID_TYPE == 'Milestone'){echo 'checked';}?> value="Milestone" > Milestone &nbsp; &nbsp; </label> 
                <label> <input id="category" name="category" type="radio"  <?php if($BID_TYPE == 'Fixed'){echo 'checked';}?>  value="Fixed" > Fixed </label> 
              </div>
            </div>
          </div>
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Website Address</label>
                <input class="form-control" id="websiteAddress" name="websiteAddress" type="text" aria-describedby="nameHelp" value="<?= $WEBSITE_URL;?>" required="" placeholder="Enter website url">
              </div>
              
            </div>
          </div>
		  
		  <?= htmlspecialchars_decode($project[0]->HTML_POSITION);?>
			<?php if($PROJECT_ID > 0){?>
			<div class="form-group">
				<div class="form-row">
					<div class="col-md-8">
					 <?php
					  $i =0;
					  echo '<b>Note: </b>';
						foreach($dynamic as $vale){
							$d = $vale->FILED_NAME.$i ;
							echo $$d.' , ';
							$i++;
						}
					  ?>
					</div>
				</div>
		  </div>
			<?php } ?>
			
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">File Upload</label> 
                <input class="file-input-area" name="file" style="opacity: 1;" type="file"><br/>
				<!--<input class="text file-input-value" readonly="" type="text">
				<a href="#" class="button_sub">Browse</a> -->
				<?= substr($FILE_UPLOAD, 15, 50);?>
              </div>
              
            </div>
          </div>
		  
           <div class="form-group">
				<label for="exampleInputEmail1"><?= $project[0]->P_TYPE_NAME;?> Details </label>
				<textarea class="form-control" name="details" id="details" required=""rows="2" cols="30" placeholder="Write down category details"> <?= $DETAILS_OF_VIDEO;?> </textarea>
          </div>
		   
		     <div class="form-group">
            <div class="form-row">
              <div class="col-md-4">
                <label for="exampleInputEmail1">Start Date</label> 
                <input class="form-control" id="startDate" name="startDate" type="date" value="<?= $START_DATE_PRO?>" required="" placeholder="Enter date">
              </div>
                <div class="col-md-4">
                <label for="exampleInputEmail1">Estimated Due Date</label> 
                <input class="form-control" id="endDate" name="endDateS" type="date" value="<?= $END_DATE_PRO?>" required="" placeholder="Enter date">
              </div>
            </div>
          </div>
		   
		  <?php if($PROJECT_ID > 0){?>
		   <div class="form-group" style="position:relative;">
			 <div class="form-row">
				<div class="col-md-8">
					<label for="exampleInputEmail1">Status</label>
					<select id="PROJECT_STATUS" name="PROJECT_STATUS" >   
						 <option value="Active" <?php if($PROJECT_STATUS == 'Active'){ echo 'selected="selected"';}?>>Active / Ongoing</option>
						 <option value="Close" <?php if($PROJECT_STATUS == 'Close'){ echo 'selected="selected"';}?>>Close</option>
						 <option value="DeActive" <?php if($PROJECT_STATUS == 'DeActive'){ echo 'selected="selected"';}?>>DeActive</option>
					</select>						
				  </div>
			  </div>
		  </div>
		  <?php }?>
		  
		   <?php 
		   $userType = $this->session->userdata('userType');
		   if($userType == 'Admin'){?>
		   <div class="form-group" style="position:relative;">
			 <div class="form-row">
				<div class="col-md-8">
					<label for="exampleInputEmail1">Choose Client</label>
					<select id="projecttype" name="clientID" >   
						<option value="0">Select choose</option>                                       	
						<?= $this->user_model->select_client_list($ENT_USER);?>
					</select>						
				  </div>
			  </div>
		  </div>
		   <?php }?>
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
               <label class="wide" for="id-01"> I have read and accept the <a href="<?= SITE_URL;?>setup/terms_condition/" target="_blank">Terms of Sale</a>.</label>
				<input id="id-01" name="agreed" required="" class="chk outtaHere1" type="checkbox">
							
			 </div>
              
            </div>
          </div>
          <button class="btn btn-primary" name="submit" type="submit" id="button"><?= $BUTON;?></button>
		  </div>
        </form>
        
      </div>
	 
	 <?php require('include/footer.php');?>