<div id="news">
    <form id="searchnewscontrol"> 
        <?php if (isset($form_main)) echo $form_main; ?>
        <input id="id" name="id" type="hidden" value=""/> 
    </form> 
    <table id="tabel-newscontrol" style="display:none;">
    </table>
    <script type="text/javascript" >
        var id;
        function datanewscontrol(com,grid){
                                    
            if (com=='Pilih Semua')
            {
                $('.bDiv tbody tr',grid).addClass('trSelected');
            }
                
            if (com=='Reset Pilihan')
            {
                $('.bDiv tbody tr',grid).removeClass('trSelected');
            }
                                    
            if (com=='Tambah Data'){
                showLoading();
                var nocache = Math.random();
                var dataString = 'nocache='+nocache;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url("news/news/prepare_add"); ?>',
                    data: dataString,
                    cache: false,
                    success: function(html){
                        if(html!='')
                        {
                            hideLoading();
                            $('body').append(html);
                            var opts = {
                                height   : 300,
                                width    : 'auto',
                                fmAllow: true,
                                toolbar  : 'normal'
                            };
                            $("#da-ex-wysiwyg").elrte(opts);
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
                        url: '<?php echo site_url("news/news/prepare_edit"); ?>',
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
                        url: '<?php echo site_url("news/news/prepare_delete"); ?>',
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
                    
        }

    </script>
    <?php
    echo $js_grid;
    ?>
</div>