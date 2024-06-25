

<nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top" style="background: #fab900 ! important;">
  <a class="navbar-brand app-name" href="<?php echo base_url()?>index.php"> 
	<img class="" src="<?php echo base_url() ?>images/logo.png" style="width:150px; height:40px;">
	
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar" >
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a  <?php if($this->router->fetch_method()=='index'){ echo 'class="nav-link active"';}else{ echo 'class="nav-link"';}?> href="<?php echo base_url()?>index.php">Home</a>
      </li>
	  
       <li class="nav-item">
        <a <?php if($this->router->fetch_method()=='food_menu'){ echo 'class="nav-link active"';}else{ echo 'class="nav-link"';}?>  href="<?php echo base_url()?>index.php/Login/food_menu">Food Menu</a>
      </li>
	  
	  <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url()?>index.php#loyalty">Loyalty Program</a>
      </li>
	  
      <li class="nav-item">
        <a class="nav-link" href="JavaScript:void(0);" data-toggle="modal" data-target="#myModal1">Sign In </a>
      </li> 

	  <li class="nav-item">
        <a class="nav-link" href="JavaScript:void(0);" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Outlet Login</a>
      </li> 
	  
	  <li ><a  <?php if($this->router->fetch_method()=='track_order'){ echo 'class="nav-link active"';}else{ echo 'class="nav-link"';}?> href="<?php echo base_url()?>index.php/Login/track_order">Track Order </a></li>  

	
    </ul>
  </div>  
</nav>
<style>

.navbar-dark .navbar-nav .active>.nav-link, .navbar-dark .navbar-nav .nav-link.active, .navbar-dark .navbar-nav .nav-link.show, .navbar-dark .navbar-nav .show>.nav-link {
     color: #000000 ! important;
}
.sidebar-title {
    padding: 15px 15px 15px;
    background: #5e4103 ! important;
    float: left;
    width: 100%;
}
.card-body .btn {
    background-color: #fab900 ! important;
    color: #fff;
}
.navbar-dark .navbar-nav .nav-link
{
	color: #FFFFFF ! important;
}
</style>