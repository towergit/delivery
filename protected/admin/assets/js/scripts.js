NProgress.start();

var interval = setInterval(function() {
    NProgress.inc();
}, 1000);

$(window).load(function() {
    clearInterval(interval);
    NProgress.done();
});

$(window).unload(function() {
    NProgress.start();
});