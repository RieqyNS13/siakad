<?php
class Jurusan_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total(){
		return $this->db->get("jurusan_6771")->num_rows();
	}
	function getJurusan($start,$limit){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from jurusan_6771 limit $start,$limit");
		return $query->result();
	}
	function getKodediklat(){
		$result=$this->db->get("mata_diklat_6771")->result();
		$asu='';
		foreach($result as $mbuh){
			$asu.="<option value=\"".$mbuh->kode_mata_diklat."\">".$mbuh->kode_mata_diklat." | ".$mbuh->nama_mata_diklat."</option>";
		}
		return $asu;
	}
	function cariJurusan($q,$start,$limit){
		$q=$this->db->escape_str($q);
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from jurusan_6771 a inner join mata_diklat_6771 b on a.kode_diklat=b.kode_mata_diklat where a.nama_jurusan like '$q' or a.nama_full like '$q' or b.kode_mata_diklat like '$q' limit $start,$limit");
		if($query)return $query;
		return false;
	}
	function jumlahcariJurusan($q){
		$q=$this->db->escape_str($q);
		$query=$this->db->query("select * from jurusan_6771 a inner join mata_diklat_6771 b on a.kode_diklat=b.kode_mata_diklat where a.nama_jurusan like '$q' or a.nama_full like '$q' or b.kode_mata_diklat like '$q'");
		return $query->num_rows();
	}
	function cekJurusanBelumAda($data){
		$query=$this->db->query("select * from jurusan_6771 where nama_jurusan='".$data["nama_jurusan"]."'");
		if($query->num_rows()>=1)return array("status"=>false,"msg"=>"Kode jurusan sudah ada");
		else return array("status"=>true,"msg"=>null);
	}
	function editJurusan($post){
		$data["nama_jurusan"]=$this->db->escape_str($post["nama_jurusan"]);
		$cek=$this->cekJurusanBelumAda($data);
		if($cek["status"]==false)return array("sukses"=>false,"msg"=>"Sudah ada jurusan dengan kode '".$data["nama_jurusan"]."'");
		$this->db->where("id_jurusan",$post["id_jurusan_forEdit"]);
		unset($post["id_jurusan_forEdit"]);
		$update=$this->db->update("jurusan_6771",$post);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());		
	}
	function inputKelas($post){
		$data["nama_jurusan"]=$this->db->escape_str($post["nama_jurusan"]);
		$data["nama_full"]=$this->db->escape_str($post["nama_full"]);
		$data["kode_diklat"]=$this->db->escape_str($post["kode_diklat"]);
		$cek=$this->cekJurusanBelumAda($data);
		if($cek["status"]==false){
			return array("sukses"=>false,"msg"=>$cek["msg"]);
		}
		$query=$this->db->insert("jurusan_6771", $post);
		if($query)return array("sukses"=>true,"msg"=>"Sukses menambahkan jurusan");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
}
?>