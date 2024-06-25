<?php
class Errors extends CI_Controller
{

   public function __construct()

   {

       parent::__construct();
       $this->load->helper('url');
       $this->load->library('session');

   }



   public function index()

   {

       $this->output->set_status_header('404');
        $data['heading']="Something went Wrong";
        $data['message']="Something went Wrong";
    //    $this->load->view('errors/html/error404');    
       $this->load->view('err404',$data);    
    }


}
?>