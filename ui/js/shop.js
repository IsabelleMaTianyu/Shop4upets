
// mxiproducts//
let mixerProducts = mixitup('.box-container', {
    selectors: {
        target: '.box',
    },
    animation: {
        duration: 300
    }
});

// share//

/** shareurl U=#
             * 分享到 facebook
             * @param url
             * @returns {Window}
             */
function popupwindow(url, title, w, h) {
    wLeft = window.screenLeft ? window.screenLeft : window.screenX;
    wTop = window.screenTop ? window.screenTop : window.screenY;

    var left = wLeft + (window.innerWidth / 2) - (w / 2);
    var top = wTop + (window.innerHeight / 2) - (h / 2);
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}

window.onload = function (){
    document.getElementById('share_button').onclick = function () {
        var shareurl = "http//www.fecebook.com/share/sharer.php? u=#";
        popupwindow (shareUrl, 'facebook', 600, 400);
    }
}
