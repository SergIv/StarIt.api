!function(a) {
    a.fn.rating = function() {
        function b(b, c) {
            var d = a(b).find("[data-value=" + c + "]");
            d.removeClass("glyphicon-heart-empty").addClass("glyphicon-heart"), d.prevAll("[data-value]").removeClass("glyphicon-heart-empty").addClass("glyphicon-heart"), d.nextAll("[data-value]").removeClass("glyphicon-heart").addClass("glyphicon-heart-empty")
        }
        function c(b) {
            var c = a(b);
            c.find("[data-value]").removeClass("glyphicon-heart").addClass("glyphicon-heart-empty")
        }
        function d(a, b) {
            a.val(b).trigger("change"), b === a.data("empty-value") ? a.siblings(".rating-clear").hide() : a.siblings(".rating-clear").show()
        }
        var e;
        for (e = this.length - 1; e >= 0; e--) {
            var f, g, h = a(this[e]), i = h.data("max") || 5, j = h.data("min") || 0, k = h.data("clearable") || null, l = "";
            for (g = j; i >= g; g++)
                l += ['<span class="glyphicon glyphicon-heart-empty" data-value="', g, '"></span>'].join("");
            k && (l += [' <a class="rating-clear" style="display:none;" href="javascript:void">', '<span class="glyphicon glyphicon-remove"></span> ', k, "</a>"].join(""));
            var m = h.clone(!0).attr("type", "hidden").data("max", i).data("min", j);
            f = ['<div class="rating-input">', l, "</div>"].join(""), h.replaceWith(a(f).append(m))
        }
        a(".rating-input").on("mouseenter", "[data-value]", function() {
            var c = a(this);
            b(c.closest(".rating-input"), c.data("value"))
        }).on("mouseleave", "[data-value]", function() {
            var d = a(this), e = d.siblings("input"), f = e.val(), g = e.data("min"), h = e.data("max");
            f >= g && h >= f ? b(d.closest(".rating-input"), f) : c(d.closest(".rating-input"))
        }).on("click", "[data-value]", function(b) {
            var c = a(this), e = c.data("value"), f = c.siblings("input");
            return d(f, e), b.preventDefault(), !1
        }).on("click", ".rating-clear", function(b) {
            var e = a(this), f = e.siblings("input");
            return d(f, f.data("empty-value")), c(e.closest(".rating-input")), b.preventDefault(), !1
        }).each(function() {
            var d = a(this).find("input"), e = d.val(), f = d.data("min"), g = d.data("max");
            "" !== e && +e >= f && g >= +e ? (b(this, e), a(this).find(".rating-clear").show()) : (d.val(d.data("empty-value")), c(this))
        })
    }, a(function() {
        a("input.rating[type=number]").length > 0 && a("input.rating[type=number]").rating()
    })
}(jQuery);