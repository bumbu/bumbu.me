<?php
/**
 * Plugin Name: WP Markdown Editor (bumbu)
 * Plugin URI: https://github.com/hoducha/wp-markdown-editor
 * Description: WP Markdown Editor replaces the default editor with a WYSIWYG Markdown Editor for your posts and pages.
 * Version: 3.0.0
 * Author: Ha Ho
 * Website: http://www.hoducha.com
 * License: GPLv2 or later
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

if (!function_exists('jetpack_require_lib')) {
    include_once dirname( __FILE__ ) . '/jetpack/require-lib.php';
}

if (!class_exists('WPCom_Markdown')) {
    include_once dirname( __FILE__ ) . '/jetpack/markdown/easy-markdown.php';
}

define('PLUGIN_VERSION', '2.0');
define('MINIMUM_WP_VERSION', '3.1');

class WpMarkdownEditor
{
    private static $instance;

    private function __construct()
    {
        // Activation / Deactivation hooks
        register_activation_hook(__FILE__, array($this, 'plugin_activation'));
        register_deactivation_hook(__FILE__, array($this, 'plugin_deactivation'));

        // Load markdown editor
        add_action('admin_enqueue_scripts', array($this, 'enqueue_stuffs'));
        add_action('admin_footer', array($this, 'init_editor'));

        // Remove quicktags buttons
        add_filter('quicktags_settings', array($this, 'quicktags_settings'), $editorId = 'content');

        // Load Jetpack Markdown module
        $this->load_jetpack_markdown_module();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    function enqueue_stuffs()
    {
        // only enqueue stuff on the post editor page
        if (get_current_screen()->base !== 'post') {
            return;
        }

        wp_enqueue_script('simplemde-js', $this->plugin_url('/editor/simplemde.min.js'));
        wp_enqueue_script('marked-js', $this->plugin_url('/editor/marked.min.js'));
        wp_enqueue_style('simplemde-css', $this->plugin_url('/editor/simplemde.min.css'));
        wp_enqueue_style('custom-css', $this->plugin_url('/style.css'));
    }

    function load_jetpack_markdown_module()
    {
        // If the module is active, let's make this active for posting, period.
        // Comments will still be optional.
        add_filter('pre_option_' . WPCom_Markdown::POST_OPTION, '__return_true');
        add_action('admin_init', array($this, 'jetpack_markdown_posting_always_on'), 11);
    }

    function jetpack_markdown_posting_always_on()
    {
        global $wp_settings_fields;
        if (isset($wp_settings_fields['writing']['default'][ WPCom_Markdown::POST_OPTION ])) {
            unset($wp_settings_fields['writing']['default'][ WPCom_Markdown::POST_OPTION ]);
        }
    }

    function init_editor()
    {
        if (get_current_screen()->base == 'post') {
            wp_enqueue_script('init-editor', $this->plugin_url('/editor/init.js'));
        }

    }

    function quicktags_settings($qtInit)
    {
        $qtInit['buttons'] = ' ';
        return $qtInit;
    }

    function plugin_url($path)
    {
        return plugins_url('wp-markdown-editor/' . $path);
    }

    function plugin_activation()
    {
        global $wpdb;
        $wpdb->query("UPDATE `" . $wpdb->prefix . "usermeta` SET `meta_value` = 'false' WHERE `meta_key` = 'rich_editing'");
    }

    function plugin_deactivation()
    {
        global $wpdb;
        $wpdb->query("UPDATE `" . $wpdb->prefix . "usermeta` SET `meta_value` = 'true' WHERE `meta_key` = 'rich_editing'");
    }

}

WpMarkdownEditor::getInstance();
