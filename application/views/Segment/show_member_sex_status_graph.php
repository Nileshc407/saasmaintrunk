<?php
$this->load->view('header/header');
?>
<!-- ************************************AM Graph************************************* -->
<script src="<?php echo base_url()?>amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>amcharts/plugins/dataloader/dataloader.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/light.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/dark.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/chalk.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/black.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/patterns.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/plugins/export/export.js"></script>
<script src="<?php echo base_url()?>amcharts/pie.js" type="text/javascript"></script>
<!-- ************************************AM Graph************************************* -->
<div class="row">
	<div class="col-md-12">
		<input type="text" name="member_id" id="member_id" autofocus value="" style="border: 0px solid white; color: #fff; outline: none;" />
		<h4 class="page-head-line">Segment Handlers</h4>
	</div>
</div> 
<div class="row">
	<div class="col-md-6">
		<div class="notice-board">
			<div class="panel panel-success">
				<div class="panel-body">
					<div id="active_inactive_members" style="width:100%;height:350px;"></div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('header/footer');?>
<!-- Modal -->
<div id="graph_myModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 90%;" id="show_graph"></div>
</div>
<!-- Modal -->
<script type="text/javascript">
var chart;
var chart1;
var chart2;
var chart5;
var chart6;
var chart7;
var chart8;
var chart9;
var chart_survey;

makeCharts("light", "#FFFFFF","");
	
function makeCharts(theme, bgColor)
{
 	
	chart5 = AmCharts.makeChart( "active_inactive_members",
	{
		type: "pie",
		startDuration: 1,
		addClassNames: true,
		theme: theme,
		titles: [{
			text: "Male Vs Female Vs Other Members",
			size: 12
		}],
		legend:{
			position:"bottom",
			autoMargins:true,
			equalWidths:true,
			markerType: "circle",
			horizontalGap:"20"
		},
		radius: "28%",			
		defs: {
			filter: [{
				id: "shadow",
				width: "200%",
				height: "200%",
				feOffset: {
				result: "offOut",
				"in": "SourceAlpha",
				dx: 0,
				dy: 0
			},
			feGaussianBlur: {
				result: "blurOut",
				"in": "offOut",
				stdDeviation: 5
			},
			feBlend: {
				"in": "SourceGraphic",
				"in2": "blurOut",
				"mode": "normal"
			}
			}]
		},			
		dataProvider: <?php echo $Chart_data3; ?>,
		valueField: "value1",
		titleField: "category",
		backgroundAlpha:"1",
		
		balloon: {
			adjustBorderColor: false,
			horizontalPadding: 10,
			verticalPadding: 8
		},
		"export": {
			"enabled": true,
			"libs": {
				"path": "<?php echo base_url()?>amcharts/plugins/export/libs/"
			},
			"menu": []
		},
		balloonText: "<span style='font-size:12px;'>[[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",			
		depth3D: 10,
		angle: 30			
	});	
}
</script>
<style>
.dropdown-menu > li > a
{
	color: #FFFFFF !important;
}

#dropdownMenu1 
{
    background-color: #093e60;
    color: #fff;
	border-color: #093e60;
}

.dropdown-menu > li > a:hover 
{
    background-color: #31859c !important;
}

.dropdown-menu > li > a:focus
{
	background-color: #31859C;
}
</style>
<!-- Modal -->
<div id="receipt_myModal" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="width: 90%;" id="show_member_info"></div>      
</div>
<!-- Modal -->
