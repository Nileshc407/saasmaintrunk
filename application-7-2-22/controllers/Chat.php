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
	}
	function index()
	{	
		// $data['listOfUsers'] = $this->users_model->getUsers(); 
		// $this->load->view('chat/userList', $data);	
	}
	function insert_chat()
	{
		$Company_id=$this->input->post('Company_id');
		$from_email_id=$this->input->post('from_email_id');
		
		$data['chat_user_id'] = $this->Users_model->getchatUsers($Company_id,$from_email_id); 
		foreach($data['chat_user_id'] as $val)
		{
			$to_email_id=$val['From_email_id'];
			$to_name=$val['From_name'];
		}
		
		$today=date('Y-m-d H:i:s');
		$Post_data=array
					   (
						'Company_id'=>$this->input->post('Company_id'),
						'From_email_id'=>$this->input->post('from_email_id'),
						'From_name'=>$this->input->post('from_name'),
						'To_email_id'=>$to_email_id,
						'To_name'=>$to_name,
						'message'=>$this->input->post('message'),
						'Sent_date'=>$today,
						'read'=>0	
					   );
		$result = $this->Users_model->insert_chat_message($Post_data);
		
		/*--------------------Update Chat_status in session tbl busy---------------------*/
		$Post_data1=array ('Chat_status'=> 0);
					   
		$result1 = $this->Users_model->Update_chat_status_session_tbl($Post_data1,$this->input->post('enroll_id'),$this->input->post('Company_id'));
		/*--------------------Update Chat_status in session tbl busy---------------------*/
	}
	/*--------------------Update Chat_status in session tbl available ---------------------*/
	function End_chat() // Whene user End Chat
	{
		$enroll =  $_GET['enroll'];
		$Company_id =  $_GET['Company_id'];	
		
		$Post_data2=array ('Chat_status'=> 1);
					   
		$result2 = $this->Users_model->Update_chat_status_session_tbl($Post_data2,$enroll,$Company_id);
		
	/*********************Send Chat End  Message to Customer **************************/		
		$data['chat_user_id'] = $this->Users_model->getchatUsers($Company_id,$_GET['from_email_id']); 
		
		foreach($data['chat_user_id'] as $val)
		{
			$to_email_id=$val['From_email_id'];
			$to_name=$val['From_name'];
		}
		
		$today=date('Y-m-d H:i:s');
		
		$Post_data=array
					   (
						'Company_id'=>$_GET['Company_id'],
						'From_email_id'=>$_GET['from_email_id'],
						'From_name'=>$_GET['from_name'],
						'To_email_id'=>$to_email_id,
						'To_name'=>$to_name,
						'message'=>$_GET['message'],
						'Sent_date'=>$today,
						'read'=>0	
					   );
		
		$result = $this->Users_model->insert_chat_message($Post_data);
		
	/*********************Send Chat End  Message to Customer **************************/			
		redirect('Home');	
	}
	function End_chat_auto() // Whene refresh page
	{	
		$enroll =  $this->input->post('enroll');	
		$Company_id =  $this->input->post('Company_id');		
		$Post_data2=array ('Chat_status'=> 1);
					   
				$result2 = $this->Users_model->Update_chat_status_session_tbl($Post_data2,$enroll,$Company_id);
				
			redirect('Home');	
	}
	/*--------------------Update Chat_status in session tbl available ---------------------*/
	function getchats()
	{
		$from=$_REQUEST["from"];
		$data = $this->Users_model->getchats($from);
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
		$To_email_id=$_REQUEST["from_email_id"];
		$from=$_REQUEST["from"];
		$data = $this->Users_model->getchatsnew($Company_id,$To_email_id,$from);
		 $data2 = $this->Users_model->checkchatsnew($Company_id,$from,$To_email_id);
		$count_message=count($data);
		$mess2='no messeges';
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
		$Company_id = $_REQUEST["Company_id"];
		$data['chat_user_id'] = $this->Users_model->getchatUsers($Company_id,$this->input->post('from_email_id')); 
		if($data['chat_user_id']!=NULL)
		{
			foreach($data['chat_user_id'] as $val)
			{
				$to_id=$val['From_email_id'];
				$from_id=$val['To_email_id'];
				$to_name=$val['From_name'];
			}
				$enroll_name=$_REQUEST["from"];
				$from_email_id=$_REQUEST["from_email_id"];
				$Company_id=$_REQUEST["Company_id"];
				$data = $this->Users_model->getchatsall($Company_id,$enroll_name,$from_email_id);
				
				$count_message=count($data);
				$mess2='';
				$flag=0;
			foreach($data as $rec)
			{
				$mess[]='<b>'.$rec["From_name"].':&nbsp;</b>'.$rec["message"];
				$mess2=implode('*',$mess);	
			} 
				$this->output->set_output($mess2);
		}
	}	
}
?>