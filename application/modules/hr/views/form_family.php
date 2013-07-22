<div id="form_familycontrol">

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


                        <div id="family_pict_show"> 
                            <div align="center"><img <?php if (isset($hr_family_pict)) { ?>src="<?php echo base_url(); ?>userpict/<?php echo $hr_family_pict; ?>" <?php } ?> height="150" width="110" /> </div>
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
            <form class="da-form" id="familycontrol_familycontrol"  action="javascript:ffamilycontrol_send();">
                <?php if (isset($form)) echo $form; ?>
                <input type="hidden" value="<?php if (isset($hr_family_id)) echo $hr_family_id; ?>" name="box_family_id" id="box_family_id">


                <div class="da-form-row">
                    <label>Hubungan</label>
                    <div class="da-form-item">
                        <select data-bvalidator="required,cekcombo"  name="box_family_relation" class="text ui-widget-content ui-corner-all">
                            <?php
                            $data = $this->data_master->relation();
                            foreach ($data as $key => $value) {
                                $selected = "";
                                if (isset($hr_family_relation))
                                    if ($hr_family_relation == $key)
                                        $selected = "selected";
                                echo "<option value='$key' $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Nama Lengkap</label>
                    <div class="da-form-item">
                        <input value="<?php
                            if (isset($hr_family_full_name))
                                echo $hr_family_full_name;
                            ?>" size="40" type="text" name="box_family_full_name" id="box_family_full_name" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Nomor KTP</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_ktp))
                                   echo $hr_family_ktp;
                            ?>" type="text" name="box_family_ktp" id="box_family_ktp" data-bvalidator="required" >
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Nama Panggilan</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_nick_name))
                                   echo $hr_family_nick_name;
                            ?>" type="text" name="box_family_nick_name" id="box_family_nick_name" data-bvalidator="required">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Alamat</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_address))
                                   echo $hr_family_address;
                            ?>" size="40" type="text" name="box_family_address" id="box_family_address" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Nomor Telepon</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_phone))
                                   echo $hr_family_phone;
                            ?>" size="40" type="text" name="box_family_phone" id="box_family_phone" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>HP</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_hp))
                                   echo $hr_family_hp;
                            ?>" size="40" type="text" name="box_family_hp" id="box_family_hp" data-bvalidator="" >
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Tempat Lahir</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_birth_place))
                                   echo $hr_family_birth_place;
                            ?>" size="40" type="text" name="box_family_birth_place" id="box_family_birth_place" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Email</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_email))
                                   echo $hr_family_email;
                            ?>" size="40" type="text" name="box_family_email" id="box_family_email" data-bvalidator="">
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Tanggal Lahir</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_birth_date))
                                   echo $hr_family_birth_date;
                            ?>" size="40" type="text" name="box_family_birth_date" id="box_family_birth_date" data-bvalidator="" >
                    </div>
                </div>

                <div class="da-form-row">
                    <label>Pekerjaan</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_family_job))
                                   echo $hr_family_job;
                            ?>" type="text" name="box_family_job" id="box_family_job" data-bvalidator="">
                    </div>
                </div>

                <input <?php if (isset($hr_family_pict)) { ?> value="<?php echo $hr_family_pict; ?>" <?php } ?> type="hidden" name="box_family_pict" id="box_family_pict">

                <div class="da-button-row">
                    <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
                </div>

            </form>
        </div>
    </div>

    <script type="text/javascript" >

        $(window).resize(function() {
            $('#form_familycontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_familycontrol').dialog({
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
            $('#familycontrol_familycontrol').bValidator();
            
            //datepicker
            $('#box_family_enter_date').datepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy" <?php if (isset($hr_family_enter_date)) { ?> , currentText: "<?php echo $hr_family_enter_date; ?>" <?php } ?>});
            $('#box_family_out_date').datepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy" <?php if (isset($hr_family_out_date)) { ?> , currentText: "<?php echo $hr_family_out_date; ?>" <?php } ?>});
            $('#box_family_birth_date').datepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy" <?php if (isset($hr_family_birth_date)) { ?> , currentText: "<?php echo $hr_family_birth_date; ?>" <?php } ?>});

        });
	
        function ffamilycontrol_send(){
            showLoading();
            str = $("#familycontrol_familycontrol").serialize();
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
                        $('#form_familycontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-familycontrol").flexReload();
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
                $("#family_pict_show").html($(this));
                $(this).fadeIn();
            }).attr('src', 'userpict/'+pictureUrl)
            .attr('width', '270')
            .error(function(){
                alert("Failed to show pict");
            });
            document.getElementById('box_family_pict').value = pictureUrl;
        }
        
        function startUpload(){
            $("#user_pict_show").html("loading...");
        }

    </script>
</div>