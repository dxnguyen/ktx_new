try{/* @preserve
 * Leaflet 1.7.1+master.80b2685, a JS library for interactive maps. http://leafletjs.com
 * (c) 2010-2021 Vladimir Agafonkin, (c) 2010-2011 CloudMade
 */
!function(t,i){"object"==typeof exports&&"undefined"!=typeof module?i(exports):"function"==typeof define&&define.amd?define(["exports"],i):i((t="undefined"!=typeof globalThis?globalThis:t||self).L={})}(this,function(t){"use strict";function u(t){for(var i,e,n=1,o=arguments.length;n<o;n++)for(i in e=arguments[n])t[i]=e[i];return t}var s=Object.create||function(t){return i.prototype=t,new i};function i(){}function a(t,i){var e=Array.prototype.slice;if(t.bind)return t.bind.apply(t,e.call(arguments,1));var n=e.call(arguments,2);return function(){return t.apply(i,n.length?n.concat(e.call(arguments)):arguments)}}var e=0;function h(t){return"_leaflet_id"in t||(t._leaflet_id=++e),t._leaflet_id}function n(t,i,e){var n,o,s=function(){n=!1,o&&(r.apply(e,o),o=!1)},r=function(){n?o=arguments:(t.apply(e,arguments),setTimeout(s,i),n=!0)};return r}function o(t,i,e){var n=i[1],o=i[0],i=n-o;return t===n&&e?t:((t-o)%i+i)%i+o}function l(){return!1}function r(t,i){if(!1===i)return t;i=Math.pow(10,void 0===i?6:i);return Math.round(t*i)/i}function c(t){return t.trim?t.trim():t.replace(/^\s+|\s+$/g,"")}function _(t){return c(t).split(/\s+/)}function d(t,i){for(var e in Object.prototype.hasOwnProperty.call(t,"options")||(t.options=t.options?s(t.options):{}),i)t.options[e]=i[e];return t.options}function p(t,i,e){var n,o=[];for(n in t)o.push(encodeURIComponent(e?n.toUpperCase():n)+"="+encodeURIComponent(t[n]));return(i&&-1!==i.indexOf("?")?"&":"?")+o.join("&")}var m=/\{ *([\w_ -]+) *\}/g;function f(t,e){return t.replace(m,function(t,i){i=e[i];if(void 0===i)throw new Error("No value provided for variable "+t);return i="function"==typeof i?i(e):i})}var g=Array.isArray||function(t){return"[object Array]"===Object.prototype.toString.call(t)};function v(t,i){for(var e=0;e<t.length;e++)if(t[e]===i)return e;return-1}var y="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";function x(t){return window["webkit"+t]||window["moz"+t]||window["ms"+t]}var w=0;function P(t){var i=+new Date,e=Math.max(0,16-(i-w));return w=i+e,window.setTimeout(t,e)}var b=window.requestAnimationFrame||x("RequestAnimationFrame")||P,T=window.cancelAnimationFrame||x("CancelAnimationFrame")||x("CancelRequestAnimationFrame")||function(t){window.clearTimeout(t)};function z(t,i,e){if(!e||b!==P)return b.call(window,a(t,i));t.call(i)}function M(t){t&&T.call(window,t)}var C={__proto__:null,extend:u,create:s,bind:a,get lastId(){return e},stamp:h,throttle:n,wrapNum:o,falseFn:l,formatNum:r,trim:c,splitWords:_,setOptions:d,getParamString:p,template:f,isArray:g,indexOf:v,emptyImageUrl:y,requestFn:b,cancelFn:T,requestAnimFrame:z,cancelAnimFrame:M};function Z(){}Z.extend=function(t){function i(){d(this),this.initialize&&this.initialize.apply(this,arguments),this.callInitHooks()}var e,n=i.__super__=this.prototype,o=s(n);for(e in(o.constructor=i).prototype=o,this)Object.prototype.hasOwnProperty.call(this,e)&&"prototype"!==e&&"__super__"!==e&&(i[e]=this[e]);return t.statics&&u(i,t.statics),t.includes&&(function(t){if("undefined"!=typeof L&&L&&L.Mixin){t=g(t)?t:[t];for(var i=0;i<t.length;i++)t[i]===L.Mixin.Events&&console.warn("Deprecated include of L.Mixin.Events: this property will be removed in future releases, please inherit from L.Evented instead.",(new Error).stack)}}(t.includes),u.apply(null,[o].concat(t.includes))),u(o,t),delete o.statics,delete o.includes,o.options&&(o.options=n.options?s(n.options):{},u(o.options,t.options)),o._initHooks=[],o.callInitHooks=function(){if(!this._initHooksCalled){n.callInitHooks&&n.callInitHooks.call(this),this._initHooksCalled=!0;for(var t=0,i=o._initHooks.length;t<i;t++)o._initHooks[t].call(this)}},i},Z.include=function(t){var i=this.prototype.options;return u(this.prototype,t),t.options&&(this.prototype.options=i,this.mergeOptions(t.options)),this},Z.mergeOptions=function(t){return u(this.prototype.options,t),this},Z.addInitHook=function(t){var i=Array.prototype.slice.call(arguments,1),e="function"==typeof t?t:function(){this[t].apply(this,i)};return this.prototype._initHooks=this.prototype._initHooks||[],this.prototype._initHooks.push(e),this};var S={on:function(t,i,e){if("object"==typeof t)for(var n in t)this._on(n,t[n],i);else for(var o=0,s=(t=_(t)).length;o<s;o++)this._on(t[o],i,e);return this},off:function(t,i,e){if(arguments.length)if("object"==typeof t)for(var n in t)this._off(n,t[n],i);else{t=_(t);for(var o=1===arguments.length,s=0,r=t.length;s<r;s++)o?this._off(t[s]):this._off(t[s],i,e)}else delete this._events;return this},_on:function(t,i,e){if("function"==typeof i){this._events=this._events||{};var n=this._events[t];n||(this._events[t]=n=[]);for(var t={fn:i,ctx:e=e===this?void 0:e},o=n,s=0,r=o.length;s<r;s++)if(o[s].fn===i&&o[s].ctx===e)return;o.push(t)}else console.warn("wrong listener type: "+typeof i)},_off:function(t,i,e){var n,o,s;if(this._events&&(n=this._events[t]))if(1!==arguments.length)if(e===this&&(e=void 0),"function"==typeof i){for(o=0,s=n.length;o<s;o++){var r=n[o];if(r.ctx===e&&r.fn===i)return this._firingCount&&(r.fn=l,this._events[t]=n=n.slice()),void n.splice(o,1)}console.warn("listener not found")}else console.warn("wrong listener type: "+typeof i);else{if(this._firingCount)for(o=0,s=n.length;o<s;o++)n[o].fn=l;delete this._events[t]}},fire:function(t,i,e){if(!this.listens(t,e))return this;var n=u({},i,{type:t,target:this,sourceTarget:i&&i.sourceTarget||this});if(this._events){var o=this._events[t];if(o){this._firingCount=this._firingCount+1||1;for(var s=0,r=o.length;s<r;s++){var a=o[s];a.fn.call(a.ctx||this,n)}this._firingCount--}}return e&&this._propagateEvent(n),this},listens:function(t,i){"string"!=typeof t&&console.warn('"string" type argument expected');var e=this._events&&this._events[t];if(e&&e.length)return!0;if(i)for(var n in this._eventParents)if(this._eventParents[n].listens(t,i))return!0;return!1},once:function(t,i,e){if("object"==typeof t){for(var n in t)this.once(n,t[n],i);return this}var o=a(function(){this.off(t,i,e).off(t,o,e)},this);return this.on(t,i,e).on(t,o,e)},addEventParent:function(t){return this._eventParents=this._eventParents||{},this._eventParents[h(t)]=t,this},removeEventParent:function(t){return this._eventParents&&delete this._eventParents[h(t)],this},_propagateEvent:function(t){for(var i in this._eventParents)this._eventParents[i].fire(t.type,u({layer:t.target,propagatedFrom:t.target},t),!0)}};S.addEventListener=S.on,S.removeEventListener=S.clearAllEventListeners=S.off,S.addOneTimeEventListener=S.once,S.fireEvent=S.fire,S.hasEventListeners=S.listens;var k=Z.extend(S);function E(t,i,e){this.x=e?Math.round(t):t,this.y=e?Math.round(i):i}var B=Math.trunc||function(t){return 0<t?Math.floor(t):Math.ceil(t)};function A(t,i,e){return t instanceof E?t:g(t)?new E(t[0],t[1]):null==t?t:"object"==typeof t&&"x"in t&&"y"in t?new E(t.x,t.y):new E(t,i,e)}function I(t,i){if(t)for(var e=i?[t,i]:t,n=0,o=e.length;n<o;n++)this.extend(e[n])}function O(t,i){return!t||t instanceof I?t:new I(t,i)}function R(t,i){if(t)for(var e=i?[t,i]:t,n=0,o=e.length;n<o;n++)this.extend(e[n])}function N(t,i){return t instanceof R?t:new R(t,i)}function D(t,i,e){if(isNaN(t)||isNaN(i))throw new Error("Invalid LatLng object: ("+t+", "+i+")");this.lat=+t,this.lng=+i,void 0!==e&&(this.alt=+e)}function j(t,i,e){return t instanceof D?t:g(t)&&"object"!=typeof t[0]?3===t.length?new D(t[0],t[1],t[2]):2===t.length?new D(t[0],t[1]):null:null==t?t:"object"==typeof t&&"lat"in t?new D(t.lat,"lng"in t?t.lng:t.lon,t.alt):void 0===i?null:new D(t,i,e)}E.prototype={clone:function(){return new E(this.x,this.y)},add:function(t){return this.clone()._add(A(t))},_add:function(t){return this.x+=t.x,this.y+=t.y,this},subtract:function(t){return this.clone()._subtract(A(t))},_subtract:function(t){return this.x-=t.x,this.y-=t.y,this},divideBy:function(t){return this.clone()._divideBy(t)},_divideBy:function(t){return this.x/=t,this.y/=t,this},multiplyBy:function(t){return this.clone()._multiplyBy(t)},_multiplyBy:function(t){return this.x*=t,this.y*=t,this},scaleBy:function(t){return new E(this.x*t.x,this.y*t.y)},unscaleBy:function(t){return new E(this.x/t.x,this.y/t.y)},round:function(){return this.clone()._round()},_round:function(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this},floor:function(){return this.clone()._floor()},_floor:function(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this},ceil:function(){return this.clone()._ceil()},_ceil:function(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this},trunc:function(){return this.clone()._trunc()},_trunc:function(){return this.x=B(this.x),this.y=B(this.y),this},distanceTo:function(t){var i=(t=A(t)).x-this.x,t=t.y-this.y;return Math.sqrt(i*i+t*t)},equals:function(t){return(t=A(t)).x===this.x&&t.y===this.y},contains:function(t){return t=A(t),Math.abs(t.x)<=Math.abs(this.x)&&Math.abs(t.y)<=Math.abs(this.y)},toString:function(){return"Point("+r(this.x)+", "+r(this.y)+")"}},I.prototype={extend:function(t){return t=A(t),this.min||this.max?(this.min.x=Math.min(t.x,this.min.x),this.max.x=Math.max(t.x,this.max.x),this.min.y=Math.min(t.y,this.min.y),this.max.y=Math.max(t.y,this.max.y)):(this.min=t.clone(),this.max=t.clone()),this},getCenter:function(t){return new E((this.min.x+this.max.x)/2,(this.min.y+this.max.y)/2,t)},getBottomLeft:function(){return new E(this.min.x,this.max.y)},getTopRight:function(){return new E(this.max.x,this.min.y)},getTopLeft:function(){return this.min},getBottomRight:function(){return this.max},getSize:function(){return this.max.subtract(this.min)},contains:function(t){var i,e;return(t=("number"==typeof t[0]||t instanceof E?A:O)(t))instanceof I?(i=t.min,e=t.max):i=e=t,i.x>=this.min.x&&e.x<=this.max.x&&i.y>=this.min.y&&e.y<=this.max.y},intersects:function(t){t=O(t);var i=this.min,e=this.max,n=t.min,o=t.max,t=o.x>=i.x&&n.x<=e.x,e=o.y>=i.y&&n.y<=e.y;return t&&e},overlaps:function(t){t=O(t);var i=this.min,e=this.max,n=t.min,o=t.max,t=o.x>i.x&&n.x<e.x,e=o.y>i.y&&n.y<e.y;return t&&e},isValid:function(){return!(!this.min||!this.max)}},R.prototype={extend:function(t){var i,e,n=this._southWest,o=this._northEast;if(t instanceof D)e=i=t;else{if(!(t instanceof R))return t?this.extend(j(t)||N(t)):this;if(i=t._southWest,e=t._northEast,!i||!e)return this}return n||o?(n.lat=Math.min(i.lat,n.lat),n.lng=Math.min(i.lng,n.lng),o.lat=Math.max(e.lat,o.lat),o.lng=Math.max(e.lng,o.lng)):(this._southWest=new D(i.lat,i.lng),this._northEast=new D(e.lat,e.lng)),this},pad:function(t){var i=this._southWest,e=this._northEast,n=Math.abs(i.lat-e.lat)*t,t=Math.abs(i.lng-e.lng)*t;return new R(new D(i.lat-n,i.lng-t),new D(e.lat+n,e.lng+t))},getCenter:function(){return new D((this._southWest.lat+this._northEast.lat)/2,(this._southWest.lng+this._northEast.lng)/2)},getSouthWest:function(){return this._southWest},getNorthEast:function(){return this._northEast},getNorthWest:function(){return new D(this.getNorth(),this.getWest())},getSouthEast:function(){return new D(this.getSouth(),this.getEast())},getWest:function(){return this._southWest.lng},getSouth:function(){return this._southWest.lat},getEast:function(){return this._northEast.lng},getNorth:function(){return this._northEast.lat},contains:function(t){t=("number"==typeof t[0]||t instanceof D||"lat"in t?j:N)(t);var i,e,n=this._southWest,o=this._northEast;return t instanceof R?(i=t.getSouthWest(),e=t.getNorthEast()):i=e=t,i.lat>=n.lat&&e.lat<=o.lat&&i.lng>=n.lng&&e.lng<=o.lng},intersects:function(t){t=N(t);var i=this._southWest,e=this._northEast,n=t.getSouthWest(),o=t.getNorthEast(),t=o.lat>=i.lat&&n.lat<=e.lat,e=o.lng>=i.lng&&n.lng<=e.lng;return t&&e},overlaps:function(t){t=N(t);var i=this._southWest,e=this._northEast,n=t.getSouthWest(),o=t.getNorthEast(),t=o.lat>i.lat&&n.lat<e.lat,e=o.lng>i.lng&&n.lng<e.lng;return t&&e},toBBoxString:function(){return[this.getWest(),this.getSouth(),this.getEast(),this.getNorth()].join(",")},equals:function(t,i){return!!t&&(t=N(t),this._southWest.equals(t.getSouthWest(),i)&&this._northEast.equals(t.getNorthEast(),i))},isValid:function(){return!(!this._southWest||!this._northEast)}};var H={latLngToPoint:function(t,i){t=this.projection.project(t),i=this.scale(i);return this.transformation._transform(t,i)},pointToLatLng:function(t,i){i=this.scale(i),i=this.transformation.untransform(t,i);return this.projection.unproject(i)},project:function(t){return this.projection.project(t)},unproject:function(t){return this.projection.unproject(t)},scale:function(t){return 256*Math.pow(2,t)},zoom:function(t){return Math.log(t/256)/Math.LN2},getProjectedBounds:function(t){if(this.infinite)return null;var i=this.projection.bounds,t=this.scale(t);return new I(this.transformation.transform(i.min,t),this.transformation.transform(i.max,t))},infinite:!(D.prototype={equals:function(t,i){return!!t&&(t=j(t),Math.max(Math.abs(this.lat-t.lat),Math.abs(this.lng-t.lng))<=(void 0===i?1e-9:i))},toString:function(t){return"LatLng("+r(this.lat,t)+", "+r(this.lng,t)+")"},distanceTo:function(t){return W.distance(this,j(t))},wrap:function(){return W.wrapLatLng(this)},toBounds:function(t){var i=180*t/40075017,t=i/Math.cos(Math.PI/180*this.lat);return N([this.lat-i,this.lng-t],[this.lat+i,this.lng+t])},clone:function(){return new D(this.lat,this.lng,this.alt)}}),wrapLatLng:function(t){var i=this.wrapLng?o(t.lng,this.wrapLng,!0):t.lng;return new D(this.wrapLat?o(t.lat,this.wrapLat,!0):t.lat,i,t.alt)},wrapLatLngBounds:function(t){var i=t.getCenter(),e=this.wrapLatLng(i),n=i.lat-e.lat,i=i.lng-e.lng;if(0==n&&0==i)return t;e=t.getSouthWest(),t=t.getNorthEast();return new R(new D(e.lat-n,e.lng-i),new D(t.lat-n,t.lng-i))}},W=u({},H,{wrapLng:[-180,180],R:6371e3,distance:function(t,i){var e=Math.PI/180,n=t.lat*e,o=i.lat*e,s=Math.sin((i.lat-t.lat)*e/2),e=Math.sin((i.lng-t.lng)*e/2),e=s*s+Math.cos(n)*Math.cos(o)*e*e,e=2*Math.atan2(Math.sqrt(e),Math.sqrt(1-e));return this.R*e}}),F=6378137,U={R:F,MAX_LATITUDE:85.0511287798,project:function(t){var i=Math.PI/180,e=this.MAX_LATITUDE,e=Math.max(Math.min(e,t.lat),-e),e=Math.sin(e*i);return new E(this.R*t.lng*i,this.R*Math.log((1+e)/(1-e))/2)},unproject:function(t){var i=180/Math.PI;return new D((2*Math.atan(Math.exp(t.y/this.R))-Math.PI/2)*i,t.x*i/this.R)},bounds:new I([-(Tt=F*Math.PI),-Tt],[Tt,Tt])};function V(t,i,e,n){if(g(t))return this._a=t[0],this._b=t[1],this._c=t[2],void(this._d=t[3]);this._a=t,this._b=i,this._c=e,this._d=n}function q(t,i,e,n){return new V(t,i,e,n)}V.prototype={transform:function(t,i){return this._transform(t.clone(),i)},_transform:function(t,i){return t.x=(i=i||1)*(this._a*t.x+this._b),t.y=i*(this._c*t.y+this._d),t},untransform:function(t,i){return new E((t.x/(i=i||1)-this._b)/this._a,(t.y/i-this._d)/this._c)}};var G=u({},W,{code:"EPSG:3857",projection:U,transformation:q(zt=.5/(Math.PI*U.R),.5,-zt,.5)}),K=u({},G,{code:"EPSG:900913"});function Y(t){return document.createElementNS("http://www.w3.org/2000/svg",t)}function X(t,i){for(var e,n,o,s,r="",a=0,h=t.length;a<h;a++){for(e=0,n=(o=t[a]).length;e<n;e++)r+=(e?"L":"M")+(s=o[e]).x+" "+s.y;r+=i?Ct.svg?"z":"x":""}return r||"M0 0"}var J=document.documentElement.style,$="ActiveXObject"in window,Q=$&&!document.addEventListener,tt="msLaunchUri"in navigator&&!("documentMode"in document),it=Mt("webkit"),et=Mt("android"),nt=Mt("android 2")||Mt("android 3"),ot=parseInt(/WebKit\/([0-9]+)|$/.exec(navigator.userAgent)[1],10),st=et&&Mt("Google")&&ot<537&&!("AudioNode"in window),rt=!!window.opera,at=!tt&&Mt("chrome"),ht=Mt("gecko")&&!it&&!rt&&!$,ut=!at&&Mt("safari"),lt=Mt("phantom"),ct="OTransition"in J,_t=0===navigator.platform.indexOf("Win"),dt=$&&"transition"in J,pt="WebKitCSSMatrix"in window&&"m11"in new window.WebKitCSSMatrix&&!nt,mt="MozPerspective"in J,ft=!window.L_DISABLE_3D&&(dt||pt||mt)&&!ct&&!lt,gt="undefined"!=typeof orientation||Mt("mobile"),vt=gt&&it,yt=gt&&pt,xt=!window.PointerEvent&&window.MSPointerEvent,wt=!(!window.PointerEvent&&!xt),Pt="ontouchstart"in window||!!window.TouchEvent,bt=!window.L_NO_TOUCH&&(Pt||wt),Lt=gt&&rt,F=gt&&ht,Tt=1<(window.devicePixelRatio||window.screen.deviceXDPI/window.screen.logicalXDPI),zt=function(){var t=!1;try{var i=Object.defineProperty({},"passive",{get:function(){t=!0}});window.addEventListener("testPassiveEventSupport",l,i),window.removeEventListener("testPassiveEventSupport",l,i)}catch(t){}return t}(),ot=!!document.createElement("canvas").getContext,J=!(!document.createElementNS||!Y("svg").createSVGRect);function Mt(t){return 0<=navigator.userAgent.toLowerCase().indexOf(t)}var Ct={ie:$,ielt9:Q,edge:tt,webkit:it,android:et,android23:nt,androidStock:st,opera:rt,chrome:at,gecko:ht,safari:ut,phantom:lt,opera12:ct,win:_t,ie3d:dt,webkit3d:pt,gecko3d:mt,any3d:ft,mobile:gt,mobileWebkit:vt,mobileWebkit3d:yt,msPointer:xt,pointer:wt,touch:bt,touchNative:Pt,mobileOpera:Lt,mobileGecko:F,retina:Tt,passiveEvents:zt,canvas:ot,svg:J,vml:!J&&function(){try{var t=document.createElement("div");t.innerHTML='<v:shape adj="1"/>';var i=t.firstChild;return i.style.behavior="url(#default#VML)",i&&"object"==typeof i.adj}catch(t){return!1}}()},Zt=Ct.msPointer?"MSPointerDown":"pointerdown",St=Ct.msPointer?"MSPointerMove":"pointermove",kt=Ct.msPointer?"MSPointerUp":"pointerup",Et=Ct.msPointer?"MSPointerCancel":"pointercancel",Bt={touchstart:Zt,touchmove:St,touchend:kt,touchcancel:Et},At={touchstart:function(t,i){i.MSPOINTER_TYPE_TOUCH&&i.pointerType===i.MSPOINTER_TYPE_TOUCH&&Ei(i);Ht(t,i)},touchmove:Ht,touchend:Ht,touchcancel:Ht},It={},Ot=!1;function Rt(t,i,e){return"touchstart"===i&&(Ot||(document.addEventListener(Zt,Nt,!0),document.addEventListener(St,Dt,!0),document.addEventListener(kt,jt,!0),document.addEventListener(Et,jt,!0),Ot=!0)),At[i]?(e=At[i].bind(this,e),t.addEventListener(Bt[i],e,!1),e):(console.warn("wrong event specified:",i),L.Util.falseFn)}function Nt(t){It[t.pointerId]=t}function Dt(t){It[t.pointerId]&&(It[t.pointerId]=t)}function jt(t){delete It[t.pointerId]}function Ht(t,i){if(i.pointerType!==(i.MSPOINTER_TYPE_MOUSE||"mouse")){for(var e in i.touches=[],It)i.touches.push(It[e]);i.changedTouches=[i],t(i)}}var Wt=200;function Ft(t,e){t.addEventListener("dblclick",e);var n,o=0;function i(t){var i;1===t.detail?"mouse"===t.pointerType||t.sourceCapabilities&&!t.sourceCapabilities.firesTouchEvents||((i=Date.now())-o<=Wt?2===++n&&e(function(t){var i,e,n={};for(e in t)i=t[e],n[e]=i&&i.bind?i.bind(t):i;return(t=n).type="dblclick",n.detail=2,n.isTrusted=!1,n._simulated=!0,n}(t)):n=1,o=i):n=t.detail}return t.addEventListener("click",i),{dblclick:e,simDblclick:i}}var Ut,Vt,qt,Gt,Kt,Yt,Xt=_i(["transform","webkitTransform","OTransform","MozTransform","msTransform"]),Jt=_i(["webkitTransition","transition","OTransition","MozTransition","msTransition"]),$t="webkitTransition"===Jt||"OTransition"===Jt?Jt+"End":"transitionend";function Qt(t){return"string"==typeof t?document.getElementById(t):t}function ti(t,i){var e=t.style[i]||t.currentStyle&&t.currentStyle[i];return"auto"===(e=(!e||"auto"===e)&&document.defaultView?(t=document.defaultView.getComputedStyle(t,null))?t[i]:null:e)?null:e}function ii(t,i,e){t=document.createElement(t);return t.className=i||"",e&&e.appendChild(t),t}function ei(t){var i=t.parentNode;i&&i.removeChild(t)}function ni(t){for(;t.firstChild;)t.removeChild(t.firstChild)}function oi(t){var i=t.parentNode;i&&i.lastChild!==t&&i.appendChild(t)}function si(t){var i=t.parentNode;i&&i.firstChild!==t&&i.insertBefore(t,i.firstChild)}function ri(t,i){if(void 0!==t.classList)return t.classList.contains(i);t=li(t);return 0<t.length&&new RegExp("(^|\\s)"+i+"(\\s|$)").test(t)}function ai(t,i){var e;if(void 0!==t.classList)for(var n=_(i),o=0,s=n.length;o<s;o++)t.classList.add(n[o]);else ri(t,i)||ui(t,((e=li(t))?e+" ":"")+i)}function hi(t,i){void 0!==t.classList?t.classList.remove(i):ui(t,c((" "+li(t)+" ").replace(" "+i+" "," ")))}function ui(t,i){void 0===t.className.baseVal?t.className=i:t.className.baseVal=i}function li(t){return void 0===(t=t.correspondingElement?t.correspondingElement:t).className.baseVal?t.className:t.className.baseVal}function ci(t,i){"opacity"in t.style?t.style.opacity=i:"filter"in t.style&&function(t,i){var e=!1,n="DXImageTransform.Microsoft.Alpha";try{e=t.filters.item(n)}catch(t){if(1===i)return}i=Math.round(100*i),e?(e.Enabled=100!==i,e.Opacity=i):t.style.filter+=" progid:"+n+"(opacity="+i+")"}(t,i)}function _i(t){for(var i=document.documentElement.style,e=0;e<t.length;e++)if(t[e]in i)return t[e];return!1}function di(t,i,e){i=i||new E(0,0);t.style[Xt]=(Ct.ie3d?"translate("+i.x+"px,"+i.y+"px)":"translate3d("+i.x+"px,"+i.y+"px,0)")+(e?" scale("+e+")":"")}function pi(t,i){t._leaflet_pos=i,Ct.any3d?di(t,i):(t.style.left=i.x+"px",t.style.top=i.y+"px")}function mi(t){return t._leaflet_pos||new E(0,0)}function fi(){Pi(window,"dragstart",Ei)}function gi(){Li(window,"dragstart",Ei)}function vi(t){for(;-1===t.tabIndex;)t=t.parentNode;t.style&&(yi(),Yt=(Kt=t).style.outline,t.style.outline="none",Pi(window,"keydown",yi))}function yi(){Kt&&(Kt.style.outline=Yt,Yt=Kt=void 0,Li(window,"keydown",yi))}function xi(t){for(;!((t=t.parentNode).offsetWidth&&t.offsetHeight||t===document.body););return t}function wi(t){var i=t.getBoundingClientRect();return{x:i.width/t.offsetWidth||1,y:i.height/t.offsetHeight||1,boundingClientRect:i}}Gt="onselectstart"in document?(qt=function(){Pi(window,"selectstart",Ei)},function(){Li(window,"selectstart",Ei)}):(Vt=_i(["userSelect","WebkitUserSelect","OUserSelect","MozUserSelect","msUserSelect"]),qt=function(){var t;Vt&&(t=document.documentElement.style,Ut=t[Vt],t[Vt]="none")},function(){Vt&&(document.documentElement.style[Vt]=Ut,Ut=void 0)});gt={__proto__:null,TRANSFORM:Xt,TRANSITION:Jt,TRANSITION_END:$t,get:Qt,getStyle:ti,create:ii,remove:ei,empty:ni,toFront:oi,toBack:si,hasClass:ri,addClass:ai,removeClass:hi,setClass:ui,getClass:li,setOpacity:ci,testProp:_i,setTransform:di,setPosition:pi,getPosition:mi,get disableTextSelection(){return qt},get enableTextSelection(){return Gt},disableImageDrag:fi,enableImageDrag:gi,preventOutline:vi,restoreOutline:yi,getSizedParentNode:xi,getScale:wi};function Pi(t,i,e,n){if(i&&"object"==typeof i)for(var o in i)Mi(t,o,i[o],e);else for(var s=0,r=(i=_(i)).length;s<r;s++)Mi(t,i[s],e,n);return this}var bi="_leaflet_events";function Li(t,i,e,n){if(1===arguments.length)Ti(t),delete t[bi];else if(i&&"object"==typeof i)for(var o in i)Ci(t,o,i[o],e);else if(i=_(i),2===arguments.length)Ti(t,function(t){return-1!==v(i,t)});else for(var s=0,r=i.length;s<r;s++)Ci(t,i[s],e,n);return this}function Ti(t,i){for(var e in t[bi]){var n=e.split(/\d/)[0];i&&!i(n)||Ci(t,n,null,null,e)}}var zi={mouseenter:"mouseover",mouseleave:"mouseout",wheel:!("onwheel"in window)&&"mousewheel"};function Mi(i,t,e,n){var o=t+h(e)+(n?"_"+h(n):"");if(i[bi]&&i[bi][o])return this;var s=function(t){return e.call(n||i,t||window.event)},r=s;!Ct.touchNative&&Ct.pointer&&0===t.indexOf("touch")?s=Rt(i,t,s):Ct.touch&&"dblclick"===t?s=Ft(i,s):"addEventListener"in i?"touchstart"===t||"touchmove"===t||"wheel"===t||"mousewheel"===t?i.addEventListener(zi[t]||t,s,!!Ct.passiveEvents&&{passive:!1}):"mouseenter"===t||"mouseleave"===t?(s=function(t){t=t||window.event,Ri(i,t)&&r(t)},i.addEventListener(zi[t],s,!1)):i.addEventListener(t,r,!1):i.attachEvent("on"+t,s),i[bi]=i[bi]||{},i[bi][o]=s}function Ci(t,i,e,n,o){o=o||i+h(e)+(n?"_"+h(n):"");var s,r,e=t[bi]&&t[bi][o];if(!e)return this;!Ct.touchNative&&Ct.pointer&&0===i.indexOf("touch")?(n=t,r=e,Bt[s=i]?n.removeEventListener(Bt[s],r,!1):console.warn("wrong event specified:",s)):Ct.touch&&"dblclick"===i?(r=e,(s=t).removeEventListener("dblclick",r.dblclick),s.removeEventListener("click",r.simDblclick)):"removeEventListener"in t?t.removeEventListener(zi[i]||i,e,!1):t.detachEvent("on"+i,e),t[bi][o]=null}function Zi(t){return t.stopPropagation?t.stopPropagation():t.originalEvent?t.originalEvent._stopped=!0:t.cancelBubble=!0,this}function Si(t){return Mi(t,"wheel",Zi),this}function ki(t){return Pi(t,"mousedown touchstart dblclick contextmenu",Zi),t._leaflet_disable_click=!0,this}function Ei(t){return t.preventDefault?t.preventDefault():t.returnValue=!1,this}function Bi(t){return Ei(t),Zi(t),this}function Ai(t,i){if(!i)return new E(t.clientX,t.clientY);var e=wi(i),n=e.boundingClientRect;return new E((t.clientX-n.left)/e.x-i.clientLeft,(t.clientY-n.top)/e.y-i.clientTop)}var Ii=Ct.win&&Ct.chrome?2*window.devicePixelRatio:Ct.gecko?window.devicePixelRatio:1;function Oi(t){return Ct.edge?t.wheelDeltaY/2:t.deltaY&&0===t.deltaMode?-t.deltaY/Ii:t.deltaY&&1===t.deltaMode?20*-t.deltaY:t.deltaY&&2===t.deltaMode?60*-t.deltaY:t.deltaX||t.deltaZ?0:t.wheelDelta?(t.wheelDeltaY||t.wheelDelta)/2:t.detail&&Math.abs(t.detail)<32765?20*-t.detail:t.detail?t.detail/-32765*60:0}function Ri(t,i){var e=i.relatedTarget;if(!e)return!0;try{for(;e&&e!==t;)e=e.parentNode}catch(t){return!1}return e!==t}var vt={__proto__:null,on:Pi,off:Li,stopPropagation:Zi,disableScrollPropagation:Si,disableClickPropagation:ki,preventDefault:Ei,stop:Bi,getMousePosition:Ai,getWheelDelta:Oi,isExternalTarget:Ri,addListener:Pi,removeListener:Li},Ni=k.extend({run:function(t,i,e,n){this.stop(),this._el=t,this._inProgress=!0,this._duration=e||.25,this._easeOutPower=1/Math.max(n||.5,.2),this._startPos=mi(t),this._offset=i.subtract(this._startPos),this._startTime=+new Date,this.fire("start"),this._animate()},stop:function(){this._inProgress&&(this._step(!0),this._complete())},_animate:function(){this._animId=z(this._animate,this),this._step()},_step:function(t){var i=+new Date-this._startTime,e=1e3*this._duration;i<e?this._runFrame(this._easeOut(i/e),t):(this._runFrame(1),this._complete())},_runFrame:function(t,i){t=this._startPos.add(this._offset.multiplyBy(t));i&&t._round(),pi(this._el,t),this.fire("step")},_complete:function(){M(this._animId),this._inProgress=!1,this.fire("end")},_easeOut:function(t){return 1-Math.pow(1-t,this._easeOutPower)}}),Di=k.extend({options:{crs:G,center:void 0,zoom:void 0,minZoom:void 0,maxZoom:void 0,layers:[],maxBounds:void 0,renderer:void 0,zoomAnimation:!0,zoomAnimationThreshold:4,fadeAnimation:!0,markerZoomAnimation:!0,transform3DLimit:8388608,zoomSnap:1,zoomDelta:1,trackResize:!0},initialize:function(t,i){i=d(this,i),this._handlers=[],this._layers={},this._zoomBoundLayers={},this._sizeChanged=!0,this._initContainer(t),this._initLayout(),this._onResize=a(this._onResize,this),this._initEvents(),i.maxBounds&&this.setMaxBounds(i.maxBounds),void 0!==i.zoom&&(this._zoom=this._limitZoom(i.zoom)),i.center&&void 0!==i.zoom&&this.setView(j(i.center),i.zoom,{reset:!0}),this.callInitHooks(),this._zoomAnimated=Jt&&Ct.any3d&&!Ct.mobileOpera&&this.options.zoomAnimation,this._zoomAnimated&&(this._createAnimProxy(),Pi(this._proxy,$t,this._catchTransitionEnd,this)),this._addLayers(this.options.layers)},setView:function(t,i,e){if((i=void 0===i?this._zoom:this._limitZoom(i),t=this._limitCenter(j(t),i,this.options.maxBounds),e=e||{},this._stop(),this._loaded&&!e.reset&&!0!==e)&&(void 0!==e.animate&&(e.zoom=u({animate:e.animate},e.zoom),e.pan=u({animate:e.animate,duration:e.duration},e.pan)),this._zoom!==i?this._tryAnimatedZoom&&this._tryAnimatedZoom(t,i,e.zoom):this._tryAnimatedPan(t,e.pan)))return clearTimeout(this._sizeTimer),this;return this._resetView(t,i),this},setZoom:function(t,i){return this._loaded?this.setView(this.getCenter(),t,{zoom:i}):(this._zoom=t,this)},zoomIn:function(t,i){return t=t||(Ct.any3d?this.options.zoomDelta:1),this.setZoom(this._zoom+t,i)},zoomOut:function(t,i){return t=t||(Ct.any3d?this.options.zoomDelta:1),this.setZoom(this._zoom-t,i)},setZoomAround:function(t,i,e){var n=this.getZoomScale(i),o=this.getSize().divideBy(2),n=(t instanceof E?t:this.latLngToContainerPoint(t)).subtract(o).multiplyBy(1-1/n),n=this.containerPointToLatLng(o.add(n));return this.setView(n,i,{zoom:e})},_getBoundsCenterZoom:function(t,i){i=i||{},t=t.getBounds?t.getBounds():N(t);var e=A(i.paddingTopLeft||i.padding||[0,0]),n=A(i.paddingBottomRight||i.padding||[0,0]),o=this.getBoundsZoom(t,!1,e.add(n));if((o="number"==typeof i.maxZoom?Math.min(i.maxZoom,o):o)===1/0)return{center:t.getCenter(),zoom:o};n=n.subtract(e).divideBy(2),e=this.project(t.getSouthWest(),o),t=this.project(t.getNorthEast(),o);return{center:this.unproject(e.add(t).divideBy(2).add(n),o),zoom:o}},fitBounds:function(t,i){if(!(t=N(t)).isValid())throw new Error("Bounds are not valid.");t=this._getBoundsCenterZoom(t,i);return this.setView(t.center,t.zoom,i)},fitWorld:function(t){return this.fitBounds([[-90,-180],[90,180]],t)},panTo:function(t,i){return this.setView(t,this._zoom,{pan:i})},panBy:function(t,i){return i=i||{},(t=A(t).round()).x||t.y?(!0===i.animate||this.getSize().contains(t)?(this._panAnim||(this._panAnim=new Ni,this._panAnim.on({step:this._onPanTransitionStep,end:this._onPanTransitionEnd},this)),i.noMoveStart||this.fire("movestart"),!1!==i.animate?(ai(this._mapPane,"leaflet-pan-anim"),e=this._getMapPanePos().subtract(t).round(),this._panAnim.run(this._mapPane,e,i.duration||.25,i.easeLinearity)):(this._rawPanBy(t),this.fire("move").fire("moveend"))):this._resetView(this.unproject(this.project(this.getCenter()).add(t)),this.getZoom()),this):this.fire("moveend");var e},flyTo:function(n,o,t){if(!1===(t=t||{}).animate||!Ct.any3d)return this.setView(n,o,t);this._stop();var s=this.project(this.getCenter()),r=this.project(n),i=this.getSize(),a=this._zoom;n=j(n),o=void 0===o?a:o;var h=Math.max(i.x,i.y),e=h*this.getZoomScale(a,o),u=r.distanceTo(s)||1,l=1.42,c=l*l;function _(t){t=(e*e-h*h+(t?-1:1)*c*c*u*u)/(2*(t?e:h)*c*u),t=Math.sqrt(t*t+1)-t;return t<1e-9?-18:Math.log(t)}function d(t){return(Math.exp(t)-Math.exp(-t))/2}function p(t){return(Math.exp(t)+Math.exp(-t))/2}var m=_(0);function f(t){return h*(p(m)*(d(t=m+l*t)/p(t))-d(m))/c}var g=Date.now(),v=(_(1)-m)/l,y=t.duration?1e3*t.duration:1e3*v*.8;return this._moveStart(!0,t.noMoveStart),function t(){var i=(Date.now()-g)/y,e=(1-Math.pow(1-i,1.5))*v;i<=1?(this._flyToFrame=z(t,this),this._move(this.unproject(s.add(r.subtract(s).multiplyBy(f(e)/u)),a),this.getScaleZoom(h/(h*(p(m)/p(m+l*e))),a),{flyTo:!0})):this._move(n,o)._moveEnd(!0)}.call(this),this},flyToBounds:function(t,i){t=this._getBoundsCenterZoom(t,i);return this.flyTo(t.center,t.zoom,i)},setMaxBounds:function(t){return(t=N(t)).isValid()?(this.options.maxBounds&&this.off("moveend",this._panInsideMaxBounds),this.options.maxBounds=t,this._loaded&&this._panInsideMaxBounds(),this.on("moveend",this._panInsideMaxBounds)):(this.options.maxBounds=null,this.off("moveend",this._panInsideMaxBounds))},setMinZoom:function(t){var i=this.options.minZoom;return this.options.minZoom=t,this._loaded&&i!==t&&(this.fire("zoomlevelschange"),this.getZoom()<this.options.minZoom)?this.setZoom(t):this},setMaxZoom:function(t){var i=this.options.maxZoom;return this.options.maxZoom=t,this._loaded&&i!==t&&(this.fire("zoomlevelschange"),this.getZoom()>this.options.maxZoom)?this.setZoom(t):this},panInsideBounds:function(t,i){this._enforcingBounds=!0;var e=this.getCenter(),t=this._limitCenter(e,this._zoom,N(t));return e.equals(t)||this.panTo(t,i),this._enforcingBounds=!1,this},panInside:function(t,i){var e=A((i=i||{}).paddingTopLeft||i.padding||[0,0]),n=A(i.paddingBottomRight||i.padding||[0,0]),o=this.project(this.getCenter()),s=this.project(t),t=this.getPixelBounds(),e=O([t.min.add(e),t.max.subtract(n)]),t=e.getSize();return e.contains(s)||(this._enforcingBounds=!0,n=s.subtract(e.getCenter()),t=e.extend(s).getSize().subtract(t),o.x+=n.x<0?-t.x:t.x,o.y+=n.y<0?-t.y:t.y,this.panTo(this.unproject(o),i),this._enforcingBounds=!1),this},invalidateSize:function(t){if(!this._loaded)return this;t=u({animate:!1,pan:!0},!0===t?{animate:!0}:t);var i=this.getSize();this._sizeChanged=!0,this._lastCenter=null;var e=this.getSize(),n=i.divideBy(2).round(),o=e.divideBy(2).round(),o=n.subtract(o);return o.x||o.y?(t.animate&&t.pan?this.panBy(o):(t.pan&&this._rawPanBy(o),this.fire("move"),t.debounceMoveend?(clearTimeout(this._sizeTimer),this._sizeTimer=setTimeout(a(this.fire,this,"moveend"),200)):this.fire("moveend")),this.fire("resize",{oldSize:i,newSize:e})):this},stop:function(){return this.setZoom(this._limitZoom(this._zoom)),this.options.zoomSnap||this.fire("viewreset"),this._stop()},locate:function(t){if(t=this._locateOptions=u({timeout:1e4,watch:!1},t),!("geolocation"in navigator))return this._handleGeolocationError({code:0,message:"Geolocation not supported."}),this;var i=a(this._handleGeolocationResponse,this),e=a(this._handleGeolocationError,this);return t.watch?this._locationWatchId=navigator.geolocation.watchPosition(i,e,t):navigator.geolocation.getCurrentPosition(i,e,t),this},stopLocate:function(){return navigator.geolocation&&navigator.geolocation.clearWatch&&navigator.geolocation.clearWatch(this._locationWatchId),this._locateOptions&&(this._locateOptions.setView=!1),this},_handleGeolocationError:function(t){var i;this._container._leaflet_id&&(i=t.code,t=t.message||(1===i?"permission denied":2===i?"position unavailable":"timeout"),this._locateOptions.setView&&!this._loaded&&this.fitWorld(),this.fire("locationerror",{code:i,message:"Geolocation error: "+t+"."}))},_handleGeolocationResponse:function(t){if(this._container._leaflet_id){var i,e=new D(t.coords.latitude,t.coords.longitude),n=e.toBounds(2*t.coords.accuracy),o=this._locateOptions;o.setView&&(i=this.getBoundsZoom(n),this.setView(e,o.maxZoom?Math.min(i,o.maxZoom):i));var s,r={latlng:e,bounds:n,timestamp:t.timestamp};for(s in t.coords)"number"==typeof t.coords[s]&&(r[s]=t.coords[s]);this.fire("locationfound",r)}},addHandler:function(t,i){if(!i)return this;i=this[t]=new i(this);return this._handlers.push(i),this.options[t]&&i.enable(),this},remove:function(){if(this._initEvents(!0),this.options.maxBounds&&this.off("moveend",this._panInsideMaxBounds),this._containerId!==this._container._leaflet_id)throw new Error("Map container is being reused by another instance");try{delete this._container._leaflet_id,delete this._containerId}catch(t){this._container._leaflet_id=void 0,this._containerId=void 0}for(var t in void 0!==this._locationWatchId&&this.stopLocate(),this._stop(),ei(this._mapPane),this._clearControlPos&&this._clearControlPos(),this._resizeRequest&&(M(this._resizeRequest),this._resizeRequest=null),this._clearHandlers(),this._loaded&&this.fire("unload"),this._layers)this._layers[t].remove();for(t in this._panes)ei(this._panes[t]);return this._layers=[],this._panes=[],delete this._mapPane,delete this._renderer,this},createPane:function(t,i){i=ii("div","leaflet-pane"+(t?" leaflet-"+t.replace("Pane","")+"-pane":""),i||this._mapPane);return t&&(this._panes[t]=i),i},getCenter:function(){return this._checkIfLoaded(),this._lastCenter&&!this._moved()?this._lastCenter:this.layerPointToLatLng(this._getCenterLayerPoint())},getZoom:function(){return this._zoom},getBounds:function(){var t=this.getPixelBounds();return new R(this.unproject(t.getBottomLeft()),this.unproject(t.getTopRight()))},getMinZoom:function(){return void 0===this.options.minZoom?this._layersMinZoom||0:this.options.minZoom},getMaxZoom:function(){return void 0===this.options.maxZoom?void 0===this._layersMaxZoom?1/0:this._layersMaxZoom:this.options.maxZoom},getBoundsZoom:function(t,i,e){t=N(t),e=A(e||[0,0]);var n=this.getZoom()||0,o=this.getMinZoom(),s=this.getMaxZoom(),r=t.getNorthWest(),a=t.getSouthEast(),t=this.getSize().subtract(e),e=O(this.project(a,n),this.project(r,n)).getSize(),a=Ct.any3d?this.options.zoomSnap:1,r=t.x/e.x,e=t.y/e.y,e=i?Math.max(r,e):Math.min(r,e),n=this.getScaleZoom(e,n);return a&&(n=Math.round(n/(a/100))*(a/100),n=i?Math.ceil(n/a)*a:Math.floor(n/a)*a),Math.max(o,Math.min(s,n))},getSize:function(){return this._size&&!this._sizeChanged||(this._size=new E(this._container.clientWidth||0,this._container.clientHeight||0),this._sizeChanged=!1),this._size.clone()},getPixelBounds:function(t,i){i=this._getTopLeftPoint(t,i);return new I(i,i.add(this.getSize()))},getPixelOrigin:function(){return this._checkIfLoaded(),this._pixelOrigin},getPixelWorldBounds:function(t){return this.options.crs.getProjectedBounds(void 0===t?this.getZoom():t)},getPane:function(t){return"string"==typeof t?this._panes[t]:t},getPanes:function(){return this._panes},getContainer:function(){return this._container},getZoomScale:function(t,i){var e=this.options.crs;return i=void 0===i?this._zoom:i,e.scale(t)/e.scale(i)},getScaleZoom:function(t,i){var e=this.options.crs;i=void 0===i?this._zoom:i;i=e.zoom(t*e.scale(i));return isNaN(i)?1/0:i},project:function(t,i){return i=void 0===i?this._zoom:i,this.options.crs.latLngToPoint(j(t),i)},unproject:function(t,i){return i=void 0===i?this._zoom:i,this.options.crs.pointToLatLng(A(t),i)},layerPointToLatLng:function(t){t=A(t).add(this.getPixelOrigin());return this.unproject(t)},latLngToLayerPoint:function(t){return this.project(j(t))._round()._subtract(this.getPixelOrigin())},wrapLatLng:function(t){return this.options.crs.wrapLatLng(j(t))},wrapLatLngBounds:function(t){return this.options.crs.wrapLatLngBounds(N(t))},distance:function(t,i){return this.options.crs.distance(j(t),j(i))},containerPointToLayerPoint:function(t){return A(t).subtract(this._getMapPanePos())},layerPointToContainerPoint:function(t){return A(t).add(this._getMapPanePos())},containerPointToLatLng:function(t){t=this.containerPointToLayerPoint(A(t));return this.layerPointToLatLng(t)},latLngToContainerPoint:function(t){return this.layerPointToContainerPoint(this.latLngToLayerPoint(j(t)))},mouseEventToContainerPoint:function(t){return Ai(t,this._container)},mouseEventToLayerPoint:function(t){return this.containerPointToLayerPoint(this.mouseEventToContainerPoint(t))},mouseEventToLatLng:function(t){return this.layerPointToLatLng(this.mouseEventToLayerPoint(t))},_initContainer:function(t){t=this._container=Qt(t);if(!t)throw new Error("Map container not found.");if(t._leaflet_id)throw new Error("Map container is already initialized.");Pi(t,"scroll",this._onScroll,this),this._containerId=h(t)},_initLayout:function(){var t=this._container;this._fadeAnimated=this.options.fadeAnimation&&Ct.any3d,ai(t,"leaflet-container"+(Ct.touch?" leaflet-touch":"")+(Ct.retina?" leaflet-retina":"")+(Ct.ielt9?" leaflet-oldie":"")+(Ct.safari?" leaflet-safari":"")+(this._fadeAnimated?" leaflet-fade-anim":""));var i=ti(t,"position");"absolute"!==i&&"relative"!==i&&"fixed"!==i&&(t.style.position="relative"),this._initPanes(),this._initControlPos&&this._initControlPos()},_initPanes:function(){var t=this._panes={};this._paneRenderers={},this._mapPane=this.createPane("mapPane",this._container),pi(this._mapPane,new E(0,0)),this.createPane("tilePane"),this.createPane("overlayPane"),this.createPane("shadowPane"),this.createPane("markerPane"),this.createPane("tooltipPane"),this.createPane("popupPane"),this.options.markerZoomAnimation||(ai(t.markerPane,"leaflet-zoom-hide"),ai(t.shadowPane,"leaflet-zoom-hide"))},_resetView:function(t,i){pi(this._mapPane,new E(0,0));var e=!this._loaded;this._loaded=!0,i=this._limitZoom(i),this.fire("viewprereset");var n=this._zoom!==i;this._moveStart(n,!1)._move(t,i)._moveEnd(n),this.fire("viewreset"),e&&this.fire("load")},_moveStart:function(t,i){return t&&this.fire("zoomstart"),i||this.fire("movestart"),this},_move:function(t,i,e){void 0===i&&(i=this._zoom);var n=this._zoom!==i;return this._zoom=i,this._lastCenter=t,this._pixelOrigin=this._getNewPixelOrigin(t),(n||e&&e.pinch)&&this.fire("zoom",e),this.fire("move",e)},_moveEnd:function(t){return t&&this.fire("zoomend"),this.fire("moveend")},_stop:function(){return M(this._flyToFrame),this._panAnim&&this._panAnim.stop(),this},_rawPanBy:function(t){pi(this._mapPane,this._getMapPanePos().subtract(t))},_getZoomSpan:function(){return this.getMaxZoom()-this.getMinZoom()},_panInsideMaxBounds:function(){this._enforcingBounds||this.panInsideBounds(this.options.maxBounds)},_checkIfLoaded:function(){if(!this._loaded)throw new Error("Set map center and zoom first.")},_initEvents:function(t){this._targets={};var i=t?Li:Pi;i((this._targets[h(this._container)]=this)._container,"click dblclick mousedown mouseup mouseover mouseout mousemove contextmenu keypress keydown keyup",this._handleDOMEvent,this),this.options.trackResize&&i(window,"resize",this._onResize,this),Ct.any3d&&this.options.transform3DLimit&&(t?this.off:this.on).call(this,"moveend",this._onMoveEnd)},_onResize:function(){M(this._resizeRequest),this._resizeRequest=z(function(){this.invalidateSize({debounceMoveend:!0})},this)},_onScroll:function(){this._container.scrollTop=0,this._container.scrollLeft=0},_onMoveEnd:function(){var t=this._getMapPanePos();Math.max(Math.abs(t.x),Math.abs(t.y))>=this.options.transform3DLimit&&this._resetView(this.getCenter(),this.getZoom())},_findEventTargets:function(t,i){for(var e,n=[],o="mouseout"===i||"mouseover"===i,s=t.target||t.srcElement,r=!1;s;){if((e=this._targets[h(s)])&&("click"===i||"preclick"===i)&&this._draggableMoved(e)){r=!0;break}if(e&&e.listens(i,!0)){if(o&&!Ri(s,t))break;if(n.push(e),o)break}if(s===this._container)break;s=s.parentNode}return n=!(n.length||r||o)&&Ri(s,t)?[this]:n},_isClickDisabled:function(t){for(;t!==this._container;){if(t._leaflet_disable_click)return!0;t=t.parentNode}},_handleDOMEvent:function(t){var i,e=t.target||t.srcElement;!this._loaded||e._leaflet_disable_events||"click"===t.type&&this._isClickDisabled(e)||("mousedown"===(i=t.type)&&vi(e),this._fireDOMEvent(t,i))},_mouseEvents:["click","dblclick","mouseover","mouseout","contextmenu"],_fireDOMEvent:function(t,i,e){"click"===t.type&&((r=u({},t)).type="preclick",this._fireDOMEvent(r,r.type,e));var n=this._findEventTargets(t,i);if(e){for(var o=[],s=0;s<e.length;s++)e[s].listens(i,!0)&&o.push(e[s]);n=o.concat(n)}if(n.length){"contextmenu"===i&&Ei(t);var r,a=n[0],h={originalEvent:t};for("keypress"!==t.type&&"keydown"!==t.type&&"keyup"!==t.type&&(r=a.getLatLng&&(!a._radius||a._radius<=10),h.containerPoint=r?this.latLngToContainerPoint(a.getLatLng()):this.mouseEventToContainerPoint(t),h.layerPoint=this.containerPointToLayerPoint(h.containerPoint),h.latlng=r?a.getLatLng():this.layerPointToLatLng(h.layerPoint)),s=0;s<n.length;s++)if(n[s].fire(i,h,!0),h.originalEvent._stopped||!1===n[s].options.bubblingMouseEvents&&-1!==v(this._mouseEvents,i))return}},_draggableMoved:function(t){return(t=t.dragging&&t.dragging.enabled()?t:this).dragging&&t.dragging.moved()||this.boxZoom&&this.boxZoom.moved()},_clearHandlers:function(){for(var t=0,i=this._handlers.length;t<i;t++)this._handlers[t].disable()},whenReady:function(t,i){return this._loaded?t.call(i||this,{target:this}):this.on("load",t,i),this},_getMapPanePos:function(){return mi(this._mapPane)||new E(0,0)},_moved:function(){var t=this._getMapPanePos();return t&&!t.equals([0,0])},_getTopLeftPoint:function(t,i){return(t&&void 0!==i?this._getNewPixelOrigin(t,i):this.getPixelOrigin()).subtract(this._getMapPanePos())},_getNewPixelOrigin:function(t,i){var e=this.getSize()._divideBy(2);return this.project(t,i)._subtract(e)._add(this._getMapPanePos())._round()},_latLngToNewLayerPoint:function(t,i,e){e=this._getNewPixelOrigin(e,i);return this.project(t,i)._subtract(e)},_latLngBoundsToNewLayerBounds:function(t,i,e){e=this._getNewPixelOrigin(e,i);return O([this.project(t.getSouthWest(),i)._subtract(e),this.project(t.getNorthWest(),i)._subtract(e),this.project(t.getSouthEast(),i)._subtract(e),this.project(t.getNorthEast(),i)._subtract(e)])},_getCenterLayerPoint:function(){return this.containerPointToLayerPoint(this.getSize()._divideBy(2))},_getCenterOffset:function(t){return this.latLngToLayerPoint(t).subtract(this._getCenterLayerPoint())},_limitCenter:function(t,i,e){if(!e)return t;var n=this.project(t,i),o=this.getSize().divideBy(2),o=new I(n.subtract(o),n.add(o)),e=this._getBoundsOffset(o,e,i);return e.round().equals([0,0])?t:this.unproject(n.add(e),i)},_limitOffset:function(t,i){if(!i)return t;var e=this.getPixelBounds(),e=new I(e.min.add(t),e.max.add(t));return t.add(this._getBoundsOffset(e,i))},_getBoundsOffset:function(t,i,e){i=O(this.project(i.getNorthEast(),e),this.project(i.getSouthWest(),e)),e=i.min.subtract(t.min),t=i.max.subtract(t.max);return new E(this._rebound(e.x,-t.x),this._rebound(e.y,-t.y))},_rebound:function(t,i){return 0<t+i?Math.round(t-i)/2:Math.max(0,Math.ceil(t))-Math.max(0,Math.floor(i))},_limitZoom:function(t){var i=this.getMinZoom(),e=this.getMaxZoom(),n=Ct.any3d?this.options.zoomSnap:1;return n&&(t=Math.round(t/n)*n),Math.max(i,Math.min(e,t))},_onPanTransitionStep:function(){this.fire("move")},_onPanTransitionEnd:function(){hi(this._mapPane,"leaflet-pan-anim"),this.fire("moveend")},_tryAnimatedPan:function(t,i){t=this._getCenterOffset(t)._trunc();return!(!0!==(i&&i.animate)&&!this.getSize().contains(t))&&(this.panBy(t,i),!0)},_createAnimProxy:function(){var t=this._proxy=ii("div","leaflet-proxy leaflet-zoom-animated");this._panes.mapPane.appendChild(t),this.on("zoomanim",function(t){var i=Xt,e=this._proxy.style[i];di(this._proxy,this.project(t.center,t.zoom),this.getZoomScale(t.zoom,1)),e===this._proxy.style[i]&&this._animatingZoom&&this._onZoomTransitionEnd()},this),this.on("load moveend",this._animMoveEnd,this),this._on("unload",this._destroyAnimProxy,this)},_destroyAnimProxy:function(){ei(this._proxy),this.off("load moveend",this._animMoveEnd,this),delete this._proxy},_animMoveEnd:function(){var t=this.getCenter(),i=this.getZoom();di(this._proxy,this.project(t,i),this.getZoomScale(i,1))},_catchTransitionEnd:function(t){this._animatingZoom&&0<=t.propertyName.indexOf("transform")&&this._onZoomTransitionEnd()},_nothingToAnimate:function(){return!this._container.getElementsByClassName("leaflet-zoom-animated").length},_tryAnimatedZoom:function(t,i,e){if(this._animatingZoom)return!0;if(e=e||{},!this._zoomAnimated||!1===e.animate||this._nothingToAnimate()||Math.abs(i-this._zoom)>this.options.zoomAnimationThreshold)return!1;var n=this.getZoomScale(i),n=this._getCenterOffset(t)._divideBy(1-1/n);return!(!0!==e.animate&&!this.getSize().contains(n))&&(z(function(){this._moveStart(!0,!1)._animateZoom(t,i,!0)},this),!0)},_animateZoom:function(t,i,e,n){this._mapPane&&(e&&(this._animatingZoom=!0,this._animateToCenter=t,this._animateToZoom=i,ai(this._mapPane,"leaflet-zoom-anim")),this.fire("zoomanim",{center:t,zoom:i,noUpdate:n}),setTimeout(a(this._onZoomTransitionEnd,this),250))},_onZoomTransitionEnd:function(){this._animatingZoom&&(this._mapPane&&hi(this._mapPane,"leaflet-zoom-anim"),this._animatingZoom=!1,this._move(this._animateToCenter,this._animateToZoom),z(function(){this._moveEnd(!0)},this))}});var ji=Z.extend({options:{position:"topright"},initialize:function(t){d(this,t)},getPosition:function(){return this.options.position},setPosition:function(t){var i=this._map;return i&&i.removeControl(this),this.options.position=t,i&&i.addControl(this),this},getContainer:function(){return this._container},addTo:function(t){this.remove(),this._map=t;var i=this._container=this.onAdd(t),e=this.getPosition(),t=t._controlCorners[e];return ai(i,"leaflet-control"),-1!==e.indexOf("bottom")?t.insertBefore(i,t.firstChild):t.appendChild(i),this._map.on("unload",this.remove,this),this},remove:function(){return this._map&&(ei(this._container),this.onRemove&&this.onRemove(this._map),this._map.off("unload",this.remove,this),this._map=null),this},_refocusOnMap:function(t){this._map&&t&&0<t.screenX&&0<t.screenY&&this._map.getContainer().focus()}}),yt=function(t){return new ji(t)};Di.include({addControl:function(t){return t.addTo(this),this},removeControl:function(t){return t.remove(),this},_initControlPos:function(){var e=this._controlCorners={},n="leaflet-",o=this._controlContainer=ii("div",n+"control-container",this._container);function t(t,i){e[t+i]=ii("div",n+t+" "+n+i,o)}t("top","left"),t("top","right"),t("bottom","left"),t("bottom","right")},_clearControlPos:function(){for(var t in this._controlCorners)ei(this._controlCorners[t]);ei(this._controlContainer),delete this._controlCorners,delete this._controlContainer}});var Hi=ji.extend({options:{collapsed:!0,position:"topright",autoZIndex:!0,hideSingleBase:!1,sortLayers:!1,sortFunction:function(t,i,e,n){return e<n?-1:n<e?1:0}},initialize:function(t,i,e){for(var n in d(this,e),this._layerControlInputs=[],this._layers=[],this._lastZIndex=0,this._handlingClick=!1,t)this._addLayer(t[n],n);for(n in i)this._addLayer(i[n],n,!0)},onAdd:function(t){this._initLayout(),this._update(),(this._map=t).on("zoomend",this._checkDisabledLayers,this);for(var i=0;i<this._layers.length;i++)this._layers[i].layer.on("add remove",this._onLayerChange,this);return this._container},addTo:function(t){return ji.prototype.addTo.call(this,t),this._expandIfNotCollapsed()},onRemove:function(){this._map.off("zoomend",this._checkDisabledLayers,this);for(var t=0;t<this._layers.length;t++)this._layers[t].layer.off("add remove",this._onLayerChange,this)},addBaseLayer:function(t,i){return this._addLayer(t,i),this._map?this._update():this},addOverlay:function(t,i){return this._addLayer(t,i,!0),this._map?this._update():this},removeLayer:function(t){t.off("add remove",this._onLayerChange,this);t=this._getLayer(h(t));return t&&this._layers.splice(this._layers.indexOf(t),1),this._map?this._update():this},expand:function(){ai(this._container,"leaflet-control-layers-expanded"),this._section.style.height=null;var t=this._map.getSize().y-(this._container.offsetTop+50);return t<this._section.clientHeight?(ai(this._section,"leaflet-control-layers-scrollbar"),this._section.style.height=t+"px"):hi(this._section,"leaflet-control-layers-scrollbar"),this._checkDisabledLayers(),this},collapse:function(){return hi(this._container,"leaflet-control-layers-expanded"),this},_initLayout:function(){var t="leaflet-control-layers",i=this._container=ii("div",t),e=this.options.collapsed;i.setAttribute("aria-haspopup",!0),ki(i),Si(i);var n=this._section=ii("section",t+"-list");e&&(this._map.on("click",this.collapse,this),Pi(i,{mouseenter:function(){Pi(n,"click",Ei),this.expand(),setTimeout(function(){Li(n,"click",Ei)})},mouseleave:this.collapse},this));var o=this._layersLink=ii("a",t+"-toggle",i);o.href="#",o.title="Layers",Pi(o,"click",Ei),Pi(o,"focus",this.expand,this),e||this.expand(),this._baseLayersList=ii("div",t+"-base",n),this._separator=ii("div",t+"-separator",n),this._overlaysList=ii("div",t+"-overlays",n),i.appendChild(n)},_getLayer:function(t){for(var i=0;i<this._layers.length;i++)if(this._layers[i]&&h(this._layers[i].layer)===t)return this._layers[i]},_addLayer:function(t,i,e){this._map&&t.on("add remove",this._onLayerChange,this),this._layers.push({layer:t,name:i,overlay:e}),this.options.sortLayers&&this._layers.sort(a(function(t,i){return this.options.sortFunction(t.layer,i.layer,t.name,i.name)},this)),this.options.autoZIndex&&t.setZIndex&&(this._lastZIndex++,t.setZIndex(this._lastZIndex)),this._expandIfNotCollapsed()},_update:function(){if(!this._container)return this;ni(this._baseLayersList),ni(this._overlaysList),this._layerControlInputs=[];for(var t,i,e,n=0,o=0;o<this._layers.length;o++)e=this._layers[o],this._addItem(e),i=i||e.overlay,t=t||!e.overlay,n+=e.overlay?0:1;return this.options.hideSingleBase&&(this._baseLayersList.style.display=(t=t&&1<n)?"":"none"),this._separator.style.display=i&&t?"":"none",this},_onLayerChange:function(t){this._handlingClick||this._update();var i=this._getLayer(h(t.target)),t=i.overlay?"add"===t.type?"overlayadd":"overlayremove":"add"===t.type?"baselayerchange":null;t&&this._map.fire(t,i)},_createRadioElement:function(t,i){t='<input type="radio" class="leaflet-control-layers-selector" name="'+t+'"'+(i?' checked="checked"':"")+"/>",i=document.createElement("div");return i.innerHTML=t,i.firstChild},_addItem:function(t){var i,e=document.createElement("label"),n=this._map.hasLayer(t.layer);t.overlay?((i=document.createElement("input")).type="checkbox",i.className="leaflet-control-layers-selector",i.defaultChecked=n):i=this._createRadioElement("leaflet-base-layers_"+h(this),n),this._layerControlInputs.push(i),i.layerId=h(t.layer),Pi(i,"click",this._onInputClick,this);var o=document.createElement("span");o.innerHTML=" "+t.name;n=document.createElement("div");return e.appendChild(n),n.appendChild(i),n.appendChild(o),(t.overlay?this._overlaysList:this._baseLayersList).appendChild(e),this._checkDisabledLayers(),e},_onInputClick:function(){var t,i,e=this._layerControlInputs,n=[],o=[];this._handlingClick=!0;for(var s=e.length-1;0<=s;s--)t=e[s],i=this._getLayer(t.layerId).layer,t.checked?n.push(i):t.checked||o.push(i);for(s=0;s<o.length;s++)this._map.hasLayer(o[s])&&this._map.removeLayer(o[s]);for(s=0;s<n.length;s++)this._map.hasLayer(n[s])||this._map.addLayer(n[s]);this._handlingClick=!1,this._refocusOnMap()},_checkDisabledLayers:function(){for(var t,i,e=this._layerControlInputs,n=this._map.getZoom(),o=e.length-1;0<=o;o--)t=e[o],i=this._getLayer(t.layerId).layer,t.disabled=void 0!==i.options.minZoom&&n<i.options.minZoom||void 0!==i.options.maxZoom&&n>i.options.maxZoom},_expandIfNotCollapsed:function(){return this._map&&!this.options.collapsed&&this.expand(),this}}),Wi=ji.extend({options:{position:"topleft",zoomInText:'<span aria-hidden="true">+</span>',zoomInTitle:"Zoom in",zoomOutText:'<span aria-hidden="true">&#x2212;</span>',zoomOutTitle:"Zoom out"},onAdd:function(t){var i="leaflet-control-zoom",e=ii("div",i+" leaflet-bar"),n=this.options;return this._zoomInButton=this._createButton(n.zoomInText,n.zoomInTitle,i+"-in",e,this._zoomIn),this._zoomOutButton=this._createButton(n.zoomOutText,n.zoomOutTitle,i+"-out",e,this._zoomOut),this._updateDisabled(),t.on("zoomend zoomlevelschange",this._updateDisabled,this),e},onRemove:function(t){t.off("zoomend zoomlevelschange",this._updateDisabled,this)},disable:function(){return this._disabled=!0,this._updateDisabled(),this},enable:function(){return this._disabled=!1,this._updateDisabled(),this},_zoomIn:function(t){!this._disabled&&this._map._zoom<this._map.getMaxZoom()&&this._map.zoomIn(this._map.options.zoomDelta*(t.shiftKey?3:1))},_zoomOut:function(t){!this._disabled&&this._map._zoom>this._map.getMinZoom()&&this._map.zoomOut(this._map.options.zoomDelta*(t.shiftKey?3:1))},_createButton:function(t,i,e,n,o){n=ii("a",e,n);return n.innerHTML=t,n.href="#",n.title=i,n.setAttribute("role","button"),n.setAttribute("aria-label",i),ki(n),Pi(n,"click",Bi),Pi(n,"click",o,this),Pi(n,"click",this._refocusOnMap,this),n},_updateDisabled:function(){var t=this._map,i="leaflet-disabled";hi(this._zoomInButton,i),hi(this._zoomOutButton,i),this._zoomInButton.setAttribute("aria-disabled","false"),this._zoomOutButton.setAttribute("aria-disabled","false"),!this._disabled&&t._zoom!==t.getMinZoom()||(ai(this._zoomOutButton,i),this._zoomOutButton.setAttribute("aria-disabled","true")),!this._disabled&&t._zoom!==t.getMaxZoom()||(ai(this._zoomInButton,i),this._zoomInButton.setAttribute("aria-disabled","true"))}});Di.mergeOptions({zoomControl:!0}),Di.addInitHook(function(){this.options.zoomControl&&(this.zoomControl=new Wi,this.addControl(this.zoomControl))});var Fi=ji.extend({options:{position:"bottomleft",maxWidth:100,metric:!0,imperial:!0},onAdd:function(t){var i="leaflet-control-scale",e=ii("div",i),n=this.options;return this._addScales(n,i+"-line",e),t.on(n.updateWhenIdle?"moveend":"move",this._update,this),t.whenReady(this._update,this),e},onRemove:function(t){t.off(this.options.updateWhenIdle?"moveend":"move",this._update,this)},_addScales:function(t,i,e){t.metric&&(this._mScale=ii("div",i,e)),t.imperial&&(this._iScale=ii("div",i,e))},_update:function(){var t=this._map,i=t.getSize().y/2,i=t.distance(t.containerPointToLatLng([0,i]),t.containerPointToLatLng([this.options.maxWidth,i]));this._updateScales(i)},_updateScales:function(t){this.options.metric&&t&&this._updateMetric(t),this.options.imperial&&t&&this._updateImperial(t)},_updateMetric:function(t){var i=this._getRoundNum(t);this._updateScale(this._mScale,i<1e3?i+" m":i/1e3+" km",i/t)},_updateImperial:function(t){var i,e=3.2808399*t;5280<e?(t=this._getRoundNum(i=e/5280),this._updateScale(this._iScale,t+" mi",t/i)):(i=this._getRoundNum(e),this._updateScale(this._iScale,i+" ft",i/e))},_updateScale:function(t,i,e){t.style.width=Math.round(this.options.maxWidth*e)+"px",t.innerHTML=i},_getRoundNum:function(t){var i=Math.pow(10,(Math.floor(t)+"").length-1),t=t/i;return i*(t=10<=t?10:5<=t?5:3<=t?3:2<=t?2:1)}}),Ui=ji.extend({options:{position:"bottomright",prefix:'<a href="https://leafletjs.com" title="A JavaScript library for interactive maps">Leaflet</a>'},initialize:function(t){d(this,t),this._attributions={}},onAdd:function(t){for(var i in(t.attributionControl=this)._container=ii("div","leaflet-control-attribution"),ki(this._container),t._layers)t._layers[i].getAttribution&&this.addAttribution(t._layers[i].getAttribution());return this._update(),t.on("layeradd",this._addAttribution,this),this._container},onRemove:function(t){t.off("layeradd",this._addAttribution,this)},_addAttribution:function(t){t.layer.getAttribution&&(this.addAttribution(t.layer.getAttribution()),t.layer.once("remove",function(){this.removeAttribution(t.layer.getAttribution())},this))},setPrefix:function(t){return this.options.prefix=t,this._update(),this},addAttribution:function(t){return t&&(this._attributions[t]||(this._attributions[t]=0),this._attributions[t]++,this._update()),this},removeAttribution:function(t){return t&&this._attributions[t]&&(this._attributions[t]--,this._update()),this},_update:function(){if(this._map){var t,i=[];for(t in this._attributions)this._attributions[t]&&i.push(t);var e=[];this.options.prefix&&e.push(this.options.prefix),i.length&&e.push(i.join(", ")),this._container.innerHTML=e.join(" | ")}}});Di.mergeOptions({attributionControl:!0}),Di.addInitHook(function(){this.options.attributionControl&&(new Ui).addTo(this)});ji.Layers=Hi,ji.Zoom=Wi,ji.Scale=Fi,ji.Attribution=Ui,yt.layers=function(t,i,e){return new Hi(t,i,e)},yt.zoom=function(t){return new Wi(t)},yt.scale=function(t){return new Fi(t)},yt.attribution=function(t){return new Ui(t)};xt=Z.extend({initialize:function(t){this._map=t},enable:function(){return this._enabled||(this._enabled=!0,this.addHooks()),this},disable:function(){return this._enabled&&(this._enabled=!1,this.removeHooks()),this},enabled:function(){return!!this._enabled}});xt.addTo=function(t,i){return t.addHandler(i,this),this};var Vi,wt={Events:S},qi=Ct.touch?"touchstart mousedown":"mousedown",Gi=k.extend({options:{clickTolerance:3},initialize:function(t,i,e,n){d(this,n),this._element=t,this._dragStartTarget=i||t,this._preventOutline=e},enable:function(){this._enabled||(Pi(this._dragStartTarget,qi,this._onDown,this),this._enabled=!0)},disable:function(){this._enabled&&(Gi._dragging===this&&this.finishDrag(),Li(this._dragStartTarget,qi,this._onDown,this),this._enabled=!1,this._moved=!1)},_onDown:function(t){var i,e;this._enabled&&(this._moved=!1,ri(this._element,"leaflet-zoom-anim")||Gi._dragging||t.shiftKey||1!==t.which&&1!==t.button&&!t.touches||((Gi._dragging=this)._preventOutline&&vi(this._element),fi(),qt(),this._moving||(this.fire("down"),i=t.touches?t.touches[0]:t,e=xi(this._element),this._startPoint=new E(i.clientX,i.clientY),this._parentScale=wi(e),t="mousedown"===t.type,Pi(document,t?"mousemove":"touchmove",this._onMove,this),Pi(document,t?"mouseup":"touchend touchcancel",this._onUp,this))))},_onMove:function(t){var i;this._enabled&&(t.touches&&1<t.touches.length?this._moved=!0:((i=new E((i=t.touches&&1===t.touches.length?t.touches[0]:t).clientX,i.clientY)._subtract(this._startPoint)).x||i.y)&&(Math.abs(i.x)+Math.abs(i.y)<this.options.clickTolerance||(i.x/=this._parentScale.x,i.y/=this._parentScale.y,Ei(t),this._moved||(this.fire("dragstart"),this._moved=!0,this._startPos=mi(this._element).subtract(i),ai(document.body,"leaflet-dragging"),this._lastTarget=t.target||t.srcElement,window.SVGElementInstance&&this._lastTarget instanceof window.SVGElementInstance&&(this._lastTarget=this._lastTarget.correspondingUseElement),ai(this._lastTarget,"leaflet-drag-target")),this._newPos=this._startPos.add(i),this._moving=!0,M(this._animRequest),this._lastEvent=t,this._animRequest=z(this._updatePosition,this,!0))))},_updatePosition:function(){var t={originalEvent:this._lastEvent};this.fire("predrag",t),pi(this._element,this._newPos),this.fire("drag",t)},_onUp:function(){this._enabled&&this.finishDrag()},finishDrag:function(){hi(document.body,"leaflet-dragging"),this._lastTarget&&(hi(this._lastTarget,"leaflet-drag-target"),this._lastTarget=null),Li(document,"mousemove touchmove",this._onMove,this),Li(document,"mouseup touchend touchcancel",this._onUp,this),gi(),Gt(),this._moved&&this._moving&&(M(this._animRequest),this.fire("dragend",{distance:this._newPos.distanceTo(this._startPos)})),this._moving=!1,Gi._dragging=!1}});function Ki(t,i){if(!i||!t.length)return t.slice();i*=i;return t=function(t,i){var e=t.length,n=new(typeof Uint8Array!=void 0+""?Uint8Array:Array)(e);n[0]=n[e-1]=1,function t(i,e,n,o,s){var r,a,h,u=0;for(a=o+1;a<=s-1;a++)h=Qi(i[a],i[o],i[s],!0),u<h&&(r=a,u=h);n<u&&(e[r]=1,t(i,e,n,o,r),t(i,e,n,r,s))}(t,n,i,0,e-1);var o,s=[];for(o=0;o<e;o++)n[o]&&s.push(t[o]);return s}(t=function(t,i){for(var e=[t[0]],n=1,o=0,s=t.length;n<s;n++)(function(t,i){var e=i.x-t.x,t=i.y-t.y;return e*e+t*t})(t[n],t[o])>i&&(e.push(t[n]),o=n);o<s-1&&e.push(t[s-1]);return e}(t,i),i)}function Yi(t,i,e){return Math.sqrt(Qi(t,i,e,!0))}function Xi(t,i,e,n,o){var s,r,a,h=n?Vi:$i(t,e),u=$i(i,e);for(Vi=u;;){if(!(h|u))return[t,i];if(h&u)return!1;a=$i(r=Ji(t,i,s=h||u,e,o),e),s===h?(t=r,h=a):(i=r,u=a)}}function Ji(t,i,e,n,o){var s,r,a=i.x-t.x,h=i.y-t.y,i=n.min,n=n.max;return 8&e?(s=t.x+a*(n.y-t.y)/h,r=n.y):4&e?(s=t.x+a*(i.y-t.y)/h,r=i.y):2&e?(s=n.x,r=t.y+h*(n.x-t.x)/a):1&e&&(s=i.x,r=t.y+h*(i.x-t.x)/a),new E(s,r,o)}function $i(t,i){var e=0;return t.x<i.min.x?e|=1:t.x>i.max.x&&(e|=2),t.y<i.min.y?e|=4:t.y>i.max.y&&(e|=8),e}function Qi(t,i,e,n){var o=i.x,s=i.y,r=e.x-o,a=e.y-s,i=r*r+a*a;return 0<i&&(1<(i=((t.x-o)*r+(t.y-s)*a)/i)?(o=e.x,s=e.y):0<i&&(o+=r*i,s+=a*i)),r=t.x-o,a=t.y-s,n?r*r+a*a:new E(o,s)}function te(t){return!g(t[0])||"object"!=typeof t[0][0]&&void 0!==t[0][0]}function ie(t){return console.warn("Deprecated use of _flat, please use L.LineUtil.isFlat instead."),te(t)}bt={__proto__:null,simplify:Ki,pointToSegmentDistance:Yi,closestPointOnSegment:function(t,i,e){return Qi(t,i,e)},clipSegment:Xi,_getEdgeIntersection:Ji,_getBitCode:$i,_sqClosestPointOnSegment:Qi,isFlat:te,_flat:ie};function ee(t,i,e){for(var n,o,s,r,a,h,u,l=[1,4,2,8],c=0,_=t.length;c<_;c++)t[c]._code=$i(t[c],i);for(s=0;s<4;s++){for(h=l[s],n=[],c=0,o=(_=t.length)-1;c<_;o=c++)r=t[c],a=t[o],r._code&h?a._code&h||((u=Ji(a,r,h,i,e))._code=$i(u,i),n.push(u)):(a._code&h&&((u=Ji(a,r,h,i,e))._code=$i(u,i),n.push(u)),n.push(r));t=n}return t}var Pt={__proto__:null,clipPolygon:ee},Lt={project:function(t){return new E(t.lng,t.lat)},unproject:function(t){return new D(t.y,t.x)},bounds:new I([-180,-90],[180,90])},F={R:6378137,R_MINOR:6356752.314245179,bounds:new I([-20037508.34279,-15496570.73972],[20037508.34279,18764656.23138]),project:function(t){var i=Math.PI/180,e=this.R,n=t.lat*i,o=this.R_MINOR/e,s=Math.sqrt(1-o*o),o=s*Math.sin(n),s=Math.tan(Math.PI/4-n/2)/Math.pow((1-o)/(1+o),s/2),n=-e*Math.log(Math.max(s,1e-10));return new E(t.lng*i*e,n)},unproject:function(t){for(var i,e=180/Math.PI,n=this.R,o=this.R_MINOR/n,s=Math.sqrt(1-o*o),r=Math.exp(-t.y/n),a=Math.PI/2-2*Math.atan(r),h=0,u=.1;h<15&&1e-7<Math.abs(u);h++)i=s*Math.sin(a),i=Math.pow((1-i)/(1+i),s/2),a+=u=Math.PI/2-2*Math.atan(r*i)-a;return new D(a*e,t.x*e/n)}},Tt={__proto__:null,LonLat:Lt,Mercator:F,SphericalMercator:U},ot=u({},W,{code:"EPSG:3395",projection:F,transformation:q(zt=.5/(Math.PI*F.R),.5,-zt,.5)}),ne=u({},W,{code:"EPSG:4326",projection:Lt,transformation:q(1/180,1,-1/180,.5)}),J=u({},H,{projection:Lt,transformation:q(1,0,-1,0),scale:function(t){return Math.pow(2,t)},zoom:function(t){return Math.log(t)/Math.LN2},distance:function(t,i){var e=i.lng-t.lng,t=i.lat-t.lat;return Math.sqrt(e*e+t*t)},infinite:!0});H.Earth=W,H.EPSG3395=ot,H.EPSG3857=G,H.EPSG900913=K,H.EPSG4326=ne,H.Simple=J;S=k.extend({options:{pane:"overlayPane",attribution:null,bubblingMouseEvents:!0},addTo:function(t){return t.addLayer(this),this},remove:function(){return this.removeFrom(this._map||this._mapToAdd)},removeFrom:function(t){return t&&t.removeLayer(this),this},getPane:function(t){return this._map.getPane(t?this.options[t]||t:this.options.pane)},addInteractiveTarget:function(t){return this._map._targets[h(t)]=this},removeInteractiveTarget:function(t){return delete this._map._targets[h(t)],this},getAttribution:function(){return this.options.attribution},_layerAdd:function(t){var i,e=t.target;e.hasLayer(this)&&(this._map=e,this._zoomAnimated=e._zoomAnimated,this.getEvents&&(i=this.getEvents(),e.on(i,this),this.once("remove",function(){e.off(i,this)},this)),this.onAdd(e),this.fire("add"),e.fire("layeradd",{layer:this}))}});Di.include({addLayer:function(t){if(!t._layerAdd)throw new Error("The provided object is not a Layer.");var i=h(t);return this._layers[i]||((this._layers[i]=t)._mapToAdd=this,t.beforeAdd&&t.beforeAdd(this),this.whenReady(t._layerAdd,t)),this},removeLayer:function(t){var i=h(t);return this._layers[i]&&(this._loaded&&t.onRemove(this),delete this._layers[i],this._loaded&&(this.fire("layerremove",{layer:t}),t.fire("remove")),t._map=t._mapToAdd=null),this},hasLayer:function(t){return h(t)in this._layers},eachLayer:function(t,i){for(var e in this._layers)t.call(i,this._layers[e]);return this},_addLayers:function(t){for(var i=0,e=(t=t?g(t)?t:[t]:[]).length;i<e;i++)this.addLayer(t[i])},_addZoomLimit:function(t){isNaN(t.options.maxZoom)&&isNaN(t.options.minZoom)||(this._zoomBoundLayers[h(t)]=t,this._updateZoomLevels())},_removeZoomLimit:function(t){t=h(t);this._zoomBoundLayers[t]&&(delete this._zoomBoundLayers[t],this._updateZoomLevels())},_updateZoomLevels:function(){var t,i=1/0,e=-1/0,n=this._getZoomSpan();for(t in this._zoomBoundLayers)var o=this._zoomBoundLayers[t].options,i=void 0===o.minZoom?i:Math.min(i,o.minZoom),e=void 0===o.maxZoom?e:Math.max(e,o.maxZoom);this._layersMaxZoom=e===-1/0?void 0:e,this._layersMinZoom=i===1/0?void 0:i,n!==this._getZoomSpan()&&this.fire("zoomlevelschange"),void 0===this.options.maxZoom&&this._layersMaxZoom&&this.getZoom()>this._layersMaxZoom&&this.setZoom(this._layersMaxZoom),void 0===this.options.minZoom&&this._layersMinZoom&&this.getZoom()<this._layersMinZoom&&this.setZoom(this._layersMinZoom)}});var oe=S.extend({initialize:function(t,i){var e,n;if(d(this,i),this._layers={},t)for(e=0,n=t.length;e<n;e++)this.addLayer(t[e])},addLayer:function(t){var i=this.getLayerId(t);return this._layers[i]=t,this._map&&this._map.addLayer(t),this},removeLayer:function(t){t=t in this._layers?t:this.getLayerId(t);return this._map&&this._layers[t]&&this._map.removeLayer(this._layers[t]),delete this._layers[t],this},hasLayer:function(t){return("number"==typeof t?t:this.getLayerId(t))in this._layers},clearLayers:function(){return this.eachLayer(this.removeLayer,this)},invoke:function(t){var i,e,n=Array.prototype.slice.call(arguments,1);for(i in this._layers)(e=this._layers[i])[t]&&e[t].apply(e,n);return this},onAdd:function(t){this.eachLayer(t.addLayer,t)},onRemove:function(t){this.eachLayer(t.removeLayer,t)},eachLayer:function(t,i){for(var e in this._layers)t.call(i,this._layers[e]);return this},getLayer:function(t){return this._layers[t]},getLayers:function(){var t=[];return this.eachLayer(t.push,t),t},setZIndex:function(t){return this.invoke("setZIndex",t)},getLayerId:h}),se=oe.extend({addLayer:function(t){return this.hasLayer(t)?this:(t.addEventParent(this),oe.prototype.addLayer.call(this,t),this.fire("layeradd",{layer:t}))},removeLayer:function(t){return this.hasLayer(t)?((t=t in this._layers?this._layers[t]:t).removeEventParent(this),oe.prototype.removeLayer.call(this,t),this.fire("layerremove",{layer:t})):this},setStyle:function(t){return this.invoke("setStyle",t)},bringToFront:function(){return this.invoke("bringToFront")},bringToBack:function(){return this.invoke("bringToBack")},getBounds:function(){var t,i=new R;for(t in this._layers){var e=this._layers[t];i.extend(e.getBounds?e.getBounds():e.getLatLng())}return i}}),re=Z.extend({options:{popupAnchor:[0,0],tooltipAnchor:[0,0],crossOrigin:!1},initialize:function(t){d(this,t)},createIcon:function(t){return this._createIcon("icon",t)},createShadow:function(t){return this._createIcon("shadow",t)},_createIcon:function(t,i){var e=this._getIconUrl(t);if(!e){if("icon"===t)throw new Error("iconUrl not set in Icon options (see the docs).");return null}i=this._createImg(e,i&&"IMG"===i.tagName?i:null);return this._setIconStyles(i,t),!this.options.crossOrigin&&""!==this.options.crossOrigin||(i.crossOrigin=!0===this.options.crossOrigin?"":this.options.crossOrigin),i},_setIconStyles:function(t,i){var e=this.options,n=e[i+"Size"],o=A(n="number"==typeof n?[n,n]:n),n=A("shadow"===i&&e.shadowAnchor||e.iconAnchor||o&&o.divideBy(2,!0));t.className="leaflet-marker-"+i+" "+(e.className||""),n&&(t.style.marginLeft=-n.x+"px",t.style.marginTop=-n.y+"px"),o&&(t.style.width=o.x+"px",t.style.height=o.y+"px")},_createImg:function(t,i){return(i=i||document.createElement("img")).src=t,i},_getIconUrl:function(t){return Ct.retina&&this.options[t+"RetinaUrl"]||this.options[t+"Url"]}});var ae=re.extend({options:{iconUrl:"marker-icon.png",iconRetinaUrl:"marker-icon-2x.png",shadowUrl:"marker-shadow.png",iconSize:[25,41],iconAnchor:[12,41],popupAnchor:[1,-34],tooltipAnchor:[16,-28],shadowSize:[41,41]},_getIconUrl:function(t){return"string"!=typeof ae.imagePath&&(ae.imagePath=this._detectIconPath()),(this.options.imagePath||ae.imagePath)+re.prototype._getIconUrl.call(this,t)},_stripUrl:function(t){function i(t,i,e){return(t=i.exec(t))&&t[e]}return(t=i(t,/^url\((['"])?(.+)\1\)$/,2))&&i(t,/^(.*)marker-icon\.png$/,1)},_detectIconPath:function(){var t=ii("div","leaflet-default-icon-path",document.body),i=ti(t,"background-image")||ti(t,"backgroundImage");if(document.body.removeChild(t),i=this._stripUrl(i))return i;i=document.querySelector('link[href$="leaflet.css"]');return i?i.href.substring(0,i.href.length-"leaflet.css".length-1):""}}),he=xt.extend({initialize:function(t){this._marker=t},addHooks:function(){var t=this._marker._icon;this._draggable||(this._draggable=new Gi(t,t,!0)),this._draggable.on({dragstart:this._onDragStart,predrag:this._onPreDrag,drag:this._onDrag,dragend:this._onDragEnd},this).enable(),ai(t,"leaflet-marker-draggable")},removeHooks:function(){this._draggable.off({dragstart:this._onDragStart,predrag:this._onPreDrag,drag:this._onDrag,dragend:this._onDragEnd},this).disable(),this._marker._icon&&hi(this._marker._icon,"leaflet-marker-draggable")},moved:function(){return this._draggable&&this._draggable._moved},_adjustPan:function(t){var i=this._marker,e=i._map,n=this._marker.options.autoPanSpeed,o=this._marker.options.autoPanPadding,s=mi(i._icon),r=e.getPixelBounds(),a=e.getPixelOrigin(),o=O(r.min._subtract(a).add(o),r.max._subtract(a).subtract(o));o.contains(s)||(n=A((Math.max(o.max.x,s.x)-o.max.x)/(r.max.x-o.max.x)-(Math.min(o.min.x,s.x)-o.min.x)/(r.min.x-o.min.x),(Math.max(o.max.y,s.y)-o.max.y)/(r.max.y-o.max.y)-(Math.min(o.min.y,s.y)-o.min.y)/(r.min.y-o.min.y)).multiplyBy(n),e.panBy(n,{animate:!1}),this._draggable._newPos._add(n),this._draggable._startPos._add(n),pi(i._icon,this._draggable._newPos),this._onDrag(t),this._panRequest=z(this._adjustPan.bind(this,t)))},_onDragStart:function(){this._oldLatLng=this._marker.getLatLng(),this._marker.closePopup&&this._marker.closePopup(),this._marker.fire("movestart").fire("dragstart")},_onPreDrag:function(t){this._marker.options.autoPan&&(M(this._panRequest),this._panRequest=z(this._adjustPan.bind(this,t)))},_onDrag:function(t){var i=this._marker,e=i._shadow,n=mi(i._icon),o=i._map.layerPointToLatLng(n);e&&pi(e,n),i._latlng=o,t.latlng=o,t.oldLatLng=this._oldLatLng,i.fire("move",t).fire("drag",t)},_onDragEnd:function(t){M(this._panRequest),delete this._oldLatLng,this._marker.fire("moveend").fire("dragend",t)}}),ue=S.extend({options:{icon:new ae,interactive:!0,keyboard:!0,title:"",alt:"",zIndexOffset:0,opacity:1,riseOnHover:!1,riseOffset:250,pane:"markerPane",shadowPane:"shadowPane",bubblingMouseEvents:!1,draggable:!1,autoPan:!1,autoPanPadding:[50,50],autoPanSpeed:10},initialize:function(t,i){d(this,i),this._latlng=j(t)},onAdd:function(t){this._zoomAnimated=this._zoomAnimated&&t.options.markerZoomAnimation,this._zoomAnimated&&t.on("zoomanim",this._animateZoom,this),this._initIcon(),this.update()},onRemove:function(t){this.dragging&&this.dragging.enabled()&&(this.options.draggable=!0,this.dragging.removeHooks()),delete this.dragging,this._zoomAnimated&&t.off("zoomanim",this._animateZoom,this),this._removeIcon(),this._removeShadow()},getEvents:function(){return{zoom:this.update,viewreset:this.update}},getLatLng:function(){return this._latlng},setLatLng:function(t){var i=this._latlng;return this._latlng=j(t),this.update(),this.fire("move",{oldLatLng:i,latlng:this._latlng})},setZIndexOffset:function(t){return this.options.zIndexOffset=t,this.update()},getIcon:function(){return this.options.icon},setIcon:function(t){return this.options.icon=t,this._map&&(this._initIcon(),this.update()),this._popup&&this.bindPopup(this._popup,this._popup.options),this},getElement:function(){return this._icon},update:function(){var t;return this._icon&&this._map&&(t=this._map.latLngToLayerPoint(this._latlng).round(),this._setPos(t)),this},_initIcon:function(){var t=this.options,i="leaflet-zoom-"+(this._zoomAnimated?"animated":"hide"),e=t.icon.createIcon(this._icon),n=!1;e!==this._icon&&(this._icon&&this._removeIcon(),n=!0,t.title&&(e.title=t.title),"IMG"===e.tagName&&(e.alt=t.alt||"")),ai(e,i),t.keyboard&&(e.tabIndex="0"),this._icon=e,t.riseOnHover&&this.on({mouseover:this._bringToFront,mouseout:this._resetZIndex});var o=t.icon.createShadow(this._shadow),e=!1;o!==this._shadow&&(this._removeShadow(),e=!0),o&&(ai(o,i),o.alt=""),this._shadow=o,t.opacity<1&&this._updateOpacity(),n&&this.getPane().appendChild(this._icon),this._initInteraction(),o&&e&&this.getPane(t.shadowPane).appendChild(this._shadow)},_removeIcon:function(){this.options.riseOnHover&&this.off({mouseover:this._bringToFront,mouseout:this._resetZIndex}),ei(this._icon),this.removeInteractiveTarget(this._icon),this._icon=null},_removeShadow:function(){this._shadow&&ei(this._shadow),this._shadow=null},_setPos:function(t){this._icon&&pi(this._icon,t),this._shadow&&pi(this._shadow,t),this._zIndex=t.y+this.options.zIndexOffset,this._resetZIndex()},_updateZIndex:function(t){this._icon&&(this._icon.style.zIndex=this._zIndex+t)},_animateZoom:function(t){t=this._map._latLngToNewLayerPoint(this._latlng,t.zoom,t.center).round();this._setPos(t)},_initInteraction:function(){var t;this.options.interactive&&(ai(this._icon,"leaflet-interactive"),this.addInteractiveTarget(this._icon),he&&(t=this.options.draggable,this.dragging&&(t=this.dragging.enabled(),this.dragging.disable()),this.dragging=new he(this),t&&this.dragging.enable()))},setOpacity:function(t){return this.options.opacity=t,this._map&&this._updateOpacity(),this},_updateOpacity:function(){var t=this.options.opacity;this._icon&&ci(this._icon,t),this._shadow&&ci(this._shadow,t)},_bringToFront:function(){this._updateZIndex(this.options.riseOffset)},_resetZIndex:function(){this._updateZIndex(0)},_getPopupAnchor:function(){return this.options.icon.options.popupAnchor},_getTooltipAnchor:function(){return this.options.icon.options.tooltipAnchor}});var le=S.extend({options:{stroke:!0,color:"#3388ff",weight:3,opacity:1,lineCap:"round",lineJoin:"round",dashArray:null,dashOffset:null,fill:!1,fillColor:null,fillOpacity:.2,fillRule:"evenodd",interactive:!0,bubblingMouseEvents:!0},beforeAdd:function(t){this._renderer=t.getRenderer(this)},onAdd:function(){this._renderer._initPath(this),this._reset(),this._renderer._addPath(this)},onRemove:function(){this._renderer._removePath(this)},redraw:function(){return this._map&&this._renderer._updatePath(this),this},setStyle:function(t){return d(this,t),this._renderer&&(this._renderer._updateStyle(this),this.options.stroke&&t&&Object.prototype.hasOwnProperty.call(t,"weight")&&this._updateBounds()),this},bringToFront:function(){return this._renderer&&this._renderer._bringToFront(this),this},bringToBack:function(){return this._renderer&&this._renderer._bringToBack(this),this},getElement:function(){return this._path},_reset:function(){this._project(),this._update()},_clickTolerance:function(){return(this.options.stroke?this.options.weight/2:0)+(this._renderer.options.tolerance||0)}}),ce=le.extend({options:{fill:!0,radius:10},initialize:function(t,i){d(this,i),this._latlng=j(t),this._radius=this.options.radius},setLatLng:function(t){var i=this._latlng;return this._latlng=j(t),this.redraw(),this.fire("move",{oldLatLng:i,latlng:this._latlng})},getLatLng:function(){return this._latlng},setRadius:function(t){return this.options.radius=this._radius=t,this.redraw()},getRadius:function(){return this._radius},setStyle:function(t){var i=t&&t.radius||this._radius;return le.prototype.setStyle.call(this,t),this.setRadius(i),this},_project:function(){this._point=this._map.latLngToLayerPoint(this._latlng),this._updateBounds()},_updateBounds:function(){var t=this._radius,i=this._radiusY||t,e=this._clickTolerance(),e=[t+e,i+e];this._pxBounds=new I(this._point.subtract(e),this._point.add(e))},_update:function(){this._map&&this._updatePath()},_updatePath:function(){this._renderer._updateCircle(this)},_empty:function(){return this._radius&&!this._renderer._bounds.intersects(this._pxBounds)},_containsPoint:function(t){return t.distanceTo(this._point)<=this._radius+this._clickTolerance()}});var _e=ce.extend({initialize:function(t,i,e){if(d(this,i="number"==typeof i?u({},e,{radius:i}):i),this._latlng=j(t),isNaN(this.options.radius))throw new Error("Circle radius cannot be NaN");this._mRadius=this.options.radius},setRadius:function(t){return this._mRadius=t,this.redraw()},getRadius:function(){return this._mRadius},getBounds:function(){var t=[this._radius,this._radiusY||this._radius];return new R(this._map.layerPointToLatLng(this._point.subtract(t)),this._map.layerPointToLatLng(this._point.add(t)))},setStyle:le.prototype.setStyle,_project:function(){var t,i,e,n,o,s=this._latlng.lng,r=this._latlng.lat,a=this._map,h=a.options.crs;h.distance===W.distance?(o=Math.PI/180,t=this._mRadius/W.R/o,i=a.project([r+t,s]),n=a.project([r-t,s]),e=i.add(n).divideBy(2),n=a.unproject(e).lat,o=Math.acos((Math.cos(t*o)-Math.sin(r*o)*Math.sin(n*o))/(Math.cos(r*o)*Math.cos(n*o)))/o,!isNaN(o)&&0!==o||(o=t/Math.cos(Math.PI/180*r)),this._point=e.subtract(a.getPixelOrigin()),this._radius=isNaN(o)?0:e.x-a.project([n,s-o]).x,this._radiusY=e.y-i.y):(h=h.unproject(h.project(this._latlng).subtract([this._mRadius,0])),this._point=a.latLngToLayerPoint(this._latlng),this._radius=this._point.x-a.latLngToLayerPoint(h).x),this._updateBounds()}});var de=le.extend({options:{smoothFactor:1,noClip:!1},initialize:function(t,i){d(this,i),this._setLatLngs(t)},getLatLngs:function(){return this._latlngs},setLatLngs:function(t){return this._setLatLngs(t),this.redraw()},isEmpty:function(){return!this._latlngs.length},closestLayerPoint:function(t){for(var i=1/0,e=null,n=Qi,o=0,s=this._parts.length;o<s;o++)for(var r=this._parts[o],a=1,h=r.length;a<h;a++){var u,l,c=n(t,u=r[a-1],l=r[a],!0);c<i&&(i=c,e=n(t,u,l))}return e&&(e.distance=Math.sqrt(i)),e},getCenter:function(){if(!this._map)throw new Error("Must add layer to map before using getCenter()");var t,i,e,n,o,s,r=this._rings[0],a=r.length;if(!a)return null;for(i=t=0;t<a-1;t++)i+=r[t].distanceTo(r[t+1])/2;if(0===i)return this._map.layerPointToLatLng(r[0]);for(e=t=0;t<a-1;t++)if(n=r[t],o=r[t+1],i<(e+=s=n.distanceTo(o)))return this._map.layerPointToLatLng([o.x-(s=(e-i)/s)*(o.x-n.x),o.y-s*(o.y-n.y)])},getBounds:function(){return this._bounds},addLatLng:function(t,i){return i=i||this._defaultShape(),t=j(t),i.push(t),this._bounds.extend(t),this.redraw()},_setLatLngs:function(t){this._bounds=new R,this._latlngs=this._convertLatLngs(t)},_defaultShape:function(){return te(this._latlngs)?this._latlngs:this._latlngs[0]},_convertLatLngs:function(t){for(var i=[],e=te(t),n=0,o=t.length;n<o;n++)e?(i[n]=j(t[n]),this._bounds.extend(i[n])):i[n]=this._convertLatLngs(t[n]);return i},_project:function(){var t=new I;this._rings=[],this._projectLatlngs(this._latlngs,this._rings,t),this._bounds.isValid()&&t.isValid()&&(this._rawPxBounds=t,this._updateBounds())},_updateBounds:function(){var t=this._clickTolerance(),t=new E(t,t);this._rawPxBounds&&(this._pxBounds=new I([this._rawPxBounds.min.subtract(t),this._rawPxBounds.max.add(t)]))},_projectLatlngs:function(t,i,e){var n,o,s=t[0]instanceof D,r=t.length;if(s){for(o=[],n=0;n<r;n++)o[n]=this._map.latLngToLayerPoint(t[n]),e.extend(o[n]);i.push(o)}else for(n=0;n<r;n++)this._projectLatlngs(t[n],i,e)},_clipPoints:function(){var t=this._renderer._bounds;if(this._parts=[],this._pxBounds&&this._pxBounds.intersects(t))if(this.options.noClip)this._parts=this._rings;else for(var i,e,n,o,s=this._parts,r=0,a=0,h=this._rings.length;r<h;r++)for(i=0,e=(o=this._rings[r]).length;i<e-1;i++)(n=Xi(o[i],o[i+1],t,i,!0))&&(s[a]=s[a]||[],s[a].push(n[0]),n[1]===o[i+1]&&i!==e-2||(s[a].push(n[1]),a++))},_simplifyPoints:function(){for(var t=this._parts,i=this.options.smoothFactor,e=0,n=t.length;e<n;e++)t[e]=Ki(t[e],i)},_update:function(){this._map&&(this._clipPoints(),this._simplifyPoints(),this._updatePath())},_updatePath:function(){this._renderer._updatePoly(this)},_containsPoint:function(t,i){var e,n,o,s,r,a,h=this._clickTolerance();if(!this._pxBounds||!this._pxBounds.contains(t))return!1;for(e=0,s=this._parts.length;e<s;e++)for(n=0,o=(r=(a=this._parts[e]).length)-1;n<r;o=n++)if((i||0!==n)&&Yi(t,a[o],a[n])<=h)return!0;return!1}});de._flat=ie;var pe=de.extend({options:{fill:!0},isEmpty:function(){return!this._latlngs.length||!this._latlngs[0].length},getCenter:function(){if(!this._map)throw new Error("Must add layer to map before using getCenter()");var t,i,e,n,o,s,r,a,h,u=this._rings[0],l=u.length;if(!l)return null;for(t=s=r=a=0,i=l-1;t<l;i=t++)e=u[t],n=u[i],o=e.y*n.x-n.y*e.x,r+=(e.x+n.x)*o,a+=(e.y+n.y)*o,s+=3*o;return h=0===s?u[0]:[r/s,a/s],this._map.layerPointToLatLng(h)},_convertLatLngs:function(t){var i=de.prototype._convertLatLngs.call(this,t),t=i.length;return 2<=t&&i[0]instanceof D&&i[0].equals(i[t-1])&&i.pop(),i},_setLatLngs:function(t){de.prototype._setLatLngs.call(this,t),te(this._latlngs)&&(this._latlngs=[this._latlngs])},_defaultShape:function(){return(te(this._latlngs[0])?this._latlngs:this._latlngs[0])[0]},_clipPoints:function(){var t=this._renderer._bounds,i=this.options.weight,i=new E(i,i),t=new I(t.min.subtract(i),t.max.add(i));if(this._parts=[],this._pxBounds&&this._pxBounds.intersects(t))if(this.options.noClip)this._parts=this._rings;else for(var e,n=0,o=this._rings.length;n<o;n++)(e=ee(this._rings[n],t,!0)).length&&this._parts.push(e)},_updatePath:function(){this._renderer._updatePoly(this,!0)},_containsPoint:function(t){var i,e,n,o,s,r,a,h,u=!1;if(!this._pxBounds||!this._pxBounds.contains(t))return!1;for(o=0,a=this._parts.length;o<a;o++)for(s=0,r=(h=(i=this._parts[o]).length)-1;s<h;r=s++)e=i[s],n=i[r],e.y>t.y!=n.y>t.y&&t.x<(n.x-e.x)*(t.y-e.y)/(n.y-e.y)+e.x&&(u=!u);return u||de.prototype._containsPoint.call(this,t,!0)}});var me=se.extend({initialize:function(t,i){d(this,i),this._layers={},t&&this.addData(t)},addData:function(t){var i,e,n,o=g(t)?t:t.features;if(o){for(i=0,e=o.length;i<e;i++)((n=o[i]).geometries||n.geometry||n.features||n.coordinates)&&this.addData(n);return this}var s=this.options;if(s.filter&&!s.filter(t))return this;var r=fe(t,s);return r?(r.feature=be(t),r.defaultOptions=r.options,this.resetStyle(r),s.onEachFeature&&s.onEachFeature(t,r),this.addLayer(r)):this},resetStyle:function(t){return void 0===t?this.eachLayer(this.resetStyle,this):(t.options=u({},t.defaultOptions),this._setLayerStyle(t,this.options.style),this)},setStyle:function(i){return this.eachLayer(function(t){this._setLayerStyle(t,i)},this)},_setLayerStyle:function(t,i){t.setStyle&&("function"==typeof i&&(i=i(t.feature)),t.setStyle(i))}});function fe(t,i){var e,n,o,s,r="Feature"===t.type?t.geometry:t,a=r?r.coordinates:null,h=[],u=i&&i.pointToLayer,l=i&&i.coordsToLatLng||ve;if(!a&&!r)return null;switch(r.type){case"Point":return ge(u,t,e=l(a),i);case"MultiPoint":for(o=0,s=a.length;o<s;o++)e=l(a[o]),h.push(ge(u,t,e,i));return new se(h);case"LineString":case"MultiLineString":return n=ye(a,"LineString"===r.type?0:1,l),new de(n,i);case"Polygon":case"MultiPolygon":return n=ye(a,"Polygon"===r.type?1:2,l),new pe(n,i);case"GeometryCollection":for(o=0,s=r.geometries.length;o<s;o++){var c=fe({geometry:r.geometries[o],type:"Feature",properties:t.properties},i);c&&h.push(c)}return new se(h);default:throw new Error("Invalid GeoJSON object.")}}function ge(t,i,e,n){return t?t(i,e):new ue(e,n&&n.markersInheritOptions&&n)}function ve(t){return new D(t[1],t[0],t[2])}function ye(t,i,e){for(var n,o=[],s=0,r=t.length;s<r;s++)n=i?ye(t[s],i-1,e):(e||ve)(t[s]),o.push(n);return o}function xe(t,i){return void 0!==t.alt?[r(t.lng,i),r(t.lat,i),r(t.alt,i)]:[r(t.lng,i),r(t.lat,i)]}function we(t,i,e,n){for(var o=[],s=0,r=t.length;s<r;s++)o.push(i?we(t[s],i-1,e,n):xe(t[s],n));return!i&&e&&o.push(o[0]),o}function Pe(t,i){return t.feature?u({},t.feature,{geometry:i}):be(i)}function be(t){return"Feature"===t.type||"FeatureCollection"===t.type?t:{type:"Feature",properties:{},geometry:t}}U={toGeoJSON:function(t){return Pe(this,{type:"Point",coordinates:xe(this.getLatLng(),t)})}};function Le(t,i){return new me(t,i)}ue.include(U),_e.include(U),ce.include(U),de.include({toGeoJSON:function(t){var i=!te(this._latlngs);return Pe(this,{type:(i?"Multi":"")+"LineString",coordinates:we(this._latlngs,i?1:0,!1,t)})}}),pe.include({toGeoJSON:function(t){var i=!te(this._latlngs),e=i&&!te(this._latlngs[0]),t=we(this._latlngs,e?2:i?1:0,!0,t);return Pe(this,{type:(e?"Multi":"")+"Polygon",coordinates:t=!i?[t]:t})}}),oe.include({toMultiPoint:function(i){var e=[];return this.eachLayer(function(t){e.push(t.toGeoJSON(i).geometry.coordinates)}),Pe(this,{type:"MultiPoint",coordinates:e})},toGeoJSON:function(i){var t=this.feature&&this.feature.geometry&&this.feature.geometry.type;if("MultiPoint"===t)return this.toMultiPoint(i);var e="GeometryCollection"===t,n=[];return this.eachLayer(function(t){t.toGeoJSON&&(t=t.toGeoJSON(i),e?n.push(t.geometry):"FeatureCollection"===(t=be(t)).type?n.push.apply(n,t.features):n.push(t))}),e?Pe(this,{geometries:n,type:"GeometryCollection"}):{type:"FeatureCollection",features:n}}});var F=Le,Te=S.extend({options:{opacity:1,alt:"",interactive:!1,crossOrigin:!1,errorOverlayUrl:"",zIndex:1,className:""},initialize:function(t,i,e){this._url=t,this._bounds=N(i),d(this,e)},onAdd:function(){this._image||(this._initImage(),this.options.opacity<1&&this._updateOpacity()),this.options.interactive&&(ai(this._image,"leaflet-interactive"),this.addInteractiveTarget(this._image)),this.getPane().appendChild(this._image),this._reset()},onRemove:function(){ei(this._image),this.options.interactive&&this.removeInteractiveTarget(this._image)},setOpacity:function(t){return this.options.opacity=t,this._image&&this._updateOpacity(),this},setStyle:function(t){return t.opacity&&this.setOpacity(t.opacity),this},bringToFront:function(){return this._map&&oi(this._image),this},bringToBack:function(){return this._map&&si(this._image),this},setUrl:function(t){return this._url=t,this._image&&(this._image.src=t),this},setBounds:function(t){return this._bounds=N(t),this._map&&this._reset(),this},getEvents:function(){var t={zoom:this._reset,viewreset:this._reset};return this._zoomAnimated&&(t.zoomanim=this._animateZoom),t},setZIndex:function(t){return this.options.zIndex=t,this._updateZIndex(),this},getBounds:function(){return this._bounds},getElement:function(){return this._image},_initImage:function(){var t="IMG"===this._url.tagName,i=this._image=t?this._url:ii("img");ai(i,"leaflet-image-layer"),this._zoomAnimated&&ai(i,"leaflet-zoom-animated"),this.options.className&&ai(i,this.options.className),i.onselectstart=l,i.onmousemove=l,i.onload=a(this.fire,this,"load"),i.onerror=a(this._overlayOnError,this,"error"),!this.options.crossOrigin&&""!==this.options.crossOrigin||(i.crossOrigin=!0===this.options.crossOrigin?"":this.options.crossOrigin),this.options.zIndex&&this._updateZIndex(),t?this._url=i.src:(i.src=this._url,i.alt=this.options.alt)},_animateZoom:function(t){var i=this._map.getZoomScale(t.zoom),t=this._map._latLngBoundsToNewLayerBounds(this._bounds,t.zoom,t.center).min;di(this._image,t,i)},_reset:function(){var t=this._image,i=new I(this._map.latLngToLayerPoint(this._bounds.getNorthWest()),this._map.latLngToLayerPoint(this._bounds.getSouthEast())),e=i.getSize();pi(t,i.min),t.style.width=e.x+"px",t.style.height=e.y+"px"},_updateOpacity:function(){ci(this._image,this.options.opacity)},_updateZIndex:function(){this._image&&void 0!==this.options.zIndex&&null!==this.options.zIndex&&(this._image.style.zIndex=this.options.zIndex)},_overlayOnError:function(){this.fire("error");var t=this.options.errorOverlayUrl;t&&this._url!==t&&(this._url=t,this._image.src=t)}}),ze=Te.extend({options:{autoplay:!0,loop:!0,keepAspectRatio:!0,muted:!1},_initImage:function(){var t="VIDEO"===this._url.tagName,i=this._image=t?this._url:ii("video");if(ai(i,"leaflet-image-layer"),this._zoomAnimated&&ai(i,"leaflet-zoom-animated"),this.options.className&&ai(i,this.options.className),i.onselectstart=l,i.onmousemove=l,i.onloadeddata=a(this.fire,this,"load"),t){for(var e=i.getElementsByTagName("source"),n=[],o=0;o<e.length;o++)n.push(e[o].src);this._url=0<e.length?n:[i.src]}else{g(this._url)||(this._url=[this._url]),!this.options.keepAspectRatio&&Object.prototype.hasOwnProperty.call(i.style,"objectFit")&&(i.style.objectFit="fill"),i.autoplay=!!this.options.autoplay,i.loop=!!this.options.loop,i.muted=!!this.options.muted;for(var s=0;s<this._url.length;s++){var r=ii("source");r.src=this._url[s],i.appendChild(r)}}}});var Me=Te.extend({_initImage:function(){var t=this._image=this._url;ai(t,"leaflet-image-layer"),this._zoomAnimated&&ai(t,"leaflet-zoom-animated"),this.options.className&&ai(t,this.options.className),t.onselectstart=l,t.onmousemove=l}});var Ce=S.extend({options:{offset:[0,7],className:"",pane:"popupPane"},initialize:function(t,i){d(this,t),this._source=i},onAdd:function(t){this._zoomAnimated=t._zoomAnimated,this._container||this._initLayout(),t._fadeAnimated&&ci(this._container,0),clearTimeout(this._removeTimeout),this.getPane().appendChild(this._container),this.update(),t._fadeAnimated&&ci(this._container,1),this.bringToFront()},onRemove:function(t){t._fadeAnimated?(ci(this._container,0),this._removeTimeout=setTimeout(a(ei,void 0,this._container),200)):ei(this._container)},getLatLng:function(){return this._latlng},setLatLng:function(t){return this._latlng=j(t),this._map&&(this._updatePosition(),this._adjustPan()),this},getContent:function(){return this._content},setContent:function(t){return this._content=t,this.update(),this},getElement:function(){return this._container},update:function(){this._map&&(this._container.style.visibility="hidden",this._updateContent(),this._updateLayout(),this._updatePosition(),this._container.style.visibility="",this._adjustPan())},getEvents:function(){var t={zoom:this._updatePosition,viewreset:this._updatePosition};return this._zoomAnimated&&(t.zoomanim=this._animateZoom),t},isOpen:function(){return!!this._map&&this._map.hasLayer(this)},bringToFront:function(){return this._map&&oi(this._container),this},bringToBack:function(){return this._map&&si(this._container),this},_prepareOpen:function(t){if(!(e=this._source)._map)return!1;if(e instanceof se){var i,e=null,n=this._source._layers;for(i in n)if(n[i]._map){e=n[i];break}if(!e)return!1;this._source=e}if(!t)if(e.getCenter)t=e.getCenter();else if(e.getLatLng)t=e.getLatLng();else{if(!e.getBounds)throw new Error("Unable to get source layer LatLng.");t=e.getBounds().getCenter()}return this.setLatLng(t),this._map&&this.update(),!0},_updateContent:function(){if(this._content){var t=this._contentNode,i="function"==typeof this._content?this._content(this._source||this):this._content;if("string"==typeof i)t.innerHTML=i;else{for(;t.hasChildNodes();)t.removeChild(t.firstChild);t.appendChild(i)}this.fire("contentupdate")}},_updatePosition:function(){var t,i,e;this._map&&(t=this._map.latLngToLayerPoint(this._latlng),e=A(this.options.offset),i=this._getAnchor(),this._zoomAnimated?pi(this._container,t.add(i)):e=e.add(t).add(i),i=this._containerBottom=-e.y,e=this._containerLeft=-Math.round(this._containerWidth/2)+e.x,this._container.style.bottom=i+"px",this._container.style.left=e+"px")},_getAnchor:function(){return[0,0]}}),Ze=Ce.extend({options:{maxWidth:300,minWidth:50,maxHeight:null,autoPan:!0,autoPanPaddingTopLeft:null,autoPanPaddingBottomRight:null,autoPanPadding:[5,5],keepInView:!1,closeButton:!0,autoClose:!0,closeOnEscapeKey:!0,className:""},openOn:function(t){return t.openPopup(this),this},onAdd:function(t){Ce.prototype.onAdd.call(this,t),t.fire("popupopen",{popup:this}),this._source&&(this._source.fire("popupopen",{popup:this},!0),this._source instanceof le||this._source.on("preclick",Zi))},onRemove:function(t){Ce.prototype.onRemove.call(this,t),t.fire("popupclose",{popup:this}),this._source&&(this._source.fire("popupclose",{popup:this},!0),this._source instanceof le||this._source.off("preclick",Zi))},getEvents:function(){var t=Ce.prototype.getEvents.call(this);return(void 0!==this.options.closeOnClick?this.options.closeOnClick:this._map.options.closePopupOnClick)&&(t.preclick=this._close),this.options.keepInView&&(t.moveend=this._adjustPan),t},_close:function(){this._map&&this._map.closePopup(this)},_initLayout:function(){var t="leaflet-popup",i=this._container=ii("div",t+" "+(this.options.className||"")+" leaflet-zoom-animated"),e=this._wrapper=ii("div",t+"-content-wrapper",i);this._contentNode=ii("div",t+"-content",e),ki(i),Si(this._contentNode),Pi(i,"contextmenu",Zi),this._tipContainer=ii("div",t+"-tip-container",i),this._tip=ii("div",t+"-tip",this._tipContainer),this.options.closeButton&&((i=this._closeButton=ii("a",t+"-close-button",i)).setAttribute("role","button"),i.setAttribute("aria-label","Close popup"),i.href="#close",i.innerHTML='<span aria-hidden="true">&#215;</span>',Pi(i,"click",this._close,this))},_updateLayout:function(){var t=this._contentNode,i=t.style;i.width="",i.whiteSpace="nowrap";var e=t.offsetWidth,e=Math.min(e,this.options.maxWidth);e=Math.max(e,this.options.minWidth),i.width=e+1+"px",i.whiteSpace="",i.height="";var n=t.offsetHeight,o=this.options.maxHeight,e="leaflet-popup-scrolled";o&&o<n?(i.height=o+"px",ai(t,e)):hi(t,e),this._containerWidth=this._container.offsetWidth},_animateZoom:function(t){var i=this._map._latLngToNewLayerPoint(this._latlng,t.zoom,t.center),t=this._getAnchor();pi(this._container,i.add(t))},_adjustPan:function(t){var i,e,n,o,s,r,a,h;this.options.autoPan&&(this._map._panAnim&&this._map._panAnim.stop(),i=this._map,s=parseInt(ti(this._container,"marginBottom"),10)||0,e=this._container.offsetHeight+s,h=this._containerWidth,(r=new E(this._containerLeft,-e-this._containerBottom))._add(mi(this._container)),n=i.layerPointToContainerPoint(r),a=A(this.options.autoPanPadding),o=A(this.options.autoPanPaddingTopLeft||a),s=A(this.options.autoPanPaddingBottomRight||a),r=i.getSize(),a=0,n.x+h+s.x>r.x&&(a=n.x+h-r.x+s.x),n.x-a-o.x<(h=0)&&(a=n.x-o.x),n.y+e+s.y>r.y&&(h=n.y+e-r.y+s.y),n.y-h-o.y<0&&(h=n.y-o.y),(a||h)&&i.fire("autopanstart").panBy([a,h],{animate:t&&"moveend"===t.type}))},_getAnchor:function(){return A(this._source&&this._source._getPopupAnchor?this._source._getPopupAnchor():[0,0])}});Di.mergeOptions({closePopupOnClick:!0}),Di.include({openPopup:function(t,i,e){return t instanceof Ze||(t=new Ze(e).setContent(t)),i&&t.setLatLng(i),this.hasLayer(t)?this:(this._popup&&this._popup.options.autoClose&&this.closePopup(),this._popup=t,this.addLayer(t))},closePopup:function(t){return t&&t!==this._popup||(t=this._popup,this._popup=null),t&&this.removeLayer(t),this}}),S.include({bindPopup:function(t,i){return t instanceof Ze?(d(t,i),(this._popup=t)._source=this):(this._popup&&!i||(this._popup=new Ze(i,this)),this._popup.setContent(t)),this._popupHandlersAdded||(this.on({click:this._openPopup,keypress:this._onKeyPress,remove:this.closePopup,move:this._movePopup}),this._popupHandlersAdded=!0),this},unbindPopup:function(){return this._popup&&(this.off({click:this._openPopup,keypress:this._onKeyPress,remove:this.closePopup,move:this._movePopup}),this._popupHandlersAdded=!1,this._popup=null),this},openPopup:function(t){return this._popup&&this._popup._prepareOpen(t)&&this._map.openPopup(this._popup,t),this},closePopup:function(){return this._popup&&this._popup._close(),this},togglePopup:function(){return this._popup&&(this._popup._map?this.closePopup():this.openPopup()),this},isPopupOpen:function(){return!!this._popup&&this._popup.isOpen()},setPopupContent:function(t){return this._popup&&this._popup.setContent(t),this},getPopup:function(){return this._popup},_openPopup:function(t){var i;this._popup&&this._map&&(Bi(t),i=t.layer||t.target,this._popup._source!==i||i instanceof le?(this._popup._source=i,this.openPopup(t.latlng)):this._map.hasLayer(this._popup)?this.closePopup():this.openPopup(t.latlng))},_movePopup:function(t){this._popup.setLatLng(t.latlng)},_onKeyPress:function(t){13===t.originalEvent.keyCode&&this._openPopup(t)}});var Se=Ce.extend({options:{pane:"tooltipPane",offset:[0,0],direction:"auto",permanent:!1,sticky:!1,interactive:!1,opacity:.9},onAdd:function(t){Ce.prototype.onAdd.call(this,t),this.setOpacity(this.options.opacity),this.options.interactive&&(ai(this._container,"leaflet-interactive"),this._source&&this._source.addInteractiveTarget(this._container)),t.fire("tooltipopen",{tooltip:this}),this._source&&this._source.fire("tooltipopen",{tooltip:this},!0)},onRemove:function(t){Ce.prototype.onRemove.call(this,t),this.options.interactive&&(hi(this._container,"leaflet-interactive"),this._source&&this._source.removeInteractiveTarget(this._container)),t.fire("tooltipclose",{tooltip:this}),this._source&&this._source.fire("tooltipclose",{tooltip:this},!0)},getEvents:function(){var t=Ce.prototype.getEvents.call(this);return this.options.permanent||(t.preclick=this._close),t},_close:function(){this._map&&this._map.closeTooltip(this)},_initLayout:function(){var t="leaflet-tooltip "+(this.options.className||"")+" leaflet-zoom-"+(this._zoomAnimated?"animated":"hide");this._contentNode=this._container=ii("div",t)},_updateLayout:function(){},_adjustPan:function(){},_setPosition:function(t){var i,e=this._map,n=this._container,o=e.latLngToContainerPoint(e.getCenter()),s=e.layerPointToContainerPoint(t),r=this.options.direction,a=n.offsetWidth,h=n.offsetHeight,u=A(this.options.offset),e=this._getAnchor(),h="top"===r?(i=a/2,h):"bottom"===r?(i=a/2,0):(i="center"===r?a/2:"right"===r?0:"left"===r?a:s.x<o.x?(r="right",0):(r="left",a+2*(u.x+e.x)),h/2);t=t.subtract(A(i,h,!0)).add(u).add(e),hi(n,"leaflet-tooltip-right"),hi(n,"leaflet-tooltip-left"),hi(n,"leaflet-tooltip-top"),hi(n,"leaflet-tooltip-bottom"),ai(n,"leaflet-tooltip-"+r),pi(n,t)},_updatePosition:function(){var t=this._map.latLngToLayerPoint(this._latlng);this._setPosition(t)},setOpacity:function(t){this.options.opacity=t,this._container&&ci(this._container,t)},_animateZoom:function(t){t=this._map._latLngToNewLayerPoint(this._latlng,t.zoom,t.center);this._setPosition(t)},_getAnchor:function(){return A(this._source&&this._source._getTooltipAnchor&&!this.options.sticky?this._source._getTooltipAnchor():[0,0])}});Di.include({openTooltip:function(t,i,e){return t instanceof Se||(t=new Se(e).setContent(t)),i&&t.setLatLng(i),this.hasLayer(t)?this:this.addLayer(t)},closeTooltip:function(t){return this.removeLayer(t)}}),S.include({bindTooltip:function(t,i){return this._tooltip&&this.isTooltipOpen()&&this.unbindTooltip(),t instanceof Se?(d(t,i),(this._tooltip=t)._source=this):(this._tooltip&&!i||(this._tooltip=new Se(i,this)),this._tooltip.setContent(t)),this._initTooltipInteractions(),this._tooltip.options.permanent&&this._map&&this._map.hasLayer(this)&&this.openTooltip(),this},unbindTooltip:function(){return this._tooltip&&(this._initTooltipInteractions(!0),this.closeTooltip(),this._tooltip=null),this},_initTooltipInteractions:function(t){var i,e;!t&&this._tooltipHandlersAdded||(i=t?"off":"on",e={remove:this.closeTooltip,move:this._moveTooltip},this._tooltip.options.permanent?e.add=this._openTooltip:(e.mouseover=this._openTooltip,e.mouseout=this.closeTooltip,e.click=this._openTooltip),this._tooltip.options.sticky&&(e.mousemove=this._moveTooltip),this[i](e),this._tooltipHandlersAdded=!t)},openTooltip:function(t){return this._tooltip&&this._tooltip._prepareOpen(t)&&this._map.openTooltip(this._tooltip,t),this},closeTooltip:function(){return this._tooltip&&this._tooltip._close(),this},toggleTooltip:function(){return this._tooltip&&(this._tooltip._map?this.closeTooltip():this.openTooltip()),this},isTooltipOpen:function(){return this._tooltip.isOpen()},setTooltipContent:function(t){return this._tooltip&&this._tooltip.setContent(t),this},getTooltip:function(){return this._tooltip},_openTooltip:function(t){this._tooltip&&this._map&&(this._tooltip._source=t.layer||t.target,this.openTooltip(this._tooltip.options.sticky?t.latlng:void 0))},_moveTooltip:function(t){var i=t.latlng;this._tooltip.options.sticky&&t.originalEvent&&(t=this._map.mouseEventToContainerPoint(t.originalEvent),t=this._map.containerPointToLayerPoint(t),i=this._map.layerPointToLatLng(t)),this._tooltip.setLatLng(i)}});var ke=re.extend({options:{iconSize:[12,12],html:!1,bgPos:null,className:"leaflet-div-icon"},createIcon:function(t){var i=t&&"DIV"===t.tagName?t:document.createElement("div"),t=this.options;return t.html instanceof Element?(ni(i),i.appendChild(t.html)):i.innerHTML=!1!==t.html?t.html:"",t.bgPos&&(t=A(t.bgPos),i.style.backgroundPosition=-t.x+"px "+-t.y+"px"),this._setIconStyles(i,"icon"),i},createShadow:function(){return null}});re.Default=ae;var Ee=S.extend({options:{tileSize:256,opacity:1,updateWhenIdle:Ct.mobile,updateWhenZooming:!0,updateInterval:200,zIndex:1,bounds:null,minZoom:0,maxZoom:void 0,maxNativeZoom:void 0,minNativeZoom:void 0,noWrap:!1,pane:"tilePane",className:"",keepBuffer:2},initialize:function(t){d(this,t)},onAdd:function(){this._initContainer(),this._levels={},this._tiles={},this._resetView()},beforeAdd:function(t){t._addZoomLimit(this)},onRemove:function(t){this._removeAllTiles(),ei(this._container),t._removeZoomLimit(this),this._container=null,this._tileZoom=void 0},bringToFront:function(){return this._map&&(oi(this._container),this._setAutoZIndex(Math.max)),this},bringToBack:function(){return this._map&&(si(this._container),this._setAutoZIndex(Math.min)),this},getContainer:function(){return this._container},setOpacity:function(t){return this.options.opacity=t,this._updateOpacity(),this},setZIndex:function(t){return this.options.zIndex=t,this._updateZIndex(),this},isLoading:function(){return this._loading},redraw:function(){var t;return this._map&&(this._removeAllTiles(),(t=this._clampZoom(this._map.getZoom()))!==this._tileZoom&&(this._tileZoom=t,this._updateLevels()),this._update()),this},getEvents:function(){var t={viewprereset:this._invalidateAll,viewreset:this._resetView,zoom:this._resetView,moveend:this._onMoveEnd};return this.options.updateWhenIdle||(this._onMove||(this._onMove=n(this._onMoveEnd,this.options.updateInterval,this)),t.move=this._onMove),this._zoomAnimated&&(t.zoomanim=this._animateZoom),t},createTile:function(){return document.createElement("div")},getTileSize:function(){var t=this.options.tileSize;return t instanceof E?t:new E(t,t)},_updateZIndex:function(){this._container&&void 0!==this.options.zIndex&&null!==this.options.zIndex&&(this._container.style.zIndex=this.options.zIndex)},_setAutoZIndex:function(t){for(var i,e=this.getPane().children,n=-t(-1/0,1/0),o=0,s=e.length;o<s;o++)i=e[o].style.zIndex,e[o]!==this._container&&i&&(n=t(n,+i));isFinite(n)&&(this.options.zIndex=n+t(-1,1),this._updateZIndex())},_updateOpacity:function(){if(this._map&&!Ct.ielt9){ci(this._container,this.options.opacity);var t,i=+new Date,e=!1,n=!1;for(t in this._tiles){var o,s=this._tiles[t];s.current&&s.loaded&&(o=Math.min(1,(i-s.loaded)/200),ci(s.el,o),o<1?e=!0:(s.active?n=!0:this._onOpaqueTile(s),s.active=!0))}n&&!this._noPrune&&this._pruneTiles(),e&&(M(this._fadeFrame),this._fadeFrame=z(this._updateOpacity,this))}},_onOpaqueTile:l,_initContainer:function(){this._container||(this._container=ii("div","leaflet-layer "+(this.options.className||"")),this._updateZIndex(),this.options.opacity<1&&this._updateOpacity(),this.getPane().appendChild(this._container))},_updateLevels:function(){var t=this._tileZoom,i=this.options.maxZoom;if(void 0!==t){for(var e in this._levels)e=Number(e),this._levels[e].el.children.length||e===t?(this._levels[e].el.style.zIndex=i-Math.abs(t-e),this._onUpdateLevel(e)):(ei(this._levels[e].el),this._removeTilesAtZoom(e),this._onRemoveLevel(e),delete this._levels[e]);var n=this._levels[t],o=this._map;return n||((n=this._levels[t]={}).el=ii("div","leaflet-tile-container leaflet-zoom-animated",this._container),n.el.style.zIndex=i,n.origin=o.project(o.unproject(o.getPixelOrigin()),t).round(),n.zoom=t,this._setZoomTransform(n,o.getCenter(),o.getZoom()),l(n.el.offsetWidth),this._onCreateLevel(n)),this._level=n}},_onUpdateLevel:l,_onRemoveLevel:l,_onCreateLevel:l,_pruneTiles:function(){if(this._map){var t,i,e,n=this._map.getZoom();if(n>this.options.maxZoom||n<this.options.minZoom)this._removeAllTiles();else{for(t in this._tiles)(e=this._tiles[t]).retain=e.current;for(t in this._tiles)(e=this._tiles[t]).current&&!e.active&&(i=e.coords,this._retainParent(i.x,i.y,i.z,i.z-5)||this._retainChildren(i.x,i.y,i.z,i.z+2));for(t in this._tiles)this._tiles[t].retain||this._removeTile(t)}}},_removeTilesAtZoom:function(t){for(var i in this._tiles)this._tiles[i].coords.z===t&&this._removeTile(i)},_removeAllTiles:function(){for(var t in this._tiles)this._removeTile(t)},_invalidateAll:function(){for(var t in this._levels)ei(this._levels[t].el),this._onRemoveLevel(Number(t)),delete this._levels[t];this._removeAllTiles(),this._tileZoom=void 0},_retainParent:function(t,i,e,n){var o=Math.floor(t/2),t=Math.floor(i/2),i=e-1,e=new E(+o,+t);e.z=+i;e=this._tileCoordsToKey(e),e=this._tiles[e];return e&&e.active?e.retain=!0:(e&&e.loaded&&(e.retain=!0),n<i&&this._retainParent(o,t,i,n))},_retainChildren:function(t,i,e,n){for(var o=2*t;o<2*t+2;o++)for(var s=2*i;s<2*i+2;s++){var r=new E(o,s);r.z=e+1;r=this._tileCoordsToKey(r),r=this._tiles[r];r&&r.active?r.retain=!0:(r&&r.loaded&&(r.retain=!0),e+1<n&&this._retainChildren(o,s,e+1,n))}},_resetView:function(t){t=t&&(t.pinch||t.flyTo);this._setView(this._map.getCenter(),this._map.getZoom(),t,t)},_animateZoom:function(t){this._setView(t.center,t.zoom,!0,t.noUpdate)},_clampZoom:function(t){var i=this.options;return void 0!==i.minNativeZoom&&t<i.minNativeZoom?i.minNativeZoom:void 0!==i.maxNativeZoom&&i.maxNativeZoom<t?i.maxNativeZoom:t},_setView:function(t,i,e,n){var o=Math.round(i),o=void 0!==this.options.maxZoom&&o>this.options.maxZoom||void 0!==this.options.minZoom&&o<this.options.minZoom?void 0:this._clampZoom(o),s=this.options.updateWhenZooming&&o!==this._tileZoom;n&&!s||(this._tileZoom=o,this._abortLoading&&this._abortLoading(),this._updateLevels(),this._resetGrid(),void 0!==o&&this._update(t),e||this._pruneTiles(),this._noPrune=!!e),this._setZoomTransforms(t,i)},_setZoomTransforms:function(t,i){for(var e in this._levels)this._setZoomTransform(this._levels[e],t,i)},_setZoomTransform:function(t,i,e){var n=this._map.getZoomScale(e,t.zoom),e=t.origin.multiplyBy(n).subtract(this._map._getNewPixelOrigin(i,e)).round();Ct.any3d?di(t.el,e,n):pi(t.el,e)},_resetGrid:function(){var t=this._map,i=t.options.crs,e=this._tileSize=this.getTileSize(),n=this._tileZoom,o=this._map.getPixelWorldBounds(this._tileZoom);o&&(this._globalTileRange=this._pxBoundsToTileRange(o)),this._wrapX=i.wrapLng&&!this.options.noWrap&&[Math.floor(t.project([0,i.wrapLng[0]],n).x/e.x),Math.ceil(t.project([0,i.wrapLng[1]],n).x/e.y)],this._wrapY=i.wrapLat&&!this.options.noWrap&&[Math.floor(t.project([i.wrapLat[0],0],n).y/e.x),Math.ceil(t.project([i.wrapLat[1],0],n).y/e.y)]},_onMoveEnd:function(){this._map&&!this._map._animatingZoom&&this._update()},_getTiledPixelBounds:function(t){var i=this._map,e=i._animatingZoom?Math.max(i._animateToZoom,i.getZoom()):i.getZoom(),e=i.getZoomScale(e,this._tileZoom),t=i.project(t,this._tileZoom).floor(),e=i.getSize().divideBy(2*e);return new I(t.subtract(e),t.add(e))},_update:function(t){var i=this._map;if(i){var e=this._clampZoom(i.getZoom());if(void 0===t&&(t=i.getCenter()),void 0!==this._tileZoom){var n,i=this._getTiledPixelBounds(t),o=this._pxBoundsToTileRange(i),s=o.getCenter(),r=[],i=this.options.keepBuffer,a=new I(o.getBottomLeft().subtract([i,-i]),o.getTopRight().add([i,-i]));if(!(isFinite(o.min.x)&&isFinite(o.min.y)&&isFinite(o.max.x)&&isFinite(o.max.y)))throw new Error("Attempted to load an infinite number of tiles");for(n in this._tiles){var h=this._tiles[n].coords;h.z===this._tileZoom&&a.contains(new E(h.x,h.y))||(this._tiles[n].current=!1)}if(1<Math.abs(e-this._tileZoom))this._setView(t,e);else{for(var u=o.min.y;u<=o.max.y;u++)for(var l=o.min.x;l<=o.max.x;l++){var c,_=new E(l,u);_.z=this._tileZoom,this._isValidTile(_)&&((c=this._tiles[this._tileCoordsToKey(_)])?c.current=!0:r.push(_))}if(r.sort(function(t,i){return t.distanceTo(s)-i.distanceTo(s)}),0!==r.length){this._loading||(this._loading=!0,this.fire("loading"));for(var d=document.createDocumentFragment(),l=0;l<r.length;l++)this._addTile(r[l],d);this._level.el.appendChild(d)}}}}},_isValidTile:function(t){var i=this._map.options.crs;if(!i.infinite){var e=this._globalTileRange;if(!i.wrapLng&&(t.x<e.min.x||t.x>e.max.x)||!i.wrapLat&&(t.y<e.min.y||t.y>e.max.y))return!1}if(!this.options.bounds)return!0;t=this._tileCoordsToBounds(t);return N(this.options.bounds).overlaps(t)},_keyToBounds:function(t){return this._tileCoordsToBounds(this._keyToTileCoords(t))},_tileCoordsToNwSe:function(t){var i=this._map,e=this.getTileSize(),n=t.scaleBy(e),e=n.add(e);return[i.unproject(n,t.z),i.unproject(e,t.z)]},_tileCoordsToBounds:function(t){t=this._tileCoordsToNwSe(t),t=new R(t[0],t[1]);return t=!this.options.noWrap?this._map.wrapLatLngBounds(t):t},_tileCoordsToKey:function(t){return t.x+":"+t.y+":"+t.z},_keyToTileCoords:function(t){var i=t.split(":"),t=new E(+i[0],+i[1]);return t.z=+i[2],t},_removeTile:function(t){var i=this._tiles[t];i&&(ei(i.el),delete this._tiles[t],this.fire("tileunload",{tile:i.el,coords:this._keyToTileCoords(t)}))},_initTile:function(t){ai(t,"leaflet-tile");var i=this.getTileSize();t.style.width=i.x+"px",t.style.height=i.y+"px",t.onselectstart=l,t.onmousemove=l,Ct.ielt9&&this.options.opacity<1&&ci(t,this.options.opacity)},_addTile:function(t,i){var e=this._getTilePos(t),n=this._tileCoordsToKey(t),o=this.createTile(this._wrapCoords(t),a(this._tileReady,this,t));this._initTile(o),this.createTile.length<2&&z(a(this._tileReady,this,t,null,o)),pi(o,e),this._tiles[n]={el:o,coords:t,current:!0},i.appendChild(o),this.fire("tileloadstart",{tile:o,coords:t})},_tileReady:function(t,i,e){i&&this.fire("tileerror",{error:i,tile:e,coords:t});var n=this._tileCoordsToKey(t);(e=this._tiles[n])&&(e.loaded=+new Date,this._map._fadeAnimated?(ci(e.el,0),M(this._fadeFrame),this._fadeFrame=z(this._updateOpacity,this)):(e.active=!0,this._pruneTiles()),i||(ai(e.el,"leaflet-tile-loaded"),this.fire("tileload",{tile:e.el,coords:t})),this._noTilesToLoad()&&(this._loading=!1,this.fire("load"),Ct.ielt9||!this._map._fadeAnimated?z(this._pruneTiles,this):setTimeout(a(this._pruneTiles,this),250)))},_getTilePos:function(t){return t.scaleBy(this.getTileSize()).subtract(this._level.origin)},_wrapCoords:function(t){var i=new E(this._wrapX?o(t.x,this._wrapX):t.x,this._wrapY?o(t.y,this._wrapY):t.y);return i.z=t.z,i},_pxBoundsToTileRange:function(t){var i=this.getTileSize();return new I(t.min.unscaleBy(i).floor(),t.max.unscaleBy(i).ceil().subtract([1,1]))},_noTilesToLoad:function(){for(var t in this._tiles)if(!this._tiles[t].loaded)return!1;return!0}});var Be=Ee.extend({options:{minZoom:0,maxZoom:18,subdomains:"abc",errorTileUrl:"",zoomOffset:0,tms:!1,zoomReverse:!1,detectRetina:!1,crossOrigin:!1},initialize:function(t,i){this._url=t,(i=d(this,i)).detectRetina&&Ct.retina&&0<i.maxZoom&&(i.tileSize=Math.floor(i.tileSize/2),i.zoomReverse?(i.zoomOffset--,i.minZoom++):(i.zoomOffset++,i.maxZoom--),i.minZoom=Math.max(0,i.minZoom)),"string"==typeof i.subdomains&&(i.subdomains=i.subdomains.split("")),this.on("tileunload",this._onTileRemove)},setUrl:function(t,i){return this._url===t&&void 0===i&&(i=!0),this._url=t,i||this.redraw(),this},createTile:function(t,i){var e=document.createElement("img");return Pi(e,"load",a(this._tileOnLoad,this,i,e)),Pi(e,"error",a(this._tileOnError,this,i,e)),!this.options.crossOrigin&&""!==this.options.crossOrigin||(e.crossOrigin=!0===this.options.crossOrigin?"":this.options.crossOrigin),e.alt="",e.setAttribute("role","presentation"),e.src=this.getTileUrl(t),e},getTileUrl:function(t){var i={r:Ct.retina?"@2x":"",s:this._getSubdomain(t),x:t.x,y:t.y,z:this._getZoomForUrl()};return this._map&&!this._map.options.crs.infinite&&(t=this._globalTileRange.max.y-t.y,this.options.tms&&(i.y=t),i["-y"]=t),f(this._url,u(i,this.options))},_tileOnLoad:function(t,i){Ct.ielt9?setTimeout(a(t,this,null,i),0):t(null,i)},_tileOnError:function(t,i,e){var n=this.options.errorTileUrl;n&&i.getAttribute("src")!==n&&(i.src=n),t(e,i)},_onTileRemove:function(t){t.tile.onload=null},_getZoomForUrl:function(){var t=this._tileZoom,i=this.options.maxZoom;return(t=this.options.zoomReverse?i-t:t)+this.options.zoomOffset},_getSubdomain:function(t){t=Math.abs(t.x+t.y)%this.options.subdomains.length;return this.options.subdomains[t]},_abortLoading:function(){var t,i,e;for(t in this._tiles)this._tiles[t].coords.z!==this._tileZoom&&((e=this._tiles[t].el).onload=l,e.onerror=l,e.complete||(e.src=y,i=this._tiles[t].coords,ei(e),delete this._tiles[t],this.fire("tileabort",{tile:e,coords:i})))},_removeTile:function(t){var i=this._tiles[t];if(i)return i.el.setAttribute("src",y),Ee.prototype._removeTile.call(this,t)},_tileReady:function(t,i,e){if(this._map&&(!e||e.getAttribute("src")!==y))return Ee.prototype._tileReady.call(this,t,i,e)}});function Ae(t,i){return new Be(t,i)}var Ie=Be.extend({defaultWmsParams:{service:"WMS",request:"GetMap",layers:"",styles:"",format:"image/jpeg",transparent:!1,version:"1.1.1"},options:{crs:null,uppercase:!1},initialize:function(t,i){this._url=t;var e,n=u({},this.defaultWmsParams);for(e in i)e in this.options||(n[e]=i[e]);var o=(i=d(this,i)).detectRetina&&Ct.retina?2:1,t=this.getTileSize();n.width=t.x*o,n.height=t.y*o,this.wmsParams=n},onAdd:function(t){this._crs=this.options.crs||t.options.crs,this._wmsVersion=parseFloat(this.wmsParams.version);var i=1.3<=this._wmsVersion?"crs":"srs";this.wmsParams[i]=this._crs.code,Be.prototype.onAdd.call(this,t)},getTileUrl:function(t){var i=this._tileCoordsToNwSe(t),e=this._crs,e=O(e.project(i[0]),e.project(i[1])),i=e.min,e=e.max,e=(1.3<=this._wmsVersion&&this._crs===ne?[i.y,i.x,e.y,e.x]:[i.x,i.y,e.x,e.y]).join(","),t=Be.prototype.getTileUrl.call(this,t);return t+p(this.wmsParams,t,this.options.uppercase)+(this.options.uppercase?"&BBOX=":"&bbox=")+e},setParams:function(t,i){return u(this.wmsParams,t),i||this.redraw(),this}});Be.WMS=Ie,Ae.wms=function(t,i){return new Ie(t,i)};var Oe=S.extend({options:{padding:.1},initialize:function(t){d(this,t),h(this),this._layers=this._layers||{}},onAdd:function(){this._container||(this._initContainer(),this._zoomAnimated&&ai(this._container,"leaflet-zoom-animated")),this.getPane().appendChild(this._container),this._update(),this.on("update",this._updatePaths,this)},onRemove:function(){this.off("update",this._updatePaths,this),this._destroyContainer()},getEvents:function(){var t={viewreset:this._reset,zoom:this._onZoom,moveend:this._update,zoomend:this._onZoomEnd};return this._zoomAnimated&&(t.zoomanim=this._onAnimZoom),t},_onAnimZoom:function(t){this._updateTransform(t.center,t.zoom)},_onZoom:function(){this._updateTransform(this._map.getCenter(),this._map.getZoom())},_updateTransform:function(t,i){var e=this._map.getZoomScale(i,this._zoom),n=mi(this._container),o=this._map.getSize().multiplyBy(.5+this.options.padding),s=this._map.project(this._center,i),s=this._map.project(t,i).subtract(s),s=o.multiplyBy(-e).add(n).add(o).subtract(s);Ct.any3d?di(this._container,s,e):pi(this._container,s)},_reset:function(){for(var t in this._update(),this._updateTransform(this._center,this._zoom),this._layers)this._layers[t]._reset()},_onZoomEnd:function(){for(var t in this._layers)this._layers[t]._project()},_updatePaths:function(){for(var t in this._layers)this._layers[t]._update()},_update:function(){var t=this.options.padding,i=this._map.getSize(),e=this._map.containerPointToLayerPoint(i.multiplyBy(-t)).round();this._bounds=new I(e,e.add(i.multiplyBy(1+2*t)).round()),this._center=this._map.getCenter(),this._zoom=this._map.getZoom()}}),Re=Oe.extend({options:{tolerance:0},getEvents:function(){var t=Oe.prototype.getEvents.call(this);return t.viewprereset=this._onViewPreReset,t},_onViewPreReset:function(){this._postponeUpdatePaths=!0},onAdd:function(){Oe.prototype.onAdd.call(this),this._draw()},_initContainer:function(){var t=this._container=document.createElement("canvas");Pi(t,"mousemove",this._onMouseMove,this),Pi(t,"click dblclick mousedown mouseup contextmenu",this._onClick,this),Pi(t,"mouseout",this._handleMouseOut,this),t._leaflet_disable_events=!0,this._ctx=t.getContext("2d")},_destroyContainer:function(){M(this._redrawRequest),delete this._ctx,ei(this._container),Li(this._container),delete this._container},_updatePaths:function(){if(!this._postponeUpdatePaths){for(var t in this._redrawBounds=null,this._layers)this._layers[t]._update();this._redraw()}},_update:function(){var t,i,e,n;this._map._animatingZoom&&this._bounds||(Oe.prototype._update.call(this),t=this._bounds,i=this._container,e=t.getSize(),n=Ct.retina?2:1,pi(i,t.min),i.width=n*e.x,i.height=n*e.y,i.style.width=e.x+"px",i.style.height=e.y+"px",Ct.retina&&this._ctx.scale(2,2),this._ctx.translate(-t.min.x,-t.min.y),this.fire("update"))},_reset:function(){Oe.prototype._reset.call(this),this._postponeUpdatePaths&&(this._postponeUpdatePaths=!1,this._updatePaths())},_initPath:function(t){this._updateDashArray(t);t=(this._layers[h(t)]=t)._order={layer:t,prev:this._drawLast,next:null};this._drawLast&&(this._drawLast.next=t),this._drawLast=t,this._drawFirst=this._drawFirst||this._drawLast},_addPath:function(t){this._requestRedraw(t)},_removePath:function(t){var i=t._order,e=i.next,i=i.prev;e?e.prev=i:this._drawLast=i,i?i.next=e:this._drawFirst=e,delete t._order,delete this._layers[h(t)],this._requestRedraw(t)},_updatePath:function(t){this._extendRedrawBounds(t),t._project(),t._update(),this._requestRedraw(t)},_updateStyle:function(t){this._updateDashArray(t),this._requestRedraw(t)},_updateDashArray:function(t){if("string"==typeof t.options.dashArray){for(var i,e=t.options.dashArray.split(/[, ]+/),n=[],o=0;o<e.length;o++){if(i=Number(e[o]),isNaN(i))return;n.push(i)}t.options._dashArray=n}else t.options._dashArray=t.options.dashArray},_requestRedraw:function(t){this._map&&(this._extendRedrawBounds(t),this._redrawRequest=this._redrawRequest||z(this._redraw,this))},_extendRedrawBounds:function(t){var i;t._pxBounds&&(i=(t.options.weight||0)+1,this._redrawBounds=this._redrawBounds||new I,this._redrawBounds.extend(t._pxBounds.min.subtract([i,i])),this._redrawBounds.extend(t._pxBounds.max.add([i,i])))},_redraw:function(){this._redrawRequest=null,this._redrawBounds&&(this._redrawBounds.min._floor(),this._redrawBounds.max._ceil()),this._clear(),this._draw(),this._redrawBounds=null},_clear:function(){var t,i=this._redrawBounds;i?(t=i.getSize(),this._ctx.clearRect(i.min.x,i.min.y,t.x,t.y)):(this._ctx.save(),this._ctx.setTransform(1,0,0,1,0,0),this._ctx.clearRect(0,0,this._container.width,this._container.height),this._ctx.restore())},_draw:function(){var t,i,e=this._redrawBounds;this._ctx.save(),e&&(i=e.getSize(),this._ctx.beginPath(),this._ctx.rect(e.min.x,e.min.y,i.x,i.y),this._ctx.clip()),this._drawing=!0;for(var n=this._drawFirst;n;n=n.next)t=n.layer,(!e||t._pxBounds&&t._pxBounds.intersects(e))&&t._updatePath();this._drawing=!1,this._ctx.restore()},_updatePoly:function(t,i){if(this._drawing){var e,n,o,s,r=t._parts,a=r.length,h=this._ctx;if(a){for(h.beginPath(),e=0;e<a;e++){for(n=0,o=r[e].length;n<o;n++)s=r[e][n],h[n?"lineTo":"moveTo"](s.x,s.y);i&&h.closePath()}this._fillStroke(h,t)}}},_updateCircle:function(t){var i,e,n,o;this._drawing&&!t._empty()&&(i=t._point,e=this._ctx,n=Math.max(Math.round(t._radius),1),1!=(o=(Math.max(Math.round(t._radiusY),1)||n)/n)&&(e.save(),e.scale(1,o)),e.beginPath(),e.arc(i.x,i.y/o,n,0,2*Math.PI,!1),1!=o&&e.restore(),this._fillStroke(e,t))},_fillStroke:function(t,i){var e=i.options;e.fill&&(t.globalAlpha=e.fillOpacity,t.fillStyle=e.fillColor||e.color,t.fill(e.fillRule||"evenodd")),e.stroke&&0!==e.weight&&(t.setLineDash&&t.setLineDash(i.options&&i.options._dashArray||[]),t.globalAlpha=e.opacity,t.lineWidth=e.weight,t.strokeStyle=e.color,t.lineCap=e.lineCap,t.lineJoin=e.lineJoin,t.stroke())},_onClick:function(t){for(var i,e,n=this._map.mouseEventToLayerPoint(t),o=this._drawFirst;o;o=o.next)(i=o.layer).options.interactive&&i._containsPoint(n)&&(("click"===t.type||"preclick"===t.type)&&this._map._draggableMoved(i)||(e=i));this._fireEvent(!!e&&[e],t)},_onMouseMove:function(t){var i;!this._map||this._map.dragging.moving()||this._map._animatingZoom||(i=this._map.mouseEventToLayerPoint(t),this._handleMouseHover(t,i))},_handleMouseOut:function(t){var i=this._hoveredLayer;i&&(hi(this._container,"leaflet-interactive"),this._fireEvent([i],t,"mouseout"),this._hoveredLayer=null,this._mouseHoverThrottled=!1)},_handleMouseHover:function(t,i){if(!this._mouseHoverThrottled){for(var e,n,o=this._drawFirst;o;o=o.next)(e=o.layer).options.interactive&&e._containsPoint(i)&&(n=e);n!==this._hoveredLayer&&(this._handleMouseOut(t),n&&(ai(this._container,"leaflet-interactive"),this._fireEvent([n],t,"mouseover"),this._hoveredLayer=n)),this._fireEvent(!!this._hoveredLayer&&[this._hoveredLayer],t),this._mouseHoverThrottled=!0,setTimeout(a(function(){this._mouseHoverThrottled=!1},this),32)}},_fireEvent:function(t,i,e){this._map._fireDOMEvent(i,e||i.type,t)},_bringToFront:function(t){var i,e,n=t._order;n&&(i=n.next,e=n.prev,i&&((i.prev=e)?e.next=i:i&&(this._drawFirst=i),n.prev=this._drawLast,(this._drawLast.next=n).next=null,this._drawLast=n,this._requestRedraw(t)))},_bringToBack:function(t){var i,e,n=t._order;n&&(i=n.next,(e=n.prev)&&((e.next=i)?i.prev=e:e&&(this._drawLast=e),n.prev=null,n.next=this._drawFirst,this._drawFirst.prev=n,this._drawFirst=n,this._requestRedraw(t)))}});function Ne(t){return Ct.canvas?new Re(t):null}var De=function(){try{return document.namespaces.add("lvml","urn:schemas-microsoft-com:vml"),function(t){return document.createElement("<lvml:"+t+' class="lvml">')}}catch(t){}return function(t){return document.createElement("<"+t+' xmlns="urn:schemas-microsoft.com:vml" class="lvml">')}}(),zt={_initContainer:function(){this._container=ii("div","leaflet-vml-container")},_update:function(){this._map._animatingZoom||(Oe.prototype._update.call(this),this.fire("update"))},_initPath:function(t){var i=t._container=De("shape");ai(i,"leaflet-vml-shape "+(this.options.className||"")),i.coordsize="1 1",t._path=De("path"),i.appendChild(t._path),this._updateStyle(t),this._layers[h(t)]=t},_addPath:function(t){var i=t._container;this._container.appendChild(i),t.options.interactive&&t.addInteractiveTarget(i)},_removePath:function(t){var i=t._container;ei(i),t.removeInteractiveTarget(i),delete this._layers[h(t)]},_updateStyle:function(t){var i=t._stroke,e=t._fill,n=t.options,o=t._container;o.stroked=!!n.stroke,o.filled=!!n.fill,n.stroke?(i=i||(t._stroke=De("stroke")),o.appendChild(i),i.weight=n.weight+"px",i.color=n.color,i.opacity=n.opacity,n.dashArray?i.dashStyle=g(n.dashArray)?n.dashArray.join(" "):n.dashArray.replace(/( *, *)/g," "):i.dashStyle="",i.endcap=n.lineCap.replace("butt","flat"),i.joinstyle=n.lineJoin):i&&(o.removeChild(i),t._stroke=null),n.fill?(e=e||(t._fill=De("fill")),o.appendChild(e),e.color=n.fillColor||n.color,e.opacity=n.fillOpacity):e&&(o.removeChild(e),t._fill=null)},_updateCircle:function(t){var i=t._point.round(),e=Math.round(t._radius),n=Math.round(t._radiusY||e);this._setPath(t,t._empty()?"M0 0":"AL "+i.x+","+i.y+" "+e+","+n+" 0,23592600")},_setPath:function(t,i){t._path.v=i},_bringToFront:function(t){oi(t._container)},_bringToBack:function(t){si(t._container)}},je=Ct.vml?De:Y,He=Oe.extend({getEvents:function(){var t=Oe.prototype.getEvents.call(this);return t.zoomstart=this._onZoomStart,t},_initContainer:function(){this._container=je("svg"),this._container.setAttribute("pointer-events","none"),this._rootGroup=je("g"),this._container.appendChild(this._rootGroup)},_destroyContainer:function(){ei(this._container),Li(this._container),delete this._container,delete this._rootGroup,delete this._svgSize},_onZoomStart:function(){this._update()},_update:function(){var t,i,e;this._map._animatingZoom&&this._bounds||(Oe.prototype._update.call(this),i=(t=this._bounds).getSize(),e=this._container,this._svgSize&&this._svgSize.equals(i)||(this._svgSize=i,e.setAttribute("width",i.x),e.setAttribute("height",i.y)),pi(e,t.min),e.setAttribute("viewBox",[t.min.x,t.min.y,i.x,i.y].join(" ")),this.fire("update"))},_initPath:function(t){var i=t._path=je("path");t.options.className&&ai(i,t.options.className),t.options.interactive&&ai(i,"leaflet-interactive"),this._updateStyle(t),this._layers[h(t)]=t},_addPath:function(t){this._rootGroup||this._initContainer(),this._rootGroup.appendChild(t._path),t.addInteractiveTarget(t._path)},_removePath:function(t){ei(t._path),t.removeInteractiveTarget(t._path),delete this._layers[h(t)]},_updatePath:function(t){t._project(),t._update()},_updateStyle:function(t){var i=t._path,t=t.options;i&&(t.stroke?(i.setAttribute("stroke",t.color),i.setAttribute("stroke-opacity",t.opacity),i.setAttribute("stroke-width",t.weight),i.setAttribute("stroke-linecap",t.lineCap),i.setAttribute("stroke-linejoin",t.lineJoin),t.dashArray?i.setAttribute("stroke-dasharray",t.dashArray):i.removeAttribute("stroke-dasharray"),t.dashOffset?i.setAttribute("stroke-dashoffset",t.dashOffset):i.removeAttribute("stroke-dashoffset")):i.setAttribute("stroke","none"),t.fill?(i.setAttribute("fill",t.fillColor||t.color),i.setAttribute("fill-opacity",t.fillOpacity),i.setAttribute("fill-rule",t.fillRule||"evenodd")):i.setAttribute("fill","none"))},_updatePoly:function(t,i){this._setPath(t,X(t._parts,i))},_updateCircle:function(t){var i=t._point,e=Math.max(Math.round(t._radius),1),n="a"+e+","+(Math.max(Math.round(t._radiusY),1)||e)+" 0 1,0 ",e=t._empty()?"M0 0":"M"+(i.x-e)+","+i.y+n+2*e+",0 "+n+2*-e+",0 ";this._setPath(t,e)},_setPath:function(t,i){t._path.setAttribute("d",i)},_bringToFront:function(t){oi(t._path)},_bringToBack:function(t){si(t._path)}});function We(t){return Ct.svg||Ct.vml?new He(t):null}Ct.vml&&He.include(zt),Di.include({getRenderer:function(t){t=(t=t.options.renderer||this._getPaneRenderer(t.options.pane)||this.options.renderer||this._renderer)||(this._renderer=this._createRenderer());return this.hasLayer(t)||this.addLayer(t),t},_getPaneRenderer:function(t){if("overlayPane"===t||void 0===t)return!1;var i=this._paneRenderers[t];return void 0===i&&(i=this._createRenderer({pane:t}),this._paneRenderers[t]=i),i},_createRenderer:function(t){return this.options.preferCanvas&&Ne(t)||We(t)}});var Fe=pe.extend({initialize:function(t,i){pe.prototype.initialize.call(this,this._boundsToLatLngs(t),i)},setBounds:function(t){return this.setLatLngs(this._boundsToLatLngs(t))},_boundsToLatLngs:function(t){return[(t=N(t)).getSouthWest(),t.getNorthWest(),t.getNorthEast(),t.getSouthEast()]}});He.create=je,He.pointsToPath=X,me.geometryToLayer=fe,me.coordsToLatLng=ve,me.coordsToLatLngs=ye,me.latLngToCoords=xe,me.latLngsToCoords=we,me.getFeature=Pe,me.asFeature=be,Di.mergeOptions({boxZoom:!0});Lt=xt.extend({initialize:function(t){this._map=t,this._container=t._container,this._pane=t._panes.overlayPane,this._resetStateTimeout=0,t.on("unload",this._destroy,this)},addHooks:function(){Pi(this._container,"mousedown",this._onMouseDown,this)},removeHooks:function(){Li(this._container,"mousedown",this._onMouseDown,this)},moved:function(){return this._moved},_destroy:function(){ei(this._pane),delete this._pane},_resetState:function(){this._resetStateTimeout=0,this._moved=!1},_clearDeferredResetState:function(){0!==this._resetStateTimeout&&(clearTimeout(this._resetStateTimeout),this._resetStateTimeout=0)},_onMouseDown:function(t){if(!t.shiftKey||1!==t.which&&1!==t.button)return!1;this._clearDeferredResetState(),this._resetState(),qt(),fi(),this._startPoint=this._map.mouseEventToContainerPoint(t),Pi(document,{contextmenu:Bi,mousemove:this._onMouseMove,mouseup:this._onMouseUp,keydown:this._onKeyDown},this)},_onMouseMove:function(t){this._moved||(this._moved=!0,this._box=ii("div","leaflet-zoom-box",this._container),ai(this._container,"leaflet-crosshair"),this._map.fire("boxzoomstart")),this._point=this._map.mouseEventToContainerPoint(t);var i=new I(this._point,this._startPoint),t=i.getSize();pi(this._box,i.min),this._box.style.width=t.x+"px",this._box.style.height=t.y+"px"},_finish:function(){this._moved&&(ei(this._box),hi(this._container,"leaflet-crosshair")),Gt(),gi(),Li(document,{contextmenu:Bi,mousemove:this._onMouseMove,mouseup:this._onMouseUp,keydown:this._onKeyDown},this)},_onMouseUp:function(t){1!==t.which&&1!==t.button||(this._finish(),this._moved&&(this._clearDeferredResetState(),this._resetStateTimeout=setTimeout(a(this._resetState,this),0),t=new R(this._map.containerPointToLatLng(this._startPoint),this._map.containerPointToLatLng(this._point)),this._map.fitBounds(t).fire("boxzoomend",{boxZoomBounds:t})))},_onKeyDown:function(t){27===t.keyCode&&(this._finish(),this._clearDeferredResetState(),this._resetState())}});Di.addInitHook("addHandler","boxZoom",Lt),Di.mergeOptions({doubleClickZoom:!0});ot=xt.extend({addHooks:function(){this._map.on("dblclick",this._onDoubleClick,this)},removeHooks:function(){this._map.off("dblclick",this._onDoubleClick,this)},_onDoubleClick:function(t){var i=this._map,e=i.getZoom(),n=i.options.zoomDelta,n=t.originalEvent.shiftKey?e-n:e+n;"center"===i.options.doubleClickZoom?i.setZoom(n):i.setZoomAround(t.containerPoint,n)}});Di.addInitHook("addHandler","doubleClickZoom",ot),Di.mergeOptions({dragging:!0,inertia:!0,inertiaDeceleration:3400,inertiaMaxSpeed:1/0,easeLinearity:.2,worldCopyJump:!1,maxBoundsViscosity:0});G=xt.extend({addHooks:function(){var t;this._draggable||(t=this._map,this._draggable=new Gi(t._mapPane,t._container),this._draggable.on({dragstart:this._onDragStart,drag:this._onDrag,dragend:this._onDragEnd},this),this._draggable.on("predrag",this._onPreDragLimit,this),t.options.worldCopyJump&&(this._draggable.on("predrag",this._onPreDragWrap,this),t.on("zoomend",this._onZoomEnd,this),t.whenReady(this._onZoomEnd,this))),ai(this._map._container,"leaflet-grab leaflet-touch-drag"),this._draggable.enable(),this._positions=[],this._times=[]},removeHooks:function(){hi(this._map._container,"leaflet-grab"),hi(this._map._container,"leaflet-touch-drag"),this._draggable.disable()},moved:function(){return this._draggable&&this._draggable._moved},moving:function(){return this._draggable&&this._draggable._moving},_onDragStart:function(){var t,i=this._map;i._stop(),this._map.options.maxBounds&&this._map.options.maxBoundsViscosity?(t=N(this._map.options.maxBounds),this._offsetLimit=O(this._map.latLngToContainerPoint(t.getNorthWest()).multiplyBy(-1),this._map.latLngToContainerPoint(t.getSouthEast()).multiplyBy(-1).add(this._map.getSize())),this._viscosity=Math.min(1,Math.max(0,this._map.options.maxBoundsViscosity))):this._offsetLimit=null,i.fire("movestart").fire("dragstart"),i.options.inertia&&(this._positions=[],this._times=[])},_onDrag:function(t){var i,e;this._map.options.inertia&&(i=this._lastTime=+new Date,e=this._lastPos=this._draggable._absPos||this._draggable._newPos,this._positions.push(e),this._times.push(i),this._prunePositions(i)),this._map.fire("move",t).fire("drag",t)},_prunePositions:function(t){for(;1<this._positions.length&&50<t-this._times[0];)this._positions.shift(),this._times.shift()},_onZoomEnd:function(){var t=this._map.getSize().divideBy(2),i=this._map.latLngToLayerPoint([0,0]);this._initialWorldOffset=i.subtract(t).x,this._worldWidth=this._map.getPixelWorldBounds().getSize().x},_viscousLimit:function(t,i){return t-(t-i)*this._viscosity},_onPreDragLimit:function(){var t,i;this._viscosity&&this._offsetLimit&&(t=this._draggable._newPos.subtract(this._draggable._startPos),i=this._offsetLimit,t.x<i.min.x&&(t.x=this._viscousLimit(t.x,i.min.x)),t.y<i.min.y&&(t.y=this._viscousLimit(t.y,i.min.y)),t.x>i.max.x&&(t.x=this._viscousLimit(t.x,i.max.x)),t.y>i.max.y&&(t.y=this._viscousLimit(t.y,i.max.y)),this._draggable._newPos=this._draggable._startPos.add(t))},_onPreDragWrap:function(){var t=this._worldWidth,i=Math.round(t/2),e=this._initialWorldOffset,n=this._draggable._newPos.x,o=(n-i+e)%t+i-e,i=(n+i+e)%t-i-e,i=Math.abs(o+e)<Math.abs(i+e)?o:i;this._draggable._absPos=this._draggable._newPos.clone(),this._draggable._newPos.x=i},_onDragEnd:function(t){var i,e,n,o,s=this._map,r=s.options,a=!r.inertia||this._times.length<2;s.fire("dragend",t),a?s.fire("moveend"):(this._prunePositions(+new Date),e=this._lastPos.subtract(this._positions[0]),t=(this._lastTime-this._times[0])/1e3,i=r.easeLinearity,e=(a=e.multiplyBy(i/t)).distanceTo([0,0]),t=Math.min(r.inertiaMaxSpeed,e),e=a.multiplyBy(t/e),n=t/(r.inertiaDeceleration*i),(o=e.multiplyBy(-n/2).round()).x||o.y?(o=s._limitOffset(o,s.options.maxBounds),z(function(){s.panBy(o,{duration:n,easeLinearity:i,noMoveStart:!0,animate:!0})})):s.fire("moveend"))}});Di.addInitHook("addHandler","dragging",G),Di.mergeOptions({keyboard:!0,keyboardPanDelta:80});K=xt.extend({keyCodes:{left:[37],right:[39],down:[40],up:[38],zoomIn:[187,107,61,171],zoomOut:[189,109,54,173]},initialize:function(t){this._map=t,this._setPanDelta(t.options.keyboardPanDelta),this._setZoomDelta(t.options.zoomDelta)},addHooks:function(){var t=this._map._container;t.tabIndex<=0&&(t.tabIndex="0"),Pi(t,{focus:this._onFocus,blur:this._onBlur,mousedown:this._onMouseDown},this),this._map.on({focus:this._addHooks,blur:this._removeHooks},this)},removeHooks:function(){this._removeHooks(),Li(this._map._container,{focus:this._onFocus,blur:this._onBlur,mousedown:this._onMouseDown},this),this._map.off({focus:this._addHooks,blur:this._removeHooks},this)},_onMouseDown:function(){var t,i,e;this._focused||(t=document.body,e=document.documentElement,i=t.scrollTop||e.scrollTop,e=t.scrollLeft||e.scrollLeft,this._map._container.focus(),window.scrollTo(e,i))},_onFocus:function(){this._focused=!0,this._map.fire("focus")},_onBlur:function(){this._focused=!1,this._map.fire("blur")},_setPanDelta:function(t){for(var i=this._panKeys={},e=this.keyCodes,n=0,o=e.left.length;n<o;n++)i[e.left[n]]=[-1*t,0];for(n=0,o=e.right.length;n<o;n++)i[e.right[n]]=[t,0];for(n=0,o=e.down.length;n<o;n++)i[e.down[n]]=[0,t];for(n=0,o=e.up.length;n<o;n++)i[e.up[n]]=[0,-1*t]},_setZoomDelta:function(t){for(var i=this._zoomKeys={},e=this.keyCodes,n=0,o=e.zoomIn.length;n<o;n++)i[e.zoomIn[n]]=t;for(n=0,o=e.zoomOut.length;n<o;n++)i[e.zoomOut[n]]=-t},_addHooks:function(){Pi(document,"keydown",this._onKeyDown,this)},_removeHooks:function(){Li(document,"keydown",this._onKeyDown,this)},_onKeyDown:function(t){if(!(t.altKey||t.ctrlKey||t.metaKey)){var i,e=t.keyCode,n=this._map;if(e in this._panKeys)n._panAnim&&n._panAnim._inProgress||(i=this._panKeys[e],t.shiftKey&&(i=A(i).multiplyBy(3)),n.panBy(i),n.options.maxBounds&&n.panInsideBounds(n.options.maxBounds));else if(e in this._zoomKeys)n.setZoom(n.getZoom()+(t.shiftKey?3:1)*this._zoomKeys[e]);else{if(27!==e||!n._popup||!n._popup.options.closeOnEscapeKey)return;n.closePopup()}Bi(t)}}});Di.addInitHook("addHandler","keyboard",K),Di.mergeOptions({scrollWheelZoom:!0,wheelDebounceTime:40,wheelPxPerZoomLevel:60});J=xt.extend({addHooks:function(){Pi(this._map._container,"wheel",this._onWheelScroll,this),this._delta=0},removeHooks:function(){Li(this._map._container,"wheel",this._onWheelScroll,this)},_onWheelScroll:function(t){var i=Oi(t),e=this._map.options.wheelDebounceTime;this._delta+=i,this._lastMousePos=this._map.mouseEventToContainerPoint(t),this._startTime||(this._startTime=+new Date);e=Math.max(e-(+new Date-this._startTime),0);clearTimeout(this._timer),this._timer=setTimeout(a(this._performZoom,this),e),Bi(t)},_performZoom:function(){var t=this._map,i=t.getZoom(),e=this._map.options.zoomSnap||0;t._stop();var n=this._delta/(4*this._map.options.wheelPxPerZoomLevel),n=4*Math.log(2/(1+Math.exp(-Math.abs(n))))/Math.LN2,n=e?Math.ceil(n/e)*e:n,n=t._limitZoom(i+(0<this._delta?n:-n))-i;this._delta=0,this._startTime=null,n&&("center"===t.options.scrollWheelZoom?t.setZoom(i+n):t.setZoomAround(this._lastMousePos,i+n))}});Di.addInitHook("addHandler","scrollWheelZoom",J);Di.mergeOptions({tapHold:Ct.touchNative&&Ct.safari&&Ct.mobile,tapTolerance:15});U=xt.extend({addHooks:function(){Pi(this._map._container,"touchstart",this._onDown,this)},removeHooks:function(){Li(this._map._container,"touchstart",this._onDown,this)},_onDown:function(t){var i;clearTimeout(this._holdTimeout),1===t.touches.length&&(i=t.touches[0],this._startPos=this._newPos=new E(i.clientX,i.clientY),this._holdTimeout=setTimeout(a(function(){this._cancel(),this._isTapValid()&&(Pi(document,"touchend",Ei),Pi(document,"touchend touchcancel",this._cancelClickPrevent),this._simulateEvent("contextmenu",i))},this),600),Pi(document,"touchend touchcancel contextmenu",this._cancel,this),Pi(document,"touchmove",this._onMove,this))},_cancelClickPrevent:function t(){Li(document,"touchend",Ei),Li(document,"touchend touchcancel",t)},_cancel:function(){clearTimeout(this._holdTimeout),Li(document,"touchend touchcancel contextmenu",this._cancel,this),Li(document,"touchmove",this._onMove,this)},_onMove:function(t){t=t.touches[0];this._newPos=new E(t.clientX,t.clientY)},_isTapValid:function(){return this._newPos.distanceTo(this._startPos)<=this._map.options.tapTolerance},_simulateEvent:function(t,i){t=new MouseEvent(t,{bubbles:!0,cancelable:!0,view:window,screenX:i.screenX,screenY:i.screenY,clientX:i.clientX,clientY:i.clientY});t._simulated=!0,i.target.dispatchEvent(t)}});Di.addInitHook("addHandler","tapHold",U),Di.mergeOptions({touchZoom:Ct.touch,bounceAtZoomLimits:!0});zt=xt.extend({addHooks:function(){ai(this._map._container,"leaflet-touch-zoom"),Pi(this._map._container,"touchstart",this._onTouchStart,this)},removeHooks:function(){hi(this._map._container,"leaflet-touch-zoom"),Li(this._map._container,"touchstart",this._onTouchStart,this)},_onTouchStart:function(t){var i,e,n=this._map;!t.touches||2!==t.touches.length||n._animatingZoom||this._zooming||(i=n.mouseEventToContainerPoint(t.touches[0]),e=n.mouseEventToContainerPoint(t.touches[1]),this._centerPoint=n.getSize()._divideBy(2),this._startLatLng=n.containerPointToLatLng(this._centerPoint),"center"!==n.options.touchZoom&&(this._pinchStartLatLng=n.containerPointToLatLng(i.add(e)._divideBy(2))),this._startDist=i.distanceTo(e),this._startZoom=n.getZoom(),this._moved=!1,this._zooming=!0,n._stop(),Pi(document,"touchmove",this._onTouchMove,this),Pi(document,"touchend touchcancel",this._onTouchEnd,this),Ei(t))},_onTouchMove:function(t){if(t.touches&&2===t.touches.length&&this._zooming){var i=this._map,e=i.mouseEventToContainerPoint(t.touches[0]),n=i.mouseEventToContainerPoint(t.touches[1]),o=e.distanceTo(n)/this._startDist;if(this._zoom=i.getScaleZoom(o,this._startZoom),!i.options.bounceAtZoomLimits&&(this._zoom<i.getMinZoom()&&o<1||this._zoom>i.getMaxZoom()&&1<o)&&(this._zoom=i._limitZoom(this._zoom)),"center"===i.options.touchZoom){if(this._center=this._startLatLng,1==o)return}else{n=e._add(n)._divideBy(2)._subtract(this._centerPoint);if(1==o&&0===n.x&&0===n.y)return;this._center=i.unproject(i.project(this._pinchStartLatLng,this._zoom).subtract(n),this._zoom)}this._moved||(i._moveStart(!0,!1),this._moved=!0),M(this._animRequest);i=a(i._move,i,this._center,this._zoom,{pinch:!0,round:!1});this._animRequest=z(i,this,!0),Ei(t)}},_onTouchEnd:function(){this._moved&&this._zooming?(this._zooming=!1,M(this._animRequest),Li(document,"touchmove",this._onTouchMove,this),Li(document,"touchend touchcancel",this._onTouchEnd,this),this._map.options.zoomAnimation?this._map._animateZoom(this._center,this._map._limitZoom(this._zoom),!0,this._map.options.zoomSnap):this._map._resetView(this._center,this._map._limitZoom(this._zoom))):this._zooming=!1}});Di.addInitHook("addHandler","touchZoom",zt),Di.BoxZoom=Lt,Di.DoubleClickZoom=ot,Di.Drag=G,Di.Keyboard=K,Di.ScrollWheelZoom=J,Di.TapHold=U,Di.TouchZoom=zt,t.Bounds=I,t.Browser=Ct,t.CRS=H,t.Canvas=Re,t.Circle=_e,t.CircleMarker=ce,t.Class=Z,t.Control=ji,t.DivIcon=ke,t.DivOverlay=Ce,t.DomEvent=vt,t.DomUtil=gt,t.Draggable=Gi,t.Evented=k,t.FeatureGroup=se,t.GeoJSON=me,t.GridLayer=Ee,t.Handler=xt,t.Icon=re,t.ImageOverlay=Te,t.LatLng=D,t.LatLngBounds=R,t.Layer=S,t.LayerGroup=oe,t.LineUtil=bt,t.Map=Di,t.Marker=ue,t.Mixin=wt,t.Path=le,t.Point=E,t.PolyUtil=Pt,t.Polygon=pe,t.Polyline=de,t.Popup=Ze,t.PosAnimation=Ni,t.Projection=Tt,t.Rectangle=Fe,t.Renderer=Oe,t.SVG=He,t.SVGOverlay=Me,t.TileLayer=Be,t.Tooltip=Se,t.Transformation=V,t.Util=C,t.VideoOverlay=ze,t.bind=a,t.bounds=O,t.canvas=Ne,t.circle=function(t,i,e){return new _e(t,i,e)},t.circleMarker=function(t,i){return new ce(t,i)},t.control=yt,t.divIcon=function(t){return new ke(t)},t.extend=u,t.featureGroup=function(t,i){return new se(t,i)},t.geoJSON=Le,t.geoJson=F,t.gridLayer=function(t){return new Ee(t)},t.icon=function(t){return new re(t)},t.imageOverlay=function(t,i,e){return new Te(t,i,e)},t.latLng=j,t.latLngBounds=N,t.layerGroup=function(t,i){return new oe(t,i)},t.map=function(t,i){return new Di(t,i)},t.marker=function(t,i){return new ue(t,i)},t.point=A,t.polygon=function(t,i){return new pe(t,i)},t.polyline=function(t,i){return new de(t,i)},t.popup=function(t,i){return new Ze(t,i)},t.rectangle=function(t,i){return new Fe(t,i)},t.setOptions=d,t.stamp=h,t.svg=We,t.svgOverlay=function(t,i,e){return new Me(t,i,e)},t.tileLayer=Ae,t.tooltip=function(t,i){return new Se(t,i)},t.transformation=q,t.version="1.7.1+master.80b26852",t.videoOverlay=function(t,i,e){return new ze(t,i,e)};var Ue=window.L;t.noConflict=function(){return window.L=Ue,this},window.L=t});
}catch(e){console.log(e)}try{(function (root, factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define(['leaflet'], factory);
	} else if (typeof modules === 'object' && module.exports) {
		// define a Common JS module that relies on 'leaflet'
		module.exports = factory(require('leaflet'));
	} else {
		// Assume Leaflet is loaded into global object L already
		factory(L);
	}
}(this, function (L) {
	'use strict';

	L.TileLayer.Provider = L.TileLayer.extend({
		initialize: function (arg, options) {
			var providers = L.TileLayer.Provider.providers;

			var parts = arg.split('.');

			var providerName = parts[0];
			var variantName = parts[1];

			if (!providers[providerName]) {
				throw 'No such provider (' + providerName + ')';
			}

			var provider = {
				url: providers[providerName].url,
				options: providers[providerName].options
			};

			// overwrite values in provider from variant.
			if (variantName && 'variants' in providers[providerName]) {
				if (!(variantName in providers[providerName].variants)) {
					throw 'No such variant of ' + providerName + ' (' + variantName + ')';
				}
				var variant = providers[providerName].variants[variantName];
				var variantOptions;
				if (typeof variant === 'string') {
					variantOptions = {
						variant: variant
					};
				} else {
					variantOptions = variant.options;
				}
				provider = {
					url: variant.url || provider.url,
					options: L.Util.extend({}, provider.options, variantOptions)
				};
			}

			// replace attribution placeholders with their values from toplevel provider attribution,
			// recursively
			var attributionReplacer = function (attr) {
				if (attr.indexOf('{attribution.') === -1) {
					return attr;
				}
				return attr.replace(/\{attribution.(\w*)\}/g,
					function (match, attributionName) {
						return attributionReplacer(providers[attributionName].options.attribution);
					}
				);
			};
			provider.options.attribution = attributionReplacer(provider.options.attribution);

			// Compute final options combining provider options with any user overrides
			var layerOpts = L.Util.extend({}, provider.options, options);
			L.TileLayer.prototype.initialize.call(this, provider.url, layerOpts);
		}
	});

	/**
	 * Definition of providers.
	 * see http://leafletjs.com/reference.html#tilelayer for options in the options map.
	 */

	L.TileLayer.Provider.providers = {
		OpenStreetMap: {
			url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			options: {
				maxZoom: 19,
				attribution:
					'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			},
			variants: {
				Mapnik: {},
				DE: {
					url: 'https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png',
					options: {
						maxZoom: 18
					}
				},
				CH: {
					url: 'https://tile.osm.ch/switzerland/{z}/{x}/{y}.png',
					options: {
						maxZoom: 18,
						bounds: [[45, 5], [48, 11]]
					}
				},
				France: {
					url: 'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png',
					options: {
						maxZoom: 20,
						attribution: '&copy; OpenStreetMap France | {attribution.OpenStreetMap}'
					}
				},
				HOT: {
					url: 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
					options: {
						attribution:
							'{attribution.OpenStreetMap}, ' +
							'Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a> ' +
							'hosted by <a href="https://openstreetmap.fr/" target="_blank">OpenStreetMap France</a>'
					}
				},
				BZH: {
					url: 'https://tile.openstreetmap.bzh/br/{z}/{x}/{y}.png',
					options: {
						attribution: '{attribution.OpenStreetMap}, Tiles courtesy of <a href="http://www.openstreetmap.bzh/" target="_blank">Breton OpenStreetMap Team</a>',
						bounds: [[46.2, -5.5], [50, 0.7]]
					}
				}
			}
		},
		OpenSeaMap: {
			url: 'https://tiles.openseamap.org/seamark/{z}/{x}/{y}.png',
			options: {
				attribution: 'Map data: &copy; <a href="http://www.openseamap.org">OpenSeaMap</a> contributors'
			}
		},
		OpenPtMap: {
			url: 'http://openptmap.org/tiles/{z}/{x}/{y}.png',
			options: {
				maxZoom: 17,
				attribution: 'Map data: &copy; <a href="http://www.openptmap.org">OpenPtMap</a> contributors'
			}
		},
		OpenTopoMap: {
			url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
			options: {
				maxZoom: 17,
				attribution: 'Map data: {attribution.OpenStreetMap}, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
			}
		},
		OpenRailwayMap: {
			url: 'https://{s}.tiles.openrailwaymap.org/standard/{z}/{x}/{y}.png',
			options: {
				maxZoom: 19,
				attribution: 'Map data: {attribution.OpenStreetMap} | Map style: &copy; <a href="https://www.OpenRailwayMap.org">OpenRailwayMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
			}
		},
		OpenFireMap: {
			url: 'http://openfiremap.org/hytiles/{z}/{x}/{y}.png',
			options: {
				maxZoom: 19,
				attribution: 'Map data: {attribution.OpenStreetMap} | Map style: &copy; <a href="http://www.openfiremap.org">OpenFireMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
			}
		},
		SafeCast: {
			url: 'https://s3.amazonaws.com/te512.safecast.org/{z}/{x}/{y}.png',
			options: {
				maxZoom: 16,
				attribution: 'Map data: {attribution.OpenStreetMap} | Map style: &copy; <a href="https://blog.safecast.org/about/">SafeCast</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
			}
		},
		Stadia: {
			url: 'https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png',
			options: {
				maxZoom: 20,
				attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
			},
			variants: {
				AlidadeSmooth: {
					url: 'https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png'
				},
				AlidadeSmoothDark: {
					url: 'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png'
				},
				OSMBright: {
					url: 'https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.png'
				},
				Outdoors: {
					url: 'https://tiles.stadiamaps.com/tiles/outdoors/{z}/{x}/{y}{r}.png'
				}
			}
		},
		Thunderforest: {
			url: 'https://{s}.tile.thunderforest.com/{variant}/{z}/{x}/{y}.png?apikey={apikey}',
			options: {
				attribution:
					'&copy; <a href="http://www.thunderforest.com/">Thunderforest</a>, {attribution.OpenStreetMap}',
				variant: 'cycle',
				apikey: '<insert your api key here>',
				maxZoom: 22
			},
			variants: {
				OpenCycleMap: 'cycle',
				Transport: {
					options: {
						variant: 'transport'
					}
				},
				TransportDark: {
					options: {
						variant: 'transport-dark'
					}
				},
				SpinalMap: {
					options: {
						variant: 'spinal-map'
					}
				},
				Landscape: 'landscape',
				Outdoors: 'outdoors',
				Pioneer: 'pioneer',
				MobileAtlas: 'mobile-atlas',
				Neighbourhood: 'neighbourhood'
			}
		},
		CyclOSM: {
			url: 'https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png',
			options: {
				maxZoom: 20,
				attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: {attribution.OpenStreetMap}'
			}
		},
		Hydda: {
			url: 'https://{s}.tile.openstreetmap.se/hydda/{variant}/{z}/{x}/{y}.png',
			options: {
				maxZoom: 20,
				variant: 'full',
				attribution: 'Tiles courtesy of <a href="http://openstreetmap.se/" target="_blank">OpenStreetMap Sweden</a> &mdash; Map data {attribution.OpenStreetMap}'
			},
			variants: {
				Full: 'full',
				Base: 'base',
				RoadsAndLabels: 'roads_and_labels'
			}
		},
		Jawg: {
			url: 'https://{s}.tile.jawg.io/{variant}/{z}/{x}/{y}{r}.png?access-token={accessToken}',
			options: {
				attribution:
					'<a href="http://jawg.io" title="Tiles Courtesy of Jawg Maps" target="_blank">&copy; <b>Jawg</b>Maps</a> ' +
					'{attribution.OpenStreetMap}',
				minZoom: 0,
				maxZoom: 22,
				subdomains: 'abcd',
				variant: 'jawg-terrain',
				// Get your own Jawg access token here : https://www.jawg.io/lab/
				// NB : this is a demonstration key that comes with no guarantee
				accessToken: '<insert your access token here>',
			},
			variants: {
				Streets: 'jawg-streets',
				Terrain: 'jawg-terrain',
				Sunny: 'jawg-sunny',
				Dark: 'jawg-dark',
				Light: 'jawg-light',
				Matrix: 'jawg-matrix'
			}
		},
		MapBox: {
			url: 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}{r}?access_token={accessToken}',
			options: {
				attribution:
					'&copy; <a href="https://www.mapbox.com/about/maps/" target="_blank">Mapbox</a> ' +
					'{attribution.OpenStreetMap} ' +
					'<a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a>',
				tileSize: 512,
				maxZoom: 18,
				zoomOffset: -1,
				id: 'mapbox/streets-v11',
				accessToken: '<insert your access token here>',
			}
		},
		MapTiler: {
			url: 'https://api.maptiler.com/maps/{variant}/{z}/{x}/{y}{r}.{ext}?key={key}',
			options: {
				attribution:
					'<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
				variant: 'streets',
				ext: 'png',
				key: '<insert your MapTiler Cloud API key here>',
				tileSize: 512,
				zoomOffset: -1,
				minZoom: 0,
				maxZoom: 21
			},
			variants: {
				Streets: 'streets',
				Basic: 'basic',
				Bright: 'bright',
				Pastel: 'pastel',
				Positron: 'positron',
				Hybrid: {
					options: {
						variant: 'hybrid',
						ext: 'jpg'
					}
				},
				Toner: 'toner',
				Topo: 'topo',
				Voyager: 'voyager'
			}
		},
		Stamen: {
			url: 'https://stamen-tiles-{s}.a.ssl.fastly.net/{variant}/{z}/{x}/{y}{r}.{ext}',
			options: {
				attribution:
					'Map tiles by <a href="http://stamen.com">Stamen Design</a>, ' +
					'<a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; ' +
					'Map data {attribution.OpenStreetMap}',
				subdomains: 'abcd',
				minZoom: 0,
				maxZoom: 20,
				variant: 'toner',
				ext: 'png'
			},
			variants: {
				Toner: 'toner',
				TonerBackground: 'toner-background',
				TonerHybrid: 'toner-hybrid',
				TonerLines: 'toner-lines',
				TonerLabels: 'toner-labels',
				TonerLite: 'toner-lite',
				Watercolor: {
					url: 'https://stamen-tiles-{s}.a.ssl.fastly.net/{variant}/{z}/{x}/{y}.{ext}',
					options: {
						variant: 'watercolor',
						ext: 'jpg',
						minZoom: 1,
						maxZoom: 16
					}
				},
				Terrain: {
					options: {
						variant: 'terrain',
						minZoom: 0,
						maxZoom: 18
					}
				},
				TerrainBackground: {
					options: {
						variant: 'terrain-background',
						minZoom: 0,
						maxZoom: 18
					}
				},
				TerrainLabels: {
					options: {
						variant: 'terrain-labels',
						minZoom: 0,
						maxZoom: 18
					}
				},
				TopOSMRelief: {
					url: 'https://stamen-tiles-{s}.a.ssl.fastly.net/{variant}/{z}/{x}/{y}.{ext}',
					options: {
						variant: 'toposm-color-relief',
						ext: 'jpg',
						bounds: [[22, -132], [51, -56]]
					}
				},
				TopOSMFeatures: {
					options: {
						variant: 'toposm-features',
						bounds: [[22, -132], [51, -56]],
						opacity: 0.9
					}
				}
			}
		},
		TomTom: {
			url: 'https://{s}.api.tomtom.com/map/1/tile/{variant}/{style}/{z}/{x}/{y}.{ext}?key={apikey}',
			options: {
				variant: 'basic',
				maxZoom: 22,
				attribution:
					'<a href="https://tomtom.com" target="_blank">&copy;  1992 - ' + new Date().getFullYear() + ' TomTom.</a> ',
				subdomains: 'abcd',
				style: 'main',
				ext: 'png',
				apikey: '<insert your API key here>',
			},
			variants: {
				Basic: 'basic',
				Hybrid: 'hybrid',
				Labels: 'labels'
			}
		},
		Esri: {
			url: 'https://server.arcgisonline.com/ArcGIS/rest/services/{variant}/MapServer/tile/{z}/{y}/{x}',
			options: {
				variant: 'World_Street_Map',
				attribution: 'Tiles &copy; Esri'
			},
			variants: {
				WorldStreetMap: {
					options: {
						attribution:
							'{attribution.Esri} &mdash; ' +
							'Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
					}
				},
				DeLorme: {
					options: {
						variant: 'Specialty/DeLorme_World_Base_Map',
						minZoom: 1,
						maxZoom: 11,
						attribution: '{attribution.Esri} &mdash; Copyright: &copy;2012 DeLorme'
					}
				},
				WorldTopoMap: {
					options: {
						variant: 'World_Topo_Map',
						attribution:
							'{attribution.Esri} &mdash; ' +
							'Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community'
					}
				},
				WorldImagery: {
					options: {
						variant: 'World_Imagery',
						attribution:
							'{attribution.Esri} &mdash; ' +
							'Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
					}
				},
				WorldTerrain: {
					options: {
						variant: 'World_Terrain_Base',
						maxZoom: 13,
						attribution:
							'{attribution.Esri} &mdash; ' +
							'Source: USGS, Esri, TANA, DeLorme, and NPS'
					}
				},
				WorldShadedRelief: {
					options: {
						variant: 'World_Shaded_Relief',
						maxZoom: 13,
						attribution: '{attribution.Esri} &mdash; Source: Esri'
					}
				},
				WorldPhysical: {
					options: {
						variant: 'World_Physical_Map',
						maxZoom: 8,
						attribution: '{attribution.Esri} &mdash; Source: US National Park Service'
					}
				},
				OceanBasemap: {
					options: {
						variant: 'Ocean_Basemap',
						maxZoom: 13,
						attribution: '{attribution.Esri} &mdash; Sources: GEBCO, NOAA, CHS, OSU, UNH, CSUMB, National Geographic, DeLorme, NAVTEQ, and Esri'
					}
				},
				NatGeoWorldMap: {
					options: {
						variant: 'NatGeo_World_Map',
						maxZoom: 16,
						attribution: '{attribution.Esri} &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC'
					}
				},
				WorldGrayCanvas: {
					options: {
						variant: 'Canvas/World_Light_Gray_Base',
						maxZoom: 16,
						attribution: '{attribution.Esri} &mdash; Esri, DeLorme, NAVTEQ'
					}
				}
			}
		},
		OpenWeatherMap: {
			url: 'http://{s}.tile.openweathermap.org/map/{variant}/{z}/{x}/{y}.png?appid={apiKey}',
			options: {
				maxZoom: 19,
				attribution: 'Map data &copy; <a href="http://openweathermap.org">OpenWeatherMap</a>',
				apiKey: '<insert your api key here>',
				opacity: 0.5
			},
			variants: {
				Clouds: 'clouds',
				CloudsClassic: 'clouds_cls',
				Precipitation: 'precipitation',
				PrecipitationClassic: 'precipitation_cls',
				Rain: 'rain',
				RainClassic: 'rain_cls',
				Pressure: 'pressure',
				PressureContour: 'pressure_cntr',
				Wind: 'wind',
				Temperature: 'temp',
				Snow: 'snow'
			}
		},
		HERE: {
			/*
			 * HERE maps, formerly Nokia maps.
			 * These basemaps are free, but you need an api id and app key. Please sign up at
			 * https://developer.here.com/plans
			 */
			url:
				'https://{s}.{base}.maps.api.here.com/maptile/2.1/' +
				'{type}/{mapID}/{variant}/{z}/{x}/{y}/{size}/{format}?' +
				'app_id={app_id}&app_code={app_code}&lg={language}',
			options: {
				attribution:
					'Map &copy; 1987-' + new Date().getFullYear() + ' <a href="http://developer.here.com">HERE</a>',
				subdomains: '1234',
				mapID: 'newest',
				'app_id': '<insert your app_id here>',
				'app_code': '<insert your app_code here>',
				base: 'base',
				variant: 'normal.day',
				maxZoom: 20,
				type: 'maptile',
				language: 'eng',
				format: 'png8',
				size: '256'
			},
			variants: {
				normalDay: 'normal.day',
				normalDayCustom: 'normal.day.custom',
				normalDayGrey: 'normal.day.grey',
				normalDayMobile: 'normal.day.mobile',
				normalDayGreyMobile: 'normal.day.grey.mobile',
				normalDayTransit: 'normal.day.transit',
				normalDayTransitMobile: 'normal.day.transit.mobile',
				normalDayTraffic: {
					options: {
						variant: 'normal.traffic.day',
						base: 'traffic',
						type: 'traffictile'
					}
				},
				normalNight: 'normal.night',
				normalNightMobile: 'normal.night.mobile',
				normalNightGrey: 'normal.night.grey',
				normalNightGreyMobile: 'normal.night.grey.mobile',
				normalNightTransit: 'normal.night.transit',
				normalNightTransitMobile: 'normal.night.transit.mobile',
				reducedDay: 'reduced.day',
				reducedNight: 'reduced.night',
				basicMap: {
					options: {
						type: 'basetile'
					}
				},
				mapLabels: {
					options: {
						type: 'labeltile',
						format: 'png'
					}
				},
				trafficFlow: {
					options: {
						base: 'traffic',
						type: 'flowtile'
					}
				},
				carnavDayGrey: 'carnav.day.grey',
				hybridDay: {
					options: {
						base: 'aerial',
						variant: 'hybrid.day'
					}
				},
				hybridDayMobile: {
					options: {
						base: 'aerial',
						variant: 'hybrid.day.mobile'
					}
				},
				hybridDayTransit: {
					options: {
						base: 'aerial',
						variant: 'hybrid.day.transit'
					}
				},
				hybridDayGrey: {
					options: {
						base: 'aerial',
						variant: 'hybrid.grey.day'
					}
				},
				hybridDayTraffic: {
					options: {
						variant: 'hybrid.traffic.day',
						base: 'traffic',
						type: 'traffictile'
					}
				},
				pedestrianDay: 'pedestrian.day',
				pedestrianNight: 'pedestrian.night',
				satelliteDay: {
					options: {
						base: 'aerial',
						variant: 'satellite.day'
					}
				},
				terrainDay: {
					options: {
						base: 'aerial',
						variant: 'terrain.day'
					}
				},
				terrainDayMobile: {
					options: {
						base: 'aerial',
						variant: 'terrain.day.mobile'
					}
				}
			}
		},
		HEREv3: {
			/*
			 * HERE maps API Version 3.
			 * These basemaps are free, but you need an API key. Please sign up at
			 * https://developer.here.com/plans
			 * Version 3 deprecates the app_id and app_code access in favor of apiKey
			 *
			 * Supported access methods as of 2019/12/21:
			 * @see https://developer.here.com/faqs#access-control-1--how-do-you-control-access-to-here-location-services
			 */
			url:
				'https://{s}.{base}.maps.ls.hereapi.com/maptile/2.1/' +
				'{type}/{mapID}/{variant}/{z}/{x}/{y}/{size}/{format}?' +
				'apiKey={apiKey}&lg={language}',
			options: {
				attribution:
					'Map &copy; 1987-' + new Date().getFullYear() + ' <a href="http://developer.here.com">HERE</a>',
				subdomains: '1234',
				mapID: 'newest',
				apiKey: '<insert your apiKey here>',
				base: 'base',
				variant: 'normal.day',
				maxZoom: 20,
				type: 'maptile',
				language: 'eng',
				format: 'png8',
				size: '256'
			},
			variants: {
				normalDay: 'normal.day',
				normalDayCustom: 'normal.day.custom',
				normalDayGrey: 'normal.day.grey',
				normalDayMobile: 'normal.day.mobile',
				normalDayGreyMobile: 'normal.day.grey.mobile',
				normalDayTransit: 'normal.day.transit',
				normalDayTransitMobile: 'normal.day.transit.mobile',
				normalNight: 'normal.night',
				normalNightMobile: 'normal.night.mobile',
				normalNightGrey: 'normal.night.grey',
				normalNightGreyMobile: 'normal.night.grey.mobile',
				normalNightTransit: 'normal.night.transit',
				normalNightTransitMobile: 'normal.night.transit.mobile',
				reducedDay: 'reduced.day',
				reducedNight: 'reduced.night',
				basicMap: {
					options: {
						type: 'basetile'
					}
				},
				mapLabels: {
					options: {
						type: 'labeltile',
						format: 'png'
					}
				},
				trafficFlow: {
					options: {
						base: 'traffic',
						type: 'flowtile'
					}
				},
				carnavDayGrey: 'carnav.day.grey',
				hybridDay: {
					options: {
						base: 'aerial',
						variant: 'hybrid.day'
					}
				},
				hybridDayMobile: {
					options: {
						base: 'aerial',
						variant: 'hybrid.day.mobile'
					}
				},
				hybridDayTransit: {
					options: {
						base: 'aerial',
						variant: 'hybrid.day.transit'
					}
				},
				hybridDayGrey: {
					options: {
						base: 'aerial',
						variant: 'hybrid.grey.day'
					}
				},
				pedestrianDay: 'pedestrian.day',
				pedestrianNight: 'pedestrian.night',
				satelliteDay: {
					options: {
						base: 'aerial',
						variant: 'satellite.day'
					}
				},
				terrainDay: {
					options: {
						base: 'aerial',
						variant: 'terrain.day'
					}
				},
				terrainDayMobile: {
					options: {
						base: 'aerial',
						variant: 'terrain.day.mobile'
					}
				}
			}
		},
		FreeMapSK: {
			url: 'https://{s}.freemap.sk/T/{z}/{x}/{y}.jpeg',
			options: {
				minZoom: 8,
				maxZoom: 16,
				subdomains: 'abcd',
				bounds: [[47.204642, 15.996093], [49.830896, 22.576904]],
				attribution:
					'{attribution.OpenStreetMap}, vizualization CC-By-SA 2.0 <a href="http://freemap.sk">Freemap.sk</a>'
			}
		},
		MtbMap: {
			url: 'http://tile.mtbmap.cz/mtbmap_tiles/{z}/{x}/{y}.png',
			options: {
				attribution:
					'{attribution.OpenStreetMap} &amp; USGS'
			}
		},
		CartoDB: {
			url: 'https://{s}.basemaps.cartocdn.com/{variant}/{z}/{x}/{y}{r}.png',
			options: {
				attribution: '{attribution.OpenStreetMap} &copy; <a href="https://carto.com/attributions">CARTO</a>',
				subdomains: 'abcd',
				maxZoom: 19,
				variant: 'light_all'
			},
			variants: {
				Positron: 'light_all',
				PositronNoLabels: 'light_nolabels',
				PositronOnlyLabels: 'light_only_labels',
				DarkMatter: 'dark_all',
				DarkMatterNoLabels: 'dark_nolabels',
				DarkMatterOnlyLabels: 'dark_only_labels',
				Voyager: 'rastertiles/voyager',
				VoyagerNoLabels: 'rastertiles/voyager_nolabels',
				VoyagerOnlyLabels: 'rastertiles/voyager_only_labels',
				VoyagerLabelsUnder: 'rastertiles/voyager_labels_under'
			}
		},
		HikeBike: {
			url: 'https://tiles.wmflabs.org/{variant}/{z}/{x}/{y}.png',
			options: {
				maxZoom: 19,
				attribution: '{attribution.OpenStreetMap}',
				variant: 'hikebike'
			},
			variants: {
				HikeBike: {},
				HillShading: {
					options: {
						maxZoom: 15,
						variant: 'hillshading'
					}
				}
			}
		},
		BasemapAT: {
			url: 'https://maps{s}.wien.gv.at/basemap/{variant}/{type}/google3857/{z}/{y}/{x}.{format}',
			options: {
				maxZoom: 19,
				attribution: 'Datenquelle: <a href="https://www.basemap.at">basemap.at</a>',
				subdomains: ['', '1', '2', '3', '4'],
				type: 'normal',
				format: 'png',
				bounds: [[46.358770, 8.782379], [49.037872, 17.189532]],
				variant: 'geolandbasemap'
			},
			variants: {
				basemap: {
					options: {
						maxZoom: 20, // currently only in Vienna
						variant: 'geolandbasemap'
					}
				},
				grau: 'bmapgrau',
				overlay: 'bmapoverlay',
				terrain: {
					options: {
						variant: 'bmapgelaende',
						type: 'grau',
						format: 'jpeg'
					}
				},
				surface: {
					options: {
						variant: 'bmapoberflaeche',
						type: 'grau',
						format: 'jpeg'
					}
				},
				highdpi: {
					options: {
						variant: 'bmaphidpi',
						format: 'jpeg'
					}
				},
				orthofoto: {
					options: {
						maxZoom: 20, // currently only in Vienna
						variant: 'bmaporthofoto30cm',
						format: 'jpeg'
					}
				}
			}
		},
		nlmaps: {
			url: 'https://geodata.nationaalgeoregister.nl/tiles/service/wmts/{variant}/EPSG:3857/{z}/{x}/{y}.png',
			options: {
				minZoom: 6,
				maxZoom: 19,
				bounds: [[50.5, 3.25], [54, 7.6]],
				attribution: 'Kaartgegevens &copy; <a href="https://www.kadaster.nl">Kadaster</a>'
			},
			variants: {
				'standaard': 'brtachtergrondkaart',
				'pastel': 'brtachtergrondkaartpastel',
				'grijs': 'brtachtergrondkaartgrijs',
				'luchtfoto': {
					'url': 'https://service.pdok.nl/hwh/luchtfotorgb/wmts/v1_0/Actueel_ortho25/EPSG:3857/{z}/{x}/{y}.jpeg',
				}
			}
		},
		NASAGIBS: {
			url: 'https://map1.vis.earthdata.nasa.gov/wmts-webmerc/{variant}/default/{time}/{tilematrixset}{maxZoom}/{z}/{y}/{x}.{format}',
			options: {
				attribution:
					'Imagery provided by services from the Global Imagery Browse Services (GIBS), operated by the NASA/GSFC/Earth Science Data and Information System ' +
					'(<a href="https://earthdata.nasa.gov">ESDIS</a>) with funding provided by NASA/HQ.',
				bounds: [[-85.0511287776, -179.999999975], [85.0511287776, 179.999999975]],
				minZoom: 1,
				maxZoom: 9,
				format: 'jpg',
				time: '',
				tilematrixset: 'GoogleMapsCompatible_Level'
			},
			variants: {
				ModisTerraTrueColorCR: 'MODIS_Terra_CorrectedReflectance_TrueColor',
				ModisTerraBands367CR: 'MODIS_Terra_CorrectedReflectance_Bands367',
				ViirsEarthAtNight2012: {
					options: {
						variant: 'VIIRS_CityLights_2012',
						maxZoom: 8
					}
				},
				ModisTerraLSTDay: {
					options: {
						variant: 'MODIS_Terra_Land_Surface_Temp_Day',
						format: 'png',
						maxZoom: 7,
						opacity: 0.75
					}
				},
				ModisTerraSnowCover: {
					options: {
						variant: 'MODIS_Terra_NDSI_Snow_Cover',
						format: 'png',
						maxZoom: 8,
						opacity: 0.75
					}
				},
				ModisTerraAOD: {
					options: {
						variant: 'MODIS_Terra_Aerosol',
						format: 'png',
						maxZoom: 6,
						opacity: 0.75
					}
				},
				ModisTerraChlorophyll: {
					options: {
						variant: 'MODIS_Terra_Chlorophyll_A',
						format: 'png',
						maxZoom: 7,
						opacity: 0.75
					}
				}
			}
		},
		NLS: {
			// NLS maps are copyright National library of Scotland.
			// http://maps.nls.uk/projects/api/index.html
			// Please contact NLS for anything other than non-commercial low volume usage
			//
			// Map sources: Ordnance Survey 1:1m to 1:63K, 1920s-1940s
			//   z0-9  - 1:1m
			//  z10-11 - quarter inch (1:253440)
			//  z12-18 - one inch (1:63360)
			url: 'https://nls-{s}.tileserver.com/nls/{z}/{x}/{y}.jpg',
			options: {
				attribution: '<a href="http://geo.nls.uk/maps/">National Library of Scotland Historic Maps</a>',
				bounds: [[49.6, -12], [61.7, 3]],
				minZoom: 1,
				maxZoom: 18,
				subdomains: '0123',
			}
		},
		JusticeMap: {
			// Justice Map (http://www.justicemap.org/)
			// Visualize race and income data for your community, county and country.
			// Includes tools for data journalists, bloggers and community activists.
			url: 'https://www.justicemap.org/tile/{size}/{variant}/{z}/{x}/{y}.png',
			options: {
				attribution: '<a href="http://www.justicemap.org/terms.php">Justice Map</a>',
				// one of 'county', 'tract', 'block'
				size: 'county',
				// Bounds for USA, including Alaska and Hawaii
				bounds: [[14, -180], [72, -56]]
			},
			variants: {
				income: 'income',
				americanIndian: 'indian',
				asian: 'asian',
				black: 'black',
				hispanic: 'hispanic',
				multi: 'multi',
				nonWhite: 'nonwhite',
				white: 'white',
				plurality: 'plural'
			}
		},
		GeoportailFrance: {
			url: 'https://wxs.ign.fr/{apikey}/geoportail/wmts?REQUEST=GetTile&SERVICE=WMTS&VERSION=1.0.0&STYLE={style}&TILEMATRIXSET=PM&FORMAT={format}&LAYER={variant}&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}',
			options: {
				attribution: '<a target="_blank" href="https://www.geoportail.gouv.fr/">Geoportail France</a>',
				bounds: [[-75, -180], [81, 180]],
				minZoom: 2,
				maxZoom: 18,
				// Get your own geoportail apikey here : http://professionnels.ign.fr/ign/contrats/
				// NB : 'choisirgeoportail' is a demonstration key that comes with no guarantee
				apikey: 'choisirgeoportail',
				format: 'image/png',
				style: 'normal',
				variant: 'GEOGRAPHICALGRIDSYSTEMS.PLANIGNV2'
			},
			variants: {
				plan: 'GEOGRAPHICALGRIDSYSTEMS.PLANIGNV2',
				parcels: {
					options: {
						variant: 'CADASTRALPARCELS.PARCELLAIRE_EXPRESS',
						style: 'PCI vecteur',
						maxZoom: 20
					}
				},
				orthos: {
					options: {
						maxZoom: 19,
						format: 'image/jpeg',
						variant: 'ORTHOIMAGERY.ORTHOPHOTOS'
					}
				}
			}
		},
		OneMapSG: {
			url: 'https://maps-{s}.onemap.sg/v3/{variant}/{z}/{x}/{y}.png',
			options: {
				variant: 'Default',
				minZoom: 11,
				maxZoom: 18,
				bounds: [[1.56073, 104.11475], [1.16, 103.502]],
				attribution: '<img src="https://docs.onemap.sg/maps/images/oneMap64-01.png" style="height:20px;width:20px;"/> New OneMap | Map data &copy; contributors, <a href="http://SLA.gov.sg">Singapore Land Authority</a>'
			},
			variants: {
				Default: 'Default',
				Night: 'Night',
				Original: 'Original',
				Grey: 'Grey',
				LandLot: 'LandLot'
			}
		},
		USGS: {
			url: 'https://basemap.nationalmap.gov/arcgis/rest/services/USGSTopo/MapServer/tile/{z}/{y}/{x}',
			options: {
				maxZoom: 20,
				attribution: 'Tiles courtesy of the <a href="https://usgs.gov/">U.S. Geological Survey</a>'
			},
			variants: {
				USTopo: {},
				USImagery: {
					url: 'https://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryOnly/MapServer/tile/{z}/{y}/{x}'
				},
				USImageryTopo: {
					url: 'https://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryTopo/MapServer/tile/{z}/{y}/{x}'
				}
			}
		},
		WaymarkedTrails: {
			url: 'https://tile.waymarkedtrails.org/{variant}/{z}/{x}/{y}.png',
			options: {
				maxZoom: 18,
				attribution: 'Map data: {attribution.OpenStreetMap} | Map style: &copy; <a href="https://waymarkedtrails.org">waymarkedtrails.org</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
			},
			variants: {
				hiking: 'hiking',
				cycling: 'cycling',
				mtb: 'mtb',
				slopes: 'slopes',
				riding: 'riding',
				skating: 'skating'
			}
		},
		OpenAIP: {
			url: 'https://{s}.tile.maps.openaip.net/geowebcache/service/tms/1.0.0/openaip_basemap@EPSG%3A900913@png/{z}/{x}/{y}.{ext}',
			options: {
				attribution: '<a href="https://www.openaip.net/">openAIP Data</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-NC-SA</a>)',
				ext: 'png',
				minZoom: 4,
				maxZoom: 14,
				tms: true,
				detectRetina: true,
				subdomains: '12'
			}
		},
		OpenSnowMap: {
			url: 'https://tiles.opensnowmap.org/{variant}/{z}/{x}/{y}.png',
			options: {
				minZoom: 9,
				maxZoom: 18,
				attribution: 'Map data: {attribution.OpenStreetMap} & ODbL, &copy; <a href="https://www.opensnowmap.org/iframes/data.html">www.opensnowmap.org</a> <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
			},
			variants: {
				pistes: 'pistes',
			}
		},
		AzureMaps: {
			url: 
				'https://atlas.microsoft.com/map/tile?api-version={apiVersion}'+
				'&tilesetId={variant}&x={x}&y={y}&zoom={z}&language={language}'+
				'&subscription-key={subscriptionKey}',
			options: {
				attribution: 'See https://docs.microsoft.com/en-US/rest/api/maps/renderv2/getmaptilepreview for details.',
				apiVersion: '2.0',
				variant: 'microsoft.imagery',
				subscriptionKey: '<insert your subscription key here>',
				language: 'en-US',
			},
			variants: {
				MicrosoftImagery: 'microsoft.imagery',
				MicrosoftBaseDarkGrey: 'microsoft.base.darkgrey',
				MicrosoftBaseRoad: 'microsoft.base.road',
				MicrosoftBaseHybridRoad: 'microsoft.base.hybrid.road',
				MicrosoftTerraMain: 'microsoft.terra.main',
				MicrosoftWeatherInfraredMain: {
					url: 
					'https://atlas.microsoft.com/map/tile?api-version={apiVersion}'+
					'&tilesetId={variant}&x={x}&y={y}&zoom={z}'+
					'&timeStamp={timeStamp}&language={language}' +
					'&subscription-key={subscriptionKey}',
					options: {
						timeStamp: '2021-05-08T09:03:00Z',
						attribution: 'See https://docs.microsoft.com/en-US/rest/api/maps/renderv2/getmaptilepreview#uri-parameters for details.',
						variant: 'microsoft.weather.infrared.main',
					},
				},
				MicrosoftWeatherRadarMain: {
					url: 
					'https://atlas.microsoft.com/map/tile?api-version={apiVersion}'+
					'&tilesetId={variant}&x={x}&y={y}&zoom={z}'+
					'&timeStamp={timeStamp}&language={language}' +
					'&subscription-key={subscriptionKey}',
					options: {
						timeStamp: '2021-05-08T09:03:00Z',
						attribution: 'See https://docs.microsoft.com/en-US/rest/api/maps/renderv2/getmaptilepreview#uri-parameters for details.',
						variant: 'microsoft.weather.radar.main',
					},
				}
			},
		}
	};

	L.tileLayer.provider = function (provider, options) {
		return new L.TileLayer.Provider(provider, options);
	};

	return L;
}))}catch(e){console.log(e)}try{!function (t, s) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = s() : "function" == typeof define && define.amd ? define(s) : (t || self).Typed = s()
}(this, function () {
    function t() {
        return t = Object.assign ? Object.assign.bind() : function (t) {
            for (var s = 1; s < arguments.length; s++) {
                var e = arguments[s];
                for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n])
            }
            return t
        }, t.apply(this, arguments)
    }

    var s = {
        strings: ["These are the default values...", "You know what you should do?", "Use your own!", "Have a great day!"],
        stringsElement: null,
        typeSpeed: 0,
        startDelay: 0,
        backSpeed: 0,
        smartBackspace: !0,
        shuffle: !1,
        backDelay: 700,
        fadeOut: !1,
        fadeOutClass: "typed-fade-out",
        fadeOutDelay: 500,
        loop: !1,
        loopCount: Infinity,
        showCursor: !0,
        cursorChar: "|",
        autoInsertCss: !0,
        attr: null,
        bindInputFocusEvents: !1,
        contentType: "html",
        onBegin: function (t) {
        },
        onComplete: function (t) {
        },
        preStringTyped: function (t, s) {
        },
        onStringTyped: function (t, s) {
        },
        onLastStringBackspaced: function (t) {
        },
        onTypingPaused: function (t, s) {
        },
        onTypingResumed: function (t, s) {
        },
        onReset: function (t) {
        },
        onStop: function (t, s) {
        },
        onStart: function (t, s) {
        },
        onDestroy: function (t) {
        }
    }, e = new (/*#__PURE__*/function () {
        function e() {
        }

        var n = e.prototype;
        return n.load = function (e, n, i) {
            if (e.el = "string" == typeof i ? document.querySelector(i) : i, e.options = t({}, s, n), e.isInput = "input" === e.el.tagName.toLowerCase(), e.attr = e.options.attr, e.bindInputFocusEvents = e.options.bindInputFocusEvents, e.showCursor = !e.isInput && e.options.showCursor, e.cursorChar = e.options.cursorChar, e.cursorBlinking = !0, e.elContent = e.attr ? e.el.getAttribute(e.attr) : e.el.textContent, e.contentType = e.options.contentType, e.typeSpeed = e.options.typeSpeed, e.startDelay = e.options.startDelay, e.backSpeed = e.options.backSpeed, e.smartBackspace = e.options.smartBackspace, e.backDelay = e.options.backDelay, e.fadeOut = e.options.fadeOut, e.fadeOutClass = e.options.fadeOutClass, e.fadeOutDelay = e.options.fadeOutDelay, e.isPaused = !1, e.strings = e.options.strings.map(function (t) {
                return t.trim()
            }), e.stringsElement = "string" == typeof e.options.stringsElement ? document.querySelector(e.options.stringsElement) : e.options.stringsElement, e.stringsElement) {
                e.strings = [], e.stringsElement.style.cssText = "clip: rect(0 0 0 0);clip-path:inset(50%);height:1px;overflow:hidden;position:absolute;white-space:nowrap;width:1px;";
                var r = Array.prototype.slice.apply(e.stringsElement.children), o = r.length;
                if (o) for (var a = 0; a < o; a += 1) e.strings.push(r[a].innerHTML.trim())
            }
            for (var u in e.strPos = 0, e.currentElContent = this.getCurrentElContent(e), e.currentElContent && e.currentElContent.length > 0 && (e.strPos = e.currentElContent.length - 1, e.strings.unshift(e.currentElContent)), e.sequence = [], e.strings) e.sequence[u] = u;
            e.arrayPos = 0, e.stopNum = 0, e.loop = e.options.loop, e.loopCount = e.options.loopCount, e.curLoop = 0, e.shuffle = e.options.shuffle, e.pause = {
                status: !1,
                typewrite: !0,
                curString: "",
                curStrPos: 0
            }, e.typingComplete = !1, e.autoInsertCss = e.options.autoInsertCss, e.autoInsertCss && (this.appendCursorAnimationCss(e), this.appendFadeOutAnimationCss(e))
        }, n.getCurrentElContent = function (t) {
            return t.attr ? t.el.getAttribute(t.attr) : t.isInput ? t.el.value : "html" === t.contentType ? t.el.innerHTML : t.el.textContent
        }, n.appendCursorAnimationCss = function (t) {
            var s = "data-typed-js-cursor-css";
            if (t.showCursor && !document.querySelector("[" + s + "]")) {
                var e = document.createElement("style");
                e.setAttribute(s, "true"), e.innerHTML = "\n        .typed-cursor{\n          opacity: 1;\n        }\n        .typed-cursor.typed-cursor--blink{\n          animation: typedjsBlink 0.7s infinite;\n          -webkit-animation: typedjsBlink 0.7s infinite;\n                  animation: typedjsBlink 0.7s infinite;\n        }\n        @keyframes typedjsBlink{\n          50% { opacity: 0.0; }\n        }\n        @-webkit-keyframes typedjsBlink{\n          0% { opacity: 1; }\n          50% { opacity: 0.0; }\n          100% { opacity: 1; }\n        }\n      ", document.body.appendChild(e)
            }
        }, n.appendFadeOutAnimationCss = function (t) {
            var s = "data-typed-fadeout-js-css";
            if (t.fadeOut && !document.querySelector("[" + s + "]")) {
                var e = document.createElement("style");
                e.setAttribute(s, "true"), e.innerHTML = "\n        .typed-fade-out{\n          opacity: 0;\n          transition: opacity .25s;\n        }\n        .typed-cursor.typed-cursor--blink.typed-fade-out{\n          -webkit-animation: 0;\n          animation: 0;\n        }\n      ", document.body.appendChild(e)
            }
        }, e
    }()), n = new (/*#__PURE__*/function () {
        function t() {
        }

        var s = t.prototype;
        return s.typeHtmlChars = function (t, s, e) {
            if ("html" !== e.contentType) return s;
            var n = t.substring(s).charAt(0);
            if ("<" === n || "&" === n) {
                var i;
                for (i = "<" === n ? ">" : ";"; t.substring(s + 1).charAt(0) !== i && !(1 + ++s > t.length);) ;
                s++
            }
            return s
        }, s.backSpaceHtmlChars = function (t, s, e) {
            if ("html" !== e.contentType) return s;
            var n = t.substring(s).charAt(0);
            if (">" === n || ";" === n) {
                var i;
                for (i = ">" === n ? "<" : "&"; t.substring(s - 1).charAt(0) !== i && !(--s < 0);) ;
                s--
            }
            return s
        }, t
    }());/*#__PURE__*/
    return function () {
        function t(t, s) {
            e.load(this, s, t), this.begin()
        }

        var s = t.prototype;
        return s.toggle = function () {
            this.pause.status ? this.start() : this.stop()
        }, s.stop = function () {
            this.typingComplete || this.pause.status || (this.toggleBlinking(!0), this.pause.status = !0, this.options.onStop(this.arrayPos, this))
        }, s.start = function () {
            this.typingComplete || this.pause.status && (this.pause.status = !1, this.pause.typewrite ? this.typewrite(this.pause.curString, this.pause.curStrPos) : this.backspace(this.pause.curString, this.pause.curStrPos), this.options.onStart(this.arrayPos, this))
        }, s.destroy = function () {
            this.reset(!1), this.options.onDestroy(this)
        }, s.reset = function (t) {
            void 0 === t && (t = !0), clearInterval(this.timeout), this.replaceText(""), this.cursor && this.cursor.parentNode && (this.cursor.parentNode.removeChild(this.cursor), this.cursor = null), this.strPos = 0, this.arrayPos = 0, this.curLoop = 0, t && (this.insertCursor(), this.options.onReset(this), this.begin())
        }, s.begin = function () {
            var t = this;
            this.options.onBegin(this), this.typingComplete = !1, this.shuffleStringsIfNeeded(this), this.insertCursor(), this.bindInputFocusEvents && this.bindFocusEvents(), this.timeout = setTimeout(function () {
                0 === t.strPos ? t.typewrite(t.strings[t.sequence[t.arrayPos]], t.strPos) : t.backspace(t.strings[t.sequence[t.arrayPos]], t.strPos)
            }, this.startDelay)
        }, s.typewrite = function (t, s) {
            var e = this;
            this.fadeOut && this.el.classList.contains(this.fadeOutClass) && (this.el.classList.remove(this.fadeOutClass), this.cursor && this.cursor.classList.remove(this.fadeOutClass));
            var i = this.humanizer(this.typeSpeed), r = 1;
            !0 !== this.pause.status ? this.timeout = setTimeout(function () {
                s = n.typeHtmlChars(t, s, e);
                var i = 0, o = t.substring(s);
                if ("^" === o.charAt(0) && /^\^\d+/.test(o)) {
                    var a = 1;
                    a += (o = /\d+/.exec(o)[0]).length, i = parseInt(o), e.temporaryPause = !0, e.options.onTypingPaused(e.arrayPos, e), t = t.substring(0, s) + t.substring(s + a), e.toggleBlinking(!0)
                }
                if ("`" === o.charAt(0)) {
                    for (; "`" !== t.substring(s + r).charAt(0) && (r++, !(s + r > t.length));) ;
                    var u = t.substring(0, s), p = t.substring(u.length + 1, s + r), c = t.substring(s + r + 1);
                    t = u + p + c, r--
                }
                e.timeout = setTimeout(function () {
                    e.toggleBlinking(!1), s >= t.length ? e.doneTyping(t, s) : e.keepTyping(t, s, r), e.temporaryPause && (e.temporaryPause = !1, e.options.onTypingResumed(e.arrayPos, e))
                }, i)
            }, i) : this.setPauseStatus(t, s, !0)
        }, s.keepTyping = function (t, s, e) {
            0 === s && (this.toggleBlinking(!1), this.options.preStringTyped(this.arrayPos, this));
            var n = t.substring(0, s += e);
            this.replaceText(n), this.typewrite(t, s)
        }, s.doneTyping = function (t, s) {
            var e = this;
            this.options.onStringTyped(this.arrayPos, this), this.toggleBlinking(!0), this.arrayPos === this.strings.length - 1 && (this.complete(), !1 === this.loop || this.curLoop === this.loopCount) || (this.timeout = setTimeout(function () {
                e.backspace(t, s)
            }, this.backDelay))
        }, s.backspace = function (t, s) {
            var e = this;
            if (!0 !== this.pause.status) {
                if (this.fadeOut) return this.initFadeOut();
                this.toggleBlinking(!1);
                var i = this.humanizer(this.backSpeed);
                this.timeout = setTimeout(function () {
                    s = n.backSpaceHtmlChars(t, s, e);
                    var i = t.substring(0, s);
                    if (e.replaceText(i), e.smartBackspace) {
                        var r = e.strings[e.arrayPos + 1];
                        e.stopNum = r && i === r.substring(0, s) ? s : 0
                    }
                    s > e.stopNum ? (s--, e.backspace(t, s)) : s <= e.stopNum && (e.arrayPos++, e.arrayPos === e.strings.length ? (e.arrayPos = 0, e.options.onLastStringBackspaced(), e.shuffleStringsIfNeeded(), e.begin()) : e.typewrite(e.strings[e.sequence[e.arrayPos]], s))
                }, i)
            } else this.setPauseStatus(t, s, !1)
        }, s.complete = function () {
            this.options.onComplete(this), this.loop ? this.curLoop++ : this.typingComplete = !0
        }, s.setPauseStatus = function (t, s, e) {
            this.pause.typewrite = e, this.pause.curString = t, this.pause.curStrPos = s
        }, s.toggleBlinking = function (t) {
            this.cursor && (this.pause.status || this.cursorBlinking !== t && (this.cursorBlinking = t, t ? this.cursor.classList.add("typed-cursor--blink") : this.cursor.classList.remove("typed-cursor--blink")))
        }, s.humanizer = function (t) {
            return Math.round(Math.random() * t / 2) + t
        }, s.shuffleStringsIfNeeded = function () {
            this.shuffle && (this.sequence = this.sequence.sort(function () {
                return Math.random() - .5
            }))
        }, s.initFadeOut = function () {
            var t = this;
            return this.el.className += " " + this.fadeOutClass, this.cursor && (this.cursor.className += " " + this.fadeOutClass), setTimeout(function () {
                t.arrayPos++, t.replaceText(""), t.strings.length > t.arrayPos ? t.typewrite(t.strings[t.sequence[t.arrayPos]], 0) : (t.typewrite(t.strings[0], 0), t.arrayPos = 0)
            }, this.fadeOutDelay)
        }, s.replaceText = function (t) {
            this.attr ? this.el.setAttribute(this.attr, t) : this.isInput ? this.el.value = t : "html" === this.contentType ? this.el.innerHTML = t : this.el.textContent = t
        }, s.bindFocusEvents = function () {
            var t = this;
            this.isInput && (this.el.addEventListener("focus", function (s) {
                t.stop()
            }), this.el.addEventListener("blur", function (s) {
                t.el.value && 0 !== t.el.value.length || t.start()
            }))
        }, s.insertCursor = function () {
            this.showCursor && (this.cursor || (this.cursor = document.createElement("span"), this.cursor.className = "typed-cursor", this.cursor.setAttribute("aria-hidden", !0), this.cursor.innerHTML = this.cursorChar, this.el.parentNode && this.el.parentNode.insertBefore(this.cursor, this.el.nextSibling)))
        }, t
    }()
});
//# sourceMappingURL=typed.umd.js.map;
}catch(e){console.log(e)}