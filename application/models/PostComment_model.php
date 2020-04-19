<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostComment_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('post_comments')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('post_comments')->row();
    }

    public function findAll() {
        return $this->db->get('post_comments');
    }

    public function findAllByAttributes($datas = []) {
        $this->db->select('post_comments.*, posts.meta_title AS post_title, posts.slug AS post_slug');
        foreach ($datas as $attr => $val) {
            $this->db->where('post_comments.'. $attr, $val);
        }

        $this->db->join('posts', 'posts.id = post_comments.post_id', 'left');
        return $this->db->get('post_comments');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');

        $this->db->insert('post_comments', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['updated_at'] = date('c');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('post_comments', $data);

        return $update;
    }

    public function delete($id = "") {
        if (empty($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $delete = $this->db->delete('post_comments');

        return $delete;
    }
}
