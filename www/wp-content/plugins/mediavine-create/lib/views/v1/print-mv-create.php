<?php
$creation = (array) $args['creation'];
echo do_shortcode( '[mv_create type="' . $args['type'] . '" key="' . $creation['id'] . '" print="true" style="' . $args['card_style'] . '"]' );
