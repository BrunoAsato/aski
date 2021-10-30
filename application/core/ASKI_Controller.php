<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ASKI_Controller extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		echo "teste<br />teste";
		if ((!$this->session->all_userdata('session_id')) && (!$this->session->all_userdata('logado'))) {
          redirect('aski/login');
      	}
	}

}

?>