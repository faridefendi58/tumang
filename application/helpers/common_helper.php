<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */


if ( ! function_exists('is_active'))
{

	function is_active($selected_page_name = "") {
        $CI	=&	get_instance();
        $CI->load->library('session');

        if ($CI->session->userdata('last_page') == $selected_page_name) {
            return "active";
        }else {
            return "";
        }
	}
}

if ( ! function_exists('is_multi_level_active'))
{
    function is_multi_level_active($selected_pages = "", $item = "") {
        $CI	=&	get_instance();
        $CI->load->library('session');

		for ($i = 0; $i < sizeof($selected_pages); $i++) {
			if ($CI->session->userdata('last_page') == $selected_pages[$i]) {
	            if ($item == 1) {
	                return "opened active";
	            }else {
	                return "opened";
	            }
	        }
		}
		return "";
    }
}

if (! function_exists('get_settings')) {
  function get_settings($key = '') {
    $CI	=&	get_instance();
    $CI->load->database();

    $CI->db->where('key', $key);
    $result = $CI->db->get('settings')->row()->value;
    return $result;
  }
}

if (! function_exists('currency')) {
  function currency($price = "") {
    $CI	=&	get_instance();
    $CI->load->database();
		if ($price != "") {
			$CI->db->where('key', 'system_currency');
			$currency_code = $CI->db->get('settings')->row()->value;

			$CI->db->where('code', $currency_code);
			$symbol = $CI->db->get('currency')->row()->symbol;

			$CI->db->where('key', 'currency_position');
			$position = $CI->db->get('settings')->row()->value;

			if ($position == 'right') {
				return $price.$symbol;
			}elseif ($position == 'right-space') {
				return $price.' '.$symbol;
			}elseif ($position == 'left') {
				return $symbol.$price;
			}elseif ($position == 'left-space') {
				return $symbol.' '.$price;
			}
		}
  }
}
if (! function_exists('currency_code_and_symbol')) {
  function currency_code_and_symbol($type = "") {
    $CI	=&	get_instance();
    $CI->load->database();
		$CI->db->where('key', 'system_currency');
		$currency_code = $CI->db->get('settings')->row()->value;

		$CI->db->where('code', $currency_code);
		$symbol = $CI->db->get('currency')->row()->symbol;
		if ($type == "") {
			return $symbol;
		}else {
			return $currency_code;
		}

  }
}

if (! function_exists('get_frontend_settings')) {
  function get_frontend_settings($key = '') {
    $CI	=&	get_instance();
    $CI->load->database();

    $CI->db->where('key', $key);
    $result = $CI->db->get('frontend_settings')->row()->value;
    return $result;
  }
}

if ( ! function_exists('slugify'))
{
  function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
            return 'n-a';
        return $text;
    }
}

if ( ! function_exists('get_video_extension'))
{
    // Checks if a video is youtube, vimeo or any other
    function get_video_extension($url) {
        if (strpos($url, '.mp4') > 0) {
            return 'mp4';
        } elseif (strpos($url, '.webm') > 0) {
            return 'webm';
        } else {
            return 'unknown';
        }
    }
}

if (! function_exists('get_pages')) {
    function get_pages() {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->order_by('meta_title' , 'asc');
        $pages = $CI->db->get('pages')->result_array();

        return $pages;
    }
}

if (! function_exists('get_page')) {
    function get_page($slug) {
        //$file = APPPATH .'/views/frontend/default/'. $slug .'.twig';
        //$content = file_get_contents($file);
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('slug', $slug);
        $result = $CI->db->get('pages')->row();

        return $result;
    }
}

if (! function_exists('get_posts')) {
    function get_posts() {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->order_by('id' , 'desc');
        $pages = $CI->db->get('posts')->result_array();

        return $pages;
    }
}

if (! function_exists('get_post')) {
    function get_post($slug) {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('slug', $slug);
        $result = $CI->db->get('posts')->row();

        return $result;
    }
}

if (! function_exists('get_themes')) {
    function get_themes() {
        $items = [];
        foreach (scandir(APPPATH.'/views/frontend') as $dir) {
            if ( !in_array($dir, ['.', '..']) && is_dir(APPPATH.'/views/frontend/'.$dir) ){
                if (file_exists(APPPATH.'/views/frontend/'.$dir.'/manifest.json')){
                    $manifest = file_get_contents(APPPATH.'/views/frontend/'.$dir.'/manifest.json');
                    $item = json_decode($manifest, true);

                    if (!is_array($item)){
                        $item = ['id'=>$dir, 'name'=>ucfirst($dir), 'preview'=>'screenshot.png'];
                    }

                    $item ['path'] = APPPATH.'views/frontend/'.$dir;
                    $item ['img_path'] = 'uploads/frontend/theme-'.$dir.'.png';
                    $items[$dir] = $item;
                }
            }
        }

        return $items;
    }
}

if (! function_exists('get_post_categories')) {
    function get_post_categories() {
        $CI	=&	get_instance();
        $CI->load->database();

        $results = $CI->db->get('post_category')->result_array();
        return $results;
    }
}

if (! function_exists('get_post_in_categories')) {
    function get_post_in_categories($post_id) {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('post_id', $post_id);
        $results = $CI->db->get('post_in_category')->result_array();
        $items = [];
        if (count($results) > 0) {
            foreach ($results as $id => $result) {
                array_push($items, $result['category_id']);
            }
        }

        return $items;
    }
}

if (! function_exists('get_theme_configs')) {
    function get_theme_configs($name = null) {

        $theme_name = get_settings('theme');
        $theme_settings = get_settings($theme_name.'_theme');
        $items = [];
        if (!empty($theme_settings)) {
            $theme_settings = json_decode($theme_settings, true);
            if (is_array($theme_settings)) {
                if (empty($name)) {
                    $items = $theme_settings;
                } else {
                    return $theme_settings[$name];
                }
            }
        }

        return $items;
    }
}

// ------------------------------------------------------------------------
/* End of file user_helper.php */
/* Location: ./system/helpers/common.php */
