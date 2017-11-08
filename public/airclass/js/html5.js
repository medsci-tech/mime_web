!window.qcVideo && function (global) {
    function getMappingArgs(fn) {
        var args = fn.toString().split("{")[0].replace(/\s|function|\(|\)/g, "").split(","), i = 0;
        for (args[0] || (args = []); args[i];) args[i] = require(args[i]), i += 1;
        return args
    }

    function newInst(key, ifExist) {
        (ifExist ? ns.instances[key] : !ns.instances[key]) && ns.modules[key] && (ns.instances[key] = ns.modules[key].apply(window, getMappingArgs(ns.modules[key])))
    }

    function require(key) {
        return newInst(key, !1), ns.instances[key] || {}
    }

    function loadJs(url, onLoadCB, onErrorCB) {
        var el = document.createElement("script");
        el.setAttribute("type", "text/javascript"), el.setAttribute("src", url), el.setAttribute("async", !0), onLoadCB && (el.onload = onLoadCB), onErrorCB && (el.onerror = onErrorCB), document.getElementsByTagName("head")[0].appendChild(el)
    }

    function core(key, target) {
        if (!ns.modules[key] && (ns.modules[key] = target, newInst(key, !0), waiter[key])) {
            for (var i = 0; waiter[key][i];) waiter[key][i](require(key)), i += 1;
            delete waiter[key]
        }
    }

    var ns = {modules: {}, instances: {}}, waiter = {};
    core.use = function (key, cb) {
        if (cb = cb || function () {
            }, ns.modules[key]) cb(require(key)); else {
            var config = require("config");
            config[key] && (waiter[key] || (waiter[key] = [], loadJs(config[key])), waiter[key].push(cb))
        }
    }, core.get = function (key) {
        return require(key)
    }, core.loadJs = loadJs, global.qcVideo = core
}(window), qcVideo("Base", function (util) {
    var unique = "base_" + +new Date, global = window, uuid = 1, Base = function () {
    }, debug = !0, realConsole = global.console, console = realConsole || {}, wrap = function (fn) {
        return function () {
            if (debug) try {
                fn.apply(realConsole, [this.__get_class_info__()].concat(arguments))
            } catch (xe) {
            }
        }
    };
    Base.prototype.__get_class_info__ = function () {
        var now = new Date;
        return now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds() + ">" + (this.className || "BASE") + ">"
    }, Base.setDebug = function (open) {
        debug = !!open
    }, Base.filter_error = function (fn, name) {
        return "function" != util.type(fn) ? fn : function () {
            try {
                return fn.apply(this, arguments)
            } catch (xe) {
                var rep = qcVideo.get("BJ_REPORT");
                throw rep && rep.push && (xe.stack && (xe.stack = (this.className || "") + "-" + (name || "constructor") + " " + xe.stack), rep.push(xe)), new Error(xe.message || "")
            }
        }
    }, Base.prototype.loop = Base.loop = function () {
    }, Base.extend = function (protoProps, staticProps) {
        protoProps = protoProps || {};
        var constructor = protoProps.hasOwnProperty("constructor") ? protoProps.constructor : function () {
            return sup.apply(this, arguments)
        };
        constructor = Base.filter_error(constructor);
        var kk, sup = this, Fn = function () {
            this.constructor = constructor
        };
        if (protoProps) for (kk in protoProps) protoProps[kk] = Base.filter_error(protoProps[kk], kk);
        return Fn.prototype = sup.prototype, constructor.prototype = new Fn, util.merge(constructor.prototype, protoProps), util.merge(constructor, sup, !0), util.merge(constructor, staticProps), util.merge(constructor, {__super__: sup.prototype}), constructor
    }, Base.prototype.log = wrap(console.log || Base.loop), Base.prototype.debug = wrap(console.debug || Base.loop), Base.prototype.error = wrap(console.error || Base.loop), Base.prototype.info = wrap(console.info || Base.loop);
    var eventCache = {}, getUniqueId = function () {
        return this.__id || (this.__id = unique + ++uuid)
    }, initEvent = function (ctx, event) {
        var id = getUniqueId.call(ctx);
        eventCache.hasOwnProperty(id) || (eventCache[id] = {}), event && (eventCache[id][event] || (eventCache[id][event] = []))
    };
    return Base.prototype.on = function (ctx, event, fn) {
        initEvent(ctx, event), eventCache[getUniqueId.call(ctx)][event].push(fn)
    }, Base.prototype.batchOn = function (ctx, ary) {
        for (var i = 0, j = ary.length; i < j; i++) this.on(ctx, ary[i].event, ary[i].fn)
    }, Base.prototype.fire = function (event, opt) {
        var cache = eventCache[getUniqueId.call(this)];
        cache && cache[event] && util.each(cache[event], function (fn) {
            fn.call(global, opt)
        })
    }, Base.prototype.off = function (ctx, event, fn) {
        initEvent(ctx);
        var find = -1, list = eventCache[getUniqueId.call(ctx)][event];
        util.each(list, function (handler, index) {
            if (handler === fn) return find = index, !1
        }), find !== -1 && list.splice(find, 1)
    }, Base.instance = function (opt, staticOpt) {
        return new (Base.extend(opt, staticOpt))
    }, Base
}), qcVideo("tlsPwd", function () {
    function Now() {
        return +new Date
    }

    function addTlsScript() {
        var a = document.createElement("script");
        a.src = "https://tls.qcloud.com/libs/encrypt.min.js", document.body.insertBefore(a, document.body.childNodes[0])
    }

    function getSigPwd() {
        try {
            return Encrypt.getRSAH1()
        } catch (e) {
        }
        return ""
    }

    function fetchSigPwd(cb, start) {
        var now = Now();
        if (start) getSigPwdStartTime = now, addTlsScript(); else if (now - getSigPwdStartTime > 5e3) return void cb(null, "timeout");
        var pwd = getSigPwd();
        pwd && pwd.length > 0 ? cb(pwd) : setTimeout(function () {
            fetchSigPwd(cb)
        }, 1e3)
    }

    var getSigPwdStartTime;
    return function (cb) {
        fetchSigPwd(function (pwd) {
            cb(pwd)
        }, !0)
    }
}), qcVideo("touristTlsLogin", function (tlsPwd) {
    function askJsonp(src) {
        var a = document.createElement("script");
        a.src = src, document.body.insertBefore(a, document.body.childNodes[0])
    }

    function tlsGetUserSig_JsonPCallback(info) {
        info = info || {};
        var ErrorCode = info.ErrorCode;
        clear_jsonP(), 0 == ErrorCode ? (_info.userSig = info.UserSig, _info.done(_info)) : _info.done(null, ErrorCode)
    }

    function clear_jsonP() {
        global.tlsAnoLogin = null, global.tlsGetUserSig = null
    }

    function tlsAnoLogin_JsonPCallback(info) {
        info = info || {};
        var ErrorCode = info.ErrorCode;
        0 == ErrorCode ? (_info.identifier = info.Identifier, _info.TmpSig = info.TmpSig, global.tlsGetUserSig = tlsGetUserSig_JsonPCallback, askJsonp("https://tls.qcloud.com/getusersig?tmpsig=" + _info.TmpSig + "&identifier=" + encodeURIComponent(_info.identifier) + "&accounttype=" + _info.accountType + "&sdkappid=" + _info.sdkAppID)) : (clear_jsonP(), _info.done(null, ErrorCode))
    }

    var global = window, _info = {};
    return function (sdkappid, accounttype, cb) {
        _info = {
            sdkAppID: sdkappid,
            appIDAt3rd: sdkappid,
            accountType: accounttype,
            identifier: "",
            userSig: "",
            done: cb
        }, clear_jsonP(), tlsPwd(function (pwd, error) {
            error && _info.done(null, error), askJsonp("https://tls.qcloud.com/anologin?sdkappid=" + _info.sdkAppID + "&accounttype=" + _info.accountType + "&url=&passwd=" + pwd), global.tlsAnoLogin = tlsAnoLogin_JsonPCallback
        })
    }
}), qcVideo("api", function () {
    var now = function () {
            return +new Date
        }, uuid = 0, global = window, unique = "qcvideo_" + now(), overTime = 1e4,
        request = function (address, cbName, cb) {
            return function () {
                global[cbName] = function (data) {
                    cb(data), delete global[cbName]
                }, setTimeout(function () {
                    "undefined" != typeof global[cbName] && (delete global[cbName], cb({retcode: 1e4, errmsg: "请求超时"}))
                }, overTime), qcVideo.loadJs(address + (address.indexOf("?") > 0 ? "&" : "?") + "callback=" + cbName, function (e) {
                    "undefined" != typeof global[cbName] && (delete global[cbName], cb({retcode: 10001, errmsg: ""}))
                }, function (e) {
                    "undefined" != typeof global[cbName] && (delete global[cbName], cb({retcode: 10002, errmsg: ""}))
                })
            }
        }, hiSender = function () {
            var img = new Image;
            return function (src) {
                img.onload = img.onerror = img.onabort = function () {
                    img.onload = img.onerror = img.onabort = null, img = null
                }, img.src = src
            }
        }, apdTime = function (url) {
            return url + (url.indexOf("?") > 0 ? "&" : "?") + "_=" + now()
        };
    return {
        request: function (address, cb) {
            var cbName = unique + "_callback" + ++uuid;
            request(apdTime(address), cbName, cb)()
        }, report: function (address) {
            hiSender()(apdTime(address))
        }
    }
}), qcVideo("BJ_REPORT", function () {
    return function (global) {
        if (global.BJ_REPORT) return global.BJ_REPORT;
        var _error = [], _config = {
            id: 0,
            uin: 0,
            url: "",
            combo: 1,
            ext: {},
            level: 4,
            ignore: [],
            random: 1,
            delay: 1e3,
            submit: null
        }, _isOBJByType = function (o, type) {
            return Object.prototype.toString.call(o) === "[object " + (type || "Object") + "]"
        }, _isOBJ = function (obj) {
            var type = typeof obj;
            return "object" === type && !!obj
        }, _isEmpty = function (obj) {
            return null === obj || !_isOBJByType(obj, "Number") && !obj
        }, _processError = (global.onerror, function (errObj) {
            try {
                if (errObj.stack) {
                    var url = errObj.stack.match("https?://[^\n]+");
                    url = url ? url[0] : "";
                    var rowCols = url.match(":(\\d+):(\\d+)");
                    rowCols || (rowCols = [0, 0, 0]);
                    var stack = _processStackMsg(errObj);
                    return {msg: stack, rowNum: rowCols[1], colNum: rowCols[2], target: url.replace(rowCols[0], "")}
                }
                return errObj
            } catch (err) {
                return errObj
            }
        }), _processStackMsg = function (error) {
            var stack = error.stack.replace(/\n/gi, "").split(/\bat\b/).slice(0, 5).join("@").replace(/\?[^:]+/gi, ""),
                msg = error.toString();
            return stack.indexOf(msg) < 0 && (stack = msg + "@" + stack), stack
        }, _error_tostring = function (error, index) {
            var param = [], params = [], stringify = [];
            if (_isOBJ(error)) {
                error.level = error.level || _config.level;
                for (var key in error) {
                    var value = error[key];
                    if (!_isEmpty(value)) {
                        if (_isOBJ(value)) try {
                            value = JSON.stringify(value)
                        } catch (err) {
                            value = "[BJ_REPORT detect value stringify error] " + err.toString()
                        }
                        stringify.push(key + ":" + value), param.push(key + "=" + encodeURIComponent(value)), params.push(key + "[" + index + "]=" + encodeURIComponent(value))
                    }
                }
            }
            return [params.join("&"), stringify.join(","), param.join("&")]
        }, _imgs = [], _submit = function (url) {
            if (_config.submit) _config.submit(url); else {
                var _img = new Image;
                _imgs.push(_img), _img.src = url
            }
        }, error_list = [], comboTimeout = 0, _send = function (isReoprtNow) {
            if (_config.report) {
                for (; _error.length;) {
                    var isIgnore = !1, error = _error.shift(), error_str = _error_tostring(error, error_list.length);
                    if (_isOBJByType(_config.ignore, "Array")) for (var i = 0, l = _config.ignore.length; i < l; i++) {
                        var rule = _config.ignore[i];
                        if (_isOBJByType(rule, "RegExp") && rule.test(error_str[1]) || _isOBJByType(rule, "Function") && rule(error, error_str[1])) {
                            isIgnore = !0;
                            break
                        }
                    }
                    isIgnore || (_config.combo ? error_list.push(error_str[0]) : _submit(_config.report + error_str[2] + "&_t=" + +new Date), _config.onReport && _config.onReport(_config.id, error))
                }
                var count = error_list.length;
                if (count) {
                    var comboReport = function () {
                        clearTimeout(comboTimeout), _submit(_config.report + error_list.join("&") + "&count=" + count + "&_t=" + +new Date), comboTimeout = 0, error_list = []
                    };
                    isReoprtNow ? comboReport() : comboTimeout || (comboTimeout = setTimeout(comboReport, _config.delay))
                }
            }
        }, report = {
            push: function (msg) {
                return Math.random() >= _config.random ? report : (_error.push(_isOBJ(msg) ? _processError(msg) : {msg: msg}), _send(), report)
            }, report: function (msg) {
                return msg && report.push(msg), _send(!0), report
            }, info: function (msg) {
                return msg ? (_isOBJ(msg) ? msg.level = 2 : msg = {
                    msg: msg,
                    level: 2
                }, report.push(msg), report) : report
            }, debug: function (msg) {
                return msg ? (_isOBJ(msg) ? msg.level = 1 : msg = {
                    msg: msg,
                    level: 1
                }, report.push(msg), report) : report
            }, init: function (config) {
                if (_isOBJ(config)) for (var key in config) _config[key] = config[key];
                var id = parseInt(_config.id, 10);
                return id && (_config.report = (_config.url || "//badjs2.qq.com/badjs") + "?id=" + id + "&uin=" + parseInt(_config.uin || (document.cookie.match(/\buin=\D+(\d+)/) || [])[1], 10) + "&from=" + encodeURIComponent(location.href) + "&ext=" + JSON.stringify(_config.ext) + "&"), report
            }, __onerror__: global.onerror
        };
        return "undefined" != typeof console && console.error && setTimeout(function () {
            var err = ((location.hash || "").match(/([#&])BJ_ERROR=([^&$]+)/) || [])[2];
            err && console.error("BJ_ERROR", decodeURIComponent(err).replace(/(:\d+:\d+)\s*/g, "$1\n"))
        }, 0), report
    }(window)
}), qcVideo("codeReport", function (api, version) {
    function report(domain, cgi, type, code, time) {
        var obj = {
            domain: domain,
            cgi: cgi,
            type: type,
            code: code,
            time: time,
            appid: 20182,
            platform: version.IOS ? "ios" : version.ANDROID ? "android" : "pc",
            expansion1: "h5",
            expansion2: from
        }, params = "";
        for (var k in obj) params += k + "=", params += encodeURIComponent(obj[k]), params += "&";
        params = params.substr(0, params.length - 1), api.report(("https:" == location.protocol ? REPORT_URL_HTTPS : REPORT_URL) + "?" + params)
    }

    var now = function () {
            return +(new Date).getTime()
        }, REPORT_URL = "//report.huatuo.qq.com/code.cgi", REPORT_URL_HTTPS = "//report.huatuo.qq.com/code.cgi", url = "",
        cgiStartPoint = 0, cgiEndPoint = 0, from = "";
    return {
        reportStart: function (_url, _from) {
            cgiStartPoint = now(), url = _url, from = _from
        }, reportEnd: function (type, code) {
            cgiEndPoint = now(), url = url.substring(url.indexOf(":") + 3, url.indexOf("?")), report(url.substring(0, url.indexOf("/")), url.substring(url.indexOf("/"), url.length), type, code, cgiEndPoint - cgiStartPoint)
        }, reportParams: function (params) {
            api.report(("https:" == location.protocol ? REPORT_URL_HTTPS : REPORT_URL) + "?" + params)
        }
    }
}), qcVideo("css", function () {
    var css = {};
    return document.defaultView && document.defaultView.getComputedStyle ? css.getComputedStyle = function (a, b) {
        var c, d, e;
        return b = b.replace(/([A-Z]|^ms)/g, "-$1").toLowerCase(), (d = a.ownerDocument.defaultView) && (e = d.getComputedStyle(a, null)) && (c = e.getPropertyValue(b)), c
    } : document.documentElement.currentStyle && (css.getComputedStyle = function (a, b) {
        var c, d = a.currentStyle && a.currentStyle[b], e = a.style;
        return null === d && e && (c = e[b]) && (d = c), d
    }), {
        getWidth: function (e) {
            return 0 | (css.getComputedStyle(e, "width") || "").toLowerCase().replace("px", "")
        }, getHeight: function (e) {
            return 0 | (css.getComputedStyle(e, "height") || "").toLowerCase().replace("px", "")
        }, textAlign: function (e) {
            e.style["text-align"] = "center"
        }, getVisibleHeight: function () {
            var doc = document, docE = doc.documentElement, body = doc.body;
            return docE && docE.clientHeight || body && body.offsetHeight || window.innerHeight || 0
        }, getVisibleWidth: function () {
            var doc = document, docE = doc.documentElement, body = doc.body;
            return docE && docE.clientWidth || body && body.offsetWidth || window.innerWidth || 0
        }
    }
}), qcVideo("interval", function () {
    function each(cb) {
        for (var key in stack) if (!1 === cb.call(stack[key])) return
    }

    function tick() {
        var now = +new Date;
        each(function () {
            var me = this;
            !me.__time && (me.__time = now), me.__time + me._ftp <= now && 1 === me.status && (me.__time = now, me._cb.call())
        })
    }

    function stop() {
        var start = 0;
        each(function () {
            1 === this.status && (start += 1)
        }), 0 !== start && 0 !== length || (clearInterval(git), git = null)
    }

    function _start() {
        this.status = 1, !git && (git = setInterval(tick, gTime))
    }

    function _pause() {
        this.status = 0, this.__time = +new Date, stop()
    }

    function _clear() {
        delete stack[this._id], length -= 1, stop()
    }

    var git, stack = {}, length = 0, gTime = 16, uuid = 0;
    return function (callback, time) {
        return length += 1, uuid += 1, stack[uuid] = {
            _id: uuid,
            _cb: callback,
            _ftp: time || gTime,
            start: _start,
            pause: _pause,
            clear: _clear
        }
    }
}), "object" != typeof JSON && (JSON = {}), function () {
    "use strict";

    function f(n) {
        return n < 10 ? "0" + n : n
    }

    function quote(string) {
        return escapable.lastIndex = 0, escapable.test(string) ? '"' + string.replace(escapable, function (a) {
            var c = meta[a];
            return "string" == typeof c ? c : "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4)
        }) + '"' : '"' + string + '"'
    }

    function str(key, holder) {
        var i, k, v, length, partial, mind = gap, value = holder[key];
        switch (value && "object" == typeof value && "function" == typeof value.toJSON && (value = value.toJSON(key)), "function" == typeof rep && (value = rep.call(holder, key, value)), typeof value) {
            case"string":
                return quote(value);
            case"number":
                return isFinite(value) ? String(value) : "null";
            case"boolean":
            case"null":
                return String(value);
            case"object":
                if (!value) return "null";
                if (gap += indent, partial = [], "[object Array]" === Object.prototype.toString.apply(value)) {
                    for (length = value.length, i = 0; i < length; i += 1) partial[i] = str(i, value) || "null";
                    return v = 0 === partial.length ? "[]" : gap ? "[\n" + gap + partial.join(",\n" + gap) + "\n" + mind + "]" : "[" + partial.join(",") + "]", gap = mind, v
                }
                if (rep && "object" == typeof rep) for (length = rep.length, i = 0; i < length; i += 1) "string" == typeof rep[i] && (k = rep[i], v = str(k, value), v && partial.push(quote(k) + (gap ? ": " : ":") + v)); else for (k in value) Object.prototype.hasOwnProperty.call(value, k) && (v = str(k, value), v && partial.push(quote(k) + (gap ? ": " : ":") + v));
                return v = 0 === partial.length ? "{}" : gap ? "{\n" + gap + partial.join(",\n" + gap) + "\n" + mind + "}" : "{" + partial.join(",") + "}", gap = mind, v
        }
    }

    "function" != typeof Date.prototype.toJSON && (Date.prototype.toJSON = function () {
        return isFinite(this.valueOf()) ? this.getUTCFullYear() + "-" + f(this.getUTCMonth() + 1) + "-" + f(this.getUTCDate()) + "T" + f(this.getUTCHours()) + ":" + f(this.getUTCMinutes()) + ":" + f(this.getUTCSeconds()) + "Z" : null
    }, String.prototype.toJSON = Number.prototype.toJSON = Boolean.prototype.toJSON = function () {
        return this.valueOf()
    });
    var cx, escapable, gap, indent, meta, rep;
    "function" != typeof JSON.stringify && (escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g, meta = {
        "\b": "\\b",
        "\t": "\\t",
        "\n": "\\n",
        "\f": "\\f",
        "\r": "\\r",
        '"': '\\"',
        "\\": "\\\\"
    }, JSON.stringify = function (value, replacer, space) {
        var i;
        if (gap = "", indent = "", "number" == typeof space) for (i = 0; i < space; i += 1) indent += " "; else "string" == typeof space && (indent = space);
        if (rep = replacer, replacer && "function" != typeof replacer && ("object" != typeof replacer || "number" != typeof replacer.length)) throw new Error("JSON.stringify");
        return str("", {"": value})
    }), "function" != typeof JSON.parse && (cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g, JSON.parse = function (text, reviver) {
        function walk(holder, key) {
            var k, v, value = holder[key];
            if (value && "object" == typeof value) for (k in value) Object.prototype.hasOwnProperty.call(value, k) && (v = walk(value, k), void 0 !== v ? value[k] = v : delete value[k]);
            return reviver.call(holder, key, value)
        }

        var j;
        if (text = String(text), cx.lastIndex = 0, cx.test(text) && (text = text.replace(cx, function (a) {
                return "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4)
            })), /^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) return j = eval("(" + text + ")"), "function" == typeof reviver ? walk({"": j}, "") : j;
        throw new SyntaxError("JSON.parse")
    })
}(), qcVideo("JSON", function () {
    return JSON
}), qcVideo("LinkIm", function (Base, touristTlsLogin) {
    return Base.extend({
        className: "LinkIm", checkLoginStatus: function (uniqueImVal) {
            var s = this.link.checkLoginBarrage(uniqueImVal);
            return "0" != s ? s : "uninit"
        }, destroy: function () {
            delete this.link, delete this.im
        }, constructor: function (link, im, uniqueImVal, done, fail) {
            var self = this;
            self.link = link, self.im = im;
            var roll = function () {
                var status = self.checkLoginStatus(uniqueImVal);
                "uninit" == status ? setTimeout(roll, 1e3) : "fail" == status ? touristTlsLogin(self.im.sdkAppID, self.im.accountType, function (info, error) {
                    error ? fail && fail("tlsLogin:" + error) : (info.groupId = self.im.groupId, info.nickName = self.im.nickName, info.appId = uniqueImVal, delete info.done, delete info.TmpSig, self.link.loginBarrage(info), done && done())
                }) : (self.link.loginBarrage({
                    appId: uniqueImVal,
                    groupId: self.im.groupId,
                    nickName: self.im.nickName
                }), done && done())
            };
            roll()
        }
    })
}), qcVideo("lStore", function () {
    function getStorage() {
        return storage ? storage : (storage = doc.body.appendChild(doc.createElement("div")), storage.style.display = "none", storage.setAttribute("data-store-js", ""), storage.addBehavior("#default#userData"), storage.load(localStorageName), storage)
    }

    var storage, get, set, remove, clear, win = window, doc = win.document, localStorageName = "localStorage",
        globalStorageName = "globalStorage", key_prefix = "qc_video_love_", ok = !1;
    set = get = remove = clear = function () {
    };
    try {
        localStorageName in win && win[localStorageName] && (storage = win[localStorageName], set = function (key, val) {
            storage.setItem(key, val)
        }, get = function (key) {
            return storage.getItem(key)
        }, remove = function (key) {
            storage.removeItem(key)
        }, clear = function () {
            storage.clear()
        }, ok = !0)
    } catch (e) {
    }
    try {
        !ok && globalStorageName in win && win[globalStorageName] && (storage = win[globalStorageName][win.location.hostname], set = function (key, val) {
            storage[key] = val
        }, get = function (key) {
            return storage[key] && storage[key].value
        }, remove = function (key) {
            delete storage[key]
        }, clear = function () {
            for (var key in storage) delete storage[key]
        }, ok = !0)
    } catch (e) {
    }
    return !ok && doc.documentElement.addBehavior && (set = function (key, val) {
        try {
            var storage = getStorage();
            storage.setAttribute(key, val), storage.save(localStorageName)
        } catch (e) {
        }
    }, get = function (key) {
        try {
            var storage = getStorage();
            return storage.getAttribute(key)
        } catch (e) {
            return ""
        }
    }, remove = function (key) {
        try {
            var storage = getStorage();
            storage.removeAttribute(key), storage.save(localStorageName)
        } catch (e) {
        }
    }, clear = function () {
        try {
            var storage = getStorage(), attributes = storage.XMLDocument.documentElement.attributes;
            storage.load(localStorageName);
            for (var attr, i = 0; attr = attributes[i]; i++) storage.removeAttribute(attr.name);
            storage.save(localStorageName)
        } catch (e) {
        }
    }), {
        get: function (key) {
            return get(key_prefix + key)
        }, set: function (key, val) {
            set(key_prefix + key, val)
        }, remove: function (key) {
            remove(key_prefix + key)
        }, clear: clear
    }
}), qcVideo("util", function () {
    var util = {
        paramsToObject: function (link) {
            var pairs, pair, query, key, value, result = {};
            query = link || "", query = query.replace("?", ""), pairs = query.split("&");
            for (var i = 0, j = pairs.length; i < j; i++) {
                var keyVal = pairs[i];
                pair = keyVal.split("="), key = pair[0], value = pair.slice(1).join("="), result[decodeURIComponent(key)] = decodeURIComponent(value)
            }
            return result
        }, each: function (opt, cb) {
            var i, j, key = 0;
            if (this.isArray(opt)) for (i = 0, j = opt.length; i < j && !1 !== cb.call(opt[i], opt[i], i); i++) ; else if (this.isPlainObject(opt)) for (key in opt) if (!1 === cb.call(opt[key], opt[key], key)) break
        }
    }, toString = Object.prototype.toString, hasOwn = Object.prototype.hasOwnProperty, class2type = {
        "[object Boolean]": "boolean",
        "[object Number]": "number",
        "[object String]": "string",
        "[object Function]": "function",
        "[object Array]": "array",
        "[object Date]": "date",
        "[object RegExp]": "regExp",
        "[object Object]": "object"
    }, isWindow = function (obj) {
        return obj && "object" == typeof obj && "setInterval" in obj
    };
    return util.type = function (obj) {
        return null == obj ? String(obj) : class2type[toString.call(obj)] || "object"
    }, util.isArray = Array.isArray || function (obj) {
        return "array" === util.type(obj)
    }, util.isPlainObject = function (obj) {
        if (!obj || "object" !== util.type(obj) || obj.nodeType || isWindow(obj)) return !1;
        if (obj.constructor && !hasOwn.call(obj, "constructor") && !hasOwn.call(obj.constructor.prototype, "isPrototypeOf")) return !1;
        var key;
        for (key in obj) ;
        return void 0 === key || hasOwn.call(obj, key)
    }, util.merge = function (tar, sou, deep) {
        var name, src, copy, clone, copyIsArray;
        for (name in sou) src = tar[name], copy = sou[name], tar !== copy && (deep && copy && (util.isPlainObject(copy) || (copyIsArray = util.isArray(copy))) ? (copyIsArray ? (copyIsArray = !1, clone = src && util.isArray(src) ? src : []) : clone = src && util.isPlainObject(src) ? src : {}, tar[name] = util.merge(clone, copy, deep)) : void 0 !== copy && (tar[name] = copy));
        return tar
    }, util.capitalize = function (str) {
        return str = str || "", str.charAt(0).toUpperCase() + str.slice(1)
    }, util.convertTime = function (s) {
        s = 0 | s;
        var h = 3600, m = 60, hours = s / h | 0, minutes = (s - hours * h) / m | 0, sec = s - hours * h - minutes * m;
        return hours = hours > 0 ? hours + ":" : "", minutes = minutes > 0 ? minutes + ":" : "00:", sec = sec > 0 ? sec + "" : hours.length > 0 || minutes.length > 0 ? "00" : "00:00:00", hours = 2 == hours.length ? "0" + hours : hours, minutes = 2 == minutes.length ? "0" + minutes : minutes, sec = 1 == sec.length ? "0" + sec : sec, hours + minutes + sec
    }, util.fix2 = function (num) {
        return num.toFixed(2) - 0
    }, util.fileType = function (src) {
        return src.indexOf(".mp4") > 0 ? "mp4" : src.indexOf(".m3u8") > 0 ? "hls" : void 0
    }, util.loadImg = function (url, ready) {
        var onReady, width, height, newWidth, newHeight, img = new Image;
        return img.src = url, img.complete ? void ready.call(img) : (width = img.width, height = img.height, img.onerror = function () {
            onReady.end = !0, img = img.onload = img.onerror = null
        }, onReady = function () {
            newWidth = img.width, newHeight = img.height, (newWidth !== width || newHeight !== height || newWidth * newHeight > 1024) && (ready.call(img), onReady.end = !0)
        }, onReady(), void(img.onload = function () {
            !onReady.end && onReady(), img = img.onload = img.onerror = null
        }))
    }, util.resize = function (max, sou) {
        var sRate = sou.width / sou.height;
        return max.width < sou.width && (sou.width = max.width, sou.height = sou.width / sRate), max.height < sou.height && (sou.height = max.height, sou.width = sou.height * sRate), sou
    }, util.toKeyValue = function (obj) {
        var retString = "";
        for (var k in obj) retString += k + "=", retString += encodeURIComponent(obj[k]), retString += "&";
        return retString.length > 0 && (retString = retString.substr(0, retString.length - 1)), retString
    }, util
}), qcVideo("version", function () {
    var agent = navigator.userAgent, v = {IOS: !!agent.match(/iP(od|hone|ad)/i), ANDROID: !!/Android/i.test(agent)},
        dom = document.createElement("video"), h5Able = {probably: 1, maybe: 1};
    dom = dom.canPlayType ? dom : null, v.IS_MAC = window.navigator && navigator.appVersion && navigator.appVersion.indexOf("Mac") > -1, v.ABLE_H5_MP4 = dom && dom.canPlayType("video/mp4") in h5Able, v.ABLE_H5_WEBM = dom && dom.canPlayType("video/webm") in h5Able, v.ABLE_H5_HLS = dom && dom.canPlayType("application/x-mpegURL") in h5Able, v.IS_MOBILE = v.IOS || v.ANDROID, v.ABLE_H5_APPLE_HLS = dom && dom.canPlayType("application/vnd.apple.mpegURL") in h5Able, v.FLASH_VERSION = -1, v.IS_IE = "ActiveXObject" in window, v.ABLE_FLASH = function () {
        var swf;
        if (document.all) try {
            if (swf = new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) return v.FLASH_VERSION = parseInt(swf.GetVariable("$version").split(" ")[1].split(",")[0]), !0
        } catch (e) {
            return !1
        } else try {
            if (navigator.plugins && navigator.plugins.length > 0 && (swf = navigator.plugins["Shockwave Flash"])) {
                for (var words = swf.description.split(" "), i = 0; i < words.length; ++i) isNaN(parseInt(words[i])) || (v.FLASH_VERSION = parseInt(words[i]));
                return !0
            }
        } catch (e) {
            return !1
        }
        return !1
    }(), v.getFlashAble = function () {
        return v.ABLE_FLASH ? v.FLASH_VERSION <= 10 ? "lowVersion" : "able" : ""
    };
    var ableHlsJs = !(!window.MediaSource || !window.MediaSource.isTypeSupported('video/mp4; codecs="avc1.42E01E,mp4a.40.2"')),
        forceCheckHLS = function () {
            return !!(v.ANDROID && !v.ABLE_H5_HLS && agent.substr(agent.indexOf("Android") + 8, 1) >= 4)
        };
    return v.REQUIRE_HLS_JS = ableHlsJs && !v.ABLE_H5_HLS && !v.ABLE_H5_APPLE_HLS, v.getLivePriority = function () {
        return v.IOS || v.ANDROID ? (forceCheckHLS() && (v.ABLE_H5_HLS = !0), "h5") : !v.ABLE_FLASH && v.ABLE_H5_MP4 ? "h5" : v.ABLE_FLASH ? "flash" : v.ABLE_H5_MP4 ? "h5" : ""
    }, v.getVodPriority = function (inWhiteAppId) {
        return v.IOS || v.ANDROID ? "h5" : !v.ABLE_FLASH && v.ABLE_H5_MP4 ? "h5" : v.ABLE_FLASH ? "flash" : v.ABLE_H5_MP4 ? "h5" : ""
    }, v.PROTOCOL = function () {
        try {
            var href = window.location.href;
            if (0 === href.indexOf("https")) return "https"
        } catch (xe) {
        }
        return "http"
    }(), v
}), qcVideo("vodReporter", function (api, util) {
    function uuid(len, radix) {
        var i, chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".split(""), uuid = [];
        if (radix = radix || chars.length, len) for (i = 0; i < len; i++) uuid[i] = chars[0 | Math.random() * radix]; else {
            var r;
            for (uuid[8] = uuid[13] = uuid[18] = uuid[23] = "-", uuid[14] = "4", i = 0; i < 36; i++) uuid[i] || (r = 0 | 16 * Math.random(), uuid[i] = chars[19 == i ? 3 & r | 8 : r])
        }
        return uuid.join("")
    }

    function getPlatform() {
        var platform = "", exployer = "", UA = window.navigator.userAgent, isIE = detectIE();
        return UA ? (UA.indexOf("Android") > -1 ? platform = "android" : /iPhone|iPad|iPod/.test(UA) ? platform = "ios" : UA.indexOf("Mac") > -1 ? platform = "mac" : UA.indexOf("Windows") > -1 && (platform = "windows"), isIE ? exployer = isIE : UA.indexOf("Firefox") >= 0 ? exployer = "firefox" : UA.indexOf("Chrome") >= 0 ? exployer = "chrome" : UA.indexOf("Opera") >= 0 ? exployer = "opera" : UA.indexOf("Safari") >= 0 && (exployer = "safari")) : (platform = "unknown", exployer = "unknown"), {
            platform: platform,
            exployer: exployer
        }
    }

    function detectIE() {
        var ua = window.navigator.userAgent, msie = ua.indexOf("MSIE ");
        if (msie > 0) return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
        var trident = ua.indexOf("Trident/");
        if (trident > 0) {
            var rv = ua.indexOf("rv:");
            return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10)
        }
        var edge = ua.indexOf("Edge/");
        return edge > 0 && parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10)
    }

    function report(params) {
        api.report(("https:" == location.protocol ? REPORT_URL_HTTPS : REPORT_URL) + "?" + params)
    }

    var REPORT_URL = "http://vodreport.qcloud.com/report.go",
        REPORT_URL_HTTPS = "https://vodreport.qcloud.com/report.go", seq = uuid(8, 10), ua = getPlatform();
    return {
        reportStart: function (_url, _from) {
        }, reportEnd: function (type, code) {
        }, reportParams: function (params) {
            var params = JSON.parse(params);
            params["interface"] = "Vod_Report", params.seq = seq, params.platform = ua.platform, params.exployer = ua.exployer, params.version = "1.0", report(util.toKeyValue(params))
        }
    }
}), qcVideo("config", function (version) {
    var h5 = version.PROTOCOL + "://imgcache.qq.com/open/qcloud/video/h5",
        flash = version.PROTOCOL + "://imgcache.qq.com/open/qcloud/video/flash";
    return {
        $: h5 + "/zepto-v1.2.0.min.js?max_age=20000000",
        h5player: h5 + "/h5player.js",
        flash: flash + "/video_player.swf?max_age=1800",
        Hls: h5 + "/hls.release.js?max_age=20000000",
        h5css: h5 + "/video.css?ver=0531&max_age=20000000",
        set: function (key, url) {
            this[key] = url
        }
    }
}), qcVideo("constants", function () {
    return {
        SERVER_API: "https:" == location.protocol ? "//playvideo.qcloud.com/index.php" : "//play.video.qcloud.com/index.php",
        SERVER_API_PARAMS: {file_id: 1, app_id: 1, player_id: 1, refer: 1},
        TDBANK_REPORT_API: "//tudg.qq.com/dataimport/ImportService",
        OK_CODE: "0",
        ERROR_CODE: {
            TIME_OUT: "10000",
            SCRIPT_ONLOAD: "10001",
            SCRIPT_ONERROR: "10002",
            REQUIRE_PWD: "11046",
            ERROR_PW: "1003",
            REQUIRE_APP_ID: "11044",
            ERROR_APP_ID: "10008",
            REQUIRE_FID: "11045",
            ERROR_FID: "10008"
        },
        ERROR_MSG: {
            10000: "请求超时,请检查网络设置",
            10001: "数据解析失败",
            10002: "连接超时，请稍后再试",
            11046: "密码错误，请重新输入",
            1003: "密码错误，请重新输入",
            10008: "视频源不存在"
        },
        TIP_MESSAGE: {LoadVideoFailed: "加载视频失败", VideoNeedTranscode: "缺少视频数据，请对视频进行转码"},
        NAMES_DEFINITION: {original: "超清", high: "高清", normal: "标清", phone: "手机"},
        DEFINITION_MAP: {"手机": "phone", "标清": "normal", "高清": "high", "超清": "original"},
        DEFINITION_PRIORITY: {
            0: [210, 10, 214],
            1: [220, 20, 224, 225, 25],
            2: [230, 30, 234, 235, 35],
            4: [240, 40, 244, 245, 246, 247, 248, 260, 261, 262, 263, 264, 2, 4, 45, 46, 47, 48, 60, 61, 62, 63, 64]
        },
        JUST_MP4_DEFINITION_PRIORITY: {
            0: [10],
            1: [20, 25],
            2: [30, 35],
            4: [40, 2, 4, 45, 46, 47, 48, 60, 61, 62, 63, 64]
        },
        ONLY_MP4_NO_TRANS: {0: [], 1: [], 2: [0], 4: []},
        RESOLUTION_PRIORITY: [2, 1, 0, 4],
        DEFINITION_NAME: {0: "手机", 1: "标清", 2: "高清", 4: "超清"},
        DEFINITION_NAME_NO: {0: 1, 1: 2, 2: 3, 4: 4},
        DEFINITION_NO_NAME: {1: 0, 2: 1, 3: 2, 4: 4},
        LOGO_LOCATION: {L_U: "0", L_D: "1", R_U: "2", R_D: "3"},
        PATCH_TYPE: {IMAGE: "0", MOVE: "1"},
        PATCH_LOC: {START: "0", PAUSE: "1", END: "2"},
        TAP: "tap",
        CLICK: "click",
        MP4: "mp4",
        HLS: "hls",
        FLV: "flv",
        UNICODE_WORD: {
            PLAY: "播放",
            PAUSE: "暂停",
            MUTE: "静音",
            VOLUME: "音量",
            FULL_SCREEN: "全屏",
            EXIT_FULL_SCREEN: "退出全屏",
            TIP_OPR_VOLUME: "或用键盘↑ 键盘↓",
            SETTING: "设置",
            TIP_REQUIRE_FLASH: "当前浏览器不能支持视频播放，可下载最新的QQ浏览器或者安装FLASH即可播放",
            TIP_UPDATE_FLASH: "当前浏览器flash版本过低，可下载最新的FLASH版本进行播放",
            TIP_CLICK_UPDATE_FLASH: "点击更新",
            SWITCH_DEF: "更换清晰度",
            NET_ERROR: "Error: 视频加载失败,点击播放按钮重新播放"
        },
        FIRE: "FIRE",
        EVENT: {
            OS_TIME_UPDATE: "OS_TIME_UPDATE",
            OS_PLAYING: "OS_PLAYING",
            OS_SEEKING: "OS_SEEKING",
            OS_PROGRESS: "OS_PROGRESS",
            OS_LOADED_META_DATA: "OS_LOADED_META_DATA",
            OS_PLAYER_END: "OS_PLAYER_END",
            OS_VIDEO_LOADING: "OS_VIDEO_LOADING",
            OS_ERROR: "OS_ERROR",
            OS_BLOCK: "OS_BLOCK",
            OS_PAUSE: "OS_PAUSE",
            OS_VOLUME_CHANGE: "OS_VOLUME_CHANGE",
            OS_RESIZE: "OS_RESIZE",
            OS_LAND_SCAPE_UI: "OS_LAND_SCAPE_UI",
            OS_PORTRAIT_UI: "OS_PORTRAIT_UI",
            OS_DURATION_UPDATE: "OS_DURATION_UPDATE",
            UI_PAUSE: "UI_PAUSE",
            UI_PLAY: "UI_PLAY",
            UI_FULL_SCREEN: "UI_FULL_SCREEN",
            UI_QUIT_FULL_SCREEN: "UI_QUIT_FULL_SCREEN",
            UI_SET_PROGRESS: "UI_SET_PROGRESS",
            UI_SET_VOLUME: "UI_SET_VOLUME",
            UI_DRAG_PLAY: "UI_DRAG_PLAY",
            UI_PLUS_PLAY: "UI_PLUS_PLAY",
            UI_MINUS_PLAY: "UI_MINUS_PLAY",
            UI_SIMULATION_POSITION: "UI_SIMULATION_POSITION",
            UI_OPEN_SETTING: "UI_OPEN_SETTING",
            UI_CHOSE_DEFINITION: "UI_CHOSE_DEFINITION"
        },
        BAD_JS_REPORT_WHITE_APP_IDS: {1251132611: 1, 1251438353: 1, 1251768344: 1, 1251536981: 1}
    }
}), qcVideo("Error", function (constants) {
    return {NET_ERROR: constants.UNICODE_WORD.NET_ERROR}
}), qcVideo("FullScreenApi", function (version) {
    var apiMap, specApi, browserApi, i, fullscreenAPI = {};
    for (apiMap = [["requestFullscreen", "exitFullscreen", "fullscreenElement", "fullscreenEnabled", "fullscreenchange", "fullscreenerror"], ["webkitRequestFullscreen", "webkitExitFullscreen", "webkitFullscreenElement", "webkitFullscreenEnabled", "webkitfullscreenchange", "webkitfullscreenerror"], ["webkitRequestFullScreen", "webkitCancelFullScreen", "webkitCurrentFullScreenElement", "webkitCancelFullScreen", "webkitfullscreenchange", "webkitfullscreenerror"], ["mozRequestFullScreen", "mozCancelFullScreen", "mozFullScreenElement", "mozFullScreenEnabled", "mozfullscreenchange", "mozfullscreenerror"], ["msRequestFullscreen", "msExitFullscreen", "msFullscreenElement", "msFullscreenEnabled", "msFullscreenChange", "msFullscreenError"]], specApi = apiMap[0], i = 0; i < apiMap.length; i++) if (apiMap[i][1] in document) {
        browserApi = apiMap[i];
        break
    }
    if (browserApi && !version.IS_MOBILE) for (fullscreenAPI.supportFullScreen = !0, i = 0; i < browserApi.length; i++) fullscreenAPI[specApi[i]] = browserApi[i]; else fullscreenAPI.supportFullScreen = !1;
    return fullscreenAPI
}), qcVideo("H5", function (constants, api, util, Base, config, startup_tpl, TDBankReporter, codeReport) {
    var $;
    return Base.extend({
        verifyDone: function (data) {
            var me = this;
            util.merge(me.store, data, !0), util.merge(me.store, {parameter: me.option});
            var h5player = qcVideo.get("h5player");
            h5player.render(me.store), me.sdklink.setSwf(h5player.mediaPlayer), delete me.sdklink
        },
        getFinalVideos: function (o, source) {
            if (o && o.length) {
                for (var map = {}, ai = 0, al = o.length; ai < al; ai++) map[o[ai].split("?")[0]] = o[ai];
                if (source && source.length) {
                    for (var st, finalVideos = [], vi = 0, vl = source.length; vi < vl; vi++) st = source[vi].url.split("?")[0], map.hasOwnProperty(st) && (source[vi].url = map[st], finalVideos.push(source[vi]));
                    return finalVideos
                }
            }
            return null
        },
        addStyle: function () {
            var node = document.createElement("link");
            node.href = config.h5css, node.rel = "stylesheet", node.media = "screen", document.getElementsByTagName("head")[0].appendChild(node);
        },
        askDoor: function (firstTime, pass) {
            var key, me = this, store = me.store, address = constants.SERVER_API + "?interface=Vod_Api_GetPlayInfo&1=1";
            for (key in constants.SERVER_API_PARAMS) store.hasOwnProperty(key) && (address += "&" + key + "=" + store[key]);
            void 0 !== pass && (address += "&pass=" + pass), codeReport.reportStart(address, "vod"), me.loading(!0), api.request(address, function (ret) {
                me.loading();
                var code = ret.retcode + "", data = ret.data;
                if (TDBankReporter.pushEvent("connectPlayCgiH5", {setting: {app_id: me.store.app_id}}), code != constants.ERROR_CODE.TIME_OUT && code != constants.ERROR_CODE.SCRIPT_ONLOAD && code != constants.SCRIPT_ONERROR ? codeReport.reportEnd("0" == code ? "1" : "3", code) : codeReport.reportEnd(2, code), code == constants.OK_CODE) {
                    if (me.store.videos && me.store.videos.length) {
                        var finalVideos = me.getFinalVideos(me.store.videos, data.file_info.image_video.videoUrls);
                        finalVideos && (data.file_info.image_video.videoUrls = finalVideos)
                    }
                    me.verifyDone(data)
                } else {
                    var isPwdError = code == constants.ERROR_CODE.REQUIRE_PWD || code == constants.ERROR_CODE.ERROR_PW;
                    if (isPwdError && firstTime) me.renderPWDPanel(); else {
                        var errorMsg = constants.ERROR_MSG[code] || "";
                        errorMsg && isPwdError || (errorMsg += (ret.errmsg ? ret.errmsg : "") + " Code:(" + code + ")"), me.erTip(errorMsg, isPwdError)
                    }
                }
            })
        },
        className: "PlayerH5",
        $pwd: null,
        $out: null,
        option: {},
        constructor: function (_$, targetId, opt, eid, link) {
            $ = _$;
            var me = this;
            me.option = opt, me.sdklink = link, opt.no_css || me.addStyle(), me.store = util.merge({
                $renderTo: $("#" + targetId),
                sdk_method: eid + "_callback",
                keepArgs: {targetId: targetId, eid: eid, refer: opt.refer}
            }, opt);
            var $out = me.$out = me.store.$renderTo.html(startup_tpl.main({
                sure: "确定",
                errpass: "抱歉，密码错误",
                enterpass: "请输入密码",
                videlocked: "该视频已加密"
            }));
            me.$pwd = $out.find('[data-area="pwd"]'), me.$error = $out.find('[data-area="error"]'), me.$loading = $out.find('[data-area="loading"]'), $out.find('[data-area="main"]').css({
                width: me.store.width,
                height: me.store.height
            }), me.$error.css({top: me.store.height / 2}), me.$loading.css({top: me.store.height / 2});
            var third = opt.third_video;
            if (third && third.urls) {
                var key,
                    data = {file_info: {duration: third.duration || 0, image_video: {videoUrls: []}}, player_info: {}};
                for (key in third.urls) data.file_info.image_video.videoUrls.push({
                    definition: key,
                    url: third.urls[key]
                });
                me.verifyDone(data)
            } else me.askDoor(!0)
        },
        loading: function (visible) {
        },
        erTip: function (msg, pwdEr) {
            if (pwdEr) this.$pwd.find(".txt").text(msg).css("visibility", "visible"); else {
                var listeners = this.sdklink.listeners;
                listeners && listeners.playStatus && listeners.playStatus("error", msg), this.option.hide_h5_error || console.log(msg)
            }
        },
        sureHandler: function () {
            var me = this, $pwd = me.$pwd, pwd = $pwd.find('input[type="password"]').val() + "", able = pwd.length > 0;
            $pwd.find(".txt").text(able ? "" : "抱歉，密码错误").css("visibility", able ? "hidden" : "visible"), able && me.askDoor(!1, pwd)
        },
        renderPWDPanel: function () {
            var me = this, cw = me.store.width, ch = me.store.height, $pwd = me.$pwd, $parent = $pwd.parent();
            $pwd.show().on("click", "[tx-act]", function (e) {
                var act = $(this).attr("tx-act"), handler = me[act + "Handler"];
                return handler && handler.call(me), e.stopPropagation(), !1
            });
            var pw = $pwd.width(), ph = $pwd.height(), fW = $parent.width();
            fW && fW <= pw ? $pwd.css({left: "0px", top: "0px"}).width(fW) : $pwd.css({
                left: (cw - pw) / 2 + "px",
                top: (ch - ph) / 2 + "px"
            })
        }
    })
}), qcVideo("MD5", function () {
    "use strict";

    function safe_add(x, y) {
        var lsw = (65535 & x) + (65535 & y), msw = (x >> 16) + (y >> 16) + (lsw >> 16);
        return msw << 16 | 65535 & lsw
    }

    function bit_rol(num, cnt) {
        return num << cnt | num >>> 32 - cnt
    }

    function md5_cmn(q, a, b, x, s, t) {
        return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s), b)
    }

    function md5_ff(a, b, c, d, x, s, t) {
        return md5_cmn(b & c | ~b & d, a, b, x, s, t)
    }

    function md5_gg(a, b, c, d, x, s, t) {
        return md5_cmn(b & d | c & ~d, a, b, x, s, t)
    }

    function md5_hh(a, b, c, d, x, s, t) {
        return md5_cmn(b ^ c ^ d, a, b, x, s, t)
    }

    function md5_ii(a, b, c, d, x, s, t) {
        return md5_cmn(c ^ (b | ~d), a, b, x, s, t)
    }

    function binl_md5(x, len) {
        x[len >> 5] |= 128 << len % 32, x[(len + 64 >>> 9 << 4) + 14] = len;
        var i, olda, oldb, oldc, oldd, a = 1732584193, b = -271733879, c = -1732584194, d = 271733878;
        for (i = 0; i < x.length; i += 16) olda = a, oldb = b, oldc = c, oldd = d, a = md5_ff(a, b, c, d, x[i], 7, -680876936), d = md5_ff(d, a, b, c, x[i + 1], 12, -389564586), c = md5_ff(c, d, a, b, x[i + 2], 17, 606105819), b = md5_ff(b, c, d, a, x[i + 3], 22, -1044525330), a = md5_ff(a, b, c, d, x[i + 4], 7, -176418897), d = md5_ff(d, a, b, c, x[i + 5], 12, 1200080426), c = md5_ff(c, d, a, b, x[i + 6], 17, -1473231341), b = md5_ff(b, c, d, a, x[i + 7], 22, -45705983), a = md5_ff(a, b, c, d, x[i + 8], 7, 1770035416), d = md5_ff(d, a, b, c, x[i + 9], 12, -1958414417), c = md5_ff(c, d, a, b, x[i + 10], 17, -42063), b = md5_ff(b, c, d, a, x[i + 11], 22, -1990404162), a = md5_ff(a, b, c, d, x[i + 12], 7, 1804603682), d = md5_ff(d, a, b, c, x[i + 13], 12, -40341101), c = md5_ff(c, d, a, b, x[i + 14], 17, -1502002290), b = md5_ff(b, c, d, a, x[i + 15], 22, 1236535329), a = md5_gg(a, b, c, d, x[i + 1], 5, -165796510), d = md5_gg(d, a, b, c, x[i + 6], 9, -1069501632), c = md5_gg(c, d, a, b, x[i + 11], 14, 643717713), b = md5_gg(b, c, d, a, x[i], 20, -373897302), a = md5_gg(a, b, c, d, x[i + 5], 5, -701558691), d = md5_gg(d, a, b, c, x[i + 10], 9, 38016083), c = md5_gg(c, d, a, b, x[i + 15], 14, -660478335), b = md5_gg(b, c, d, a, x[i + 4], 20, -405537848), a = md5_gg(a, b, c, d, x[i + 9], 5, 568446438), d = md5_gg(d, a, b, c, x[i + 14], 9, -1019803690), c = md5_gg(c, d, a, b, x[i + 3], 14, -187363961), b = md5_gg(b, c, d, a, x[i + 8], 20, 1163531501), a = md5_gg(a, b, c, d, x[i + 13], 5, -1444681467), d = md5_gg(d, a, b, c, x[i + 2], 9, -51403784), c = md5_gg(c, d, a, b, x[i + 7], 14, 1735328473), b = md5_gg(b, c, d, a, x[i + 12], 20, -1926607734), a = md5_hh(a, b, c, d, x[i + 5], 4, -378558), d = md5_hh(d, a, b, c, x[i + 8], 11, -2022574463), c = md5_hh(c, d, a, b, x[i + 11], 16, 1839030562), b = md5_hh(b, c, d, a, x[i + 14], 23, -35309556), a = md5_hh(a, b, c, d, x[i + 1], 4, -1530992060), d = md5_hh(d, a, b, c, x[i + 4], 11, 1272893353), c = md5_hh(c, d, a, b, x[i + 7], 16, -155497632), b = md5_hh(b, c, d, a, x[i + 10], 23, -1094730640), a = md5_hh(a, b, c, d, x[i + 13], 4, 681279174), d = md5_hh(d, a, b, c, x[i], 11, -358537222), c = md5_hh(c, d, a, b, x[i + 3], 16, -722521979), b = md5_hh(b, c, d, a, x[i + 6], 23, 76029189), a = md5_hh(a, b, c, d, x[i + 9], 4, -640364487), d = md5_hh(d, a, b, c, x[i + 12], 11, -421815835), c = md5_hh(c, d, a, b, x[i + 15], 16, 530742520), b = md5_hh(b, c, d, a, x[i + 2], 23, -995338651), a = md5_ii(a, b, c, d, x[i], 6, -198630844), d = md5_ii(d, a, b, c, x[i + 7], 10, 1126891415), c = md5_ii(c, d, a, b, x[i + 14], 15, -1416354905), b = md5_ii(b, c, d, a, x[i + 5], 21, -57434055), a = md5_ii(a, b, c, d, x[i + 12], 6, 1700485571), d = md5_ii(d, a, b, c, x[i + 3], 10, -1894986606), c = md5_ii(c, d, a, b, x[i + 10], 15, -1051523), b = md5_ii(b, c, d, a, x[i + 1], 21, -2054922799), a = md5_ii(a, b, c, d, x[i + 8], 6, 1873313359), d = md5_ii(d, a, b, c, x[i + 15], 10, -30611744), c = md5_ii(c, d, a, b, x[i + 6], 15, -1560198380), b = md5_ii(b, c, d, a, x[i + 13], 21, 1309151649), a = md5_ii(a, b, c, d, x[i + 4], 6, -145523070), d = md5_ii(d, a, b, c, x[i + 11], 10, -1120210379), c = md5_ii(c, d, a, b, x[i + 2], 15, 718787259), b = md5_ii(b, c, d, a, x[i + 9], 21, -343485551), a = safe_add(a, olda), b = safe_add(b, oldb), c = safe_add(c, oldc), d = safe_add(d, oldd);
        return [a, b, c, d]
    }

    function binl2rstr(input) {
        var i, output = "";
        for (i = 0; i < 32 * input.length; i += 8) output += String.fromCharCode(input[i >> 5] >>> i % 32 & 255);
        return output
    }

    function rstr2binl(input) {
        var i, output = [];
        for (output[(input.length >> 2) - 1] = void 0, i = 0; i < output.length; i += 1) output[i] = 0;
        for (i = 0; i < 8 * input.length; i += 8) output[i >> 5] |= (255 & input.charCodeAt(i / 8)) << i % 32;
        return output
    }

    function rstr_md5(s) {
        return binl2rstr(binl_md5(rstr2binl(s), 8 * s.length))
    }

    function rstr_hmac_md5(key, data) {
        var i, hash, bkey = rstr2binl(key), ipad = [], opad = [];
        for (ipad[15] = opad[15] = void 0, bkey.length > 16 && (bkey = binl_md5(bkey, 8 * key.length)), i = 0; i < 16; i += 1) ipad[i] = 909522486 ^ bkey[i], opad[i] = 1549556828 ^ bkey[i];
        return hash = binl_md5(ipad.concat(rstr2binl(data)), 512 + 8 * data.length), binl2rstr(binl_md5(opad.concat(hash), 640))
    }

    function rstr2hex(input) {
        var x, i, hex_tab = "0123456789abcdef", output = "";
        for (i = 0; i < input.length; i += 1) x = input.charCodeAt(i), output += hex_tab.charAt(x >>> 4 & 15) + hex_tab.charAt(15 & x);
        return output
    }

    function str2rstr_utf8(input) {
        return unescape(encodeURIComponent(input))
    }

    function raw_md5(s) {
        return rstr_md5(str2rstr_utf8(s))
    }

    function hex_md5(s) {
        return rstr2hex(raw_md5(s))
    }

    function raw_hmac_md5(k, d) {
        return rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d))
    }

    function hex_hmac_md5(k, d) {
        return rstr2hex(raw_hmac_md5(k, d))
    }

    function md5(string, key, raw) {
        return key ? raw ? raw_hmac_md5(key, string) : hex_hmac_md5(key, string) : raw ? raw_md5(string) : hex_md5(string)
    }

    return {className: "MD5", md5: md5}
}), qcVideo("Player", function (util, Base, version, css, H5, Swf, SwfJsLink, constants, TDBankReporter, BJ_REPORT, config) {
    function getEid() {
        return eidUuid += 1, "video_" + eidUuid
    }

    function matchIfmWidth(opt, ele) {
        ele.style.width = "0px", ele.style.height = "0px";
        var rate = opt.width / opt.height, tempW = css.getVisibleWidth(), tempH = css.getVisibleHeight();
        return opt.width > tempW || opt.height > tempH ? (opt.width > tempW && (tempH = tempW / rate), opt.height > tempH && (tempW = tempH * rate), tempW / tempH !== rate && (tempH = tempW / rate), ele.style.width = (opt.width = tempW) + "px", ele.style.height = (opt.height = tempH) + "px", !1) : (ele.style.width = opt.width + "px", ele.style.height = opt.height + "px", !0)
    }

    function setSuitableWH(opt, ele) {
        var width = opt.width, height = opt.height, pW = css.getWidth(ele), pH = css.getHeight(ele),
            rate = width / height, minPix = 4;
        if (pW < minPix && ele.parentNode) for (var pEle = ele.parentNode; ;) {
            if (!pEle || pEle === document.body) {
                pW = css.getVisibleWidth(), pH = css.getVisibleHeight();
                break
            }
            if (pW = css.getWidth(pEle), pH = css.getHeight(pEle), pW > minPix) break;
            pEle = pEle.parentNode
        }
        pH < minPix && pW > minPix && (pH = pW / rate), opt.match_page_width && !matchIfmWidth(opt, ele) || (pW < minPix && (pW = width), pH < minPix && (pH = pW / rate), pW < width && (width = pW, height = width / rate), pH < height && (height = pH, width = height * rate), opt.width = width - 0, opt.height = height - 0)
    }

    var eidUuid = +new Date, ableReportJsError = 0;
    return Base.extend({
        className: "Player", verifyDone: function (targetId, opt, listener) {
            var ele = document.getElementById(targetId);
            this.targetId = targetId, setSuitableWH(opt, ele);
            var inWhiteAppId = !1;
            opt && opt.app_id && (inWhiteAppId = !version.IS_MOBILE, opt.inWhiteHlsJs = inWhiteAppId);
            var ver = version.getVodPriority(inWhiteAppId), eid = getEid(), flashAble = version.getFlashAble(),
                link = new SwfJsLink(eid, listener);
            if ("h5" == ver) qcVideo.use("$", function ($) {
                version.REQUIRE_HLS_JS ? qcVideo.use("Hls", function (mod) {
                    new H5($, targetId, opt, eid, link)
                }) : new H5($, targetId, opt, eid, link)
            }), TDBankReporter.pushEvent("connectInitH5", {setting: {app_id: opt.app_id}}); else {
                if ("flash" != ver) return void(ele.innerText = constants.UNICODE_WORD.TIP_REQUIRE_FLASH);
                "lowVersion" == flashAble ? ele.innerHTML = constants.UNICODE_WORD.TIP_UPDATE_FLASH + '<a target="_blank" style="color:blue;" href="http://www.macromedia.com/go/getflashplayer">' + constants.UNICODE_WORD.TIP_CLICK_UPDATE_FLASH + "</a>" : (new Swf(targetId, eid, opt, link), TDBankReporter.pushEvent("connectInitFlash", {setting: {app_id: opt.app_id}}))
            }
            return css.textAlign(ele), link
        }, constructor: function (targetId, opt, listener) {
            if (TDBankReporter.pushEvent("connectInit", {setting: {app_id: opt.app_id}}), util.isPlainObject(targetId)) {
                var tmp = opt;
                opt = targetId, targetId = tmp
            }
            if (opt && opt.wording) {
                var i, m;
                for (i in opt.wording) m = opt.wording[i], constants.ERROR_MSG[i] ? m && (constants.ERROR_MSG[i] = m) : constants.TIP_MESSAGE[i] ? m && (constants.TIP_MESSAGE[i] = m) : constants.NAMES_DEFINITION[i] ? m && (constants.NAMES_DEFINITION[i] = m) : constants.UNICODE_WORD[i] = m
            }
            if (ableReportJsError = 0 === ableReportJsError && opt && opt.app_id in constants.BAD_JS_REPORT_WHITE_APP_IDS ? 1 : -1, 1 === ableReportJsError && BJ_REPORT.init({
                    id: 1067,
                    uin: 123,
                    combo: 0,
                    delay: 1e3,
                    url: "//badjs2.qq.com/badjs",
                    ignore: [/Script error/i],
                    level: 4,
                    random: 1
                }), opt.refer = document.domain, targetId && document.getElementById(targetId)) {
                if (opt.app_id && opt.file_id) return this.verifyDone(targetId, opt, listener);
                var video = opt.third_video;
                if (video) return video.urls ? this.verifyDone(targetId, opt, listener) : console.log("缺少视频地址信息，请补齐urls；");
                console.log("缺少参数，请补齐appId，file_id")
            } else console.log("没有指定有效播放器容器！")
        }, remove: function () {
            this.targetId && (document.getElementById(this.targetId).innerHTML = "")
        }
    })
}), qcVideo("startup", function (Base, Player) {
    return Base.instance({
        className: "startup", constructor: Base.loop, start: function (targetId, opt) {
            new Player(targetId, opt)
        }
    })
}), qcVideo("startup_tpl", function () {
    return {
        main: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p('<style>\r\n\t\t\t        .layer-password {font-size:14px;font-family: \'helvetica neue\', tahoma, arial, \'hiragino sans gb\', \'microsoft yahei\', \'Simsun\', sans-serif;position:absolute;top:50%;left:50%;width:20rem;background-color:#242424}\r\n\t\t\t        .layer-password .tip {display:block;width:88%;padding:1em 6% .5em;color:#0073d0;border-bottom:1px solid #0073d0;font-size: 1.2em;}\r\n\t\t\t        .layer-password .password {font-size:1em;line-height:2em;display:block;width:88%;height:2em;margin:1em auto 0;color:#bfbfbf;border:none;border-bottom:1px solid #bfbfbf;background-color:inherit;}\r\n\t\t\t        .layer-password .txt {font-size:1em;display:block;visibility:hidden;padding:.5em 6% .5em;color:#5a5a5a}\r\n\t\t\t        .layer-password .bottom {border-top:1px solid #313234}\r\n\t\t\t        .layer-password .bottom .btn {line-height:3.25em;height:3.25em;text-align:center;color:#8e8e8e}\r\n\t\t\t        .layer-password .bottom .btn.ok {display:block;width:50%;margin:0 auto;font-size: 1.2em;text-decoration: none;}\r\n\t\t\t    </style>\r\n\t\t\t\r\n\t\t\t    <div data-area="main" style="position: relative;background-color: #000;">\r\n\t\t\t        <div class="layer-password" data-area="pwd" style="display:none;z-index:5;">\r\n\t\t\t            <span class="tip" style="border: none;background-color: #242424;border-bottom: 1px solid #0073d0;position: relative;">'), _p(data.videlocked), _p('</span>\r\n\t\t\t            <input class="password" placeholder="'), _p(data.enterpass), _p('" type="password">\r\n\t\t\t            <span class="txt">'), _p(data.errpass), _p('</span>\r\n\t\t\t            <div class="bottom">\r\n\t\t\t                <a class="btn ok" href="#" tx-act="sure">'), _p(data.sure), _p('</a>\r\n\t\t\t            </div>\r\n\t\t\t        </div>\r\n\t\t\t\r\n\t\t\t        <div style="color: red;text-align: center;position: absolute;width: 99%;height: 50%;  font-size: 1rem;"\r\n\t\t\t        data-area="error" style="display:none;"> </div>\r\n\t\t\t        <div data-area="loading" style="text-align: center;position: absolute;width: 99%;height: 50%;font-size: 1rem;display:none;">loading....</div>\r\n\t\t\t\t</div>'), __p.join("")
        }, __escapeHtml: function () {
            var a = {"&": "&amp;", "<": "&lt;", ">": "&gt;", "'": "&#39;", '"': "&quot;", "/": "&#x2F;"},
                b = /[&<>'"\/]/g;
            return function (c) {
                return "string" != typeof c ? c : c ? c.replace(b, function (b) {
                    return a[b] || b
                }) : ""
            }
        }()
    }
}), qcVideo("Swf", function (Base, config, JSON, LinkIm) {
    var getHtmlCode = function (option, eid) {
        var __ = [], address = config.flash, _ = function (str) {
                __.push(str)
            }, flashvars = "auto_play=" + option.auto_play + "&version=1&refer=" + option.refer + "&jscbid=" + eid,
            VMode = option.VMode || option.WMode || "window";
        return flashvars += option.disable_full_screen ? "&disable_full_screen=1" : "&disable_full_screen=0", flashvars += option.debug ? "&debug=1" : "", option.file_id && (flashvars += "&file_id=" + option.file_id), option.app_id && (flashvars += "&app_id=" + option.app_id), void 0 !== option.definition && (flashvars += "&definition=" + option.definition), void 0 !== option.player_id && (flashvars += "&player_id=" + option.player_id), void 0 !== option.disable_drag && (flashvars += "&disable_drag=" + option.disable_drag), void 0 !== option.stretch_full && (flashvars += "&stretch_full=" + option.stretch_full), option.videos && option.videos.length && (flashvars += "&videos=" + encodeURIComponent(JSON.stringify(option.videos))), option.third_video && (flashvars += "&third_video=" + encodeURIComponent(JSON.stringify(option.third_video))), option.skin && (flashvars += "&skin=" + encodeURIComponent(JSON.stringify(option.skin))), option.stop_time && (flashvars += "&stop_time=" + option.stop_time), option.remember && (flashvars += "&remember=" + option.remember), option.capture && (flashvars += "&capture=" + option.capture), option.stretch_patch && (flashvars += "&stretch_patch=" + option.stretch_patch), "https:" == location.protocol && (flashvars += "&https=1"), option.wording && (flashvars += "&wording=1"), _('<object data="' + address + '" id="' + eid + '_object" width="' + option.width + 'px" height="' + option.height + 'px"  style="background-color:#000000;" '), _('align="middle" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab#version=9,0,0,0">'), _('<param name="flashVars" value="' + flashvars + '"  />'), _('<param name="src" value="' + address + '"  />'), _('<param name="wmode" value="' + VMode + '"/>'), _('<param name="quality" value="High"/>'), _('<param name="allowScriptAccess" value="always"/>'), _('<param name="allowNetworking" value="all"/>'), _('<param name="allowFullScreen" value="true"/>'), _('<embed style="background-color:#000000;"  id="' + eid + '_embed" width="' + option.width + 'px" height="' + option.height + 'px" flashvars="' + flashvars + '"'), _('align="middle" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowfullscreen="true" bgcolor="#000000" quality="high"'), _('src="' + address + '"'), _('wmode="' + VMode + '" allowfullscreen="true" invokeurls="false" allownetworking="all" allowscriptaccess="always">'), _("</object>"), __.join("")
    };
    return Base.extend({
        className: "PlayerSwf", option: null, constructor: function (targetId, eid, opt, context) {
            document.getElementById(this.targetId = targetId).innerHTML = getHtmlCode(opt, eid)
        }, remove: function () {
            this.linkIm && (this.linkIm.destroy(), this.linkIm = null);
            var node = document.getElementById(this.targetId) || {}, parent = node.parentNode;
            node.parentNode && "object" == (node.parentNode.tagName || "").toLowerCase() && (node = parent, parent = node.parentNode);
            try {
                parent.removeChild(node)
            } catch (xe) {
            }
        }
    })
}), qcVideo("SwfJsLink", function (util, JSON, H5, codeReport, vodReporter, constants) {
    var global = window, cap = function (str) {
        return str.replace(/(\w)/, function (v) {
            return v.toUpperCase()
        })
    }, tryIt = function (fn) {
        return function () {
            try {
                return fn.apply(this, arguments)
            } catch (xe) {
                return "0"
            }
        }
    }, pixesToInt = function (str) {
        return 0 | (str ? str + "" : "").replace("px", "")
    }, SwfJsLink = function (id, listeners) {
        var me = this;
        me.id = id, me.tecGet = id + "_tecGet", me.operate = id + "_operate", me.source = id + "_source", me.barrage = id + "_barrage", me.close_barrage = id + "_close_barrage", me.login_barrage = id + "_login_barrage", me.check_login_barrage = id + "_check_login_barrage", me.listeners = {};
        var type = util.type(listeners);
        listeners && "function" != type ? "object" == type && util.merge(me.listeners, listeners) : me.listeners.playStatus = listeners || function () {
        }, global[id + "_callback"] = function (cmd) {
            var cmds = cmd.split(":"), key = cmds[0];
            if (me.listeners.hasOwnProperty(key)) switch (key) {
                case"playStatus":
                    me.listeners[key](cmds[1]);
                    break;
                case"fullScreen":
                    me.listeners[key]("1" == cmds[1]);
                    break;
                case"dragPlay":
                    me.listeners[key](cmds[1]);
                    break;
                case"netStatus":
                    me.listeners[key](cmds[1])
            }
        }, global[id + "_call_js"] = function (cmd, data) {
            if ("codeReport" == cmd && codeReport.reportParams(data), "vodReport" == cmd && vodReporter.reportParams(data), "wording" == cmd) {
                var msg = {};
                return util.merge(msg, constants.ERROR_MSG), util.merge(msg, constants.TIP_MESSAGE), util.merge(msg, constants.NAMES_DEFINITION), util.merge(msg, constants.UNICODE_WORD), msg
            }
        }
    };
    return util.each(["volume", "duration", "currentTime", "clarity", "allClaritys"], function (name) {
        SwfJsLink.prototype["get" + cap(name)] = function (name) {
            return function () {
                try {
                    var ret = this.getSwf()[this.tecGet](name);
                    return "currentTime" == name && (ret = 0 | ret), ret
                } catch (xe) {
                    return ""
                }
            }
        }(name)
    }), util.each(["seeking", "suspended", "playing", "playEnd"], function (name) {
        SwfJsLink.prototype["is" + cap(name)] = function (name) {
            return function () {
                try {
                    var state = this.getSwf()[this.tecGet]("playState");
                    if (state == name) return !0
                } catch (xe) {
                }
                return !1
            }
        }(name)
    }), util.merge(SwfJsLink.prototype, {
        setSwf: function (obj) {
            this.swf = obj, this.tecGet = "sdk_tecGet", this.operate = "sdk_operate", this.source = "sdk_source", this.barrage = "sdk_barrage", this.close_barrage = "sdk_close_barrage"
        }, isJsPlayer: function () {
            return "sdk_tecGet" == this.tecGet
        }, getSwf: function () {
            var me = this;
            if (!me.swf) try {
                var ctx1 = document.getElementById(this.id + "_object"),
                    ctx2 = document.getElementById(this.id + "_embed");
                ctx1 && ctx1[this.tecGet] ? this.swf = ctx1 : ctx2 && ctx2[this.tecGet] && (this.swf = ctx2)
            } catch (xe) {
                return {}
            }
            return this.swf
        }, resize: function (w, h) {
            var swf = this.getSwf();
            swf && (this.isJsPlayer() ? this.getSwf()[this.operate]("resize", w, h) : (swf.width = pixesToInt(w), swf.height = pixesToInt(h)))
        }, getWidth: function () {
            return pixesToInt(this.getSwf().width)
        }, getHeight: function () {
            return pixesToInt(this.getSwf().height)
        }, pause: tryIt(function () {
            return this.getSwf()[this.operate]("pause")
        }), resume: tryIt(function () {
            return this.getSwf()[this.operate]("resume")
        }), play: tryIt(function (time) {
            return this.getSwf()[this.operate]("play", 0 | time || 1)
        }), setClarity: tryIt(function (clarity) {
            return this.getSwf()[this.operate]("clarity", -1, clarity)
        }), setFullScreen: tryIt(function (fullScreen) {
            return fullScreen ? this.getSwf()[this.operate]("openfullscreen") : this.getSwf()[this.operate]("cancelfullscreen")
        }), capture: tryIt(function () {
            return this.getSwf()[this.operate]("capture")
        }), changeVideo: tryIt(function (opt) {
            if (!this.isJsPlayer()) return this.getSwf()[this.source](opt.file_id, opt.app_id || "", opt.videos && opt.videos.length ? JSON.stringify(opt.videos) : "", opt.third_video ? JSON.stringify(opt.third_video) : "", opt.auto_play ? 1 : 0);
            var args = this.getSwf()[this.source](), link = this;
            opt.width = opt.width || args.width, opt.height = opt.height || args.height, opt.refer = args.refer, qcVideo.use("$", function (mod) {
                new H5(mod, args.targetId, opt, args.eid, link)
            })
        }), remove: tryIt(function () {
            var swf = this.getSwf(), parent = swf.parentNode;
            parent.removeChild(swf), "object" == (parent.tagName || "").toLowerCase() && parent.parentNode.removeChild(parent)
        }), isFullScreen: function () {
            try {
                return "1" == this.getSwf()[this.tecGet]("fullscreen")
            } catch (xe) {
            }
            return !1
        }, addBarrage: tryIt(function (ary) {
            if (ary && ary.length > 0) return this.getSwf()[this.barrage](JSON.stringify(ary))
        }), closeBarrage: tryIt(function () {
            return this.getSwf()[this.close_barrage]()
        }), loginBarrage: tryIt(function (info) {
            var m = info ? JSON.stringify(info) : "";
            return this.getSwf()[this.login_barrage](m)
        }), checkLoginBarrage: tryIt(function (appid) {
            return this.getSwf()[this.check_login_barrage](appid)
        })
    }), SwfJsLink
}), qcVideo("TDBankReporter", function (MD5, constants) {
    var _platForm = 6, _storeInfo = {}, _playId = "", _ifFirstPlaying = !0, _vid = "", _reportStep = 2,
        pushPlayEvent = function (event, storeInfo) {
            switch (_storeInfo = storeInfo || {}, event) {
                case"playing":
                    (_ifFirstPlaying || _vid != storeInfo.vid) && (_vid = storeInfo.vid, _playId = MD5.md5((new Date).getTime()), _reportStep = 2, _detectOS(), sendReq()), _ifFirstPlaying = !1;
                    break;
                case"seeking":
                    break;
                case"playEnd":
                    _ifFirstPlaying = !0;
                    break;
                case"suspended":
                    break;
                case"connectInit":
                    _reportStep = 200, _platForm = 0, sendReq();
                    break;
                case"connectInitFlash":
                    _reportStep = 201, _platForm = 0, sendReq();
                    break;
                case"connectInitH5":
                    _reportStep = 202, _platForm = 0, sendReq();
                    break;
                case"connectPlayCgiH5":
                    _reportStep = 204, _platForm = 0, sendReq()
            }
        }, _detectOS = function () {
            var detect = function () {
                var sUserAgent = navigator.userAgent;
                return /Android/i.test(sUserAgent) ? "Android" : /iPhone|iPad|iPod/i.test(sUserAgent) ? "iOS" : /Windows/i.test(sUserAgent) ? "Windows" : /Mac/i.test(sUserAgent) ? "Mac" : "other"
            };
            switch (detect()) {
                case"Android":
                    _platForm = 4;
                    break;
                case"iOS":
                    _platForm = 5;
                    break;
                case"Windows":
                    _platForm = 6;
                    break;
                case"Mac":
                    _platForm = 7;
                    break;
                default:
                    _platForm = 6
            }
        }, _getReportData = function () {
            var dataArray = [_platForm, _storeInfo.setting ? _storeInfo.setting.app_id : 0, "", _storeInfo.vid || "", _playId || "", "", 0, "", 0, "", _reportStep || 2, encodeURIComponent(window.location.href) || "", 0];
            return dataArray.join(";")
        }, http_img_sender = function () {
            var img = new Image, sender = function (src) {
                img.onload = img.onerror = img.onabort = function () {
                    img.onload = img.onerror = img.onabort = null, img = null
                }, img.src = src
            };
            return sender
        }, sendReq = function () {
            var reqData = _getReportData(),
                url = constants.TDBANK_REPORT_API + '?m=dataImport&p=["100043","' + reqData + '"]';
            try {
                var sender = http_img_sender();
                sender(url)
            } catch (xe) {
            }
        };
    return _detectOS(), {className: "TDBankReporter", pushEvent: pushPlayEvent}
}), qcVideo.use("Player", function (mod) {
    qcVideo.Player = mod
}), qcVideo("h5player", function ($, Base, constants, util, MediaPlayer, version) {
    var getSpecArgs = function (opt) {
        return {
            disable_drag: !!opt.disable_drag,
            stretch_full: !!opt.stretch_full,
            stop_time: 0 | opt.stop_time,
            remember: !!opt.remember,
            stretch_patch: !!opt.stretch_patch,
            disable_full_screen: !!opt.disable_full_screen,
            hide_h5_setting: !!opt.hide_h5_setting
        }
    };
    return Base.instance({
        className: "h5player", constructor: Base.loop, render: function (opt) {
            Base.setDebug(opt.debug);
            var parameter = opt.parameter || {}, store = {
                    patch: {},
                    videos: {},
                    logo: {},
                    setting: {
                        width: opt.width,
                        height: opt.height,
                        $renderTo: opt.$renderTo,
                        isAutoPlay: 1 == parameter.auto_play,
                        file_id: parameter.file_id,
                        app_id: parameter.app_id,
                        definition: parameter.definition,
                        resolution: void 0,
                        inWhiteHlsJs: parameter.inWhiteHlsJs,
                        playbackRate: parameter.playbackRate || 1
                    }
                }, fileInfo = opt.file_info, video = fileInfo.image_video.videoUrls || [], player_info = opt.player_info,
                patch = player_info.patch_info || [];
            version.ABLE_H5_HLS || version.ABLE_H5_APPLE_HLS || version.REQUIRE_HLS_JS && parameter.inWhiteHlsJs || (constants.DEFINITION_PRIORITY = constants.JUST_MP4_DEFINITION_PRIORITY);
            var resolution = player_info.resolution_type;
            void 0 !== resolution && (store.setting.resolution = resolution), store.imgUrls = fileInfo.image_video.imgUrls, store.image_url = fileInfo.image_url, store.duration = 0 | fileInfo.duration, store.logo.url = player_info.logo_pic, store.logo.location = player_info.logo_location, store.logo.redirect = player_info.logo_url, store.customization = getSpecArgs(opt), store.keepArgs = opt.keepArgs, store.sdk_method = opt.sdk_method, store.vid = fileInfo.vid, $.each(patch, function (_, item) {
                store.patch[0 | item.location_type] = {
                    url: item.patch_url,
                    redirect: item.patch_redirect_url,
                    type: item.patch_type
                }
            });
            var hasMoreFormat = !1, sourceIsMp4 = !1, hasDefinition = !1, defConfigs = constants.DEFINITION_PRIORITY,
                hasThird = !!parameter.third_video;
            if ($.each(video, function (_, item) {
                    var def = 0 | item.definition;
                    0 == def ? item.url.toLowerCase().indexOf(".mp4") > 0 && (sourceIsMp4 = !0) : def > 1 && (hasMoreFormat = !0);
                    var _defList = "";
                    for (var i in defConfigs) _defList = "," + defConfigs[i].join(",") + ",", _defList.indexOf("," + def + ",") != -1 && (hasDefinition = !0);
                    store.videos[def] = {
                        definition: def,
                        name: fileInfo.name || "",
                        url: hasThird !== !0 ? item.url.replace(/http:|https:/i, document.location.protocol) : item.url,
                        height: item.vheight,
                        width: item.vwidth
                    }
                }), !hasDefinition) {
                void 0 == store.setting.resolution && (store.setting.resolution = "1");
                for (var key in store.videos) key > 0 && constants.DEFINITION_PRIORITY[store.setting.resolution].push(+key)
            }
            sourceIsMp4 && !hasMoreFormat && (constants.DEFINITION_PRIORITY = constants.ONLY_MP4_NO_TRANS, opt.disable_drag = !0, store.customization = getSpecArgs(opt)), this.mediaPlayer = new MediaPlayer(store)
        }, destroy: function () {
            this.mediaPlayer.destroy()
        }
    })
}), qcVideo("Bottom_container", function ($, UICom, Drag, util, UiControl, constants, FullScreenApi, version) {
    var volume_width = 49, undefined = undefined, EVENT = constants.EVENT, FIRE = constants.FIRE,
        WORD = constants.UNICODE_WORD, svg_info = {
            play: {title: WORD.PLAY, method: "svg_bottom_play"},
            pause: {title: WORD.PAUSE, method: "svg_bottom_pause"},
            volume: {title: WORD.MUTE, method: "svg_bottom_volume"},
            mute_volume: {title: WORD.VOLUME, method: "svg_bottom_volume_mute"},
            full_volume: {title: WORD.VOLUME, method: "svg_bottom_volume_full"},
            fullscreen: {title: WORD.FULL_SCREEN, method: "svg_bottom_fullscreen"},
            quit_fullscreen: {title: WORD.EXIT_FULL_SCREEN, method: "svg_bottom_quit_fullscreen"}
        };
    return UICom.extend({
        className: "Bottom_container", init: function () {
            var me = this;
            me.subs = {}, me.$el.find("[sub-component]").each(function () {
                var $me = $(this);
                me.subs[$me.attr("sub-component")] = $me
            }), me.processDrag = new Drag(me.subs.progress_pointer, me.subs.progress_bg).on(Drag.EVENT_DRAG_STOP, function () {
                var p = this.getPercent();
                me.fire(FIRE, {event: EVENT.UI_DRAG_PLAY, value: {percent: p}}), me._setSimulationPercent(p)
            }), me.subs.volume_slider && (me.volumeDrag = new Drag(me.subs.volume_slider, me.subs.volume_bg).on(Drag.EVENT_DRAG_STOP, function () {
                me.fire(FIRE, {event: EVENT.UI_SET_VOLUME, value: {volume: this.getPercent()}})
            }).setMaxWidth(volume_width - 4)), $(window).on("keydown", function (e) {
                var keyCode = e.keyCode;
                38 == keyCode ? me.volumeDrag && me.fire(FIRE, {
                    event: EVENT.UI_SET_VOLUME,
                    value: {volume: Math.min(1, me.volumeDrag.getPercent() + .1)}
                }) : 40 == keyCode ? me.volumeDrag && me.fire(FIRE, {
                    event: EVENT.UI_SET_VOLUME,
                    value: {volume: Math.max(0, me.volumeDrag.getPercent() - .1)}
                }) : 39 == keyCode ? me.fire(FIRE, {
                    event: EVENT.UI_PLUS_PLAY,
                    value: {}
                }) : 37 == keyCode && me.fire(FIRE, {event: EVENT.UI_MINUS_PLAY, value: {}})
            }), FullScreenApi.supportFullScreen || (this.subs.fullscreen_btn && this.subs.fullscreen_btn.width(0).height(0).hide().empty(), this.subs.setting.css("right", 5))
        }, enableFull: function (bool) {
            this.subs.fullscreen_btn && this.subs.fullscreen_btn[bool ? "show" : "hide"]()
        }, enableDrag: function (bool) {
            this.processDrag.enAble(bool);
            var cursor = bool ? "pointer" : "default";
            this.subs.progress_load.css("cursor", cursor), this.subs.progress_bg.css("cursor", cursor)
        }, catchControlStatusChange: function (s, obj) {
            var m = UiControl.MODE, subs = this.subs;
            switch (this.enable(!0), s) {
                case m.WAIT:
                    this.enable(!1), this.$el.show(), this._setSvg(subs.play_btn, "play");
                    break;
                case m.PLAY:
                    this._setSvg(subs.play_btn, "pause");
                    break;
                case m.PAUSE:
                    this._setSvg(subs.play_btn, "play");
                    break;
                case m.FULL:
                    this._setSvg(subs.fullscreen_btn, "quit_fullscreen");
                    break;
                case m.QUIT_FULL:
                    this._setSvg(subs.fullscreen_btn, "fullscreen");
                    break;
                case m.RESIZE:
                    obj.offset.width > 0 && (obj.offset.width < 270 ? this.subs.time_duration.hide() : this.subs.time_duration.show());
                    break;
                case m.END:
                    this._setProgress({pPercent: 0, lPercent: 100})
            }
        }, _setSvg: function ($dom, name) {
            if ($dom.attr("now") !== name) {
                var item = svg_info[name];
                $dom.attr({title: item.title, now: name}).find("svg").each(function () {
                    var $svg = $(this), id = $svg.attr("svg-mode");
                    id == item.method ? $(this).width("100%").height("100%").show() : $(this).hide()
                })
            }
        }, _setSimulationPercent: function (percent) {
            var me = this;
            setTimeout(function () {
                me.fire(FIRE, {event: EVENT.UI_SIMULATION_POSITION, value: {percent: percent}})
            }, 25)
        }, _setProgress: function (obj) {
            var me = this, subs = me.subs;
            if (subs) {
                if (obj.lPercent !== undefined) {
                    var lPercent = (obj.lPercent || 0) / 100;
                    me._lPercent !== lPercent && (me._lPercent = lPercent, subs.progress_load.css("width", 100 * lPercent + "%"))
                }
                if (obj.pPercent !== undefined && me.processDrag && !me.processDrag.isMoving()) {
                    var pPercent = (obj.pPercent || 0) / 100;
                    me._pPercent !== pPercent && (me._pPercent = pPercent, subs.progress_play.css("width", 100 * pPercent + "%"), subs.progress_pointer.css("left", pPercent * subs.progress_bg.width()))
                }
            }
        }, setTime: function (obj) {
            var subs = this.subs;
            obj.currentTime !== undefined && this.duration && (subs.time_played.html(util.convertTime(obj.currentTime)), this._setProgress({pPercent: util.fix2(obj.currentTime / this.duration * 100)})), obj.duration !== undefined && (this.duration = obj.duration, subs.time_duration.html(" / " + util.convertTime(obj.duration))), obj.loaded !== undefined && this.duration && this._setProgress({lPercent: util.fix2(obj.loaded / this.duration * 100)})
        }, setVolume: function (vPercent) {
            var me = this, subs = me.subs;
            subs && (100 == vPercent ? me._setSvg(subs.volume_mute, "full_volume") : 0 == vPercent ? me._setSvg(subs.volume_mute, "mute_volume") : me._setSvg(subs.volume_mute, "volume"), vPercent = (vPercent || 0) / 100 * volume_width, subs.volume_track.width(vPercent), me.volumeDrag && !me.volumeDrag.isMoving() && subs.volume_slider.css("left", vPercent))
        }, on_click_setting: function () {
            this.fire(FIRE, {event: EVENT.UI_OPEN_SETTING, value: {}})
        }, on_click_play_btn: function ($dom) {
            this.fire(FIRE, {event: EVENT["play" == $dom.attr("now") ? "UI_PLAY" : "UI_PAUSE"], value: {}})
        }, on_click_volume_mute: function ($dom) {
            this.fire(FIRE, {
                event: EVENT.UI_SET_VOLUME,
                value: {volume: $dom.attr("now") in {full_volume: !0, mute_volume: !0} ? .5 : 0}
            })
        }, on_click_fullscreen_btn: function ($dom) {
            this.fire(FIRE, {
                event: "fullscreen" == $dom.attr("now") ? EVENT.UI_FULL_SCREEN : EVENT.UI_QUIT_FULL_SCREEN,
                value: {}
            })
        }, _click_progress_handler: function (event) {
            if (this.processDrag.isAble()) {
                var $bg = this.subs.progress_bg,
                    percent = ((event.pageX - $bg.offset().left) / $bg.width()).toFixed(3) - 0;
                this.debug("点击播放进度百分比==" + percent), this.fire(FIRE, {
                    event: EVENT.UI_DRAG_PLAY,
                    value: {percent: percent}
                }), this._setSimulationPercent(percent)
            }
        }, _click_volume_handler: function (event) {
            var $bg = this.subs.volume_bg, percent = ((event.pageX - $bg.offset().left) / $bg.width()).toFixed(3) - 0;
            this.fire(FIRE, {event: EVENT.UI_SET_VOLUME, value: {volume: percent}})
        }, on_click_progress_bg: function ($d, e) {
            this._click_progress_handler(e)
        }, on_click_progress_play: function ($d, e) {
            this._click_progress_handler(e)
        }, on_click_progress_load: function ($d, e) {
            this._click_progress_handler(e)
        }, on_click_volume_bg: function ($d, e) {
            this._click_volume_handler(e)
        }, on_click_volume_track: function ($d, e) {
            this._click_volume_handler(e)
        }
    })
}), qcVideo("Center_container", function ($, UICom, constants, UiControl, version) {
    return UICom.extend({
        className: "Center_container", init: function () {
            var me = this;
            me.subs = {}, me.$el.find("[sub-component]").each(function () {
                var $me = $(this);
                me.subs[$me.attr("sub-component")] = $me
            }), me._fixButtonSize(), me.subs.play.on("mouseenter", function () {
                me.log("mouseenter", me.subs.play.find("circle[data-opacity]")), me.subs.play.find("circle[data-opacity]").attr("fill-opacity", "0.8")
            }).on("mouseleave", function () {
                me.log("mouseleave", me.subs.play.find("circle[data-opacity]")), me.subs.play.find("circle[data-opacity]").attr("fill-opacity", "0.5")
            })
        }, catchControlStatusChange: function (s, data) {
            var m = UiControl.MODE, subs = this.subs;
            switch (subs.error.hide(), s) {
                case m.WAIT:
                    subs.play.hide(), subs.loading.show();
                    break;
                case m.PLAY:
                    subs.loading.hide(), subs.play.hide();
                    break;
                case m.PAUSE:
                    subs.loading.hide(), subs.play.show();
                    break;
                case m.ERROR:
                    subs.loading.hide(), subs.play.hide(), subs.error.text(data.msg).show();
                    break;
                case m.FULL:
                    this._fixButtonSize();
                    break;
                case m.QUIT_FULL:
                    this._fixButtonSize();
                    break;
                case m.RESIZE:
                    this._fixButtonSize();
                    break;
                case m.END:
                    subs.loading.hide(), subs.play.show()
            }
        }, _fixButtonSize: function () {
            var me = this, offset = me.store.getMainOffset(), max = version.IS_MOBILE ? 2e3 : 75,
                size = Math.min(.3 * Math.min(offset.width, offset.height), max) / 2;
            me.subs.play.width(2 * size).height(2 * size).css({margin: "-" + size + "px 0 0 -" + size + "px"})
        }, on_click_play: function () {
            this.fire(constants.FIRE, {event: constants.EVENT.UI_PLAY, value: {}})
        }
    })
}), qcVideo("Logo", function ($, UICom) {
    return UICom.extend({
        className: "Logo", init: function () {
            this._setLogo(this.store.getLogo())
        }, _setLogo: function (obj) {
            var html = "";
            if (obj && obj.url) {
                var href = obj.redirect && obj.redirect.length > 10 ? obj.redirect : "javascript:void(0);",
                    style = "position:absolute;z-index:20;", loc = obj.location = 0 | obj.location;
                0 == loc ? style += "top:5px;left:5px;" : 1 == loc ? style += "bottom:5px;left:5px;" : 2 == loc ? style += "top:5px;right:5px;" : 3 == loc && (style += "bottom:5px;right:5px;"), html = '<a href="' + href + '" target="_blank"><img src="' + obj.url + '" style="' + style + '"/></a>'
            }
            this.$el.html(html), this.$el.find("img").on("error", function (e) {
                $(this).parent().remove()
            })
        }
    })
}), qcVideo("Patch", function ($, UICom, UiControl, util) {
    return UICom.extend({
        className: "Patch", init: function () {
            this._show_start_patch = !1
        }, catchControlStatusChange: function (s, data) {
            var m = UiControl.MODE, me = this;
            switch (me.$el.show(), s) {
                case m.WAIT:
                    me.store.happenToSdk("playStatus:seeking"), me._poster = null, me.$el.hide();
                    break;
                case m.PLAY:
                    me._poster = null, me._show_start_patch = !0, me.$el.html(""), me.store.happenToSdk("playStatus:playing");
                    break;
                case m.PAUSE:
                    me._show_start_patch ? (me._setPoster(me.store.getPausePatch()), me.store.happenToSdk("playStatus:" + me.status.getSDKStatus())) : (me._show_start_patch = !0, me._setPoster(me.store.getStartPatch()), me.store.happenToSdk("playStatus:ready"));
                    break;
                case m.ERROR:
                    me._poster = null, me.$el.html("");
                    break;
                case m.END:
                    me._setPoster(me.store.getSopPatch()), me.store.happenToSdk("playStatus:playEnd");
                    break;
                case m.RESIZE:
                    me._poster && me._setPoster(me._poster);
                    break;
                case m.DRAG:
                    me.store.happenToSdk("dragPlay:" + data.time)
            }
        }, _setPoster: function (obj) {
            if (obj && obj.url) {
                var me = this, $el = me.$el, hasRedirect = obj.redirect && obj.redirect.length > 7,
                    link = hasRedirect ? obj.redirect : "javascript:void(0);",
                    style = hasRedirect ? "" : "cursor: default;";
                me._poster = obj;
                var tpl = qcVideo.get("MediaPlayer_tpl");
                me.store.isCustomization("stretch_patch") ? $el.html(tpl.patch_image({
                    astyle: style,
                    istyle: "z-index: 31;position: absolute;top: 0;left: 0;width:100%;height:100%;border:none;",
                    url: obj.url,
                    link: "javascript:void(0)"
                })) : util.loadImg(obj.url, function () {
                    var offset = me.store.getMainOffset(),
                        target = util.resize(offset, {width: this.width, height: this.height});
                    $el.html(tpl.patch_image({
                        astyle: style,
                        istyle: "z-index: 31;position: absolute;border:none;top: " + (offset.height >= target.height ? (offset.height - target.height) / 2 + "px" : "0px") + ";left: " + (offset.width >= target.width ? (offset.width - target.width) / 2 + "px" : "0px") + ";width:" + target.width + "px;height:" + target.height + "px",
                        url: obj.url,
                        link: link
                    }))
                })
            }
        }
    })
}), qcVideo("Setting", function ($, UICom, constants) {
    return UICom.extend({
        FULL_VIEW: !1, className: "Setting", init: function () {
            var w = $(document.body).width();
            w > 0 && w < 500 && (this.FULL_VIEW = !0);
            var data = [], all = this.store.getUniqueNoDefinition();
            for (var key in all) data.push({
                sdk_no: all[key].resolutionNameNo,
                sdk_name: constants.NAMES_DEFINITION[constants.DEFINITION_MAP[all[key].resolutionName]]
            });
            var tplObj = qcVideo.get("MediaPlayer_tpl");
            this.$el.append(tplObj.setting_definition({name: constants.UNICODE_WORD.SWITCH_DEF, values: data}))
        }, show: function (obj) {
            var me = this, on = "setting-definition-value-curr", off = "setting-definition-value";
            me.$el.find("div[data-def]").each(function () {
                var $me = $(this);
                $me.attr("data-def") == obj.currentDefinitionSdkNo ? $me.removeClass(off).addClass(on) : $me.addClass(off).removeClass(on)
            }), me.$el.show().css("opacity", .8)
        }, hide: function () {
            var me = this;
            me.$el.css("opacity", 0), setTimeout(function () {
                me.$el.hide()
            }, 300)
        }, on_click_definition: function ($dom) {
            $dom.hasClass("setting-definition-value-curr") || (this.hide(), this.fire(constants.FIRE, {
                event: constants.EVENT.UI_CHOSE_DEFINITION,
                value: {value: 0 | $dom.attr("data-def")}
            }))
        }, on_click_close: function () {
            this.hide()
        }
    })
}), qcVideo("UICom", function (Base) {
    var undefined = undefined;
    return Base.extend({
        className: "UICom", tapEvent: "click", destroy: function () {
            this.$el && (this.$el.remove(), delete this.$el, delete this.status, delete this.store)
        }, constructor: function (store, status, $el) {
            var me = this;
            me.$el = $el, me.status = status, me.store = store, me.enable_tag = !0, me.init()
        }, init: Base.loop, visible: function (visible) {
            this.$el && this.$el[visible ? "show" : "hide"]()
        }, enable: function (enable) {
            return enable === undefined ? !!this.enable_tag : void(this.enable_tag = enable)
        }, catchControlStatusChange: Base.loop, live: function (match, fn) {
            var me = this, get = function (ctx, hand) {
                return function (e) {
                    return ctx.enable_tag && hand.call(ctx, this, e), e.stopPropagation(), !1
                }
            };
            me.$el.on(me.tapEvent, match, get(me, fn))
        }
    })
}), qcVideo("Drag", function ($) {
    var Drag = function ($el, $papa) {
        var me = this;
        me.$papa = $papa, me.$el = $el, me.maxWidth = 0, me._able = !0, me[Drag.EVENT_DRAG_START] = me[Drag.EVENT_DRAG_STOP] = me[Drag.EVENT_DRAG_ING] = function () {
        }, me.$el.on("dragstart", function (e) {
            me._able && me._dragStartHandler.call(me, e)
        }).on("drag", function (e) {
            me._able && me._dragDragHandler.call(me, e)
        }).on("dragend", function (e) {
            me._able && me._dragEndHandler.call(me, e)
        }).on("dragenter", function (e) {
            e.preventDefault()
        }).on("dragover", function (e) {
            e.preventDefault()
        })
    };
    return $.extend(Drag.prototype, {
        _modifyPath: function (e) {
            var diff = e.x - this._startX + this._sourceLeft;
            diff >= 0 && diff <= this._maxWidth && this.$el.css("left", diff)
        }, _dragStartHandler: function (e) {
            this.__moving = !0, this._maxWidth = this.maxWidth || this.$papa.width(), this._startX = e.x, this._sourceLeft = this.$el.position().left, this[Drag.EVENT_DRAG_START]()
        }, _dragDragHandler: function (e) {
            this._modifyPath(e), this[Drag.EVENT_DRAG_ING]()
        }, _dragEndHandler: function (e) {
            this._modifyPath(e), this[Drag.EVENT_DRAG_STOP](), this.__moving = !1
        }, getPercent: function () {
            return this.$el.position().left / (this.maxWidth || this.$papa.width())
        }, on: function (eventName, fn) {
            return this[eventName] = fn, this
        }, isMoving: function () {
            return !!this.__moving
        }, setMaxWidth: function (w) {
            return this.maxWidth = w, this
        }, enAble: function (able) {
            this._able = able
        }, isAble: function () {
            return this._able
        }
    }), Drag.EVENT_DRAG_START = "EVENT_DRAG_START", Drag.EVENT_DRAG_STOP = "EVENT_DRAG_STOP", Drag.EVENT_DRAG_ING = "EVENT_DRAG_ING", Drag
}), qcVideo("MediaPlayer", function ($, Base, UiControl, PlayerSystem, PlayerStore, MediaPlayer_tpl, Error, version, constants, FullScreenApi) {
    var mainId = "trump_main_unique_", uuid = 1;
    return Base.extend({
        system: !1, store: !1, control: !1, className: "MediaPlayer", destroy: function () {
            this.control && (this.system.destroy(), this.control.destroy(), this.store.destroy(), delete this.control, delete this.system, delete this.store)
        }, __filter_play: function () {
            var me = this;
            me.system.isMetaDataRendered() || (me.control.setWait(), me.system.status.setSDKStatus("seeking"))
        }, dragPlay: function (second) {
            var me = this;
            me.playEndYet = !1, me.whenReadyToPlay = !0, me.__filter_play(), me.system.play(second), me.control.setDragPlay(second)
        }, toPlay: function (second) {
            var me = this;
            me.playEndYet = !1;
            var url = this.video_data.url, system = this.system, status = system.status;
            this.whenReadyToPlay = !0, this.__filter_play(), "error" === status.getRunningStatus() && (status.clear(), status.setRememberKey(url), system.setUrl(url)), system.play(void 0 !== second ? second : status.get_played())
        }, tapEvent: "click", toPxNum: function (n) {
            return 0 | (n || "").toLowerCase().replace("px", "")
        }, ableToPlay: function (t) {
            var me = this, stop_time = me.store.getCustomization("stop_time");
            return !(stop_time && me.system.status.get_played() >= stop_time)
        }, constructor: function (info) {
            var me = this, mid = mainId + uuid++, EVENT = constants.EVENT, setting = info.setting;
            if (!setting.width || !setting.height) {
                var $p = setting.$renderTo.parent(), pw = $p.width(), ph = $p.height();
                setting.width = pw - me.toPxNum($p.css("padding-left")) - me.toPxNum($p.css("padding-right")), setting.height = ph - me.toPxNum($p.css("padding-top")) - me.toPxNum($p.css("padding-bottom"))
            }
            var store = me.store = new PlayerStore(info), $container = setting.$renderTo.html(MediaPlayer_tpl.main({
                    width: setting.width,
                    height: setting.height,
                    mainId: mid
                })).find("div"), system = me.system = new PlayerSystem($container), status = system.getStatus(),
                video = me.video_data = store.getVideoInfo(setting.resolution, setting.definition);
            video.url || console && console.error("当前环境没有可播放的视频文件");
            var ableRemember = store.isCustomization("remember");
            status.setRememberKey(video.url), status.enableRemember(ableRemember), status.set_duration(store.getDuration()), me.system.fileType === constants.HLS && (ableRemember = !1, store.setCustomization("disable_drag", !0)), store.store.mainId = mid, me.control = new UiControl(store, status, $container), me.control.enableDrag(!store.isCustomization("disable_drag")), me.control.enableFull(!store.isCustomization("disable_full_screen")), me.system.setUrl(video.url), me.system.status.setRunningStatus("wait"), status.setSDKStatus("suspended"), me.batchOn(status, [{
                event: EVENT.OS_PROGRESS,
                fn: function () {
                    me.control.setTime({loaded: status.get_loaded()})
                }
            }, {
                event: EVENT.OS_TIME_UPDATE, fn: function () {
                    var played = status.get_played();
                    me.control.setTime({currentTime: played}), me.ableToPlay(played) || system.pause()
                }
            }, {
                event: EVENT.OS_BLOCK, fn: function (e) {
                    status.setRunningStatus("error"), me.control.setError(Error.NET_ERROR)
                }
            }, {
                event: EVENT.OS_PLAYER_END, fn: function (e) {
                    playEnd()
                }
            }]);
            var playEnd = function () {
                me.playEndYet = !0, me.whenReadyToPlay = !1, me.control.setEnd(), status.setRunningStatus("end"), status.setSDKStatus("playEnd")
            };
            if (FullScreenApi.supportFullScreen) {
                var fullChange = function (event) {
                    var isFull = me.system.isFullScreen($("#" + store.store.mainId));
                    isFull || me.system.setFullScreen(!1, store.store.mainId);
                    try {
                        me.control.setFull(isFull), me.control.setResize()
                    } catch (xe) {
                    }
                };
                $(document).on(FullScreenApi.fullscreenchange, fullChange), $("#" + store.store.mainId).on(FullScreenApi.fullscreenchange, fullChange)
            }
            version.IS_MOBILE || $container.on(me.tapEvent, function (e) {
                "play" == status.getRunningStatus() && system.pause()
            }), me.batchOn(me.control, [{
                event: EVENT.UI_PLAY, fn: function (e) {
                    var time = e.time || status.get_played();
                    me.playEndYet && (time = 0), me.ableToPlay(time) && me.toPlay(time)
                }
            }, {
                event: EVENT.UI_PAUSE, fn: function (e) {
                    system.pause()
                }
            }, {
                event: EVENT.UI_SET_VOLUME, fn: function (e) {
                    system.volume(e.volume)
                }
            }, {
                event: EVENT.UI_DRAG_PLAY, fn: function (e) {
                    var time = e.percent * store.getDuration() | 0;
                    time && !me.ableToPlay(time) || me.dragPlay(time)
                }
            }, {
                event: EVENT.UI_FULL_SCREEN, fn: function (e) {
                    me.system.setFullScreen(!0, mid)
                }
            }, {
                event: EVENT.UI_QUIT_FULL_SCREEN, fn: function (e) {
                    me.system.setFullScreen(!1, mid)
                }
            }, {
                event: EVENT.UI_PLUS_PLAY, fn: function (e) {
                    var time = Math.min(status.get_played() + 5, store.getDuration() - 2);
                    time && !me.ableToPlay(time) || me.dragPlay(time)
                }
            }, {
                event: EVENT.UI_MINUS_PLAY, fn: function (e) {
                    var time = Math.max(status.get_played() - 5, 0);
                    time && !me.ableToPlay(time) || me.dragPlay(time)
                }
            }, {
                event: EVENT.UI_SIMULATION_POSITION, fn: function (e) {
                    me.control.setTime({
                        loaded: status.start_duration(),
                        currentTime: parseInt(e.percent * store.getDuration())
                    })
                }
            }, {
                event: EVENT.UI_OPEN_SETTING, fn: function (e) {
                    me.control.openSetting({currentDefinitionSdkNo: me.video_data.resolutionNameNo})
                }
            }, {
                event: EVENT.UI_CHOSE_DEFINITION, fn: function (e) {
                    me.switchClarity(e.value)
                }
            }]);
            var updateShowMode = function (end) {
                version.IS_MOBILE && (end ? (system.setShowMode(!1), me.control.show()) : (system.setShowMode(!0), me.control.hide()))
            };
            me.batchOn(system, [{
                event: EVENT.OS_LAND_SCAPE_UI, fn: function () {
                }
            }, {
                event: EVENT.OS_PORTRAIT_UI, fn: function () {
                }
            }, {
                event: EVENT.OS_LOADED_META_DATA, fn: function () {
                    me.whenReadyToPlay ? me.switchPlayTime ? setTimeout(function () {
                        me.dragPlay(me.switchPlayTime), me.switchPlayTime = 0
                    }, 10) : me.control.setPlay() : (system.pause(), me.control.setPause(), status.setSDKStatus("suspended"))
                }
            }, {
                event: EVENT.OS_RESIZE, fn: function (e) {
                    me.control.setResize()
                }
            }, {
                event: EVENT.OS_PLAYING, fn: function (e) {
                    me.control.setPlay(), status.setSDKStatus("playing"), updateShowMode(!1)
                }
            }, {
                event: EVENT.OS_SEEKING, fn: function (e) {
                    me.control.setWait(), status.setSDKStatus("seeking"), updateShowMode(!1)
                }
            }, {
                event: EVENT.OS_PAUSE, fn: function (e) {
                    var t = status.get_played(), a = store.getDuration();
                    t > 1 && a && Math.abs(a - t) < 2 || (me.ableToPlay(t) ? status.setSDKStatus("suspended") : status.setSDKStatus("stop"), me.control.setPause(), updateShowMode(!0))
                }
            }, {
                event: EVENT.OS_VOLUME_CHANGE, fn: function (e) {
                    me.control.setVolume(e.volume)
                }
            }, {
                event: EVENT.OS_PLAYER_END, fn: function (e) {
                    playEnd(), updateShowMode(!0)
                }
            }, {
                event: EVENT.OS_BLOCK, fn: function (e) {
                    status.setRunningStatus("error"), me.control.setError(Error.NET_ERROR)
                }
            }, {
                event: EVENT.OS_DURATION_UPDATE, fn: function (e) {
                    me.store.store.duration = e.duration, me.control.setTime(e)
                }
            }]), ableRemember && me.rememberPlay(status, system, 0 | info.duration), system.setPlayRate(setting.playbackRate), me.whenReadyToPlay = !1, setting.isAutoPlay && !version.IS_MOBILE ? setTimeout(function () {
                me.whenReadyToPlay = !0, me.control.setWait(), system.play()
            }, 10) : me.control.setPause()
        }, rememberPlay: function (status, system, duration) {
            var lPlayed = status.get_local_played() - 0, lVolume = status.get_local_volume() - 0;
            lVolume > 0 && system.volume(lVolume), lPlayed > 0 && (0 == duration || lPlayed + 5 < duration) && (this.whenReadyToPlay = !0, this.debug("记忆播放位置:", lPlayed), this.system.setUrl(this.video_data.url), this.system.play())
        }, switchClarity: function (no) {
            var me = this, data = me.video_data, system = me.system;
            if (data.resolutionNameNo != no && me.store.isInDefinition(no)) {
                me.debug("当前清晰度", no);
                var video = me.video_data = me.store.getVideoInfo(constants.DEFINITION_NO_NAME[0 | no]),
                    played = system.status.get_played();
                me.whenReadyToPlay = !0, system.status.clear(), system.status.setRememberKey(video.url), system.setUrl(video.url), system.play(played), me.switchPlayTime = played, this.__filter_play()
            } else me.debug("当前不支持该清晰度切换", no)
        }, sdk_tecGet: function (attr, st) {
            if (this.store) {
                var status = this.system.status;
                switch (attr) {
                    case"volume":
                        return status.get_volume();
                    case"duration":
                        return this.store.getDuration();
                    case"currentTime":
                        return status.get_played();
                    case"clarity":
                        return this.video_data.resolutionNameNo;
                    case"allClaritys":
                        var key, all = this.store.getUniqueNoDefinition(), ret = [];
                        for (key in all) ret.push(all[key].resolutionNameNo);
                        return ret;
                    case"playState":
                        return status.getSDKStatus()
                }
            }
        }, sdk_operate: function (method, a, b, c) {
            if (this.store) switch (this.debug("operate", method), method) {
                case"resize":
                    var $main = $("#" + this.store.getIDMain());
                    $main.width(a).height(b), $main.parent().width(a).height(b), this.control.setResize();
                    break;
                case"pause":
                    this.system.pause();
                    break;
                case"resume":
                    this.toPlay();
                    break;
                case"play":
                    this.toPlay(a);
                    break;
                case"clarity":
                    this.switchClarity(b);
                    break;
                case"capture":
                    break;
                case"destroy":
                    this.destroy()
            }
        }, sdk_source: function () {
            if (this.store) {
                var ret = $.extend({}, this.store.getKeepArgs(), this.store.getMainOffset());
                return delete ret.width, delete ret.height, this.destroy(), ret
            }
        }, sdk_barrage: function (barrageAryStr) {
        }, sdk_close_barrage: function () {
        }
    })
}), qcVideo("MediaPlayer_tpl", function () {
    return {
        main: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p("<style>\r\n\t\t\t    #"), _p(this.__escapeHtml(data.mainId)), _p('{\r\n\t\t\t        width:100%;height:100%;margin: 0px auto;position:relative;background-color: #000;\r\n\t\t\t    }\r\n\t\t\t    </style>\r\n\t\t\t\t<div id="'), _p(this.__escapeHtml(data.mainId)), _p('" style="width:'), _p(this.__escapeHtml(data.width)), _p("px;height:"), _p(this.__escapeHtml(data.height)), _p('px"></div>'), __p.join("")
        }, patch: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p('<div component="patch"></div>'), __p.join("")
        }, patch_image: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p('<a style="'), _p(this.__escapeHtml(data.astyle)), _p('" href="'), _p(this.__escapeHtml(data.link)), _p('" '), _p(this.__escapeHtml(data.link.indexOf("javascript") > -1 ? "" : ' target="_blank"')), _p('><img style="'), _p(this.__escapeHtml(data.istyle)), _p('" src="'), _p(this.__escapeHtml(data.url)), _p('"/></a>'), __p.join("")
        }, logo: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p('<div class="'), _p(this.__escapeHtml(data.nick)), _p('control-module" component="logo"></div>'), __p.join("")
        }, setting: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p('<div class="'), _p(this.__escapeHtml(data.nick)), _p('setting" component="setting" style="display:none;">\r\n\t\t\t        <div sub-component="close" class="'), _p(this.__escapeHtml(data.nick)), _p('setting-close">>></div>\r\n\t\t\t    </div>'), __p.join("")
        }, setting_definition: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            _p('<!--更换清晰度-->\r\n\t\t\t    <div class="setting-definition">'), _p(this.__escapeHtml(data.name)), _p('</div>\r\n\t\t\t    <div class="setting-split-line"></div>\r\n\t\t\t    <div>');
            var value = data.values;
            for (var key in value) {
                var one = value[key];
                _p('            <div sub-component="definition" class="'), _p(this.__escapeHtml(one.selected ? "setting-definition-value-curr" : "setting-definition-value")), _p('" data-def="'), _p(this.__escapeHtml(one.sdk_no)), _p('">'), _p(this.__escapeHtml(one.sdk_name)), _p("</div>")
            }
            return _p("    </div>"), __p.join("")
        }, center: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            }, i = data.nick, dot = i + "spinner-dot " + i + "spinner-dot";
            return _p('    <div component="center_container">\r\n\t\t\t        <div class="'), _p(this.__escapeHtml(i)), _p('error" sub-component="error">\r\n\t\t\t\r\n\t\t\t        </div>\r\n\t\t\t        <div class="'), _p(this.__escapeHtml(i)), _p('spinner" sub-component="loading" style="min-width:22px;min-height:22px;max-width:100px;max-height:100px;">\r\n\t\t\t            <svg height="100%" version="1.1" viewBox="0 0 22 22" width="100%">\r\n\t\t\t                <svg x="7" y="1"><circle class="'), _p(this.__escapeHtml(dot)), _p('-1" cx="4" cy="4" r="2"></circle></svg>\r\n\t\t\t                <svg x="11" y="3"><circle class='), _p(this.__escapeHtml(dot)), _p('-2" cx="4" cy="4" r="2"></circle></svg>\r\n\t\t\t                <svg x="13" y="7"><circle class="'), _p(this.__escapeHtml(dot)), _p('-3" cx="4" cy="4" r="2"></circle></svg>\r\n\t\t\t                <svg x="11" y="11"><circle class="'), _p(this.__escapeHtml(dot)), _p('-4" cx="4" cy="4" r="2"></circle></svg>\r\n\t\t\t                <svg x="7" y="13"><circle class="'), _p(this.__escapeHtml(dot)), _p('-5" cx="4" cy="4" r="2"></circle></svg>\r\n\t\t\t                <svg x="3" y="11"><circle class="'), _p(this.__escapeHtml(dot)), _p('-6" cx="4" cy="4" r="2"></circle></svg>\r\n\t\t\t                <svg x="1" y="7"><circle class="'), _p(this.__escapeHtml(dot)), _p('-7" cx="4" cy="4" r="2"></circle></svg>\r\n\t\t\t                <svg x="3" y="3"><circle class="'), _p(this.__escapeHtml(dot)), _p('-8" cx="4" cy="4" r="2"></circle></svg>\r\n\t\t\t            </svg>\r\n\t\t\t        </div>\r\n\t\t\t        <div class="'), _p(this.__escapeHtml(i)), _p('play-controller" sub-component="play" style="width: 98px;margin: -49px 0 0 -49px;">\r\n\t\t\t            <svg height="100%" version="1.1" viewBox="0 0 98 98" width="100%">\r\n\t\t\t                <circle cx="49" cy="49" fill="#000" stroke="#fff" stroke-width="2" fill-opacity="0.5" r="48" data-opacity="true"></circle>\r\n\t\t\t                <circle cx="-49" cy="49" fill-opacity="0" r="46.5" stroke="#fff"\r\n\t\t\t                        stroke-dasharray="293" stroke-dashoffset="-293.0008789998712" stroke-width="4"\r\n\t\t\t                        transform="rotate(-90)"></circle>\r\n\t\t\t                <polygon fill="#fff" points="32,27 72,49 32,71"></polygon>\r\n\t\t\t            </svg>\r\n\t\t\t        </div>\r\n\t\t\t    </div>'), __p.join("")
        }, bottom: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            }, nick = data.nick;
            return _p('    <!--底部控制栏-->\r\n\t\t\t    <div data-resize-module="bottom" class="'), _p(this.__escapeHtml(nick)), _p("control-bottom "), _p(this.__escapeHtml(nick)), _p('control-bottom-flow" component="bottom_container" style="display:none;">\r\n\t\t\t        <div style="width:99%;height:36px;margin:0px auto;position:relative;  background: #000;">\r\n\t\t\t            <!--进度栏-->\r\n\t\t\t            <div class="'), _p(this.__escapeHtml(nick)), _p('progress-bar-container">\r\n\t\t\t                <div class="'), _p(this.__escapeHtml(nick)), _p('progress-bar" aria-label="播放滑块" style="touch-action: none;'), _p(this.__escapeHtml(data.version.IS_MOBILE ? "display:none" : "")), _p('">\r\n\t\t\t                    <div class="'), _p(this.__escapeHtml(nick)), _p('progress-list" sub-component="progress_bg">\r\n\t\t\t                        <div class="'), _p(this.__escapeHtml(nick)), _p("play-progress "), _p(this.__escapeHtml(nick)), _p('in-bg-color" style="/*transform: scaleX(0.001);*/width:1%;"\r\n\t\t\t                             sub-component="progress_play"></div>\r\n\t\t\t                        <div class="'), _p(this.__escapeHtml(nick)), _p('load-progress" style="/*transform: scaleX(0.001);*/width:1%;" sub-component="progress_load"></div>\r\n\t\t\t                    </div>\r\n\t\t\t                    <div class="'), _p(this.__escapeHtml(nick)), _p("scrubber-button "), _p(this.__escapeHtml(nick)), _p('in-bg-color"\r\n\t\t\t                         style="left: 0px; height: 13px; " sub-component="progress_pointer" draggable="true"></div>\r\n\t\t\t                </div>\r\n\t\t\t            </div>\r\n\t\t\t\r\n\t\t\t            <div class="'), _p(this.__escapeHtml(nick)), _p('bottom-controls" style="'), _p(this.__escapeHtml(data.version.IS_MOBILE ? "border-top: solid 1px rgba(255, 255, 255, .2)" : "")), _p('">\r\n\t\t\t                <!--播放-->\r\n\t\t\t                <button class="'), _p(this.__escapeHtml(nick)), _p('button" style="width:36px;height:36px;float:left;" title="'), _p(this.__escapeHtml(data.WORD.PLAY)), _p('" sub-component="play_btn" now="play">\r\n\t\t\t                    <!--firefox:svg:animate not support--->\r\n\t\t\t                    <!--SVG底部 播放 按钮-->\r\n\t\t\t                    <svg svg-mode="svg_bottom_play" width="100%" height="100%" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\r\n\t\t\t                        <path d="M11,10 L18,13.74 18,22.28 11,26 M18,13.74 L26,18 26,18 18,22.28" fill="#fff"></path>\r\n\t\t\t                    </svg>\r\n\t\t\t                    <!--SVG底部 暂停 按钮-->\r\n\t\t\t                    <svg svg-mode="svg_bottom_pause" style="width:0px;height:0px" width="100%" height="100%" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\r\n\t\t\t                        <path d="M11,10 L17,10 17,26 11,26 M20,10 L26,10 26,26 20,26" fill="#fff"></path>\r\n\t\t\t                    </svg>\r\n\t\t\t                </button>'), data.is_max_screen && (_p('\r\n\t\t\t                    <!--静音-->\r\n\t\t\t                    <div class="'), _p(this.__escapeHtml(nick)), _p('volume-control" style="float:left;">\r\n\t\t\t                        <button class="'), _p(this.__escapeHtml(nick)), _p('button" style="width:36px;height:36px;" title="'), _p(this.__escapeHtml(data.WORD.MUTE)), _p('" sub-component="volume_mute" now="volume">\r\n\t\t\t                            <!--SVG底部 音量 按钮-->\r\n\t\t\t                            <svg svg-mode="svg_bottom_volume" width="100%" height="100%" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\r\n\t\t\t                                <path d="M12.39,15.54 L10,15.54 L10,20.44 L12.4,20.44 L17,25.50 L17,10.48 L12.39,15.54 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M12.39,15.54 L10,15.54 L10,20.44 L12.4,20.44 L17,25.50 L17,10.48 L12.39,15.54 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M22,17.99 C22,16.4 20.74,15.05 19,14.54 L19,21.44 C20.74,20.93 22,19.59 22,17.99 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M22,17.99 C22,16.4 20.74,15.05 19,14.54 L19,21.44 C20.74,20.93 22,19.59 22,17.99 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                            </svg>\r\n\t\t\t\r\n\t\t\t                            <!--SVG底部 音量静音 按钮-->\r\n\t\t\t                            <svg style="width:0px;height:0px" svg-mode="svg_bottom_volume_mute" width="100%" height="100%" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\r\n\t\t\t                                <path d="M12.39,15.54 L10,15.54 L10,20.44 L12.4,20.44 L17,25.50 L17,10.48 L12.39,15.54 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M12.39,15.54 L10,15.54 L10,20.44 L12.4,20.44 L17,25.50 L17,10.48 L12.39,15.54 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M19.63,15.92 L20.68,14.93 L22.81,16.94 L24.94,14.93 L26,15.92 L23.86,17.93 L26,19.93 L24.94,20.92 L22.81,18.92 L20.68,20.92 L19.63,19.93 L21.76,17.93 L19.63,15.92 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M19.63,15.92 L20.68,14.93 L22.81,16.94 L24.94,14.93 L26,15.92 L23.86,17.93 L26,19.93 L24.94,20.92 L22.81,18.92 L20.68,20.92 L19.63,19.93 L21.76,17.93 L19.63,15.92 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                            </svg>\r\n\t\t\t\r\n\t\t\t                            <!--SVG底部 音量满格 按钮-->\r\n\t\t\t                            <svg style="width:0px;height:0px" svg-mode="svg_bottom_volume_full" width="100%" height="100%" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg"\r\n\t\t\t                                 xmlns:xlink="http://www.w3.org/1999/xlink">\r\n\t\t\t                                <path d="M12.39,15.54 L10,15.54 L10,20.44 L12.4,20.44 L17,25.50 L17,10.48 L12.39,15.54 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M12.39,15.54 L10,15.54 L10,20.44 L12.4,20.44 L17,25.50 L17,10.48 L12.39,15.54 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M22,17.99 C22,16.4 20.74,15.05 19,14.54 L19,21.44 C20.74,20.93 22,19.59 22,17.99 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M22,17.99 C22,16.4 20.74,15.05 19,14.54 L19,21.44 C20.74,20.93 22,19.59 22,17.99 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M19,24.31 L19,26 C22.99,25.24 26,21.94 26,18 C26,14.05 22.99,10.75 19,10 L19,11.68 C22.01,12.41 24.24,14.84 24.24,18 C24.24,21.15 22.01,23.58 19,24.31 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                                <path d="M19,24.31 L19,26 C22.99,25.24 26,21.94 26,18 C26,14.05 22.99,10.75 19,10 L19,11.68 C22.01,12.41 24.24,14.84 24.24,18 C24.24,21.15 22.01,23.58 19,24.31 Z" opacity="1" fill="#fff"></path>\r\n\t\t\t                            </svg>\r\n\t\t\t                        </button>\r\n\t\t\t\r\n\t\t\t                        <div class="'), _p(this.__escapeHtml(nick)), _p('volume-panel" title="'), _p(this.__escapeHtml(data.WORD.TIP_OPR_VOLUME)), _p('" style="">\r\n\t\t\t                            <div class="'), _p(this.__escapeHtml(nick)), _p('volume-slider" style="touch-action: none;" sub-component="volume_bg" >\r\n\t\t\t                                <div class="'), _p(this.__escapeHtml(nick)), _p('volume-slider-track-after"></div>\r\n\t\t\t                                <div class="'), _p(this.__escapeHtml(nick)), _p("volume-slider-track "), _p(this.__escapeHtml(nick)), _p('in-bg-color" style="width: 24px;" sub-component="volume_track"></div>\r\n\t\t\t                                <div class="'), _p(this.__escapeHtml(nick)), _p('volume-slider-handle" style="left: 24px;" sub-component="volume_slider" draggable="true"></div>\r\n\t\t\t                            </div>\r\n\t\t\t                        </div>\r\n\t\t\t                    </div>')), _p('\r\n\t\t\t                <!--播放进度-->\r\n\t\t\t                <div class="'), _p(this.__escapeHtml(nick)), _p('time-progress" style="float:left;">\r\n\t\t\t                    <span class="'), _p(this.__escapeHtml(nick)), _p('in-color" sub-component="time_played">00:00:00</span>\r\n\t\t\t                    <span sub-component="time_duration">--</span>\r\n\t\t\t                </div>\r\n\t\t\t                <!--全屏按钮-->\r\n\t\t\t                <button class="'), _p(this.__escapeHtml(nick)), _p("button "), _p(this.__escapeHtml(nick)), _p('control-left" style="right: 5px;" title="'), _p(this.__escapeHtml(data.WORD.FULL_SCREEN)), _p('" sub-component="fullscreen_btn" now="fullscreen">\r\n\t\t\t                    <!--SVG底部 全屏 按钮-->\r\n\t\t\t                    <svg svg-mode="svg_bottom_fullscreen" xmlns:xlink="http://www.w3.org/1999/xlink" height="100%" version="1.1" viewBox="0 0 36 36" width="100%">\r\n\t\t\t                        <defs>\r\n\t\t\t                            <path d="M7,16 L10,16 L10,13 L13,13 L13,10 L7,10 L7,16 Z" id="svg-full-1"></path>\r\n\t\t\t                            <path d="M23,10 L23,13 L26,13 L26,16 L29,16 L29,10 L23,10 Z" id="svg-full-2"></path>\r\n\t\t\t                            <path d="M23,23 L23,26 L29,26 L29,20 L26,20 L26,23 L23,23 Z" id="svg-full-3"></path>\r\n\t\t\t                            <path d="M10,20 L7,20 L7,26 L13,26 L13,23 L10,23 L10,20 Z" id="svg-full-4"></path>\r\n\t\t\t                        </defs>\r\n\t\t\t                        <use fill="#fff" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-full-1"></use>\r\n\t\t\t                        <use fill="#fff" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-full-2"></use>\r\n\t\t\t                        <use fill="#fff" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-full-3"></use>\r\n\t\t\t                        <use fill="#fff" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-full-4"></use>\r\n\t\t\t                    </svg>\r\n\t\t\t\r\n\t\t\t                    <!--SVG底部 退出全屏 按钮-->\r\n\t\t\t                    <svg style="width:0px;height:0px" svg-mode="svg_bottom_quit_fullscreen" xmlns:xlink="http://www.w3.org/1999/xlink" height="100%" version="1.1" viewBox="0 0 36 36" width="100%">\r\n\t\t\t                        <defs>\r\n\t\t\t                            <path d="M13,10 L10,10 L10,13 L7,13 L7,16 L13,16 L13,10 Z" id="svg-quit-1"></path>\r\n\t\t\t                            <path d="M29,16 L29,13 L26,13 L26,10 L23,10 L23,16 L29,16 Z" id="svg-quit-2"></path>\r\n\t\t\t                            <path d="M29,23 L29,20 L23,20 L23,26 L26,26 L26,23 L29,23 Z" id="svg-quit-3"></path>\r\n\t\t\t                            <path d="M10,26 L13,26 L13,20 L7,20 L7,23 L10,23 L10,26 Z" id="svg-quit-4"></path>\r\n\t\t\t                        </defs>\r\n\t\t\t                        <use stroke="#000" stroke-opacity=".15" stroke-width="2px" xlink:href="#svg-quit-1"></use>\r\n\t\t\t                        <use stroke="#000" stroke-opacity=".15" stroke-width="2px" xlink:href="#svg-quit-2"></use>\r\n\t\t\t                        <use stroke="#000" stroke-opacity=".15" stroke-width="2px" xlink:href="#svg-quit-3"></use>\r\n\t\t\t                        <use stroke="#000" stroke-opacity=".15" stroke-width="2px" xlink:href="#svg-quit-4"></use>\r\n\t\t\t                        <use fill="#fff" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-quit-1"></use>\r\n\t\t\t                        <use fill="#fff" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-quit-2"></use>\r\n\t\t\t                        <use fill="#fff" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-quit-3"></use>\r\n\t\t\t                        <use fill="#fff" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-quit-4"></use>\r\n\t\t\t                    </svg>\r\n\t\t\t                </button>\r\n\t\t\t\r\n\t\t\t                <!--设置-->\r\n\t\t\t                <button class="'),
                _p(this.__escapeHtml(nick)), _p("button "), _p(this.__escapeHtml(nick)), _p('control-left" style="right: 41px;" title="'), _p(this.__escapeHtml(data.WORD.SETTING)), _p('" sub-component="setting">\r\n\t\t\t                    <svg xmlns:xlink="http://www.w3.org/1999/xlink" height="100%" version="1.1" viewBox="0 0 36 36" width="100%">\r\n\t\t\t                        <defs>\r\n\t\t\t                            <path d="M27,19.35 L27,16.65 L24.61,16.65 C24.44,15.79 24.10,14.99 23.63,14.28 L25.31,12.60 L23.40,10.69 L21.72,12.37 C21.01,11.90 20.21,11.56 19.35,11.38 L19.35,9 L16.65,9 L16.65,11.38 C15.78,11.56 14.98,11.90 14.27,12.37 L12.59,10.69 L10.68,12.60 L12.36,14.28 C11.89,14.99 11.55,15.79 11.38,16.65 L9,16.65 L9,19.35 L11.38,19.35 C11.56,20.21 11.90,21.01 12.37,21.72 L10.68,23.41 L12.59,25.32 L14.28,23.63 C14.99,24.1 15.79,24.44 16.65,24.61 L16.65,27 L19.35,27 L19.35,24.61 C20.21,24.44 21.00,24.1 21.71,23.63 L23.40,25.32 L25.31,23.41 L23.62,21.72 C24.09,21.01 24.43,20.21 24.61,19.35 L27,19.35 Z M18,22.05 C15.76,22.05 13.95,20.23 13.95,18 C13.95,15.76 15.76,13.95 18,13.95 C20.23,13.95 22.05,15.76 22.05,18 C22.05,20.23 20.23,22.05 18,22.05 L18,22.05 Z"\r\n\t\t\t                                  id="svg-setting"></path>\r\n\t\t\t                        </defs>\r\n\t\t\t                        <use xlink:href="#svg-setting" fill="#fff"></use>\r\n\t\t\t                    </svg>\r\n\t\t\t                </button>\r\n\t\t\t            </div>\r\n\t\t\t        </div>\r\n\t\t\t    </div>'), __p.join("")
        }, controller: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p(this.style(data)), _p('    <div h5-controller id="'), _p(this.__escapeHtml(data.controller.id)), _p('" style="position: absolute;top: 0px;left: 0px;width: 100%;height: 100%;z-index:3;">\r\n\t\t\t        <!--<div style="position:abolute;width:100%;height:100%;z-index:2" data-mask="video"></div>  -->'), _p(this.center(data)), _p("        "), _p(this.bottom(data)), _p("        "), _p(this.patch(data)), _p("        "), _p(this.logo(data)), _p("        "), _p(this.setting(data)), _p("    </div>"), __p.join("")
        }, video: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p('<div style="position: relative;width: 100%;height: 100%;  overflow: hidden;-webkit-box-sizing: border-box;box-sizing: border-box;">\r\n\t\t\t        <video\r\n\t\t\t        oncontextmenu="return false;"\r\n\t\t\t        preload="none"\r\n\t\t\t        x-webkit-airplay="true"\r\n\t\t\t        webkit-playsinline="true"\r\n\t\t\t        playsinline=""\r\n\t\t\t        id="'), _p(data.vid), _p('" width="100%" height="100%"\r\n\t\t\t        style="z-index: 1;overflow: hidden;box-sizing: border-box;position: absolute;top: -200%;left: 0px;">\r\n\t\t\t            <source src=\''), _p(data.url), _p("' type=\""), _p(data.type), _p('"/>\r\n\t\t\t        </video>\r\n\t\t\t    </div>'), __p.join("")
        }, style: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p("<style>"), _p(this.style_center(data)), _p("        "), _p(this.style_bottom(data)), _p("        "), _p(this.style_setting(data)), _p("    </style>"), __p.join("")
        }, style_setting: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            };
            return _p("."), _p(this.__escapeHtml(data.nick)), _p("setting{z-index: 200;/*height: 100%;*/position: absolute;top: 0px;opacity: 0;width: 100%;color: #fff;font-size: 1rem;display:none;background-color:#000;text-align: center;}\r\n\t\t\t   ."), _p(this.__escapeHtml(data.nick)), _p("setting-close{top: 45%;right: 2px;font-size: 2em;display: inline-block;padding: 3px;position: absolute;cursor: pointer;opacity: 0.6;}\r\n\t\t\t   ."), _p(this.__escapeHtml(data.nick)), _p("setting-close:hover{opacity: 1;}\r\n\t\t\t   ."), _p(this.__escapeHtml(data.nick)), _p("setting .setting-split-line{width: 90%;height: 1px;background-color: rgb(0,160,233);border: none;margin: 0px auto;margin-bottom: 10px;}\r\n\t\t\t   ."), _p(this.__escapeHtml(data.nick)), _p("setting .setting-definition{width: 100%;margin: 1em 0;font-size:1.5em;}\r\n\t\t\t   ."), _p(this.__escapeHtml(data.nick)), _p("setting .setting-definition-value-curr,."), _p(this.__escapeHtml(data.nick)), _p("setting .setting-definition-value{font-size: 1.5em;display: inline-block;padding:0.5em;}\r\n\t\t\t   ."), _p(this.__escapeHtml(data.nick)), _p("setting .setting-definition-value:hover{color: rgb(0,160,233);}\r\n\t\t\t   ."), _p(this.__escapeHtml(data.nick)), _p("setting .setting-definition-value{cursor: pointer;}\r\n\t\t\t   ."), _p(this.__escapeHtml(data.nick)), _p("setting .setting-definition-value-curr{cursor: default;border: 2px solid rgb(0,160,233);border-radius: 2px;color: rgb(0,160,233);}"), __p.join("")
        }, style_center: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            }, nick = data.nick;
            _p("\r\n\t\t\t    ."), _p(this.__escapeHtml(nick)), _p("control-module{position: absolute;top: 0px;left: 0px;}\r\n\t\t\t\r\n\t\t\t    ."), _p(this.__escapeHtml(nick)), _p("play-controller{\r\n\t\t\t      position: absolute;\r\n\t\t\t      left: 50%;\r\n\t\t\t      top: 50%;\r\n\t\t\t      display:none;\r\n\t\t\t      z-index: 101;\r\n\t\t\t      cursor: pointer;\r\n\t\t\t    }\r\n\t\t\t\r\n\t\t\t    /**转菊花开始**/\r\n\t\t\t    ."), _p(this.__escapeHtml(nick)), _p("spinner {\r\n\t\t\t        position: absolute;\r\n\t\t\t        left: 45%;\r\n\t\t\t        top: 45%;\r\n\t\t\t        width: 10%;\r\n\t\t\t        height: 10%;\r\n\t\t\t        z-index: 102;\r\n\t\t\t    }\r\n\t\t\t    ."), _p(this.__escapeHtml(nick)), _p("error {\r\n\t\t\t          position: absolute;\r\n\t\t\t          left: 0;\r\n\t\t\t          top: 45%;\r\n\t\t\t          width: 100%;\r\n\t\t\t          height: 20%;\r\n\t\t\t          z-index: 102;\r\n\t\t\t          display: none;\r\n\t\t\t          text-align: center;\r\n\t\t\t          font-size: 1rem;\r\n\t\t\t          color: red;\r\n\t\t\t    }");
            for (var keyFrames = ["@keyframes", "@-moz-keyframes", "@-webkit-keyframes"], i = 0, i = 0; i < keyFrames.length; i++) _p("        "), _p(this.__escapeHtml(keyFrames[i])), _p(" "), _p(this.__escapeHtml(nick)), _p("spinner-dot-fade {\r\n\t\t\t            0% {\r\n\t\t\t                opacity: .5;\r\n\t\t\t                -moz-transform: scale(1.2,1.2);\r\n\t\t\t                -ms-transform: scale(1.2,1.2);\r\n\t\t\t                -webkit-transform: scale(1.2,1.2);\r\n\t\t\t                transform: scale(1.2,1.2)\r\n\t\t\t            }\r\n\t\t\t\r\n\t\t\t            50% {\r\n\t\t\t                opacity: .15;\r\n\t\t\t                -moz-transform: scale(.9,.9);\r\n\t\t\t                -ms-transform: scale(.9,.9);\r\n\t\t\t                -webkit-transform: scale(.9,.9);\r\n\t\t\t                transform: scale(.9,.9)\r\n\t\t\t            }\r\n\t\t\t\r\n\t\t\t            to {\r\n\t\t\t                opacity: .15;\r\n\t\t\t                -moz-transform: scale(.85,.85);\r\n\t\t\t                -ms-transform: scale(.85,.85);\r\n\t\t\t                -webkit-transform: scale(.85,.85);\r\n\t\t\t                transform: scale(.85,.85)\r\n\t\t\t            }\r\n\t\t\t        }");
            _p("\r\n\t\t\t\r\n\t\t\t   ."), _p(this.__escapeHtml(nick)), _p("spinner-dot {\r\n\t\t\t       -moz-animation: "), _p(this.__escapeHtml(nick)), _p("spinner-dot-fade .8s ease infinite;\r\n\t\t\t       -webkit-animation: "), _p(this.__escapeHtml(nick)), _p("spinner-dot-fade .8s ease infinite;\r\n\t\t\t       animation: "), _p(this.__escapeHtml(nick)), _p("spinner-dot-fade .8s ease infinite;\r\n\t\t\t       opacity: 0;\r\n\t\t\t       /*fill: #1275cf;*/\r\n\t\t\t       fill: #fff;\r\n\t\t\t       -moz-transform-origin: 4px 4px;\r\n\t\t\t       -ms-transform-origin: 4px 4px;\r\n\t\t\t       -webkit-transform-origin: 4px 4px;\r\n\t\t\t       transform-origin: 4px 4px\r\n\t\t\t   }");
            for (var i = 0; i < 7; i++) _p("            ."), _p(this.__escapeHtml(nick)), _p("spinner-dot-"), _p(this.__escapeHtml(i + 1)), _p(" { -moz-animation-delay: ."), _p(this.__escapeHtml(i + 1)), _p("s; -webkit-animation-delay: ."), _p(this.__escapeHtml(i + 1)), _p("s; animation-delay: ."), _p(this.__escapeHtml(i + 1)), _p("s }");
            return _p("   /**转菊花结束**/"), __p.join("")
        }, style_bottom: function (data) {
            var __p = [], _p = function (s) {
                __p.push(s)
            }, i = "#" + data.controller.id, nick = data.nick;
            return _p("        "), _p(this.__escapeHtml(i)), _p(" button, "), _p(this.__escapeHtml(i)), _p(" svg { margin: 0px; padding: 0px; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("control-bottom {\r\n\t\t\t            position: absolute;\r\n\t\t\t            text-shadow: 0 0 2px rgba(0, 0, 0, .5);\r\n\t\t\t            bottom: 0;\r\n\t\t\t            height: 36px;\r\n\t\t\t            width: 100%;\r\n\t\t\t            z-index: 61;\r\n\t\t\t            text-align: left;\r\n\t\t\t            direction: ltr;\r\n\t\t\t            font-size: 11px;\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("control-left{width:36px;height:36px;position: absolute;z-index: 3;bottom: 0px; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("control-bottom, ."), _p(this.__escapeHtml(nick)), _p("scrubber-button,."), _p(this.__escapeHtml(nick)), _p("setting {\r\n\t\t\t            -moz-transition: opacity .25s cubic-bezier(0.0, 0.0, 0.2, 1);\r\n\t\t\t            -webkit-transition: opacity .25s cubic-bezier(0.0, 0.0, 0.2, 1);\r\n\t\t\t            transition: opacity .25s cubic-bezier(0.0, 0.0, 0.2, 1);\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("progress-bar-container {\r\n\t\t\t            display: block;\r\n\t\t\t            position: absolute;\r\n\t\t\t            width: 100%;\r\n\t\t\t            bottom: 36px;\r\n\t\t\t            height: 5px;\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("progress-bar-container:hover{height:15px; }\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("progress-bar-container:hover ."), _p(this.__escapeHtml(nick)), _p("scrubber-button{ top: 1px; height: 15px;width: 15px;}\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("progress-bar {\r\n\t\t\t            position: absolute;\r\n\t\t\t            bottom: 0;\r\n\t\t\t            left: 0;\r\n\t\t\t            width: 100%;\r\n\t\t\t            height: 100%;\r\n\t\t\t            z-index: 31;\r\n\t\t\t            outline: none;\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("progress-list {\r\n\t\t\t            cursor: pointer;\r\n\t\t\t            z-index: 39;\r\n\t\t\t            background: rgba(255, 255, 255, .2);\r\n\t\t\t            height: 100%;\r\n\t\t\t            -moz-transform: scaleY(0.6);\r\n\t\t\t            -ms-transform: scaleY(0.6);\r\n\t\t\t            -webkit-transform: scaleY(0.6);\r\n\t\t\t            transform: scaleY(0.6);\r\n\t\t\t            -moz-transition: -moz-transform .1s cubic-bezier(0.4, 0.0, 1, 1);\r\n\t\t\t            -webkit-transition: -webkit-transform .1s cubic-bezier(0.4, 0.0, 1, 1);\r\n\t\t\t            -ms-transition: -ms-transform .1s cubic-bezier(0.4, 0.0, 1, 1);\r\n\t\t\t            transition: transform .1s cubic-bezier(0.4, 0.0, 1, 1);\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("load-progress, ."), _p(this.__escapeHtml(nick)), _p("play-progress {\r\n\t\t\t            cursor: pointer;\r\n\t\t\t            position: absolute;\r\n\t\t\t            left: 0;\r\n\t\t\t            bottom: 0;\r\n\t\t\t            width: 100%;\r\n\t\t\t            height: 100%;\r\n\t\t\t            -moz-transform-origin: 0 0;\r\n\t\t\t            -ms-transform-origin: 0 0;\r\n\t\t\t            -webkit-transform-origin: 0 0;\r\n\t\t\t            transform-origin: 0 0;\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("play-progress { z-index: 34; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("load-progress { z-index: 33; background: rgba(255, 255, 255, .4); }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("scrubber-button {\r\n\t\t\t            height: 13px;\r\n\t\t\t            width: 13px;\r\n\t\t\t            z-index: 43;\r\n\t\t\t            top: -4px;\r\n\t\t\t            position: absolute;\r\n\t\t\t            margin-left: -6.5px;\r\n\t\t\t            border-radius: 6.5px;\r\n\t\t\t            opacity: 0;\r\n\t\t\t            cursor: e-resize;\r\n\t\t\t            -moz-transition: -moz-transform .1s cubic-bezier(0.0, 0.0, 0.2, 1);\r\n\t\t\t            -webkit-transition: -webkit-transform .1s cubic-bezier(0.0, 0.0, 0.2, 1);\r\n\t\t\t            -ms-transition: -ms-transform .1s cubic-bezier(0.0, 0.0, 0.2, 1);\r\n\t\t\t            transition: transform .1s cubic-bezier(0.0, 0.0, 0.2, 1);\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("bottom-controls { height: 36px; line-height: 36px; text-align: left; direction: ltr;  position: relative;overflow: hidden; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("button {\r\n\t\t\t\r\n\t\t\t            border: none;\r\n\t\t\t            background-color: transparent;\r\n\t\t\t            padding: 0;\r\n\t\t\t            color: inherit;\r\n\t\t\t            text-align: inherit;\r\n\t\t\t            font-family: inherit;\r\n\t\t\t            cursor: default;\r\n\t\t\t            line-height: inherit;\r\n\t\t\t            cursor: pointer;\r\n\t\t\t            opacity: 0.7;\r\n\t\t\t\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("in-bg-color { background: #1275cf; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("in-color { color: #1275cf; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("volume-control { display: inline-block; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("volume-panel{\r\n\t\t\t            display: inline-block;\r\n\t\t\t            width: 49px;\r\n\t\t\t            height: 36px;\r\n\t\t\t            -moz-transition: width .2s cubic-bezier(0.4, 0.0, 1, 1);\r\n\t\t\t            -webkit-transition: width .2s cubic-bezier(0.4, 0.0, 1, 1);\r\n\t\t\t            transition: width .2s cubic-bezier(0.4, 0.0, 1, 1);\r\n\t\t\t            cursor: pointer;\r\n\t\t\t            overflow: hidden;\r\n\t\t\t            outline: 0;\r\n\t\t\t            padding-right: 4px;\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("volume-slider { height: 100%; position: relative; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("volume-slider-track{\r\n\t\t\t            position: absolute;\r\n\t\t\t            display: block;\r\n\t\t\t            top: 50%;\r\n\t\t\t            left: 0;\r\n\t\t\t            height: 3px;\r\n\t\t\t            margin-top: -1.5px;\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("volume-slider-track-after {\r\n\t\t\t              content: '';\r\n\t\t\t              width: 49px;\r\n\t\t\t              background: rgba(255, 255, 255, .2);\r\n\t\t\t              position: absolute;\r\n\t\t\t              top: 50%;\r\n\t\t\t              left: 0;\r\n\t\t\t              height: 3px;\r\n\t\t\t              margin-top: -1.5px;\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("volume-slider-handle {\r\n\t\t\t            position: absolute;\r\n\t\t\t            top: 50%;\r\n\t\t\t            width: 4px;\r\n\t\t\t            height: 13px;\r\n\t\t\t            margin-top: -6.5px;\r\n\t\t\t            background: #fff;\r\n\t\t\t            cursor: e-resize;\r\n\t\t\t             opacity: 0.7;\r\n\t\t\t        }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("time-progress { color: #ddd; display: inline-block; vertical-align: top; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("control-bottom { opacity: 0.5; }\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("scrubber-button { opacity: 0; }\r\n\t\t\t\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("control-bottom-flow:hover, ."), _p(this.__escapeHtml(nick)), _p("control-bottom-stick:hover,\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("control-bottom-flow:hover ."), _p(this.__escapeHtml(nick)), _p("scrubber-button,\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("control-bottom-stick ."), _p(this.__escapeHtml(nick)), _p("scrubber-button,\r\n\t\t\t        ."), _p(this.__escapeHtml(nick)), _p("control-bottom-stick:hover ."), _p(this.__escapeHtml(nick)), _p("scrubber-button { opacity: 1; }"), __p.join("")
        }, __escapeHtml: function () {
            var a = {"&": "&amp;", "<": "&lt;", ">": "&gt;", "'": "&#39;", '"': "&quot;", "/": "&#x2F;"},
                b = /[&<>'"\/]/g;
            return function (c) {
                return "string" != typeof c ? c : c ? c.replace(b, function (b) {
                    return a[b] || b
                }) : ""
            }
        }()
    }
}), qcVideo("PlayerStatus", function (Base, constants, lStore) {
    var blockTime = 25e3, EVENT = constants.EVENT, undefined = undefined;
    return Base.extend({
        className: "PlayerStatus", clear: function () {
            var me = this;
            me._start_duration = 0, me.played = 0, me.duration = 0, me.loaded = 0, me.loaded_overtime = 0, me.errorCode = 0
        }, start_duration: function (second) {
            return second === undefined ? this._start_duration : void(this._start_duration = second)
        }, check: function () {
            var me = this;
            if (me.__isMaybeBlockStatus()) {
                me.played >= me.duration && me.duration > 0 && me.fire(EVENT.OS_PLAYER_END);
                var dif = +new Date - me.status_start;
                dif > blockTime && me.__getStatusValue() === me.status_value && !me.inCache(me.played) && (me.debug("overtime", dif), me.fire(EVENT.OS_BLOCK))
            }
        }, constructor: function () {
            var me = this;
            me.clear(), me.remember = !1
        }, enableRemember: function (bool) {
            this.remember = bool
        }, setRememberKey: function (key) {
            this.rememberKey = key
        }, destroy: function () {
        }, __getStatusValue: function () {
            return this.played + ":" + this.loaded + ":" + this.duration
        }, __isMaybeBlockStatus: function () {
            return "play" === this.status || "load" === this.status
        }, setRunningStatus: function (status) {
            this.status = status, this.status_start = +new Date, this.status_value = this.__getStatusValue()
        }, getRunningStatus: function () {
            return this.status
        }, setSDKStatus: function (s) {
            this._sdk_status = s
        }, getSDKStatus: function () {
            return this._sdk_status
        }, set_duration: function (num) {
            this.duration = num - 0
        }, set_loaded: function (num) {
            this.loaded = num - 0, this.fire(EVENT.OS_PROGRESS)
        }, get_loaded: function () {
            return this.loaded | 0 + this._start_duration
        }, set_played: function (num) {
            this.played = num - 0, this.fire(EVENT.OS_TIME_UPDATE), this.remember && (lStore.set(this.rememberKey + "_played", this.get_played()), this.get_local_played())
        }, set_volume: function (num) {
            this._volume = num, this.remember && (lStore.set("volume", num), this.get_local_volume())
        }, get_volume: function () {
            return this._volume || 0 | lStore.get("volume") || .5
        }, get_local_volume: function () {
            return lStore.get("volume")
        }, get_local_played: function () {
            return lStore.get(this.rememberKey + "_played")
        }, get_played: function () {
            return this.played | 0 + this._start_duration
        }, inCache: function (second) {
            var loaded = this.get_loaded(), start = this.start_duration();
            return this.debug(loaded, start, second), this.loaded > 0 && second <= loaded + 5 && second >= start ? (this.debug("in mem"), !0) : (this.debug("out mem"), !1)
        }
    })
}), qcVideo("PlayerStore", function ($, Base, util, constants, TDBankReporter) {
    var undefined = undefined;
    return Base.extend({
        className: "PlayerStore", constructor: function (store) {
            this.store = store
        }, destroy: function () {
            delete this.store
        }, _getPoster: function (pos) {
            var image_url = this.store.image_url, imgs = this.store.imgUrls, patch = this.store.patch, maxSize = 0,
                maxPosition = 0, tempSize = 0;
            if (patch && patch[pos] && patch[pos].url) return patch[pos];
            if (pos == constants.PATCH_LOC.START && image_url && image_url.indexOf("p.qpic.cn") == -1) return {
                url: image_url,
                type: pos,
                redirect: ""
            };
            if (image_url && imgs && imgs.length > 0 && pos == constants.PATCH_LOC.START) {
                for (var user_choose_url = image_url.substring(0, image_url.lastIndexOf("/")), i = 0, j = imgs.length; i < j; i++) tempSize = (0 | imgs[i].vheight) * (0 | imgs[i].vwidth), tempSize > maxSize && imgs[i].url.indexOf(user_choose_url) != -1 && (maxSize = tempSize, maxPosition = i);
                return {url: imgs[maxPosition].url, type: pos, redirect: ""}
            }
            return !1
        }, happenToSdk: function (arg) {
            var me = this;
            if (me.__happen_last_time_status != arg) {
                var playStatus = arg.split(":")[1];
                TDBankReporter.pushEvent(playStatus, me.store), me.__happen_last_time_status = arg, window[this.store.sdk_method](arg)
            }
        }, isCustomization: function (n) {
            return 1 == this.store.customization[n]
        }, getCustomization: function (n) {
            return this.store.customization[n]
        }, setCustomization: function (k, v) {
            return this.store.customization[k] = v
        }, getDuration: function () {
            return this.store.duration
        }, getLogo: function () {
            return this.store.logo
        }, getIDMain: function () {
            return this.store.mainId
        }, getMainOffset: function () {
            var $main = $("#" + this.store.mainId), offset = $main.offset();
            return offset.width = $main.width(), offset.height = $main.height(), offset
        }, getStartPatch: function () {
            return this._getPoster(0 | constants.PATCH_LOC.START)
        }, getPausePatch: function () {
            return this._getPoster(0 | constants.PATCH_LOC.PAUSE)
        }, getSopPatch: function () {
            return this._getPoster(0 | constants.PATCH_LOC.END)
        }, getAllDefinition: function () {
            var def, ind, ret = {}, pir = constants.DEFINITION_PRIORITY;
            for (def in this.store.videos) for (ind in pir) $.each(pir[ind], function (_, i) {
                if (def == i) return ret[def] = {
                    resolution: ind,
                    resolutionName: constants.DEFINITION_NAME[ind],
                    resolutionNameNo: constants.DEFINITION_NAME_NO[ind]
                }, !1
            });
            return ret
        }, getUniqueNoDefinition: function () {
            var all = this.getAllDefinition(), ret = {}, unique = {};
            for (var key in all) unique[all[key].resolutionNameNo] || (unique[all[key].resolutionNameNo] = !0, ret[key] = all[key]);
            return ret
        }, isInDefinition: function (no) {
            if (no !== undefined) {
                var all = this.getAllDefinition();
                for (var k in all) if (all[k].resolutionNameNo == no) return !0
            }
            return !1
        }, getKeepArgs: function () {
            return this.store.keepArgs
        }, getVideoInfo: function (res, def) {
            var rst, me = this, videos = me.store.videos, resolutionPriority = constants.RESOLUTION_PRIORITY,
                getRstFromDefPriority = function (res) {
                    var arr = constants.DEFINITION_PRIORITY[res];
                    if (arr && arr.length > 0) for (var i = 0; i < arr.length; i++) if (videos[arr[i]]) return videos[arr[i]]
                }, all = this.getAllDefinition();
            if (me.debug(":get video:resource==" + res + ";definition==" + def), def !== undefined && (rst = videos[0 | def], all[def] || (rst = null)), rst || res === undefined || (rst = getRstFromDefPriority(0 | res)), !rst) for (var i = 0, j = resolutionPriority.length; i < j && !(rst = getRstFromDefPriority(resolutionPriority[i])); i++) ;
            if (rst) {
                var map = me.getAllDefinition()[rst.definition];
                return me.debug(":getVideoInfo result:清晰度==" + map.resolution + ";名称==" + map.resolutionName + ";sdk清晰度" + map.resolutionNameNo), util.merge({
                    resolution: map.resolution,
                    resolutionName: map.resolutionName,
                    resolutionNameNo: map.resolutionNameNo
                }, rst)
            }
        }
    })
}), qcVideo("PlayerSystem", function ($, Base, interval, constants, util, FullScreenApi, version, JSON) {
    var EVENT = constants.EVENT, undefined = undefined, getId = function () {
            return "video_id_" + +new Date
        },
        EventAry = "loadstart,suspend,abort,error,emptied,stalled,loadedmetadata,loadeddata,canplay,canplaythrough,playing,waiting,seeking,seeked,ended,durationchange,timeupdate,progress,play,pause,ratechange,volumechange".split(","),
        orientationMap = {}, orientationChange = function () {
            var key;
            switch (window.orientation) {
                case 180:
                    for (key in orientationMap) orientationMap[key] && orientationMap[key].happenResize && orientationMap[key].happenResize(!0);
                    break;
                case 90:
                    for (key in orientationMap) orientationMap[key] && orientationMap[key].happenResize && orientationMap[key].happenResize(!1)
            }
        };
    return window.addEventListener && window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", orientationChange, !1), Base.extend({
        className: "PlayerSystem",
        constructor: function ($renderTo) {
            var me = this;
            me.$renderTo = $renderTo;
            var PlayerStatus = qcVideo.get("PlayerStatus");
            me.status = new PlayerStatus, me.timeTask = interval(function () {
                me.status.check()
            }, 1e3)
        },
        happenResize: function (isLandScape) {
            this.fire(isLandScape ? EVENT.OS_LAND_SCAPE_UI : EVENT.OS_PORTRAIT_UI)
        },
        destroy: function () {
            delete orientationMap[this.__system_id], this.callMethod("pause"), this.video.src = "", delete this.video, this.$video.off().remove(), delete this.$renderTo, this.timeTask.clear(), delete this.$renderTo, this.status.destroy(), delete this.status
        },
        getStatus: function () {
            return this.status
        },
        callMethod: function (mtd) {
            try {
                "play" == mtd && (this.has_call_play = !0), this.video[mtd](), this.status.setRunningStatus(mtd)
            } catch (xe) {
                this.debug(xe)
            }
        },
        __getBuffer: function () {
            var end = 0;
            try {
                for (var i = 0, j = this.video.buffered.length; i < j; i++) end = 0 | this.video.buffered.end(i)
            } catch (e) {
            }
            return end
        },
        _status_ary: [],
        _bind: function () {
            var me = this, metadataDone = function () {
                me.metadatadone = !0, me.video.duration && me.video.duration > 0 && me.fire(EVENT.OS_DURATION_UPDATE, {duration: me.video.duration}), me._seek_time > 1 && me.video.currentTime < 1 && (me.video.currentTime = me._seek_time), me._volume && (me.video.volume = this._volume), me._seek_time = 0, me.fire(EVENT.OS_LOADED_META_DATA)
            }, getHandler = function (event) {
                return function (e) {
                    if (me.debug(event, me.has_call_play), me.has_call_play) switch (event) {
                        case"loadedmetadata":
                            metadataDone();
                            break;
                        case"error":
                            me.debug(event, e), me.fire(EVENT.OS_BLOCK);
                            break;
                        case"seeking":
                            me.fire(EVENT.OS_SEEKING);
                            break;
                        case"seeked":
                            me.fire(EVENT.OS_PLAYING);
                            break;
                        case"playing":
                            me.fire(EVENT.OS_PLAYING);
                            break;
                        case"pause":
                            me.fire(EVENT.OS_PAUSE);
                            break;
                        case"progress":
                            me.metadatadone || metadataDone(), me.status.set_loaded(me.__getBuffer());
                            break;
                        case"timeupdate":
                            me.status.set_played(0 | me.video.currentTime);
                            break;
                        case"ended":
                            me.fire(EVENT.OS_PLAYER_END)
                    }
                }
            };
            $.each(EventAry, function (_, event) {
                me.$video.on(event, getHandler(event))
            })
        },
        setUrl: function (src) {
            var me = this, $renderTo = me.$renderTo, type = me.fileType = util.fileType(src);
            me.__system_id = getId(), orientationMap[me.__system_id] = me;
            var tpl = {
                vid: me.__system_id,
                width: $renderTo.width(),
                height: $renderTo.height(),
                url: src,
                type: type == constants.MP4 ? "video/mp4" : type == constants.HLS ? "application/x-mpegURL" : "video/flv"
            };
            me.metadatadone = !1, me.has_call_play = !1, me._seek_time = 0, me.timeTask.start(), me.status.clear(), me.$video && ($.each(EventAry, function (_, event) {
                me.$video.off(event)
            }), me.video.src = "", me._hls && me._hls.detachMedia(me.video), me.callMethod("pause"), me.$video.parent().remove());
            var tplObj = qcVideo.get("MediaPlayer_tpl");
            if ($renderTo.prepend(tplObj.video(tpl)), me.video = (me.$video = $("#" + tpl.vid)).get(0), me._bind(), me._toPlayOrPauseView(!1), version.REQUIRE_HLS_JS && type == constants.HLS) {
                var Hls = qcVideo.get("Hls");
                me._hls = new Hls, me._hls.loadSource(src), me._hls.attachMedia(me.video)
            }
        },
        isFullScreen: function ($dom) {
            var zIndex = $dom.css("z-index");
            return "auto" != zIndex && zIndex ? zIndex > 1e4 : document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen
        },
        setPlayRate: function (rate) {
            if (this.video) try {
                this.video.playbackRate = rate
            } catch (xe) {
            }
        },
        setFullScreen: function (isFull, targetID) {
            var me = this, $main = $("#" + targetID), $win = $(window), target = isFull ? $main.get(0) : document;
            if (isFull) {
                var offset = $main.offset();
                target[FullScreenApi.requestFullscreen](), setTimeout(function () {
                    me.isFullScreen($main) && (me.__offset = offset, $main.width($win.width()), $main.height($win.height()), me.fire(EVENT.OS_RESIZE, {}))
                }, 250)
            } else target[FullScreenApi.exitFullscreen](), me.__offset && ($main.width(me.__offset.width), $main.height(me.__offset.height))
        },
        setShowMode: function (sourceMode) {
            sourceMode ? this.video.setAttribute("controls", "controls") : this.video.removeAttribute("controls")
        },
        _toPlayOrPauseView: function (isPlay) {
            var w = "-200%";
            isPlay && (w = 0), this.$video.css("top", w)
        },
        isMetaDataRendered: function () {
            return this.metadatadone
        },
        play: function (time) {
            if (this.video) {
                if (time !== undefined) try {
                    this.video.currentTime = this._seek_time = time - this.status.start_duration()
                } catch (xe) {
                    this.log(xe)
                }
                this.callMethod("play")
            }
            this._toPlayOrPauseView(!0)
        },
        pause: function () {
            this.video && this.callMethod("pause")
        },
        volume: function (volume) {
            return volume === undefined ? this.video.volume : void(volume > 1 || this.video && (this._volume = this.video.volume = volume, this.status.set_volume(volume), this.fire(EVENT.OS_VOLUME_CHANGE, {volume: volume})))
        }
    })
}), qcVideo("UiControl", function ($, Base, util, constants, version) {
    var MODE, id = "qvideo_control_" + +new Date + "_", uid = 1, bottomLeft = 10, UiControl = Base.extend({
        className: "UiControl", destroy: function () {
            var me = this;
            if (delete me.store, delete me.status, me.children) {
                for (var name in me.children) me.children[name].destroy();
                delete me.children
            }
            me.$el && (me.$el.remove(), me.$el = null)
        }, __ableShowUi: function () {
            return !this.__on_ui
        }, __ableHideUi: function () {
            return this.__on_ui && "playing" == this.status.getSDKStatus() && !this.__hover_controller && +new Date - this.__show_ui_time > 2e3
        }, __delayHideUi: function () {
            var me = this;
            "playing" != me.status.getSDKStatus() || me.__hover_controller || (me.__show_ui_time = +new Date, me.__hide_ui_tid && (clearTimeout(me.__hide_ui_tid), me.__hide_ui_tid = null), me.__hide_ui_tid = setTimeout(function () {
                me.__ableHideUi() && (me.__on_ui = !1, me.children.Bottom_container.$el.hide(), me.log("hide"))
            }, 2080))
        }, enterPlayerUi: function () {
            this.__ableShowUi() && (this.__on_ui = !0, this.children.Bottom_container.$el.show(), this.log("show")), this.__delayHideUi()
        }, leavePlayerUi: function () {
            this.__delayHideUi()
        }, slidePlayerUi: function () {
            this.__ableShowUi() && (this.__on_ui = !0, this.children.Bottom_container.$el.show(), this.log("show")), this.__delayHideUi()
        }, constructor: function (store, status, $renderTo) {
            var me = this;
            me.store = store, me.status = status, me.children = {};
            var width = $renderTo.width(), height = $renderTo.height();
            uid += 1;
            var tpl = qcVideo.get("MediaPlayer_tpl");
            $renderTo.append(tpl.controller({
                is_max_screen: width > 500,
                width: width,
                height: height,
                version: version,
                nick: "trump-",
                controller: {left: bottomLeft, width: width - 2 * bottomLeft - 2, id: id + uid},
                WORD: constants.UNICODE_WORD
            })), $renderTo.find("[component]").each(function () {
                var $me = $(this), component = util.capitalize($me.attr("component")), UICom = qcVideo.get(component);
                me.children[component] = new UICom(store, status, $me), me.on(me.children[component], constants.FIRE, function (obj) {
                    me.fire(obj.event, obj.value)
                }), me.children[component].live("[sub-component]", function (dom, e) {
                    if (this.enable()) {
                        var $dom = $(dom), method = "on_click_" + $dom.attr("sub-component");
                        "function" == util.type(this[method]) && this[method]($dom, e)
                    }
                })
            }), me.$el = $renderTo.find("div[h5-controller]"), version.IS_MOBILE || $renderTo.off("mouseenter").off("mouseleave").off("mousemove").on("mouseenter", function (e) {
                me.enterPlayerUi()
            }).on("mouseleave", function () {
                me.leavePlayerUi()
            }).on("mousemove", function () {
                me.slidePlayerUi()
            }), me.children.Bottom_container.$el.on("mouseenter", function (e) {
                me.__hover_controller = !0
            }).on("mouseleave", function (e) {
                me.__hover_controller = !1
            }), me.setViewMode(height), this.setWait(), this.setTime({duration: me.store.getDuration()}), this.setResize(), me.store.isCustomization("hide_h5_setting") && me.$el.find('[sub-component="setting"]').hide()
        }, setViewMode: function (height) {
            var me = this, sourceH = 36, $settingEl = this.children.Setting.$el;
            if (version.IS_MOBILE && height > 0) {
                $settingEl.show();
                var rate = sourceH / height, askRate = .25, zoom = 1;
                rate != askRate && (zoom = height * askRate / sourceH), this.children.Bottom_container.$el.css("zoom", zoom), setTimeout(function () {
                    var h = $settingEl.height(), ch = me.$el.height() || 1, rate = h / ch, size = "1rem";
                    rate < .3 ? size = "2rem" : rate < .5 ? size = "1.5rem" : rate > .9 && (size = "0.5rem"), me.log(h, height, ch, rate, size), $settingEl.css("font-size", size).height("100%").hide()
                }, 300)
            } else $settingEl.height("100%")
        }, show: function () {
            this.$el.show()
        }, hide: function () {
            this.$el.hide()
        }, eachChild: function (fn) {
            for (var i in this.children) fn(this.children[i])
        }, setWait: function () {
            this.eachChild(function (son) {
                son.catchControlStatusChange(MODE.WAIT)
            })
        }, setPlay: function () {
            this.eachChild(function (son) {
                son.catchControlStatusChange(MODE.PLAY)
            })
        }, setPause: function () {
            this.eachChild(function (son) {
                son.catchControlStatusChange(MODE.PAUSE)
            })
        }, setEnd: function () {
            this.eachChild(function (son) {
                son.catchControlStatusChange(MODE.END)
            })
        }, setError: function (msg) {
            this.eachChild(function (son) {
                son.catchControlStatusChange(MODE.ERROR, {msg: msg})
            })
        }, openSetting: function (obj) {
            this.children.Setting.show(obj)
        }, setFull: function (isFull) {
            var me = this;
            isFull ? me.eachChild(function (son) {
                son.catchControlStatusChange(MODE.FULL)
            }) : me.eachChild(function (son) {
                son.catchControlStatusChange(MODE.QUIT_FULL)
            })
        }, setResize: function () {
            var offset = this.store.getMainOffset();
            this.eachChild(function (son) {
                son.catchControlStatusChange(MODE.RESIZE, {offset: offset})
            })
        }, setTime: function (obj) {
            this.children.Bottom_container.setTime(obj)
        }, setVolume: function (percent) {
            this.children.Bottom_container.setVolume(100 * percent)
        }, setDragPlay: function (time) {
            this.children.Patch.catchControlStatusChange(MODE.DRAG, {
                time: time
            })
        }, enableDrag: function (bool) {
            this.children.Bottom_container.enableDrag(bool)
        }, enableFull: function (bool) {
            this.children.Bottom_container.enableFull(bool)
        }
    });
    return MODE = UiControl.MODE = {
        WAIT: "wait",
        READY: "ready",
        PAUSE: "pause",
        PLAY: "play",
        BLOCK: "block",
        ERROR: "error",
        END: "end",
        FULL: "full",
        QUIT_FULL: "quitfull",
        RESIZE: "RESIZE",
        DRAG: "DRAG"
    }, UiControl
});
/*  |xGv00|133fa4f1d277f793eb078c2deeddb29e */