<div id="form_track_typecontrol">
    <form id="track_typecontrol_track_typecontrol" class="modal_form" action="javascript:ftrack_typecontrol_send();">
        <table cellspacing="0" border="0" cellpadding="5" class="modal_form">

            <input type="hidden" value="<?php if (isset($hr_track_type_id)) echo $hr_track_type_id; ?>" name="box_track_type_id" id="box_track_type_id">

            <tr>
                <td>Track Type Name</td>
                <td><input value="<?php
if (isset($hr_track_type_name))
    echo $hr_track_type_name;
?>" type="text" name="box_track_type_name" id="box_track_type_name" data-bvalidator="required" class="text ui-widget-content ui-corner-all"></td>
            </tr>

            <tr>
                <td>Detail</td>
                <td><input value="<?php
                           if (isset($hr_track_type_det))
                               echo $hr_track_type_det;
?>" type="text" name="box_track_type_det" id="box_track_type_det" data-bvalidator="required" class="text ui-widget-content ui-corner-all" size="40"></td>
            </tr>

        </table>

        <tr>
            <td></td>
        <input type="submit" name="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only hasDatepicker" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
        </tr>

    </form>
    <script type="text/javascript" >

        
        $(document).ready(function () {
            
            $('#form_track_typecontrol').dialog({
                close: function(event, ui) {$(this).remove()},
                draggable: false,
                show: 'fade',
                hide: 'fade',
                title: '<?php echo $title; ?>',
                resizable: false,
                width: 600,
                modal: true
            });
            
            //bvalidator
            $('#track_typecontrol_track_typecontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#user_last_login').datetimepicker();

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