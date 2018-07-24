<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {


	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('user_model'));
	}
	
	public function index()
	{
		$data = array();
		$data['MSG'] = 'Login';
		if(isset($_POST['submit'])){
			$username = $this->input->post('exampleInputEmail1');
			$password = $this->input->post('exampleInputPassword1');
			
			$company = $this->user_model->companyInfo();
			
			if(strlen($username) > 0 AND strlen($password) > 0){
				$query = $this->db->query("SELECT * FROM u_access_user WHERE (ADMIN_LOGIN_NAME = '".addslashes($username)."' OR ADMIN_EMAIL = '".addslashes($username)."') AND ADMIN_PASSWORD = '".$password."' ");
				$count = $query->num_rows();
				if($count == 1){
					$userData = $query->row();
					if($userData->ADMIN_STATUS == 'Active'){
						if(isset($userData)){
							$newdata = array(
									'userID'  		=> $userData->ADMIN_ID,
									'adminName'     => $userData->ADMIN_LOGIN_NAME,
									'userName'      => $userData->ADMIN_NAME,
									'userType'      => $userData->ADMIN_TYPE,
									'projectType'   => $userData->PROJECT_TYPE,
									'refer'     	=> $userData->ENT_USER,
									'companyID'     => $company[0]->COMPANY_ID,
									'logged_in' => TRUE
							);
							$this->session->set_userdata($newdata);
						}else{
							$data['MSG'] = '<span style="color:#fff;">System error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#fff;">Sorry ! your account DeActive</span>';
					}
				}else{
					$data['MSG'] = '<span style="color:#fff;">User name or password is wrong</span>';
				}
			}else{
				$data['MSG'] = '<span style="color:#fff;">Enter user name and password</span>';
			}
			
		}
		
		$userID = $this->session->userData('userID');
		$logged_in = $this->session->userData('logged_in');
		if($userID > 0 AND $logged_in == TRUE){
			$data['dataArray'] = $this->user_model->projectInfo();
			//$this->load->view('project/view_project', $data);
			$this->load->view('index', $data);
		}else{
			$this->load->view('login', $data);
		}
	}
}
