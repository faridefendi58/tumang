<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_model extends CI_Model {

    const STATUS_PENDING = 'pending';
    const STATUS_CHECKED = 'checked';

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
    public function get_item($datas = []) {
        $this->db->select('section_chart.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('section_chart.'. $attr, $val);
        }

        return $this->db->get('section_chart')->row();
    }
    
    public function get_items($datas = []) {
        $items = [];
        $this->db->select('section_chart.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('section_chart.'. $attr, $val);
        }

        $this->db->order_by("section_chart.date", "desc");
        $models = $this->db->get('section_chart');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }
    
    public function is_date_chart_exists($date){
        $this->db->where('date', date("Y-m-d", strtotime($date)));
        $query = $this->db->get('section_chart');
        if ($query->num_rows() > 0){
            return true;
        }

        return false;
    }
    
    public function create($data){
        $data['date'] = date("Y-m-d", strtotime($data['date']));
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');

        $this->db->insert('section_chart', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }
    
    public function update($data) {
        $data['date'] = date("Y-m-d", strtotime($data['date']));
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('section_chart', $data);

        return $update;
    }
    
    public function delete($id = ""){
        $this->db->where('id', $id);
        $delete = $this->db->delete('section_chart');

        return $delete;
    }
    
    public function get_items_by_date($data){
        $items = [];
        $this->db->select('section_chart.date, section_chart.open, section_chart.close, section_chart.low, section_chart.high');
        $this->db->where('section_chart.date >=', $data['start']);
        $this->db->where('section_chart.date <=', $data['end']);

        $this->db->order_by("section_chart.date", "asc");
        $models = $this->db->get('section_chart');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }
}