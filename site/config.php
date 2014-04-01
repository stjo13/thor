<?php
    /**
    * Site configuration, this file is changed by user per site.
    *
    */

    /**
    * Set level of error reporting
    */
    error_reporting(-1);
    ini_set('display_errors', 1);


/**
* Set database(s).
*/
$to->config['database'][0]['dsn'] = 'sqlite:' . THOR_SITE_PATH . '/data/.ht.sqlite';

	
/**
* Set what to show as debug or developer information in the get_debug() theme helper.
*/
$to->config['debug']['thor'] = false;
$to->config['debug']['session'] = false;
$to->config['debug']['timer'] = true;
$to->config['debug']['db-num-queries'] = true;
$to->config['debug']['db-queries'] = true;


/**
 * What type of urls should be used?
 * 
 * default      = 0      => index.php/controller/method/arg1/arg2/arg3
 * clean        = 1      => controller/method/arg1/arg2/arg3
 * querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
 */
$to->config['url_type'] = 1;

/**
 * Set a base_url to use another than the default calculated
 */
$to->config['base_url'] = null;


    /*
    * Define session name
    */
    $to->config['session_name'] = preg_replace('/[:\.\/-_]/', '', $_SERVER["SERVER_NAME"]);
	$to->config['session_key'] = 'thor';
	

    /*
    * Define server timezone
    */
    $to->config['timezone'] = 'Europe/Stockholm';

    /*
    * Define internal character encoding
    */
    $to->config['character_encoding'] = 'UTF-8';

    /*
    * Define language
    */
    $to->config['language'] = 'en';
	
/**
* Define the controllers, their classname and enable/disable them.
*
* The array-key is matched against the url, for example:
* the url 'developer/dump' would instantiate the controller with the key "developer", that is
* CCDeveloper and call the method "dump" in that class. This process is managed in:
* $to->FrontControllerRoute();
* which is called in the frontcontroller phase from index.php.
*/
$to->config['controllers'] = array(
  'index'     => array('enabled' => true,'class' => 'CCIndex'),
  'developer' => array('enabled' => true,'class' => 'CCDeveloper'),
  'guestbook' => array('enabled' => true,'class' => 'CCGuestbook'),
);

/**
 * Settings for the theme.
 */
$to->config['theme'] = array(
  // The name of the theme in the theme directory
  'name'    => 'core', 
);

    