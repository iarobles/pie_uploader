<?php

class PieConfig {

    private static $PIE_CONFIG = array();
    private static $initialized = false;

    public static function getConfig($configKey) {

        if (!self::$initialized) {
            self::initConfig();
            self::$initialized = true;
        }

        return self::$PIE_CONFIG[$configKey];
    }

    public static function getConfigurations() {
        return self::$PIE_CONFIG;
    }

    public static function initConfig() {

        /* ---------------------------------- Apache home ------------------------------------ */
        self::$PIE_CONFIG["IS_GUINDOUS"] = true; // if we have a fuc#@# windows runnging apache
        
        self::$PIE_CONFIG["WIN_ROOT1"] = "C:/"; //thanks guindous, everything will be ok without your stupid paths
        self::$PIE_CONFIG["WIN_ROOT2"] = "C:\\";//another "funny" patch to handle apache/guindous machines :@
        self::$PIE_CONFIG["WIN_ROOT3"] = "C:";//another "funny" patch to handle apache/guindous machines :@
        
        self::$PIE_CONFIG["APACHE_HOME"] = "C:/apps/xampp/htdocs";
        //self::$PIE_CONFIG["APACHE_HOME"] = "/var/www";
        /* ------------------------------------------------------------------------------------ */

        /* ---------------------------------- Pie home --------------------------------------- */
        //Pie needs to know its home to avoid an accidental self-destruction
        self::$PIE_CONFIG["PIE_HOME"] = self::$PIE_CONFIG["APACHE_HOME"] . "/pie_uploader";
        /* --------------------------------------------------------------------------------- */


        /* ---------------------------------- File extension image ------------------------- */
        self::$PIE_CONFIG["FILE_EXTENSION_IMAGE"] = array("html" => "html.png",
            "zip" => "page_white_compressed.png",
            "php" => "page_white_php.png",
            "txt" => "page_white_text.png",
            "default" => "unknown.png",
            "directory"=>"folder.png");
        /* --------------------------------------------------------------------------------- */

        /* -------------------- class used for retrieve users information in login page --- */
        //the home of the users dao class that PIE will use to locate the dao class

        self::$PIE_CONFIG["USERS_DAO_PATH_NAME"] = "php";
        self::$PIE_CONFIG["USERS_DAO_CLASS_NAME"] = "UsersPHPDAO";
        /* --------------------------------------------------------------------------------- */


        /* --------------------- valid users for login -------------------------------- */
        //IMPORTANT:next configurations only applies if USERS_DAO_CLASS_NAME = UsersPHPDAO
        // userLoginName => password
        self::$PIE_CONFIG["PIE_VALID_USERS"] = array("test" => "123", "test2" => "1234");

        // userLoginName => array of allowed paths
        self::$PIE_CONFIG["USER_ALLOWED_PATHS"] = array("test" => array("/test", "/zipbuilder"));

        /* --------------------------------------------------------------------------------- */

        /* --------------------- captcha configuration  --------------------------------- */
        self::$PIE_CONFIG["CAPTCHA_ENABLED"] = false;
        //next public and private keys are provided by google/recaptcha for each site
        //that you want to protect
        self::$PIE_CONFIG["RECAPTCHA_PUBLIC_KEY"] = "6Le1rLwSAAAAAC37n6kB9OjlohyLPWJEzwPzYB2l";
        self::$PIE_CONFIG["RECAPTCHA_PRIVATE_KEY"] = "6Le1rLwSAAAAAM6c7s0zF2TRBVePproljVlgf8WY";
    }

}

?>
