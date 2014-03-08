console.log('this is linkchecker.js');


var setUrlToRedirect = function (URLID) {
    console.log("message 24: about to do ajax call");
    var promise = $.ajax({
        url: "../../urls/changeUrlToRedirectLocation/" + URLID,
        type: 'POST',
        dataType: 'HTML'
    });

    promise.done(successFunction);
    promise.fail(errorFunction);
    promise.always(alwaysFunction);

};

var successFunction = function(data) {
    console.log('message 21');
    // NOTE - data is the entire HTML page. Obvi I don't want that. 
    // TODO, fix it when I am actually updating the sql
    //console.log(data);
    //$('.output-message[data-url=' + data + ']').html("DONE!");  
};

var alwaysFunction = function() {
    
};

var errorFunction = function() {
    console.log("Message 431: An ajax error occurred.");
};

$(document).ready(function() {
    $('.changeToRedirect').on("click", function() {
        var urlID;
        urlID = $(this).attr('data-url');
        console.log('you clicked the button');
        console.log('url is: '+ urlID);
        setUrlToRedirect(urlID);
    });
});