<?php

class Secure extends CI_Controller {

    private $i = 0;

    function Application() {
        parent::__construct();
    }

    function secure() {
        $this->i+=1;

        //exception list
        $privillage[] = '';
        $privillage[] = 'dashboard';
        $privillage[] = 'public';
        $privillage[] = 'dc';

        $page[] = '';
        $page[] = 'dashboard';
        $page[] = 'public';
        $page[] = 'browse';
        $page[] = 'datatable';
        $page[] = 'login';
        $page[] = 'logout';
        $page[] = 'profile';





        $rawString = explode('/', uri_string());
        $context = & get_instance();

        if ($this->i == 1) {
 
            $cek = true;

            if (!in_array($rawString[0], $privillage) || (isset($rawString[1]) && !in_array($rawString[1], $page))) {

                if (isset($rawString[2])) {
                    if (!$context->acl->privillage($rawString[0], $rawString[1], $rawString[2])) {
                        //redirect('public/oops/index');
                        redirect(base_url(), 'refresh');
                    }
                } else {
                    if (!$context->acl->privillage($rawString[0], $rawString[1])) {
                        //redirect('public/oops/index');
                        redirect(base_url(), 'refresh');
                    }
                }

                //this
                if (!$context->input->is_ajax_request() && uri_string() != '')
                    redirect(base_url(), 'refresh');
            }
        }
    }

}

?>