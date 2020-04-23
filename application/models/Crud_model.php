<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function update_system_settings() {
        $data['value'] = html_escape($this->input->post('system_name'));
        $this->db->where('key', 'system_name');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('system_title'));
        $this->db->where('key', 'system_title');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('author'));
        $this->db->where('key', 'author');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('slogan'));
        $this->db->where('key', 'slogan');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('language'));
        $this->db->where('key', 'language');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('text_align'));
        $this->db->where('key', 'text_align');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('system_email'));
        $this->db->where('key', 'system_email');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('address'));
        $this->db->where('key', 'address');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('phone'));
        $this->db->where('key', 'phone');
        $this->db->update('settings', $data);
        
        $data['value'] = html_escape($this->input->post('fax'));
        $this->db->where('key', 'fax');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('youtube_api_key'));
        $this->db->where('key', 'youtube_api_key');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('vimeo_api_key'));
        $this->db->where('key', 'vimeo_api_key');
        $this->db->update('settings', $data);

        /*$data['value'] = html_escape($this->input->post('purchase_code'));
        $this->db->where('key', 'purchase_code');
        $this->db->update('settings', $data);*/

        $data['value'] = html_escape($this->input->post('footer_text'));
        $this->db->where('key', 'footer_text');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('footer_link'));
        $this->db->where('key', 'footer_link');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('website_keywords'));
        $this->db->where('key', 'website_keywords');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('website_description'));
        $this->db->where('key', 'website_description');
        $this->db->update('settings', $data);
    }

    function trim_and_return_json($untrimmed_array) {
        $trimmed_array = array();
        if(sizeof($untrimmed_array) > 0){
            foreach ($untrimmed_array as $row) {
                if ($row != "") {
                    array_push($trimmed_array, $row);
                }
            }
        }
        return json_encode($trimmed_array);
    }

    public function get_course_thumbnail_url($course_id) {

         if (file_exists('uploads/thumbnails/course_thumbnails/'.$course_id.'.jpg'))
             return base_url().'uploads/thumbnails/course_thumbnails/'.$course_id.'.jpg';
        else
            return base_url().'uploads/thumbnails/thumbnail.png';
    }

    public function get_course_by_id($course_id = "") {
        return $this->db->get_where('course', array('id' => $course_id));
    }

    public function get_top_courses() {
        return $this->db->get_where('course', array('is_top_course' => 1, 'status' => 'active'));
    }

    public function update_frontend_settings() {
        $data['value'] = html_escape($this->input->post('banner_title'));
        $this->db->where('key', 'banner_title');
        $this->db->update('frontend_settings', $data);

        $data['value'] = html_escape($this->input->post('banner_sub_title'));
        $this->db->where('key', 'banner_sub_title');
        $this->db->update('frontend_settings', $data);


        $data['value'] = $this->input->post('about_us');
        $this->db->where('key', 'about_us');
        $this->db->update('frontend_settings', $data);

        $data['value'] = $this->input->post('terms_and_condition');
        $this->db->where('key', 'terms_and_condition');
        $this->db->update('frontend_settings', $data);

        $data['value'] = $this->input->post('privacy_policy');
        $this->db->where('key', 'privacy_policy');
        $this->db->update('frontend_settings', $data);
    }

    public function update_frontend_banner() {
        move_uploaded_file($_FILES['banner_image']['tmp_name'], 'uploads/frontend/home-banner.jpg');
    }

    public function update_theme() {
        $data = [];
        $data['value'] = $this->input->post('Themes')['name'];
        $this->db->where('key', 'theme');
        $this->db->update('settings', $data);
    }

    public function handleWishList($course_id) {
        $wishlists = array();
        $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        if ($user_details['wishlist'] == "") {
            array_push($wishlists, $course_id);
        }else {
            $wishlists = json_decode($user_details['wishlist']);
            if (in_array($course_id, $wishlists)) {
                $container = array();
                foreach ($wishlists as $key) {
                    if ($key != $course_id) {
                        array_push($container, $key);
                    }
                }
                $wishlists = $container;
                // $key = array_search($course_id, $wishlists);
                // unset($wishlists[$key]);
            }else {
                array_push($wishlists, $course_id);
            }
        }

        $updater['wishlist'] = json_encode($wishlists);
        $this->db->where('id', $this->session->userdata('user_id'));
        $this->db->update('users', $updater);
    }

    public function is_added_to_wishlist($course_id = "") {
        if ($this->session->userdata('user_login') == 1) {
            $wishlists = array();
            $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
            $wishlists = json_decode($user_details['wishlist']);
            if (in_array($course_id, $wishlists)) {
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

    public function getWishLists() {
        $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        return json_decode($user_details['wishlist']);
    }

    public function get_latest_10_course() {
        $this->db->order_by("id", "desc");
        $this->db->limit('10');
        $this->db->where('status', 'active');
        return $this->db->get('course')->result_array();
    }

    /*
     * Edit page data
     */
    public function edit_pages($page_id) {
        $data = $this->input->post('Pages');
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');
        $this->db->where('id', $page_id);
        $this->db->update('pages', $data);
    }

    /*
     * Add new page
     */
    public function add_page() {
        $data = $this->input->post('Pages');
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');
        $this->db->insert('pages', $data);
    }

    /*
     * Delete page
     */
    public function delete_page($page_id) {
        $this->db->where('id', $page_id);
        $this->db->delete('pages');
    }

    /*
     * Edit post data
     */
    public function edit_posts($post_id) {
        $data = $this->input->post('Posts');
        $data['updated_at'] = date('c');
        $data['updated_by'] = $this->session->userdata('user_id');
        $this->db->where('id', $post_id);
        $this->db->update('posts', $data);
    }

    /*
     * Add new post
     */
    public function add_post() {
        $data = $this->input->post('Posts');
        $data['created_at'] = date('c');
        $data['created_by'] = $this->session->userdata('user_id');
        $this->db->insert('posts', $data);
    }

    /*
     * Delete post
     */
    public function delete_post($post_id) {
        $this->db->where('id', $post_id);
        $this->db->delete('posts');
    }

    public function update_logo() {
        $theme = get_settings('theme');
        if (isset($_FILES['logo'])) {
            $theme_setting = get_settings($theme .'_theme');
            $upload_folder = 'assets/frontend/'. $theme .'/img';
            if (!is_dir($upload_folder)) {
                mkdir($upload_folder, 0700, TRUE);
            }
            move_uploaded_file($_FILES['logo']['tmp_name'], $upload_folder.'/'.$_FILES['logo']['name']);
            $data = [];
            if (!empty($theme_setting)) {
                $theme_setting = json_decode($theme_setting, true);
                $theme_setting['logo'] = $upload_folder.'/'. $_FILES['logo']['name'];
                $data['value'] = json_encode($theme_setting);
                $this->db->where('key', $theme .'_theme');
                $this->db->update('settings', $data);
            } else {
                $theme_setting = [ 'logo' => $upload_folder.'/'. $_FILES['logo']['name'] ];
                $data['key'] = $theme .'_theme';
                $data['value'] = json_encode($theme_setting);
                $this->db->insert('settings', $data);
            }
        }
    }
    
    public function update_banner_text(){
        $data['title'] = $this->input->post('title');
        $data['sub_title'] = $this->input->post('sub_title');
        $data['content'] = $this->input->post('content');
        $data['button_link'] = $this->input->post('button_link');
        $data['button_text'] = $this->input->post('button_text');
        
        $file_handle = fopen('assets/banner_text.json', 'w'); 
        fwrite($file_handle, json_encode($data));
        fclose($file_handle);
    }
}
