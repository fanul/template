<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pict extends CI_Controller {

	public function __construct(){
            parent::__construct();
            if($this->session->userdata('username') == NULL ) redirect('user/login', 'refresh');
    }

	function index()
	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}
	
	public function upload() {
		$config['upload_path'] = './userpict/';
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= '1024';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$err = '';
			foreach($error as $er){
				$err .= "$er";
			}
			echo "<script type='text/javascript'>alert('Upload Error $err')</script>";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$data = $this->upload->data();
			$name = $data['file_name'];
			echo "<script type='text/javascript'>parent.displayPicture('$name');</script>";
		}
	}
	

	function do_upload()
	{
		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= '1024';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('upload_success', $data);
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */