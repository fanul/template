<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <!-- Viewport metatags -->
        <meta name="HandheldFriendly" content="true" />
        <meta name="MobileOptimized" content="320" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- iOS webapp metatags -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />

        <!-- iOS webapp icons -->
        <link rel="apple-touch-icon" href="touch-icon-iphone.html" />
        <link rel="apple-touch-icon" sizes="72x72" href="touch-icon-ipad.html" />
        <link rel="apple-touch-icon" sizes="114x114" href="touch-icon-retina.html" />

        <!-- CSS Reset -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/reset.css" media="screen" />
        <!--  Fluid Grid System -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fluid.css" media="screen" />
        <!-- Theme Stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dandelion.theme.css" media="screen" />
        <!--  Main Stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dandelion.css" media="screen" />
        <!-- Demo Stylesheet 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/demo.css" media="screen" />
        -->

        <!-- flexy grid -->
        <link href="<?php echo base_url(); ?>css/flexigrid.css" rel="stylesheet" type="text/css" />

        <!-- jQuery JavaScript File -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>

        <!-- Plugin Files -->

        <!-- Swiper Plugin -->
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/swiper/js/idangerous.swiper-2.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/swiper/js/idangerous.swiper.scrollbar-2.0.js"></script>

        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/swiper/css/idangerous.swiper.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/swiper/css/idangerous.swiper.scrollbar.css" />

        <!-- file input -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.fileinput.js"></script>
        <!-- Placeholder Plugin -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.placeholder.js"></script>
        <!-- Mousewheel Plugin -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.mousewheel.min.js"></script>
        <!-- Scrollbar Plugin -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tinyscrollbar.min.js"></script>
        <!-- Tooltips Plugin -->
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/tipsy/jquery.tipsy-min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/tipsy/tipsy.css" />
        <!-- Backtotop Plugin -->
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/backtotop/backtotop.jquery.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/backtotop/backtotop.jquery.css" media="screen"/>
        <!-- Chosen Plugin -->
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/chosen/chosen.jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/chosen/ajax-chosen.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/chosen/chosen.css" />
        <!-- Picklist Plugin -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/core/plugins/picklist/jquery.picklist.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>js/core/plugins/picklist/jquery.picklist.css" media="screen"/>

        <!-- TinyMCE -->
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/tinymce4/tinymce.min.js"></script>
        
        <!-- ELRTE -->
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/elrte/js/elrte.full.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/elrte/css/elrte.css" />

        <!-- ELFINDER -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/elfinder/elfinder.min.css">
            <script type="text/javascript" src="<?php echo base_url(); ?>js/elfinder/elfinder.min.js"></script>
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/elfinder/jquery-ui-smooth.css">
                <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/elfinder/theme.css">


                    <!-- Validation Plugin 
                    <script type="text/javascript" src="<?php echo base_url(); ?>plugins/validate/jquery.validate.js"></script>
                    -->
                    <!-- bvalidator -->
                    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bvalidator.css" media="screen" />
                    <!-- Statistic Plugin JavaScript Files (requires metadata and excanvas for IE) -->
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.metadata.js"></script>
                    <!--[if lt IE 9]>
                    <script type="text/javascript" src="js/excanvas.js"></script>
                    <![endif]-->
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/core/plugins/dandelion.circularstat.min.js"></script>

                    <!-- Wizard Plugin -->
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/core/plugins/dandelion.wizard.min.js"></script>

                    <!-- Fullcalendar Plugin -->
                    <script type="text/javascript" src="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.min.js"></script>
                    <script type="text/javascript" src="<?php echo base_url(); ?>plugins/fullcalendar/gcal.js"></script>
                    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.css" media="screen" />
                    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.print.css" media="print" />

                    <!-- Load Google Chart Plugin -->
                    <!-- 
                    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                    <script type="text/javascript">
                            // Load the Visualization API and the piechart package.
                            google.load('visualization', '1.0', {'packages':['corechart']});
                    </script>
                    -->
                    <!-- Debounced resize script for preventing to many window.resize events
                          Recommended for Google Charts to perform optimally when resizing -->
                    <!-- 
                    <script type="text/javascript" src="js/jquery.debouncedresize.js"></script>
                    -->
                    <!-- Demo JavaScript Files 
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/demo/demo.dashboard.js"></script>
                    -->

                    <!-- Core JavaScript Files -->
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/core/dandelion.core.js"></script>

                    <!-- Customizer JavaScript File (remove if not needed) 
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/core/dandelion.customizer.js"></script>
                    -->

                    <!-- HIGHCHART -->
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/highchart/highcharts.js"></script>
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/highchart/exporting.js"></script>


                    <!-- jQuery-UI JavaScript Files -->
                    <script type="text/javascript" src="<?php echo base_url(); ?>jui/js/jquery-ui-1.8.20.min.js"></script>
                    <script type="text/javascript" src='<?php echo base_url(); ?>js/jquery.bvalidator.js'></script>
                    <script type="text/javascript" src="<?php echo base_url(); ?>jui/js/jquery.ui.timepicker.min.js"></script>
                    <script type="text/javascript" src="<?php echo base_url(); ?>jui/js/jquery.ui.touch-punch.min.js"></script>
                    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>jui/css/jquery.ui.all.css" media="screen" />

                    <script type="text/javascript" src="<?php echo base_url(); ?>js/script.js"></script>
                    <script type="text/javascript" src="<?php echo base_url(); ?>js/flexigrid.pack.js"></script>

                    <script type="text/javascript" >
                        var mainURL = "<?php echo site_url(); ?>";

                        $(document).ready(function(){
                            loadPage('#da-content-wrap','<?php echo site_url("dashboard/dashboard/welcome") ?>');
                            
                            BackToTop({
                                text : '^ Back to top',
                                autoShow : true,
                                timeEffect : 500,
                                autoShowOffset : '330',
                                appearMethod : 'fade',
                                effectScroll : 'linear' /** all effects http://jqueryui.com/docs/effect/#easing */
                            });                            
                        });


                    </script>

                    <title>Dandelion Admin - Dashboard</title>

                    </head>

                    <body>

                        <!-- Main Wrapper. Set this to 'fixed' for fixed layout and 'fluid' for fluid layout' -->
                        <div id="da-wrapper" class="fluid">

                            <!-- Header -->
                            <div id="da-header">

                                <div id="da-header-top">

                                    <!-- Container -->
                                    <div class="da-container clearfix">

                                        <!-- Logo Container. All images put here will be vertically centere -->
                                        <div id="da-logo-wrap">
                                            <div id="da-logo">
                                                <div id="da-logo-img">
                                                    <a href="dashboard.html">
                                                        <img src="images/logo-travel.png" alt="Dandelion Admin" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Header Toolbar Menu -->
                                        <?php $this->load->view('panel/toolbar', $notif_list); ?>
                                    </div>
                                </div>

                                <div id="da-header-bottom">
                                    <!-- Container -->
                                    <div class="da-container clearfix">

                                        <!-- Breadcrumbs -->
                                        <?php $this->load->view('panel/breadcrumb'); ?>

                                        <!-- Content -->
                                        <div id="da-content">

                                            <!-- Container -->
                                            <div class="da-container clearfix">

                                                <!-- Sidebar Separator do not remove -->
                                                <div id="da-sidebar-separator"></div>

                                                <!-- Sidebar -->
                                                <div id="da-sidebar">

                                                    <!-- Main Navigation -->
                                                    <?php $this->load->view('panel/menu', $menu); ?>

                                                    <!-- Main Content Wrapper -->
                                                    <div id="da-content-wrap" class="clearfix">
                                                        <!-- Content Area -->
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        <!-- Footer 
                                        <div id="da-footer">
                                            <div class="da-container clearfix">
                                                <p>Coded By Fanul.
                                            </div>
                                        </div>
                                        -->
                                        <?php //$this->load->view('panel/chat'); ?>

                                        </body>

                                        </html>