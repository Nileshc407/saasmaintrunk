<?php
class Chat extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();	
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Users_model');
		$this->load->library('session');	
		$this->load->helper('language');
		//$session_site_lang = $this->session->userdata('site_lang');		
		//$this->lang->load("message","".$session_site_lang."");
	}
	
	function index()
	{
		// $data['listOfUsers'] = $this->Users_model->getUsers(); 
		// $this->load->view('chat/userList', $data);	
	}
	function insert_chat()
	{
		$today=date('Y-m-d H:i:s');
		$Post_data=array
					   (
						'Company_id'=>$this->input->post('Company_id'),
						'From_email_id'=>$this->input->post('from_email_id'),
						'From_name'=>$this->input->post('from_name'),
						'To_email_id'=>$this->input->post('to_email_id'),
						'To_name'=>$this->input->post('to_name'),
						'message'=>$this->input->post('message'),
						'Sent_date'=>$today,
						'read'=>0	
					   );
		$result = $this->Users_model->insert_chat_message($Post_data);
	}
	function getchats()
	{
		$from=$_REQUEST["from"];
		$data = $this->Users_model->getchats($from);
		 $data2 = $this->Users_model->checkchatsnew($from);

		$count_message=count($data);
		$mess2="no messages";
		foreach($data as $rec)
		{
			$mess[]=$rec["message"];
			$mess2=implode('*',$mess);
		} 		 
		  $this->output->set_output($mess2);
	}
	function getchatsnew()
	{
		$Company_id=$_REQUEST["Company_id"];
		$Cust_email_id=$_REQUEST["Cust_email_id"];
		$from=$_REQUEST["from"];
		$data = $this->Users_model->getchatsnew($Company_id,$Cust_email_id,$from);
		$data2 = $this->Users_model->checkchatsnew($Company_id,$Cust_email_id,$from);

		$count_message=count($data);
		$mess2=1111;
		$flag=0;
		foreach($data as $rec)
		{
			$mess[]='<b>'.$rec["From_name"].':&nbsp;</b>'.$rec["message"];
			$mess2=implode('*',$mess);	
		} 
		$this->output->set_output($mess2);
	}
	function getchatsall()
	{
		$Company_id=$_REQUEST["Company_id"];
		$Cust_email_id=$_REQUEST["Cust_email_id"];
		//$enrollId=$_REQUEST["enrollId"];
		$from=$_REQUEST["from"];
		$data = $this->Users_model->getchatsall($Company_id,$Cust_email_id,$from);
		
		
		$count_message=count($data);
		$mess2=9999;
		$flag=0;
		foreach($data as $rec)
		{
			$mess[]='<b>'.$rec["From_name"].':&nbsp;</b>'.$rec["message"];
			$mess2=implode('*',$mess);	
		} 
		$this->output->set_output($mess2);	
	}
}
?>