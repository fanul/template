<div id="family">
    <form id="searchfamilycontrol"> 
        <?php if (isset($form_main)) echo $form_main; ?>
        <input id="id" name="id" type="hidden" value=""/> 
    </form> 
    <table id="tabel-familycontrol" style="display:none;">
    </table>
    <script type="text/javascript" >
        var id;
        function datafamilycontrol(com,grid){
                                    
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
                        url: '<?php echo site_url("hr/family/prepare_status"); ?>',
                        data: dataString,
                        cache: false,
                        success: function(html){
                            if(html!='')
                            {
                                hideLoading();
                                $('body').append(html);
                            } else alert('anda tidak mempunyai akses');
                        },
                        error:function(xhr,ajaxOptions,thrownError){
                            ajaxError(xhr,ajaxOptions,thrownError);
                        }			
                    })
                }
            }
                                    
            if (com=='Tambah Data'){
                showLoading();
                var nocache = Math.random();
                var id = $('#form_main').val();
                var dataString = 'id='+id+'&nocache='+nocache;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url("hr/family/prepare_add"); ?>',
                    data: dataString,
                    cache: false,
                    success: function(html){
                        if(html!='')
                        {
                            hideLoading();
                            $('body').append(html);
                        } else alert('anda tidak mempunyai akses');
                    },
                    error:function(xhr,ajaxOptions,thrownError){
                        ajaxError(xhr,ajaxOptions,thrownError);
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
                        url: '<?php echo site_url("hr/family/prepare_edit"); ?>',
                        data: dataString,
                        cache: false,
                        success: function(html){
                            if(html!='')
                            {
                                hideLoading();
                                $('body').append(html);
                            } else alert('anda tidak mempunyai akses');
                        },
                        error:function(xhr,ajaxOptions,thrownError){
                            ajaxError(xhr,ajaxOptions,thrownError);
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
                        url: '<?php echo site_url("hr/family/prepare_delete"); ?>',
                        data: dataString,
                        cache: false,
                        success: function(html){
                            if(html!='')
                            {
                                hideLoading();
                                $('body').append(html);
                            } else alert('anda tidak mempunyai akses');
                        },
                        error:function(xhr,ajaxOptions,thrownError){
                            ajaxError(xhr,ajaxOptions,thrownError);
                        }			
                    })
                }
            }
                        
            if (com=='Input Keluarga')
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
                        url: '<?php echo site_url("hr/family"); ?>',
                        data: dataString,
                        cache: false,
                        success: function(html){
                            if(html!=''){
                                $('html').append(html);
                                $('#family').dialog({
                                    close: function(event, ui) {$(this).remove()},
                                    position: ['auto', 65],
                                    draggable: false,
                                    show: 'fade',
                                    hide: 'fade',
                                    title: 'Daftar Detail Peringatan',
                                    resizable: false,
                                    closeOnEscape: false,
                                    modal: true,
                                    width: 900
                                }); } else alert('anda tidak mempunyai akses');
                        },
                        error:function(xhr,ajaxOptions,thrownError){
                            ajaxError(xhr,ajaxOptions,thrownError);
                        }			
                    })
                }
            }
                        
            if (com=='Detail')
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
                    loadPage('#da-content-wrap', '<?php echo site_url("hr/family/prepare_detail"); ?>', 'id='+id)
                }
            }
                    
        }

    </script>
    <?php
    echo $js_grid;
    ?>
</div>