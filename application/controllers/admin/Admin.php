<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller{
	function __construct(){
		date_default_timezone_set("Asia/Jakarta");
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->model(array("admin/SubmitRaport_model", "admin/NilaiTugas_model","admin/NilaiRaport_model","admin/NilaiPraktek_model","admin/NilaiSikap_model", "admin/NilaiPortofolio_model","admin/NilaiProyek_model","admin/NilaiUas_model", "admin/NilaiUts_model","admin/Log_model","Home_m","admin/Login_model","admin/Guru_model",
		"admin/Siswa_model","admin/Mapel_model","admin/MapelGuru_model","admin/Ortu_model","admin/Walikelas_model","admin/Kelas_model","admin/BagiMapel_model","admin/Jurusan_model","admin/MataDiklat_model"));
	}
	//private $data=null;
	function test(){
		$data=$this->SubmitRaport_model->getNilai("6771","1","2015-2016");
		print_r($data);
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
	function backup(){
		//echo $this->session->userdata("hak_akses");die;
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || $this->session->userdata("hak_akses")!="admin")redirect("admin/login");
		else{
			//$this->load->view("admin/index",array("nama_user"=>$this->session->userdata("nama_user")));
			if(!empty($this->uri->segment(3)) && $this->uri->segment(3)=="get"){
				$this->load->helper('download');

				$dump=shell_exec("C:/xampp/mysql/bin/mysqldump --user=root --password= --host=localhost --database ".$this->db->database);
				force_download($this->db->database.".sql",$dump);
			}else{
			$hak_akses=$this->session->hak_akses;
			$tables=$this->db->list_tables();
			foreach($tables as $table){
				$columns=$this->db->list_fields($table);
				$dataGay[$table]=$columns;
			}
			//print_r($dataGay);die;
			$judul=$this->session->userdata("nama_hak_akses")." - Control Panel";
			$notif=$this->Log_model->getLog();
			$data=array("idAktif"=>"backup","judulKonten"=>$judul,"nama_user"=>$this->session->userdata("nama_user"),"hak_akses"=>$hak_akses,"notif_log"=>$notif);
			$data["tables"]=$dataGay;
			$this->template->load("admin/index","admin/backup",$data);
			}
		}
	}
	function editProfil(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(count($post)==0)die;
			$this->db->where(array("username"=>$this->session->user,"kd_role"=>$this->session->hak_akses));
			$query=$this->db->update("user_6771",$post);
			if($query)echo json_encode(array("sukses"=>"Sukses edit profile"));
			else{
				$error=$this->db->error();
				json_encode(array("error"=>isset($error["code"])?$error["message"]:"Error tidak diketahui"));
			}
			$this->session->set_userdata("nama_user",trim($post["nama"]));
		}
	}
	function editAkun(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(count($post)==0)die;
			if(empty($post["password"][0]) || empty($post["password"][1]) || empty($post["username"]))die(json_encode(array("error"=>"Password dan username tidak boleh kosong")));
			$pw=trim($post["password"][0]);
			$pw2=trim($post["password"][1]);
			$user=trim($post["username"]);
			if(strcmp($pw,$pw2)!=0)die(json_encode(array("error"=>"Password harus sama !!")));
			$this->db->where(array("username"=>$this->session->user,"kd_role"=>$this->session->hak_akses));
			$query=$this->db->update("user_6771",array("username"=>$user,"password"=>md5($pw)));
			if($query)echo json_encode(array("sukses"=>"Sukses edit akun"));
			else{
				$error=$this->db->error();
				json_encode(array("error"=>isset($error["code"])?$error["message"]:"Error tidak diketahui"));
			}
			$this->session->set_userdata("user",$user);
		}
	}
}
?>