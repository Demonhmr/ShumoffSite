<?php
/**
 * Shumoff Theme - Search Form
 *
 * @package Shumoff_Theme
 */
?>
<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="search-field" class="search-label">
        <span class="screen-reader-text"><?php _e( 'Поиск по сайту:', 'shumoff' ); ?></span>
    </label>
    <input type="search"
           id="search-field"
           class="search-field"
           placeholder="<?php echo esc_attr_x( 'Поиск...', 'placeholder', 'shumoff' ); ?>"
           value="<?php echo get_search_query(); ?>"
           name="s"
           required>
    <button type="submit" class="search-submit" aria-label="Поиск">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </button>
</form>
