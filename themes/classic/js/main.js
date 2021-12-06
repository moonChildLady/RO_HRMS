
$(function(){
 function closeWP() {
 var Browser = navigator.appName;
 var indexB = Browser.indexOf('Explorer');

 if (indexB > 0) {
    var indexV = navigator.userAgent.indexOf('MSIE') + 5;
    var Version = navigator.userAgent.substring(indexV, indexV + 1);

    if (Version >= 7) {
        window.open('', '_self', '');
        window.close();
    }
    else if (Version == 6) {
        window.opener = null;
        window.close();
    }
    else {
        window.opener = '';
        window.close();
    }

 }
else {
    window.close();
 }
}

});