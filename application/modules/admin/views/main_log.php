

<div id="da-content-area">
    <div class="grid_4">
        <div class="da-panel">
            <div class="da-panel-header">
                <div class="da-panel-title"><?php if (isset($title)) echo $title; ?></div>
            </div>
            <div class="da-panel-content">

                <div id="logcontrol">
                    <form id="searchlogcontrol"> 
                        <input id="id" name="id" type="hidden" value=""/> 
                    </form> 
                    <table id="tabel-logcontrol" style="display:none;">
                    </table>
                    <script type="text/javascript" >
                        var id;
                        function datalogcontrol(com,grid){
                                        
                            if (com=='Pilih Semua')
                            {
                                $('.bDiv tbody tr',grid).addClass('trSelected');
                            }
                    
                            if (com=='Reset Pilihan')
                            {
                                $('.bDiv tbody tr',grid).removeClass('trSelected');
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
                                        url: '<?php echo site_url("admin/syslog/prepare_delete"); ?>',
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
                                        url: '<?php echo site_url("admin/syslog/prepare_print"); ?>',
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
                <div id="tambah">

                </div>

            </div>

        </div>
    </div>

    <div class="clear"></div>

