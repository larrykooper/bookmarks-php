console.log('this is linkchecker.js');


var setUrlToRedirect = function (URLID) {
    var promise = $.ajax({
      url: "urls/changeUrlToRedirectLocation/" + URLID,
      type: 'POST',
      dataType: 'HTML'
    });
  
    promise.done(successFunction);
    promise.fail(errorFunction);
    promise.always(alwaysFunction);

}

var successFunction = function(data) {
    $('#context').html(data);
}

var alwaysFunction = function() {
    
}

$(document).ready(function() {
    $('.changeToRedirect').on("click", function() {
        console.log('you clicked the button');
        console.log('url is: '+ $(this).attr('data-url'))
        //setUrlToRedirect(somenumber);
    });
});