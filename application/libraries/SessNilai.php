<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class SessNilai{
	
	public function get_userdata($key,$key2){
		if(isset($_SESSION[$key]) && isset($_SESSION[$key][$key2]))return $_SESSION[$key][$key2];
		return null;
	}	
	public function resetSessNilai($asu){
		$CI =& get_instance();
		foreach($CI->session->userdata as $key=>$session){
			$exp=explode("_",$key,2);
			if(count($exp)==2 && $exp[0]=="nilai" && $exp[1]!=$asu)unset($CI->session->userdata[$key]);
		}
	}
}
?>