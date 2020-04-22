<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('contact')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('contact')->row();
    }

    public function findAll() {
        return $this->db->get('contact');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('contact');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');

        $this->db->insert('contact', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {

        $this->db->where('id', $data['id']);
        $update = $this->db->update('contact', $data);

        return $update;
    }

    public function delete($id = "") {
        if (empty($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $delete = $this->db->delete('contact');

        return $delete;
    }

    public function get_item($datas = []) {
        $this->db->select('contact.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('contact.'. $attr, $val);
        }

        return $this->db->get('contact')->row();
    }

    public function get_items($datas = []) {
        $items = [];
        $this->db->select('contact.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('contact.'. $attr, $val);
        }

        $models = $this->db->get('contact');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }
}
