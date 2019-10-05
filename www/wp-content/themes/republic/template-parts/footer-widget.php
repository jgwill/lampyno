<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="large-12 columns footerwidgetarea">
    <div class="footer-widgets">
<div class="bottom-menu-1 large-3 columns">
<?php if (!dynamic_sidebar('footer-1') ) : ?>
<?php endif; ?>
</div> <!-- end div #bottom-menu-left -->
<div class="bottom-menu-2 large-3 columns">
<?php if (!dynamic_sidebar('footer-2') ) : ?>
<?php endif; ?>
</div> <!-- end div #bottom-menu-center -->
<div class="bottom-menu-3 large-3 columns">
<?php if ( !dynamic_sidebar('footer-3') ) : ?>
<?php endif; ?>
</div>
<div class="bottom-menu-4 large-3 columns">
<?php if ( !dynamic_sidebar('footer-4') ) : ?>
<?php endif; ?>
</div></div></div>