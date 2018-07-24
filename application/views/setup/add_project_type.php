 <?php require('include/header.php');?>
  
	  <style>
	  .draggable{cursor:move;}
	  </style>
  <script type="text/javascript">
		
		$(function(){
			inputData();
		})	
		function inputData(){
			var html = document.getElementById('dropBoxS').innerHTML;
			//alert(html);
			document.getElementById("htmlFiled").value = html;
		}
			
		function dragStart(e){
			e.dataTransfer.setData("Text", e.target.getAttribute("id"));
		}
		function dragOver(e){
			e.preventDefault();
			e.stopPropagation();
		}
		function drop(e){
			e.stopPropagation();
			e.preventDefault();
		
			var data = e.dataTransfer.getData("Text");
		
			//e.target.appendChild(document.getElementById(data));
			if (data) {
				var childElement = document.getElementById(data);
				if (childElement) {
					e.target.appendChild(childElement);
					inputData();
				}
			}
			
		}
	</script>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> <?= $MSG;?></div>
        <div class="card-body">
          <form action="" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Project type</label>
                <input class="form-control" id="ClientsName" name="ClientsName" type="text" aria-describedby="nameHelp" value="<?= $P_TYPE_NAME?>" required="" placeholder="Enter project type name">
              </div>
              
            </div>
          </div>
		  
		  
		   <button class="btn btn-primary" name="submit" type="submit" id="button"><?= $BUTON;?></button>
		  </form>
		  <div class="form-group" style="margin-top:20px;">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Note : </label>
                When A Project type will be create, Auto 6 fileds are generated for that Project type.
				<ol style="margin-top:20px;" class="project_type">
					<li>Project Name</li>
					<li>Project Price</li>
					<li>Payment Category</li>
					<li>Website Address</li>
					<li>Details</li>
					<li>File Upload</li>
				</ol>
              </div>
              
            </div>
          </div>
        </div>
       
      </div>
	  
	  <?php
	  if($set > 0){
		?>
			 <div class="card mb-3" style="margin:10px;">
				<div class="card-header">
				  <i class="fa fa-table"></i> Select Project items</div>
				<div class="card-body" id="dropBoxS" ondragover="dragOver(event);" ondrop="drop(event);">
					<?php
					$query = $this->db->query("SELECT * FROM s_filed_type WHERE PROJECT_TYPE = '".$set."' AND FILED_STATUS = 'Active' ORDER BY FILED_ID DESC");
					$num = $query->num_rows();
					$dataArray = $this->user_model->projectTypeInfo($set);
					$checkNum = $dataArray[0]->LIMIT_ITEM;
					$html = htmlspecialchars_decode($dataArray[0]->HTML_POSITION);
					if($num == $checkNum AND strlen($html) > 10){
						echo $html;
					}else{	
						if($query->num_rows() > 0){
							$row = $query->result();
							if(is_array($row) and sizeof($row) > 0):
								foreach($row AS $value){
								?>
								
								<div class="form-group draggable" id="<?= $value->FILED_NAME;?>" draggable="true" ondragstart="dragStart(event);" ondrop="return false;" >
									<div class="form-row">
									  <div class="col-md-8">
									  <?php echo htmlspecialchars_decode($value->FILED_HTML); ?>
									  </div>
								   </div>
								 </div>
								<?php
								}
							endif;					
						}else{
							echo 'Please add filed <a href="'.SITE_URL.'setup/filed_item/"> Add Filed</a>';
						}
					}
					?>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="form-row">
						  <div class="col-md-8">
							<form action="" method="post">
								<div class="comment-block"><textarea name="htmlFiled" id="htmlFiled" class="Textarea" style="display:none;"></textarea>	</div>	
								<input type="hidden" name="number" value="<?= $query->num_rows();?>">
								<button class="btn btn-primary" name="submit_save" type="submit" id="button"> Save</button>
							</form>	
							</div>
						</div>
					</div>
				</div>
			</div>
	  <?php
	  }
	  ?>
	 
	  
	   <div class="card mb-3" style="margin:10px;">
			<div class="card-header">
			  <i class="fa fa-table"></i> Manage Project Type</div>
			<div class="card-body">
				<div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL</th>
                  <th>Project Type</th>
                  <th>Status</th>
                 
                  <th align="center">Action</th>
                 
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
					  <td><?= $data->P_TYPE_NAME; ?></td>
					  <td><?= $data->P_STATUS; ?></td>
					   <td><center> <a href="<?= SITE_URL;?>setup/project_type/<?= $data->P_TYPE_ID;?>/"><span class="fa fa-edit"></span> </a>
					   <a href="<?= SITE_URL;?>setup/project_type/?set=<?= $data->P_TYPE_ID;?>"><span class="fa fa-check"></span> </a>
					   <a href="<?= SITE_URL;?>dashboard/add_project/?type=<?= $data->P_TYPE_ID;?>"><span class="fa fa-eye"></span> </a>
					   </center></td>
					  
					</tr>
				<?php
					$i++;
					}
				}else{
					echo '<tr><td colspan="6"> No project type found</td></tr>';
				}
			  ?>
              </tbody>
               
                
            </table>
          </div>
			</div>
		</div>
	  	 <?php require('include/footer.php');?>
		 
		
		
		 