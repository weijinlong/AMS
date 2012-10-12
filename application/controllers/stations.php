<?php

/**
 * stations controller.
 *
 * @package    AMS
 * @subpackage stations
 * @author     Nouman Tayyab
 */
class Stations extends CI_Controller {

    /**
     * constructor. Load layout,Model,Library and helpers
     * 
     */
    function __construct() {
        parent::__construct();
        $this->layout = 'main_layout.php';
        $this->load->model('station_model');
    }

    /**
     * List all the stations
     *  
     */
    public function index() {
        $data['stations'] = $this->station_model->get_all();
        $this->load->view('stations/list', $data);
    }

    /**
     * Show Detail of specific station
     * 
     * @param $station_id as a uri segment
     */
    public function detail() {
        $station_id = $this->uri->segment(3);
        $data['station_detail'] = $this->station_model->get_station_by_id($station_id);
        $this->load->view('stations/detail', $data);
    }

    /**
     * set or update the start time of station.
     * 
     * @param $id get id of a station
     * @param $start_date get station start date
     * @return json 
     */
    public function update_station_date() {
        if (isAjax()) {
            $station_id = $this->input->post('id');
            $start_date = $this->input->post('start_date');
            $station = $this->station_model->update_station($station_id, array('start_date' => $start_date));
            echo json_encode(array('success' => true, 'station' => $station));
            exit;
        }
    }

}

?>