<div id="form_work_shiftcontrol">
    <form id="work_shiftcontrol_work_shiftcontrol" class="da-form" action="javascript:fwork_shiftcontrol_send();">

        <input type="hidden" value="<?php if (isset($work_shift_id)) echo $work_shift_id; ?>" name="box_work_shift_id" id="box_work_shift_id">


        <div class="da-form-inline">

            <div class="da-form-row">
                <label>Nama Shift</label>
                <div class="da-form-item">
                    <input 
                        value="<?php if (isset($work_shift_name)) echo $work_shift_name;?>" 
                        type="text" name="box_work_shift_name" id="box_work_shift_name" data-bvalidator="required" >
                </div>
            </div>

            <div class="da-form-row">
                <label>Waktu Mulai</label>
                <div class="da-form-item">
                    <input value="<?php if (isset($work_shift_start_time)) echo $work_shift_start_time;?>" 
                    type="text" name="box_work_shift_start_time" id="box_work_shift_start_time" data-bvalidator="required" size="40">
                </div>
            </div>

            <div class="da-form-row">
                <label>Waktu Berakhir</label>
                <div class="da-form-item">
                    <input value="<?php if (isset($work_shift_end_time)) echo $work_shift_end_time; ?>" 
                    type="text" name="box_work_shift_end_time" id="box_work_shift_end_time" data-bvalidator="required" size="40">
                </div>
            </div>

            <div class="da-button-row">
                <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
            </div>

        </div>

    </form>

    <script type="text/javascript" >

        $(window).resize(function() {
            $('#form_work_shiftcontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_work_shiftcontrol').dialog({
                close: function(event, ui) {$(this).remove()},
                draggable: false,
                show: 'fade',
                hide: 'fade',
                title: '<?php echo $title; ?>',
                resizable: false,
                width: 'auto',
                open: function(event, ui){
                    // untuk auto-close dialog :)
                    //setTimeout("$('#form_work_shiftcontrol').dialog('close')",3000);
                },
                modal: true
            });
            
            //bvalidator
            $('#work_shiftcontrol_work_shiftcontrol').bValidator();
            
            $('#box_work_shift_start_time').timepicker({});
            $('#box_work_shift_end_time').timepicker({
                timeFormat: "hh:mm:ss"
            });

        });
	
        function fwork_shiftcontrol_send(){
            showLoading();
            str = $("#work_shiftcontrol_work_shiftcontrol").serialize();
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
                        $('#form_work_shiftcontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-work_shiftcontrol").flexReload();
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