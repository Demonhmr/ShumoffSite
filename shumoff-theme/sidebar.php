<?php
/**
 * Shumoff Theme - Sidebar Template
 *
 * @package Shumoff_Theme
 */

if ( ! is_active_sidebar( 'sidebar-main' ) ) {
    return;
}
?>

<aside class="sidebar" id="secondary">
    <div class="sidebar-inner">
        <?php dynamic_sidebar( 'sidebar-main' ); ?>
    </div>
</aside>
