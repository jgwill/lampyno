randomString=function(len, charSet) {
	charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	var randomString = '';
	for (var i = 0; i < len; i++) {
		var randomPoz = Math.floor(Math.random() * charSet.length);
		randomString += charSet.substring(randomPoz,randomPoz+1);
	}
	return randomString;
} 

// Models for SPA. Every call to aw2_spa creates a model
var spa_model;
var spa_models_collection;
var spa_models;

// all the events which are supported	
var spa_events= {};
_.extend(spa_events, Backbone.Events);

//all the when which are supported
var spa_when= {};
_.extend(spa_when, Backbone.Events);

//js Library Collection
var spa_lib;
var spa_lib_collection;
var spa_libs;


(

function($) {

	$.fn.center = function() {
		this.css({
			'position': 'fixed',
			'left': '50%',
			'top': '50%'
		});
		this.css({
			'margin-left': -this.outerWidth() / 2 + 'px',
			'margin-top': -this.outerHeight() / 2 + 'px'
		});

		return this;
	}

	spa_model = Backbone.Model.extend({
		defaults:{"when":"immediate"}
	});
	spa_models_collection = Backbone.Collection.extend({model: spa_model});
	spa_models=new spa_models_collection();	



// All Whens
	spa_when.on("immediate",function(model){
	  var obj={};
	  obj.model=model;
	  spa_libs.get('core').run_function(obj);		
	})	
	

	spa_when.on("on_event",function(model){

		//if($('.spa_main').length==0)
		//	console.log('spa_main not found');
			
		bind_event=model.get('bind_event');
		bind_selector=model.get('bind_selector');
		var namespace=$(document).data('namespace');

		$('body').find(bind_selector).attr('data-model',model.id);
		bind_event=bind_event + '.' + namespace;
		$( "body" ).off( bind_event, bind_selector);
		
		$( "body" ).on( bind_event, bind_selector, {id:model.id},function(event) {
		var obj={};
		obj.model=spa_models.get(event.data.id);
		obj.event=event;
		obj.$bound_element=$(this);
		spa_libs.get('core').run_function(obj);		
		event.preventDefault();
	  });
  })

	
	// All Libraries
	spa_lib=Backbone.Model.extend({
		defaults: {'js':null,'css':null,'cdnjs':null,'cdncss':null,'loaded':false},
		load:function(obj){
			var d1 = $.Deferred();
			var mylib=this;
			if(mylib.has('loaded') && mylib.get('loaded')==true)
				d1.resolve();			
			else{
					var cssarray=new Array();
					if(mylib.has('css')){
						var newArray=mylib.get('css').split(',');
						cssarray = cssarray.concat(newArray);
					}
					if(mylib.has('cdncss')){
						var newArray=mylib.get('cdncss').split(',');
						$.each(newArray,function(index, value){
							newArray[index]=aw2_cdn + value;
						})					
						cssarray = cssarray.concat(newArray);
					}
					if(cssarray.length!=0){
						$.each(cssarray,function(index, value){
							var cssLink = $("<link rel='stylesheet' type='text/css' href='" + value +"'>");
							$("head").append(cssLink); 
						})
					}
					var jsarray=new Array();
					if(mylib.has('js')){
						var newArray=mylib.get('js').split(',');
						jsarray = jsarray.concat(newArray);
					}
					if(mylib.has('cdnjs')){
						var newArray=mylib.get('cdnjs').split(',');
						$.each(newArray,function(index, value){
							newArray[index]=aw2_cdn + value;
						})					
						jsarray = jsarray.concat(newArray);
					}
					if(jsarray.length!=0){
						$LAB.script(jsarray).wait(
							function(){
								mylib.loaded=true;
								d1.resolve();
							})
					}
					else{
						d1.resolve();
					}
			}
			return d1.promise();
		},
		set_defaults:function(){}
	});
	spa_lib_collection = Backbone.Collection.extend({model: spa_lib});
	spa_libs=new spa_lib_collection();	

	//core library
	
	var corelib=spa_libs.add({id: 'core'});
	
	// Private Functions ============================================

	//Load SPA
	corelib.load_spa=function(){
		var $pointer = $('.spa_main');
		$(document).data('namespace',randomString(8));
		$(document).data('spa_call',false);
		mainhtml=$pointer.clone().wrap('<p>').parent().html();
		$(document).data(document.location.href,mainhtml)
		spa_libs.get('core').parse_html($(document),null);
		//tracking google-analytics
		spa_libs.get('core').ga_auto_pageview()
		
	}

	// Run a function against any library

	corelib.ga_auto_pageview=function(){
		//tracking google-analytics
		//[aw2_spa spa_activity='google_analytics:pageview' set_defaults='true' title='document.title' page='window.location.pathname' ]
		if (window.ga_tracking_id != undefined) {
			var new_model=spa_models.add({id: randomString(8)});
			new_model.set('spa_activity','google_analytics:pageview');
			new_model.set('set_defaults','true');
			new_model.set('title',document.title);
			new_model.set('page',window.location.pathname);	
			spa_libs.get('core').run_function({model:new_model})
		}	
	}
	
	corelib.run_function=function(obj){
    //Step 0 Check if alert required
		var alert_promise = $.Deferred();

		var alert_msg=spa_libs.get('core').if_prop('alert',obj);
		if(alert_msg==null)
			alert_promise.resolve(true)
		else{
			spa_libs.get('bootbox').load().done(function(){
				bootbox.alert(alert_msg, function() {
					alert_promise.resolve(true);
				}); 
			})
		}
		
		var confirmation_promise = $.Deferred();
		var confirmation=spa_libs.get('core').if_prop('confirmation',obj);

		alert_promise.done(function(){
		//Step 0 Check if confirmation required
		if(confirmation==null)
			confirmation_promise.resolve(true)
		else{
			spa_libs.get('bootbox').load().done(function(){
				bootbox.confirm(confirmation, function(result) {
				if(result==true)
					confirmation_promise.resolve(true);
				else
					confirmation_promise.reject(true);
				}); 
			})
		}	
		})
		confirmation_promise.done(function(){
			
				
		
			//Step 1: If any libraries are mention will load the libraries. lib='a,b,c'
				var d1 = $.Deferred();
				var model=obj.model;	
				
				var cssarray=new Array();
				if(model.has('cdncss')){
					var newArray=model.get('cdncss').split(',');
					$.each(newArray,function(index, value){
						newArray[index]=aw2_cdn + value;
					})					
					cssarray = cssarray.concat(newArray);
				}
				if(cssarray.length!=0){
					$.each(cssarray,function(index, value){
						var cssLink = $("<link rel='stylesheet' type='text/css' href='" + value +"'>");
						$("head").append(cssLink); 
					})
				}
				
				if(model.has('lib')){
					var libarray=model.get('lib').split(',');
					var promisearray=[];
					for(var i = 0; i < libarray.length; i++){
						promisearray.push(spa_libs.get(libarray[i]).load());
					}
					$.when.apply($, promisearray).done(function(){
						//Step 2: If set_defaults=true then will fire the set_defaults command of all the dependancy libraries

						if(model.has('set_defaults') && (model.get('set_defaults')=="true" || model.get('set_defaults')==true))
						$.each(libarray,function(index,value){
							if(spa_libs.get(value).hasOwnProperty('set_defaults'))
								spa_libs.get(value).set_defaults(obj);
						})		
						d1.resolve()
					}); 
				}
				else if(model.has('cdnjs')){
					var jsarray=model.get('cdnjs').split(',');
					$.each(jsarray,function(index, value){
					jsarray[index]=aw2_cdn + value;
					})

					$LAB.script(jsarray).wait(
						function(){
						d1.resolve();
					})
				}
				else	
					d1.resolve()

				d1.done(function(){
					//Step 3: Will look for the spa_activity command eg fancybox:close and load the library. Will load fancybox
					  var spa_activity=	model.get('spa_activity');
					  var parts=spa_activity.split(':');
					  //console.log(spa_activity);
					  if(parts.length!=2)console.log(spa_activity + " is wrong");
					  var mylib=spa_libs.get(parts[0]);
					  if(mylib==undefined){
						console.log ('library ' + parts[0] + ' does not exist');
						return;
					}	
					  mylib.load().done(function(){
						//Step 4: If set_defaults=true then will fire the set_defaults command of fancybox
						if(model.has('set_defaults') && (model.get('set_defaults')=="true" || model.get('set_defaults')==true)){
							if(mylib.hasOwnProperty('set_defaults'))
								mylib.set_defaults(obj);
						}		
						
						// Step 4.5 Run Google Analytics
						var ga_category=spa_libs.get('core').if_prop('ga_category',obj);
						if(ga_category!=null){
							if (window.ga_tracking_id != undefined) {
								var new_model=spa_models.add({id: randomString(8)});
								new_model.set('spa_activity','google_analytics:event');
								new_model.set('category',ga_category);
								new_model.set('action',spa_libs.get('core').if_prop('ga_action',obj));
								new_model.set('label',spa_libs.get('core').if_prop('ga_label',obj));
								new_model.set('value',spa_libs.get('core').if_prop('ga_value',obj));
								spa_libs.get('core').run_function({model:new_model})
							}	
						}
						
						//Step 5: Will fire the command mentioned. Will fire fancybox.close() . If you just want to load then say fancybox:load . If you just want to set defaults say fancybox:set_defaults
						if(mylib.hasOwnProperty(parts[1]))
							mylib[parts[1]](obj);	
						else{
							console.log ('library ' + parts[0] + ' does not have function ' + parts[1]);
							return;
						}				

					})
					
				})
		})	
			
	}
	
	corelib.post_to_server=function(url,data){
	
		var d1 = $.Deferred();
		var post = $.ajax({
			url: url,
			data: data,
			type: "POST"
		});

		post.done(function(data){
			d1.resolve(data);
		});

		post.fail(function(){
			alert("Unable to load Page");
		});
		return d1.promise(data);
	}	

	corelib.parse_html = function ($block,content) {
		//Loop through all the scripts
		$block.find("script[type='text/spa']").each(
			function () {
				// Create the model for the action
				if ($(this).attr('model')){
					var myaction = spa_models.get($(this).attr('model'));
				}
				else{
					var myaction=spa_models.add({id: randomString(8)});
				}

				$.each(this.attributes, function() {
					if(this.specified) {
					name = this.name.replace('data-','');
					myaction.set(name,this.value);
					}
				});
				if(content)myaction.set('content',content);
				myaction.set('script_text',$(this).text());
				myaction.set('script_html',$(this).html());
				spa_when.trigger(myaction.get('when'),myaction);	
			}
		)

		/* $block.find("[data-spa_activity]").each(
			function () {
				var myaction=spa_models.add({id: randomString(8)});
				myaction.set('spa_activity',$(this).data('spa_activity'));
				myaction.set('when','on_event');
				if(!$(this).data('bind_event'))bind_event='click';
				else
				bind_event=$(this).data('bind_event')
				myaction.set('bind_event',bind_event);
				$(this).attr('data-model',myaction.id);
				myaction.set('bind_selector',"[data-model='" + myaction.id + "']");
				spa_when.trigger(myaction.get('when'),myaction);	
			}
		) */
		
		// to bind 	data-get_spa_uri directly
		var myaction=spa_models.add({id: randomString(8)});
		myaction.set('spa_activity','core:get_spa_uri');
		myaction.set('when','on_event');
		myaction.set('bind_event','click');
		myaction.set('spinner_lib','spinkit');
		myaction.set('bind_selector',"[data-get_spa_uri]");
		spa_when.trigger(myaction.get('when'),myaction);	

		// to run any libraries which have load_if_class
		spa_libs.each(function(mymodel){
			if(mymodel.has('load_if_class')){
			if($('.' + mymodel.get('load_if_class')).length>0){
				var new_model=spa_models.add({id: randomString(8)});
				new_model.set('spa_activity',mymodel.id + ':set_defaults');
				spa_libs.get('core').run_function({model:new_model})
			}
		  }		
		})	

		// to run any libraries which have load_if_data
		spa_libs.each(function(mymodel){
		  if(mymodel.has('load_if_data')){
			if($('[' + mymodel.get('load_if_data') + ']').length>0){
				var new_model=spa_models.add({id: randomString(8)});
				new_model.set('spa_activity',mymodel.id + ':set_defaults');
				spa_libs.get('core').run_function({model:new_model})
			}

		  }		
		})	
	}
	
	corelib.collect_data=function(model,$bound_element){
		var obj={};	
		
		// Collect all the attributes of the model
		_.each(model.attributes, function(val, key) {
			obj[key]=val
		});
		
		// Collect all group data
		var group=null;
		if(model.has('group'))group=model.get('group');
		if($bound_element && $bound_element!==null && $bound_element.attr('data-group'))
			group=$bound_element.attr('data-group');

		if(group){
			$('body').find('[data-group="' + group + '"]').each(
				function(){
					if($(this).attr("data-val"))
						obj[$(this).attr('id')]=$(this).attr('data-val');
					else
						obj[$(this).attr('id')]=$(this).val();


					if($(this).attr("data-active_val") && $(this).hasClass('active')){
						if($(this).attr('name').indexOf("[]")>-1){
							fname=$(this).attr('name').replace("[]", "");
							if(!(obj[fname] instanceof Array))
								obj[fname]=new Array();
							obj[fname].push($(this).data('active_val'));
						}
						else
							obj[$(this).attr('name')]=$(this).data('active_val');

					}
				}
			)			
		}

			
		// Collect any form data
		if(model.formData){
			var formdata=$.param(model.formData);
			model.formData=null;
		}
		
		// collect any data of bound_element
		if($bound_element && $bound_element!==null){
			$.each($bound_element.data(), function(name, value) {
			if(typeof value === 'object'){}
			else
				obj[name]=value;
			})

			if($bound_element.attr('id') && $bound_element.val()!=null){
					obj[$bound_element.attr('id')]= $bound_element.val();
			}
		}
			
		var str = $.param(obj);
		return str;	
	}

	corelib.if_prop=function(prop,obj,func) {
		var value=null;
		if(obj.hasOwnProperty('$bound_element')){
			if(obj.$bound_element.data(prop))
				value= obj.$bound_element.data(prop);
		}
		if(obj.hasOwnProperty('model')){
			if(obj.model.has(prop))
				value= obj.model.get(prop);
		}

		if(!func)return value;	
		if(value)
		return func(value);		
	}

	// Public functions	===============================================

	// Register a new library
	corelib.new_lib=function(obj){
		if(obj.hasOwnProperty('model')){
			libobj=obj.model;
			libobj.set_defaults=new Function('$',obj.model.get('script_text'))
			}
		else		
			libobj=obj;
			
		var templib=spa_libs.add({id: libobj.lib});
		templib.set('css',libobj.hasOwnProperty('css') ? libobj.css : null)
		templib.set('cdncss',libobj.hasOwnProperty('cdncss') ? libobj.cdncss : null)
		templib.set('cdnjs',libobj.hasOwnProperty('cdnjs') ? libobj.cdnjs : null)
		templib.set('js',libobj.hasOwnProperty('js') ? libobj.js : null)
		templib.set('load_if_class',libobj.hasOwnProperty('load_if_class') ? libobj.load_if_class : null)
		templib.set('load_if_data',libobj.hasOwnProperty('load_if_data') ? libobj.load_if_data : null)
		templib.set_defaults=libobj.hasOwnProperty('set_defaults') ? libobj.set_defaults : function(){};
		return templib;
	}
	
	corelib.js_def=function(obj){
		var model=obj.model;		
		var script_obj=spa_libs.get('core').get_param_as_obj(model);
		script_obj.lib=model.get('id');
		spa_libs.get('core').new_lib(script_obj);
	}

	corelib.get_param_as_obj=function(model){
		var func=new Function("var x=" + model.get('script_text') + ';return x');
		return func();
	}
	

	// Run a script after loading
	corelib.run_script=function(obj){
		var model=obj.model;
		if(model.has('script_text')){
			var newfunc=new Function('$','obj',model.get('script_text'))
			newfunc(jQuery,obj);
		}

	}

	// Run a script after loading
	corelib.reload=function(obj){
		window.location.reload();
	}
	
	// Run a script after loading
	corelib.timer=function(obj){
		var model=obj.model;
		var delay=model.get('delay');
		if(model.has('script_text')){
			var newfunc=new Function('$','obj',model.get('script_text'))
			window.setInterval(function(){
				newfunc(jQuery,obj);
			}, delay*1000);
			
		}

	}
	
	// Insert HTML into DOM
	corelib.insert_html=function(obj){
		var model=obj.model;
		var $content = model.has('content')?$(model.get('content')):$('body');	
		var htmlcontent = model.has("html_selector")?$content.find(model.get("html_selector")).html():$content.html()	
		$target=$(model.get("target_selector"))
		model.get('append')=='true'?$target.append(htmlcontent):$target.html(htmlcontent)	
	};

	// Remove existing dom object and place dom object in the same place
	corelib.replace_html=function(obj){
		var model=obj.model;
		var html_selector=model.get('html_selector')
		$(html_selector).after('<div id=temp_placeholder></div>')
		$('#temp_placeholder').css('height',$( window ).height());
		$(html_selector).remove();
		var $pointer = $(model.get('content')).find(html_selector);
		mainhtml=$pointer.clone().wrap('<p>').parent().html();
		$('#temp_placeholder').after(mainhtml);
		$('#temp_placeholder').remove();
	}

	// Get a URI from the server and replace spa_main with new content
	corelib.get_spa_uri=function(obj){

		var model=obj.model;
		var $bound_element=obj.$bound_element;
		var namespace=$(document).data('namespace');
		$( "body" ).off( '.' + namespace);
		$(document).data('namespace', randomString(8));
			

		var d1 = $.Deferred();
		//show spinner library
		if(model.has('spinner_lib')){
			lib=model.get('spinner_lib');	
			spa_libs.get(lib).load().done(function(){spa_libs.get(lib).show(obj)})
		}

		//find the href
		var post_url=$bound_element && $bound_element!==null && $bound_element.attr('href')?$bound_element.attr('href'):""
		post_url = model.has('uri')?model.get('uri'):post_url;	
		post_url=$bound_element && $bound_element!==null && $bound_element.data('uri')?$bound_element.data('uri'):post_url;

		if(model.has('refresh')){
			post_url=document.location.href;
		}
		
		var cache = model.has('cache')?model.get('cache'):'yes';	
		cache=$bound_element && $bound_element!==null && $bound_element.data('cache')?$bound_element.data('cache'):cache;	
		//check if it is there in cache
		if(cache!='no' && $(document).data(post_url)){
			d1.resolve($(document).data(post_url));
		}
		else{
				
			var str=spa_libs.get('core').collect_data(model,$bound_element);		
			str+='&spa_call=true&spa_uri=true';
			
			var promise=spa_libs.get('core').post_to_server(post_url,str)
			promise.done(function(data){
				d1.resolve(data)
			})
		}

		d1.done(
			function(data){
				$(document).data(post_url,data)
				$(document).data('spa_call',true);
				reply='<div>' + data + '</div>';
				$reply=$(reply);
				var new_model=spa_models.add({id: randomString(8)});
				new_model.set('html_selector','.spa_main');
				new_model.set('content',reply);
				new_model.set('url',post_url);
				
				spa_libs.get('core').set_history_url({model:new_model})
				spa_libs.get('core').replace_html({model:new_model})

				
				//tracking google-analytics
				spa_libs.get('core').ga_auto_pageview();
				
				$('.spa_main').fadeTo( 1000,1 )

				//hide spinner
				if(model.has('spinner_lib')){
					lib=model.get('spinner_lib');	
					spa_libs.get(lib).load().done(function(){spa_libs.get(lib).hide(obj)})
				}

				
				spa_libs.get('core').parse_html($reply,reply);

				scroll='.spa_main';
				if(model.has('scrollto'))scroll=model.get('scrollto');
				
				$('html, body').animate({
					scrollTop: $(scroll).offset().top
				}, 1000);

			});

	};
	
	// Get a URI from the server and replace spa_main with new content
	corelib.get_history_uri=function(obj){
		var model=obj.model;
		var $bound_element=obj.$bound_element;
		var d1 = $.Deferred();
		//show spinner library
		if(model.has('spinner_lib')){
			lib=model.get('spinner_lib');	
			spa_libs.get(lib).load().done(function(){spa_libs.get(lib).show(obj)})
		}

		//find the href
		var post_url=$bound_element && $bound_element!==null && $bound_element.attr('href')?$bound_element.attr('href'):""
		post_url = model.has('uri')?model.get('uri'):post_url;	
		post_url=$bound_element && $bound_element!==null && $bound_element.data('uri')?$bound_element.data('uri'):post_url;
		
		var cache = model.has('cache')?model.get('cache'):'yes';	
		cache=$bound_element && $bound_element!==null && $bound_element.data('cache')?$bound_element.data('cache'):cache;	
		//check if it is there in cache
		if(cache!='no' && $(document).data(post_url)){
			d1.resolve($(document).data(post_url));
		}
		else{
			var str=spa_libs.get('core').collect_data(model,$bound_element);		
			str+='&spa_call=true&spa_uri=true';
			var post_url = post_url	
			
			var promise=spa_libs.get('core').post_to_server(post_url,str)
			promise.done(function(data){
				d1.resolve(data)
			})
		}

		d1.done(
			function(data){
				$(document).data(post_url,data)
				reply='<div>' + data + '</div>';
				$reply=$(reply);
				var new_model=spa_models.add({id: randomString(8)});
				new_model.set('html_selector','.spa_main');
				new_model.set('content',reply);
				spa_libs.get('core').replace_html({model:new_model})

				$('.spa_main').fadeTo( 1000,1);
				//hide spinner
				if(model.has('spinner_lib')){
					lib=model.get('spinner_lib');	
					spa_libs.get(lib).load().done(function(){spa_libs.get(lib).hide(obj)})
				}
				spa_libs.get('core').parse_html($reply,reply);
				$('html, body').animate({
					scrollTop: $('.spa_main').offset().top
				}, 1000);

			});

	};

	// Get ajax content using URI 
	corelib.get_ajax_uri=function(obj){
		var d1 = $.Deferred();
		var model=obj.model;
		var $bound_element=obj.$bound_element
		//show spinner library
		if(model.has('spinner_lib')){
			lib=model.get('spinner_lib');	
			spa_libs.get(lib).load().done(function(){spa_libs.get(lib).show(obj)})
		}

		//find the href
		var post_url=$bound_element && $bound_element!==null && $bound_element.attr('href')?$bound_element.attr('href'):""
		post_url = model.has('uri')?model.get('uri'):post_url;	
		post_url=$bound_element && $bound_element!==null && $bound_element.data('uri')?$bound_element.data('uri'):post_url;
		//check if it is there in cache
		var cache = model.has('cache')?model.get('cache'):'yes';	
		cache=$bound_element && $bound_element!==null && $bound_element.data('cache')?$bound_element.data('cache'):cache;	
		
		if(cache!='no' && $(document).data('ajax_' + post_url)){
			d1.resolve($(document).data('ajax_' + post_url));
		}
		else{
			var str=spa_libs.get('core').collect_data(model,$bound_element);		
			str+='&spa_call=true&ajax=true'
			var promise=spa_libs.get('core').post_to_server(post_url,str)
			promise.done(function(data){
				d1.resolve(data)
			})
		}

		d1.done(
			function(data){
				$(document).data('ajax_' + post_url,data)
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
	
	// Get ajax content
	corelib.get_ajax=function(obj){
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
		var post_url = ajaxurl+ "?action=run_awesome2_block&ajax=true"	
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

	corelib.set_document_title=function(obj){
		document.title=obj.model.get("script_text");
	};

	corelib.set_spa_title=function(obj){
		if($(document).data('spa_call')==true)
			document.title=obj.model.get("script_text");
	};
	
	corelib.set_history_url=function(obj){
			var model=obj.model;
			var url=obj.model.get("url");
			if(url.search("{")>=0){
				var spa_page_model = $(".spa_main").data('spa_page_model');
			// Collect all the attributes of the model
			_.each(spa_page_model.attributes, function(val, key) {
				url=url.replace("{" + key + "}", val);
			});
			}
			history.pushState({}, "new", url);

			$(window).off('popstate');
			$(window).on("popstate",function(event) {
				var obj={};
				obj.model=spa_models.add({id: randomString(8)});
				obj.model.set('uri',document.location.href);
				obj.model.set('spinner_lib','spinkit');
				spa_libs.get('core').get_history_uri(obj);
				});
	};
	
	
	// Submit a form	
	corelib.form_submit=function(obj) {
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

			var post_url = ajaxurl+ "?action=run_awesome2_block&ajax=true&rnd=" + randomString(5);	
			
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
			

			
			str+='&spa_call=true&ajax=true&form_submit=true'
			
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




	// Submit a form	
	corelib.form_submit_iframe=function(obj) {
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
			var post_url = ajaxurl+ "?action=run_awesome2_block&ajax=true&spa_call=true&form_submit=true&slug=" + model.get('slug')	
			
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


	
	corelib.set_spa_data=function(obj) {
		var spa_page_model;
		var spa_page_default_model;
		
		if ($(".spa_main").data('spa_page_model')) {
			spa_page_model = $(".spa_main").data('spa_page_model');
			spa_page_default_model = $(".spa_main").data('spa_page_default_model');
		}
		else{
			spa_page_model = new Backbone.Model({});
			spa_page_default_model = new Backbone.Model({});
		}
		var model=obj.model;
		var key=model.get('key');
		var value=model.get('value');
		spa_page_model.set(key,value);
		var default_value=model.get('default');
		if(default_value!=undefined)
			spa_page_default_model.set(key,default_value);
			
		if(value==undefined || value==null || value==''){
			spa_page_model.set(key,spa_page_default_model.get(key));
		}		
		
		$(".spa_main").data('spa_page_model',spa_page_model) ;
		$(".spa_main").data('spa_page_default_model',spa_page_default_model);
	}
	

	corelib.get_spa_data=function(obj) {
		var spa_page_model;
		var spa_page_default_model;
		
		if ($(".spa_main").data('spa_page_model')) {
			spa_page_model = $(".spa_main").data('spa_page_model');
			spa_page_default_model = $(".spa_main").data('spa_page_default_model');
		}
		else{
			return '';
		}
		var model=obj.model;
		var key=model.get('key');
		var default_value=model.get('default');
		var value=spa_page_model.get('key');
		if(value==undefined || value==null || value=='')
			value=spa_page_default_model.get(key);
			
		if(value==undefined || value==null || value=='')
			value=default_value;
		
		return value;
	}	
	
//Cookie Functions
	corelib.read_cookie=function(obj) {
		var model=obj.model;
		var cname=model.get('key');
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		}
		return "";
	}

	corelib.create_cookie=function(obj) {
		var model=obj.model;
		var name=model.get('key');
		var value=model.get('value');
		var days=parseInt(model.get('days'));
		var hour=parseInt(model.get('hour'));
		var date = new Date();
		date.setTime(date.getTime()+(-1*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
		document.cookie = name+"="+value+expires+"; path=/";
		
		expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			expires = "; expires="+date.toGMTString();
		}
		if (hour) {
			var date = new Date();
			date.setTime(date.getTime()+(60*60*1000));
			expires = "; expires="+date.toGMTString();
		}
		
		document.cookie = name+"="+value+expires+"; path=/";
	}

	
// Console Functions	
	
	corelib.console_log=function(obj){
		console.log(obj.model.get("script_text"));
	}

	corelib.console_error=function(obj){
		console.error(obj.model.get("script_text"));
	}
	
	corelib.console_start=function(obj){
		console.groupCollapsed(obj.model.get('title'))
	}
	
	corelib.console_end=function(obj){
		console.groupEnd();
	}	

	corelib.editor=function(){
		$modules=$("script[type='text/module']");
		
		if($modules.length==0)return;
		
		$('body').append('<div id="editor" class="bottomfix" style="position: fixed;bottom: 0px;right: 20px;z-index: 16000010; background-color: #263238; padding: 10px;"><ul id="editor_modules" style="display:none"></ul></div>');
		
		$('#editor').append('<button style="z-index:5000" class="aw2-hierarchy btn btn-error btn-xs">Editor</button>');

		if (typeof aw2_app_modules !== 'undefined') {
			$('#editor').append('<a href="' + homeurl + '/wp-admin/edit.php?post_type=' + aw2_app_modules + '" target="_blank">List</a>');
		}
		if (typeof aw2_app !== 'undefined' && aw2_app !== '') {
			$('#editor').append('&nbsp;&nbsp;&nbsp;<a href="' + homeurl + '/' + aw2_app + '/z" target="_blank">z</a>');
		}
		
		
		$('.aw2-hierarchy').click(function(){
			$('#editor_modules').toggle("slow");
			console.log($(this));
			if($(this).html() == 'Editor')
				$(this).html('Close');
			else
				$(this).html('Editor');
		});
		
		$modules.each(function(){
			//$('#editor_modules').append('<li><a target=_blank href="' + homeurl + '/wp-admin/post.php?post=' +  $(this).attr('data-module_id') + '&action=edit" class="btn btn-info btn-xs" >Module:' +  $(this).attr('data-module_title') + ' (' +  $(this).attr('data-module_slug') + ')</a></li>')
			$('#editor_modules').append('<li><a target=_blank href="' + homeurl + '/wp-admin/post.php?post=' +  $(this).attr('data-module_id') + '&action=edit" class="btn btn-xs" data-module_slug= '+ $(this).attr('data-module_slug') +' >Module:' +  $(this).attr('data-module_title') + '</a></li>')
		})
		
		$('#editor_modules li a').hover(
			function() {
				$('body').find('[data-module-slug="' + $( this ).data( 'module_slug' ) +'"]').append('<span class="module-hover"></span>');	
			}, function() {
				$('body').find('.module-hover').remove();	
			}
		);
	}
})(jQuery);