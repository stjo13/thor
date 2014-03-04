<?php
/**
* Standard controller layout.
*
* @package ThorCore
*/
class CCIndex implements IController {

   /**
    * Implementing interface IController. All controllers must have an index action.
    */
   public function Index() {   
      global $to;
      $to->data['title'] = "The Index Controller";
	  $to->data['main'] = "<h1>The Index Controller</h1>";
   }

} 