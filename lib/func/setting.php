<?php

// アイキャッチ設定
add_theme_support('post-thumbnails');

// html5許可
add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

// oembed消去
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

// wp-json消去
remove_action('template_redirect', 'rest_output_link_header', 11);

// 絵文字消去
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// 外部投稿ツール消去
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// meta generator消去
remove_action('wp_head', 'wp_generator');

// 短縮URL消去
remove_action('wp_head', 'wp_shortlink_wp_head');

// 次の記事消去
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

// adminbarカスタマイズ
function remove_adminbar_item($wp_admin_bar)
{
    if (!is_admin()) {
        $wp_admin_bar->remove_node('wp-logo');
        $wp_admin_bar->remove_node('new-content');
        $wp_admin_bar->remove_node('comments');
        $wp_admin_bar->remove_node('appearance');
        $wp_admin_bar->remove_node('updates');
        $wp_admin_bar->remove_node('search');
        $wp_admin_bar->remove_node('customize');
    }
}
add_action('admin_bar_menu', 'remove_adminbar_item', 999);

// タイトルタグ追加
add_theme_support('title-tag');

// タイトルタグセパレーター変更
function title_separator($sep)
{
    $sep = '｜';
    return $sep;
}
add_filter('document_title_separator', 'title_separator');

// 標準のjquery消去
function my_delete_local_jquery()
{
    wp_deregister_script('jquery');
}
add_action('wp_enqueue_scripts', 'my_delete_local_jquery');

// Gutenberg用のCSSの消去
function dequeue_plugins_style()
{
    wp_dequeue_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'dequeue_plugins_style', 9999);

// インラインCSSの消去
function remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head',
        [
          $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
          'recent_comments_style'
        ]
    );
}
add_action('widgets_init', 'remove_recent_comments_style');

// ウィジェット登録
function arphabet_widgets_init()
{
    register_sidebar(array(
        'name' => 'サイドバー',
        'id' => 'side-bar',
        'before_widget' => '<div class="sidebar-area">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="h5 title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'arphabet_widgets_init');

// メニュー登録
function register_my_menu()
{
    register_nav_menu('header-menu', __('ヘッダーメニュー'));
}
add_action('init', 'register_my_menu');

// エディタースタイル追加
function wpdocs_theme_add_editor_styles()
{
    add_editor_style('editor-style.css');
}
add_action('admin_init', 'wpdocs_theme_add_editor_styles');

// 抜粋文
function my_the_excerpt($postContent)
{
    $postContent = mb_strimwidth($postContent, 0, 90, '…', 'UTF-8');
    return $postContent;
}
add_filter('get_the_excerpt', 'my_the_excerpt');

// エディタースタイル
if (!function_exists('initialize_tinymce_styles')) {
    function initialize_tinymce_styles($init_array)
    {
        $style_formats = array(
      array(
        'title' => 'ボタン',
        'inline' => 'span',
        'classes' => 'rich-btn',
      ),
      array(
        'title' => '赤文字',
        'inline' => 'span',
        'classes' => 'markerPink',
      ),
      array(
        'title' => '注意',
        'block' => 'div',
        'classes' => 'exclamationBox',
      ),
    );
        $init_array['style_formats'] = json_encode($style_formats);
        $init_array['table_resize_bars'] = false;
        $init_array['object_resizing'] = 'img';

        return $init_array;
    }
}
add_filter('tiny_mce_before_init', 'initialize_tinymce_styles', 10000);

function extend_tiny_mce_before_init($mce_init)
{
    $mce_init['cache_suffix'] = 'v='.time();

    return $mce_init;
}
add_filter('tiny_mce_before_init', 'extend_tiny_mce_before_init');

