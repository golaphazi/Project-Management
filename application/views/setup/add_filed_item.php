 <?php require('include/header.php');?>
 
 <script>
 function selectHtml(id1, id2, id3){
	var mainFiled = id2.length;
	if(mainFiled > 2){
		var html = '';
		if(id3 == 'text'){
			html += '<label for="exampleInputName">'+id1+'</label>';
			html += '<input class="form-control" id="'+id2+'" name="'+id2+'" type="text" aria-describedby="nameHelp" value="" required="" placeholder="Enter '+id1+'">';					
		}else if(id3 == 'area'){
			html += '<label for="exampleInputName">'+id1+'</label>';
			html += '<div class="comment-block"><textarea class="Textarea" id="'+id2+'" name="'+id2+'" type="text" placeholder="Enter '+id1+'"> </textarea> </div>';
					
		}else if(id3 == 'Checkbox'){
			html += '<label for="exampleInputName">'+id1+'</label>';
			html += ' <input type="checkbox" value="Item1" id="'+id2+'" name="'+id2+'"  > Item1 ';
			html += ' <input type="checkbox" value="Item2" id="'+id2+'" name="'+id2+'"  > Item2 ';
					
		}else if(id3 == 'Radio'){
			html += '<label for="exampleInputName">'+id1+'</label>';
			html += ' <input type="radio" value="Item1" id="'+id2+'" name="'+id2+'"  > Item1 ';
			html += ' <input type="radio" value="Item2" id="'+id2+'" name="'+id2+'"  > Item2 ';
					
		}else if(id3 == 'Select'){
			html += '<label for="exampleInputName">'+id1+'</label>';
			html += '<select id="'+id2+'" name="'+id2+'" class="'+id2+'">';
			html += ' <option value="Item1"> Item1</option> ';
			html += ' <option value="Item2"> Item2</option> ';
			html += '</select> ';
					
		}else{
			html ='';
		}
		
		document.getElementById("htmlFiled").value = html;
		document.getElementById("htmlFiledDiv").innerHTML  = html;
	}else{
		document.getElementById("filedName").focus();
		return false;
	}
	
 }
 
 function selectFileName(data){
	// alert(data);
	var filed = document.getElementById("filedDatabase");
	
	var fileName = data.toUpperCase().trim().replace(/ /g,'_').replace(/[\W]+/g, '');
	
	filed.value = fileName;
 }
 /*
 function auto_load(){
	 var id1 = document.getElementById("filedName").value;
	 var id2 = document.getElementById("filedDatabase").value;
	 var id3 = document.getElementById("radioType").value;
	 selectHtml(id1, id2, id3);
	 //alert(id1);
 }
 window.onload = auto_load;
 */
 function alertMassage(){
	 if(!confirm('Are you sure remove this filed? ')){
		 return false;
	 }
	 return true;
 }
 </script>
 <div class="card mb-3" style="margin:10px;">
        <div class="card-header">
          <i class="fa fa-table"></i> <?= $MSG;?></div>
        <div class="card-body">
          <form action="<?= SITE_URL;?>setup/filed_item/" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <label for="exampleInputName">Filed Name</label>
                <input class="form-control" id="filedName" name="filedName" onkeyup="selectFileName(this.value)" onblur="selectFileName(this.value)" type="text" aria-describedby="nameHelp" value="<?= $FIELD_TITLE?>" required="" placeholder="Enter filed name">
              </div>
              
            </div>
          </div>
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-8">
                <input class="form-control" id="filedDatabase" name="filedDatabase" readonly ="readonly" type="text" aria-describedby="nameHelp" value="<?= $FILED_NAME?>" required="" placeholder="Database Filed name">
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
		  <?php if($FILED_ID > 0){?>
		   <div class="form-group" style="position:relative;">
			 <div class="form-row">
				<div class="col-md-8">
					<label for="exampleInputEmail1">Status</label>
					<select id="usertype" name="usertype" >   
						 <option value="Active" <?php if($FILED_STATUS == 'Active'){ echo 'selected="selected"';}?>>Active</option>
						 <option value="DeActive" <?php if($FILED_STATUS == 'DeActive'){ echo 'selected="selected"';}?>>DeActive</option>
					</select>						
				  </div>
			  </div>
		  </div>
		  <?php }?>
		   <div class="form-group" style="position:relative;">
			 <div class="form-row">
				<div class="col-md-8">
					<label for="exampleInputEmail1">Html Area </label>
					<?php if($HTML_TYPE == 'text'){ echo 'checked';} ?>
					<ul class="htmlField">
						<li> <input type="radio" name="radioType" value="text" id="radioType" onchange="selectHtml(filedName.value, filedDatabase.value,this.value);" <?php if($HTML_TYPE == 'text'){ echo 'checked';} ?>> Text </li>
						<li> <input type="radio" name="radioType" value="area" id="radioType" onchange="selectHtml(filedName.value, filedDatabase.value,this.value);" <?php if($HTML_TYPE == 'area'){ echo 'checked';} ?>> TextArea</li>
						<li> <input type="radio" name="radioType" value="Checkbox" id="radioType" onchange="selectHtml(filedName.value, filedDatabase.value,this.value);" <?php if($HTML_TYPE == 'Checkbox'){ echo 'checked';} ?>> Checkbox</li>
						<li> <input type="radio" name="radioType" value="Radio" id="radioType" onchange="selectHtml(filedName.value, filedDatabase.value,this.value);" <?php if($HTML_TYPE == 'Radio'){ echo 'checked';} ?>> Radio</li>
						<li> <input type="radio" name="radioType" value="Select" id="radioType" onchange="selectHtml(filedName.value, filedDatabase.value,this.value);" <?php if($HTML_TYPE == 'Select'){ echo 'checked';} ?>> Select</li>
					</ul>
					<div class="comment-block"><textarea name="htmlFiled" id="htmlFiled" class="Textarea" style="display:block;"><?= $FILED_HTML;?></textarea>	</div>	
					
				  </div>
			  </div>
			   
		  </div>
		   <div class="form-group" style="position:relative;">
			  <div class="form-row">
				<div class="col-md-8">
					<div id="htmlFiledDiv"> <?= htmlspecialchars_decode($FILED_HTML);?>	</div>
				  </div>
			  </div>
			</div>
		   <button class="btn btn-primary" name="submit" type="submit" id="button"><?= $BUTON;?></button>
		  </form>
        </div>
       
      </div>
	  
	   <div class="card mb-3" style="margin:10px;">
			<div class="card-header">
			  <i class="fa fa-table"></i> Manage Filed Items</div>
			<div class="card-body">
				<div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL</th>
                  <th>Title</th>
                  <th>Name</th>
                  <th>Status</th>
                 
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
					  <td align="center"><?= $i; ?></td>
					  <td><?= $proJect[0]->P_TYPE_NAME; ?></td>
					  <td><?= $data->FIELD_TITLE; ?></td>
					  <td><?= $data->FILED_NAME; ?></td>
					  <td><?= $data->FILED_STATUS; ?></td>
					   <td><center> <a href="<?= SITE_URL;?>setup/filed_item/<?= $data->FILED_ID;?>/"><span class="fa fa-edit"></span> </a>
					   <a onclick="return alertMassage()" href="<?= SITE_URL;?>setup/filed_item/?delete=<?= $data->FILED_ID;?>"><span class="fa fa-trash"></span> </a>
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