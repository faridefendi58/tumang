<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_HIDDEN = 'hidden';
    const TYPE_PAGE = 'page';
    const TYPE_POST = 'post';
    const TYPE_CUSTOM_LINK = 'custom_link';
    const TYPE_CATEGORY = 'category';

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function findByPk($id) {
        $this->db->where('id', $id);
        return $this->db->get('menus')->row();
    }

    public function findByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('menus')->row();
    }

    public function findAll() {
        return $this->db->get('menus');
    }

    public function findAllByAttributes($datas = []) {
        foreach ($datas as $attr => $val) {
            $this->db->where($attr, $val);
        }

        return $this->db->get('menus');
    }

    public function create($data = []) {
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');

        $this->db->insert('menus', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data) {
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('id', $data['id']);
        $update = $this->db->update('menus', $data);

        return $update;
    }

    public function delete($id = "") {
        if (empty($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $delete = $this->db->delete('menus');

        return $delete;
    }

    public function is_menu_exists($slug) {
        $this->db->where('slug', $slug);
        $query = $this->db->get('menus');
        if ($query->num_rows() > 0){
            return true;
        }

        return false;
    }

    public function get_item($datas = []) {
        $this->db->select('menus.*, menu_groups.title AS group_name');
        foreach ($datas as $attr => $val) {
            $this->db->where('menus.'. $attr, $val);
        }

        $this->db->join('menu_groups', 'menu_groups.id = menus.group_id', 'left');
        return $this->db->get('menus')->row();
    }

    public function get_items($datas = []) {
        $items = [];
        $this->db->select('menus.*, menu_groups.title AS group_name, menus2.title AS parent');
        foreach ($datas as $attr => $val) {
            $this->db->where('menus.'. $attr, $val);
        }

        $this->db->join('menus AS menus2', 'menus2.id = menus.parent_id', 'left');
        $this->db->join('menu_groups', 'menu_groups.id = menus.group_id', 'left');
        $models = $this->db->get('menus');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }

    public function get_group_items() {
        $items = [];
        $models = $this->db->get('menu_groups');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
        }

        return $items;
    }

    public function get_next_sort_order($group_id = 0, $parent_id = 0) {
        $next_order = 1;
        if ($group_id > 0) {
            $this->db->select('MAX(sort_order) AS max_order');
            $this->db->where('menus.group_id', $group_id);
            $this->db->where('menus.parent_id', $parent_id);
            $query = $this->db->get('menus');
            if ($query->num_rows() > 0){
                $next_order = $query->row()->max_order + 1;
            }
        }

        return $next_order;
    }

    private $r_items = [];

    public function get_recursive_items($parent_id = 0, $level = 0) {
        $this->db->select('menus.id, menus.title');
        $this->db->where('menus.parent_id', $parent_id);
        $this->db->where('menus.level', $level);

        //$this->db->order_by("menus.sort_order", "asc");
        $models = $this->db->get('menus');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
            foreach ($items as $i => $item) {
                $label = str_repeat("- ", $level).''.$item['title'];
                array_push($this->r_items, ['id' => $item['id'], 'title' => $label]);
                if ($this->has_child($item['id'])) {
                    $new_level = $level + 1;
                    $this->get_recursive_items($item['id'], $new_level);
                }
            }
        }

        return $this->r_items;
    }

    private function has_child($id) {
        $this->db->select('menus.id');
        $this->db->where('menus.parent_id', $id);
        $num_rows = $this->db->get('menus')->num_rows();

        return ($num_rows > 0)? true : false;
    }

    private $s_items = '';

    public function get_sortable_items($group_id = 0, $parent_id = 0, $level = 0, $data_module = null) {
        $this->db->select('menus.id, menus.title');
        $this->db->where('menus.group_id', $group_id);
        $this->db->where('menus.parent_id', $parent_id);
        $this->db->where('menus.level', $level);
        //$this->db->order_by("menus.sort_order", "asc");
        $models = $this->db->get('menus');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
            foreach ($items as $i => $item) {
                if (empty($data_module)) {
                    $data_module = $item['id'];
                }
                $update_btn = '<a href="javascript:void(0);" class="pull-right"><i class="fa fa-pencil" id="'. site_url('panel-admin/menus/update/'. $item['id']) .'"></i></a>';
                $this->s_items .= '<li class="sortableListsOpen" id="'. $item['id'] .'" data-module="'. $data_module .'"><div><i class="fa fa-arrows-alt"></i>'.$item['title'].' '. $update_btn .'</div>';
                if ($this->has_child($item['id'])) {
                    $this->s_items .= '<ul>';
                    $new_level = $level + 1;
                    $this->get_sortable_items($group_id, $item['id'], $new_level, $data_module);
                    $this->s_items .= '</ul>';
                }
                $this->s_items .= '</li>';
            }
        }

        return $this->s_items;
    }

    public function get_types($_type = null) {
        $items = [
            self::TYPE_PAGE => 'Page',
            self::TYPE_POST => 'Post',
            self::TYPE_CUSTOM_LINK => 'Custom Link',
            self::TYPE_CATEGORY => 'Category'
        ];

        if (!empty($_type)) {
            return $items[$_type];
        }

        return $items;
    }

    public function get_arr_items($group_id = 0, $parent_id = 0, $level = 0) {
        $this->db->select('menus.id, menus.title, menus.slug, menus.type');
        $this->db->where('menus.parent_id', $parent_id);
        $this->db->where('menus.level', $level);
        if ($group_id > 0) {
            $this->db->where('menus.group_id', $group_id);
        }

        $models = $this->db->get('menus');
        $_items = [];
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
            foreach ($items as $i => $item) {
                if ($this->has_child($item['id'])) {
                    $_items[$level][$item['id']] = ['label' => $item['title'], 'url' => '#', 'items' => self::child($item['id']), 'visible' => true];
                } else {
                    $_items[$level][$item['id']] = ['label' => $item['title'], 'url' => ($item['type'] == 'custom_link')? $item['slug'] : site_url($item['slug']), 'visible' => true];
                }
            }
        }

        return $_items[$level];
    }

    private function child($parent_id)
    {
        $this->db->select('menus.id, menus.title, menus.slug, menus.type');
        $this->db->where('menus.parent_id', $parent_id);

        $models = $this->db->get('menus');
        $_items = [];
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
            foreach ($items as $i => $item) {
                if ($this->has_child($item['id'])) {
                    $_items[] = ['label' => $item['title'], 'url' => '#', 'items'=>self::child($item['id']), 'visible' => true];
                } else {
                    $_items[] = ['label' => $item['title'], 'url' => ($item['type'] == 'custom_link')? $item['slug'] : site_url($item['slug']), 'visible' => true];
                }
            }
        }

        return $_items;
    }

    private $bs_items = '';

    public function get_bootstrap_menus($group_id = 0, $parent_id = 0, $level = 0, $options = []) {
        $this->db->select('menus.id, menus.title, menus.slug, menus.type');
        $this->db->where('menus.group_id', $group_id);
        $this->db->where('menus.parent_id', $parent_id);
        $this->db->where('menus.level', $level);
        $this->db->order_by('menus.sort_order', 'asc');

        $models = $this->db->get('menus');
        if ($models->num_rows() > 0) {
            $items = $models->result_array();
            foreach ($items as $i => $item) {
                $url = ($item['type'] == 'custom_link')? $item['slug'] : site_url($item['slug']);
                if (empty($data_module)) {
                    $data_module = $item['id'];
                }
                $this->bs_items .= '<li class="'. $options['li_class'] .'" >';
                if ($this->has_child($item['id'])) {
                    $this->bs_items .= '<a href="#" class="'. $options['a_class'] .'">'. $item['title'] .' <i class="flaticon-down-arrow"></i></a>';
                    $this->bs_items .= '<ul class="'. $options['ul_sub_class'] .'">';
                    $new_level = $level + 1;
                    $this->get_bootstrap_menus($group_id, $item['id'], $new_level, $options);
                    $this->bs_items .= '</ul>';
                } else {
                    $this->bs_items .= '<a href="'. $url .'" class="nav-link active">'. $item['title'] .'</a>';
                }
                $this->bs_items .= '</li>';
            }
        }

        return $this->bs_items;
    }
}
