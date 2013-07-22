<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Group extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $gridId = "tabel-groupcontrol";
        $searchId = "searchgroupcontrol";
        $output['title'] = 'Data Master Group Control';

        $colModel['sys_group_id'] = array('Id Group', 100, TRUE, 'center', 0, TRUE);
        $colModel['sys_group_name'] = array('Nama Group', 100, TRUE, 'center', 1);
        $colModel['sys_group_detail'] = array('Detail', 100, TRUE, 'center', 1);
        $colModel['sys_group_status'] = array('Status', 100, TRUE, 'center', 1);

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
        $buttons[] = array('Pilih Semua', 'add', 'datagroupcontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datagroupcontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'datagroupcontrol');

        $buttons[] = array('Edit Data', 'edit', 'datagroupcontrol');

        $buttons[] = array('Hapus Data', 'delete', 'datagroupcontrol');


        $buttons[] = array('separator');

        $buttons[] = array('Ganti Status', 'acc', 'datagroupcontrol');
        $buttons[] = array('separator');

        $buttons[] = array('Print', 'print', 'datagroupcontrol');
        $buttons[] = array('Access', 'access', 'datagroupcontrol');


        // advanced search
        $params = '';
        if (isset($_POST['sys_group_name']) && !is_null($_POST['sys_group_name']) && $_POST['sys_group_name'] != '') {
            $params .= 'sys_group_name=' . $_POST['name_selector'] . '=' . $_POST['sys_group_name'] . '&';
            $output['sys_group_name'] = $_POST['sys_group_name'];
            $output['collapsed'] = 1;
        }
        if (isset($_POST['sys_group_detail']) && !is_null($_POST['sys_group_detail']) && $_POST['sys_group_detail'] != '') {
            $params .= 'sys_group_detail=' . $_POST['detail_selector'] . '=' . $_POST['sys_group_detail'] . '&';
            $output['sys_group_detail'] = $_POST['sys_group_detail'];
            $output['collapsed'] = 1;
        }
        $param = substr($params, 0, -1);

        // coloring
        
          $gridColor[0]['mode'] = 'col'; // (row or column coloring)
          $gridColor[0]['index'] = 3;
          $gridColor[0]['condition'] = array('Suspend'=>'yellow','Idle'=>'green');
         

        $site = site_url("admin/group/datatable/" . $param);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'sys_group_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;

        if (isset($_POST['name_selector']))
            $output['name_selector'] = $_POST['name_selector'];

        if (isset($_POST['detail_selector']))
            $output['detail_selector'] = $_POST['detail_selector'];

        $this->load->view('main_group', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('sys_group_name', 'sys_group_detail', 'sys_group_status');
        $this->flexigrid->validate_post('sys_group_id', 'desc', $valid_fields);
        $records = $this->query->get_list_table('sys_group', 'sys_group_id', $param);

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
            $record_items[] = array($row->sys_group_id, $row->sys_group_id, $row->sys_group_name, $row->sys_group_detail, $row->sys_group_status);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $output['title'] = 'Tambah Group';
        $output['groupcontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("admin/group/add");
        //$output['karyawan_nik'] = $this->generate_nik();
        $this->load->view('form_group', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('sys_group', 'sys_group_id', $id);
        $output['title'] = 'Edit Group';

        $output['sys_group_id'] = $record->sys_group_id;
        $output['sys_group_name'] = $record->sys_group_name;
        $output['sys_group_detail'] = $record->sys_group_detail;
        $output['sys_group_status'] = $record->sys_group_status;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'sys_group_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("admin/group/edit");
        $this->load->view('form_group', $output);
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('sys_group', 'sys_group_id', $id);
        $output['title'] = 'Printing Group';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("admin/group/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_group', 'sys_group_id', $value);
            $text .= 'nama: ' . $detail->sys_group_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-groupcontrol").flexReload();';
        $output['send_url'] = site_url("admin/group/delete");
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
        $output['function'] = '$("#tabel-groupcontrol").flexReload();';
        $output['send_url'] = site_url("admin/group/status");
        $this->load->view('form_change', $output);
    }

    public function prepare_access() {
        $output['title'] = 'Tambah Akses';
        $output['groupcontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("admin/group/access");
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
        foreach ($data as $key => $value) {
            $selected = "";
            if (isset($sys_group_status)) {
                if ($value == $sys_group_status)
                    $selected = "selected";
            }
            echo "<option value='$value' $selected>$value</option>";
        }
    }

    public function access() {
        print_r($_POST);
        echo 'ok';
    }

    public function add() {

        $data['sys_group_name'] = $this->input->post('box_group_name');
        $data['sys_group_detail'] = $this->input->post('box_group_detail');
        $data['sys_group_status'] = $this->input->post('box_group_status');

        $id = $this->db->insert('sys_group', $data);

        $this->log->insert("Menambahkan Group " . $data['sys_group_name'], $id, 'sys_group');

        echo 'ok';
    }

    public function edit() {

        $data['sys_group_name'] = $this->input->post('box_group_name');
        $data['sys_group_detail'] = $this->input->post('box_group_detail');
        $data['sys_group_status'] = $this->input->post('box_group_status');


        $id = $this->db->update('sys_group', $data, array('sys_group_id' => $this->input->post('box_group_id')));

        $this->log->insert("Mengedit Group " . $data['sys_group_name'], $id, 'sys_group');

        echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('sys_group', 'sys_group_id', $value);
            $id = $this->db->delete('sys_group', array('sys_group_id' => $value));

            $this->log->insert("Menghapus Group " . $record->sys_group_name, $id, 'sys_group');
        }
        echo 'ok';
    }

    public function status() {

        $data['sys_group_status'] = $this->input->post('wfstatus_change');
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_group', 'sys_group_id', $value);
            $id = $this->db->update('sys_group', $data, array('sys_group_id' => $value));
            $this->log->insert("Update Status Group " . $detail->sys_group_name, $id, 'sys_group');
        }

        echo 'ok';
    }

    public function popup($id) {
        $output['url'] = site_url('admin\group\cetak_individu_pdf' . '\\' . $id);
        $this->load->view('popup', $output);
    }

    public function printing($id) {
        $params = explode('PRINTING', $id);
        if (count($params) > 1) {
            $via = $this->my_encrypt->decode($params[1]);
            $id = $this->my_encrypt->decode($params[0]);

            $record = $this->query->get_detail('sys_group', 'sys_group_id', $id);
            $output['data'] = $record;
            $output['id'] = $id;

            switch ($via) {
                case 'Web':
                    $this->load->view('print\print_group', $output);
                    break;
                case 'Web - Auto Print':
                    $output['auto'] = true;
                    $this->load->view('print\print_group', $output);
                    break;
                case 'Pdf' :
                    $this->printing_pdf($id);
                    break;
                case 'Excel' :
                    $this->printing_excel($id);
                    break;
                default: break;
            }
        } else
            show_404();
    }

    public function printing_pdf($id) {
        $this->load->helper('pdf');

        $record = $this->query->get_detail('sys_group', 'sys_group_id', $id);
        $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_group', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('sys_group', 'sys_group_id', $id);

        $this->load->library('pxl');
        $laporan = new PHPExcel();
        $laporan->getProperties()->setTitle("Daftar Pelanggaran Karyawan")->setDescription("Laporan");
        $laporan->setActiveSheetIndex(0);
        $worksheet1 = 'Daftar ';
        $laporan->getActiveSheet()->setTitle($worksheet1);
        $laporan->getActiveSheet()->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(6);
        $laporan->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $laporan->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $laporan->getActiveSheet()->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $laporan->getActiveSheet()->setCellValue("A1", "Laporan");
        $laporan->getActiveSheet()->mergeCells('A1:L1');
        $laporan->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $laporan->getActiveSheet()->getStyle('A1')->getFont()->setSize(25);

        // ** border
        $myBorder = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $allBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $row = 2;

        foreach ($record as $item => $value) {
            $laporan->getActiveSheet()->setCellValue("A" . $row++, $value);
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($laporan, 'Excel5');
        $objWriter->save('php://output');
    }

    public function notification() {
        
    }

}

?>
