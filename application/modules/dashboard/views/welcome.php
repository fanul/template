<div id="da-content-area">
    <div class="grid_4">
        <div class="da-panel">
            <div class="da-panel-header">
                <div class="da-panel-title">Fanul Default Template</div>
            </div>
            <div class="da-panel-content with-padding">

                <span>
                    <div class="device">
                        <a class="arrow-left" href="#"></a>
                        <a class="arrow-right" href="#"></a>
                        <div class="swiper-container">
                          <div class="swiper-wrapper">

                              <?php
                              if(isset($news)&&count($news)>0)
                              {
                                foreach ($news as $item) {
                                 ?>

                                 <div class="swiper-slide white-slide"> 
                                    <?php echo htmlspecialchars_decode($item->news_content); ?>
                                </div>
                                <?php
                            }
                        }?>

                        </div>
                    </div>
                    <div class="pagination"></div>
                </div>
                </<span>

            </div>
            

        </div>

        <script type="text/javascript">
            $(document).ready(function(){


              var mySwiper = new Swiper('.swiper-container',{
                pagination: '.pagination',
                loop:true,
                grabCursor: true,
                paginationClickable: true
            });
              $('.arrow-left').on('click', function(e){
                e.preventDefault()
                mySwiper.swipePrev()
            });
              $('.arrow-right').on('click', function(e){
                e.preventDefault()
                mySwiper.swipeNext()
            });
  

            });
        </script>

    </div>

    <div class="clear"></div>