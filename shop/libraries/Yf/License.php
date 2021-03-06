<?php

class Yf_License
{
    const VERSION = "1.0";
    const CTLPREFIX = "Game";

    public function __construct()
    {
    }

    static public function init()
    {
        $PluginManager = Yf_Plugin_Manager::getInstance();
        $PluginManager->trigger("perm");
    }

    static public function is_ajax()
    {
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] && (strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest")) {
            return true;
        }
        else {
            return false;
        }
    }

    static public function start($ctl = "Index", $met ="index", $typ ="e")
    {
        if (!$_REQUEST["ctl"]) {
            $_REQUEST["ctl"] = $ctl;
        }


        $ctl = $_REQUEST["ctl"] . "Ctl";

        if (!$_REQUEST["met"]) {
            $_REQUEST["met"] = $met;
        }

        $met = $_REQUEST["met"];
        $Yf_Registry = Yf_Registry::getInstance();
        $ccmd_rows = ($Yf_Registry["ccmd_rows"] ? $Yf_Registry["ccmd_rows"] : array());

        if (!$_REQUEST["typ"]) {
            if ($ccmd_rows[$_REQUEST["ctl"]][$_REQUEST["met"]]) {
                $_REQUEST["typ"] = $ccmd_rows[$_REQUEST["ctl"]][$_REQUEST["met"]]["typ"];
            }
            else {
                $_REQUEST["typ"] = $typ;
            }
        }

        $typ = $_REQUEST["typ"];


        $ctl = htmlspecialchars($ctl);
        $met = htmlspecialchars($met);
        $typ = htmlspecialchars($typ);


        self::init();
        $Router = new Yf_Router($ctl, $met, $typ);
        $rs = $Router->service();
        if (is_array($rs) || is_object($rs)) {
            print_r($rs);
        }
        else {
            $output = $rs;
        }

        if ($output) {
            //if ($checkjs) {
                $output = preg_replace_callback("|.*</body>|", 				function()
                {
                }
                    , $output);
         //   }

            echo trim($output);
        }

        if (RUNTIME) {
            self::checkRuntime();
        }
    }

    static public function checkRuntime()
    {
        global $import_file_row;
        $runtime_file = Yf_Registry::get("runtime_file");
        $runtime = Yf_Registry::get("runtime");
        if ($runtime_file && !$import_file_row) {
            $runtime_content = "";

            if (is_file($runtime_file)) {
                $runtime_content .= php_strip_whitespace($runtime_file);
            }

            foreach ($import_file_row as $key => $php_file ) {
                $runtime_content .= php_strip_whitespace($php_file);
            }

            if (!file_exists(dirname($runtime_file))) {
                mkdir(dirname($runtime_file), 511, true);
            }

            file_put_contents($runtime_file, $runtime_content);
        }
    }
}

class Yf_Licence_Maker
{
    private $keydir;
    private $data = array();
    private $output;

    public function getData($licence_data, $public_key_data)
    {
        $licence = base64_decode($licence_data);
        $ret = openssl_public_decrypt($licence, $data, $public_key_data);
        $data = unserialize($data);
        return $data;
    }

    public function check($licence_data, $public_key_data, $evn_row)
    {
        $licence = base64_decode($licence_data);
        $ret = openssl_public_decrypt($licence, $data, $public_key_data);
        $data = unserialize($data);
        return $this->checkDate($data, $evn_row);
    }

    public function checkDate($data, $evn_row)
    {
        $domain = new Yf_Utils_Domain();
        $expires = $data["expires"];
        if (($expires < time()) || ($domain->getDomain($evn_row["domain"]) != $domain->getDomain($data["domain"]))) {
            return false;
        }

        return true;
    }

    public function checkLicence()
    {
        $url = "";
        $arr_param = array();
        $data = get_url($url, $arr_param = array());

        if (200 == $data["status"]) {
            return true;
        }
        else {
            return false;
        }
    }
}

class Yf_Core_Router extends Yf_Controller
{
    /**
     * App控制器
     *
     * @access public
     * @var string|null
     */
    public $controller;

    public function __construct(&$ctl, &$met, &$typ)
    {
        parent::__construct($ctl, $met, $typ);
    }

    public function checkUrl()
    {
        global $ccmd_rows;
        $Yf_Registry = Yf_Registry::getInstance();
        $int_row = $Yf_Registry["int_row"];
        $float_row = $Yf_Registry["float_row"];

        if (is_file($this->path)) {
        }
        else {
            error_header(404, "Page Not Found");
            throw new Yf_ProtocalException(sprintf(_("file: %s does not exists"), $this->path));
        }
    }

    public function service()
    {
        $rs = $this->getData();
        return $rs;
    }

    public function setPath(&$ctl, &$act)
    {
        $this->path = CTL_PATH . "/" . implode("/", explode("_", $ctl)) . ".php";
        $this->ctl = &$ctl;
        return $this->path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getData()
    {
        try {
            $this->checkUrl();
            $this->controller = new $this->className($this->ctl, $this->met, $this->typ);
            $this->controller->run();
            $d = $this->controller->getData();
            $protocol_data = Yf_Data::encodeProtocolData($d, $this->typ);
            $PluginManager = Yf_Plugin_Manager::getInstance();
            $PluginManager->trigger("log");
            return $protocol_data;
        }
        catch (Yf_ProtocalException $e) {
            if ("cli" != SAPI) {
                if (Yf_Registry::get("error_url") && ("e" == $this->typ)) {
                    location_to(Yf_Registry::get("error_url") . "?msg=" . urlencode($e->getMessage()));
                    exit();
                }

                $Data = new Yf_Data();
                $Data->setError($e->getMessage(), $e->getCode(), $e->getId());
                $d = $Data->getDataRows();
                $protocol_data = Yf_Data::encodeProtocolData($d);
                return $protocol_data;
            }
            else {
                print_r($e->getMessage());
            }
        }
        catch (Exception $e) {
            if ("cli" != SAPI) {
                if (Yf_Registry::get("error_url") && ("e" == $this->typ)) {
                    location_to(Yf_Registry::get("error_url") . "?msg=" . urlencode($e->getMessage()));
                    exit();
                }

                $Data = new Yf_Data();
                $Data->setError($e->getMessage(), $e->getCode());
                $d = $Data->getDataRows();
                $protocol_data = Yf_Data::encodeProtocolData($d);
                return $protocol_data;
            }
            else {
                print_r($e->getMessage());
            }
        }
    }
}


?>
