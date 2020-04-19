<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostCategory_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('post_category')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('post_category')->row();
    }

    public function findAll() {
        return $this->db->get('post_category');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('post_category');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');

        $this->db->insert('post_category', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function create_post_in_category($data = []) {
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');

        $this->db->insert('post_in_category', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('post_category', $data);

        return $update;
    }

    public function delete($id = "") {
        $this->db->where('id', $id);
        $delete = $this->db->delete('post_category');

        $this->db->where('category_id', $id);
        $delete2 = $this->db->delete('post_in_category');

        return $delete;
    }

    public function deleteAllByAttributes($datas = []) {
        if (count($datas) > 0) {
            foreach ($datas as $attr => $val) {
                $this->db->where($attr, $val);
            }
            return $this->db->delete('post_category');
        }

        return false;
    }

    public function delete_post_in_category($datas = []) {
        if (count($datas) > 0) {
            foreach ($datas as $attr => $val) {
                $this->db->where($attr, $val);
            }
            return $this->db->delete('post_in_category');
        }

        return false;
    }

    public function get_items() {
        $this->db->select('post_category.id, post_category.slug, post_category.title');

        $results = $this->db->get('post_category')->result_array();
        return $results;
    }
}
