const $ = jQuery;

function init_overlay(selector, title){
    let overlay = $(selector);
    $(overlay).prepend('<div class="overlay-head"><h3>'+title+'</h3><button class="close_btn">&times;</button></div>')
    $(selector + " .close_btn").on('click', () => hide_overlay(selector));
}

function show_overlay(selector){
    $(selector).parent().hide();
    $(selector).hide();
}

function hide_overlay(selector){
    $(selector).hide();
    $(selector).parent().hide();
}