/*
 Selectr 2.4.13
 http://mobius.ovh/docs/selectr

 Released under the MIT license
*/
(function (g, k) { "function" === typeof define && define.amd ? define([], k) : "object" === typeof exports ? module.exports = k("Selectr") : g.Selectr = k("Selectr") })(this, function (g) {
    function k(a, c) { return a.hasOwnProperty(c) && (!0 === a[c] || a[c].length) } function n(a, c, e) { a.parentNode ? a.parentNode.parentNode || c.appendChild(a.parentNode) : c.appendChild(a); b.removeClass(a, "excluded"); e || (a.innerHTML = a.textContent) } var l = function () { }; l.prototype = {
        on: function (a, c) {
            this._events = this._events || {}; this._events[a] = this._events[a] ||
                []; this._events[a].push(c)
        }, off: function (a, c) { this._events = this._events || {}; !1 !== a in this._events && this._events[a].splice(this._events[a].indexOf(c), 1) }, emit: function (a) { this._events = this._events || {}; if (!1 !== a in this._events) for (var c = 0; c < this._events[a].length; c++)this._events[a][c].apply(this, Array.prototype.slice.call(arguments, 1)) }
    }; l.mixin = function (a) { for (var c = ["on", "off", "emit"], b = 0; b < c.length; b++)"function" === typeof a ? a.prototype[c[b]] = l.prototype[c[b]] : a[c[b]] = l.prototype[c[b]]; return a };
    var b = {
        extend: function (a, c) { for (var e in c) if (c.hasOwnProperty(e)) { var d = c[e]; d && "[object Object]" === Object.prototype.toString.call(d) ? (a[e] = a[e] || {}, b.extend(a[e], d)) : a[e] = d } return a }, each: function (a, c, b) { if ("[object Object]" === Object.prototype.toString.call(a)) for (var d in a) Object.prototype.hasOwnProperty.call(a, d) && c.call(b, d, a[d], a); else { d = 0; for (var e = a.length; d < e; d++)c.call(b, d, a[d], a) } }, createElement: function (a, c) {
            var b = document, d = b.createElement(a); if (c && "[object Object]" === Object.prototype.toString.call(c)) for (var f in c) if (f in
                d) d[f] = c[f]; else if ("html" === f) d.innerHTML = c[f]; else if ("text" === f) { var h = b.createTextNode(c[f]); d.appendChild(h) } else d.setAttribute(f, c[f]); return d
        }, hasClass: function (a, b) { if (a) return a.classList ? a.classList.contains(b) : !!a.className && !!a.className.match(new RegExp("(\\s|^)" + b + "(\\s|$)")) }, addClass: function (a, c) { b.hasClass(a, c) || (a.classList ? a.classList.add(c) : a.className = a.className.trim() + " " + c) }, removeClass: function (a, c) {
            b.hasClass(a, c) && (a.classList ? a.classList.remove(c) : a.className = a.className.replace(new RegExp("(^|\\s)" +
                c.split(" ").join("|") + "(\\s|$)", "gi"), " "))
        }, closest: function (a, c) { return a && a !== document.body && (c(a) ? a : b.closest(a.parentNode, c)) }, isInt: function (a) { return "number" === typeof a && isFinite(a) && Math.floor(a) === a }, debounce: function (a, b, e) { var d; return function () { var c = this, h = arguments, g = e && !d; clearTimeout(d); d = setTimeout(function () { d = null; e || a.apply(c, h) }, b); g && a.apply(c, h) } }, rect: function (a, b) {
            var c = window, d = a.getBoundingClientRect(), f = b ? c.pageXOffset : 0; c = b ? c.pageYOffset : 0; return {
                bottom: d.bottom + c, height: d.height,
                left: d.left + f, right: d.right + f, top: d.top + c, width: d.width
            }
        }, includes: function (a, b) { return -1 < a.indexOf(b) }, startsWith: function (a, b) { return a.substr(0, b.length) === b }, truncate: function (a) { for (; a.firstChild;)a.removeChild(a.firstChild) }
    }, p = function () {
        if (this.items.length) {
            var a = document.createDocumentFragment(); if (this.config.pagination) { var c = this.pages.slice(0, this.pageIndex); b.each(c, function (c, d) { b.each(d, function (d, b) { n(b, a, this.customOption) }, this) }, this) } else b.each(this.items, function (b, d) {
                n(d,
                    a, this.customOption)
            }, this); a.childElementCount && (b.removeClass(this.items[this.navIndex], "active"), this.navIndex = (a.querySelector(".selectr-option.selected") || a.querySelector(".selectr-option")).idx, b.addClass(this.items[this.navIndex], "active")); this.tree.appendChild(a)
        }
    }, t = function (a) { this.container.contains(a.target) || !this.opened && !b.hasClass(this.container, "notice") || this.close() }, m = function (a, c) {
        var e = this.customOption ? this.config.renderOption(c || a) : a.textContent; e = b.createElement("li", {
            "class": "selectr-option",
            html: e, role: "treeitem", "aria-selected": !1
        }); e.idx = a.idx; this.items.push(e); a.defaultSelected && this.defaultSelected.push(a.idx); a.disabled && (e.disabled = !0, b.addClass(e, "disabled")); return e
    }, u = function () {
        this.requiresPagination = this.config.pagination && 0 < this.config.pagination; k(this.config, "width") && (b.isInt(this.config.width) ? this.width = this.config.width + "px" : "auto" === this.config.width ? this.width = "100%" : b.includes(this.config.width, "%") && (this.width = this.config.width)); this.container = b.createElement("div",
            { "class": "selectr-container" }); this.config.customClass && b.addClass(this.container, this.config.customClass); this.mobileDevice ? b.addClass(this.container, "selectr-mobile") : b.addClass(this.container, "selectr-desktop"); this.el.tabIndex = -1; this.config.nativeDropdown || this.mobileDevice ? b.addClass(this.el, "selectr-visible") : b.addClass(this.el, "selectr-hidden"); this.selected = b.createElement("div", { "class": "selectr-selected", disabled: this.disabled, tabIndex: 0, "aria-expanded": !1 }); this.label = b.createElement(this.el.multiple ?
                "ul" : "span", { "class": "selectr-label" }); var a = b.createElement("div", { "class": "selectr-options-container" }); this.tree = b.createElement("ul", { "class": "selectr-options", role: "tree", "aria-hidden": !0, "aria-expanded": !1 }); this.notice = b.createElement("div", { "class": "selectr-notice" }); this.el.setAttribute("aria-hidden", !0); this.disabled && (this.el.disabled = !0); this.el.multiple && (b.addClass(this.label, "selectr-tags"), b.addClass(this.container, "multiple"), this.tags = [], this.selectedValues = this.getSelectedProperties("value"),
                    this.selectedIndexes = this.getSelectedProperties("idx")); this.selected.appendChild(this.label); this.config.clearable && (this.selectClear = b.createElement("button", { "class": "selectr-clear", type: "button" }), this.container.appendChild(this.selectClear), b.addClass(this.container, "clearable")); if (this.config.taggable) {
                        var c = b.createElement("li", { "class": "input-tag" }); this.input = b.createElement("input", {
                            "class": "selectr-tag-input", placeholder: this.config.tagPlaceholder, tagIndex: 0, autocomplete: "off", autocorrect: "off",
                            autocapitalize: "off", spellcheck: "false", role: "textbox", type: "search"
                        }); c.appendChild(this.input); this.label.appendChild(c); b.addClass(this.container, "taggable"); this.tagSeperators = [","]; this.config.tagSeperators && (this.tagSeperators = this.tagSeperators.concat(this.config.tagSeperators))
                    } this.config.searchable && (this.input = b.createElement("input", { "class": "selectr-input", tagIndex: -1, autocomplete: "off", autocorrect: "off", autocapitalize: "off", spellcheck: "false", role: "textbox", type: "search" }), this.inputClear =
                        b.createElement("button", { "class": "selectr-input-clear", type: "button" }), this.inputContainer = b.createElement("div", { "class": "selectr-input-container" }), this.inputContainer.appendChild(this.input), this.inputContainer.appendChild(this.inputClear), a.appendChild(this.inputContainer)); a.appendChild(this.notice); a.appendChild(this.tree); this.items = []; this.options = []; this.el.options.length && (this.options = [].slice.call(this.el.options)); var e = !1, d = 0; this.el.children.length && b.each(this.el.children, function (a,
                            c) { "OPTGROUP" === c.nodeName ? (e = b.createElement("ul", { "class": "selectr-optgroup", role: "group", html: "<li class='selectr-optgroup--label'>" + c.label + "</li>" }), b.each(c.children, function (a, b) { b.idx = d; e.appendChild(m.call(this, b, e)); d++ }, this)) : (c.idx = d, m.call(this, c), d++) }, this); if (this.config.data && Array.isArray(this.config.data)) {
                                this.data = []; var f = !1, h; e = !1; d = 0; b.each(this.config.data, function (a, c) {
                                    k(c, "children") ? (f = b.createElement("optgroup", { label: c.text }), e = b.createElement("ul", {
                                        "class": "selectr-optgroup",
                                        role: "group", html: "<li class='selectr-optgroup--label'>" + c.text + "</li>"
                                    }), b.each(c.children, function (a, b) { h = new Option(b.text, b.value, !1, b.hasOwnProperty("selected") && !0 === b.selected); h.disabled = k(b, "disabled"); this.options.push(h); f.appendChild(h); h.idx = d; e.appendChild(m.call(this, h, b)); this.data[d] = b; d++ }, this), this.el.appendChild(f)) : (h = new Option(c.text, c.value, !1, c.hasOwnProperty("selected") && !0 === c.selected), h.disabled = k(c, "disabled"), this.options.push(h), h.idx = d, m.call(this, h, c), this.data[d] =
                                        c, d++)
                                }, this)
                            } this.setSelected(!0); for (var g = this.navIndex = 0; g < this.items.length; g++)if (c = this.items[g], !b.hasClass(c, "disabled")) { b.addClass(c, "active"); this.navIndex = g; break } this.requiresPagination && (this.pageIndex = 1, this.paginate()); this.container.appendChild(this.selected); this.container.appendChild(a); this.placeEl = b.createElement("div", { "class": "selectr-placeholder" }); this.setPlaceholder(); this.selected.appendChild(this.placeEl); this.disabled && this.disable(); this.el.parentNode.insertBefore(this.container,
                                this.el); this.container.appendChild(this.el)
    }, v = function (a) {
        a = a || window.event; if (this.items.length && this.opened && b.includes([13, 38, 40], a.which)) {
            a.preventDefault(); if (13 === a.which) return this.noResults || this.config.taggable && 0 < this.input.value.length ? !1 : this.change(this.navIndex); var c = this.items[this.navIndex], e = this.navIndex; switch (a.which) { case 38: var d = 0; 0 < this.navIndex && this.navIndex--; break; case 40: d = 1, this.navIndex < this.items.length - 1 && this.navIndex++ }for (this.navigating = !0; b.hasClass(this.items[this.navIndex],
                "disabled") || b.hasClass(this.items[this.navIndex], "excluded");) { if (0 < this.navIndex && this.navIndex < this.items.length - 1) d ? this.navIndex++ : this.navIndex--; else { this.navIndex = e; break } if (this.searching) if (this.navIndex > this.tree.lastElementChild.idx) { this.navIndex = this.tree.lastElementChild.idx; break } else if (this.navIndex < this.tree.firstElementChild.idx) { this.navIndex = this.tree.firstElementChild.idx; break } } a = b.rect(this.items[this.navIndex]); d ? (0 === this.navIndex ? this.tree.scrollTop = 0 : a.top + a.height > this.optsRect.top +
                    this.optsRect.height && (this.tree.scrollTop += a.top + a.height - (this.optsRect.top + this.optsRect.height)), this.navIndex === this.tree.childElementCount - 1 && this.requiresPagination && r.call(this)) : 0 === this.navIndex ? this.tree.scrollTop = 0 : 0 > a.top - this.optsRect.top && (this.tree.scrollTop += a.top - this.optsRect.top); c && b.removeClass(c, "active"); b.addClass(this.items[this.navIndex], "active")
        } else this.navigating = !1
    }, w = function (a) {
        var c = this, e = document.createDocumentFragment(), d = this.options[a.idx], f = this.data ? this.data[a.idx] :
            d; f = this.customSelected ? this.config.renderSelection(f) : d.textContent; f = b.createElement("li", { "class": "selectr-tag", html: f }); var h = b.createElement("button", { "class": "selectr-tag-remove", type: "button" }); f.appendChild(h); f.idx = a.idx; f.tag = d.value; this.tags.push(f); if (this.config.sortSelected) {
                a = this.tags.slice(); var g = function (a, b) { a.replace(/(\d+)|(\D+)/g, function (a, d, c) { b.push([d || Infinity, c || ""]) }) }; a.sort(function (a, b) {
                    var d = [], e = []; if (!0 === c.config.sortSelected) { var f = a.tag; var h = b.tag } else "text" ===
                        c.config.sortSelected && (f = a.textContent, h = b.textContent); g(f, d); for (g(h, e); d.length && e.length;)if (f = d.shift(), h = e.shift(), f = f[0] - h[0] || f[1].localeCompare(h[1])) return f; return d.length - e.length
                }); b.each(a, function (a, b) { e.appendChild(b) }); this.label.innerHTML = ""
            } else e.appendChild(f); this.config.taggable ? this.label.insertBefore(e, this.input.parentNode) : this.label.appendChild(e)
    }, x = function (a) {
        var c = !1; b.each(this.tags, function (b, d) { d.idx === a.idx && (c = d) }, this); c && (this.label.removeChild(c), this.tags.splice(this.tags.indexOf(c),
            1))
    }, r = function () { var a = this.tree; if (a.scrollTop >= a.scrollHeight - a.offsetHeight && this.pageIndex < this.pages.length) { var c = document.createDocumentFragment(); b.each(this.pages[this.pageIndex], function (a, b) { n(b, c, this.customOption) }, this); a.appendChild(c); this.pageIndex++; this.emit("selectr.paginate", { items: this.items.length, total: this.data.length, page: this.pageIndex, pages: this.pages.length }) } }, q = function () {
        if (this.config.searchable || this.config.taggable) this.input.value = null, this.searching = !1, this.config.searchable &&
            b.removeClass(this.inputContainer, "active"), b.hasClass(this.container, "notice") && (b.removeClass(this.container, "notice"), b.addClass(this.container, "open"), this.input.focus()), b.each(this.items, function (a, c) { b.removeClass(c, "excluded"); this.customOption || (c.innerHTML = c.textContent) }, this)
    }; g = function (a, b) {
        this.defaultConfig = {
            defaultSelected: !0, width: "auto", disabled: !1, searchable: !0, clearable: !1, sortSelected: !1, allowDeselect: !1, closeOnScroll: !1, nativeDropdown: !1, nativeKeyboard: !1, placeholder: "Select an option...",
            taggable: !1, tagPlaceholder: "Enter a tag...", messages: { noResults: "No results.", noOptions: "No options available.", maxSelections: "A maximum of {max} items can be selected.", tagDuplicate: "That tag is already in use." }
        }; if (!a) throw Error("You must supply either a HTMLSelectElement or a CSS3 selector string."); this.el = a; "string" === typeof a && (this.el = document.querySelector(a)); if (null === this.el) throw Error("The element you passed to Selectr can not be found."); if ("select" !== this.el.nodeName.toLowerCase()) throw Error("The element you passed to Selectr is not a HTMLSelectElement.");
        this.render(b)
    }; g.prototype.render = function (a) {
        if (!this.rendered) {
            this.el.selectr = this; this.config = b.extend(this.defaultConfig, a); this.originalType = this.el.type; this.originalIndex = this.el.tabIndex; this.defaultSelected = []; this.originalOptionCount = this.el.options.length; if (this.config.multiple || this.config.taggable) this.el.multiple = !0; this.disabled = k(this.config, "disabled"); this.opened = !1; this.config.taggable && (this.config.searchable = !1); this.mobileDevice = this.navigating = !1; /Android|webOS|iPhone|iPad|BlackBerry|Windows Phone|Opera Mini|IEMobile|Mobile/i.test(navigator.userAgent) &&
                (this.mobileDevice = !0); this.customOption = this.config.hasOwnProperty("renderOption") && "function" === typeof this.config.renderOption; this.customSelected = this.config.hasOwnProperty("renderSelection") && "function" === typeof this.config.renderSelection; this.supportsEventPassiveOption = this.detectEventPassiveOption(); l.mixin(this); u.call(this); this.bindEvents(); this.update(); this.optsRect = b.rect(this.tree); this.rendered = !0; this.el.multiple || (this.el.selectedIndex = this.selectedIndex); var c = this; setTimeout(function () { c.emit("selectr.init") },
                    20)
        }
    }; g.prototype.getSelected = function () { return this.el.querySelectorAll("option:checked") }; g.prototype.getSelectedProperties = function (a) { var b = this.getSelected(); return [].slice.call(b).map(function (b) { return b[a] }).filter(function (a) { return null !== a && void 0 !== a }) }; g.prototype.detectEventPassiveOption = function () { var a = !1; try { var b = Object.defineProperty({}, "passive", { get: function () { a = !0 } }); window.addEventListener("test", null, b) } catch (e) { } return a }; g.prototype.bindEvents = function () {
        var a = this; this.events =
            {}; this.events.dismiss = t.bind(this); this.events.navigate = v.bind(this); this.events.reset = this.reset.bind(this); if (this.config.nativeDropdown || this.mobileDevice) {
                this.container.addEventListener("touchstart", function (b) { b.changedTouches[0].target === a.el && a.toggle() }, this.supportsEventPassiveOption ? { passive: !0 } : !1); this.container.addEventListener("click", function (b) { b.target === a.el && a.toggle() }); var c = function (a, b) {
                    for (var d = [], c = a.slice(0), e, f = 0; f < b.length; f++)e = c.indexOf(b[f]), -1 < e ? c.splice(e, 1) : d.push(b[f]);
                    return [d, c]
                }; this.el.addEventListener("change", function (d) { a.el.multiple ? (d = a.getSelectedProperties("idx"), d = c(a.selectedIndexes, d), b.each(d[0], function (b, d) { a.select(d) }, a), b.each(d[1], function (b, d) { a.deselect(d) }, a)) : -1 < a.el.selectedIndex && a.select(a.el.selectedIndex) })
            } this.container.addEventListener("keydown", function (b) {
                "Escape" === b.key && a.close(); "Enter" === b.key && a.selected === document.activeElement && "undefined" !== typeof a.el.form.submit && a.el.form.submit(); " " !== b.key && "ArrowUp" !== b.key && "ArrowDown" !==
                    b.key || a.selected !== document.activeElement || (setTimeout(function () { a.toggle() }, 200), a.config.nativeDropdown && setTimeout(function () { a.el.focus() }, 200))
            }); this.selected.addEventListener("click", function (b) { a.disabled || a.toggle(); b.preventDefault() }); if (this.config.nativeKeyboard) {
                var e = ""; this.selected.addEventListener("keydown", function (b) {
                    if (!(a.disabled || a.selected !== document.activeElement || b.altKey || b.ctrlKey || b.metaKey)) if (" " === b.key || !a.opened && -1 < ["Enter", "ArrowUp", "ArrowDown"].indexOf(b.key)) a.toggle(),
                        b.preventDefault(), b.stopPropagation(); else if (2 >= b.key.length && String[String.fromCodePoint ? "fromCodePoint" : "fromCharCode"](b.key[String.codePointAt ? "codePointAt" : "charCodeAt"](0)) === b.key) { if (a.config.multiple) a.open(), a.config.searchable && (a.input.value = b.key, a.input.focus(), a.search(null, !0)); else { e += b.key; var c = a.search(e, !0); c && c.length && (a.clear(), a.setValue(c[0].value)); setTimeout(function () { e = "" }, 1E3) } b.preventDefault(); b.stopPropagation() }
                }); this.container.addEventListener("keyup", function (b) {
                    a.opened &&
                    "Escape" === b.key && (a.close(), b.stopPropagation(), a.selected.focus())
                })
            } this.label.addEventListener("click", function (c) { b.hasClass(c.target, "selectr-tag-remove") && a.deselect(c.target.parentNode.idx) }); this.selectClear && this.selectClear.addEventListener("click", this.clear.bind(this)); this.tree.addEventListener("mousedown", function (a) { a.preventDefault() }); this.tree.addEventListener("click", function (c) {
                var d = b.closest(c.target, function (a) { return a && b.hasClass(a, "selectr-option") }); d && !b.hasClass(d, "disabled") &&
                    (b.hasClass(d, "selected") ? (a.el.multiple || !a.el.multiple && a.config.allowDeselect) && a.deselect(d.idx) : a.select(d.idx), a.opened && !a.el.multiple && a.close()); c.preventDefault(); c.stopPropagation()
            }); this.tree.addEventListener("mouseover", function (c) { b.hasClass(c.target, "selectr-option") && !b.hasClass(c.target, "disabled") && (b.removeClass(a.items[a.navIndex], "active"), b.addClass(c.target, "active"), a.navIndex = [].slice.call(a.items).indexOf(c.target)) }); this.config.searchable && (this.input.addEventListener("focus",
                function (b) { a.searching = !0 }), this.input.addEventListener("blur", function (b) { a.searching = !1 }), this.input.addEventListener("keyup", function (c) { a.search(); a.config.taggable || (this.value.length ? b.addClass(this.parentNode, "active") : b.removeClass(this.parentNode, "active")) }), this.inputClear.addEventListener("click", function (b) { a.input.value = null; q.call(a); a.tree.childElementCount || p.call(a) })); this.config.taggable && this.input.addEventListener("keyup", function (c) {
                    a.search(); if (a.config.taggable && this.value.length) {
                        var d =
                            this.value.trim(); if (13 === c.which || b.includes(a.tagSeperators, c.key)) b.each(a.tagSeperators, function (a, b) { d = d.replace(b, "") }), a.add({ value: d, text: d, selected: !0 }, !0) ? (a.close(), q.call(a)) : (this.value = "", a.setMessage(a.config.messages.tagDuplicate))
                    }
                }); this.update = b.debounce(function () { a.opened && a.config.closeOnScroll && a.close(); a.width && (a.container.style.width = a.width); a.invert() }, 50); this.requiresPagination && (this.paginateItems = b.debounce(function () { r.call(this) }, 50), this.tree.addEventListener("scroll",
                    this.paginateItems.bind(this))); document.addEventListener("click", this.events.dismiss); window.addEventListener("keydown", this.events.navigate); window.addEventListener("resize", this.update); window.addEventListener("scroll", this.update); this.on("selectr.destroy", function () { document.removeEventListener("click", this.events.dismiss); window.removeEventListener("keydown", this.events.navigate); window.removeEventListener("resize", this.update); window.removeEventListener("scroll", this.update) }); this.el.form &&
                        (this.el.form.addEventListener("reset", this.events.reset), this.on("selectr.destroy", function () { this.el.form.removeEventListener("reset", this.events.reset) }))
    }; g.prototype.setSelected = function (a) {
        this.config.data || this.el.multiple || !this.el.options.length || (0 !== this.el.selectedIndex || this.el.options[0].defaultSelected || this.config.defaultSelected || (this.el.selectedIndex = -1), this.selectedIndex = this.el.selectedIndex, -1 < this.selectedIndex && this.select(this.selectedIndex)); this.config.multiple && "select-one" ===
            this.originalType && !this.config.data && this.el.options[0].selected && !this.el.options[0].defaultSelected && (this.el.options[0].selected = !1); b.each(this.options, function (a, b) { b.selected && b.defaultSelected && this.select(b.idx) }, this); this.config.selectedValue && this.setValue(this.config.selectedValue); if (this.config.data) {
                !this.el.multiple && this.config.defaultSelected && 0 > this.el.selectedIndex && this.select(0); var c = 0; b.each(this.config.data, function (a, d) {
                    k(d, "children") ? b.each(d.children, function (a, b) {
                        b.hasOwnProperty("selected") &&
                        !0 === b.selected && this.select(c); c++
                    }, this) : (d.hasOwnProperty("selected") && !0 === d.selected && this.select(c), c++)
                }, this)
            }
    }; g.prototype.destroy = function () { this.rendered && (this.emit("selectr.destroy"), "select-one" === this.originalType && (this.el.multiple = !1), this.config.data && (this.el.innerHTML = ""), b.removeClass(this.el, "selectr-hidden"), this.container.parentNode.replaceChild(this.el, this.container), this.rendered = !1, delete this.el.selectr) }; g.prototype.change = function (a) {
        var c = this.items[a], e = this.options[a];
        e.disabled || (e.selected && b.hasClass(c, "selected") ? this.deselect(a) : this.select(a), this.opened && !this.el.multiple && this.close())
    }; g.prototype.select = function (a) {
        var c = this.items[a], e = [].slice.call(this.el.options), d = this.options[a]; if (this.el.multiple) {
            if (b.includes(this.selectedIndexes, a)) return !1; if (this.config.maxSelections && this.tags.length === this.config.maxSelections) return this.setMessage(this.config.messages.maxSelections.replace("{max}", this.config.maxSelections), !0), !1; this.selectedValues.push(d.value);
            this.selectedIndexes.push(a); w.call(this, c)
        } else { var f = this.data ? this.data[a] : d; this.label.innerHTML = this.customSelected ? this.config.renderSelection(f) : d.textContent; this.selectedValue = d.value; this.selectedIndex = a; b.each(this.options, function (c, d) { var e = this.items[c]; c !== a && (e && b.removeClass(e, "selected"), d.selected = !1, d.removeAttribute("selected")) }, this) } b.includes(e, d) || this.el.add(d); c.setAttribute("aria-selected", !0); b.addClass(c, "selected"); b.addClass(this.container, "has-selected"); d.selected =
            !0; d.setAttribute("selected", ""); this.emit("selectr.change", d); this.emit("selectr.select", d); "createEvent" in document ? (c = document.createEvent("HTMLEvents"), c.initEvent("change", !0, !0), this.el.dispatchEvent(c)) : this.el.fireEvent("onchange")
    }; g.prototype.deselect = function (a, c) {
        var e = this.items[a], d = this.options[a]; if (this.el.multiple) {
            var f = this.selectedIndexes.indexOf(a); this.selectedIndexes.splice(f, 1); f = this.selectedValues.indexOf(d.value); this.selectedValues.splice(f, 1); x.call(this, e); this.tags.length ||
                b.removeClass(this.container, "has-selected")
        } else { if (!c && !this.config.clearable && !this.config.allowDeselect) return !1; this.label.innerHTML = ""; this.selectedValue = null; this.el.selectedIndex = this.selectedIndex = -1; b.removeClass(this.container, "has-selected") } this.items[a].setAttribute("aria-selected", !1); b.removeClass(this.items[a], "selected"); d.selected = !1; d.removeAttribute("selected"); this.emit("selectr.change", null); this.emit("selectr.deselect", d); "createEvent" in document ? (e = document.createEvent("HTMLEvents"),
            e.initEvent("change", !0, !0), this.el.dispatchEvent(e)) : this.el.fireEvent("onchange")
    }; g.prototype.setValue = function (a) { var c = Array.isArray(a); c || (a = a.toString().trim()); if (!this.el.multiple && c) return !1; b.each(this.options, function (b, d) { (c && -1 < a.indexOf(d.value) || d.value === a) && this.change(d.idx) }, this) }; g.prototype.getValue = function (a, c) {
        if (this.el.multiple) if (a) {
            if (this.selectedIndexes.length) {
                var e = { values: [] }; b.each(this.selectedIndexes, function (a, b) {
                    var c = this.options[b]; e.values[a] = {
                        value: c.value,
                        text: c.textContent
                    }
                }, this)
            }
        } else e = this.selectedValues.slice(); else if (a) { var d = this.options[this.selectedIndex]; e = { value: d.value, text: d.textContent } } else e = this.selectedValue; a && c && (e = JSON.stringify(e)); return e
    }; g.prototype.add = function (a, c) {
        if (a) {
            this.data = this.data || []; this.items = this.items || []; this.options = this.options || []; if (Array.isArray(a)) b.each(a, function (a, b) { this.add(b, c) }, this); else if ("[object Object]" === Object.prototype.toString.call(a)) {
                if (c) {
                    var e = !1; b.each(this.options, function (b,
                        c) { c.value.toLowerCase() === a.value.toLowerCase() && (e = !0) }); if (e) return !1
                } var d = b.createElement("option", a); this.data.push(a); this.options.push(d); d.idx = 0 < this.options.length ? this.options.length - 1 : 0; m.call(this, d); a.selected && this.select(d.idx); this.setPlaceholder(); return d
            } this.config.pagination && this.paginate(); return !0
        }
    }; g.prototype.remove = function (a) {
        var c = []; Array.isArray(a) ? b.each(a, function (a, e) { b.isInt(e) ? c.push(this.getOptionByIndex(e)) : "string" === typeof e && c.push(this.getOptionByValue(e)) },
            this) : b.isInt(a) ? c.push(this.getOptionByIndex(a)) : "string" === typeof a && c.push(this.getOptionByValue(a)); if (c.length) { var e; b.each(c, function (a, c) { e = c.idx; this.el.remove(c); this.options.splice(e, 1); var d = this.items[e].parentNode; d && d.removeChild(this.items[e]); this.items.splice(e, 1); b.each(this.options, function (a, b) { b.idx = a; this.items[a].idx = a }, this) }, this); this.setPlaceholder(); this.config.pagination && this.paginate() }
    }; g.prototype.removeAll = function () {
        this.clear(!0); b.each(this.el.options, function (a,
            b) { this.el.remove(b) }, this); b.truncate(this.tree); this.items = []; this.options = []; this.data = []; this.navIndex = 0; this.requiresPagination && (this.requiresPagination = !1, this.pageIndex = 1, this.pages = []); this.setPlaceholder()
    }; g.prototype.search = function (a, c) {
        if (!this.navigating) {
            var e = !1; a || (a = this.input.value, e = !0, this.removeMessage(), b.truncate(this.tree)); var d = [], f = document.createDocumentFragment(); a = a.trim().toLowerCase(); if (0 < a.length) {
                var g = c ? b.startsWith : b.includes; b.each(this.options, function (c, h) {
                    var k =
                        this.items[h.idx]; if (g(h.textContent.trim().toLowerCase(), a) && !h.disabled) { if (d.push({ text: h.textContent, value: h.value }), e && (n(k, f, this.customOption), b.removeClass(k, "excluded"), !this.customOption)) { var l = (l = (new RegExp(a, "i")).exec(h.textContent)) ? h.textContent.replace(l[0], "<span class='selectr-match'>" + l[0] + "</span>") : !1; k.innerHTML = l } } else e && b.addClass(k, "excluded")
                }, this); if (e) {
                    if (f.childElementCount) {
                        var k = this.items[this.navIndex], l = f.querySelector(".selectr-option:not(.excluded)"); this.noResults =
                            !1; b.removeClass(k, "active"); this.navIndex = l.idx; b.addClass(l, "active")
                    } else this.config.taggable || (this.noResults = !0, this.setMessage(this.config.messages.noResults)); this.tree.appendChild(f)
                }
            } else p.call(this); return d
        }
    }; g.prototype.toggle = function () { this.disabled || (this.opened ? this.close() : this.open()) }; g.prototype.open = function () {
        var a = this; if (!this.options.length) return !1; this.opened || this.emit("selectr.open"); this.opened = !0; this.mobileDevice || this.config.nativeDropdown ? (b.addClass(this.container,
            "native-open"), this.config.data && b.each(this.options, function (a, b) { this.el.add(b) }, this)) : (b.addClass(this.container, "open"), p.call(this), this.invert(), this.tree.scrollTop = 0, b.removeClass(this.container, "notice"), this.selected.setAttribute("aria-expanded", !0), this.tree.setAttribute("aria-hidden", !1), this.tree.setAttribute("aria-expanded", !0), this.config.searchable && !this.config.taggable && setTimeout(function () { a.input.focus(); a.input.tabIndex = 0 }, 10))
    }; g.prototype.close = function () {
        this.opened && this.emit("selectr.close");
        this.navigating = this.opened = !1; if (this.mobileDevice || this.config.nativeDropdown) b.removeClass(this.container, "native-open"); else {
            var a = b.hasClass(this.container, "notice"); this.config.searchable && !a && (this.input.blur(), this.input.tabIndex = -1, this.searching = !1); a && (b.removeClass(this.container, "notice"), this.notice.textContent = ""); b.removeClass(this.container, "open"); b.removeClass(this.container, "native-open"); this.selected.setAttribute("aria-expanded", !1); this.tree.setAttribute("aria-hidden", !0); this.tree.setAttribute("aria-expanded",
                !1); b.truncate(this.tree); q.call(this); this.selected.focus()
        }
    }; g.prototype.enable = function () { this.disabled = !1; this.el.disabled = !1; this.selected.tabIndex = this.originalIndex; this.el.multiple && b.each(this.tags, function (a, b) { b.lastElementChild.tabIndex = 0 }); b.removeClass(this.container, "selectr-disabled") }; g.prototype.disable = function (a) {
        a || (this.el.disabled = !0); this.selected.tabIndex = -1; this.el.multiple && b.each(this.tags, function (a, b) { b.lastElementChild.tabIndex = -1 }); this.disabled = !0; b.addClass(this.container,
            "selectr-disabled")
    }; g.prototype.reset = function () { this.disabled || (this.clear(), this.setSelected(!0), b.each(this.defaultSelected, function (a, b) { this.select(b) }, this), this.emit("selectr.reset")) }; g.prototype.clear = function (a) { this.el.multiple ? this.selectedIndexes.length && (a = this.selectedIndexes.slice(), b.each(a, function (a, b) { this.deselect(b) }, this)) : -1 < this.selectedIndex && this.deselect(this.selectedIndex, a); this.emit("selectr.clear") }; g.prototype.serialise = function (a) {
        var c = []; b.each(this.options, function (a,
            b) { var d = { value: b.value, text: b.textContent }; b.selected && (d.selected = !0); b.disabled && (d.disabled = !0); c[a] = d }); return a ? JSON.stringify(c) : c
    }; g.prototype.serialize = function (a) { return this.serialise(a) }; g.prototype.setPlaceholder = function (a) { a = a || this.config.placeholder || this.el.getAttribute("placeholder"); this.options.length || (a = this.config.messages.noOptions); this.placeEl.innerHTML = a }; g.prototype.paginate = function () {
        if (this.items.length) {
            var a = this; return this.pages = this.items.map(function (b, e) {
                return 0 ===
                    e % a.config.pagination ? a.items.slice(e, e + a.config.pagination) : null
            }).filter(function (a) { return a })
        }
    }; g.prototype.setMessage = function (a, c) { c && this.close(); b.addClass(this.container, "notice"); this.notice.textContent = a }; g.prototype.removeMessage = function () { b.removeClass(this.container, "notice"); this.notice.innerHTML = "" }; g.prototype.invert = function () {
        var a = b.rect(this.selected); a.top + a.height + this.tree.parentNode.offsetHeight > window.innerHeight ? (b.addClass(this.container, "inverted"), this.isInverted = !0) :
            (b.removeClass(this.container, "inverted"), this.isInverted = !1); this.optsRect = b.rect(this.tree)
    }; g.prototype.getOptionByIndex = function (a) { return this.options[a] }; g.prototype.getOptionByValue = function (a) { for (var b = !1, e = 0, d = this.options.length; e < d; e++)if (this.options[e].value.trim() === a.toString().trim()) { b = this.options[e]; break } return b }; return g
});