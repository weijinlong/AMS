<div style="width: 270px;position: fixed;">
    <div class="sidebar">
								<?php
								if(	!	isset($inst_id)	&&	empty($inst_id))
								{
												$inst_id	=	FALSE;
												$style	=	'';
								}
								else
												$style	=	'active';
								?>
        <div class="container-sidebar <?php	echo	$style;	?>">

            <div><a class="" href="javascript:void(0);">Instantiations</a></div>
        </div>
								<div class="clearfix"></div>
								<?php
								if(isset($asset_instantiations['records'])	&&	!	empty($asset_instantiations['records']))
								{
												?>
												<?php
												foreach($asset_instantiations['records']	as	$asset_instantiation)
												{
																if($asset_instantiation->id	==	$inst_id)
																				$style	=	'active';
																else
																				$style	=	'';
																?>
																<div class="container-sidebar <?php	echo	$style;	?>" ><h4><a style="<?php	echo	$style;	?>" href="<?php	echo	site_url('instantiations/detail/'	.	$asset_instantiation->id)	?>"><?php	echo	$asset_details->guid_identifier	?></a></h4>
																				<?php
																				echo	(isset($asset_instantiation->organization)	&&	($asset_instantiation->organization	!=	NULL))	?	"Organization: "	.	$asset_instantiation->organization	.	'<br/>'	:	'';
																				echo	(isset($asset_instantiation->asset_title)	&&	($asset_instantiation->asset_title	!=	NULL))	?	"Title: "	.	$asset_instantiation->asset_title	.	'<br/>'	:	'';
																				echo	(isset($asset_instantiation->instantiation_identifier)	&&	($asset_instantiation->instantiation_identifier	!=	NULL))	?	"Instantiation ID: "	.	$asset_instantiation->instantiation_identifier	.	'<br/>'	:	'';
																				echo	(isset($asset_instantiation->format_name)	&&	($asset_instantiation->format_name	!=	NULL)	)	?	"Format: "	.	$asset_instantiation->format_name	.	'<br/>'	:	'';
																				echo	(isset($asset_instantiation->generation)	&&	($asset_instantiation->generation	!=	NULL)	)	?	"Generation: "	.	$asset_instantiation->generation	.	'<br/>'	:	'';
																				echo	($asset_instantiation->actual_duration	>	0)	?	"Actual Duration: "	.	duration($asset_instantiation->actual_duration)	.	'<br/>'	:	'';
																				echo	($asset_instantiation->projected_duration	>	0)	?	"Projected Duration: "	.	duration($asset_instantiation->projected_duration)	.	'<br/>'	:	'';
																				?>
																</div>
												<?php	}
												?>

								<?php	}	?>

    </div>
</div>