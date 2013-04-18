<div class="row">
	<div style="margin: 2px 0px 10px 0px;float:left;width: 570px;">

		<?php
		$asset_title_type = explode('|', trim(str_replace('(**)', '', $asset_details->title_type)));
		$asset_title = explode('|', trim(str_replace('(**)', '', $asset_details->title)));
		$asset_title_ref = explode('|', trim(str_replace('(**)', '', $asset_details->title_ref)));
		$combine_title = '';
		foreach ($asset_title as $index => $title)
		{
			if (isset($asset_title_type[$index]) && $asset_title_type[$index] != '')
				$combine_title.= $asset_title_type[$index] . ': ';
			if (isset($asset_title_ref[$index]))
			{
				if ($asset_title_ref[$index] != '')
				{
					$combine_title.="<a target='_blank' href='$asset_title_ref[$index]'>$title</a>: ";
					$combine_title.=' (' . $asset_title_ref[$index] . ')';
				}
				else
					$combine_title.=$title;
			}
			else
				$combine_title.=$title;
			$combine_title.='<div class="clearfix"></div>';
		}
		?>
		<h2><?php echo $combine_title; ?></h2>
	</div>
	<?php
	if ($next_result_id)
	{
		?>
		<div style="float: right;margin-left:5px"><a href="<?php echo site_url('instantiations/detail/' . $next_result_id); ?>" class="btn">Next >></a></div>
		<?php
	}
	if ($prev_result_id)
	{
		?>
		<div style="float: right;margin-left:5px"><a href="<?php echo site_url('instantiations/detail/' . $prev_result_id); ?>" class="btn"><< Previous</a></div>
		<?php
	} if ( ! is_empty($last_page))
	{
		?>
		<div style="float: right;margin-left:5px;"><a href="<?php echo site_url($last_page); ?>" class="btn">Return</a></div>
	<?php } ?>
	<div style="float: right;">
		<button class="btn "><span class="icon-download-alt"></span>Export Instantiation</button>
	</div>
	<div class="clearfix"></div>
	<?php $this->load->view('partials/_list'); ?>

	<div class="span9" style="margin-left: 250px;" id="ins_view_detail">
		<?php $this->load->view('partials/_proxy_files'); ?>
		<div style="float: left;margin-left: 10px;">

			<?php
			if ($this->role_id != '20')
			{
				?>
						
				<!--<div><a href="<?php echo site_url('instantiations/edit/' . $inst_id); ?>" class="btn">Edit Instantiation</a></div>-->
			<?php } ?>
			<table  cellPadding="8" class="record-detail-table">
				<!--				Instantiation ID	Start		-->
				<?php
				if ($inst_identifier->instantiation_identifier || $inst_identifier->instantiation_source)
				{
					$ins_identifier = explode(' | ', trim(str_replace('(**)', '', $inst_identifier->instantiation_identifier)));
					$ins_identifier_src = explode(' | ', trim(str_replace('(**)', '', $inst_identifier->instantiation_source)));
					$combine_identifier = '';
					foreach ($ins_identifier as $index => $identifier)
					{
						$combine_identifier.= '<p>';
						$combine_identifier.= $identifier;
						if (isset($ins_identifier_src[$index]) && ! empty($ins_identifier_src[$index]))
							$combine_identifier.=' (' . $ins_identifier_src[$index] . ')';
						$combine_identifier.= '</p>';
					}
					?>
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b><span class="label_star"> *</span> Instantiation ID:</b></label>
						</td>
						<td>

							<p><?php echo $combine_identifier; ?></p>

						</td>
					</tr>
				<?php } ?>
				<!--				Instantiation ID	End		-->
				<!--				Date 	Start		-->
				<?php
				if ($inst_dates->dates != '' || $inst_dates->date_type != '')
				{
					?>
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Date:</b></label>
						</td>
						<td>
							<?php
							if ($inst_dates->date_type != '')
							{
								?>
								<span><?php echo $inst_dates->date_type . ':'; ?></span>
								<?php
							}
							if ($inst_dates->dates != '')
							{
								?>
								<span><?php echo date("Y-m-d", strtotime($inst_dates->dates)); ?></span>

							<?php } ?>


						</td>
					</tr>
				<?php } ?>
				<!--				Date 	End		-->
				<!--				Media Type 	Start		-->
				<?php
				if (isset($inst_media_type->media_type) && $inst_media_type->media_type != '')
				{
					$media_type = explode(' | ', $inst_media_type->media_type);
					?>
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b><span class="label_star"> *</span> Media Type:</b></label>
						</td>
						<td>
							<?php
							foreach ($media_type as $value)
							{
								?>
								<p><?php echo $value; ?></p>
							<?php }
							?>
						</td>
					</tr>
				<?php } ?>
				<!--				Media Type	End		-->
				<!--				Format 	Start		-->
				<?php
				if (isset($inst_format->format_name) && $inst_format->format_name != '')
				{

					$format = 'Format: ';
					if (isset($inst_format->format_type) && ($inst_format->format_type != NULL))
					{
						if ($inst_format->format_type === 'physical')
							$format = 'Physical Format: ';
						if ($inst_format->format_type === 'digital')
							$format = 'Digital Format: ';
					}
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b>  <?php echo $format; ?></b></label>
						</td>
						<td>
							<span>	<?php echo $inst_format->format_name; ?></span>
						</td>
					</tr>
				<?php } ?>
				<!--				Format	End		-->
				<!--				Generation 	Start		-->
				<?php
				if (isset($inst_generation) && $inst_generation->generation != '')
				{

					$generations = explode(' | ', $inst_generation->generation);
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Generation:</b></label>
						</td>
						<td>
							<?php
							foreach ($generations as $generation)
							{
								?>
								<p>	<?php echo $generation; ?></p>
							<?php } ?>
						</td>
					</tr>

				<?php } ?>
				<!--				Generation	End		-->
				<!--				Location 	Start		-->
				<?php
				if ($detail_instantiation->location && $detail_instantiation->location != '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><span class="label_star"> *</span><b> Location:</b></label>
						</td>
						<td>
							<p>	<?php echo $detail_instantiation->location; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Location	End		-->
				<!--				Duration 	Start		-->
				<?php
				if ($detail_instantiation->projected_duration !== NULL && $detail_instantiation->projected_duration !== '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><span class="label_star"> *</span><b> Duration:</b></label>
						</td>
						<td>

							<p><?php echo $detail_instantiation->projected_duration; ?></p>

						</td>
					</tr>

					<?php
				}
				else if ($detail_instantiation->actual_duration !== '' && $detail_instantiation->actual_duration !== NULL)
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><span class="label_star"> *</span><b> Duration:</b></label>
						</td>
						<td>
							<p>	<?php echo date('H:i:s', strtotime($detail_instantiation->actual_duration)); ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Duration	End		-->
				<!--				Time Start 	Start		-->
				<?php
				if ($detail_instantiation->time_start && $detail_instantiation->time_start != '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Time Start:</b></label>
						</td>
						<td>
							<p>	<?php echo $detail_instantiation->time_start; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Time Start	End		-->
				<!--				File Size 	Start		-->
				<?php
				if ($detail_instantiation->file_size && $detail_instantiation->file_size != '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> File Size:</b></label>
						</td>
						<td>
							<p>	<?php echo $detail_instantiation->file_size . ' ' . $detail_instantiation->file_size_unit_of_measure; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				File Size	End		-->
				<!--				Standard 	Start		-->
				<?php
				if ($detail_instantiation->standard && $detail_instantiation->standard != '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Standard:</b></label>
						</td>
						<td>
							<p>	<?php echo $detail_instantiation->standard; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Standard	End		-->
				<!--				Dimensions: 	Start		-->
				<?php
				if (isset($inst_demension->instantiation_dimension) && $inst_demension->instantiation_dimension != '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Dimensions:</b></label>
						</td>
						<td>
							<p>	<?php echo $inst_demension->instantiation_dimension . ' ' . $inst_demension->unit_of_measure; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Dimensions	End		-->
				<!--				Data Rate 	Start		-->
				<?php
				if ($detail_instantiation->data_rate != '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Data Rate:</b></label>
						</td>
						<td>
							<?php $data_rate_unit = (isset($inst_data_rate_unit->unit_of_measure)) ? $inst_data_rate_unit->unit_of_measure : ''; ?>
							<p>	<?php echo $detail_instantiation->data_rate . ' ' . $data_rate_unit; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Data Rate	End		-->
				<!--			 Color 	Start		-->
				<?php
				if (isset($inst_color->color) && $inst_color->color != '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Color:</b></label>
						</td>
						<td>
							<p>	<?php echo $inst_color->color; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Color	End		-->
				<!--			 Tracks 	Start		-->
				<?php
				if ($detail_instantiation->tracks && $detail_instantiation->tracks != '')
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Tracks:</b></label>
						</td>
						<td>
							<p>	<?php echo $detail_instantiation->tracks; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Tracks	End		-->
				<!--			 Channel Configuration 	Start		-->
				<?php
				if ($detail_instantiation->channel_configuration && $detail_instantiation->channel_configuration)
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Channel Configuration:</b></label>
						</td>
						<td>
							<p>	<?php echo $detail_instantiation->channel_configuration; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Channel Configuration	End		-->
				<!--			 Language 	Start		-->
				<?php
				if ($detail_instantiation->language && $detail_instantiation->language)
				{
					?>	
					<tr>
						<td class="record-detail-page">
							<label><i class="icon-question-sign"></i><b> Language:</b></label>
						</td>
						<td>
							<p>	<?php echo $detail_instantiation->language; ?></p>

						</td>
					</tr>

				<?php } ?>
				<!--				Language	End		-->
				<!--			 Annotation 	Start		-->
				<?php
				if ($inst_annotation->ins_annotation != '' || $inst_annotation->ins_annotation_type != '')
				{
					$ins_annotation = explode(' | ', trim(str_replace('(**)', '', $inst_annotation->ins_annotation)));
					$ins_annotation_type = explode(' | ', trim(str_replace('(**)', '', $inst_annotation->ins_annotation_type)));
					$combine_annotation = '';
					if ((count($ins_annotation) > 0 && $ins_annotation[0] != '') || (count($ins_annotation_type) > 0 && $ins_annotation_type[0] != ''))
					{
						if (count($ins_annotation) > count($ins_annotation_type))
						{
							foreach ($ins_annotation as $index => $row)
							{
								if (isset($ins_annotation_type[$index]) && $ins_annotation_type[$index] != '')
								{
									$combine_annotation.=$ins_annotation_type[$index] . ': ';
								}
								$combine_annotation.=$row;
								$combine_annotation.='<div class="clearfix"></div>';
							}
						}
						else
						{
							foreach ($ins_annotation_type as $index => $row)
							{
								$combine_annotation.=$row . ': ';
								if (isset($ins_annotation[$index]) && $ins_annotation[$index] != '')
								{
									$combine_annotation.=$ins_annotation[$index];
								}

								$combine_annotation.='<div class="clearfix"></div>';
							}
						}

						if ( ! empty($combine_annotation) && trim($combine_annotation) != ':')
						{
							?>
							<tr>
								<td class="record-detail-page">
									<label><i class="icon-question-sign"></i><b> Annotation:</b></label>
								</td>
								<td>
									<p>	<?php echo $combine_annotation; ?></p>

								</td>
							</tr>
							<?php
						}
					}
					?>	


				<?php } ?>
				<!--				Annotation	End		-->
			</table>

		</div>

		<?php
		if (isset($ins_nomination) && ! empty($ins_nomination))
		{
			?>
			<div class="nomination-container">

				<p><b><?php echo $ins_nomination->status; ?></b></p>
				<p><?php echo $ins_nomination->nomination_reason; ?></p>
				<?php
				if ($ins_nomination->nominated_by != '')
				{
					?>
					<p><?php echo 'Nominated by ' . $ins_nomination->first_name . ' ' . $ins_nomination->last_name; ?></p>
					<?php
				}
				if ($ins_nomination->nominated_at != '')
				{
					?>
					<p><?php echo ' at ' . $ins_nomination->nominated_at; ?></p>

				<?php }
				?>
			</div>
			<?php
		}
		?>
		<?php
		if (isset($instantiation_events) && ! is_empty($instantiation_events))
		{
			?>
			<table cellpadding="4" class="table table-bordered" >
				<thead>
				<th>Event Type</th>
				<th>Event Date</th>
				<th>Event Note</th>
				<th>Event Outcome</th>
				</thead>
				<tbody>
					<?php
					foreach ($instantiation_events as $events)
					{
						?>
						<tr>
							<td><?php echo (isset($events->event_type) && ! is_empty($events->event_type)) ? $events->event_type : ''; ?></td>
							<td><?php echo (isset($events->event_date) && ! is_empty($events->event_date)) ? $events->event_date : ''; ?></td>
							<td><?php echo (isset($events->event_note) && ! is_empty($events->event_note)) ? $events->event_note : ''; ?></td>
							<td><?php echo (isset($events->event_outcome) && ! is_empty($events->event_outcome)) ? $events->event_outcome : ''; ?></td>
						</tr>
					<?php } ?>
				</tbody></table>
		<?php }
		?>
	</div>
	<div class="clearfix"></div>


	<?php $this->load->view('essence_track/list'); ?>
</div>
