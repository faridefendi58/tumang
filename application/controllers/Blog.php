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

    public function comment($param = "") {
        $success = 0;
        if (isset($_POST['PostComment'])){
            $_post = $this->input->post('PostComment');
            if ($_post['post_id'] == $param) {
                $id = $this->postComment_model->create($_post);
                if ($id > 0) {
                    $success = 1;
                    $model = $this->post_model->findByPk($_post['post_id']);
                    //send mail to admin
                    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                    try {
                        $mail->SMTPDebug = 0;
                        $has_smtp = has_setting('use_smtp');
                        if ($has_smtp) {
                            $use_smtp = get_settings('use_smtp');
                            if ($use_smtp > 0) {
                                $mail->isSMTP();
                                $mail->Host = get_settings('smtp_host');
                                $mail->SMTPAuth = true;
                                $mail->Username = get_settings('smtp_user');
                                $mail->Password = get_settings('smtp_secret');
                                $mail->SMTPSecure = get_settings('smtp_secure');
                                $mail->Port = get_settings('smtp_port');
                            } else {
                                $mail->isMail();
                            }
                        } else {
                            $mail->isMail();
                        }

                        //Recipients
                        $mail->setFrom( get_settings('system_email'), 'Admin '. get_settings('system_name') );
                        $mail->addAddress( get_settings('system_email'), 'Admin '. get_settings('system_name') );
                        $mail->addReplyTo( $_post['author_email'], $_post['author_name'] );

                        //Content
                        $mail->isHTML(true);
                        $mail->Subject = '['. get_settings('system_name') .'] Komentar User';
                        $mail->Body = "Halo Admin, 
                    <br/><br/>
                    Ada pesan baru dari pengunjung dengan data berikut:
                    <br/><br/>
                    <b>Artikel</b> : <a href='". site_url('blog/'. $model->slug) ."'>". $model->meta_title ."</a> <br/> 
                    <b>Nama pengunjung</b> : ".$_post['author_name']." <br/> 
                    <b>Alamat Email</b> : ".$_post['author_email']." <br/>
                    <br/>
                    <b>Komentar</b> :<br/> ".$_post['content']."";

                        $mail->send();
                    } catch (Exception $e) {}
                }
            }
        }

        echo ($success > 0)? 'success':'failed';exit;
    }
}