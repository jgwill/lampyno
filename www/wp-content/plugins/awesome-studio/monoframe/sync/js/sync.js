var sync={};
(function ($) {
  
	sync.get_url_vars=function(){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}

	sync.initialize=function(action,post_slug,post_type,active_btn,app_slug,reload){
		var d = $.Deferred();
		var site_url=$(active_btn).siblings('.js-site-sync-url').val();

		if(site_url.length==0){
			var msg='<div class="error">Please select the site to Sync</div>';
			$(active_btn).siblings('.js-action-msg').html(msg);  
			//ladda.stop();
			d.resolve();
			return;
		}
			
		url=ajaxurl+'?action=awesome_sync_init&post_slug='+post_slug+'&activity='+action+'&post_type='+post_type+'&app_slug='+app_slug+'&site_url='+encodeURIComponent(site_url);
		$.get(url,function( response ) {
			//ladda.stop();
			var data = $.parseJSON(response);//parse JSON
			if(data.status == 'fail'){
				var msg='<div class="error">'+data.message+'</div>';
				$(active_btn).siblings('.js-action-msg').html(msg);  
			} else {
				var msg='<div class="updated">'+data.message+'</div>';
				$(active_btn).siblings('.js-action-msg').html(msg); 
				if(reload=='true'){
					window.location.reload(true); 
				}
			}
			d.resolve();
		});
		
		return d.promise();		
	}
	
	sync.bulk_initialize=function(action,post_type,ladda,active_btn,app_slug){
		var js_action_msg =$(active_btn).siblings('.js-action-msg');
		var js_progress = $(active_btn).parents('td.actions').find('.js-progress');
		var site_url= $(active_btn).siblings('.js-site-sync-url').val();
		
		js_action_msg.hide();
		
		if(site_url.length==0){
			var msg='<div class="error">Please select the site to Sync</div>';
			js_action_msg.html(msg);
			js_action_msg.show();			
			ladda.stop();
			return;
		}
			
		url=ajaxurl+'?action=awesome_bulk_sync&activity='+action+'&post_type='+post_type+'&app_slug='+app_slug+'&site_url='+encodeURIComponent(site_url);
		$.get(url,function( response ) {
			
			var data = $.parseJSON(response);//parse JSON
			if(data.status == 'fail'){
				ladda.stop();
				var msg='<div class="error">'+data.message+'</div>';
				js_action_msg.html(msg);
				js_action_msg.show(); 
			} 
			else {
				//all the items that can be installed are avilable
				//setup a progress bar display
				
				js_progress.attr('max',data.items.length);
				js_progress.attr('value',0);
				js_progress.show();
				$(window).on('beforeunload.bulk_initialize',function(e){
					confirmationMessage = "Sync will fail if you navigate away from this page.";
					e.returnValue = confirmationMessage;     // Gecko, Trident, Chrome 34+
					return confirmationMessage;
				});
				
				$.when(sync.handle_bulk_items(action,app_slug,active_btn,data.items)).then(function(){
					ladda.stop();
					js_action_msg.show();
					js_progress.hide();
					$(window).off('beforeunload.bulk_initialize');
				});
			}
		});
	}
	
	sync.handle_bulk_items=function(action,app_slug,active_btn,items){
		if (typeof items == 'undefined'){
			return true;
		}
		//get first item and send the request on it's success remove the item and call the function again till item count is 0

		var d = $.Deferred();
		var progress_count = 0;
		var js_progress = $(active_btn).parents('td.actions').find('.js-progress');
		function single_item(){
			//console.log(items);
			//console.log(items.length);
			if(!items.length){
				d.resolve();
			}
			else {
				var post_slug=items[0].post_name;
				var post_type=items[0].post_type;
				
				$.when(sync.initialize(action,post_slug,post_type,active_btn,app_slug,false)).then(function(){
					progress_count++;
					js_progress.attr('value',progress_count);
					items.shift();				
					single_item();
				}); 
			}
		}
		single_item();
		return d.promise();
	}
	
	sync.ladda_bind=function(target, options ) {
		
		options = options || {};

			var targets = [];
		
		if( typeof target === 'string' ) {
			nodes=document.querySelectorAll( target );
			for ( var i = 0; i < nodes.length; i++ ) {
				targets.push( nodes[ i ] );
			}
		}
		else if( typeof target === 'object' && typeof target.nodeName === 'string' ) {
			targets = [ target ];
		}
		
		for( var i = 0, len = targets.length; i < len; i++ ) {

			(function() {
				var element = targets[i];

				// Make sure we're working with a DOM element
				if( typeof element.addEventListener === 'function' ) {
					var instance = Ladda.create( element );

					element.addEventListener( 'click', function( event ) {
						instance.startAfter( 1 );
						// Invoke callbacks
						if( typeof options.callback === 'function' ) {
							options.callback.apply(element, [ instance ] );
						}
					

					}, false );
				}
			})();

		}
		
	}
	
	sync.ladda_install_bind=function(selector,action){
		sync.ladda_bind( selector,{
		    callback: function( instance ) {
				var active_btn=this;
				
				var post_slug = this.getAttribute('data-slug');
				var post_type = this.getAttribute('data-post_type');
				var app_slug = this.getAttribute('data-app');
				var reload = this.getAttribute('data-reload');
				
				$(active_btn).siblings('.js-action-msg').html('');
				$.when(sync.initialize(action,post_slug,post_type,active_btn,app_slug,reload)).then(function(){
					instance.stop();
				});
				
		    }
		});
	}
	
	sync.ladda_bulk_install_bind=function(selector,action){
		sync.ladda_bind( selector,{
		    callback: function( instance ) {
				var active_btn=this;
				
				var post_type = this.getAttribute('data-post_type');
				var app_slug = this.getAttribute('data-app_slug');
				
				
				$(active_btn).siblings('.js-action-msg').html('');
				bootbox.confirm({
					title: "Are You Sure?",
					message: "Bulk action will update all the posts within "+post_type+". Proceed with Caution.",
					closeButton: true,
					onEscape: function() {
						instance.stop();
					},
					buttons: {
						confirm: {
							label: "Continue",
							className: "btn-danger",
							
						},
						cancel: {
							label: 'Cancel',
							className: "btn-default",
						}
					},
					callback: function(result) {
						if(result)
							sync.bulk_initialize(action,post_type,instance,active_btn,app_slug);
						else
							instance.stop();
					}
				});	
				
		    }
		});
	}
	
	
	sync.get_types=function(){
		
		active_object = $('.master-nav a.selected').data('value');
	
		$.get(ajaxurl+'?action=aw2_get_types&object_type='+active_object,function( response ) {
			$('#aw2-loader').hide();

			var data = $.parseJSON(response);//parse JSON

			if(data.error){
				var msg='<div class=error>'+data.message+'</div>';
				$('.js-modules').html(msg);  
			} else {
				if(data.results.length){
					$menu=$('<ul class="menuitems"></ul>');			
					$.each(data.results, function(i, item) {
						//console.log(item);
						if(item.slug!='ignore'){
							$menu.append('<li><a href="#'+item.slug+'" class="js-menu-item"><span>'+item.name+'</span><span>'+item.count+' available</span></a></li>');
						}				
					});
					
					
					if(window.location.hash.length > 0)
					{
						$menu.find('[href^="'+window.location.hash+'"]').addClass('js-active-menu').addClass('active-item')
					}	
					else{
						$menu.find('.js-menu-item').first().addClass('js-active-menu').addClass('active-item');
					}
					
					
					$menu.appendTo('.js-menu');
					$('.aw2_navbar').show();
					awesome_catalogue.set_priority_nav();
				}	
				
				awesome_catalogue.get_catalogue_items();
				
			}
		 
		});
	}

}) (jQuery);

 jQuery(document).ready(function($){
	
	sync.ladda_install_bind('.js-push-button','push');
	sync.ladda_install_bind('.js-pull-button','pull');	
	
	sync.ladda_bulk_install_bind('.js-bulk-push-button','push');
	sync.ladda_bulk_install_bind('.js-bulk-pull-button','pull');	
	
	$('.js-site-sync-url').on('change', function() {
		$('.js-site-sync-url').val($(this).val());
	});
	
});