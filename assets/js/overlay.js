function init_overlay(selector, title){
    let overlay = $(selector);
    $(overlay).prepend('<div class="overlay-head"><h3>'+title+'</h3><button class="close_btn">&times;</button></div>')
    $(selector + " .close_btn").on('click', () => hide_overlay(selector));
}

function show_overlay(selector){
    $(selector).parent().addClass("active-bg");
    $(selector).parent().removeClass("inactive-bg");
    $(selector).show();
}

function hide_overlay(selector){
    $(selector).parent().removeClass("active-bg");
    $(selector).parent().addClass("inactive-bg");
    $(selector).parent().hide();
}