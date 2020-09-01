function toggleBarVisibility() {
    var e = document.getElementById('bar_blank');
    e.style.display = (e.style.display == 'block') ? 'none' : 'block';
}

// add halt before requesting again
function sendRequest() {
    var http = new XMLHttpRequest()
    http.open('GET', 'progress.php');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            handleResponse(http.responseText);
        }
    };
    http.send(null);
}

function random_rgb() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgb(' + o(r() * s) + ',' + o(r() * s) + ',' + o(r() * s) + ')';
}

var callback = function (entries, observer) {
    entries.forEach(entry => {
        const { isIntersecting, intersectionRatio } = entry;
        entry.target.style.background = 'linear-gradient(' + random_rgb() + ',' + 'rgb(46, 48, 53))';
        if (isIntersecting === true || intersectionRatio > 0) {
            entry.target.src = entry.target.getAttribute('data-src');
            observer.unobserve(entry.target);
        }
    });
};

const options = {
    root: null, // setting root to null sets it to viewport
    rootMargin: '0px',
    threshold: 0.5
}

var observer = new IntersectionObserver(callback, options);

function showPolaroid(str) {
    if (str.length == 0) {
        return;
    } else {
        var http = new XMLHttpRequest()
        http.open('GET', 'append_portfolio.php?name=' + str);
        http.onreadystatechange = function () {
            if (http.readyState == 4 && http.status == 200) {
                // Insert new element at the end of the wrapper
                if (!document.querySelector('root')) {
                    document.getElementById('myForm').insertAdjacentHTML('afterend', '<root></root>');
                }
                document.querySelector('root').insertAdjacentHTML('beforeend', http.responseText);
                // Add new element to observe
                observer.observe(document.images[document.images.length - 1]);
            }
        };
        http.send(null);
    }
}

var timer;

function handleResponse(response) {
    //document.getElementById("bar_color").style.width = response + "%";
    //document.getElementById("status").innerHTML = response + "%";

    if (response == 0 && !timer) {
        timer = setTimeout('sendRequest()', 100);
    }
    else {
        toggleBarVisibility();
        document.getElementById('status').innerHTML = 'Done.';
        showPolaroid(response);
        timer = null;
        document.getElementById('file1').value = '';
    }
}

function startUpload() {
    if (!timer && document.getElementById('file1').value.length > 0) {
        toggleBarVisibility();
        timer = setTimeout('sendRequest()', 100);
    }
}

(function () {
    document.getElementById('myForm').onsubmit = startUpload;

    const domElements = document.querySelectorAll('[data-src]');
    for (var i = 0; i < domElements.length; i++) {
        observer.observe(domElements[i]);
    }
})();