<div id="window_print">
    <form id="f_print" class="modal_form" action="javascript:print()">
        <p>Pilih Tipe Print<br></p>
        <table>
            <tr>
                <td>Ganti Status</td>
                <td><select data-bvalidator="required,cekcombo"  id="wfprint_change" name="wfprint_change" class="text ui-widget-content ui-corner-all">
                        <?php
                        $data = $this->data_master->selector($data_master);
                        foreach ($data as $key => $value) {
                            $selected = "";
                            if ($value == '')
                                $selected = "selected";
                            echo "<option value='$key' $selected>$value</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php echo $form; ?>
        <input type="submit" name="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" id="submit" name="submit" value="Ya">
        <input type="button" onclick="$('#window_print').dialog('close');" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" value="Tidak">
    </form>
    <script type="text/javascript" >
        $(document).ready(function () {
            
            $('#window_print').dialog({
                close: function(event, ui) {$(this).remove()},
                draggable: false,
                show: 'fade',
                hide: 'fade',
                title: 'Konfirmasi',
                resizable: false,
                width: 350,
                modal: true
            });
                
            //another setup
            $('#f_print').bValidator();
        });
	
        function print(){
            var id = $('#wfprint_change').val();
            var print_id = $('#print_id').val();
            window.open('<?php echo $send_url; ?>' + 'PRINTING' + id , 'cetak individu');
            $('#window_print').remove();
        }
    </script>
</div>