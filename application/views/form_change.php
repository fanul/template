<div id="window_status">
<form id="f_status" class="modal_form" action="javascript:status()">
	<p>Pilih Status Untuk<br></p>
        <p> <?php echo $text; ?><br /></p>
	 <table>
            <tr>
                <td>Ganti Status</td>
                <td><select data-bvalidator="required,cekcombo"  id="wfstatus_change" name="wfstatus_change" class="text ui-widget-content ui-corner-all">
                        <?php
                        $data = $this->data_master->selector($data_master);
                        foreach ($data as $key => $value) {
                            $selected = "";
                            if ($value == '')
                                $selected = "selected";
                            echo "<option value='$key' $selected>$value</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php echo $form; ?>
	<input type="submit" name="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" id="submit" name="submit" value="Ya">
	<input type="button" onclick="$('#window_status').dialog('close');" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" value="Tidak">
</form>
<script type="text/javascript" >
	$(document).ready(function () {
            
		$('#window_status').dialog({
			close: function(event, ui) {$(this).remove()},
			draggable: false,
			show: 'fade',
			hide: 'fade',
			title: 'Konfirmasi',
			resizable: false,
			width: 350,
			modal: true
		});
                
                //another setup
                $('#f_status').bValidator();
	});
	
	function status(){
		str = str = $('#f_status').serialize();
		nocache = Math.random();
		dataString = str+'&nocache='+nocache;
		$.ajax({
			type: 'POST',
			url: '<?php echo $send_url; ?>',
			data: dataString,
			cache: false,
			success: function(html){
				if (html == 'ok'){
					$('#window_status').dialog('close');
					showSukses('Data berhasil distatus');
					<?php echo $function; ?>
				}else{
					$('#window_status').dialog('close');
					showError('Data gagal distatus');
				}
			},
			error:function(xhr,ajaxOptions,thrownError){
				ajaxError(xhr,ajaxOptions,thrownError);
			}			
		})
	}
</script>
</div>