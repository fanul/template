<div id="window_hapus">
<form id="f_hapus" class="modal_form" action="javascript:hapus()">
	<p>Apakah anda ingin menghapus data ini?<br></p>
        <p><?php echo $text; ?></p>
	<?php echo $form; ?>
	<input type="submit" name="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" id="submit" name="submit" value="Ya">
	<input type="button" onclick="$('#window_hapus').dialog('close');" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" value="Tidak">
</form>
<script type="text/javascript" >
	$(document).ready(function () {
		$('#window_hapus').dialog({
			close: function(event, ui) {$(this).remove()},
			draggable: false,
			show: 'fade',
			hide: 'fade',
			title: 'Konfirmasi',
			resizable: false,
			width: 350,
			modal: true
		});
	});
	
	function hapus(){
		str = str = $("#f_hapus").serialize();
		nocache = Math.random();
		dataString = str+'&nocache='+nocache;
		$.ajax({
			type: 'POST',
			url: '<?php echo $send_url; ?>',
			data: dataString,
			cache: false,
			success: function(html){
				if (html == 'ok'){
					$('#window_hapus').dialog('close');
					showSukses('Data berhasil dihapus');
					<?php echo $function; ?>
				}else{
					$('#window_hapus').dialog('close');
					showError('Data gagal dihapus');
				}
			},
			error:function(xhr,ajaxOptions,thrownError){
				ajaxError(xhr,ajaxOptions,thrownError);
			}			
		})
	}
</script>
</div>