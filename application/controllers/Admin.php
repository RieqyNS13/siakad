<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller{
	function __construct(){
		date_default_timezone_set("Asia/Jakarta");
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->model(array("SubmitRaport_model", "NilaiTugas_model","NilaiRaport_model","NilaiPraktek_model","NilaiSikap_model", "NilaiPortofolio_model","NilaiProyek_model","NilaiUas_model", "NilaiUts_model","Log_model","Home_m","Login_model","Guru_model","Siswa_model","Mapel_model","MapelGuru_model","Ortu_model","Walikelas_model","Kelas_model","BagiMapel_model","Jurusan_model","MataDiklat_model"));
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
	function login(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses")){
			$this->load->view("admin/login");
		}else redirect("admin/index");
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
	function editNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai Tugas"));
		else{
			$edit=$this->NilaiTugas_model->editData();
			echo json_encode($edit);
			
		}
	}
	function editNilaiPraktek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai Tugas"));
		else{
			$edit=$this->NilaiPraktek_model->editData();
			echo json_encode($edit);
			
		}
	}
	function editNilaiProyek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai Tugas"));
		else{
			$edit=$this->NilaiProyek_model->editData();
			echo json_encode($edit);
			
		}
	}
	function editNilaiPortofolio(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai Tugas"));
		else{
			$edit=$this->NilaiPortofolio_model->editData();
			echo json_encode($edit);
			
		}
	}
	function editNilaiUas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai UAS"));
		else{
			$edit=$this->NilaiUas_model->editData();
			echo json_encode($edit);
			
		}
	}
	function editNilaiUts(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai UTS"));
		else{
			$edit=$this->NilaiUts_model->editData();
			echo json_encode($edit);
			
		}
	}
	function editNilaisikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai UTS"));
		else{
			$edit=$this->NilaiSikap_model->editData();
			echo json_encode($edit);
			
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
	function logout(){
		$this->session->sess_destroy();
		redirect("admin");
	}
	function gantiPagingRaport(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas8",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok8",$post["nis"]);
				$this->session->set_userdata("kd_mapel8",$post["kd_mapel"]);
				$this->session->set_userdata("semester8",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran8",$post["tahun_ajaran"]);
				redirect("admin/dataRaport");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_raport",abs((int)$post["perpage"]));
				redirect("admin/dataRaport");
			}
			
		}
	}
	function gantiPagingSubmitRaport(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["submit"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				if($this->session->userdata("hak_akses")=="admin")$this->session->set_userdata("kd_kelas9",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok9",$post["nis"]);
				$this->session->set_userdata("semester9",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran9",$post["tahun_ajaran"]);
				$this->session->set_userdata("sudahdisubmit",$post["submit"]);
				redirect("admin/submitRaport");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_submitraport",abs((int)$post["perpage"]));
				redirect("admin/submitRaport");
			}
			
		}
	}
	function gantiPagingBagiMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kelas_prefix"]) && isset($post["kd_jurusan"]) && isset($post["semester"]) && isset($post["kode_kelompok_mapel"])){
				$this->session->set_userdata("kelas_prefix",$post["kelas_prefix"]);
				$this->session->set_userdata("kd_jurusan",$post["kd_jurusan"]);
				$this->session->set_userdata("semester",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran",$post["tahun_ajaran"]);
				$this->session->set_userdata("kode_kelompok_mapel",$post["kode_kelompok_mapel"]);
				redirect("admin/dataBagiMapel");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_bagimapel",abs((int)$post["perpage"]));
				redirect("admin/dataBagiMapel");
			}
			
		}
	}
	function gantiPagingNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok",$post["nis"]);
				$this->session->set_userdata("kd_mapel",$post["kd_mapel"]);
				$this->session->set_userdata("semester",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran",$post["tahun_ajaran"]);
				redirect("admin/dataNilaiTugas");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaitugas",abs((int)$post["perpage"]));
				redirect("admin/dataNilaiTugas");
			}
			
		}
	}
	function gantiPagingNilaiPraktek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas4",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok4",$post["nis"]);
				$this->session->set_userdata("kd_mapel4",$post["kd_mapel"]);
				$this->session->set_userdata("semester4",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran4",$post["tahun_ajaran"]);
				redirect("admin/dataNilaiPraktek");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaipraktek",abs((int)$post["perpage"]));
				redirect("admin/dataNilaiPraktek");
			}
			
		}
		
	}
	function gantiPagingNilaiProyek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas5",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok5",$post["nis"]);
				$this->session->set_userdata("kd_mapel5",$post["kd_mapel"]);
				$this->session->set_userdata("semester5",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran5",$post["tahun_ajaran"]);
				redirect("admin/dataNilaiProyek");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaiproyek",abs((int)$post["perpage"]));
				redirect("admin/dataNilaiProyek");
			}
			
		}
	}
	function gantiPagingNilaiPortofolio(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas6",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok6",$post["nis"]);
				$this->session->set_userdata("kd_mapel6",$post["kd_mapel"]);
				$this->session->set_userdata("semester6",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran6",$post["tahun_ajaran"]);
				redirect("admin/dataNilaiPortofolio");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaiportofolio",abs((int)$post["perpage"]));
				redirect("admin/dataNilaiPortofolio");
			}
			
		}
	}
	function gantiPagingNilaiUas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas2",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok2",$post["nis"]);
				$this->session->set_userdata("kd_mapel2",$post["kd_mapel"]);
				$this->session->set_userdata("semester2",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran2",$post["tahun_ajaran"]);
				redirect("admin/dataNilaiUAS");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaiuas",abs((int)$post["perpage"]));
				redirect("admin/dataNilaiUAS");
			}
			
		}
	}
	function gantiPagingNilaiSikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas7",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok7",$post["nis"]);
				$this->session->set_userdata("kd_mapel7",$post["kd_mapel"]);
				$this->session->set_userdata("semester7",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran7",$post["tahun_ajaran"]);
				redirect("admin/dataNilaiSikap");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaisikap",abs((int)$post["perpage"]));
				redirect("admin/dataNilaiSikap");
			}
			
		}
	}
	function gantiPagingNilaiUts(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas3",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok3",$post["nis"]);
				$this->session->set_userdata("kd_mapel3",$post["kd_mapel"]);
				$this->session->set_userdata("semester3",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran3",$post["tahun_ajaran"]);
				redirect("admin/dataNilaiUTS");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaiuts",abs((int)$post["perpage"]));
				redirect("admin/dataNilaiUTS");
			}
			
		}
	}
	function gantiPagingKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_kelas",abs((int)$post["perpage"]));
				redirect("admin/dataKelas");
			}
			
		}
	}
	function gantiPagingJurusan(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_jurusan",abs((int)$post["perpage"]));
				redirect("admin/dataJurusan");
			}
			
		}
	}
	function gantiPagingMataDiklat(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_matadiklat",abs((int)$post["perpage"]));
				redirect("admin/dataMataDiklat");
			}
			
		}
	}
	function gantiPagingWaliKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_walikelas",abs((int)$post["perpage"]));
				redirect("admin/dataWaliKelas");
			}
			
		}
	}
	function gantiPagingGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_guru",abs((int)$post["perpage"]));
				redirect("admin/dataGuru");
			}
			
		}
	}
	function dataOrtuSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			if($this->session->perpage_ortu)$perpage=$this->session->perpage_ortu;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/dataOrtuSiswa');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->Ortu_model->cariOrtuSiswa($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Ortu_model->jumlahcariOrtuSiswa($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->Ortu_model->total();
				$data["caristatus"]=null;
				$get=$this->Ortu_model->getOrtuSiswa($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["idAktif"]="datasiswa";
			$data["siswaData"]=$this->Ortu_model->getNisData();
			$data["dataOrtu"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["hak_akses"]=$this->session->hak_akses;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$this->template->load("admin/index","admin/ortu_siswa",$data);
			
		}
	}
	function dataWaliKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_walikelas)$perpage=$this->session->perpage_walikelas;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/dataWaliKelas');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->Walikelas_model->cariWaliKelas($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Walikelas_model->jumlahCariWaliKelas($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->Walikelas_model->total();
				$data["caristatus"]=null;
				$get=$this->Walikelas_model->getWaliKelas($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["idAktif"]="datakurikulum";
			$data["kodeGuru"]=$this->MapelGuru_model->getKodeGuru();
			$data["dataWalikelas"]=$get;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["hak_akses"]=$this->session->hak_akses;
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/wali_kelas",$data);
			
		}
	}
	function dataMapelGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_mapelguru)$perpage=$this->session->perpage_mapelguru;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/dataMapelGuru');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->MapelGuru_model->cariMapelGuru($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->MapelGuru_model->jumlahcariMapelGuru($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->MapelGuru_model->total();
				$data["caristatus"]=null;
				$get=$this->MapelGuru_model->getMapelGuru($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			
			$data["idAktif"]="dataguru";
			$data["kodeGuru"]=$this->MapelGuru_model->getKodeGuru();
			$data["kodeMapel"]=$this->MapelGuru_model->getKodeMapel();
			$data["dataMapelGuru"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["hak_akses"]=$this->session->hak_akses;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/mapel_guru",$data);
			
		}
	}
	function dataGuru(){
		//if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || $this->session->userdata("hak_akses")!="admin")redirect("admin/login");
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_guru)$perpage=$this->session->perpage_guru;
			else $perpage=5;
			
			$config['base_url'] = site_url('admin/dataGuru');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->Guru_model->cariGuru($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Guru_model->jumlahcariGuru($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
				
			}else{
			//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->Guru_model->total();
				$data["caristatus"]=null;
				$get=$this->Guru_model->getGuru($data['page'],$perpage);
			}
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["idAktif"]="dataguru";
			$data["dataGuru"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["hak_akses"]=$this->session->hak_akses;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/guru",$data);
			
		}
	}
	function hapusGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$kode_guru=$this->input->post("kode_guruforHapus");
			$kode_guru=$this->db->escape_str($kode_guru);
			$data=$this->db->query("select * from guru_6771 where kode_guru='".$kode_guru."'")->row();
			if(!empty($data->photo))unlink($data->photo);
			$query=$this->db->query("delete from guru_6771 where kode_guru='".$kode_guru."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function hapusNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai Tugas"));
		else{
			$hapus=$this->NilaiTugas_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function hapusNilaiPraktek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai Tugas"));
		else{
			$hapus=$this->NilaiPraktek_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function hapusNilaiProyek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai Tugas"));
		else{
			$hapus=$this->NilaiProyek_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function hapusNilaiPortofolio(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai Tugas"));
		else{
			$hapus=$this->NilaiPortofolio_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function hapusNilaiUAS(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai UAS"));
		else{
			$hapus=$this->NilaiUas_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function hapusNilaiUTS(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai UTS"));
		else{
			$hapus=$this->NilaiUts_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function hapusNilaisikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai UTS"));
		else{
			$hapus=$this->NilaiSikap_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function hapusMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa hapus mapel"));
		else{
			$kode_mapel=$this->input->post("kode_mapel_forHapus");
			$kode_mapel=$this->db->escape_str($kode_mapel);
			$query=$this->db->query("delete from mapel_6771 where kode_mapel='".$kode_mapel."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function hapusMapelGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa hapus mapel guru ".$this->session->userdata("hak_akses")));
		else{
			$id=$this->input->post("id_forHapus");
			$id=abs((int)$id);
			$query=$this->db->query("delete from guru_mengajar_6771 where id=$id");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function editJurusan(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa edit jurusan"));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->Jurusan_model->editJurusan($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}
	}
	function editBagiMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa edit pembagian mapel"));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->BagiMapel_model->editData($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}
	}
	function editMataDiklat(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->MataDiklat_model->editMataDiklat($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}
	}
	function editMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa edit mapel"));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->Mapel_model->editMapel($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}
	}
	function editKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->Kelas_model->editKelas($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}
	}
	function editWalikelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa edit wali kelas"));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->Walikelas_model->editWaliKelas($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}
	}
	function editOrtuSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa edit orang tua siswa ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->Ortu_model->editOrtuSiswa($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}
	}
	function editMapelGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa edit mapel guru ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			$edit=$this->MapelGuru_model->editMapelGuru($post);
			if($edit["sukses"]===true)echo json_encode(array("sukses"=>$edit["msg"]));
			else echo json_encode(array("error"=>isset($edit["msg"]["message"])?$edit["msg"]["message"]:$edit["msg"]));
		}		
	}
	function editGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$post2=$this->input->post();
			if(count($post2)==0)die("silent");
			foreach($post2 as $key=>$data){
				$post[str_replace("2","",$key)]=$data;
			}
			if(isset($post["photo"]))unset($post["photo"]);
			$data=array();
			if(isset($_FILES["photo2"])){
				$config["upload_path"]="./assets/images/guru/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["photo2"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("photo2")){
					$dataupload=$this->upload->data();
					$data["photo"]=$config["upload_path"].$dataupload["file_name"];
					$query=$this->db->query("select * from guru_6771 where kode_guru='".$this->db->escape_str($post["kode_guruforEdit"])."'")->row();
					if(!empty($query->photo))unlink($query->photo);
				}else{
					echo json_encode(array("error"=>$this->upload->display_errors()));
					die;
				}
			}
			if($post["options"]==2 && strlen(trim($post["nip"]))==0)die(json_encode(array("error"=>"NIP Tidak boleh kosong"))); 
			else if($post["options"]==1){
				$post["nip"]=null;
			}
			//print_r(array_merge($_FILES,$post));die;
			if(isset($post["options"]))unset($post["options"]);
			foreach($post as $key=>$line){
				$data[$key]=$line;
				if(strlen(trim($line))==0 && $key!="nip")die(json_encode(array("error"=>"Masih ada data yang kosong")));
				
			}
			$data["tgl_lahir"]=date("Y-m-d",strtotime($data["tgl_lahir"]));
			$input=$this->Guru_model->editGuru($data);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
		
		
	}
	function editSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa edit orang siswa ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(count($post)==0)die("silent");
			if(isset($post["photo"]))unset($post["photo"]);
			if(isset($_FILES["photo"])){
				$config["upload_path"]="./assets/images/siswa/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["photo"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("photo")){
					$dataupload=$this->upload->data();
					$post["photo"]=$config["upload_path"].$dataupload["file_name"];
					$query=$this->db->query("select * from siswa_6771 where nis='".$this->db->escape_str($post["nis_forEdit"])."'")->row();
					if(!empty($query->photo))unlink($query->photo);
				}else{
					echo json_encode(array("error"=>$this->upload->display_errors()));
					die;
				}
			}
			if(empty($post["nis"]) || empty($post["nisn"]))die(json_encode(array("error"=>"NIS dan NISN tidak boleh kosong")));
			if(empty($post["kd_jurusan"]) || $post["kd_jurusan"]=='0')die(json_encode(array("error"=>"Pilih jurusan dulu")));
			if(empty($post["kd_kelas"]) || $post["kd_kelas"]=='0')die(json_encode(array("error"=>"Pilih kelas dulu")));
			
			$input=$this->Siswa_model->editSiswa($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
		
		
	}
	function submitKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$post=$this->input->post();
			if(empty($post["prefix_kelas"])|| empty($post["kd_jurusan"]) || empty($post["nomor_kelas"]))die(json_encode(array("error"=>"Prefix kelas, Jurusan, dan Nomor kelas tidak boleh kosong")));
			$input=$this->Kelas_model->inputKelas($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function submitNilaiUAS(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai UAS"));
		else{
			$input=$this->NilaiUas_model->inputData();
			echo json_encode($input);
		}
	}
	function submitNilaisikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai UAS"));
		else{
			$input=$this->NilaiSikap_model->inputData();
			echo json_encode($input);
		}
	}
	function submitNilaiUTS(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai UTS"));
		else{
			$input=$this->NilaiUts_model->inputData();
			echo json_encode($input);
		}
	}
	function submitNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai Tugas"));
		else{
			$input=$this->NilaiTugas_model->inputData();
			echo json_encode($input);
		}
	}
	function submitNilaiPraktek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai Tugas"));
		else{
			$input=$this->NilaiPraktek_model->inputData();
			echo json_encode($input);
		}
	}
	function submitNilaiProyek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai Tugas"));
		else{
			$input=$this->NilaiProyek_model->inputData();
			echo json_encode($input);
		}
	}
	function submitNilaiPortofolio(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai Tugas"));
		else{
			$input=$this->NilaiPortofolio_model->inputData();
			echo json_encode($input);
		}
	}
	function submitBagiMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input pembagian mapel"));
		else{
			$post=$this->input->post();
			if(empty(trim($post["kelas_prefix"])) || empty($post["kd_jurusan"]) || empty($post["semester"]) || empty($post["kode_mapel"]) || empty($post["kode_kelompok_mapel"]))die(json_encode(array("error"=>"Prefix kelas, Jurusan, Kode mapel, dll tidak boleh kosong")));
			$input=$this->BagiMapel_model->inputData($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function submitMataDiklat(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input mapel"));
		else{
			$post=$this->input->post();
			if(empty($post["kode_mata_diklat"])|| empty($post["nama_mata_diklat"]))die(json_encode(array("error"=>"Kode diklat dan nama diklat tidak boleh kosong")));
			$input=$this->MataDiklat_model->inputMataDiklat($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function submitJurusan(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$post=$this->input->post();
			if(empty($post["nama_jurusan"])|| empty($post["nama_full"]) || empty($post["kode_diklat"]))die(json_encode(array("error"=>"Kode jurusan, nama jurusan, dan kode diklat tidak boleh kosong")));
			$input=$this->Jurusan_model->inputKelas($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
		
	}
	function submitWaliKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input wali kelas"));
		else{
			$post=$this->input->post();
			if(empty($post["kode_guru"])|| empty($post["id_kelas"]))die(json_encode(array("error"=>"Kode guru dan Kelas tidak boleh kosong")));
			$input=$this->Walikelas_model->inputWalikelas($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function submitOrtuSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input orang tua siswa ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(empty($post["nis"])|| empty($post["nama_ayah"]) || empty($post["nama_ibu"]))die(json_encode(array("error"=>"NIS, nama ayah, dan nama ibu tidak boleh kosong")));
			$input=$this->Ortu_model->inputOrtuSiswa($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function submitMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input mata diklat"));
		else{
			$post=$this->input->post();
			if(empty($post["kode_mapel"])|| empty($post["nama_mapel"]))die(json_encode(array("error"=>"Kode mapel dan nama mapel tidak boleh kosong")));
			$input=$this->Mapel_model->inputMapel($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
		
	}
	function submitMapelGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(empty($post["kode_guru"])|| empty($post["kd_mapel"]))die(json_encode(array("error"=>"Kode guru dan kode mapel tidak boleh kosong")));
			$input=$this->MapelGuru_model->inputMapelGuru($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function submitSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(isset($post["photo"]))unset($post["photo"]);
			if(isset($_FILES["photo"])){
				$config["upload_path"]="./assets/images/siswa/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["photo"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("photo")){
					$dataupload=$this->upload->data();
					$post["photo"]=$config["upload_path"].$dataupload["file_name"];
				}else{
					echo json_encode(array("error"=>$this->upload->display_errors()));
					die;
				}
			}
			if(empty($post["nis"]) || empty($post["nisn"]))die(json_encode(array("error"=>"NIS dan NISN tidak boleh kosong")));
			if(empty($post["kd_jurusan"]) || $post["kd_jurusan"]=='0')die(json_encode(array("error"=>"Pilih jurusan dulu")));
			if(empty($post["kd_kelas"]) || $post["kd_kelas"]=='0')die(json_encode(array("error"=>"Pilih kelas dulu")));
			$input=$this->Siswa_model->inputSiswa($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
		}
	}
	function submitGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$post=$this->input->post();
			if(isset($post["photo"]))unset($post["photo"]);
			if(isset($_FILES["photo"])){
				$config["upload_path"]="./assets/images/guru/";
				$config["allowed_types"]= 'gif|png|jpg|jpeg|bmp';
				$config["overwrite"]=TRUE;
				$config["file_name"]=md5($_FILES["photo"]["name"].time());
				$this->load->library('upload', $config);
				if($this->upload->do_upload("photo")){
					$dataupload=$this->upload->data();
					$data["photo"]=$config["upload_path"].$dataupload["file_name"];
				}else{
					echo json_encode(array("error"=>$this->upload->display_errors()));
					die;
				}
				
			}
			if($post["options"]==2 && strlen(trim($post["nip"]))==0)die(json_encode(array("error"=>"NIP Tidak boleh kosong"))); 
			if(isset($post["options"]))unset($post["options"]);
			foreach($post as $key=>$line){
				if(strlen(trim($line))==0)die(json_encode(array("error"=>"Masih ada data yang kosong")));
				$data[$key]=$line;
			}
			$data["tgl_lahir"]=date("Y-m-d",strtotime($data["tgl_lahir"]));
			$input=$this->Guru_model->inputGuru($data);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
				
		}
	}
	function lihatDetailBagiMapel(){
		$post=$this->input->post();
		if(isset($post["id"])){
			$this->db->where("id",$post["id"]);
			$data=$this->db->get("pembagian_mapel_6771");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function lihatDetailNilaiTugas(){
		$post=$this->input->post();
		if(isset($post["nis"])){
			echo json_encode($this->NilaiTugas_model->getNilaiByNis());
		}
	}
	function lihatDetailKelas(){
		$post=$this->input->post();
		if(isset($post["id_kelas"])){
			$data=$this->db->query("select * from kelas_6771 where id_kelas=".$this->db->escape_str($post["id_kelas"])."");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function lihatDetailJurusan(){
		$post=$this->input->post();
		if(isset($post["id_jurusan"])){
			$data=$this->db->query("select * from jurusan_6771 where id_jurusan=".$this->db->escape_str($post["id_jurusan"])."");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function lihatDetailOrtuSiswa(){
		$post=$this->input->post();
		if(isset($post["nis"])){
			$data=$this->db->query("select a.*,b.nama from ortu_siswa_6771 a inner join siswa_6771 b on a.nis=b.nis where a.nis='".$this->db->escape_str($post["nis"])."'");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function lihatDetailGuru(){
		$post=$this->input->post();
		if(isset($post["kode_guru"])){
			$data=$this->db->query("select * from guru_6771 where kode_guru='".$this->db->escape_str($post["kode_guru"])."'");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function lihatDetailMapelGuru(){
		$post=$this->input->post();
		if(isset($post["id"])){
			$id=abs((int)$post["id"]);
			$data=$this->db->query("select * from guru_mengajar_6771 where id=$id");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
		
	}
	function lihatDetailDiklat(){
		$post=$this->input->post();
		if(isset($post["kode_mata_diklat"])){
			$kode=$this->db->escape_str($post["kode_mata_diklat"]);
			$data=$this->db->query("select * from mata_diklat_6771 where kode_mata_diklat='".$kode."'");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function lihatDetailMapel(){
		$post=$this->input->post();
		if(isset($post["kode_mapel"])){
			$data=$this->db->query("select * from mapel_6771 where kode_mapel='".$this->db->escape_str($post["kode_mapel"])."'");
			if($data->num_rows()>=1){
				foreach($data->row() as $key=>$ikkeh)$data->row()->$key=stripslashes($ikkeh);
				echo json_encode($data->row());
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function lihatDetailSiswa(){
		$post=$this->input->post();
		if(isset($post["nis"])){
			$nis=$this->db->escape_str($post["nis"]);
			$data=$this->db->query("select * from siswa_6771 a inner join jurusan_6771 b inner join kelas_6771 c inner join agama_6771 d on a.kd_jurusan=b.id_jurusan and a.kd_kelas=c.id_kelas and a.kd_agama=d.id_agama where a.nis='".$nis."' ");
			if($data->num_rows()>=1){
				$row=$data->row();
				$data2=$this->db->query("select a.id_kelas,a.prefix_kelas,b.nama_jurusan,a.nomor_kelas from kelas_6771 a inner join jurusan_6771 b on a.kd_jurusan=b.id_jurusan where a.kd_jurusan=".$row->kd_jurusan." order by a.prefix_kelas,a.nomor_kelas")->result();
				foreach($row as $key=>$ikkeh)$row->$key=stripslashes($ikkeh);
				$row->pilih_kelas=$data2;
				echo json_encode($row);
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
	}
	function lihatDetailWaliKelas(){
		$post=$this->input->post();
		if(isset($post["kode_guru"])){
			$kode=$this->db->escape_str($post["kode_guru"]);
			$data=$this->db->query("select * from walikelas_6771 where kode_guru='".$kode."'");
			if($data->num_rows()>=1){
				$row=$data->row();
				foreach($row as $key=>$ikkeh)$row->$key=stripslashes($ikkeh);
				echo json_encode($row);
			}else{
				$error=$this->db->error();
				if(isset($error["message"]))echo json_encode(array("error"=>$error["message"]));
			}
		}
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
					$this->load->view("admin/login",array("status"=>'<div class="alert alert-danger" role="alert"><strong>Login Gagal</strong></div>'));
				}
			}
		}
	}
	function gantiPagingOrtuSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_ortu",abs((int)$post["perpage"]));
				redirect("admin/dataOrtuSiswa");
			}
			
		}
	}
	function gantiPagingSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				if(isset($post["tampil"]))$this->session->set_userdata("tampil",$post["tampil"]);
				$this->session->set_userdata("perpage_siswa",abs((int)$post["perpage"]));
				redirect("admin/dataSiswa");
			}
			
		}
	}
	function gantiPagingMapelGuru(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_mapelguru",abs((int)$post["perpage"]));
				redirect("admin/dataMapelGuru");
			}
			
		}
	}
	function gantiPagingMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_mapel",abs((int)$post["perpage"]));
				redirect("admin/dataMapel");
			}
			
		}
	}
	function getKelas(){
		if(!empty($this->input->get("id_jurusan"))){
			$id_jurusan=$this->db->escape_str($this->input->get("id_jurusan"));
			$query=$this->db->query("select * from kelas_6771 a inner join jurusan_6771 b on a.kd_jurusan=b.id_jurusan where b.id_jurusan=$id_jurusan")->result();
			$kelas='';
			foreach($query as $mbuh)$kelas.="<option value=\"".$mbuh->id_kelas."\">".$mbuh->prefix_kelas." ".$mbuh->nama_jurusan." ".$mbuh->nomor_kelas."</option>";
			echo $kelas;
			
		}else echo "you bitches";
	}
	function hapusMataDiklat(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$kode=$this->input->post("kode_forHapus");
			$kode=$this->db->escape_str($kode);
			$query=$this->db->query("delete from mata_diklat_6771 where kode_mata_diklat='".$kode."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function hapusBagiMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa hapus pembagian mapel"));
		else{
			$kode=$this->input->post("id_forHapus");
			$kode=$this->db->escape_str($kode);
			$query=$this->db->delete("pembagian_mapel_6771",array("id"=>$kode));
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function hapusOrtuSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$nis=$this->input->post("nis_forHapus");
			$nis=$this->db->escape_str($nis);
			$query=$this->db->query("delete from ortu_siswa_6771 where nis='".$nis."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function hapusJurusan(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa hapus jurusan"));
		else{
			$id=$this->input->post("id_jurusan_forHapus");
			$id=$this->db->escape_str($id);
			$query=$this->db->query("delete from jurusan_6771 where id_jurusan='".$id."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function hapusKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input kelas"));
		else{
			$id=$this->input->post("id_kelas_forHapus");
			$id=$this->db->escape_str($id);
			$query=$this->db->query("delete from kelas_6771 where id_kelas='".$id."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function hapusWaliKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa hapus wali kelas"));
		else{
			$kode=$this->input->post("kode_guru_forHapus");
			$query=$this->db->delete("walikelas_6771",array("kode_guru"=>$kode));
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function hapusSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","tatausaha")))echo json_encode(array("error"=>"Hanya Admin dan Tata Usaha saja yang bisa input siswa ".$this->session->userdata("hak_akses")));
		else{
			$nis=$this->input->post("nis_forEdit");
			$nis=$this->db->escape_str($nis);
			$data=$this->db->query("select * from siswa_6771 where nis='".$nis."'")->row();
			if(!empty($data->photo))unlink($data->photo);
			$query=$this->db->query("delete from siswa_6771 where nis='".$nis."'");
			if($query){
				echo json_encode(array("sukses"=>"Berhasil hapus data"));
			}else{
				echo json_encode(array("error"=>$this->db->error()["message"]));
			}
		}
	}
	function getNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiTugas_model->getNilai();
		echo json_encode($data);
	}
	function getNilaiPraktek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiPraktek_model->getNilai();
		echo json_encode($data);
	}
	function getNilaiProyek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiProyek_model->getNilai();
		echo json_encode($data);
	}
	function getNilaiPortofolio(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiPortofolio_model->getNilai();
		echo json_encode($data);
	}
	function getNilaiUas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiUas_model->getNilai();
		echo json_encode($data);
	}
	function getNilaiSikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiSikap_model->getNilai();
		echo json_encode($data);
	}
	function getNilaiUts(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiUts_model->getNilai();
		echo json_encode($data);
	}
	function getSiswaByKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiTugas_model->getSiswaByKelas($this->input->get("all"));
		echo $data;
		
	}
	function dataNilaiUAS(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaiuas)$perpage=$this->session->perpage_nilaiuas;
			else $perpage=5;
			$config['base_url'] = site_url('admin/dataNilaiUAS');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;;
			
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas2");
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok2");
			$arr["nilai_uas_6771.kd_mapel"]=$this->session->userdata("kd_mapel2");
			$arr["nilai_uas_6771.semester"]=$this->session->userdata("semester2");
			$arr["nilai_uas_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran2");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilaiUAS"]=$this->NilaiUas_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiUas_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("nis_cok2");
				$this->session->unset_userdata("kd_kelas2");
				$this->session->unset_userdata("kd_mapel2");
				$this->session->unset_userdata("semester2");
				$this->session->unset_userdata("tahun_ajaran2");
			
			}else{
				$data["dataNilaiUAS"]=$this->NilaiUas_model->getData($data['page'],$perpage,$arr);
				$config['total_rows']=$this->NilaiUas_model->total($arr);
				$data["caristatus"]=null;
			}
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok2"))?$this->session->userdata("nis_cok2"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas2"))?$this->session->userdata("kd_kelas2"):'0';
			$data["kd_mapel_value"]=!is_null($this->session->userdata("kd_mapel2"))?$this->session->userdata("kd_mapel2"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester2"))?$this->session->userdata("semester2"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran2"))?$this->session->userdata("tahun_ajaran2"):'0';
			
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiTugas_model->getNisData();
			$data["mapelData"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"));
			$data["mapelData2"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"),2);
			$fck=$this->Home_m->getMapelYgDiajar($this->session->userdata("kode_guru"));
			$data["mapelYangDiajar"]=array();
			foreach($fck as $fuck)$data["mapelYangDiajar"][]=$fuck->kd_mapel;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="datanilai";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/nilai_uas",$data);			
		}
		
	}
	function dataNilaiUTS(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaiuts)$perpage=$this->session->perpage_nilaiuts;
			else $perpage=5;
			$config['base_url'] = site_url('admin/dataNilaiUTS');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;;
			
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas3");
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok3");
			$arr["nilai_uts_6771.kd_mapel"]=$this->session->userdata("kd_mapel3");
			$arr["nilai_uts_6771.semester"]=$this->session->userdata("semester3");
			$arr["nilai_uts_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran3");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilaiUTS"]=$this->NilaiUts_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiUts_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("kd_kelas3");
				$this->session->unset_userdata("kd_kelas3");
				$this->session->unset_userdata("kd_mapel3");
				$this->session->unset_userdata("semester3");
				$this->session->unset_userdata("tahun_ajaran3");
			
			}else{
				$data["dataNilaiUTS"]=$this->NilaiUts_model->getData($data['page'],$perpage,$arr);
				$config['total_rows']=$this->NilaiUts_model->total($arr);
				$data["caristatus"]=null;
			}
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok3"))?$this->session->userdata("nis_cok3"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas3"))?$this->session->userdata("kd_kelas3"):'0';
			$data["kd_mapel_value"]=!is_null($this->session->userdata("kd_mapel3"))?$this->session->userdata("kd_mapel3"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester3"))?$this->session->userdata("semester3"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran3"))?$this->session->userdata("tahun_ajaran3"):'0';
			
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiTugas_model->getNisData();
			$data["mapelData"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"));
			$data["mapelData2"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"),2);
			$fck=$this->Home_m->getMapelYgDiajar($this->session->userdata("kode_guru"));
			$data["mapelYangDiajar"]=array();
			foreach($fck as $fuck)$data["mapelYangDiajar"][]=$fuck->kd_mapel;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="datanilai";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/nilai_uts",$data);			
		}
		
	}
	function dataNilaiSikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaisikap)$perpage=$this->session->perpage_nilaisikap;
			else $perpage=5;
			$config['base_url'] = site_url('admin/dataNilaiSikap');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;;
			
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas7");
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok7");
			$arr["nilai_sikap_6771.kd_mapel"]=$this->session->userdata("kd_mapel7");
			$arr["nilai_sikap_6771.semester"]=$this->session->userdata("semester7");
			$arr["nilai_sikap_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran7");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilai"]=$this->NilaiSikap_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiSikap_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("nis_cok7");
				$this->session->unset_userdata("kd_kelas7");
				$this->session->unset_userdata("kd_mapel7");
				$this->session->unset_userdata("semester7");
				$this->session->unset_userdata("tahun_ajaran7");
			
			}else{
				$data["dataNilai"]=$this->NilaiSikap_model->getData($data['page'],$perpage,$arr);
				$config['total_rows']=$this->NilaiSikap_model->total($arr);
				$data["caristatus"]=null;
			}
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok7"))?$this->session->userdata("nis_cok7"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas7"))?$this->session->userdata("kd_kelas7"):'0';
			$data["kd_mapel_value"]=!is_null($this->session->userdata("kd_mapel7"))?$this->session->userdata("kd_mapel7"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester7"))?$this->session->userdata("semester7"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran7"))?$this->session->userdata("tahun_ajaran7"):'0';
			
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiTugas_model->getNisData();
			$data["mapelData"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"));
			$data["mapelData2"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"),2);
			$fck=$this->Home_m->getMapelYgDiajar($this->session->userdata("kode_guru"));
			$data["mapelYangDiajar"]=array();
			foreach($fck as $fuck)$data["mapelYangDiajar"][]=$fuck->kd_mapel;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="datanilai3";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/nilai_sikap",$data);			
		}
		
	}
	function AksiSubmitRaport(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai UAS"));
		else{
			$input=$this->SubmitRaport_model->inputData();
			echo json_encode($input);
		}
	}
	function submitRaport(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if(empty($data["walikelas"]) && $this->session->userdata("hak_akses")!="admin")die(json_encode(array("error"=>"Hanya guru dan admin yang bisa submit raport")));
			if($this->session->userdata("hak_akses")=="admin")$data["semuakelas"]=$this->Siswa_model->getKelasurut();
			
			if($this->session->perpage_submitraport)$perpage=$this->session->perpage_submitraport;
			else $perpage=5;
			$config['base_url'] = site_url('admin/submitRaport');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			
			
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok9");
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas9");
			$arr["nilai_tugas_6771.semester"]=$this->session->userdata("semester9");
			$arr["nilai_tugas_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran9");
			$arr["submitraport_6771.submit"]=$this->session->userdata("sudahdisubmit");
			//print_r($arr);die;
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				
				
				$config['total_rows']=0;
				$data["dataNilai"]=$this->SubmitRaport_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config["total_rows"]=$this->SubmitRaport_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("nis_cok9");
				$this->session->unset_userdata("kd_kelas9");
				$this->session->unset_userdata("semester9");
				$this->session->unset_userdata("tahun_ajaran9");
				$this->session->unset_userdata("sudahdisubmit");
			}else{
				if($this->session->hak_akses=="admin"){
					$config['total_rows']=0;
					$kd_kelas=$this->input->get("kd_kelas");
					if(!empty($kd_kelas)){
						$this->session->unset_userdata("nis_cok9");
						$this->session->unset_userdata("kd_kelas9");
						$this->session->unset_userdata("semester9");
						$this->session->unset_userdata("tahun_ajaran9");
						$this->session->unset_userdata("sudahdisubmit");
						$arr=null;
					}
					$data["dataNilai"]=$this->SubmitRaport_model->getData($data['page'],$perpage,$arr,$kd_kelas);
					$config['total_rows']=$this->SubmitRaport_model->total($arr,$kd_kelas);
					
				}
				else {
					$data["dataNilai"]=$this->SubmitRaport_model->getData($data['page'],$perpage,$arr);
					
					$config['total_rows']=$this->SubmitRaport_model->total($arr);

				}
				//print_r($data["dataNilai"]);die;
				//print_r($data['dataNilai']);
				//die;
				
				$data["caristatus"]=null;
			}
			
			//print_r($data["walikelas"]);die;
			//$data["caristatus"]=null;
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok9"))?$this->session->userdata("nis_cok9"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas9"))?$this->session->userdata("kd_kelas9"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester9"))?$this->session->userdata("semester9"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran9"))?$this->session->userdata("tahun_ajaran9"):'0';
			$data["sudahdisubmit_value"]=!is_null($this->session->userdata("sudahdisubmit"))?$this->session->userdata("sudahdisubmit"):'0';
			$data["sudahdisubmit"]=$this->SubmitRaport_model->listSudahAda();
			//print_r($data["sudahdisubmit"]);die;
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiPraktek_model->getNisData();
			$data["mapelData2"]=$this->NilaiPraktek_model->getMapelData($this->session->userdata("kode_guru"),2);
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="raport";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/submit_raport",$data);
		}
	}
	function getNilaiRaport(){
		$post=$this->input->post();
		//print_r($post);die;
		if(!empty($post["nis"]) && !empty($post["semester"]) && !empty($post["tahun_ajaran"])){
			$data=$this->SubmitRaport_model->getNilai($post["nis"],$post["semester"],$post["tahun_ajaran"]);
			echo json_encode($data);
		}else echo json_encode(array("error"=>"Paratemeter tidak ada"));
	}
	function dataRaport(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_raport)$perpage=$this->session->perpage_raport;
			else $perpage=5;
			$config['base_url'] = site_url('admin/dataRaport');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas8");
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok8");
			$arr["nilai_tugas_6771.kd_mapel"]=$this->session->userdata("kd_mapel8");
			$arr["nilai_tugas_6771.semester"]=$this->session->userdata("semester8");
			$arr["nilai_tugas_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran8");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilai"]=$this->NilaiRaport_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiRaport_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("nis_cok8");
				$this->session->unset_userdata("kd_kelas8");
				$this->session->unset_userdata("kd_mapel8");
				$this->session->unset_userdata("semester8");
				$this->session->unset_userdata("tahun_ajaran8");
			}else{
				$data["dataNilai"]=$this->NilaiRaport_model->getData($data['page'],$perpage,$arr);
				//print_r($data['dataNilai']);
				//die;
				$config['total_rows']=$this->NilaiRaport_model->total($arr);
				$data["caristatus"]=null;
			}
			//$data["caristatus"]=null;
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok8"))?$this->session->userdata("nis_cok8"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas8"))?$this->session->userdata("kd_kelas8"):'0';
			$data["kd_mapel_value"]=!is_null($this->session->userdata("kd_mapel8"))?$this->session->userdata("kd_mapel8"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester8"))?$this->session->userdata("semester8"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran8"))?$this->session->userdata("tahun_ajaran8"):'0';

			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiPraktek_model->getNisData();
			$data["mapelData2"]=$this->NilaiPraktek_model->getMapelData($this->session->userdata("kode_guru"),2);
			
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="raport";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/raport",$data);
		}
	}
	function dataNilaiPraktek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaipraktek)$perpage=$this->session->perpage_nilaipraktek;
			else $perpage=5;
			$config['base_url'] = site_url('admin/dataNilaiPraktek');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas4");
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok4");
			$arr["nilai_praktek_6771.kd_mapel"]=$this->session->userdata("kd_mapel4");
			$arr["nilai_praktek_6771.semester"]=$this->session->userdata("semester4");
			$arr["nilai_praktek_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran4");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilai"]=$this->NilaiPraktek_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiPraktek_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("nis_cok4");
				$this->session->unset_userdata("kd_kelas4");
				$this->session->unset_userdata("kd_mapel4");
				$this->session->unset_userdata("semester4");
				$this->session->unset_userdata("tahun_ajaran4");
			}else{
				$data["dataNilai"]=$this->NilaiPraktek_model->getData($data['page'],$perpage,$arr);
				$config['total_rows']=$this->NilaiPraktek_model->total($arr);
				$data["caristatus"]=null;
			}
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok4"))?$this->session->userdata("nis_cok4"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas4"))?$this->session->userdata("kd_kelas4"):'0';
			$data["kd_mapel_value"]=!is_null($this->session->userdata("kd_mapel4"))?$this->session->userdata("kd_mapel4"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester4"))?$this->session->userdata("semester4"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran4"))?$this->session->userdata("tahun_ajaran4"):'0';
			
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiPraktek_model->getNisData();
			$data["mapelData"]=$this->NilaiPraktek_model->getMapelData($this->session->userdata("kode_guru"));
			$data["mapelData2"]=$this->NilaiPraktek_model->getMapelData($this->session->userdata("kode_guru"),2);
			$fck=$this->Home_m->getMapelYgDiajar($this->session->userdata("kode_guru"));
			$data["mapelYangDiajar"]=array();
			foreach($fck as $fuck)$data["mapelYangDiajar"][]=$fuck->kd_mapel;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="datanilai2";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/nilai_praktek",$data);
		}
	}
	function dataNilaiProyek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaiproyek)$perpage=$this->session->perpage_nilaiproyek;
			else $perpage=5;
			$config['base_url'] = site_url('admin/dataNilaiProyek');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas5");
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok5");
			$arr["nilai_praktek_6771.kd_mapel"]=$this->session->userdata("kd_mapel5");
			$arr["nilai_praktek_6771.semester"]=$this->session->userdata("semester5");
			$arr["nilai_praktek_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran5");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilai"]=$this->NilaiProyek_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiProyek_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("nis_cok5");
				$this->session->unset_userdata("kd_kelas5");
				$this->session->unset_userdata("kd_mapel5");
				$this->session->unset_userdata("semester5");
				$this->session->unset_userdata("tahun_ajaran5");
			}else{
				$data["dataNilai"]=$this->NilaiProyek_model->getData($data['page'],$perpage,$arr);
				$config['total_rows']=$this->NilaiProyek_model->total($arr);
				$data["caristatus"]=null;
			}
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok5"))?$this->session->userdata("nis_cok5"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas5"))?$this->session->userdata("kd_kelas5"):'0';
			$data["kd_mapel_value"]=!is_null($this->session->userdata("kd_mapel5"))?$this->session->userdata("kd_mapel5"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester5"))?$this->session->userdata("semester5"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran5"))?$this->session->userdata("tahun_ajaran5"):'0';
			
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiProyek_model->getNisData();
			$data["mapelData"]=$this->NilaiProyek_model->getMapelData($this->session->userdata("kode_guru"));
			$data["mapelData2"]=$this->NilaiProyek_model->getMapelData($this->session->userdata("kode_guru"),2);
			$fck=$this->Home_m->getMapelYgDiajar($this->session->userdata("kode_guru"));
			$data["mapelYangDiajar"]=array();
			foreach($fck as $fuck)$data["mapelYangDiajar"][]=$fuck->kd_mapel;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="datanilai2";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/nilai_proyek",$data);
		}
	}
	function dataNilaiPortofolio(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaiportofolio)$perpage=$this->session->perpage_nilaiportofolio;
			else $perpage=5;
			$config['base_url'] = site_url('admin/dataNilaiPortofolio');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas6");
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok6");
			$arr["nilai_portofolio_6771.kd_mapel"]=$this->session->userdata("kd_mapel6");
			$arr["nilai_portofolio_6771.semester"]=$this->session->userdata("semester6");
			$arr["nilai_portofolio_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran6");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilai"]=$this->NilaiPortofolio_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiPortofolio_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("nis_cok6");
				$this->session->unset_userdata("kd_kelas6");
				$this->session->unset_userdata("kd_mapel6");
				$this->session->unset_userdata("semester6");
				$this->session->unset_userdata("tahun_ajaran6");
			}else{
				$data["dataNilai"]=$this->NilaiPortofolio_model->getData($data['page'],$perpage,$arr);
				$config['total_rows']=$this->NilaiPortofolio_model->total($arr);
				$data["caristatus"]=null;
			}
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok6"))?$this->session->userdata("nis_cok6"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas6"))?$this->session->userdata("kd_kelas6"):'0';
			$data["kd_mapel_value"]=!is_null($this->session->userdata("kd_mapel6"))?$this->session->userdata("kd_mapel6"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester6"))?$this->session->userdata("semester6"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran6"))?$this->session->userdata("tahun_ajaran6"):'0';
			
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiPortofolio_model->getNisData();
			$data["mapelData"]=$this->NilaiPortofolio_model->getMapelData($this->session->userdata("kode_guru"));
			$data["mapelData2"]=$this->NilaiPortofolio_model->getMapelData($this->session->userdata("kode_guru"),2);
			$fck=$this->Home_m->getMapelYgDiajar($this->session->userdata("kode_guru"));
			$data["mapelYangDiajar"]=array();
			foreach($fck as $fuck)$data["mapelYangDiajar"][]=$fuck->kd_mapel;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="datanilai2";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/nilai_portofolio",$data);
		}
	}
	function dataNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaitugas)$perpage=$this->session->perpage_nilaitugas;
			else $perpage=5;
			$config['base_url'] = site_url('admin/dataNilaiTugas');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$arr["siswa_6771.kd_kelas"]=$this->session->userdata("kd_kelas");
			$arr["siswa_6771.nis"]=$this->session->userdata("nis_cok");
			$arr["nilai_tugas_6771.kd_mapel"]=$this->session->userdata("kd_mapel");
			$arr["nilai_tugas_6771.semester"]=$this->session->userdata("semester");
			$arr["nilai_tugas_6771.tahun_ajaran"]=$this->session->userdata("tahun_ajaran");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilaiTugas"]=$this->NilaiTugas_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiTugas_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				$this->session->unset_userdata("nis_cok");
				$this->session->unset_userdata("kd_kelas");
				$this->session->unset_userdata("kd_mapel");
				$this->session->unset_userdata("semester");
				$this->session->unset_userdata("tahun_ajaran");
			}else{
				$data["dataNilaiTugas"]=$this->NilaiTugas_model->getData($data['page'],$perpage,$arr);
				$config['total_rows']=$this->NilaiTugas_model->total($arr);
				$data["caristatus"]=null;
			}
			$this->pagination->initialize($config);
			
			$data["nis_value"]=!is_null($this->session->userdata("nis_cok"))?$this->session->userdata("nis_cok"):'0';
			$data["kd_kelas_value"]=!is_null($this->session->userdata("kd_kelas"))?$this->session->userdata("kd_kelas"):'0';
			$data["kd_mapel_value"]=!is_null($this->session->userdata("kd_mapel"))?$this->session->userdata("kd_mapel"):'0';
			$data["semester_value"]=!is_null($this->session->userdata("semester"))?$this->session->userdata("semester"):'0';
			$data["tahun_ajaran_value"]=!is_null($this->session->userdata("tahun_ajaran"))?$this->session->userdata("tahun_ajaran"):'0';
			
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiTugas_model->getNisData();
			$data["mapelData"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"));
			$data["mapelData2"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"),2);
			$fck=$this->Home_m->getMapelYgDiajar($this->session->userdata("kode_guru"));
			$data["mapelYangDiajar"]=array();
			foreach($fck as $fuck)$data["mapelYangDiajar"][]=$fuck->kd_mapel;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="datanilai";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/nilai_tugas",$data);
		}
	}
	function dataBagiMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_bagimapel)$perpage=$this->session->perpage_bagimapel;
			else $perpage=5;

			$arr["kelas_prefix"]=$this->session->userdata("kelas_prefix");
			$arr["kd_jurusan"]=$this->session->userdata("kd_jurusan");
			$arr["semester"]=$this->session->userdata("semester");
			$arr["tahun_ajaran"]=$this->session->userdata("tahun_ajaran");
			$arr["kode_kelompok_mapel"]=$this->session->userdata("kode_kelompok_mapel");
			
			//foreach($arr as $asu)i
						
			$config['base_url'] = site_url('admin/dataBagiMapel');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->BagiMapel_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->BagiMapel_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
				$this->session->unset_userdata("kelas_prefix");$arr["kelas_prefix"]=null;
				$this->session->unset_userdata("kd_jurusan");$arr["kd_jurusan"]=null;
				$this->session->unset_userdata("tahun_ajaran");$arr["tahun_ajaran"]=null;
				$this->session->unset_userdata("semester");$arr["semester"]=null;
				$this->session->unset_userdata("kode_kelompok_mapel");$arr["kode_kelompok_mapel"]=null;
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$data["caristatus"]=null;
				$get=$this->BagiMapel_model->getData($data['page'],$perpage,$arr);
				$config['total_rows'] =$this->BagiMapel_model->total($arr);
				//echo $config['total_rows'];
				//die;
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["kelas_prefix"]=!is_null($arr["kelas_prefix"])?$arr["kelas_prefix"]:"0";
			$data["kd_jurusan"]=!is_null($arr["kd_jurusan"])?$arr["kd_jurusan"]:"0";
			$data["semester"]=!is_null($arr["semester"])?$arr["semester"]:"0";
			$data["kode_kelompok_mapel"]=!is_null($arr["kode_kelompok_mapel"])?$arr["kode_kelompok_mapel"]:"0";
			$data["tahun_ajaran"]=!is_null($arr["tahun_ajaran"])?$arr["tahun_ajaran"]:"0";
			
			$data["idAktif"]="datakurikulum";
			$data["jurusan"]=$this->Kelas_model->getJurusan();
			$data["kelompokMapel"]=$this->BagiMapel_model->getKelompokMapel();
			$data["dataBagiMapel"]=$get;
			$data["kodeMapel"]=$this->MapelGuru_model->getKodeMapel();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["hak_akses"]=$this->session->hak_akses;
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/pembagian_mapel",$data);
			
		}
	}
	function dataKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_kelas)$perpage=$this->session->perpage_kelas;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/dataKelas');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->Kelas_model->cariKelas($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Kelas_model->jumlahcariKelas($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->Kelas_model->total();
				$data["caristatus"]=null;
				$get=$this->Kelas_model->getKelas($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["idAktif"]="datakurikulum";
			$data["jurusan"]=$this->Kelas_model->getJurusan();
			$data["dataKelas"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["hak_akses"]=$this->session->hak_akses;
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/kelas",$data);
			
		}
	}
	function dataJurusan(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_jurusan)$perpage=$this->session->perpage_jurusan;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/dataJurusan');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->Jurusan_model->cariJurusan($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Jurusan_model->jumlahcariJurusan($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->Jurusan_model->total();
				$data["caristatus"]=null;
				$get=$this->Jurusan_model->getJurusan($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			
			$data["idAktif"]="datakurikulum";
			$data["dataJurusan"]=$get;
			$data["kodeDikat"]=$this->Jurusan_model->getKodediklat();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["hak_akses"]=$this->session->hak_akses;
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/jurusan",$data);
			
		}

	}
	function dataMataDiklat(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_matadiklat)$perpage=$this->session->perpage_matadiklat;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/dataMataDiklat');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->Mapel_model->cariMapel($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Mapel_model->jumlahcariMapel($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->MataDiklat_model->total();
				$data["caristatus"]=null;
				$get=$this->MataDiklat_model->getMataDiklat($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["idAktif"]="datakurikulum";
			$data["dataMataDiklat"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["hak_akses"]=$this->session->hak_akses;
			$data["judulKonten"]=$this->session->nama_hak_akses."- Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/mata_diklat",$data);
			
		}
	}
	function dataMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_mapel)$perpage=$this->session->perpage_mapel;
			else $perpage=5;
						
			$config['base_url'] = site_url('admin/dataMapel');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$getdata=$this->Mapel_model->cariMapel($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Mapel_model->jumlahcariMapel($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$get=$getdata->result();
			}else{
				//$config["num_links"]=$config['total_rows']/$perpage;
				$config['total_rows'] = $this->Mapel_model->total();
				$data["caristatus"]=null;
				$get=$this->Mapel_model->getMapel($data['page'],$perpage);
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			
			$data["idAktif"]="datakurikulum";
			$data["dataMapel"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["hak_akses"]=$this->session->hak_akses;
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/mapel",$data);
			
		}

	}
	function dataSiswa(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_siswa)$perpage=$this->session->perpage_siswa;
			else $perpage=5;
			
			$tampil=$this->session->userdata("tampil");
			
			$config['base_url'] = site_url('admin/dataSiswa');
		
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['reuse_query_string'] = true;
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$get=$this->Siswa_model->cariSiswa($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->Siswa_model->jumlahcariSiswa($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><b>Ditemukan '".$config['total_rows']."' data dengan keyword '".$getrequest["q"]."'</b></div>";
				$data["agama"]=null;
			}else{
			//$config["num_links"]=$config['total_rows']/$perpage;

				$config['total_rows'] = $this->Siswa_model->total($tampil);
				$data["caristatus"]=null;
				$get=$this->Siswa_model->getSiswa($data['page'],$perpage,$tampil);
				
				
			}
			$jurusan='';
			$query=$this->db->query("select * from jurusan_6771")->result();
			foreach($query as $mbuh){
				$jurusan.="<option value=\"".$mbuh->id_jurusan."\">".$mbuh->nama_jurusan." | ".$mbuh->nama_full."</option>";
			}
			$agama='';
			$query=$this->db->query("select * from agama_6771")->result();
			foreach($query as $mbuh){
				$agama.="<option value=\"".$mbuh->id_agama."\">".$mbuh->agama."</option>";
			}
			$data["agama"]=$agama;
			$data["idAktif"]="datasiswa";
			$data["jurusan"]=$jurusan;
			//print_r($this->Siswa_model->getKelasurut());die;
			$data["tampil"]=$tampil!=null?$tampil:0;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			
			foreach($get as $key=>$line){
				foreach($line as $key2=>$mbuh)$get[$key]->$key2=stripslashes($mbuh);
			}
			$data["dataSiswa"]=$get;
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["hak_akses"]=$this->session->hak_akses;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["notif_log"]=$this->Log_model->getLog();
			$this->template->load("admin/index","admin/siswa",$data);
			
		}
	}
}
?>