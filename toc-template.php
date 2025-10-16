<?php
if (!defined('ABSPATH')) exit;

function atoc_get_toc_html($titles) {
    ob_start();
    ?>
    <div class="atoc-toc-wrapper">
        <div class="atoc-toc-title">فهرست محتوا</div>
        <ul class="atoc-toc-list">
            <?php foreach ($titles as $item): ?>
                <li><a href="#<?php echo esc_attr($item['anchor']); ?>"><?php echo esc_html($item['title']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
