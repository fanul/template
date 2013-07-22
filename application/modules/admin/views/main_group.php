
    <div id="da-content-area">

        <div class="grid_2">
            <div class="da-panel collapsible <?php if (isset($collapsed)) echo ''; else echo 'collapsed'; ?> ">
                <div class="da-panel-header">
                    <span class="da-panel-title">Advanced Search</span>
                    <span class="da-panel-toggler"></span>
                </div>
                <div class="da-panel-content">
                    <div id="advanced-search">
                        <form id="sform" name="sform">
                            <p style="margin-left: 20px; padding-top: 20px">
                                Nama 
                                <select id="name_selector" name="name_selector">
                                    <option value="lk">Mengandung Kata</option>
                                    <option value="nlk">Tidak Mengandung Kata</option>
                                    <option value="eq">Sama Dengan</option>
                                    <option value="neq">Tidak Sama Dengan</option>
                                    <option value="gt">Lebih Besar</option>
                                    <option value="lt">Lebih Kecil</option>
                                </select>
                                <input type="text" id="sys_group_name" name="sys_group_name" value="<?php if (isset($sys_group_name)) echo $sys_group_name; ?>" autocomplete="off" /><br />
                            </p>
                            <p style="margin-left: 20px">
                                Detail
                                <select id="detail_selector" name="detail_selector">
                                    <option value="lk">Mengandung Kata</option>
                                    <option value="nlk">Tidak Mengandung Kata</option>
                                    <option value="eq">Sama Dengan</option>
                                    <option value="neq">Tidak Sama Dengan</option>
                                    <option value="gt">Lebih Besar</option>
                                    <option value="lt">Lebih Kecil</option>
                                </select>
                                <input type="text" id="sys_group_detail" name="sys_group_detail" value="<?php if (isset($sys_group_detail)) echo $sys_group_detail; ?>" autocomplete="off" /><br />
                            </p>
                            <p>
                                <span style="margin-left: 300px">
                                    <input type="reset" value="Reset" onclick="javascript:loadPage('#da-content-wrap','<?php echo site_url("admin/group") ?>')" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"/> 
                                    <input type="submit" value="Submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"/> 
                                </span>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid_4">
            <div class="da-panel">
                <div class="da-panel-header">
                    <div class="da-panel-title"><?php if (isset($title)) echo $title; ?></div>
                </div>
                <div class="da-panel-content">
                    <div id="groupcontrol">
                        <form id="searchgroupcontrol"> 
                            <input id="id" name="id" type="hidden" value=""/> 
                        </form> 
                        <table id="tabel-groupcontrol" style="display:none;">
                        </table>
                        <script type="text/javascript" >
                            var id;
                                                                
                            //for advanced filtering
                            $(document).ready(function(){
                                                                
                                $('#name_selector').val('<?php if (isset($name_selector)) echo $name_selector; else echo ''; ?>').attr('selected','selected');
                                $('#detail_selector').val('<?php if (isset($detail_selector)) echo $detail_selector; else echo ''; ?>').attr('selected','selected');

                            });
                                                                
                            $('#sform').submit(function (){
                                                                                        
                                var str = $("#sform").serialize();
                                $('#da-content-wrap').html("<center><img src='"+mainURL+"images/load.gif'/></center>");
                                $.ajax({
                                    type: "POST",
                                    url: '<?php echo site_url("admin/group"); ?>',
                                    data: str + '&nocache=' + Math.random(),
                                    success: function(html){
                                        $('#da-content-wrap').html(html);
                                    },
                                    error: function(xadmin,ajaxOptions,tadminownError){
                                        ajaxError(xadmin,ajaxOptions,tadminownError);
                                    }
                                });	
                                return false;
                            });
                                                
                                                
                            function datagroupcontrol(com,grid){
                                                                                    
                                if (com=='Pilih Semua')
                                {
                                    $('.bDiv tbody tr',grid).addClass('trSelected');
                                }
                                                                
                                if (com=='Reset Pilihan')
                                {
                                    $('.bDiv tbody tr',grid).removeClass('trSelected');
                                }
                                                                                    
                                if (com=='Ganti Status')
                                {
                                    items = $('.trSelected',grid);
                                    if (items.length == 0){
                                        //showError('Pilih salah satu data terlebih dahulu');
                                        alert('Pilih salah satu data terlebih dahulu');
                                    }else{
                                        var ids = '';
                                        for(var i=0; i<items.length; i++)
                                        {
                                            idData = items[i].getElementsByTagName("td");
                                            id = idData[0].firstChild.innerHTML;
                                            ids += id + '|';
                                        }
                                        var nocache = Math.random();
                                        var dataString = 'ids='+ids+'&nocache='+nocache;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo site_url("admin/group/prepare_status"); ?>',
                                            data: dataString,
                                            cache: false,
                                            success: function(html){
                                                if(html!='')
                                                {
                                                    hideLoading();
                                                    $('body').append(html);
                                                } else alert('anda tidak mempunyai akses');
                                            },
                                            error:function(xadmin,ajaxOptions,tadminownError){
                                                ajaxError(xadmin,ajaxOptions,tadminownError);
                                            }			
                                        })
                                    }
                                }
                                                                                    
                                if (com=='Tambah Data'){
                                    showLoading();
                                    var nocache = Math.random();
                                    var dataString = 'nocache='+nocache;
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo site_url("admin/group/prepare_add"); ?>',
                                        data: dataString,
                                        cache: false,
                                        success: function(html){
                                            if(html!='')
                                            {
                                                hideLoading();
                                                $('body').append(html);
                                            } else alert('anda tidak mempunyai akses');
                                        },
                                        error:function(xadmin,ajaxOptions,tadminownError){
                                            ajaxError(xadmin,ajaxOptions,tadminownError);
                                        }			
                                    })
                                }
                                if (com=='Edit Data')
                                {
                                    items = $('.trSelected',grid);
                                    if (items.length == 0){
                                        //showError('Pilih salah satu data terlebih dahulu');
                                        alert('Pilih Salah Satu data Terlebih dahulu');
                                    }
                                    else if(items.length > 1)
                                    {
                                        alert('Pilih Salah Satu Saja');
                                    }
                                    else{
                                        idData = items[0].getElementsByTagName("td");
                                        id = idData[0].firstChild.innerHTML;
                                        var nocache = Math.random();
                                        var dataString = 'id='+id+'&nocache='+nocache;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo site_url("admin/group/prepare_edit"); ?>',
                                            data: dataString,
                                            cache: false,
                                            success: function(html){
                                                if(html!='')
                                                {
                                                    hideLoading();
                                                    $('body').append(html);
                                                } else alert('anda tidak mempunyai akses');
                                            },
                                            error:function(xadmin,ajaxOptions,tadminownError){
                                                ajaxError(xadmin,ajaxOptions,tadminownError);
                                            }			
                                        })
                                    }
                                }
                                                                
                                if (com=='Hapus Data')
                                {
                                    items = $('.trSelected',grid);
                                    if (items.length == 0){
                                        showError('Pilih salah satu data terlebih dahulu');
                                    }else{
                                                                                                
                                        var ids = '';
                                        for(var i=0; i<items.length; i++)
                                        {
                                            idData = items[i].getElementsByTagName("td");
                                            id = idData[0].firstChild.innerHTML;
                                            ids += id + '|';
                                        }

                                        var nocache = Math.random();
                                        var dataString = 'ids='+ids+'&nocache='+nocache;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo site_url("admin/group/prepare_delete"); ?>',
                                            data: dataString,
                                            cache: false,
                                            success: function(html){
                                                if(html!='')
                                                {
                                                    hideLoading();
                                                    $('body').append(html);
                                                } else alert('anda tidak mempunyai akses');
                                            },
                                            error:function(xadmin,ajaxOptions,tadminownError){
                                                ajaxError(xadmin,ajaxOptions,tadminownError);
                                            }			
                                        })
                                    }
                                }
                                                                        
                                if (com=='Print')
                                {
                                    items = $('.trSelected',grid);
                                    if (items.length == 0){
                                        alert('Pilih salah satu data terlebih dahulu');
                                        //showError('Pilih salah satu data terlebih dahulu');
                                    }
                                    else if(items.length > 1)
                                    {
                                        alert('Pilih Salah Satu Saja');
                                    }
                                    else{
                                                                	
                                        idData = items[0].getElementsByTagName("td");
                                        id = idData[0].firstChild.innerHTML;
                                        var nocache = Math.random();
                                        var dataString = 'id='+id+'&nocache='+nocache;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo site_url("admin/group/prepare_print"); ?>',
                                            data: dataString,
                                            cache: false,
                                            success: function(html){
                                                if(html!='')
                                                {
                                                    hideLoading();
                                                    $('body').append(html);
                                                } else alert('anda tidak mempunyai akses');
                                            },
                                            error:function(xadmin,ajaxOptions,tadminownError){
                                                ajaxError(xadmin,ajaxOptions,tadminownError);
                                            }			
                                        })
                                    }
                                }
                                             
                                if (com=='Access')
                                {
                                    items = $('.trSelected',grid);
                                    if (items.length == 0){
                                        //showError('Pilih salah satu data terlebih dahulu');
                                        alert('Pilih Salah Satu data Terlebih dahulu');
                                    }
                                    else if(items.length > 1)
                                    {
                                        alert('Pilih Salah Satu Saja');
                                    }
                                    else{
                                        idData = items[0].getElementsByTagName("td");
                                        id = idData[0].firstChild.innerHTML;
                                        //alert(id);
                                        var nocache = Math.random();
                                        var dataString = 'id='+id+'&nocache='+nocache;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo site_url("admin/access"); ?>',
                                            data: dataString,
                                            cache: false,
                                            success: function(html){
                                                if(html!=''){
                                                    $('html').append(html);
                                                    $('#access').dialog({
                                                        close: function(event, ui) {$(this).remove()},
                                                        position: ['auto', 65],
                                                        draggable: false,
                                                        show: 'fade',
                                                        hide: 'fade',
                                                        title: 'Daftar Akses',
                                                        resizable: false,
                                                        closeOnEscape: false,
                                                        modal: true,
                                                        width: 900
                                                    });
                                                } else alert('anda tidak mempunyai akses');
                                            },
                                            error:function(xhr,ajaxOptions,thrownError){
                                                ajaxError(xhr,ajaxOptions,thrownError);
                                            }			
                                        })
                                    }
                                }
                                             
                            }

                        </script>
                        <?php
                        echo $js_grid;
                        ?>
                    </div>
                    <div id="tambah">

                    </div>

                </div>

            </div>
        </div>

        <div class="clear"></div>