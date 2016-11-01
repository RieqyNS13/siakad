<?php 
class User_m extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function inputSiswa($post){
		$cek=$this->db->get_where("user_6771",array("username"=>$post["nis"]));
		if($cek->num_rows()>=1)return array("sukses"=>false,"msg"=>"Sudah ada akun dengan nis tersebut");
		$cek=$this->db->get_where("siswa_6771", array("nis"=>$post["nis"]));
		if($cek->num_rows()>=1){
			$data=array("username"=>$post["nis"],"password"=>md5($post["password"]),"nama"=>$post["nama"],"email"=>$post["email"],"no_telp"=>$post["no_telp"],"kd_role"=>"siswa");
			$input=$this->db->insert("user_6771",$data);
			if($input)return array("sukses"=>true,"msg"=>null);
			else{
				$dberror=$this->db->error();
				if(isset($dberror["code"]))return array("sukses"=>false,"msg"=>$dberror["message"]);
				else return array("sukses"=>false,"msg"=>"Error tidak diketahui");
			}
		}else return array("sukses"=>false,"msg"=>"Tidak ada siswa dengan NIS '".$post["nis"]."'");
	}
	function inputGuru($post){
		$cek=$this->db->get_where("user_6771",array("username"=>$post["nip"]));
		if($cek->num_rows()>=1)return array("sukses"=>false,"msg"=>"Sudah ada akun dengan kode_guru/nip tersebut");
		
		$this->db->where("nip",$post["nip"]);
		$this->db->or_where("kode_guru",$post["nip"]);
		$cek=$this->db->get("guru_6771");
		if($cek->num_rows()>=1){
			$data=array("username"=>$post["nip"],"password"=>md5($post["password"]),"nama"=>$post["nama"],"email"=>$post["email"],"no_telp"=>$post["no_telp"],"kd_role"=>"guru");
			$input=$this->db->insert("user_6771",$data);
			if($input)return array("sukses"=>true,"msg"=>null);
			else{
				$dberror=$this->db->error();
				if(isset($dberror["code"]))return array("sukses"=>false,"msg"=>$dberror["message"]);
				else return array("sukses"=>false,"msg"=>"Error tidak diketahui");
			}
		}else return array("sukses"=>false,"msg"=>"Tidak ada guru dengan kode_guru/nip '".$post["nip"]."'");
	}
}
?>