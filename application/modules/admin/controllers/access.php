<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Access extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $id = $this->input->post('id');

        $detail = $this->query->get_detail('v_acl', 'sys_group_id', $id);
        if (count($detail) == 0)
            $detail = $this->query->get_detail('sys_group', 'sys_group_id', $id);

        $gridId = "tabel-accesscontrol";
        $searchId = "searchaccesscontrol";
        $output['title'] = 'Privillage Acces of ' . $detail->sys_group_name;

        $colModel['sys_group_id'] = array('Id Group', 100, TRUE, 'center', 0, TRUE);
        $colModel['sys_group_name'] = array('Nama Group', 100, TRUE, 'center', 1);
        $colModel['sys_privillage'] = array('Privillage', 100, TRUE, 'center', 1);
        $colModel['sys_page'] = array('Page', 100, TRUE, 'center', 1);
        $colModel['sys_access'] = array('Access', 100, TRUE, 'center', 1);
        $colModel['sys_url'] = array('Url', 100, TRUE, 'center', 1);

        $gridParams = array(
            'width' => 'auto',
            'height' => 250,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40,50]',
            'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} Group.',
            'blockOpacity' => 0.5,
            'showTableToggleBtn' => false,
            'singleSelect' => false,
            'hide' => 'true'
        );

        $buttons[] = array('Pilih Semua', 'add', 'dataaccesscontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'dataaccesscontrol');
        $buttons[] = array('separator');

        $buttons[] = array('Hapus Data', 'delete', 'dataaccesscontrol');
        
        $buttons[] = array('separator');
        $buttons[] = array('Access', 'access', 'dataaccesscontrol');


        // advanced search
        $params = $id;

        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("admin/access/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'sys_group_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;

        $output['form_main'] = form_input(array(
            'name' => 'form_main',
            'id' => 'form_main',
            'value' => $id,
            'type' => 'hidden'));
        $output['id'] = $id;

        if (isset($_POST['nocache']))
            $this->load->view('main_access', $output);
        else
            redirect(base_url(), 'refresh');
    }

    public function datatable($param = NULL) {
        $valid_fields = array('sys_group_name', 'sys_group_detail', 'sys_group_status', 'sys_privillage', 'sys_page', 'sys_access', 'sys_url');
        $this->flexigrid->validate_post('sys_group_id', 'desc', $valid_fields);

        $where['sys_group_id'] = $param;
        $records = $this->query->get_list_table('v_acl', 'sys_group_id', NULL, $where);

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
            $record_items[] = array($row->sys_acl_id, $row->sys_acl_id, $row->sys_group_name, $row->sys_privillage,
                $row->sys_page, $row->sys_access, $row->sys_url);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_acl', 'sys_acl_id', $value);
            $text .= 'acl: ' . $detail->sys_acl_id . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-accesscontrol").flexReload();';
        $output['send_url'] = site_url("admin/access/delete");
        $this->load->view('form_delete', $output);
    }

    public function prepare_status() {
        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_group', 'sys_group_id', $value);
            $text .= 'nama: ' . $detail->sys_group_name . '<br>';
        }

        $output['text'] = $text;
        $output['data_master'] = 'change_status';
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-accescontrol").flexReload();';
        $output['send_url'] = site_url("admin/group/status");
        $this->load->view('form_change', $output);
    }

    public function prepare_access() {

        $output['sys_group_id'] = $this->input->post('id');
        $output['title'] = 'Tambah Akses';
        $output['accesscontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("admin/access/analayze");
        $output['function'] = '$("#tabel-accescontrol").flexReload();';
        //$output['karyawan_nik'] = $this->generate_nik();
        $this->load->view('form_access', $output);
    }

    public function prepare_page() {
        $dir = './application/modules/' . $_POST['dir'] . '/controllers/';
        $data = $this->data_master->list_master_page($dir);
        $i = 0;
        foreach ($data as $key => $value) {
            $selected = "";
            if ($i++ == 0) {
                $selected = "selected";
            }
            echo "<option value='$value' $selected>$value</option>";
        }
    }

    public function prepare_function() {

        $dir = './application/modules/' . $_POST['dir'] . '/controllers/' . $_POST['page'] . '.php';
        $data = $this->data_master->list_master_function($dir, $_POST['page']);

        $where['sys_group_id'] = $_POST['id'];
        $where['sys_privillage'] = $_POST['dir'];
        $where['sys_page'] = $_POST['page'];
        $detail = $this->query->get_table('v_acl', $where);

        if (isset($detail->sys_access))
            $acc = explode(',', $detail->sys_access);
        else
            $acc = array();

        //print_r($acc);
        foreach ($data as $key => $value) {
            $selected = "";

            if (in_array($value, $acc)) {
                $selected = "selected='selected'";
            }
            echo "<option value='$value' $selected>$value</option>";
        }
    }

    public function analayze() {

        $data['sys_group_id'] = $this->input->post('box_group_id');
        $data['sys_privillage'] = $this->input->post('box_group_privillage');
        $data['sys_page'] = $this->input->post('box_group_page');
        $data['sys_access'] = $this->input->post('acc');
        $data['sys_url'] = $data['sys_privillage'] . '/' . $data['sys_page'];

        $where['sys_privillage'] = $data['sys_privillage'];
        $where['sys_page'] = $data['sys_page'];
        $cek = $this->db->from('v_acl')->where($where)->count_all_results();

        if ($cek == 0)
            $this->add($data);
        else
            $this->edit($data, $where);

        echo 'ok';
    }

    public function add($data) {

        $id = $this->db->insert('sys_acl', $data);

        $this->log->insert("Menambahkan acl ", $id, 'sys_acl');

        //echo 'ok';
    }

    public function edit($data, $where) {

        $id = $this->db->update('sys_acl', $data, $where);

        $this->log->insert("Menambahkan acl ", $id, 'sys_acl');


        //echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('sys_acl', 'sys_acl_id', $value);
            $id = $this->db->delete('sys_acl', array('sys_acl_id' => $value));

            $this->log->insert("Menghapus acl " . $record->sys_acl_id, $id, 'sys_acl');
        }
        echo 'ok';
    }

}

?>
