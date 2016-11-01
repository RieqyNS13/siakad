<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User_m extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getUser($user,$start,$limit){
		$this->db->select("id_user,username,nama,email,no_telp");
		$this->db->limit($limit,$start);
		return $this->db->get_where("user_6771","kd_role=".$this->db->escape($user)."")->result();
	}
	function totalUser($user){
		$cok=$this->db->get_where("user_6771","kd_role=".$this->db->escape($user));
		return $cok->num_rows();
	}
	function tambahUser($post,$user){
		$post=$this->dataTrim($post);
		if(empty($post["username"]) || empty($post["password"]) || empty($post["password2"]) || empty($post["nama"]))return array("sukses"=>false,"msg"=>"Username, password, dan nama harus diisi");
		if($post["password"]!==$post["password2"])return array("sukses"=>false,"msg"=>"Password tidak sama");
		unset($post["password2"]);
		$post["password"]=md5(trim($post["password"]));
		$post["kd_role"]=trim($user);
		$cek=$this->db->get_where("user_6771",array("username"=>($post["username"]),"kd_role"=>($post["kd_role"])));
		//print_r($post);die;
		if($cek->num_rows()>0)return array("sukses"=>false,"msg"=>"User '".$post["username"]."' sudah ada");
		$query=$this->db->insert("user_6771",$post);
		if($query)return array("sukses"=>true,"msg"=>"Sukses tambah data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function getUser2($id_user,$kd_role){
		$this->db->select("id_user,username,nama,email,no_telp");
		$query=$this->db->get_where("user_6771",array("id_user"=>$id_user,"kd_role"=>$kd_role));
		if($query)return $query->row();
		else return false;
	}
	function editProfil($post,$kd_role){
		$post=$this->dataTrim($post);
		$this->db->where(array("id_user"=>$post["id_user_forEdit"],"kd_role"=>$kd_role));unset($post["id_user_forEdit"]);
		$query=$this->db->update("user_6771",$post);
		if($query)return array("sukses"=>true,"msg"=>"Sukses update profil");
		else return array("sukses"=>false,"msg"=>call_user_func(function(){
			$dberror=$this->db->error();
			return empty($dberror["code"])?"Gagal update profil":$dberror["message"];
		}));
	}
	function dataTrim($post){
		foreach($post as $key=>$val)$post2[$key]=trim($val);
		return $post2;
	}
	function editAkun($post,$kd_role,$type){
		$post=$this->dataTrim($post);
		if($type==1 && empty($post["username"]))return array("sukses"=>false,"msg"=>"Username harus diisi");
		else if($type==2 && (empty($post["password"]) || empty($post["password2"])))return array("sukses"=>false,"msg"=>"Password dan ulangi password harus diisi");
		if($type==2){
			if($post["password"]===$post["password2"]){
				unset($post["password2"]);
				$post["password"]=md5($post["password"]);
			}else return array("sukses"=>false,"msg"=>"Password tidak sama");
		}else{
			if(!$this->cekUser($post["username"],$kd_role))return array("sukses"=>false,"msg"=>"Username sudah ada");
		}
		$this->db->where(array("id_user"=>$post["id_user_forEdit"],"kd_role"=>$kd_role));unset($post["id_user_forEdit"]);
		$query=$this->db->update("user_6771",$post);
		if($query)return array("sukses"=>true,"msg"=>"Sukses update akun");
		else return array("sukses"=>false,"msg"=>call_user_func(function(){
			$dberror=$this->db->error();
			return empty($dberror["code"])?"Gagal update akun":$dberror["message"];
		}));
	}
	function cekUser($username,$kd_role){
		$this->db->select("*");
		$this->db->from("user_6771");
		$this->db->where(array("username"=>$username,"kd_role"=>$kd_role));
		$query=$this->db->get();
		if($query->num_rows()>0)return false;
		return true;
	}
	function hapusAkun($id_user,$kd_role){
		$id_user=trim($id_user);
		$this->db->where(array("id_user"=>$id_user,"kd_role"=>$kd_role));
		$query=$this->db->delete("user_6771");
		if($query)return array("sukses"=>true,"msg"=>"Sukses hapus akun");
		else return array("sukses"=>false,"msg"=>call_user_func(function(){
			$dberror=$this->db->error();
			return empty($dberror["code"])?"Gagal hapus akun":$dberror["message"];
		}));
	}
	function cari($q,$kd_role,$start,$limit){
		$q=$this->db->escape_str($q);
		$this->db->select("id_user,username,nama,email,no_telp");
		$this->db->where("kd_role",$kd_role);
		$this->db->group_start();
		$this->db->like("username",$q,"both",false); 
		$this->db->or_like("nama",$q,"both",false);
		$this->db->or_like("email",$q,"both",false);
		$this->db->or_like("no_telp",$q,"both",false);
		$this->db->group_end();
		$this->db->from("user_6771");
		$this->db->limit($limit,$start);
		//echo $this->db->get_compiled_select();die;
		$get=$this->db->get();
		return $get->result();
	} 
	function test(){
		$this->db->select("*")->like("username","!","both",false)->from("user_6771");
		echo $this->db->get_compiled_select();
	}
	function jumlahcari($q,$kd_role){
		$q=$this->db->escape_str($q);
		$this->db->select("id_user,username,nama,email,no_telp");
		$this->db->where("kd_role",$kd_role);
		$this->db->group_start();
		$this->db->like("username",$q,"both",false); 
		$this->db->or_like("nama",$q,"both",false);
		$this->db->or_like("email",$q,"both",false);
		$this->db->or_like("no_telp",$q,"both",false);
		$this->db->group_end();
		$this->db->from("user_6771");
		$get=$this->db->get();
		return $get->num_rows();
	}
}
?>