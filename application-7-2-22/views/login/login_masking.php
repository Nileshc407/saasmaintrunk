<html>
<head>
<title>IgainSpark</title>
<?php
	
$URL=$this->config->item('base_url')."index.php/Login/?masking_flag=1";
if(isset($_SESSION['Login_masking']))
{
	$URL=$_SESSION['current_url'];
}
//  /index.php/Enrollmentc/enrollment
 //echo $URL;	
?>
</head>
<frameset rows="100%,0" border="0">
<frame src="<?php echo $URL;?>" frameborder="0">
<frame frameborder="0">
</frameset>

</html>