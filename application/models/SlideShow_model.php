<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SlideShow_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('slide_show')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('slide_show')->row();
    }

    public function findAll() {
        return $this->db->get('slide_show');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('slide_show');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');

        $this->db->insert('slide_show', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['updated_at'] = date('c');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('slide_show', $data);

        return $update;
    }

    public function delete($id = "") {
        if (empty($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $delete = $this->db->delete('slide_show');

        return $delete;
    }

    public function get_item($datas = []) {
        $this->db->select('slide_show.*, slide_show_category.title AS category_name');
        foreach ($datas as $attr => $val) {
            $this->db->where('slide_show.'. $attr, $val);
        }

        $this->db->join('slide_show_category', 'slide_show.category_id = slide_show_category.id', 'left');
        return $this->db->get('slide_show')->row();
    }

    public function get_items($datas = []) {
        $items = [];
        $this->db->select('slide_show.*, slide_show_category.title AS category_name');
        foreach ($datas as $attr => $val) {
            if ($attr != 'order_by') {
                $this->db->where('slide_show.' . $attr, $val);
            }
        }

        $this->db->join('slide_show_category', 'slide_show.category_id = slide_show_category.id', 'left');

        if (isset($datas['order_by'])) {
            $this->db->order_by("slide_show.". $datas['order_by'], "asc");
        } else {
            $this->db->order_by("slide_show.id", "desc");
        }

        $models = $this->db->get('slide_show');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }

    public function get_categories($datas = []) {
        $items = [];
        $this->db->select('slide_show_category.*');
        foreach ($datas as $attr => $val) {
            $this->db->where('slide_show_category.'. $attr, $val);
        }
        $this->db->order_by("slide_show_category.id", "desc");
        $models = $this->db->get('slide_show_category');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }
}
