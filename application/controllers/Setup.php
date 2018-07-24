<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class setup extends CI_Controller {

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
	
	
	public function add_user($id=''){
		$data = array();
		$data['MSG'] = 'Add Client';
		$data['BUTON'] = 'Add Client';
		$data['dataArrayMile'] = $this->user_model->userInfo();
		
		$userID = $this->session->userdata('userID');
		$userType = $this->session->userdata('userType');
		if($id > 0 AND $userType == 'Admin'){
			$dataArray = $this->user_model->userInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['ADMIN_ID'] = $dataArray[0]->ADMIN_ID;
				$data['ADMIN_NAME'] = $dataArray[0]->ADMIN_NAME;
				$data['ADMIN_LOGIN_NAME'] = $dataArray[0]->ADMIN_LOGIN_NAME;
				$data['ADMIN_EMAIL'] = $dataArray[0]->ADMIN_EMAIL;
				$data['ADMIN_PASSWORD'] = $dataArray[0]->ADMIN_PASSWORD;
				$data['ADMIN_TYPE'] = $dataArray[0]->ADMIN_TYPE;
				$data['PROJECT_TYPE'] = $dataArray[0]->PROJECT_TYPE;
				
				$data['ADMIN_STATUS'] = $dataArray[0]->ADMIN_STATUS;
				
				$data['BUTON'] = 'Edit Client';
				$edit = 1;
			}else{
				$data['ADMIN_ID'] = '0';
				$data['ADMIN_NAME'] = '';
				$data['ADMIN_LOGIN_NAME'] = '';
				$data['ADMIN_EMAIL'] = '';
				$data['ADMIN_PASSWORD'] = '';
				$data['ADMIN_TYPE'] = '';
				$data['PROJECT_TYPE'] = '';
				$data['ADMIN_STATUS'] = '';
				$edit = 0;
			}
		}else{
			$data['ADMIN_ID'] = '0';
			$data['ADMIN_NAME'] = '';
			$data['ADMIN_LOGIN_NAME'] = '';
			$data['ADMIN_EMAIL'] = '';
			$data['ADMIN_PASSWORD'] = '';
			$data['ADMIN_TYPE'] = '';
			$data['PROJECT_TYPE'] = '';
			$data['ADMIN_STATUS'] = '';
			$edit = 0;
			
		}
		if(isset($_POST['submit'])){
			$ADMIN_NAME = $this->input->post('ClientsName');
			$ADMIN_LOGIN_NAME = $this->input->post('LoginName');
			$ADMIN_EMAIL = $this->input->post('email_address');
			$ADMIN_PASSWORD = $this->input->post('password');
			$ADMIN_TYPE = $this->input->post('usertype');
			$PROJECT_TYPE = $this->input->post('projecttype');
			
			$ADMIN_STATUS = 'Active';
			
			if(strlen($ADMIN_NAME) > 4 AND strlen($ADMIN_LOGIN_NAME) > 3 AND strlen($ADMIN_EMAIL) > 4){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM u_access_user WHERE ADMIN_LOGIN_NAME = '".addslashes($ADMIN_LOGIN_NAME)."' OR ADMIN_EMAIL = '".addslashes($ADMIN_EMAIL)."'");
					$count = $query->num_rows();
					if($count == 0){
						$insert_data = "INSERT INTO 
													u_access_user
													(
														ADMIN_NAME,
														ADMIN_LOGIN_NAME,														
														ADMIN_EMAIL,														
														ADMIN_PASSWORD,														
														ADMIN_TYPE,														
														PROJECT_TYPE,														
														ENT_USER,														
														ENT_DATE,														
														ADMIN_STATUS 
													)
													VALUES
													(
														'".addslashes($ADMIN_NAME)."',
														'".addslashes($ADMIN_LOGIN_NAME)."',														
														'".addslashes($ADMIN_EMAIL)."',														
														'".addslashes($ADMIN_PASSWORD)."',														
														'".addslashes($ADMIN_TYPE)."',														
														'".addslashes($PROJECT_TYPE)."',														
														'".addslashes($userID)."',														
														'".date("Y-m-d")."',														
														'".addslashes($ADMIN_STATUS)."'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$ADMIN_ID = $this->db->insert_id();
							$insert_data_per = "INSERT INTO 
														u_personal_information
														(
															FIRST_NAME,
															EMAIL_ADDRESS,														
															ADMIN_ID,														
															END_DATE,														
															PER_STATUS 
														)
														VALUES
														(
															'".addslashes($ADMIN_NAME)."',
															'".addslashes($ADMIN_EMAIL)."',														
															'".addslashes($ADMIN_ID)."',														
															'".date("Y-m-d")."',														
															'".addslashes($ADMIN_STATUS)."'
														)
											
											";
								$insert = $this->db->query($insert_data_per);
							$data['MSG'] = '<span style="color:green;">Successfully added user</span>';
							redirect(SITE_URL.'setup/add_user/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already added user</span>';
					}
				
				}else{
						if($data['ADMIN_ID'] == 1){
							$ADMIN_STATUS = 'Active';
							$ADMIN_TYPE = 'Admin';
						}else{
							$ADMIN_STATUS 	= $this->input->post('ADMIN_STATUS');
							$ADMIN_TYPE 	= $this->input->post('usertype');
						}
						
			
						$insert_data = "UPDATE 
												u_access_user

												SET
													ADMIN_NAME = '".addslashes($ADMIN_NAME)."',
													ADMIN_LOGIN_NAME = '".addslashes($ADMIN_LOGIN_NAME)."',
													ADMIN_EMAIL = '".addslashes($ADMIN_EMAIL)."',
													ADMIN_PASSWORD = '".addslashes($ADMIN_PASSWORD)."',
													ADMIN_TYPE = '".addslashes($ADMIN_TYPE)."',
													PROJECT_TYPE = '".addslashes($PROJECT_TYPE)."',
													ADMIN_STATUS = '".addslashes($ADMIN_STATUS)."'
												WHERE ADMIN_ID = '".$id."'
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$data['MSG'] = '<span style="color:green;">Successfully updated user</span>';
							redirect(SITE_URL.'setup/add_user/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
				
				}
			}else{
				$data['MSG'] = 'Please enter user name';
			}
		}
		if($userType == 'Admin'){
			$this->load->view('setup/add_clients', $data);
		}else{
			redirect(SITE_URL.'setup/team_details/');
		}
	}
	
	public function team_details($id='',$get='show'){
		$data = array();
		$data['MSG'] = 'Team Details';
			
		$data['BUTON'] = 'Add member';
		
		$userID = $this->session->userdata('userID');
		$userType = $this->session->userdata('userType');
		$projectType = $this->session->userdata('projectType');
		$data['dataArrayMile'] = $this->user_model->userInfo('0','*',$userID);
		$data['get'] = $get;
		
		if($userID > 0 AND $userType == 'Client'){
			
			if($id > 0){
				if($get == 'invite'){
				$data['MSG'] = '';
				 if(isset($_POST['permision'])){
					$invititation = $this->input->post('invititation');
					$this->db->delete('p_project_access', array('ENT_USER' => $id, 'TYPE_ACCESS' => 'Child'));
						
					if(is_array($invititation) AND sizeof($invititation) > 0){	
						foreach($invititation as $dataA){
							if(strlen($dataA) > 0){
								$insertD = array();
								$insertD['PRODUCT_ID'] = $dataA;
								$insertD['ENT_USER'] = $id;
								$insertD['PERMISION'] = 'Edit';
								$insertD['TYPE_ACCESS'] = 'Child';
								$insertD['P_STATUS'] = 'Active';
								
								if($this->db->insert('p_project_access', $insertD)){
									$data['MSG'] = 'Successfuly permite for those projects';
								
								}else{
									$data['MSG'] = 'System error';
									//redirect(SITE_URL.'setup/team_details/');
								}
							}
							
						}
						redirect(SITE_URL.'setup/team_details/');
					}
				 }
				 
				 /*Access for project*/
				$queryRow = $this->db->query("SELECT PRODUCT_ID FROM p_project_access WHERE ENT_USER = '".$id."' AND P_STATUS = 'Active' ORDER BY P_STATUS DESC");
				if(is_array($queryRow->result()) AND sizeof($queryRow->result()) > 0){
					$array = array();
					$i = 0;
					foreach($queryRow->result() AS $value){
						
						$array[$i] = $value->PRODUCT_ID;
						$i++;
					}
					$data['array'] = $array;
				}else{
					$data['array'] = array();
				}
					
			
					/*Access for project end */
			 }
			$dataArray = $this->user_model->userInfo($id,'*',$userID);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['ADMIN_ID'] = $dataArray[0]->ADMIN_ID;
				$data['ADMIN_NAME'] = $dataArray[0]->ADMIN_NAME;
				$data['ADMIN_LOGIN_NAME'] = $dataArray[0]->ADMIN_LOGIN_NAME;
				$data['ADMIN_EMAIL'] = $dataArray[0]->ADMIN_EMAIL;
				$data['ADMIN_PASSWORD'] = $dataArray[0]->ADMIN_PASSWORD;
				$data['ADMIN_TYPE'] = $dataArray[0]->ADMIN_TYPE;
				$data['PROJECT_TYPE'] = $dataArray[0]->PROJECT_TYPE;
				
				$data['ADMIN_STATUS'] = $dataArray[0]->ADMIN_STATUS;
				
				$data['BUTON'] = 'Edit member';
				$edit = 1;
			}else{
				$data['ADMIN_ID'] = '';
				$data['ADMIN_NAME'] = '';
				$data['ADMIN_LOGIN_NAME'] = '';
				$data['ADMIN_EMAIL'] = '';
				$data['ADMIN_PASSWORD'] = '';
				$data['ADMIN_TYPE'] = '';
				$data['PROJECT_TYPE'] = '';
				$data['ADMIN_STATUS'] = '';
				$edit = 0;
			}
		}else{
			$data['ADMIN_ID'] = '';
			$data['ADMIN_NAME'] = '';
			$data['ADMIN_LOGIN_NAME'] = '';
			$data['ADMIN_EMAIL'] = '';
			$data['ADMIN_PASSWORD'] = '';
			$data['ADMIN_TYPE'] = '';
			$data['PROJECT_TYPE'] = '';
			$data['ADMIN_STATUS'] = '';
			$edit = 0;
			
		}
		if(isset($_POST['submit'])){
			$ADMIN_NAME = $this->input->post('ClientsName');
			$ADMIN_LOGIN_NAME = $this->input->post('LoginName');
			$ADMIN_EMAIL = $this->input->post('email_address');
			$ADMIN_PASSWORD = $this->input->post('password');
			$ADMIN_TYPE = 'Member';
			$PROJECT_TYPE = $projectType;
			
			$ADMIN_STATUS = 'Active';
			
			if(strlen($ADMIN_NAME) > 3 AND strlen($ADMIN_LOGIN_NAME) > 3 AND strlen($ADMIN_EMAIL) > 4){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM u_access_user WHERE ADMIN_LOGIN_NAME = '".addslashes($ADMIN_LOGIN_NAME)."' OR ADMIN_EMAIL = '".addslashes($ADMIN_EMAIL)."'");
					$count = $query->num_rows();
					if($count == 0){
						$insert_data = "INSERT INTO 
													u_access_user
													(
														ADMIN_NAME,
														ADMIN_LOGIN_NAME,														
														ADMIN_EMAIL,														
														ADMIN_PASSWORD,														
														ADMIN_TYPE,														
														PROJECT_TYPE,														
														ENT_USER,														
														ENT_DATE,														
														ADMIN_STATUS 
													)
													VALUES
													(
														'".addslashes($ADMIN_NAME)."',
														'".addslashes($ADMIN_LOGIN_NAME)."',														
														'".addslashes($ADMIN_EMAIL)."',														
														'".addslashes($ADMIN_PASSWORD)."',														
														'".addslashes($ADMIN_TYPE)."',														
														'".addslashes($PROJECT_TYPE)."',														
														'".addslashes($userID)."',														
														'".date("Y-m-d")."',														
														'".addslashes($ADMIN_STATUS)."'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$ADMIN_ID = $this->db->insert_id();
							$insert_data_per = "INSERT INTO 
														u_personal_information
														(
															FIRST_NAME,
															EMAIL_ADDRESS,														
															ADMIN_ID,														
															END_DATE,														
															PER_STATUS 
														)
														VALUES
														(
															'".addslashes($ADMIN_NAME)."',
															'".addslashes($ADMIN_EMAIL)."',														
															'".addslashes($ADMIN_ID)."',														
															'".date("Y-m-d")."',														
															'".addslashes($ADMIN_STATUS)."'
														)
											
											";
								$insert = $this->db->query($insert_data_per);
							$data['MSG'] = '<span style="color:green;">Successfully added Member</span>';
							redirect(SITE_URL.'setup/add_user/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already added Member</span>';
					}
				
				}else{
						if($data['ADMIN_TYPE'] == 'Client'){
							$ADMIN_STATUS = 'Active';
						}else{
							$ADMIN_STATUS = $this->input->post('ADMIN_STATUS');
						}
						$insert_data = "UPDATE 
												u_access_user

												SET
													ADMIN_NAME = '".addslashes($ADMIN_NAME)."',
													ADMIN_LOGIN_NAME = '".addslashes($ADMIN_LOGIN_NAME)."',
													ADMIN_EMAIL = '".addslashes($ADMIN_EMAIL)."',
													ADMIN_PASSWORD = '".addslashes($ADMIN_PASSWORD)."',
													ADMIN_STATUS = '".addslashes($ADMIN_STATUS)."'
												WHERE ADMIN_ID = '".$id."' AND ENT_USER = '".$userID."'
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$data['MSG'] = '<span style="color:green;">Successfully updated Member</span>';
							redirect(SITE_URL.'setup/add_user/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					
				}
			}else{
				$data['MSG'] = 'Please enter user name';
			}
			
		}
		
			
		
		$this->load->view('setup/team_details', $data);
			
		}else{
			redirect(SITE_URL.'dashboard/view_project/');
		}
		
	}
	
	public function project_type($id=''){
		$data = array();
		$data['MSG'] = 'Add Project Type';
		$data['BUTON'] = 'Add Type';
		$data['dataArrayMile'] = $this->user_model->projectTypeInfo();
		
		$userID = $this->session->userdata('userID');
		$userType = $this->session->userdata('userType');
		
		$data['set'] = isset($_GET['set']) ? $_GET['set'] : '0';
		
		if(isset($_POST['submit_save'])){
			$htmlFiled = htmlspecialchars(trim($this->input->post('htmlFiled')));
			$num = $this->input->post('number');
			$insert_data = "UPDATE 
									s_project_type

									SET
										HTML_POSITION = '".addslashes($htmlFiled)."',
										LIMIT_ITEM = '".addslashes($num)."'
									WHERE P_TYPE_ID = '".$data['set']."'
							";
			$insert = $this->db->query($insert_data);
		}
		
		if($id > 0 AND $userType == 'Admin'){
			$dataArray = $this->user_model->projectTypeInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['P_TYPE_ID'] = $dataArray[0]->P_TYPE_ID;
				$data['P_TYPE_NAME'] = $dataArray[0]->P_TYPE_NAME;
				$data['P_STATUS'] = $dataArray[0]->P_STATUS;
				$data['BUTON'] = 'Edit Type';
				$edit = 1;
			}else{
				$data['P_TYPE_ID'] = '';
				$data['P_TYPE_NAME'] = '';
				$data['P_STATUS'] = '';
				$edit = 0;
			}
		}else{
			$data['P_TYPE_ID'] = '';
			$data['P_TYPE_NAME'] = '';
			$data['P_STATUS'] = '';
			$edit = 0;
			
		}
		if(isset($_POST['submit'])){
			$P_TYPE_NAME = $this->input->post('ClientsName');
			
			$P_STATUS = 'Active';
			
			if(strlen($P_TYPE_NAME) > 4){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM s_project_type WHERE P_TYPE_NAME = '".addslashes($P_TYPE_NAME)."'");
					$count = $query->num_rows();
					if($count == 0){
						$insert_data = "INSERT INTO 
													s_project_type
													(
														P_TYPE_NAME,
																											
														P_STATUS 
													)
													VALUES
													(
														'".addslashes($P_TYPE_NAME)."',
														'".addslashes($P_STATUS)."'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							
							
							
							$data['MSG'] = '<span style="color:green;">Successfully added type</span>';
							redirect(SITE_URL.'setup/project_type/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already added type</span>';
					}
				
				}else{
					//if($id != $PARENT_CATE_ID){
						$insert_data = "UPDATE 
												s_project_type

												SET
													P_TYPE_NAME = '".addslashes($P_TYPE_NAME)."',
													P_STATUS = '".addslashes($P_STATUS)."'
												WHERE P_TYPE_ID = '".$id."'
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$data['MSG'] = '<span style="color:green;">Successfully updated type</span>';
							redirect(SITE_URL.'setup/project_type/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					//}
				}
			}else{
				$data['MSG'] = 'Please enter type name';
			}
		}
		if($userType == 'Admin'){
			$this->load->view('setup/add_project_type', $data);
		}
	}
	
	public function filed_item($id=''){
		$data = array();
		$data['MSG'] = 'Add Filed item';
		$data['BUTON'] = 'Add Item';
		$data['dataArrayMile'] = $this->user_model->filedItemInfo();
		
		$userID = $this->session->userdata('userID');
		$userType = $this->session->userdata('userType');
		
		/**delete option**/
			$delete = isset($_GET['delete']) ? $_GET['delete'] : '0';
			
		if($userType == 'Admin' AND $delete > 0){
			$dataArray1 = $this->user_model->filedItemInfo($delete);
			$fild = $dataArray1[0]->FILED_NAME;
			$PROJECT_TYPE = $dataArray1[0]->PROJECT_TYPE;
				
			if($this->db->query("DELETE FROM s_filed_type WHERE FILED_ID = '".addslashes($delete)."'")){
				
				$this->user_model->updateFiled($PROJECT_TYPE);
				
				$query = $this->db->query("SELECT * FROM s_filed_type WHERE FILED_NAME = '".addslashes($fild)."'");
				$count = $query->num_rows();
				if($count == 0){
					$this->db->query("ALTER TABLE `p_project` DROP `".$fild."`");
				}
				redirect(SITE_URL.'setup/filed_item/');
			}
			
		}
		/**delete option end**/
		
		if($id > 0 AND $userType == 'Admin'){
			

			$dataArray = $this->user_model->filedItemInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['FILED_ID'] = $dataArray[0]->FILED_ID;
				$data['FIELD_TITLE'] = $dataArray[0]->FIELD_TITLE;
				$data['FILED_NAME'] = $dataArray[0]->FILED_NAME;
				$data['FILED_HTML'] = $dataArray[0]->FILED_HTML;
				$data['HTML_TYPE'] = $dataArray[0]->HTML_TYPE;
				$data['PROJECT_TYPE'] = $dataArray[0]->PROJECT_TYPE;
				
				$data['FILED_STATUS'] = $dataArray[0]->FILED_STATUS;
				
				$data['BUTON'] = 'Edit Item';
				$edit = 1;
			}else{
				$data['FILED_ID'] = '';
				$data['FIELD_TITLE'] = '';
				$data['FILED_NAME'] = '';
				$data['FILED_HTML'] = '';
				$data['HTML_TYPE'] = '';
				$data['PROJECT_TYPE'] = '';
				$data['PROJECT_TYPE'] = '';
				
				$data['FILED_STATUS'] = '';
				$edit = 0;
			}
		}else{
			$data['FILED_ID'] = '';
			$data['FIELD_TITLE'] = '';
			$data['FILED_NAME'] = '';
			$data['FILED_HTML'] = '';
			$data['PROJECT_TYPE'] = '';
			$data['HTML_TYPE'] = '';
			$data['PROJECT_TYPE'] = '';
			
			$data['FILED_STATUS'] = '';
			$edit = 0;
			
		}
		if(isset($_POST['submit'])){
			$FIELD_TITLE = $this->input->post('filedName');
			$FILED_NAME = trim($this->input->post('filedDatabase'));
			$FILED_HTML = htmlspecialchars($this->input->post('htmlFiled'));
			$HTML_TYPE = $this->input->post('radioType');
			$PROJECT_TYPE = $this->input->post('projecttype');
			
			$FILED_STATUS = 'Active';
			
			if(strlen($FILED_HTML) > 4){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM s_filed_type WHERE FILED_NAME = '".addslashes($FILED_NAME)."' AND PROJECT_TYPE = '".addslashes($PROJECT_TYPE)."'");
					$count = $query->num_rows();
					if($count == 0){
						$insert_data = "INSERT INTO 
													s_filed_type
													(
														FILED_NAME,
														FIELD_TITLE,
														FILED_HTML,
														HTML_TYPE,
														PROJECT_TYPE,
														ENT_DATE,
														ENT_USER,
														FILED_STATUS 
													)
													VALUES
													(
														'".addslashes($FILED_NAME)."',
														'".addslashes($FIELD_TITLE)."',
														'".addslashes($FILED_HTML)."',
														'".addslashes($HTML_TYPE)."',
														'".addslashes($PROJECT_TYPE)."',
														'".date("Y-m-d")."',
														'".addslashes($FILED_STATUS)."',
														'".addslashes($userID)."'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$id_set = $this->db->insert_id();
							$result = $this->db->query("SHOW COLUMNS FROM `p_project` LIKE '".$FILED_NAME."'");
							if($result->num_rows() == 0){
								$projectI = $this->user_model->projectTypeInfo($PROJECT_TYPE);
								$comments = $projectI[0]->P_TYPE_NAME;
								$this->db->query("ALTER TABLE `p_project` ADD `".$FILED_NAME."` MEDIUMTEXT  COMMENT  'sub table - ".$comments."' AFTER `REF`");
							}
							
							$this->user_model->updateFiled($PROJECT_TYPE);
							
							$data['MSG'] = '<span style="color:green;">Successfully added filed</span>';
							//redirect(SITE_URL.'setup/filed_item/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already added filed</span>';
					}
				
				}else{
					//if($id != $PARENT_CATE_ID){
						$FILED_STATUS = $this->input->post('usertype');
						$insert_data = "UPDATE 
												s_filed_type

												SET
													FILED_NAME = '".addslashes($FILED_NAME)."',
													FIELD_TITLE = '".addslashes($FIELD_TITLE)."',
													FILED_HTML = '".addslashes($FILED_HTML)."',
													HTML_TYPE = '".addslashes($HTML_TYPE)."',
													PROJECT_TYPE = '".addslashes($PROJECT_TYPE)."',
													FILED_STATUS = '".addslashes($FILED_STATUS)."'
												WHERE FILED_ID = '".$id."'
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							
							$this->user_model->updateFiled($PROJECT_TYPE);
							$data['MSG'] = '<span style="color:green;">Successfully updated filed</span>';
							redirect(SITE_URL.'setup/filed_item/');
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					//}
				}
			}else{
				$data['MSG'] = 'Please enter type name';
			}
		}
		if($userType == 'Admin'){
			$this->load->view('setup/add_filed_item', $data);
		}
	}

	public function company_setting(){
		$data = array();
		$data['MSG'] = '';
		$userID = $this->session->userdata('userID');
		$userType = $this->session->userdata('userType');
		$companyID = $this->session->userdata('companyID');
		
		$data['dataArray'] = $this->user_model->companyInfo($companyID);
		$data['edit'] = isset($_GET['edit']) ? $_GET['edit'] : 'none';
		
		if(isset($_POST['submit_per']) AND $data['edit'] == 'per'){
			$C_COMPANY_NAME = $this->input->post('BusinessName');
			$C_SUB_TITLE = $this->input->post('FirstName');
			$C_EMAIL = $this->input->post('emailAddress');
			$C_PHONE_NUM = $this->input->post('phoneNo');
			$C_ADDRESS = htmlspecialchars($this->input->post('address'));
			
			$insert_data = "UPDATE 
									c_company

									SET
										C_COMPANY_NAME = '".addslashes($C_COMPANY_NAME)."',
										C_SUB_TITLE = '".addslashes($C_SUB_TITLE)."',
										C_PHONE_NUM = '".addslashes($C_PHONE_NUM)."',
										C_EMAIL = '".addslashes($C_EMAIL)."',
										C_ADDRESS = '".$C_ADDRESS."'										
									WHERE COMPANY_ID = '".$companyID."'
							";
			$insert = $this->db->query($insert_data);
			if($insert){
				$data['MSG'] = 'Sucessfully update your information ';
				redirect(SITE_URL.'setup/company_setting/');
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
			}
			
			
		}
		
		
		if(isset($_POST['submit_add']) AND $data['edit'] == 'add'){
			
			$FILE_UPLOAD = $_FILES['logo']['name'];
			if(strlen($FILE_UPLOAD) > 4){
				$uploaddir = 'image/';
				$uploadfile = time().'-'. basename($_FILES['logo']['name']);

				if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploaddir.$uploadfile)) {
					
				}

				$insert_data = "UPDATE 
									c_company
								SET
									C_LOGO = '".addslashes($uploadfile)."'
								WHERE COMPANY_ID = '".$companyID."'
							";
				$insert = $this->db->query($insert_data);
				if($insert){
					$data['MSG'] = 'Sucessfully update your logo ';
					redirect(SITE_URL.'setup/company_setting/');
				}else{
					$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
				}
					
			}

			
			
		}
		
		if(isset($_POST['submit_acc']) AND $data['edit'] == 'acc'){
				$C_VAT = $this->input->post('vat');
			
				$insert_data = "UPDATE 
									c_company
								SET
									C_VAT = '".addslashes($C_VAT)."'
								WHERE COMPANY_ID = '".$companyID."'
							";
				$insert = $this->db->query($insert_data);
				if($insert){
					$data['MSG'] = 'Sucessfully update your vat ';
					redirect(SITE_URL.'setup/company_setting/');
				}else{
					$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
				}
					
			
		}
		
		
		if($userType == 'Admin'){
			$this->load->view('setup/company_setting', $data);
		}else{
			redirect(SITE_URL.'dashboard/view_project/');
		}
		
		
	}

	public function terms_condition(){
		$data = array();
		$data['MSG'] = 'Terms & Condiction';
		$data['dataArray'] = $this->user_model->projectInfo();
		$this->load->view('setup/terms', $data);
	}
	
	
	
}	