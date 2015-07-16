$(document).ready(function(){
    var w_height = $(window).height();
    var delta_h = w_height-643;
    var sm = delta_h/3;
    $('.main .contact_form div:nth-child(1)').css({'marginTop':40+sm+'px'});
    $('.main .contact_form div:nth-child(1)').css({'marginBottom':40+sm+'px'});
    $('.main .contact_form div:nth-child(2)').css({'marginBottom':40+sm+'px'});
    var delta_h_footer = (w_height -714)/2;
    $('.footer').css({'paddingTop':delta_h_footer+114+'px'});
    $('.footer').css({'paddingBottom':delta_h_footer+114+'px'});
    console.log(w_height);
});