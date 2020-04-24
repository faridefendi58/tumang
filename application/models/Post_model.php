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
        $data['featured_image'] = $this->upload_featured_image($data);
        
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');

        $this->db->insert('posts', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['featured_image'] = $this->upload_featured_image($data);
        
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
    
    public function get_by_category($cat_id, $limit = 20) {
        $this->db->select('posts.*, post_in_category.*');
        $this->db->join('posts', 'posts.id = post_in_category.post_id', 'left');
        $this->db->where('post_in_category.category_id', $cat_id);
        $this->db->order_by('posts.created_at', 'desc');
        $this->db->limit($limit);

        return $this->db->get('post_in_category')->result_array();
    }
    
    public function get_last_five(){
        $this->db->select('meta_title, slug');
        $this->db->order_by('created_at', 'desc');
        $this->db->limit(5);
        $result = $this->db->get('posts')->result_array();
        
        return $this->db->get('posts')->result_array();
    }
    
    public function upload_featured_image($data){
        //echo "<pre>";print_r($_FILES);die;
        if (isset($_FILES['Posts']['tmp_name']) && $_FILES['Posts']['name'] != "") {
            $name = $data['slug'].'.jpg';
            move_uploaded_file($_FILES['Posts']['tmp_name']['featured_image'], 'uploads/posts/'.$name);
            //$this->session->set_flashdata('flash_message', get_phrase('post_featured_image_successfully'));
            return $name;
        }
        return "default.jpg";
    }

    public function get_comments($data = []) {
        $this->db->select('*');
        if (isset($data['post_id'])) {
            $this->db->where('post_id', $data['post_id']);
        }

        if (isset($data['status'])) {
            $this->db->where('status', $data['status']);
        }

        $this->db->order_by('id', 'desc');
        $limit = 20;
        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $this->db->limit($limit);

        $items = $this->db->get('post_comments')->result_array();

        return $items;
    }
}
