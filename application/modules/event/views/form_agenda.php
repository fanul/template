<div id="form_agendacontrol">
    <form id="agendacontrol_agendacontrol" class="da-form" action="javascript:fagendacontrol_send();">

        <div class="da-form-inline">

            <div class="da-form-row">
                <label>Tipe Event</label>
                <div class="da-form-item">
                    <select data-bvalidator="required,cekcombo"  id="box_event_type_id" name="box_event_type_id">
                        <?php
                        $data = $this->data_master->event_type_list();
                        foreach ($data as $row) {
                            $selected = "";
                            if (isset($event_type_id)) {
                                if ($row->event_type_id == $event_type_id)
                                    $selected = "selected";
                            }
                            echo "<option value='$row->event_type_id' $selected>$row->event_type_name</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="da-form-row">
                <label>Nama Agenda</label>
                <div class="da-form-item">
                    <input value="<?php
                        if (isset($agenda_name))
                            echo $agenda_name;
                        ?>" type="text" name="box_agenda_name" id="box_agenda_name" data-bvalidator="required" >
                </div>
            </div>

            <div class="da-form-row">
                <label>Detail Agenda</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($agenda_det))
                               echo $agenda_det;
                        ?>" type="text" name="box_agenda_det" id="box_agenda_det" data-bvalidator="required" >
                </div>
            </div>

            <div class="da-form-row">
                <label>Agenda Mulai</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($agenda_start_date_indo))
                               echo $agenda_start_date_indo;
                        ?>" type="text" name="box_agenda_start_date_indo" id="box_agenda_start_date_indo" data-bvalidator=""  size="40">
                </div>
            </div>

            <div class="da-form-row">
                <label>Agenda Berakhir</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($agenda_end_date_indo))
                               echo $agenda_end_date_indo;
                        ?>" type="text" name="box_agenda_end_date_indo" id="box_agenda_end_date_indo" data-bvalidator="" size="40">
                </div>
            </div>

            <div class="da-form-row">
                <label>Biaya Agenda</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($agenda_cost))
                               echo $agenda_cost;
                        ?>" type="text" name="box_agenda_cost" id="box_agenda_cost" data-bvalidator="required" >
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
            $('#agendacontrol_agendacontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#box_agenda_start_date_indo').datetimepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy", timeFormat: 'hh:mm:ss' <?php if (isset($agenda_last_login)) { ?> , currentText: "<?php echo $agenda_last_login; ?>" <?php } ?>});
            $('#box_agenda_end_date_indo').datetimepicker({yearRange: "-30:+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy", timeFormat: 'hh:mm:ss' <?php if (isset($agenda_last_login)) { ?> , currentText: "<?php echo $agenda_last_login; ?>" <?php } ?>});
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