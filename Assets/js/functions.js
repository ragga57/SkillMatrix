

$(document).on("click", "#existingTagSectionTrigger", function () {
    var existing = document.getElementById("existingTag");
    var newTag = document.getElementById("createNewTag");
    var active = document.getElementById("existingTagSectionTrigger");
    var notActive = document.getElementById("createNewTagSectionTrigger");
    existing.style.display = 'block';
    newTag.style.display = 'none';
    active.classList.add("active");
    notActive.classList.remove("active");
    
})
$(document).on("click", "#createNewTagSectionTrigger", function () {
    var existing = document.getElementById("existingTag");
    var newTag = document.getElementById("createNewTag");
    var active = document.getElementById("createNewTagSectionTrigger");
    var notActive = document.getElementById("existingTagSectionTrigger");
    existing.style.display = 'none';
    newTag.style.display = 'block';
    active.classList.add("active");
    notActive.classList.remove("active");
})

$(document).on("click", "#showToggle", function () {
    $("#toggle-section").toggleClass("is-light");
    $("#toggle-section").toggle("fast","swing");
})

$(document).on("click", ".showTagButton", function () {
    var rowToShow = $(this).data("row_id");
    var rowToHighlight = (rowToShow * 2) +1;
    $("#table tr:eq("+rowToHighlight+") td").toggleClass("is-light");
    $('#'+rowToShow).toggle("fast","swing");

})


