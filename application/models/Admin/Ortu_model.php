<?php
class Ortu_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total(){
		return $this->db->get("ortu_siswa_6771")->num_rows();
	}
	function getOrtuSiswa($start,$limit){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from ortu_siswa_6771 a inner join siswa_6771 b on a.nis=b.nis limit $start,$limit");
		return $query->result();
	}
	function cekNisBelumAda($nis){
		$query=$this->db->query("select * from ortu_siswa_6771 where nis='$nis'");
		if($query->num_rows()>=1)return false;
		return true;
	}
	function cariOrtuSiswa($q,$start,$limit){
		$q=$this->db->escape_str($q);
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from ortu_siswa_6771 a inner join siswa_6771 b on a.nis=b.nis where a.nis like '%$q%' or b.nama like '%$q%' or a.nama_ayah like '%$q%' or a.nama_ibu like '%$q%' or a.pekerjaan_ayah
		like '%$q%' or a.pekerjaan_ibu like '%$q%' or a.alamat_ortu like '$q' limit $start,$limit");
		if($query)return $query;
		return false;
	}
	function jumlahcariOrtuSiswa($q){
		$q=$this->db->escape_str($q);
		$query=$this->db->query("select * from ortu_siswa_6771 a inner join siswa_6771 b on a.nis=b.nis where a.nis like '%$q%' or b.nama like '%$q%' or a.nama_ayah like '%$q%' or a.nama_ibu like '%$q%' or a.pekerjaan_ayah
		like '%$q%' or a.pekerjaan_ibu like '%$q%' or a.alamat_ortu like '$q'");
		return $query->num_rows();
	}
	function editOrtuSiswa($data){
		$nis=$this->db->escape_str($data["nis"]);
		if($data["nis"]!==$data["nis_forEdit"] && !$this->cekNisBelumAda($nis))return array("sukses"=>false,"msg"=>"Siswa dengan nis '".$data["nis"]."' sudah punya ortu");
		$this->db->where("nis",$data["nis_forEdit"]);
		unset($data["nis_forEdit"]);
		$update=$this->db->update("ortu_siswa_6771",$data);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());	
	}
	function inputOrtuSiswa($data){
		$nis=$this->db->escape_str($data["nis"]);
		if(!$this->cekNisBelumAda($nis)){
			return array("sukses"=>false,"msg"=>"Siswa dengan nis '".$nis."' sudah mempunyai ortu");
		}
		$query=$this->db->insert("ortu_siswa_6771", $data);
		if($query)return array("sukses"=>true,"msg"=>"Sukses tambah data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function getNisData(){
		$get=$this->db->query("select * from siswa_6771")->result();
		$asu="";
		foreach($get as $key=>$data){
			$asu.="<option value=\"".$data->nis."\">".$data->nis." | ".$data->nama."</option>";
		}
		return $asu;
	}
}