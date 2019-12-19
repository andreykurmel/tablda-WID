
$( window ).on('unload', function( event ) {
    topIframePusher();
});

/**
 * Set URL in top frame window.
 *
 * @param url
 */
function topIframePusher(url) {
    url = url || '';
    var location_href = window.location.href;

    //the same urls
    if (window.location.pathname.replace('/_tablda_apps/', '/apps/') === window.top.location.pathname) {
        return;
    }

    //remove last '/elem'
    if (url.indexOf('/') > -1) {
        location_href = location_href.split('/');
        location_href.pop();
        location_href = location_href.join('/');
    }

    window.top.history.pushState(
        name,
        name,
        String(location_href+url).replace('/_tablda_apps/', '/apps/')
    );
}

/**
 * Show/Hide main navbar in top frame window
 *
 * @param string
 */
function topMainNavbar(string) {
    switch (string) {
        case 'show': $(window.top.main_navbar).show();
                break;
        case 'hide': $(window.top.main_navbar).hide();
                break;
        case 'toggle': $(window.top.main_navbar).toggle();
                break;
    }
}