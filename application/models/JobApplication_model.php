<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JobApplication_model extends CI_Model {

    const STATUS_PENDING = 'pending';
    const STATUS_CHECKED = 'checked';

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('job_application')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('job_application')->row();
    }

    public function findAll() {
        return $this->db->get('job_application');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('job_application');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');

        $this->db->insert('job_application', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {

        $this->db->where('id', $data['id']);
        $update = $this->db->update('job_application', $data);

        return $update;
    }

    public function delete($id = "") {
        if (empty($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $delete = $this->db->delete('job_application');

        return $delete;
    }

    public function get_item($datas = []) {
        $this->db->select('job_application.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('job_application.'. $attr, $val);
        }

        return $this->db->get('job_application')->row();
    }

    public function get_items($datas = []) {
        $items = [];
        $this->db->select('job_application.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('job_application.'. $attr, $val);
        }

        $this->db->order_by("job_application.id", "desc");
        $models = $this->db->get('job_application');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }

    public function markAsChecked($id) {
        $this->db->where('id', $id);
        $data = ['status' => self::STATUS_CHECKED];
        $update = $this->db->update('job_application', $data);

        return $update;
    }
}
