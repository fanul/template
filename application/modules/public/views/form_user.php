<div id="form_usercontrol">
    <form id="usercontrol_usercontrol" class="modal_form" action="javascript:fusercontrol_send();">
        <table cellspacing="0" border="0" cellpadding="5" class="modal_form">

            <input type="hidden" value="<?php if (isset($sys_user_id)) echo $sys_user_id; ?>" name="wfsys_user_id" id="wfsys_user_id">

            <tr>
                <td>Nama User</td>
                <td><input value="<?php
if (isset($sys_user_name))
    echo $sys_user_name;
?>" type="text" name="wfsys_user_name" id="wfsys_user_name" data-bvalidator="required" class="text ui-widget-content ui-corner-all"></td>
            </tr>

            <tr>
                <td>Default Password</td>
                <td><input value="<?php
                           $checked = "checked=checked";
                           if (isset($sys_user_password))
                               $checked = "";
?>" <?php echo $checked; ?> onchange="checkCheckBox()" type="checkbox" name="checked" id="checked" class="text ui-widget-content ui-corner-all"></td>
            </tr>

            <tr>
                <td>Custom Password</td>
                <td><input value="<?php
                           $disabled = 'disabled=disabled';
                           $background = 'gray';
                           if (isset($sys_user_password)) {
                               echo $sys_user_password;
                               $disabled = "";
                               $background = '';
                           }
?>" 
                           <?php echo $disabled; ?> type="password" name="wfsys_user_password" id="wfsys_user_password" data-bvalidator="required" class="text ui-widget-content ui-corner-all" size="40" style="background: <?php echo $background ?>"></td>
            </tr>

            <tr>
                <td>Tipe</td>
                <td><select data-bvalidator="required,cekcombo"  id="wfsys_user_type" name="wfsys_user_type" class="text ui-widget-content ui-corner-all">
                        <?php
                        $data = $this->data_master->user_type();
                        foreach ($data as $key => $value) {
                            $selected = "";
                            if (isset($sys_user_type)) {
                                if ($value == $sys_user_type)
                                    $selected = "selected";
                            }
                            echo "<option value='$key' $selected>$value</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

        </table>

        <tr>
            <td></td>
        <input type="submit" name="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only hasDatepicker" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
        </tr>

    </form>
    <script type="text/javascript" >
        
        function checkCheckBox()
        {
            var isChecked = $('#checked').attr('checked')?true:false;
            
            if(isChecked)
            {
                $("#wfsys_user_password").attr("disabled", "disabled");
                $("#wfsys_user_password").val('');
                $("#wfsys_user_password").css("background","gray");

            }
            else
            {
                $("#wfsys_user_password").removeAttr("disabled");
                $("#wfsys_user_password").removeAttr("style");
                $("#wfsys_user_password").setAttribute("disabled", false);
            }
        }
        
        $(document).ready(function () {
            
            $('#form_usercontrol').dialog({
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
            $('#usercontrol_usercontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#wfsys_user_last_login').datetimepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy", timeFormat: 'hh:mm:ss' <?php if (isset($sys_user_last_login)) { ?> , currentText: "<?php echo $sys_user_last_login; ?>" <?php } ?>});
            
            //$('.user_last_login').datetimepicker();
            //$('#user_last_login').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($usercontrol_tanggal_lahir)) { ?> , currentText: "<?php echo $usercontrol_tanggal_lahir; ?>" <?php } ?>});
            //$('#usercontrol_tanggal_kerja').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($usercontrol_tanggal_lamar)) { ?> , currentText: "<?php echo $usercontrol_tanggal_kerja; ?>" <?php } ?>});
            //$('#usercontrol_selesai').datepicker({yearRange: "-100:+0",changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd" <?php if (isset($selesai)) { ?> , currentText: "<?php echo $selesai; ?>" <?php } ?>});
        });
	
        function fusercontrol_send(){
            showLoading();
            str = $("#usercontrol_usercontrol").serialize();
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
                        $('#form_usercontrol').dialog('close');
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