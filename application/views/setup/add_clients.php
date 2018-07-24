 <?php require('include/header.php');?>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> <?= $MSG;?></div>
        <div class="card-body">
          <form action="" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Clients name</label>
                <input class="form-control" id="ClientsName" name="ClientsName" type="text" aria-describedby="nameHelp" value="<?= $ADMIN_NAME?>" required="" placeholder="Enter clients name">
              </div>
              
            </div>
          </div>
		  
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Login name</label>
                <input class="form-control" id="LoginName" name="LoginName" type="text" aria-describedby="nameHelp" value="<?= $ADMIN_LOGIN_NAME?>" required="" placeholder="Enter login id">
              </div>
              
            </div>
          </div>
		  
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Email address</label>
                <input class="form-control" id="email_address" name="email_address" type="text" aria-describedby="nameHelp" value="<?= $ADMIN_EMAIL?>" required="" placeholder="Enter email address">
              </div>
              
            </div>
          </div>
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Create password</label>
                <input class="form-control" id="password" name="password" type="text" aria-describedby="nameHelp" value="<?= $ADMIN_PASSWORD?>" required="" placeholder="Enter your password">
              </div>
              
            </div>
          </div>
		  <div class="form-group" style="position:relative;">
			 <div class="form-row">
				<div class="col-md-8">
					<label for="exampleInputEmail1">Project type</label>
					<select id="projecttype" name="projecttype" >   
						<option value="">Select choose</option>                                       	
						<?= $this->user_model->select_project_type_list($PROJECT_TYPE);?>
					</select>						
				  </div>
			  </div>
		  </div>
		  <?php if($ADMIN_ID != 1){?>
		  <div class="form-group" style="position:relative;">
			 <div class="form-row">
				<div class="col-md-8">
					<label for="exampleInputEmail1">Client type</label>
					<select id="usertype" name="usertype" >   
						 <option value="Client" <?php if($ADMIN_TYPE == 'Client'){ echo 'selected="selected"';}?>>Client</option>
						 <option value="Admin" <?php if($ADMIN_TYPE == 'Admin'){ echo 'selected="selected"';}?>>Admin</option>
					</select>						
				  </div>
			  </div>
		  </div>		  <?php }?>		   <?php if($ADMIN_ID > 0 AND $ADMIN_ID != 1){?>		   <div class="form-group" style="position:relative;">			 <div class="form-row">				<div class="col-md-8">					<label for="exampleInputEmail1">Status</label>					<select id="ADMIN_STATUS" name="ADMIN_STATUS" >   						 <option value="Active" <?php if($ADMIN_STATUS == 'Active'){ echo 'selected="selected"';}?>>Active</option>						 <option value="DeActive" <?php if($ADMIN_STATUS == 'DeActive'){ echo 'selected="selected"';}?>>DeActive</option>					</select>										  </div>			  </div>		  </div>		  <?php }?>
		   <button class="btn btn-primary" name="submit" type="submit" id="button"><?= $BUTON;?></button>
		  </form>
        </div>
       
      </div>
	  
	   <div class="card mb-3" style="margin:10px;">
			<div class="card-header">
			  <i class="fa fa-table"></i> Manage Client</div>
			<div class="card-body">
				<div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                 <!-- <th align="center">SL#</th>-->
                  <th>Login Name</th>
					<th>Email</th>
                  <th>Type</th>
                  <th>Project Type</th>                  <th>Status</th>
                  <th>Action</th>
                 
                </tr>
              </thead>
              
			  <tbody>
			   <?php
				
				if(is_array($dataArrayMile) AND sizeof($dataArrayMile) > 0){
					$i = 1;
					foreach($dataArrayMile AS $data){
						$proJect = $this->user_model->projectTypeInfo($data->PROJECT_TYPE);
				?>
					 <tr>
					  <!--<td align="center"><?= $i; ?></td>-->
					  <td><?= $data->ADMIN_LOGIN_NAME; ?></td>
					  <td><?= $data->ADMIN_EMAIL; ?></td>
					  <td> <?= $data->ADMIN_TYPE; ?></td>
					  <td> <?= $proJect[0]->P_TYPE_NAME; ?></td>					  <td> <?= $data->ADMIN_STATUS; ?></td>
					  <td><center> <a href="<?= SITE_URL;?>setup/add_user/<?= $data->ADMIN_ID;?>/"><span class="fa fa-edit"></span> </a></center></td>
					  
					</tr>
				<?php
					$i++;
					}
				}else{
					echo '<tr><td colspan="6"> No client found</td></tr>';
				}
			  ?>
              </tbody>
               
                
            </table>
          </div>
			</div>
		</div>
	  	 <?php require('include/footer.php');?>