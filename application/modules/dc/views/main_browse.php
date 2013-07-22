
<div id="da-content-area">

    <div class="grid_4">
        <div class="da-panel">

       <!-- <div class="da-panel-title"><?php if (isset($title)) echo $title; ?></div> -->

            <div class="da-panel-content">
                <div id="el-finder" name="el-finder">

                </div>
                <script type="text/javascript" >
                    $(document).ready(function(){
                        $('#el-finder').elfinder({
                            url: '<?php echo site_url('dc/browse/elfinder'); ?>'
                        }).elfinder('instance');
                    });
                </script>
            </div>

        </div>
    </div>

    <div class="clear"></div>

