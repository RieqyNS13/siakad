<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array("pagination"));
		$this->load->model("Admin/User_m");
	}
	function tampilUser($user=null){
		if($this->session->hak_akses!=="admin")return show_error("Hanya admin yang bisa mengakses halaman ini", 403, $heading = 'An Error Was Encountered');
		
		$config["uri_segment"] = 5;
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
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$q_search=$this->input->get("q");
		switch($user){
			case "tatausaha":
				$cok="tatausaha";
				break;
			case "kurikulum":
				$cok="kurikulum";
				break;
			case "admin":
				$cok="admin";
				break;
			case "guru":
				$cok="guru";
				break;
			default:
				return show_404();
				break;
		}
		if(!empty($this->session->userdata["perpageuser"][$cok]))$perpage=$this->session->userdata["perpageuser"][$cok];
		else $perpage=5;
		if($q_search!==null){
			$total_rows=$this->User_m->jumlahcari($q_search,$cok);
			$data["dataUser"]=$this->User_m->cari($q_search,$cok,$page,$perpage);
			$data["caristatus"]="<div class=\"col-sm-12 spasiAtas\"><div class=\"alert alert-info\" role=\"alert\">Ditemukan '".$total_rows."' data dengan keyword '".$q_search."'</div></div>";
		}else{
			$total_rows=$this->User_m->totalUser($cok); 
			$data["dataUser"]=$this->User_m->getUser($cok,$page,$perpage);
			$data["caristatus"]=null;
		}
		$config['total_rows']=$total_rows;
		$config['per_page'] = $perpage;
		$config['base_url'] = site_url("admin/user/show/{$cok}");
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data["judulKonten"]=$judul=$this->session->userdata("nama_hak_akses")." - Control Panel";
		$data["nama_user"]=$this->session->userdata("nama_user");
		$data["perpage"]=$perpage;
		$data["hak_akses"]=$this->session->hak_akses;
		$data["startPage"]=$page;
		$data["idAktif"]="user";
		$this->template->load("admin/index","admin/user/{$cok}",$data);
	}
	function gantiPaging(){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses"))redirect("admin/login");
		else{
			$post=$this->input->post();
			if(isset($post["perpage"]) && !empty($this->uri->segment(4))){
				$user=strtolower($this->uri->segment(4));
				$this->session->userdata["perpageuser"][$user]=abs((int)$post["perpage"]);
				redirect("admin/user/show/{$user}");
			}
			
		}
	}
	function tambahUser($user=null){
		if($user==null)return show_404();
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin")))echo json_encode(array("error"=>"Hanya Admin yang punya akses"));
		else{
			$post=$this->input->post();
			$insert=$this->User_m->tambahUser($post,$user);
			if($insert["sukses"])echo json_encode(array("sukses"=>$insert["msg"]));
			else echo json_encode(array("error"=>isset($insert["msg"]["message"])?$insert["msg"]["message"]:$insert["msg"]));
		}

	}
	function getUser($kd_role=null){
		if($kd_role==null)return show_404();
		$kd_role=strtolower($kd_role);
		$roles=array("tatausaha","admin","kurikulum","guru");
		if(!in_array($kd_role,$roles))return show_404();
		if(!empty($this->input->post("id_user"))){
			$cok=$this->User_m->getUser2($this->input->post("id_user"),$kd_role);
			if($cok)echo json_encode($cok);
			else return show_404();
			
		}else return show_404();
	}
	function editProfil($kd_role=null){
		if($kd_role==null)return show_404();
		$kd_role=strtolower($kd_role);
		$roles=array("tatausaha","admin","kurikulum","guru");
		if(!in_array($kd_role,$roles))return show_404();
		$post=$this->input->post();
		if(count($post)==0)return show_404();
		$edit=$this->User_m->editProfil($post,$kd_role);
		if($edit["sukses"])echo json_encode(array("sukses"=>$edit["msg"]));
		else echo json_encode(array("error"=>$edit["msg"]));
	}
	function editAkun($params){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin")))echo json_encode(array("error"=>"Hanya Admin yang punya akses"));	
		$exp=explode("_",$params);
		if(count($exp)!=2)return show_404();
		$kd_role=strtolower($exp[0]);
		$roles=array("tatausaha","admin","kurikulum","guru");
		$type=abs((int)$exp[1]);
		if(($type!=1 && $type!=2) || $kd_role==null || !in_array($kd_role,$roles))return show_404(); 
		$post=$this->input->post();
		if(count($post)==0)return show_404();
		$edit=$this->User_m->editAkun($post,$kd_role,$type);
		if($edit["sukses"])echo json_encode(array("sukses"=>$edit["msg"]));
		else echo json_encode(array("error"=>$edit["msg"]));
	}
	function hapusAkun($kd_role=null,$type=null){
		if(!$this->session->has_userdata("user") || !$this->session->has_userdata("hak_akses") || !in_array($this->session->userdata("hak_akses"),array("admin")))echo json_encode(array("error"=>"Hanya Admin saja yang punya akses"));
		if($kd_role==null || $type=null)return show_404();
		$kd_role=strtolower($kd_role);
		$roles=array("tatausaha","admin","kurikulum","guru");
		if(!in_array($kd_role,$roles))return show_404();
		$id_user=$this->input->post("id_user");
		if(empty($id_user))return show_404();
		$hapus=$this->User_m->hapusAkun($id_user,$kd_role);
		if($hapus["sukses"])echo json_encode(array("sukses"=>$hapus["msg"]));
		else echo json_encode(array("error"=>$hapus["msg"]));
	}
	
}