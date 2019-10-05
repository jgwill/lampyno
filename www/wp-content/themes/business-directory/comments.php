<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Business Directory
 * @since Business Directory 1.0.3
 */
if (comments_open()) :
    ?>
    <div id="commentsbox">
        <?php if (have_comments()) : ?>
            <h3 id="comments">
                <?php
                comments_number(__('No Responses', 'business-directory'), __('One Response', 'business-directory'), __('% Responses', 'business-directory'));
                _e('so far', 'business-directory');
                ?></h3>
            <ol class="commentlist">
                <?php wp_list_comments(); ?>
            </ol>
            <div class="comment-nav">
                <div class="alignleft">
                    <?php previous_comments_link() ?>
                </div>
                <div class="alignright">
                    <?php next_comments_link() ?>
                </div>
            </div>
            <?php
        else : // this is displayed if there are no comments so far 
            if (comments_open()) :
                ?>
                <!-- If comments are open, but there are no comments. -->
            <?php else : // comments are closed      ?>
                <!-- If comments are closed. -->
                <p class="nocomments"><?php _e('Comments are closed.', 'business-directory'); ?></p>
            <?php
            endif;
        endif;
        if (comments_open()) :
            comment_form();
        endif; // if you delete this the sky will fall on your head    
        ?>
    </div>
    <?php
endif; // end ! comments_open() ?>