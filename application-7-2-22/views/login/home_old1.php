<?php
$this->load->view('header/header');
if(($Logged_user_id == 2 && $Super_seller == 0) || $Logged_user_id == 5 )//|| $Logged_user_id == 4
{
?>

<div class="row">
	<div class="col-md-12">
		<input type="text" name="member_id" tabindex="1" id="member_id" value="" style="border: 0px solid white; color: #fff; outline: none;"/>
		<img src="<?php echo base_url()?>images/landing_page.png" class="img-responsive" style="margin: 0px auto;" />
	</div>
</div>

<?php $this->load->view('header/footer');?>

<?php
}
else
{
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
		<h4 class="page-head-line">Dashboard</h4>
	</div>
</div>

<div class="row">
	<div class="col-md-2">
		<div class="dropdown">
			<button class="btn btn-defualt dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Graph Themes
				<span class="glyphicon glyphicon-cog"></span>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li>
					<a href="javascript:void(0);" onclick="makeCharts('light', '#ffffff','');">
						<img width="36" height="35" alt="theme_light" class="attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/LightTheme.png" kasperskylab_antibanner="on">
						Light
					</a>
				</li>				
				<li>
					<a href="javascript:void(0);" onclick="makeCharts('dark', '#282828','');">
						<img width="36" height="35" alt="theme_dark" class="attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/DarkTheme.png" kasperskylab_antibanner="on">
						Dark
					</a>
				</li>				
				<li>
					<a href="javascript:void(0);" onclick="makeCharts('chalk', '#282828','<?php echo base_url()?>images/chalk_bg.jpg');">
						<img width="36" height="35" alt="theme_chalk" class="attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/ChalkTheme.jpg" kasperskylab_antibanner="on">
						Chalk
					</a>
				</li>				
				<li>
					<a href="javascript:void(0);" onclick="makeCharts('patterns', '#ffffff','');">
						<img width="35" height="35" alt="theme_pattern" class="attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/PatternTheme.jpg" kasperskylab_antibanner="on">
						Pattern
					</a>
				</li>
			</ul>
		</div>
	</div>
	
	<div class="col-md-2 pull-right">
		<strong>Export to : </strong>
		<a onclick="exportCharts();" href="javascript:void(0);" >
			<img class="img-responsive img-thumbnail" src="<?php echo base_url(); ?>images/pdf.png" width="50" alt="PDF Dump" title="PDF Dump"/>
		</a>
	</div>
</div>
<br>

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
			
	<div class="col-md-6">
		<div class="notice-board">
			<div class="panel panel-success">
				<div class="panel-body">					   
					<div id="monthly_enrollments" style="width:100%;height:350px;"></div>
				</div>
				<div class="panel-footer"><a href="javascript:void(0);" onclick="graph_details(4);">Last 12 Months View...</a></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="notice-board">
			<div class="panel panel-success">
				<div class="panel-body">
					<div id="points_six_month" style="width:100%;height:350px;"></div>
				</div>
				<div class="panel-footer"><a href="javascript:void(0);" onclick="graph_details(1);">Last 12 Months View...</a></div>
			</div>
		</div>
	</div>
			
	<div class="col-md-6">
		<div class="notice-board">
			<div class="panel panel-success">
				<div class="panel-body">					   
					<div id="count_six_month" style="width:100%;height:350px;"></div>
				</div>
				<div class="panel-footer"><a href="javascript:void(0);" onclick="graph_details(2);">Last 12 Months View...</a></div>
			</div>
		</div>
	</div>
</div>


<?php 
		
		// echo"<br>customers_comment------".$customers_comment;
if($Chart_data7 != NULL || $customers_comment != NULL) { 
?>

<div class="row">

	<?php if($Chart_data7 != NULL) { ?>	
		<div class="col-md-6">
			<div class="notice-board">
				<div class="panel panel-success">
					<div class="panel-body">
						<div id="survey_feedback" style="width:100%;height:350px;"></div>
					</div>
					
				</div>
			</div>
		</div>	
	<?php } ?>
	
	<?php if($customers_comment != NULL) { ?>
		<div class="col-md-6">		
			<div class="panel panel-info">
				<div class="panel-heading">	
					<div class="row">
					<div class="col-md-6"><h4>Member's Suggestions</h4></div>		
					</div>	
				</div>	
						
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
						<tr>
							<th class="text-center">Member Name</th>
							<th class="text-center">Suggestions</th>
						</tr>
						</thead>
						
						<tbody>						
							<?php 
								foreach($customers_comment as $opt)
								{
									echo '<tr>';
									echo '<td class="text-center">'.$opt['First_name'].' '.$opt['Last_name'].'</td>';
									echo '<td class="text-left">'.$opt['Content_description'].'</td>';
									echo '</tr>';									
								}							
							?>
						</tbody> 
					</table>
				</div>
			</div>
		</div>
	<?php } ?>
	
</div>

<?php } ?>


<div class="row">
	<div class="col-md-8">
		<div class="panel panel-info">
			<div class="panel-heading">		
				<div class="row">
					<div class="col-md-6"><h4>Top 10 Happy Members..!! (Last 1 Month)</h4></div>
					<div class="col-md-6"><img src="<?php echo base_url()?>images/happy.png" class="img-responsive img-circle pull-right" alt="Happy"></div>
				</div>			
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					<tr>
						<th class="text-center">Member Name</th>
						<th class="text-center">Email ID</th>
						<th class="text-center">Phone Number</th>
						<th class="text-center">Total Purchase</th>
						<th class="text-center">Total Points Issued</th>
						<th class="text-center">Total Points Redeemed</th>
					</tr>
					</thead>
					
					<tbody>
					
						<?php
						if($happy_customers != NULL)
						{
							$Total_Purchase_amount = $happy_customers['Total_Purchase_amount'];
							$Total_Loyalty_pts = $happy_customers['Total_Loyalty_pts'];
							$Total_Redeem_points = $happy_customers['Total_Redeem_points'];
							$Customer_name = $happy_customers['Customer_name'];
							$Customer_email = $happy_customers['Customer_email'];
							$Customer_phno = $happy_customers['Customer_phno'];
							
							for($i=0;$i<10;$i++)
							{
								if($Total_Purchase_amount[$i] != NULL)
								{
									echo '<tr>';
									echo '<td class="text-center">'.$Customer_name[$i].'</td>';
									echo '<td class="text-center">'.$Customer_email[$i].'</td>';
									echo '<td class="text-center">'.$Customer_phno[$i].'</td>';
									echo '<td class="text-center">'.$Total_Purchase_amount[$i].'</td>';
									echo '<td class="text-center">'.$Total_Loyalty_pts[$i].'</td>';
									echo '<td class="text-center">'.$Total_Redeem_points[$i].'</td>';
									echo '</tr>';
								}
							}
						}
						?>
					</tbody> 
				</table>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="panel panel-info">
			<div class="panel-heading">		
				<div class="row">
					<div class="col-md-6"><h4>Top 10 Worry Members..? (Last 1 Month)</h4></div>
					<div class="col-md-6"><img src="<?php echo base_url()?>images/worry.png" class="img-responsive img-circle pull-right" alt="Happy"></div>
				</div>			
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					<tr>
						<th class="text-center">Member Name</th>
						<th class="text-center">Last Visit</th>
					</tr>
					</thead>
					
					<tbody>
						<?php
						if($worry_customers != NULL)
						{
							$Worry_Customer_name = $worry_customers['Worry_Customer_name'];
							$Customer_last_visit = $worry_customers['Customer_last_visit'];
							
							for($i=0;$i<10;$i++)
							{
								if($Worry_Customer_name[$i] != NULL)
								{
									echo '<tr>';
									echo '<td class="text-center">'.$Worry_Customer_name[$i].'</td>';
									echo '<td class="text-center">'.date("d M Y",strtotime($Customer_last_visit[$i])).'</td>';
									echo '</tr>';
								}
							}
						}
						?>				
					</tbody> 
				</table>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>

<!-- Modal -->
<div id="graph_myModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 90%;" id="show_graph"></div>
</div>
<!-- Modal -->

<script type="text/javascript">
function graph_details(graph_flag)
{	
	$.ajax({
		type: "POST",
		data: {graph_flag: graph_flag},
		url: "<?php echo base_url()?>index.php/Home/twelve_month_graph",
		success: function(data)
		{			
			$('#graph_myModal').show();
			$("#graph_myModal").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
			$("#show_graph").html(data.graphHtml);
		}
	});
}
</script>

<script type="text/javascript">
var Chart_data7 = <?php echo $Chart_data7; ?>;
var chart1;
var chart2;
var chart5;
var chart6;
var chart7;

makeCharts("light", "#FFFFFF","");
	
function makeCharts(theme, bgColor, bgImage)
{
	if(chart1)
	{
		chart1.clear();
	}
	if(chart2)
	{
		chart2.clear();
	}
	if(chart5)
	{
		chart5.clear();
	}
	if(chart6)
	{
		chart6.clear();
	}
	if(chart7 && Chart_data7 != 0)
	{
		chart7.clear();
	}
	
	if(bgImage != "")
	{
		$('.panel-body').css("background","url("+bgImage+") no-repeat");
	}
	else
	{
		$('.panel-body').css("background","url()");
		$('.panel-body').css("background-color",bgColor);
	}

	chart1 = AmCharts.makeChart( "points_six_month",
	{
		type: "serial",
		theme: theme,
		addClassNames: true,
		autoMargins: true,
		marginBottom: 100,
		titles: [{
			"text": "Total Points Issued Vs Total Points Redeemed",
			"size": 12
		}],
		balloon: {
			adjustBorderColor: false,
			horizontalPadding: 10,
			verticalPadding: 8
		},
		startDuration: 1,
		dataProvider: <?php echo $Chart_data; ?>,
		graphs: [ {
			alphaField: "alpha",
			balloonText: "<span style='font-size:12px;'>Total Points Issued in [[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",		
			fillAlphas: 1,
			type: "column",
			title: "Total Points Issued",
			valueField: "value1"
		},{
			id: "graph2",
			alphaField: "alpha",
			balloonText: "<span style='font-size:12px;'>Total Points Redeemed in [[category]]:<br><span style='font-size:20px;'>[[value2]]</span> </span>",		
			fillAlphas: 1,
			type: "column",
			title: "Total Points Redeemed",
			valueField: "value2"
		}],
		categoryField: "category",
		categoryAxis: {
			gridPosition: "start",
			gridAlpha: 0,
			tickPosition: "start",
			tickLength: 10,
			labelRotation: 60
		},
		legend:{
			position:"bottom",
			autoMargins:true,
			equalWidths:true,
			markerType: "circle",
			horizontalGap:"20"
		},
		"export": {
			"enabled": true,
			"libs": {
				"path": "<?php echo base_url()?>amcharts/plugins/export/libs/"
			},
			"menu": []
		},
		depth3D: 20,
		angle: 30
	} );
	
	chart2 = AmCharts.makeChart( "count_six_month",
	{
		type: "serial",
		theme: theme,
		addClassNames: true,
		autoMargins: true,
		marginBottom: 100,
		titles: [{
			"text": "No. of Loyalty Transactions Vs No. of Redeem Transactions",
			"size": 12
		}],
		balloon: {
			adjustBorderColor: false,
			horizontalPadding: 10,
			verticalPadding: 8
		},
		startDuration: 1,
		dataProvider: <?php echo $Chart_data2; ?>,
		graphs: [ {
			"balloonText": "<span style='font-size:12px;'>No. of Loyalty Transactions in [[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",
			"bullet": "round",
			"bulletBorderAlpha": 1,
			"bulletColor": "#FFFFFF",
			"hideBulletsCount": 50,
			"title": "No. of Loyalty Transactions",
			"valueField": "value1",
			"useLineColorForBulletBorder": true,
			"balloon":{
				"drop":true
			}
		},{
			"id": "graph2",
			"balloonText": "<span style='font-size:12px;'>No. of Redeem Transactions in [[category]]:<br><span style='font-size:20px;'>[[value2]]</span> </span>",
			"bullet": "round",
			"bulletBorderAlpha": 1,
			"bulletColor": "#FFFFFF",
			"hideBulletsCount": 50,
			"title": "No. of Redeem Transactions",
			"valueField": "value2",
			"useLineColorForBulletBorder": true,
			"balloon":{
				"drop":true
			}
		}],
		categoryField: "category",
		categoryAxis: {
			gridPosition: "start",
			gridAlpha: 0,
			tickPosition: "start",
			tickLength: 10,
			labelRotation: 60
		},
		legend:{
			position:"bottom",
			autoMargins:true,
			equalWidths:true,
			markerType: "circle",
			horizontalGap:"20"
		},
		"export": {
			"enabled": true,
			"libs": {
				"path": "<?php echo base_url()?>amcharts/plugins/export/libs/"
			},
			"menu": []
		},
		depth3D: 20,
		angle: 30
	} );
	
	chart6 = AmCharts.makeChart( "monthly_enrollments",
	{
		type: "serial",
		theme: theme,
		addClassNames: true,
		autoMargins: true,
		marginBottom: 100,
		titles: [{
			"text": "Member Enrollments",
			"size": 12
		}],
		balloon: {
			adjustBorderColor: false,
			horizontalPadding: 10,
			verticalPadding: 8
		},
		startDuration: 1,
		dataProvider: <?php echo $Chart_data4; ?>,
		graphs: [ {
			alphaField: "alpha",
			balloonText: "<span style='font-size:12px;'>Total No. of Enrollments in [[category4]]:<br><span style='font-size:20px;'>[[value4]]</span> </span>",		
			fillAlphas: 1,
			type: "column",
			title: "No. of Member Enrollments",
			valueField: "value4"
			
			/* "balloonText": "<span style='font-size:12px;'>Total No. of Enrollments in [[category4]]:<br><span style='font-size:20px;'>[[value4]]</span> </span>",
			"bullet": "round",
			"bulletBorderAlpha": 1,
			"bulletColor": "#FFFFFF",
			"hideBulletsCount": 50,
			"title": "No. of Member Enrollments",
			"valueField": "value4",
			"type": "column",
			"useLineColorForBulletBorder": true,
			"balloon":
			{
				"drop":true
			} */
		}
		],
		categoryField: "category4",
		categoryAxis: {
			gridPosition: "start",
			gridAlpha: 0,
			tickPosition: "start",
			tickLength: 10,
			labelRotation: 60
		},
		"export": {
			"enabled": true,
			"libs": {
				"path": "<?php echo base_url()?>amcharts/plugins/export/libs/"
			},
			"menu": []
		},
		depth3D: 20,
		angle: 30
	} );
	
	chart5 = AmCharts.makeChart( "active_inactive_members",
	{
		type: "pie",
		startDuration: 1,
		addClassNames: true,
		theme: theme,
		titles: [{
			text: "Active Vs Inactive Members (Last 30 Days)",
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
	
	if(Chart_data7 != 0)
	{
		
		chart7 = AmCharts.makeChart( "survey_feedback",
			{
				"type": "serial",
				theme: theme,
				titles: [{
				text: "Survey Responded Members Vs Non-Responded Members",
				size: 12
				}],
				"legend": {
				"autoMargins": false,
				"borderAlpha": 0.2,
				"equalWidths": false,
				"horizontalGap": 10,
				"markerSize": 10,
				"useGraphSettings": true,
				"valueAlign": "left",
				"valueWidth": 0
			},
			"dataProvider":  <?php echo $Chart_data7; ?>,			
			"valueAxes": [{
				"stackType": "100%",
				"axisAlpha": 0,
				"gridAlpha": 0,
				"labelsEnabled": false,
				"position": "left"
			}],
			"graphs": [{
				"balloonText": "Total Responded:[[value]]",
				"fillAlphas": 0.9,
				"fontSize": 11,
				"labelText": "[[percents]]%",
				"lineAlpha": 0.5,
				"title": "Total Responded",
				"type": "column",
				"valueField": "ToatalResponder"
			}, {
				"balloonText":"Total Not Responded:[[value]]",
				"fillAlphas": 0.9,
				"fontSize": 11,
				"labelText": "[[percents]]%",
				"lineAlpha": 0.5,
				"title": "Total Not Responded",
				"type": "column",
				"valueField": "TotalNotResponder"
			}],
			"marginTop": 30,
			"marginRight": 0,
			"marginLeft": 0,
			"marginBottom": 40,
			"autoMargins": false,
			"categoryField": "surveyname",
			"categoryAxis": {
				"gridPosition": "start",
				"axisAlpha": 0,
				"gridAlpha": 0
			},
			"export": {
			"enabled": true,
			"libs": {
				"path": "<?php echo base_url()?>amcharts/plugins/export/libs/"
			},
			"menu": []
		},

		});
	}
}

function exportCharts() 
{

	var images = [];
	var pending = AmCharts.charts.length;
	for ( var i = 0; i < AmCharts.charts.length; i++ ) 
	{
		var chart = AmCharts.charts[ i ];		
		chart.export.capture( {}, function() {
		this.toJPG( {}, function( data ) {
			images.push( {
				"image": data,
				"fit": [ 523.28, 769.89 ]
			} );
			pending--;
			if ( pending === 0 ) 
			{
				// all done - construct PDF
				chart.export.toPDF( {
					content: images
				}, function( data ) {
					this.download( data, "application/pdf", "<?php echo $Graph_name; ?>" );
				} );
			}
      } );
    } );
  }
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

<?php } ?>

<!-- Modal -->
<div id="receipt_myModal" class="modal fade" role="dialog" >
	<div class="modal-dialog" style="width: 90%;" id="show_member_info"></div>      
</div>
<!-- Modal -->

<script type="text/javascript">	
	$(document).ready( function ()
	{		
		/* $("#member_id").focus();		
		$('body').mousedown(function(event) 
		{			
			if(event.which) 
			{
				setFocus();
			}
		}); */	
	}); 
	
	function setFocus()
	{
		$("#member_id").focus();
	}
	 
	setInterval(function()
	{
		var cardid = $('#member_id').val();			
		if(cardid != "")
		{
			$.ajax(
			{				
				type: "POST",
				data: {cardID:cardid},
				url: "<?php echo base_url(); ?>index.php/Home/member_visit",
				success:function(data)
				{
					$('#member_id').val("");
					$("#member_id").blur(); 
					$("#show_member_info").html(data.transactionReceiptHtml);	
					$('#receipt_myModal').show();
					$("#receipt_myModal").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );		
				}			
			});			
		}
	},1000);
</script>


