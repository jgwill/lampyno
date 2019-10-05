!function(e){var n=!1;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var o=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=o,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var o=arguments[e];for(var t in o)n[t]=o[t]}return n}return function n(o){function t(n,r,i){var c;if("undefined"!=typeof document){if(arguments.length>1){if("number"==typeof(i=e({path:"/"},t.defaults,i)).expires){var a=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*i.expires),i.expires=a}i.expires=i.expires?i.expires.toUTCString():"";try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(e){}r=o.write?o.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=(n=(n=encodeURIComponent(String(n))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape);var s="";for(var f in i)i[f]&&(s+="; "+f,!0!==i[f]&&(s+="="+i[f]));return document.cookie=n+"="+r+s}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var l=p[u].split("="),C=l.slice(1).join("=");this.json||'"'!==C.charAt(0)||(C=C.slice(1,-1));try{var g=l[0].replace(d,decodeURIComponent);if(C=o.read?o.read(C,g):o(C,g)||C.replace(d,decodeURIComponent),this.json)try{C=JSON.parse(C)}catch(e){}if(n===g){c=C;break}n||(c[g]=C)}catch(e){}}return c}}return t.set=t,t.get=function(e){return t.call(t,e)},t.getJSON=function(){return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(n,o){t(n,"",e(o,{expires:-1}))},t.withConverter=n,t}(function(){})});
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/y4kaxcqu';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();

(function($){
  window.mvCreateIntercom = {
    loaded: 'loading'
  }
  
  window.mvCreateIntercom.init = function() {
    if (window.mvCreateIntercom.loaded === 'loaded') {
      return
    }
    var auth = window.mvcreate_intercom.access_token
    var identity = Cookies.get('mvi_identity_v2');
  
    if (identity) {
      Intercom('boot', {
        app_id: 'y4kaxcqu',
        email: window.mvcreate_intercom.email,
        user_hash: identity,
        "create_registered": true,
      });
      return;
    }
    if (auth) {
      auth = 'bearer ' + auth;
      $.ajax({
        type: 'GET',
        beforeSend: function(request) {
          request.setRequestHeader('Authorization', auth);
        },
        url: 'https://publisher-identity.mediavine.com/api/v1/auth/intercom',
        processData: false,
        success: function(msg) {
          Intercom('boot', {
            app_id: 'y4kaxcqu',
            email: window.mvcreate_intercom.email,
            user_hash: msg.data.hash,
            "create_registered": true,
          });
          Cookies.set('mvi_identity_v2', msg.data.hash)
          window.mvCreateIntercom.loaded = 'loaded'
        },
        error: function() {
          Intercom('boot', {
            app_id: "y4kaxcqu",
            email: window.mvcreate_intercom.email,
          })
          window.mvCreateIntercom.loaded = 'loaded'
        }
      });
    }
  }
  
})(jQuery)
