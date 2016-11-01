<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Raport extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->library("SessNilai");
		$this->load->model(array("admin/NilaiRaport_model","admin/SubmitRaport_model","admin/NilaiPraktek_model","admin/Log_model","admin/Siswa_model"));
	}
	function index(){
		$this->sessnilai->resetSessNilai("raport");
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			if($this->session->perpage_raport)$perpage=$this->session->perpage_raport;
			else $perpage=5;
			$config['base_url'] = site_url('admin/raport/index');
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
			$arr["siswa_6771.kd_kelas"]=$this->sessnilai->get_userdata("nilai_raport","kd_kelas");
			$arr["siswa_6771.nis"]=$this->sessnilai->get_userdata("nilai_raport","nis_cok");
			$arr["nilai_tugas_6771.kd_mapel"]=$this->sessnilai->get_userdata("nilai_raport","kd_mapel");
			$arr["nilai_tugas_6771.semester"]=$this->sessnilai->get_userdata("nilai_raport","semester");
			$arr["nilai_tugas_6771.tahun_ajaran"]=$this->sessnilai->get_userdata("nilai_raport","tahun_ajaran");
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
			
			$data["nis_value"]=$this->sessnilai->get_userdata("nilai_raport","nis_cok")!=null?$this->sessnilai->get_userdata("nilai_raport","nis_cok"):'0';
			$data["kd_kelas_value"]=$this->sessnilai->get_userdata("nilai_raport","kd_kelas")!=null?$this->sessnilai->get_userdata("nilai_raport","kd_kelas"):'0';
			$data["kd_mapel_value"]=$this->sessnilai->get_userdata("nilai_raport","kd_mapel")!=null?$this->sessnilai->get_userdata("nilai_raport","kd_mapel"):'0';
			$data["semester_value"]=$this->sessnilai->get_userdata("nilai_raport","semester")!=null?$this->sessnilai->get_userdata("nilai_raport","semester"):'0';
			$data["tahun_ajaran_value"]=$this->sessnilai->get_userdata("nilai_raport","tahun_ajaran")!=null?$this->sessnilai->get_userdata("nilai_raport","tahun_ajaran"):'0';

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
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["kd_mapel"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				$this->session->userdata["nilai_raport"]["kd_kelas"]=$post["kd_kelas"];
				$this->session->userdata["nilai_raport"]["nis_cok"]=$post["nis"];
				$this->session->userdata["nilai_raport"]["kd_mapel"]=$post["kd_mapel"];
				$this->session->userdata["nilai_raport"]["semester"]=$post["semester"];
				$this->session->userdata["nilai_raport"]["tahun_ajaran"]=$post["tahun_ajaran"];
				redirect("admin/raport/index");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_raport",abs((int)$post["perpage"]));
				redirect("admin/raport/index");
			}
			
		}
	}
	
}