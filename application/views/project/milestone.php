 <?php require('include/header.php');?>
<div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Mileston Project List
		 </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL</th>
                  <th>Project Name</th>
                  <th>Website URL</th>
                  <th>Price</th>
                  <th>View</th>
                </tr>
              </thead>
              
			  <tbody>
			   <?php
				
				if(is_array($dataArray) AND sizeof($dataArray) > 0){
					$i = 1;
					foreach($dataArray AS $data){
					if($data->BID_TYPE == 'Milestone'){	
				?>
					 <tr>
					  <td align="center"><?= $i; ?></td>
					  <td><a href="<?= SITE_URL;?>dashboard/view_project/<?= $data->PROJECT_ID; ?>/" ><?= substr($data->PROJECT_NAME, 0, 40); ?> </a></td>
					  <td><?= $data->WEBSITE_URL; ?></td>
					  <td>&euro; <?= $data->PRICE; ?></td>
					  <td align="center"> 
					  <a href="<?= SITE_URL;?>dashboard/milestones/<?= $data->PROJECT_ID; ?>/" title="View Milestone"> <span class="fa fa-eye"></span></a>			 
					  </td>
					
					</tr>
				<?php
					$i++;
					}
					}
				}else{
					echo '<tr><td colspan="6"> No mileston project found</td></tr>';
				}
			  ?>
              </tbody>
               
                
            </table>
          </div>
        </div>
       
      </div>
	  	 <?php require('include/footer.php');?>