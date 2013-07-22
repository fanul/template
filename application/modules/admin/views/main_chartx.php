

    <div id="da-content-area">

        <div class="grid_4">
            <div class="da-panel">

                                                       <!-- <div class="da-panel-title"><?php if (isset($title)) echo $title; ?></div> -->
                <div class="da-panel-widget">
                    <div class="da-panel-content">
                        <div class="content_top" id="graph">
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    
                                    new Highcharts.Chart({
                                        chart: {
                                            renderTo: 'graph',
                                            type: 'column'
                                        },
                                        title: {
                                            text: 'Gaji Karyawan',
                                            x: -10
                                        },
                                        xAxis: {
                                            title: {text: 'Created By Fanul'}
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Pendapatan '
                                            }
                                        },
                                        series: [
                                            
                                            <?php 
                                                $str ="";
                                                foreach($data as $item){
                                                    $str.= "{";
                                                    $str.=" name: '".$item->hr_employee_nick_name."',";
                                                    $str.=" data: [".$item->hr_employee_salary."]";
                                                    $str.="},";
                                                }
                                                $str = substr($str, 0, -1);
                                                echo $str;
                                            ?>
                                               
         
                                        ]
                                    });
                                }); 
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clear"></div>