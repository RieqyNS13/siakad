<?php 
class MapelGuru_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total(){
		return $this->db->get("guru_mengajar_6771")->num_rows();
	}
	function getMapelGuru($start,$limit){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from guru_mengajar_6771 a inner join guru_6771 b inner join mapel_6771 c on a.kode_guru=b.kode_guru and a.kd_mapel=c.kode_mapel order by a.id desc limit $start,$limit");
		return $query->result();
	}
	function editMapelGuru($data){
		$idedit=$this->db->escape_str($data["id_forEdit"]);
		$dat=$this->db->query("select * from guru_mengajar_6771 where id='".$idedit."'")->row();
		$tmp=$dat->kode_guru;
		$tmp2=$dat->kd_mapel;
		if($data["kd_mapel"]!==$tmp2 && !$this->belumAda($data["kode_guru"],$data["kd_mapel"]))return array("sukses"=>false,"msg"=>"Guru dengan kode '".$data["kode_guru"]."' sudah mengajar kode mapel '".$data["kd_mapel"]."'");
		if($data["kode_guru"]!==$tmp && !$this->belumAda($data["kode_guru"],$data["kd_mapel"]))return array("sukses"=>false,"msg"=>"Guru dengan kode '".$data["kode_guru"]."' sudah mengajar kode mapel '".$data["kd_mapel"]."'");
		$this->db->where("id",$data["id_forEdit"]);
		unset($data["id_forEdit"]);
		$update=$this->db->update("guru_mengajar_6771",$data);
		if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	function getKodeGuru(){
		$query=$this->db->query("select * from guru_6771")->result();
		$data='';
		foreach($query as $mbuh){
			$data.="<option value=\"".$mbuh->kode_guru."\">".stripslashes($mbuh->kode_guru)." | ".stripslashes($mbuh->nama)."</option>";
		}
		return $data;
	}
	function cariMapelGuru($q,$start,$limit){
		$q=$this->db->escape_str($q);
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from guru_mengajar_6771 a inner join guru_6771 b inner join mapel_6771 c on a.kode_guru=b.kode_guru and a.kd_mapel=c.kode_mapel
		where a.kode_guru like '%$q%' or b.nama like '%$q%' or a.kd_mapel like '%$q%' or c.nama_mapel like '%$q%' order by a.id desc limit $start,$limit");
		if($query)return $query;
		return false;
	}
	function jumlahcariMapelGuru($q){
		$q=$this->db->escape_str($q);
		$query=$this->db->query("select * from guru_mengajar_6771 a inner join guru_6771 b inner join mapel_6771 c on a.kode_guru=b.kode_guru and a.kd_mapel=c.kode_mapel
		where a.kode_guru like '%$q%' or b.nama like '%$q%' or a.kd_mapel like '%$q%' or c.nama_mapel like '%$q%'");
		return $query->num_rows();
	}
	function belumAda($kode_guru,$kode_mapel){
		$query=$this->db->query("select * from guru_mengajar_6771 where kode_guru='".$kode_guru."' and kd_mapel='".$kode_mapel."'");
		if($query->num_rows()>=1)return false;
		return true;
	}
	function getKodeMapel(){
		$query=$this->db->query("select * from mapel_6771")->result();
		$data='';
		foreach($query as $mbuh){
			$data.="<option value=\"".$mbuh->kode_mapel."\">".stripslashes($mbuh->kode_mapel)." | ".stripslashes($mbuh->nama_mapel)."</option>";
		}
		return $data;
	}
	function inputMapelGuru($data){
		foreach($data as $key=>$line)$data[$key]=$line;
		$kode_guru=$this->db->escape_str($data["kode_guru"]);
		$kd_mapel=$this->db->escape_str($data["kd_mapel"]);
		if(!$this->belumAda($kode_guru,$kd_mapel))return array("sukses"=>false,"msg"=>"Guru dengan kode '".$data["kode_guru"]."' sudah mengajar kode mapel '".$data["kd_mapel"]."'");
		$query=$this->db->insert("guru_mengajar_6771", $data);
		if($query)return array("sukses"=>true,"msg"=>"Sukses menambahkan mapel guru");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
	
}
?>