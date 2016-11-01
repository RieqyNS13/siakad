<?php 
class BagiMapel_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function total($arr=null){
		if($arr!=null){
			foreach($arr as $key=>$mbuh){
				if(!is_null($mbuh) && $mbuh!=="0")$this->db->where($key,$mbuh);
			}
		}
		return $this->db->get("pembagian_mapel_6771")->num_rows();
	}
	function getData($start,$limit,$arr=null){
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$mbut=array();
		$mbut2=array();
		if($arr!=null){
			foreach($arr as $key=>$arr2){
				if(!is_null($arr2) && $arr2!=="0"){
					$mbut[]=$this->db->escape($arr2);
					$mbut2[]="a.".$key;
				}
			}
			$where='';
			if(count($mbut)>0){
				$end=end($mbut2);
				$a=0;
				$where.="where ";
				foreach($mbut2 as $key=>$mbuh){
					$where.=$mbuh."=".$mbut[$a];
					$a++;
					if($mbuh!==$end)$where.=" and ";
				}				
				//echo $end;die;
			}
		}else $where=null;
		$query=$this->db->query("select * from pembagian_mapel_6771 a inner join jurusan_6771 b inner join mapel_6771 c inner join kelompok_mapel_6771 d 
		on a.kd_jurusan=b.id_jurusan and a.kode_mapel=c.kode_mapel and a.kode_kelompok_mapel=d.kode_kelompok ".$where." limit $start,$limit");
		return $query->result();
	}
	function getKelompokMapel(){
		$get=$this->db->get("kelompok_mapel_6771")->result();
		$asu='';
		foreach($get as $data){
			$asu.="<option value=\"".$data->kode_kelompok."\">".$data->kode_kelompok." | ".$data->nama_kelompok_mapel."</option>";
		}
		return $asu;
	}
	function cekBelumAda($param){
		$data=$this;
		foreach($param as $key=>$mbuh)$data->$key=$this->db->escape_str($mbuh);
		$query=$this->db->query("select * from pembagian_mapel_6771 where semester=".$data->semester." and kelas_prefix='".$data->kelas_prefix."' and kd_jurusan=".$data->kd_jurusan." 
		and kode_mapel='".$data->kode_mapel."' and kode_kelompok_mapel='".$data->kode_kelompok_mapel."' and tahun_ajaran='".$data->tahun_ajaran."'");
		if($query->num_rows()>=1){
			return array("status"=>false,"msg"=>"Data sudah ada");
		}else return array("status"=>true,"msg"=>null);
	}
	function editData($post){
		$cek=$this->cekBelumAda($post);
		if($cek["status"]==false)return array("sukses"=>false,"msg"=>$cek["msg"]);
		else{
			$this->db->where("id",$post["id_forEdit"]);
			unset($post["id_forEdit"]);
			$update=$this->db->update("pembagian_mapel_6771",$post);
			if($update)return array("sukses"=>true,"msg"=>"Sukses edit data");
			else return array("sukses"=>false,"msg"=>$this->db->error());
		}	
	}
	function cariData($q,$start,$limit){
		$q=$this->db->escape_str($q);
		$start=abs((int)$start);
		$limit=abs((int)$limit);
		$query=$this->db->query("select * from pembagian_mapel_6771 a inner join jurusan_6771 b inner join mapel_6771 c inner join kelompok_mapel_6771 d on 
		a.kd_jurusan=b.id_jurusan and a.kode_mapel=c.kode_mapel and a.kode_kelompok_mapel=d.kode_kelompok where a.semester like '%".$q."%' or a.kelas_prefix like '%".$q."%'
		or b.nama_jurusan like '%".$q."%' or b.nama_full like '%".$q."%' or c.kode_mapel like '%".$q."%' or c.nama_mapel like '%".$q."%' or d.kode_kelompok like '%".$q."%'
		or d.nama_kelompok_mapel like '%".$q."%' or a.tahun_ajaran like '%".$q."%' limit $start,$limit");
		return $query;
	}
	function jumlahcariData($q){
		$q=$this->db->escape_str($q);
		$query=$this->db->query("select * from pembagian_mapel_6771 a inner join jurusan_6771 b inner join mapel_6771 c inner join kelompok_mapel_6771 d on 
		a.kd_jurusan=b.id_jurusan and a.kode_mapel=c.kode_mapel and a.kode_kelompok_mapel=d.kode_kelompok where a.semester like '%".$q."%' or a.kelas_prefix like '%".$q."%'
		or b.nama_jurusan like '%".$q."%' or b.nama_full like '%".$q."%' or c.kode_mapel like '%".$q."%' or c.nama_mapel like '%".$q."%' or d.kode_kelompok like '%".$q."%'
		or d.nama_kelompok_mapel like '%".$q."%' or a.tahun_ajaran like '%".$q."%'");
		return $query->num_rows();
	}
	function inputData($post){
		$cek=$this->cekBelumAda($post);
		if($cek["status"]==false){
			return array("sukses"=>false,"msg"=>$cek["msg"]);
		}
		$query=$this->db->insert("pembagian_mapel_6771", $post);
		if($query)return array("sukses"=>true,"msg"=>"Sukses menambahkan data");
		else return array("sukses"=>false,"msg"=>$this->db->error());
	}
}