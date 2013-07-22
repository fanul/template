<div id="form_notifcontrol">
    <table cellspacing="0" border="0" cellpadding="5" class="modal_form">

        <tr>
            <td>Tes</td>
        </tr>

        <tr>
            <td><?php echo $sys_notif_message; ?></td>
        </tr>

    </table>

</div>

<script type="text/javascript" >
        
    $(document).ready(function () {
            
        $('#form_notifcontrol').dialog({
            close: function(event, ui) {$(this).remove(); window.location.reload();},
            draggable: false,
            show: 'fade',
            hide: 'fade',
            title: '<?php echo $title; ?>',
            resizable: false,
            width: 600,
            modal: true
        });

    });

</script>