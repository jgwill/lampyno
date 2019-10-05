shiftedit={};
shiftedit.dictionary={};
var TokenIterator = ace.require("ace/token_iterator").TokenIterator;
function starts_with(haystack, needle) {
	return needle === "" || haystack.indexOf(needle) === 0
}
function clone(obj) {
    if (null == obj || "object" != typeof obj) return obj;
    var copy = obj.constructor();
    for (var attr in obj) {
        if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
    }
    return copy;
}
getDefinitionRanges = function(editor){
		var session = editor.getSession();
		var iterator = new TokenIterator(session, 0, 0);
		var token = iterator.getCurrentToken();
		var definitions = {};
		var definitionRanges = clone(definitions);		
		var context = 'html';
		var attribute_name = "";
		var attribute_value = "";
		
		while (token !== null) {
			if (!token) {
				token = iterator.stepForward();
				continue
			}
			if (token.type == "support.php_tag" && token.value != "?>") {
				context = "php"
			} else if (token.type == "support.php_tag" && token.value == "?>") {
				context = "html"
			} else if (starts_with(token.type, "meta.tag.style.tag-name") && context != "css") {
				context = "css"
			} else if (starts_with(token.type, "meta.tag.style.tag-name") && context == "css") {
				context = "html"
			} else if (starts_with(token.type, "meta.tag.script.tag-name") && context != "js") {
				context = "js"
			} else if (starts_with(token.type, "meta.tag.script.tag-name") && context == "js") {
				context = "html"
			}
			//console.log("context:"+context);
			if (!definitions[context] && context !== "html") {
				definitions[context] = {
					classes : {},
					functions : {},
					variables : {},
					ids : {}

				};
				if (!definitionRanges[context]) {
					definitionRanges[context] = clone(definitions[context])
				}
			} else if (context == "html" && !definitions["css"]) {
				definitions["css"] = {
					functions : {},
					variables : {},
					ids : {},
					classes : {}

				};
				if (!definitionRanges["css"]) {
					definitionRanges["css"] = clone(definitions["css"])
				}
			}
			//console.log("token.type:"+token.type);
			if (token.type == "entity.other.attribute-name.awui" && context == "html") {
				attribute_name = token.value;
				attribute_value = ""
			}
			if (token.type == "string.attribute-value.awui" && context == "html") {
				attribute_value = token.value
			}
			if ((token.type == "keyword" || token.type == "storage.type") && (token.value == "function" || token.value == "def")) {
				func = " "
			}
			
			
			
			if (context == "css") {
				if (token.type == "variable") {
					name = token.value.substr(1);
					definitions[context]["classes"][name] = 1;
					definitionRanges[context]["classes"][name] = {
						start : {
							column : iterator.getCurrentTokenColumn() + 1,
							row : iterator.getCurrentTokenRow()
						}
					}
				}
			}
			if (context == "css") {
				if (token.type == "keyword") {
					name = token.value.substr(1);
					definitions[context]["ids"][name] = 1;
					definitionRanges[context]["ids"][name] = {
						start : {
							column : iterator.getCurrentTokenColumn() + 1,
							row : iterator.getCurrentTokenRow()
						}
					}
				}
			} else if (context == "html" && attribute_name == "id" && attribute_value) {
				name = attribute_value.replace(/"/g, "");
				definitions["css"]["ids"][name] = 1;
				definitionRanges["css"]["ids"][name] = {
					start : {
						column : iterator.getCurrentTokenColumn() + 1,
						row : iterator.getCurrentTokenRow()
					}
				};
				attribute_value = ""
			} else if (context == "html" && attribute_name == "class" && attribute_value) {
				var classes = attribute_value.replace(/"/g, "").split(" ");
				for (i in classes) {
					name = classes[i];
					definitions["css"]["classes"][name] = 1;
					definitionRanges["css"]["classes"][name] = {
						start : {
							column : iterator.getCurrentTokenColumn() + 1,
							row : iterator.getCurrentTokenRow()
						}
					}
				}
				attribute_value = ""
			}
			token = iterator.stepForward()
		}
		//console.log("Inside Def:");
		//console.log(definitions);
		this.definitions = definitions;
		this.definitionRanges = definitionRanges;
}
shiftedit.autocomplete = function () {
	var _this = this;
	var html_tags = ["!doctype", "a", "abbr", "acronym", "address", "applet", "area", "article", "aside", "audio", "b", "base", "basefont", "bdo", "bgsound", "big", "blink", "blockquote", "body", "br", "button", "canvas", "caption", "center", "cite", "code", "col", "colgroup", "command", "comment", "datalist", "dd", "del", "dfn", "dir", "div", "dl", "dt", "em", "embed", "fieldset", "figcaption", "figure", "font", "footer", "form", "frame", "frameset", "h1", "h2", "h3", "h4", "h5", "h6", "head", "header", "hgroup", "hr", "html", "i", "iframe", "ilayer", "img", "input", "ins", "isindex", "kbd", "keygen", "label", "layer", "legend", "li", "link", "listing", "map", "mark", "marquee", "menu", "meta", "meter", "multicol", "nav", "nextid", "nobr", "noembed", "noframes", "nolayer", "noscript", "object", "ol", "optgroup", "option", "output", "p", "param", "plaintext", "pre", "progress", "q", "rb", "rbc", "rp", "rt", "rtc", "ruby", "s", "samp", "script", "section", "select", "small", "source", "spacer", "span", "strike", "strong", "style", "sub", "summary", "sup", "table", "tbody", "td", "textarea", "tfoot", "th", "thead", "time", "tr", "tt", "u", "ul", "var", "wbr", "video", "wbr", "xml", "xmp"];
	function commonAttributes(obj) {
		var result = {};
		var n;
		if (obj) {
			for (n in obj) {
				result[n] = obj[n]
			}
		}
		for (n in {
			id : 2,
			"class" : 2,
			style : 2,
			title : 2
		})
			result[n] = 2;
		return function () {
			return result
		}
		()
	}
	function merge(obj1, obj2) {
		var obj1b = clone(obj1);
		var obj2b = clone(obj2);
		return jQuery.extend(obj1b, obj2b)
	}
	var jqueryDictionary = {
		add : "(selector)"
	};
	var jsDictionary = {
		Global : {
			Infinity : 2,
			NaN : 2,
			undefined : 2,
			decodeURI : "(uri)",
			decodeURIComponent : "(uri)",
			encodeURI : "(uri)",
			encodeURIComponent : "(uri)",
			escape : "(string)",
			eval : "(string)",
			isFinite : "(value)",
			isNaN : "(value)",
			Number : "(object)",
			parseFloat : "(string)",
			parseInt : "(string, radix)",
			String : "(object)"
		},
		Array : {
			length : 2,
			concat : "(array2, array3, ..., arrayX)",
			indexOf : "(item, start)",
			join : "(separator)",
			lastIndexOf : "(item, start)",
			pop : "()",
			push : "(item1, item2, ..., itemX)",
			reverse : "()",
			shift : "()",
			slice : "(start, end)",
			sort : "(sortfunction)",
			splice : "(index, howmany, item1, ....., itemX)",
			toString : "(item1, item2, ..., itemX)",
			unshift : "()",
			valueOf : "()"
		},
		Number : {
			toExponential : "(x)",
			toFixed : "(x)",
			toPrecision : "(x)",
			toString : "(radix)",
			valueOf : "()"
		},
		String : {
			length : 2,
			charAt : "(index)",
			charCodeAt : "(index)",
			concat : "(string1, string2, ..., stringX)",
			fromCharCode : "(n1, n2, ..., nX)",
			indexOf : "(searchvalue, start)",
			lastIndexOf : "(searchvalue, start)",
			localeCompare : "(compareString)",
			match : "(regexp)",
			replace : "(searchvalue, newvalue)",
			search : "(searchvalue)",
			slice : "(start, end)",
			split : "(separator, limit)",
			substr : "(start, length)",
			substring : "(start, end)",
			toLocaleLowerCase : "()",
			toLocaleUpperCase : "()",
			toLowerCase : "()",
			toString : "()",
			toUpperCase : "()",
			trim : "()",
			valueOf : "()"
		},
		Math : {
			"round($0)" : 2,
			"random($0)" : 2,
			"max($0)" : 2,
			"min($0)" : 2,
			"abs($0)" : 2,
			"acos($0)" : 2,
			"asin($0)" : 2,
			"atan2($0)" : 2,
			"ceil($0)" : 2,
			"cos($0)" : 2,
			"exp($0)" : 2,
			"floor($0)" : 2,
			"log($0)" : 2,
			"pow($0)" : 2,
			"sin($0)" : 2,
			"sqrt($0)" : 2,
			"tan($0)" : 2,
			E : 2,
			LN2 : 2,
			LN10 : 2,
			LOG2E : 2,
			LOG10E : 2,
			PI : 2,
			SQRT1_2 : 2,
			SQRT2 : 2
		},
		console : {
			"log($0)" : 2,
			"error($0)" : 2,
			"trace($0)" : 2,
			"warn($0)" : 2
		},
		document : {
			anchors : 2,
			applets : 2,
			body : 2,
			cookie : 2,
			documentMode : 2,
			domain : 2,
			forms : 2,
			images : 2,
			lastModified : 2,
			links : 2,
			readyState : 2,
			referrer : 2,
			title : 2,
			URL : 2,
			"close($0)" : 2,
			"getElementById($0)" : 2,
			"getElementsByName($0)" : 2,
			"getElementsByClassName($0)" : 2,
			"getElementsByTagName($0)" : 2,
			"open($0)" : 2,
			"write($0)" : 2,
			"writeln($0)" : 2
		},
		history : {
			length : 2,
			"back($0)" : 2,
			"forward($0)" : 2,
			"go($0)" : 2
		},
		JSON : {
			"parse($0)" : 2,
			"stringify($0)" : 2
		},
		location : {
			hash : 2,
			host : 2,
			hostname : 2,
			href : 2,
			pathname : 2,
			port : 2,
			protocol : 2,
			search : 2,
			"assign($0)" : 2,
			"reload($0)" : 2,
			"replace($0)" : 2
		},
		navigator : {
			appCodeName : 2,
			appName : 2,
			appVersion : 2,
			cookieEnabled : 2,
			onLine : 2,
			platform : 2,
			userAgent : 2,
			"javaEnabled($0)" : 2,
			"taintEnabled($0)" : 2
		},
		RegEzp : {
			compile : 2,
			exec : 2,
			test : 2
		},
		screen : {
			availHeight : 2,
			availWidth : 2,
			colorDepth : 2,
			height : 2,
			pixelDepth : 2,
			width : 2
		},
		window : {
			closed : 2,
			defaultStatus : 2,
			document : 2,
			frames : 2,
			history : 2,
			innerHeight : 2,
			innerWidth : 2,
			length : 2,
			location : 2,
			name : 2,
			navigator : 2,
			opener : 2,
			outerHeight : 2,
			outerWidth : 2,
			pageXOffset : 2,
			pageYOffset : 2,
			parent : 2,
			screen : 2,
			screenLeft : 2,
			screenTop : 2,
			screenX : 2,
			screenY : 2,
			self : 2,
			status : 2,
			top : 2,
			"alert($0)" : 2,
			"blur($0)" : 2,
			"clearInterval($0)" : 2,
			"clearTimeout($0)" : 2,
			"close($0)" : 2,
			"confirm($0)" : 2,
			"createPopup($0)" : 2,
			"focus($0)" : 2,
			"moveBy($0)" : 2,
			"moveTo($0)" : 2,
			"open($0)" : 2,
			"print($0)" : 2,
			"prompt($0)" : 2,
			"resizeBy($0)" : 2,
			"resizeTo($0)" : 2,
			"scroll($0)" : 2,
			"scrollBy($0)" : 2,
			"scrollTo($0)" : 2,
			"setInterval($0)" : 2,
			"setTimeout($0)" : 2
		}
	};
	var cssDictionary = {
		background : {
			"#$0" : 2
		},
		"background-color" : {
			"#$0" : 2,
			transparent : 2,
			fixed : 2
		},
		"background-image" : {
			"url('/$0')" : 2
		},
		"background-repeat" : {
			repeat : 2,
			"repeat-x" : 2,
			"repeat-y" : 2,
			"no-repeat" : 2,
			inherit : 2
		},
		"background-position" : {
			bottom : 2,
			center : 2,
			left : 2,
			right : 2,
			top : 2,
			inherit : 2
		},
		"background-attachment" : {
			scroll : 2,
			fixed : 2
		},
		"background-size" : {
			cover : 2,
			contain : 2
		},
		"background-clip" : {
			"border-box" : 2,
			"padding-box" : 2,
			"content-box" : 2
		},
		"background-origin" : {
			"border-box" : 2,
			"padding-box" : 2,
			"content-box" : 2
		},
		border : {
			"solid $0" : 2,
			"dashed $0" : 2,
			"dotted $0" : 2,
			"#$0" : 2
		},
		"border-top" : 1,
		"border-right" : 1,
		"border-bottom" : 1,
		"border-left" : 1,
		"border-color" : {
			"#$0" : 2
		},
		"border-width" : 1,
		"border-style" : {
			solid : 2,
			dashed : 2,
			dotted : 2,
			"double" : 2,
			groove : 2,
			hidden : 2,
			inherit : 2,
			inset : 2,
			none : 2,
			outset : 2,
			ridged : 2
		},
		"border-spacing" : 1,
		"border-collapse" : {
			collapse : 2,
			separate : 2
		},
		bottom : {
			px : 2,
			em : 2,
			"%" : 2
		},
		clear : {
			left : 2,
			right : 2,
			both : 2,
			none : 2
		},
		clip : 1,
		color : {
			"#$0" : 2,
			"rgb(#$00,0,0)" : 2
		},
		content : 1,
		cursor : {
			"default" : 2,
			pointer : 2,
			move : 2,
			text : 2,
			wait : 2,
			help : 2,
			progress : 2,
			"n-resize" : 2,
			"ne-resize" : 2,
			"e-resize" : 2,
			"se-resize" : 2,
			"s-resize" : 2,
			"sw-resize" : 2,
			"w-resize" : 2,
			"nw-resize" : 2
		},
		display : {
			none : 2,
			block : 2,
			inline : 2,
			"inline-block" : 2,
			"table-cell" : 2
		},
		"empty-cells" : {
			show : 2,
			hide : 2
		},
		"float" : {
			left : 2,
			right : 2,
			none : 2
		},
		"font-family" : {
			Arial : 2,
			"Comic Sans MS" : 2,
			Consolas : 2,
			"Courier New" : 2,
			Courier : 2,
			Georgia : 2,
			Monospace : 2,
			"Sans-Serif" : 2,
			"Segoe UI" : 2,
			Tahoma : 2,
			"Times New Roman" : 2,
			"Trebuchet MS" : 2,
			Verdana : 2
		},
		"font-size" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"font-weight" : {
			bold : 2,
			normal : 2
		},
		"font-style" : {
			italic : 2,
			normal : 2
		},
		"font-variant" : {
			normal : 2,
			"small-caps" : 2
		},
		font : 1,
		height : {
			px : 2,
			em : 2,
			"%" : 2
		},
		left : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"letter-spacing" : {
			normal : 2
		},
		"line-height" : {
			normal : 2
		},
		"list-style" : 1,
		"list-style-image" : 1,
		"list-style-position" : 1,
		"list-style-type" : {
			none : 2,
			disc : 2,
			circle : 2,
			square : 2,
			decimal : 2,
			"decimal-leading-zero" : 2,
			"lower-roman" : 2,
			"upper-roman" : 2,
			"lower-greek" : 2,
			"lower-latin" : 2,
			"upper-latin" : 2,
			georgian : 2,
			"lower-alpha" : 2,
			"upper-alpha" : 2
		},
		margin : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"margin-right" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"margin-left" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"margin-top" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"margin-bottom" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"max-height" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"max-width" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"min-height" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"min-width" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		outline : 1,
		"outline-color" : 1,
		"outline-style" : 1,
		"outline-width" : 1,
		overflow : {
			hidden : 2,
			visible : 2,
			auto : 2,
			scroll : 2
		},
		"overflow-x" : {
			hidden : 2,
			visible : 2,
			auto : 2,
			scroll : 2
		},
		"overflow-y" : {
			hidden : 2,
			visible : 2,
			auto : 2,
			scroll : 2
		},
		padding : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"padding-top" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"padding-right" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"padding-bottom" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"padding-left" : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"page-break-after" : {
			auto : 2,
			always : 2,
			avoid : 2,
			left : 2,
			right : 2
		},
		"page-break-before" : {
			auto : 2,
			always : 2,
			avoid : 2,
			left : 2,
			right : 2
		},
		"page-break-inside" : 1,
		position : {
			absolute : 2,
			relative : 2,
			fixed : 2,
			"static" : 2
		},
		right : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"table-layout" : {
			fixed : 2,
			auto : 2
		},
		"text-decoration" : {
			none : 2,
			underline : 2,
			"line-through" : 2,
			blink : 2
		},
		"text-align" : {
			left : 2,
			right : 2,
			center : 2,
			justify : 2
		},
		"text-indent" : 1,
		"text-transform" : {
			capitalize : 2,
			uppercase : 2,
			lowercase : 2,
			none : 2
		},
		top : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"vertical-align" : {
			top : 2,
			bottom : 2
		},
		visibility : {
			hidden : 2,
			visible : 2
		},
		"white-space" : {
			nowrap : 2,
			normal : 2,
			pre : 2,
			"pre-line" : 2,
			"pre-wrap" : 2
		},
		width : {
			px : 2,
			em : 2,
			"%" : 2
		},
		"word-spacing" : {
			normal : 2
		},
		"z-index" : 1,
		opacity : 1,
		filter : {
			"alpha(opacity=$0100)" : 2
		},
		"text-shadow" : {
			"$02px 2px 2px #777" : 2
		},
		"text-overflow" : {
			"ellipsis-word" : 2,
			clip : 2,
			ellipsis : 2
		},
		"border-radius" : 1,
		"-moz-border-radius" : 1,
		"-moz-border-radius-topright" : 1,
		"-moz-border-radius-bottomright" : 1,
		"-moz-border-radius-topleft" : 1,
		"-moz-border-radius-bottomleft" : 1,
		"-webkit-border-radius" : 1,
		"-webkit-border-top-right-radius" : 1,
		"-webkit-border-top-left-radius" : 1,
		"-webkit-border-bottom-right-radius" : 1,
		"-webkit-border-bottom-left-radius" : 1,
		"-moz-box-shadow" : 1,
		"-webkit-box-shadow" : 1,
		transform : {
			"rotate($00deg)" : 2,
			"skew($00deg)" : 2
		},
		"-moz-transform" : {
			"rotate($00deg)" : 2,
			"skew($00deg)" : 2
		},
		"-webkit-transform" : {
			"rotate($00deg)" : 2,
			"skew($00deg)" : 2
		}
	};
	var cssPseudoClasses = {
		link : 1,
		visited : 1,
		active : 1,
		hover : 1,
		focus : 1,
		"first-letter" : 1,
		"first-line" : 1,
		"first-child" : 1,
		before : 1,
		after : 1,
		"last-child" : 1
	};
	var xmlDictionary = {
		html : 1,
		head : 1,
		meta : {
			name : {
				description : 1,
				keywords : 1
			},
			content : {
				"text/html; charset=UTF-8" : 1
			},
			"http-equiv" : {
				"content-type" : 1
			}
		},
		link : {
			type : {
				"text/css" : 1,
				"image/png" : 1,
				"image/jpeg" : 1,
				"image/gif" : 1
			},
			rel : {
				stylesheet : 1,
				icon : 1
			},
			href : 2,
			media : {
				all : 1,
				screen : 1,
				print : 1
			}
		},
		style : {
			type : {
				"text/css" : 1
			},
			media : {
				all : 1,
				screen : 1,
				print : 1
			}
		},
		title : 1,
		option : {
			value : 2,
			selected : {
				selected : 1
			}
		},
		optgroup : {
			label : 2
		},
		script : {
			type : {
				"text/javascript" : 1
			},
			src : 2
		},
		body : {
			onload : 2
		},
		a : {
			name : 2,
			href : 2,
			target : {
				_blank : 1,
				top : 1
			},
			rel : {
				nofollow : 1,
				alternate : 1,
				author : 1,
				bookmark : 1,
				help : 1,
				license : 1,
				next : 1,
				noreferrer : 1,
				prefetch : 1,
				prev : 1,
				search : 1,
				tag : 1
			}
		},
		img : {
			src : 2,
			alt : 2,
			width : 2,
			height : 2
		},
		form : {
			method : {
				get : 1,
				post : 1
			},
			action : 2,
			enctype : {
				"multipart/form-data" : 1,
				"application/x-www-form-urlencoded" : 1
			},
			onsubmit : 2,
			target : {
				_blank : 1,
				top : 1
			}
		},
		input : {
			type : {
				text : 1,
				password : 1,
				hidden : 1,
				checkbox : 1,
				submit : 1,
				radio : 1,
				file : 1,
				button : 1,
				reset : 1,
				image : 1,
				color : 1,
				date : 1,
				datetime : 1,
				"datetime-local" : 1,
				email : 1,
				month : 1,
				number : 1,
				range : 1,
				search : 1,
				tel : 1,
				time : 1,
				url : 1,
				week : 1
			},
			name : 2,
			value : 2,
			placeholder : 2,
			checked : {
				checked : 1
			},
			maxlength : 2,
			multiple : {
				multiple : 1
			},
			disabled : {
				disabled : 1
			},
			readonly : {
				readonly : 1
			},
			size : 2,
			step : 2,
			onchange : 2,
			onfocus : 2,
			onblur : 2,
			autocomplete : {
				on : 1,
				off : 1
			},
			autofocus : {
				autofocus : 1
			},
			form : 2,
			formaction : 2,
			formenctype : {
				"application/x-www-form-urlencoded" : 1,
				"multipart/form-data" : 1,
				"text/plain" : 1
			},
			formmethod : {
				get : 1,
				post : 1
			},
			formnovalidate : {
				formnovalidate : 1
			},
			formtarget : {
				_blank : 1,
				_self : 1,
				_parent : 1,
				_top : 1
			},
			height : 2,
			list : 2,
			max : 2,
			min : 2,
			pattern : 2,
			required : {
				required : 1
			},
			width : 2
		},
		select : {
			name : 2,
			size : 2,
			multiple : {
				multiple : 1
			},
			disabled : {
				disabled : 1
			},
			readonly : {
				readonly : 1
			},
			onchange : 2
		},
		label : {
			"for" : 2
		},
		textarea : {
			name : 2,
			cols : 2,
			rows : 2,
			placeholder : 2,
			wrap : {
				on : 1,
				off : 1,
				hard : 1,
				soft : 1
			},
			disabled : {
				disabled : 1
			},
			readonly : {
				readonly : 1
			},
			autofocus : {
				autofocus : 1
			},
			form : 2,
			maxlength : 2,
			required : {
				required : 1
			}
		},
		button : {
			onclick : 2,
			type : {
				button : 1,
				submit : 1
			},
			title : 2
		},
		keygen : {
			onclick : 2,
			challenge : {
				challenge : 1
			},
			disabled : {
				disabled : 1
			},
			keytype : {
				rsa : 1,
				dsa : 1,
				ec : 1
			},
			name : 2
		},
		table : {
			border : {
				0 : 1
			},
			cellpadding : {
				0 : 1
			},
			cellspacing : {
				0 : 1
			},
			width : 2,
			height : 2,
			summary : 2
		},
		th : {
			colspan : 2,
			rowspan : 2,
			width : 2,
			height : 2,
			valign : {
				top : 1,
				bottom : 1,
				baseline : 1,
				middle : 1
			}
		},
		td : {
			colspan : 2,
			rowspan : 2,
			width : 2,
			height : 2,
			valign : {
				top : 1,
				bottom : 1,
				baseline : 1,
				middle : 1
			}
		},
		iframe : {
			src : 2,
			frameborder : {
				0 : 1
			},
			allowfullscreen : {
				"true" : 1,
				"false" : 1
			},
			sandbox : {
				"allow-same-origin" : 1,
				"allow-top-navigation" : 1,
				"allow-forms" : 1,
				"allow-scripts" : 1
			},
			seamless : {
				seamless : 1
			},
			srcdoc : 2
		},
		audio : {
			src : 2,
			autoplay : {
				autoplay : 1
			},
			controls : {
				controls : 1
			},
			loop : {
				loop : 1
			},
			muted : {
				muted : 1
			},
			preload : {
				auto : 1,
				metadata : 1,
				none : 1
			}
		},
		video : {
			src : 2,
			autoplay : {
				autoplay : 1
			},
			controls : {
				controls : 1
			},
			width : 2,
			height : 2,
			loop : {
				loop : 1
			},
			muted : {
				muted : 1
			},
			poster : 2,
			preload : {
				auto : 1,
				metadata : 1,
				none : 1
			}
		}
	};
	var entityDictionary = {
		"&Aacute;" : 1,
		"&aacute;" : 1,
		"&Acirc;" : 1,
		"&acirc;" : 1,
		"&acute;" : 1,
		"&AElig;" : 1,
		"&aelig;" : 1,
		"&Agrave;" : 1,
		"&agrave;" : 1,
		"&alefsym;" : 1,
		"&Alpha;" : 1,
		"&alpha;" : 1,
		"&amp;" : 1,
		"&and;" : 1,
		"&ang;" : 1,
		"&Aring;" : 1,
		"&aring;" : 1,
		"&asymp;" : 1,
		"&Atilde;" : 1,
		"&atilde;" : 1,
		"&Auml;" : 1,
		"&auml;" : 1,
		"&bdquo;" : 1,
		"&Beta;" : 1,
		"&beta;" : 1,
		"&brvbar;" : 1,
		"&bull;" : 1,
		"&cap;" : 1,
		"&Ccedil;" : 1,
		"&ccedil;" : 1,
		"&cedil;" : 1,
		"&cent;" : 1,
		"&Chi;" : 1,
		"&chi;" : 1,
		"&circ;" : 1,
		"&clubs;" : 1,
		"&cong;" : 1,
		"&copy;" : 1,
		"&crarr;" : 1,
		"&cup;" : 1,
		"&curren;" : 1,
		"&Dagger;" : 1,
		"&dagger;" : 1,
		"&dArr;" : 1,
		"&darr;" : 1,
		"&deg;" : 1,
		"&Delta;" : 1,
		"&delta;" : 1,
		"&diams;" : 1,
		"&divide;" : 1,
		"&Eacute;" : 1,
		"&eacute;" : 1,
		"&Ecirc;" : 1,
		"&ecirc;" : 1,
		"&Egrave;" : 1,
		"&egrave;" : 1,
		"&empty;" : 1,
		"&emsp;" : 1,
		"&ensp;" : 1,
		"&Epsilon;" : 1,
		"&epsilon;" : 1,
		"&equiv;" : 1,
		"&Eta;" : 1,
		"&eta;" : 1,
		"&ETH;" : 1,
		"&eth;" : 1,
		"&Euml;" : 1,
		"&euml;" : 1,
		"&euro;" : 1,
		"&exist;" : 1,
		"&fnof;" : 1,
		"&forall;" : 1,
		"&frac12;" : 1,
		"&frac14;" : 1,
		"&frac34;" : 1,
		"&frasl;" : 1,
		"&Gamma;" : 1,
		"&gamma;" : 1,
		"&ge;" : 1,
		"&gt;" : 1,
		"&hArr;" : 1,
		"&harr;" : 1,
		"&hearts;" : 1,
		"&hellip;" : 1,
		"&Iacute;" : 1,
		"&iacute;" : 1,
		"&Icirc;" : 1,
		"&icirc;" : 1,
		"&iexcl;" : 1,
		"&Igrave;" : 1,
		"&igrave;" : 1,
		"&image;" : 1,
		"&infin;" : 1,
		"&int;" : 1,
		"&Iota;" : 1,
		"&iota;" : 1,
		"&iquest;" : 1,
		"&isin;" : 1,
		"&Iuml;" : 1,
		"&iuml;" : 1,
		"&Kappa;" : 1,
		"&kappa;" : 1,
		"&Lambda;" : 1,
		"&lambda;" : 1,
		"&lang;" : 1,
		"&laquo;" : 1,
		"&lArr;" : 1,
		"&larr;" : 1,
		"&lceil;" : 1,
		"&ldquo;" : 1,
		"&le;" : 1,
		"&lfloor;" : 1,
		"&lowast;" : 1,
		"&loz;" : 1,
		"&lrm;" : 1,
		"&lsaquo;" : 1,
		"&lsquo;" : 1,
		"&lt;" : 1,
		"&macr;" : 1,
		"&mdash;" : 1,
		"&micro;" : 1,
		"&middot;" : 1,
		"&minus;" : 1,
		"&Mu;" : 1,
		"&mu;" : 1,
		"&nabla;" : 1,
		"&nbsp;" : 1,
		"&ndash;" : 1,
		"&ne;" : 1,
		"&ni;" : 1,
		"&not;" : 1,
		"&notin;" : 1,
		"&nsub;" : 1,
		"&Ntilde;" : 1,
		"&ntilde;" : 1,
		"&Nu;" : 1,
		"&nu;" : 1,
		"&Oacute;" : 1,
		"&oacute;" : 1,
		"&Ocirc;" : 1,
		"&ocirc;" : 1,
		"&OElig;" : 1,
		"&oelig;" : 1,
		"&Ograve;" : 1,
		"&ograve;" : 1,
		"&oline;" : 1,
		"&Omega;" : 1,
		"&omega;" : 1,
		"&Omicron;" : 1,
		"&omicron;" : 1,
		"&oplus;" : 1,
		"&or;" : 1,
		"&ordf;" : 1,
		"&ordm;" : 1,
		"&Oslash;" : 1,
		"&oslash;" : 1,
		"&Otilde;" : 1,
		"&otilde;" : 1,
		"&otimes;" : 1,
		"&Ouml;" : 1,
		"&ouml;" : 1,
		"&para;" : 1,
		"&part;" : 1,
		"&permil;" : 1,
		"&perp;" : 1,
		"&Phi;" : 1,
		"&phi;" : 1,
		"&Pi;" : 1,
		"&pi;" : 1,
		"&piv;" : 1,
		"&plusmn;" : 1,
		"&pound;" : 1,
		"&Prime;" : 1,
		"&prime;" : 1,
		"&prod;" : 1,
		"&prop;" : 1,
		"&Psi;" : 1,
		"&psi;" : 1,
		"&quot;" : 1,
		"&radic;" : 1,
		"&rang;" : 1,
		"&raquo;" : 1,
		"&rArr;" : 1,
		"&rarr;" : 1,
		"&rceil;" : 1,
		"&rdquo;" : 1,
		"&real;" : 1,
		"&reg;" : 1,
		"&rfloor;" : 1,
		"&Rho;" : 1,
		"&rho;" : 1,
		"&rlm;" : 1,
		"&rsaquo;" : 1,
		"&rsquo;" : 1,
		"&sbquo;" : 1,
		"&Scaron;" : 1,
		"&scaron;" : 1,
		"&sdot;" : 1,
		"&sect;" : 1,
		"&shy;" : 1,
		"&Sigma;" : 1,
		"&sigma;" : 1,
		"&sigmaf;" : 1,
		"&sim;" : 1,
		"&spades;" : 1,
		"&sub;" : 1,
		"&sube;" : 1,
		"&sum;" : 1,
		"&sup;" : 1,
		"&sup1;" : 1,
		"&sup2;" : 1,
		"&sup3;" : 1,
		"&supe;" : 1,
		"&szlig;" : 1,
		"&Tau;" : 1,
		"&tau;" : 1,
		"&there4;" : 1,
		"&Theta;" : 1,
		"&theta;" : 1,
		"&thetasym;" : 1,
		"&thinsp;" : 1,
		"&THORN;" : 1,
		"&thorn;" : 1,
		"&tilde;" : 1,
		"&times;" : 1,
		"&trade;" : 1,
		"&Uacute;" : 1,
		"&uacute;" : 1,
		"&uArr;" : 1,
		"&uarr;" : 1,
		"&Ucirc;" : 1,
		"&ucirc;" : 1,
		"&Ugrave;" : 1,
		"&ugrave;" : 1,
		"&uml;" : 1,
		"&upsih;" : 1,
		"&Upsilon;" : 1,
		"&upsilon;" : 1,
		"&Uuml;" : 1,
		"&uuml;" : 1,
		"&weierp;" : 1,
		"&Xi;" : 1,
		"&xi;" : 1,
		"&Yacute;" : 1,
		"&yacute;" : 1,
		"&yen;" : 1,
		"&Yuml;" : 1,
		"&yuml;" : 1,
		"&Zeta;" : 1,
		"&zeta;" : 1,
		"&zwj;" : 1,
		"&zwnj;" : 1
	};
		var awuiDictionary= {
		'aw2_block' : {
			slug:2,
			get_transient:2,
			set_transient:2,
			set_get_transient:2,
			set_param:2
		},
		'aw2_page' : {
			slug:2,
			get_transient:2,
			set_transient:2,
			set_get_transient:2,
			set_param:2
		},
		'aw2_module' : {
			slug:2,
			get_transient:2,
			set_transient:2,
			set_get_transient:2,
			set_param:2
		},
		'aw2_component' : {
			slug:2,
			get_transient:2,
			set_transient:2,
			set_get_transient:2,
			set_param:2
		},
		'aw2_data' : {
			slug:2,
			get_transient:2,
			set_transient:2,
			set_get_transient:2,
			set_param:2
		},
		'aw2_query' : {
			slug:2,
			get_transient:2,
			set_transient:2,
			set_get_transient:2,
			set_param:2
		},
		'aw2_call_func' : {
			set_param:2,
			p1:2,
			p2:2,
		},
		'aw2_case' :  {
			cond:2,
			equal:2
		},
		'aw2_case_else' : 1,
		'aw2_collection' :  {
			id:2,
			main:{
				'count':1,
				'options':1,
				'yes':1,
				'no':1,
				'stringify':1,
			},
			set_param:1
		},
		'aw2_cookie' :  {
			main:2,
			default:2,
			separator:2,
			set_param:2
		},
		'aw2_debug' : {
			start:2,
			stop:2,
			when:{
				"all":1,
				"request":1
			},
			param:1,
			output:{
				"console":1,
				"log":1,
				"screen":1
				
			},
			conditions:1,
			content:1
		},
		'aw2_delete_post' :  {
			post_id:2,
			force:2
		},
		'aw2_and' :    {
			odd:2,
			even:2,
			empty:2,
			not_empty:2,
			request_exists:2,
			request_not_exists:2,
			param_exists:2,
			param_not_exists:2,
			terms:2,
			cond:2,
			equal:2,
			notequal:2,
			greater:2,
			less:2,
			greaterequal:2,
			lessequal:2,
			true:2,
			false:2,
		},
		'aw2_or' :    {
			odd:2,
			even:2,
			empty:2,
			not_empty:2,
			request_exists:2,
			request_not_exists:2,
			param_exists:2,
			param_not_exists:2,
			terms:2,
			cond:2,
			equal:2,
			notequal:2,
			greater:2,
			less:2,
			greaterequal:2,
			lessequal:2,
			true:2,
			false:2,
		},
		'aw2_else' :    {
			odd:2,
			even:2,
			empty:2,
			not_empty:2,
			request_exists:2,
			request_not_exists:2,
			param_exists:2,
			param_not_exists:2,
			terms:2,
			cond:2,
			equal:2,
			notequal:2,
			greater:2,
			less:2,
			greaterequal:2,
			lessequal:2,
			true:2,
			false:2,
		},
		'aw2_if' :  {
			odd:2,
			even:2,
			empty:2,
			not_empty:2,
			request_exists:2,
			request_not_exists:2,
			param_exists:2,
			param_not_exists:2,
			terms:2,
			cond:2,
			equal:2,
			notequal:2,
			greater:2,
			less:2,
			greaterequal:2,
			lessequal:2,
			true:2,
			false:2,
		},
		'aw2_if_logged_in' :  {
			main:{
				"yes":1,
				"no":1
			},
			role:2
		},
		'aw2_if_part' :2,
		'aw2_if_filter' : 2,
		'aw2_ignore' :2,
		'aw2_include_lib' :  {
			fancybox:2,
			flexslider:2,
			isotope :2,
			jassorslider :2,
			less :2,
			pagination :2,
			spin :2,
			zclip :2,
			bootstrap_table :2,
			bootstrap_select :2,
			bootstrap3_dialog :2,
			content_hover :2,
			enquire :2,
			snippet :2,
			highlight :2,
			typeahead :2,
			match_height :2
		},
		'aw2_insert_post' :  {
			store_new_post_id:2
		},
		'aw2_inner' :  {
			for_shortcode:2
		},
		'aw2_woo_product' :  {
			main:2,
			product_id: 2,
			yes:2,
			no:2
		},
		'aw2_loop' :  {
			id:2
		},
		'aw2_remote' :  {
			url:2
		},
		'aw2_sample_block' :2,
		'aw2_query_backup' :  {
			slug:2
		},
		'aw2_register_post_type' :  {
			post_type:2
		},
		'aw2_query_db' :  {
			id:2,
			main:2,
			found_posts:2,
			paged:2,
			posts_per_page:2
		},
		'aw2_meta_box' :  {
			id:2,
			part:{
				"field":1,
				"main":1
			}
		},
		'aw2_counter' :  {
			main:2
		},
		'aw2_set_seo' :  {
			main:2
		},
		'aw2_seo' :  {
			main:2
		},
		'aw2_custom_query' :  {
			main:2,
			id:2
		},
		'aw2_device' :  {
			main:{
				"mobile":1,
				"tablet":1,
				"desktop":1,
				"mobile_or_tablet":1,
				"desktop_or_tablet":1
			}
		},
		'aw2_loop_item' :  {
			loop_index:2,
			loop_key:2,
			loop_value:2,
			set_param:2,
			odd:2,
			even:2,
			first:2,
			last:2,
			between:2,
			main:2
		},
		'aw2_loop_value' :  {
			main:2,
			id:2,
			cond:2,
			default:2,
			meta:{
				"single":1,
				"array":1
			},
			set_param:2,
			taxonomy:2,
			url:2,
			excerpt:2,
			featured_image:2,
			featured_image_url:2,
			length:2,
			the_content:2,
			post_title:2,
			post_content:2,
			name:2,
			date_format:2,
			words:2,
			separator:2,
			json:2,
			size:{
				"full":1,
				"thumbnail":1,
				"medium":1,
				"large":1,
			},
		},
		'aw2_or' :    {
			odd:2,
			even:2,
			empty:2,
			not_empty:2,
			request_exists:2,
			request_not_exists:2,
			param_exists:2,
			param_not_exists:2,
			terms:2,
			cond:2,
			equal:2,
			notequal:2,
			greater:2,
			less:2,
			greaterequal:2,
			lessequal:2,
			true:2,
			false:2
		},
		'aw2_param' :  {
			main:2,
			default:2,
			separator:2,
			set_param:2
		},
		'aw2_query_post' :  {
			id:2,
			post_type:2,
			post_id:2,
			slug:2,
			post_title:2,
			post_content:2
		},
		'aw2_query_posts' :  {
			id:2,
			run:2,
			param_taxonomy:2,
			request_taxonomy:2,
			part:{
				"main":1,
				"tax_query":1,
				"meta_query":1
			},
			query_type:{
				"get_posts":1,
				"get_pages":1,
				"wp_query":1,
			},
			conditions:1,
			relation:{
				"AND":1,
				"OR":1
			},
		},
		'aw2_util' :  {
			set_param:2,
			attachment_url:2,
			get_term_link:2,
			current_url:2,
			slug:2,
			size:2,
			attachment_id:2,
			taxonomy:2,
			now:2,
			format:2,
			week_number:2,
			token:2,
			term_image_url:2,
			term_taxonomy_id:2
		},
		'aw2_query_parents' :  {
			child_posts_id:2,
			meta_key:2,
			post_type:2,
			id:2,
			main:2,
			set_param:2,
			cond:2,
		},
		'aw2_query_term' :  {
			query_by:2,
			query_value:2,
			taxonomy:2,
			id:2,
			main:2,
			set_param:2,
			cond:2,
		},
		'aw2_delete_term':{
			term_id:2,
			taxonomy:2
		},
		'aw2_query_terms' :  {
			id:2,
			conditions:2,
			main:2,
			set_param:2,
			separator:2
		},
		'aw2_query_user' :  {
			query_by:2,
			query_value:2,
			id:2,
			main:2,
			set_param:2,
			cond:2
		},
		'aw2_query_users' :  {
			id:2
		},
		'aw2_ready_script' :  2,
		'aw2_breadcrumb' :  2,
		'aw2_request' :  {
			main:2,
			"default":2,
			separator:2,
			set_param:2,
			assume_empty:2,
			store:{
				"true":1,
				"false":1
			}
		},
		'aw2_run_shortcode' :  {
			shortcode:2
		},
		'aw2_rewrite_rule' :2,
		'aw2_query_vars' :{
			main:2
		},
		'aw2_save_form_data' :  {
			tag:2,
			set_id_as_param:2,
		},
		'aw2_script' :  2,
		'aw2_session' :  {
			main:2,
			default:2,
			separator:2,
			set_param:2
		},
		'aw2_set_cookie' :  {
			key:2,
			value:2,
			overwrite:{
				"yes":1,
				"no":1,
				"empty":1
			},
			'from_request':1,
			'default':1,
			'content_as_key':1,
			'content_as_array':1,
			'cond':1
		},
		'aw2_set_meta' :  {
			post_id:2
		},
		'aw2_set_param' :  {
			key:2,
			value:2,
			overwrite:{
				"yes":1,
				"no":1,
				"empty":1
			},
			'from_request':1,
			'default':1,
			'content_as_key':1,
			'content_as_array':1,
			'cond':1
		},
		'aw2_set_session' :  {
			key:2,
			value:2,
			overwrite:{
				"yes":1,
				"no":1,
				"empty":1
			},
			'from_request':1,
			'default':1,
			'content_as_key':1,
			'content_as_array':1,
			'cond':1
		},
		'aw2_set_taxonomy' :  {
			post_id:2,
			taxonomy:2,
			terms:2,
			terms_slugs:2,
			append:{
				"true":1,
				"false":1
			},
		},
		'aw2_set_template' :  {
			main:2
		},
		'aw2_style' :2,
		'aw2_switch' :2,
		'aw2_ui' :  {
			slug:2,
			ui_id:2,
			ui_class:2,
		},
		'aw2_use_template' :  {
			main:2,
			noerror:2,
			get_transient:2,
			set_transient:2,
			set_get_transient:2
		},
		'aw2_create_table' :  {
			id:2,
			col:2
		},
		'aw2_create_row' :  {
			id:2,
			row_id:2,
			no_of_rows:2
		},
		'aw2_create_cols' :  {
			id:2,
			cols:2
		},
		'aw2_lipsum' :  {
			amount:2,
			start:2,
			what:2
		},
		'aw2_is' :  {
			main:2
		},
		'aw2_url' :  {
			main:2
		},
		'aw2_i18n' :  {
			main:2
		},
		'aw2_set_hook' :  {
			action:{
				"init":1,
				"wp_footer":1,
				"wp_head":1,
				"redux":1,
				"cmb2_meta_boxes":1
			}
		},
		'aw2_value' :  {
			main:2,
			id:2,
			cond:2,
			default:2,
			set_param:2,
			separator:2,
			post_title:2,
			post_content:2,
			featured_image:2,
			featured_image_url:2,
			author_meta:2,
			display_name :2,
			taxonomy:2,
			term_id:2,
			name:2,
			count:2,
			parent:2,
			term_taxonomy_id:2,
			slug:2,
			meta:{
				"single":1,
				"array":1
			},
		},
		'aw2_browser_action' :  {
			slug:2,
			bind_selector:2,
			group:2,			
			browser_action:{
				"run_aw_block":1,
				"load_more":1,
				"immediate":1,
			},
			when:{
				on_event:1
			},
			bind_event:{
				click:1
			},
			bind_event:{
				click:1
			},
			loader_selector:2,
			disable_selector:2,
			fancybox_loader:2
		},
		'aw2_set_field' : 2,
		'aw2_field' : 2,
		'aw2_local' : 2,
		'aw2_do_shortcode' :  {
			slug:2,
			get_transient:2,
			set_transient:2,
			set_get_transient:2
		},
		'aw2_dump_array' :  {
			main:2
		},
		'aw2_enqueue_script' :  {
			handle:2,
			script:2
		},
		'aw2_external_image_cache' :  {
			url:2,
			extension:2
		},
		'aw2_delete_transient' :2,
		'aw2_theme_options' :  2,
		'aw2_menu' :  2,
		'aw2_wp_mail' :  {
			id:2,
			run:2,
			part:{
				"main":1,
				"message":1
			},
		},
		'aw2_spa' :  {
			lib:2,
			group:2,			
			spa_activity:{
				"core:set_spa_data":1,
				"core:set_history_url":1,
				"core:run_script":1,
				"core:set_document_title":1,
				"core:set_history_url":1,
				"core:run_script":1,
				"core:insert_html":1,
				"core:replace_html":1,
				"core:get_spa_uri":1,
				"core:get_ajax_uri":1,
				"core:get_ajax":1
			},
			when:{
				"on_event":1,
				"immediate":1
			},
			bind_event:{
				"click":1
			},
			bind_selector:2,
			uri:2,
			url:2,
			spinner_lib:2,
			scroll:2,
			slug:2,
			key:2,
			value:2,
			'default':2,
			set_defaults:2,
			disable_selector:2,
			fancybox_loader:2,
			target_selector:2,
			html_selector:2
		}
	};
	
	for (var i = 0; i < html_tags.length; i++) {
		xmlDictionary[html_tags[i]] = commonAttributes(xmlDictionary[html_tags[i]])
	}
	this.html_tags = html_tags;
	this.run = function (editor, session, pos, prefix, callback, forced) {
		var subject;
		var items;
		var container = editor.container;
		var line = session.getLine(pos.row).substr(0, pos.column);
		//var openSites = shiftedit.app.tabs.openSites;
		//var tabs = Ext.getCmp("tabs");
		var wordpress = false;
		var siteDefiniitions = {};
		var className = "";
		
		wordpress = true

		var prevRow = pos.row > 0 ? pos.row - 1 : 0;
		var state = session.getState(prevRow, pos.column);
		var mode = session.getMode();
		var tokenizer = mode.getTokenizer();
		var data = tokenizer.getLineTokens(line, state, pos.row);
		var tokenState = typeof data.state == "object" ? data.state[0] : data.state;
		var lang = session.$modeId.replace("ace/mode/", "");
		lang = (tokenState.match(/(php|js|css|awui|awspa)\-/i) || ["", lang])[1].toLowerCase();
		
		var php_functions = {};
		var awui_functions = {};
		var js_functions = {};
		var css_classes = {};
		var dom_ids = {};
		var php_vars = {};
		var php_classes = {};
		
		var obj = container;
		var curleft = 0;
		var curtop = 0;
		if (container.offsetParent) {
			do {
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop
			} while (obj = obj.offsetParent)
		}
		var TokenIterator = ace.require("ace/token_iterator").TokenIterator;
		var iterator = new TokenIterator(session, pos.row, pos.column);
		var token = iterator.getCurrentToken();
		var type;
		if (token) {
			type = token.type
		}
		var tagName = "";
		definitions = (new getDefinitionRanges(editor)).definitions;
		//console.log('definitions:');
		//console.log(definitions);
		if (definitions.css)
		{
			css_classes = merge(css_classes, definitions.css.classes);
			dom_ids = merge(dom_ids, definitions.css.ids)
		}	
		if (definitions.js)
			js_functions = merge(js_functions, definitions.js.functions)
		
		
		//console.log('lang:'+lang);
		//console.log('token state:'+tokenState);
		//console.log('token type: '+token.type);
		
		//depending on context populate item list and return the options
		if ( lang === "awui") {
			while (token) {
				if (token.type.indexOf("tag-name") !== -1) {
					tagName = token.value;
					break
				}
				token = iterator.stepBackward()
			}
			if (tagName) {
				//console.log("Tag: " + tagName)
			}
		}
		//items=awuiDictionary;
		if( lang === "css" ) {
			if(tokenState === "css-start") {
				if(type==="variable" && (/(\..*)$/i.test(line))){
					subject = "css_class";
					// token state:css-start  token type: variable
					items = css_classes
				} else if(type==="string" && (/(:.*)$/i.test(line))) {
					subject = "css_pseudo_class";
					//token type: string
					items = cssPseudoClasses
				} else if(type==="keyword" && (/(#.*)$/i.test(line))) {
					subject = "css_id";
					//token type: keyword
					items = dom_ids
				} else if(type==="constant" ) {
					subject = "css_tags";
					//token type: constant
					//console.log('list of tags');
				}
			}
			else if(tokenState === "css-ruleset"){
				if (/:[^;]+$/.test(line)) {
					subject = "css_attribute_value";
					/([\w\-]+):[^:]*$/.test(line);
					var CSSAttribute = RegExp.$1;
					items = cssDictionary[CSSAttribute]
				} else {
					subject = "css_attribute_name";
					items = cssDictionary
				}
			}
			
			//token state:css-ruleset
			//token type: text
		}
		
		if( lang === "js" || lang === "awspa" )
		{
			//&& tokenState === "js-start" 
			if ((/\$\([^)]+\).(\w*)$/i.test(line))||(/\jQuery\([^)]+\).(\w*)$/i.test(line))) {
				subject = "jquery";
				items = jqueryDictionary
			}else if ((lang === "js" || lang === "awspa")&& type == "string") {
				if (/(\..*)$/i.test(line)) {
					subject = "js_class";
					items = css_classes
				}
				if (/(#.*)$/i.test(line)) {
					subject = "css_id";
					items = dom_ids
				}
			} else if (/([A-z]*)\.([A-z]*)$/i.test(line)) {
				subject = "js_property";
				if (jsDictionary[RegExp.$1]) {
					items = jsDictionary[RegExp.$1]
				} else {
					items = merge(jsDictionary.String, jsDictionary.Array);
					items = merge(items, jsDictionary.Number)
				}
			}
			//console.log('subject:'+subject);
		}
		
		if( lang === "awui" )
		{
			if(tokenState === "start") {
				items=awuiDictionary;
				/*
				{
						"json":"this is fundata",					}

				token state:start  text.awui
				*/			
				// &nbsp; // token state:start   token type: text.awui
				if (/&[A-z]*$/i.test(line)) {
					subject = "html_entity";
					items = entityDictionary
				}
			} else if(tokenState === "meta.tag.punctuation.tag-open.awui4" || tokenState === "meta.tag.punctuation.tag-open.awui" ) {
				if(type ==='entity.other.attribute-name.awui')
				{
					subject = "awui_attribute_name";
					items = awuiDictionary['aw'+tagName]
					//console.log(items);
				}
				else if(type=== "string.attribute-value.awui" && /([\w]+)="([^"]+\s)?([^"]*)$/i.test(line)){
					subject = "awui_attribute_value";
					attribute = RegExp.$1;
					//console.log("attribute "+attribute );
					if(awuiDictionary.hasOwnProperty('aw'+tagName)) {
						if (awuiDictionary['aw'+tagName].hasOwnProperty(attribute)) {
							items = awuiDictionary['aw'+tagName][attribute]
						}
					}	
				}
			} else if(tokenState === "meta.tag.punctuation.tag-open.xml" ) {
				if(type ==='meta.tag.tag-name.xml' && (/<(\w*)$/i.test(line)))
				{
					subject = "html_tag";
					items = xmlDictionary
				}else if (type ==='entity.other.attribute-name.awui'  && /\s([\w]*)$/i.test(line)) {
					subject = "html_attribute_name";
					items = xmlDictionary[tagName]
				}
			} else if(tokenState === "string.attribute-value.awui0" ) {
					if (type=== "string.attribute-value.awui" && /([\w]+)="([^"]+\s)?([^"]*)$/i.test(line)) {
						subject = "html_attribute_value";
						attribute = RegExp.$1;
						if (xmlDictionary.hasOwnProperty(tagName)) {
							xmlDictionary[tagName].class = css_classes;
							xmlDictionary[tagName].id = dom_ids;
							if (xmlDictionary[tagName].hasOwnProperty(attribute)) {
								items = xmlDictionary[tagName][attribute]
							}
							//console.log(items);
						}
						else if(awuiDictionary.hasOwnProperty('aw'+tagName)) {
							if (awuiDictionary['aw'+tagName].hasOwnProperty(attribute)) {
								items = awuiDictionary['aw'+tagName][attribute]
							}
							//console.log(items);
						}
					}
			}
			//console.log("subject :"+subject);
			//[aw2_debug start
			//token state:meta.tag.punctuation.tag-open.awui3 && token type: entity.other.attribute-name.awui
				//[aw2_debug meta='single'
				//token type: string.attribute-value.awui
			
			//<div>
			//token state:meta.tag.punctuation.tag-open.xml  token type: meta.tag.tag-name.xml
				//<div class>
				//token type: entity.other.attribute-name.awui
				
			//class="ting"
			// token state:string.attribute-value.awui0 	token type: string.attribute-value.awui	
			
			//console.log('subject: '+subject);
		}
		
		
		//now we have items let's build options
		
		var options = [];
		var caption;
		var value;
		var snippet;
		var doc = "";
		
		
		
		for (i in items) {
			caption = i;
			value = i;
			snippet = null;
			if (subject === "html_entity") {
				value = value.substr(1)
			}
			
			doc = "";
			if (typeof items[i] === "object" && items[i][1]) {
				doc = items[i][1]
				
				//console.log('doc: '+doc);
			}
			
			switch (subject) {
				case "html_attribute_name":
					snippet = value + '="$0"';
					break;
				case "css_attribute_name":
					snippet = value + ": ";
					break
			}
			
			options.push({
				caption : caption,
				snippet : snippet,
				value : value,
				meta : subject,
				doc : doc
			})
		}
		return options
	}
};