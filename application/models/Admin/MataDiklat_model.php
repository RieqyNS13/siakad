<?php
class MataDiklat_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total(){
		return $this->db->get("mata_diklat_6771")->num_rows();
	}
	function getMataDiklat($start,$limit){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from mata_diklat_6771 limit $start,$limit");
		return $query->result();
	}
	function cekDiklatBelumAda($kode){
		$query=$this->db->query("select * from mata_diklat_6771 where kode_mata_diklat='".$kode."'");
		if($query->num_rows()>=1)return array("status"=>false,"msg"=>"Kode mata diklat sudah ada");
		else return array("status"=>true,"msg"=>null);
	}
	function inputMataDiklat($post){
		$kode=$this->db->escape_str($post["kode_mata_diklat"]);
		$cek=$this->cekDiklatBelumAda($kode);
		if($cek["status"]==false){
			return array("sukses"=>false,"msg"=>$cek["msg"]);
		}
		$query=$this->db->insert("mata_diklat_6771", $post);
		if($query)return array("sukses"=>true,"msg"=>"Sukses menambahkan mata diklat");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function editMataDiklat($post){
		$kode=$this->db->escape_str($post["kode_mata_diklat"]);
		if($post["kode_forEdit"]!==$post["kode_mata_diklat"]){
			$cek=$this->cekDiklatBelumAda($kode);
			if($cek["status"]==false)return array("sukses"=>false,"msg"=>"Sudah ada mata diklat dengan kode '".$kode."'");

		}
		$this->db->where("kode_mata_diklat",$post["kode_forEdit"]);
		unset($post["kode_forEdit"]);
		$update=$this->db->update("mata_diklat_6771",$post);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());		
	}
	function cari($q,$start,$limit){
		$this->db->limit($limit,$start);
		$this->db->like("kode_mata_diklat",$q,"both",false);
		$this->db->or_like("nama_mata_diklat",$q,"both",false);
		$query=$this->db->get("mata_diklat_6771");
		return $query->result();
	}
	function jumlahCari($q){
		$this->db->like("kode_mata_diklat",$q,"both",false);
		$this->db->or_like("nama_mata_diklat",$q,"both",false);
		$query=$this->db->get("mata_diklat_6771");
		return $query->num_rows();
	}
}