<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel_admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index() {
        if ($this->session->userdata('admin_login') == true) {
            $this->dashboard();
        }else {
            $this->need_login();
        }
    }

    public function login() {
        if ($this->session->userdata('admin_login') == true) {
            redirect(site_url('panel-admin/dashboard'), 'refresh');
        } else {
            $this->load->view('backend/login.php');
        }
    }

    private function need_login() {
        $this->session->set_userdata('r', $this->uri->uri_string);
        redirect(site_url('panel-admin/login'), 'refresh');
    }

    public function validate_login($from = "") {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $credential = array('email' => $email, 'password' => sha1($password));

        // Checking login credential for admin
        $query = $this->db->get_where('users', $credential);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->role_id));
            $this->session->set_userdata('name', $row->first_name.' '.$row->last_name);
            if ($row->role_id == 1) {
                $this->session->set_userdata('admin_login', '1');
                $r = $this->session->userdata('r');
                if (!empty($r) && ($r != 'panel-admin/login')) {
                    $this->session->set_userdata('r', null);
                    redirect(site_url($r), 'refresh');
                } else {
                    redirect(site_url('panel-admin/dashboard'), 'refresh');
                }
            }else if($row->role_id == 2){
                $this->session->set_userdata('user_login', '1');
                redirect(site_url('home'), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error_message',get_phrase('invalid_login_credentials'));
            if ($from == "user")
                redirect(site_url('home'), 'refresh');
            else {
                redirect(site_url('panel-admin/login'), 'refresh');
            }

        }

    }

    public function logout($from = "") {
        //destroy sessions of specific userdata. We've done this for not removing the cart session
        $this->session_destroy();

        if ($from == "user")
            redirect(site_url('home'), 'refresh');
        else {
            redirect(site_url('panel-admin/login'), 'refresh');
        }
    }

    public function session_destroy() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('name');
        if ($this->session->userdata('admin_login') == 1) {
            $this->session->unset_userdata('admin_login');
        }else {
            $this->session->unset_userdata('user_login');
        }
    }

    public function forgot_password($from = "") {
        $email = $this->input->post('email');
        //resetting user password here
        $new_password = substr( md5( rand(100000000,20000000000) ) , 0,7);

        // Checking credential for admin
        $query = $this->db->get_where('users' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $this->db->where('email' , $email);
            $this->db->update('users' , array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password, $email);
            $this->session->set_flashdata('flash_message', get_phrase('please_check_your_email_for_new_password'));
            if ($from == 'backend') {
                $this->need_login();
            }else {
                redirect(site_url('home'), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error_message', get_phrase('password_reset_failed'));
            if ($from == 'backend') {
                $this->need_login();
            }else {
                redirect(site_url('home'), 'refresh');
            }
        }
    }

    public function dashboard() {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }
        $this->session->set_userdata('last_page', 'dashboard');
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('dashboard');
        $this->load->view('backend/index.php', $page_data);
    }

    public function blank_template() {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }
        $this->session->set_userdata('last_page', 'blank_template');
        $page_data['page_name'] = 'blank_template';
        $this->load->view('backend/index.php', $page_data);
    }

    public function lockscreen($status = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        if ($status == "lock") {
            $this->load->view('backend/admin/lockscreen.php');
        }else if($status == "unlock") {
            if ($this->user_model->unlock_screen_by_password($this->input->post('password'))) {
                redirect(site_url('panel-admin/dashboard'), 'refresh');
            }else {
                $this->session->set_flashdata('error_message',get_phrase('invalid_password'));
                redirect(site_url('panel-admin/lockscreen/lock'), 'refresh');
            }
        }
    }

    public function users($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }
        if ($param1 == "add") {
            $this->user_model->add_user();
            redirect(site_url('panel-admin/users'), 'refresh');
        }
        elseif ($param1 == "edit") {
            $this->user_model->edit_user($param2);
            redirect(site_url('panel-admin/users'), 'refresh');
        }
        elseif ($param1 == "delete") {
            $this->user_model->delete_user($param2);
            redirect(site_url('panel-admin/users'), 'refresh');
        }

        $this->session->set_userdata('last_page', 'users');
        $page_data['page_name'] = 'users';
        $page_data['page_title'] = get_phrase('student');
        $page_data['users'] = $this->user_model->get_user($param2);
        $this->load->view('backend/index', $page_data);
    }

    public function user_form($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        if ($param1 == 'add_user_form') {
            $page_data['page_name'] = 'user_add';
            $page_data['page_title'] = get_phrase('student_add');
            $this->load->view('backend/index', $page_data);
        }
        elseif ($param1 == 'edit_user_form') {
            $page_data['page_name'] = 'user_edit';
            $page_data['user_id'] = $param2;
            $page_data['page_title'] = get_phrase('student_edit');
            $this->load->view('backend/index', $page_data);
        }
    }

    public function system_settings($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        if ($param1 == 'system_update') {
            $this->crud_model->update_system_settings();
            $this->session->set_flashdata('flash_message', get_phrase('system_settings_updated'));
            redirect(site_url('panel-admin/system_settings'), 'refresh');
        }

        if ($param1 == 'logo_upload') {
            move_uploaded_file($_FILES['logo']['tmp_name'], 'assets/backend/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('backend_logo_updated'));
            redirect(site_url('panel-admin/system_settings'), 'refresh');
        }

        if ($param1 == 'favicon_upload') {
            move_uploaded_file($_FILES['favicon']['tmp_name'], 'assets/favicon.png');
            $this->session->set_flashdata('flash_message', get_phrase('favicon_updated'));
            redirect(site_url('panel-admin/system_settings'), 'refresh');
        }

        $this->session->set_userdata('last_page', 'system_settings');
        $page_data['page_name'] = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function frontend_settings($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        if ($param1 == 'frontend_update') {
            $this->crud_model->update_frontend_settings();
            $this->session->set_flashdata('flash_message', get_phrase('frontend_settings_updated'));
            redirect(site_url('panel-admin/frontend_settings'), 'refresh');
        }

        if ($param1 == 'banner_image_update') {
            $this->crud_model->update_frontend_banner();
            $this->session->set_flashdata('flash_message', get_phrase('banner_image_update'));
            redirect(site_url('panel-admin/frontend_settings'), 'refresh');
        }

        if ($param1 == 'logo_upload') {
            $this->crud_model->update_logo();

            $this->session->set_flashdata('flash_message', get_phrase('frontend_logo_updated'));
            redirect(site_url('panel-admin/frontend_settings'), 'refresh');
        }

        if ($param1 == 'theme_update') {
            $this->crud_model->update_theme();
            $this->session->set_flashdata('flash_message', get_phrase('theme_update'));
            redirect(site_url('panel-admin/frontend_settings'), 'refresh');
        }

        $this->session->set_userdata('last_page', 'frontend_settings');
        $page_data['page_name'] = 'frontend_settings';
        $page_data['page_title'] = get_phrase('frontend_settings');
        $page_data['themes'] = get_themes();
        $this->load->view('backend/index', $page_data);
    }

    public function manage_language($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] = $param2;
        }
        if ($param1 == 'update_phrase') {
            $language     = $param2;
            $total_phrase = $this->input->post('total_phrase');
            for ($i = 1; $i < $total_phrase; $i++) {
                //$data[$language]    =    $this->input->post('phrase').$i;
                $this->db->where('phrase_id', $i);
                $this->db->update('language', array(
                    $language => $this->input->post('phrase' . $i)
                ));
            }
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(site_url('panel-admin/manage_language/edit_phrase/' . $language), 'refresh');
        }
        if ($param1 == 'do_update') {
            $language        = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(site_url('panel-admin/manage_language'), 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = html_escape($this->input->post('phrase'));
            $this->db->insert('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('phrase_added'));
            redirect(site_url('panel-admin/manage_language'), 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);

            $this->session->set_flashdata('flash_message', get_phrase('language_added'));
            redirect(site_url('panel-admin/manage_language'), 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('flash_message', get_phrase('language_deleted'));

            redirect(site_url('panel-admin/manage_language'), 'refresh');
        }
        $this->session->set_userdata('last_page', 'manage_language');
        $page_data['page_name']  = 'manage_language';
        $page_data['page_title'] = get_phrase('manage_language');
        $this->load->view('backend/index', $page_data);
    }

    public function update_phrase_with_ajax() {
        $checker['phrase_id'] = $this->input->post('phraseId');
        $updater[$this->input->post('currentEditingLanguage')] = $this->input->post('updatedValue');

        $this->db->where('phrase_id', $checker['phrase_id']);
        $this->db->update('language', $updater);

        echo $checker['phrase_id'].' '.$this->input->post('currentEditingLanguage').' '.$this->input->post('updatedValue');
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->need_login();
        }
        if ($param1 == 'update_profile_info') {
            $this->user_model->edit_user($param2);
            redirect(site_url('panel-admin/manage_profile'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $this->user_model->change_password($param2);
            redirect(site_url('panel-admin/manage_profile'), 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('users', array(
            'id' => $this->session->userdata('user_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /** basic cms */
    public function pages($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        $this->session->set_userdata('last_page', 'pages');
        if ($param1 == 'create') {
            $page_data['page_name'] = 'pages_create';
            $page_data['page_title'] = get_phrase('create_new_page');

            if (isset($_POST['Pages'])){
                $errors = [];
                $is_page_exists = $this->page_model->is_page_exists($this->input->post('Pages')['slug']);
                if ($is_page_exists) {
                    $this->session->set_flashdata('error_message', get_phrase('permalink_already_exist'));
                    array_push($errors, get_phrase('permalink_already_exist'));
                }

                if (count($errors) == 0) {
                    $id = $this->page_model->create($this->input->post('Pages'));
                    if ($id > 0) {
                        $this->onAfterPageSaved();
                        $this->session->set_flashdata('flash_message', get_phrase('your_new_page_is_successfully_added'));
                        redirect(site_url('panel-admin/pages/update/' . $id), 'refresh');
                    }
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'update') {
            $page_data['page_name'] = 'pages_update';
            $page_data['page_data'] = $this->page_model->findByPk($param2);
            $page_data['page_title'] = $page_data['page_data']->meta_title;

            if (isset($_POST['Pages']) && is_object($page_data['page_data'])){
                $errors = [];
                if ($page_data['page_data']->slug != $this->input->post('Pages')['slug']) {
                    $is_page_exists = $this->page_model->is_page_exists($this->input->post('Pages')['slug']);
                    if ($is_page_exists) {
                        $this->session->set_flashdata('error_message', get_phrase('permalink_already_exist'));
                        array_push($errors, get_phrase('permalink_already_exist'));
                    }
                }

                if (count($errors) == 0) {
                    $_POST['Pages']['id'] = $param2;
                    $update = $this->page_model->update($this->input->post('Pages'));
                    if ($update) {
                        $this->onAfterPageSaved();
                        $this->session->set_flashdata('flash_message', get_phrase('your_page_is_successfully_updated'));
                        redirect(site_url('panel-admin/pages/update/' . $param2), 'refresh');
                    }
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "delete") {
            $delete = $this->page_model->delete($param2);
            if ($delete) {
                $this->onAfterPageSaved();
                $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
                redirect(site_url('panel-admin/pages'), 'refresh');
            }
        } else {
            $page_data['page_name'] = 'pages';
            $page_data['page_title'] = get_phrase('pages');
            $page_data['pages'] = get_pages();
            $this->load->view('backend/index', $page_data);
        }
    }

    private function onAfterPageSaved() {
        $json_page_file = APPPATH.'/data/pages.json';
        if (!file_exists($json_page_file)) {
            fopen($json_page_file, "w");
        }

        $slugs = $this->page_model->get_all_slugs();
        try {
            file_put_contents($json_page_file, json_encode($slugs));
            if (!empty($this->input->post('Pages')['slug']) && !empty($this->input->post('Pages')['content'])) {
                $cached_folder = APPPATH.'views/frontend/'. get_settings('theme') .'/pages';
                if (!is_dir($cached_folder)) {
                    mkdir($cached_folder, 0775, true);
                    fopen($cached_folder .'/index.html', "w");
                }

                $single_page_file = $cached_folder .'/'. $this->input->post('Pages')['slug'] .'.twig';
                if (!file_exists($single_page_file)) {
                    fopen($single_page_file, "w");
                }

                file_put_contents($single_page_file, $this->input->post('Pages')['content']);
            }
        } catch (\Exception $e){}
    }

    public function posts($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        $this->session->set_userdata('last_page', 'posts');

        if ($param1 == 'create') {
            $page_data['page_name'] = 'posts_create';
            $page_data['page_title'] = get_phrase('create_new_post');

            if (isset($_POST['Posts'])){
                $errors = [];
                $is_post_exists = $this->post_model->is_post_exists($this->input->post('Posts')['slug']);
                if ($is_post_exists) {
                    $this->session->set_flashdata('error_message', get_phrase('permalink_already_exist'));
                    array_push($errors, get_phrase('permalink_already_exist'));
                }

                if (count($errors) == 0) {
                    $categories = [];
                    if (is_array($this->input->post('Posts')['category'])) {
                        $categories = $this->input->post('Posts')['category'];
                        unset($_POST['Posts']['category']);
                    }

                    if (array_key_exists('allow_comment', $this->input->post('Posts'))) {
                        $_POST['Posts']['allow_comment'] = 1;
                    } else {
                        $_POST['Posts']['allow_comment'] = 0;
                    }

                    $id = $this->post_model->create($this->input->post('Posts'));
                    if ($id > 0) {
                        if (count($categories) > 0) {
                            foreach ($categories as $ic => $cat_id) {
                                $c_data = ['post_id' => $id, 'category_id' => $cat_id];
                                $save_category = $this->postCategory_model->create_post_in_category($c_data);
                            }
                        }
                        $this->session->set_flashdata('flash_message', get_phrase('your_new_post_is_successfully_added'));
                        redirect(site_url('panel-admin/posts/update/' . $id), 'refresh');
                    }
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'update') {
            $page_data['page_name'] = 'posts_update';
            $page_data['page_data'] = $this->post_model->findByPk($param2);
            $page_data['page_title'] = $page_data['page_data']->meta_title;

            if (isset($_POST['Posts']) && is_object($page_data['page_data'])){
                $errors = [];
                if ($page_data['page_data']->slug != $this->input->post('Posts')['slug']) {
                    $is_post_exists = $this->post_model->is_post_exists($this->input->post('Posts')['slug']);
                    if ($is_post_exists) {
                        $this->session->set_flashdata('error_message', get_phrase('permalink_already_exist'));
                        array_push($errors, get_phrase('permalink_already_exist'));
                    }
                }

                if (count($errors) == 0) {
                    $categories = [];
                    if (is_array($this->input->post('Posts')['category'])) {
                        $categories = $this->input->post('Posts')['category'];
                        if (count($categories) > 0) {
                            // delete unselected
                            $post_in_category = get_post_in_categories($param2);
                            if (count($post_in_category) > 0) {
                                foreach ($post_in_category as $in => $c_id) {
                                    if (!in_array($c_id, $categories)) {
                                        $del_category = $this->postCategory_model->delete_post_in_category(['post_id' => $param2, 'category_id' => $c_id]);
                                    }
                                }
                            }
                            foreach ($categories as $ic => $cat_id) {
                                $c_data = ['post_id' => $param2, 'category_id' => $cat_id];
                                if (!in_array($cat_id, $post_in_category)) {
                                    $save_category = $this->postCategory_model->create_post_in_category($c_data);
                                }
                            }
                        }
                        unset($_POST['Posts']['category']);
                    }

                    if (array_key_exists('allow_comment', $this->input->post('Posts'))) {
                        $_POST['Posts']['allow_comment'] = 1;
                    } else {
                        $_POST['Posts']['allow_comment'] = 0;
                    }

                    $_POST['Posts']['id'] = $param2;
                    $update = $this->post_model->update($this->input->post('Posts'));
                    if ($update) {
                        $this->session->set_flashdata('flash_message', get_phrase('your_post_is_successfully_updated'));
                        redirect(site_url('panel-admin/posts/update/' . $param2), 'refresh');
                    }
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "delete") {
            $this->post_model->delete($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(site_url('panel-admin/posts/view'), 'refresh');
        } elseif ($param1 == "direct-upload") {
            if (isset($_FILES['file']['name'])) {
                $path_info = pathinfo($_FILES['file']['name']);
                if (!in_array($path_info['extension'], ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'webp'])) {
                    echo json_encode('Tipe dokumen yang diperbolehkan hanya jpg, jpeg, webp, dan png');
                }

                $uploadfile = 'uploads/posts/' . time() . '.' . $path_info['extension'];
                move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);

                echo json_encode(['location' => site_url($uploadfile)]);
            }
        } elseif ($param1 == "comment") {
            $page_data['page_name'] = 'posts_comment';
            $page_data['page_title'] = get_phrase("post_comments");
            if ($param2 == 'approve') {
                if (isset($_POST['id'])) {
                    $result = ['success' => 0];
                    $data = ['id' => $_POST['id'], 'status' => 'approved'];
                    $update = $this->postComment_model->update($data);
                    if ($update) {
                        $result['success'] = 1;
                        $result['message'] = get_phrase('successfully_approved');
                    } else {
                        $result['message'] = get_phrase('failed_execution');
                    }
                    echo json_encode($result); exit;
                }
            } elseif ($param2 == 'reject') {
                if (isset($_POST['id'])) {
                    $result = ['success' => 0];
                    $data = ['id' => $_POST['id'], 'status' => 'rejected'];
                    $update = $this->postComment_model->update($data);
                    if ($update) {
                        $result['success'] = 1;
                        $result['message'] = get_phrase('successfully_rejected');
                    } else {
                        $result['message'] = get_phrase('failed_execution');
                    }
                    echo json_encode($result); exit;
                }
            } elseif ($param2 == 'delete') {
                if (isset($_POST['id'])) {
                    $result = ['success' => 0];
                    $delete = $this->postComment_model->delete($_POST['id']);
                    if ($delete) {
                        $result['success'] = 1;
                        $result['message'] = get_phrase('successfully_deleted');
                    } else {
                        $result['message'] = get_phrase('failed_execution');
                    }
                    echo json_encode($result); exit;
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "detail-comment") {
            $page_data['page_name'] = 'posts_comment_detail';
            $page_data['page_title'] = get_phrase("post_comment_detail");
            $page_data['page_data'] = $this->postComment_model->findByPk($param2);

            $this->load->view('backend/index', $page_data);
        } else {
            $page_data['page_name'] = 'posts';
            $page_data['page_title'] = get_phrase('posts');
            $page_data['posts'] = get_posts();
            $this->load->view('backend/index', $page_data);
        }
    }

    public function themes($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        $this->session->set_userdata('last_page', 'themes');

        $page_data['page_name'] = 'themes';
        $page_data['page_title'] = get_phrase('themes');
        $page_data['themes'] = get_themes();

        $this->load->view('backend/index', $page_data);
    }

    public function menus($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        $this->session->set_userdata('last_page', 'menus');

        $page_data['group_id'] = '';
        if ($param1 == "view") {
            if (!empty($param2)) {
                $page_data['group_id'] = $param2;
            }
            $page_data['page_name'] = 'menus';
            $page_data['page_title'] = get_phrase('menus');
            $page_data['menus'] = $this->menu_model->get_items(['group_id' => $page_data['group_id']]);

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "create") {
            $page_data['page_name'] = 'menus_create';
            $page_data['page_title'] = get_phrase("add_menu");
            $page_data['menus'] = $this->menu_model->get_recursive_items();
            $page_data['groups'] = $this->menu_model->get_group_items();

            if (isset($_POST['Menus'])) {
                $errors = [];
                $_custom_link = '';
                if (isset($this->input->post('Menus')['type']) && $this->input->post('Menus')['type'] == Menu_model::TYPE_CUSTOM_LINK) {
                    $_custom_link = $this->input->post('Menus')['slug'];
                    $slug = $_custom_link;
                }
                if (empty($_custom_link)) {
                    $slug = slugify($this->input->post('Menus')['title']);
                    $_POST['Menus']['slug'] = $slug;
                }
                $parent_id = 0;
                if (!empty($this->input->post('Menus')['parent_id'])) {
                    $parent_id = $this->input->post('Menus')['parent_id'];
                    $p_model = $this->menu_model->findByPk($parent_id);
                    if (is_object($p_model)) {
                        $_POST['Menus']['level'] = $p_model->level + 1;
                    }
                }

                if (!empty($this->input->post('Menus')['group_id'])) {
                    $_POST['Menus']['sort_order'] = $this->menu_model->get_next_sort_order($this->input->post('Menus')['group_id'], $parent_id);
                }

                if (empty($_custom_link)) {
                    $is_menu_exists = $this->menu_model->is_menu_exists($slug);
                    if ($is_menu_exists) {
                        $this->session->set_flashdata('error_message', get_phrase('menu_already_exist'));
                        array_push($errors, get_phrase('menu_already_exist'));
                    }
                }

                if (count($errors) == 0) {
                    $menu_id = $this->menu_model->create($this->input->post('Menus'));
                    if ($menu_id) {
                        $this->session->set_flashdata('flash_message', get_phrase('your_data_is_successfully_saved'));
                        redirect(site_url('panel-admin/menus/update/' . $menu_id), 'refresh');
                    }
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "update") {
            $page_data['page_name'] = 'menus_update';
            $page_data['page_title'] = get_phrase("update_menu");
            $page_data['page_data'] = $this->menu_model->findByPk($param2);
            $page_data['menus'] = $this->menu_model->get_recursive_items();
            $page_data['groups'] = $this->menu_model->get_group_items();

            if (isset($_POST['Menus'])) {
                $errors = [];
                $_custom_link = '';
                if (isset($this->input->post('Menus')['type']) && $this->input->post('Menus')['type'] == Menu_model::TYPE_CUSTOM_LINK) {
                    $_custom_link = $this->input->post('Menus')['slug'];
                    $slug = $_custom_link;
                }
                if (empty($_custom_link)) {
                    $old_slug = $page_data['page_data']->slug;
                    $slug = slugify($this->input->post('Menus')['title']);
                }
                /*if ($slug != $old_slug) {
                    $is_menu_exists = $this->menu_model->is_menu_exists($slug);
                    if ($is_menu_exists) {
                        $this->session->set_flashdata('error_message', get_phrase('menu_already_exist'));
                        array_push($errors, get_phrase('menu_already_exist'));
                    } else {
                        $_POST['Menus']['slug'] = $slug;
                    }
                }*/

                $old_parent_id = $page_data['page_data']->parent_id;
                $parent_id = 0;
                if (!empty($this->input->post('Menus')['parent_id']) && ($this->input->post('Menus')['parent_id'] != $old_parent_id)) {
                    $parent_id = $this->input->post('Menus')['parent_id'];
                    $p_model = $this->menu_model->findByPk($this->input->post('Menus')['parent_id']);
                    if (is_object($p_model)) {
                        $_POST['Menus']['level'] = $p_model->level + 1;
                    }
                }

                $old_sort_order = $page_data['page_data']->sort_order;
                $auto_create_sort_order = true;
                if (!empty($this->input->post('Menus')['sort_order']) && ($this->input->post('Menus')['sort_order'] != $old_sort_order)) {
                    $auto_create_sort_order = false;
                }

                $old_group_id = $page_data['page_data']->group_id;
                if (!empty($this->input->post('Menus')['group_id']) && ($this->input->post('Menus')['group_id'] != $old_group_id) && $auto_create_sort_order) {
                    $_POST['Menus']['sort_order'] = $this->menu_model->get_next_sort_order($this->input->post('Menus')['group_id'], $parent_id);
                }

                if (count($errors) == 0) {
                    $_POST['Menus']['id'] = $page_data['page_data']->id;
                    $update = $this->menu_model->update($this->input->post('Menus'));
                    if ($update) {
                        $this->session->set_flashdata('flash_message', get_phrase('your_data_is_successfully_updated'));
                        redirect(site_url('panel-admin/menus/update/' . $page_data['page_data']->id), 'refresh');
                    }
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'delete') {
            if (isset($_POST['id'])) {
                $result = ['success' => 0];
                $delete = $this->menu_model->delete($_POST['id']);
                if ($delete) {
                    $result['success'] = 1;
                    $result['message'] = get_phrase('successfully_deleted');
                } else {
                    $result['message'] = get_phrase('failed_execution');
                }
                echo json_encode($result); exit;
            }
        } elseif ($param1 == 'add-link') {
            if (isset($_POST['CustomLink'])) {
                $errors = [];
                if (empty($this->input->post('CustomLink')['slug']) || ($this->input->post('CustomLink')['slug'] == 'http://')) {
                    array_push($errors, 'Url ' . get_phrase('is_required'));
                }

                if (empty($this->input->post('CustomLink')['title'])) {
                    array_push($errors, 'Link Text ' . get_phrase('is_required'));
                }

                if (count($errors) == 0) {
                    $_POST['CustomLink']['type'] = Menu_model::TYPE_CUSTOM_LINK;
                    $menu_id = $this->menu_model->create($this->input->post('CustomLink'));
                    if ($menu_id) {
                        $this->session->set_flashdata('flash_message', get_phrase('your_data_is_successfully_saved'));
                        redirect(site_url('panel-admin/menus/update/' . $menu_id), 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', implode(", ", $errors));
                }

                $page_data['page_name'] = 'menus';
                $page_data['page_title'] = get_phrase('menus');
                $page_data['menus'] = $this->menu_model->get_items();

                $this->load->view('backend/index', $page_data);
            }

            if (isset($_POST['PageLink'])) {
                $errors = [];
                if (empty($this->input->post('PageLink')['page_id']) || (count($this->input->post('PageLink')['page_id']) <= 0)) {
                    array_push($errors, 'Please select at least 1 page.');
                }

                if (count($errors) == 0) {
                    $saved = 0;
                    foreach ($this->input->post('PageLink')['page_id'] as $i => $pag_id) {
                        $params = [];
                        $params['type'] = Menu_model::TYPE_PAGE;
                        $page_model = $this->page_model->findByPk($pag_id);
                        $params['rel_id'] = $pag_id;
                        $params['title'] = $page_model->meta_title;
                        $params['slug'] = $page_model->slug;
                        $menu_id = $this->menu_model->create($params);
                        if ($menu_id) {
                            $saved = $saved + 1;
                        }
                    }
                    if ($saved > 0) {
                        $this->session->set_flashdata('flash_message', get_phrase('your_data_is_successfully_saved'));
                        redirect(site_url('panel-admin/menus'), 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', implode(", ", $errors));
                }

                $page_data['page_name'] = 'menus';
                $page_data['page_title'] = get_phrase('menus');
                $page_data['menus'] = $this->menu_model->get_items();

                $this->load->view('backend/index', $page_data);
            }

            if (isset($_POST['CategoryLink'])) {
                $errors = [];
                if (empty($this->input->post('CategoryLink')['cat_id']) || (count($this->input->post('CategoryLink')['cat_id']) <= 0)) {
                    array_push($errors, 'Please select at least 1 category.');
                }

                if (count($errors) == 0) {
                    $saved = 0;
                    foreach ($this->input->post('CategoryLink')['cat_id'] as $i => $cat_id) {
                        $params = [];
                        $params['type'] = Menu_model::TYPE_CATEGORY;
                        $cat_model = $this->postCategory_model->findByPk($cat_id);
                        $params['rel_id'] = $cat_id;
                        $params['title'] = $cat_model->title;
                        $params['slug'] = $cat_model->slug;
                        if (!empty($this->input->post('CategoryLink')['group_id'])) {
                            $params['group_id'] = $this->input->post('CategoryLink')['group_id'];
                        }
                        $menu_id = $this->menu_model->create($params);
                        if ($menu_id) {
                            $saved = $saved + 1;
                        }
                    }
                    if ($saved > 0) {
                        $this->session->set_flashdata('flash_message', get_phrase('your_data_is_successfully_saved'));
                        redirect(site_url('panel-admin/menus'), 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', implode(", ", $errors));
                }

                $page_data['page_name'] = 'menus';
                $page_data['page_title'] = get_phrase('menus');
                $page_data['menus'] = $this->menu_model->get_items();

                $this->load->view('backend/index', $page_data);
            }
        } elseif ($param1 == 'type') {
            if (isset($_POST['type'])) {
                $page_data['type'] = $_POST['type'];

                $this->load->view('backend/admin/menus_type', $page_data);
            }
        } elseif ($param1 == 're-order') {
            if (isset($_POST['Menus']) && (count($_POST['Menus']) > 0)) {
                $saved_counter = 0;
                foreach ($_POST['Menus'] as $i => $menu) {
                    $datas = [];
                    $datas['id'] = $menu['id'];
                    if (array_key_exists('parentId', $menu)) {
                        $datas['parent_id'] = $menu['parentId'];
                        $parent_model = $this->menu_model->findByPk($menu['parentId']);
                        $datas['level'] = $parent_model->level + 1;
                    } else {
                        $datas['parent_id'] = 0;
                        $datas['level'] = 0;
                    }
                    $datas['sort_order'] = $menu['order'] + 1;
                    $update = $this->menu_model->update($datas);
                    if ($update) {
                        $saved_counter = $saved_counter + 1;
                    }
                }
                $results = ['success' => 0, 'message' => 'Failed to update data.'];
                if ($saved_counter > 0) {
                    $results = ['success' => 1, 'message' => 'Your data is successfully updated.'];
                }
                echo json_encode($results);
            }
        } else {
            $page_data['page_name'] = 'menus';
            $page_data['page_title'] = get_phrase('menus');
            $page_data['menus'] = $this->menu_model->get_items();

            $this->load->view('backend/index', $page_data);
        }
    }

    public function theme_editor($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        $this->session->set_userdata('last_page', 'editor');

        $page_data['page_name'] = 'theme_editor';
        $page_data['page_title'] = get_phrase('theme_editor');

        $this->load->view('backend/index', $page_data);
    }

    public function categories($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        $this->session->set_userdata('last_page', 'posts');

        if ($param1 == 'create') {
            $page_data['page_name'] = 'posts_category_create';
            $page_data['page_title'] = get_phrase('create_new_category');

            if (isset($_POST['PostsCategory'])){
                $errors = [];
                $is_post_exists = $this->postCategory_model->is_category_exists($this->input->post('PostsCategory')['slug']);
                if ($is_post_exists) {
                    $this->session->set_flashdata('error_message', get_phrase('slug_already_exist'));
                    array_push($errors, get_phrase('slug_already_exist'));
                }

                if (count($errors) == 0) {
                    $id = $this->postCategory_model->create($this->input->post('PostsCategory'));
                    if ($id > 0) {
                        $this->session->set_flashdata('flash_message', get_phrase('your_new_category_is_successfully_added'));
                        redirect(site_url('panel-admin/categories/update/' . $id), 'refresh');
                    }
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'update') {
            $page_data['page_name'] = 'posts_category_update';
            $page_data['page_data'] = $this->postCategory_model->findByPk($param2);
            $page_data['page_title'] = $page_data['page_data']->title;

            if (isset($_POST['PostsCategory']) && is_object($page_data['page_data'])){
                $errors = [];
                if ($page_data['page_data']->slug != $this->input->post('PostsCategory')['slug']) {
                    $is_post_exists = $this->postCategory_model->is_category_exists($this->input->post('PostsCategory')['slug']);
                    if ($is_post_exists) {
                        $this->session->set_flashdata('error_message', get_phrase('permalink_already_exist'));
                        array_push($errors, get_phrase('permalink_already_exist'));
                    }
                }

                if (count($errors) == 0) {
                    $_POST['PostsCategory']['id'] = $param2;
                    $update = $this->postCategory_model->update($this->input->post('PostsCategory'));
                    if ($update) {
                        $this->session->set_flashdata('flash_message', get_phrase('your_data_is_successfully_updated'));
                        redirect(site_url('panel-admin/categories/update/' . $param2), 'refresh');
                    }
                }
            }

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "view") {
            $page_data['page_name'] = 'posts_category';
            $page_data['page_title'] = get_phrase('categories');
            $page_data['categories'] = get_post_categories();
            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "delete") {
            if (isset($_POST['id']) && $_POST['id'] == $param2) {
                $result = ['success' => 0];
                $delete = $this->postCategory_model->delete($_POST['id']);
                if ($delete) {
                    $result['success'] = 1;
                    $result['message'] = get_phrase('successfully_deleted');
                } else {
                    $result['message'] = get_phrase('failed_execution');
                }
                echo json_encode($result); exit;
            }
        } else {
            $page_data['page_name'] = 'posts_category';
            $page_data['page_title'] = get_phrase('categories');
            $page_data['categories'] = get_post_categories();
            $this->load->view('backend/index', $page_data);
        }
    }

    public function contacts($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            $this->need_login();
        }

        $this->session->set_userdata('last_page', 'contacts');

        if ($param1 == 'detail') {
            $page_data['page_name'] = 'contacts_detail';
            $page_data['data'] = $this->contact_model->findByPk($param2);
            $page_data['page_title'] = get_phrase('contacts');

            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "view") {
            $page_data['page_name'] = 'contacts';
            $page_data['page_title'] = get_phrase('contacts');
            $page_data['items'] = $this->contact_model->get_items();
            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == "delete") {
            if (isset($_POST['id']) && $_POST['id'] == $param2) {
                $result = ['success' => 0];
                $delete = $this->contact_model->delete($_POST['id']);
                if ($delete) {
                    $result['success'] = 1;
                    $result['message'] = get_phrase('successfully_deleted');
                } else {
                    $result['message'] = get_phrase('failed_execution');
                }
                echo json_encode($result); exit;
            }
        } else {
            $page_data['page_name'] = 'contacts';
            $page_data['page_title'] = get_phrase('contacts');
            $page_data['items'] = $this->contact_model->get_items();
            $this->load->view('backend/index', $page_data);
        }
    }
}
