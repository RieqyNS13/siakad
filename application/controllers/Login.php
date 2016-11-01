<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model(array("admin/Login_model","Home_m"));
	}
	function index(){
		if(!$this->session->has_userdata("user") && !$this->session->has_userdata("hak_akses")){
			$tab=$this->session->flashdata("tab");
			$color=$this->session->flashdata("color");
			$status=$this->session->flashdata("status");
			$this->load->view("login",array("tab"=>!is_null($tab)?$tab:"#siswa","color"=>!is_null($color)?$color:"#0085c1","status"=>!is_null($status)?$status:null));
		}else redirect("home");
	}
	function cekloginSiswa(){
		if($this->session->has_userdata("user") && !$this->session->has_userdata("hak_akses"))redirect("home");
		$post=$this->input->post();
		if(isset($post["username"]) && isset($post["password"])){
			$username=trim($post["username"]);
			$password=trim($post["password"]);
			$cek=$this->Login_model->cekloginSiswa($username,$password);
			if($cek){
				$this->session->set_userdata("nomor_user",$cek->id_user);
				$this->session->set_userdata("nama_user",$cek->nama);
				$this->session->set_userdata("hak_akses",$cek->kd_role);
				$this->session->set_userdata("user",$cek->username);
				redirect("home");
			}else{
				$this->session->set_flashdata("color","#0085c1");
				$this->session->set_flashdata("tab","#siswa");
				$this->session->set_flashdata("status",'<div class="alert alert-danger" role="alert"><strong>Login Gagal</strong></div>');
				redirect("login");
			}
		}else print_r($post);
	}
	function cekloginGuru(){
		if($this->session->has_userdata("user") && !$this->session->has_userdata("hak_akses"))redirect("home");
		$post=$this->input->post();
		if(isset($post["username"]) && isset($post["password"])){
			$username=trim($post["username"]);
			$password=trim($post["password"]);
			$cek=$this->Login_model->cekloginGuru($username,$password);
			if($cek){
				$this->session->set_userdata("nomor_user",$cek->id_user);
				$this->session->set_userdata("nama_user",$cek->nama);
				$this->session->set_userdata("hak_akses",$cek->kd_role);
				$this->session->set_userdata("nama_hak_akses",$cek->nama_role);
				$this->session->set_userdata("user",$cek->username);
				$cekwalikelas=$this->Home_m->cekWaliKelas($cek->kode_guru);
				if($cekwalikelas["walikelas"]){
					$datawali=$cekwalikelas["data"];
					$kelas=$datawali->prefix_kelas." ".$datawali->nama_jurusan." ".$datawali->nomor_kelas;
					$this->session->set_userdata("walikelas",$kelas);
				}
				redirect("home");
			}else{
				$this->session->set_flashdata("color","#e67f22");
				$this->session->set_flashdata("tab","#guru");
				$this->session->set_flashdata("status",'<div class="alert alert-danger" role="alert"><strong>Login Gagal</strong></div>');
				redirect("login");
			}
		}else print_r($post);
	}
	
	
	
}
?>