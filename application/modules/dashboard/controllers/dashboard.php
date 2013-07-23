<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    function index() {
        $output['notification'] = '?';

        $tes = $this->render_notif();
        $output['notif_list']['notif_list']['notif_list'] = $tes;

        $output['menu'] = $this->render_menu();

        $this->load->view('dashboard', $output);
    }

    public function render_notif() {
        $where['sys_user_id'] = $this->session->userdata('sys_user_id');
        $where['sys_notif_status'] = 0;
        $notif = $this->query->get_list_basic('sys_notif', $where);
        return $notif;
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('');
    }

    public function prepare_toolbar_notification() {
        
    }

    public function welcome() {

        $where['news_is_display'] = '1';
        $result = $this->query->get_list_basic('v_news',$where);
        $output['news'] = $this->render_news($result);
        $this->load->view('welcome',$output);
    }

    public function render_news($news=null)
    {
        $proced = array();
        if(!is_null($news))
        {
            foreach ($news as $item ) {
                $oke = false;

                if($item->news_is_periodic)
                {
                    $date = getdate();
                    $today = $date['year'].'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'].':'.$date['seconds'];;
                    if(strtotime($today) >= strtotime($item->news_start_date) && strtotime($today) <= strtotime($item->news_end_date))
                    {
                        $oke = true;
                    }
                }

                if(!$item->news_is_public)
                {
                    if(strstr($this->session->userdata('sys_user_id'),$item->news_viewer))
                        $oke = true;

                } else $oke = true;

                if($oke)
                    $proced[] = $item;

            }
        }
        return $proced;
    }

    public function render_menu() {
        $component = array();
        $detail = $this->query->get_list_basic('v_acl', array('sys_group_id' => $this->session->userdata('sys_group_id')));
        foreach ($detail as $item) {
            $component['page'][$item->sys_url] = true;
            $component['priv'][$item->sys_privillage] = true;
        }

        return $component;
    }

}

?>
