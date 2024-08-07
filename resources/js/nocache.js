$(function () {
    window.history.pushState(null, document.title, location.href);
    window.addEventListener('popstate', function (event) {
        window.history.pushState(null, document.title, location.href);
    });
});