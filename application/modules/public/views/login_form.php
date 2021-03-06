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
        <!-- Login Stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/login.css" media="screen" />

        <!-- Required JavaScript Files -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.placeholder.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>plugins/validate/jquery.validate.min.js"></script>

        <!-- Core JavaScript Files -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/core/dandelion.login.js"></script>
        <script type="text/javascript"  src='<?php echo base_url();?>js/md5.js'></script>

        <title>Dandelion Admin - Login</title>

        <script type="text/javascript" >
            
            function hashPwd() {
                var formLogin = document.getElementById('da-login-form');
			
                var userLog = document.getElementById('da-login-username');
                var userPwd = document.getElementById('da-login-password');
			
                var password = userPwd.value;
                //semisecureMessage.innerHTML = 'Encrypting password and logging in...';
                var userMD5Pwd = document.createElement('input');
                userMD5Pwd.setAttribute('type', 'hidden');
                
                userMD5Pwd.setAttribute('id', 'pass');
                userMD5Pwd.setAttribute('name', 'pass');
                userMD5Pwd.value = hex_md5(password);
                //document.getElementById('MD5Text').innerHTML = userMD5Pwd.value;
                formLogin.appendChild(userMD5Pwd);
                
                userPwd.value = '';
                for (var i = 0; i < password.length; i++) {
                    userPwd.value += '*';
                }
                return true;
                
               
                
            }
                
            $(document).ready(function () {
                $("#da-login-form").validate({
                    rules: {
                        username: {
                            required: true
                        },
                        password: {
                            required: true
                        }
                    }
                });
            });
                
        </script>

    </head>

    <body>


        <div id="da-login">
            <div id="da-login-box-wrapper">
                <?php //echo date("d-m-Y H:i:s", time()); ?>
                <div id="da-login-top-shadow">
                </div>
                <div id="da-login-box">
                    <div id="da-login-box-header">
                        <h1>Login</h1>
                        <?php if (isset ($error)) echo "<br><h2>".$error."</h2>"; ?>
                    </div>
                    <div id="da-login-box-content">
                        <form id="da-login-form" method="post" action="" onsubmit="javascript:hashPwd();">
                            <div id="da-login-input-wrapper">
                                <div class="da-login-input">
                                    <input type="text" name="username" id="da-login-username" placeholder="Username" />
                                </div>
                                <div class="da-login-input">
                                    <input type="password" name="password" id="da-login-password" placeholder="Password" />
                                </div>
                            </div>
                            <div id="da-login-button">
                                <input type="submit" value="Login" id="da-login-submit" />
                            </div>
                        </form>
                    </div>
                    <!--
                    <div id="da-login-box-footer">
                        <a href="#">lupa password?</a>
                        <div id="da-login-tape"></div>
                    </div>
                    -->
                </div>
                <div id="da-login-bottom-shadow">
                </div>
            </div>
        </div>

    </body>

</html>
