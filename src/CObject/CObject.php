<?php
    /**
    * Holding a instance of CThor to enable use of $this in subclasses.
    *
    * @package ThorCore
    */
    class CObject {

       public $config;
       public $request;
       public $data;
	   public $db;
	   public $views;
	   public $session;

       /**
        * Constructor
        */
       protected function __construct() {
        $to = CThor::Instance();
        $this->config   = &$to->config;
        $this->request  = &$to->request;
        $this->data     = &$to->data;
		$this->db       = &$to->db;
		$this->views	= &$to->views;
		$this->session  = &$to->session;
    }

		/**
		* Redirect to another url and store the session
		*/
		protected function RedirectTo($url) {
    $to = CThor::Instance();
    if(isset($to->config['debug']['db-num-queries']) && $to->config['debug']['db-num-queries'] && isset($to->db)) {
      $this->session->SetFlash('database_numQueries', $this->db->GetNumQueries());
    }
    if(isset($to->config['debug']['db-queries']) && $to->config['debug']['db-queries'] && isset($to->db)) {
      $this->session->SetFlash('database_queries', $this->db->GetQueries());
    }
    if(isset($to->config['debug']['timer']) && $to->config['debug']['timer']) {
		$this->session->SetFlash('timer', $to->timer);
    }
    $this->session->StoreInSession();
    header('Location: ' . $this->request->CreateUrl($url));
  }    

}