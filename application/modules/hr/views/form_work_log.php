<div id="form_work_logcontrol">
    <form id="work_logcontrol_work_logcontrol" class="da-form" action="javascript:fwork_logcontrol_send();">

        <input type="hidden" value="<?php if (isset($work_log_id)) echo $work_log_id; ?>" name="box_work_log_id" id="box_work_log_id">

        <div class="da-form-inline">

            <div class="da-form-row">
                <label>Waktu</label>
                <div class="da-form-item">
                    <input 
                        value="<?php if (isset($hr_work_log_time)) echo $hr_work_log_time;?>" 
                        type="text" name="box_work_log_time" id="box_work_log_time" data-bvalidator="required" >
                </div>
            </div>

            <div class="da-form-row">
                <label>NIK</label>
                <div class="da-form-item">
                    <input value="<?php if (isset($hr_employee_nik)) echo $hr_employee_nik;?>" 
                    type="text" name="box_employee_nik" id="box_employee_nik" data-bvalidator="required" size="40">
                </div>
            </div>

            <div class="da-form-row">
                <label>Special</label>
                <div class="da-form-item">
                  <?php $checked="checked=checked"; if (!isset($hr_work_log_special)) $checked='' ?>
                  <input type="checkbox" id="box_is_special" <?php echo $checked; ?> onchange="disable_special()">
                </div>
            </div>

            <div class="da-form-row">
                <label></label>
                <div class="da-form-item">
                    <input value="<?php if (isset($hr_work_log_special)) echo $hr_work_log_special; ?>" 
                    type="text" name="box_work_log_special" id="box_work_log_special" data-bvalidator="required" size="40">
                </div>
            </div>

            <div class="da-form-row">
                <label>Permission</label>
                <div class="da-form-item">
                    <?php $checked="checked=checked"; if (!isset($hr_work_log_permission)) $checked='' ?>
                  <input type="checkbox" id="box_is_permission" <?php echo $checked; ?> onchange="disable_permission()">
                </div>
            </div>

            <div class="da-form-row">
                <label></label>
                <div class="da-form-item">
                    <input value="<?php if (isset($hr_work_log_permission)) echo $hr_work_log_permission; ?>" 
                    type="text" name="box_work_log_permission" id="box_work_log_permission" data-bvalidator="required" size="40">
                </div>
            </div>

            <div class="da-button-row">
                <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
            </div>

        </div>

    </form>

    <script type="text/javascript" >

        $(window).resize(function() {
            $('#form_work_logcontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#box_employee_nik').autocomplete({
                source: function(req, add){
                    $.ajax({
                        url: '<?php echo site_url("hr/work_log/search_employee"); ?>',
                        dataType: 'json',
                        type: 'POST',
                        data: req,
                        success: function(data){
                            if(data.response =='true'){
                                add(data.message);
                            } else {
                                $('#kontrak_span_nama2').text('');
                            }
                        }
                    });
                },
                minLength: 0,
                select: function( event, ui ) {
                    if(ui.item.label != null )
                        $('#box_employee_nik').val(ui.item.label);
                }
            }).data("autocomplete")._renderItem = function (ul,item)
            {
                return $("<li></li>")
                .data("item.autocomplete", item)
                .append( "<a> nik:  " + item.label + " , Nama: " + item.nama + "</a>" )
                .appendTo( ul )
            };
            

            $('#form_work_logcontrol').dialog({
                close: function(event, ui) {$(this).remove()},
                draggable: false,
                show: 'fade',
                hide: 'fade',
                title: '<?php echo $title; ?>',
                resizable: false,
                width: 'auto',
                open: function(event, ui){
                    // untuk auto-close dialog :)
                    //setTimeout("$('#form_work_logcontrol').dialog('close')",3000);


                    disable_special();
                    disable_permission();
                    $("#box_employee_nik").focus();

                },
                modal: true
            });
            
            //bvalidator
            $('#work_logcontrol_work_logcontrol').bValidator();
            
            $('#box_work_log_time').datetimepicker({yearRange: "-5:+5",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy", timeFormat: 'hh:mm:ss' <?php if (isset($sys_user_last_login)) { ?> , currentText: "<?php echo $sys_user_last_login; ?>" <?php } ?>});


        });
	
        function disable_special()
        {
            var is_checked = $('#box_is_special').attr('checked')?true:false;
            
            if(!is_checked)
            {
                $('#box_work_log_special').attr('disabled', 'disabled');
                
            }
            else
            {
                $('#box_work_log_special').removeAttr('disabled');
                
            }
        }

        function disable_permission()
        {
            var is_checked = $('#box_is_permission').attr('checked')?true:false;
            
            if(!is_checked)
            {
                $('#box_work_log_permission').attr('disabled', 'disabled');
                
            }
            else
            {
                $('#box_work_log_permission').removeAttr('disabled');
                
            }
        }

        function fwork_logcontrol_send(){
            showLoading();
            str = $("#work_logcontrol_work_logcontrol").serialize();
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
                        $('#form_work_logcontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-work_logcontrol").flexReload();
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