<div class="sidebar-menu">
    <header class="logo-env">
        <!-- logo -->
        <div class="logo">
            <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
                <img src="<?php echo base_url().'assets/backend/logo.png'; ?>" width="120" alt="" />
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse">
            <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                <i class="entypo-menu"></i>
            </a>
        </div>

    </header>

    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
        <!-- Search Bar -->
        <li class="<?php echo is_active('dashboard'); ?>">
            <a href="<?php echo site_url('panel-admin/dashboard'); ?>">
                <i class="fa fa-th-large"></i>
				<span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <li class = "<?php echo is_multi_level_active(['pages'], 1); ?>">
            <a href="javascript:;">
                <i class="fa fa-clone"></i>
				<span><?php echo get_phrase('pages'); ?></span>
            </a>
            <ul class="sub-menu">
                <li class = "<?php echo is_active('view_pages'); ?>" > <a href="<?php echo site_url('panel-admin/pages/view'); ?>"><?php echo get_phrase('view_pages'); ?></a> </li>
                <li class = "<?php echo is_active('add_pages'); ?>" > <a href="<?php echo site_url('panel-admin/pages/create'); ?>"><?php echo get_phrase('create_new_page'); ?></a> </li>
                <br>
            </ul>
        </li>

        <li class = "<?php echo is_multi_level_active(['posts', 'view'], 1); ?>">
            <a href="javascript:;">
                <i class="fa fa-file-text"></i>
                <span><?php echo get_phrase('posts'); ?></span>
            </a>
            <ul class="sub-menu">
                <li class = "<?php echo is_active('view_posts'); ?>" > <a href="<?php echo site_url('panel-admin/posts/view'); ?>"><?php echo get_phrase('view_posts'); ?></a> </li>
                <li class = "<?php echo is_active('add_posts'); ?>" > <a href="<?php echo site_url('panel-admin/posts/create'); ?>"><?php echo get_phrase('create_new_post'); ?></a> </li>
                <li class = "<?php echo is_active('view_comments'); ?>" > <a href="<?php echo site_url('panel-admin/posts/comment'); ?>"><?php echo get_phrase('view_comments'); ?></a> </li>
                <li class = "<?php echo is_active('view_categories'); ?>" > <a href="<?php echo site_url('panel-admin/categories/view'); ?>"><?php echo get_phrase('view_categories'); ?></a> </li>
                <li class = "<?php echo is_active('add_category'); ?>" > <a href="<?php echo site_url('panel-admin/categories/create'); ?>"><?php echo get_phrase('create_new_category'); ?></a> </li>
                <br>
            </ul>
        </li>

        <li class = "<?php echo is_multi_level_active(['appearance', 'themes', 'menus', 'editor', 'section_chart', 'slide_show', 'section_settings'], 1); ?>">
            <a href="javascript:;">
                <i class="fa fa-paint-brush"></i>
                <span><?php echo get_phrase('appearance'); ?></span>
            </a>
            <ul class="sub-menu">
                <li class = "<?php echo is_active('themes'); ?>" > <a href="<?php echo site_url('panel-admin/themes'); ?>"><?php echo get_phrase('themes'); ?></a> </li>
                <li class = "<?php echo is_active('menus'); ?>" > <a href="<?php echo site_url('panel-admin/menus'); ?>"><?php echo get_phrase('menus'); ?></a> </li>
                <li class = "<?php echo is_active('editor'); ?>" > <a href="<?php echo site_url('panel-admin/theme-editor'); ?>"><?php echo get_phrase('editor'); ?></a> </li>
                <li class = "<?php echo is_multi_level_active(['section_chart', 'section_settings'], 1); ?>" >
                    <a href="javascript:;">
                        <span><?php echo get_phrase('Section Page'); ?></span>
                    </a>
                    <ul class="sub-menu">
                        <li class = "<?php echo is_active('section_chart'); ?>" ><a href="<?=site_url('panel-admin/section-chart'); ?>">Charts</a></li>
                        <li class = "<?php echo is_active('section_settings'); ?>" ><a href="<?=site_url('panel-admin/section-settings'); ?>">Section Settings</a></li>
                    </ul>
                </li>
                <li class = "<?php echo is_active('slide_show'); ?>" > <a href="<?php echo site_url('panel-admin/slide-show'); ?>"><?php echo get_phrase('slide_show'); ?></a> </li>
                <br>
            </ul>
        </li>

        <li class = "<?php echo is_multi_level_active(['contacts'], 1); ?>">
            <a href="javascript:;">
                <i class="fa fa-inbox"></i>
                <span><?php echo get_phrase('contacts'); ?></span>
            </a>
            <ul class="sub-menu">
                <li class = "<?php echo is_active('view_contacts'); ?>" > <a href="<?php echo site_url('panel-admin/contacts/view'); ?>"><?php echo get_phrase('view_contacts'); ?></a> </li>
                <br>
            </ul>
        </li>

        <li class = "<?php echo is_multi_level_active(['job_applications'], 1); ?>">
            <a href="javascript:;">
                <i class="fa fa-file"></i>
                <span><?php echo get_phrase('job_applications'); ?></span>
            </a>
            <ul class="sub-menu">
                <li class = "<?php echo is_active('overview'); ?>" > <a href="<?php echo site_url('panel-admin/job-applications/view'); ?>"><?php echo get_phrase('overview'); ?></a> </li>
                <br>
            </ul>
        </li>

        <li class = "<?php echo is_multi_level_active(['system_settings', 'manage_language', 'frontend_settings','users'], 1); ?>">
            <a href="javascript:;">
                <i class="fa fa-sliders"></i>
				<span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul class="sub-menu">
                <li class = "<?php echo is_active('users'); ?>" > <a href="<?php echo site_url('panel-admin/users'); ?>"><?php echo get_phrase('user'); ?></a> </li>
                <li class = "<?php echo is_active('system_settings'); ?>" > <a href="<?php echo site_url('panel-admin/system-settings'); ?>"><?php echo get_phrase('system_settings'); ?></a> </li>
                <li class = "<?php echo is_active('frontend_settings'); ?>" > <a href="<?php echo site_url('panel-admin/frontend-settings'); ?>"><?php echo get_phrase('frontend_settings'); ?></a> </li>
                <li class = "<?php echo is_active('manage_language'); ?>" > <a href="<?php echo site_url('panel-admin/manage-language'); ?>"><?php echo get_phrase('manage_language'); ?></a> </li>
                <br>
            </ul>
        </li>
    </ul>
</div>
