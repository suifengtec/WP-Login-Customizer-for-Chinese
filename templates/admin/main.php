<div class="clt-logo-plugin-container">
    <h1 class="clt-plugin-title"><?php echo esc_html($page_title) ?></h1>
    <p class="clt-plugin-description">自定义登录页面</p>
    <?php do_action( 'cwp_login_admin_notices' ) ?>
    <h1 class="nav-tab-wrapper clt-nav-wrapper">
        <?php do_action( 'cwp_login_admin_tabs_links_' . $page_id ); ?>
        <a href="<?php echo wp_login_url() ?>" target="_blank" class="clt-login-preview button-primary">
            预览登录页面</a>
    </h1>
    <div class="tabs-content-wrapper">
        <?php do_action( 'cwp_login_admin_tabs_contents_' . $page_id ); ?>
    </div>
</div>