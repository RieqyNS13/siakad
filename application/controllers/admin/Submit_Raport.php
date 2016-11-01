<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Submit_Raport extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->library("SessNilai");
		$this->load->model(array("admin/NilaiRaport_model","admin/SubmitRaport_model","admin/NilaiPraktek_model","admin/Log_model","admin/Siswa_model"));
	}
	function index(){
		$this->sessnilai->resetSessNilai("submitRaport");
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if(empty($data["walikelas"]) && $this->session->userdata("hak_akses")!="admin")die(json_encode(array("error"=>"Hanya guru dan admin yang bisa submit raport")));
			if($this->session->userdata("hak_akses")=="admin")$data["semuakelas"]=$this->Siswa_model->getKelasurut();
			
			if($this->session->perpage_submitraport)$perpage=$this->session->perpage_submitraport;
			else $perpage=5;
			$config['base_url'] = site_url('admin/submit_raport/index');
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
			
			
			$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$arr["siswa_6771.nis"]=$this->sessnilai->get_userdata("nilai_submitRaport","nis_cok");
			$arr["siswa_6771.kd_kelas"]=$this->sessnilai->get_userdata("nilai_submitRaport","kd_kelas");
			$arr["nilai_tugas_6771.semester"]=$this->sessnilai->get_userdata("nilai_submitRaport","semester");
			$arr["nilai_tugas_6771.tahun_ajaran"]=$this->sessnilai->get_userdata("nilai_submitRaport","tahun_ajaran");
			$arr["submitraport_6771.submit"]=$this->sessnilai->get_userdata("nilai_submitRaport","sudahdisubmit");
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
			
			$data["nis_value"]=$this->sessnilai->get_userdata("nilai_submitRaport","nis_cok")!=null?$this->sessnilai->get_userdata("nilai_submitRaport","nis_cok"):'0';
			$data["kd_kelas_value"]=$this->sessnilai->get_userdata("nilai_submitRaport","kd_kelas")!=null?$this->sessnilai->get_userdata("nilai_submitRaport","kd_kelas"):'0';
			$data["semester_value"]=$this->sessnilai->get_userdata("nilai_submitRaport","semester")!=null?$this->sessnilai->get_userdata("nilai_submitRaport","semester"):'0';
			$data["tahun_ajaran_value"]=$this->sessnilai->get_userdata("nilai_submitRaport","tahun_ajaran")!=null?$this->sessnilai->get_userdata("nilai_submitRaport","tahun_ajaran"):'0';
			$data["sudahdisubmit_value"]=$this->sessnilai->get_userdata("nilai_submitRaport","sudahdisubmit")!=null?$this->sessnilai->get_userdata("nilai_submitRaport","sudahdisubmit"):'0';
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
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kd_kelas"]) && isset($post["nis"]) && isset($post["submit"]) && isset($post["semester"]) && isset($post["tahun_ajaran"])){
				if($this->session->userdata("hak_akses")=="admin")$this->session->userdata["nilai_submitRaport"]["kd_kelas"]=$post["kd_kelas"];
				$this->session->userdata["nilai_submitRaport"]["nis_cok"]=$post["nis"];
				$this->session->userdata["nilai_submitRaport"]["semester"]=$post["semester"];
				$this->session->userdata["nilai_submitRaport"]["tahun_ajaran"]=$post["tahun_ajaran"];
				$this->session->userdata["nilai_submitRaport"]["tahun_ajaran"]=$post["submit"];
				redirect("admin/submit_raport/index");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_submitraport",abs((int)$post["perpage"]));
				redirect("admin/submit_raport/index");
			}
			
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
	function SubmitRaport(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","guru")))echo json_encode(array("error"=>"Hanya Guru saja yang bisa input nilai UAS"));
		else{
			$input=$this->SubmitRaport_model->inputData();
			echo json_encode($input);
		}
	}
	
}