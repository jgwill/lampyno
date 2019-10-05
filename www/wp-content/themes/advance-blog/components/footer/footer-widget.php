<?php
if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')): ?>
    <div class="footer-widget-area">
        <div class="wrapper">
            <div class="flex-grid">
            <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="col">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="col">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('footer-3')) : ?>
                <div class="col">
                    <?php dynamic_sidebar('footer-3'); ?>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif;