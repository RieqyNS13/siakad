<?php 
class Guru_model extends CI_Model{
	function __construct(){
		$this->load->library("Proses_data");
		parent::__construct();
	}
	function getSemuaGuru(){
		$query=$this->db->query("select * from guru_6771");
		return $query->result();
	}
	function cekGurubelumAda($kode_guru){
		$cek=$this->db->query("select * from guru_6771 where kode_guru='".$kode_guru."'");
		if($cek->num_rows()>=1)return false;
		return true;
	}
	function total(){
		return $this->db->get("guru_6771")->num_rows();
	}
	function getGuru($start,$limit){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		//$i=($start)*$limit;
		$query=$this->db->query("select * from guru_6771 limit $start,$limit");
		return $query->result();
	}
	function cariGuru($q,$start,$limit){
		$q=$this->db->escape_str($q);
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from guru_6771 where kode_guru like '%$q%' or nip like '%$q%' or nama like '%$q%' or telepon like '%$q%' or tempat_lahir
		like '%$q%' or tgl_lahir like '%$q%' or alamat like '%$q%' limit $start,$limit");
		if($query)return $query;
		return false;
	}
	function jumlahcariGuru($q){
		$q=$this->db->escape_str($q);
		$query=$this->db->query("select * from guru_6771 where kode_guru like '%$q%' or nip like '%$q%' or nama like '%$q%' or telepon like '%$q%' or tempat_lahir
		like '%$q%' or tgl_lahir like '%$q%' or alamat like '%$q%'");
		return $query->num_rows();
	}

	function editGuru($data){
		$kode_guru=$this->db->escape_str($data["kode_guru"]);
		if($data["kode_guru"]!==$data["kode_guruforEdit"] && !$this->cekGurubelumAda($kode_guru))return array("sukses"=>false,"msg"=>"Guru dengan kode guru '".$data["kode_guru"]."' sudah ada");
		$this->db->where("kode_guru",$data["kode_guruforEdit"]);
		unset($data["kode_guruforEdit"]);
		$update=$this->db->update("guru_6771",$data);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function inputGuru($data){
		$kode_guru=$this->db->escape_str($data["kode_guru"]);
		if(!$this->cekGurubelumAda($kode_guru)){
			return array("sukses"=>false,"msg"=>"Kode guru '".$data["kode_guru"]."' sudah ada");
		}
		$query=$this->db->insert("guru_6771", $data);
		if($query)return array("sukses"=>true,"msg"=>"Sukses tambah data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
		
	}
	function lihatDetailGuru($kode_guru){
		return $this->db->query("select * from guru_6771 where kode_guru='".$this->db->escape_str($kode_guru)."'");
	}
	
	function inputGuru_csv($data){
		$cek=$this->proses_data->checkDataSudahDisi($data,array("nip"));
		$data=$this->proses_data->trimData($data);
		if($this->db->get_where("guru_6771",array("kode_guru"=>$data["kode_guru"]))->num_rows()>0)return array("sukses"=>false);
		if(!$cek)return array("sukses"=>false,"msg"=>"Data error");
		$query=$this->db->insert("guru_6771",$data);
		if($query)return array("sukses"=>true);
		else return array("sukses"=>false);
	}
}
?>