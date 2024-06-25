<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downloadpdf extends CI_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();		
		$this->load->helper(array('form', 'url','encryption_val'));
		$this->load->model('login/Login_model');
		$this->load->model('Users_model');
		$this->load->model('Igain_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library("Excel");
		$this->load->library('m_pdf');
		$this->load->library('Send_notification');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->model('shopping/Shopping_model');
		$this->load->library('cart');
		$this->load->model('General_setting_model');
	}	
    public function index()
    {
		
		// header("Content-Type: application/octet-stream"); 
					  
		// $file = $_GET["file"]; 
		 // echo"--file---".$file."---<br>";
		 // die;
		/* header("Content-Disposition: attachment; filename=" . urlencode($file));    
		header("Content-Type: application/download"); 
		header("Content-Description: File Transfer");             
		header("Content-Length: " . filesize($file)); 
		  
		flush(); // This doesn't really matter. 
		  
		$fp = fopen($file, "r"); 
		while (!feof($fp)) { 
			echo fread($fp, 65536); 
			flush(); // This is essential for large downloads 
		}					  
		fclose($fp);  */
		// header("Content-Disposition", "attachment; filename='".$file."'");
		
		$file = $_GET["file"]; 
		
		if (isset($_GET['file'])) {
		$file = $_GET['file'];
		// echo $file;
		// var_dump(is_readable($file));
		// if (file_exists($file) && is_readable($file) && preg_match('/\.pdf$/',$file)) {
			
			header('Content-Type: application/download');
			header("Content-Disposition: attachment; filename=\"$file\"");
			readfile($file);
		 // }
		// }
	}
 
		
	}
}
?>