<div id="form_accesscontrol">
    <form id="accesscontrol_accesscontrol" class="da-form" action="javascript:faccesscontrol_send();">

        <div class="da-form-inline">

            <input type="hidden" value="<?php if (isset($sys_group_id)) echo $sys_group_id; ?>" name="box_group_id" id="box_group_id">

            <div class="da-form-row">
                <label>Privillage</label>
                <div class="da-form-item large">
                    <select data-bvalidator="required"  id="box_group_privillage" name="box_group_privillage" onchange="change_page()">
                        <?php
                        $data = $this->data_master->list_master_dir();
                        foreach ($data as $key => $value) {
                            $selected = "";
                            if (isset($sys_group_status)) {
                                if ($value == $sys_group_status)
                                    $selected = "selected";
                            }
                            echo "<option value='$value' $selected>$value</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="da-form-row">
                <label>Page</label>
                <div class="da-form-item large">
                    <select data-bvalidator="required"  id="box_group_page" name="box_group_page" onchange="change_function()">
                    </select>
                </div>
            </div>

            <!--            <div class="da-form-row">
                            <label>Function</label>
                            <div class="da-form-item large">
                                <select data-bvalidator="required,cekcombo"  id="box_group_function" name="box_group_function" >
                                </select>
                            </div>
                        </div>-->

            <div class="da-form-row da-form-block">
                <label>Function</label>
                <div class="da-form-item large">
                    <div id="pick_trouble" style="min-width: 400px">
                        <select id="da-ex-picklist" name="da-ex-picklist[]" multiple="multiple">
                        </select>
                    </div>
                </div>
            </div>

            <div class="da-button-row">
                <input type="submit" name="submit" class="hasDatepicker da-button blue" id="submit" name="submit" value="<?php echo $tombol; ?>"></td>
            </div>

        </div>




    </form>

    <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
        <div class="ui-dialog-buttonset">
            <button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                <span class="ui-button-text">Submit</span>
            </button>
        </div>
    </div>
    <script type="text/javascript" >

        $(window).resize(function() {
            $('#form_accesscontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            $('#form_accesscontrol').dialog({
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
            $('#accesscontrol_accesscontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#user_last_login').datetimepicker();

            $('#da-ex-picklist').daPickList();
        });
	
        function change_page()
        {
            var dir = $('#box_group_privillage').find('option:selected').text();
            nocache = Math.random();
            var dataString = 'dir='+dir+'&nocache='+nocache;
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/access/prepare_page'); ?>',
                data: dataString,
                cache: false,
                success: function(html){
                    $("#box_group_page").html(html);
                    change_function();

                },
                error:function(xhr,ajaxOptions,thrownError){
                    hideLoading();
                    ajaxError(xhr,ajaxOptions,thrownError);
                }
            });
                        
        }
        
        function change_function()
        {
            var dir = $('#box_group_privillage').find('option:selected').text();
            var page = $('#box_group_page').find('option:selected').text();
            var id = $('#box_group_id').val();
            nocache = Math.random();
            var dataString = 'dir='+dir+'&page='+page+'&nocache='+nocache+'&id='+id;
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/access/prepare_function'); ?>',
                data: dataString,
                cache: false,
                success: function(html){
                    //$("#box_group_function").html(html);
                    $('#pick_trouble').empty();
                    $('#pick_trouble').append('<select id="da-ex-picklist" multiple="multiple"></select>');
                    $('#da-ex-picklist').html(html);
                    $('#da-ex-picklist').daPickList();
                    
                    $('#da-ex-picklist').find('option:selected').each(function(){
                        //$(this).daPickList().ins
                        var removeVal = $(this).val();
                        var removedElement;
                        $('.pickList_sourceList li').each(function(){
                            if($(this).text()==removeVal)
                            {
                                removedElement = $(this).get();
                                $(this).remove();                        
                                $("#tabel-accesscontrol").flexReload();
                            }
                        });
                        $('.pickList_targetList').append(removedElement);
                        
                    });

                },
                error:function(xhr,ajaxOptions,thrownError){
                    hideLoading();
                    ajaxError(xhr,ajaxOptions,thrownError);
                }
            });

        }
        
        function faccesscontrol_send(){
            showLoading();
            var acc = '';
            $('#da-ex-picklist').find('option:selected').each(function(){
                acc += $(this).val() + ',';
            });
            acc = acc.substring(0,acc.length-1);
            str = $("#accesscontrol_accesscontrol").serialize();
            nocache = Math.random();
            var dataString = str+'&nocache='+nocache+'&acc='+acc;
            $.ajax({
                type: 'POST',
                url: '<?php echo $send_url; ?>',
                data: dataString,
                cache: false,
                success: function(html){
                    if (html == 'ok'){
                        hideLoading();
                        $('#form_accesscontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-accesscontrol").flexReload();
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