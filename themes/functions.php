<?php
    /**
    * Helpers for theming, available for all themes in their template files and functions.php.
    * This file is included right before the themes own functions.php
    */

	
/**
* Print debuginformation from the framework.
*/
function get_debug() {
	// Only if debug is wanted.
  $to = CThor::Instance();
  if(empty($to->config['debug'])) {
    return;
  }
  
  // Get the debug output
  $html = null;
  if(isset($to->config['debug']['db-num-queries']) && $to->config['debug']['db-num-queries'] && isset($to->db)) {
    $flash = $to->session->GetFlash('database_numQueries');
    $flash = $flash ? "$flash + " : null;
    $html .= "<p>Database made $flash" . $to->db->GetNumQueries() . " queries.</p>";
  }
  if(isset($to->config['debug']['db-queries']) && $to->config['debug']['db-queries'] && isset($to->db)) {
    $flash = $to->session->GetFlash('database_queries');
    $queries = $to->db->GetQueries();
    if($flash) {
      $queries = array_merge($flash, $queries);
    }
    $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
  }
  if(isset($to->config['debug']['timer']) && $to->config['debug']['timer']) {
    $html .= "<p>Page was loaded in " . round(microtime(true) - $to->timer['first'], 5)*1000 . " msecs.</p>";
  }
  if(isset($to->config['debug']['thor']) && $to->config['debug']['thor']) {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CThor:</p><pre>" . htmlent(print_r($to, true)) . "</pre>";
  }
  if(isset($to->config['debug']['session']) && $to->config['debug']['session']) {
    $html .= "<hr><h3>SESSION</h3><p>The content of CThor->session:</p><pre>" . htmlent(print_r($to->session, true)) . "</pre>";
    $html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
  }
  return $html;
}


/**
* Get messages stored in flash-session.
*/
function get_messages_from_session() {
  $messages = CThor::Instance()->session->GetMessages();
  $html = null;
  if(!empty($messages)) {
    foreach($messages as $val) {
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}
  
	
/**
* Prepend the base_url.
*/
function base_url($url) {
  return CThor::Instance()->request->base_url . trim($url, '/');
}


/**
* Create a url to an internal resource.
*/
function create_url($url=null) {
  return CThor::Instance()->request->CreateUrl($url);
}


/**
* Prepend the theme_url, which is the url to the current theme directory.
*/
function theme_url($url) {
  $to = CThor::Instance();
  return "{$to->request->base_url}themes/{$to->config['theme']['name']}/{$url}";
}


/**
* Return the current url.
*/
function current_url() {
  return CThor::Instance()->request->current_url;
}

/**
* Render all views.
*/
function render_views() {
  return CThor::Instance()->views->Render();
}