<?php
/**
 * Template Name: About - Leadership
 *
 * The template for the Leadership page
 */
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php get_template_part('partials/about', 'header'); ?>

            <?php the_post(); ?>

            <section class="section-content leadership-content">
                <?php get_template_part('partials/content', 'about') ?>
            </section>

            <section class="section-content">
                <?php
                $associated_bios = get_post_meta($post->ID, 'ws_attached_leadership_programs_bios', true);
                if ($associated_bios): ?>
                    <h2>Programs</h2>
                <?php endif; ?>
                <?php
                $bio_counter = 0;
                foreach ($associated_bios as $bio_id) : ?>
                    <?php $bio_counter++; ?>
                    <?php $post = get_post($bio_id); ?>
                    <?php setup_postdata($post); ?>
                    <?php $position = get_post_meta($post->ID, 'ws_bio_position', true); ?>
                   
                    <div class="col-md-4 no-padding">
                        <article <?php post_class(); ?>>
                            <header class="entry-header">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="headshot clearfix">
                                        <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"><?php echo get_the_post_thumbnail($post->ID, 'medium', $attr = 'style=width:100%'); ?></a>
                                    </div>
                                <?php else : ?>
                                    <div class="headshot-pattern <?php echo WS_Helpers::get_random_pattern(); ?>">
                                        <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"></a>
                                    </div>
                                <?php endif; ?>

                                <h3 class="leader-name entry-title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <?php if ($position) : ?>
                                    <span class="entry-position"><?php echo esc_html($position); ?></span>
                                <?php endif; ?>
                            </header>

                            <div class="bio-content">
                                <?php
                                if (get_the_excerpt()) {
                                    the_excerpt();
                                } else {
                                    the_content();
                                }
                                ?>
                            </div>

                            <footer class="entry-footer">
                                <a href="<?php the_permalink(); ?>">Read more about <?php the_title(); ?></a>
                            </footer>
                        </article>
                    </div>

                    <?php if ($bio_counter % 3 == 0): ?>
                       <div style="clear:both"></div>
                    <?php endif; ?>
                <?php endforeach; wp_reset_postdata(); ?>

                <div style="clear:both"></div>

                <?php
                $bio_counter = 0;
                $associated_customer_bios = get_post_meta($post->ID, 'ws_attached_leadership_customer_bios', true);
                ?>
                <?php if ($associated_customer_bios): ?>
                    <h2>Customer Contacts</h2>
                    <?php
                    foreach ($associated_customer_bios as $bio_id) : ?>
                        <?php $bio_counter++; ?>
                        <?php $post = get_post($bio_id); ?>
                        <?php setup_postdata($post); ?>
                        <?php $position = get_post_meta($post->ID, 'ws_bio_position', true); ?>
                        <div class="col-md-4 no-padding">
                            <article <?php post_class(); ?>>
                                <header class="entry-header">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="headshot clearfix">
                                            <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"><?php echo get_the_post_thumbnail($post->ID, 'medium', $attr = 'style=width:100%'); ?></a>
                                        </div>
                                    <?php else : ?>
                                        <div class="headshot-pattern <?php echo WS_Helpers::get_random_pattern(); ?>">
                                            <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"></a>
                                        </div>
                                    <?php endif; ?>

                                    <h3 class="leader-name entry-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                    <?php if ($position) : ?>
                                        <span class="entry-position"><?php echo esc_html($position); ?></span>
                                    <?php endif; ?>
                                </header>

                                <div class="bio-content">
                                    <?php
                                    if (get_the_excerpt()) {
                                        the_excerpt();
                                    } else {
                                        the_content();
                                    }
                                    ?>
                                </div>

                                <footer class="entry-footer">
                                    <a href="<?php the_permalink(); ?>">Read more about <?php the_title(); ?></a>
                                </footer>
                            </article>
                        </div>
                        <?php if ($bio_counter % 3 == 0): ?>
                           <div style="clear:both"></div>
                        <?php endif; ?>
                    <?php endforeach; wp_reset_postdata(); ?>
                <?php endif; ?>
                <div style="clear:both"></div>

                <?php
                $associated_shared_bios = get_post_meta($post->ID, 'ws_attached_leadership_shared_bios', true);
                $bio_counter = 0;
                if ($associated_shared_bios):?>
                    <h2>Shared Support</h2>
                    <?php
                    foreach ($associated_shared_bios as $bio_id) : ?>
                        <?php $bio_counter++; ?>
                        <?php $post = get_post($bio_id); ?>
                        <?php setup_postdata($post); ?>
                        <?php $position = get_post_meta($post->ID, 'ws_bio_position', true); ?>
                       
                        <div class="col-md-4 no-padding">
                            <article <?php post_class(); ?>>
                                <header class="entry-header">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="headshot clearfix">
                                            <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"><?php echo get_the_post_thumbnail($post->ID, 'medium', $attr = 'style=width:100%'); ?></a>
                                        </div>
                                    <?php else : ?>
                                        <div class="headshot-pattern <?php echo WS_Helpers::get_random_pattern(); ?>">
                                            <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"></a>
                                        </div>
                                    <?php endif; ?>

                                    <h3 class="leader-name entry-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                    <?php if ($position) : ?>
                                        <span class="entry-position"><?php echo esc_html($position); ?></span>
                                    <?php endif; ?>
                                </header>

                                <div class="bio-content">
                                    <?php
                                    if (get_the_excerpt()) {
                                        the_excerpt();
                                    } else {
                                        the_content();
                                    }
                                    ?>
                                </div>

                                <footer class="entry-footer">
                                    <a href="<?php the_permalink(); ?>">Read more about <?php the_title(); ?></a>
                                </footer>
                            </article>
                        </div>
                        <?php if ($bio_counter % 3 == 0): ?>
                           <div style="clear:both"></div>
                        <?php endif; ?>
                    <?php endforeach;
                    wp_reset_postdata(); ?>
                <?php endif; ?>
            </section>
        </main>
    </div>


<?php get_footer(); ?>