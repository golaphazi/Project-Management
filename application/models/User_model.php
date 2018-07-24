<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_model extends CI_Model {
	var $CI;
	public function __construct(){
		parent::__construct();
      	$this->CI =& get_instance();
	
 	}
	public function loginAuthentication($username,$password){
		$query = $this->db->query("SELECT * FROM u_access_user WHERE ADMIN_LOGIN_NAME = '".addslashes($username)."' AND ADMIN_PASSWORD = '".$password."'");
		$count = $query->num_rows();
		if($count == 1){
			return $query->row();
		}else{
			return '0';
		}
		
	}
	public function companyInfo($id=''){
		if($id > 0){
			$query = $this->db->query("SELECT * FROM c_company WHERE COMPANY_ID = '".$id."' AND C_STATUS = 'Active' ORDER BY COMPANY_ID DESC LIMIT 0,1");
		}else{
			$query = $this->db->query("SELECT * FROM c_company WHERE  C_STATUS = 'Active'  ORDER BY COMPANY_ID DESC LIMIT 0,1");
		}
		
		$count = $query->num_rows();
		if($count > 0){
			return $query->result();		
		}else{
			return '0';
		}
	}
	
	public function userInfo($id='',$select='*',$per=''){
		if($per > 0){
			$perInfo = 'AND info.ENT_USER = '.$per.'';
		}else{
			$perInfo = '';
		}
		if($id > 0){
			$query = $this->db->query("SELECT $select FROM u_access_user AS info INNER JOIN u_personal_information AS per ON info.ADMIN_ID = per.ADMIN_ID WHERE info.ADMIN_ID = '".$id."' $perInfo ");
			$count = $query->num_rows();
			if($count == 1){
				return $query->result();
			}else{
				return '0';
			}
		}else{
			$query = $this->db->query("SELECT $select FROM u_access_user AS info INNER JOIN u_personal_information AS per ON info.ADMIN_ID = per.ADMIN_ID $perInfo");
			
			$count = $query->num_rows();
			if($count > 0){
				return $query->result();		
			}else{
				return '0';
			}
		}
	}
	
	public function showDynamicFiled($PROJECT_TYPE){
		$query = $this->db->query("SELECT * FROM s_filed_type WHERE PROJECT_TYPE = '".$PROJECT_TYPE."' AND FILED_STATUS = 'Active' ORDER BY FILED_ID DESC");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return '';
		}
	}
	
	public function updateFiled($PROJECT_TYPE){
		$query = $this->db->query("SELECT * FROM s_filed_type WHERE PROJECT_TYPE = '".$PROJECT_TYPE."' AND FILED_STATUS = 'Active' ORDER BY FILED_ID DESC");
		$num = $query->num_rows();
			if($query->num_rows() > 0){
				$row = $query->result();
				$html = '';
				if(is_array($row) and sizeof($row) > 0):
					foreach($row AS $value){
						$html .= '<div class="form-group draggable" id="'.$value->FILED_NAME.'" draggable="true" ondragstart="dragStart(event);" ondrop="return false;" >
									<div class="form-row">
									  <div class="col-md-8">
									  '.htmlspecialchars_decode($value->FILED_HTML).'
									  </div>
								   </div>
								 </div>';
					}
					
				endif;
			}
			
			$insert_data = "UPDATE 
								s_project_type

								SET
									HTML_POSITION = '".htmlspecialchars($html)."',
									LIMIT_ITEM = '".addslashes($num)."'
								WHERE P_TYPE_ID = '".$PROJECT_TYPE."'
						";
			$insert = $this->db->query($insert_data);
		
	}
	
	public function projectTypeInfo($id=''){
		if($id > 0){
			$query = $this->db->query("SELECT * FROM s_project_type WHERE P_TYPE_ID = '".$id."' AND P_STATUS != 'Delete' ORDER BY P_TYPE_ID DESC");
		}else{
			$query = $this->db->query("SELECT * FROM s_project_type WHERE  P_STATUS != 'Delete' ORDER BY P_TYPE_ID DESC");
		}
		
		$count = $query->num_rows();
		if($count > 0){
			return $query->result();		
		}else{
			return '0';
		}
	}
	
	public function filedItemInfo($id=''){
		if($id > 0){
			$query = $this->db->query("SELECT * FROM s_filed_type WHERE FILED_ID = '".$id."' AND FILED_STATUS != 'Delete' ORDER BY PROJECT_TYPE ASC");
		}else{
			$query = $this->db->query("SELECT * FROM s_filed_type WHERE  FILED_STATUS != 'Delete' ORDER BY PROJECT_TYPE ASC");
		}
		
		$count = $query->num_rows();
		if($count > 0){
			return $query->result();		
		}else{
			return '0';
		}
	}
	
	public function create_zip($id='0'){
		    $archive_file_name = 'upload/files/'.$id.'_document.zip';
			
			$zip = new ZipArchive();
			if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
				exit("cannot open <$archive_file_name>\n");
			}
			
			$project = $this->projectInfo($id);			
			if(is_array($project) AND sizeof($project) > 0){
				foreach($project as $files)
				{
					if(strlen($files->FILE_UPLOAD) > 25){
						$str = explode('/', $files->FILE_UPLOAD);
						$name = $str[sizeof($str) -1];
						$zip->addFile($files->FILE_UPLOAD,$name);
					}
				}
			}
			
			$massage =	$this->user_model->massageInfo($id);
			if(is_array($massage) AND sizeof($massage) > 0){
				foreach($massage as $files_m)
				{
					if(strlen($files_m->ATTACH_FILE) > 25){
						$str = explode('/', $files_m->ATTACH_FILE);
						$name_m = $str[sizeof($str) -1];
						$zip->addFile($files_m->ATTACH_FILE,$name_m);
					}
				}
			}
			
			$zip->close();
			
			$this->download($archive_file_name,'zip');
			

	}
	
	public function download($file, $type=''){
		
		$str = explode('/', $file);
		$name = $str[sizeof($str) -1];
		
		$str1 = explode('.', $name);
		$ext = $str1[sizeof($str1) -1];
		
		$filePath = $file;
		if(!empty($name) && file_exists($filePath)){
			// Define headers
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$name");
			header("Content-Type: application/$ext");
			header("Content-Transfer-Encoding: binary");
			
			readfile($filePath);
			if($type == 'zip'){
				unlink($file);
			}
			exit;
		}
	}
	
	public function login_check(){
		$userID = $this->session->userData('userID');
		$logged_in = $this->session->userData('logged_in');
		if($userID > 0 AND $logged_in == TRUE){
			
		}else{
			redirect(SITE_URL.'login/');
		}
	}
	
	public function projectInfo($id='0'){
		$userType = $this->session->userData('userType');
		$userID = $this->session->userData('userID');
		
		if($id > 0){
			if($userType == 'Admin'){
				$query = $this->db->query("SELECT * FROM p_project WHERE PROJECT_ID = '".$id."' AND PROJECT_STATUS != 'Delete' ORDER BY PROJECT_ID DESC");
			}else{
				$query = $this->db->query("SELECT * FROM p_project ps, p_project_access acc WHERE acc.PRODUCT_ID = '".$id."' AND acc.ENT_USER = '".$userID."' AND acc.PRODUCT_ID = ps.PROJECT_ID AND ps.PROJECT_STATUS != 'Delete' ORDER BY ps.PROJECT_ID DESC");
			}
		}else{
			if($userType == 'Admin'){
					$query = $this->db->query("SELECT * FROM p_project WHERE PROJECT_STATUS != 'Delete' ORDER BY PROJECT_ID DESC");
			}else{
					$query = $this->db->query("SELECT distinct(ps.PROJECT_ID) ,ps.PROJECT_NAME, ps.WEBSITE_URL, ps.REF, ps.ENT_DATE, ps.PRICE, ps.BID_TYPE, ps.ENT_USER, ps.FILE_UPLOAD FROM p_project ps, p_project_access acc WHERE acc.ENT_USER = '".$userID."' AND acc.PRODUCT_ID = ps.PROJECT_ID AND ps.PROJECT_STATUS != 'Delete' ORDER BY ps.PROJECT_ID DESC");
			}
		
		}
		$count = $query->num_rows();
		if($count > 0){
			return $query->result();		
		}else{
			return '0';
		}
		
	}
	
	public function milestoneInfo($id,$mile=''){
		if($mile > 0){
			$query = $this->db->query("SELECT * FROM p_mileston WHERE PROJECT_ID = '".$id."' AND MILESTON_ID = '".$mile."' AND MILESTONE_STAUTS != 'Delete' ORDER BY MILESTON_ID ASC");
		
		}else{
			$query = $this->db->query("SELECT * FROM p_mileston WHERE PROJECT_ID = '".$id."'  AND MILESTONE_STAUTS != 'Delete' ORDER BY MILESTON_ID ASC");
		}
		$count = $query->num_rows();
		if($count > 0){
			return $query->result();		
		}else{
			return '0';
		}
	}
	public function massageInfo($id, $milestonID='', $date=''){
		if($milestonID > 0){
			if(strlen($date) > 0){
				$query = $this->db->query("SELECT * FROM p_massage WHERE PROJECT_ID = '".$id."' AND MILESTON_ID = '".$milestonID."' AND ENT_DATE = '".$date."' AND MASSAGE_STATUS != 'Delete' ORDER BY MASSAGE_ID ASC");
			}else{
				$query = $this->db->query("SELECT * FROM p_massage WHERE PROJECT_ID = '".$id."' AND MILESTON_ID = '".$milestonID."' AND MASSAGE_STATUS != 'Delete' ORDER BY MASSAGE_ID ASC");
			}
		}else{
			$query = $this->db->query("SELECT * FROM p_massage WHERE PROJECT_ID = '".$id."' AND MASSAGE_STATUS != 'Delete' ORDER BY MASSAGE_ID ASC");
		
		}
		$count = $query->num_rows();
		if($count > 0){
			return $query->result();		
		}else{
			return '0';
		}
	}
	
	public function massageInfoDis($id, $milestonID=''){
		if($milestonID > 0){
			$query = $this->db->query("SELECT DISTINCT  ENT_DATE FROM p_massage WHERE PROJECT_ID = '".$id."' AND MILESTON_ID = '".$milestonID."' AND MASSAGE_STATUS != 'Delete' ORDER BY MASSAGE_ID ASC");
		
		}else{
			$query = $this->db->query("SELECT DISTINCT  ENT_DATE FROM p_massage WHERE PROJECT_ID = '".$id."' AND MASSAGE_STATUS != 'Delete' ORDER BY MASSAGE_ID ASC");
		
		}
		$count = $query->num_rows();
		if($count > 0){
			return $query->result();		
		}else{
			return '0';
		}
	}
	
	
	public function select_video_list($selectId='0',$queryId = '0', $show='parent'){
		
		$arrayVedio = array('Website' => 'Website Video', 'Mobile' => 'Mobile App Video', 'Animated' => 'Animated Video', 'Other' => 'Other');
		$count = sizeof($arrayVedio);
		if($count > 0){
			$res = '';
			foreach($arrayVedio AS $key=>$data){
				if($selectId == $key){
					$res .= '<option value="'.$key.'" selected> '.$data.' </option>';
				}else{
					$res .= '<option value="'.$key.'"> '.$data.' </option>';
				}
			}
			return $res;
		}else{
			return '';
		}
	}
	
	public function select_client_list($selectId='0'){
		$query = $this->db->query("SELECT * FROM u_access_user WHERE  ADMIN_TYPE = 'Client' ORDER BY ADMIN_ID DESC");
		if(is_array($query->result()) AND sizeof($query->result()) > 0){
			$res = '';
			foreach($query->result() AS $value){
				
				if($selectId == $value->ADMIN_ID){
					$res .= '<option value="'.$value->ADMIN_ID.'" selected > '.$value->ADMIN_NAME.' ('.$value->ADMIN_LOGIN_NAME.')  </option>';
				}else{
					$res .= '<option value="'.$value->ADMIN_ID.'"> '.$value->ADMIN_NAME.' ('.$value->ADMIN_LOGIN_NAME.') </option>';
				}
			}
			return $res;
		}else{
			return '';
		}
		
	}
	
	
	public function select_project_type_list($selectId='0'){
		$query = $this->db->query("SELECT * FROM s_project_type WHERE  P_STATUS != 'Delete' ORDER BY P_TYPE_ID DESC");
		if(is_array($query->result()) AND sizeof($query->result()) > 0){
			$res = '';
			foreach($query->result() AS $value){
				
				if($selectId == $value->P_TYPE_ID){
					$res .= '<option value="'.$value->P_TYPE_ID.'" selected > '.$value->P_TYPE_NAME.' </option>';
				}else{
					$res .= '<option value="'.$value->P_TYPE_ID.'"> '.$value->P_TYPE_NAME.' </option>';
				}
			}
			return $res;
		}else{
			return '';
		}
		
	}
	
	public function select_project_list(array $selectId){
		$userID = $this->session->userdata('userID');
		$query = $this->db->query("SELECT * FROM p_project WHERE ENT_USER = '".$userID."' AND PROJECT_STATUS = 'Active' ORDER BY PROJECT_ID DESC");
		if(is_array($query->result()) AND sizeof($query->result()) > 0){
			$res = '';
			foreach($query->result() AS $value){
				
				if(in_array($value->PROJECT_ID, $selectId, true)){
					$res .= '<input type="checkbox" name="invititation[]"  value="'.$value->PROJECT_ID.'" checked="checked" > '.substr($value->PROJECT_NAME, 0, 100).' <br/> <br/>';
				}else{
					$res .= '<input type="checkbox" name="invititation[]" value="'.$value->PROJECT_ID.'"> '.substr($value->PROJECT_NAME, 0, 100).'<br/> <br/>';
				}
			}
			return $res;
		}else{
			return '';
		}
		
	}
	
	public function select_voice_list($selectId='0',$queryId = '0', $show='parent'){
		
		$arrayVedio = array('Male - English' => 'Male - English', 'Female - English' => 'Female - English', 'Male - American' => 'Male - American', 'Female - American' => 'Female - American');
		$count = sizeof($arrayVedio);
		if($count > 0){
			$res = '';
			foreach($arrayVedio AS $key=>$data){
				if($selectId == $key){
					$res .= '<option value="'.$key.'" selected> '.$data.' </option>';
				}else{
					$res .= '<option value="'.$key.'"> '.$data.' </option>';
				}
			}
			return $res;
		}else{
			return '';
		}
	}
	
	public function select_music_list($selectId='0',$queryId = '0', $show='parent'){
		
		$arrayVedio = array('Corporate' => 'Corporate', 'Happy' => 'Happy', 'Serious' => 'Serious', 'Other' => 'Other (please explain)');
		$count = sizeof($arrayVedio);
		if($count > 0){
			$res = '';
			foreach($arrayVedio AS $key=>$data){
				if($selectId == $key){
					$res .= '<option value="'.$key.'" selected> '.$data.' </option>';
				}else{
					$res .= '<option value="'.$key.'"> '.$data.' </option>';
				}
			}
			return $res;
		}else{
			return '';
		}
	}
	
	public function date_format_orginal($date=''){
		return date("d M Y", strtotime($date));
	}
	
	public function select_client_information($from_date='0000-00-00',$to_date='0000-00-00',$clientID='0',$report_nae=''){
		$massage = '';
		$massage .= '<div class="div_center"><p class="headding">European IT Solutions <br/><span class="subheadding">Senpara, Mirpur 10, Dhaka, Bangladesh.</span></p>
						';
		if($report_nae != ''){
			$massage .= '<span class="subheadding bold_subheadding">'.$report_nae.'</span> <br/>';
		}
		if($from_date != '0000-00-00' AND $to_date != '0000-00-00'){
			$massage .= '<span class="subheadding">Reporting Period: <span class="bold_subheadding"> '.$from_date.'</span> to  <span class="bold_subheadding"> '.$to_date.'</span></span><br/>';
		}
		if($clientID > 0){
			$clientInfo = $this->cliensInfo($clientID);
			$massage .= '<span class="subheadding">  <span class="bold_subheadding"> '.$clientInfo[0]->CLIENTS_NAME.' </span> ('.$clientInfo[0]->COMPANY_NAME.') </span> <br/>';
		}
		$massage .= '</div>';
		
		return $massage;
	}
	
	
	public function count_any_where($table, $field, $where=''){
		if(strlen($where)>4){
			$query = $this->db->query("SELECT COUNT($field) AS count_field FROM $table WHERE $where");
		}else{
			$query = $this->db->query("SELECT COUNT($field) AS count_field FROM $table");
		}
		$cout = $query->result();
		return $cout[0]->count_field;
	}
	
	public function min_any_where($table, $field, $where=''){
		if(strlen($where)>4){
			$query = $this->db->query("SELECT MIN($field) AS count_field FROM $table WHERE $where");
		}else{
			$query = $this->db->query("SELECT MIN($field) AS count_field FROM $table");
		}
		$cout = $query->result();
		if($cout[0]->count_field == '0000-00-00' OR strlen($cout[0]->count_field) < 3){
			return  date("Y-m-d");
		}else{
			return $cout[0]->count_field;
		}
		
	}
	
	public function sum_any_where($table, $field, $where=''){
		if(strlen($where)>4){
			$query = $this->db->query("SELECT SUM($field) AS count_field FROM $table WHERE $where");
		}else{
			$query = $this->db->query("SELECT SUM($field) AS count_field FROM $table");
		}
		$cout = $query->result();
		$sum = $cout[0]->count_field;
		if($sum > 0){
			$sum = $sum;
		}else{$sum = 0;}
		return $sum;
	}
	
	public function max_any_where($table, $field, $where=''){
		if(strlen($where)>4){
			$query = $this->db->query("SELECT MAX($field) AS count_field FROM $table WHERE $where");
		}else{
			$query = $this->db->query("SELECT MAX($field) AS count_field FROM $table");
		}
		$cout = $query->result();
		$sum = $cout[0]->count_field;
		if($sum > 0){
			$sum = $sum;
		}else{$sum = 0;}
		return $sum;
	}
}
