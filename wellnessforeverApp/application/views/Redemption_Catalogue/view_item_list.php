						
						
						<li id="item_list">
								<!-- inner menu: contains the actual data -->
								<ul class="menu">
									<?php  foreach ($Redeemtion_details2 as $item) { 
									//echo "Merchandize_item_name ".$item->Merchandize_item_name;
									?>
									
									<li>
										<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Merchandize_Item_details/?Company_merchandise_item_id=<?php echo $item['Company_merchandise_item_id']; ?>">
											<div class="pull-left">
												<img src="<?php echo $item["Thumbnail_image1"]; ?>" class="img-circle">
											</div>
											
											<p style="margin-top: 10px;width: 200px;">
											<h4>
												<?php echo $item["Merchandize_item_name"]; ?>
											</h4>
											<small>Quantity : <?php echo $item["Quantity"]; ?></small>
											
												<span class="label label-info"><?php echo $item["Total_points"]; ?></span>
											</p>
										</a>
									</li>
									
									<?php } ?>
									
								</ul>
						</li>