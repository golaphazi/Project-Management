<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {

    var $CI;
	function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
		$this->load->library('session');
		$this->load->model(array('user_model'));
		$this->load->helper('url');
		$this->user_model->login_check();
		
	}
	
	public function index(){
		$data = array();
		//redirect(SITE_URL.'dashboard/view_project/');
		$this->load->view('index', $data);		
	}
	
	public function add_project($id=''){
		$data = array();
		
		$userID = $this->session->userdata('userID');
		$userType = $this->session->userdata('userType');
		$refer = $this->session->userdata('refer');
		
		$type = $this->session->userdata('projectType');
		
		if($userType == 'Admin'){
			$projectType = isset($_GET['type']) ? $_GET['type'] : $type;
		}else{
			$projectType = $type;
		}
		
		$dynamic = $this->user_model->showDynamicFiled($projectType);
		
		if($id > 0){
			$dataArray = $this->user_model->projectInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['PROJECT_NAME'] = $dataArray[0]->PROJECT_NAME;
				$data['PRICE'] = $dataArray[0]->PRICE;
				$data['PROJECT_ID'] = $dataArray[0]->PROJECT_ID;
				$data['WEBSITE_URL'] = $dataArray[0]->WEBSITE_URL;
				$projectType = $dataArray[0]->PROJECT_TYPE;
				$dynamic = $this->user_model->showDynamicFiled($projectType);
		
				/*dynamic filed*/
				$i =0;
				if(is_array($dynamic) AND sizeof($dynamic) > 0){
					foreach($dynamic as $vale){
						$v = $vale->FILED_NAME;
						$data[$vale->FILED_NAME.$i] = $dataArray[0]->$v;
						$i++;
					}
				}
				/*dynamic filed end*/
				
				$data['FILE_UPLOAD'] =  $dataArray[0]->FILE_UPLOAD;
				$data['DETAILS_OF_VIDEO'] = $dataArray[0]->DETAILS_OF_VIDEO;
				$data['BID_TYPE'] = $dataArray[0]->BID_TYPE;
				$data['PROJECT_STATUS'] = $dataArray[0]->PROJECT_STATUS;
				$data['ENT_USER'] = $dataArray[0]->ENT_USER;
				$data['START_DATE_PRO'] = $dataArray[0]->START_DATE_PRO;
				$data['END_DATE_PRO'] = $dataArray[0]->END_DATE_PRO;
				
				$data['BUTON'] = 'Edit';
				$edit = 1;
			}else{
				$data['PROJECT_NAME'] = '';
				$data['PRICE'] = '';
				$data['PROJECT_ID'] = '';
				$data['WEBSITE_URL'] = '';
				$data['ENT_USER'] = '';
				
				/*dynamic filed*/
				if(is_array($dynamic) AND sizeof($dynamic) > 0){
					foreach($dynamic as $vale){
						$data[$vale->FILED_NAME] = '';
					}	
				}	
				/*dynamic filed end*/
				
				$data['FILE_UPLOAD'] = '';				
				$data['DETAILS_OF_VIDEO'] = '';				
				$data['BID_TYPE'] = 'Milestone';				
				$data['PROJECT_STATUS'] = '';				
				$data['START_DATE_PRO'] = '';				
				$data['END_DATE_PRO'] = '';				
				$data['BUTON'] = 'Add';
				$edit = 0;
			}
		}else{
			$data['PROJECT_NAME'] = '';
			$data['PRICE'] = '';
			$data['PROJECT_ID'] = '';
			$data['WEBSITE_URL'] = '';
			$data['ENT_USER'] = '';
			
			/*dynamic filed*/
			if(is_array($dynamic) AND sizeof($dynamic) > 0){				
				foreach($dynamic as $vale){
					$data[$vale->FILED_NAME] = '';
				}
			}
			/*dynamic filed end*/
			
			$data['FILE_UPLOAD'] = '';				
			$data['DETAILS_OF_VIDEO'] = '';		
			$data['BID_TYPE'] = 'Milestone';		
			$data['PROJECT_STATUS'] = '';		
			$data['START_DATE_PRO'] = '';		
			$data['END_DATE_PRO'] = '';		
			$data['BUTON'] = 'Add';
			$edit = 0;
			
		}
		
		$data['dynamic'] = $dynamic;
		$data['type'] = $projectType;
		
		$data['project'] = $this->user_model->projectTypeInfo($projectType);
		
		if($userType == 'Admin'){
			$typeFor = $this->user_model->projectTypeInfo();
			$viewType = '';
			foreach($typeFor AS $typeView){
				$viewType .= '<a href="'.SITE_URL.'dashboard/add_project/?type='.$typeView->P_TYPE_ID.'" style="color:#fff;"> '.substr($typeView->P_TYPE_NAME, 0, 10).' </a> <span class="" aria-hidden="true" style="margin:0px 10px; border:1px solid #ccc;"></span>';
			}
			$data['type_category'] = ''.$viewType.'';
		}else{
			$data['type_category'] = '';
		}
		$data['MSG'] = ''.$data['project'][0]->P_TYPE_NAME.' Order Form';
		if(isset($_POST['submit'])){
			$PROJECT_NAME = $this->input->post('ProjectName');
			$PRICE		  = $this->input->post('PRICE');
			$WEBSITE_URL = $this->input->post('websiteAddress');
			
			$DETAILS_OF_VIDEO = $this->input->post('details');
			$BID_TYPE = $this->input->post('category');
			
			$START_DATE_PRO = $this->input->post('startDate');
			$END_DATE_PRO = $this->input->post('endDateS');
			
			$PROJECT_STATUS = 'Active';
			
				$uploadfile = $data['FILE_UPLOAD'];
				$FILE_UPLOAD = $_FILES['file']['name'];
				if(strlen($FILE_UPLOAD) > 4){
					$uploaddir = 'upload/project/';
					$uploadfile = $uploaddir .time().'-'. basename($_FILES['file']['name']);

					if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
						
					} 
				}
			
				$userType = $this->session->userdata('userType');
			   if($userType == 'Admin'){
				   $userID = $this->input->post('clientID');
			   }
			//echo $uploadfile;exit;
			$REF = $userID.$this->user_model->max_any_where('p_project','PROJECT_ID', '');
			
			if(strlen($PROJECT_NAME) > 4){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM p_project WHERE PROJECT_NAME = '".addslashes($PROJECT_NAME)."' AND ENT_USER = '".addslashes($userID)."'");
					$count = $query->num_rows();
					if($count == 0){
						
						 $insert = array();
						 
						 $insert['PROJECT_NAME'] = 	addslashes($PROJECT_NAME);
						 $insert['PRICE'] 		 = 	addslashes($PRICE);
						 $insert['WEBSITE_URL']  = 	addslashes($WEBSITE_URL);
						 $insert['REF'] 		 = 	addslashes($REF);
						 foreach($dynamic as $valet){
							$insert[$valet->FILED_NAME] = $this->input->post($valet->FILED_NAME);
						 }
						 $insert['FILE_UPLOAD']  	= 	addslashes($uploadfile);
						 $insert['DETAILS_OF_VIDEO'] = 	addslashes($DETAILS_OF_VIDEO);
						 $insert['ENT_DATE'] 		 = 	date("Y-m-d");
						 $insert['START_DATE_PRO'] 	 = 	$START_DATE_PRO;
						 $insert['END_DATE_PRO'] 	 = 	$END_DATE_PRO;
						 $insert['ENT_USER'] 		 = 	addslashes($userID);
						 $insert['PROJECT_TYPE'] 	 = 	addslashes($projectType);
						 $insert['BID_TYPE'] 		 = 	addslashes($BID_TYPE);
						 $insert['PROJECT_STATUS'] 	 = 	addslashes($PROJECT_STATUS);
						
						if($this->db->insert('p_project', $insert)){
							$id = $this->db->insert_id();
							$data['MSG'] = '<span style="color:green;">Successfully submitted Project</span>';
							
							$user = array($refer,$userID);
							foreach($user as $access){
								if($access > 0){
									$insertA = array();
									$insertA['PRODUCT_ID'] = $id;
									$insertA['ENT_USER'] = $access;
									$insertA['PERMISION'] = 'Edit';
									$insertA['TYPE_ACCESS'] = 'Parent';
									$insertA['P_STATUS'] = 'Active';
									
									$this->db->insert('p_project_access', $insertA);
								}
							}
							if($BID_TYPE == 'Milestone'){
								redirect(SITE_URL.'dashboard/add_milestone/'.$id.'/');
							}else{
								redirect(SITE_URL.'dashboard/view_project/'.$id.'/');
							}
							
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already submitted Project</span>';
					}
				
				}else{
						$PROJECT_STATUS = $this->input->post('PROJECT_STATUS');
						
						
						$update = array();
						$update['PROJECT_NAME'] = addslashes($PROJECT_NAME);
						$update['PRICE'] = addslashes($PRICE);
						$update['WEBSITE_URL'] = addslashes($WEBSITE_URL);
						
						foreach($dynamic as $valet){
							$update[$valet->FILED_NAME] = $this->input->post($valet->FILED_NAME);
						 }
						 $update['FILE_UPLOAD'] = addslashes($uploadfile);
						 $update['DETAILS_OF_VIDEO'] = addslashes($DETAILS_OF_VIDEO);
						 $update['START_DATE_PRO'] = addslashes($START_DATE_PRO);
						 $update['END_DATE_PRO'] = addslashes($END_DATE_PRO);
						 $update['BID_TYPE'] = addslashes($BID_TYPE);
						 $update['PROJECT_STATUS'] = addslashes($PROJECT_STATUS);
						
						
						$user = array($refer,$userID);
							foreach($user as $access){
								if($access > 0){
									$this->db->delete('p_project_access', array('ENT_USER' => $access, 'PRODUCT_ID' => $id));
						
									$insertA = array();
									$insertA['PRODUCT_ID'] = $id;
									$insertA['ENT_USER'] = $access;
									$insertA['PERMISION'] = 'Edit';
									$insertA['TYPE_ACCESS'] = 'Parent';
									$insertA['P_STATUS'] = 'Active';
									
									$this->db->insert('p_project_access', $insertA);
								}
							}	
						
						if($this->db->update('p_project', $update, array('PROJECT_ID' => $id))){
							$data['MSG'] = '<span style="color:green;">Successfully updated Project</span>';
							redirect(SITE_URL.'dashboard/view_project/'.$id.'/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					
				}
			}else{
				$data['MSG'] = 'Please enter Project name';
			}
		}
		if($userType == 'Admin'){
			$this->load->view('project/add_project', $data);	
		}else{
			redirect(SITE_URL.'dashboard/view_project/');
		}
		
	}
	
	public function add_milestone($id=''){
		if($id > 0){
			$dataArray = $this->user_model->projectInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				$data = array();
				$data['BUTON'] = 'Add';
				$data['MSG'] = 'Add Milestone';
				$data['dataArrayMile'] = $this->user_model->milestoneInfo($id);
				$userID = $this->session->userdata('userID');
				
				$data['MILESTON_ID'] = '';
				$data['name'] = '';
				$data['price'] = '';
				$data['date'] = '';
				$data['status'] = '';
				$data['PAYMENT_STATUS'] = '';
				
				
				if(isset($_POST['submit'])){
					$milestone = $this->input->post('milestone');
					$price		 = $this->input->post('price');
					$date		 = $this->input->post('date');
					
					if(is_array($milestone) AND sizeof($milestone) > 0){	
						foreach($milestone as $index=>$dataD){
							if(strlen($dataD) > 2){
							
								$insert = array();
								$insert['PROJECT_ID'] = $id;
								$insert['MILESTONE_DETAILS'] = $dataD;
								$insert['PRICE'] = $price[$index];
								$insert['ENT_USER'] = $userID;
								$insert['ENT_DATE'] = $date[$index];
								$insert['ENT_TIME'] = date("Y-m-d");
								
								$miles = $this->db->query("SELECT * FROM p_mileston WHERE PROJECT_ID = '".$id."'  AND MILESTONE_STAUTS = 'Active' ORDER BY MILESTON_ID DESC");
								$count1 = $miles->num_rows();
								
								if($index < 1 AND $count1 == 0){
									$insert['PAYMENT_STATUS'] = 'Due';
									$insert['MILESTONE_STAUTS'] = 'Active';
								}else{
									$insert['PAYMENT_STATUS'] = 'Pending';
									$insert['MILESTONE_STAUTS'] = 'Upcoming';
								}
								
								$this->db->insert('p_mileston', $insert);
							}
							
						}
					}
					$data['MSG'] = 'Successfully add Milestone';
					redirect(SITE_URL.'dashboard/view_project/'.$id.'/');
				}
				
				$this->load->view('project/add_milestone', $data);	
			
			}else{
				redirect(SITE_URL.'dashboard/view_project/');
			}
			
		}else{
			redirect(SITE_URL.'dashboard/view_project/');
		}
	}
	
	public function edit_milestone($id='', $mile=''){
		if($id > 0){
			$dataArray = $this->user_model->projectInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				$data = array();
				$data['BUTON'] = 'Update';
				$data['MSG'] = 'Update Milestone';
				$data['dataArrayMile'] = $this->user_model->milestoneInfo($id);
				
				$miles = $this->user_model->milestoneInfo($id,$mile);
				if(is_array($miles) AND sizeof($miles) > 0){
					$data['MILESTON_ID'] = $miles[0]->MILESTON_ID;
					$data['name'] = $miles[0]->MILESTONE_DETAILS;
					$data['price'] = $miles[0]->PRICE;
					$data['date'] = $miles[0]->ENT_DATE;
					$data['status'] = $miles[0]->MILESTONE_STAUTS;
					$data['PAYMENT_STATUS'] = $miles[0]->PAYMENT_STATUS;
				}else{
					$data['MILESTON_ID'] =0;
					$data['name'] = '';
					$data['price'] = '';
					$data['date'] = '';
					$data['status'] = '';
					$data['PAYMENT_STATUS'] = '';
				}
				$userID = $this->session->userdata('userID');
				$mass = 1;
				$massage = '';
				if(isset($_POST['submit'])){
					$milestone = $this->input->post('milestone');
					$price		 = $this->input->post('price');
					$date		 = $this->input->post('date');
					$status		 = $this->input->post('status');
					$PAYMENT_STATUS		 = $this->input->post('PAYMENT_STATUS');
					if(is_array($milestone) AND sizeof($milestone) > 0){		
										
						foreach($milestone as $index=>$data1){
							if(strlen($data1) > 3){
								$insert = array();
								$insert['MILESTONE_DETAILS'] = $data1;
								$insert['PRICE'] = $price[$index];
								$insert['ENT_DATE'] = $date[$index];
								$insert['PAYMENT_STATUS'] = $PAYMENT_STATUS;
								$insert['MILESTONE_STAUTS'] = $status;
								
								$mileD = $this->db->query("SELECT * FROM p_mileston WHERE PROJECT_ID = '".$id."'  AND MILESTONE_STAUTS = 'Active' ORDER BY MILESTON_ID DESC");
								$count1 = $mileD->num_rows();
								
								if($data['status'] == 'Active' AND $count1 < 2){
									$mass = 1;
								}else if($count1 == 0){
									$mass = 1;
								}else if($status != 'Active'){
									$mass = 1;
								}else{
									$mass = 0;
									$massage = 'Already Runing Milestone';
								}
								if($mass == 1){
									if($this->db->update('p_mileston', $insert, array('PROJECT_ID' => $id, 'MILESTON_ID' => $mile, 'ENT_USER' => $userID))){
										$data['MSG'] = 'Successfully Edit Milestone';
										redirect(SITE_URL.'dashboard/add_milestone/'.$id.'/');										
									}
									
								}else{
									$data['MSG'] = $massage;
								}
								
							}
							
						}
						
						
					}
				}
				
				$this->load->view('project/add_milestone', $data);	
			
			}else{
				redirect(SITE_URL.'dashboard/view_project/');
			}
			
		}else{
			redirect(SITE_URL.'dashboard/view_project/');
		}
	}
	
	public function view_project($getID='0'){
		$data = array();
		$data['MSG'] = '';
		
		$userID = $this->session->userdata('userID');
		if($getID > 0){
			$data['dataArray'] = $this->user_model->projectInfo($getID);
			if(is_array($data['dataArray']) AND sizeof($data['dataArray']) > 0){
				$data['dataArrayMile'] = $this->user_model->milestoneInfo($getID);
				
				$checkDib = $data['dataArray'][0]->BID_TYPE;
				$milestonID = 0;
				$addCheck = 1;
				if($checkDib == 'Milestone'){
					$miles = $this->db->query("SELECT * FROM p_mileston WHERE PROJECT_ID = '".$getID."'  AND MILESTONE_STAUTS = 'Active' ORDER BY MILESTON_ID DESC");
					$count1 = $miles->num_rows();
					if($count1 > 0){
						$row = $miles->result();
						$milestonID = $row[0]->MILESTON_ID;
					}else{
						$data['MSG'] = '<span style="color:#a94442;"> Please Active your next milestone</span>';
						$addCheck = 0;
					}
				}
				$data['milestonID'] = $milestonID;
				$data['getID'] = $getID;
				$data['dataArrayMassageDis'] = $this->user_model->massageInfoDis($getID,$milestonID);
				//$data['dataArrayMassage'] = $this->user_model->massageInfo($getID,$milestonID);
				
				
				if(isset($_POST['comments_post'])){
					$massage = $this->input->post('comment');
			
					$PROJECT_STATUS = 'Active';
					if(strlen($massage) > 2){
						$uploadfile = '';
						$FILE_UPLOAD = $_FILES['file']['name'];
						if(strlen($FILE_UPLOAD) > 4){
							$uploaddir = 'upload/massage/';
							$uploadfile = $uploaddir .time().'-'. basename($_FILES['file']['name']);

							if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
								
							} 
						}
						$query = $this->db->query("SELECT * FROM p_massage WHERE MASSAGE_BODY = '".addslashes($massage)."' AND ENT_USER = '".addslashes($userID)."' AND PROJECT_ID = '".addslashes($getID)."'");
						$count = $query->num_rows();
						if($count == 0){
							
							if($addCheck == 1){
								
								$insert = array();
								$insert['PROJECT_ID'] = addslashes($getID);
								
								if($checkDib == 'Milestone'){
									$insert['MILESTON_ID'] = addslashes($milestonID);
								}
								
								$insert['FROM_ID'] = $userID;
								$insert['MASSAGE_BODY'] = addslashes($massage);
								$insert['ATTACH_FILE'] = addslashes($uploadfile);
								$insert['ENT_DATE'] = date("Y-m-d");
								$insert['ENT_TIME'] = date("h:i:s");
								$insert['ENT_USER'] = $userID;
								$insert['MASSAGE_STATUS'] = addslashes($PROJECT_STATUS);
								
								
								if($this->db->insert('p_massage', $insert)){
									$data['MSG'] = '<span style="color:green;"> -- Successfully submitted your comments</span>';
									$massID = $this->db->insert_id();
									redirect(SITE_URL.'dashboard/view_project/'.$getID.'/#massage'.$massID.'');
								}else{
									$data['MSG'] = '<span style="color:#a94442;"> -- Systen error</span>';
								}
								
							}
						}
					}
				}
			
			$this->load->view('project/view_project_details', $data);
			}else{
				redirect(SITE_URL.'dashboard/view_project/');
			}
		}else{
			$data['dataArray'] = $this->user_model->projectInfo();
			$this->load->view('project/view_project', $data);
		}
	}
	
	public function download(){
		$file = isset($_GET['file']) ? $_GET['file'] : '';
		return $this->user_model->download($file);
	}
	
	public function zip_download($id=0){
		if($id > 0){
			$this->user_model->create_zip($id);		
		}else{
			redirect(SITE_URL.'dashboard/view_project/');
		}
	}
	public function documents($id=0){
		if($id > 0){
			$this->user_model->create_zip($id);		
		}		
		$data = array();
		$data['MSG'] = 'Video Order Form';
		$data['dataArray'] = $this->user_model->projectInfo();
		$this->load->view('project/document', $data);
	}
	
	public function milestones($getID='0',$milestonID='0'){
		$data = array();
		$data['MSG'] = 'Milestone Form';
		$data['dataArray'] = $this->user_model->projectInfo();
		
		if($getID > 0){
			$data['dataArrayMile'] = $this->user_model->milestoneInfo($getID);
			if(is_array($data['dataArrayMile'])){
				
				
				$data['milestonID'] = $milestonID;
				$data['getID'] = $getID;
				
				$data['dataArrayMassage'] = $this->user_model->massageInfo($getID,$milestonID);
				
				$this->load->view('project/milestone_view', $data);
				
			}else{
				redirect(SITE_URL.'dashboard/milestones/');
			}
		}else{
			$this->load->view('project/milestone', $data);
		}
			
	}
	
	
	public function your_details(){
		$data = array();
		$data['MSG'] = '';
		$userID = $this->session->userdata('userID');
		$userType = $this->session->userdata('userType');
		$data['dataArray'] = $this->user_model->userInfo($userID);
		$data['edit'] = isset($_GET['edit']) ? $_GET['edit'] : 'none';
		
		if(isset($_POST['submit_per']) AND $data['edit'] == 'per'){
			$BUSINESS_NAME = $this->input->post('BusinessName');
			$JOB_TITLE = $this->input->post('jobTitle');
			$FIRST_NAME = $this->input->post('FirstName');
			$SURNAME = $this->input->post('surName');
			$EMAIL_ADDRESS = $this->input->post('emailAddress');
			$PHONE_NUMBER = $this->input->post('phoneNo');
			
			$insert_data = "UPDATE 
									u_personal_information

									SET
										BUSINESS_NAME = '".addslashes($BUSINESS_NAME)."',
										JOB_TITLE = '".addslashes($JOB_TITLE)."',
										FIRST_NAME = '".addslashes($FIRST_NAME)."',
										SURNAME = '".addslashes($SURNAME)."',
										EMAIL_ADDRESS = '".addslashes($EMAIL_ADDRESS)."',
										PHONE_NUMBER = '".addslashes($PHONE_NUMBER)."'										
									WHERE ADMIN_ID = '".$userID."'
							";
			$insert = $this->db->query($insert_data);
			if($insert){
				$data['MSG'] = 'Sucessfully update your information ';
				redirect(SITE_URL.'dashboard/your_details/');
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
			}
			
			
		}
		
		
		if(isset($_POST['submit_add']) AND $data['edit'] == 'add'){
			$ADDRESS = $this->input->post('address');
			$CITY = $this->input->post('cityName');
			$POSTCODE_ZIP = $this->input->post('postCode');
			$COUNTRY = $this->input->post('Country');
			$STATE = $this->input->post('state');
			
			$insert_data = "UPDATE 
									u_personal_information

									SET
										ADDRESS = '".addslashes($ADDRESS)."',
										CITY = '".addslashes($CITY)."',
										POSTCODE_ZIP = '".addslashes($POSTCODE_ZIP)."',
										COUNTRY = '".addslashes($COUNTRY)."',
										STATE = '".addslashes($STATE)."'										
									WHERE ADMIN_ID = '".$userID."'
							";
			$insert = $this->db->query($insert_data);
			if($insert){
				$data['MSG'] = 'Sucessfully update your address ';
				redirect(SITE_URL.'dashboard/your_details/');
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
			}
			
			
		}
		
		if(isset($_POST['submit_acc']) AND $data['edit'] == 'acc'){
			$old = $this->input->post('oldPassword');
			$ADMIN_PASSWORD = $this->input->post('Password');
			$confirm = $this->input->post('confirm_Password');
			
			$check = $data['dataArray'][0]->ADMIN_PASSWORD;
			if($old == $check){
				if($ADMIN_PASSWORD == $confirm){
					$insert_data = "UPDATE 
											u_access_user

											SET
												ADMIN_PASSWORD = '".addslashes($ADMIN_PASSWORD)."'
											WHERE ADMIN_ID = '".$userID."'
									";
					$insert = $this->db->query($insert_data);
					if($insert){
						$data['MSG'] = 'Sucessfully update your password ';
						redirect(SITE_URL.'dashboard/your_details/');
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
					}
				}else{
					$data['MSG'] = '<span style="color:#a94442;">Sorry New password & Confirm password is wrong</span>';
				}
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Sorry old password is wrong</span>';
			}
		}
		
		if($userType != 'Member'){
			$this->load->view('project/your_details', $data);
		}else{
			redirect(SITE_URL.'dashboard/view_project/');
		}
		
		
	}
	
	
	
	public function invoice($getID='0', $miles= '0'){
		$data = array();
		$data['MSG'] = 'Milestone Form';
		$data['miles'] = $miles;
		$data['projectId'] = $getID;
		$data['dataArray'] = $this->user_model->projectInfo($getID);
		
		$pdff = isset($_GET['get']) ? $_GET['get'] : '';
		$data['pdf'] = $pdff;
		
		if($pdff == 'pdf'){
			
			require_once( 'pdf/phpToPDF.php');
			
			$dataArray = $this->user_model->projectInfo($getID);
			
			$company = $this->user_model->companyInfo();
			$projectType = $dataArray[0]->BID_TYPE; 
			if($projectType == 'Milestone'){ $title = 'Milestone Name';}else{$title = 'Project Name';}
			$my_html = '';
			$my_html .= ' <html>
						  <head>
						 <style>
						   table.no-border > tbody > tr > td, table.no-border > tbody > th > td{border:0px solid #ccc !important;}

							table.tablesorter{
								border: 1px solid #ccc !important;
								text-align:left;
							}

							table.tablesorter tr td, table.tablesorter tr th, table.tablesorter thead tr  th, table.tablesorter tbody tr , table.tablesorter tbody tr  td, table.tablesorter thead tr , ttable.tablesorter tfoot tr {
								font-size:12px !important;
								padding:5px;
							}
							table.tablesorter > thead {
							 
							  display: table-header-group;
							}
							table.tablesorter > tbody > tr > td, table.tablesorter > tr > td {
							  border-top: 1px solid #ccc;
							  border-right: 1px solid #ccc;
							}
							table.tablesorter > tbody > tr > td:last-child, table.tablesorter > tr > td:last-child {
								border-right: none;
							}
							header{text-align: center; width:100%;}
							h1.header {
								font: bold 13px sans-serif;
								letter-spacing: 1px;
								text-transform: uppercase;
								color: #000;
								padding: 0.4em 0;
							}
							/*h1.header {
								background: #000;
								border-radius: 0.25em;
								
								margin: 0 0 1em;
								padding: 0.4em 0;
							}*/
							
							.col-md-8 {
								-ms-flex: 0 0 66.666667%;
								flex: 0 0 66.666667%;
								max-width: 66.666667%;
								
							}
							.col-md-4 {
								-ms-flex: 0 0 33.333333%;
								flex: 0 0 33.333333%;
								max-width: 33.333333%;
								
							}
							.row{max-width:100%;}
							.col-md-12 {
								-ms-flex: 0 0 100%;
								flex: 0 0 100%;
								max-width: 100%;
							}
							b,i,p{font-size:11px;}
							.project_name_invoice {
									font-size: 15px;
									font-weight: bold;
								}
								body {
									font: .9em/.8em Arial, Helvetica, sans-serif;
									color: #000;
								}
							</style>
						  </head>
							<body>
							<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<header>
										<h1 class="header">INVOICE</h1>
									</header>
								</div>
								 <div class="col-md-8" style="padding-top:15px;float:left;">
									<span class="project_name_invoice">'.$dataArray[0]->PROJECT_NAME.' </span>
								</div>
								 <div class="col-md-4" style="padding-top:15px;float:right;">
									<p> <b>Invoice : </b> '.$dataArray[0]->REF.'</p>
									<p> <b>Date : </b> '.$this->user_model->date_format_orginal($dataArray[0]->ENT_DATE).'</p>
									<p> <b>Paid Amount : </b> &euro; '.number_format($dataArray[0]->PRICE).'</p>
								 </div>
								 
								 <div class="col-md-12" style="padding-top:25px;" >
								<div class="table-responsive">
									<table class="table table-bordered tablesorter" width="100%" cellspacing="0">
									  <thead>
									 
									<tr>
									  <th>'.$title.'</th>
									  <th>Rate</th>
									  <th>Quantity</th>
									  <th>Date</th>
									  <th>Payment</th>
									  <th>Price</th>
									 
									</tr>
								  </thead>
								  <tbody>
								';
						$Net_price = 0;
						 
						  if($projectType == 'Milestone'){
							$milses = $this->user_model->milestoneInfo($dataArray[0]->PROJECT_ID, $miles);
							foreach($milses AS $values):
							 $Net_price1 = $values->PRICE;
							
								$my_html .='<tr>
												<td> '.$values->MILESTONE_DETAILS.'  </td>
												<td> &euro; '. number_format($values->PRICE).'  </td>
												<td> <center>1 </center> </td>
												<td> '. $this->user_model->date_format_orginal($values->ENT_DATE).'  </td>
												<td> '.$values->PAYMENT_STATUS.' </td>
												<td> &euro; '. number_format($Net_price1).' </td>
											</tr>'; 
							 
							 $Net_price += $Net_price1;
							endforeach;
							
						  }else{
							
							$Net_price = $dataArray[0]->PRICE;
							
							$my_html .='<tr>
											<td> '.$dataArray[0]->PROJECT_NAME.'  </td>
											<td> &euro; '.number_format($dataArray[0]->PRICE).'  </td>
											<td> <center>1 </center> </td>
											<td> '. $this->user_model->date_format_orginal($dataArray[0]->ENT_DATE).'  </td>
											<td> &euro; '. number_format($Net_price).'  </td>
										</tr>';
						  }
							
					$my_html .= '</tbody></table>
								</div>
								</div>';
						
					$vat = ($Net_price / 100) * $company[0]->C_VAT;
				$phone = '';
				$Email = '';
				$Address = '';
				if(strlen($company[0]->C_PHONE_NUM) > 2){ $phone ='<p><b>Phone: </b>'.$company[0]->C_PHONE_NUM.'</p>'; }
				if(strlen($company[0]->C_EMAIL) > 2){ $Email ='<p><b>Email: </b>'.$company[0]->C_EMAIL.'</p>'; }
				if(strlen($company[0]->C_ADDRESS) > 2){ $Address ='<p><b>Email: </b>'.$company[0]->C_ADDRESS.'</p>'; }
				
					$my_html .='<div class="col-md-8" style="padding-top:15px; display:block;"></div>
									<div class="col-md-4" style="padding-top:15px;float:right;">
										<div class="table-responsive">
											<table class="table table-bordered tablesorter" width="100%" cellspacing="0">
												<tr>
													<td><b>Sub Total : </b> </td> <td> &euro; '.number_format($Net_price).' </td></tr>
												<tr>	
													<td><b>VAT @ '. $company[0]->C_VAT.'% : </b> </td> <td> &euro; '. number_format($vat).' </td></tr>
												<tr>	
													<td><b>Total : </b> </td> <td> &euro; '. number_format($Net_price + $vat).' </td></tr>
												<tr>	
													<td><b>Due Amount : </b> </td> <td> &euro; 0 </td>
												</tr>
											</table>
										</div>
										
									 </div>
									 <div class="col-md-12" style="padding-top:25px;display:block;">
										<h3> '. $company[0]->C_COMPANY_NAME.'<span style="font-size:13px;"> '. $company[0]->C_SUB_TITLE.'</span></h3>
										
									</div>
									<div class="col-md-12" style="padding-top:5px;">
										'.$phone.'
										'.$Email.'
										'.$Address.'
									</div>';
										
					$my_html .= '		
							</div>
						</div>
						</body>
						</html>
						';
			$type = isset($_GET['save']) ? $_GET['save'] : 'view';
			$pdf_options = array(
								  "source_type" => 'html',
								  "source" => $my_html,
								  "footer" => 'Page phptopdf_on_page_number of phptopdf_pages_total',
								  "action" => $type,
								  "save_directory" => 'pdf/file/',
								  "beta" => true,
								  "file_name" => 'pdf_invoice__'.time().'.pdf');
			  
			//$file_upload = "http://v2.potatobd.com/pdf/file/".$pdf_options['file_name']."";
			
			
			phptopdf($pdf_options);
			
		}else{
			$this->load->view('project/invoice', $data);
		}
	}
	
	
	
}

?>