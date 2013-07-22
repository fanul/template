<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class News extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $gridId = "tabel-newscontrol";
        $searchId = "searchnewscontrol";
        $output['title'] = 'Data Master News Control';

        $colModel['news_id'] = array('Id News', 100, TRUE, 'center', 0, TRUE);
        $colModel['sys_user_name'] = array('Pembuat', 100, TRUE, 'center', 1);
        $colModel['news_publish_date'] = array('Tanggal Dibuat', 100, TRUE, 'center', 1);
        $colModel['news_edit_date'] = array('Terakhir Diperbarui', 100, TRUE, 'center', 1);
        $colModel['news_title'] = array('Judul', 100, TRUE, 'center', 1);
        $colModel['news_is_display'] = array('Ditampilkan?', 100, TRUE, 'center', 1);
        $colModel['news_is_periodic'] = array('Periodik?', 100, TRUE, 'center', 1);
        $colModel['news_start_date'] = array('Tanggal Mulai Ditampilkan', 100, TRUE, 'center', 1);
        $colModel['news_end_date'] = array('Tanggal Akhir Ditampilkan', 100, TRUE, 'center', 1);
        $colModel['news_is_public'] = array('Publik?', 100, TRUE, 'center', 1);
        $colModel['news_viewer'] = array('Daftar Pembaca', 100, TRUE, 'center', 1);



        $gridParams = array(
            'width' => 'auto',
            'height' => 250,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40,50]',
            'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} News.',
            'blockOpacity' => 0.5,
            'showTableToggleBtn' => false,
            'singleSelect' => false,
            'hide' => 'true'
        );
        $buttons[] = array('Pilih Semua', 'add', 'datanewscontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datanewscontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'datanewscontrol');
        $buttons[] = array('Edit Data', 'edit', 'datanewscontrol');
        $buttons[] = array('Hapus Data', 'delete', 'datanewscontrol');

        $buttons[] = array('separator');

        $buttons[] = array('Ganti Status', 'acc', 'datanewscontrol');
        $buttons[] = array('separator');

        $buttons[] = array('Print', 'print', 'datanewscontrol');
        $buttons[] = array('Access', 'access', 'datanewscontrol');


        // advanced search
        $params = '';
        if (isset($_POST['news_name']) && !is_null($_POST['news_name']) && $_POST['news_name'] != '') {
            $params .= 'news_name=' . $_POST['name_selector'] . '=' . $_POST['news_name'] . '&';
            $output['news_name'] = $_POST['news_name'];
            $output['collapsed'] = 1;
        }
        if (isset($_POST['news_detail']) && !is_null($_POST['news_detail']) && $_POST['news_detail'] != '') {
            $params .= 'news_detail=' . $_POST['detail_selector'] . '=' . $_POST['news_detail'] . '&';
            $output['news_detail'] = $_POST['news_detail'];
            $output['collapsed'] = 1;
        }
        //with advanced
        //$param = substr($params, 0, -1);
        //without advanced
        $param = '';

        // coloring
        $gridColor[0]['mode'] = 'col'; // (row or column coloring)
        $gridColor[0]['index'] = 3;
        $gridColor[0]['condition'] = array('Suspend' => 'yellow', 'Idle' => 'green');

        $site = site_url("news/news/datatable/" . $param);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'news_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;

        if (isset($_POST['name_selector']))
            $output['name_selector'] = $_POST['name_selector'];

        if (isset($_POST['detail_selector']))
            $output['detail_selector'] = $_POST['detail_selector'];

        $this->load->view('main_news', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('sys_user_name', 'news_publish_date_indo', 'news_title', 'news_is_display', 'news_is_periodic'
            , 'news_start_date_indo', 'news_end_date_indo', 'news_is_public', 'news_viewer');
        $this->flexigrid->validate_post('news_id', 'desc', $valid_fields);
        $records = $this->query->get_list_table('v_news', 'news_id', $param);

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
            $record_items[] = array($row->news_id, $row->news_id, $row->sys_user_name, $row->news_publish_date_indo, $row->news_title,
                $row->news_is_display, $row->news_is_periodic, $row->news_start_date_indo, $row->news_end_date_indo,
                $row->news_is_public, $row->news_viewer);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $output['title'] = 'Tambah News';
        $output['newscontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("news/news/add");
        //$output['karyawan_nik'] = $this->generate_nik();
        $this->load->view('form_news2', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_news', 'news_id', $id);
        $output['title'] = 'Edit News';

        $output['news_id'] = $record->news_id;
        $output['sys_user_name'] = $record->sys_user_name;
        $output['news_title'] = $record->news_title;
        $output['news_is_display'] = $record->news_is_display;
        $output['news_is_periodic'] = $record->news_is_periodic;
        $output['news_start_date'] = $record->news_start_date_indo;
        $output['news_end_date'] = $record->news_end_date_indo;
        $output['news_is_public'] = $record->news_is_public;
        $output['news_viewer'] = $record->news_viewer;
        $output['news_content'] = $record->news_content;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'news_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("news/news/edit");
        $this->load->view('form_news2', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('news', 'news_id', $value);
            $text .= 'nama: ' . $detail->news_title . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-newscontrol").flexReload();';
        $output['send_url'] = site_url("news/news/delete");
        $this->load->view('form_delete', $output);
    }

    public function add() {

        $data['sys_user_id'] = $this->session->userdata('sys_user_id');
        $data['news_title'] = $this->input->post('box_news_title');
        $data['news_is_display'] = $this->input->post('box_news_title');
        $data['news_is_periodic'] = $this->input->post('box_news_is_periodic');
        $data['news_start_date'] = date_format(date_create($this->input->post('box_news_start_date')), 'Y-m-d h:i:s');
        $data['news_end_date'] = date_format(date_create($this->input->post('box_news_end_date')), 'Y-m-d h:i:s');
        $data['news_is_public'] = $this->input->post('box_news_is_public');
        $data['news_viewer'] = $this->input->post('box_news_viewer');
        $data['news_content'] = htmlspecialchars($this->input->post('box_news_content',false));

        $date = getdate();
        $data['news_publish_date'] = $date['year'].'-'.$date['month'].'-'.$date['mday'].' '.
                $date['hours'].':'.$date['minutes'].':'.$date['seconds'];
        

        $id = $this->db->insert('news', $data);

        $this->log->insert("Menambahkan News " . $data['news_title'], $id, 'news');

        echo 'ok';
    }

    public function edit() {

        //$data['sys_user_id'] = $this->input->post('box_sys_user_id');
        $data['news_publish_date'] = date_format(date_create($this->input->post('box_news_publish_date')), 'Y-m-d h:i:s');
        $data['news_title'] = $this->input->post('box_news_title');
        $data['news_is_display'] = $this->input->post('box_news_is_display');
        $data['news_is_periodic'] = $this->input->post('box_news_is_periodic');
        $data['news_start_date'] = date_format(date_create($this->input->post('box_news_start_date')), 'Y-m-d h:i:s');
        $data['news_end_date'] = date_format(date_create($this->input->post('box_news_end_date')), 'Y-m-d h:i:s');
        $data['news_is_public'] = $this->input->post('box_news_is_public');
        $data['news_viewer'] = $this->input->post('box_news_viewer');
        $data['news_content'] = htmlspecialchars($this->input->post('box_news_content',false));

        $id = $this->db->update('news', $data, array('news_id' => $this->input->post('box_news_id')));

        $this->log->insert("Mengedit News " . $data['news_title'], $id, 'news');

        echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('news', 'news_id', $value);
            $id = $this->db->delete('news', array('news_id' => $value));

            $this->log->insert("Menghapus News " . $record->news_title, $id, 'news');
        }
        echo 'ok';
    }

    public function search_grouped_employee() {
        $keyword = $this->input->post('term');

        $data['response'] = 'false';

        $search['hr_employee_nik'] = $keyword;
        $search['hr_employee_nick_name'] = $keyword;
        $search['sys_user_name'] = $keyword;
        $search['sys_group_name'] = $keyword;

        $group_by = 'sys_group_id';

        $query = $this->query->lookup_table_or('v_employee', $search, null, null, null, $group_by);

        $result = '<option value=""></option>';
        if ($query->num_rows() > 0) {
            $grouped = null;
            foreach ($query->result() as $row) {

                if($grouped != $row->sys_group_id)
                {
                    $result .= '<optgroup label="'.$row->sys_group_name.'">';
                    $grouped = $row->sys_group_id;
                }

                $result.='<option>'.$row->hr_employee_nick_name.'</option>';
            }
        }
        echo $result;
    }

}

?>
