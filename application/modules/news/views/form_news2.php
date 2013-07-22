<div id="form_newscontrol">
    <form id="newscontrol_newscontrol" class="da-form" action="javascript:fnewscontrol_send();">

        <div class="da-form-inline">

            <input type="hidden" value="<?php if (isset($news_id)) echo $news_id; ?>" name="box_news_id" id="box_news_id">

            <div class="da-form-row">
                <label>Judul</label>
                <div class="da-form-item">
                    <input value="<?php
if (isset($news_title))
    echo $news_title;
?>" type="text" name="box_news_title" id="box_news_title" data-bvalidator="required" > 
                </div>
            </div>

            <div class="da-form-row">
                <label>Ditampilkan</label>
                <div class="da-form-item">
                    <input value="<?php
                           $checked = "checked=checked";
                           if (!isset($news_is_display)||$news_is_display==0)
                               $checked = "";
?>" <?php echo $checked; ?>  type="checkbox" name="box_is_display" id="box_is_display">
                </div>
            </div>

            <div class="da-form-row">
                <label>Periodik</label>
                <div class="da-form-item">
                    <input value="<?php
                           $checked = "checked=checked";
                           if (!isset($news_is_periodic)||$news_is_periodic==0)
                               $checked = "";
?>" <?php echo $checked; ?> type="checkbox" name="box_is_periodic" id="box_is_periodic" onchange="disable_date();">
                </div>
            </div>

            <div class="da-form-row">
                <label>Tanggal Mulai</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($news_start_date))
                               echo $news_start_date;
?>" type="text" name="box_news_start_date" id="box_news_start_date" data-bvalidator="cekcombo" > 
                </div>
            </div>

            <div class="da-form-row">
                <label>Tanggal Akhir</label>
                <div class="da-form-item">
                    <input value="<?php
                           if (isset($news_end_date))
                               echo $news_end_date;
?>" type="text" name="box_news_end_date" id="box_news_end_date" data-bvalidator="cekcombo" > 
                </div>
            </div>

            <div class="da-form-row">
                <label>Publik</label>
                <div class="da-form-item">
                    <input value="<?php
                           $checked = "checked=checked";
                           if (!isset($news_is_public)||$news_is_public==0)
                               $checked = "";
?>" <?php echo $checked; ?> type="checkbox" name="box_is_public" id="box_is_public">
                </div>
            </div>

            <br>

            <div class="da-form-row">
                <label>Function</label>
                <div class="da-form-item large">
                    <span class="formNote">Tekan Dan Tahan [ctrl] untuk memilih lebih dari 1</span>
                    <select data-placeholder="Your Favorite Football Team" class="chzn-select" multiple="" tabindex="-1" style="max-width: 350px">
                        <option value=""></option>
                        <optgroup label="NFC EAST">
                            <option>Dallas Cowboys</option>
                            <option>New York Giants</option>
                            <option>Philadelphia Eagles</option>
                            <option>Washington Redskins</option>
                        </optgroup>
                        <optgroup label="NFC NORTH">
                            <option>Chicago Bears</option>
                            <option>Detroit Lions</option>
                            <option>Green Bay Packers</option>
                            <option>Minnesota Vikings</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="da-form-row">
                <label>Berita</label>
                <div class="da-form-item large">
                    <textarea name="box_news_content" id="box_news_content"><?php if(isset($news_content)) echo $news_content;?></textarea>
                    <!-- <textarea id="box_old_content" style="display: none"></textarea> -->
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
            $('#form_newscontrol').dialog("option", "position", ['center', 'center']);
        });
        
        $(document).ready(function () {
            
            //var editor = new elRTE(document.getElementById('da-ex-wysiwyg'), opts);

            $('.chzn-select').chosen();

            $('#form_newscontrol').dialog({
                close: function(event, ui) {$(this).remove()},
                draggable: false,
                show: 'fade',
                hide: 'fade',
                title: '<?php echo $title; ?>',
                resizable: false,
                position: [250,'center'],
                width: 'auto',
                open: function (event, ui) {
                    $('#form_newscontrol').css('overflow', 'hidden');

                    tinyMCE.init({
                        mode : "textareas",
                        plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor jbimages"
                        ],
                        style_formats: [
                        {title: 'Bold text', inline: 'b'},
                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                        {title: 'Table styles'},
                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ],
                        relative_urls : true,
                           toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages"
                });

                     //tinyMCE.get('box_news_content').focus(); 
                     //tinyMCE.activeEditor.setContent($("#box_old_content").text());

                    disable_date();

                },
                modal: true
            });
            
            //bvalidator
            $('#newscontrol_newscontrol').bValidator();
            
            //ini bugnya entah kenapa harus dikasi hasDatepicker di class div.nya
            $('#box_news_start_date').datetimepicker({yearRange: "+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy", timeFormat: 'hh:mm:ss' <?php if (isset($news_start_date)) { ?> , currentText: "<?php echo $news_start_date; ?>" <?php } ?>});
            $('#box_news_end_date').datetimepicker({yearRange: "+30",changeMonth: true,changeYear: true,dateFormat: "dd-mm-yy", timeFormat: 'hh:mm:ss' <?php if (isset($news_end_date)) { ?> , currentText: "<?php echo $news_end_date; ?>" <?php } ?>});
            
        });
    
        
        function fnewscontrol_send(){
            
            str = $("#newscontrol_newscontrol").serialize();
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
                        $('#form_newscontrol').dialog('close');
                        showSukses('Proses berhasil');
                        $("#tabel-newscontrol").flexReload();
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

        function disable_date()
        {
            var is_checked = $('#box_is_periodic').attr('checked')?true:false;
            
            if(!is_checked)
            {
                $('#box_news_start_date').attr('disabled', 'disabled');
                $('#box_news_end_date').attr('disabled', 'disabled');
                
            }
            else
            {
                $('#box_news_start_date').removeAttr('disabled');
                $('#box_news_end_date').removeAttr('disabled');
                
            }
        }

        function cekcombo()
        {
            if(!$('#box_is_periodic').checked())
                return true;
            else
                return false;
        }

    </script>
</div>