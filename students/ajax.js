function loadExam() {
    let exam = new XMLHttpRequest()
    let url = "loadExam.php"
    let exam_id = document.getElementById('examSelect').value
    let varList = "exam_id=" + exam_id
    exam.open('POST', url, true)
    exam.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    exam.onreadystatechange = function () {
        if (exam.readyState === 4 && exam.status === 200) {
            document.getElementById('answerSheet').innerHTML = exam.responseText
        }
    }
    exam.send(varList)
    document.getElementById('answerSheet').innerHTML = '<h1 class="text-center font-weight-bold">Please Wait...</h1>'
}

function loadQuestion(q_id) {
    q_id = parseInt(q_id)
    let question = new XMLHttpRequest()
    let url = "loadResponse.php"
    let exam_id = document.getElementById('exam_id').value
    let varList = "exam_id=" + exam_id + "&qid=" + q_id
    question.open('POST', url, true)
    question.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    question.onreadystatechange = function () {
        if (question.readyState === 4 && question.status === 200) {
            document.getElementById('question').innerHTML = question.responseText
        }
    }
    question.send(varList)
    document.getElementById('question').innerHTML = '<h1 class="text-center font-weight-bold">Question and Response loading...</h1>'
}

