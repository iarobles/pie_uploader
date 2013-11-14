<?php
require_once('./lib/recaptcha_1_11/recaptchalib.php');
require_once('./src/PieConfiguration.php');
$publickey = PieConfig::getConfig("RECAPTCHA_PUBLIC_KEY");
$captchaEnabled = PieConfig::getConfig("CAPTCHA_ENABLED");
?>
<script type="text/javascript" src="./webroot/login/js/login_jquery.js"></script>
<div id="main_body" >

    <img id="top" src="./webroot/login/img/top.png" alt=""/>
    <div id="form_container">

        <h1><a>Untitled Form</a></h1>
        <form id="pie_login_params" class="appnitro"  method="post" action="">
            <div class="form_description">
                <h2>Pie Uploader PHP</h2>
                <p>Because upload has never been so easy!</p>
            </div>
            <div class="pie-login-container-box ">
                <div class="pie-login-fields-container">
                    <ul >
                        <li id="li_1" class="pie-label-container" >
                            <label class="description" for="element_1">User</label>
                            <div >
                                <input id="userName" name="userName" class="element text medium" type="text" maxlength="255" value=""/>
                            </div>
                        </li>
                        <li id="li_2" class="pie-label-container">
                            <label class="description" for="element_2">Password</label>
                            <div >
                                <input id="password" name="password" class="element text medium" type="password" maxlength="255" value=""/>
                            </div>
                        </li>
                        <?php if ($captchaEnabled): ?>
                            <li>
                            <?php echo recaptcha_get_html($publickey); ?>
                        </li>
                        <?php endif; ?>
                        <li>
                            <div id="login_error_message"></div>
                        </li>
                        <li class="buttons">
                            <input type="hidden" name="form_id" value="3115" />                            
                            <input id="saveForm" class="button_text" type="submit" name="submit" value="Bake it!" />
                        </li>
                    </ul>
                </div>
                <div class="pie-login-img-container"><img src="./webroot/img/pie_palooza_logo.jpg" class="pie-logon"alt="pie-logon"/></div>
            </div>
        </form>
    </div>
    <img id="bottom" src="./webroot/login/img/bottom.png" alt=""/>
</div>