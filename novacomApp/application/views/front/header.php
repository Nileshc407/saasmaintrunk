<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Registration, Landing">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
<?php /*  ?><link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css"><?php */ ?>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/line-icons.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/owl.carousel.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/owl.theme.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/nivo-lightbox.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/magnific-popup.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/animate.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/menu_sideslide.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/main.css">    
<link rel="stylesheet" href="<?=base_url()?>assets/css/responsive.css">


<?php 
	
	$General_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'General', 'value');
	$General_details = json_decode($General_data, true);
	
	$Label_font = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Label_font', 'value');
	$Label_font_details = json_decode($Label_font, true);
	
	$General_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Placeholder_font', 'value');
	$General_details = json_decode($General_data, true);
	
	$General_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Button_font', 'value');
	$General_details = json_decode($General_data, true);
	
	$Extra_large_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Extra_large_font', 'value');
	$Extra_large_font_details = json_decode($Extra_large_font_data, true);
	
	print_r($Extra_large_font_details);
	
	// echo"---color----".$Label_font_details[0]['Label_font_colour']."--<br>";
	
	?>