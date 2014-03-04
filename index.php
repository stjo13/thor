<?php
//
// PHASE: BOOTSTRAP
//
define('THOR_INSTALL_PATH', dirname(__FILE__));
define('THOR_SITE_PATH', THOR_INSTALL_PATH . '/site');

require(THOR_INSTALL_PATH.'/src/CThor/bootstrap.php');

$to = CThor::Instance();

//
// PHASE: FRONTCONTROLLER ROUTE
//
$to->FrontControllerRoute();

//
// PHASE: THEME ENGINE RENDER
//
$to->ThemeEngineRender();