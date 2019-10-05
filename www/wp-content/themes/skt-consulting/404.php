<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package SKT Consulting
 */
get_header(); ?>
<div class="container">
    <div class="page_content">
        <section class="site-main" id="sitemain">
            <header class="page-header">
                <h1 class="entry-title"><?php
esc_html_e('404 Not Found', 'skt-consulting'); ?></h1>
            </header><!-- .page-header -->
            <div class="page-content">
                <p class="text-404"><?php
esc_html_e('Looks like you have taken a wrong turn.....Dont worry... it happens to the best of us.', 'skt-consulting'); ?></p>
                <?php
get_search_form(); ?>
            </div><!-- .page-content -->
        </section>
     <?php
get_sidebar(); ?>      
    <div class="clear"></div>
    </div>
</div>
<?php
get_footer(); ?>