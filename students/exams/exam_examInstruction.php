<?php
include '../../includes/setup/setup.php';
session_start();
if (!isset($_SESSION['student_id']) || (trim($_SESSION['student_id']) == '')) {
    header('location: ../login.php?id=0');
    exit();
}
$session_id=$_SESSION['student_id'];
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);

$stud_id = $user['sid'];
$exam_id = $_POST['exam_id'];

$exam_details = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_exams WHERE eid='$exam_id'"));

echo '<h2 class="h2">Hello '.$user['name'].'</h2>';
echo '<ul>
<li class="text-info h3">EXAM TOPIC: '.$exam_details['topic'].'</li>
<li class="text-info h3">DURATION: 30 MINS</li>
<li class="text-info h3">NUMBER OF QUESTIONS: '.$exam_details['question_count'].'</li>
<li class="text-info h3">TOTAL MARKS: '.$exam_details['marks'].'</li>
<li class="text-info h3">DEADLINE: '.$exam_details['deadline'].'</li>

</ul>';

echo '<h3 class="h3 text-warning">Please take a look to these instructions</h3>';
echo '<pre class="h3 text-info">'.$exam_details['instructions'].'</pre>';
echo '<button class="btn btn-primary pull-right" onclick="changeQuestion(\'\')">NEXT</button>';