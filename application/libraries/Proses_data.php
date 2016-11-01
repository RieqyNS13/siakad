<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Proses_data{
	private $CI;
	function __construct(){
		$this->CI=& get_instance();
	}
	function trimData($data){
		foreach($data as $key=>$val){
			$data2[$key]=trim($val);
		}
		return $data2;
	}
	function checkDataSudahDisi($data,$key_kecuali=array()){
		$data=$this->trimData($data);
		foreach($data as $key=>$val){
			if(strlen($val)==0 && !in_array($key,$key_kecuali))return false;
		}
		return true;
	}
	function isKosongSemua($data){
		$data=$this->trimData($data);
		$jumlah=count($data);
		$i=0;
		foreach($data as $val){
			//die(json_encode(array("error"=>$val)));
			if(strlen($val)==0)$i++;
		}
		
		if($i==$jumlah)return true;
		else return false;
	}
	
}
?>