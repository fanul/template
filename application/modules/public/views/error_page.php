<!--
<div id="da-content-area">
    <div class="grid_4">
        <div class="da-panel">
            <div class="da-panel-header">
                <div class="da-panel-title">ERROR</div>
            </div>
            <div class="da-panel-content">
                <h1 style="text-align: center">
                    anda tidak mempunyai akses
                </h1>
                
            </div>

        </div>
    </div>

    <div class="clear"></div>
-->

<script type="text/javascript">
    $(document).ready(function(){
       <?php 
            if(!isset($message))
            {
                echo 'alert("anda tidak punya akses");';
            }
            else
            {
                echo 'alert("'.$message.'");';
            }
       ?>
    });
</script>