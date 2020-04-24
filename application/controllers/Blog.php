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
            $page_data['comments'] = $this->post_model->get_comments(['post_id' => $data->id, 'status' => 'approved', 'limit' => 20]);

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
                    /*$mail = new \PHPMailer\PHPMailer\PHPMailer(true);
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
                    } catch (Exception $e) {}*/

                    // fungsi standard email u/ hemat limit smtp (tidak urgent bgt)
                    try {
                        $to      = get_settings('system_email');
                        $subject = '['. get_settings('system_name') .'] Komentar User';
                        $message = "Halo Admin, 
                            <br/><br/>
                            Ada komentar baru dari pengunjung dengan data berikut:
                            <br/><br/>
                            <b>Artikel</b> : <a href='". site_url('blog/'. $model->slug) ."'>". $model->meta_title ."</a> <br/> 
                            <b>Nama pengunjung</b> : ".$_post['author_name']." <br/> 
                            <b>Alamat Email</b> : ".$_post['author_email']." <br/>
                            <br/>
                            <b>Komentar</b> :<br/> ".$_post['content']."";
                        $headers = 'From: '. $_post['author_email'] .'' . "\r\n" .
                            'Reply-To: '. $_post['author_email'] .'' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                        mail($to, $subject, $message, $headers);
                    } catch (Exception $exception){}
                }
            }
        }

        echo ($success > 0)? 'success':'failed';exit;
    }

    public function apply_job($param = "") {
        $success = 0;
        if (isset($_POST['JobApplication'])){
            $_post = $this->input->post('JobApplication');
            $_errors = [];
            if ($_post['post_id'] == $param) {
                $model = $this->post_model->findByPk($_post['post_id']);
                $hashed = $this->rpHash($_POST['captcha']);
                if ($hashed != $_POST['captchaHash']) {
                    array_push($_errors, 'Kode verifikasi yang Anda masukkan salah.');
                }

                if(filter_var($_post['email'], FILTER_VALIDATE_EMAIL) === false){
                    array_push($_errors, $_post['email'].' bukan alamat email yang valid.');
                }
                $tmp_name = null; $file_name = null;
                if (isset($_FILES) && !empty($_FILES['JobApplication'])) {
                    $path_info = pathinfo($_FILES['JobApplication']['name']['cv']);
                    if (!in_array($path_info['extension'], ['jpg','JPG','jpeg','JPEG','png','PNG','pdf'])) {
                        array_push($_errors, 'CV hanya dalam format jpg, jpeg, png, dan pdf yang diperbolehkan.');
                    }
                    if ($_FILES['JobApplication']['size']['cv'] > 3000000) {
                        array_push($_errors, 'Ukuran file terlalu besar, maksimum 3MB.');
                    }
                    if (!empty($_FILES['JobApplication']['tmp_name']['cv'])) {
                        $tmp_name = $_FILES['JobApplication']['tmp_name']['cv'];
                        $file_name = $_FILES['JobApplication']['name']['cv'];
                    }
                }
                $id = 0;
                if (count($_errors) == 0) {
                    $id = $this->jobApplication_model->create($_post);
                }
                if ($id > 0) {
                    $success = 1;
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
                        $mail->addReplyTo( $_post['email'], $_post['name'] );

                        //Content
                        $mail->isHTML(true);
                        $mail->Subject = '[Lamaran Kerja] '. ucwords($_post['name']);
                        $mail->Body = "Halo Admin,
                            <br/><br/>
                            Ada pelamar baru dengan data berikut:
                            <br/><br/>
                            <b>Nama Lowongan</b> : <a href='". site_url('blog/'. $model->slug) ."'>". $model->meta_title ."</a> <br/>
                            <b>Nama pengunjung</b> : ".$_post['name']." <br/>
                            <b>Alamat Email</b> : ".$_post['email']." <br/>
                            <br/>
                            <b>Catatan</b> :<br/> ".$_post['notes']."";

                        if (!empty($tmp_name)) {
                            $mail->addAttachment($tmp_name, $file_name);
                        }

                        $mail->send();
                    } catch (Exception $e) {}

                    $this->session->set_flashdata('success_message', 'Lamaran Anda telah berhasil disimpan. Kami akan segera memprosesnya.');
                    redirect(site_url('blog/'. $model->slug).'#apply-job', 'refresh');
                } else {
                    $this->session->set_flashdata('error_message', implode(", ", $_errors));
                    redirect(site_url('blog/'. $model->slug).'#apply-job', 'refresh');
                }
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    function rpHash2($value) {
        $hash = 5381;
        $value = strtoupper($value);
        for($i = 0; $i < strlen($value); $i++) {
            $hash = (($hash << 5) + $hash) + ord(substr($value, $i));
        }
        return $hash;
    }

    public function rpHash($value, $hash = 5381) {
        $value = strtoupper($value);
        for($i = 0; $i < strlen($value); $i++) {
            $hash = ($this->leftShift32($hash, 5) + $hash) + ord(substr($value, $i));
        }
        return $hash;
    }

    private function leftShift32($number, $steps) {
        // convert to binary (string)
        $binary = decbin($number);
        // left-pad with 0's if necessary
        $binary = str_pad($binary, 32, "0", STR_PAD_LEFT);
        // left shift manually
        $binary = $binary.str_repeat("0", $steps);
        // get the last 32 bits
        $binary = substr($binary, strlen($binary) - 32);
        // if it's a positive number return it
        // otherwise return the 2's complement
        return ($binary{0} == "0" ? bindec($binary) :
            -(pow(2, 31) - bindec(substr($binary, 1))));
    }
}