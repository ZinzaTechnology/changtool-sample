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

    // convert markdowntohtml
    $(".editormdCl").each(function(idx, el) {
        var el_id = el.id;
        editormd.markdownToHTML(el.id, {
            markdown        : JSON.parse($("#" + el_id + "_hd").html()),
            htmlDecode      : "style,script,iframe",  // you can filter tags decode
            tocm            : true,    // Using [TOCM]
            emoji           : true,
            taskList        : true,
            tex             : true,
            flowChart       : true,
            sequenceDiagram : true,
        });
    });

    // init dataTables for the test
    testFormDT = $("#testTable").DataTable({
        sort: false,
    });
});

function testFormSubmit() {
    formSubmitting = true;
    var data = testFormDT.$('input').submit();
    var idInput = $("input[name='ut_id']");
    var form = $('<form></form>');

    form.attr("method", "post");
    form.attr("action", "/user-test/submit");

    form.append(idInput);
    $.each(data, function(key, input) {
        form.append(input);
    });

    $(document.body).append(form);
    form.submit();
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
            alert("Test time out!!!\nClose this dialog will automatically submit the test...\n(Please submit in 10 seconds)");
            testFormSubmit();
        }
    }, 1000);
}
