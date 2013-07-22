<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Syslog extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $gridId = "tabel-logcontrol";
        $searchId = "searchlogcontrol";
        $output['title'] = 'Data Master Log Control';

        $colModel['sys_log_id'] = array('Id Log', 100, TRUE, 'center', 0, TRUE);
        $colModel['sys_log_action'] = array('Nama Log', 200, TRUE, 'center', 1);
        $colModel['sys_log_row'] = array('Detail', 100, TRUE, 'center', 1);
        $colModel['sys_log_table'] = array('Tabel', 100, TRUE, 'center', 1);
        $colModel['sys_log_query'] = array('Query', 100, TRUE, 'center', 1);
        $colModel['sys_log_phase'] = array('Phase', 100, TRUE, 'center', 1);
        $colModel['sys_log_time_indo'] = array('Waktu', 100, TRUE, 'center', 1);


        $gridParams = array(
            'width' => 'auto',
            'height' => 250,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40,50]',
            'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} Log.',
            'blockOpacity' => 0.5,
            'showTableToggleBtn' => false,
            'singleSelect' => false,
            'hide' => 'true'
        );
        $buttons[] = array('Pilih Semua', 'add', 'datalogcontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datalogcontrol');
        $buttons[] = array('separator');

        $buttons[] = array('Hapus Data', 'delete', 'datalogcontrol');


        // advanced search
        $params = '';

        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("admin/syslog/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'sys_log_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;

        $this->load->view('main_log', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('sys_log_action', 'sys_log_row', 'sys_log_table', 'sys_log_query', 'sys_log_phase', 'sys_log_time_indo');
        $this->flexigrid->validate_post('sys_log_id', 'desc', $valid_fields);
        $records = $this->query->get_list_table('v_log', 'sys_log_id', $param);

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
            $record_items[] = array($row->sys_log_id, $row->sys_log_id, $row->sys_log_action, $row->sys_log_row, $row->sys_log_table,
                $row->sys_log_query, $row->sys_log_phase, $row->sys_log_time_indo);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('sys_log', 'sys_log_id', $id);
        $output['title'] = 'Printing Log';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("admin/syslog/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_log', 'sys_log_id', $value);
            $text .= 'nama: ' . $detail->sys_log_action . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-logcontrol").flexReload();';
        $output['send_url'] = site_url("admin/syslog/delete");
        $this->load->view('form_delete', $output);
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('sys_log', 'sys_log_id', $value);
            $id = $this->db->delete('sys_log', array('sys_log_id' => $value));

            //$this->log->insert("Menghapus Log " . $record->sys_log_name, $id, 'sys_log');
        }
        echo 'ok';
    }

    public function printing($id) {
        $params = explode('PRINTING', $id);
        if (count($params) > 1) {
            $via = $this->my_encrypt->decode($params[1]);
            $id = $this->my_encrypt->decode($params[0]);

            $record = $this->query->get_detail('sys_log', 'sys_log_id', $id);
            $output['data'] = $record;
            $output['id'] = $id;

            switch ($via) {
                case 'Web':
                    $this->load->view('print\print_log', $output);
                    break;
                case 'Web - Auto Print':
                    $output['auto'] = true;
                    $this->load->view('print\print_log', $output);
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

        $record = $this->query->get_detail('sys_log', 'sys_log_id', $id);
        $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_log', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('sys_log', 'sys_log_id', $id);

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
