<li class="da-header-button notif">
    <?php if (isset($notif_list) && count($notif_list)>0) ?>
        <span class="da-button-count"><?php echo count($notif_list); ?></span>
    <a href="#">Notifications</a>
    <ul class="da-header-dropdown">
        <li class="da-dropdown-caret">
            <span class="caret-outer"></span>
            <span class="caret-inner"></span>
        </li>
        <li>
            <span class="da-dropdown-sub-title">Notifications</span>
            <ul class="da-dropdown-sub">

                <?php
                foreach ($notif_list as $notification) {
                    ?>

                    <li class="unread" id="<?php echo $notification->sys_user_id; ?>">
                        <a href="#" onclick="javascript:notif_click(<?php echo $notification->sys_user_id; ?>);">
                            <span class="message">
                                <?php echo $notification->sys_notif_message; ?>
                            </span>
                            <span class="time">
                                <?php echo $notification->sys_notif_date_send; ?>
                            </span>
                        </a>
                    </li>

                    <?php
                }
                ?>
            </ul>
            <a class="da-dropdown-sub-footer">
                View all notifications
            </a>
        </li>
    </ul>
</li>

<script type="text/javascript">
    
    function notif_click(id)
    {
        //alert(id);
        var link = '<?php echo site_url("public/notif/prepare_notif/"); ?>' +'/' + id;
        //alert(link);
        $.ajax({
            type: 'GET',
            url: link,
            cache: false,
            success: function(html){
                hideLoading();
                $('body').append(html);
            },
            error:function(xhr,ajaxOptions,thrownError){
                ajaxError(xhr,ajaxOptions,thrownError);
            }			
        });
        
    $(".da-button-count").remove();
        
        return false;
    }
    
    
</script>