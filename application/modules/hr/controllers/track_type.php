<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Track_type extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $gridId = "tabel-track_typecontrol";
        $searchId = "searchtrack_typecontrol";
        $output['title'] = 'Data Master Group Control';

        $colModel['hr_track_type_id'] = array('Id Group', 100, TRUE, 'center', 0, TRUE);
        $colModel['hr_track_type_name'] = array('Nama Group', 100, TRUE, 'center', 1);
        $colModel['hr_track_type_det'] = array('Detail', 100, TRUE, 'center', 1);

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
        $buttons[] = array('Pilih Semua', 'add', 'datatrack_typecontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datatrack_typecontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'datatrack_typecontrol');

        $buttons[] = array('Edit Data', 'edit', 'datatrack_typecontrol');

        $buttons[] = array('Hapus Data', 'delete', 'datatrack_typecontrol');

        // advanced search
        $params = '';
        /*
          if (isset($_POST['hr_track_type_name']) && !is_null($_POST['hr_track_type_name']) && $_POST['hr_track_type_name'] != '') {
          $params .= 'hr_track_type_name=' . $_POST['name_selector'] . '=' . $_POST['hr_track_type_name'] . '&';
          $output['hr_track_type_name'] = $_POST['hr_track_type_name'];
          $output['collapsed'] = 1;
          }
          if (isset($_POST['hr_track_type_detail']) && !is_null($_POST['hr_track_type_detail']) && $_POST['hr_track_type_detail'] != '') {
          $params .= 'hr_track_type_detail=' . $_POST['detail_selector'] . '=' . $_POST['hr_track_type_detail'] . '&';
          $output['hr_track_type_detail'] = $_POST['hr_track_type_detail'];
          $output['collapsed'] = 1;
          }
          $param = substr($params, 0, -1);
         */

        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("hr/track_type/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'hr_track_type_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;

        if (isset($_POST['name_selector']))
            $output['name_selector'] = $_POST['name_selector'];

        if (isset($_POST['detail_selector']))
            $output['detail_selector'] = $_POST['detail_selector'];

        $this->load->view('main_track_type', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('hr_track_type_name', 'hr_track_type_det');
        $this->flexigrid->validate_post('hr_track_type_id', 'desc', $valid_fields);
        $records = $this->query->get_list_table('hr_track_type', 'hr_track_type_id', $param);

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
            $record_items[] = array($row->hr_track_type_id, $row->hr_track_type_id, $row->hr_track_type_name, $row->hr_track_type_det);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $output['title'] = 'Tambah Track Type';
        $output['track_typecontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("hr/track_type/add");
        //$output['karyawan_nik'] = $this->generate_nik();
        $this->load->view('form_track_type', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $id);
        $output['title'] = 'Edit Group';

        $output['hr_track_type_id'] = $record->hr_track_type_id;
        $output['hr_track_type_name'] = $record->hr_track_type_name;
        $output['hr_track_type_det'] = $record->hr_track_type_det;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'hr_track_type_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("hr/track_type/edit");
        $this->load->view('form_track_type', $output);
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $id);
        $output['title'] = 'Printing Group';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("hr/track_type/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $value);
            $text .= 'nama: ' . $detail->hr_track_type_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-track_typecontrol").flexReload();';
        $output['send_url'] = site_url("hr/track_type/delete");
        $this->load->view('form_delete', $output);
    }

    public function prepare_status() {
        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $value);
            $text .= 'nama: ' . $detail->hr_track_type_name . '<br>';
        }

        $output['text'] = $text;
        $output['data_master'] = 'change_status';
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-track_typecontrol").flexReload();';
        $output['send_url'] = site_url("hr/track_type/status");
        $this->load->view('form_change', $output);
    }

    public function add() {

        $data['hr_track_type_name'] = $this->input->post('box_track_type_name');
        $data['hr_track_type_det'] = $this->input->post('box_track_type_det');

        $id = $this->db->insert('hr_track_type', $data);

        $this->log->insert("Menambahkan Track Type " . $data['hr_track_type_name'], $id, 'hr_track_type');

        echo 'ok';
    }

    public function edit() {

        $data['hr_track_type_name'] = $this->input->post('box_track_type_name');
        $data['hr_track_type_det'] = $this->input->post('box_track_type_det');


        $id = $this->db->update('hr_track_type', $data, array('hr_track_type_id' => $this->input->post('box_track_type_id')));

        $this->log->insert("Mengedit Track Type " . $data['hr_track_type_name'], $id, 'hr_track_type');

        echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $value);
            $id = $this->db->delete('hr_track_type', array('hr_track_type_id' => $value));

            $this->log->insert("Menghapus Group " . $record->hr_track_type_name, $id, 'hr_track_type');
        }
        echo 'ok';
    }

    public function status() {

        $data['hr_track_type_status'] = $this->input->post('wfstatus_change');
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $value);
            $id = $this->db->update('hr_track_type', $data, array('hr_track_type_id' => $value));
            $this->log->insert("Update Status Group " . $detail->hr_track_type_name, $id, 'hr_track_type');
        }

        echo 'ok';
    }

    public function popup($id) {
        $output['url'] = site_url('hr\track_type\cetak_individu_pdf' . '\\' . $id);
        $this->load->view('popup', $output);
    }

    public function printing($id) {
        $params = explode('PRINTING', $id);
        if (count($params) > 1) {
            $via = $this->my_encrypt->decode($params[1]);
            $id = $this->my_encrypt->decode($params[0]);

            $record = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $id);
            $output['data'] = $record;
            $output['id'] = $id;

            switch ($via) {
                case 'Web':
                    $this->load->view('print\print_track_type', $output);
                    break;
                case 'Web - Auto Print':
                    $output['auto'] = true;
                    $this->load->view('print\print_track_type', $output);
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

        $record = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $id);
        $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_track_type', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('hr_track_type', 'hr_track_type_id', $id);

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
