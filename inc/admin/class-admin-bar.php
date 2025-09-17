<?php
/**
 * Admin Bar Events Menu
 *
 * @package DmEvents
 * @subpackage Admin
 */

namespace DmEvents\Admin;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds Events navigation to WordPress admin bar
 */
class Admin_Bar {

    public function __construct() {
        add_action('admin_bar_menu', array($this, 'add_events_menu'), 999);
    }

    /**
     * Add Events menu to admin bar
     *
     * @param WP_Admin_Bar $wp_admin_bar
     */
    public function add_events_menu($wp_admin_bar) {
        if (!current_user_can('edit_posts')) {
            return;
        }

        // Get events page URL from settings
        $events_url = Settings_Page::get_main_events_page_url();

        // Fallback to post type archive if no custom URL set
        if (empty($events_url)) {
            $events_url = get_post_type_archive_link('dm_events');
        }

        // Don't add menu if no URL available
        if (empty($events_url)) {
            return;
        }

        $wp_admin_bar->add_menu(array(
            'id'    => 'dm-events',
            'title' => __('View Events', 'dm-events'),
            'href'  => $events_url,
            'meta'  => array(
                'title' => __('View Events Calendar', 'dm-events'),
                'target' => '_blank'
            )
        ));
    }
}