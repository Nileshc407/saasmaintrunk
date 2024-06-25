<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<div class="col-md-1">
				<div class="dropdown">
					<button class="btn btn-defualt dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Graph Themes
						<span class="glyphicon glyphicon-cog"></span>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li>
							<a href="javascript:void(0);" onclick="makeCharts1('light', '#ffffff','');">
								<img width="36" height="35" alt="theme_light" class="attachment-full size-full wp-post-image" src="https://www.amcharts.com/wp-content/uploads/2013/11/theme_light2.png" kasperskylab_antibanner="on">
								Light
							</a>
						</li>
						
						<li>
							<a href="javascript:void(0);" onclick="makeCharts1('dark', '#282828','');">
								<img width="36" height="35" alt="theme_dark" class="attachment-full size-full wp-post-image" src="https://www.amcharts.com/wp-content/uploads/2013/11/theme_dark2.png" kasperskylab_antibanner="on">
								Dark
							</a>
						</li>
						
						<li>
							<a href="javascript:void(0);" onclick="makeCharts1('chalk', '#282828','<?php echo base_url()?>images/chalk_bg.jpg');">
								<img width="36" height="35" alt="theme_chalk" class="attachment-full size-full wp-post-image" src="https://www.amcharts.com/wp-content/uploads/2013/11/theme_chalk.png" kasperskylab_antibanner="on">
								Chalk
							</a>
						</li>
						
						<li>
							<a href="javascript:void(0);" onclick="makeCharts1('patterns', '#ffffff','');">
								<img width="35" height="35" alt="theme_pattern" class="attachment-full size-full wp-post-image" src="https://www.amcharts.com/wp-content/uploads/2013/11/theme_pattern2.png" kasperskylab_antibanner="on">
								Pattern
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="notice-board">
						<div class="panel panel-success">
							<div class="panel-body" id="graph_body">
								<div id="points_12_month" style="width:100%;height:500px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="col-md-12">
				<button type="button" id="close_modal" class="btn btn-primary">Close</button>
			</div>
		</div>
	</div>

<script type="text/javascript">
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#graph_myModal').hide();
		$("#graph_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
		
		location.reload();
	});
});

var chart3;
makeCharts1("light", "#FFFFFF","");
	
function makeCharts1(theme, bgColor, bgImage)
{
	if(chart3)
	{
		chart3.clear();
	}
	
	if(bgImage != "")
	{
		$('#graph_body').css("background","url("+bgImage+") no-repeat");
	}
	else
	{
		$('#graph_body').css("background","url()");
		$('#graph_body').css("background-color",bgColor);
	}
	
	chart3 = AmCharts.makeChart( "points_12_month",
	{
		type: "serial",
		theme: theme,
		addClassNames: true,
		autoMargins: true,
		marginBottom: 100,
		
		<?php if($graph_flag == "1"){ ?>
		
			titles: [{
				"text": "Total <?php echo $Company_details->Currency_name; ?> Issued Vs Total <?php echo $Company_details->Currency_name; ?> Redeemed",
				"size": 12
			}],
			
		<?php }
		else if($graph_flag == "5"){ ?>
		
			titles: [{
					"text": "Total Issued Quantity Vs Total Used Quantity",
				"size": 12
			}],
	<?php }
		else if($graph_flag == "6"){ ?>
		
			titles: [{
					"text": "Partner Total Issued Quantity  Vs Partner Total Used Quantity",
				"size": 12
			}],
			
		<?php } else if($graph_flag == "4"){ ?>
		
			titles: [{
				"text": "Member Enrollments",
				"size": 12
			}],
			
		<?php } else { ?>
		
			titles: [{
				"text": "No. of Loyalty Transactions Vs No. of Redeem Transactions",
				"size": 12
			}],
			
		<?php } ?>
		
		balloon: {
			adjustBorderColor: false,
			horizontalPadding: 10,
			verticalPadding: 8
		},
		startDuration: 1,
		dataProvider: <?php echo $Chart_data; ?>,
		
		<?php if($graph_flag == "1"){ ?>
		
			graphs: [ {
				alphaField: "alpha",
				balloonText: "<span style='font-size:12px;'>Total <?php echo $Company_details->Currency_name; ?> Issued in [[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",		
				fillAlphas: 1,
				type: "column",
				title: "Total <?php echo $Company_details->Currency_name; ?> Issed",
				valueField: "value1"
			},{
				id: "graph2",
				alphaField: "alpha",
				balloonText: "<span style='font-size:12px;'>Total <?php echo $Company_details->Currency_name; ?> Redeemed in [[category]]:<br><span style='font-size:20px;'>[[value2]]</span> </span>",		
				fillAlphas: 1,
				type: "column",
				title: "Total <?php echo $Company_details->Currency_name; ?> Redeemed",
				valueField: "value2"
			}],
			
		<?php }
			else if($graph_flag == "5"){ ?>
		
			graphs: [ {
				"balloonText": "<span style='font-size:12px;'>Total Issed Quantity in [[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",
				"bullet": "round",
				"bulletBorderAlpha": 1,
				"bulletColor": "#FFFFFF",
				"hideBulletsCount": 50,
				"title": "Total Issed Quantity",
				"valueField": "value1",
				"useLineColorForBulletBorder": true,
				"balloon":{
					"drop":true
				}
			},{
				"id": "graph2",
				"balloonText": "<span style='font-size:12px;'>Total Used Quantity in [[category]]:<br><span style='font-size:20px;'>[[value2]]</span> </span>",
				"bullet": "round",
				"bulletBorderAlpha": 1,
				"bulletColor": "#FFFFFF",
				"hideBulletsCount": 50,
				"title": "Total Used Quantity",
				"valueField": "value2",
				"useLineColorForBulletBorder": true,
				"balloon":{
					"drop":true
				}
			}],
			
			
			
		<?php } else if($graph_flag == "6"){ ?>
		
			graphs: [ {
				alphaField: "alpha",
				balloonText: "<span style='font-size:12px;'>Total Issued Quantity in [[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",		
				fillAlphas: 1,
				type: "column",
				title: "Partner Total Issed Quantity",
				valueField: "value1"
			},{
				id: "graph2",
				alphaField: "alpha",
				balloonText: "<span style='font-size:12px;'>Total Used Quantity in [[category]]:<br><span style='font-size:20px;'>[[value2]]</span> </span>",		
				fillAlphas: 1,
				type: "column",
				title: "Partner Total Used Quantity",
				valueField: "value2"
			}],
			
		<?php } else if($graph_flag == "4"){ ?>
		
			graphs: [ {
				alphaField: "alpha",
				balloonText: "<span style='font-size:12px;'>Total No. of Enrollments in [[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",		
				fillAlphas: 1,
				type: "column",
				title: "No. of Member Enrollments",
				valueField: "value1"
			
				/* "balloonText": "<span style='font-size:12px;'>Total No. of Enrollments in [[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",
				"bullet": "round",
				"bulletBorderAlpha": 1,
				"bulletColor": "#FFFFFF",
				"hideBulletsCount": 50,
				"title": "No. of Member Enrollments",
				"valueField": "value1",
				"useLineColorForBulletBorder": true,
				"balloon":{
					"drop":true
				} */
			}],
			
		<?php }else{ ?>
		
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
			},{
				"id": "graph3",
				"balloonText": "<span style='font-size:12px;'>No. of Online Purchase Transactions in [[category]]:<br><span style='font-size:20px;'>[[value3]]</span> </span>",
				"bullet": "round",
				"bulletBorderAlpha": 1,
				"bulletColor": "#FFFFFF",
				"hideBulletsCount": 50,
				"title": "No. of Online Purchase Transactions",
				"valueField": "value3",
				"useLineColorForBulletBorder": true,
				"balloon":{
					"drop":true
				}
			}],
			
		<?php } ?>
		
		categoryField: "category",
		categoryAxis: {
			gridPosition: "start",
			gridAlpha: 0,
			tickPosition: "start",
			tickLength: 10,
			labelRotation: 60
		},
		
		<?php if($graph_flag != "4"){ ?>
		
			legend:{
				position:"bottom",
				autoMargins:true,
				equalWidths:true,
				markerType: "circle",
				horizontalGap:"20"
			},
			
		<?php } ?>
		
		depth3D: 20,
		angle: 30
	});
}
</script>
