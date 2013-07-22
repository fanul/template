<div id="form_usercontrol">
    <form id="usercontrol_usercontrol" class="da-form" action="javascript:fusercontrol_send();">
        <input type="hidden" value="<?php if (isset($sys_user_id)) echo $sys_user_id; ?>" name="box_user_id" id="box_user_id">

        <div class="da-form-inline">

            <div class="da-form-row">
                <label>Nama User</label>
                <div class="da-form-item">
                    <input value="<?php
if (isset($sys_user_name))
    echo $sys_user_name;
?>" type="text" name="box_user_name" id="box_user_name" data-bvalidator="required">
                </div>
            </div>

            <div class="da-form-row">
                <label>Default Password</label>
                <div class="da-form-item">
                    <input value="<?php
                           $checked = "checked=checked";
                           if (isset($sys_user_password))
                               $checked = "";
?>" <?php echo $checked; ?> onchange="checkCheckBox()" type="checkbox" name="checked" id="checked" >
                </div>
                <br>
                <label>Custom Password</label>
                <div class="da-form-item">
                    <input value="<?php
                           $disabled = 'disabled=disabled';
                           $background = 'gray';
                           if (isset($sys_user_password)) {
                               echo $sys_user_password;
                               $disabled = "";
                               $background = '';
                           }
?>" 
                           <?php echo $disabled; ?> type="password" name="box_user_password" id="box_user_password" data-bvalidator="required" size="40" style="background: <?php echo $background ?>">
                </div>
            </div>

            <div class="da-form-row">
                <label>Last Login</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($sys_user_last_login))
                               echo $sys_user_last_login;
                           ?>" type="text" name="box_user_last_login" id="box_user_last_login" data-bvalidator="" size="40">
                </div>
            </div>

            <div class="da-form-row">
                <label>Group</label>
                <div class="da-form-item">
                    <select data-bvalidator="required,cekcombo"  id="box_group_id" name="box_group_id">
                        <?php
                        $data = $this->data_master->group_list();
                        foreach ($data as $row) {
                            $selected = "";
                            if (isset($sys_group_id)) {
                                if ($row->sys_group_id == $sys_group_id)
                                    $selected = "selected";
                            }
                            echo "<option value='$row->sys_group_id' $selected>$row->sys_group_name</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="da-form-row">
                <label>Tipe</label>
                <select data-bvalidator="required,cekcombo"  id="box_user_type" name="box_user_type">
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
            
            if(isChecked)
            {
                $("#box_user_password").attr("disabled", "disabled");
                $("#box_user_password").val('');
                $("#box_user_password").css("background","gray");

            }
            else
            {
                $("#box_user_password").removeAttr("disabled");
                $("#box_user_password").removeAttr("style");
                $("#box_user_password").setAttribute("disabled", false);
            }
        }
        
        $(window).resize(function() {
            $('#form_usercontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_usercontrol').dialog({
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
            $('#usercontrol_usercontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#box_user_last_login').datetimepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy", timeFormat: 'hh:mm:ss' <?php if (isset($sys_user_last_login)) { ?> , currentText: "<?php echo $sys_user_last_login; ?>" <?php } ?>});
            
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