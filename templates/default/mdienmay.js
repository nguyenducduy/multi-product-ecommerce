/* mobify-accordion 0.2.0 2013-03-20 */
var Mobify = (window.Mobify = window.Mobify || {})
;(Mobify.$ = Mobify.$ || window.Zepto || window.jQuery),
  (Mobify.UI = Mobify.UI || {}),
  (function (n, t) {
    ;(n.support = n.support || {}), n.extend(n.support, { touch: 'ontouchend' in t })
  })(Mobify.$, document),
  (Mobify.UI.Utils = (function (n) {
    function t() {
      if (/iPhone\ OS\ 3_1/.test(navigator.userAgent)) return void 0
      var n,
        t = document.createElement('fakeelement'),
        e = {
          transition: 'transitionEnd transitionend',
          OTransition: 'oTransitionEnd',
          MSTransition: 'msTransitionEnd',
          MozTransition: 'transitionend',
          WebkitTransition: 'webkitTransitionEnd',
        }
      for (n in e) if (void 0 !== t.style[n]) return e[n]
    }
    var e = {},
      i = n.support
    return (
      (e.events = i.touch
        ? { down: 'touchstart', move: 'touchmove', up: 'touchend' }
        : { down: 'mousedown', move: 'mousemove', up: 'mouseup' }),
      (e.getCursorPosition = i.touch
        ? function (n) {
            return (n = n.originalEvent || n), { x: n.touches[0].clientX, y: n.touches[0].clientY }
          }
        : function (n) {
            return { x: n.clientX, y: n.clientY }
          }),
      (e.getProperty = function (n) {
        for (
          var t = ['Webkit', 'Moz', 'O', 'ms', ''], e = document.createElement('div').style, i = 0;
          t.length > i;
          ++i
        )
          if (void 0 !== e[t[i] + n]) return t[i] + n
      }),
      n.extend(e.events, { transitionend: t() }),
      e
    )
  })(Mobify.$)),
  (Mobify.UI.Accordion = (function (n, t) {
    n.support
    var e = function (t) {
      ;(this.element = t), (this.$element = n(t)), (this.dragRadius = 10), this.bind()
    }
    return (
      (e.prototype.bind = function () {
        function e() {
          var t = n(this).parent()
          t.hasClass('m-closed') && n(this).parent().removeClass('m-active')
          var e = 0
          n('.m-item', h).each(function () {
            var t = n(this)
            e += t.height()
          }),
            h.css('min-height', e + 'px')
        }
        function i(n) {
          n.removeClass('m-opened'),
            n.addClass('m-closed'),
            t.events.transitionend || n.removeClass('m-active'),
            n.find('.m-content').css('max-height', 0)
        }
        function o(n) {
          var e = n.find('.m-content')
          n.addClass('m-active'), n.removeClass('m-closed'), n.addClass('m-opened')
          var i = e.children(),
            o = 'outerHeight' in i ? i.outerHeight() : i.height()
          e.css('max-height', 1.5 * o + 'px'), t.events.transitionend && h.css('min-height', h.height() + o + 'px')
        }
        function s(n) {
          c = t.getCursorPosition(n)
        }
        function r(n) {
          u = t.getCursorPosition(n)
        }
        function a() {
          if (!(u && ((dx = c.x - u.x), (dy = c.y - u.y), (u = void 0), dx * dx + dy * dy > f * f))) {
            var t = n(this).parent()
            t.hasClass('m-active') ? i(t) : o(t)
          }
        }
        function d(n) {
          n.preventDefault()
        }
        var c,
          u,
          h = this.$element,
          f = this.dragRadius,
          m = location.hash,
          v = h.find('.m-header a[href="' + m + '"]')
        v.length && o(v.parent()),
          h.find('.m-header').on(t.events.down, s).on(t.events.move, r).on(t.events.up, a).on('click', d),
          t.events.transitionend && h.find('.m-content').on(t.events.transitionend, e)
      }),
      (e.prototype.unbind = function () {
        this.$element.off()
      }),
      (e.prototype.destroy = function () {
        this.unbind(), this.$element.remove(), (this.$element = null)
      }),
      e
    )
  })(Mobify.$, Mobify.UI.Utils)),
  (function (n) {
    n.fn.accordion = function (t) {
      return (
        this.each(function () {
          var e = n(this),
            i = e._accordion
          i || (i = new Mobify.UI.Accordion(this)), t && (i[t](), 'destroy' === t && (i = null)), (e._accordion = i)
        }),
        this
      )
    }
  })(Mobify.$)
var Events = function () {
  var eventSplitter = /\s+/
  function Events() {}
  Events.prototype.on = function (events, callback, context) {
    var cache, event, list
    if (!callback) return this
    cache = this.__events || (this.__events = {})
    events = events.split(eventSplitter)
    while ((event = events.shift())) {
      list = cache[event] || (cache[event] = [])
      list.push(callback, context)
    }
    return this
  }
  Events.prototype.off = function (events, callback, context) {
    var cache, event, list, i
    if (!(cache = this.__events)) return this
    if (!(events || callback || context)) {
      delete this.__events
      return this
    }
    events = events ? events.split(eventSplitter) : keys(cache)
    while ((event = events.shift())) {
      list = cache[event]
      if (!list) continue
      if (!(callback || context)) {
        delete cache[event]
        continue
      }
      for (i = list.length - 2; i >= 0; i -= 2) {
        if (!((callback && list[i] !== callback) || (context && list[i + 1] !== context))) {
          list.splice(i, 2)
        }
      }
    }
    return this
  }
  Events.prototype.trigger = function (events) {
    var cache,
      event,
      all,
      list,
      i,
      len,
      rest = [],
      args,
      returned = { status: true }
    if (!(cache = this.__events)) return this
    events = events.split(eventSplitter)
    for (i = 1, len = arguments.length; i < len; i++) {
      rest[i - 1] = arguments[i]
    }
    while ((event = events.shift())) {
      if ((all = cache.all)) all = all.slice()
      if ((list = cache[event])) list = list.slice()
      callEach(list, rest, this, returned)
      callEach(all, [event].concat(rest), this, returned)
    }
    return returned.status
  }
  Events.mixTo = function (receiver) {
    receiver = receiver.prototype || receiver
    var proto = Events.prototype
    for (var p in proto) {
      if (proto.hasOwnProperty(p)) {
        receiver[p] = proto[p]
      }
    }
  }
  var keys = Object.keys
  if (!keys) {
    keys = function (o) {
      var result = []
      for (var name in o) {
        if (o.hasOwnProperty(name)) {
          result.push(name)
        }
      }
      return result
    }
  }
  function callEach(list, args, context, returned) {
    var r
    if (list) {
      for (var i = 0, len = list.length; i < len; i += 2) {
        r = list[i].apply(list[i + 1] || context, args)
        r === false && returned.status && (returned.status = false)
      }
    }
  }
  return Events
}.call(this)
var Class = function (require, exports, module) {
  var module = {}
  function Class(o) {
    if (!(this instanceof Class) && isFunction(o)) {
      return classify(o)
    }
  }
  module.exports = Class
  Class.create = function (parent, properties) {
    if (!isFunction(parent)) {
      properties = parent
      parent = null
    }
    properties || (properties = {})
    parent || (parent = properties.Extends || Class)
    properties.Extends = parent
    function SubClass() {
      parent.apply(this, arguments)
      if (this.constructor === SubClass && this.initialize) {
        this.initialize.apply(this, arguments)
      }
    }
    if (parent !== Class) {
      mix(SubClass, parent, parent.StaticsWhiteList)
    }
    implement.call(SubClass, properties)
    return classify(SubClass)
  }
  function implement(properties) {
    var key, value
    for (key in properties) {
      value = properties[key]
      if (Class.Mutators.hasOwnProperty(key)) {
        Class.Mutators[key].call(this, value)
      } else {
        this.prototype[key] = value
      }
    }
  }
  Class.extend = function (properties) {
    properties || (properties = {})
    properties.Extends = this
    return Class.create(properties)
  }
  function classify(cls) {
    cls.extend = Class.extend
    cls.implement = implement
    return cls
  }
  Class.Mutators = {
    Extends: function (parent) {
      var existed = this.prototype
      var proto = createProto(parent.prototype)
      mix(proto, existed)
      proto.constructor = this
      this.prototype = proto
      this.superclass = parent.prototype
    },
    Implements: function (items) {
      isArray(items) || (items = [items])
      var proto = this.prototype,
        item
      while ((item = items.shift())) {
        mix(proto, item.prototype || item)
      }
    },
    Statics: function (staticProperties) {
      mix(this, staticProperties)
    },
  }
  function Ctor() {}
  var createProto = Object.__proto__
    ? function (proto) {
        return { __proto__: proto }
      }
    : function (proto) {
        Ctor.prototype = proto
        return new Ctor()
      }
  function mix(r, s, wl) {
    for (var p in s) {
      if (s.hasOwnProperty(p)) {
        if (wl && indexOf(wl, p) === -1) continue
        if (p !== 'prototype') {
          r[p] = s[p]
        }
      }
    }
  }
  var toString = Object.prototype.toString
  var isArray =
    Array.isArray ||
    function (val) {
      return toString.call(val) === '[object Array]'
    }
  var isFunction = function (val) {
    return toString.call(val) === '[object Function]'
  }
  var indexOf = Array.prototype.indexOf
    ? function (arr, item) {
        return arr.indexOf(item)
      }
    : function (arr, item) {
        for (var i = 0, len = arr.length; i < len; i++) {
          if (arr[i] === item) {
            return i
          }
        }
        return -1
      }
  return module.exports
}.call(this)
var Aspect = function (require, exports) {
  var exports = {}
  exports.before = function (methodName, callback, context) {
    return weave.call(this, 'before', methodName, callback, context)
  }
  exports.after = function (methodName, callback, context) {
    return weave.call(this, 'after', methodName, callback, context)
  }
  var eventSplitter = /\s+/
  function weave(when, methodName, callback, context) {
    var names = methodName.split(eventSplitter)
    var name, method
    while ((name = names.shift())) {
      method = getMethod(this, name)
      if (!method.__isAspected) {
        wrap.call(this, name)
      }
      this.on(when + ':' + name, callback, context)
    }
    return this
  }
  function getMethod(host, methodName) {
    var method = host[methodName]
    if (!method) {
      throw new Error('Invalid method name: ' + methodName)
    }
    return method
  }
  function wrap(methodName) {
    var old = this[methodName]
    this[methodName] = function () {
      var args = Array.prototype.slice.call(arguments)
      var beforeArgs = ['before:' + methodName].concat(args)
      if (this.trigger.apply(this, beforeArgs) === false) return
      var ret = old.apply(this, arguments)
      var afterArgs = ['after:' + methodName, ret].concat(args)
      this.trigger.apply(this, afterArgs)
      return ret
    }
    this[methodName].__isAspected = true
  }
  return exports
}.call(this)
var Attribute = function (require, exports) {
  var exports = {}
  exports.initAttrs = function (config) {
    var attrs = (this.attrs = {})
    var specialProps = this.propsInAttrs || []
    mergeInheritedAttrs(attrs, this, specialProps)
    if (config) {
      mergeUserValue(attrs, config)
    }
    setSetterAttrs(this, attrs, config)
    parseEventsFromAttrs(this, attrs)
    copySpecialProps(specialProps, this, attrs, true)
  }
  exports.get = function (key) {
    var attr = this.attrs[key] || {}
    var val = attr.value
    return attr.getter ? attr.getter.call(this, val, key) : val
  }
  exports.set = function (key, val, options) {
    var attrs = {}
    if (isString(key)) {
      attrs[key] = val
    } else {
      attrs = key
      options = val
    }
    options || (options = {})
    var silent = options.silent
    var override = options.override
    var now = this.attrs
    var changed = this.__changedAttrs || (this.__changedAttrs = {})
    for (key in attrs) {
      if (!attrs.hasOwnProperty(key)) continue
      var attr = now[key] || (now[key] = {})
      val = attrs[key]
      if (attr.readOnly) {
        throw new Error('This attribute is readOnly: ' + key)
      }
      if (attr.setter) {
        val = attr.setter.call(this, val, key)
      }
      var prev = this.get(key)
      if (!override && isPlainObject(prev) && isPlainObject(val)) {
        val = merge(merge({}, prev), val)
      }
      now[key].value = val
      if (!this.__initializingAttrs && !isEqual(prev, val)) {
        if (silent) {
          changed[key] = [val, prev]
        } else {
          this.trigger('change:' + key, val, prev, key)
        }
      }
    }
    return this
  }
  exports.change = function () {
    var changed = this.__changedAttrs
    if (changed) {
      for (var key in changed) {
        if (changed.hasOwnProperty(key)) {
          var args = changed[key]
          this.trigger('change:' + key, args[0], args[1], key)
        }
      }
      delete this.__changedAttrs
    }
    return this
  }
  exports._isPlainObject = isPlainObject
  var toString = Object.prototype.toString
  var hasOwn = Object.prototype.hasOwnProperty
  var iteratesOwnLast
  ;(function () {
    var props = []
    function Ctor() {
      this.x = 1
    }
    Ctor.prototype = { valueOf: 1, y: 1 }
    for (var prop in new Ctor()) {
      props.push(prop)
    }
    iteratesOwnLast = props[0] !== 'x'
  })()
  var isArray =
    Array.isArray ||
    function (val) {
      return toString.call(val) === '[object Array]'
    }
  function isString(val) {
    return toString.call(val) === '[object String]'
  }
  function isFunction(val) {
    return toString.call(val) === '[object Function]'
  }
  function isWindow(o) {
    return o != null && o == o.window
  }
  function isPlainObject(o) {
    if (!o || toString.call(o) !== '[object Object]' || o.nodeType || isWindow(o)) {
      return false
    }
    try {
      if (o.constructor && !hasOwn.call(o, 'constructor') && !hasOwn.call(o.constructor.prototype, 'isPrototypeOf')) {
        return false
      }
    } catch (e) {
      return false
    }
    var key
    if (iteratesOwnLast) {
      for (key in o) {
        return hasOwn.call(o, key)
      }
    }
    for (key in o) {
    }
    return key === undefined || hasOwn.call(o, key)
  }
  function isEmptyObject(o) {
    if (!o || toString.call(o) !== '[object Object]' || o.nodeType || isWindow(o) || !o.hasOwnProperty) {
      return false
    }
    for (var p in o) {
      if (o.hasOwnProperty(p)) return false
    }
    return true
  }
  function merge(receiver, supplier) {
    var key, value
    for (key in supplier) {
      if (supplier.hasOwnProperty(key)) {
        value = supplier[key]
        if (isArray(value)) {
          value = value.slice()
        } else if (isPlainObject(value)) {
          var prev = receiver[key]
          isPlainObject(prev) || (prev = {})
          value = merge(prev, value)
        }
        receiver[key] = value
      }
    }
    return receiver
  }
  var keys = Object.keys
  if (!keys) {
    keys = function (o) {
      var result = []
      for (var name in o) {
        if (o.hasOwnProperty(name)) {
          result.push(name)
        }
      }
      return result
    }
  }
  function mergeInheritedAttrs(attrs, instance, specialProps) {
    var inherited = []
    var proto = instance.constructor.prototype
    while (proto) {
      if (!proto.hasOwnProperty('attrs')) {
        proto.attrs = {}
      }
      copySpecialProps(specialProps, proto.attrs, proto)
      if (!isEmptyObject(proto.attrs)) {
        inherited.unshift(proto.attrs)
      }
      proto = proto.constructor.superclass
    }
    for (var i = 0, len = inherited.length; i < len; i++) {
      merge(attrs, normalize(inherited[i]))
    }
  }
  function mergeUserValue(attrs, config) {
    merge(attrs, normalize(config, true))
  }
  function copySpecialProps(specialProps, receiver, supplier, isAttr2Prop) {
    for (var i = 0, len = specialProps.length; i < len; i++) {
      var key = specialProps[i]
      if (supplier.hasOwnProperty(key)) {
        receiver[key] = isAttr2Prop ? receiver.get(key) : supplier[key]
      }
    }
  }
  var EVENT_PATTERN = /^(on|before|after)([A-Z].*)$/
  var EVENT_NAME_PATTERN = /^(Change)?([A-Z])(.*)/
  function parseEventsFromAttrs(host, attrs) {
    for (var key in attrs) {
      if (attrs.hasOwnProperty(key)) {
        var value = attrs[key].value,
          m
        if (isFunction(value) && (m = key.match(EVENT_PATTERN))) {
          host[m[1]](getEventName(m[2]), value)
          delete attrs[key]
        }
      }
    }
  }
  function getEventName(name) {
    var m = name.match(EVENT_NAME_PATTERN)
    var ret = m[1] ? 'change:' : ''
    ret += m[2].toLowerCase() + m[3]
    return ret
  }
  function setSetterAttrs(host, attrs, config) {
    var options = { silent: true }
    host.__initializingAttrs = true
    for (var key in config) {
      if (config.hasOwnProperty(key)) {
        if (attrs[key].setter) {
          host.set(key, config[key], options)
        }
      }
    }
    delete host.__initializingAttrs
  }
  var ATTR_SPECIAL_KEYS = ['value', 'getter', 'setter', 'readOnly']
  function normalize(attrs, isUserValue) {
    var newAttrs = {}
    for (var key in attrs) {
      var attr = attrs[key]
      if (!isUserValue && isPlainObject(attr) && hasOwnProperties(attr, ATTR_SPECIAL_KEYS)) {
        newAttrs[key] = attr
        continue
      }
      newAttrs[key] = { value: attr }
    }
    return newAttrs
  }
  function hasOwnProperties(object, properties) {
    for (var i = 0, len = properties.length; i < len; i++) {
      if (object.hasOwnProperty(properties[i])) {
        return true
      }
    }
    return false
  }
  function isEmptyAttrValue(o) {
    return o == null || ((isString(o) || isArray(o)) && o.length === 0) || isEmptyObject(o)
  }
  function isEqual(a, b) {
    if (a === b) return true
    if (isEmptyAttrValue(a) && isEmptyAttrValue(b)) return true
    var className = toString.call(a)
    if (className != toString.call(b)) return false
    switch (className) {
      case '[object String]':
        return a == String(b)
      case '[object Number]':
        return a != +a ? b != +b : a == 0 ? 1 / a == 1 / b : a == +b
      case '[object Date]':
      case '[object Boolean]':
        return +a == +b
      case '[object RegExp]':
        return (
          a.source == b.source && a.global == b.global && a.multiline == b.multiline && a.ignoreCase == b.ignoreCase
        )
      case '[object Array]':
        var aString = a.toString()
        var bString = b.toString()
        return aString.indexOf('[object') === -1 && bString.indexOf('[object') === -1 && aString === bString
    }
    if (typeof a != 'object' || typeof b != 'object') return false
    if (isPlainObject(a) && isPlainObject(b)) {
      if (!isEqual(keys(a), keys(b))) {
        return false
      }
      for (var p in a) {
        if (a[p] !== b[p]) return false
      }
      return true
    }
    return false
  }
  return exports
}.call(this)
var Base = function (require, exports, module) {
  var module = {}
  module.exports = Class.create({
    Implements: [Events, Aspect, Attribute],
    initialize: function (config) {
      this.initAttrs(config)
      parseEventsFromInstance(this, this.attrs)
    },
    destroy: function () {
      this.off()
      for (var p in this) {
        if (this.hasOwnProperty(p)) {
          delete this[p]
        }
      }
      this.destroy = function () {}
    },
  })
  function parseEventsFromInstance(host, attrs) {
    for (var attr in attrs) {
      if (attrs.hasOwnProperty(attr)) {
        var m = '_onChange' + ucfirst(attr)
        if (host[m]) {
          host.on('change:' + attr, host[m])
        }
      }
    }
  }
  function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.substring(1)
  }
  return module.exports
}.call(this)
;(function () {
  var CountDown = Base.extend({
    initialize: function (options) {
      CountDown.superclass.initialize.apply(this, arguments)
      this.options = options || {}
    },
    _timeleft: function () {
      if (this.get('timeLeft') !== null) {
        return this.get('timeLeft')
      }
      if (this.options.timeLeft) {
        return this.options.timeLeft
      }
      return (this.options.endDatetime.getTime() - new Date().getTime()) / 1000
    },
    _run: function () {
      var time_left = this._timeleft()
      var d, h, m
      var days = this.options.daysNode
      var hours = this.options.hoursNode
      var minutes = this.options.minutesNode
      var seconds = this.options.secondsNode
      if (time_left <= 0) {
        this.end()
        days.html(this._fixNumber(0))
        hours.html(this._fixNumber(0))
        minutes.html(this._fixNumber(0))
        seconds.html(this._fixNumber(0))
        return
      }
      d = Math.floor(time_left / 86400)
      time_left -= d * 86400
      h = Math.floor(time_left / 3600)
      time_left -= h * 3600
      m = Math.floor(time_left / 60)
      time_left -= m * 60
      days.html(this._fixNumber(d))
      hours.html(this._fixNumber(h))
      minutes.html(this._fixNumber(m))
      seconds.html(this._fixNumber(Math.floor(time_left)))
      this.set('timeLeft', this._timeleft() - 1)
    },
    _start: function () {
      var run = (function (context) {
        return function () {
          context._run.apply(context)
        }
      })(this)
      var time_loop = setInterval(run, 1000)
      this.set('time_loop', time_loop)
    },
    _pause: function () {
      clearInterval(this.get('time_loop'))
    },
    _resume: function () {
      this._start()
    },
    _stop: function () {
      clearInterval(this.get('time_loop'))
      this.set('timeLeft', null)
    },
    _fixNumber: function (number) {
      number = number.toString()
      if (number.length === 1) {
        return '0' + number
      }
      return number
    },
    start: function () {
      this._start()
      this.trigger('start')
    },
    pause: function () {
      this._pause()
      this.trigger('pause')
    },
    stop: function () {
      this._stop()
      this.trigger('stop')
    },
    resume: function () {
      this._resume()
      this.trigger('resume')
    },
    restart: function () {
      this._stop()
      this._start()
      this.trigger('restart')
    },
    end: function () {
      this._stop()
      this.trigger('end')
    },
  })
  this.CountDown = CountDown
}.call(this))
$(document).ready(function () {
  $('.m-carousel').carousel()
  $('.m-accordion').accordion()
  var isShowSearch = false
  var oldScrollSearch = 0
  var newScollSearch = 0
  setTimeout(function () {
    oldScrollSearch = $(window).scrollTop()
  }, 100)
  $(window).scroll(function () {
    newScrollSearch = $(window).scrollTop()
    if (newScrollSearch < oldScrollSearch) {
      isShowSearch = true
    } else {
      isShowSearch = false
    }
    oldScrollSearch = newScrollSearch
    if (isShowSearch) {
      if (newScrollSearch < 37) {
        $('.search').removeClass('sticky')
      } else {
        $('.search').addClass('sticky')
      }
    } else {
      $('.search').removeClass('sticky')
    }
  })
  if (typeof ispriceajax !== 'undefined' && ispriceajax == 1 && $('.loadprice').length > 0) {
    var str20first = ''
    var str30next = ''
    var str50last = ''
    $('.loadprice').each(function (ix) {
      if (ix < 20) {
        if ($(this).attr('rel')) {
          if (str20first != '') str20first += ',' + $(this).attr('rel')
          else str20first += $(this).attr('rel')
        }
      } else if (ix > 19 && ix < 50) {
        if ($(this).attr('rel')) {
          if (str30next != '') str30next += ',' + $(this).attr('rel')
          else str30next += $(this).attr('rel')
        }
      } else if (ix > 49) {
        if ($(this).attr('rel')) {
          if (str50last != '') str50last += ',' + $(this).attr('rel')
          else str50last += $(this).attr('rel')
        }
      }
    })
    if (str20first != '') {
      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: { id: str20first },
        url: rooturl + 'site/price',
        error: function () {},
        success: function (datajs) {
          if (datajs && datajs.data) {
            $.each(datajs.data, function (i) {
              var objassign = $('.lp' + datajs.data[i].id)
              if (objassign.find('.pricenew').length > 0) {
                objassign.find('.pricenew').html(datajs.data[i].discount + ' đ')
                var percent = Math.floor(
                  ((parseFloat(datajs.data[i].discount) - parseFloat(datajs.data[i].sell)) * 100) /
                    parseFloat(datajs.data[i].sell)
                )
                if (percent > 0 && percent < 100) {
                  objassign.find('span.persale').html(percent + '%')
                }
              }
              if (objassign.find('.priceold').length > 0) {
                objassign.find('.priceold').html(datajs.data[i].sell + ' đ')
              } else if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('div.priceold').length == 0) {
                objassign.find('div.pricenew').before('<div class="priceold">' + datajs.data[i].sell + ' đ</div>')
                var percent = Math.floor(
                  ((parseFloat(datajs.data[i].discount) - parseFloat(datajs.data[i].sell)) * 100) /
                    parseFloat(datajs.data[i].sell)
                )
                if (percent > 0 && percent < 100) {
                  objassign.find('span.persale').html(percent + '%')
                }
              }
            })
            if (str30next != '') {
              $.ajax({
                type: 'POST',
                dataType: 'json',
                data: { id: str30next },
                url: rooturl + 'site/price',
                error: function () {},
                success: function (datajs) {
                  if (datajs && datajs.data) {
                    $.each(datajs.data, function (i) {
                      var objassign = $('.lp' + datajs.data[i].id)
                      if (objassign.find('.pricenew').length > 0) {
                        objassign.find('.pricenew').html(datajs.data[i].discount + ' đ')
                        var percent = Math.floor(
                          ((parseFloat(datajs.data[i].discount) - parseFloat(datajs.data[i].sell)) * 100) /
                            parseFloat(datajs.data[i].sell)
                        )
                        if (percent > 0 && percent < 100) {
                          objassign.find('span.persale').html(percent + '%')
                        }
                      }
                      if (objassign.find('.priceold').length > 0) {
                        objassign.find('.priceold').html(datajs.data[i].sell + ' đ')
                      } else if (
                        parseInt(datajs.data[i].isdiscount) == 1 &&
                        objassign.find('div.priceold').length == 0
                      ) {
                        objassign
                          .find('div.pricenew')
                          .before('<div class="priceold">' + datajs.data[i].sell + ' đ</div>')
                        var percent = Math.floor(
                          ((parseFloat(datajs.data[i].discount) - parseFloat(datajs.data[i].sell)) * 100) /
                            parseFloat(datajs.data[i].sell)
                        )
                        if (percent > 0 && percent < 100) objassign.find('span.persale').html(percent + '%')
                      }
                    })
                    if (str50last != '') {
                      $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: { id: str50last },
                        url: rooturl + 'site/price',
                        error: function () {},
                        success: function (datajs) {
                          if (datajs && datajs.data) {
                            $.each(datajs.data, function (i) {
                              var objassign = $('.lp' + datajs.data[i].id)
                              if (objassign.find('.pricenew').length > 0) {
                                objassign.find('.pricenew').html(datajs.data[i].discount + ' đ')
                                var percent = Math.floor(
                                  ((parseFloat(datajs.data[i].discount) - parseFloat(datajs.data[i].sell)) * 100) /
                                    parseFloat(datajs.data[i].sell)
                                )
                                if (percent > 0 && percent < 100) {
                                  objassign.find('span.persale').html(percent + '%')
                                }
                              }
                              if (objassign.find('.priceold').length > 0) {
                                objassign.find('.priceold').html(datajs.data[i].sell + ' đ')
                              } else if (
                                parseInt(datajs.data[i].isdiscount) == 1 &&
                                objassign.find('div.priceold').length == 0
                              ) {
                                objassign
                                  .find('div.pricenew')
                                  .before('<div class="priceold">' + datajs.data[i].sell + ' đ</div>')
                                var percent = Math.floor(
                                  ((parseFloat(datajs.data[i].discount) - parseFloat(datajs.data[i].sell)) * 100) /
                                    parseFloat(datajs.data[i].sell)
                                )
                                if (percent > 0 && percent < 100) objassign.find('span.persale').html(percent + '%')
                              }
                            })
                          }
                        },
                      })
                    }
                  }
                },
              })
            }
          }
        },
      })
    }
  }
  if ($('#loadpromotionlist').length > 0 && pid) {
    $.post(
      rooturl + 'product/loadpromotionajax',
      { pid: pid },
      function (data) {
        if (data && data.success == 1 && data.blockhtml) {
          $('#loadpromotionlist').css('display', 'block')
          $('#loadpromotionlist').html(data.blockhtml)
          $('.giftids').before('<div class="promolabel">Khuyến mãi:</div>')
          var firstpromoobj
          if ($('.activefirst').length > 0) firstpromoobj = $('.activefirst')
          else {
            firstpromoobj = $('.promotions').first()
            if (firstpromoobj.parent().css('display') == 'none') {
              $('.promotions').each(function () {
                if ($(this).parent().css('display') != 'none') {
                  firstpromoobj = $(this)
                  return
                }
              })
            }
          }
          if (firstpromoobj && $('.promotions').length == 1 && firstpromoobj.parent().css('display') == 'none') {
            $('.areapricegift .areagift').css('display', 'none')
          } else if ($('.promotions').length == 1 && !firstpromoobj) {
            $('.areapricegift .areagift').css('display', 'none')
            firstpromoobj = $('.promotions').first()
          }
          if (firstpromoobj && firstpromoobj.val() != '') {
            firstpromoobj.attr('checked', 'checked')
            processpromotion(firstpromoobj.val())
          }
        } else {
          if ($('.infogift_pre').length > 0) {
            $('.bar_pre_center').css('display', 'none')
            $('.giftpromo_pre').css('padding', '0px')
          }
        }
      },
      'json'
    )
  }
  $.ajax({
    type: 'POST',
    data: { url: $(location).attr('href') },
    url: rooturl + 'index/initxajax',
    dataType: 'xml',
    success: function (data) {
      if ($(data).find('logindata').length > 0) {
        $('#loginform').html($(data).find('logindata').text())
        $('#myregionlogin').bind('change', function () {
          $(this).parent().attr('action', $(location).attr('href'))
          $(this).parent().submit()
        })
      } else if ($(data).find('loginlink').length > 0) {
        $('#loginBanner').attr('action', rooturl + 'login/index/redirect/' + $(data).find('loginlink').text())
        $('#linklogin').attr('href', rooturl + 'thanh-vien/dang-ky/redirect/' + $(data).find('loginlink').text())
      }
      if ($(data).find('cartcontent').length > 0) {
        var numbercart = $(data).find('cartcontent').text()
        $('.cart-info-hd').html(numbercart)
        $('.numbercartnewfooter').html($('.cart-info-hd').find('.numbercartnew').text())
        $('.numbercartnewinfo').html($('.cart-info-hd').find('.numbercartnew').text().replace('(', '').replace(')', ''))
      }
      if ($(data).find('initfunction').length > 0) {
        if ($(data).find('initfunction').text() == 1) {
          initinternalbar()
        }
      }
    },
  })
  if ($('.cartquantity').length > 0) {
    $('.cartquantity')
      .unbind('change')
      .change(function () {
        $.post(rooturl + 'cart/updatecartmobile', $('#checkoutform').serialize(), function () {
          window.location.href = rooturl + 'cart/checkout'
        })
      })
  }
  if ($('.cartquantity2').length > 0) {
    $('.cartquantity2')
      .unbind('change')
      .change(function () {
        $.post(rooturl + 'cart/update', $('#checkoutform').serialize(), function () {
          window.location.href = rooturl + 'cart'
        })
      })
  }
  $('.notify-bar-button a')
    .unbind('click')
    .click(function () {
      $(this).parent().parent().hide()
    })
})
function processpromotion(r) {
  var ids = ''
  if ($('.giftids').length > 0) {
    $('.giftids').each(function () {
      ids += $(this).attr('id') + ','
    })
  }
  $.post(
    rooturl + 'product/promotionajax',
    { id: r, ids: ids },
    function (data) {
      if (data && data.block && data.id && data.urlbuynow) {
        $('.areapricegift .areaprice').html(data.block)
        if ($('.buyprepaid').length > 0) {
          if (data.prid) $('.buyprepaid').attr('id', data.prid)
          $('.buyprepaid').attr('rel', data.id)
        } else if ($('#buyonline').length > 0) $('#buyonline').attr('href', data.urlbuynow)
        else if ($('#buystore').length > 0) $('#buystore').attr('href', data.urlbuynow + '&s=1')
      }
    },
    'json'
  )
}
function loadReview(id, order) {
  $.ajax({
    type: 'post',
    dataType: 'html',
    url: '/site/productreview/indexajax',
    data: 'id=' + id + '&order=' + order,
    success: function (html) {
      $('#comment').html(html)
      var countcomment =
        parseInt($('.countcomment span b').html()) > 0 ? '(' + $('.countcomment span b').html() + ')' : ''
      if (countcomment != '' || countcomment != null) $('.totalcomm a span').html(countcomment)
      if ($('.commentnumber').length > 0) {
        $('.commentnumber').each(function () {
          $(this).find('span').html($('#productreviewtotal').val())
        })
      }
      $('.writepost').limit(1000, '#contentcounter')
      $('.writepostreply').limit(1000, '.countercontentdata')
    },
  })
}
function loadpageReview(id, order) {
  $.ajax({
    type: 'post',
    dataType: 'html',
    url: '/site/pagereview/indexajax',
    data: 'id=' + id + '&order=' + order,
    success: function (html) {
      $('#comments').html(html)
    },
  })
}
var page = 1
function loadmoreReview(id) {
  $('.viewallproducts a').append('<span class="loading-gif"></span>')
  page++
  $.ajax({
    type: 'post',
    dataType: 'html',
    url: '/site/productreview/loadmore',
    data: 'id=' + id + '&page=' + page,
    success: function (html) {
      if (html != '') {
        $('.infocoms > ul > li:last-child').after(html)
        $('.loading-gif').remove()
      } else {
        $('.viewallproducts').remove()
      }
    },
  })
}
function sendReview(id, parentid, check, reply) {
  $('.combtn a').append('<span class="loading-gif" style="position: absolute;top: 13px;left: -39px;"></span>')
  var parentobj = parent
  parent = parentid
  var name = $('#reviewfullname').val()
  var email = $('#reviewemail').val()
  var content = $('#reviewcontent').val()
  var pass = true
  var datastring = ''
  if (reply != 1) {
    if (name == '') {
      $('#reviewfullname').css('border', 'solid 1px red')
      $('#reviewfullname').attr('placeholder', 'Vui lòng nhập tên của bạn')
      pass = false
    } else {
      $('#reviewfullname').css('border', 'solid 1px ccc')
      $('#reviewfullname').attr('placeholder', 'Họ và tên')
    }
    if (email == '') {
      $('#reviewemail').css('border', 'solid 1px red')
      $('#reviewemail').attr('placeholder', 'Vui lòng nhập Email')
      pass = false
    } else {
      if (validate(email) == false) {
        $('#reviewemail').css('border', 'solid 1px red')
        $('#reviewemail').attr('placeholder', 'Email không hợp lệ')
        pass = false
      } else {
        $('#reviewemail').css('border', 'solid 1px ccc')
        $('#reviewemail').attr('placeholder', 'Email')
      }
    }
    if (content == '') {
      $('#reviewcontent').css('border', 'solid 1px red')
      $('#reviewcontent').attr('placeholder', 'Vui lòng nhập nội dung bình luận')
      pass = false
    } else {
      $('#reviewcontent').css('border', 'solid 1px ccc')
      $('#reviewcontent').attr('placeholder', 'Nội dung bình luận')
    }
  } else {
  }
  datastring = 'email=' + email + '&name=' + name + '&content=' + content + '&id=' + id + '&parent=' + parent
  if (pass) {
    $('.notifi').html('')
    $('.writepost').val('')
    $('#contentcounter').html('1000')
    $('.writepostreply').val('')
    $('.countercontentdata').html('1000')
    $.ajax({
      type: 'post',
      dataType: 'html',
      url: '/site/productreview/addajax',
      data: datastring,
      success: function (html) {
        $('.notifi').css('display', 'block')
        if (html == '3') {
          $('.notifi').append("<p class='error'>Email không hợp lệ</p>")
        }
        if (html == '4') {
          $('.notifi').append("<p class='error'>Vui lòng nhập nội dung bình luận</p>")
        }
        if (html == '5') {
          $('.notifi').append("<p class='error'>Vui lòng chọn sản phẩm để bình luận</p>")
        }
        if (html == '6') {
          $('#contentcounter').html('1000')
          $('.writepostreply').val('')
          $('.countercontentdata').html('1000')
          $('.notifi').append(
            "<p class='success'>Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn</p>"
          )
          var now = new Date()
          var month = parseInt(now.getMonth()) + 1
          var dateString =
            now.getHours() +
            ':' +
            now.getMinutes() +
            ' Ngày ' +
            now.getDate() +
            '/' +
            month +
            '/' +
            now.getFullYear() +
            ' '
          var html =
            '<li><div class="nameuser">' +
            name +
            '<span style="float:right;font-weight: normal;font-size:12px;"><i>' +
            dateString +
            '</i></span ></div><div class="contuser">' +
            content +
            '</div>'
          html +=
            '<div class="right"><div id="likeproductreview2545"><a href="javascript:void(0)">Thích</a> <span id="likecom2545">0</span></div>'
          html += '</div></li>'
          $('.infocoms > ul').prepend(html)
          if (parent > 0) {
            $('#reply' + parent).hide()
          }
          if (check == 0) {
            $('#reviewfullname').val('')
            $('#reviewemail').val('')
            $('#reviewcontent').val('')
          } else {
            if (check == 1) {
              $('#reviewcontent').val('')
            }
          }
        }
        if (html == '7') {
          $('.notifi').append("<p class='error'>Vui lòng chọn sản phẩm để bình luận</p>")
        }
        $('.loading-gif').remove()
      },
    })
  } else {
    $('.loading-gif').remove()
  }
}
function replyreview(url, objectid, parentreviewid, uid) {
  if (objectid > 0 && parentreviewid > 0) {
    url += 'site/productreview/reply/id/' + objectid + '/parentid/' + parentreviewid
    Shadowbox.open({ content: url, player: 'iframe', height: 175, width: 400 })
  }
}
function replyopen(id) {
  $('.dropdown_' + id).slideToggle(100)
}
function closereply(id) {
  $('#reply' + id).fadeOut(10)
}
function orderreview(pid) {
  var order = $('#forder').val()
  if (typeof order != 'undefined') {
    loadReview(pid, order)
  }
}
function likereview(objectid, reviewid) {
  if (objectid > 0 && reviewid > 0) {
    datastring = 'pid=' + objectid + '&rid=' + reviewid
    $.ajax({
      type: 'post',
      dataType: 'html',
      url: '/productreviewthumb/addajaxmobile',
      data: datastring,
      success: function (html) {
        if (html == 'done') {
          currentthumbup = parseInt($('#likecom' + reviewid).html())
          currentthumbup = currentthumbup + 1
          $('#likecom' + reviewid).html(currentthumbup)
          $('#likeproductreview' + reviewid + ' a').removeAttr('onclick')
          $('#likeproductreview' + reviewid + ' a').css('background', '#f1f1f1')
        }
      },
    })
  }
}
function likeproduct(objectid) {
  if (objectid > 0) {
    datastring = 'pid=' + objectid + '&rid=0'
    $.ajax({
      type: 'post',
      dataType: 'html',
      url: '/productreviewthumb/addajax',
      data: datastring,
      success: function (html) {
        if (html == 'done') {
          currentthumbup = parseInt($('#likeproduct').html())
          currentthumbup = currentthumbup + 1
          $('#likeproduct').html(currentthumbup)
        }
      },
    })
  }
}
function validate(email) {
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
  if (reg.test(email) == false) {
    return false
  }
}
function checkvalidate(obj) {
  if ($(obj).val().trim() != '') $(obj).css('border', '1px solid #ccc')
  else $(obj).css('border', 'solid 1px red')
}
$('.forcedesktop').click(function () {
  createCookie('forcedesktop', 1, 1)
  desktopurl = rooturl.substr(rooturl.indexOf('.') + 1)
  window.location.href = 'http://' + desktopurl
})
function createCookie(name, value, days) {
  if (days) {
    var date = new Date()
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000)
    var expires = '; expires=' + date.toGMTString()
  } else var expires = ''
  desktopurl = rooturl.substr(rooturl.indexOf('.') + 1).replace('/', '')
  document.cookie = name + '=' + value + expires + '; path=/;domain=' + desktopurl
}
function getCookie(c_name) {
  if (document.cookie.length > 0) {
    c_start = document.cookie.indexOf(c_name + '=')
    if (c_start != -1) {
      c_start = c_start + c_name.length + 1
      c_end = document.cookie.indexOf(';', c_start)
      if (c_end == -1) {
        c_end = document.cookie.length
      }
      return unescape(document.cookie.substring(c_start, c_end))
    }
  }
  return ''
}
function deleteCookie(c_name) {
  document.cookie = encodeURIComponent(c_name) + '=deleted; expires=' + new Date(0).toUTCString()
}
function eventclick(type, category, action, label, value) {
  ga('send', { hitType: type, eventCategory: category, eventAction: action, eventLabel: label, eventValue: value })
}
/* mobify-carousel 0.2.2 2013-06-17 */
var Mobify = (window.Mobify = window.Mobify || {})
;(Mobify.$ = Mobify.$ || window.Zepto || window.jQuery),
  (Mobify.UI = Mobify.UI ? Mobify.$.extend(Mobify.UI, { classPrefix: 'm-' }) : { classPrefix: 'm-' }),
  (function (t, e) {
    ;(t.support = t.support || {}), t.extend(t.support, { touch: 'ontouchend' in e })
  })(Mobify.$, document),
  (Mobify.UI.Utils = (function (t) {
    var e = {},
      i = t.support,
      n = navigator.userAgent
    ;(e.events = i.touch
      ? { down: 'touchstart', move: 'touchmove', up: 'touchend' }
      : { down: 'mousedown', move: 'mousemove', up: 'mouseup' }),
      (e.getCursorPosition = i.touch
        ? function (t) {
            return (t = t.originalEvent || t), { x: t.touches[0].clientX, y: t.touches[0].clientY }
          }
        : function (t) {
            return { x: t.clientX, y: t.clientY }
          }),
      (e.getProperty = function (t) {
        for (
          var e = ['Webkit', 'Moz', 'O', 'ms', ''], i = document.createElement('div').style, n = 0;
          e.length > n;
          ++n
        )
          if (void 0 !== i[e[n] + t]) return e[n] + t
      }),
      t.extend(i, {
        transform: !!e.getProperty('Transform'),
        transform3d: !(!(window.WebKitCSSMatrix && 'm11' in new WebKitCSSMatrix()) || /android\s+[1-2]/i.test(n)),
      })
    var s = e.getProperty('Transform')
    e.translateX = i.transform3d
      ? function (t, e) {
          'number' == typeof e && (e += 'px'), (t.style[s] = 'translate3d(' + e + ',0,0)')
        }
      : i.transform
      ? function (t, e) {
          'number' == typeof e && (e += 'px'), (t.style[s] = 'translate(' + e + ',0)')
        }
      : function (t, e) {
          'number' == typeof e && (e += 'px'), (t.style.left = e)
        }
    var o = (e.getProperty('Transition'), e.getProperty('TransitionDuration'))
    return (
      (e.setTransitions = function (t, e) {
        t.style[o] = e ? '' : '0s'
      }),
      (e.requestAnimationFrame = (function () {
        var t =
            window.requestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            window.msRequestAnimationFrame ||
            function (t) {
              window.setTimeout(t, 1e3 / 60)
            },
          e = function () {
            t.apply(window, arguments)
          }
        return e
      })()),
      e
    )
  })(Mobify.$)),
  (Mobify.UI.Carousel = (function (t, e) {
    var i = {
        dragRadius: 10,
        moveRadius: 20,
        classPrefix: void 0,
        classNames: {
          outer: 'carousel',
          inner: 'carousel-inner',
          item: 'item',
          center: 'center',
          touch: 'has-touch',
          dragging: 'dragging',
          active: 'active',
          fluid: 'fluid',
        },
      },
      n = t.support,
      s = function (t, e) {
        this.setOptions(e), this.initElements(t), this.initOffsets(), this.initAnimation(), this.bind()
      }
    return (
      (s.defaults = i),
      (s.prototype.setOptions = function (e) {
        var n = this.options || t.extend({}, i, e)
        ;(n.classNames = t.extend({}, n.classNames, e.classNames || {})),
          (n.classPrefix = n.classPrefix || Mobify.UI.classPrefix),
          (this.options = n)
      }),
      (s.prototype.initElements = function (e) {
        ;(this._index = 1),
          (this.element = e),
          (this.$element = t(e)),
          (this.$inner = this.$element.find('.' + this._getClass('inner'))),
          (this.$items = this.$inner.children()),
          (this.$start = this.$items.eq(0)),
          (this.$sec = this.$items.eq(1)),
          (this.$current = this.$items.eq(this._index - 1)),
          (this._length = this.$items.length),
          (this._alignment = this.$element.hasClass(this._getClass('center')) ? 0.5 : 0),
          (this._isFluid = this.$element.hasClass(this._getClass('fluid')))
      }),
      (s.prototype.initOffsets = function () {
        this._offsetDrag = 0
      }),
      (s.prototype.initAnimation = function () {
        ;(this.animating = !1), (this.dragging = !1), (this._needsUpdate = !1), this._enableAnimation()
      }),
      (s.prototype._getClass = function (t) {
        return this.options.classPrefix + this.options.classNames[t]
      }),
      (s.prototype._enableAnimation = function () {
        this.animating ||
          (e.setTransitions(this.$inner[0], !0),
          this.$inner.removeClass(this._getClass('dragging')),
          (this.animating = !0))
      }),
      (s.prototype._disableAnimation = function () {
        this.animating &&
          (e.setTransitions(this.$inner[0], !1),
          this.$inner.addClass(this._getClass('dragging')),
          (this.animating = !1))
      }),
      (s.prototype.update = function () {
        if (!this._needsUpdate) {
          var t = this
          ;(this._needsUpdate = !0),
            e.requestAnimationFrame(function () {
              t._update()
            })
        }
      }),
      (s.prototype._update = function () {
        if (this._needsUpdate) {
          var t = this.$current,
            i = this.$start,
            n = t.prop('offsetLeft') + t.prop('clientWidth') * this._alignment,
            s = i.prop('offsetLeft') + i.prop('clientWidth') * this._alignment,
            o = Math.round(-(n - s) + this._offsetDrag)
          e.translateX(this.$inner[0], o), (this._needsUpdate = !1)
        }
      }),
      (s.prototype.bind = function () {
        function i(t) {
          n.touch || t.preventDefault(),
            (d = !0),
            (c = !1),
            (a = e.getCursorPosition(t)),
            (u = 0),
            (l = 0),
            (h = !1),
            p._disableAnimation(),
            ($ = 1 == p._index),
            (_ = p._index == p._length)
        }
        function s(t) {
          if (d && !c) {
            var i = e.getCursorPosition(t),
              n = p.$element.width()
            ;(u = a.x - i.x),
              (l = a.y - i.y),
              h || (f(u) > f(l) && f(u) > m)
                ? ((h = !0),
                  t.preventDefault(),
                  $ && 0 > u ? (u = (u * -n) / (u - n)) : _ && u > 0 && (u = (u * n) / (u + n)),
                  (p._offsetDrag = -u),
                  p.update())
                : f(l) > f(u) && f(l) > m && (c = !0)
          }
        }
        function o() {
          d &&
            ((d = !1),
            p._enableAnimation(),
            !c && f(u) > v.moveRadius ? (u > 0 ? p.next() : p.prev()) : ((p._offsetDrag = 0), p.update()))
        }
        function r(t) {
          h && t.preventDefault()
        }
        var a,
          u,
          l,
          h,
          f = Math.abs,
          d = !1,
          c = !1,
          m = this.options.dragRadius,
          p = this,
          g = this.$element,
          y = this.$inner,
          v = this.options,
          $ = !1,
          _ = !1,
          w = t(window).width()
        y
          .on(e.events.down + '.carousel', i)
          .on(e.events.move + '.carousel', s)
          .on(e.events.up + '.carousel', o)
          .on('click.carousel', r)
          .on('mouseout.carousel', o),
          g.on('click', '[data-slide]', function (e) {
            e.preventDefault()
            var i = t(this).attr('data-slide'),
              n = parseInt(i, 10)
            isNaN(n) ? p[i]() : p.move(n)
          }),
          g.on('afterSlide', function (t, e, i) {
            p.$items.eq(e - 1).removeClass(p._getClass('active')),
              p.$items.eq(i - 1).addClass(p._getClass('active')),
              p.$element.find("[data-slide='" + e + "']").removeClass(p._getClass('active')),
              p.$element.find("[data-slide='" + i + "']").addClass(p._getClass('active'))
          }),
          t(window).on('resize orientationchange', function () {
            w != t(window).width() && (p._disableAnimation(), (w = t(window).width()), p.update())
          }),
          g.trigger('beforeSlide', [1, 1]),
          g.trigger('afterSlide', [1, 1]),
          p.update()
      }),
      (s.prototype.unbind = function () {
        this.$inner.off()
      }),
      (s.prototype.destroy = function () {
        this.unbind(),
          this.$element.trigger('destroy'),
          this.$element.remove(),
          (this.$element = null),
          (this.$inner = null),
          (this.$start = null),
          (this.$current = null)
      }),
      (s.prototype.move = function (t, e) {
        var i = this.$element,
          n = (this.$inner, this.$items),
          s = (this.$start, this.$current),
          o = this._length,
          r = this._index
        ;(e = e || {}),
          1 > t ? (t = 1) : t > this._length && (t = o),
          t == this._index,
          this._enableAnimation(),
          i.trigger('beforeSlide', [r, t]),
          (this.$current = s = n.eq(t - 1)),
          (this._offsetDrag = 0),
          (this._index = t),
          this.update(),
          i.trigger('afterSlide', [r, t])
      }),
      (s.prototype.next = function () {
        this.move(this._index + 1)
      }),
      (s.prototype.prev = function () {
        this.move(this._index - 1)
      }),
      s
    )
  })(Mobify.$, Mobify.UI.Utils)),
  (function (t) {
    ;(t.fn.carousel = function (e, i) {
      var n = t.extend({}, t.fn.carousel.defaults)
      return (
        'object' == typeof e && ((n = t(n, e)), (i = null), (e = null)),
        this.each(function () {
          var s = (t(this), this._carousel)
          s || (s = new Mobify.UI.Carousel(this, n)),
            e && (s[e](i), 'destroy' === e && (s = null)),
            (this._carousel = s)
        }),
        this
      )
    }),
      (t.fn.carousel.defaults = {})
  })(Mobify.$)
!(function ($) {
  $.fn.slideDown = function (duration) {
    var position = this.css('position')
    this.show()
    this.css({ position: 'absolute', visibility: 'hidden' })
    var marginTop = this.css('margin-top')
    var marginBottom = this.css('margin-bottom')
    var paddingTop = this.css('padding-top')
    var paddingBottom = this.css('padding-bottom')
    var height = this.css('height')
    this.css({
      position: position,
      visibility: 'visible',
      overflow: 'hidden',
      height: 0,
      marginTop: 0,
      marginBottom: 0,
      paddingTop: 0,
      paddingBottom: 0,
    })
    this.animate(
      {
        height: height,
        marginTop: marginTop,
        marginBottom: marginBottom,
        paddingTop: paddingTop,
        paddingBottom: paddingBottom,
      },
      duration
    )
  }
  $.fn.slideUp = function (duration) {
    if (this.height() > 0) {
      var target = this
      var position = target.css('position')
      var height = target.css('height')
      var marginTop = target.css('margin-top')
      var marginBottom = target.css('margin-bottom')
      var paddingTop = target.css('padding-top')
      var paddingBottom = target.css('padding-bottom')
      this.css({
        visibility: 'visible',
        overflow: 'hidden',
        height: height,
        marginTop: marginTop,
        marginBottom: marginBottom,
        paddingTop: paddingTop,
        paddingBottom: paddingBottom,
      })
      target.animate(
        { height: 0, marginTop: 0, marginBottom: 0, paddingTop: 0, paddingBottom: 0 },
        {
          duration: duration,
          queue: false,
          complete: function () {
            target.hide()
            target.css({
              visibility: 'visible',
              overflow: 'hidden',
              height: height,
              marginTop: marginTop,
              marginBottom: marginBottom,
              paddingTop: paddingTop,
              paddingBottom: paddingBottom,
            })
          },
        }
      )
    }
  }
  $.fn.slideToggle = function (duration) {
    if (this.height() == 0) {
      this.slideDown(duration)
    } else {
      this.slideUp(duration)
    }
  }
})(Zepto)
;(window.Modernizr = (function (a, b, c) {
  function A(a, b) {
    var c = a.charAt(0).toUpperCase() + a.substr(1),
      d = (a + ' ' + n.join(c + ' ') + c).split(' ')
    return z(d, b)
  }
  function z(a, b) {
    for (var d in a) if (k[a[d]] !== c) return b == 'pfx' ? a[d] : !0
    return !1
  }
  function y(a, b) {
    return !!~('' + a).indexOf(b)
  }
  function x(a, b) {
    return typeof a === b
  }
  function w(a, b) {
    return v(prefixes.join(a + ';') + (b || ''))
  }
  function v(a) {
    k.cssText = a
  }
  var d = '2.0.6',
    e = {},
    f = !0,
    g = b.documentElement,
    h = b.head || b.getElementsByTagName('head')[0],
    i = 'modernizr',
    j = b.createElement(i),
    k = j.style,
    l,
    m = Object.prototype.toString,
    n = 'Webkit Moz O ms Khtml'.split(' '),
    o = {},
    p = {},
    q = {},
    r = [],
    s,
    t = {}.hasOwnProperty,
    u
  !x(t, c) && !x(t.call, c)
    ? (u = function (a, b) {
        return t.call(a, b)
      })
    : (u = function (a, b) {
        return b in a && x(a.constructor.prototype[b], c)
      }),
    (o.cssanimations = function () {
      return A('animationName')
    })
  for (var B in o) u(o, B) && ((s = B.toLowerCase()), (e[s] = o[B]()), r.push((e[s] ? '' : 'no-') + s))
  v(''),
    (j = l = null),
    a.attachEvent &&
      (function () {
        var a = b.createElement('div')
        a.innerHTML = '<elem></elem>'
        return a.childNodes.length !== 1
      })() &&
      (function (a, b) {
        function s(a) {
          var b = -1
          while (++b < g) a.createElement(f[b])
        }
        a.iepp = a.iepp || {}
        var d = a.iepp,
          e =
            d.html5elements ||
            'abbr|article|aside|audio|canvas|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video',
          f = e.split('|'),
          g = f.length,
          h = new RegExp('(^|\\s)(' + e + ')', 'gi'),
          i = new RegExp('<(/*)(' + e + ')', 'gi'),
          j = /^\s*[\{\}]\s*$/,
          k = new RegExp('(^|[^\\n]*?\\s)(' + e + ')([^\\n]*)({[\\n\\w\\W]*?})', 'gi'),
          l = b.createDocumentFragment(),
          m = b.documentElement,
          n = m.firstChild,
          o = b.createElement('body'),
          p = b.createElement('style'),
          q = /print|all/,
          r
        ;(d.getCSS = function (a, b) {
          if (a + '' === c) return ''
          var e = -1,
            f = a.length,
            g,
            h = []
          while (++e < f) {
            g = a[e]
            if (g.disabled) continue
            ;(b = g.media || b), q.test(b) && h.push(d.getCSS(g.imports, b), g.cssText), (b = 'all')
          }
          return h.join('')
        }),
          (d.parseCSS = function (a) {
            var b = [],
              c
            while ((c = k.exec(a)) != null)
              b.push(((j.exec(c[1]) ? '\n' : c[1]) + c[2] + c[3]).replace(h, '$1.iepp_$2') + c[4])
            return b.join('\n')
          }),
          (d.writeHTML = function () {
            var a = -1
            r = r || b.body
            while (++a < g) {
              var c = b.getElementsByTagName(f[a]),
                d = c.length,
                e = -1
              while (++e < d) c[e].className.indexOf('iepp_') < 0 && (c[e].className += ' iepp_' + f[a])
            }
            l.appendChild(r),
              m.appendChild(o),
              (o.className = r.className),
              (o.id = r.id),
              (o.innerHTML = r.innerHTML.replace(i, '<$1font'))
          }),
          (d._beforePrint = function () {
            ;(p.styleSheet.cssText = d.parseCSS(d.getCSS(b.styleSheets, 'all'))), d.writeHTML()
          }),
          (d.restoreHTML = function () {
            ;(o.innerHTML = ''), m.removeChild(o), m.appendChild(r)
          }),
          (d._afterPrint = function () {
            d.restoreHTML(), (p.styleSheet.cssText = '')
          }),
          s(b),
          s(l)
        d.disablePP ||
          (n.insertBefore(p, n.firstChild),
          (p.media = 'print'),
          (p.className = 'iepp-printshim'),
          a.attachEvent('onbeforeprint', d._beforePrint),
          a.attachEvent('onafterprint', d._afterPrint))
      })(a, b),
    (e._version = d),
    (e._domPrefixes = n),
    (e.testProp = function (a) {
      return z([a])
    }),
    (e.testAllProps = A),
    (g.className = g.className.replace(/\bno-js\b/, '') + (f ? ' js ' + r.join(' ') : ''))
  return e
})(this, this.document)),
  (function (a, b, c) {
    function k(a) {
      return !a || a == 'loaded' || a == 'complete'
    }
    function j() {
      var a = 1,
        b = -1
      while (p.length - ++b) if (p[b].s && !(a = p[b].r)) break
      a && g()
    }
    function i(a) {
      var c = b.createElement('script'),
        d
      ;(c.src = a.s),
        (c.onreadystatechange = c.onload = function () {
          !d && k(c.readyState) && ((d = 1), j(), (c.onload = c.onreadystatechange = null))
        }),
        m(function () {
          d || ((d = 1), j())
        }, H.errorTimeout),
        a.e ? c.onload() : n.parentNode.insertBefore(c, n)
    }
    function h(a) {
      var c = b.createElement('link'),
        d
      ;(c.href = a.s), (c.rel = 'stylesheet'), (c.type = 'text/css')
      if (!a.e && (w || r)) {
        var e = function (a) {
          m(function () {
            if (!d)
              try {
                a.sheet.cssRules.length ? ((d = 1), j()) : e(a)
              } catch (b) {
                b.code == 1e3 || b.message == 'security' || b.message == 'denied'
                  ? ((d = 1),
                    m(function () {
                      j()
                    }, 0))
                  : e(a)
              }
          }, 0)
        }
        e(c)
      } else
        (c.onload = function () {
          d ||
            ((d = 1),
            m(function () {
              j()
            }, 0))
        }),
          a.e && c.onload()
      m(function () {
        d || ((d = 1), j())
      }, H.errorTimeout),
        !a.e && n.parentNode.insertBefore(c, n)
    }
    function g() {
      var a = p.shift()
      ;(q = 1),
        a
          ? a.t
            ? m(function () {
                a.t == 'c' ? h(a) : i(a)
              }, 0)
            : (a(), j())
          : (q = 0)
    }
    function f(a, c, d, e, f, h) {
      function i() {
        !o &&
          k(l.readyState) &&
          ((r.r = o = 1),
          !q && j(),
          (l.onload = l.onreadystatechange = null),
          m(function () {
            u.removeChild(l)
          }, 0))
      }
      var l = b.createElement(a),
        o = 0,
        r = { t: d, s: c, e: h }
      ;(l.src = l.data = c),
        !s && (l.style.display = 'none'),
        (l.width = l.height = '0'),
        a != 'object' && (l.type = d),
        (l.onload = l.onreadystatechange = i),
        a == 'img'
          ? (l.onerror = i)
          : a == 'script' &&
            (l.onerror = function () {
              ;(r.e = r.r = 1), g()
            }),
        p.splice(e, 0, r),
        u.insertBefore(l, s ? null : n),
        m(function () {
          o || (u.removeChild(l), (r.r = r.e = o = 1), j())
        }, H.errorTimeout)
    }
    function e(a, b, c) {
      var d = b == 'c' ? z : y
      ;(q = 0), (b = b || 'j'), C(a) ? f(d, a, b, this.i++, l, c) : (p.splice(this.i++, 0, a), p.length == 1 && g())
      return this
    }
    function d() {
      var a = H
      a.loader = { load: e, i: 0 }
      return a
    }
    var l = b.documentElement,
      m = a.setTimeout,
      n = b.getElementsByTagName('script')[0],
      o = {}.toString,
      p = [],
      q = 0,
      r = 'MozAppearance' in l.style,
      s = r && !!b.createRange().compareNode,
      t = r && !s,
      u = s ? l : n.parentNode,
      v = a.opera && o.call(a.opera) == '[object Opera]',
      w = 'webkitAppearance' in l.style,
      x = w && 'async' in b.createElement('script'),
      y = r ? 'object' : v || x ? 'img' : 'script',
      z = w ? 'img' : y,
      A =
        Array.isArray ||
        function (a) {
          return o.call(a) == '[object Array]'
        },
      B = function (a) {
        return Object(a) === a
      },
      C = function (a) {
        return typeof a == 'string'
      },
      D = function (a) {
        return o.call(a) == '[object Function]'
      },
      E = [],
      F = {},
      G,
      H
    ;(H = function (a) {
      function f(a) {
        var b = a.split('!'),
          c = E.length,
          d = b.pop(),
          e = b.length,
          f = { url: d, origUrl: d, prefixes: b },
          g,
          h
        for (h = 0; h < e; h++) (g = F[b[h]]), g && (f = g(f))
        for (h = 0; h < c; h++) f = E[h](f)
        return f
      }
      function e(a, b, e, g, h) {
        var i = f(a),
          j = i.autoCallback
        if (!i.bypass) {
          b && (b = D(b) ? b : b[a] || b[g] || b[a.split('/').pop().split('?')[0]])
          if (i.instead) return i.instead(a, b, e, g, h)
          e.load(i.url, i.forceCSS || (!i.forceJS && /css$/.test(i.url)) ? 'c' : c, i.noexec),
            (D(b) || D(j)) &&
              e.load(function () {
                d(), b && b(i.origUrl, h, g), j && j(i.origUrl, h, g)
              })
        }
      }
      function b(a, b) {
        function c(a) {
          if (C(a)) e(a, h, b, 0, d)
          else if (B(a)) for (i in a) a.hasOwnProperty(i) && e(a[i], h, b, i, d)
        }
        var d = !!a.test,
          f = d ? a.yep : a.nope,
          g = a.load || a.both,
          h = a.callback,
          i
        c(f), c(g), a.complete && b.load(a.complete)
      }
      var g,
        h,
        i = this.yepnope.loader
      if (C(a)) e(a, 0, i, 0)
      else if (A(a)) for (g = 0; g < a.length; g++) (h = a[g]), C(h) ? e(h, 0, i, 0) : A(h) ? H(h) : B(h) && b(h, i)
      else B(a) && b(a, i)
    }),
      (H.addPrefix = function (a, b) {
        F[a] = b
      }),
      (H.addFilter = function (a) {
        E.push(a)
      }),
      (H.errorTimeout = 1e4),
      b.readyState == null &&
        b.addEventListener &&
        ((b.readyState = 'loading'),
        b.addEventListener(
          'DOMContentLoaded',
          (G = function () {
            b.removeEventListener('DOMContentLoaded', G, 0), (b.readyState = 'complete')
          }),
          0
        )),
      (a.yepnope = d())
  })(this, this.document),
  (Modernizr.load = function () {
    yepnope.apply(window, [].slice.call(arguments, 0))
  })
$(function () {
  $('.menu-icon').click(function () {
    $('.drop-down').stop(true, false).slideToggle('fast')
  })
  $('.menu').click(function () {
    $(this).next('.dropdown').slideToggle('fast')
    return false
  })
  $('.close').click(function () {
    $(this).parent('ul').parent('.dropdown').slideToggle('fast')
  })
  var featuredSwiper = $('.featured').swiper({
    slidesPerView: 'auto',
    centeredSlides: true,
    initialSlide: 7,
    tdFlow: { rotate: 30, stretch: 10, depth: 150 },
  })
  $('.thumbs-cotnainer').each(function () {
    $(this).swiper({ slidesPerView: 'auto', offsetPxBefore: 25, offsetPxAfter: 10, calculateHeight: true })
  })
  $('.banners-container').each(function () {
    $(this).swiper({ slidesPerView: 'auto', offsetPxBefore: 25, offsetPxAfter: 10 })
  })
  var currentQuestion = $('.p3question #answesitem').length
  if (currentQuestion > 0) {
    var page = 1
    var fpgid = $('#answesitem').attr('data-id')
    var url = rooturl + 'product/loadquestion'
    $('.guessloading').css('display', 'block')
    var data = { action: 'loadquestion', page: page, fpgid: fpgid }
    $.ajax({
      type: 'POST',
      data: data,
      url: url,
      dataType: 'html',
      success: function (data) {
        if (data != '') {
          $('.guessloading').css('display', 'none')
          $('#answesitem').html(data)
        }
      },
    })
  }
  var question = 2
  var arrayanswer = new Array()
  $('body').on('click', '#next', function () {
    var fpgid = $(this).attr('data-id')
    var totalquestion = $(this).attr('rel')
    var answer = $('.p3question input:checked').val()
    var answertext = $('#answertext').val()
    if (answer == 'true') {
      if (question <= totalquestion) {
        var url = rooturl + 'product/nextquestion'
        $('.guessloading').css('display', 'block')
        var data = { action: 'nextquestion', question: question, fpgid: fpgid, totalquestion: totalquestion }
        $.ajax({
          type: 'POST',
          data: data,
          url: url,
          dataType: 'html',
          success: function (data) {
            if (data != '') {
              $('.guessloading').css('display', 'none')
              question = question + 1
              $('#answesitem').html(data)
            }
          },
        })
        $('.p3alert').text('')
      } else {
        var htmlinfo =
          '<strong>Thông tin liên hệ</strong><span>Mời bạn để lại thông tin để nhận thông báo khi <i><a href="https://ecommerce.kubil.app/" target="_blank" style="text-decoration:none;color:#00a1e6"><b>dienmay</b>.com</a></i> công bố kết quả</span>'
        htmlinfo +=
          '<input id="ffullname" class="p3input2" name="ffullname" type="text" placeholder="Họ và tên bạn"><div class="clear"></div>'
        htmlinfo +=
          '<input maxlength="15" id="fphoneguess" class="p3input2" name="fphone" type="text" placeholder="Điện thoại của bạn"><div class="clear"></div>'
        htmlinfo +=
          '<input id="femail" class="p3input2" name="femail" type="text" placeholder="Email của bạn"><div class="clear"></div>'
        htmlinfo +=
          '<input id="faddress" class="p3input2" name="faddress" type="text" placeholder="Địa chỉ của bạn"><div class="clear"></div>'
        htmlinfo +=
          '<label class="p3check"><input id="fcheckproduct" class="check" name="fcheckproduct" type="checkbox" checked value="1">Nhận thông báo qua email và tin nhắn khi sản phẩm này được bán</label><div class="clear"></div>'
        htmlinfo +=
          '<label class="p3check"><input id="fcheckfull" class="check" name="fcheckfull" type="checkbox" checked value="1">Nhận thông báo qua email về các chương trình khuyến mãi khác của dienmay.com</label><div class="clear"></div>'
        htmlinfo +=
          '<div class="btn-step"><a data-id="' +
          fpgid +
          '" rel="' +
          answertext +
          '" id="confirm_info" href="javascript:;">Hoàn tất</a></div>'
        htmlinfo += '<label class="loadinggif p3alert guessloading"></label>'
        $('.p3question').html(htmlinfo)
        $('.p3alert').text('')
      }
    } else if (answer == 'false') {
      $('.p3alert').text('Ừm...có vẻ như bạn chọn chưa đúng.')
    } else if (typeof answer == 'undefined' && typeof answertext == 'undefined') {
      $('.p3alert').text('Bạn chưa chọn câu trả lời')
    } else {
      if (isNaN(answertext)) {
        $('#answertext').addClass('errorborder')
        $('#answertext').focus()
        $('.p3alert').text('Bạn chưa nhập số người')
      } else if (answertext != '') {
        if (question <= totalquestion) {
          var url = rooturl + 'product/nextquestion'
          $('.guessloading').css('display', 'block')
          var data = { action: 'nextquestion', question: question, fpgid: fpgid, totalquestion: totalquestion }
          $.ajax({
            type: 'POST',
            data: data,
            url: url,
            dataType: 'html',
            success: function (data) {
              if (data != '') {
                $('.guessloading').css('display', 'none')
                question = question + 1
                $('#answesitem').html(data)
              }
            },
          })
          $('.p3alert').text('')
        } else {
          var htmlinfo =
            '<strong>Thông tin liên hệ</strong><span>Mời bạn để lại thông tin để nhận thông báo khi <i><a href="https://ecommerce.kubil.app/" target="_blank" style="text-decoration:none;color:#00a1e6"><b>dienmay</b>.com</a></i> công bố kết quả</span>'
          htmlinfo +=
            '<input id="ffullname" class="p3input2" name="ffullname" type="text" placeholder="Họ và tên bạn"><div class="clear"></div>'
          htmlinfo +=
            '<input id="fphoneguess" class="p3input2" name="fphone" type="text" placeholder="Điện thoại của bạn"><div class="clear"></div>'
          htmlinfo +=
            '<input id="femail" class="p3input2" name="femail" type="text" placeholder="Email của bạn"><div class="clear"></div>'
          htmlinfo +=
            '<input id="faddress" class="p3input2" name="faddress" type="text" placeholder="Địa chỉ của bạn"><div class="clear"></div>'
          htmlinfo +=
            '<label class="p3check"><input id="fcheckproduct" class="check" name="fcheckproduct" type="checkbox" checked value="1">Nhận thông báo qua email và tin nhắn khi sản phẩm này được bán</label><div class="clear"></div>'
          htmlinfo +=
            '<label class="p3check"><input id="fcheckfull" class="check" name="fcheckfull" type="checkbox" value="1">Nhận thông báo qua email về các chương trình khuyến mãi khác của dienmay.com</label><div class="clear"></div>'
          htmlinfo +=
            '<div class="btn-step"><a data-id="' +
            fpgid +
            '" rel="' +
            answertext +
            '" id="confirm_info" href="javascript:;">Hoàn tất</a></div>'
          htmlinfo += '<label class="loadinggif p3alert guessloading"></label>'
          $('.p3question').html(htmlinfo)
          $('.p3alert').text('')
        }
      } else {
        $('#answertext').addClass('errorborder')
        $('#answertext').focus()
        $('.p3alert').text('Bạn chưa dự đoán số người trả lời giống bạn.')
      }
    }
  })
  $('body').on('click', '#confirm_info', function () {
    var fpgid = $(this).attr('data-id')
    var answertext = $(this).attr('rel')
    var ffullname = $('#ffullname').val()
    var femail = $('#femail').val()
    var fphone = $('#fphoneguess').val()
    var faddress = $('#faddress').val()
    var flag = true
    if (faddress == '' || faddress == null) {
      $('#faddress').addClass('errorborder')
      $('#faddress').focus()
      $('.alertaddress').text('Vui lòng nhập địa chỉ')
      flag = false
    }
    $('#faddress').change(function () {
      $('#faddress').removeClass('errorborder')
      $('.alertaddress').text('')
      flag = true
    })
    var atpos = femail.indexOf('@')
    var dotpos = femail.lastIndexOf('.')
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= femail.length) {
      $('#femail').addClass('errorborder')
      $('#femail').focus()
      $('.alertemail').text('Email không đúng định dạng')
      flag = false
    }
    $('#femail').change(function () {
      $('#femail').removeClass('errorborder')
      $('.alertemail').text('')
      flag = true
    })
    if (fphone.value == '') {
      $('#fphoneguess').addClass('errorborder')
      $('#fphoneguess').focus()
      $('.alertphone').text('Vui lòng nhập số điện thoại')
      flag = false
    } else if (isNaN(parseInt(fphone))) {
      $('#fphoneguess').addClass('errorborder')
      $('#fphoneguess').focus()
      $('.alertphone').text('Số điện thoại không đúng')
      flag = false
    }
    $('#fphoneguess').change(function () {
      $('#fphoneguess').removeClass('errorborder')
      $('.alertphone').text('')
      flag = true
    })
    if (ffullname == '' || ffullname == null) {
      $('#ffullname').addClass('errorborder')
      $('#ffullname').focus()
      $('.alertfullname').text('Vui lòng nhập họ tên')
      flag = false
    }
    $('#ffullname').change(function () {
      $('#ffullname').removeClass('errorborder')
      $('.alertfullname').text('')
      flag = true
    })
    var fcheckproduct = $('#fcheckproduct:checked').val()
    if (fcheckproduct == 'undefined') {
      fcheckproduct = 0
    }
    var fcheckfull = $('#fcheckfull:checked').val()
    if (fcheckfull == 'undefined') {
      fcheckfull = 0
    }
    if (flag == true) {
      var url = rooturl + 'product/saveinfoguess'
      $('.guessloading').css('display', 'block')
      var data = {
        action: 'saveinfoguess',
        ffullname: ffullname,
        femail: femail,
        fphone: fphone,
        faddress: faddress,
        fnewsletterproduct: fcheckproduct,
        newsletter: fcheckfull,
        fpgid: fpgid,
        fanswer: answertext,
      }
      $.ajax({
        type: 'POST',
        data: data,
        url: url,
        dataType: 'json',
        success: function (data) {
          if (data.error == 0) {
            $('.guessloading').css('display', 'none')
            $('.p3question').html(data.html)
          } else if (data.error == -2) {
            $('.guessloading').css('display', 'none')
            $('.p3question').html(data.html)
          }
        },
      })
      $('.p3alert').text('')
    }
  })
})
var Swiper = function (a, b) {
  function d(a) {
    return document.querySelectorAll ? document.querySelectorAll(a) : jQuery(a)
  }
  function v() {
    var a = h - k
    return b.freeMode && (a = h - k), b.slidesPerView > e.slides.length && (a = 0), 0 > a && (a = 0), a
  }
  function x() {
    function f(a) {
      var c = new Image()
      ;(c.onload = function () {
        e.imagesLoaded++, e.imagesLoaded == e.imagesToLoad.length && (e.reInit(), b.onImagesReady && b.onImagesReady(e))
      }),
        (c.src = a)
    }
    if (
      (e.browser.ie10
        ? (e.h.addEventListener(e.wrapper, e.touchEvents.touchStart, J, !1),
          e.h.addEventListener(document, e.touchEvents.touchMove, M, !1),
          e.h.addEventListener(document, e.touchEvents.touchEnd, N, !1))
        : (e.support.touch &&
            (e.h.addEventListener(e.wrapper, 'touchstart', J, !1),
            e.h.addEventListener(e.wrapper, 'touchmove', M, !1),
            e.h.addEventListener(e.wrapper, 'touchend', N, !1)),
          b.simulateTouch &&
            (e.h.addEventListener(e.wrapper, 'mousedown', J, !1),
            e.h.addEventListener(document, 'mousemove', M, !1),
            e.h.addEventListener(document, 'mouseup', N, !1))),
      b.autoResize && e.h.addEventListener(window, 'resize', e.resizeFix, !1),
      y(),
      (e._wheelEvent = !1),
      b.mousewheelControl)
    ) {
      void 0 !== document.onmousewheel && (e._wheelEvent = 'mousewheel')
      try {
        WheelEvent('wheel'), (e._wheelEvent = 'wheel')
      } catch (a) {}
      e._wheelEvent || (e._wheelEvent = 'DOMMouseScroll'),
        e._wheelEvent && e.h.addEventListener(e.container, e._wheelEvent, B, !1)
    }
    if ((b.keyboardControl && e.h.addEventListener(document, 'keydown', A, !1), b.updateOnImagesReady)) {
      document.querySelectorAll
        ? (e.imagesToLoad = e.container.querySelectorAll('img'))
        : window.jQuery && (e.imagesToLoad = d(e.container).find('img'))
      for (var c = 0; e.imagesToLoad.length > c; c++) f(e.imagesToLoad[c].getAttribute('src'))
    }
  }
  function y() {
    if (b.preventLinks) {
      var a = []
      document.querySelectorAll
        ? (a = e.container.querySelectorAll('a'))
        : window.jQuery && (a = d(e.container).find('a'))
      for (var c = 0; a.length > c; c++) e.h.addEventListener(a[c], 'click', E, !1)
    }
    if (b.releaseFormElements)
      for (
        var f = document.querySelectorAll
            ? e.container.querySelectorAll('input, textarea, select')
            : d(e.container).find('input, textarea, select'),
          c = 0;
        f.length > c;
        c++
      )
        e.h.addEventListener(f[c], e.touchEvents.touchStart, F, !0)
    if (b.onSlideClick) for (var c = 0; e.slides.length > c; c++) e.h.addEventListener(e.slides[c], 'click', C, !1)
    if (b.onSlideTouch)
      for (var c = 0; e.slides.length > c; c++) e.h.addEventListener(e.slides[c], e.touchEvents.touchStart, D, !1)
  }
  function z() {
    if (b.onSlideClick) for (var a = 0; e.slides.length > a; a++) e.h.removeEventListener(e.slides[a], 'click', C, !1)
    if (b.onSlideTouch)
      for (var a = 0; e.slides.length > a; a++) e.h.removeEventListener(e.slides[a], e.touchEvents.touchStart, D, !1)
    if (b.releaseFormElements)
      for (
        var c = document.querySelectorAll
            ? e.container.querySelectorAll('input, textarea, select')
            : d(e.container).find('input, textarea, select'),
          a = 0;
        c.length > a;
        a++
      )
        e.h.removeEventListener(c[a], e.touchEvents.touchStart, F, !0)
    if (b.preventLinks) {
      var f = []
      document.querySelectorAll
        ? (f = e.container.querySelectorAll('a'))
        : window.jQuery && (f = d(e.container).find('a'))
      for (var a = 0; f.length > a; a++) e.h.removeEventListener(f[a], 'click', E, !1)
    }
  }
  function A(a) {
    var b = a.keyCode || a.charCode
    if (37 == b || 39 == b || 38 == b || 40 == b) {
      for (
        var c = !1,
          d = e.h.getOffset(e.container),
          f = e.h.windowScroll().left,
          g = e.h.windowScroll().top,
          h = e.h.windowWidth(),
          i = e.h.windowHeight(),
          j = [
            [d.left, d.top],
            [d.left + e.width, d.top],
            [d.left, d.top + e.height],
            [d.left + e.width, d.top + e.height],
          ],
          k = 0;
        j.length > k;
        k++
      ) {
        var l = j[k]
        l[0] >= f && f + h >= l[0] && l[1] >= g && g + i >= l[1] && (c = !0)
      }
      if (!c) return
    }
    o
      ? ((37 == b || 39 == b) && (a.preventDefault ? a.preventDefault() : (a.returnValue = !1)),
        39 == b && e.swipeNext(),
        37 == b && e.swipePrev())
      : ((38 == b || 40 == b) && (a.preventDefault ? a.preventDefault() : (a.returnValue = !1)),
        40 == b && e.swipeNext(),
        38 == b && e.swipePrev())
  }
  function B(a) {
    var d,
      c = e._wheelEvent
    if (
      (a.detail
        ? (d = -a.detail)
        : 'mousewheel' == c
        ? (d = a.wheelDelta)
        : 'DOMMouseScroll' == c
        ? (d = -a.detail)
        : 'wheel' == c && (d = Math.abs(a.deltaX) > Math.abs(a.deltaY) ? -a.deltaX : -a.deltaY),
      b.freeMode)
    ) {
      o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y')
      var g, h
      o
        ? ((g = e.getWrapperTranslate('x') + d),
          (h = e.getWrapperTranslate('y')),
          g > 0 && (g = 0),
          -v() > g && (g = -v()))
        : ((g = e.getWrapperTranslate('x')),
          (h = e.getWrapperTranslate('y') + d),
          h > 0 && (h = 0),
          -v() > h && (h = -v())),
        e.setWrapperTransition(0),
        e.setWrapperTranslate(g, h, 0)
    } else 0 > d ? e.swipeNext() : e.swipePrev()
    return b.autoplay && e.stopAutoplay(), a.preventDefault ? a.preventDefault() : (a.returnValue = !1), !1
  }
  function C() {
    e.allowSlideClick && ((e.clickedSlide = this), (e.clickedSlideIndex = e.slides.indexOf(this)), b.onSlideClick(e))
  }
  function D() {
    ;(e.clickedSlide = this), (e.clickedSlideIndex = e.slides.indexOf(this)), b.onSlideTouch(e)
  }
  function E(a) {
    return e.allowLinks ? void 0 : (a.preventDefault ? a.preventDefault() : (a.returnValue = !1), !1)
  }
  function F(a) {
    return a.stopPropagation ? a.stopPropagation() : (a.returnValue = !1), !1
  }
  function J(a) {
    if ((b.preventLinks && (e.allowLinks = !0), e.isTouched || b.onlyExternal)) return !1
    if (b.noSwiping && a.target && a.target.className && a.target.className.indexOf(b.noSwipingClass) > -1) return !1
    if (((I = !1), (e.isTouched = !0), (G = 'touchstart' == a.type), !G || 1 == a.targetTouches.length)) {
      b.loop && e.fixLoop(),
        e.callPlugins('onTouchStartBegin'),
        G || (a.preventDefault ? a.preventDefault() : (a.returnValue = !1))
      var c = G ? a.targetTouches[0].pageX : a.pageX || a.clientX,
        d = G ? a.targetTouches[0].pageY : a.pageY || a.clientY
      ;(e.touches.startX = e.touches.currentX = c),
        (e.touches.startY = e.touches.currentY = d),
        (e.touches.start = e.touches.current = o ? c : d),
        e.setWrapperTransition(0),
        (e.positions.start = e.positions.current = o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y')),
        o ? e.setWrapperTranslate(e.positions.start, 0, 0) : e.setWrapperTranslate(0, e.positions.start, 0),
        (e.times.start = new Date().getTime()),
        (j = void 0),
        b.moveStartThreshold > 0 && (H = !1),
        b.onTouchStart && b.onTouchStart(e),
        e.callPlugins('onTouchStartEnd')
    }
  }
  function M(a) {
    if (e.isTouched && !b.onlyExternal && (!G || 'mousemove' != a.type)) {
      var c = G ? a.targetTouches[0].pageX : a.pageX || a.clientX,
        d = G ? a.targetTouches[0].pageY : a.pageY || a.clientY
      if (
        (j === void 0 && o && (j = !!(j || Math.abs(d - e.touches.startY) > Math.abs(c - e.touches.startX))),
        void 0 !== j || o || (j = !!(j || Math.abs(d - e.touches.startY) < Math.abs(c - e.touches.startX))),
        j)
      )
        return (e.isTouched = !1), void 0
      if (a.assignedToSwiper) return (e.isTouched = !1), void 0
      if (
        ((a.assignedToSwiper = !0),
        (e.isMoved = !0),
        b.preventLinks && (e.allowLinks = !1),
        b.onSlideClick && (e.allowSlideClick = !1),
        b.autoplay && e.stopAutoplay(),
        !G || 1 == a.touches.length)
      ) {
        if (
          (e.callPlugins('onTouchMoveStart'),
          a.preventDefault ? a.preventDefault() : (a.returnValue = !1),
          (e.touches.current = o ? c : d),
          (e.positions.current = (e.touches.current - e.touches.start) * b.touchRatio + e.positions.start),
          e.positions.current > 0 && b.onResistanceBefore && b.onResistanceBefore(e, e.positions.current),
          e.positions.current < -v() &&
            b.onResistanceBefore &&
            b.onResistanceAfter(e, Math.abs(e.positions.current + v())),
          b.resistance && '100%' != b.resistance)
        ) {
          if (e.positions.current > 0) {
            var f = 1 - e.positions.current / k / 2
            e.positions.current = 0.5 > f ? k / 2 : e.positions.current * f
          }
          if (e.positions.current < -v()) {
            var g = (e.touches.current - e.touches.start) * b.touchRatio + (v() + e.positions.start),
              f = (k + g) / k,
              h = e.positions.current - (g * (1 - f)) / 2,
              i = -v() - k / 2
            e.positions.current = i > h || 0 >= f ? i : h
          }
        }
        if (
          (b.resistance &&
            '100%' == b.resistance &&
            (e.positions.current > 0 && (!b.freeMode || b.freeModeFluid) && (e.positions.current = 0),
            e.positions.current < -v() && (!b.freeMode || b.freeModeFluid) && (e.positions.current = -v())),
          !b.followFinger)
        )
          return
        return (
          b.moveStartThreshold
            ? Math.abs(e.touches.current - e.touches.start) > b.moveStartThreshold || H
              ? ((H = !0),
                o ? e.setWrapperTranslate(e.positions.current, 0, 0) : e.setWrapperTranslate(0, e.positions.current, 0))
              : (e.positions.current = e.positions.start)
            : o
            ? e.setWrapperTranslate(e.positions.current, 0, 0)
            : e.setWrapperTranslate(0, e.positions.current, 0),
          (b.freeMode || b.watchActiveIndex) && e.updateActiveSlide(e.positions.current),
          b.grabCursor &&
            ((e.container.style.cursor = 'move'),
            (e.container.style.cursor = 'grabbing'),
            (e.container.style.cursor = '-moz-grabbin'),
            (e.container.style.cursor = '-webkit-grabbing')),
          K || (K = e.touches.current),
          L || (L = new Date().getTime()),
          (e.velocity = (e.touches.current - K) / (new Date().getTime() - L) / 2),
          2 > Math.abs(e.touches.current - K) && (e.velocity = 0),
          (K = e.touches.current),
          (L = new Date().getTime()),
          e.callPlugins('onTouchMoveEnd'),
          b.onTouchMove && b.onTouchMove(e),
          !1
        )
      }
    }
  }
  function N() {
    if ((j && e.swipeReset(), !b.onlyExternal && e.isTouched)) {
      ;(e.isTouched = !1),
        b.grabCursor &&
          ((e.container.style.cursor = 'move'),
          (e.container.style.cursor = 'grab'),
          (e.container.style.cursor = '-moz-grab'),
          (e.container.style.cursor = '-webkit-grab')),
        e.positions.current || 0 === e.positions.current || (e.positions.current = e.positions.start),
        b.followFinger &&
          (o ? e.setWrapperTranslate(e.positions.current, 0, 0) : e.setWrapperTranslate(0, e.positions.current, 0)),
        (e.times.end = new Date().getTime()),
        (e.touches.diff = e.touches.current - e.touches.start),
        (e.touches.abs = Math.abs(e.touches.diff)),
        (e.positions.diff = e.positions.current - e.positions.start),
        (e.positions.abs = Math.abs(e.positions.diff))
      var c = e.positions.diff,
        d = e.positions.abs,
        f = e.times.end - e.times.start
      if (
        (5 > d &&
          300 > f &&
          0 == e.allowLinks &&
          (b.freeMode || 0 == d || e.swipeReset(),
          b.preventLinks && (e.allowLinks = !0),
          b.onSlideClick && (e.allowSlideClick = !0)),
        setTimeout(function () {
          b.preventLinks && (e.allowLinks = !0), b.onSlideClick && (e.allowSlideClick = !0)
        }, 100),
        !e.isMoved)
      )
        return (e.isMoved = !1), b.onTouchEnd && b.onTouchEnd(e), e.callPlugins('onTouchEnd'), void 0
      e.isMoved = !1
      var h = v()
      if (e.positions.current > 0)
        return e.swipeReset(), b.onTouchEnd && b.onTouchEnd(e), e.callPlugins('onTouchEnd'), void 0
      if (-h > e.positions.current)
        return e.swipeReset(), b.onTouchEnd && b.onTouchEnd(e), e.callPlugins('onTouchEnd'), void 0
      if (b.freeMode) {
        if (b.freeModeFluid) {
          var q,
            l = 1e3 * b.momentumRatio,
            m = e.velocity * l,
            n = e.positions.current + m,
            p = !1,
            r = 20 * Math.abs(e.velocity) * b.momentumBounceRatio
          ;-h > n &&
            (b.momentumBounce && e.support.transitions
              ? (-r > n + h && (n = -h - r), (q = -h), (p = !0), (I = !0))
              : (n = -h)),
            n > 0 &&
              (b.momentumBounce && e.support.transitions ? (n > r && (n = r), (q = 0), (p = !0), (I = !0)) : (n = 0)),
            0 != e.velocity && (l = Math.abs((n - e.positions.current) / e.velocity)),
            o ? e.setWrapperTranslate(n, 0, 0) : e.setWrapperTranslate(0, n, 0),
            e.setWrapperTransition(l),
            b.momentumBounce &&
              p &&
              e.wrapperTransitionEnd(function () {
                I &&
                  (b.onMomentumBounce && b.onMomentumBounce(e),
                  o ? e.setWrapperTranslate(q, 0, 0) : e.setWrapperTranslate(0, q, 0),
                  e.setWrapperTransition(300))
              }),
            e.updateActiveSlide(n)
        }
        return (
          (!b.freeModeFluid || f >= 300) && e.updateActiveSlide(e.positions.current),
          b.onTouchEnd && b.onTouchEnd(e),
          e.callPlugins('onTouchEnd'),
          void 0
        )
      }
      ;(i = 0 > c ? 'toNext' : 'toPrev'),
        'toNext' == i && 300 >= f && (30 > d || !b.shortSwipes ? e.swipeReset() : e.swipeNext(!0)),
        'toPrev' == i && 300 >= f && (30 > d || !b.shortSwipes ? e.swipeReset() : e.swipePrev(!0))
      var s = 0
      if ('auto' == b.slidesPerView) {
        for (
          var w, t = Math.abs(o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y')), u = 0, x = 0;
          e.slides.length > x;
          x++
        )
          if (((w = o ? e.slides[x].getWidth(!0) : e.slides[x].getHeight(!0)), (u += w), u > t)) {
            s = w
            break
          }
        s > k && (s = k)
      } else s = g * b.slidesPerView
      'toNext' == i && f > 300 && (d >= 0.5 * s ? e.swipeNext(!0) : e.swipeReset()),
        'toPrev' == i && f > 300 && (d >= 0.5 * s ? e.swipePrev(!0) : e.swipeReset()),
        b.onTouchEnd && b.onTouchEnd(e),
        e.callPlugins('onTouchEnd')
    }
  }
  function O(a, c, d) {
    function k() {
      ;(g += h),
        (j = 'toNext' == i ? g > a : a > g),
        j
          ? (o ? e.setWrapperTranslate(Math.round(g), 0) : e.setWrapperTranslate(0, Math.round(g)),
            (e._DOMAnimating = !0),
            window.setTimeout(function () {
              k()
            }, 1e3 / 60))
          : (b.onSlideChangeEnd && b.onSlideChangeEnd(e),
            o ? e.setWrapperTranslate(a, 0) : e.setWrapperTranslate(0, a),
            (e._DOMAnimating = !1))
    }
    if (e.support.transitions || !b.DOMAnimation) {
      o ? e.setWrapperTranslate(a, 0, 0) : e.setWrapperTranslate(0, a, 0)
      var f = 'to' == c && d.speed >= 0 ? d.speed : b.speed
      e.setWrapperTransition(f)
    } else {
      var g = o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y'),
        f = 'to' == c && d.speed >= 0 ? d.speed : b.speed,
        h = Math.ceil(((a - g) / f) * (1e3 / 60)),
        i = g > a ? 'toNext' : 'toPrev',
        j = 'toNext' == i ? g > a : a > g
      if (e._DOMAnimating) return
      k()
    }
    e.updateActiveSlide(a),
      b.onSlideNext && 'next' == c && b.onSlideNext(e, a),
      b.onSlidePrev && 'prev' == c && b.onSlidePrev(e, a),
      b.onSlideReset && 'reset' == c && b.onSlideReset(e, a),
      ('next' == c || 'prev' == c || ('to' == c && 1 == d.runCallbacks)) && P()
  }
  function P() {
    if ((e.callPlugins('onSlideChangeStart'), b.onSlideChangeStart))
      if (b.queueStartCallbacks && e.support.transitions) {
        if (e._queueStartCallbacks) return
        ;(e._queueStartCallbacks = !0),
          b.onSlideChangeStart(e),
          e.wrapperTransitionEnd(function () {
            e._queueStartCallbacks = !1
          })
      } else b.onSlideChangeStart(e)
    if (b.onSlideChangeEnd)
      if (e.support.transitions)
        if (b.queueEndCallbacks) {
          if (e._queueEndCallbacks) return
          ;(e._queueEndCallbacks = !0), e.wrapperTransitionEnd(b.onSlideChangeEnd)
        } else e.wrapperTransitionEnd(b.onSlideChangeEnd)
      else
        b.DOMAnimation ||
          setTimeout(function () {
            b.onSlideChangeEnd(e)
          }, 10)
  }
  function Q() {
    for (var a = e.paginationButtons, b = 0; a.length > b; b++) e.h.removeEventListener(a[b], 'click', S, !1)
  }
  function R() {
    for (var a = e.paginationButtons, b = 0; a.length > b; b++) e.h.addEventListener(a[b], 'click', S, !1)
  }
  function S(a) {
    for (var b, c = a.target || a.srcElement, d = e.paginationButtons, f = 0; d.length > f; f++) c === d[f] && (b = f)
    e.swipeTo(b)
  }
  function U() {
    e.calcSlides(),
      b.loader.slides.length > 0 && 0 == e.slides.length && e.loadSlides(),
      b.loop && e.createLoop(),
      e.init(),
      x(),
      b.pagination && b.createPagination && e.createPagination(!0),
      b.loop || b.initialSlide > 0 ? e.swipeTo(b.initialSlide, 0, !1) : e.updateActiveSlide(0),
      b.autoplay && e.startAutoplay()
  }
  if (document.body.__defineGetter__ && HTMLElement) {
    var c = HTMLElement.prototype
    c.__defineGetter__ &&
      c.__defineGetter__('outerHTML', function () {
        return new XMLSerializer().serializeToString(this)
      })
  }
  if (
    (window.getComputedStyle ||
      (window.getComputedStyle = function (a) {
        return (
          (this.el = a),
          (this.getPropertyValue = function (b) {
            var c = /(\-([a-z]){1})/g
            return (
              'float' === b && (b = 'styleFloat'),
              c.test(b) &&
                (b = b.replace(c, function () {
                  return arguments[2].toUpperCase()
                })),
              a.currentStyle[b] ? a.currentStyle[b] : null
            )
          }),
          this
        )
      }),
    Array.prototype.indexOf ||
      (Array.prototype.indexOf = function (a, b) {
        for (var c = b || 0, d = this.length; d > c; c++) if (this[c] === a) return c
        return -1
      }),
    (document.querySelectorAll || window.jQuery) && void 0 !== a && (a.nodeType || 0 !== d(a).length))
  ) {
    var e = this
    ;(e.touches = { start: 0, startX: 0, startY: 0, current: 0, currentX: 0, currentY: 0, diff: 0, abs: 0 }),
      (e.positions = { start: 0, abs: 0, diff: 0, current: 0 }),
      (e.times = { start: 0, end: 0 }),
      (e.id = new Date().getTime()),
      (e.container = a.nodeType ? a : d(a)[0]),
      (e.isTouched = !1),
      (e.isMoved = !1),
      (e.activeIndex = 0),
      (e.activeLoaderIndex = 0),
      (e.activeLoopIndex = 0),
      (e.previousIndex = null),
      (e.velocity = 0),
      (e.snapGrid = []),
      (e.slidesGrid = []),
      (e.imagesToLoad = []),
      (e.imagesLoaded = 0),
      (e.wrapperLeft = 0),
      (e.wrapperRight = 0),
      (e.wrapperTop = 0),
      (e.wrapperBottom = 0)
    var f,
      g,
      h,
      i,
      j,
      k,
      l = {
        mode: 'horizontal',
        touchRatio: 1,
        speed: 300,
        freeMode: !1,
        freeModeFluid: !1,
        momentumRatio: 1,
        momentumBounce: !0,
        momentumBounceRatio: 1,
        slidesPerView: 1,
        slidesPerGroup: 1,
        simulateTouch: !0,
        followFinger: !0,
        shortSwipes: !0,
        moveStartThreshold: !1,
        autoplay: !1,
        onlyExternal: !1,
        createPagination: !0,
        pagination: !1,
        paginationElement: 'span',
        paginationClickable: !1,
        paginationAsRange: !0,
        resistance: !0,
        scrollContainer: !1,
        preventLinks: !0,
        noSwiping: !1,
        noSwipingClass: 'swiper-no-swiping',
        initialSlide: 0,
        keyboardControl: !1,
        mousewheelControl: !1,
        useCSS3Transforms: !0,
        loop: !1,
        loopAdditionalSlides: 0,
        calculateHeight: !1,
        updateOnImagesReady: !0,
        releaseFormElements: !0,
        watchActiveIndex: !1,
        visibilityFullFit: !1,
        offsetPxBefore: 0,
        offsetPxAfter: 0,
        offsetSlidesBefore: 0,
        offsetSlidesAfter: 0,
        centeredSlides: !1,
        queueStartCallbacks: !1,
        queueEndCallbacks: !1,
        autoResize: !0,
        resizeReInit: !1,
        DOMAnimation: !0,
        loader: { slides: [], slidesHTMLType: 'inner', surroundGroups: 1, logic: 'reload', loadAllSlides: !1 },
        slideElement: 'div',
        slideClass: 'swiper-slide',
        slideActiveClass: 'swiper-slide-active',
        slideVisibleClass: 'swiper-slide-visible',
        wrapperClass: 'swiper-wrapper',
        paginationElementClass: 'swiper-pagination-switch',
        paginationActiveClass: 'swiper-active-switch',
        paginationVisibleClass: 'swiper-visible-switch',
      }
    b = b || {}
    for (var m in l)
      if (m in b && 'object' == typeof b[m]) for (var n in l[m]) n in b[m] || (b[m][n] = l[m][n])
      else m in b || (b[m] = l[m])
    ;(e.params = b), b.scrollContainer && ((b.freeMode = !0), (b.freeModeFluid = !0)), b.loop && (b.resistance = '100%')
    var o = 'horizontal' === b.mode
    e.touchEvents = {
      touchStart: e.support.touch || !b.simulateTouch ? 'touchstart' : e.browser.ie10 ? 'MSPointerDown' : 'mousedown',
      touchMove: e.support.touch || !b.simulateTouch ? 'touchmove' : e.browser.ie10 ? 'MSPointerMove' : 'mousemove',
      touchEnd: e.support.touch || !b.simulateTouch ? 'touchend' : e.browser.ie10 ? 'MSPointerUp' : 'mouseup',
    }
    for (var p = e.container.childNodes.length - 1; p >= 0; p--)
      if (e.container.childNodes[p].className)
        for (var q = e.container.childNodes[p].className.split(' '), r = 0; q.length > r; r++)
          q[r] === b.wrapperClass && (f = e.container.childNodes[p])
    ;(e.wrapper = f),
      (e._extendSwiperSlide = function (a) {
        return (
          (a.append = function () {
            return (
              b.loop
                ? (a.insertAfter(e.slides.length - e.loopedSlides),
                  e.removeLoopedSlides(),
                  e.calcSlides(),
                  e.createLoop())
                : e.wrapper.appendChild(a),
              e.reInit(),
              a
            )
          }),
          (a.prepend = function () {
            return (
              b.loop
                ? (e.wrapper.insertBefore(a, e.slides[e.loopedSlides]),
                  e.removeLoopedSlides(),
                  e.calcSlides(),
                  e.createLoop())
                : e.wrapper.insertBefore(a, e.wrapper.firstChild),
              e.reInit(),
              a
            )
          }),
          (a.insertAfter = function (c) {
            if (c === void 0) return !1
            var d
            return (
              b.loop
                ? ((d = e.slides[c + 1 + e.loopedSlides]),
                  e.wrapper.insertBefore(a, d),
                  e.removeLoopedSlides(),
                  e.calcSlides(),
                  e.createLoop())
                : ((d = e.slides[c + 1]), e.wrapper.insertBefore(a, d)),
              e.reInit(),
              a
            )
          }),
          (a.clone = function () {
            return e._extendSwiperSlide(a.cloneNode(!0))
          }),
          (a.remove = function () {
            e.wrapper.removeChild(a), e.reInit()
          }),
          (a.html = function (b) {
            return b === void 0 ? a.innerHTML : ((a.innerHTML = b), a)
          }),
          (a.index = function () {
            for (var b, c = e.slides.length - 1; c >= 0; c--) a === e.slides[c] && (b = c)
            return b
          }),
          (a.isActive = function () {
            return a.index() === e.activeIndex ? !0 : !1
          }),
          a.swiperSlideDataStorage || (a.swiperSlideDataStorage = {}),
          (a.getData = function (b) {
            return a.swiperSlideDataStorage[b]
          }),
          (a.setData = function (b, c) {
            return (a.swiperSlideDataStorage[b] = c), a
          }),
          (a.data = function (b, c) {
            return c ? (a.setAttribute('data-' + b, c), a) : a.getAttribute('data-' + b)
          }),
          (a.getWidth = function (b) {
            return e.h.getWidth(a, b)
          }),
          (a.getHeight = function (b) {
            return e.h.getHeight(a, b)
          }),
          (a.getOffset = function () {
            return e.h.getOffset(a)
          }),
          a
        )
      }),
      (e.calcSlides = function (a) {
        var c = e.slides ? e.slides.length : !1
        ;(e.slides = []), (e.displaySlides = [])
        for (var d = 0; e.wrapper.childNodes.length > d; d++)
          if (e.wrapper.childNodes[d].className)
            for (var f = e.wrapper.childNodes[d].className, g = f.split(' '), h = 0; g.length > h; h++)
              g[h] === b.slideClass && e.slides.push(e.wrapper.childNodes[d])
        for (d = e.slides.length - 1; d >= 0; d--) e._extendSwiperSlide(e.slides[d])
        c &&
          (c !== e.slides.length || a) &&
          (z(),
          y(),
          e.updateActiveSlide(),
          b.createPagination && e.params.pagination && e.createPagination(),
          e.callPlugins('numberOfSlidesChanged'))
      }),
      (e.createSlide = function (a, c, d) {
        var c = c || e.params.slideClass,
          d = d || b.slideElement,
          f = document.createElement(d)
        return (f.innerHTML = a || ''), (f.className = c), e._extendSwiperSlide(f)
      }),
      (e.appendSlide = function (a, b, c) {
        return a ? (a.nodeType ? e._extendSwiperSlide(a).append() : e.createSlide(a, b, c).append()) : void 0
      }),
      (e.prependSlide = function (a, b, c) {
        return a ? (a.nodeType ? e._extendSwiperSlide(a).prepend() : e.createSlide(a, b, c).prepend()) : void 0
      }),
      (e.insertSlideAfter = function (a, b, c, d) {
        return a === void 0
          ? !1
          : b.nodeType
          ? e._extendSwiperSlide(b).insertAfter(a)
          : e.createSlide(b, c, d).insertAfter(a)
      }),
      (e.removeSlide = function (a) {
        if (e.slides[a]) {
          if (b.loop) {
            if (!e.slides[a + e.loopedSlides]) return !1
            e.slides[a + e.loopedSlides].remove(), e.removeLoopedSlides(), e.calcSlides(), e.createLoop()
          } else e.slides[a].remove()
          return !0
        }
        return !1
      }),
      (e.removeLastSlide = function () {
        return e.slides.length > 0
          ? (b.loop
              ? (e.slides[e.slides.length - 1 - e.loopedSlides].remove(),
                e.removeLoopedSlides(),
                e.calcSlides(),
                e.createLoop())
              : e.slides[e.slides.length - 1].remove(),
            !0)
          : !1
      }),
      (e.removeAllSlides = function () {
        for (var a = e.slides.length - 1; a >= 0; a--) e.slides[a].remove()
      }),
      (e.getSlide = function (a) {
        return e.slides[a]
      }),
      (e.getLastSlide = function () {
        return e.slides[e.slides.length - 1]
      }),
      (e.getFirstSlide = function () {
        return e.slides[0]
      }),
      (e.activeSlide = function () {
        return e.slides[e.activeIndex]
      })
    var s = []
    for (var t in e.plugins)
      if (b[t]) {
        var u = e.plugins[t](e, b[t])
        u && s.push(u)
      }
    ;(e.callPlugins = function (a, b) {
      b || (b = {})
      for (var c = 0; s.length > c; c++) a in s[c] && s[c][a](b)
    }),
      e.browser.ie10 &&
        !b.onlyExternal &&
        (o ? e.wrapper.classList.add('swiper-wp8-horizontal') : e.wrapper.classList.add('swiper-wp8-vertical')),
      b.freeMode && (e.container.className += ' swiper-free-mode'),
      (e.initialized = !1),
      (e.init = function (a, c) {
        var d = e.h.getWidth(e.container),
          f = e.h.getHeight(e.container)
        if (d !== e.width || f !== e.height || a) {
          ;(e.width = d), (e.height = f), (k = o ? d : f)
          var i = e.wrapper
          if ((a && e.calcSlides(c), 'auto' === b.slidesPerView)) {
            var j = 0,
              l = 0
            b.slidesOffset > 0 &&
              ((i.style.paddingLeft = ''),
              (i.style.paddingRight = ''),
              (i.style.paddingTop = ''),
              (i.style.paddingBottom = '')),
              (i.style.width = ''),
              (i.style.height = ''),
              b.offsetPxBefore > 0 && (o ? (e.wrapperLeft = b.offsetPxBefore) : (e.wrapperTop = b.offsetPxBefore)),
              b.offsetPxAfter > 0 && (o ? (e.wrapperRight = b.offsetPxAfter) : (e.wrapperBottom = b.offsetPxAfter)),
              b.centeredSlides &&
                (o
                  ? ((e.wrapperLeft = (k - this.slides[0].getWidth(!0)) / 2),
                    (e.wrapperRight = (k - e.slides[e.slides.length - 1].getWidth(!0)) / 2))
                  : ((e.wrapperTop = (k - e.slides[0].getHeight(!0)) / 2),
                    (e.wrapperBottom = (k - e.slides[e.slides.length - 1].getHeight(!0)) / 2))),
              o
                ? (e.wrapperLeft >= 0 && (i.style.paddingLeft = e.wrapperLeft + 'px'),
                  e.wrapperRight >= 0 && (i.style.paddingRight = e.wrapperRight + 'px'))
                : (e.wrapperTop >= 0 && (i.style.paddingTop = e.wrapperTop + 'px'),
                  e.wrapperBottom >= 0 && (i.style.paddingBottom = e.wrapperBottom + 'px'))
            var m = 0,
              n = 0
            ;(e.snapGrid = []), (e.slidesGrid = [])
            for (var p = 0, q = 0; e.slides.length > q; q++) {
              var r = e.slides[q].getWidth(!0),
                s = e.slides[q].getHeight(!0)
              b.calculateHeight && (p = Math.max(p, s))
              var t = o ? r : s
              if (b.centeredSlides) {
                var u = q === e.slides.length - 1 ? 0 : e.slides[q + 1].getWidth(!0),
                  v = q === e.slides.length - 1 ? 0 : e.slides[q + 1].getHeight(!0),
                  w = o ? u : v
                if (t > k) {
                  for (var x = 0; Math.floor(t / (k + e.wrapperLeft)) >= x; x++)
                    0 === x ? e.snapGrid.push(m + e.wrapperLeft) : e.snapGrid.push(m + e.wrapperLeft + k * x)
                  e.slidesGrid.push(m + e.wrapperLeft)
                } else e.snapGrid.push(n), e.slidesGrid.push(n)
                n += t / 2 + w / 2
              } else {
                if (t > k) for (var x = 0; Math.floor(t / k) >= x; x++) e.snapGrid.push(m + k * x)
                else e.snapGrid.push(m)
                e.slidesGrid.push(m)
              }
              ;(m += t), (j += r), (l += s)
            }
            b.calculateHeight && (e.height = p),
              o
                ? ((h = j + e.wrapperRight + e.wrapperLeft),
                  (i.style.width = j + 'px'),
                  (i.style.height = e.height + 'px'))
                : ((h = l + e.wrapperTop + e.wrapperBottom),
                  (i.style.width = e.width + 'px'),
                  (i.style.height = l + 'px'))
          } else if (b.scrollContainer) {
            ;(i.style.width = ''), (i.style.height = '')
            var y = e.slides[0].getWidth(!0),
              z = e.slides[0].getHeight(!0)
            ;(h = o ? y : z), (i.style.width = y + 'px'), (i.style.height = z + 'px'), (g = o ? y : z)
          } else {
            if (b.calculateHeight) {
              var p = 0,
                z = 0
              o || (e.container.style.height = ''), (i.style.height = '')
              for (var q = 0; e.slides.length > q; q++)
                (e.slides[q].style.height = ''),
                  (p = Math.max(e.slides[q].getHeight(!0), p)),
                  o || (z += e.slides[q].getHeight(!0))
              var s = p
              if (o) var z = s
              ;(k = e.height = s), o || (e.container.style.height = k + 'px')
            } else
              var s = o ? e.height : e.height / b.slidesPerView,
                z = o ? e.height : e.slides.length * s
            var r = o ? e.width / b.slidesPerView : e.width,
              y = o ? e.slides.length * r : e.width
            ;(g = o ? r : s),
              b.offsetSlidesBefore > 0 &&
                (o ? (e.wrapperLeft = g * b.offsetSlidesBefore) : (e.wrapperTop = g * b.offsetSlidesBefore)),
              b.offsetSlidesAfter > 0 &&
                (o ? (e.wrapperRight = g * b.offsetSlidesAfter) : (e.wrapperBottom = g * b.offsetSlidesAfter)),
              b.offsetPxBefore > 0 && (o ? (e.wrapperLeft = b.offsetPxBefore) : (e.wrapperTop = b.offsetPxBefore)),
              b.offsetPxAfter > 0 && (o ? (e.wrapperRight = b.offsetPxAfter) : (e.wrapperBottom = b.offsetPxAfter)),
              b.centeredSlides &&
                (o
                  ? ((e.wrapperLeft = (k - g) / 2), (e.wrapperRight = (k - g) / 2))
                  : ((e.wrapperTop = (k - g) / 2), (e.wrapperBottom = (k - g) / 2))),
              o
                ? (e.wrapperLeft > 0 && (i.style.paddingLeft = e.wrapperLeft + 'px'),
                  e.wrapperRight > 0 && (i.style.paddingRight = e.wrapperRight + 'px'))
                : (e.wrapperTop > 0 && (i.style.paddingTop = e.wrapperTop + 'px'),
                  e.wrapperBottom > 0 && (i.style.paddingBottom = e.wrapperBottom + 'px')),
              (h = o ? y + e.wrapperRight + e.wrapperLeft : z + e.wrapperTop + e.wrapperBottom),
              (i.style.width = y + 'px'),
              (i.style.height = z + 'px')
            var m = 0
            ;(e.snapGrid = []), (e.slidesGrid = [])
            for (var q = 0; e.slides.length > q; q++)
              e.snapGrid.push(m),
                e.slidesGrid.push(m),
                (m += g),
                (e.slides[q].style.width = r + 'px'),
                (e.slides[q].style.height = s + 'px')
          }
          e.initialized ? e.callPlugins('onInit') : e.callPlugins('onFirstInit'), (e.initialized = !0)
        }
      }),
      (e.reInit = function (a) {
        e.init(!0, a)
      }),
      (e.resizeFix = function (a) {
        if ((e.callPlugins('beforeResizeFix'), e.init(b.resizeReInit || a), b.freeMode)) {
          var c = o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y')
          if (-v() > c) {
            var d = o ? -v() : 0,
              f = o ? 0 : -v()
            e.setWrapperTransition(0), e.setWrapperTranslate(d, f, 0)
          }
        } else b.loop ? e.swipeTo(e.activeLoopIndex, 0, !1) : e.swipeTo(e.activeIndex, 0, !1)
        e.callPlugins('afterResizeFix')
      }),
      (e.destroy = function () {
        e.browser.ie10
          ? (e.h.removeEventListener(e.wrapper, e.touchEvents.touchStart, J, !1),
            e.h.removeEventListener(document, e.touchEvents.touchMove, M, !1),
            e.h.removeEventListener(document, e.touchEvents.touchEnd, N, !1))
          : (e.support.touch &&
              (e.h.removeEventListener(e.wrapper, 'touchstart', J, !1),
              e.h.removeEventListener(e.wrapper, 'touchmove', M, !1),
              e.h.removeEventListener(e.wrapper, 'touchend', N, !1)),
            b.simulateTouch &&
              (e.h.removeEventListener(e.wrapper, 'mousedown', J, !1),
              e.h.removeEventListener(document, 'mousemove', M, !1),
              e.h.removeEventListener(document, 'mouseup', N, !1))),
          b.autoResize && e.h.removeEventListener(window, 'resize', e.resizeFix, !1),
          z(),
          b.paginationClickable && Q(),
          b.mousewheelControl && e._wheelEvent && e.h.removeEventListener(e.container, e._wheelEvent, B, !1),
          b.keyboardControl && e.h.removeEventListener(document, 'keydown', A, !1),
          b.autoplay && e.stopAutoplay(),
          e.callPlugins('onDestroy')
      }),
      b.grabCursor &&
        ((e.container.style.cursor = 'move'),
        (e.container.style.cursor = 'grab'),
        (e.container.style.cursor = '-moz-grab'),
        (e.container.style.cursor = '-webkit-grab')),
      (e.allowSlideClick = !0),
      (e.allowLinks = !0)
    var H,
      K,
      L,
      G = !1,
      I = !0
    ;(e.swipeNext = function (a) {
      !a && b.loop && e.fixLoop(), e.callPlugins('onSwipeNext')
      var c = o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y'),
        d = c
      if ('auto' == b.slidesPerView) {
        for (var f = 0; e.snapGrid.length > f; f++)
          if (-c >= e.snapGrid[f] && e.snapGrid[f + 1] > -c) {
            d = -e.snapGrid[f + 1]
            break
          }
      } else {
        var h = g * b.slidesPerGroup
        d = -(Math.floor(Math.abs(c) / Math.floor(h)) * h + h)
      }
      return -v() > d && (d = -v()), d == c ? !1 : (O(d, 'next'), !0)
    }),
      (e.swipePrev = function (a) {
        !a && b.loop && e.fixLoop(), !a && b.autoplay && e.stopAutoplay(), e.callPlugins('onSwipePrev')
        var d,
          c = Math.ceil(o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y'))
        if ('auto' == b.slidesPerView) {
          d = 0
          for (var f = 1; e.snapGrid.length > f; f++) {
            if (-c == e.snapGrid[f]) {
              d = -e.snapGrid[f - 1]
              break
            }
            if (-c > e.snapGrid[f] && e.snapGrid[f + 1] > -c) {
              d = -e.snapGrid[f]
              break
            }
          }
        } else {
          var h = g * b.slidesPerGroup
          d = -(Math.ceil(-c / h) - 1) * h
        }
        return d > 0 && (d = 0), d == c ? !1 : (O(d, 'prev'), !0)
      }),
      (e.swipeReset = function () {
        e.callPlugins('onSwipeReset')
        var d,
          a = o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y'),
          c = g * b.slidesPerGroup
        if ((-v(), 'auto' == b.slidesPerView)) {
          d = 0
          for (var h = 0; e.snapGrid.length > h; h++) {
            if (-a === e.snapGrid[h]) return
            if (-a >= e.snapGrid[h] && e.snapGrid[h + 1] > -a) {
              d = e.positions.diff > 0 ? -e.snapGrid[h + 1] : -e.snapGrid[h]
              break
            }
          }
          ;-a >= e.snapGrid[e.snapGrid.length - 1] && (d = -e.snapGrid[e.snapGrid.length - 1]), -v() >= a && (d = -v())
        } else d = 0 > a ? Math.round(a / c) * c : 0
        return (
          b.scrollContainer && (d = 0 > a ? a : 0),
          -v() > d && (d = -v()),
          b.scrollContainer && k > g && (d = 0),
          d == a ? !1 : (O(d, 'reset'), !0)
        )
      }),
      (e.swipeTo = function (a, c, d) {
        ;(a = parseInt(a, 10)), e.callPlugins('onSwipeTo', { index: a, speed: c }), b.loop && (a += e.loopedSlides)
        var f = o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y')
        if (!(a > e.slides.length - 1 || 0 > a)) {
          var h
          return (
            (h = 'auto' == b.slidesPerView ? -e.slidesGrid[a] : -a * g),
            -v() > h && (h = -v()),
            h == f ? !1 : ((d = d === !1 ? !1 : !0), O(h, 'to', { index: a, speed: c, runCallbacks: d }), !0)
          )
        }
      }),
      (e._queueStartCallbacks = !1),
      (e._queueEndCallbacks = !1),
      (e.updateActiveSlide = function (a) {
        if (e.initialized && 0 != e.slides.length) {
          if (
            ((e.previousIndex = e.activeIndex),
            a > 0 && (a = 0),
            a === void 0 && (a = o ? e.getWrapperTranslate('x') : e.getWrapperTranslate('y')),
            'auto' == b.slidesPerView)
          ) {
            if (((e.activeIndex = e.slidesGrid.indexOf(-a)), 0 > e.activeIndex)) {
              for (var d = 0; e.slidesGrid.length - 1 > d && !(-a > e.slidesGrid[d] && e.slidesGrid[d + 1] > -a); d++);
              var f = Math.abs(e.slidesGrid[d] + a),
                h = Math.abs(e.slidesGrid[d + 1] + a)
              e.activeIndex = h >= f ? d : d + 1
            }
          } else e.activeIndex = b.visibilityFullFit ? Math.ceil(-a / g) : Math.round(-a / g)
          if (
            (e.activeIndex == e.slides.length && (e.activeIndex = e.slides.length - 1),
            0 > e.activeIndex && (e.activeIndex = 0),
            e.slides[e.activeIndex])
          ) {
            e.calcVisibleSlides(a)
            for (
              var i = RegExp('\\s*' + b.slideActiveClass), j = RegExp('\\s*' + b.slideVisibleClass), d = 0;
              e.slides.length > d;
              d++
            )
              (e.slides[d].className = e.slides[d].className.replace(i, '').replace(j, '')),
                e.visibleSlides.indexOf(e.slides[d]) >= 0 && (e.slides[d].className += ' ' + b.slideVisibleClass)
            if (((e.slides[e.activeIndex].className += ' ' + b.slideActiveClass), b.loop)) {
              var k = e.loopedSlides
              ;(e.activeLoopIndex = e.activeIndex - k),
                e.activeLoopIndex >= e.slides.length - 2 * k &&
                  (e.activeLoopIndex = e.slides.length - 2 * k - e.activeLoopIndex),
                0 > e.activeLoopIndex && (e.activeLoopIndex = e.slides.length - 2 * k + e.activeLoopIndex)
            } else e.activeLoopIndex = e.activeIndex
            b.pagination && e.updatePagination(a)
          }
        }
      }),
      (e.createPagination = function (a) {
        b.paginationClickable && e.paginationButtons && Q()
        var c = '',
          f = e.slides.length,
          g = f
        b.loop && (g -= 2 * e.loopedSlides)
        for (var h = 0; g > h; h++)
          c += '<' + b.paginationElement + ' class="' + b.paginationElementClass + '"></' + b.paginationElement + '>'
        ;(e.paginationContainer = b.pagination.nodeType ? b.pagination : d(b.pagination)[0]),
          (e.paginationContainer.innerHTML = c),
          (e.paginationButtons = []),
          document.querySelectorAll
            ? (e.paginationButtons = e.paginationContainer.querySelectorAll('.' + b.paginationElementClass))
            : window.jQuery && (e.paginationButtons = d(e.paginationContainer).find('.' + b.paginationElementClass)),
          a || e.updatePagination(),
          e.callPlugins('onCreatePagination'),
          b.paginationClickable && R()
      }),
      (e.updatePagination = function (a) {
        if (!(1 > e.slides.length)) {
          if (document.querySelectorAll) var c = e.paginationContainer.querySelectorAll('.' + b.paginationActiveClass)
          else if (window.jQuery) var c = d(e.paginationContainer).find('.' + b.paginationActiveClass)
          if (c) {
            for (var f = e.paginationButtons, g = 0; f.length > g; g++) f[g].className = b.paginationElementClass
            var h = b.loop ? e.loopedSlides : 0
            if (b.paginationAsRange) {
              e.visibleSlides || e.calcVisibleSlides(a)
              for (var i = [], g = 0; e.visibleSlides.length > g; g++) {
                var j = e.slides.indexOf(e.visibleSlides[g]) - h
                b.loop && 0 > j && (j = e.slides.length - 2 * e.loopedSlides + j),
                  b.loop &&
                    j >= e.slides.length - 2 * e.loopedSlides &&
                    ((j = e.slides.length - 2 * e.loopedSlides - j), (j = Math.abs(j))),
                  i.push(j)
              }
              for (g = 0; i.length > g; g++) f[i[g]] && (f[i[g]].className += ' ' + b.paginationVisibleClass)
              b.loop
                ? (f[e.activeLoopIndex].className += ' ' + b.paginationActiveClass)
                : (f[e.activeIndex].className += ' ' + b.paginationActiveClass)
            } else
              b.loop
                ? (f[e.activeLoopIndex].className += ' ' + b.paginationActiveClass + ' ' + b.paginationVisibleClass)
                : (f[e.activeIndex].className += ' ' + b.paginationActiveClass + ' ' + b.paginationVisibleClass)
          }
        }
      }),
      (e.calcVisibleSlides = function (a) {
        var c = [],
          d = 0,
          f = 0,
          h = 0
        o && e.wrapperLeft > 0 && (a += e.wrapperLeft), !o && e.wrapperTop > 0 && (a += e.wrapperTop)
        for (var i = 0; e.slides.length > i; i++) {
          ;(d += f),
            (f = 'auto' == b.slidesPerView ? (o ? e.h.getWidth(e.slides[i], !0) : e.h.getHeight(e.slides[i], !0)) : g),
            (h = d + f)
          var j = !1
          b.visibilityFullFit
            ? (d >= -a && -a + k >= h && (j = !0), -a >= d && h >= -a + k && (j = !0))
            : (h > -a && -a + k >= h && (j = !0), d >= -a && -a + k > d && (j = !0), -a > d && h > -a + k && (j = !0)),
            j && c.push(e.slides[i])
        }
        0 == c.length && (c = [e.slides[e.activeIndex]]), (e.visibleSlides = c)
      })
    var T = void 0
    ;(e.startAutoplay = function () {
      return T !== void 0
        ? !1
        : (b.autoplay &&
            !b.loop &&
            (T = setInterval(function () {
              e.swipeNext(!0) || e.swipeTo(0)
            }, b.autoplay)),
          b.autoplay &&
            b.loop &&
            (autoPlay = setInterval(function () {
              e.swipeNext()
            }, b.autoplay)),
          e.callPlugins('onAutoplayStart'),
          void 0)
    }),
      (e.stopAutoplay = function () {
        T && clearInterval(T), (T = void 0), e.callPlugins('onAutoplayStop')
      }),
      (e.loopCreated = !1),
      (e.removeLoopedSlides = function () {
        if (e.loopCreated)
          for (var a = 0; e.slides.length > a; a++)
            e.slides[a].getData('looped') === !0 && e.wrapper.removeChild(e.slides[a])
      }),
      (e.createLoop = function () {
        if (0 != e.slides.length) {
          e.loopedSlides = b.slidesPerView + b.loopAdditionalSlides
          for (var a = '', c = '', d = 0; e.loopedSlides > d; d++) a += e.slides[d].outerHTML
          for (d = e.slides.length - e.loopedSlides; e.slides.length > d; d++) c += e.slides[d].outerHTML
          for (f.innerHTML = c + f.innerHTML + a, e.loopCreated = !0, e.calcSlides(), d = 0; e.slides.length > d; d++)
            (e.loopedSlides > d || d >= e.slides.length - e.loopedSlides) && e.slides[d].setData('looped', !0)
          e.callPlugins('onCreateLoop')
        }
      }),
      (e.fixLoop = function () {
        if (e.activeIndex < e.loopedSlides) {
          var a = e.slides.length - 3 * e.loopedSlides + e.activeIndex
          e.swipeTo(a, 0, !1)
        } else if (e.activeIndex > e.slides.length - 2 * b.slidesPerView) {
          var a = -e.slides.length + e.activeIndex + e.loopedSlides
          e.swipeTo(a, 0, !1)
        }
      }),
      (e.loadSlides = function () {
        var a = ''
        e.activeLoaderIndex = 0
        for (
          var c = b.loader.slides,
            d = b.loader.loadAllSlides ? c.length : b.slidesPerView * (1 + b.loader.surroundGroups),
            f = 0;
          d > f;
          f++
        )
          a +=
            'outer' == b.loader.slidesHTMLType
              ? c[f]
              : '<' +
                b.slideElement +
                ' class="' +
                b.slideClass +
                '" data-swiperindex="' +
                f +
                '">' +
                c[f] +
                '</' +
                b.slideElement +
                '>'
        ;(e.wrapper.innerHTML = a),
          e.calcSlides(!0),
          b.loader.loadAllSlides || e.wrapperTransitionEnd(e.reloadSlides, !0)
      }),
      (e.reloadSlides = function () {
        var a = b.loader.slides,
          c = parseInt(e.activeSlide().data('swiperindex'), 10)
        if (!(0 > c || c > a.length - 1)) {
          e.activeLoaderIndex = c
          var d = Math.max(0, c - b.slidesPerView * b.loader.surroundGroups),
            f = Math.min(c + b.slidesPerView * (1 + b.loader.surroundGroups) - 1, a.length - 1)
          if (c > 0) {
            var h = -g * (c - d)
            o ? e.setWrapperTranslate(h, 0, 0) : e.setWrapperTranslate(0, h, 0), e.setWrapperTransition(0)
          }
          if ('reload' === b.loader.logic) {
            e.wrapper.innerHTML = ''
            for (var i = '', j = d; f >= j; j++)
              i +=
                'outer' == b.loader.slidesHTMLType
                  ? a[j]
                  : '<' +
                    b.slideElement +
                    ' class="' +
                    b.slideClass +
                    '" data-swiperindex="' +
                    j +
                    '">' +
                    a[j] +
                    '</' +
                    b.slideElement +
                    '>'
            e.wrapper.innerHTML = i
          } else {
            for (var k = 1e3, l = 0, j = 0; e.slides.length > j; j++) {
              var m = e.slides[j].data('swiperindex')
              d > m || m > f ? e.wrapper.removeChild(e.slides[j]) : ((k = Math.min(m, k)), (l = Math.max(m, l)))
            }
            for (var j = d; f >= j; j++) {
              if (k > j) {
                var n = document.createElement(b.slideElement)
                ;(n.className = b.slideClass),
                  n.setAttribute('data-swiperindex', j),
                  (n.innerHTML = a[j]),
                  e.wrapper.insertBefore(n, e.wrapper.firstChild)
              }
              if (j > l) {
                var n = document.createElement(b.slideElement)
                ;(n.className = b.slideClass),
                  n.setAttribute('data-swiperindex', j),
                  (n.innerHTML = a[j]),
                  e.wrapper.appendChild(n)
              }
            }
          }
          e.reInit(!0)
        }
      }),
      U()
  }
}
;(Swiper.prototype = {
  plugins: {},
  wrapperTransitionEnd: function (a, b) {
    function f() {
      if ((a(c), c.params.queueEndCallbacks && (c._queueEndCallbacks = !1), !b))
        for (var g = 0; e.length > g; g++) d.removeEventListener(e[g], f, !1)
    }
    var c = this,
      d = c.wrapper,
      e = ['webkitTransitionEnd', 'transitionend', 'oTransitionEnd', 'MSTransitionEnd', 'msTransitionEnd']
    if (a) for (var g = 0; e.length > g; g++) d.addEventListener(e[g], f, !1)
  },
  getWrapperTranslate: function (a) {
    var c,
      d,
      b = this.wrapper
    if (window.WebKitCSSMatrix) {
      var e = new WebKitCSSMatrix(window.getComputedStyle(b, null).webkitTransform)
      c = ('' + e).split(',')
    } else {
      var e =
        window.getComputedStyle(b, null).MozTransform ||
        window.getComputedStyle(b, null).OTransform ||
        window.getComputedStyle(b, null).MsTransform ||
        window.getComputedStyle(b, null).msTransform ||
        window.getComputedStyle(b, null).transform ||
        window.getComputedStyle(b, null).getPropertyValue('transform').replace('translate(', 'matrix(1, 0, 0, 1,')
      c = ('' + e).split(',')
    }
    return (
      this.params.useCSS3Transforms
        ? ('x' == a && (d = 16 == c.length ? parseFloat(c[12]) : window.WebKitCSSMatrix ? e.m41 : parseFloat(c[4])),
          'y' == a && (d = 16 == c.length ? parseFloat(c[13]) : window.WebKitCSSMatrix ? e.m42 : parseFloat(c[5])))
        : ('x' == a && (d = parseFloat(b.style.left, 10) || 0), 'y' == a && (d = parseFloat(b.style.top, 10) || 0)),
      d || 0
    )
  },
  setWrapperTranslate: function (a, b, c) {
    var d = this.wrapper.style
    ;(a = a || 0),
      (b = b || 0),
      (c = c || 0),
      this.params.useCSS3Transforms
        ? this.support.transforms3d
          ? (d.webkitTransform = d.MsTransform = d.msTransform = d.MozTransform = d.OTransform = d.transform =
              'translate3d(' + a + 'px, ' + b + 'px, ' + c + 'px)')
          : ((d.webkitTransform = d.MsTransform = d.msTransform = d.MozTransform = d.OTransform = d.transform =
              'translate(' + a + 'px, ' + b + 'px)'),
            this.support.transforms || ((d.left = a + 'px'), (d.top = b + 'px')))
        : ((d.left = a + 'px'), (d.top = b + 'px')),
      this.callPlugins('onSetWrapperTransform', { x: a, y: b, z: c })
  },
  setWrapperTransition: function (a) {
    var b = this.wrapper.style
    ;(b.webkitTransitionDuration = b.MsTransitionDuration = b.msTransitionDuration = b.MozTransitionDuration = b.OTransitionDuration = b.transitionDuration =
      a / 1e3 + 's'),
      this.callPlugins('onSetWrapperTransition', { duration: a })
  },
  h: {
    getWidth: function (a, b) {
      var c = window.getComputedStyle(a, null).getPropertyValue('width'),
        d = parseFloat(c)
      return (
        (isNaN(d) || c.indexOf('%') > 0) &&
          (d =
            a.offsetWidth -
            parseFloat(window.getComputedStyle(a, null).getPropertyValue('padding-left')) -
            parseFloat(window.getComputedStyle(a, null).getPropertyValue('padding-right'))),
        b &&
          (d +=
            parseFloat(window.getComputedStyle(a, null).getPropertyValue('padding-left')) +
            parseFloat(window.getComputedStyle(a, null).getPropertyValue('padding-right'))),
        d
      )
    },
    getHeight: function (a, b) {
      if (b) return a.offsetHeight
      var c = window.getComputedStyle(a, null).getPropertyValue('height'),
        d = parseFloat(c)
      return (
        (isNaN(d) || c.indexOf('%') > 0) &&
          (d =
            a.offsetHeight -
            parseFloat(window.getComputedStyle(a, null).getPropertyValue('padding-top')) -
            parseFloat(window.getComputedStyle(a, null).getPropertyValue('padding-bottom'))),
        b &&
          (d +=
            parseFloat(window.getComputedStyle(a, null).getPropertyValue('padding-top')) +
            parseFloat(window.getComputedStyle(a, null).getPropertyValue('padding-bottom'))),
        d
      )
    },
    getOffset: function (a) {
      var b = a.getBoundingClientRect(),
        c = document.body,
        d = a.clientTop || c.clientTop || 0,
        e = a.clientLeft || c.clientLeft || 0,
        f = window.pageYOffset || a.scrollTop,
        g = window.pageXOffset || a.scrollLeft
      return (
        document.documentElement &&
          !window.pageYOffset &&
          ((f = document.documentElement.scrollTop), (g = document.documentElement.scrollLeft)),
        { top: b.top + f - d, left: b.left + g - e }
      )
    },
    windowWidth: function () {
      return window.innerWidth
        ? window.innerWidth
        : document.documentElement && document.documentElement.clientWidth
        ? document.documentElement.clientWidth
        : void 0
    },
    windowHeight: function () {
      return window.innerHeight
        ? window.innerHeight
        : document.documentElement && document.documentElement.clientHeight
        ? document.documentElement.clientHeight
        : void 0
    },
    windowScroll: function () {
      return 'undefined' != typeof pageYOffset
        ? { left: window.pageXOffset, top: window.pageYOffset }
        : document.documentElement
        ? { left: document.documentElement.scrollLeft, top: document.documentElement.scrollTop }
        : void 0
    },
    addEventListener: function (a, b, c, d) {
      a.addEventListener ? a.addEventListener(b, c, d) : a.attachEvent && a.attachEvent('on' + b, c)
    },
    removeEventListener: function (a, b, c, d) {
      a.removeEventListener ? a.removeEventListener(b, c, d) : a.detachEvent && a.detachEvent('on' + b, c)
    },
  },
  setTransform: function (a, b) {
    var c = a.style
    c.webkitTransform = c.MsTransform = c.msTransform = c.MozTransform = c.OTransform = c.transform = b
  },
  setTranslate: function (a, b) {
    var c = a.style,
      d = { x: b.x || 0, y: b.y || 0, z: b.z || 0 },
      e = this.support.transforms3d
        ? 'translate3d(' + d.x + 'px,' + d.y + 'px,' + d.z + 'px)'
        : 'translate(' + d.x + 'px,' + d.y + 'px)'
    ;(c.webkitTransform = c.MsTransform = c.msTransform = c.MozTransform = c.OTransform = c.transform = e),
      this.support.transforms || ((c.left = d.x + 'px'), (c.top = d.y + 'px'))
  },
  setTransition: function (a, b) {
    var c = a.style
    c.webkitTransitionDuration = c.MsTransitionDuration = c.msTransitionDuration = c.MozTransitionDuration = c.OTransitionDuration = c.transitionDuration =
      b + 'ms'
  },
  support: {
    touch:
      (window.Modernizr && Modernizr.touch === !0) ||
      (function () {
        return !!('ontouchstart' in window || (window.DocumentTouch && document instanceof DocumentTouch))
      })(),
    transforms3d:
      (window.Modernizr && Modernizr.csstransforms3d === !0) ||
      (function () {
        var a = document.createElement('div')
        return (
          'webkitPerspective' in a.style ||
          'MozPerspective' in a.style ||
          'OPerspective' in a.style ||
          'MsPerspective' in a.style ||
          'perspective' in a.style
        )
      })(),
    transforms:
      (window.Modernizr && Modernizr.csstransforms === !0) ||
      (function () {
        var a = document.createElement('div').style
        return (
          'transform' in a ||
          'WebkitTransform' in a ||
          'MozTransform' in a ||
          'msTransform' in a ||
          'MsTransform' in a ||
          'OTransform' in a
        )
      })(),
    transitions:
      (window.Modernizr && Modernizr.csstransitions === !0) ||
      (function () {
        var a = document.createElement('div').style
        return (
          'transition' in a ||
          'WebkitTransition' in a ||
          'MozTransition' in a ||
          'msTransition' in a ||
          'MsTransition' in a ||
          'OTransition' in a
        )
      })(),
  },
  browser: {
    ie8: (function () {
      var a = -1
      if ('Microsoft Internet Explorer' == navigator.appName) {
        var b = navigator.userAgent,
          c = RegExp('MSIE ([0-9]{1,}[.0-9]{0,})')
        null != c.exec(b) && (a = parseFloat(RegExp.$1))
      }
      return -1 != a && 9 > a
    })(),
    ie10: window.navigator.msPointerEnabled,
  },
}),
  (window.jQuery || window.Zepto) &&
    (function (a) {
      a.fn.swiper = function (b) {
        var c = new Swiper(a(this)[0], b)
        return a(this).data('swiper', c), c
      }
    })(window.jQuery || window.Zepto)
Swiper.prototype.plugins.tdFlow = function (swiper, params) {
  if (!swiper.support.transforms3d) return
  var slides, wrapperSize, slideSize, initialized
  var isH = swiper.params.mode == 'horizontal'
  if (!params) return
  var defaults = { rotate: 50, stretch: 0, depth: 100, modifier: 1, shadows: true }
  params = params || {}
  for (var prop in defaults) {
    if (!(prop in params)) {
      params[prop] = defaults[prop]
    }
  }
  function init() {
    initialized = true
    slides = swiper.slides
    for (var i = 0; i < slides.length; i++) {
      swiper.setTransition(slides[i], 0)
    }
    if (isH) {
      wrapperSize = swiper.h.getWidth(swiper.wrapper)
      slideSize = wrapperSize / slides.length
      for (var i = 0; i < slides.length; i++) {
        slides[i].swiperSlideOffset = slides[i].offsetLeft
      }
    } else {
      wrapperSize = swiper.h.getHeight(swiper.wrapper)
      slideSize = wrapperSize / slides.length
      for (var i = 0; i < slides.length; i++) {
        slides[i].swiperSlideOffset = slides[i].offsetTop
      }
    }
  }
  function threeDSlides(transform) {
    if (!initialized) return
    var transform = transform || { x: 0, y: 0, z: 0 }
    var center = isH ? -transform.x + swiper.width / 2 : -transform.y + swiper.height / 2
    var rotate = isH ? params.rotate : -params.rotate
    var translate = params.depth
    for (var i = 0; i < swiper.slides.length; i++) {
      var slideOffset = swiper.slides[i].swiperSlideOffset
      var offsetMultiplier = ((center - slideOffset - slideSize / 2) / slideSize) * params.modifier
      var rotateY = isH ? rotate * offsetMultiplier : 0
      var rotateX = isH ? 0 : rotate * offsetMultiplier
      var translateZ = -translate * Math.abs(offsetMultiplier)
      var translateY = isH ? 0 : params.stretch * offsetMultiplier
      var translateX = isH ? params.stretch * offsetMultiplier : 0
      if (Math.abs(translateX) < 0.001) translateX = 0
      if (Math.abs(translateY) < 0.001) translateY = 0
      if (Math.abs(translateZ) < 0.001) translateZ = 0
      if (Math.abs(rotateY) < 0.001) rotateY = 0
      if (Math.abs(rotateX) < 0.001) rotateX = 0
      var slideTransform =
        'translate3d(' +
        translateX +
        'px,' +
        translateY +
        'px,' +
        translateZ +
        'px)  rotateX(' +
        rotateX +
        'deg) rotateY(' +
        rotateY +
        'deg)'
      swiper.setTransform(swiper.slides[i], slideTransform)
      swiper.slides[i].style.zIndex = -Math.abs(Math.round(offsetMultiplier)) + 1
      if (params.shadows) {
        var shadowBefore = isH
          ? swiper.slides[i].querySelector('.swiper-slide-shadow-left')
          : swiper.slides[i].querySelector('.swiper-slide-shadow-top')
        var shadowAfter = isH
          ? swiper.slides[i].querySelector('.swiper-slide-shadow-right')
          : swiper.slides[i].querySelector('.swiper-slide-shadow-bottom')
        shadowAfter.style.opacity = -offsetMultiplier > 0 ? -offsetMultiplier : 0
        shadowBefore.style.opacity = offsetMultiplier > 0 ? offsetMultiplier : 0
      }
    }
    if (swiper.ie10) {
      var ws = swiper.wrapper.style
      ws.perspectiveOrigin = center + 'px 50%'
    }
  }
  var hooks = {
    onFirstInit: function (args) {
      slides = swiper.slides
      if (params.shadows) {
        var shadowEl1 = document.createElement('div')
        var shadowEl2 = document.createElement('div')
        shadowEl1.className = isH ? 'swiper-slide-shadow-left' : 'swiper-slide-shadow-top'
        shadowEl2.className = isH ? 'swiper-slide-shadow-right' : 'swiper-slide-shadow-bottom'
        for (var i = 0; i < slides.length; i++) {
          slides[i].appendChild(shadowEl1.cloneNode())
          slides[i].appendChild(shadowEl2.cloneNode())
        }
      }
      init()
      threeDSlides({
        x: swiper.getWrapperTranslate('x'),
        y: swiper.getWrapperTranslate('y'),
        z: swiper.getWrapperTranslate('z'),
      })
    },
    onInit: function (args) {
      init()
      threeDSlides({
        x: swiper.getWrapperTranslate('x'),
        y: swiper.getWrapperTranslate('y'),
        z: swiper.getWrapperTranslate('z'),
      })
    },
    onSetWrapperTransform: function (transform) {
      threeDSlides(transform)
    },
    onSetWrapperTransition: function (args) {
      for (var i = 0; i < swiper.slides.length; i++) {
        swiper.setTransition(swiper.slides[i], args.duration)
        if (isH && params.shadows) {
          swiper.setTransition(swiper.slides[i].querySelector('.swiper-slide-shadow-left'), args.duration)
          swiper.setTransition(swiper.slides[i].querySelector('.swiper-slide-shadow-right'), args.duration)
        } else if (params.shadows) {
          swiper.setTransition(swiper.slides[i].querySelector('.swiper-slide-shadow-top'), args.duration)
          swiper.setTransition(swiper.slides[i].querySelector('.swiper-slide-shadow-bottom'), args.duration)
        }
      }
    },
  }
  return hooks
}
;(function (t, e, i) {
  function o(i, o, n) {
    var r = e.createElement(i)
    return o && (r.id = te + o), n && (r.style.cssText = n), t(r)
  }
  function n() {
    return i.innerHeight ? i.innerHeight : t(i).height()
  }
  function r(t) {
    var e = H.length,
      i = (j + t) % e
    return 0 > i ? e + i : i
  }
  function h(t, e) {
    return Math.round((/%/.test(t) ? ('x' === e ? E.width() : n()) / 100 : 1) * parseInt(t, 10))
  }
  function l(t, e) {
    return t.photo || t.photoRegex.test(e)
  }
  function s(t, e) {
    return t.retinaUrl && i.devicePixelRatio > 1 ? e.replace(t.photoRegex, t.retinaSuffix) : e
  }
  function a(t) {
    'contains' in x[0] && !x[0].contains(t.target) && (t.stopPropagation(), x.focus())
  }
  function d() {
    var e,
      i = t.data(A, Z)
    null == i
      ? ((_ = t.extend({}, Y)), console && console.log && console.log('Error: cboxElement missing settings object'))
      : (_ = t.extend({}, i))
    for (e in _) t.isFunction(_[e]) && 'on' !== e.slice(0, 2) && (_[e] = _[e].call(A))
    ;(_.rel = _.rel || A.rel || t(A).data('rel') || 'nofollow'),
      (_.href = _.href || t(A).attr('href')),
      (_.title = _.title || A.title),
      'string' == typeof _.href && (_.href = t.trim(_.href))
  }
  function c(i, o) {
    t(e).trigger(i), se.trigger(i), t.isFunction(o) && o.call(A)
  }
  function u() {
    var t,
      e,
      i,
      o,
      n,
      r = te + 'Slideshow_',
      h = 'click.' + te
    _.slideshow && H[1]
      ? ((e = function () {
          clearTimeout(t)
        }),
        (i = function () {
          ;(_.loop || H[j + 1]) && (t = setTimeout(J.next, _.slideshowSpeed))
        }),
        (o = function () {
          M.html(_.slideshowStop).unbind(h).one(h, n),
            se.bind(ne, i).bind(oe, e).bind(re, n),
            x.removeClass(r + 'off').addClass(r + 'on')
        }),
        (n = function () {
          e(),
            se.unbind(ne, i).unbind(oe, e).unbind(re, n),
            M.html(_.slideshowStart)
              .unbind(h)
              .one(h, function () {
                J.next(), o()
              }),
            x.removeClass(r + 'on').addClass(r + 'off')
        }),
        _.slideshowAuto ? o() : n())
      : x.removeClass(r + 'off ' + r + 'on')
  }
  function f(i) {
    G ||
      ((A = i),
      d(),
      (H = t(A)),
      (j = 0),
      'nofollow' !== _.rel &&
        ((H = t('.' + ee).filter(function () {
          var e,
            i = t.data(this, Z)
          return i && (e = t(this).data('rel') || i.rel || this.rel), e === _.rel
        })),
        (j = H.index(A)),
        -1 === j && ((H = H.add(A)), (j = H.length - 1))),
      g
        .css({ opacity: parseFloat(_.opacity), cursor: _.overlayClose ? 'pointer' : 'auto', visibility: 'visible' })
        .show(),
      V && x.add(g).removeClass(V),
      _.className && x.add(g).addClass(_.className),
      (V = _.className),
      K.html(_.close).show(),
      $ ||
        (($ = q = !0),
        x.css({ visibility: 'hidden', display: 'block' }),
        (W = o(ae, 'LoadedContent', 'width:0; height:0; overflow:hidden').appendTo(v)),
        (D = b.height() + k.height() + v.outerHeight(!0) - v.height()),
        (B = C.width() + T.width() + v.outerWidth(!0) - v.width()),
        (N = W.outerHeight(!0)),
        (z = W.outerWidth(!0)),
        (_.w = h(_.initialWidth, 'x')),
        (_.h = h(_.initialHeight, 'y')),
        J.position(),
        u(),
        c(ie, _.onOpen),
        O.add(F).hide(),
        x.focus(),
        e.addEventListener &&
          (e.addEventListener('focus', a, !0),
          se.one(he, function () {
            e.removeEventListener('focus', a, !0)
          })),
        _.returnFocus &&
          se.one(he, function () {
            t(A).focus()
          })),
      w())
  }
  function p() {
    !x &&
      e.body &&
      ((X = !1),
      (E = t(i)),
      (x = o(ae)
        .attr({ id: Z, class: t.support.opacity === !1 ? te + 'IE' : '', role: 'dialog', tabindex: '-1' })
        .hide()),
      (g = o(ae, 'Overlay').hide()),
      (S = o(ae, 'LoadingOverlay').add(o(ae, 'LoadingGraphic'))),
      (y = o(ae, 'Wrapper')),
      (v = o(ae, 'Content').append(
        (F = o(ae, 'Title')),
        (I = o(ae, 'Current')),
        (P = t('<button type="button"/>').attr({ id: te + 'Previous' })),
        (R = t('<button type="button"/>').attr({ id: te + 'Next' })),
        (M = o('button', 'Slideshow')),
        S,
        (K = t('<button type="button"/>').attr({ id: te + 'Close' }))
      )),
      y
        .append(
          o(ae).append(o(ae, 'TopLeft'), (b = o(ae, 'TopCenter')), o(ae, 'TopRight')),
          o(ae, !1, 'clear:left').append((C = o(ae, 'MiddleLeft')), v, (T = o(ae, 'MiddleRight'))),
          o(ae, !1, 'clear:left').append(o(ae, 'BottomLeft'), (k = o(ae, 'BottomCenter')), o(ae, 'BottomRight'))
        )
        .find('div div')
        .css({ float: 'left' }),
      (L = o(ae, !1, 'position:absolute; width:9999px; visibility:hidden; display:none')),
      (O = R.add(P).add(I).add(M)),
      t(e.body).append(g, x.append(y, L)))
  }
  function m() {
    function i(t) {
      t.which > 1 || t.shiftKey || t.altKey || t.metaKey || t.control || (t.preventDefault(), f(this))
    }
    return x
      ? (X ||
          ((X = !0),
          R.click(function () {
            J.next()
          }),
          P.click(function () {
            J.prev()
          }),
          K.click(function () {
            J.close()
          }),
          g.click(function () {
            _.overlayClose && J.close()
          }),
          t(e).bind('keydown.' + te, function (t) {
            var e = t.keyCode
            $ && _.escKey && 27 === e && (t.preventDefault(), J.close()),
              $ &&
                _.arrowKey &&
                H[1] &&
                !t.altKey &&
                (37 === e ? (t.preventDefault(), P.click()) : 39 === e && (t.preventDefault(), R.click()))
          }),
          t.isFunction(t.fn.on) ? t(e).on('click.' + te, '.' + ee, i) : t('.' + ee).live('click.' + te, i)),
        !0)
      : !1
  }
  function w() {
    var e,
      n,
      r,
      a = J.prep,
      u = ++de
    ;(q = !0),
      (U = !1),
      (A = H[j]),
      d(),
      c(le),
      c(oe, _.onLoad),
      (_.h = _.height ? h(_.height, 'y') - N - D : _.innerHeight && h(_.innerHeight, 'y')),
      (_.w = _.width ? h(_.width, 'x') - z - B : _.innerWidth && h(_.innerWidth, 'x')),
      (_.mw = _.w),
      (_.mh = _.h),
      _.maxWidth && ((_.mw = h(_.maxWidth, 'x') - z - B), (_.mw = _.w && _.w < _.mw ? _.w : _.mw)),
      _.maxHeight && ((_.mh = h(_.maxHeight, 'y') - N - D), (_.mh = _.h && _.h < _.mh ? _.h : _.mh)),
      (e = _.href),
      (Q = setTimeout(function () {
        S.show()
      }, 100)),
      _.inline
        ? ((r = o(ae).hide().insertBefore(t(e)[0])),
          se.one(le, function () {
            r.replaceWith(W.children())
          }),
          a(t(e)))
        : _.iframe
        ? a(' ')
        : _.html
        ? a(_.html)
        : l(_, e)
        ? ((e = s(_, e)),
          t((U = new Image()))
            .addClass(te + 'Photo')
            .bind('error', function () {
              ;(_.title = !1), a(o(ae, 'Error').html(_.imgError))
            })
            .one('load', function () {
              var e
              u === de &&
                ((U.alt = t(A).attr('alt') || t(A).attr('data-alt') || ''),
                _.retinaImage &&
                  i.devicePixelRatio > 1 &&
                  ((U.height = U.height / i.devicePixelRatio), (U.width = U.width / i.devicePixelRatio)),
                _.scalePhotos &&
                  ((n = function () {
                    ;(U.height -= U.height * e), (U.width -= U.width * e)
                  }),
                  _.mw && U.width > _.mw && ((e = (U.width - _.mw) / U.width), n()),
                  _.mh && U.height > _.mh && ((e = (U.height - _.mh) / U.height), n())),
                _.h && (U.style.marginTop = Math.max(_.mh - U.height, 0) / 2 + 'px'),
                H[1] &&
                  (_.loop || H[j + 1]) &&
                  ((U.style.cursor = 'pointer'),
                  (U.onclick = function () {
                    J.next()
                  })),
                (U.style.width = U.width + 'px'),
                (U.style.height = U.height + 'px'),
                setTimeout(function () {
                  a(U)
                }, 1))
            }),
          setTimeout(function () {
            U.src = e
          }, 1))
        : e &&
          L.load(e, _.data, function (e, i) {
            u === de && a('error' === i ? o(ae, 'Error').html(_.xhrError) : t(this).contents())
          })
  }
  var g,
    x,
    y,
    v,
    b,
    C,
    T,
    k,
    H,
    E,
    W,
    L,
    S,
    F,
    I,
    M,
    R,
    P,
    K,
    O,
    _,
    D,
    B,
    N,
    z,
    A,
    j,
    U,
    $,
    q,
    G,
    Q,
    J,
    V,
    X,
    Y = {
      transition: 'elastic',
      speed: 300,
      fadeOut: 300,
      width: !1,
      initialWidth: '600',
      innerWidth: !1,
      maxWidth: !1,
      height: !1,
      initialHeight: '450',
      innerHeight: !1,
      maxHeight: !1,
      scalePhotos: !0,
      scrolling: !0,
      inline: !1,
      html: !1,
      iframe: !1,
      fastIframe: !0,
      photo: !1,
      href: !1,
      title: !1,
      rel: !1,
      opacity: 0.9,
      preloading: !0,
      className: !1,
      retinaImage: !1,
      retinaUrl: !1,
      retinaSuffix: '@2x.$1',
      current: 'image {current} of {total}',
      previous: 'previous',
      next: 'next',
      close: 'X',
      xhrError: 'This content failed to load.',
      imgError: 'This image failed to load.',
      open: !1,
      returnFocus: !0,
      reposition: !0,
      loop: !0,
      slideshow: !1,
      slideshowAuto: !0,
      slideshowSpeed: 2500,
      slideshowStart: 'start slideshow',
      slideshowStop: 'stop slideshow',
      photoRegex: /\.(gif|png|jp(e|g|eg)|bmp|ico|webp)((#|\?).*)?$/i,
      onOpen: !1,
      onLoad: !1,
      onComplete: !1,
      onCleanup: !1,
      onClosed: !1,
      overlayClose: !0,
      escKey: !0,
      arrowKey: !0,
      top: !1,
      bottom: !1,
      left: !1,
      right: !1,
      fixed: !1,
      data: void 0,
    },
    Z = 'colorbox',
    te = 'cbox',
    ee = te + 'Element',
    ie = te + '_open',
    oe = te + '_load',
    ne = te + '_complete',
    re = te + '_cleanup',
    he = te + '_closed',
    le = te + '_purge',
    se = t('<a/>'),
    ae = 'div',
    de = 0
  t.colorbox ||
    (t(p),
    (J = t.fn[Z] = t[Z] = function (e, i) {
      var o = this
      if (((e = e || {}), p(), m())) {
        if (t.isFunction(o)) (o = t('<a/>')), (e.open = !0)
        else if (!o[0]) return o
        i && (e.onComplete = i),
          o
            .each(function () {
              t.data(this, Z, t.extend({}, t.data(this, Z) || Y, e))
            })
            .addClass(ee),
          ((t.isFunction(e.open) && e.open.call(o)) || e.open) && f(o[0])
      }
      return o
    }),
    (J.position = function (t, e) {
      function i(t) {
        ;(b[0].style.width = k[0].style.width = v[0].style.width = parseInt(t.style.width, 10) - B + 'px'),
          (v[0].style.height = C[0].style.height = T[0].style.height = parseInt(t.style.height, 10) - D + 'px')
      }
      var o,
        r,
        l,
        s = 0,
        a = 0,
        d = x.offset()
      E.unbind('resize.' + te),
        x.css({ top: -9e4, left: -9e4 }),
        (r = E.scrollTop()),
        (l = E.scrollLeft()),
        _.fixed
          ? ((d.top -= r), (d.left -= l), x.css({ position: 'fixed' }))
          : ((s = r), (a = l), x.css({ position: 'absolute' })),
        (a +=
          _.right !== !1
            ? Math.max(E.width() - _.w - z - B - h(_.right, 'x'), 0)
            : _.left !== !1
            ? h(_.left, 'x')
            : Math.round(Math.max(E.width() - _.w - z - B, 0) / 2)),
        (s +=
          _.bottom !== !1
            ? Math.max(n() - _.h - N - D - h(_.bottom, 'y'), 0)
            : _.top !== !1
            ? h(_.top, 'y')
            : Math.round(Math.max(n() - _.h - N - D, 0) / 2)),
        x.css({ top: d.top, left: d.left, visibility: 'visible' }),
        (t = x.width() === _.w + z && x.height() === _.h + N ? 0 : t || 0),
        (y[0].style.width = y[0].style.height = '9999px'),
        (o = { width: _.w + z + B, height: _.h + N + D, top: s, left: a }),
        0 === t && x.css(o),
        x.dequeue().animate(o, {
          duration: t,
          complete: function () {
            i(this),
              (q = !1),
              (y[0].style.width = _.w + z + B + 'px'),
              (y[0].style.height = _.h + N + D + 'px'),
              _.reposition &&
                setTimeout(function () {
                  E.bind('resize.' + te, J.position)
                }, 1),
              e && e()
          },
          step: function () {
            i(this)
          },
        })
    }),
    (J.resize = function (t) {
      $ &&
        ((t = t || {}),
        t.width && (_.w = h(t.width, 'x') - z - B),
        t.innerWidth && (_.w = h(t.innerWidth, 'x')),
        W.css({ width: _.w }),
        t.height && (_.h = h(t.height, 'y') - N - D),
        t.innerHeight && (_.h = h(t.innerHeight, 'y')),
        t.innerHeight || t.height || (W.css({ height: 'auto' }), (_.h = W.height())),
        W.css({ height: _.h }),
        J.position('none' === _.transition ? 0 : _.speed))
    }),
    (J.prep = function (e) {
      function i() {
        return (_.w = _.w || W.width()), (_.w = _.mw && _.mw < _.w ? _.mw : _.w), _.w
      }
      function n() {
        return (_.h = _.h || W.height()), (_.h = _.mh && _.mh < _.h ? _.mh : _.h), _.h
      }
      if ($) {
        var h,
          a = 'none' === _.transition ? 0 : _.speed
        W.empty().remove(),
          (W = o(ae, 'LoadedContent').append(e)),
          W.hide()
            .appendTo(L.show())
            .css({ width: i(), overflow: _.scrolling ? 'auto' : 'hidden' })
            .css({ height: n() })
            .prependTo(v),
          L.hide(),
          t(U).css({ float: 'none' }),
          (h = function () {
            function e() {
              t.support.opacity === !1 && x[0].style.removeAttribute('filter')
            }
            var i,
              n,
              h = H.length,
              d = 'frameBorder',
              u = 'allowTransparency'
            $ &&
              ((n = function () {
                clearTimeout(Q), S.hide(), c(ne, _.onComplete)
              }),
              F.html(_.title).add(W).show(),
              h > 1
                ? ('string' == typeof _.current &&
                    I.html(_.current.replace('{current}', j + 1).replace('{total}', h)).show(),
                  R[_.loop || h - 1 > j ? 'show' : 'hide']().html(_.next),
                  P[_.loop || j ? 'show' : 'hide']().html(_.previous),
                  _.slideshow && M.show(),
                  _.preloading &&
                    t.each([r(-1), r(1)], function () {
                      var e,
                        i,
                        o = H[this],
                        n = t.data(o, Z)
                      n && n.href ? ((e = n.href), t.isFunction(e) && (e = e.call(o))) : (e = t(o).attr('href')),
                        e && l(n, e) && ((e = s(n, e)), (i = new Image()), (i.src = e))
                    }))
                : O.hide(),
              _.iframe
                ? ((i = o('iframe')[0]),
                  d in i && (i[d] = 0),
                  u in i && (i[u] = 'true'),
                  _.scrolling || (i.scrolling = 'no'),
                  t(i)
                    .attr({
                      src: _.href,
                      name: new Date().getTime(),
                      class: te + 'Iframe',
                      allowFullScreen: !0,
                      webkitAllowFullScreen: !0,
                      mozallowfullscreen: !0,
                    })
                    .one('load', n)
                    .appendTo(W),
                  se.one(le, function () {
                    i.src = '//about:blank'
                  }),
                  _.fastIframe && t(i).trigger('load'))
                : n(),
              'fade' === _.transition ? x.fadeTo(a, 1, e) : e())
          }),
          'fade' === _.transition
            ? x.fadeTo(a, 0, function () {
                J.position(0, h)
              })
            : J.position(a, h)
      }
    }),
    (J.next = function () {
      !q && H[1] && (_.loop || H[j + 1]) && ((j = r(1)), f(H[j]))
    }),
    (J.prev = function () {
      !q && H[1] && (_.loop || j) && ((j = r(-1)), f(H[j]))
    }),
    (J.close = function () {
      $ &&
        !G &&
        ((G = !0),
        ($ = !1),
        c(re, _.onCleanup),
        E.unbind('.' + te),
        g.fadeTo(_.fadeOut || 0, 0),
        x.stop().fadeTo(_.fadeOut || 0, 0, function () {
          x.add(g).css({ opacity: 1, cursor: 'auto' }).hide(),
            c(le),
            W.empty().remove(),
            setTimeout(function () {
              ;(G = !1), c(he, _.onClosed)
            }, 1)
        }))
    }),
    (J.remove = function () {
      x &&
        (x.stop(),
        t.colorbox.close(),
        x.stop().remove(),
        g.remove(),
        (G = !1),
        (x = null),
        t('.' + ee)
          .removeData(Z)
          .removeClass(ee),
        t(e).unbind('click.' + te))
    }),
    (J.element = function () {
      return t(A)
    }),
    (J.settings = Y))
})(jQuery, document, window)
/* Respond.js v1.0.1pre: min/max-width media query polyfill. (c) Scott Jehl. MIT/GPLv2 Lic. j.mp/respondjs  */
;(function (e, h) {
  e.respond = {}
  respond.update = function () {}
  respond.mediaQueriesSupported = h
  if (h) {
    return
  }
  var u = e.document,
    r = u.documentElement,
    i = [],
    k = [],
    p = [],
    o = {},
    g = 30,
    f = u.getElementsByTagName('head')[0] || r,
    b = f.getElementsByTagName('link'),
    d = [],
    a = function () {
      var B = b,
        w = B.length,
        z = 0,
        y,
        x,
        A,
        v
      for (; z < w; z++) {
        ;(y = B[z]), (x = y.href), (A = y.media), (v = y.rel && y.rel.toLowerCase() === 'stylesheet')
        if (!!x && v && !o[x]) {
          if (y.styleSheet && y.styleSheet.rawCssText) {
            m(y.styleSheet.rawCssText, x, A)
            o[x] = true
          } else {
            if (!/^([a-zA-Z]+?:(\/\/)?)/.test(x) || x.replace(RegExp.$1, '').split('/')[0] === e.location.host) {
              d.push({ href: x, media: A })
            }
          }
        }
      }
      t()
    },
    t = function () {
      if (d.length) {
        var v = d.shift()
        n(v.href, function (w) {
          m(w, v.href, v.media)
          o[v.href] = true
          t()
        })
      }
    },
    m = function (G, v, x) {
      var E = G.match(/@media[^\{]+\{([^\{\}]+\{[^\}\{]+\})+/gi),
        H = (E && E.length) || 0,
        v = v.substring(0, v.lastIndexOf('/')),
        w = function (I) {
          return I.replace(/(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g, '$1' + v + '$2$3')
        },
        y = !H && x,
        B = 0,
        A,
        C,
        D,
        z,
        F
      if (v.length) {
        v += '/'
      }
      if (y) {
        H = 1
      }
      for (; B < H; B++) {
        A = 0
        if (y) {
          C = x
          k.push(w(G))
        } else {
          C = E[B].match(/@media ([^\{]+)\{([\S\s]+?)$/) && RegExp.$1
          k.push(RegExp.$2 && w(RegExp.$2))
        }
        z = C.split(',')
        F = z.length
        for (; A < F; A++) {
          D = z[A]
          i.push({
            media: D.match(/(only\s+)?([a-zA-Z]+)(\sand)?/) && RegExp.$2,
            rules: k.length - 1,
            minw: D.match(/\(min\-width:[\s]*([\s]*[0-9]+)px[\s]*\)/) && parseFloat(RegExp.$1),
            maxw: D.match(/\(max\-width:[\s]*([\s]*[0-9]+)px[\s]*\)/) && parseFloat(RegExp.$1),
          })
        }
      }
      j()
    },
    l,
    q,
    j = function (E) {
      var v = 'clientWidth',
        x = r[v],
        D = (u.compatMode === 'CSS1Compat' && x) || u.body[v] || x,
        z = {},
        C = u.createDocumentFragment(),
        B = b[b.length - 1],
        w = new Date().getTime()
      if (E && l && w - l < g) {
        clearTimeout(q)
        q = setTimeout(j, g)
        return
      } else {
        l = w
      }
      for (var y in i) {
        var F = i[y]
        if ((!F.minw && !F.maxw) || ((!F.minw || (F.minw && D >= F.minw)) && (!F.maxw || (F.maxw && D <= F.maxw)))) {
          if (!z[F.media]) {
            z[F.media] = []
          }
          z[F.media].push(k[F.rules])
        }
      }
      for (var y in p) {
        if (p[y] && p[y].parentNode === f) {
          f.removeChild(p[y])
        }
      }
      for (var y in z) {
        var G = u.createElement('style'),
          A = z[y].join('\n')
        G.type = 'text/css'
        G.media = y
        if (G.styleSheet) {
          G.styleSheet.cssText = A
        } else {
          G.appendChild(u.createTextNode(A))
        }
        C.appendChild(G)
        p.push(G)
      }
      f.insertBefore(C, B.nextSibling)
    },
    n = function (v, x) {
      var w = c()
      if (!w) {
        return
      }
      w.open('GET', v, true)
      w.onreadystatechange = function () {
        if (w.readyState != 4 || (w.status != 200 && w.status != 304)) {
          return
        }
        x(w.responseText)
      }
      if (w.readyState == 4) {
        return
      }
      w.send(null)
    },
    c = (function () {
      var v = false
      try {
        v = new XMLHttpRequest()
      } catch (w) {
        v = new ActiveXObject('Microsoft.XMLHTTP')
      }
      return function () {
        return v
      }
    })()
  a()
  respond.update = a
  function s() {
    j(true)
  }
  if (e.addEventListener) {
    e.addEventListener('resize', s, false)
  } else {
    if (e.attachEvent) {
      e.attachEvent('onresize', s)
    }
  }
})(
  this,
  (function (f) {
    if (f.matchMedia) {
      return true
    }
    var e,
      i = document,
      c = i.documentElement,
      g = c.firstElementChild || c.firstChild,
      h = !i.body,
      d = i.body || i.createElement('body'),
      b = i.createElement('div'),
      a = 'only all'
    b.id = 'mq-test-1'
    b.style.cssText = 'position:absolute;top:-99em'
    d.appendChild(b)
    b.innerHTML = '_<style media="' + a + '"> #mq-test-1 { width: 9px; }</style>'
    if (h) {
      c.insertBefore(d, g)
    }
    b.removeChild(b.firstChild)
    e = b.offsetWidth == 9
    if (h) {
      c.removeChild(d)
    } else {
      d.removeChild(b)
    }
    return e
  })(this)
)
jQuery.cookie = function (key, value, options) {
  if (arguments.length > 1 && (value === null || typeof value !== 'object')) {
    options = jQuery.extend({}, options)
    if (value === null) {
      options.expires = -1
    }
    if (typeof options.expires === 'number') {
      var days = options.expires,
        t = (options.expires = new Date())
      t.setDate(t.getDate() + days)
    }
    return (document.cookie = [
      encodeURIComponent(key),
      '=',
      options.raw ? String(value) : encodeURIComponent(String(value)),
      options.expires ? '; expires=' + options.expires.toUTCString() : '',
      options.path ? '; path=' + options.path : '',
      options.domain ? '; domain=' + options.domain : '',
      options.secure ? '; secure' : '',
    ].join(''))
  }
  options = value || {}
  var result,
    decode = options.raw
      ? function (s) {
          return s
        }
      : decodeURIComponent
  return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie))
    ? decode(result[1])
    : null
}
!(function ($) {
  var Datepicker = function (element, options) {
    this.element = $(element)
    this.format = DPGlobal.parseFormat(options.format || this.element.data('date-format') || 'mm/dd/yyyy')
    this.picker = $(DPGlobal.template)
      .appendTo('body')
      .on({ click: $.proxy(this.click, this), mousedown: $.proxy(this.mousedown, this) })
    this.isInput = this.element.is('input')
    this.component = this.element.is('.date') ? this.element.find('.add-on') : false
    if (this.isInput) {
      this.element.on({
        focus: $.proxy(this.show, this),
        blur: $.proxy(this.hide, this),
        keyup: $.proxy(this.update, this),
      })
    } else {
      if (this.component) {
        this.component.on('click', $.proxy(this.show, this))
      } else {
        this.element.on('click', $.proxy(this.show, this))
      }
    }
    this.minViewMode = options.minViewMode || this.element.data('date-minviewmode') || 0
    if (typeof this.minViewMode === 'string') {
      switch (this.minViewMode) {
        case 'months':
          this.minViewMode = 1
          break
        case 'years':
          this.minViewMode = 2
          break
        default:
          this.minViewMode = 0
          break
      }
    }
    this.viewMode = options.viewMode || this.element.data('date-viewmode') || 0
    if (typeof this.viewMode === 'string') {
      switch (this.viewMode) {
        case 'months':
          this.viewMode = 1
          break
        case 'years':
          this.viewMode = 2
          break
        default:
          this.viewMode = 0
          break
      }
    }
    this.startViewMode = this.viewMode
    this.weekStart = options.weekStart || this.element.data('date-weekstart') || 0
    this.weekEnd = this.weekStart === 0 ? 6 : this.weekStart - 1
    this.fillDow()
    this.fillMonths()
    this.update()
    this.showMode()
  }
  Datepicker.prototype = {
    constructor: Datepicker,
    show: function (e) {
      this.picker.show()
      this.height = this.component ? this.component.outerHeight() : this.element.outerHeight()
      this.place()
      $(window).on('resize', $.proxy(this.place, this))
      if (e) {
        e.stopPropagation()
        e.preventDefault()
      }
      if (!this.isInput) {
        $(document).on('mousedown', $.proxy(this.hide, this))
      }
      this.element.trigger({ type: 'show', date: this.date })
    },
    hide: function () {
      this.picker.hide()
      $(window).off('resize', this.place)
      this.viewMode = this.startViewMode
      this.showMode()
      if (!this.isInput) {
        $(document).off('mousedown', this.hide)
      }
      this.set()
      this.element.trigger({ type: 'hide', date: this.date })
    },
    set: function () {
      var formated = DPGlobal.formatDate(this.date, this.format)
      if (!this.isInput) {
        if (this.component) {
          this.element.find('input').prop('value', formated)
        }
        this.element.data('date', formated)
      } else {
        this.element.prop('value', formated)
      }
    },
    setValue: function (newDate) {
      if (typeof newDate === 'string') {
        this.date = DPGlobal.parseDate(newDate, this.format)
      } else {
        this.date = new Date(newDate)
      }
      this.set()
      this.viewDate = new Date(this.date.getFullYear(), this.date.getMonth(), 1, 0, 0, 0, 0)
      this.fill()
    },
    place: function () {
      var offset = this.component ? this.component.offset() : this.element.offset()
      this.picker.css({ top: offset.top + this.height, left: offset.left })
    },
    update: function (newDate) {
      this.date = DPGlobal.parseDate(
        typeof newDate === 'string' ? newDate : this.isInput ? this.element.prop('value') : this.element.data('date'),
        this.format
      )
      this.viewDate = new Date(this.date.getFullYear(), this.date.getMonth(), 1, 0, 0, 0, 0)
      this.fill()
    },
    fillDow: function () {
      var dowCnt = this.weekStart
      var html = '<tr>'
      while (dowCnt < this.weekStart + 7) {
        html += '<th class="dow">' + DPGlobal.dates.daysMin[dowCnt++ % 7] + '</th>'
      }
      html += '</tr>'
      this.picker.find('.datepicker-days thead').append(html)
    },
    fillMonths: function () {
      var html = ''
      var i = 0
      while (i < 12) {
        html += '<span class="month">' + DPGlobal.dates.monthsShort[i++] + '</span>'
      }
      this.picker.find('.datepicker-months td').append(html)
    },
    fill: function () {
      var d = new Date(this.viewDate),
        year = d.getFullYear(),
        month = d.getMonth(),
        currentDate = this.date.valueOf()
      this.picker.find('.datepicker-days th:eq(1)').text(DPGlobal.dates.months[month] + ' ' + year)
      var prevMonth = new Date(year, month - 1, 28, 0, 0, 0, 0),
        day = DPGlobal.getDaysInMonth(prevMonth.getFullYear(), prevMonth.getMonth())
      prevMonth.setDate(day)
      prevMonth.setDate(day - ((prevMonth.getDay() - this.weekStart + 7) % 7))
      var nextMonth = new Date(prevMonth)
      nextMonth.setDate(nextMonth.getDate() + 42)
      nextMonth = nextMonth.valueOf()
      html = []
      var clsName
      while (prevMonth.valueOf() < nextMonth) {
        if (prevMonth.getDay() === this.weekStart) {
          html.push('<tr>')
        }
        clsName = ''
        if (prevMonth.getMonth() < month) {
          clsName += ' old'
        } else if (prevMonth.getMonth() > month) {
          clsName += ' new'
        }
        if (prevMonth.valueOf() === currentDate) {
          clsName += ' active'
        }
        html.push('<td class="day' + clsName + '">' + prevMonth.getDate() + '</td>')
        if (prevMonth.getDay() === this.weekEnd) {
          html.push('</tr>')
        }
        prevMonth.setDate(prevMonth.getDate() + 1)
      }
      this.picker.find('.datepicker-days tbody').empty().append(html.join(''))
      var currentYear = this.date.getFullYear()
      var months = this.picker
        .find('.datepicker-months')
        .find('th:eq(1)')
        .text(year)
        .end()
        .find('span')
        .removeClass('active')
      if (currentYear === year) {
        months.eq(this.date.getMonth()).addClass('active')
      }
      html = ''
      year = parseInt(year / 10, 10) * 10
      var yearCont = this.picker
        .find('.datepicker-years')
        .find('th:eq(1)')
        .text(year + '-' + (year + 9))
        .end()
        .find('td')
      year -= 1
      for (var i = -1; i < 11; i++) {
        html +=
          '<span class="year' +
          (i === -1 || i === 10 ? ' old' : '') +
          (currentYear === year ? ' active' : '') +
          '">' +
          year +
          '</span>'
        year += 1
      }
      yearCont.html(html)
    },
    click: function (e) {
      e.stopPropagation()
      e.preventDefault()
      var target = $(e.target).closest('span, td, th')
      if (target.length === 1) {
        switch (target[0].nodeName.toLowerCase()) {
          case 'th':
            switch (target[0].className) {
              case 'switch':
                this.showMode(1)
                break
              case 'prev':
              case 'next':
                this.viewDate['set' + DPGlobal.modes[this.viewMode].navFnc].call(
                  this.viewDate,
                  this.viewDate['get' + DPGlobal.modes[this.viewMode].navFnc].call(this.viewDate) +
                    DPGlobal.modes[this.viewMode].navStep * (target[0].className === 'prev' ? -1 : 1)
                )
                this.fill()
                this.set()
                break
            }
            break
          case 'span':
            if (target.is('.month')) {
              var month = target.parent().find('span').index(target)
              this.viewDate.setMonth(month)
            } else {
              var year = parseInt(target.text(), 10) || 0
              this.viewDate.setFullYear(year)
            }
            if (this.viewMode !== 0) {
              this.date = new Date(this.viewDate)
              this.element.trigger({
                type: 'changeDate',
                date: this.date,
                viewMode: DPGlobal.modes[this.viewMode].clsName,
              })
            }
            this.showMode(-1)
            this.fill()
            this.set()
            break
          case 'td':
            if (target.is('.day')) {
              var day = parseInt(target.text(), 10) || 1
              var month = this.viewDate.getMonth()
              if (target.is('.old')) {
                month -= 1
              } else if (target.is('.new')) {
                month += 1
              }
              var year = this.viewDate.getFullYear()
              this.date = new Date(year, month, day, 0, 0, 0, 0)
              this.viewDate = new Date(year, month, Math.min(28, day), 0, 0, 0, 0)
              this.fill()
              this.set()
              this.element.trigger({
                type: 'changeDate',
                date: this.date,
                viewMode: DPGlobal.modes[this.viewMode].clsName,
              })
            }
            break
        }
      }
    },
    mousedown: function (e) {
      e.stopPropagation()
      e.preventDefault()
    },
    showMode: function (dir) {
      if (dir) {
        this.viewMode = Math.max(this.minViewMode, Math.min(2, this.viewMode + dir))
      }
      this.picker
        .find('>div')
        .hide()
        .filter('.datepicker-' + DPGlobal.modes[this.viewMode].clsName)
        .show()
    },
  }
  $.fn.datepicker = function (option, val) {
    return this.each(function () {
      var $this = $(this),
        data = $this.data('datepicker'),
        options = typeof option === 'object' && option
      if (!data) {
        $this.data('datepicker', (data = new Datepicker(this, $.extend({}, $.fn.datepicker.defaults, options))))
      }
      if (typeof option === 'string') data[option](val)
    })
  }
  $.fn.datepicker.defaults = {}
  $.fn.datepicker.Constructor = Datepicker
  var DPGlobal = {
    modes: [
      { clsName: 'days', navFnc: 'Month', navStep: 1 },
      { clsName: 'months', navFnc: 'FullYear', navStep: 1 },
      { clsName: 'years', navFnc: 'FullYear', navStep: 10 },
    ],
    dates: {
      days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
      months: [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
      ],
      monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    isLeapYear: function (year) {
      return (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0
    },
    getDaysInMonth: function (year, month) {
      return [31, DPGlobal.isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month]
    },
    parseFormat: function (format) {
      var separator = format.match(/[.\/\-\s].*?/),
        parts = format.split(/\W+/)
      if (!separator || !parts || parts.length === 0) {
        throw new Error('Invalid date format.')
      }
      return { separator: separator, parts: parts }
    },
    parseDate: function (date, format) {
      var parts = date.split(format.separator),
        date = new Date(),
        val
      date.setHours(0)
      date.setMinutes(0)
      date.setSeconds(0)
      date.setMilliseconds(0)
      if (parts.length === format.parts.length) {
        for (var i = 0, cnt = format.parts.length; i < cnt; i++) {
          val = parseInt(parts[i], 10) || 1
          switch (format.parts[i]) {
            case 'dd':
            case 'd':
              date.setDate(val)
              break
            case 'mm':
            case 'm':
              date.setMonth(val - 1)
              break
            case 'yy':
              date.setFullYear(2000 + val)
              break
            case 'yyyy':
              date.setFullYear(val)
              break
          }
        }
      }
      return date
    },
    formatDate: function (date, format) {
      var val = {
        d: date.getDate(),
        m: date.getMonth() + 1,
        yy: date.getFullYear().toString().substring(2),
        yyyy: date.getFullYear(),
      }
      val.dd = (val.d < 10 ? '0' : '') + val.d
      val.mm = (val.m < 10 ? '0' : '') + val.m
      var date = []
      for (var i = 0, cnt = format.parts.length; i < cnt; i++) {
        date.push(val[format.parts[i]])
      }
      return date.join(format.separator)
    },
    headTemplate:
      '<thead>' +
      '<tr>' +
      '<th class="prev">&lsaquo;</th>' +
      '<th colspan="5" class="switch"></th>' +
      '<th class="next">&rsaquo;</th>' +
      '</tr>' +
      '</thead>',
    contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
  }
  DPGlobal.template =
    '<div class="datepicker dropdown-menu">' +
    '<div class="datepicker-days">' +
    '<table class=" table-condensed">' +
    DPGlobal.headTemplate +
    '<tbody></tbody>' +
    '</table>' +
    '</div>' +
    '<div class="datepicker-months">' +
    '<table class="table-condensed">' +
    DPGlobal.headTemplate +
    DPGlobal.contTemplate +
    '</table>' +
    '</div>' +
    '<div class="datepicker-years">' +
    '<table class="table-condensed">' +
    DPGlobal.headTemplate +
    DPGlobal.contTemplate +
    '</table>' +
    '</div>' +
    '</div>'
})(window.jQuery)
function bottombar_init() {
  $.fn.adjustNotifyPanel = function () {
    $(this).find('ul, .topitempanel').css({ height: 'auto' })
    var windowHeight = $(window).height()
    var panelsub = $(this).find('.topitempanel').height()
    var panelAdjust = windowHeight - 100
    var ulAdjust = panelAdjust - 25
    if (panelsub >= panelAdjust) {
      $(this).find('.topitempanel').css({ height: panelAdjust })
      $(this).find('ul').css({ height: ulAdjust })
    } else if (panelsub < panelAdjust) {
      $(this).find('ul').css({ height: 'auto' })
    }
  }
  $('#topmessage').adjustNotifyPanel()
  $('#topnotification').adjustNotifyPanel()
  $(window).resize(function () {
    $('#topmessage').adjustNotifyPanel()
    $('#topnotification').adjustNotifyPanel()
  })
  $('.topbutton').click(function () {
    if ($(this).next('.topitempanel').is(':visible')) {
      $(this).next('.topitempanel').hide()
      $('.topbutton').removeClass('active')
    } else {
      $('.topitempanel').hide()
      $(this).next('.topitempanel').toggle()
      $('.topbutton').removeClass('active')
      $(this).toggleClass('active')
      $(this).find('.badge').hide()
      var parentid = $(this).parent().attr('id')
      if (parentid == 'topnotification') {
        topnotify_notification()
      } else if (parentid == 'topmessage') {
        topnotify_message()
      }
    }
    return false
  })
  $(document).click(function () {
    $('.topitempanel').hide()
    $('.topbutton').removeClass('active')
  })
  $('.topitempanel ul').click(function (e) {
    e.stopPropagation()
  })
  setTimeout('bottombar_refresh()', 5000)
}
function topnotify_notification() {
  var currentNotification = parseInt($('#topnotification .badge').text())
  var currentShow = $('#topnotification .topitempanel ul li').length
  if (currentNotification > 0 || currentShow == 0) {
    $('#topnotification .topitempanel .viewall').before(
      '<div class="tmp_indicator" style="text-align:center;padding:10px 0;"><img src="' +
        imageDir +
        'ajax_indicator.gif" border="0" /></div>'
    )
    $.ajax({
      type: 'POST',
      dataType: 'xml',
      url: rooturl_profile + 'notification/indexajax',
      error: function () {
        $('#topnotification .topitempanel .tmp_indicator').remove()
      },
      success: function (xml) {
        $('#topnotification .topitempanel .tmp_indicator').remove()
        var count = $(xml).find('count').text()
        if (count != '0') {
          var html = ''
          $(xml)
            .find('notification')
            .each(function () {
              html +=
                '<li><img class="avatar" src="' +
                $(this).find('avatar').text() +
                '" alt="" /><div class="info">' +
                $(this).find('data').text() +
                '</div><br class="cl" /></li>'
            })
          if (currentNotification > 0) $('#topnotification .topitempanel ul').prepend(html)
          else $('#topnotification .topitempanel ul').html(html)
        }
      },
    })
    $('#topnotification .badge').text('0')
  }
}
function topnotify_message() {
  var currentNotification = parseInt($('#topmessage .badge').text())
  var currentShow = $('#topmessage .topitempanel ul li').length
  if (currentNotification > 0 || currentShow == 0) {
    $('#topmessage .viewall').before(
      '<div class="tmp_indicator" style="text-align:center;padding:10px 0;"><img src="' +
        imageDir +
        'ajax_indicator.gif" border="0" /></div>'
    )
    $.ajax({
      type: 'POST',
      dataType: 'xml',
      url: rooturl_profile + 'message/bottomindexajax',
      error: function () {
        $('#topmessage .tmp_indicator').remove()
      },
      success: function (xml) {
        $('#topmessage .tmp_indicator').remove()
        var count = $(xml).find('count').text()
        if (count != '0') {
          var html = ''
          $(xml)
            .find('message')
            .each(function () {
              html +=
                '<li><img class="avatar" src="' +
                $(this).find('avatar').text() +
                '" /><div class="info">' +
                $(this).find('data').text() +
                '</div><br class="cl" /></li>'
            })
          if (currentNotification > 0) $('#topmessage .topitempanel ul').prepend(html)
          else $('#topmessage .topitempanel ul').html(html)
        }
      },
    })
    $('#topmessage .badge').text('0')
  }
}
function bottombar_refresh() {
  if (typeof websocketenable != 'undefined' && websocketenable == 1) return true
  $.ajax({
    type: 'GET',
    dataType: 'xml',
    url: rooturl_profile + 'notification/refreshajax',
    error: function () {},
    success: function (xml) {
      var newNotification = $(xml).find('notification').text()
      var newMessage = $(xml).find('message').text()
      $('#topnotification .badge').html(newNotification)
      $('#topmessage .badge').html(newMessage)
      var newTitle = document.title.replace(/\(\d+\) /, '')
      if (parseInt(newNotification) > 0 || parseInt(newMessage) > 0) {
        if (parseInt(newNotification) > 0) $('#topnotification .badge').show()
        Tinycon.setBubble(parseInt(newNotification) + parseInt(newMessage))
      } else Tinycon.setBubble(0)
      if (parseInt(newMessage) > 0) $('#topmessage .badge').show()
      document.title = newTitle
      setTimeout('bottombar_refresh()', 5000)
    },
  })
}
;(function () {
  var Tinycon = {}
  var currentFavicon = null
  var originalFavicon = null
  var originalTitle = document.title
  var faviconImage = null
  var canvas = null
  var options = {}
  var defaults = { width: 7, height: 9, font: '10px arial', colour: '#ffffff', background: '#F03D25', fallback: true }
  var ua = (function (browser) {
    var agent = navigator.userAgent.toLowerCase()
    return function (browser) {
      return agent.indexOf(browser) !== -1
    }
  })()
  var browser = {
    chrome: ua('chrome'),
    webkit: ua('chrome') || ua('safari'),
    safari: ua('safari') && !ua('chrome'),
    mozilla: ua('mozilla') && !ua('chrome') && !ua('safari'),
  }
  var getFaviconTag = function () {
    var links = document.getElementsByTagName('link')
    for (var i = 0; i < links.length; i++) {
      if (links[i].getAttribute('rel') === 'icon') {
        return links[i]
      }
    }
    return false
  }
  var removeFaviconTag = function () {
    var links = document.getElementsByTagName('link')
    var head = document.getElementsByTagName('head')[0]
    for (var i = 0; i < links.length; i++) {
      if (links[i].getAttribute('rel') === 'icon') {
        head.removeChild(links[i])
      }
    }
  }
  var getCurrentFavicon = function () {
    if (!originalFavicon || !currentFavicon) {
      var tag = getFaviconTag()
      originalFavicon = currentFavicon = tag ? tag.getAttribute('href') : '/favicon.ico'
    }
    return currentFavicon
  }
  var getCanvas = function () {
    if (!canvas) {
      canvas = document.createElement('canvas')
      canvas.width = 16
      canvas.height = 16
    }
    return canvas
  }
  var setFaviconTag = function (url) {
    removeFaviconTag()
    var link = document.createElement('link')
    link.type = 'image/x-icon'
    link.rel = 'icon'
    link.href = url
    document.getElementsByTagName('head')[0].appendChild(link)
  }
  var log = function (message) {
    if (window.console) window.console.log(message)
  }
  var drawFavicon = function (num, colour) {
    if (!getCanvas().getContext || browser.safari) {
      return updateTitle(num)
    }
    var context = getCanvas().getContext('2d')
    var colour = colour || '#000000'
    var num = num || 0
    faviconImage = new Image()
    faviconImage.onload = function () {
      context.clearRect(0, 0, 16, 16)
      context.drawImage(faviconImage, 0, 0, faviconImage.width, faviconImage.height, 0, 0, 16, 16)
      if (num > 0) drawBubble(context, num, colour)
      refreshFavicon()
    }
    faviconImage.src = getCurrentFavicon()
  }
  var updateTitle = function (num) {
    if (options.fallback) {
      if (num > 0) {
        document.title = '(' + num + ') ' + originalTitle
      } else {
        document.title = originalTitle
      }
    }
  }
  var drawBubble = function (context, num, colour) {
    var len = (num + '').length - 1
    var width = options.width + 6 * len
    var w = 16 - width
    var h = 16 - options.height
    context.font = (browser.webkit ? 'normal ' : '') + options.font
    context.fillStyle = options.background
    context.strokeStyle = options.background
    context.lineWidth = 1
    context.fillRect(w, h, width - 1, options.height)
    context.beginPath()
    context.moveTo(w - 0.5, h + 1)
    context.lineTo(w - 0.5, 15)
    context.stroke()
    context.beginPath()
    context.moveTo(15.5, h + 1)
    context.lineTo(15.5, 15)
    context.stroke()
    context.beginPath()
    context.strokeStyle = 'rgba(0,0,0,0.3)'
    context.moveTo(w, 16)
    context.lineTo(15, 16)
    context.stroke()
    context.fillStyle = options.colour
    context.textAlign = 'right'
    context.textBaseline = 'top'
    context.fillText(num, 15, browser.mozilla ? 7 : 6)
  }
  var refreshFavicon = function () {
    if (!getCanvas().getContext) return
    setFaviconTag(getCanvas().toDataURL())
  }
  Tinycon.setOptions = function (custom) {
    options = {}
    for (var i in defaults) {
      options[i] = custom[i] ? custom[i] : defaults[i]
    }
    return this
  }
  Tinycon.setImage = function (url) {
    currentFavicon = url
    refreshFavicon()
    return this
  }
  Tinycon.setBubble = function (num, colour) {
    if (isNaN(num)) return log('Bubble must be a number')
    drawFavicon(num, colour)
    return this
  }
  Tinycon.reset = function () {
    Tinycon.setImage(originalFavicon)
  }
  Tinycon.setOptions(defaults)
  window.Tinycon = Tinycon
})()
eval(
  (function (p, a, c, k, e, r) {
    e = function (c) {
      return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
    }
    if (!''.replace(/^/, String)) {
      while (c--) r[e(c)] = k[c] || e(c)
      k = [
        function (e) {
          return r[e]
        },
      ]
      e = function () {
        return '\\w+'
      }
      c = 1
    }
    while (c--) if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c])
    return p
  })(
    ';(5($){$.1n.20({1j:5(1K,3){6 24=17 1K=="1J";3=$.20({},$.P.2A,{12:24?1K:U,7:24?U:1K,1N:24?$.P.2A.1N:10,M:3&&!3.1T?10:50},3);3.28=3.28||5(e){a e};3.22=3.22||3.2f;a m.K(5(){2O $.P(m,3)})},w:5(1X){a m.1c("w",1X)},1o:5(1X){a m.1e("1o",[1X])},2L:5(){a m.1e("2L")},2K:5(3){a m.1e("2K",[3])},2J:5(){a m.1e("2J")}});$.P=5(g,3){6 C={3h:38,3S:40,3d:46,3v:9,3B:13,3I:27,2W:4X,2Z:33,3a:34,3g:8};6 $g=$(g).4W("1j","4V").R(3.3y);6 1k;6 1a="";6 1p=$.P.3L(3);6 1m=0;6 1U;6 Q={1l:p};6 h=$.P.3b(3,g,2D,Q);6 29;$.2C.3m&&$(g.3n).1c("4R.1j",5(){4(29){29=p;a p}});$g.1c(($.2C.3m?"4P":"4O")+".1j",5(t){1m=1;1U=t.3G;4N(t.3G){W C.3h:4(h.I()){t.1w();h.2V()}j{Y(0,y)}Z;W C.3S:4(h.I()){t.1w();h.32()}j{Y(0,y)}Z;W C.2Z:4(h.I()){t.1w();h.35()}j{Y(0,y)}Z;W C.3a:4(h.I()){t.1w();h.39()}j{Y(0,y)}Z;W 3.1i&&$.1s(3.V)==","&&C.2W:W C.3v:W C.3B:4(2D()){t.1w();29=y;a p}Z;W C.3I:h.11();Z;4K:2y(1k);1k=2x(Y,3.1N);Z}}).2v(5(){1m++}).4J(5(){1m=0;4(!Q.1l){3o()}}).3r(5(){4(3.3s){4(!h.I()){Y(0,y)}}j{4(1m++>1&&!h.I()){Y(0,y)}}}).1c("1o",5(){6 1n=(26.f>1)?26[1]:U;5 2t(q,7){6 w;4(7&&7.f){1h(6 i=0;i<7.f;i++){4(7[i].w.N()==q.N()){w=7[i];Z}}}4(17 1n=="5")1n(w);j $g.1e("w",w&&[w.7,w.e])}$.K(19($g.L()),5(i,e){2s(e,2t,2t)})}).1c("2L",5(){1p.1E()}).1c("2K",5(){$.20(y,3,26[1]);4("7"2R 26[1])1p.1I()}).1c("2J",5(){h.1Z();$g.1Z();$(g.3n).1Z(".1j")});5 2D(){6 H=h.H();4(!H)a p;6 v=H.w;1a=v;4(3.1i){6 z=19($g.L());4(z.f>1){6 31=3.V.f;6 1q=$(g).1g().G;6 2q,2c=0;$.K(z,5(i,1t){2c+=1t.f;4(1q<=2c){2q=i;a p}2c+=31});z[2q]=v;v=z.3c(3.V)}v+=3.V}$g.L(v);1u();$g.1e("w",[H.7,H.e]);a y}5 Y(4H,3f){4(1U==C.3d){h.11();a}6 O=$g.L();4(!3f&&O==1a)a;1a=O;O=1v(O);4(O.f>=3.2p){$g.R(3.2o);4(!3.1Q)O=O.N();2s(O,3p,1u)}j{1R();h.11()}};5 19(e){4(!e)a[""];4(!3.1i)a[$.1s(e)];a $.4G(e.2n(3.V),5(1t){a $.1s(e).f?$.1s(1t):U})}5 1v(e){4(!3.1i)a e;6 z=19(e);4(z.f==1)a z[0];6 1q=$(g).1g().G;4(1q==e.f){z=19(e)}j{z=19(e.2k(e.3w(1q),""))}a z[z.f-1]}5 1V(q,2j){4(3.1V&&(1v($g.L()).N()==q.N())&&1U!=C.3g){$g.L($g.L()+2j.3w(1v(1a).f));$(g).1g(1a.f,1a.f+2j.f)}};5 3o(){2y(1k);1k=2x(1u,4F)};5 1u(){6 4A=h.I();h.11();2y(1k);1R();4(3.3C){$g.1o(5(w){4(!w){4(3.1i){6 z=19($g.L()).1A(0,-1);$g.L(z.3c(3.V)+(z.f?3.V:""))}j{$g.L("");$g.1e("w",U)}}})}};5 3p(q,7){4(7&&7.f&&1m){1R();h.3E(7,q);1V(q,7[0].e);h.2d()}j{1u()}};5 2s(A,21,3J){4(!3.1Q)A=A.N();6 7=1p.3K(A);4(7&&7.f){21(A,7)}j 4((17 3.12=="1J")&&(3.12.f>0)){6 1C={4z:+2O 4y()};$.K(3.1C,5(3Q,23){1C[3Q]=17 23=="5"?23():23});$.4x({4v:"4u",4s:"1j"+g.4o,2T:3.2T,12:3.12,7:$.20({q:1v(A),4n:3.M},1C),21:5(7){6 1d=3.1M&&3.1M(7)||1M(7);1p.1G(A,1d);21(A,1d)}})}j{h.2Y();3J(A)}};5 1M(7){6 1d=[];6 2e=7.2n("\\n");1h(6 i=0;i<2e.f;i++){6 B=$.1s(2e[i]);4(B){B=B.2n("|");1d[1d.f]={7:B,e:B[0],w:3.2b&&3.2b(B,B[0])||B[0]}}}a 1d};5 1R(){$g.1H(3.2o)}};$.P.2A={3y:"4m",37:"4l",2o:"4k",2p:1,1N:4h,1Q:p,1z:y,1W:p,1y:4g,M:4f,3C:p,1C:{},2m:y,2f:5(B){a B[0]},22:U,1V:p,D:0,1i:p,V:" ",3i:y,3s:p,28:5(e,A){a e.2k(2O 4e("(?![^&;]+;)(?!<[^<>]*)("+A.2k(/([\\^\\$\\(\\)\\[\\]\\{\\}\\*\\.\\+\\?\\|\\\\])/3k,"\\\\$1")+")(?![^<>]*>)(?![^&;]+;)","3k"),"<3l>$1</3l>")},1T:y,1O:4d};$.P.3L=5(3){6 7={};6 f=0;5 1z(s,2r){4(!3.1Q)s=s.N();6 i=s.3q(2r);4(3.1W=="1t"){i=s.N().1o("\\\\b"+2r.N())}4(i==-1)a p;a i==0||3.1W};5 1G(q,e){4(f>3.1y){1E()}4(!7[q]){f++}7[q]=e}5 1I(){4(!3.7)a p;6 14={},3t=0;4(!3.12)3.1y=1;14[""]=[];1h(6 i=0,3x=3.7.f;i<3x;i++){6 S=3.7[i];S=(17 S=="1J")?[S]:S;6 e=3.22(S,i+1,3.7.f);4(e===p)2w;6 1Y=e.4c(0).N();4(!14[1Y])14[1Y]=[];6 B={e:e,7:S,w:3.2b&&3.2b(S)||e};14[1Y].2z(B);4(3t++<3.M){14[""].2z(B)}};$.K(14,5(i,e){3.1y++;1G(i,e)})}2x(1I,25);5 1E(){7={};f=0}a{1E:1E,1G:1G,1I:1I,3K:5(q){4(!3.1y||!f)a U;4(!3.12&&3.1W){6 15=[];1h(6 k 2R 7){4(k.f>0){6 c=7[k];$.K(c,5(i,x){4(1z(x.e,q)){15.2z(x)}})}}a 15}j 4(7[q]){a 7[q]}j 4(3.1z){1h(6 i=q.f-1;i>=3.2p;i--){6 c=7[q.44(0,i)];4(c){6 15=[];$.K(c,5(i,x){4(1z(x.e,q)){15[15.f]=x}});a 15}}}a U}}};$.P.3b=5(3,g,h,Q){6 F={E:"42"};6 l,o=-1,7,A="",2I=y,u,r;5 3O(){4(!2I)a;u=$("<41/>").11().R(3.37).1f("3V","4t").2N(2M.3R).3U(5(t){4($(m).3P(":I")){g.2v()}Q.1l=p;3W.3X(Q.1l)});r=$("<3Y/>").2N(u).3Z(5(t){4(1b(t).3F&&1b(t).3F.43()==\'3A\'){o=$("1x",r).1H(F.E).45(1b(t));$(1b(t)).R(F.E)}}).3r(5(t){$(1b(t)).R(F.E);h();4(3.3i)g.2v();a p}).47(5(){Q.1l=y}).48(5(){Q.1l=p});4(3.D>0)u.1f("D",3.D);2I=p}5 1b(t){6 u=t.1b;49(u&&u.4a!="3A")u=u.4b;4(!u)a[];a u}5 16(2a){l.1A(o,o+1).1H(F.E);3j(2a);6 2l=l.1A(o,o+1).R(F.E);4(3.1T){6 J=0;l.1A(0,o).K(5(){J+=m.1B});4((J+2l[0].1B-r.1D())>r[0].4i){r.1D(J+2l[0].1B-r.4j())}j 4(J<r.1D()){r.1D(J)}}};5 3j(2a){o+=2a;4(o<0){o=l.1F()-1}j 4(o>=l.1F()){o=0}}5 36(2h){a 3.M&&3.M<2h?3.M:2h}5 2U(){r.2S();6 M=36(7.f);1h(6 i=0;i<M;i++){4(!7[i])2w;6 2g=3.2f(7[i].7,i+1,M,7[i].e,A);4(2g===p)2w;6 1x=$("<1x/>").4p(3.28(2g,A)).R(i%2==0?"4q":"4r").2N(r)[0];$.7(1x,"2Q",7[i])}l=r.3T("1x");4(3.2m){l.1A(0,1).R(F.E);o=0}4($.1n.2P)r.2P()}a{3E:5(d,q){3O();7=d;A=q;2U()},32:5(){16(1)},2V:5(){16(-1)},35:5(){4(o!=0&&o-8<0){16(-o)}j{16(-8)}},39:5(){4(o!=l.1F()-1&&o+8>l.1F()){16(l.1F()-1-o)}j{16(8)}},11:5(){u&&u.11();l&&l.1H(F.E);o=-1},I:5(){a u&&u.3P(":I")},4w:5(){a m.I()&&(l.3N("."+F.E)[0]||3.2m&&l[0])},2d:5(){6 J=$(g).J();u.1f({D:17 3.D=="1J"||3.D>0?3.D:$(g).D(),3M:J.3M+g.1B,2i:J.2i}).2d();4(3.1T){r.1D(0);r.1f({3z:3.1O,4B:\'4C\'});4($.2C.4D&&17 2M.3R.4E.3z==="1S"){6 1L=0;l.K(5(){1L+=m.1B});6 2u=1L>3.1O;r.1f(\'4I\',2u?3.1O:1L);4(!2u){l.D(r.D()-3e(l.1f("3H-2i"))-3e(l.1f("3H-4L")))}}}},H:5(){6 H=l&&l.3N("."+F.E).1H(F.E);a H&&H.f&&$.7(H[0],"2Q")},2Y:5(){r&&r.2S()},1Z:5(){u&&u.4M()}}};$.1n.1g=5(G,T){4(G!==1S){a m.K(5(){4(m.2B){6 18=m.2B();4(T===1S||G==T){18.4Q("2E",G);18.h()}j{18.4S(y);18.4T("2E",G);18.4U("2E",T);18.h()}}j 4(m.3u){m.3u(G,T)}j 4(m.1P){m.1P=G;m.30=T}})}6 X=m[0];4(X.2B){6 2F=2M.1g.4Y(),3D=X.e,2G="<->",2H=2F.2X.f;2F.2X=2G;6 1r=X.e.3q(2G);X.e=3D;m.1g(1r,1r+2H);a{G:1r,T:1r+2H}}j 4(X.1P!==1S){a{G:X.1P,T:X.30}}}})(4Z);',
    62,
    311,
    '|||options|if|function|var|data|||return||||value|length|input|select||else||listItems|this||active|false||list||event|element||result||true|words|term|row|KEY|width|ACTIVE|CLASSES|start|selected|visible|offset|each|val|max|toLowerCase|currentValue|Autocompleter|config|addClass|rawValue|end|null|multipleSeparator|case|field|onChange|break||hide|url||stMatchSets|csub|moveSelect|typeof|selRange|trimWords|previousValue|target|bind|parsed|trigger|css|selection|for|multiple|autocomplete|timeout|mouseDownOnSelect|hasFocus|fn|search|cache|cursorAt|caretAt|trim|word|hideResultsNow|lastWord|preventDefault|li|cacheLength|matchSubset|slice|offsetHeight|extraParams|scrollTop|flush|size|add|removeClass|populate|string|urlOrData|listHeight|parse|delay|scrollHeight|selectionStart|matchCase|stopLoading|undefined|scroll|lastKeyPressCode|autoFill|matchContains|handler|firstChar|unbind|extend|success|formatMatch|param|isUrl||arguments||highlight|blockSubmit|step|formatResult|progress|show|rows|formatItem|formatted|available|left|sValue|replace|activeItem|selectFirst|split|loadingClass|minChars|wordAt|sub|request|findValueCallback|scrollbarsVisible|focus|continue|setTimeout|clearTimeout|push|defaults|createTextRange|browser|selectCurrent|character|range|teststring|textLength|needsInit|unautocomplete|setOptions|flushCache|document|appendTo|new|bgiframe|ac_data|in|empty|dataType|fillList|prev|COMMA|text|emptyList|PAGEUP|selectionEnd|seperator|next|||pageUp|limitNumberOfItems|resultsClass||pageDown|PAGEDOWN|Select|join|DEL|parseInt|skipPrevCheck|BACKSPACE|UP|inputFocus|movePosition|gi|strong|opera|form|hideResults|receiveData|indexOf|click|clickFire|nullData|setSelectionRange|TAB|substring|ol|inputClass|maxHeight|LI|RETURN|mustMatch|orig|display|nodeName|keyCode|padding|ESC|failure|load|Cache|top|filter|init|is|key|body|DOWN|find|hover|position|console|debug|ul|mouseover||div|ac_over|toUpperCase|substr|index||mousedown|mouseup|while|tagName|parentNode|charAt|180|RegExp|1000|100|400|clientHeight|innerHeight|ac_loading|ac_results|ac_input|limit|name|html|ac_even|ac_odd|port|absolute|abort|mode|current|ajax|Date|timestamp|wasVisible|overflow|auto|msie|style|200|map|crap|height|blur|default|right|remove|switch|keydown|keypress|move|submit|collapse|moveStart|moveEnd|off|attr|188|createRange|jQuery|150'.split(
      '|'
    ),
    0,
    {}
  )
)
;(function ($) {
  $.fn.extend({
    limit: function (limit, element) {
      var interval, f
      var self = $(this)
      $(this).focus(function () {
        interval = window.setInterval(substring, 100)
      })
      $(this).blur(function () {
        clearInterval(interval)
        substring()
      })
      substringFunction =
        'function substring(){ var val = $(self).val();var length = val.length;/*if(length > limit){$(self).val($(self).val().substring(0,limit));}*/'
      if (typeof element != 'undefined')
        substringFunction +=
          "$(element).html(limit-length);/*if($(element).html() != limit-length){$(element).html((limit-length<=0)?'0':limit-length);}*/"
      substringFunction += '}'
      eval(substringFunction)
      substring()
    },
  })
})(jQuery)
;(function () {
  var ua = navigator.userAgent.toLowerCase(),
    S = {
      version: '3.0rc1',
      adapter: null,
      cache: [],
      client: {
        isIE: ua.indexOf('msie') > -1,
        isIE6: ua.indexOf('msie 6') > -1,
        isIE7: ua.indexOf('msie 7') > -1,
        isGecko: ua.indexOf('gecko') > -1 && ua.indexOf('safari') == -1,
        isWebkit: ua.indexOf('applewebkit/') > -1,
        isWindows: ua.indexOf('windows') > -1 || ua.indexOf('win32') > -1,
        isMac: ua.indexOf('macintosh') > -1 || ua.indexOf('mac os x') > -1,
        isLinux: ua.indexOf('linux') > -1,
      },
      content: null,
      current: -1,
      dimensions: null,
      gallery: [],
      expando: 'shadowboxCacheKey',
      libraries: {
        Prototype: 'prototype',
        jQuery: 'jquery',
        MooTools: 'mootools',
        YAHOO: 'yui',
        dojo: 'dojo',
        Ext: 'ext',
      },
      options: {
        adapter: null,
        animate: true,
        animateFade: true,
        autoplayMovies: true,
        continuous: false,
        ease: function (x) {
          return 1 + Math.pow(x - 1, 3)
        },
        enableKeys: true,
        errors: {
          fla: { name: 'Flash', url: 'http://www.adobe.com/products/flashplayer/' },
          qt: { name: 'QuickTime', url: 'http://www.apple.com/quicktime/download/' },
          wmp: { name: 'Windows Media Player', url: 'http://www.microsoft.com/windows/windowsmedia/' },
          f4m: { name: 'Flip4Mac', url: 'http://www.flip4mac.com/wmv_download.htm' },
        },
        ext: {
          img: ['png', 'jpg', 'jpeg', 'gif', 'bmp'],
          swf: ['swf'],
          flv: ['flv', 'm4v'],
          qt: ['dv', 'mov', 'moov', 'movie', 'mp4'],
          wmp: ['asf', 'wm', 'wmv'],
          qtwmp: ['avi', 'mpg', 'mpeg'],
        },
        flashParams: { bgcolor: '#000000', allowfullscreen: true },
        flashVars: {},
        flashVersion: '9.0.115',
        handleOversize: 'resize',
        handleUnsupported: 'link',
        language: 'en',
        onChange: null,
        onClose: null,
        onFinish: null,
        onOpen: null,
        players: ['img'],
        showMovieControls: true,
        skipSetup: false,
        slideshowDelay: 0,
        useSizzle: true,
        viewportPadding: 20,
      },
      path: '',
      plugins: null,
      ready: false,
      regex: {
        domain: /:\/\/(.*?)[:\/]/,
        inline: /#(.+)$/,
        rel: /^(light|shadow)box/i,
        gallery: /^(light|shadow)box\[(.*?)\]/i,
        unsupported: /^unsupported-(\w+)/,
        param: /\s*([a-z_]*?)\s*=\s*(.+)\s*/,
      },
      applyOptions: function (opts) {
        if (opts) {
          default_options = apply({}, S.options)
          apply(S.options, opts)
        }
      },
      revertOptions: function () {
        apply(S.options, default_options)
      },
      change: function (index) {
        if (!S.gallery) {
          return
        }
        if (!S.gallery[index]) {
          if (!S.options.continuous) {
            return
          } else {
            index = index < 0 ? S.gallery.length - 1 : 0
          }
        }
        S.current = index
        if (typeof slide_timer == 'number') {
          clearTimeout(slide_timer)
          slide_timer = null
          slide_delay = slide_start = 0
        }
        if (S.options.onChange) {
          S.options.onChange()
        }
        loadContent()
      },
      close: function () {
        if (!active) {
          return
        }
        active = false
        listenKeys(false)
        if (S.content) {
          S.content.remove()
          S.content = null
        }
        if (typeof slide_timer == 'number') {
          clearTimeout(slide_timer)
        }
        slide_timer = null
        slide_delay = 0
        if (S.options.onClose) {
          S.options.onClose()
        }
        S.skin.onClose()
        S.revertOptions()
      },
      contentId: function () {
        return content_id
      },
      error: function (msg) {
        if (!S.debug) {
          return
        }
        if (typeof window.console != 'undefined' && typeof console.log == 'function') {
          console.log(msg)
        } else {
          alert(msg)
        }
      },
      getCurrent: function () {
        return S.current > -1 ? S.gallery[S.current] : null
      },
      hasNext: function () {
        return S.gallery.length > 1 && (S.current != S.gallery.length - 1 || S.options.continuous)
      },
      init: function (opts) {
        if (initialized) {
          return
        }
        initialized = true
        opts = opts || {}
        init_options = opts
        if (opts) {
          apply(S.options, opts)
        }
        for (var e in S.options.ext) {
          S.regex[e] = new RegExp('.(' + S.options.ext[e].join('|') + ')s*$', 'i')
        }
        if (!S.path) {
          var pathre = /(.+\/)shadowbox\.js/i,
            path
          each(document.getElementsByTagName('script'), function (s) {
            path = pathre.exec(s.src)
            if (path) {
              S.path = path[1]
              return false
            }
          })
        }
        if (S.options.adapter) {
          S.adapter = S.options.adapter.toLowerCase()
        } else {
          for (var lib in S.libraries) {
            if (typeof window[lib] != 'undefined') {
              S.adapter = S.libraries[lib]
              break
            }
          }
          if (!S.adapter) {
            S.adapter = 'base'
          }
        }
        if (S.options.useSizzle && !window.Sizzle) {
          if (window.jQuery) {
            window.Sizzle = jQuery.find
          } else {
            U.include(S.path + 'libraries/sizzle/sizzle.js')
          }
        }
        if (!S.lang) {
          U.include(S.path + 'languages/shadowbox-' + S.options.language + '.js')
        }
        each(S.options.players, function (p) {
          if ((p == 'swf' || p == 'flv') && !window.swfobject) {
            U.include(S.path + 'libraries/swfobject/swfobject.js')
          }
          if (!S[p]) {
            U.include(S.path + 'players/shadowbox-' + p + '.js')
          }
        })
        if (!S.lib) {
          U.include(S.path + 'adapters/shadowbox-' + S.adapter + '.js')
        }
        waitDom(waitLibs)
      },
      isActive: function () {
        return active
      },
      isPaused: function () {
        return slide_timer == 'paused'
      },
      load: function () {
        if (S.ready) {
          return
        }
        S.ready = true
        if (S.skin.options) {
          apply(S.options, S.skin.options)
          apply(S.options, init_options)
        }
        S.skin.init()
        if (!S.options.skipSetup) {
          S.setup()
        }
      },
      next: function () {
        S.change(S.current + 1)
      },
      open: function (obj) {
        if (U.isLink(obj)) {
          if (S.inCache(obj)) {
            obj = S.cache[obj[S.expando]]
          } else {
            obj = S.buildCacheObj(obj)
          }
        }
        if (obj.constructor == Array) {
          S.gallery = obj
          S.current = 0
        } else {
          if (!obj.gallery) {
            S.gallery = [obj]
            S.current = 0
          } else {
            S.current = null
            S.gallery = []
            each(S.cache, function (c) {
              if (c.gallery && c.gallery == obj.gallery) {
                if (S.current == null && c.content == obj.content && c.title == obj.title) {
                  S.current = S.gallery.length
                }
                S.gallery.push(c)
              }
            })
            if (S.current == null) {
              S.gallery.unshift(obj)
              S.current = 0
            }
          }
        }
        obj = S.getCurrent()
        if (obj.options) {
          S.revertOptions()
          S.applyOptions(obj.options)
        }
        var item,
          remove,
          m,
          format,
          replace,
          oe = S.options.errors,
          msg,
          el
        for (var i = 0; i < S.gallery.length; ++i) {
          item = S.gallery[i] = apply({}, S.gallery[i])
          remove = false
          if ((m = S.regex.unsupported.exec(item.player))) {
            if (S.options.handleUnsupported == 'link') {
              item.player = 'html'
              switch (m[1]) {
                case 'qtwmp':
                  format = 'either'
                  replace = [oe.qt.url, oe.qt.name, oe.wmp.url, oe.wmp.name]
                  break
                case 'qtf4m':
                  format = 'shared'
                  replace = [oe.qt.url, oe.qt.name, oe.f4m.url, oe.f4m.name]
                  break
                default:
                  format = 'single'
                  if (m[1] == 'swf' || m[1] == 'flv') {
                    m[1] = 'fla'
                  }
                  replace = [oe[m[1]].url, oe[m[1]].name]
              }
              msg = S.lang.errors[format].replace(/\{(\d+)\}/g, function (m, n) {
                return replace[n]
              })
              item.content = '<div class="sb-message">' + msg + '</div>'
            } else {
              remove = true
            }
          } else {
            if (item.player == 'inline') {
              m = S.regex.inline.exec(item.content)
              if (m) {
                var el = U.get(m[1])
                if (el) {
                  item.content = el.innerHTML
                } else {
                  S.error('Cannot find element with id ' + m[1])
                }
              } else {
                S.error('Cannot find element id for inline content')
              }
            } else {
              if (item.player == 'swf' || item.player == 'flv') {
                var version = (item.options && item.options.flashVersion) || S.options.flashVersion
                if (!swfobject.hasFlashPlayerVersion(version)) {
                  item.width = 310
                  item.height = 177
                }
              }
            }
          }
          if (remove) {
            S.gallery.splice(i, 1)
            if (i < S.current) {
              --S.current
            } else {
              if (i == S.current) {
                S.current = i > 0 ? i - 1 : i
              }
            }
            --i
          }
        }
        if (S.gallery.length) {
          if (!active) {
            if (typeof S.options.onOpen == 'function' && S.options.onOpen(obj) === false) {
              return
            }
            S.skin.onOpen(obj, loadContent)
          } else {
            loadContent()
          }
          active = true
        }
      },
      pause: function () {
        if (typeof slide_timer != 'number') {
          return
        }
        var time = new Date().getTime()
        slide_delay = Math.max(0, slide_delay - (time - slide_start))
        if (slide_delay) {
          clearTimeout(slide_timer)
          slide_timer = 'paused'
          if (S.skin.onPause) {
            S.skin.onPause()
          }
        }
      },
      play: function () {
        if (!S.hasNext()) {
          return
        }
        if (!slide_delay) {
          slide_delay = S.options.slideshowDelay * 1000
        }
        if (slide_delay) {
          slide_start = new Date().getTime()
          slide_timer = setTimeout(function () {
            slide_delay = slide_start = 0
            S.next()
          }, slide_delay)
          if (S.skin.onPlay) {
            S.skin.onPlay()
          }
        }
      },
      previous: function () {
        S.change(S.current - 1)
      },
      setDimensions: function (height, width, max_h, max_w, tb, lr, resizable) {
        var h = (height = parseInt(height)),
          w = (width = parseInt(width)),
          pad = parseInt(S.options.viewportPadding) || 0
        var extra_h = 2 * pad + tb
        if (h + extra_h >= max_h) {
          h = max_h - extra_h
        }
        var extra_w = 2 * pad + lr
        if (w + extra_w >= max_w) {
          w = max_w - extra_w
        }
        var resize_h = height,
          resize_w = width,
          change_h = (height - h) / height,
          change_w = (width - w) / width,
          oversized = change_h > 0 || change_w > 0
        if (resizable && oversized && S.options.handleOversize == 'resize') {
          if (change_h > change_w) {
            w = Math.round((width / height) * h)
          } else {
            if (change_w > change_h) {
              h = Math.round((height / width) * w)
            }
          }
          resize_w = w
          resize_h = h
        }
        S.dimensions = {
          height: h + tb,
          width: w + lr,
          inner_h: h,
          inner_w: w,
          top: (max_h - (h + extra_h)) / 2 + pad,
          left: (max_w - (w + extra_w)) / 2 + pad,
          oversized: oversized,
          resize_h: resize_h,
          resize_w: resize_w,
        }
      },
      setup: function (links, opts) {
        each(S.findLinks(links), function (link) {
          S.addCache(link, opts)
        })
      },
      teardown: function (links) {
        each(S.findLinks(links), S.removeCache)
      },
      findLinks: function (links) {
        if (!links) {
          var links = [],
            rel
          each(document.getElementsByTagName('a'), function (a) {
            rel = a.getAttribute('rel')
            if (rel && S.regex.rel.test(rel)) {
              links.push(a)
            }
          })
        } else {
          var len = links.length
          if (len) {
            if (window.Sizzle) {
              if (typeof links == 'string') {
                links = Sizzle(links)
              } else {
                if (len == 2 && links.push && typeof links[0] == 'string' && links[1].nodeType) {
                  links = Sizzle(links[0], links[1])
                }
              }
            }
          } else {
            links = [links]
          }
        }
        return links
      },
      inCache: function (link) {
        return typeof link[S.expando] == 'number' && S.cache[link[S.expando]]
      },
      addCache: function (link, opts) {
        if (!S.inCache(link)) {
          link[S.expando] = S.cache.length
          S.lib.addEvent(link, 'click', handleClick)
        }
        S.cache[link[S.expando]] = S.buildCacheObj(link, opts)
      },
      removeCache: function (link) {
        S.lib.removeEvent(link, 'click', handleClick)
        S.cache[link[S.expando]] = null
        delete link[S.expando]
      },
      clearCache: function () {
        each(S.cache, function (obj) {
          S.removeCache(obj.link)
        })
        S.cache = []
      },
      buildCacheObj: function (link, opts) {
        var obj = { link: link, title: link.getAttribute('title'), options: apply({}, opts || {}), content: link.href }
        if (opts) {
          each(['player', 'title', 'height', 'width', 'gallery'], function (option) {
            if (typeof obj.options[option] != 'undefined') {
              obj[option] = obj.options[option]
              delete obj.options[option]
            }
          })
        }
        if (!obj.player) {
          obj.player = S.getPlayer(obj.content)
        }
        var rel = link.getAttribute('rel')
        if (rel) {
          var match = rel.match(S.regex.gallery)
          if (match) {
            obj.gallery = escape(match[2])
          }
          each(rel.split(';'), function (parameter) {
            match = parameter.match(S.regex.param)
            if (match) {
              if (match[1] == 'options') {
                eval('apply(obj.options,' + match[2] + ')')
              } else {
                obj[match[1]] = match[2]
              }
            }
          })
        }
        return obj
      },
      getPlayer: function (content) {
        var r = S.regex,
          p = S.plugins,
          m = content.match(r.domain),
          same_domain = m && document.domain == m[1]
        if (content.indexOf('#') > -1 && same_domain) {
          return 'inline'
        }
        var q = content.indexOf('?')
        if (q > -1) {
          content = content.substring(0, q)
        }
        if (r.img.test(content)) {
          return 'img'
        }
        if (r.swf.test(content)) {
          return p.fla ? 'swf' : 'unsupported-swf'
        }
        if (r.flv.test(content)) {
          return p.fla ? 'flv' : 'unsupported-flv'
        }
        if (r.qt.test(content)) {
          return p.qt ? 'qt' : 'unsupported-qt'
        }
        if (r.wmp.test(content)) {
          if (p.wmp) {
            return 'wmp'
          }
          if (p.f4m) {
            return 'qt'
          }
          if (S.client.isMac) {
            return p.qt ? 'unsupported-f4m' : 'unsupported-qtf4m'
          }
          return 'unsupported-wmp'
        }
        if (r.qtwmp.test(content)) {
          if (p.qt) {
            return 'qt'
          }
          if (p.wmp) {
            return 'wmp'
          }
          return S.client.isMac ? 'unsupported-qt' : 'unsupported-qtwmp'
        }
        return 'iframe'
      },
    },
    U = (S.util = {
      animate: function (el, p, to, d, cb) {
        var from = parseFloat(S.lib.getStyle(el, p))
        if (isNaN(from)) {
          from = 0
        }
        var delta = to - from
        if (delta == 0) {
          if (cb) {
            cb()
          }
          return
        }
        var op = p == 'opacity'
        function fn(ease) {
          var to = from + ease * delta
          if (op) {
            U.setOpacity(el, to)
          } else {
            el.style[p] = to + 'px'
          }
        }
        if (!d || (!op && !S.options.animate) || (op && !S.options.animateFade)) {
          fn(1)
          if (cb) {
            cb()
          }
          return
        }
        d *= 1000
        var begin = new Date().getTime(),
          ease = S.options.ease,
          end = begin + d,
          time,
          timer = setInterval(function () {
            time = new Date().getTime()
            if (time >= end) {
              clearInterval(timer)
              fn(1)
              if (cb) {
                cb()
              }
            } else {
              fn(ease((time - begin) / d))
            }
          }, 10)
      },
      apply: function (o, e) {
        for (var p in e) {
          o[p] = e[p]
        }
        return o
      },
      clearOpacity: function (el) {
        var s = el.style
        if (window.ActiveXObject) {
          if (typeof s.filter == 'string' && /alpha/i.test(s.filter)) {
            s.filter = s.filter.replace(/[\w\.]*alpha\(.*?\);?/i, '')
          }
        } else {
          s.opacity = ''
        }
      },
      each: function (obj, fn, scope) {
        for (var i = 0, len = obj.length; i < len; ++i) {
          if (fn.call(scope || obj[i], obj[i], i, obj) === false) {
            return
          }
        }
      },
      get: function (id) {
        return document.getElementById(id)
      },
      include: (function () {
        var includes = {}
        return function (file) {
          if (includes[file]) {
            return
          }
          includes[file] = true
          var head = document.getElementsByTagName('head')[0],
            script = document.createElement('script')
          script.src = file
          head.appendChild(script)
        }
      })(),
      isLink: function (obj) {
        if (!obj || !obj.tagName) {
          return false
        }
        var up = obj.tagName.toUpperCase()
        return up == 'A' || up == 'AREA'
      },
      removeChildren: function (el) {
        while (el.firstChild) {
          el.removeChild(el.firstChild)
        }
      },
      setOpacity: function (el, o) {
        var s = el.style
        if (window.ActiveXObject) {
          s.zoom = 1
          s.filter =
            (s.filter || '').replace(/\s*alpha\([^\)]*\)/gi, '') + (o == 1 ? '' : ' alpha(opacity=' + o * 100 + ')')
        } else {
          s.opacity = o
        }
      },
    }),
    apply = U.apply,
    each = U.each,
    init_options,
    initialized = false,
    default_options = {},
    content_id = 'sb-content',
    active = false,
    slide_timer,
    slide_start,
    slide_delay = 0
  if (navigator.plugins && navigator.plugins.length) {
    var names = []
    each(navigator.plugins, function (p) {
      names.push(p.name)
    })
    names = names.join()
    var f4m = names.indexOf('Flip4Mac') > -1
    S.plugins = {
      fla: names.indexOf('Shockwave Flash') > -1,
      qt: names.indexOf('QuickTime') > -1,
      wmp: !f4m && names.indexOf('Windows Media') > -1,
      f4m: f4m,
    }
  } else {
    function detectPlugin(n) {
      try {
        var axo = new ActiveXObject(n)
      } catch (e) {}
      return !!axo
    }
    S.plugins = {
      fla: detectPlugin('ShockwaveFlash.ShockwaveFlash'),
      qt: detectPlugin('QuickTime.QuickTime'),
      wmp: detectPlugin('wmplayer.ocx'),
      f4m: false,
    }
  }
  function waitDom(cb) {
    if (document.addEventListener) {
      document.addEventListener(
        'DOMContentLoaded',
        function () {
          document.removeEventListener('DOMContentLoaded', arguments.callee, false)
          cb()
        },
        false
      )
    } else {
      if (document.attachEvent) {
        document.attachEvent('onreadystatechange', function () {
          if (document.readyState === 'complete') {
            document.detachEvent('onreadystatechange', arguments.callee)
            cb()
          }
        })
        if (document.documentElement.doScroll && window == window.top) {
          ;(function () {
            if (S.ready) {
              return
            }
            try {
              document.documentElement.doScroll('left')
            } catch (error) {
              setTimeout(arguments.callee, 0)
              return
            }
            cb()
          })()
        }
      }
    }
    if (typeof window.onload == 'function') {
      var oldonload = window.onload
      window.onload = function () {
        oldonload()
        cb()
      }
    } else {
      window.onload = cb
    }
  }
  function waitLibs() {
    if (S.lib && S.lang) {
      S.load()
    } else {
      setTimeout(waitLibs, 0)
    }
  }
  function handleClick(e) {
    var link
    if (U.isLink(this)) {
      link = this
    } else {
      link = S.lib.getTarget(e)
      while (!U.isLink(link) && link.parentNode) {
        link = link.parentNode
      }
    }
    S.lib.preventDefault(e)
    if (link) {
      S.open(link)
      if (S.gallery.length) {
        S.lib.preventDefault(e)
      }
    }
  }
  function listenKeys(on) {
    if (!S.options.enableKeys) {
      return
    }
    S.lib[(on ? 'add' : 'remove') + 'Event'](document, 'keydown', handleKey)
  }
  function handleKey(e) {
    var code = S.lib.keyCode(e),
      handler
    switch (code) {
      case 81:
      case 88:
      case 27:
        handler = S.close
        break
      case 37:
        handler = S.previous
        break
      case 39:
        handler = S.next
        break
      case 32:
        handler = typeof slide_timer == 'number' ? S.pause : S.play
    }
    if (handler) {
      S.lib.preventDefault(e)
      handler()
    }
  }
  function loadContent() {
    var obj = S.getCurrent()
    if (!obj) {
      return
    }
    var p = obj.player == 'inline' ? 'html' : obj.player
    if (typeof S[p] != 'function') {
      S.error('Unknown player: ' + p)
    }
    var change = false
    if (S.content) {
      S.content.remove()
      change = true
      S.revertOptions()
      if (obj.options) {
        S.applyOptions(obj.options)
      }
    }
    U.removeChildren(S.skin.bodyEl())
    S.content = new S[p](obj)
    listenKeys(false)
    S.skin.onLoad(S.content, change, function () {
      if (!S.content) {
        return
      }
      if (typeof S.content.ready != 'undefined') {
        var id = setInterval(function () {
          if (S.content) {
            if (S.content.ready) {
              clearInterval(id)
              id = null
              S.skin.onReady(contentReady)
            }
          } else {
            clearInterval(id)
            id = null
          }
        }, 100)
      } else {
        S.skin.onReady(contentReady)
      }
    })
    if (S.gallery.length > 1) {
      var next = S.gallery[S.current + 1] || S.gallery[0]
      if (next.player == 'img') {
        var a = new Image()
        a.src = next.content
      }
      var prev = S.gallery[S.current - 1] || S.gallery[S.gallery.length - 1]
      if (prev.player == 'img') {
        var b = new Image()
        b.src = prev.content
      }
    }
  }
  function contentReady() {
    if (!S.content) {
      return
    }
    S.content.append(S.skin.bodyEl(), content_id, S.dimensions)
    S.skin.onFinish(finishContent)
  }
  function finishContent() {
    if (!S.content) {
      return
    }
    if (S.content.onLoad) {
      S.content.onLoad()
    }
    if (S.options.onFinish) {
      S.options.onFinish()
    }
    if (!S.isPaused()) {
      S.play()
    }
    listenKeys(true)
  }
  window.Shadowbox = S
})()
;(function () {
  var g = Shadowbox,
    f = g.util,
    q = false,
    b = [],
    m = ['sb-nav-close', 'sb-nav-next', 'sb-nav-play', 'sb-nav-pause', 'sb-nav-previous'],
    o = {
      markup:
        '<div id="sb-container"><div id="sb-overlay"></div><div id="sb-wrapper"><a id="sb-nav-close" title="{close}" onclick="Shadowbox.close()"></a><div id="sb-title"><div id="sb-title-inner"></div></div><div id="sb-body"><div id="sb-body-inner"></div><div id="sb-loading"><a onclick="Shadowbox.close()">{cancel}</a></div></div><div id="sb-info"><div id="sb-info-inner"><div id="sb-counter"></div><div id="sb-nav"><a id="sb-nav-next" title="{next}" onclick="Shadowbox.next()"></a><a id="sb-nav-play" title="{play}" onclick="Shadowbox.play()"></a><a id="sb-nav-pause" title="{pause}" onclick="Shadowbox.pause()"></a><a id="sb-nav-previous" title="{previous}" onclick="Shadowbox.previous()"></a></div><div style="clear:both"></div></div></div></div></div>',
      options: {
        animSequence: 'sync',
        autoDimensions: false,
        counterLimit: 10,
        counterType: 'default',
        displayCounter: true,
        displayNav: true,
        fadeDuration: 0.35,
        initialHeight: 160,
        initialWidth: 320,
        modal: false,
        overlayColor: '#000',
        overlayOpacity: 0.8,
        resizeDuration: 0.35,
        showOverlay: true,
        troubleElements: ['select', 'object', 'embed', 'canvas'],
      },
      init: function () {
        var s = o.markup.replace(/\{(\w+)\}/g, function (w, x) {
          return g.lang[x]
        })
        g.lib.append(document.body, s)
        if (g.client.isIE6) {
          f.get('sb-body').style.zoom = 1
          var u,
            r,
            t = /url\("(.*\.png)"\)/
          f.each(m, function (w) {
            u = f.get(w)
            if (u) {
              r = g.lib.getStyle(u, 'backgroundImage').match(t)
              if (r) {
                u.style.backgroundImage = 'none'
                u.style.filter =
                  'progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,src=' +
                  r[1] +
                  ',sizingMethod=scale);'
              }
            }
          })
        }
        var v
        g.lib.addEvent(window, 'resize', function () {
          if (v) {
            clearTimeout(v)
            v = null
          }
          if (g.isActive()) {
            v = setTimeout(function () {
              o.onWindowResize()
              var w = g.content
              if (w && w.onWindowResize) {
                w.onWindowResize()
              }
            }, 50)
          }
        })
      },
      bodyEl: function () {
        return f.get('sb-body-inner')
      },
      onOpen: function (u, r) {
        e(false)
        var t = g.options.autoDimensions && 'height' in u ? u.height : g.options.initialHeight,
          s = g.options.autoDimensions && 'width' in u ? u.width : g.options.initialWidth
        f.get('sb-container').style.display = 'block'
        var v = p(t, s)
        d(v.inner_h, v.top, false)
        h(v.width, v.left, false)
        i(r)
      },
      onLoad: function (s, t, r) {
        k(true)
        j(t, function () {
          if (!s) {
            return
          }
          if (!t) {
            f.get('sb-wrapper').style.display = ''
          }
          r()
        })
      },
      onReady: function (r) {
        var t = g.content
        if (!t) {
          return
        }
        var s = p(t.height, t.width, t.resizable)
        o.resizeContent(s.inner_h, s.width, s.top, s.left, true, function () {
          l(r)
        })
      },
      onFinish: function (r) {
        k(false, r)
      },
      onClose: function () {
        i()
        e(true)
      },
      onPlay: function () {
        c('play', false)
        c('pause', true)
      },
      onPause: function () {
        c('pause', false)
        c('play', true)
      },
      onWindowResize: function () {
        var t = g.content
        if (!t) {
          return
        }
        var s = p(t.height, t.width, t.resizable)
        h(s.width, s.left, false)
        d(s.inner_h, s.top, false)
        var r = f.get(g.contentId())
        if (r) {
          if (t.resizable && g.options.handleOversize == 'resize') {
            r.height = s.resize_h
            r.width = s.resize_w
          }
        }
      },
      resizeContent: function (s, t, w, v, u, r) {
        var y = g.content
        if (!y) {
          return
        }
        var x = p(y.height, y.width, y.resizable)
        switch (g.options.animSequence) {
          case 'hw':
            d(x.inner_h, x.top, u, function () {
              h(x.width, x.left, u, r)
            })
            break
          case 'wh':
            h(x.width, x.left, u, function () {
              d(x.inner_h, x.top, u, r)
            })
            break
          default:
            h(x.width, x.left, u)
            d(x.inner_h, x.top, u, r)
        }
      },
    }
  function n() {
    f.get('sb-container').style.top = document.documentElement.scrollTop + 'px'
  }
  function e(r) {
    if (r) {
      f.each(b, function (s) {
        s[0].style.visibility = s[1] || ''
      })
    } else {
      b = []
      f.each(g.options.troubleElements, function (s) {
        f.each(document.getElementsByTagName(s), function (t) {
          b.push([t, t.style.visibility])
          t.style.visibility = 'hidden'
        })
      })
    }
  }
  function i(r) {
    var s = f.get('sb-overlay'),
      t = f.get('sb-container'),
      v = f.get('sb-wrapper')
    if (r) {
      if (g.client.isIE6) {
        n()
        g.lib.addEvent(window, 'scroll', n)
      }
      if (g.options.showOverlay) {
        q = true
        s.style.backgroundColor = g.options.overlayColor
        f.setOpacity(s, 0)
        if (!g.options.modal) {
          g.lib.addEvent(s, 'click', g.close)
        }
        v.style.display = 'none'
      }
      t.style.visibility = 'visible'
      if (q) {
        var u = parseFloat(g.options.overlayOpacity)
        f.animate(s, 'opacity', u, g.options.fadeDuration, r)
      } else {
        r()
      }
    } else {
      if (g.client.isIE6) {
        g.lib.removeEvent(window, 'scroll', n)
      }
      g.lib.removeEvent(s, 'click', g.close)
      if (q) {
        v.style.display = 'none'
        f.animate(s, 'opacity', 0, g.options.fadeDuration, function () {
          t.style.display = ''
          v.style.display = ''
          f.clearOpacity(s)
        })
      } else {
        t.style.visibility = 'hidden'
      }
    }
  }
  function c(t, r) {
    var s = f.get('sb-nav-' + t)
    if (s) {
      s.style.display = r ? '' : 'none'
    }
  }
  function k(s, r) {
    var u = f.get('sb-loading'),
      w = g.getCurrent().player,
      v = w == 'img' || w == 'html'
    if (s) {
      function t() {
        f.clearOpacity(u)
        if (r) {
          r()
        }
      }
      f.setOpacity(u, 0)
      u.style.display = ''
      if (v) {
        f.animate(u, 'opacity', 1, g.options.fadeDuration, t)
      } else {
        t()
      }
    } else {
      function t() {
        u.style.display = 'none'
        f.clearOpacity(u)
        if (r) {
          r()
        }
      }
      if (v) {
        f.animate(u, 'opacity', 0, g.options.fadeDuration, t)
      } else {
        t()
      }
    }
  }
  function a(u) {
    var z = g.getCurrent()
    f.get('sb-title-inner').innerHTML = z.title || ''
    var C, t, x, D, s
    if (g.options.displayNav) {
      C = true
      var B = g.gallery.length
      if (B > 1) {
        if (g.options.continuous) {
          t = s = true
        } else {
          t = B - 1 > g.current
          s = g.current > 0
        }
      }
      if (g.options.slideshowDelay > 0 && g.hasNext()) {
        D = !g.isPaused()
        x = !D
      }
    } else {
      C = t = x = D = s = false
    }
    c('close', C)
    c('next', t)
    c('play', x)
    c('pause', D)
    c('previous', s)
    var r = ''
    if (g.options.displayCounter && g.gallery.length > 1) {
      var B = g.gallery.length
      if (g.options.counterType == 'skip') {
        var y = 0,
          w = B,
          v = parseInt(g.options.counterLimit) || 0
        if (v < B && v > 2) {
          var A = Math.floor(v / 2)
          y = g.current - A
          if (y < 0) {
            y += B
          }
          w = g.current + (v - A)
          if (w > B) {
            w -= B
          }
        }
        while (y != w) {
          if (y == B) {
            y = 0
          }
          r += '<a onclick="Shadowbox.change(' + y + ');"'
          if (y == g.current) {
            r += ' class="sb-counter-current"'
          }
          r += '>' + y++ + '</a>'
        }
      } else {
        var r = g.current + 1 + ' ' + g.lang.of + ' ' + B
      }
    }
    f.get('sb-counter').innerHTML = r
    u()
  }
  function j(u, s) {
    var y = f.get('sb-wrapper'),
      B = f.get('sb-title'),
      v = f.get('sb-info'),
      r = f.get('sb-title-inner'),
      z = f.get('sb-info-inner'),
      A = parseInt(g.lib.getStyle(r, 'height')) || 0,
      x = parseInt(g.lib.getStyle(z, 'height')) || 0
    var w = function () {
      r.style.visibility = z.style.visibility = 'hidden'
      a(s)
    }
    if (u) {
      f.animate(B, 'height', 0, 0.35)
      f.animate(v, 'height', 0, 0.35)
      f.animate(y, 'paddingTop', A, 0.35)
      f.animate(y, 'paddingBottom', x, 0.35, w)
    } else {
      B.style.height = v.style.height = '0px'
      y.style.paddingTop = A + 'px'
      y.style.paddingBottom = x + 'px'
      w()
    }
  }
  function l(u) {
    var s = f.get('sb-wrapper'),
      w = f.get('sb-title'),
      v = f.get('sb-info'),
      z = f.get('sb-title-inner'),
      y = f.get('sb-info-inner'),
      x = parseInt(g.lib.getStyle(z, 'height')) || 0,
      r = parseInt(g.lib.getStyle(y, 'height')) || 0
    z.style.visibility = y.style.visibility = ''
    if (z.innerHTML != '') {
      f.animate(w, 'height', x, 0.35)
      f.animate(s, 'paddingTop', 0, 0.35)
    }
    f.animate(v, 'height', r, 0.35)
    f.animate(s, 'paddingBottom', 0, 0.35, u)
  }
  function d(u, z, y, r) {
    var A = f.get('sb-body'),
      x = f.get('sb-wrapper'),
      w = parseInt(u),
      v = parseInt(z)
    if (y) {
      f.animate(A, 'height', w, g.options.resizeDuration)
      f.animate(x, 'top', v, g.options.resizeDuration, r)
    } else {
      A.style.height = w + 'px'
      x.style.top = v + 'px'
      if (r) {
        r()
      }
    }
  }
  function h(x, z, y, r) {
    var v = f.get('sb-wrapper'),
      u = parseInt(x),
      t = parseInt(z)
    if (y) {
      f.animate(v, 'width', u, g.options.resizeDuration)
      f.animate(v, 'left', t, g.options.resizeDuration, r)
    } else {
      v.style.width = u + 'px'
      v.style.left = t + 'px'
      if (r) {
        r()
      }
    }
  }
  function p(r, u, t) {
    var s = f.get('sb-body-inner')
    ;(sw = f.get('sb-wrapper')),
      (so = f.get('sb-overlay')),
      (tb = sw.offsetHeight - s.offsetHeight),
      (lr = sw.offsetWidth - s.offsetWidth),
      (max_h = so.offsetHeight),
      (max_w = so.offsetWidth)
    g.setDimensions(r, u, max_h, max_w, tb, lr, t)
    return g.dimensions
  }
  g.skin = o
})()
if (typeof jQuery == 'undefined') {
  throw 'Unable to load Shadowbox adapter, jQuery not found'
}
if (typeof Shadowbox == 'undefined') {
  throw 'Unable to load Shadowbox adapter, Shadowbox not found'
}
;(function (b, a) {
  a.lib = {
    getStyle: function (d, c) {
      return b(d).css(c)
    },
    remove: function (c) {
      b(c).remove()
    },
    getTarget: function (c) {
      return c.target
    },
    getPageXY: function (c) {
      return [c.pageX, c.pageY]
    },
    preventDefault: function (c) {
      c.preventDefault()
    },
    keyCode: function (c) {
      return c.keyCode
    },
    addEvent: function (e, c, d) {
      b(e).bind(c, d)
    },
    removeEvent: function (e, c, d) {
      b(e).unbind(c, d)
    },
    append: function (d, c) {
      b(d).append(c)
    },
  }
})(jQuery, Shadowbox)
;(function (a) {
  a.fn.shadowbox = function (b) {
    return this.each(function () {
      var d = a(this)
      var e = a.extend({}, b || {}, a.metadata ? d.metadata() : a.meta ? d.data() : {})
      var c = this.className || ''
      e.width = parseInt((c.match(/w:(\d+)/) || [])[1]) || e.width
      e.height = parseInt((c.match(/h:(\d+)/) || [])[1]) || e.height
      Shadowbox.setup(d, e)
    })
  }
})(jQuery)
if (typeof Shadowbox == 'undefined') {
  throw 'Unable to load Shadowbox language file, Shadowbox not found.'
}
Shadowbox.lang = {
  code: 'en',
  of: 'of',
  loading: 'loading',
  cancel: '',
  next: 'Next',
  previous: 'Previous',
  play: 'Play',
  pause: 'Pause',
  close: 'Close',
  errors: {
    single: 'You must install the <a href="{0}">{1}</a> browser plugin to view this content.',
    shared:
      'You must install both the <a href="{0}">{1}</a> and <a href="{2}">{3}</a> browser plugins to view this content.',
    either:
      'You must install either the <a href="{0}">{1}</a> or the <a href="{2}">{3}</a> browser plugin to view this content.',
  },
}
;(function (a) {
  a.html = function (b) {
    this.obj = b
    this.height = b.height ? parseInt(b.height, 10) : 300
    this.width = b.width ? parseInt(b.width, 10) : 500
  }
  a.html.prototype = {
    append: function (b, e, c) {
      this.id = e
      var d = document.createElement('div')
      d.id = e
      d.className = 'html'
      d.innerHTML = this.obj.content
      b.appendChild(d)
    },
    remove: function () {
      var b = document.getElementById(this.id)
      if (b) {
        a.lib.remove(b)
      }
    },
  }
})(Shadowbox)
;(function (a) {
  a.iframe = function (c) {
    this.obj = c
    var b = document.getElementById('sb-overlay')
    this.height = c.height ? parseInt(c.height, 10) : b.offsetHeight
    this.width = c.width ? parseInt(c.width, 10) : b.offsetWidth
  }
  a.iframe.prototype = {
    append: function (b, e, d) {
      this.id = e
      var c =
        '<iframe id="' +
        e +
        '" name="' +
        e +
        '" height="100%" width="100%" frameborder="0" marginwidth="0" marginheight="0" scrolling="auto"'
      if (a.client.isIE) {
        c += ' allowtransparency="true"'
        if (a.client.isIE6) {
          c += ' src="javascript:false;document.write(\'\');"'
        }
      }
      c += '></iframe>'
      b.innerHTML = c
    },
    remove: function () {
      var b = document.getElementById(this.id)
      if (b) {
        a.lib.remove(b)
        if (a.client.isGecko) {
          delete window.frames[this.id]
        }
      }
    },
    onLoad: function () {
      var b = a.client.isIE ? document.getElementById(this.id).contentWindow : window.frames[this.id]
      b.location.href = this.obj.content
    },
  }
})(Shadowbox)
;(function (h) {
  var e = h.util,
    i,
    k,
    j = 'sb-drag-layer',
    d
  function b() {
    i = { x: 0, y: 0, start_x: null, start_y: null }
  }
  function c(m, o, l) {
    if (m) {
      b()
      var n = [
        'position:absolute',
        'height:' + o + 'px',
        'width:' + l + 'px',
        'cursor:' + (h.client.isGecko ? '-moz-grab' : 'move'),
        'background-color:' + (h.client.isIE ? '#fff;filter:alpha(opacity=0)' : 'transparent'),
      ].join(';')
      h.lib.append(h.skin.bodyEl(), '<div id="' + j + '" style="' + n + '"></div>')
      h.lib.addEvent(e.get(j), 'mousedown', g)
    } else {
      var p = e.get(j)
      if (p) {
        h.lib.removeEvent(p, 'mousedown', g)
        h.lib.remove(p)
      }
      k = null
    }
  }
  function g(m) {
    h.lib.preventDefault(m)
    var l = h.lib.getPageXY(m)
    i.start_x = l[0]
    i.start_y = l[1]
    k = e.get(h.contentId())
    h.lib.addEvent(document, 'mousemove', f)
    h.lib.addEvent(document, 'mouseup', a)
    if (h.client.isGecko) {
      e.get(j).style.cursor = '-moz-grabbing'
    }
  }
  function a() {
    h.lib.removeEvent(document, 'mousemove', f)
    h.lib.removeEvent(document, 'mouseup', a)
    if (h.client.isGecko) {
      e.get(j).style.cursor = '-moz-grab'
    }
  }
  function f(o) {
    var q = h.content,
      p = h.dimensions,
      n = h.lib.getPageXY(o)
    var m = n[0] - i.start_x
    i.start_x += m
    i.x = Math.max(Math.min(0, i.x + m), p.inner_w - q.width)
    k.style.left = i.x + 'px'
    var l = n[1] - i.start_y
    i.start_y += l
    i.y = Math.max(Math.min(0, i.y + l), p.inner_h - q.height)
    k.style.top = i.y + 'px'
  }
  h.img = function (m) {
    this.obj = m
    this.resizable = true
    this.ready = false
    var l = this
    d = new Image()
    d.onload = function () {
      l.height = m.height ? parseInt(m.height, 10) : d.height
      l.width = m.width ? parseInt(m.width, 10) : d.width
      l.ready = true
      d.onload = ''
      d = null
    }
    d.src = m.content
  }
  h.img.prototype = {
    append: function (l, o, n) {
      this.id = o
      var m = document.createElement('img')
      m.id = o
      m.src = this.obj.content
      m.style.position = 'absolute'
      m.setAttribute('height', n.resize_h)
      m.setAttribute('width', n.resize_w)
      l.appendChild(m)
    },
    remove: function () {
      var l = e.get(this.id)
      if (l) {
        h.lib.remove(l)
      }
      c(false)
      if (d) {
        d.onload = ''
        d = null
      }
    },
    onLoad: function () {
      var l = h.dimensions
      if (l.oversized && h.options.handleOversize == 'drag') {
        c(true, l.resize_h, l.resize_w)
      }
    },
    onWindowResize: function () {
      if (k) {
        var p = h.content,
          o = h.dimensions,
          n = parseInt(h.lib.getStyle(k, 'top')),
          m = parseInt(h.lib.getStyle(k, 'left'))
        if (n + p.height < o.inner_h) {
          k.style.top = o.inner_h - p.height + 'px'
        }
        if (m + p.width < o.inner_w) {
          k.style.left = o.inner_w - p.width + 'px'
        }
      }
    },
  }
})(Shadowbox)
Shadowbox.options.players = ['html', 'iframe', 'img']
Shadowbox.options.useSizzle = false
