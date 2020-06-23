<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('promo')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('promo')->row();
    }

    public function findAll() {
        return $this->db->get('promo');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('promo');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');

        $this->db->insert('promo', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('promo', $data);

        return $update;
    }

    public function delete($id = "") {
        if (empty($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $delete = $this->db->delete('promo');

        return $delete;
    }

    public function get_item($datas = []) {
        $this->db->select('promo.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('promo.'. $attr, $val);
        }
        return $this->db->get('promo')->row();
    }
    
    public function get_items($datas = []) {
        $items = [];
        $this->db->select('promo.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('promo.'. $attr, $val);
        }
        
        $models = $this->db->get('promo');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }
}