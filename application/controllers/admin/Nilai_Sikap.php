<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Nilai_Sikap extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->library("SessNilai");
		$this->load->model(array("Home_m","admin/NilaiTugas_model","admin/NilaiSikap_model","admin/Kelas_model","admin/MapelGuru_model","admin/SubmitRaport_model","admin/Log_model","admin/Siswa_model"));
	}
	function index(){
		$this->sessnilai->resetSessNilai("sikap");
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_nilaisikap)$perpage=$this->session->perpage_nilaisikap;
			else $perpage=5;
			$config['base_url'] = site_url('admin/nilai_sikap/index');
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
			$arr["siswa_6771.kd_kelas"]=$this->sessnilai->get_userdata("nilai_sikap","kd_kelas");
			$arr["siswa_6771.nis"]=$this->sessnilai->get_userdata("nilai_sikap","nis_cok");
			$arr["nilai_sikap_6771.kd_mapel"]=$this->sessnilai->get_userdata("nilai_sikap","kd_mapel");
			$arr["nilai_sikap_6771.semester"]=$this->sessnilai->get_userdata("nilai_sikap","semester");
			$arr["nilai_sikap_6771.tahun_ajaran"]=$this->sessnilai->get_userdata("nilai_sikap","tahun_ajaran");
			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && !empty($getrequest["q"])){
				$data["dataNilai"]=$this->NilaiSikap_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->NilaiSikap_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config["total_rows"]."' data dengan keyword '".$getrequest["q"]."'</div></div>";
				
				unset($this->session->userdata["nilai_sikap"]);
			}else{
				$data["dataNilai"]=$this->NilaiSikap_model->getData($data['page'],$perpage,$arr);
				$config['total_rows']=$this->NilaiSikap_model->total($arr);
				$data["caristatus"]=null;
			}
			$this->pagination->initialize($config);
			
			$data["nis_value"]=$this->sessnilai->get_userdata("nilai_sikap","nis_cok")!=null?$this->sessnilai->get_userdata("nilai_sikap","nis_cok"):'0';
			$data["kd_kelas_value"]=$this->sessnilai->get_userdata("nilai_sikap","kd_kelas")!=null?$this->sessnilai->get_userdata("nilai_sikap","kd_kelas"):'0';
			$data["kd_mapel_value"]=$this->sessnilai->get_userdata("nilai_sikap","kd_mapel")!=null?$this->sessnilai->get_userdata("nilai_sikap","kd_mapel"):'0';
			$data["semester_value"]=$this->sessnilai->get_userdata("nilai_sikap","semester")!=null?$this->sessnilai->get_userdata("nilai_sikap","semester"):'0';
			$data["tahun_ajaran_value"]=$this->sessnilai->get_userdata("nilai_sikap","tahun_ajaran")!=null?$this->sessnilai->get_userdata("nilai_sikap","tahun_ajaran"):'0';
			
			$data['pagination'] = $this->pagination->create_links();
			$data["startPage"]=$data['page'];
			$data["perpage"]=$perpage;
			$data["nama_user"]=$this->session->userdata("nama_user");
			$data["judulKonten"]=$this->session->nama_hak_akses." - Control Panel";
			$data["nisData"]=$this->NilaiSikap_model->getNisData();
			$data["mapelData"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"));
			$data["mapelData2"]=$this->NilaiTugas_model->getMapelData($this->session->userdata("kode_guru"),2);
			$fck=$this->Home_m->getMapelYgDiajar($this->session->userdata("kode_guru"));
			$data["mapelYangDiajar"]=array();
			foreach($fck as $fuck)$data["mapelYangDiajar"][]=$fuck->kd_mapel;
			$data["kelas"]=$this->Siswa_model->getKelasurut();
			$data["idAktif"]="datanilai2";
			$data["notif_log"]=$this->Log_model->getLog();
			$data["hakAkses"]=$this->session->userdata("hak_akses");
			$this->template->load("admin/index","admin/nilai_sikap",$data);
		}
	}
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->userdata["nilai_sikap"]["kd_kelas"]=$post["kd_kelas"];
				$this->session->userdata["nilai_sikap"]["nis_cok"]=$post["nis"];
				$this->session->userdata["nilai_sikap"]["kd_mapel"]=$post["kd_mapel"];
				$this->session->userdata["nilai_sikap"]["semester"]=$post["semester"];
				$this->session->userdata["nilai_sikap"]["tahun_ajaran"]=$post["tahun_ajaran"];
				redirect("admin/nilai_sikap/index");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_nilaisikap",abs((int)$post["perpage"]));
				redirect("admin/nilai_sikap/index");
			}
			
		}
	}
	function tambahNilaisikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai UAS"));
		else{
			$input=$this->NilaiSikap_model->inputData();
			echo json_encode($input);
		}
	}
	function editNilaiProyek(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa edit nilai UTS"));
		else{
			$edit=$this->NilaiSikap_model->editData();
			echo json_encode($edit);
			
		}
	}
	function hapusNilaisikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa hapus nilai Sikap"));
		else{
			$hapus=$this->NilaiSikap_model->hapusData();
			echo json_encode($hapus);
		}
	}
	function getNilaiSikap(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiSikap_model->getNilai();
		echo json_encode($data);
	}
	function getSiswaByKelas(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))die(json_encode(array("error"=>"Harus login dulu")));
		$data=$this->NilaiTugas_model->getSiswaByKelas($this->input->get("all"));
		echo $data;
		
	}
}

?>