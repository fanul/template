<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Track_record extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $id = $this->input->post('id');

        $detail = $this->query->get_detail('v_employee', 'hr_employee_nik', $id);

        $gridId = "tabel-track_recordcontrol";
        $searchId = "searchtrack_recordcontrol";
        $output['title'] = 'Data Master Family Of ' . $detail->hr_employee_full_name;

        $colModel['hr_track_record_id'] = array('Id', 100, TRUE, 'center', 0, TRUE);
        $colModel['hr_track_type_name'] = array('Jenis', 100, TRUE, 'center', 0);
        $colModel['hr_track_record_name'] = array('Nama', 100, TRUE, 'center', 1);
        $colModel['hr_track_record_date_indo'] = array('Tanggal', 100, TRUE, 'center', 1);
        $colModel['hr_track_record_det'] = array('Detail', 100, TRUE, 'center', 1);
        $colModel['hr_track_record_point'] = array('Point', 100, TRUE, 'center', 1);
        $colModel['hr_track_record_valid'] = array('Valid', 100, TRUE, 'center', 1);

        $gridParams = array(
            'width' => 'auto',
            'height' => 250,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40,50]',
            'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} Employee.',
            'blockOpacity' => 0.5,
            'showTableToggleBtn' => false,
            'singleSelect' => false,
            'hide' => 'true'
        );

        $buttons[] = array('Pilih Semua', 'add', 'datatrack_recordcontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datatrack_recordcontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'datatrack_recordcontrol');

        $buttons[] = array('Edit Data', 'edit', 'datatrack_recordcontrol');

        $buttons[] = array('Hapus Data', 'delete', 'datatrack_recordcontrol');

        // advanced search
        $params = $id;


        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("hr/track_record/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'hr_track_record_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;

        $output['form_main'] = form_input(array(
            'name' => 'form_main',
            'id' => 'form_main',
            'value' => $id,
            'type' => 'hidden'));
        $output['id'] = $id;


        $this->load->view('main_track_record', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('hr_track_record_name', 'hr_track_type_name',
            'hr_track_record_date_indo', 'hr_track_record_det', 'hr_track_record_point',
            'hr_track_record_valid');
        $this->flexigrid->validate_post('hr_track_record_id', 'asc', $valid_fields);
        $where['hr_employee_nik'] = $param;
        $records = $this->query->get_list_table('v_track_record', 'hr_track_record_id', NULL, $where);

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
            $record_items[] = array($row->hr_track_record_id, $row->hr_track_record_id,
                $row->hr_track_type_name, $row->hr_track_record_name, $row->hr_track_record_date_indo,
                $row->hr_track_record_det, $row->hr_track_record_point, $row->hr_track_record_valid,);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $id = $this->input->post('id');
        $output['title'] = 'Tambah Keluarga';
        $output['track_recordcontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("hr/track_record/add");

        $output['form'] = form_input(array(
            'name' => 'box_employee_nik',
            'id' => 'box_employee_nik',
            'value' => $id,
            'type' => 'hidden'));
        //$output['track_record_nik'] = $this->generate_nik();
        $this->load->view('form_track_record', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_track_record', 'hr_track_record_id', $id);
        $output['title'] = 'Edit Profile';
        //print_r($record);
        $output['hr_track_record_id'] = $record->hr_track_record_id;
        $output['hr_track_record_name'] = $record->hr_track_record_name;
        $output['hr_track_type_id'] = $record->hr_track_type_id;
        $output['hr_track_record_point'] = $record->hr_track_record_point;
        $output['hr_track_record_det'] = $record->hr_track_record_det;
        $output['hr_track_record_date_indo'] = $record->hr_track_record_date_indo;
        $output['hr_track_record_valid'] = $record->hr_track_record_valid;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'hr_track_record_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("hr/track_record/edit");
        $this->load->view('form_track_record', $output);
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('sys_track_record', 'sys_track_record_id', $id);
        $output['title'] = 'Printing Group';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("hr/track_record/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('hr_track_record', 'hr_track_record_id', $value);
            $text .= 'nama: ' . $detail->hr_track_record_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-track_recordcontrol").flexReload();';
        $output['send_url'] = site_url("hr/track_record/delete");
        $this->load->view('form_delete', $output);
    }

    public function prepare_detail() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_track_record', 'hr_track_record_nik', $id);
        $output['title'] = $record->hr_track_record_nick_name;
        $output['data_master'] = 'track_record_type_public';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['id'] = $id;
        //$output['send_url'] = site_url("hr/track_record/detail/" . $this->my_encrypt->encode($id));

        $output['record'] = $record;
        $this->load->view('detail_track_record', $output);
    }

    public function prepare_status() {
        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_track_record', 'sys_track_record_id', $value);
            $text .= 'nama: ' . $detail->sys_track_record_name . '<br>';
        }

        $output['text'] = $text;
        $output['data_master'] = 'change_status';
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-track_recordcontrol").flexReload();';
        $output['send_url'] = site_url("hr/track_record/status");
        $this->load->view('form_change', $output);
    }

    public function add() {

        $data['hr_employee_nik'] = $this->input->post('box_employee_nik');
        $data['hr_track_record_name'] = $this->input->post('box_track_record_name');
        $data['hr_track_type_id'] = $this->input->post('box_track_type_id');
        $data['hr_track_record_point'] = $this->input->post('box_track_record_point');
        $data['hr_track_record_det'] = $this->input->post('box_track_record_det');
        $data['hr_track_record_date'] = date_format(date_create($this->input->post('box_track_record_date_indo')), 'Y-m-d');
        $data['hr_track_record_valid'] = $this->input->post('box_track_record_valid');

        //$id = $this->db->update('hr_track_record', $data, array('hr_track_record_id' => $this->input->post('box_track_record_id')));
        $id = $this->db->insert('hr_track_record', $data);
        $this->log->insert("Menambah Track Record dengan ID" . $this->input->post('box_track_record_id'), $id, 'profile');

        echo 'ok';
    }

    public function edit() {

        $data['hr_track_record_name'] = $this->input->post('box_track_record_name');
        $data['hr_track_type_id'] = $this->input->post('box_track_type_id');
        $data['hr_track_record_point'] = $this->input->post('box_track_record_point');
        $data['hr_track_record_det'] = $this->input->post('box_track_record_det');
        $data['hr_track_record_date'] = date_format(date_create($this->input->post('box_track_record_date_indo')), 'Y-m-d');
        $data['hr_track_record_valid'] = $this->input->post('box_track_record_valid');

        $id = $this->db->update('hr_track_record', $data, array('hr_track_record_id' => $this->input->post('box_track_record_id')));

        $this->log->insert("Mengupdate Track Record " . $data['hr_track_record_name'], $id, 'hr_track_record');

        echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('hr_track_record', 'hr_track_record_id', $value);
            $id = $this->db->delete('hr_track_record', array('hr_track_record_id' => $value));

            $this->log->insert("Menghapus track_record " . $record->hr_track_record_name, $id, 'hr_track_record');
        }
        echo 'ok';
    }

    public function status() {

        $data['sys_track_record_status'] = $this->input->post('wfstatus_change');
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_track_record', 'sys_track_record_id', $value);
            $id = $this->db->update('sys_track_record', $data, array('sys_track_record_id' => $value));
            $this->log->insert("Update Status Group " . $detail->sys_track_record_name, $id, 'sys_track_record');
        }

        echo 'ok';
    }

    public function printing($id) {
        $params = explode('PRINTING', $id);
        if (count($params) > 1) {
            $via = $this->my_encrypt->decode($params[1]);
            $id = $this->my_encrypt->decode($params[0]);

            $record = $this->query->get_detail('sys_track_record', 'sys_track_record_id', $id);
            $output['data'] = $record;
            $output['id'] = $id;

            switch ($via) {
                case 'Web':
                    $this->load->view('print\print_track_record', $output);
                    break;
                case 'Web - Auto Print':
                    $output['auto'] = true;
                    $this->load->view('print\print_track_record', $output);
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

        $record = $this->query->get_detail('sys_track_record', 'sys_track_record_id', $id);
        $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_track_record', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('sys_track_record', 'sys_track_record_id', $id);

        $this->load->library('pxl');
        $laporan = new PHPExcel();
        $laporan->getProperties()->setTitle("Laporan ")->setDescription("Laporan");
        $laporan->setActiveSheetIndex(0);
        $worksheet1 = 'laporan Loh ';
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
