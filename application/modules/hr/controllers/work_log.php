<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Work_log extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $gridId = "tabel-work_logcontrol";
        $searchId = "searchwork_logcontrol";
        $output['title'] = 'Data Master Event Type Control';

        $colModel['hr_work_time_indo'] = array('Waktu', 100, TRUE, 'center', 1);
        $colModel['hr_employee_nik'] = array('NIK', 100, TRUE, 'center', 1);
        $colModel['hr_employee_full_name'] = array('Nama Karyawan', 100, TRUE, 'center', 1);
        $colModel['hr_work_log_inout'] = array('IN / OUT', 100, TRUE, 'center', 1);
        $colModel['hr_work_log_special'] = array('Acara Spesial', 100, TRUE, 'center', 1);
        $colModel['hr_work_log_permission'] = array('Izin', 100, TRUE, 'center', 1);


        // if($this->session->userdata('sys_group_name')=='admin')
        //     $colModel['hr_work_log_is_delete'] = array('dihapus?', 100, TRUE, 'center', 1);


        $gridParams = array(
            'width' => 'auto',
            'height' => 250,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40,50]',
            'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} Track Type.',
            'blockOpacity' => 0.5,
            'showTableToggleBtn' => false,
            'singleSelect' => false,
            'hide' => 'true'
        );
        $buttons[] = array('Pilih Semua', 'add', 'datawork_logcontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datawork_logcontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'datawork_logcontrol');
        // $buttons[] = array('Edit Data', 'edit', 'datawork_logcontrol');
        $buttons[] = array('Hapus Data', 'delete', 'datawork_logcontrol');

        // if($this->session->userdata('sys_group_name')=='admin')
        //     $buttons[] = array('Purge Data', 'purge', 'datawork_logcontrol');


        // advanced search
        $params = '';
        /*
          if (isset($_POST['work_log_name']) && !is_null($_POST['work_log_name']) && $_POST['work_log_name'] != '') {
          $params .= 'work_log_name=' . $_POST['name_selector'] . '=' . $_POST['work_log_name'] . '&';
          $output['work_log_name'] = $_POST['work_log_name'];
          $output['collapsed'] = 1;
          }
          if (isset($_POST['work_log_detail']) && !is_null($_POST['work_log_detail']) && $_POST['work_log_detail'] != '') {
          $params .= 'work_log_detail=' . $_POST['detail_selector'] . '=' . $_POST['work_log_detail'] . '&';
          $output['work_log_detail'] = $_POST['work_log_detail'];
          $output['collapsed'] = 1;
          }
          $param = substr($params, 0, -1);
         */

        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("hr/work_log/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'work_log_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;
        
        if (isset($_POST['name_selector']))
            $output['name_selector'] = $_POST['name_selector'];

        if (isset($_POST['detail_selector']))
            $output['detail_selector'] = $_POST['detail_selector'];

        $this->load->view('main_work_log', $output);
    }

    public function datatable($param = NULL) {

	    // if($this->session->userdata('sys_group_name')=='admin')
	    //     $valid_fields = array('hr_work_log_time', 'hr_work_log_start_time','hr_work_log_end_time','hr_work_log_is_delete');
	    // else
	    //     $valid_fields = array('hr_work_log_name', 'hr_work_log_start_time','hr_work_log_end_time');

    	$valid_fields = array('hr_work_log_time', 'hr_employee_nik','hr_employee_full_name','hr_work_log_inout',
    							'hr_work_log_special', 'hr_work_log_permission');
        $this->flexigrid->validate_post('hr_work_log_time', 'desc', $valid_fields);

        // if(!$this->session->userdata('sys_group_name')=='admin')
        //     $where['hr_work_log_is_delete'] = '0';
        // else
        //     $where = NULL;

        $records = $this->query->get_list_table('v_work_log', 'hr_work_log_time');

        $this->output->set_header($this->config->item('json_header'));
        $result = $records['records']->result();

        if (!is_null($param) && $result == NULL) {
            $record_items[] = array();
            $records['record_count'] = 0;
        } else if (!is_null($param)) {
            $records['record_count'] = count($result);
        } else if ($result == NULL)
            $record_items[] = array();

        foreach ($result as $row) {
            // if($this->session->userdata('sys_group_name')=='admin')
            //     $record_items[] = array($row->hr_work_log_id, $row->hr_work_log_id, $row->hr_work_log_name, $row->hr_work_log_start_time, $row->hr_work_log_end_time, $row->hr_work_log_is_delete);
            // else
            //     $record_items[] = array($row->hr_work_log_id, $row->hr_work_log_id, $row->hr_work_log_name, $row->hr_work_log_start_time, $row->hr_work_log_end_time);

                $record_items[] = array($row->hr_work_log_time_indo, $row->hr_work_log_time_indo, $row->hr_employee_nik, $row->hr_employee_full_name, $row->hr_work_log_inout, $row->hr_work_log_special, $row->hr_work_log_permission);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $output['title'] = 'Tambah Work Shift';
        $output['work_logcontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("hr/work_log/add");
        //$output['karyawan_nik'] = $this->generate_nik();
        $this->load->view('form_work_log', $output);
    }

    // public function prepare_edit() {
    //     $id = $this->input->post('id');
    //     $record = $this->query->get_detail('v_work_log', 'hr_work_log_id', $id);
    //     $output['title'] = 'Edit Work Shift';

    //     $output['hr_work_log_time'] = $record->hr_work_log_time;
    //     $output['hr_employee_nik'] = $record->hr_employee_nik;
    //     $output['hr_work_log_special'] = $record->hr_work_log_special;
    //     $output['hr_work_log_permission'] = $record->hr_work_log_permission;

    //     // if($this->session->userdata('sys_group_name')=='admin')
    //     //     $output['work_log_is_delete'] = $record->hr_work_log_is_delete;

    //     $output['kode_disable'] = 'disabled';
    //     $output['tombol'] = 'Update';
    //     // $output['form'] = form_input(array('name' => 'work_log_id_old', 'value' => $id, 'type' => 'hidden'));
    //     $output['send_url'] = site_url("hr/work_log/edit");
    //     $this->load->view('form_work_log', $output);
    // }


    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $value = date_format(date_create($value), 'Y-m-d h:i:s');
            $detail = $this->query->get_detail('v_work_log', 'hr_work_log_time', $value);
            $text .= 'nama: ' . $detail->hr_work_log_time_indo . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-work_logcontrol").flexReload();';
        $output['send_url'] = site_url("hr/work_log/delete");
        $this->load->view('form_delete', $output);
    }

    // public function prepare_delete() {

    //     $id = $this->input->post('ids');

    //     $text = '';
    //     $items = explode('|', substr($id, 0, -1));

    //     foreach ($items as $item => $value) {
    //         $detail = $this->query->get_detail('v_work_log', 'hr_work_log_id', $value);
    //         $text .= 'nama: ' . $detail->hr_work_log_name . '<br>';
    //     }

    //     $output['text'] = $text;
    //     $output['form'] = form_input(array(
    //         'name' => 'items',
    //         'id' => 'items',
    //         'value' => $id,
    //         'type' => 'hidden'));
    //     $output['function'] = '$("#tabel-work_logcontrol").flexReload();';
    //     $output['send_url'] = site_url("hr/work_log/delete");
    //     $this->load->view('form_delete', $output);
    // }


    public function add() {

    	$data['hr_employee_nik'] = $this->input->post('box_employee_nik');
    	$data['hr_work_log_time'] = date_format(date_create($this->input->post('box_work_log_time')), 'Y-m-d h:i:s');
    	$data['hr_work_log_special'] = $this->input->post('box_work_log_special');
    	$data['hr_work_log_permission'] = $this->input->post('box_work_log_permission');

        $search['hr_work_log_time'] = substr($data['hr_work_log_time'], 0, 10);
        $search['hr_employee_nik'] = $data['hr_employee_nik'];
        $record = $this->query->lookup_table_or('v_work_log', $search);

        if($record->num_rows() > 0)
            $data['hr_work_log_inout'] = 1;
        else
            $data['hr_work_log_inout'] = 0;

        $id = $this->db->insert('hr_work_log', $data);

        $this->log->insert("Menambahkan Work Shift " . $data['hr_work_log_time'], $id, 'hr_work_log');

        echo 'ok';
    }

    // public function edit() {

    // 	$data['hr_work_log_time'] = $this->input->post('box_work_log_time');
    // 	$data['hr_employee_nik'] = $this->input->post('box_employee_nik');
    // 	$data['hr_work_log_time'] = $this->input->post('box_work_log_time');
    // 	$data['hr_work_log_special'] = $this->input->post('box_work_log_special');
    // 	$data['hr_work_log_permission'] = $this->input->post('box_work_log_permission');

    //     $id = $this->db->update('hr_work_log', $data, array('hr_work_log_time' => $this->input->post('box_work_log_id')));

    //     $this->log->insert("Menambahkan Work Shift " . $data['hr_work_log_name'], $id, 'hr_work_log');


    //     echo 'ok';
    // }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $value = date_format(date_create($value), 'Y-m-d h:i:s');
            $record = $this->query->get_detail('v_work_log', 'hr_work_log_time', $value);
            $id = $this->db->delete('hr_work_log', array('hr_work_log_time' => $value));

            $this->log->insert("Hapus Work Log " . $record->hr_work_log_time_indo, $id, 'hr_work_log');
        }
        echo 'ok';
    }

    public function search_employee() {
        $keyword = $this->input->post('term');

        $data['response'] = 'false';

        $search['hr_employee_nik'] = $keyword;
        $search['hr_employee_nick_name'] = $keyword;
        $search['hr_employee_full_name'] = $keyword;
        $query = $this->query->lookup_table_or('v_employee', $search);

        if ($query->num_rows() > 0) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query->result() as $row) {
                $data['message'][] = array('label' => $row->hr_employee_nik, 'nama' => $row->hr_employee_nick_name);
            }
        }
        echo json_encode($data);
    }


}

?>
