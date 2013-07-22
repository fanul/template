<div id="form_agendacontrol">
    <form id="agendacontrol_agendacontrol" class="da-form" action="javascript:fagendacontrol_send();">

        <div class="da-form-inline">

            <div class="da-form-row">
                <label>Track Type Name</label>
                <div class="da-form-item">
                    <input value="
                    <?php
                    if (isset($agenda_name))
                        echo $agenda_name;
                    ?>" type="text" name="box_agenda_name" id="box_agenda_name" data-bvalidator="required">
                </div>
            </div>

            <div class="da-form-row">
                <label>Detail</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($agenda_det))
                               echo $agenda_det;
                    ?>" type="text" name="box_agenda_det" id="box_agenda_det" data-bvalidator="required" size="40">
                </div>
            </div>

            <div class="da-button-row">
                <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
            </div>

        </div>
    </form>
    <script type="text/javascript" >

        $(window).resize(function() {
            $('#form_agendacontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_agendacontrol').dialog({
                close: function(agenda, ui) {$(this).remove()},
                draggable: false,
                show: 'fade',
                hide: 'fade',
                title: '<?php echo $title; ?>',
                resizable: false,
                width: 'auto',
                modal: true
            });
            
            //bvalidator
            $('#agendacontrol_agendacontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#user_last_login').datetimepicker();
            //$('.user_last_login').datetimepicker();
            //$('#user_last_login').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($agendacontrol_tanggal_lahir)) { ?> , currentText: "<?php echo $agendacontrol_tanggal_lahir; ?>" <?php } ?>});
            //$('#agendacontrol_tanggal_kerja').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($agendacontrol_tanggal_lamar)) { ?> , currentText: "<?php echo $agendacontrol_tanggal_kerja; ?>" <?php } ?>});
            //$('#agendacontrol_selesai').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($selesai)) { ?> , currentText: "<?php echo $selesai; ?>" <?php } ?>});
        });
	
        function fagendacontrol_send(){
            showLoading();
            str = $("#agendacontrol_agendacontrol").serialize();
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
                        $('#form_agendacontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-agendacontrol").flexReload();
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