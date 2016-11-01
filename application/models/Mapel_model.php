<?php
class Mapel_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function cekMapelbelumada($kode_mapel){
		$cek=$this->db->query("select * from mapel_6771 where kode_mapel='".$kode_mapel."'");
		if($cek->num_rows()>=1)return false;
		return true;	
	}
	function total(){
		return $this->db->get("mapel_6771")->num_rows();
	}
	function getMapel($start,$limit){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from mapel_6771 limit $start,$limit");
		return $query->result();
	}
	function editMapel($data){
		$kode_mapel=$this->db->escape_str($data["kode_mapel"]);
		if($data["kode_mapel_forEdit"]!==$data["kode_mapel"] && !$this->cekMapelbelumada($kode_mapel))return array("sukses"=>false,"msg"=>"Mapel dengan kode mapel '".$data["kode_mapel"]."' sudah ada");
		$this->db->where("kode_mapel",$data["kode_mapel_forEdit"]);
		unset($data["kode_mapel_forEdit"]);
		$update=$this->db->update("mapel_6771",$data);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function inputMapel($data){
		$kode_mapel=$this->db->escape_str($data["kode_mapel"]);
		if(!$this->cekMapelbelumada($kode_mapel)){
			return array("sukses"=>false,"msg"=>"Sudah ada mapel dengan kode_mapel tersebut");
		}
		$query=$this->db->insert("mapel_6771", $data);
		if($query)return array("sukses"=>true,"msg"=>"Sukses menambahkan mapel");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function cariMapel($q,$start,$limit){
		$q=$this->db->escape_str($q);
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from mapel_6771 where kode_mapel like '%".$q."%' or nama_mapel like '%".$q."%' limit $start,$limit");
		if($query)return $query;
		return false;
	}
	function jumlahcariMapel($q){
		$q=$this->db->escape_str($q);
		$query=$this->db->query("select * from mapel_6771 where kode_mapel like '%".$q."%' or nama_mapel like '%".$q."%'");
		return $query->num_rows();
	}
}