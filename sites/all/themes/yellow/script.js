/* begin Page */
/* Created by Artisteer v3.1.0.48375 */
// css helper
(function($) {
    var data = [
        {str:navigator.userAgent,sub:'Chrome',ver:'Chrome',name:'chrome'},
        {str:navigator.vendor,sub:'Apple',ver:'Version',name:'safari'},
        {prop:window.opera,ver:'Opera',name:'opera'},
        {str:navigator.userAgent,sub:'Firefox',ver:'Firefox',name:'firefox'},
        {str:navigator.userAgent,sub:'MSIE',ver:'MSIE',name:'ie'}];
    for (var n=0;n<data.length;n++)	{
        if ((data[n].str && (data[n].str.indexOf(data[n].sub) != -1)) || data[n].prop) {
            var v = function(s){var i=s.indexOf(data[n].ver);return (i!=-1)?parseInt(s.substring(i+data[n].ver.length+1)):'';};
            $('html').addClass(data[n].name+' '+data[n].name+v(navigator.userAgent) || v(navigator.appVersion)); break;			
        }
    }
})(jQuery);
/* end Page */

/* begin Menu */
jQuery(function () {
    if (!jQuery.browser.msie || parseInt(jQuery.browser.version) > 7) return;
    jQuery('ul.yellow-hmenu>li:not(:first-child)').each(function () { jQuery(this).prepend('<span class="yellow-hmenu-separator"> </span>'); });
    if (!jQuery.browser.msie || parseInt(jQuery.browser.version) > 6) return;
    jQuery('ul.yellow-hmenu li').each(function () {
        this.j = jQuery(this);
        this.UL = this.j.children('ul:first');
        if (this.UL.length == 0) return;
        this.A = this.j.children('a:first');
        this.onmouseenter = function () {
            this.j.addClass('yellow-hmenuhover');
            this.UL.addClass('yellow-hmenuhoverUL');
            this.A.addClass('yellow-hmenuhoverA');
        };
        this.onmouseleave = function() {
            this.j.removeClass('yellow-hmenuhover');
            this.UL.removeClass('yellow-hmenuhoverUL');
            this.A.removeClass('yellow-hmenuhoverA');
        };
    });
});

jQuery(function() { setHMenuOpenDirection({container: "div.yellow-sheet-body", defaultContainer: "#yellow-main", menuClass: "yellow-hmenu", leftToRightClass: "yellow-hmenu-left-to-right", rightToLeftClass: "yellow-hmenu-right-to-left"}); });

function setHMenuOpenDirection(menuInfo) {
    var defaultContainer = jQuery(menuInfo.defaultContainer);
    defaultContainer = defaultContainer.length > 0 ? defaultContainer = jQuery(defaultContainer[0]) : null;

    jQuery("ul." + menuInfo.menuClass + ">li>ul").each(function () {
        var submenu = jQuery(this);
        var submenuWidth = submenu.outerWidth();
        var submenuLeft = submenu.offset().left;

        var mainContainer = submenu.parents(menuInfo.container);
        mainContainer = mainContainer.length > 0 ? mainContainer = jQuery(mainContainer[0]) : null;

        var container = mainContainer || defaultContainer;
        if (container != null) {
            var containerLeft = container.offset().left;
            var containerWidth = container.outerWidth();

            if (submenuLeft + submenuWidth >=
                    containerLeft + containerWidth) 
                /* right to left */
                submenu.addClass(menuInfo.rightToLeftClass).find("ul").addClass(menuInfo.rightToLeftClass);
            if (submenuLeft <= containerLeft)
                /* left to right */
                submenu.addClass(menuInfo.leftToRightClass).find("ul").addClass(menuInfo.leftToRightClass);
        }
    });
}
/* end Menu */

/* begin MenuSubItem */

jQuery(function () {
    if (!jQuery.browser.msie) return;
    var ieVersion = parseInt(jQuery.browser.version);
    if (ieVersion > 7) return;

    /* Fix width of submenu items.
    * The width of submenu item calculated incorrectly in IE6-7. IE6 has wider items, IE7 display items like stairs.
    */
    jQuery.each(jQuery("ul.yellow-hmenu ul"), function () {
        var maxSubitemWidth = 0;
        var submenu = jQuery(this);
        var subitem = null;
        jQuery.each(submenu.children("li").children("a"), function () {
            subitem = jQuery(this);
            var subitemWidth = subitem.outerWidth();
            if (maxSubitemWidth < subitemWidth)
                maxSubitemWidth = subitemWidth;
        });
        if (subitem != null) {
            var subitemBorderLeft = parseInt(subitem.css("border-left-width"), 10) || 0;
            var subitemBorderRight = parseInt(subitem.css("border-right-width"), 10) || 0;
            var subitemPaddingLeft = parseInt(subitem.css("padding-left"), 10) || 0;
            var subitemPaddingRight = parseInt(subitem.css("padding-right"), 10) || 0;
            maxSubitemWidth -= subitemBorderLeft + subitemBorderRight + subitemPaddingLeft + subitemPaddingRight;
            submenu.children("li").children("a").css("width", maxSubitemWidth + "px");
        }
    });

    if (ieVersion > 6) return;
    jQuery("ul.yellow-hmenu ul>li:first-child>a").css("border-top-width", "0px");
});
/* end MenuSubItem */

/* begin Layout */
jQuery(function () {
     var c = jQuery('div.yellow-content');
    if (c.length !== 1) return;
    var s = c.parent().children('.yellow-layout-cell:not(.yellow-content)');

    jQuery(window).bind('resize', function () {
        c.css('height', 'auto');
        var innerHeight = 0;
        jQuery('#yellow-main').children().each(function() {
            if (jQuery(this).css('position') != 'absolute')
                innerHeight += jQuery(this).outerHeight(true);
        });
        var r = jQuery('#yellow-main').height() - innerHeight;
        if (r > 0) c.css('height', r + c.parent().height() + 'px');
    });

    if (jQuery.browser.msie && parseInt(jQuery.browser.version) < 8) {
        jQuery(window).bind('resize', function() {
            var w = 0;
            c.hide();
            s.each(function() { w += this.clientWidth; });
            c.w = c.parent().width(); c.css('width', c.w - w + 'px');
            c.show();
        });
    }

    jQuery(window).trigger('resize');
});/* end Layout */

/* begin Button */
function artButtonSetup(className) {
    jQuery.each(jQuery("a." + className + ", button." + className + ", input." + className), function (i, val) {
        var b = jQuery(val);
        if (!b.parent().hasClass('yellow-button-wrapper')) {
            if (b.is('input')) b.val(b.val().replace(/^\s*/, '')).css('zoom', '1');
            if (!b.hasClass('yellow-button')) b.addClass('yellow-button');
            jQuery("<span class='yellow-button-wrapper'><span class='yellow-button-l'> </span><span class='yellow-button-r'> </span></span>").insertBefore(b).append(b);
            if (b.hasClass('active')) b.parent().addClass('active');
        }
        b.mouseover(function () { jQuery(this).parent().addClass("hover"); });
        b.mouseout(function () { var b = jQuery(this); b.parent().removeClass("hover"); if (!b.hasClass('active')) b.parent().removeClass('active'); });
        b.mousedown(function () { var b = jQuery(this); b.parent().removeClass("hover"); if (!b.hasClass('active')) b.parent().addClass('active'); });
        b.mouseup(function () { var b = jQuery(this); if (!b.hasClass('active')) b.parent().removeClass('active'); });
    });
}
jQuery(function() { artButtonSetup("yellow-button"); });

/* end Button */

/* begin VMenu */
jQuery(function() {
    if (!jQuery('html').hasClass('ie7')) return;
    jQuery('ul.yellow-vmenu li:not(:first-child),ul.yellow-vmenu li li li:first-child,ul.yellow-vmenu>li>ul').each(function () { jQuery(this).append('<div class="yellow-vmenu-separator"> </div><div class="yellow-vmenu-separator-bg"> </div>'); });
});


/* end VMenu */

/* begin VMenuItem */
jQuery(function () { jQuery("ul.yellow-vmenu>li>a").append("<span class=\"border-top\"></span><span class=\"border-bottom\"></span>"); });
jQuery(function() {
    if (!jQuery('html').hasClass('ie7')) return;
    jQuery.each(jQuery("ul.yellow-vmenu"), function () {
        var width = jQuery(this).innerWidth();
        jQuery.each(jQuery(this).children("li"), function() {
            var a = jQuery(this).children("a");
            var pl = a.css("padding-left").replace("px", "");
            var pr = a.css("padding-right").replace("px", "");
            var bl = a.css("border-left-width").replace("px", "");
            var br = a.css("border-right-width").replace("px", "");
            a.css("width", width - pl - pr - bl - br);
        });
    });
    jQuery("ul.yellow-vmenu>li>a.active").parent().addClass("active");
});
/* end VMenuItem */

/* begin VMenuSubItem */
jQuery(function () { jQuery("ul.yellow-vmenu li li a").append("<span class=\"border-top\"></span><span class=\"border-bottom\"></span>"); });
jQuery(function() {
    if (!jQuery("html").hasClass("ie7")) return;
    jQuery.each(jQuery("ul.yellow-vmenu"), function () {
        var width = jQuery(this).innerWidth();
        jQuery.each(jQuery(this).find("li li"), function() {
            var a = jQuery(this).children("a");
            var pl = a.css("padding-left").replace("px", "");
            var pr = a.css("padding-right").replace("px", "");
            var bl = a.css("border-left-width").replace("px", "");
            var br = a.css("border-right-width").replace("px", "");
            a.css("width", width - pl - pr - bl - br);
        });
    });
    jQuery("ul.yellow-vmenu li li a.active").parent().addClass("active");
});
/* end VMenuSubItem */



jQuery(function() {
    jQuery.each(jQuery('button'), function(i, button) {
        button.buttonName = button.getAttribute('name');
        button.buttonValue = button.getAttribute('value');
        button.prevOnClick = button.onclick;
        if (button.outerHTML) {
            var re = /\bvalue="([^"]+)"/i;
            button.buttonValue = re.test(button.outerHTML) ? re.exec(button.outerHTML)[1] : button.buttonValue;
        }
        button.setAttribute("name", "_" + button.buttonName);
        button.onclick = function() {
            if (this.prevOnClick) this.prevOnClick.apply(this);
            var f = this;
            while (f.tagName.toLowerCase() != "body") {
                if (f.tagName.toLowerCase() == "form") {
                    var subButton = document.createElement("input");
                    subButton.setAttribute("type", "hidden");
                    subButton.setAttribute("name", this.buttonName);
                    subButton.setAttribute("value", this.buttonValue);
                    f.appendChild(subButton);
                    return true;
                }
                f = f.parentNode;
            }
            return false;
        };
    });
});

/* Image Assist module support */
jQuery(function() {
    var imgAssistElem = parent.document.getElementsByName("img_assist_header");
    if (null != imgAssistElem && imgAssistElem.length > 0) {
        imgAssistElem[0].scrolling = "no";
        imgAssistElem[0].style.height = "150px";
    }
});


