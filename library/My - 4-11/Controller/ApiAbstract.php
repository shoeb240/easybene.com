<?php
abstract class My_Controller_ApiAbstract extends Zend_Rest_Controller
{

    const API_TOKEN_LIFE_TIME = 86400;

    const BAD_REQUEST = 400;
    const ERROR_NOTFOUND = 404;
    const ERROR_DENIED   = 403;
    const ERROR_INSECURE_REQUEST   = 403;
    const ERROR_EXPIRED  = 401;
    const ERROR_INTERNAL = 500;

    const RESPONSE_OK = 200;
    const RESPONSE_CREATED = 201;

    protected $_logger = null;
    
    public function init()
    {
        //$this->_initForceSSL();
    }
    /**
     * Action for calling error page
     *
     * @param int $code Error code of error type
     * @param string $message Error message
     */
    protected function _error($code = null, $message = '')
    {
        try {
            switch ($code) {
                case self::ERROR_NOTFOUND:
                    throw new Zend_Controller_Exception('[NOTFOUND] ' . $message, self::ERROR_NOTFOUND);
                    break;
                case self::ERROR_DENIED:
                    throw new Zend_Controller_Exception('[DENIED] ' . $message, self::ERROR_DENIED);
                    break;
                case self::ERROR_EXPIRED:
                    throw new Zend_Controller_Exception(
                        "Sorry we cannot display this page for you.
                    Maybe you have no rights to see content of this page
                    or your session has timed out.
                    Go to the <a href='" . $this->view->url(array(), 'signin') . "'>login page.</a> "
                            . $message, self::ERROR_DENIED);
                    break;
                case self::ERROR_INTERNAL:
                    throw new Zend_Controller_Exception('[INTERNAL] ' . $message, self::ERROR_INTERNAL);
                    break;
                default:
                    throw new Zend_Controller_Exception('[ERROR] ' . $message);
                    break;
            }
        } catch (Zend_Controller_Exception $e) {
            $this->getResponse()
                ->setHttpResponseCode($code)
                ->appendBody(Zend_Json::encode($e->getMessage()))
                ->sendResponse();
        }
    }


    /**
     * Checking current connection & redirect to same adress with HTTPS protocol
     */
    public function activateSSL()
    {
        // Checking protocol & activate connection over SSL if need
        if ($_SERVER['HTTPS'] != "on" && APPLICATION_ENV != "testing") {
            $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            header("Location: $url");
            exit();
        }
    }

    protected function _initForceSSL()
    {
        if($_SERVER['SERVER_PORT'] != '443') {
            header('Location: https://' . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI']);
            exit();
        }
    }

    protected function _toJson($param)
    {
        if (!is_array($param)) {
            $param = stripslashes($param);
            $param = Zend_Json::decode($param);
        }
        return $param;
    }
    
    protected function _logger()
    {
        if (is_null($this->_logger)) {
            $path = APPLICATION_PATH . '/data/logs/api/' . date("Y-m-d")  ."/";
            Default_Service_File::prepareDir($path);
            $logname = time() . ".log";
            $writer = new Zend_Log_Writer_Stream($path . $logname);
            $this->_logger = new Zend_Log($writer);
        }
        
        return $this->_logger;
    }

    public function headAction()
    {
        $this->_error(self::ERROR_NOTFOUND, "There is no such functionality at this moment");
    }

    /**
     * 
     * @param string $key
     * @param string $default
     * @return string|null
     */
    public function getJsonParam($key, $default = null)
    {
        if (!$this->_params) {
            $this->_params = Zend_Json::decode($this->getRequest()->getRawBody());
        }

        return isset($this->_params[$key]) ? $this->_params[$key] : $default;
    }
    
    /**
     * 
     * @return array
     */
    public function getJsonParams()
    {
        if (!$this->_params) {
            $this->_params = Zend_Json::decode($this->getRequest()->getRawBody());
        }

        return $this->_params;
    }
}
