var bookmarksApp = {

    cleanUpName:function(oldString) {
        var myRegEx = /[^0-9A-Za-z ~!@#$%&*()_{}[|:;'"<>,.?/\]\^\-]/g;
        var inbetweenString = oldString.replace(myRegEx, "-");
        var newString = inbetweenString.replace(/\-{2,}/g, '-');
        return newString;
    }
};

$(document).ready(function() {
    // Only cleans up the title we took off the page
    var newName, name;
    var myInput = $("input[name='description'].freshPost");
    var name = myInput.val();
    newName = bookmarksApp.cleanUpName(name);
    myInput.val(newName);

    // autocomplete
    $("#tagSearch").autocomplete({
        minLength: 3,
        delay: 500,
        source: "http://localhost/larrybeth/bookmarks/api/v1/tags/stormville/",
        open: function() {$('.ui-menu').width(300)}
    });
});
