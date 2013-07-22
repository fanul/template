<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oops extends CI_Controller {

	public function index()
	{
		$this->load->view('error_page');
	}
}
