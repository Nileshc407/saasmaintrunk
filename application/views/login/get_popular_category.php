
<script>
						var myObj2 = JSON.parse('<?php echo $result_popular_category; ?>');
						// alert(myObj2);
						var Merchandize_category_nameArr = new Array();
						var Total_qtyArr = new Array();
					
						for (x in myObj2) {
						  Merchandize_category_nameArr.push(myObj2[x].Merchandize_category_name);
						  Total_qtyArr.push(myObj2[x].Total_qty);
						}  
						
						
						var barChartData = {
							labels: Merchandize_category_nameArr,
							datasets: [{
								label: 'Menu Groups',
								backgroundColor: window.chartColors.blue,
								borderColor: window.chartColors.blue,
								borderWidth: 1,
								data: Total_qtyArr
							}]

						};
						
						
						 var ctx = document.getElementById("category_bar").getContext("2d");
							window.myBar = new Chart(ctx, {
								type: 'bar',
								 data: barChartData,
								options: {
									responsive: true,
									legend: {
										position: 'top',
									},
									title: {
										display: true,
									}
									,
									onClick: call_item,
									/* onHover: function(e) {
										 e.target.style.cursor = 'pointer';
									  } */
								}
							});
</script>	