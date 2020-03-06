<?php
$home = esc_url(home_url());
$wp_url = get_template_directory_uri();
get_header();
the_post();
$post_id = get_the_ID();
$ttl = get_the_title();
$permalink = get_the_permalink();
$cat = get_the_category();
$cat = $cat[0];
$cat_id = $cat->term_id;
$cat_name = $cat->name;
$cat_slug = get_category_link($cat_id);
$img = '';
$img_m = '';
if (has_post_thumbnail()) {
    $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $img_m = get_the_post_thumbnail_url(get_the_ID(), 'large');
}
?>
<section class="uk-section-small">
<div class="uk-container">
<div class="uk-grid-divider" uk-grid>
<article id="post-main" class="post-main uk-article uk-width-expand@m">
<h1 class="uk-h2"><?php echo $ttl; ?></h1>
<div class="uk-article-meta uk-flex uk-flex-wrap">
<time class="uk-margin-right" datetime="<?php the_time('Y-m-d'); ?>"><span class="uk-margin-small-right" uk-icon="calendar"></span><?php the_time('Y.m.d'); ?></time>
<time class="uk-margin-right" datetime="<?php the_modified_time('Y-m-d'); ?>"><span class="uk-margin-small-right" uk-icon="history"></span><?php the_modified_time('Y.m.d'); ?></time>
<p class="uk-margin-remove-top uk-margin-remove-bottom">
<a class="uk-link-text" href="<?php echo $cat_slug; ?>"><span class="uk-margin-small-right" uk-icon="folder"></span><?php echo $cat_name; ?></a>
</p>
</div>
<?php
$tags = get_the_tags();
if ($tags !== null): ?>
<div class="post-tags uk-margin-top">
<?php
foreach ($tags as $tag):
$tag_url = get_tag_link($tag->term_id);
$tag_name = $tag->name;
?>
<a class="uk-badge uk-padding-small uk-margin-small-bottom uk-margin-small-right" href="<?php echo $tag_url; ?>">#<?php echo $tag_name; ?></a>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if ($img != ''): ?>
<figure>
<img loading="lazy" class="uk-box-shadow-small uk-width-expand" src="<?php echo $img_m; ?>" srcset="<?php echo $img_m; ?> 1x, <?php echo $img; ?> 2x" alt="<?php echo $ttl; ?>">
</figure>
<?php endif; ?>
<div id="toc" class="toc uk-section-muted"></div>
<div class="main-article">
<?php the_content(); ?>
<hr class="uk-divider-icon">
<?php echo do_shortcode('[addtoany]'); ?>
</div>
</article>
<?php get_sidebar(); ?>
</div>
</div>
</section>
<?php get_footer();