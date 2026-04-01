<?php
/**
 * Nav menu page MegaMenu trigger template
 */

defined( 'ABSPATH' ) || exit;
?>
<script>
    var zy_megamenu_trigger_markup = `
    <div class="zy-megamenu-trigger" id="zy-megamenu-trigger">
        <div class="zy-toggle">
            <input id="zy-menu-metabox-input-is-enabled" <?php checked( ( isset( $data['is_enabled'] ) ? $data['is_enabled'] : '' ), '1' ); ?> type="checkbox" class="zy-toggle__check zy-megamenu-is-enabled" name="is_enabled" value="1">
            <b class="zy-toggle__switch"></b>
            <b class="zy-toggle__track"></b>
        </div>
        <h3 class="zy-dashboard-widgets__item-title">
            <label for="zy-menu-metabox-input-is-enabled"><span class="branding"></span> Zyre Mega Menu</label>
        </h3>
    </div>
    `;
</script>
