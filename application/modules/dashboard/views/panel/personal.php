<ul class="da-header-dropdown">
    <li class="da-dropdown-caret">
        <span class="caret-outer"></span>
        <span class="caret-inner"></span>
    </li>
    <li class="da-dropdown-divider"></li>
    <li><a href="#" onclick="javascript:profile()">Profile</a></li>
    <li><a href="#" onclick="javascript:password()">Change Password</a></li>
</ul> 

<script type="text/javascript" >
    
    function profile()
    {
        var nocache = Math.random();
        var dataString = 'id='+<?php echo $this->session->userdata('sys_user_id'); ?>+'&nocache='+nocache;
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("public/profile/prepare_editprofile"); ?>',
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
        
        return false;
    }
    
function password()
{
var nocache = Math.random();
var dataString = 'id='+<?php echo $this->session->userdata('sys_user_id'); ?>+'&nocache='+nocache;
$.ajax({
    type: 'POST',
    url: '<?php echo site_url("public/profile/prepare_edit"); ?>',
    data: dataString,
    cache: false,
    success: function(html){
        hideLoading();
        $('body').append(html);
    },
    error:function(xhr,ajaxOptions,thrownError){
        ajaxError(xhr,ajaxOptions,thrownError);
    }			
})
        
return false;
}
    
</script>