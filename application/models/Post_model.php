<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_HIDDEN = 'hidden';

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('posts')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('posts')->row();
    }

    public function findAll() {
        return $this->db->get('posts');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('posts');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');

        $this->db->insert('posts', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('posts', $data);

        return $update;
    }

    public function delete($id = "") {
        if (empty($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $delete = $this->db->delete('posts');

        $this->db->where('post_id', $id);
        $delete2 = $this->db->delete('post_in_category');

        return $delete;
    }

    public function is_post_exists($slug) {
        $this->db->where('slug', $slug);
        $query = $this->db->get('posts');
        if ($query->num_rows() > 0){
            return true;
        }

        return false;
    }

    public function get_item($datas = []) {
        $this->db->select('posts.*, CONCAT(u.first_name, " ", u.last_name) AS created_by_name');
        foreach ($datas as $attr => $val) {
            $this->db->where('posts.'. $attr, $val);
        }

        $this->db->join('users AS u', 'u.id = posts.created_by', 'left');
        $row = $this->db->get('posts')->row();

        if (!empty($row->tags)) {
            str_replace(", ",",",$row->tags);
            $row->tags = explode(",", $row->tags);
        }

        return $row;
    }
}
