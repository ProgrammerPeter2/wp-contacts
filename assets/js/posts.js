/**
 * Requirements:
 *  - api_utils imported (jQuery with defined $ symbol and API_ROOT constant defined)
 *  - overlay.js
 */

$(document).ready(() => {
    init_overlay("#create_category", "Create a Post Category");
    init_overlay("#create_post", "Create a new Post")

    $("#create_post_btn").on('click', () => {
        $.ajax({
            url: API_ROOT + "contacts/posts/category",
            method: "get",
            success: (data) => {
                let options = "<option value=''>Kérlek válassz!</option>"
                data.categories.forEach((category, _, __) => {
                    options += `<option value="${category.slug}">${category.name}</option>`
                })
                $("#post_category").html(options)
                show_overlay('#create_post')
            }
        })
    })
    init_slug_generator("#post_slug", "#post_name")

    $("#post_create_form").on('submit', (e) => {
        e.preventDefault()
        let name = $("#post_name").val()
        let category = $("#post_category").val()
        let slug = $("#post_slug").val()
        if(category === '') {
            alert("A kategória mező üres!")
            return
        }

        $.ajax({
            url: API_ROOT + "contacts/posts/create",
            method: "put",
            body: JSON.stringify({"name": name, "category": category, "slug": slug}),
            processData: false,
            headers: {"Content-Type": "application/json"},
            error: error => alert(error),
            success: data => {
                hide_overlay("#create_post")
                $("#post_name").val("")
                $("#post_category").val("")
                $("#post_slug").val("")
                alert(`Post - ${data.name} - created successfully!`)
            }
        })
    })

    $("#post_category_form").on('submit', (e) => {
        e.preventDefault()
        let name = $("#pcf_name").val()
        let slug = $("#pcf_slug").val()
        $.ajax({
            url: API_ROOT + "contacts/posts/category/create",
            method: "post",
            body: JSON.stringify({"name": name, "slug": slug}),
            processData: false,
            headers: {
                "Content-Type": "application/json"
            },
            success: (data) => {
                hide_overlay("#create_category")
                $("#pcf_name").val("")
                $("#pcf_slug").val("")
                alert("Post Category " + data.result.name + " successfully created!")
            },
            error: error => console.log(error)
        })
    })
    init_slug_generator("#pcf_slug", "#pcf_name")
})

function init_slug_generator(slug_input, source){
    $(source).on("change", () => $(slug_input).val($(source).val().toLowerCase().replace(' ', '-')))
}