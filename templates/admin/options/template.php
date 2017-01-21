<?php
/**
 * Template Option template
 */
?>
<div
    class="clt-templates"
    <?php if(!empty($alert_message)) : ?>
        data-alert-message="<?php echo esc_attr($alert_message) ?>"
    <?php endif; ?>
    >
    <?php printf('<div class="clt-col-12"><p class="clt-option-description">%s</p></div>',$descr) ?>
    <?php foreach( $value as $val => $template ) :
        $label = $template[0];
        $img_url = isset($template[1]) ? $template[1] : $this->get_plugin_uri() . '/themes/' . $val . '/screenshot.png';
        if(!empty($template[2]))
            $ribbon = $template[2];
        else
            $ribbon = null;
         ?>
        <div class="clt-col-6">
            <label class="clt-template-label<?php if(isset($img_url)) echo ' clt-template-image'?>"<?php if(isset($ribbon)) echo ' data-ribbon="'.esc_attr($ribbon).'"' ?>>
                <input
                    type="radio"
                    id="<?php echo esc_attr( $id . $label ) ?>"
                    data-group-id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $id ) ?>"
                    value="<?php echo esc_attr( $val ) ?>"
                    <?php checked( $val ,  get_option( $id ) ? get_option( $id ) : $std ) ?>
                    >
                <?php if(isset($img_url)) : ?>
                    <img src="<?php echo esc_url($img_url) ?>" alt="<?php esc_attr_e('template image','cwp_login') ?>" title="<?php echo esc_attr($label) ?>">
                <?php endif; ?>
                <span data-content="已启用" class="wp-ui-primary"><?php echo esc_html($label) ?></span>
            </label>
        </div>
    <?php endforeach; ?>
</div>
