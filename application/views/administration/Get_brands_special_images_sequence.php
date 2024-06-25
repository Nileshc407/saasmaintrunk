			<!--			
		<div class="table-responsive"><br><br>
			<table class="table table-bordered table-hover">
				<thead>Uploaded Images 
				<tr>
				<?php
				/* if($results2 != NULL)
				{
					foreach($results2 as $results2)
					{
						echo '<th class="text-center"><img src="'.$results2->Spl_Image.'" style="width:100px;height:100px;"><br><br>Sequence No.'.$results2->Sequence.'</th>';
					}
				} */
				?>
					
					
				</tr>
				</thead>
				
				<tbody>
				
				</tbody> 
			</table>
			
		</div>
						
		-->				
					

		<div class="row" style="margin-left:2%;">
							
			<div class="col-xs-12 col-md-12">
				<div class="thumbnail">
                <?php
                if($results2 != NULL)
				{
					foreach($results2 as $results2)
					{

                        $imageId = $results2->Spl_offer_id;
                        $imageName = $results2->Spl_Image;
                        $imagePath = $results2->Spl_Image;

                        echo '<br><img src="'.$imageName.'" id="no_image3" class="img-responsive" style="width: 340px;height:170px;">';
                    }
                }
                ?>
            </ul>

        </div>            
        
        </div>
		<button class="btn btn-primary " onclick='javascript:modal.style.display = "none";'   type="button">Close</button>
        </div>
		
		
      