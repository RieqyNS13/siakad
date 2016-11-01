<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Guru extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model("User_m");
	}
	function index(){
		redirect("login");
	}
	function buatAkun(){
		$post=$this->input->post();
		if(count($post)==0)die("silent :p");
		foreach($post as $key=>$post2)$post[$key]=trim($post2);
		if(empty($post["nip"]) || empty($post["email"]) || empty($post["password"])){
			$this->session->set_flashdata("color","#27ae61");
			$this->session->set_flashdata("tab","#signup2");
			$this->session->set_flashdata("status",'<div class="alert alert-danger" role="alert"><strong>Kode guru/NIP, email, dan password tidak boleh kosong</strong></div>');
			redirect("login");
		}
		else{
			$pw=$post["password"];
			$pw2=$post["password2"];
			if(strcmp($pw,$pw2)!=0){
				$this->session->set_flashdata("color","#27ae61");
				$this->session->set_flashdata("tab","#signup2");
				$this->session->set_flashdata("status",'<div class="alert alert-danger" role="alert"><strong>Password harus sama</strong></div>');
				redirect("login");
			}else{
				unset($post["password2"]);
				$input=$this->User_m->inputGuru($post);
				$this->session->set_flashdata("color","#27ae61");
				$this->session->set_flashdata("tab","#signup2");
				if($input["sukses"]){
					$this->session->set_flashdata("status",'<div c lass="alert alert-info" role="alert"><strong>Sukses membuat akun guru dengan kode guru/nip '.$post["nip"].'</strong></div>');
					redirect("login");
				}else{
					$this->session->set_flashdata("status",'<div class="alert alert-danger" role="alert"><strong>'.$input["msg"].'</strong></div>');
				}
				redirect("login");
			}
		}	
	}
}