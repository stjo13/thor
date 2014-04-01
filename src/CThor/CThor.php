<?php
/**
* Main class for Thor, holds everything.
*
* @package ThorCore
*/
class CThor implements ISingleton {

			/**
			* Members
			*/
			private static $instance = null;
			public $config = null;
			public $request = null;
			public $data = null;
			public $db = null;
			public $views;
			public $session;
			public $timer = array();

		/**
		* Constructor
		*/
		protected function __construct() {
				// time page generation
				$this->timer['first'] = microtime(true); 
				
				// include the site specific config.php and create a ref to $ly to be used by config.php
				$to = &$this;
			require(THOR_SITE_PATH.'/config.php');
			
				// Start a named session
					session_name($this->config['session_name']);
					session_start();
					$this->session = new CSession($this->config['session_key']);
					$this->session->PopulateFromSession();
					

					// Set default date/time-zone
					date_default_timezone_set($this->config['timezone']);
					
					// Create a database object.
					if(isset($this->config['database'][0]['dsn'])) {
					$this->db = new CMDatabase($this->config['database'][0]['dsn']);
				}
				
				// Create a container for all views and theme data
				$this->views = new CViewContainer();
		  }
  
  
  
  
  
  /**
	* Singleton pattern. Get the instance of the latest created object or create a new one.
	* @return CThor The instance of this class.
	*/
			public static function Instance() {
				if(self::$instance == null) {
					self::$instance = new CThor();
				}
				return self::$instance;
			}


	/**
	* Frontcontroller, check url and route to controllers.
	*/
  public function FrontControllerRoute() {
    // Take current url and divide it in controller, method and parameters
    $this->request = new CRequest($this->config['url_type']);
    $this->request->Init($this->config['base_url']);
    $controller = $this->request->controller;
    $method = $this->request->method;
    $arguments = $this->request->arguments;
    
    // Is the controller enabled in config.php?
    $controllerExists = isset($this->config['controllers'][$controller]);
    $controllerEnabled = false;
    $className	= false;
    $classExists = false;

    if($controllerExists) {
      $controllerEnabled = ($this->config['controllers'][$controller]['enabled'] == true);
      $className	= $this->config['controllers'][$controller]['class'];
      $classExists = class_exists($className);
    }
    
    // Check if controller has a callable method in the controller class, if then call it
    if($controllerExists && $controllerEnabled && $classExists) {
      $rc = new ReflectionClass($className);
      if($rc->implementsInterface('IController')) {
         $formattedMethod = str_replace(array('_', '-'), '', $method);
        if($rc->hasMethod($formattedMethod)) {
          $controllerObj = $rc->newInstance();
          $methodObj = $rc->getMethod($formattedMethod);
          if($methodObj->isPublic()) {
            $methodObj->invokeArgs($controllerObj, $arguments);
          } else {
            die("404. " . get_class() . ' error: Controller method not public.');
          }
        } else {
          die("404. " . get_class() . ' error: Controller does not contain method.');
        }
      } else {
        die('404. ' . get_class() . ' error: Controller does not implement interface IController.');
      }
    }
    else {
      die('404. Page is not found.');
    }
  }
  
  
		/**
		* ThemeEngineRender, renders the reply of the request to HTML or whatever.
		*/
  public function ThemeEngineRender() {
	// Save to session before output anything
    $this->session->StoreInSession();
	
    // Is theme enabled?
    if(!isset($this->config['theme'])) {
      return;
    }

    // Get the paths and settings for the theme
    $themeName = $this->config['theme']['name'];
    $themePath = THOR_INSTALL_PATH . "/themes/{$themeName}";
    $themeUrl	= $this->request->base_url . "themes/{$themeName}";
    
    // Add stylesheet path to the $to->data array
    $this->data['stylesheet'] = "{$themeUrl}/style.css";

    // Include the global functions.php and the functions.php that are part of the theme
    $to = &$this;
    include(THOR_INSTALL_PATH . '/themes/functions.php');
    $functionsPath = "{$themePath}/functions.php";
    if(is_file($functionsPath)) {
      include $functionsPath;
    }

    // Extract $to->data to own variables and handover to the template file
    extract($this->data);     
    extract($this->views->GetData());     
    include("{$themePath}/default.tpl.php");
  }

}