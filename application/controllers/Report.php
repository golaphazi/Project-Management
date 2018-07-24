<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class report extends CI_Controller {

    var $CI;
	function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
		$this->load->library('session');
		$this->load->model(array('user_model'));
		$this->load->helper('url');
		$this->user_model->login_check();
		
	}
	
	
	
	
	}
?>