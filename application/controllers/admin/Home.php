<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model(array("admin/Log_model","admin/SubmitRaport_model","Home_m"));
	}
	function index(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			//$this->load->view("admin/index",array("nama_user"=>$this->session->userdata("nama_user")));
			$hak_akses=$this->session->hak_akses;
			if($hak_akses==="guru"){
				$profil=$this->Home_m->getProfil($this->session->user,2);
				$mapel=$this->Home_m->getMapelYgDiajar($profil["msg"]->kode_guru);
				$this->session->set_userdata("kode_guru",$profil["msg"]->kode_guru);
			}else{
				
				$profil=null;
				$mapel=null;
			}
			$judul=$this->session->userdata("nama_hak_akses")." - Control Panel";
			$notif=$this->Log_model->getLog();
			$data=array("mapelYgDiajar"=>$mapel,"judulKonten"=>$judul,"nama_user"=>$this->session->userdata("nama_user"),"profil"=>$profil["msg"],"hak_akses"=>$hak_akses,"notif_log"=>$notif);
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$this->template->load("admin/index","admin/dashboard",$data);
		}
	}
	function getProfile(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$this->db->select(["username","nama","email","no_telp"]);
			$this->db->where("username",$this->session->user);
			$query=$this->db->get("user_6771");
			echo json_encode($query->row());
		}
	}
	function logout(){
		$this->session->sess_destroy();
		redirect("admin");
	}
}
?>