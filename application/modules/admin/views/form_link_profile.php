<div id="form_link_profilecontrol">
    <form id="link_profilecontrol_link_profilecontrol" class="da-form" action="javascript:flink_profilecontrol_send();">

        <div class="da-form-inline">
            <input type="hidden" value="<?php if (isset($sys_user_id)) echo $sys_user_id; ?>" name="box_user_id" id="box_user_id">
            <input type="hidden" value="<?php if (isset($hr_employee_nik)) echo $hr_employee_nik; ?>" name="box_employee_nik" id="box_employee_nik">

            <div class="da-form-row">
                <label>Nama Karyawan</label>
                <div class="da-form-item">
                    <input value="<?php
if (isset($hr_employee_nick_name))
    echo $hr_employee_nick_name;
?>" type="text" name="box_employee_nick_name" id="box_employee_nick_name" data-bvalidator="required" size="50">
                </div>
            </div>

            <div class="da-form-row">
                <label>Delete Link</label>
                <div class="da-form-item">
                    <input type="checkbox" name="checked" id="checked" value="checked" onchange="checkCheckBox()">
                </div>
                <br>
                <div class="da-form-item">
                    <ul class="da-form-list">
                        <li>
                            <input type="radio" name="box_delete_link" id="box_delete_link1" value="user" disabled="disabled">
                            <label>System User</label>
                        </li>
                        <li>
                            <input type="radio" name="box_delete_link" id="box_delete_link2" value="employee" disabled="disabled">
                            <label>Nik</label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="da-button-row">
                <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
            </div>

        </div>


    </form>
    <script type="text/javascript" >
        
        function checkCheckBox()
        {
            var isChecked = $('#checked').attr('checked')?true:false;
            
            if(!isChecked)
            {
                $("#link_profilecontrol_link_profilecontrol input[id^=box_delete_link]:radio").attr('disabled',true);

            }
            else
            {
                $("#link_profilecontrol_link_profilecontrol input[id^=box_delete_link]:radio").attr('disabled',false);
               
            }
        }
        
        $(window).resize(function() {
            $('#form_link_profilecontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_link_profilecontrol').dialog({
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
            $('#link_profilecontrol_link_profilecontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#user_last_login').datetimepicker();
            
            $('#box_employee_nick_name').autocomplete({
                source: function(req, add){
                    $.ajax({
                        url: '<?php echo site_url("admin/user/search_employee"); ?>',
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
            
        });
	
        function set_id()
        {
            
        }
        
        function flink_profilecontrol_send(){
            showLoading();
            str = $("#link_profilecontrol_link_profilecontrol").serialize();
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
                        $('#form_link_profilecontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-usercontrol").flexReload();
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