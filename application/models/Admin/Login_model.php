<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function cekloginSiswa($user,$pass){
		$user=$this->db->escape_str($user);
		$pass=$this->db->escape_str($pass);
		$pass=md5($pass);
		$query=$this->db->query("select * from `user_6771` where `username`='$user' and `password`='$pass' and kd_role='siswa'") or die(mysql_error());
		if($query->num_rows()>=1){
			return $query->row();
		}return false;
	}
	function cekloginGuru($user,$pass){
		$user=$this->db->escape_str($user);
		$pass=$this->db->escape_str($pass);
		$pass=md5($pass);
		$query=$this->db->query("select a.*,b.kode_guru,b.nip,c.* from user_6771 a inner join guru_6771 b on a.username=b.kode_guru or a.username=b.nip inner join user_role_6771 c on a.kd_role=c.kode_role where a.username='$user' and a.password='$pass' and a.kd_role='guru'") or die(mysql_error());
		if($query->num_rows()>=1){
			return $query->row();
		}
		return false;
	}
	function cekLoginAdmin($user,$pass,$type){
		$pass=md5($pass);
		$this->db->select("*");
		$this->db->from("user_6771");
		$this->db->join("user_role_6771","user_role_6771.kode_role=user_6771.kd_role");
		$this->db->where(array("username"=>$user,"password"=>$pass,"kd_role"=>$type));
		$get=$this->db->get();
		if($get->num_rows()>=1){
			return $get->row();
		}
		return false;
	}
}
?>