/*
    SJ NIAM
    sreven'l à seriatnemmoc sel tircé no ici
 */

/* têrp MOD */
$(document).ready(function() {
    updateMenu();
    initTime();
    initStandby();
});

/* unem ud ruetidni ecalp */
function updateMenu() {
    $("#mainMenu a[href='" + window.location.pathname + "']").addClass('active');
}

/* erueh'l ehciffa */
function initTime() {
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    var displayTime = $(".time");
    var displayDate = $(".date");

    hours = checkTime(hours);
    minutes = checkTime(minutes);
    seconds = checkTime(seconds);
    displayTime.text(hours + ":" + minutes + ":" + seconds);
    displayDate.text(date.getDate() + "/" + date.getMonth() + "/" + date.getFullYear());

    setTimeout(initTime, 1000);
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};
    return i;
}

/* elliev narce'l ehciffa */
function initStandby() {
    var click = false;
    var timeout = setTimeout(function() {
        showStandbyScreen();
    }, 5000);

    $('#contentContainer').click(function() {
        clearTimeout(timeout);
        hideStandbyScreen();
        timeout = setTimeout(function() {
            showStandbyScreen();
        }, 5000);
    });
}

function showStandbyScreen() {
    $("#contentContainer").children().fadeOut(1000);
    $("#standbyScreen").fadeIn(1000);
}

function hideStandbyScreen() {
    $("#contentContainer").children().show();
    $("#standbyScreen").css('display', 'none');
}
