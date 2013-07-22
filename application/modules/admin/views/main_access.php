<div id="access">
    <form id="searchaccesscontrol"> 
        <?php if (isset($form_main)) echo $form_main; ?>
        <input id="id" name="id" type="hidden" value=""/> 
    </form> 
    <table id="tabel-accesscontrol" style="display:none;">
    </table>
    <script type="text/javascript" >
        var id;
        function dataaccesscontrol(com,grid){
                                    
            if (com=='Pilih Semua')
            {
                $('.bDiv tbody tr',grid).addClass('trSelected');
            }
                
            if (com=='Reset Pilihan')
            {
                $('.bDiv tbody tr',grid).removeClass('trSelected');
            }
            
            if (com=='Access'){
                showLoading();
                var id = $('#form_main').val();
                var nocache = Math.random();
                var dataString = 'id='+id+'&nocache='+nocache;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url("admin/access/prepare_access"); ?>',
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
                        url: '<?php echo site_url("admin/access/prepare_delete"); ?>',
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