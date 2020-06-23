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
    
    public function get_items_limit($limit){
        $items = [];
        $limit = (int)$limit;
        /*$this->db->select('section_chart.date, section_chart.open, section_chart.close, section_chart.low, section_chart.high');
        $this->db->order_by('section_chart.date', 'asc');
        $this->db->limit($limit);*/
        $sql = "SELECT date, open, close, low, high FROM (
                    SELECT * FROM tbl_section_chart ORDER BY date DESC LIMIT ?
                    ) sub
                ORDER BY date ASC";
        $models = $this->db->query($sql, [$limit]);
        if ($models->num_rows() > 0) {
            foreach ($models->result_array() as $data){
                $arr = [];
                $arr[] = date("d-m-Y", strtotime($data['date']));
                $arr[] = floatval($data['low']);
                $arr[] = floatval($data['open']);
                $arr[] = floatval($data['close']);
                $arr[] = floatval($data['high']);
                $arr[] = 'Open : '.$data['open'].'
                            Close : '.$data['close'].'
                            Low : '.$data['low'].'
                            High : '.$data['high']
                    ;
                $items[] = $arr;
            }
        }
        return json_encode($items);
    }
    
    public function get_last_item(){
        $this->db->select('section_chart.*');
        $this->db->order_by('section_chart.date', 'desc');
        $this->db->limit(1);
        $result = $this->db->get('section_chart')->row();
        $result->percent = number_format(abs((($result->close - $result->open) / $result->open) * 100), 2,',','.');
        return $result;
    }
}