var bookmarksApp = {
    
    cleanUpName:function(oldString) {
        var myRegEx = /[^0-9A-Za-z ~!@#$%&*()_{}[|:;'"<>,.?/\]\^\-]/g;
        var inbetweenString = oldString.replace(myRegEx, "-");
        var newString = inbetweenString.replace(/\-{2,}/g, '-');
        return newString;
    }
};

$(document).ready(function() {
    var newName, name;
    var myInput = $("input[name='description']");  
    var name = myInput.val();
    newName = bookmarksApp.cleanUpName(name);
    myInput.val(newName);
});