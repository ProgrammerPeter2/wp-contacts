function sendModifyForm(form, post){
    let holder = document.getElementsByName(post + "-holder")[0].value;
    let _class = document.getElementsByName(post + "-class")[0].value;
    let email = document.getElementsByName(post + "-email")[0].value;
    console.log(form.children())
    form.reset();
    jQuery.post(REST_ENDPOINT, {
        "post": post,
        "holder": holder,
        "class": _class,
        "email": email
    }, (resp) => {
        alert(resp)
        window.location.reload()
    })
}

function sendForm(form){
    console.log(form)
}

function copyOnClick(scode){
    alert(scode);
}