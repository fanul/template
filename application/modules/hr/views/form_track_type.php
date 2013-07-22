<div id="form_track_typecontrol">
    <form id="track_typecontrol_track_typecontrol" class="da-form" action="javascript:ftrack_typecontrol_send();">
        <input type="hidden" value="<?php if (isset($hr_track_type_id)) echo $hr_track_type_id; ?>" name="box_track_type_id" id="box_track_type_id">

        <div class="da-form-inline">

            <div class="da-form-row">
                <label>Track Type Nama</label>
                <div class="da-form-item">
                    <input value="<?php
if (isset($hr_track_type_name))
    echo $hr_track_type_name;
?>" type="text" name="box_track_type_name" id="box_track_type_name" data-bvalidator="required">
                </div>
            </div>

            <div class="da-form-row">
                <label>Track Type Detail</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($hr_track_type_det))
                               echo $hr_track_type_det;
                           ?>" type="text" name="box_track_type_det" id="box_track_type_det" data-bvalidator="required" size="60">
                </div>
            </div>

            <div class="da-button-row">
                <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
            </div>

        </div>

    </form>
    <script type="text/javascript" >

        $(window).resize(function() {
            $('#form_track_typecontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_track_typecontrol').dialog({
                close: function(event, ui) {$(this).remove()},
                draggable: false,
                show: 'fade',
                hide: 'fade',
                title: '<?php echo $title; ?>',
                resizable: false,
                width: 'auto',
                modal: true
            });
            
            //bvalidator
            $('#track_typecontrol_track_typecontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#user_last_login').datetimepicker();
            //$('.user_last_login').datetimepicker();
            //$('#user_last_login').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($track_typecontrol_tanggal_lahir)) { ?> , currentText: "<?php echo $track_typecontrol_tanggal_lahir; ?>" <?php } ?>});
            //$('#track_typecontrol_tanggal_kerja').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($track_typecontrol_tanggal_lamar)) { ?> , currentText: "<?php echo $track_typecontrol_tanggal_kerja; ?>" <?php } ?>});
            //$('#track_typecontrol_selesai').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($selesai)) { ?> , currentText: "<?php echo $selesai; ?>" <?php } ?>});
        });
	
        function ftrack_typecontrol_send(){
            showLoading();
            str = $("#track_typecontrol_track_typecontrol").serialize();
            nocache = Math.random();
            var dataString = str+'&nocache='+nocache;
            $.ajax({
                type: 'POST',
                url: '<?php echo $send_url; ?>',
                data: dataString,
                cache: false,
                success: function(html){
                    if (html == 'ok'){
                        hideLoading();
                        $('#form_track_typecontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-track_typecontrol").flexReload();
                    }else{
                        showError('Proses gagal');
                    }
                },
                error:function(xhr,ajaxOptions,thrownError){
                    hideLoading();
                    ajaxError(xhr,ajaxOptions,thrownError);
                }
            })
        }

    </script>
</div>