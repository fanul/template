<div id="form_profilecontrol">

    <div class="da-form">
        <div class="da-form-inline">
            <form name="formupload" id="formupload" method="post" enctype="multipart/form-data" action="<?php echo site_url('/public/pict/upload'); ?>" target="upload-frame" onsubmit="javascript:startUpload();" >
                <div class="da-form-row">
                    <label>Foto</label>
                    <div class="da-form-item">

                        <input name="userfile" type="file" class="file ui-widget-content ui-corner-all" />
                        <input type="hidden" value="<?php if (isset($hr_user_id)) echo $hr_user_id; ?>" name="box_user_id" id="box_user_id">
                        <input type="submit" name="submit" class="da-button green" id="submit" name="submit" value="upload"></td>

                        &nbsp;<br>&nbsp;<br>


                        <div id="employee_pict_show"> 
                            <div align="center"><img <?php if (isset($hr_employee_pict)) { ?>src="<?php echo base_url(); ?>userpict/<?php echo $hr_employee_pict; ?>" <?php } ?> height="150" width="110" /> </div>
                        </div>
                        <iframe name="upload-frame" id="upload-frame" style="display:none;">
                        </iframe>

                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="da-form">
        <div class="da-form-inline">
            <form class="da-form" id="employeecontrol_employeecontrol"  action="javascript:fprofilecontrol_send();">
                <?php
                if (isset($form)) {
                    echo $form;
                }
                ?>
                <input type="hidden" value="<?php if (isset($hr_employee_nik)) echo $hr_employee_nik; ?>" name="box_employee_nik_old" id="box_employee_nik_old">

                <div class="da-form-row">
                    <label>NIK</label>
                    <div class="da-form-item">
                        <input value="<?php
                if (isset($hr_employee_nik))
                    echo $hr_employee_nik;
                ?>" type="text" name="box_employee_nik" id="box_employee_nik" data-bvalidator="required">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Nama Lengkap</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_full_name))
                                   echo $hr_employee_full_name;
                ?>" size="40" type="text" name="box_employee_full_name" id="box_employee_full_name" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Nomor KTP</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_ktp))
                                   echo $hr_employee_ktp;
                ?>" type="text" name="box_employee_ktp" id="box_employee_ktp" data-bvalidator="required" >
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Nama Panggilan</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_nick_name))
                                   echo $hr_employee_nick_name;
                ?>" type="text" name="box_employee_nick_name" id="box_employee_nick_name" data-bvalidator="required">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Alamat</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_address))
                                   echo $hr_employee_address;
                ?>" size="40" type="text" name="box_employee_address" id="box_employee_address" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Gaji</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_salary))
                                   echo $hr_employee_salary;
                ?>" size="40" type="text" name="box_employee_salary" id="box_employee_salary" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Nomor Telepon</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_phone))
                                   echo $hr_employee_phone;
                ?>" size="40" type="text" name="box_employee_phone" id="box_employee_phone" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>HP</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_hp))
                                   echo $hr_employee_hp;
                ?>" size="40" type="text" name="box_employee_hp" id="box_employee_hp" data-bvalidator="" >
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Tempat Lahir</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_birth_place))
                                   echo $hr_employee_birth_place;
                ?>" size="40" type="text" name="box_employee_birth_place" id="box_employee_birth_place" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Email</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_email))
                                   echo $hr_employee_email;
                ?>" size="40" type="text" name="box_employee_email" id="box_employee_email" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Tanggal Lahir</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_birth_date))
                                   echo $hr_employee_birth_date;
                ?>" size="40" type="text" name="box_employee_birth_date" id="box_employee_birth_date" data-bvalidator="" >
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Tanggal Masuk Kerja</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_enter_date))
                                   echo $hr_employee_enter_date;
                ?>" size="40" type="text" name="box_employee_enter_date" id="box_employee_enter_date" data-bvalidator="required" >
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Tanggal Keluar Karyawan</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_employee_out_date))
                                   echo $hr_employee_out_date;
                ?>" size="40" type="text" name="box_employee_out_date" id="box_employee_out_date" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Status</label>
                    <div class="da-form-item">
                        <select data-bvalidator="required,cekcombo"  id="box_employee_status" name="box_employee_status" class="text ui-widget-content ui-corner-all">
                            <?php
                            $data = $this->data_master->change_status();
                            foreach ($data as $key => $value) {
                                $selected = "";
                                if (isset($hr_employee_status)) {
                                    if ($value == $hr_employee_status)
                                        $selected = "selected";
                                }
                                echo "<option value='$key' $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <input <?php if (isset($hr_employee_pict)) { ?> value="<?php echo $hr_employee_pict; ?>" <?php } ?> type="hidden" name="box_employee_pict" id="box_employee_pict">

                <div class="da-button-row">
                    <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
                </div>

            </form>
        </div>
    </div>

    <script type="text/javascript" >

        $(window).resize(function() {
            $('#form_profilecontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_profilecontrol').dialog({
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
            $('#employeecontrol_employeecontrol').bValidator();
            
            //datepicker
            $('#box_employee_enter_date').datepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy" <?php if (isset($sys_employee_enter_date)) { ?> , currentText: "<?php echo $sys_employee_enter_date; ?>" <?php } ?>});
            $('#box_employee_out_date').datepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy" <?php if (isset($sys_employee_out_date)) { ?> , currentText: "<?php echo $sys_employee_out_date; ?>" <?php } ?>});
            $('#box_employee_birth_date').datepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy" <?php if (isset($sys_employee_birth_date)) { ?> , currentText: "<?php echo $sys_employee_birth_date; ?>" <?php } ?>});

        });
	
        function fprofilecontrol_send(){
            showLoading();
            str = $("#employeecontrol_employeecontrol").serialize();
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
                        $('#form_profilecontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-profilecontrol").flexReload();
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

        function displayPicture(pictureUrl){
            
            var img = new Image();
            $(img).load(function(){
                $(this).hide();
                $("#profile_pict_show").html($(this));
                $(this).fadeIn();
            }).attr('src', 'userpict/'+pictureUrl)
            .attr('width', '270')
            .error(function(){
                alert("Failed to show pict");
            });
            document.getElementById('box_profile_pict').value = pictureUrl;
        }
        
        function startUpload(){
            $("#user_pict_show").html("loading...");
        }

    </script>
</div>