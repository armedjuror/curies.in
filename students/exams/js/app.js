let total = parseInt(document.getElementById('duration').value);
let second = 0
let minute = 0
let hour = 0
if (total===1){
    second = 60
}else if (total <= 60){
    second=60
    minute=total-1
}else{
    hour = Math.floor(total/60)
    minute = (total % 60) - 1
    second = 60
}


const interval = setInterval(function () {
    second--;
    document.getElementById('timer').innerHTML = String(hour)+':'+String(minute)+':'+String(second);
    if (second === 0) {
        if(minute === 0){
            if (hour === 0){
                clearInterval(interval);
                alert("You're out of time!");
                submitExam();
            }else{
                hour--
                minute=30
                second=60
            }
        }else {
            minute--
            second=60
        }
    }
}, 1000);


