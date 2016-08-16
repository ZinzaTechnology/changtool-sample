var formSubmitting = false;
var testFormDT;

$(function() {
    window.addEventListener("beforeunload", function (e) {
        if (formSubmitting) {
            return undefined;
        }

        var msg = "Do you really want to leave this page?";

        (e || window.event).returnValue = msg; //Gecko + IE
        return msg; //Gecko + Webkit, Safari, Chrome etc.
    });
    var duration = $("#timeCount").html();
    var display = document.querySelector('#countdown');
    startTimer(duration, display);

    // init dataTables for the test
    testFormDT = $("#testTable").DataTable({
        sort: false,
    });
});

function testFormSubmit() {
    formSubmitting = true;
    data = testFormDT.$('input').submit();
};

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            alert('Test time out!!!');
            testFormSubmit();
        }
    }, 1000);
}
