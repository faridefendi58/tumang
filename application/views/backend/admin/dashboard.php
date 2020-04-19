<ol class="breadcrumb bc-3">
    <li class = "active">
        <a href="#">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
</ol>
<h2><i class="fa fa-arrow-circle-o-right"></i> <?php echo $page_title; ?></h2>
<br />

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('admin_dashboard'); ?>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-3">

                        <div class="tile-stats tile-green">
                            <div class="icon"><i class="fa fa-clone"></i></div>
                            <div class="num" data-start="0"
                            data-end="
                            <?php
                            $number_of_pages = $this->page_model->findAll()->num_rows();
                            echo $number_of_pages;
                            ?>
                            "
                            data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3><?php echo get_phrase('total_pages');?></h3>
                            <p><?php echo get_phrase('number_of_pages');?></p>
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="tile-stats tile-aqua">
                            <div class="icon"><i class="fa fa-file-text"></i></div>
                            <div class="num" data-start="0"
                            data-end="
                            <?php
                            $number_of_post = $this->post_model->findAll()->num_rows();
                            echo $number_of_post;
                            ?>
                            "
                            data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3><?php echo get_phrase('total_articles');?></h3>
                            <p><?php echo get_phrase('number_of_articles');?></p>
                        </div>
                    </div>

                    <div class="col-md-4">

                        <div class="tile-stats tile-blue">
                            <div class="icon"><i class="fa fa-comments"></i></div>
                            <div class="num" data-start="0"
                            data-end="
                            <?php
                            $need_approval_comments = $this->postComment_model->findAllByAttributes(['status' => 'pending'])->num_rows();
                            echo $need_approval_comments;
                            ?>
                            "
                            data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3><?php echo get_phrase('need_approval_comments');?></h3>
                            <p><?php echo get_phrase('number_of_need_approval_comments');?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
