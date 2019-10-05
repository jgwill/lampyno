<?php

function URP_Return_Pointers() {
  $pointers = array();

  $pointers['tutorial-one'] = array(
    'title'     => "<h3>" . 'Ultimate Reviews Intro' . "</h3>",
    'content'   => "<div><p>Thanks for installing Ultimate Reviews! These 6 slides will help get you started using the plugin.</p></div><div class='urp-pointer-count'><p>1 of 6 - <span class='urp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '.Header',
    'edge'      => 'top',
    'align'     => 'left',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-URP-Options') // <-- Please note this
  );

  $pointers['tutorial-two'] = array(
    'title'     => "<h3>" . 'Allow Visitors to Submit Reviews' . "</h3>",
    'content'   => "<div><p>Place the [submit-review] shortcode in the content area of any page you've created and it will display a form allowing visitors to submit reviews. Use the 'product_name' attribute to limit the review form to one product. If 'Require Admin Approval' is enabled, go to the 'Awaiting Approval' tab to see any new unapproved reviews.</p></div><div class='urp-pointer-count'><p>2 of 6 - <span class='urp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#menu-pages',
    'edge'      => 'top',
    'align'     => 'left',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-URP-Options') // <-- Please note this
  );

  $pointers['tutorial-three'] = array(
    'title'     => "<h3>" . 'Display Reviews' . "</h3>",
    'content'   => "<div><p>Place the [ultimate-reviews] shortcode in the content area of any page you've created and it will display your reviews. Use the 'product_name' attribute to limit the displayed reviews to one product.</p></div><div class='urp-pointer-count'><p>3 of 6 - <span class='urp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#menu-pages',
    'edge'      => 'top',
    'align'     => 'left',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-URP-Options') // <-- Please note this
  );

  $pointers['tutorial-four'] = array(
    'title'     => "<h3>" . 'Manually Create New Reviews' . "</h3>",
    'content'   => "<div><p>Click 'Add New' to manually create reviews for your visitors to view. Enter the review title in the title area and the review content in the main post content area. You can also set a review image using the 'Featured Image' area. Set the review details (product name, score, author, etc.) using the 'Review Details' section under the main post content area.</p></div><div class='urp-pointer-count'><p>4 of 6 - <span class='urp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#toplevel_page_EWD-URP-Options',
    'edge'      => 'top',
    'align'     => 'left',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-URP-Options') // <-- Please note this
  );

  $pointers['tutorial-five'] = array(
    'title'     => "<h3>" . 'Customize Options' . "</h3>",
    'content'   => "<div><p>The 'Options' tab has options to help customize the plugin perfectly for your site, including:</p><ul><li>Choosing whether to have text or stars for score rating input</li><li>Review images</li><li>Restricting reviews to a specific set of products (that you define)</li><li>Email notifications and more!</li></ul></div><div class='urp-pointer-count'><p>5 of 6 - <span class='urp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#Options_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-URP-Options') // <-- Please note this
  );

  $pointers['tutorial-six'] = array(
    'title'     => "<h3>" . 'Need More Help?' . "</h3>",
    'content'   => "<div><p><a href='https://wordpress.org/support/plugin/ultimate-reviews/reviews/'>Help us spread the word with a 5 star rating!</a><br><br>We've got a number of videos on how to use the plugin:<br /><iframe width='560' height='315' src='https://www.youtube.com/embed/41aGEdRfgNY?list=PLEndQUuhlvSpw3HQakJHj4G0F0Gyc-CtU' frameborder='0' allowfullscreen></iframe></p></div><div class='urp-pointer-count'><p>6 of 6</p></div>",
    'anchor_id' => '#wp-admin-bar-site-name',
    'edge'      => 'top',
    'align'     => 'left',
    'width'     => '600',
    'where'     => array( 'toplevel_page_EWD-URP-Options') // <-- Please note this
  );

  return $pointers;
}

?>
