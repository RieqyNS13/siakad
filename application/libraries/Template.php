<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
    
                
		var $template_data = array();
		
		function load($template = '', $view = '' , $view_data = array())
		{               
			$this->CI = &get_instance();
			$view_data["kontenUtama"]=$this->CI->load->view($view, $view_data, TRUE);	
			return $this->CI->load->view($template, $view_data);
		}
}