<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model(array("admin/Login_model"));
	}
	function index(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses")){
			$this->load->view("admin/login",array("status"=>$this->session->flashdata("status")));
		}else redirect("admin/index");
	}
	function ceklogin(){
		if($this->session->has_userdata("user") && $this->session->has_userdata("hak_akses") && $this->session->hak_akses=="admin")redirect("admin/index");
		else{
			$post=$this->input->post();
			if(isset($post["user"]) && isset($post["pass"]) && isset($post["type"])){
				$user=trim($post["user"]);
				$pass=trim($post["pass"]);
				$type=trim($post["type"]);
				if($type=="guru")$data=$this->Login_model->cekLoginGuru($user,$pass);
				else $data=$this->Login_model->cekLoginAdmin($user,$pass,$type);
				if($data){
					$this->session->set_userdata("user",$user);
					$this->session->set_userdata("hak_akses",$data->kode_role);
					$this->session->set_userdata("nama_user",$data->nama);
					$this->session->set_userdata("nama_hak_akses",$data->nama_role);
					redirect("admin/index");
				}else{
					$this->session->set_flashdata("status",'<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
 Login gagal
</div>');
					redirect("admin/login");
					//$this->load->view("admin/login",array("status"=>'<div class="alert alert-danger" role="alert"><font color=Login Gagal</div>'));
				}
			}
		}
	}
	 function asu(){
		echo "asu";
	}
}
?>