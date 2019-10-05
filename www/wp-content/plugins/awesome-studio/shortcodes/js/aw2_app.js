(

function($) {
	var applib=spa_libs.add({id: 'app'});

	// Submit a form	
	applib.form_submit=function(obj) {
		var model=obj.model;
		$bound_element=obj.$bound_element
		//show spinner library
		spa_libs.get('core').if_prop('spinner_lib',obj,function(spinner_lib){
			spa_libs.get(spinner_lib).load().done(function(){spa_libs.get(spinner_lib).show(obj)})
		})
		
		
		var dvalidate= $.Deferred();
		var d1 = $.Deferred();
		var $form = model.has("form_selector")?$(model.get('form_selector')[0]):$form=$bound_element.parents('form').first();	

		// disable the Button
		spa_libs.get('core').if_prop('disable_selector',obj,function(disable_selector){
			$(disable_selector).prop('disabled', true);
		})
		
		
		if((validation_library=spa_libs.get('core').if_prop('validation_library',obj))!=null){
			spa_libs.get(validation_library).load().done(function(){
				var validation_promise=spa_libs.get(validation_library).validate($form,obj);
				validation_promise.done(function(status){
					if (status==true)
						dvalidate.resolve(status);
					else	
						dvalidate.reject(status);
				})

			});
		}
		else{
			dvalidate.resolve('valid');
		}
		
		dvalidate.fail(function(){
			spa_libs.get('core').if_prop('spinner_lib',obj,function(spinner_lib){
				spa_libs.get(spinner_lib).load().done(function(){spa_libs.get(spinner_lib).hide(obj)})
			})
			spa_libs.get('core').if_prop('disable_selector',obj,function(disable_selector){
				$(disable_selector).prop('disabled', false);
			})
		})
		
		dvalidate.done(function(){

			var post_url = ajaxurl+ "?action=app_ajax&ajax=true&rnd=" + randomString(5) + '&app=' + aw2_app;	
			
			var str=spa_libs.get('core').collect_data(model,obj.$bound_element);		
			
			// Collection data for tinymce
			$form.find('.tinymce').each(function(){
				var value=tinyMCE.get($(this).attr('id')).save();
			})
			
			str+= '&' + $.param($form.serializeArray());	
			// Collection data for summernote
			$form.find('.summernote').each(function(){
				var key=$(this).attr('id');
				var value=$(this).code();
				var params = { key:value };
				var encoded = jQuery.param( params );
				console.log($(this).code());
				console.log(encoded);
				
				str+= '&' + $(this).attr('id') + '=' + $(this).code();	
			})
			

			
			str+='&ajax=true&form_submit=true'
			
			var promise=spa_libs.get('core').post_to_server(post_url,str)
			promise.done(function(data){
				d1.resolve(data)
			})

			d1.done(
				function(data){
					reply='<div>' + data + '</div>';
					$reply=$(reply);
					spa_libs.get('core').parse_html($reply,reply);
					
					spa_libs.get('core').if_prop('spinner_lib',obj,function(spinner_lib){
						spa_libs.get(spinner_lib).load().done(function(){spa_libs.get(spinner_lib).hide(obj)})
					})
					spa_libs.get('core').if_prop('disable_selector',obj,function(disable_selector){
						$(disable_selector).prop('disabled', false);
					})
			});
		})
		
	}

	// Get ajax content
	applib.get_ajax=function(obj){
		// Show the spinner
		var model=obj.model;
		var $bound_element=obj.$bound_element
		//show spinner library
		if(model.has('spinner_lib')){
			lib=model.get('spinner_lib');	
			spa_libs.get(lib).load().done(function(){spa_libs.get(lib).show(obj)})
		}
		
		// Collect the data

		var d1 = $.Deferred();
		var str=spa_libs.get('core').collect_data(model,$bound_element);
		str+='&spa_call=true'
		var post_url = ajaxurl+ "?action=app_ajax&ajax=true&app=" + aw2_app	
		var promise=spa_libs.get('core').post_to_server(post_url,str)
		promise.done(function(data){
			d1.resolve(data)
		})

		d1.done(
			function(data){
				reply='<div>' + data + '</div>';
				$reply=$(reply);
				spa_libs.get('core').parse_html($reply,reply);
				$('.spa_main').fadeTo( 1000,1 )
				//hide spinner
				if(model.has('spinner_lib')){
					lib=model.get('spinner_lib');	
					spa_libs.get(lib).load().done(function(){spa_libs.get(lib).hide(obj)})
				}
		});
	}
	
	
	// Submit a form	
	applib.form_submit_iframe=function(obj) {
		var model=obj.model;
		$bound_element=obj.$bound_element
		//show spinner library
		spa_libs.get('core').if_prop('spinner_lib',obj,function(spinner_lib){
			spa_libs.get(spinner_lib).load().done(function(){spa_libs.get(spinner_lib).show(obj)})
		})
		
		var dvalidate= $.Deferred();
		var d1 = $.Deferred();
		var $form = model.has("form_selector")?$(model.get('form_selector')[0]):$form=$bound_element.parents('form').first();	

		// disable the Button
		spa_libs.get('core').if_prop('disable_selector',obj,function(disable_selector){
			$(disable_selector).prop('disabled', true);
		})
		
		
		if((validation_library=spa_libs.get('core').if_prop('validation_library',obj))!=null){
			spa_libs.get(validation_library).load().done(function(){
				var validation_promise=spa_libs.get(validation_library).validate($form,obj);
				validation_promise.done(function(status){
					if (status==true)
						dvalidate.resolve(status);
					else	
						dvalidate.reject(status);
				})

			});
		}
		else{
			dvalidate.resolve('valid');
		}
		
		dvalidate.fail(function(){
			spa_libs.get('core').if_prop('spinner_lib',obj,function(spinner_lib){
				spa_libs.get(spinner_lib).load().done(function(){spa_libs.get(spinner_lib).hide(obj)})
			})
			spa_libs.get('core').if_prop('disable_selector',obj,function(disable_selector){
				$(disable_selector).prop('disabled', false);
			})
		})
		
		dvalidate.done(function(){
			var post_url = ajaxurl+ "?action=app_ajax&ajax=true&app=" + aw2_app+"&form_submit=true&slug=" + model.get('slug')	
			
			$("#aw2_post_iframe").remove();
            var iframe = $('<iframe name="aw2_post_iframe" id="aw2_post_iframe" style="display: none"></iframe>');
            $("body").append(iframe);

            $form.attr("action", post_url);
            $form.attr("method", "post");

            $form.attr("encoding", "multipart/form-data");
            $form.attr("enctype", "multipart/form-data");

            $form.attr("target", "aw2_post_iframe");
            //form.attr("file", $('#userfile').val());
            $form.submit();

            $("#aw2_post_iframe").load(function () {
				reply='<div>' + this.contentWindow.document.body.innerHTML + '</div>';
				$reply=$(reply);
				$("#aw2_post_iframe").remove();
				spa_libs.get('core').parse_html($reply,reply);
				
				spa_libs.get('core').if_prop('spinner_lib',obj,function(spinner_lib){
					spa_libs.get(spinner_lib).load().done(function(){spa_libs.get(spinner_lib).hide(obj)})
				})
				spa_libs.get('core').if_prop('disable_selector',obj,function(disable_selector){
					$(disable_selector).prop('disabled', false);
				})

            });
			
			

		})
		
	}	
	
})(jQuery);