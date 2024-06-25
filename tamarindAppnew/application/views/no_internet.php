<!DOCTYPE HTML>
<html>
<head>
<title>404 error page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<style>
/*
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
*/
/* reset */
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,dl,dt,dd,ol,nav ul,nav li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline;}
article, aside, details, figcaption, figure,footer, header, hgroup, menu, nav, section {display: block;}
ol,ul{list-style:none;margin:0;padding:0;}
blockquote,q{quotes:none;}
blockquote:before,blockquote:after,q:before,q:after{content:'';content:none;}
table{border-collapse:collapse;border-spacing:0;}
/* start editing from here */
a{text-decoration:none;}
.txt-rt{text-align:right;}/* text align right */
.txt-lt{text-align:left;}/* text align left */
.txt-center{text-align:center;}/* text align center */
.float-rt{float:right;}/* float right */
.float-lt{float:left;}/* float left */
.clear{clear:both;}/* clear float */
.pos-relative{position:relative;}/* Position Relative */
.pos-absolute{position:absolute;}/* Position Absolute */
.vertical-base{	vertical-align:baseline;}/* vertical align baseline */
.vertical-top{	vertical-align:top;}/* vertical align top */
.underline{	padding-bottom:5px;	border-bottom: 1px solid #eee; margin:0 0 20px 0;}/* Add 5px bottom padding and a underline */
nav.vertical ul li{	display:block;}/* vertical menu */
nav.horizontal ul li{	display: inline-block;}/* horizontal menu */
img{max-width:100%;}
/*end reset*/
/*-----light-font----*/
@font-face {
    font-family: 'open_sanslight';
    src: url('../fonts/opensans_light_macroman/OpenSans-Light-webfont.eot');
    src: url('../fonts/opensans_light_macroman/OpenSans-Light-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/opensans_light_macroman/OpenSans-Light-webfont.woff') format('woff'),
         url('../fonts/opensans_light_macroman/OpenSans-Light-webfont.ttf') format('truetype'),
         url('../fonts/opensans_light_macroman/OpenSans-Light-webfont.svg#open_sanslight') format('svg');
    font-weight: normal;
    font-style: normal;
}
	/*-----regular-font----*/
/*-----regular-font----*/
@font-face {
    font-family: 'open_sansregular';
    src: url('../fonts/opensans_regular_macroman/OpenSans-Regular-webfont.eot');
    src: url('../fonts/opensans_regular_macroman/OpenSans-Regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/opensans_regular_macroman/OpenSans-Regular-webfont.woff') format('woff'),
         url('../fonts/opensans_regular_macroman/OpenSans-Regular-webfont.ttf') format('truetype'),
         url('../fonts/opensans_regular_macroman/OpenSans-Regular-webfont.svg#open_sansregular') format('svg');
    font-weight: normal;
    font-style: normal;
}
body {
	/* background: url(../images/bg.jpg) no-repeat 100%; */
	/* background: #31859C; */
	background: #512c1d;
	background-size: 100%;
	font-family: 'open_sanslight';
	font-size: 100%;
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-size: cover;
}
/**-----start-wrap---------**/
.wrap
{
	padding: 0px 10px;
}
/**-----start-logo--------**/
.logo
{
	text-align: center;
	padding: 1em 1em 2em 1em;
}
.logo h1{
	display: block;
	padding: 1em 0em;
}
.logo img {
	width: 180px;
}
.logo span{
	font-size: 1.3em;
	color:#fff;
}
.logo span img{
	width:40px;
	height: 40px;
	vertical-align:middle;
	margin: 0px 10px;
}
/**-----end-logo---------**/
/**-----start-search-bar-section------**/
.buttom
{
	background:url(../images/bg2.png) no-repeat 100% 0%;
	background-size: 100%;
	text-align: center;
	vertical-align: middle;
	margin: 0 auto;
	width: 280px;
}
.seach_bar
{
	padding:2em;
}
.seach_bar p{
	color:#fff;
	font-weight: 300;
	font-size: 1em;
	margin: 1.3em 0em 2em 0em;
}
.seach_bar span a{
	font-size: 1em;
	color:#fff;
	text-decoration:underline;
	font-weight: 300;
	font-family: 'open_sansregular';
}
/**********search_box*************/
.search_box{
	background: #F1F3F6;
	-webkit-transition: all 0.3s ease;
	-moz-transition: all 0.3s ease;
	-o-transition: all 0.3s ease;
	transition: all 0.3s ease;
	padding: 6px 10px;
	position: relative;
	cursor: pointer;
	width: 75%;
	margin: 0 auto;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	-o-border-radius: 5px;
	box-shadow: inset 0 0 5px rgba(156, 156, 156, 0.75);
	-moz-box-shadow: inset 0 0 5px rgba(156, 156, 156, 0.75);
	-webkit-box-shadow: inset 0px 0px 5px rgba(156, 156, 156, 0.75);
}
.search_box img {
	vertical-align: middle;
	margin-right: 10px;
}
.search_box form input[type="text"] {
	border: none;
	outline: none;
	background: none;
	font-size: 1em;
	-webkit-appearance:none;
	color:#999;
	width:80%;
	 font-family: 'open_sansregular';
	-webkit-apperance: none;
}
.search_box form input[type="submit"] {
	border: none;
	cursor: pointer;
	background: url(../images/search.png) no-repeat 0px 1px;
	position: absolute;
	right: 0;
	width: 34px;
	height: 25px;
	outline: none;
}
/*****copy-right*****/
.copy_right  {
	color: #fff;
	font-size: 0.85em;
	line-height: 1.8em;
	padding: 2em 0em 0em 0em;
	font-family: 'open_sansregular';
	text-align: center;
}
.copy_right a {
	color:#FF7ED5;
	-webkit-transition: all 0.3s ease-out;
	-moz-transition: all 0.3s ease-out;
	-ms-transition: all 0.3s ease-out;
	-o-transition: all 0.3s ease-out;
	transition: all 0.3s ease-out;
}
.copy_right a:hover {
	color:#fff;
}
</style>
</head>
<body>	
	<div class="wrap">		
		<div class="content" style="margin: 30% auto;">			
			<div class="logo">
				<h1><a href="#"><img src="<?php echo $this->config->item('base_url2');?>images/wireless.png"/></a></h1>
				<span><img src="<?php echo $this->config->item('base_url2');?>images/signal.png"/>Oops. Something went wrong retrieving data from the server. Please verify your internet connection and try again.</span>
			</div>			
		</div>		
	</div>	
</body>
</html>