/*! mobify-accordion 0.2.0 2013-03-20 */
var Mobify=window.Mobify=window.Mobify||{};Mobify.$=Mobify.$||window.Zepto||window.jQuery,Mobify.UI=Mobify.UI||{},function(n,t){n.support=n.support||{},n.extend(n.support,{touch:"ontouchend"in t})}(Mobify.$,document),Mobify.UI.Utils=function(n){function t(){if(/iPhone\ OS\ 3_1/.test(navigator.userAgent))return void 0;var n,t=document.createElement("fakeelement"),e={transition:"transitionEnd transitionend",OTransition:"oTransitionEnd",MSTransition:"msTransitionEnd",MozTransition:"transitionend",WebkitTransition:"webkitTransitionEnd"};for(n in e)if(void 0!==t.style[n])return e[n]}var e={},i=n.support;return e.events=i.touch?{down:"touchstart",move:"touchmove",up:"touchend"}:{down:"mousedown",move:"mousemove",up:"mouseup"},e.getCursorPosition=i.touch?function(n){return n=n.originalEvent||n,{x:n.touches[0].clientX,y:n.touches[0].clientY}}:function(n){return{x:n.clientX,y:n.clientY}},e.getProperty=function(n){for(var t=["Webkit","Moz","O","ms",""],e=document.createElement("div").style,i=0;t.length>i;++i)if(void 0!==e[t[i]+n])return t[i]+n},n.extend(e.events,{transitionend:t()}),e}(Mobify.$),Mobify.UI.Accordion=function(n,t){n.support;var e=function(t){this.element=t,this.$element=n(t),this.dragRadius=10,this.bind()};return e.prototype.bind=function(){function e(){var t=n(this).parent();t.hasClass("m-closed")&&n(this).parent().removeClass("m-active");var e=0;n(".m-item",h).each(function(){var t=n(this);e+=t.height()}),h.css("min-height",e+"px")}function i(n){n.removeClass("m-opened"),n.addClass("m-closed"),t.events.transitionend||n.removeClass("m-active"),n.find(".m-content").css("max-height",0)}function o(n){var e=n.find(".m-content");n.addClass("m-active"),n.removeClass("m-closed"),n.addClass("m-opened");var i=e.children(),o="outerHeight"in i?i.outerHeight():i.height();e.css("max-height",1.5*o+"px"),t.events.transitionend&&h.css("min-height",h.height()+o+"px")}function s(n){c=t.getCursorPosition(n)}function r(n){u=t.getCursorPosition(n)}function a(){if(!(u&&(dx=c.x-u.x,dy=c.y-u.y,u=void 0,dx*dx+dy*dy>f*f))){var t=n(this).parent();t.hasClass("m-active")?i(t):o(t)}}function d(n){n.preventDefault()}var c,u,h=this.$element,f=this.dragRadius,m=location.hash,v=h.find('.m-header a[href="'+m+'"]');v.length&&o(v.parent()),h.find(".m-header").on(t.events.down,s).on(t.events.move,r).on(t.events.up,a).on("click",d),t.events.transitionend&&h.find(".m-content").on(t.events.transitionend,e)},e.prototype.unbind=function(){this.$element.off()},e.prototype.destroy=function(){this.unbind(),this.$element.remove(),this.$element=null},e}(Mobify.$,Mobify.UI.Utils),function(n){n.fn.accordion=function(t){return this.each(function(){var e=n(this),i=e._accordion;i||(i=new Mobify.UI.Accordion(this)),t&&(i[t](),"destroy"===t&&(i=null)),e._accordion=i}),this}}(Mobify.$);