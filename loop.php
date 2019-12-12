<div class="row">
<?php
$home = esc_url(home_url());
$wp_url = get_template_directory_uri();
if (have_posts()): while (have_posts()):
the_post();
$ttl = get_the_title();
$permalink = get_the_permalink();
$cat = get_the_category();
$cat_name = $cat[0]->name;
$img = '';
$img_m = '';
if (has_post_thumbnail()) {
    $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $img_m = get_the_post_thumbnail_url(get_the_ID(), 'large');
    if ($img == false) {
        $img = $wp_url.'/lib/images/blog-1-1000x600.jpg';
        $img_m = $wp_url.'/lib/images/blog-1-1000x600.jpg';
    }
} else {
    $img = $wp_url.'/lib/images/blog-1-1000x600.jpg';
    $img_m = $wp_url.'/lib/images/blog-1-1000x600.jpg';
}
$thumbnail = '<img class="card-img-top" src="'.$img_m.'" srcset="'.$img_m.' 1x, '.$img.' 2x" alt="'.$ttl.'">';
?>
<div class="col-lg-4 col-md-6 mb-4">
<div class="card border-0 shadow-sm">
<?php echo $thumbnail; ?>
<div class="card-body">
<h2 class="h5 text-dark font-weight-bold card-text"><?php echo $ttl; ?></h2>
<div class="text-right">
<span class="badge badge-pill badge-primary"><?php echo $cat_name; ?></span>
</div>
<a class="stretched-link" href="<?php echo $permalink; ?>"></a>
</div>
<div class="card-footer border-0">
<time class="text-muted small" datetime="<?php the_modified_time('Y-m-d'); ?>"><i class="fas fa-history mr-2"></i><?php the_modified_time('Y.m.d'); ?></time>
</div>
</div>
</div>
<?php endwhile; ?>
</div>
<?php
endif;
if (function_exists('pagination')) {
    pagination($additional_loop->max_num_pages);
}
