//google analytics
//collect data
//form submit

//spa.common.run_module why it does not have the original object
//check that when run_module set and set_selector are honoured
//hmmm spa.common.load_and_run(libname, function(){spa.loader.x(o)})
//sort out set_context
//order of loading the prerequisites

//all ajax calls -> if the return is an error then handle. so server must send error and client must show alert


var spa={};
spa.route_stack=new Array();
spa.pages=new Array();


jQuery( document ).ready(function( $ ) {
	spa.app.start(null);
 });

 
 //SPA Library

//Jquery extensions
(
 function($) {
	$.fn.is_axn = function() {  
		return $(this).is("[axn]")
	};

 $.ajaxSetup({
	  cache: true
	});

})(jQuery); 
 
//Default Settings 
(
 function($) {
	 
spa.settings={};
spa.settings.cdn='https://cdn.getawesomestudio.com/lib/';
})(jQuery); 

// Common Functions
(
 function($) {
spa.common={};

// Run a block of Actions
spa.common.parse_axns=function(nodes,parent_o){
	var d = $.Deferred();
	var axns=$();

	function allNodes(element) {
		for (var child= element.firstChild; child!==null; child= child.nextSibling) {
			if (child.nodeType===1){
				if(child.hasAttribute("axn"))
					axns=axns.add($(child))
				else	
					allNodes(child);
			}
		}
	}
	
	nodes.each(function(){
		if($(this).is_axn())
			axns=axns.add($(this))
		else{
			allNodes(this)
		}
	})
	
	//Run all the axns linearly
	var promises=[];

		
	axns.each(function(){
		var o={};
		o.el=$(this);
		o.block=parent_o.block;
		promises.push(function(){
			return spa.common.run_axn(o);
		})
	})
	
	//when all commands are executed
	$.when(spa.common.series_promises(promises)).then(
		function(){d.resolve()},
		function(){d.reject()}
	)
	
	return d.promise(); 	
}

//Run a Single Axn
spa.common.run_axn=function(o){

	var d = $.Deferred();
	var el=o.el;

	//Step 1: Resolve any curly braces in attributes
	o.tagName=el.prop("tagName").toLowerCase() ;
	
	spa.common.copy_attributes(el[0],o);
	spa.common.parse_attributes(o);
	
	if(el.attr('axn')=='')el.attr('axn','core.default');
	
	o.axn=el.attr('axn');	
	var parts=o.axn.split('.');
	if(parts.length!=2){
		console.error(o.axn + " is wrong");
		return false;
	}
	
	o.lib=parts[0];	
	o.command=parts[1];	

	spa.common.copy_attributes(el[0],o);
	//if(o.block.trigger)spa.common.copy_attributes(o.block.trigger[0],o);
	
	var status=false;
	//checks self handled or general checks
	if(spa[o.lib] && spa[o.lib][o.command + '_check']){
		status=spa[o.lib][o.command + '_check'](o);
	}
	else{
		status=spa.common.check_conditions(o);
	}
		
	if(!status){
		return d.reject()
	}

	o.axn=el.attr('axn');	
	var parts=o.axn.split('.');
	if(parts.length!=2){
		console.error(o.axn + " is wrong");
		return false;
	}
	
	o.lib=parts[0];	
	o.command=parts[1];	
	
	o.tagName=el.prop("tagName").toLowerCase() ;
	
	var promises=[];
	
	promises.push(function(){return spa.common.bind_el(o)})
	promises.push(function(){return spa.common.pre_run_command(o)})	
	promises.push(function(){return spa.common.run_command(o)});
	promises.push(function(){return spa.common.post_run_command(o)})	

	// Run all the Promises Linearly
	$.when(spa.common.linear_promises(promises)).then(
		function(){d.resolve()},
		function(){d.reject()}
	)	

	return d.promise();		
}

spa.common.check_conditions=function(o){
	var result=true;
	$.each(spa.common.conditions, function( index, value ) {
	  var ret_val=value(o);
	  if(ret_val===false){
		  result=false;
		  return false
	  }
	});	
	
	return result;
}

spa.common.bind_el=function(o){
/*
 block.trigger				The element which was bound
 block.target 				The innermost element where the event happened
 block.source					The binder element
 block.delegateTarget The element to which the binding was delegated
 
 $(this) -> The element which was bound - block.trigger
 $(event.target) -> The actual element where the event happened - 
$(event.delegateTarget)
 o.el -block.source
 
 <article role=report>
	<div id=d1 class=divx><button id=b1 class='btx'>Click 1</button></div>
	<div id=d2 class=divx><button id=b2 class='btx'>Click 2</button></div>
	<div id=d3 class=divx><button id=b3 class='btx'>Click 3</button></div>

	
	<div axn='me.update' bind=click bind_control='parents.report' bind_children='.divx' get='it worked'>old</div>
</article>
 
When #b2 is clicked
block.trigger					#divx
block.target 					#b2
block.source					template element
block.delegateTarget 	article element


*/
	var d = $.Deferred();
	if(!o.bind){
		return d.resolve();
	}

	var source=o.el;
	var parent=source;
	var delegateTarget=null;
	
	if(o.bind_control)
		parent=spa.common.get(o,o.bind_control);
	if(o.bind_selector)
		parent=$(o.bind_selector);
		 	

	if(!o.bind_namespace)
		source.attr('bind_namespace','ns' + Math.floor((Math.random() * 10000)));
	
	var bind_namespace=source.attr('bind_namespace');
	var bind=o.bind + '.spa' + '.' + bind_namespace;
	
	function post_event(event){
			event.preventDefault();
			var o={};
			o.block={};
			o.block.trigger=$(this);
			o.block.target=$(event.target);
			o.block.source=event.data.o.el;
			o.block.delegate_target=$(event.delegateTarget);
			o.block.event=event;
			o.el=event.data.o.el;
			spa.common.parse_double_curly(o)	
			spa.common.copy_attributes(o.el[0],o.block);
			spa.common.copy_attributes(this,o.block);
			spa.common.run_bound_axn(o);			
	}
	
	if(o.bind_children){
		parent.off(bind_namespace);
		parent.on(bind,o.bind_children,{o: o},post_event)
	}
	else{
		parent.off(bind_namespace);
		parent.on(bind,{o: o},post_event)		
	}	
	
	return d.reject();
}

spa.common.pre_run_command=function(o){
	var d = $.Deferred();
	var promises=[];

	//Step Confirmation
	if(o.confirmation){
		promises.push(function(){
			return spa.common.run_command(o,'notifications','confirmation');
		})
	}
	
	//Step Alert
	if(o.alert){
		promises.push(function(){
			return spa.common.run_command(o,'notifications','alert')
		})
	}
	
	//Step Prerequisites 
	promises.push(function(){
		return spa.common.prerequisites.load(o)
	});
	
	// Run all the Promises Linearly
	$.when(spa.common.linear_promises(promises)).then(
		function(){d.resolve()},
		function(){d.reject()}
	)	

	return d.promise();		
}

spa.common.run_command=function(o,lib,command){
	var d = $.Deferred();
	if(!lib)lib=o.lib;
	if(!command)command=o.command;
	console.log('library:' + lib + ' ' + 'command:' + command);


	//Load the library
	var next_step=function(){
		$.when(spa.common.load_lib(lib)).then(function(){
			if(!spa[lib][command]){
				console.error(command + " does not exist in library: " + lib);
				return d.reject();
			}
			else{
				// If the command is a function
				if($.isFunction(spa[lib][command])){
					$.when(spa[lib][command](o)).then(
						function(){d.resolve()},
						function(){d.reject()}
					)
				}
				else{
					//if the command is a html fragment
					var el=$(spa[lib][o.func]);
					$.when(spa.common.parse_axns(el,o)).then(
						function(){d.resolve()},
						function(){d.reject()}
					)
				}
			
			}
		
		
		})	
	}

	
	if(!spa[lib]){
		//check if it exists on the server
		$.when(spa.common.get_cdn_lib(o,lib)).then(
			function(){next_step()},
			function(){console.error(lib + " library does not exist ");d.reject()}		
		
		)
	}
	else{
		next_step();
	}

	return d.promise();		
}

spa.common.post_run_command=function(o){
	var d = $.Deferred();
	var promises=[];

	//set_context
	if(o.set_context)
		o.block.context=spa.common.get(o,o.set_context);
	
	if(o.analytics){
		promises.push(function(){
			return spa.common.run_command(o,{
				lib:'analytics',
				command:'run'
			});
		})
	}
	
	if(o.notification){
		promises.push(function(){
			return spa.common.run_command(o,'notifications','acknowledgement');
		})
	}
	
	// Run all the Promises Linearly
	$.when(spa.common.linear_promises(promises)).then(
		function(){d.resolve()},
		function(){d.reject()}
	)	

	return d.promise();		
	
}

//merge with run axn
spa.common.run_bound_axn=function(o){
	var d = $.Deferred();
	spa.common.run_command(null,'loader','show');	
	var el=o.el;

	o.axn=el.attr('axn');	
	var parts=o.axn.split('.');	
	o.lib=parts[0];	
	o.command=parts[1];	
	o.tagName=el.prop("tagName").toLowerCase() ;

	spa.common.copy_attributes(el[0],o);

	
	var promises=[];
	
	promises.push(function(){return spa.common.pre_run_command(o)})	
	promises.push(function(){return spa.common.run_command(o)});
	promises.push(function(){return spa.common.post_run_command(o)})	
	
	// Run all the Promises Linearly
	$.when(spa.common.linear_promises(promises)).then(
		function(){spa.common.run_command(null,'loader','hide');d.resolve()},
		function(){spa.common.run_command(null,'loader','hide');d.reject()}
	)	

	return d.promise();		
}


// Load a Library Before running a command	 
spa.common.load_lib=function(lib){
	
	if(!spa[lib])return true;
	var lib=spa[lib];
	if(lib.loaded==true)return true;
	var d = $.Deferred();
	var promises=[];

	
	$.when(spa.common.prerequisites.load(lib.prerequisites)).then(function(){
		if(!lib.init){
			d.resolve();
		}
		else
		$.when(lib.init(lib)).then(function(){
			lib.loaded=true;
			d.resolve();
		})

	})
	
	return d.promise();
}


// output functions
spa.common.direct_output=function(o){
	if(o.no_output)return;
	if(o.set_alert)
		alert(o.value);	
	
	spa.common.set(o);	
		
}	

//get and set functions
spa.common.set=function(o,extra){
	
	if(!extra)extra={};
	
	if(extra.set)
		o.pieces=extra.set.split(".");
	else	
		o.pieces=o.set.split(".");
	
	if(extra.value)
		o.value=extra.value;

	if(extra.selector){
		o.selector=extra.selector;
		spa.common.set_helper.control(o);
		return;
	}

	
	switch (o.pieces[0]) {
		
		case 'body':
			o.pieces.shift();
			o.selector=$('body');
			spa.common.set_helper.control(o)
			break;			
		case 'main':
			o.pieces.shift();
			o.selector=$('main');
			spa.common.set_helper.control(o)
			break;	
		case 'me':
			o.pieces.shift();
			o.selector=o.el
			spa.common.set_helper.control(o)
			break;		
		case 'parents' || 'controls' || 'header' || 'footer' || 'nav':
			o.selector=o.el
			spa.common.set_helper.control(o)
			break;	
		case 'data' || 'content':
			o.selector=o.el
			spa.common.set_helper.control(o)
			break;				
		case 'page':
			o.selector=spa.page_control;
			spa.common.set_helper.control(o)
			break;	

		case 'trigger':
			o.pieces.shift();
			o.selector=o.block.trigger
			spa.common.set_helper.control(o)
			break;

		case 'source':
			o.pieces.shift();
			o.selector=o.block.source
			spa.common.set_helper.control(o)
			break;
			
		case 'selector':
			o.pieces.shift();
			o.selector=$(o.set_selector)
			spa.common.set_helper.control(o)
			break;
			
		case 'spa':
			o.pieces.shift();
			o.ptr=spa;
			spa.common.set_helper.object(o)
			break;
			
		case 'settings':
			o.ptr=spa;
			spa.common.set_helper.object(o)
			break;
		case 'block':
			o.pieces.shift();
			o.ptr=o.block;
			spa.common.set_helper.object(o)
			break;

		case 'o':
			o.pieces.shift();
			o.ptr=o;
			spa.common.set_helper.object(o)
			break;			
		
		default:	
			o.ptr=spa;
			spa.common.set_helper.object(o)
			break;
		
	}
	
}

spa.common.get=function(o,get){
	if(get)
		o.pieces=get.split(".");
	else	
		o.pieces=o.get.split(".");
	
	o.value='';
	
	if(o.get_selector)
		o.selector=o.get_selector;	
	spa.common.get_helper.start(o);

	while(o.pieces.length>0) {
		if (o.value=='_error' && o.pieces['0']!='exists'){
			o.pieces=[];
		}
		else if(o.value instanceof jQuery){
			spa.common.get_helper.control(o);
		}
		else if(spa.common.isObject(o.value)){
			spa.common.get_helper.object(o);
		}	
		else if($.isArray(o.value)){
			spa.common.get_helper.array(o);
		}
		else if(typeof o.value =='string' || typeof o.value =='boolean' || typeof o.value =='number'){
			spa.common.get_helper.string(o);
		}
		else{
			o.value==='_error'			
			o.pieces=[];
		}
		
	}
	if(o.value==='_error') 
		o.value='';

	return o.value;
}


//Utility Functions to Run Parallel and Linear Promises
spa.common.parallel_promises=function(arr){
	var d=$.Deferred();
	var promisearray=[];
	$.each(arr,function(index, value){
		promisearray.push(value());
	})
	
	$.when.apply($, promisearray).done(function(){
		d.resolve();	
	})
	return 	d.promise();
}

spa.common.linear_promises=function(arr){
    var d = $.Deferred();
	
	function one_promise(){
		if(arr.length===0)
			d.resolve();
		else{

			$.when(arr[0]()).then(
			function(){
				arr.shift();
				one_promise();
			},
			function(){
				d.reject();	
			});
			
		}
	}	
	
	one_promise();
	return d.promise();
}	

spa.common.series_promises=function(arr){
    var d = $.Deferred();
	
	function one_promise(){
		if(arr.length===0)
			d.resolve();
		else{

			$.when(arr[0]()).then(
			function(){
				arr.shift();
				one_promise();
			},
			function(){
				arr.shift();
				one_promise();
			});
			
		}
	}	
	
	one_promise();
	return d.promise();
}	


spa.common.parse_attributes=function(o){

	var re=/{(.+?)}/g;

	var replacer=function(match, p1) {
		if(p1.indexOf("{")!== - 1)
			return match;
		else
			return spa.common.get(o,p1)
	}

	$.each(o.el[0].attributes, function() {
		if(this.specified) {
			var attr=this.value;
			o.el.attr(this.name,attr.replace(re, replacer));
		}
	});
	
	if(o.el.children().length==0 && o.el.text() && o.tagName!='script'){
			var text=o.el.text()
			o.el.text(text.replace(re, replacer));			
	}
	
	return true;
}

spa.common.parse_double_curly=function(o){

	var re=/{{(.+?)}}/g;

	var replacer=function(match, p1) {
		return spa.common.get(o,p1)
	}

	$.each(o.el[0].attributes, function() {
		if(this.specified) {
			var attr=this.value;
			o.el.attr(this.name,attr.replace(re, replacer));
		}
	});

	return true;
}


spa.common.parse_text=function(o){
	var re=/{(.+?)}/g;
	var replacer=function(match, p1) {
		return spa.common.get(o,p1)
	}
	var element=o.el[0];
	if(o.el.tagName=='script')return true;
		
	for (var child= element.firstChild; child!==null; child= child.nextSibling) {
		if (child.nodeType===3){
			var text=child.nodeValue;
			child.nodeValue=text.replace(re, replacer)
		}

	}
	return true;
}


//See if get_any_fragment will work
spa.common.run_module=function(route){
	var d=$.Deferred();
	$.when(spa.common.get_module({route:route})).then(function(reply){
		var el=$(reply);
		$.when(spa.common.parse_axns(el)).then(function(){
			d.resolve();
		})
	})
	return d.promise(); 
}


//Routing of HTML Fragment
//route_page
//route_module
//route_ajax
//get - gets local HTML Fragment

spa.common.get_any_fragment=function(o,route){
	var d=$.Deferred();
	
	get_function=function(){return false};
	
	if(o.get)			get_function=function(){return spa.common.get(o)}
	if(o.route_module)	get_function=function(){return spa.common.get_module(o,o.route_module)}
	if(o.route_ajax)	get_function=function(){return spa.common.get_ajax(o,o.route_ajax)}
	if(o.route_page)	get_function=function(){return spa.common.get_page(o,o.route_page)}
	
	$.when(get_function()).then(function(reply){
			d.resolve(reply);
	})
	
	return d.promise(); 
}

spa.common.get_module=function(o,route_module){
//Get a Module from the Server	
	if(route_module)
		var route=route_module
	else
		var route=o.route

	var d1 = $.Deferred();
	var url=spa.settings.path + 'modules/' + route;
	var reply=spa.common.route_stack.get(url);

	if(reply===false){
		var request = $.get(url);
		request.done(function(reply){
			//cache
			spa.common.route_stack.add(
				{route:url,type:'module',reply:reply}
			)
			d1.resolve(reply);
		});
		request.fail(function(){
			alert("Unable to Connect to Server");
		});
	}
	else
		d1.resolve(reply);

	return d1.promise();	
}

spa.common.get_page=function(o,route_page){
	
	if(route_page)
		var route=route_page
	else
		var route=o.route_page
	
	var d1 = $.Deferred();
	var url=spa.settings.path + 'pages/' + route;
	var reply=spa.common.route_stack.get(url);
	if(reply===false){
		var request = $.get(url);
		request.done(function(reply){
			//cache
			spa.common.route_stack.add(
				{route:url,type:'page',reply:reply}
			)
			d1.resolve(reply);
		});
		request.fail(function(){
			alert("Unable to Connect to Server");
		});
	}
	else
		d1.resolve(reply);
		return d1.promise();	
}

spa.common.get_ajax=function(o,route_ajax){
//Get a Route from the Server	
	//check if block alreads has params
	if(route_ajax)
		var route=route_ajax
	else
		var route=o.route

	var data=spa.common.collect.everything(o);
	var url=spa.settings.path + 'ajax/' + route + '?ajax=true';
	var d1 = $.Deferred();
	var request = $.ajax({
		url: url,
		data: data,
		type: "POST"
	});
		
	request.done(function(reply){
		//cache
		d1.resolve(reply);
	});

	request.fail(function(){
		alert("Unable to Connect to Server");
	});
	return d1.promise();
}


spa.common.run_fragment=function(o){
	var d=$.Deferred();
	var nodes=null;

	$.when(spa.common.get_any_fragment(o)).then(function(reply){
		if(reply===false){
			if(o.tagName=='template')
				nodes=$(o.el.html())
			else
				nodes=o.el.children();
		}
		else{
			if(o.tagName=='template')
				nodes=$(reply)
			else
				o.el.empty();
				o.el.append(reply);
				nodes=o.el.children();
		}
		
		$.when(spa.common.parse_axns(nodes,o)).then(
			function(){d.resolve()},
			function(){d.reject()}
		)
	})
	
	return d.promise(); 
}


spa.common.get_any_data=function(o){
	var d=$.Deferred();
	
	get_function=function(){return false};
	
	if(o.get_data)			get_function=function(){return spa.common.get(o,o.get_data)}
	if(o.route_data)	get_function=function(){return spa.common.get_data(o,o.route_data)}
	if(o.route_ajax_data)	get_function=function(){return spa.common.get_ajax_data(o,o.route_ajax_data)}
	
	$.when(get_function()).then(function(reply){
			d.resolve(reply);
	})
	
	return d.promise(); 
}


//Server Routing of Data and Fragments
spa.common.get_data_url=function(o,route_data){
	if(route_data)
		var route=route_data
	else
		var route=o.route
	
	return spa.settings.path + 'data/' + route;
	
}

spa.common.get_data=function(o,route_data){
//Get a JSON Object from the Server	
	if(route_data)
		var route=route_data
	else
		var route=o.route
	
	var url=spa.settings.path + 'data/' + route;
	var d1 = $.Deferred();
	
	var reply=spa.common.route_stack.get(url);
	if(reply===false){
		var request = $.getJSON(url);
		request.done(function(reply){
			//cache
			spa.common.route_stack.add(
				{route:url,type:'data',reply:reply}
			)
			d1.resolve(reply);
		});

		request.fail(function(){
			alert("Unable to Connect to Server");
		});
	}
	else
		d1.resolve(reply);
		
	return d1.promise();
}

spa.common.get_ajax_data=function(o,route_data){
//Get a JSON Object from the Server	
	if(route_data)
		var route=route_data
	else
		var route=o.route
	
	var data=spa.common.collect.everything(o);
	var url=spa.settings.path + 'ajax-data/' + route + '?ajax=true';
	var d1 = $.Deferred();
	var request = $.getJSON(url,data);	
		
	request.done(function(reply){
		//cache
		d1.resolve(reply);
	});

	request.fail(function(){
		alert("Unable to Connect to Server");
	});

	return d1.promise();
}

spa.common.get_module_url=function(o,route_module){
	if(route_module)
		var route=route_module
	else
		var route=o.route
	
	return spa.settings.path + 'modules/' + route;
	
}

spa.common.get_cdn_lib=function(o,lib){
	var d1 = $.Deferred();
	if(!lib)lib=o.lib;
	var request = $.get(spa.settings.cdn + lib + '/' + lib + '.html');
	request.done(function(reply){
		var selector=$(reply);
		$.when(spa.common.parse_axns(selector,o)).then(function(){
			d1.resolve();
		})		
	});

	request.fail(function(){
		d1.reject();
	});		

	return d1.promise();		
}

spa.common.isObject=function(obj){
  return obj === Object(obj);
}

spa.common.html_replace=function(original,content){
	var token='temp_holder' + Math.floor((Math.random() * 1000) + 1)
	original.after('<div id="' + token + '"></div>')
	var p=	$('#' + token);
	p.css('height',$( window ).height());
	original.remove();
	p.after(content);
	p.remove();
}

spa.common.html_append=function(selector,content){
	selector.empty();
	selector.append(content);
}


spa.common.copy_attributes=function(el,o){
	$.each(el.attributes, function() {
		if(this.specified) {
			o[this.name]=this.value;
		}
	});
}

spa.common.create_app_structure=function(){
	if($('header').length<=0)
		$('<header />').prependTo('body');
	
	if($('main').length<=0)
		$('<main />').insertAfter('header');

	if($('footer').length<=0)
		$('<footer />').insertAfter('main');
	
}

spa.common.get_script=function(src){
	var d = $.Deferred();	

	for (var i = 0,len = document.scripts.length; i < len; i++) {
		if(document.scripts[i].src==src)return true;
	}
	
	if(spa.common.route_stack.check(src)!==false)return true;
	
	$.getScript(src, function() {
		spa.common.route_stack.add(	{route:src,type:'script',reply:''});
		d.resolve(true);
	});	
	return d.promise();
}

spa.common.get_css=function(href){
	var d = $.Deferred();	
	if(document.stylesheets){
		for (var i = 0,len = document.stylesheets.length; i < len; i++) {
			if(document.scripts[i].href==href)return true;
		}
	}
	if(spa.common.route_stack.check(href)!==false)return true;

	var link=$("<link rel='stylesheet' type='text/css' href='" + href +"'>");
	$("head").append(link); 
	spa.common.route_stack.add(	{route:href,type:'css',reply:''});
	return true;
}


})(jQuery); 

 
// Prerequisite Functions
(
 function($) {
spa.common.prerequisites={};
	 
spa.common.prerequisites.cdn_css_file=function(route){
	var d = $.Deferred();
	var path=spa.settings.cdn + route;
	$.when(spa.common.get_css(path)).then(function(){
		d.resolve();
	})	
	return d.promise();	
}

spa.common.prerequisites.css_file=function(route){
	var d = $.Deferred();	
	$.when(spa.common.get_css(route)).then(function(){
		d.resolve();
	})	
	return d.promise();
	
}

spa.common.prerequisites.cdn_js_file=function(route){
	var d = $.Deferred();	
	var path=spa.settings.cdn + route;
	$.when(spa.common.get_script(path)).then(function(){
		d.resolve();
	})	
	return d.promise();
}

spa.common.prerequisites.js_file=function(route){
	var d = $.Deferred();	
	$.when(spa.common.get_script(route)).then(function(){
		d.resolve();
	})	
	return d.promise();
}

spa.common.prerequisites.lib=function(lib){
	var d = $.Deferred();	
	$.when(spa.common.load_lib(lib)).then(function(){
		d.resolve();
	})
	return d.promise();
}

spa.common.prerequisites.module=function(route){
	var d = $.Deferred();	
	$.when(spa.common.run_module(route)).then(function(){
		d.resolve();
	})
	return d.promise();
	
}

spa.common.prerequisites.load=function(o){
	if(!o)return true;
	var d = $.Deferred();
	var promises=[];	
	if(o.cdn_css_files){
		$.each(o.cdn_css_files.split(','),function(index, value){
			promises.push(function(){
				return spa.common.prerequisites.cdn_css_file(value);
			})
		})
	}
	if(o.css_files){
		$.each(o.css_files.split(','),function(index, value){
			promises.push(function(){
				return spa.common.prerequisites.css_file(value);
			})
		})
	}
	if(o.cdn_js_files){
		$.each(o.cdn_js_files.split(','),function(index, value){
			promises.push(function(){
				return spa.common.prerequisites.cdn_js_file(value);
			})
		})
	}	
	if(o.js_files){
		$.each(o.js_files.split(','),function(index, value){
			promises.push(function(){
				return spa.common.prerequisites.js_file(value);
			})
		})
	}	
	if(o.modules){
		$.each(o.modules.split(','),function(index, value){
			promises.push(function(){
				var inner=$.Deferred();
				$.when(spa.common.get_module(o,value)).then(function(reply){
					var selector=$(reply);
					$.when(spa.common.parse_axns(selector,o)).then(function(){
						inner.resolve();
					})
				})
				return inner.promise(); 
			})
		})
	}	
	if(o.libs){
		$.each(o.libs.split(','),function(index, value){
			promises.push(function(){
				return spa.common.prerequisites.lib(value);
			})
		})
	}	

	$.when(spa.common.linear_promises(promises)).then(function(){
		d.resolve();
	})
	return d.promise();	
}

})(jQuery); 


//Conditions to decide whether to run a command or not
(
 function($) {

spa.common.conditions={};
	 
spa.common.conditions.odd=function(o){
	if(!o.hasOwnProperty('odd'))
		return true;
		
	if((o.odd%2)==1)
		return true;
	else
		return false;
}

spa.common.conditions.even=function(o){
	if(!o.hasOwnProperty('even'))
		return true;
	
	if((o.even%2)==1)
		return false;
	else
		return true;
}

spa.common.conditions.true=function(o){
	if(!o.hasOwnProperty('true'))
		return true;

	if(o.true)
		return true;
	else
		return false;
}

spa.common.conditions.false=function(o){
	if(!o.hasOwnProperty('false'))
		return true;
	
	if(o.false)
		return false;
	else
		return true;
}

spa.common.conditions.empty=function(o){
	if(!o.hasOwnProperty('empty'))
		return true;
	if(Boolean(o.empty))
		return true;
	else
		return false;
}

spa.common.conditions.not_empty=function(o){
	if(!o.hasOwnProperty('not_empty'))
		return true;
	if(Boolean(o.not_empty))
		return false;
	else
		return true;
}

spa.common.conditions.cond=function(o){
	if(!o.hasOwnProperty('cond'))
		return true;
	
	if(o.hasOwnProperty('equal')){
		if(o.cond==o.equal)
			return true
		else
			return false
	}
	if(o.hasOwnProperty('not_equal')){
		if(o.cond!=o.not_equal)
			return true
		else
			return false
	}
	if(o.hasOwnProperty('greater_than')){
		if(o.cond>o.greater_than)
			return true
		else
			return false
	}
	if(o.hasOwnProperty('less_than')){
		if(o.cond<o.less_than)
			return true
		else
			return false
	}	
	if(o.hasOwnProperty('greater_equal')){
		if(o.cond>=o.greater_equal)
			return true
		else
			return false
	}
	if(o.hasOwnProperty('less_equal')){
		if(o.cond<=o.less_equal)
			return true
		else
			return false
	}
	
}


})(jQuery); 

//equal='<get>',not_equal='<get>',greater_than='<get>',less_than='<get>',greater_equal='<get>',less_equal='<get>',




//Helper Functions for spa.common.get
(
function($) {
spa.common.get_helper={};	
spa.common.get_helper.start=function(o){
	key=o.pieces[0];

	switch (key) {
		
		case 'body':
			o.pieces.shift();
			o.value=$('body');
			break;
		case 'main':
			o.pieces.shift();
			o.value=$('main');
			break;
		case 'me':
			o.pieces.shift();
			o.value=o.el;
			break;
		case 'el':
			o.pieces.shift();
			o.value=o.el;
			break;			
		case 'parents' || 'controls'|| 'header' || 'footer' || 'nav':
			o.value=o.el;
			break;
		case 'page':
			o.pieces.shift();
			o.value=spa.page_control;
			break;			
		case 'trigger' || 'source':
			o.value=o.block;
			break;
		case 'selector':
			o.pieces.shift();		
			o.value=$(o.selector);
			break;			
		case 'spa':
			o.pieces.shift();		
			o.value=spa;		
			break;
		case 'settings':
			o.value=spa;
			break;
		case 'o':
			o.pieces.shift();
			o.value=o;
			break;
		case 'block':
			o.value=o;
			break;
		case 'event':
			o.value=o.block;
			break;
			
		case 'item':
			o.value=o.block.loop;
			break;
		case 'loop':
			o.value=o.block;
			break;
		default:
			if(spa[key]){
				o.value=spa;
			}
			else{
				o.value=o.get;
				o.pieces=[]
			}
			break;
	}

	return;
}


spa.common.get_helper.loop=function(o){
	if(o.pieces.length==0)return;

	var count=o.pieces.length;
	var loop=o.value;	
	var index=loop['index'];
	
	switch (o.pieces[0]) {
		case 'odd':
			o.pieces.shift();
			if (index % 2 != 0)
				o.value= true;
			else
				o.value= false;
			break;
		case 'even':
			o.pieces.shift();
			if (index % 2 == 0)
				o.value= true;
			else
				o.value= false;
			break;
		case 'first':
			o.pieces.shift();
			if (index ==1)
				o.value= true;
			else
				o.value= false;
			break;
		case 'last':
			o.pieces.shift();
			if (index ==loop['count'])
				o.value= true;
			else
				o.value= false;
			break;
		case 'between':
			o.pieces.shift();
			if (index !=loop['count'])
				o.value= true;
			else
				o.value= false;
			break;
		default:	
			spa.common.get_helper.array_basic(o);
	}
	if(length==o.pieces.length){
		o.value='_error';
		o.pieces=[];	
	}
	return;

}	
spa.common.get_helper.array=function(o){
	if(o.pieces.length==0)return;
	
	var arr=o.value;
	var key=o.pieces[0];

	if (arr[key]){
		o.pieces.shift();
		o.value= arr[key];
		return;
	}
	
	switch ($key) {
		case 'exists':
			o.pieces.shift();
			o.value=true;
			break;
		case 'count':
			o.pieces.shift();
			o.value=o.pieces.length;
			break;
		case 'dump':
			o.pieces.shift();
			o.value=spa.common.dump(arr);
			break;
		case 'empty':
			o.pieces.shift();
			if(arr==null || arr.length==0)
				o.value=true;
			else
				o.value=false;
			break;
		case 'not_empty':
			o.pieces.shift();
			if(arr==null || arr.length==0)
				o.value=false;
			else
				o.value=true;
			break;
		case 'first':
			o.pieces.shift();
			o.value= arr[0];
			break;
		case 'last':
			o.pieces.shift();
			o.value=arr[arr.length-1];
			break;
		case 'json_encode':
			o.pieces.shift();
			o.value=JSON.stringify(arr);
			break;
		case 'comma':
			o.pieces.shift();
			o.value=arr.join(',');
			break;
		case 'space':
			o.pieces.shift();
			o.value=arr.join(' ');
			break;
	}

	if(length==o.pieces.length){
		o.value='_error';
		o.pieces=[];	
	}
	return;
	
}
spa.common.get_helper.string=function(o){
	var length=o.pieces.length;
	if(length==0)return
	var string=o.value;
	
	switch (o.pieces[0]) {
		case 'exists':
			if (o.value=='_error')
				o.value = false;
			else
				o.value = true;
			o.pieces.shift();
			break;		
		case 'json_decode':
			o.pieces.shift();
			o.value=$.parseJSON(string);
			break;
		case 'comma':
			o.pieces.shift();
			o.value=$string.split(",")
			break;
		case 'parse':
			o.pieces.shift();
			o.value=spa.common.parse_shortcode($string);
			break;
		case 'lower':
			o.pieces.shift();
			o.value=strtolower($string)	;	
			break;
		case 'space':
			o.pieces.shift();
			o.value=explode(' ', trim($string));
			break;
		case 'trim':
			o.pieces.shift();
			o.value=trim($string);
			break;
		case 'math':
			o.pieces.shift();
			$pattern = '/([^-\d.\(\)\+\*\/ \^])/';
			$replacement = '';
			$result= preg_replace($pattern, $replacement, $string);
			o.value=eval('return ' + $result +  ' ;');
			break;
		
	}
	if(length==o.pieces.length){
		o.value='_error';
		o.pieces=[];	
	}
	return;	

}	
spa.common.get_helper.object=function(o){
	var length=o.pieces.length;
	if(length==0)return
	
	var obj=o.value;
	var key=o.pieces[0];

	if(obj.hasOwnProperty(key)){
		o.pieces.shift();
		o.value= obj[key];
		return;
	}	

	switch (key) {
		case 'exists':
			o.pieces.shift();
			o.value=true;
			break;
		case 'dump':
			o.pieces.shift();
			o.value=spa.common.dump(obj);
			return ;
			break;
	}
	if(length==o.pieces.length){
		o.value='_error';
		o.pieces=[];	
	}
	return;
}
spa.common.get_helper.control=function(o){
	var length=o.pieces.length;
	if(length==0)return
	
	var el=o.value;
	key=o.pieces[0];
	
	switch (key) {

		case 'controls':
			o.pieces.shift();
			o.value=el.find("article,section");
			spa.common.get_helper.controls(o);
		break
		case 'articles':
			o.pieces.shift();
			o.value=el.find('article');
			spa.common.get_helper.controls(o);
		break
		case 'sections':
			o.pieces.shift();
			o.value=el.find('section');
			spa.common.get_helper.controls(o);
		break		
		case 'parents':
			o.pieces.shift();
			o.value=el.parents('article,section,header,footer,nav');
			spa.common.get_helper.controls(o);
		break
		case 'header' || 'footer' || 'nav':
			o.pieces.shift();
			o.value=el.children(key).first()
		break;
	
		case 'html':
			o.pieces.shift();
			if(el.prop("tagName").toLowerCase()=='script')
				o.value=el.text()
			else	
				o.value=el.html()
		break;
		case 'text':
			o.pieces.shift();
			o.value=el.text()
		break;
		case 'contents':
			o.pieces.shift();
			o.value=el.contents();
		break;
		case 'val':
			o.pieces.shift();
			if(el.val())
			o.value=el.val();
			else 
				o.value=el.attr('val');
		break;
		case 'data':
			o.pieces.shift();
			o.value=el.data();		
		break;
		case 'content':
			o.pieces.shift();
			o.value=el.data().content;		
		break;
		
		case 'id':
			o.pieces.shift();
			o.value=el.attr('id');
		break;
		case 'attr':
			o.pieces.shift();
			o.value=el.attr(o.pieces[0]);
			o.pieces.shift();
		break;
		case 'json_object':
			o.pieces.shift();
			var str=el.text()
			o.value=$.parseJSON(str);

		break;
		case 'attributes':
			o.pieces.shift();
			var attributes = {}; 
			$.each( el[0].attributes, function( index, attr ) {
					attributes[ attr.name ] = attr.value;
			} ); 
			o.value= attributes;
			break;
		default:
			o.value=el.attr(o.pieces[0]);
			o.pieces.shift();
			break;
	}
	
	if(length==o.pieces.length){
		o.value='_error';
		o.pieces=[];	
	}
	return;	
	
}

spa.common.get_helper.controls=function(o){
	var length=o.pieces.length;
	if(length==0)return
	
	var controls=o.value;
	key=o.pieces[0];
	
	switch (key) {
		case 'count':
			o.pieces.shift();
			o.value=controls.length;
			break
		default:
			o.pieces.shift();
			o.value=controls.filter("[role='" + key + "'],#" + key);
			break;			
	}
	return;	
}


})(jQuery);


//Helper functions for spa.common.set
(
function($) {
spa.common.set_helper={};
spa.common.set_helper.object=function(o){
	if(o.pieces.length==0)return;
	
	var ptr=o.ptr;
	

	while(o.pieces.length>0) {
		var piece=o.pieces[0];
		o.pieces.shift();
		if(o.pieces.length==0)
			ptr[piece]=o.value
		else{
			if(ptr[piece] instanceof jQuery){
				spa.common.set_helper.control(o);
			}
			else{
				if(!spa.common.isObject(ptr[piece]))
					ptr[piece]={};
				
				ptr=ptr[piece]
				
			}
		}
	}		
}

spa.common.set_helper.control=function(o){
	if(o.pieces.length==0)
		o.pieces.push('html')

	key=o.pieces[0];
	
	switch (key) {
		
		case 'controls':
			o.pieces.shift();
			var filter=o.pieces[0];
			o.pieces.shift();
			o.selector=o.selector.find('article,section').filter("[role='" + filter + "'],#" + filter);
			spa.common.set_helper.control(o)
		break;
		case 'parents':
			o.pieces.shift();
			var filter=o.pieces[0];
			o.pieces.shift();
			o.selector=o.selector.parents('article,section,header,footer,nav').filter("[role='" + filter + "'],#" + filter);
			spa.common.set_helper.control(o)
		break;		
		case 'articles':
			o.pieces.shift();
			var filter=o.pieces[0];
			o.pieces.shift();
			o.selector=o.selector.find('article').filter("[role='" + filter + "'],#" + filter);
			spa.common.set_helper.control(o)
		break;		
		case 'sections':
			o.pieces.shift();
			var filter=o.pieces[0];
			o.pieces.shift();
			o.selector=o.selector.find('section').filter("[role='" + filter + "'],#" + filter);
			spa.common.set_helper.control(o)
		break;	
		case 'header':
			o.pieces.shift();
			o.selector=o.selector.children('header').first();
			spa.common.set_helper.control(o)
		break;
		case 'footer':
			o.pieces.shift();
			o.selector=o.selector.children('footer').first();
			spa.common.set_helper.control(o)
		break;			
		case 'nav':
			o.pieces.shift();
			o.selector=o.selector.children('nav').first();
			spa.common.set_helper.control(o)
		break;			
		case 'data':
			o.pieces.shift();
			o.ptr=o.selector.data();
			var data=o.pieces[0];
			spa.common.set_helper.object(o)
			o.selector.trigger(data + '_change');
		break;			
		case 'content':
			o.ptr=o.selector.data();
			spa.common.set_helper.object(o)
			o.selector.trigger('content_change');
		break;		
		case 'html':
			o.pieces.shift();
			o.selector.empty();
			o.selector.html(o.value);
			break;

		case 'text':
			o.pieces.shift();
			o.selector.text(o.value)
		break;
		case 'val':
			o.pieces.shift();
			var tagName=o.selector.prop("tagName").toLowerCase() ;
			if(tagName=='input' || tagName=='textarea' || tagName=='select')
				o.selector.val(o.value)
			else
				o.selector.attr('val',o.value)				
		break;
		case 'id':
			o.pieces.shift();
			o.selector.attr('id',o.value);
		break;
		case 'attr':
			o.pieces.shift();
			o.selector.attr(o.pieces[0],o.value);
			o.pieces.shift();
		break;
		
		case 'append':
			o.pieces.shift();
			if(o.value instanceof jQuery)
				var nodes=reply
			else{
				var html=$.parseHTML(o.value)	
				var nodes=$(html);	
			}
			o.selector.append(nodes);
			spa.common.parse_axns(nodes,o);
	
		break;	
		case 'prepend':
			o.pieces.shift();
			if(typeof o.value=='string')var nodes=$(o.value);
			if(o.value instanceof jQuery)var nodes=o.value
			o.selector.prepend(nodes);
			spa.common.parse_axns(nodes,o);
		break;	
		case 'update':
			o.pieces.shift();
			o.selector.empty();
			o.selector.append(o.value);
			spa.common.parse_axns(o.selector.children(),o);
		break;		
		case 'replace':
			o.pieces.shift();
			if(typeof o.value=='string')var nodes=$(o.value);
			if(o.value instanceof jQuery)var nodes=o.value
			spa.common.html_replace(o.selector,nodes)
			spa.common.parse_axns(nodes,o);
		break;			
	}
}
})(jQuery);


//Helper functions for collecting data to be sent to server
(
function($) {
spa.common.collect={};

spa.common.collect.everything=function(o){
		
	var collect=new Array();
	
	if(o.block && o.block.params){
		collect=o.block.params;
	}	
	

	if(o.el)
	spa.common.collect.attributes(o.el,collect);
	
	if(o.block.trigger)
		spa.common.collect.attributes(o.block.trigger,collect);

	var selector='';
	$.each(collect,function(index, obj){
		if(obj.name=='ajax_selector'){
			selector=obj.value;
		};
	})

	var form='';
	$.each(collect,function(index, obj){
		if(obj.name=='ajax_forms'){
			form=obj.value;
		};
	})
	
	if(selector)
		spa.common.collect.selector(selector,collect);
	
	if(form)
		spa.common.collect.form($('#' + form),collect);
	
	var data=$.param(collect);
	return data;
}

spa.common.collect.form=function(form,arr){

	// Collection data for tinymce
	form.find('.tinymce').each(function(){
		tinyMCE.get($(this).attr('id')).save();
	})
	arr2=form.serializeArray();
	$.each(arr2,function(index, obj){
		spa.common.collect.add(obj.name,obj.value,arr);
	})
	return true;
}

spa.common.collect.attributes=function(el,arr){
	$.each(el[0].attributes, function() {
		if(this.specified) {

			spa.common.collect.add(this.name,this.value,arr);
		}
	});
	if(el.is("[val]"))
			spa.common.collect.add(el.attr('id'),el.attr('val'),arr);	
			
	if(el.attr('id') && el.val()!=null)
		spa.common.collect.add(el.attr('id'),el.val(),arr);
}

spa.common.collect.add=function(name,value,arr){
	var done=false;
	$.each(arr,function(index, obj){
		if(obj.name==name){
			obj.name=name;
			obj.value=value;
			done=true;
		};
	})
	if(!done){
		var obj={name:name,value:value}
		arr.push(obj);
	}
	return true;		
}

})(jQuery);


//route_stack library
(
function($) {
spa.common.route_stack={}

spa.common.route_stack.check=function(route){
	for (var i = 0, len = spa.route_stack.length; i < len; i++) {
		if(spa.route_stack[i].route==route)	return spa.route_stack[i]
	}
	return false;		
}

spa.common.route_stack.add=function(o){
	var route_stack=spa.common.route_stack.check(o.route);
	if(route_stack===false){
		console.log('route added ' + o.route)
		spa.route_stack.push($.extend({}, o))	
		return true;	
	}
		
	return false;

}

spa.common.route_stack.get=function(route){
	var route_stack=spa.common.route_stack.check(route);
	if(route_stack===false)return false;

	return route_stack.reply;	
}

})(jQuery);


//element library
(
function($) {
spa.common.element={}

spa.common.element.update=function(o,el){
	var d=$.Deferred();
	$.when(spa.common.get_any_data(o)).then(function(reply){
		if(reply!==false){
			el.data().content=reply;
			el.trigger(('content_change'));
		}
		$.when(spa.common.get_any_fragment(o)).then(function(reply){
			if(reply==false){
				d.resolve();
				return
			}
			el.empty();
			if(reply instanceof jQuery)
				var nodes=reply
			else{
				var html=$.parseHTML(reply,document)	
				var nodes=$(html);	
			}
			
			el.append(nodes);
			$.when(spa.common.parse_axns(nodes,o)).then(function(){
				d.resolve();
			})
		})
	})
		
	return d.promise(); 		
	
}

spa.common.element.append=function(o,el){
	var d=$.Deferred();
	$.when(spa.common.get_any_data(o)).then(function(reply){
		if(reply!==false)el.data().content=reply;
		$.when(spa.common.get_any_fragment(o)).then(function(reply){
			if(reply instanceof jQuery)
				var nodes=reply
			else{
				var html=$.parseHTML(reply)	
				var nodes=$(html);	
			}
			
			el.append(nodes);
			
			$.when(spa.common.parse_axns(nodes,o)).then(function(){
				d.resolve();
			})
		})
	})
		
	return d.promise(); 		
}

spa.common.element.prepend=function(o,el){
	var d=$.Deferred();
	$.when(spa.common.get_any_data(o)).then(function(reply){
		if(reply!==false)el.data().content=reply;
		$.when(spa.common.get_any_fragment(o)).then(function(reply){
			if(reply instanceof jQuery)
				var nodes=reply
			else{
				var html=$.parseHTML(reply)	
				var nodes=$(html);	
			}
			
			el.prepend(nodes);
			
			$.when(spa.common.parse_axns(nodes,o)).then(function(){
				d.resolve();
			})
		})
	})
		
	return d.promise(); 		
}

spa.common.element.replace=function(o,el){
	var d=$.Deferred();
		$.when(spa.common.get_any_fragment(o)).then(function(reply){
			if(reply==false){
				d.resolve();
				return
			}
			if(reply instanceof jQuery)
				var nodes=reply
			else{
				var nodes=$(reply);	
			}
			
			el.replaceWith( nodes)
			$.when(spa.common.get_any_data(o)).then(function(reply){
				if(reply!==false){
					nodes.first().data().content=reply;
					nodes.first().trigger(('content_change'));
				}
				
				$.when(spa.common.parse_axns(nodes,o)).then(function(){
					d.resolve();
				})
		})
	})
		
	return d.promise(); 		
	
}			

spa.common.element.refresh=function(o,el){
	var d=$.Deferred();
	$.when(spa.common.get_any_data(o)).then(function(reply){
		if(reply!==false){
			el.data().content=reply;
			el.trigger(('content_change'));
		}
			$.when(spa.common.parse_axns(el.children(),o)).then(function(){
				d.resolve();
			})
		})

	return d.promise(); 		
}

spa.common.element.update_content=function(o,el){
	var d=$.Deferred();
	$.when(spa.common.get_any_data(o)).then(function(reply){
		if(reply!==false){
			el.data().content=reply;
			el.trigger(('content_change'));
		}
		d.resolve();
	})
	return d.promise(); 		
}


spa.common.element.get_content=function(o,el){
	o.el=el;
	o.get='me.content.' + o.get;
	o.value=spa.common.get(o);
	spa.common.direct_output(o);
}

spa.common.element.set_content=function(o,el){
	o.value=spa.common.get(o);
	o.el=el;
	o.set='me.content' ;	
	spa.common.direct_output(o);
}


spa.common.element.get_data=function(o,el){
	o.el=el;
	o.get='me.data.' + o.get;
	o.value=spa.common.get(o);
	spa.common.direct_output(o);
}

spa.common.element.set_data=function(o,el){
	var d=$.Deferred();
	$.when(spa.common.get_any_data(o)).then(function(reply){
		if(reply!==false){
			o.value=reply;
			o.el=el;
			o.set='me.data.' + o.set;	
			spa.common.direct_output(o);
		}
		d.resolve();
	})
	return d.promise(); 	
}

})(jQuery);


//SPA Core Functions

(
function($) {
	
	
spa.core={};

spa.core.parse=function(o){
	//spa.common.parse_attributes(o);
	spa.common.parse_text(o);
}

spa.core.default=function(o){
	var d=$.Deferred();
	spa.common.parse_text(o);
	o.el.children().each(function(){
		$(this).attr('axn','core.default');
	})
	spa.common.parse_axns(o.el.children(),o).then(function(){
		d.resolve();
	})			
	
	return d.promise();
}

spa.core.set=function(o){
	o.value=spa.common.get(o);
	if(!o.set)
		o.set='el.html';
	spa.common.direct_output(o)
	return true;
}	

spa.core.alert=function(o){
	var value=spa.common.get(o);
	alert(value)
	return true;
}	
spa.core.log=function(o){
	var value=spa.common.get(o);
	console.log(value)
	return true;
}

spa.core.set_html=function(o){
	var d=$.Deferred();
	var html=spa.common.get(o);
	o.el.html(html);
	spa.common.parse_axns(o.el.children(),o).then(function(){
		d.resolve();
	})			
	
	return d.promise();
}	


spa.core.run_script=function(o){
	var text=o.el.text();
	var newfunc=new Function('$','o',text)
	newfunc(jQuery,o);
}


//library functions
spa.core.register_lib=function(o){
	spa[o.lib]={};
	var lib=spa[o.lib];

	lib.init=function(){}
	lib.loaded=false;

	lib.prerequisites={};
	var prerequisites=lib.prerequisites;

	prerequisites.cdn_css_files=o.set_cdn_css_files ? o.set_cdn_css_files : '';
	prerequisites.cdn_js_files=o.set_cdn_js_files ? o.set_cdn_js_files : '';
	prerequisites.css_files=o.set_css_files ? o.set_css_files : '';
	prerequisites.js_files=o.set_js_files ? o.set_js_files : '';
	prerequisites.libs=o.set_libs ? o.set_libs : '';
	prerequisites.modules=o.set_modules ? o.set_modules : '';
	return true;	
}

spa.core.register_command=function(o){
	if(o.tagName=='script'){
		o.value=new Function('o',o.el.text())
	}
	else{
		o.value=o.el.html();
	}
	o.set='spa.' + o.set;
	spa.common.direct_output(o)
	
	return true;	
}



//templating

spa.core.run=function(o){
	return spa.common.run_fragment(o);
}

spa.core.loop=function(o){
	var d=$.Deferred();
	$.when(spa.common.get_any_data(o)).then(function(items){
		if(!$.isArray(items)){
			console.log('Loop Element is not an Array:' + o.get);
			return;
		}
		
		var loop={};
		loop.source=items;
		loop.count=items.length;
		loop.counter=0;

		var html=o.el.html();
		o.el.empty();

		
		function one_promise(){
			loop.index=loop.counter+1;
			if(loop.counter>=loop.count){
				d.resolve();
			}
			else{
				loop.item=items[loop.counter];
				var nodes=$(html);
				o.el.append(nodes);	
				o.block.loop=loop;
				$.when(spa.common.parse_axns(nodes,o)).then(
					function(){
						loop.counter++;
						one_promise();
					},
					function(){
						loop.counter++;
						one_promise();
					}
				)			
				
			}
		}
		one_promise();
		
	})
	
	
	return d.promise(); 	
}


spa.core.if=function(o){
	return spa.common.run_fragment(o); 
}

spa.core.if_check=function(o){
	var status=spa.common.check_conditions(o);
	if(status)
		status='yes'
	else
		status='no'
		
	var siblings=o.el.nextAll();
	var more=true
	$.each(siblings,function(){
		if(!more)return;
		
		if(!$(this).is("[axn]")){
			more=false;
			return;
		} 

		var axn=$(this).attr('axn');
		if(axn=='core.else' || axn=='core.and' || axn=='core.or'){
			$(this).attr('if_status',status);	
		}
		else
			more=false;			
		
	})
	if(status=='no'){
		o.el.remove();
		return false;
	}
	return true;
}


spa.core.else=function(o){
	return spa.common.run_fragment(o);
}

spa.core.else_check=function(o){
	var status=o.el.attr('if_status');

	if(status=='yes'){
		o.el.remove();
		return false;
	}
	return true;
}


spa.core.and=function(o){
	return spa.common.run_fragment(o);
}

spa.core.and_check=function(o){
	var if_status=o.el.attr('if_status');
	var status=spa.common.check_conditions(o);
	
	if(status && if_status=='yes')
		status='yes'
	else
		status='no'
		
	var siblings=o.el.nextAll();
	var more=true
	$.each(siblings,function(){
		if(!more)return;
		
		if(!$(this).is("[axn]")){
			more=false;
			return;
		} 

		var axn=$(this).attr('axn');
		if(axn=='core.else' || axn=='core.and' || axn=='core.or'){
			$(this).attr('if_status',status);	
		}
		else
			more=false;			
		
	})
	if(status=='no'){
		o.el.remove();
		return false;
	}
	return true;
}


spa.core.or=function(o){
	return spa.common.run_fragment(o);
}

spa.core.or_check=function(o){
	var if_status=o.el.attr('if_status');
	var status=spa.common.check_conditions(o);
	
	if(status || if_status=='yes')
		status='yes'
	else
		status='no'
		
	var siblings=o.el.nextAll();
	var more=true
	$.each(siblings,function(){
		if(!more)return;
		
		if(!$(this).is("[axn]")){
			more=false;
			return;
		} 

		var axn=$(this).attr('axn');
		if(axn=='core.else' || axn=='core.and' || axn=='core.or'){
			$(this).attr('if_status',status);	
		}
		else
			more=false;			
		
	})
	if(status=='no'){
		o.el.remove();
		return false;
	}
	return true;
}


spa.core.switch=function(o){
	return spa.common.run_fragment(o);
}

spa.core.case_check=function(o){

	var case_status='no'; 
	
	if(case_status=='yes'){
		o.el.remove();
		return false;
	}
	
	var status=spa.common.check_conditions(o);
	if(!status){
		o.el.remove();
		return false;
	}

	status='yes'

	var siblings=o.el.nextAll();
	$.each(siblings,function(){
		var axn=$(this).attr('axn');
		if(axn=='core.case' || axn=='core.case_else' )
			$(this).attr('case_status',status);	
	})
	return true;		
}

spa.core.case=function(o){
	return spa.common.run_fragment(o);
}

spa.core.case_else_check=function(o){
	var case_status=o.el.attr('case_status'); 
	
	if(case_status=='yes'){
		o.el.remove();
		return false;
	}
	return true;		
}

spa.core.case_else=function(o){
	return spa.common.run_fragment(o);
}


})(jQuery); 

//route library
(
function($) {
spa.route={}
spa.route.get=function(o){

	var d=$.Deferred();
	if(o.route_module)	get_function=function(){return spa.common.get_module(o,o.route_module)}
	if(o.route_ajax)	get_function=function(){return spa.common.get_ajax(o,o.route_ajax)}
	if(o.route_data)	get_function=function(){return spa.common.get_data(o,o.route_data)}
	
	$.when(get_function()).then(function(reply){
		o.value=reply;
		spa.common.direct_output(o);
		d.resolve();
	})
	return d.promise(); 

}

spa.route.get_once=function(o){

	var d=$.Deferred();
	

	if(o.route_module && spa.common.route_stack.check(spa.common.get_module_url(o,o.route_module))!==false)
		return true; 		

	if(o.route_data && spa.common.route_stack.check(spa.common.get_data_url(o,o.route_data))!==false)
		return true; 		
	
	
	if(o.route_module)	get_function=function(){return spa.common.get_module(o,o.route_module)}
	if(o.route_data)	get_function=function(){return spa.common.get_data(o,o.route_data)}
	
	$.when(get_function()).then(function(reply){
		o.value=reply;
		spa.common.direct_output(o);
		d.resolve();
	})
	return d.promise(); 

}

spa.route.run=function(o){
	var d=$.Deferred();
	if(o.route_module)	get_function=function(){return spa.common.get_module(o,o.route_module)}
	if(o.route_ajax)	get_function=function(){return spa.common.get_ajax(o,o.route_ajax)}
	
	$.when(get_function()).then(function(reply){
		var selector=$(reply);
		$.when(spa.common.parse_axns(selector,o)).then(function(){
			d.resolve();
		})
	})
	return d.promise(); 
}


spa.route.run_once=function(o){

	var d=$.Deferred();
	

	if(o.route_module && spa.common.route_stack.check(spa.common.get_module_url(o,o.route_module))!==false)
		return true; 		

	
	if(o.route_module)	get_function=function(){return spa.common.get_module(o,o.route_module)}
	
	$.when(get_function()).then(function(reply){
		var selector=$(reply);
		$.when(spa.common.parse_axns(selector,o)).then(function(){
			d.resolve();
		})
	})
	return d.promise(); 

}

})(jQuery);


//app library
(
function($) {
spa.app={}	

spa.app.start=function(o){
	var d=$.Deferred();
	var o={};
	o.block={};
	o.block.trigger=$('body');
	spa.page_control=$('body');
	$.when(spa.common.get_cdn_lib(o,'loader')).then(function(){
		spa.loader.show();
		$.when(spa.common.parse_axns($('body'),o)).then(function(){
			spa.loader.hide();
			d.resolve();
		})
	
		
	})

	return d.promise(); 
	
}

})(jQuery);

//page library
(
function($) {
spa.page={}	
spa.page.update=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.update(o,page);
}
spa.page.append=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.append(o,page);
}
spa.page.prepend=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.prepend(o,page);
}
spa.page.refresh=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.refresh(o,page);
}
spa.page.replace=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.replace(o,page);
}
spa.page.update_content=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.update_content(o,page);
}
spa.page.get_data=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.get_data(o,page);
}
spa.page.set_data=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.set_data(o,page);
}
spa.page.get_content=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.get_content(o,page);
}
spa.page.set_content=function(o){
	var page=o.control ? spa.common.get(o,o.control) : $('main') ;
	spa.page_control=page;
	return spa.common.element.set_content(o,page);
}
})(jQuery);


//me library
(
function($) {
spa.me={}	
spa.me.update=function(o){return spa.common.element.update(o,o.el);}
spa.me.append=function(o){return spa.common.element.append(o,o.el);}
spa.me.prepend=function(o){return spa.common.element.prepend(o,o.el);}
spa.me.refresh=function(o){return spa.common.element.refresh(o,o.el);}
spa.me.replace=function(o){return spa.common.element.replace(o,o.el);}
spa.me.update_content=function(o){return spa.common.element.update_content(o,o.el);}
spa.me.get_data=function(o){return spa.common.element.get_data(o,o.el);}
spa.me.set_data=function(o){return spa.common.element.set_data(o,o.el);}
spa.me.get_content=function(o){return spa.common.element.get_content(o,o.el);}
spa.me.set_content=function(o){return spa.common.element.set_content(o,o.el);}
})(jQuery);

//main library
(
function($) {
spa.main={}	
spa.main.update=function(o){return spa.common.element.update(o,$('main'));}
spa.main.append=function(o){return spa.common.element.append(o,$('main'));}
spa.main.prepend=function(o){return spa.common.element.prepend(o,$('main'));}
spa.main.refresh=function(o){return spa.common.element.refresh(o,$('main'));}
spa.main.replace=function(o){return spa.common.element.replace(o,$('main'));}
spa.main.update_content=function(o){return spa.common.element.update_content(o,$('main'));}
spa.main.get_data=function(o){return spa.common.element.get_data(o,$('main'));}
spa.main.set_data=function(o){return spa.common.element.set_data(o,$('main'));}
spa.main.get_content=function(o){return spa.common.element.get_content(o,$('main'));}
spa.main.set_content=function(o){return spa.common.element.set_content(o,$('main'));}
})(jQuery);

//control library
(
function($) {
spa.control={}	
spa.control.update=function(o){return spa.common.element.update(o,spa.common.get(o,o.control));}
spa.control.append=function(o){return spa.common.element.append(o,spa.common.get(o,o.control));}
spa.control.prepend=function(o){return spa.common.element.prepend(o,spa.common.get(o,o.control));}
spa.control.refresh=function(o){return spa.common.element.refresh(o,spa.common.get(o,o.control));}
spa.control.replace=function(o){return spa.common.element.replace(o,spa.common.get(o,o.control));}
spa.control.update_content=function(o){return spa.common.element.update_content(o,spa.common.get(o,o.control));}
spa.control.get_data=function(o){return spa.common.element.get_data(o,spa.common.get(o,o.control));}
spa.control.set_data=function(o){return spa.common.element.set_data(o,spa.common.get(o,o.control));}
spa.control.get_content=function(o){return spa.common.element.get_content(o,spa.common.get(o,o.control));}
spa.control.set_content=function(o){return spa.common.element.set_content(o,spa.common.get(o,o.control));}
})(jQuery);

//selector library
(
function($) {
spa.selector={}	
spa.selector.update=function(o){return spa.common.element.update(o,$(o.selector));}
spa.selector.append=function(o){return spa.common.element.append(o,$(o.selector));}
spa.selector.prepend=function(o){return spa.common.element.prepend(o,$(o.selector));}
spa.selector.refresh=function(o){return spa.common.element.refresh(o,$(o.selector));}
spa.selector.replace=function(o){return spa.common.element.replace(o,$(o.selector));}
spa.selector.update_content=function(o){return spa.common.element.update_content(o,$(o.selector));}
spa.selector.get_data=function(o){return spa.common.element.get_data(o,$(o.selector));}
spa.selector.set_data=function(o){return spa.common.element.set_data(o,$(o.selector));}
spa.selector.get_content=function(o){return spa.common.element.get_content(o,$(o.selector));}
spa.selector.set_content=function(o){return spa.common.element.set_content(o,$(o.selector));}
})(jQuery);

//trigger library
(
function($) {
spa.trigger={}	
spa.trigger.update=function(o){return spa.common.element.update(o,o.block.trigger);}
spa.trigger.append=function(o){return spa.common.element.append(o,o.block.trigger);}
spa.trigger.prepend=function(o){return spa.common.element.prepend(o,o.block.trigger);}
spa.trigger.refresh=function(o){return spa.common.element.refresh(o,o.block.trigger);}
spa.trigger.replace=function(o){return spa.common.element.replace(o,o.block.trigger);}
spa.trigger.update_content=function(o){return spa.common.element.update_content(o,o.block.trigger);}
spa.trigger.get_data=function(o){return spa.common.element.get_data(o,o.block.trigger);}
spa.trigger.set_data=function(o){return spa.common.element.set_data(o,o.block.trigger);}
spa.trigger.get_content=function(o){return spa.common.element.get_content(o,o.block.trigger);}
spa.trigger.set_content=function(o){return spa.common.element.set_content(o,o.block.trigger);}
})(jQuery);


//Notifications Library
(
function($) {
spa.notifications={};	
spa.notifications.prerequisites={};
spa.notifications.prerequisites.cdn_js_files='bootstrap/3.3.6/js/bootstrap.min.js,bootbox/4.4.0/js/bootbox.min.js';

spa.notifications.confirmation=function(o){
	if(!o.confirmation)return true;
	var d = $.Deferred();
	bootbox.confirm(o.confirmation, function(result) {
		if(result==true)
			d.resolve();
		else
			d.reject();
	}); 
	return d.promise();
}

spa.notifications.alert=function(o){
	if(!o.alert)return true;
	var d = $.Deferred();
	bootbox.alert(o.alert, function() {
			d.resolve();
	}); 
	return d.promise();
}

spa.notifications.acknowledgement=function(o){
	if(!o.acknowledgement)return true;
	var d = $.Deferred();
	bootbox.alert(o.notification, function() {
			d.resolve();
	}); 
	return d.promise();
}
	
})(jQuery);



//console library
(
function($) {
spa.console={}	
spa.console.log=function(o){
	var get=spa.common.get(o);
	console.log(get);
}
spa.console.error=function(o){
	var get=spa.common.get(o);
	console.error(get);
}

})(jQuery);


//form library
(
function($) {
spa.form={};	

spa.form.ajax=function(o){
	o.block.event.preventDefault()
	var d = $.Deferred();

	o.form=o.block.trigger;

	if(o.disable_selector)$(disable_selector).prop('disabled', true);
	spa.loader.show();	
	
	var d = $.Deferred();	
	
	$.when(this.validate(o)).then(
		function(){
			$.when(spa.common.get_any_fragment(o)).then(function(reply){
					var selector=$(reply);
					$.when(spa.common.parse_axns(selector,o)).then(function(){
						if(o.disable_selector)$(disable_selector).prop('disabled', false);
						spa.loader.hide();
						d.resolve()
					})
				})
		},
		function(){
			if(o.disable_selector)$(disable_selector).prop('disabled', false);
			spa.loader.hide();
			d.reject()
		}
	)

	return d.promise();
}

spa.form.show_error=function(o,rule){
	var attrib=rule.attribute;
	var message=rule.message;
	if(o.el[0].hasAttribute('msg-' + rule.attribute))
		message=o.el.attr('msg-' + rule.attribute)
	
	if(rule.type && o.el[0].hasAttribute('msg-' + rule.type))
		message=o.el.attr('msg-' + rule.type)

		o.el.parents('.form-group').addClass('has-error');
		o.el.parents('.form-group').find('.help-block').html(message);	
}


spa.form.validate=function(o){
	var d = $.Deferred();	
	var is_error=false;
	o.form.find('.form-group').removeClass('has-error');
	o.form.find('.help-block').html('');

	var nodes=$( ":input" );
	nodes.each(function(index,value){
		for (i = 0; i < spa.validation_rules.length; i++) { 
			if(spa.validation_rules[i].attribute && $(this)[0].hasAttribute(spa.validation_rules[i].attribute)){
				var obj={};	obj.form=o.form;obj.el=$(this);
				if(spa.validation_rules[i].fn(obj)===false){
					spa.form.show_error(obj,spa.validation_rules[i]);
					is_error=true;	
					break;					
				}
			}	
			if(spa.validation_rules[i].type && $(this).attr('type')==spa.validation_rules[i].type){
				var obj={};	obj.form=o.form;obj.el=$(this);
				if(spa.validation_rules[i].fn(obj)===false){
					spa.form.show_error(obj,spa.validation_rules[i]);
					is_error=true;	
					break;					
				}
			}			
		}
	})
	if(is_error)
		d.reject()
	else
		d.resolve()
		
	return d.promise();
	
}	

})(jQuery);


//validation rules
(
function($) {
spa.validation_rules=[];	

var validation_rule={}
validation_rule.order=100;
validation_rule.message='Field is required';
validation_rule.attribute='required';
validation_rule.fn=function(o){
	if(o.el.val()==undefined || o.el.val()=='')	
		return false;
	
	return true;
}
spa.validation_rules.push(validation_rule);

var validation_rule={}
validation_rule.order=200;
validation_rule.message='Not a valid Email';
validation_rule.type='email';
validation_rule.fn=function(o){
	var pattern = /\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,10}\b/igm;
	if(!pattern.test(o.el.val()))	
		return false;
	
	return true;
}
spa.validation_rules.push(validation_rule);

var validation_rule={}
validation_rule.order=300;
validation_rule.message='Not a valid Number';
validation_rule.type='number';
validation_rule.fn=function(o){
	if(isNaN(o.el.val()))	
		return false;
	
	return true;
}
spa.validation_rules.push(validation_rule);

var validation_rule={}
validation_rule.order=400;
validation_rule.message='Field does not match';
validation_rule.attribute='match';
validation_rule.fn=function(o){
	var el2=o.form.find(o.el.match);	
	if(o.el.val()!=o.el2.val())	
		return false;
	
	return true;
}
spa.validation_rules.push(validation_rule);


})(jQuery);


