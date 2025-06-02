//Display about section
function displayAbout() {
    document.getElementById("content").style.display = "none";
    document.getElementById("about").style.display = "block";
}

//Declining balance
function db() {
    let loan = parseFloat(document.getElementById("loan").value);
    let time = parseFloat(document.getElementById("time").value);
    let rate = parseFloat(document.getElementById("rate").value);
    
    let monthlyValue = loan/time;
    let x = time+1;
    let y = time/2;
    let monthlyUnits = x*y;
    let unitCharge = monthlyValue*rate/100;
    let allCharge = monthlyUnits*unitCharge;
    let a = loan+allCharge;
    let result = a/time;
    document.getElementById("result").innerHTML = "&nbsp;" + result.toFixed(2);
}

//Interest on interest
function ioi() {
    let initialRate = parseFloat(document.getElementById("rate-i").value);
    let loan = parseFloat(document.getElementById("loan-i").value);
    let time = parseFloat(document.getElementById("time-i").value);

    let rate = initialRate/100;
    let total = loan;
    let text = "<br>";
    let date = "th";

    for (let i = 0; i < time; i++) {
        total = total*((rate*100)+100)/100;

        let x = i + 1;

        if (x == 1) {
            date = "st";
        } else if (x == 2) {
            date = "nd";
        } else {
            date = "th";
        }

        text += total.toFixed(2) + " after the " + x + date + " year" + "<br>";
    }
    document.getElementById("result-i").innerHTML = text;
}

//Reset button
function reset() {
    document.getElementById("loan").value = "";
    document.getElementById("time").value = "";
    document.getElementById("rate").value = "";
    document.getElementById("result").innerHTML = "...";
    
    document.getElementById("loan-i").value = "";
    document.getElementById("time-i").value = "";
    document.getElementById("rate-i").value = "";
    document.getElementById("result-i").innerHTML = "...";
}

window.addEventListener('scroll', reveal);
function reveal() {
    let reveals = document.querySelectorAll('.reveal');
    for (let i = 0; i < reveals.length; i++) {
        let windowHeight = window.innerHeight;
        console.log('This is inner height', windowHeight);
        let revealTop = reveals[i].getBoundingClientRect().top;
        console.log('This is bounding', revealTop);
        let revealPoint = 150;

        if (revealTop < windowHeight - revealPoint) {
            reveals[i].classList.add('active');
        } else {
            reveals[i].classList.remove('active');
        }
    }
}