<?php
/**
* Bootstrapping, setting up and loading the core.
*
* @package ThorCore
*/


/**
* Enable auto-load of class declarations.
*/
function autoload($aClassName) {
  $classFile = "/src/{$aClassName}/{$aClassName}.php";
   $file1 = THOR_SITE_PATH . $classFile;
   $file2 = THOR_INSTALL_PATH . $classFile;
   if(is_file($file1)) {
      require_once($file1);
   } elseif(is_file($file2)) {
      require_once($file2);
   }
}
spl_autoload_register('autoload');

/**
* Set a default exception handler and enable logging in it.
*/
function exception_handler($exception) {
  echo "Thor: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
}
set_exception_handler('exception_handler');


/**
* Helper, wrap html_entites with correct character encoding
*/
function htmlent($str, $flags = ENT_COMPAT) {
  return htmlentities($str, $flags, CThor::Instance()->config['character_encoding']);
}