 <?php require('include/header.php');?>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Document of Project</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL</th>
                   <th>File Name</th>
                  <th>Project Name</th>
                  <!--<th>Website URL</th>-->
                  <th>Uploded</th>
                 <th>Date</th>
                  
                </tr>
              </thead>
              
			  <tbody>
			   <?php
				
				if(is_array($dataArray) AND sizeof($dataArray) > 0){
					$i = 1;
					foreach($dataArray AS $data){
					
					if(strlen($data->FILE_UPLOAD) > 25){
						$info =	$this->user_model->userInfo($data->ENT_USER); 
				?>
					 <tr>
					  <td align="center"><?= $i; ?></td>
					  <td><a href="<?= SITE_URL;?>dashboard/download/?file=<?= $data->FILE_UPLOAD;?>" target="_blank"> <?= substr($data->FILE_UPLOAD, 26, 25); ?> </a></td>
					  <td><a href="<?= SITE_URL;?>dashboard/view_project/<?= $data->PROJECT_ID; ?>/" ><?= substr($data->PROJECT_NAME, 0, 40).'...'; ?> </a></td>
					  <!--<td><?= $data->WEBSITE_URL; ?></td>-->
					  <td> <?= $info[0]->ADMIN_NAME;?></td>
					  <td><?= $this->user_model->date_format_orginal($data->ENT_DATE); ?></td>
					  
					</tr>
				<?php
					$i++;
					
					}
					$massage =	$this->user_model->massageInfo($data->PROJECT_ID);
					if(is_array($massage)){
					foreach($massage as $mass){
						if(strlen($mass->ATTACH_FILE) > 25){
							$info1 =	$this->user_model->userInfo($mass->ENT_USER); 
							
							?>
							<tr>
							  <td align="center"><?= $i; ?></td>
							  <td><a href="<?= SITE_URL;?>dashboard/download/?file=<?= $mass->ATTACH_FILE;?>" target="_blank"> <?= substr($mass->ATTACH_FILE, 26, 25); ?> </a></td>
							  <td><a href="<?= SITE_URL;?>dashboard/view_project/<?= $data->PROJECT_ID; ?>/" ><?= substr($data->PROJECT_NAME, 0, 40).'...'; ?> </a></td>
							    <!--<td><?= $data->WEBSITE_URL; ?></td>-->
							  <td> <?= $info1[0]->ADMIN_NAME;?></td>
							  
							  <td><?= $this->user_model->date_format_orginal($mass->ENT_DATE); ?></td>
							 
							</tr>
							<?php
							$i++;
						}
					}
					}
					}
				}else{
					echo '<tr><td colspan="6"> No project found</td></tr>';
				}
			  ?>
              </tbody>
               
                
            </table>
          </div>
        </div>
       
      </div>
	  	 <?php require('include/footer.php');?>