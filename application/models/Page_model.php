<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {

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
        return $this->db->get('pages')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('pages')->row();
    }

    public function findAll() {
        return $this->db->get('pages');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('pages');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');

        $this->db->insert('pages', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('pages', $data);

        return $update;
    }

    public function delete($id = "") {
        if (empty($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $delete = $this->db->delete('pages');

        return $delete;
    }

    public function is_page_exists($slug) {
        $this->db->where('slug', $slug);
        $query = $this->db->get('pages');
        if ($query->num_rows() > 0){
            return true;
        }

        return false;
    }

    public function get_all_slugs() {
        $this->db->select('pages.slug');
        $results = $this->db->get('pages')->result_array();
        $items = [];
        if (count($results) > 0 ){
            foreach ($results as $i => $result) {
                array_push($items, $result['slug']);
            }
        }

        return $items;
    }

    public function get_all_published() {
        $this->db->select('pages.id, pages.slug, pages.meta_title');
        $this->db->where('status', self::STATUS_PUBLISHED);

        $results = $this->db->get('pages')->result_array();
        return $results;
    }
}
