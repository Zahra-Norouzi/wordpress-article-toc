<?php
/*
Plugin Name: Article TOC
Description: نمایش فهرست محتوا براساس تگ h2 در مقالات
Version: 1.0
Author: Zahra Norouzi
*/

// شورت‌کد [article_toc]
function atoc_generate_toc_shortcode($atts) {
    require_once plugin_dir_path(__FILE__) . 'toc-template.php';
    global $post;
    if (empty($post) || empty($post->post_content)) return '';
    $content = $post->post_content;
    $matches = [];
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $content, $matches);
    if (empty($matches[1])) return '';
    $toc_titles = [];
    foreach ($matches[1] as $i => $title) {
        $anchor = 'atoc-h2-' . ($i+1);
        $content = preg_replace('/(<h2[^>]*>)(.*?)<\/h2>/is', '$1<a id="' . $anchor . '"></a>$2</h2>', $content, 1);
        $toc_titles[] = [
            'anchor' => $anchor,
            'title' => wp_strip_all_tags($title)
        ];
    }
    $output = atoc_get_toc_html($toc_titles);

    add_filter('the_content', function($c) use ($content) { return $content; }, 11);
    return $output;
}
add_shortcode('article_toc', 'atoc_generate_toc_shortcode');


function atoc_toc_enqueue_styles() {
    wp_enqueue_style('atoc-article-toc', plugins_url('assets/css/article-toc.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'atoc_toc_enqueue_styles');
