<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Work_shift extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $gridId = "tabel-work_shiftcontrol";
        $searchId = "searchwork_shiftcontrol";
        $output['title'] = 'Data Master Event Type Control';

        $colModel['hr_work_shift_id'] = array('Id Group', 100, TRUE, 'center', 0, TRUE);
        $colModel['hr_work_shift_name'] = array('Nama Shift', 100, TRUE, 'center', 1);
        $colModel['hr_work_shift_start_time'] = array('Waktu Mulai', 100, TRUE, 'center', 1);
        $colModel['hr_work_shift_end_time'] = array('Waktu Berakhir', 100, TRUE, 'center', 1);

        if($this->session->userdata('sys_group_name')=='admin')
            $colModel['hr_work_shift_is_delete'] = array('dihapus?', 100, TRUE, 'center', 1);


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
        $buttons[] = array('Pilih Semua', 'add', 'datawork_shiftcontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datawork_shiftcontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'datawork_shiftcontrol');
        $buttons[] = array('Edit Data', 'edit', 'datawork_shiftcontrol');
        $buttons[] = array('Hapus Data', 'delete', 'datawork_shiftcontrol');

        if($this->session->userdata('sys_group_name')=='admin')
            $buttons[] = array('Purge Data', 'purge', 'datawork_shiftcontrol');


        // advanced search
        $params = '';
        /*
          if (isset($_POST['work_shift_name']) && !is_null($_POST['work_shift_name']) && $_POST['work_shift_name'] != '') {
          $params .= 'work_shift_name=' . $_POST['name_selector'] . '=' . $_POST['work_shift_name'] . '&';
          $output['work_shift_name'] = $_POST['work_shift_name'];
          $output['collapsed'] = 1;
          }
          if (isset($_POST['work_shift_detail']) && !is_null($_POST['work_shift_detail']) && $_POST['work_shift_detail'] != '') {
          $params .= 'work_shift_detail=' . $_POST['detail_selector'] . '=' . $_POST['work_shift_detail'] . '&';
          $output['work_shift_detail'] = $_POST['work_shift_detail'];
          $output['collapsed'] = 1;
          }
          $param = substr($params, 0, -1);
         */

        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("option/work_shift/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'work_shift_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;
        
        if (isset($_POST['name_selector']))
            $output['name_selector'] = $_POST['name_selector'];

        if (isset($_POST['detail_selector']))
            $output['detail_selector'] = $_POST['detail_selector'];

        $this->load->view('main_work_shift', $output);
    }

    public function datatable($param = NULL) {

        if($this->session->userdata('sys_group_name')=='admin')
            $valid_fields = array('hr_work_shift_name', 'hr_work_shift_start_time','hr_work_shift_end_time','hr_work_shift_is_delete');
        else
            $valid_fields = array('hr_work_shift_name', 'hr_work_shift_start_time','hr_work_shift_end_time');

        $this->flexigrid->validate_post('hr_work_shift_id', 'asc', $valid_fields);

        if(!$this->session->userdata('sys_group_name')=='admin')
            $where['hr_work_shift_is_delete'] = '0';
        else
            $where = NULL;

        $records = $this->query->get_list_table('v_work_shift', 'hr_work_shift_id', NULL, $where);

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
            if($this->session->userdata('sys_group_name')=='admin')
                $record_items[] = array($row->hr_work_shift_id, $row->hr_work_shift_id, $row->hr_work_shift_name, $row->hr_work_shift_start_time, $row->hr_work_shift_end_time, $row->hr_work_shift_is_delete);
            else
                $record_items[] = array($row->hr_work_shift_id, $row->hr_work_shift_id, $row->hr_work_shift_name, $row->hr_work_shift_start_time, $row->hr_work_shift_end_time);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $output['title'] = 'Tambah Work Shift';
        $output['work_shiftcontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("option/work_shift/add");
        //$output['karyawan_nik'] = $this->generate_nik();
        $this->load->view('form_work_shift', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_work_shift', 'hr_work_shift_id', $id);
        $output['title'] = 'Edit Work Shift';

        $output['work_shift_id'] = $record->hr_work_shift_id;
        $output['work_shift_name'] = $record->hr_work_shift_name;
        $output['work_shift_start_time'] = $record->hr_work_shift_start_time;
        $output['work_shift_end_time'] = $record->hr_work_shift_end_time;

        if($this->session->userdata('sys_group_name')=='admin')
            $output['work_shift_is_delete'] = $record->hr_work_shift_is_delete;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'work_shift_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("option/work_shift/edit");
        $this->load->view('form_work_shift', $output);
    }


    public function prepare_purge() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('v_work_shift', 'hr_work_shift_id', $value);
            $text .= 'nama: ' . $detail->hr_work_shift_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-work_shiftcontrol").flexReload();';
        $output['send_url'] = site_url("option/work_shift/purge");
        $this->load->view('form_delete', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('v_work_shift', 'hr_work_shift_id', $value);
            $text .= 'nama: ' . $detail->hr_work_shift_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-work_shiftcontrol").flexReload();';
        $output['send_url'] = site_url("option/work_shift/delete");
        $this->load->view('form_delete', $output);
    }


    public function add() {

        $data['hr_work_shift_name'] = $this->input->post('box_work_shift_name');
        $data['hr_work_shift_start_time'] = $this->input->post('box_work_shift_start_time');
        $data['hr_work_shift_end_time'] = $this->input->post('box_work_shift_end_time');

        $id = $this->db->insert('hr_work_shift', $data);

        $this->log->insert("Menambahkan Work Shift " . $data['hr_work_shift_name'], $id, 'hr_work_shift');

        echo 'ok';
    }

    public function edit() {

        $data['hr_work_shift_name'] = $this->input->post('box_work_shift_name');
        $data['hr_work_shift_start_time'] = $this->input->post('box_work_shift_start_time');
        $data['hr_work_shift_end_time'] = $this->input->post('box_work_shift_end_time');


        $id = $this->db->update('hr_work_shift', $data, array('hr_work_shift_id' => $this->input->post('box_work_shift_id')));

        $this->log->insert("Menambahkan Work Shift " . $data['hr_work_shift_name'], $id, 'hr_work_shift');


        echo 'ok';
    }

    public function purge() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('v_work_shift', 'hr_work_shift_id', $value);
            $id = $this->db->delete('hr_work_shift', array('hr_work_shift_id' => $value));

            $this->log->insert("Purge Work Shift " . $record->hr_work_shift_name, $id, 'hr_work_shift');
        }
        echo 'ok';
    }

    public function delete() {

        $data['hr_work_shift_is_delete'] = '1';
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('v_work_shift', 'hr_work_shift_id', $value);
            $id = $this->db->update('hr_work_shift', $data, array('hr_work_shift_id' => $value));
            $this->log->insert("Status Delete Work Shift " . $record->hr_work_shift_name, $id, 'hr_work_shift');
        }

        echo 'ok';
    }

}

?>
