<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bagi_mapel extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->model(array("admin/BagiMapel_model","admin/Kelas_model","admin/MapelGuru_model","admin/SubmitRaport_model","admin/Log_model"));
	}
	function index(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$data=array();
			$data["walikelas"]=$this->SubmitRaport_model->isWalikelas();
			if($this->session->perpage_bagimapel)$perpage=$this->session->perpage_bagimapel;
			else $perpage=5;

			$arr["kelas_prefix"]=$this->input->cookie("kelas_prefix");
			$arr["kd_jurusan"]=$this->input->cookie("kd_jurusan");
			$arr["semester"]=$this->input->cookie("semester");
			$arr["tahun_ajaran"]=$this->input->cookie("tahun_ajaran");
			$arr["kode_kelompok_mapel"]=$this->input->cookie("kode_kelompok_mapel");
			
			//foreach($arr as $asu)i
						
			$config['base_url'] = site_url('admin/bagi_mapel/index');
		
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

			$getrequest=$this->input->get();
			if(isset($getrequest["q"]) && strlen($getrequest["q"])>0){
				$getdata=$this->BagiMapel_model->cariData($getrequest["q"],$data['page'],$perpage);
				$config['total_rows']=$this->BagiMapel_model->jumlahcariData($getrequest["q"]);
				$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$config['total_rows']."' data dengan keyword '".htmlentities($getrequest["q"])."'</div></div>";
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
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["kelas_prefix"]) && isset($post["kd_jurusan"]) && isset($post["semester"]) && isset($post["kode_kelompok_mapel"])){
				set_cookie("kelas_prefix",$post["kelas_prefix"],3600);
				set_cookie("kd_jurusan",$post["kd_jurusan"],3600);
				set_cookie("semester",$post["semester"],3600);
				set_cookie("tahun_ajaran",$post["tahun_ajaran"],3600);
				set_cookie("kode_kelompok_mapel",$post["kode_kelompok_mapel"],3600);
				redirect("admin/bagi_mapel/index");
			}
			if(isset($post["perpage"])){
				$this->session->set_userdata("perpage_bagimapel",abs((int)$post["perpage"]));
				redirect("admin/bagi_mapel/index");
			}
			
		}
	}
	function detailBagiMapel($htmlentities=false){
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
	function tambahBagiMapel(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin","kurikulum")))echo json_encode(array("error"=>"Hanya Admin dan Kurikulum saja yang bisa input pembagian mapel"));
		else{
			$post=$this->input->post();
			if(empty(trim($post["kelas_prefix"])) || empty($post["kd_jurusan"]) || empty($post["semester"]) || empty($post["kode_mapel"]) || empty($post["kode_kelompok_mapel"]))die(json_encode(array("error"=>"Prefix kelas, Jurusan, Kode mapel, dll tidak boleh kosong")));
			$input=$this->BagiMapel_model->inputData($post);
			if($input["sukses"]===true)echo json_encode(array("sukses"=>$input["msg"]));
			else echo json_encode(array("error"=>isset($input["msg"]["message"])?$input["msg"]["message"]:$input["msg"]));
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
	
}