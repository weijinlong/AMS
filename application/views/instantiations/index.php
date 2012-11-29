<?php
if (!$isAjax)
{
    ?>
    <div class="row-fluid">
        <div class="span3">
           <?php $this->load->view('instantiations/_facet_search'); ?>
        </div>
        <div  class="span9" id="instantiation-container">
        <?php } ?>
        <div style="text-align: right;width: 860px;">
            <strong><?php echo $start; ?> - <?php echo $end; ?></strong> of <strong style="margin-right: 10px;"><?php echo $total; ?></strong>
            <?php echo $this->ajax_pagination->create_links(); ?>
        </div>
        <div style="overflow: auto;width:865px;" id="instantiation-main">
            <table class="tablesorter table-freeze-custom table-bordered" id="instantiation_table" style="margin-top:0px;margin-left: 1px;">
                <thead>
                    <tr>
                        <th><span style="float:left;min-width: 80px;">Asset ID</span></th>
                        <th><span style="float:left;min-width: 100px;">Organization</span></th>
                        <th><span style="float:left;min-width: 250px;">Asset Title</span></th>
                        <th><span style="float:left;min-width: 100px;">Instantiation ID</span></th>
                        <th><span style="float:left;min-width: 90px;">Source Date</span></th>
                        <th><span style="float:left;min-width: 90px;">Date Type</span></th>
                        <th><span style="float:left;min-width: 90px;">Format Type</span></th>
                        <th><span style="float:left;min-width: 90px;">File size</span></th>
                        <th><span style="float:left;min-width: 100px;">Unit of measure</span></th>
                        <th><span style="float:left;min-width: 70px;">Duration</span></th>
                        <th><span style="float:left;min-width: 70px;">Colors</span></th>
                        <th><span style="float:left;min-width: 70px;">Language</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($records) > 0)
                    {
                        foreach ($records as $key => $value)
                        {
                            ?>
                            <tr>
                                <td><?php echo $value->assets_id; ?></td>
                                <td><?php echo $value->organization; ?></td>
                                <td><?php echo $value->multi_assets; ?></td>
                                <td><?php echo $value->id; ?></td>
                                <td><?php echo ($value->instantiation_date == 0) ? 'No Source Date' : date('Y-m-d', $value->instantiation_date); ?></td>
                                <td><?php echo $value->date_type; ?></td>
                                <td><?php echo $value->format_type; ?></td>
                                <td><?php echo ($value->file_size == 0) ? 'N/A' : $value->file_size; ?></td>
                                <td><?php echo ($value->file_size_unit_of_measure) ? $value->file_size_unit_of_measure : 'N/A'; ?></td>
                                <td><?php echo ($value->actual_duration) ? $value->actual_duration : 'N/A'; ?></td>
                                <td><?php echo ($value->color) ? $value->color : 'N/A'; ?></td>
                                <td><?php echo ($value->language) ? $value->language : 'N/A'; ?></td>

                            </tr>
                            <?php
                        }
                    } else
                    {
                        ?>
                        <tr>
                            <td colspan="12">No instantiation record found.</td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

        <div style="text-align: right;width: 860px;">
            <strong><?php echo $start; ?> - <?php echo $end; ?></strong> of <strong style="margin-right: 10px;"><?php echo $total; ?></strong>
            <?php echo $this->ajax_pagination->create_links(); ?>
        </div>
        <?php
        if (!$isAjax)
        {
            ?>
        </div>
    </div>
    <script type="text/javascript">
               
                
        //        $(function() {
        //    			 
        //            $('#instantiation_table').freezeTableColumns({
        //                width:       860,   // required
        //                height:      600,   // required
        //                numFrozen:   2,     // optional
        //                //            frozenWidth: 150,   // optional
        //                clearWidths: true  // optional
        //            });//freezeTableColumns
        //        });
        function facet_search(param)
        {
            console.log(param);
            $.blockUI({
                css: { 
                    border: 'none', 
                    padding: '15px', 
                    backgroundColor: '#000', 
                    '-webkit-border-radius': '10px', 
                    '-moz-border-radius': '10px', 
                    opacity: .5, 
                    color: '#fff',
                    zIndex:999999
                }
            }); 
                        
            var objJSON = eval("(function(){return " + param + ";})()");
            $.ajax({
                type: 'POST', 
                url: '<?php echo site_url('instantiations/index') ?>/'+objJSON.page,
                data:$('#form_search_instantiation').serialize(),
                success: function (result)
                { 
                    $('#instantiation-container').html(result);
                    $.unblockUI();
                                
                }
            });
        }
    </script>
<?php } ?>