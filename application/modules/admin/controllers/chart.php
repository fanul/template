<?php

class Chart extends CI_Controller {

    function Application() {
        parent::__construct();
        $this->load->library('highchart_lib');
    }

    function index() {
//        $data['charts'] = $this->getChart();
//        $this->load->view('main_chart', $data);

        $record = $this->query->get_list_basic('v_employee');

//        foreach ($record as $item) {
//            $h['time'] = date_format(date_create($item->sys_log_time_indo), 'h:i:s');
//            $h['name'] = $item->sys_log_table;
//            $hour[] = $h;
//            $date[] = date_format(date_create($item->sys_log_time_indo), 'd m Y');
//            $h[$item->hr_employee_nick_name] = $item->hr_employee_salary;
//        }
        $this->load->view('main_chartx', array('data' => $record));
    }

    function getData() {
        
    }

    function getChart() {
        $this->load->library('Highcharts');
        $this->highcharts->set_title(' - Login -');
        $this->highcharts->set_dimensions(740, 300);
        $this->highcharts->set_axis_titles('Date', 'Hour');
        $credits->href = base_url();
        $credits->text = "Code 2 Learn : HighCharts";
        $this->highcharts->set_credits($credits);
        $this->highcharts->render_to("graph");

//        if ($myrow = mysql_fetch_array($result)) {
//            do {
//                $value[] = intval($myrow["age"]);
//                $date[] = ($myrow["date"]);
//            } while ($myrow = mysql_fetch_array($result));
//        }

//        $order[]['sys_log_time'] = 'desc';
        $record = $this->query->get_list_basic('v_employee');

        foreach ($record as $item) {
//            $h['time'] = date_format(date_create($item->sys_log_time_indo), 'h:i:s');
//            $h['name'] = $item->sys_log_table;
//            $hour[] = $h;
//            $date[] = date_format(date_create($item->sys_log_time_indo), 'd m Y');
            $h[$item->hr_employee_nick_name] = $item->hr_employee_salary;
            $demo[] = $h;
        }

        $this->highcharts->push_xcategorie($demo);
        $this->highcharts->export_file("Code 2 Learn Chart" . date('d M Y'));

        return $this->highcharts->render();
    }

}

?>