<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuGroup_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('menu_groups')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('menu_groups')->row();
    }

    public function findAll() {
        return $this->db->get('menu_groups');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('menu_groups');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');

        $this->db->insert('menu_groups', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('menu_groups', $data);

        return $update;
    }

    public function delete($id = "") {
        $this->db->where('id', $id);
        $delete = $this->db->delete('menu_groups');

        return $delete;
    }

    public function deleteAllByAttributes($datas = []) {
        if (count($datas) > 0) {
            foreach ($datas as $attr => $val) {
                $this->db->where($attr, $val);
            }
            return $this->db->delete('menu_groups');
        }

        return false;
    }

    public function get_items() {
        $this->db->select('menu_groups.id, menu_groups.title, menu_groups.code');

        $results = $this->db->get('menu_groups')->result_array();
        return $results;
    }
}
