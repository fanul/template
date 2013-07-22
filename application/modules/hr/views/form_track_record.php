<div id="form_track_recordcontrol">

    <form id="track_recordcontrol_track_recordcontrol" class="da-form" action="javascript:ftrack_recordcontrol_send();">

        <?php if (isset($form)) echo $form; ?>
        <input type="hidden" value="<?php if (isset($hr_track_record_id)) echo $hr_track_record_id; ?>" name="box_track_record_id" id="box_track_record_id">

        <div class="da-form-inline">

            <div class="da-form-row">
                <label>Tipe Track Record</label>
                <div class="da-form-item">
                    <select data-bvalidator="required,cekcombo"  id="box_track_type_id" name="box_track_type_id">
                        <?php
                        $data = $this->data_master->track_type_list();
                        foreach ($data as $row) {
                            $selected = "";
                            if (isset($hr_track_type_id)) {
                                if ($row->hr_track_type_id == $hr_track_type_id)
                                    $selected = "selected";
                            }
                            echo "<option value='$row->hr_track_type_id' $selected>$row->hr_track_type_name</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>


                <div class="da-form-row">
                    <label>Nama</label>
                    <div class="da-form-item">
                        <input value="<?php
                        if (isset($hr_track_record_name))
                            echo $hr_track_record_name;
                        ?>" type="text" name="box_track_record_name" id="box_track_record_name" data-bvalidator="required">
                    </div>
                </div>



                <div class="da-form-row">
                    <label>Tanggal</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_track_record_date_indo))
                                   echo $hr_track_record_date_indo;
                        ?>" size="40" type="text" name="box_track_record_date_indo" id="box_track_record_date_indo" data-bvalidator="">
                    </div>
                </div>



                <div class="da-form-row">
                    <label>Keterangan</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_track_record_det))
                                   echo $hr_track_record_det;
                        ?>" size="40" type="text" name="box_track_record_det" id="box_track_record_det" data-bvalidator="">
                    </div>
                </div>



                <div class="da-form-row">
                    <label>Point</label>
                    <div class="da-form-item">
                        <input value="<?php
                               if (isset($hr_track_record_point))
                                   echo $hr_track_record_point;
                        ?>" type="text" name="box_track_record_point" id="box_track_record_point" data-bvalidator="">
                    </div>
                </div>


                <div class="da-form-row">
                    <label>Validasi</label>
                    <div class="da-form-item">
                        <input value="<?php
                               $checked = "checked=checked";
                               if (isset($hr_track_record_need_valid) && ($hr_track_record_need_valid == '' || $hr_track_record_need_valid == '0' || $hr_track_record_need_valid == 0))
                                   $checked = "";
                        ?>" <?php echo $checked; ?> onchange="checkBoxNeedValid()" type="checkbox" name="hr_track_record_need_valid" id="hr_track_record_need_valid">
                    </div>
                </div>


            <input <?php if (isset($hr_track_record_pict)) { ?> value="<?php echo $hr_track_record_pict; ?>" <?php } ?> type="hidden" name="box_track_record_pict" id="box_track_record_pict">

            <div class="da-button-row">
                <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
            </div>

        </div>
    </form>

    <script type="text/javascript" >

        function checkBoxNeedValid()
        {
            var isChecked = $('#hr_track_record_need_valid').attr('checked')?true:false;
            
            if(!isChecked)
            {
                $("#hr_track_record_valid").attr("disabled", "disabled");
                $("#hr_track_record_valid").val('');
                $("#hr_track_record_valid").css("background","gray");

            }
            else
            {
                $("#hr_track_record_valid").removeAttr("disabled");
                $("#hr_track_record_valid").removeAttr("style");
                $("#hr_track_record_valid").setAttribute("disabled", false);
            }
        }

        $(window).resize(function() {
            $('#form_track_recordcontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_track_recordcontrol').dialog({
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
            $('#track_recordcontrol_track_recordcontrol').bValidator();
            
            //datepicker
            $('#box_track_record_date_indo').datepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy" <?php if (isset($hr_track_record_enter_date)) { ?> , currentText: "<?php echo $hr_track_record_enter_date; ?>" <?php } ?>});

        });
	
        function ftrack_recordcontrol_send(){
            showLoading();
            str = $("#track_recordcontrol_track_recordcontrol").serialize();
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
                        $('#form_track_recordcontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-track_recordcontrol").flexReload();
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
                $("#track_record_pict_show").html($(this));
                $(this).fadeIn();
            }).attr('src', 'userpict/'+pictureUrl)
            .attr('width', '270')
            .error(function(){
                alert("Failed to show pict");
            });
            document.getElementById('box_track_record_pict').value = pictureUrl;
        }
        
        function startUpload(){
            $("#user_pict_show").html("loading...");
        }

    </script>
</div>