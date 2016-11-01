<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Nilai_Tugas extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->model(array("Home_m","admin/NilaiTugas_model","admin/Kelas_model","admin/MapelGuru_model","admin/SubmitRaport_model","admin/Log_model","admin/Siswa_model"));
	}
	function index(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaitugas)$perpage=$this->session->perpage_nilaitugas;
			else $perpage=5;
			$config['base_url'] = site_url('admin/nilai_tugas/index');
			$config['per_page'] = $perpage;
			$config["uri_segment"] = 4;
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
			$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
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
			//print_r($data["dataNilaiTugas"]);die;
			$this->template->load("admin/index","admin/nilai_tugas",$data);
		}
	}
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->set_userdata("kd_kelas",$post["kd_kelas"]);
				$this->session->set_userdata("nis_cok",$post["nis"]);
				$this->session->set_userdata("kd_mapel",$post["kd_mapel"]);
				$this->session->set_userdata("semester",$post["semester"]);
				$this->session->set_userdata("tahun_ajaran",$post["tahun_ajaran"]);
				redirect("admin/nilai_tugas/index");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaitugas",abs((int)$post["perpage"]));
				redirect("admin/nilai_tugas/index");
			}
			
		}
	}
	function tambahNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai Tugas"));
		else{
			$input=$this->NilaiTugas_model->inputData();
			echo json_encode($input);
		}
	}
	function editNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai Tugas"));
		else{
			$edit=$this->NilaiTugas_model->editData();
			echo json_encode($edit);
			
		}
	}
	function hapusNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai Tugas"));
		else{
			$hapus=$this->NilaiTugas_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function detailNilaiTugas(){
		$post=$this->input->post();
		if(isset($post["nis"])){
			echo json_encode($this->NilaiTugas_model->getNilaiByNis());
		}
	}
	function getNilaiTugas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiTugas_model->getNilai();
		echo json_encode($data);
	}
	function getSiswaByKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiTugas_model->getSiswaByKelas($this->input->get("all"));
		echo $data;
		
	}
}

?>