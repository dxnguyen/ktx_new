try{lazyLoadXT={edgeY:"0px"}}catch(e){console.log(e)}try{!function(e,t,n,o,a,r,i){function s(e){i&&i.unobserve(e),e.onload=function(){this.classList.remove(r)},e["IMG"===e.tagName?"srcset":"src"]=e.getAttribute(a)}function d(n,d,c,l){for(o&&!i&&(i=new o(function(e){e.forEach(function(e){e.isIntersecting&&s(e.target)})},{rootMargin:e.lazyLoadXT&&lazyLoadXT.edgeY||""})),l=t.querySelectorAll("["+a+"]"),n=0;n<l.length;n++)(c=(d=l[n]).classList).remove("lazy"),c.add(r),i?i.observe(d):s(d)}"loading"!==t.readyState?setTimeout(d):n("DOMContentLoaded",d),n("DOMUpdated",d)}(window,document,addEventListener,window.IntersectionObserver,"data-src","lazy-hidden")}catch(e){console.log(e)}try{!function(e,o,t,r,n){function a(){for(o of(r=r||new IntersectionObserver(function(e){for(o of e)if(o.isIntersecting){for(t of(r.unobserve(o=o.target),o.poster=o.dataset.poster||o.poster,(n=o.dataset.src)&&(o.src=n),o.children))"SOURCE"===t.tagName&&(n=t.dataset.src)&&(t.src=n);o.load()}},{rootMargin:window.lazyLoadXT&&lazyLoadXT.edgeY||""}),document.querySelectorAll("video.lazy-video")))r.observe(o)}e("DOMContentLoaded",a),e("DOMUpdated",a)}(addEventListener)}catch(e){console.log(e)}