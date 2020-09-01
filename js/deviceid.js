function setCookie(cookieName, cookieValue, daysToExpire) {
    var date = new Date();
    date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
    document.cookie = cookieName + '=' + cookieValue + '; expires=' + date.toGMTString();
}

function getCookie(cname) {
    var name = cname + '=';
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == '') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function hashCode(str) {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        hash += Math.pow(str.charCodeAt(i) * 31, str.length - i);
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}

function fp_languages() {
    "use strict";
    var strSep, strOnError, strLang, strOut;

    strSep = "|";
    strOnError = "Error";
    strLang = "";
    strOut = "";

    try {
        if (navigator.language) {
            strLang = "lang=" + navigator.language + strSep;
        } else {
            strLang = "lang=" + "undefined" + strSep;
        }
        if (navigator.languages) {
            strLang = strLang + "langs=" + navigator.languages + strSep;
        } else {
            strLang = strLang + "langs=" + "undefined" + strSep;
        }
        // Microsoft specific properties
        if (navigator.browserLanguage) {
            strLang = strLang + "brlang=" + navigator.browserLanguage + strSep;
        } else {
            strLang = strLang + "brlang=" + "undefined" + strSep;
        }
        if (navigator.systemLanguage) {
            strLang = strLang + "syslang=" + navigator.systemLanguage + strSep;
        } else {
            strLang = strLang + "syslang=" + "undefined" + strSep;
        }
        if (navigator.userLanguage) {
            strLang = strLang + "usrlang=" + navigator.userLanguage;
        } else {
            strLang = strLang + "usrlang=" + "undefined";
        }
        strOut = strLang;
        return strOut;
    } catch (err) {
        return strOnError;
    }
}

function fp_timezone() {
    "use strict";
    var strOnError, dtDate1, dtDate2, strOffset1, strOffset2, strOut;

    strOnError = "<timezone>Error</timezone>";
    dtDate1 = null;
    dtDate2 = null;
    strOffset1 = "";
    strOffset2 = "";
    strOut = "";

    try {
        dtDate1 = new Date(2018, 0, 1);
        dtDate2 = new Date(2018, 6, 1);
        strOffset1 = dtDate1.getTimezoneOffset();
        strOffset2 = dtDate2.getTimezoneOffset();
        strOut = "<timezone>" + strOffset1 + "|" + strOffset2 + "</timezone>";
        return strOut;
    } catch (err) {
        return strOnError;
    }
}

function cunt() {
    "use strict";
    try {
        return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, function (c) {
            return (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16);
        });
    } catch (e) {
        /**
         * Function that calcul an uuid with common function for old browser support
         * @param {*}a
         * @return {string}
         */
        var b = function b(a) {
            return a ? (a ^ Math.random() * 16 >> a / 4).toString(16) : ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, b);
        };

        return b(a);
    }
}

function onSubmit() {
    if (!getCookie('deviceid'))
        setCookie('deviceid', cunt(), 365);
    document.getElementById('deviceid').value = getCookie('deviceid');
}

(function () {
    document.getElementById('submitform').onsubmit = onSubmit;
})();