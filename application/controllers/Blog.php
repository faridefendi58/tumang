<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        $this->load->library('twig');

        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function view($param = "")
    {
        $page_data['page_title'] = $param;

        $page_data['page_name'] = 'blog';
        $data = $this->post_model->get_item(['slug' => $param]);
        $theme_name = get_settings('theme');
        $this->twig->addGlobal('this', $this);
        if (!empty($data)) {
            $page_data['page_title'] = $data->meta_title;
            $page_data['data'] = $data;

            $this->twig->display('frontend/'. $theme_name .'/blog', $page_data);
        } else {
            $page_data['page_title'] = '404';
            $this->twig->display('frontend/'. $theme_name .'/404', $page_data);
        }
    }

    public function category($param = "")
    {
        $page_data['page_title'] = $param;

        $page_data['page_name'] = 'category';
        $data = $this->postCategory_model->findByAttributes(['slug' => $param]);
        $theme_name = get_settings('theme');
        $this->twig->addGlobal('this', $this);
        if (!empty($data)) {
            $page_data['page_title'] = $data->title;
            $page_data['data'] = $data;

            $this->twig->display('frontend/'. $theme_name .'/category', $page_data);
        } else {
            $page_data['page_title'] = '404';
            $this->twig->display('frontend/'. $theme_name .'/404', $page_data);
        }
    }

    public function settings($param = "") {
        return get_settings($param);
    }
}