<?php 
foreach($Company_details as $Company1) 
{
	$Cust_apk_link = $Company1['Cust_apk_link'];
	$Cust_ios_link = $Company1['Cust_ios_link'];
	$Company_name = $Company1['Company_name'];
	$Alise_name = $Company1['Alise_name'];
}
?>
<html>
<head>
<title><?php echo $Alise_name; ?></title>
<?php
	
$URL=$this->config->item('base_url')."/?masking_flag=1";
if(isset($_SESSION['Login_masking']))
{
	$URL=$_SESSION['current_url'];
}	
?>
</head>
<frameset rows="100%,0" border="0">
<frame src="<?php echo $URL;?>" frameborder="0">
<frame frameborder="0">
</frameset>

</html>