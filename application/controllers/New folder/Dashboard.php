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
		redirect(SITE_URL.'dashboard/view_project/');
		$this->load->view('index', $data);		
	}
	
	public function add_project($id=''){
		$data = array();
		
		$userID = $this->session->userdata('userID');
		$projectType = $this->session->userdata('projectType');
		$data['project'] = $this->user_model->projectTypeInfo($projectType);
		
		$data['MSG'] = ''.$data['project'][0]->P_TYPE_NAME.' Order Form';
		
		$data['type'] = $projectType;
		
		
		if($id > 0){
			$dataArray = $this->user_model->projectInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['PROJECT_NAME'] = $dataArray[0]->PROJECT_NAME;
				$data['PRICE'] = $dataArray[0]->PRICE;
				$data['PROJECT_ID'] = $dataArray[0]->PROJECT_ID;
				$data['WEBSITE_URL'] = $dataArray[0]->WEBSITE_URL;
				$data['VIDEO_TYPE'] = $dataArray[0]->VIDEO_TYPE;
				$data['VOICEOVER_TYPE'] = $dataArray[0]->VOICEOVER_TYPE;
				$data['MUSIC_TYPE'] = $dataArray[0]->MUSIC_TYPE;
				$data['FILE_UPLOAD'] =  $dataArray[0]->FILE_UPLOAD;
				$data['DETAILS_OF_VIDEO'] = $dataArray[0]->DETAILS_OF_VIDEO;
				
				$data['BUTON'] = 'Edit';
				$edit = 1;
			}else{
				$data['PROJECT_NAME'] = '';
				$data['PRICE'] = '';
				$data['PROJECT_ID'] = '';				
				$data['WEBSITE_URL'] = '';				
				$data['VIDEO_TYPE'] = '';				
				$data['VOICEOVER_TYPE'] = '';				
				$data['MUSIC_TYPE'] = '';				
				$data['FILE_UPLOAD'] = '';				
				$data['DETAILS_OF_VIDEO'] = '';				
				$data['BUTON'] = 'Add';
				$edit = 0;
			}
		}else{
			$data['PROJECT_NAME'] = '';
			$data['PRICE'] = '';
			$data['PROJECT_ID'] = '';			
			$data['WEBSITE_URL'] = '';			
			$data['VIDEO_TYPE'] = '';			
			$data['VOICEOVER_TYPE'] = '';			
			$data['MUSIC_TYPE'] = '';			
			$data['FILE_UPLOAD'] = '';			
			$data['DETAILS_OF_VIDEO'] = '';			
			$data['BUTON'] = 'Add';
			$edit = 0;
			
		}
		if(isset($_POST['submit'])){
			$PROJECT_NAME = $this->input->post('ProjectName');
			$PRICE		  = $this->input->post('PRICE');
			$WEBSITE_URL = $this->input->post('websiteAddress');
			$VIDEO_TYPE = $this->input->post('vedio_type');
			$VOICEOVER_TYPE = $this->input->post('voice_over_type');
			$MUSIC_TYPE = $this->input->post('music_type');
			$DETAILS_OF_VIDEO = $this->input->post('details');
			$PROJECT_STATUS = 'Active';
			
			$uploadfile = $data['FILE_UPLOAD'];
			$FILE_UPLOAD = $_FILES['file']['name'];
			if(strlen($FILE_UPLOAD) > 4){
				$uploaddir = 'upload/project/';
				$uploadfile = $uploaddir .time().'-'. basename($_FILES['file']['name']);

				if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
					
				} 
			}
			//echo $uploadfile;exit;
			$REF = $userID.$this->user_model->max_any_where('p_project','PROJECT_ID', '');
			
			if(strlen($PROJECT_NAME) > 4){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM p_project WHERE PROJECT_NAME = '".addslashes($PROJECT_NAME)."' AND ENT_USER = '".addslashes($userID)."'");
					$count = $query->num_rows();
					if($count == 0){
						$insert_data = "INSERT INTO 
													p_project
													(
														PROJECT_NAME,
														PRICE,
														WEBSITE_URL,
														REF,
														VIDEO_TYPE,
														VOICEOVER_TYPE,
														MUSIC_TYPE,
														FILE_UPLOAD,
														DETAILS_OF_VIDEO,
														ENT_DATE,
														ENT_USER,
														PROJECT_STATUS 
													)
													VALUES
													(
														'".addslashes($PROJECT_NAME)."',
														'".addslashes($PRICE)."',
														'".addslashes($WEBSITE_URL)."',
														'".addslashes($REF)."',
														'".addslashes($VIDEO_TYPE)."',
														'".addslashes($VOICEOVER_TYPE)."',
														'".addslashes($MUSIC_TYPE)."',
														'".addslashes($uploadfile)."',
														'".addslashes($DETAILS_OF_VIDEO)."',
														'".date("Y-m-d")."',
														'".addslashes($userID)."',
														'".addslashes($PROJECT_STATUS)."'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$id = $this->db->insert_id();
							$data['MSG'] = '<span style="color:green;">Successfully submitted Project</span>';
							redirect(SITE_URL.'dashboard/view_project/'.$id.'/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already submitted Project</span>';
					}
				
				}else{
					//if($id != $PARENT_CATE_ID){
						$insert_data = "UPDATE 
												p_project

												SET
													PROJECT_NAME = '".addslashes($PROJECT_NAME)."',
													PRICE = '".addslashes($PRICE)."',
													WEBSITE_URL = '".addslashes($WEBSITE_URL)."',
													VIDEO_TYPE = '".addslashes($VIDEO_TYPE)."',
													VOICEOVER_TYPE = '".addslashes($VOICEOVER_TYPE)."',
													MUSIC_TYPE = '".addslashes($MUSIC_TYPE)."',
													FILE_UPLOAD = '".addslashes($uploadfile)."',
													DETAILS_OF_VIDEO = '".addslashes($DETAILS_OF_VIDEO)."',
													PROJECT_STATUS = '".addslashes($PROJECT_STATUS)."'
												WHERE PROJECT_ID = '".$id."'
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$data['MSG'] = '<span style="color:green;">Successfully updated Project</span>';
							redirect(SITE_URL.'dashboard/view_project/'.$id.'/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					//}
				}
			}else{
				$data['MSG'] = 'Please enter Project name';
			}
		}
		$this->load->view('project/add_project', $data);	
	}
	
	
	public function view_project($getID='0'){
		$data = array();
		$data['MSG'] = '';
		$userID = $this->session->userdata('userID');
		if($getID > 0){
			$data['dataArray'] = $this->user_model->projectInfo($getID);
			$data['dataArrayMile'] = $this->user_model->milestoneInfo($getID);
			$data['dataArrayMassage'] = $this->user_model->massageInfo($getID);
			
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
						$insert_data = "INSERT INTO 
													p_massage
													(
														PROJECT_ID,
														FROM_ID,
														MASSAGE_BODY,
														ATTACH_FILE, 
														ENT_DATE, 
														ENT_TIME, 
														ENT_USER, 
														MASSAGE_STATUS 
													)
													VALUES
													(
														'".addslashes($getID)."',
														'".addslashes($userID)."',
														'".addslashes($massage)."',
														'".addslashes($uploadfile)."',
														'".date("Y-m-d")."',
														'".date("h:i:s")."',
														'".addslashes($userID)."',
														'".addslashes($PROJECT_STATUS)."'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$data['MSG'] = '<span style="color:green;"> -- Successfully submitted your comments</span>';
							redirect(SITE_URL.'dashboard/view_project/'.$getID.'/#massage');
						}else{
							$data['MSG'] = '<span style="color:#a94442;"> -- Systen error</span>';
						}
					}
				}
			}
			
			$this->load->view('project/view_project_details', $data);
		}else{
			$data['dataArray'] = $this->user_model->projectInfo();
			$this->load->view('project/view_project', $data);
		}
	}
	
	public function download(){
		$file = isset($_GET['file']) ? $_GET['file'] : '';
		return $this->user_model->download($file);
	}
	
	
	public function documents(){
		$data = array();
		$data['MSG'] = 'Video Order Form';
		$data['dataArray'] = $this->user_model->projectInfo();
		$this->load->view('project/document', $data);
	}
	
	public function milestones(){
		$data = array();
		$data['MSG'] = 'Milestone Form';
		$data['dataArray'] = $this->user_model->projectInfo();
		$this->load->view('project/milestone', $data);
	}
	
	public function team_details(){
		$data = array();
		$data['MSG'] = 'Milestone Form';
		$data['dataArray'] = $this->user_model->projectInfo();
		$this->load->view('project/team_details', $data);
	}
	
	public function your_details(){
		$data = array();
		$data['MSG'] = '';
		$userID = $this->session->userdata('userID');
		
		$data['dataArray'] = $this->user_model->userInfo($userID);
		$data['edit'] = isset($_GET['edit']) ? $_GET['edit'] : 'none';
		
		if(isset($_POST['submit_per']) AND $data['edit'] == 'per'){
			$BUSINESS_NAME = $this->input->post('BusinessName');
			$FIRST_NAME = $this->input->post('FirstName');
			$SURNAME = $this->input->post('surName');
			$EMAIL_ADDRESS = $this->input->post('emailAddress');
			$PHONE_NUMBER = $this->input->post('phoneNo');
			
			$insert_data = "UPDATE 
									u_personal_information

									SET
										BUSINESS_NAME = '".addslashes($BUSINESS_NAME)."',
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
		
		$this->load->view('project/your_details', $data);
	}
	
	
	
	public function invoice($getID='0'){
		$data = array();
		$data['MSG'] = 'Milestone Form';
		$data['dataArray'] = $this->user_model->projectInfo($getID);
		$this->load->view('project/invoice', $data);
	}
	
}

?>