 <?php require('include/header.php');?>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Project List
		 </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL</th>
                  <th>Project Name</th>
                  <th>URL</th>
                  <th>Ref</th>
                  <th>Date</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              
			  <tbody>
			   <?php
				$typeFor = $this->user_model->projectTypeInfo();
				$userType = $this->session->userdata('userType');
				$userID = $this->session->userData('userID');
				
				foreach($typeFor AS $typeView){
					if($userType == 'Admin'){
						$query1 = $this->db->query("SELECT * FROM p_project WHERE PROJECT_TYPE = '".$typeView->P_TYPE_ID."' AND PROJECT_STATUS != 'Delete' ORDER BY PROJECT_ID DESC");
					}else{
						$query1 = $this->db->query("SELECT * FROM p_project WHERE ENT_USER = '".$userID."' AND PROJECT_TYPE = '".$typeView->P_TYPE_ID."' AND PROJECT_STATUS != 'Delete' ORDER BY PROJECT_ID DESC");
					}
					$count = $query1->num_rows();
					if($count > 0){
					?>
					<tr>
						<td align="center" colspan="7"> <b><?= $typeView->P_TYPE_NAME; ?> </b></td>
					</tr> 
					<?php				
						
							$dataArray1 = $query1->result();
							if(is_array($dataArray1) AND sizeof($dataArray1) > 0){
								$i = 1;
								foreach($dataArray1 AS $data){
									
									//if($typeView->P_TYPE_ID == $data->PROJECT_TYPE){	
								?>
									 <tr>
									  <td align="center"><?= $i; ?></td>
									  <td><a href="<?= SITE_URL;?>dashboard/view_project/<?= $data->PROJECT_ID; ?>/" ><?= substr($data->PROJECT_NAME, 0, 40); ?> </a></td>
									  <td><?= $data->WEBSITE_URL; ?></td>
									  <td><center><?= $data->REF; ?></center></td>
									  <td><?= $this->user_model->date_format_orginal($data->ENT_DATE); ?></td>
									  <td>&euro; <?= $data->PRICE; ?></td>
									  <td align="center"> <a href="<?= SITE_URL;?>dashboard/add_project/<?= $data->PROJECT_ID; ?>/"  title="Update Project"><span class="fa fa-edit"></span></a>
									  <?php if($data->BID_TYPE == 'Milestone'){?>
									  <a href="<?= SITE_URL;?>dashboard/add_milestone/<?= $data->PROJECT_ID; ?>/" title="Add Milestone"> <span class="fa fa-plus"></span></a>
									  <?php }?>
									  </td>
									
									</tr>
								<?php
									$i++;
									//}
								
								}
							}else{
								echo '<tr><td colspan="6"> No project found</td></tr>';
							}
						}
					
				}
			  ?>
              </tbody>
               
                
            </table>
          </div>
        </div>
       
      </div>
	  	 <?php require('include/footer.php');?>