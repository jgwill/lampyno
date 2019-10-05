<?php

add_filter( 'default_content', 'aw2_default_ui_editor_content', 10, 2);

function aw2_default_ui_editor_content( $content ,$post) {
$content='';
if($post->post_type=='ui_block')
{
	$content = "<!-- Set help for component-->
[aw2_ignore help]
query with id: query_{{aw2_param ui_slug}}
The query must return a post

Fields
-----------------
read_more_text: The title of the Button for redirection to post page
read_more_link:The link to redirect to
[/aw2_ignore]

<!-- Set default parameters-->
[aw2_query_posts id='query_{{aw2_param ui_slug}}' param_not_exists='query_{{aw2_param ui_slug}}']
{
'post_type':'post'
}
[/aw2_query_posts]
[aw2_set_field overwrite='yes']
	{
	'read_more_text':'Know More',
	'read_more_link':'[aw2_loop_value url]'
	}
[/aw2_set_field] 

<!-- Include any libraries-->
[aw2_include_lib match_height]

<!-- Set any Templates-->

[aw2_set_template filter_button]
[/aw2_set_template]	

<!-- Less and not css-->
[aw2_less]
	.[aw2_param ui_slug]{

	}
[/aw2_less]

<!-- HTML Output-->
<div id='[aw2_param ui_id]' class='col-xs-12 [aw2_param ui_class] [aw2_param ui_slug]'>
	
</div>
<!-- Ready Script-->
[aw2_ready_script]
	
[/aw2_ready_script]";
}

if($post->post_type=='aw2_query')
{
	$content = '[aw2_query_posts part=main id=\'{{aw2_local query_id}}\']
	{
		"posts_per_page": [aw2_local posts_per_page default=\'-1\'],
		"post_type": "post",
		"post_status": "publish",
		"post__not_in": [ [aw2_local post_not_in ] ],
		"offset": "[aw2_local offset default=\'0\']",
		"order": "[aw2_local order default=\'DESC\']",
		"orderby": "[aw2_local orderby default=\'date\']"
		
	}
[/aw2_query_posts]

[aw2_query_posts part=meta_query not_empty=\'{{aw2_local parent_shop_id}}\' id=\'{{aw2_local query_id}}\']
	{
		"key": "parent_shop_id",
		"value": "[aw2_local parent_shop_id]",
		"compare": "="
	}
[/aw2_query_posts]

[aw2_query_posts part=tax_query not_empty=\'{{aw2_local service_term_id}}\' id=\'{{aw2_local query_id}}\']
  {
  	"taxonomy": "service",
  	"terms": [ [aw2_local service_term_id /] ],
  	"field": "ids"
	}
[/aw2_query_posts]

[aw2_query_posts part=tax_query not_empty=\'{{aw2_local city}}\' id=\'{{aw2_local query_id}}\']
  {
  	"taxonomy": "city",
  	"terms": "[aw2_local city /]",
  	"field": "slug"
	}
[/aw2_query_posts]

[aw2_query_posts id=\'{{aw2_local query_id}}\' run=true query_type=\'{{aw2_local query_type default="get_posts"}}\'][/aw2_query_posts]';
}

if($post->post_type=='aw2_data')
{
	$content = '[aw2_create_table id="newsletter_content"]
{
  "action_button_text":"Need help in upgrading?",
  "action_button_url":"http://www.wpoets.com/wordpress-upgrade/"
}
[/aw2_create_table]

[aw2_create_row id="newsletter_content"]
[aw2_create_cols col="main_content" ]
<p>
	<h2>Is your WordPress updated?</h2>
</p>
[/aw2_create_cols]
[/aw2_create_row]';
}
if($post->post_type=='aw2_hook')
{
	$content = '[aw2_set_hook action="init"]

[/aw2_set_hook]';
}
	return $content;
}