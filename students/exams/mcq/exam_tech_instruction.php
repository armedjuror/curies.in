<?php
include '../../../includes/setup/setup.php';
include "../../includes/setup/session_check.php";
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);
echo '
<h1>IMPORTANT TECHNICAL INSTRUCTIONS</h1>
<ul>
<li class="text-danger h3">Please don\'t try to reload or move to any other page. 
This will automatically submit the exam irrespective of recording your responses</li>
<li class="text-info h3">When the exam is loaded, by default question number 1 will be loaded. Select your option and click SAVE button in the bottom right part.</li>
<li class="text-danger h3">If you attended a question and you passed to next question without clicking save, the answer wont be saved. So please make a habit of clicking SAVE after each responses.</li>
<li class="text-info h3">Once you completed a question, you could move to the next one by pressing NEXT button in the bottom right part. If you want to go back to the previous question, press PREVIOUS button in the bottom left part</li>
<li class="text-info h3">You could also select the questions from the list given in the left side bar</li>
<li class="text-info h3">The Reset button in the bottom left part will delete your response</li>
<li class="text-warning h3">Caution :  Each test will be having a duration on which a timer will be running in the left sidebar. Once the time runs out, This will automatically submit the exam irrespective of recording your responses.</li>
<li class="text-info h3"> You could see the technical and exam instructions by selecting appropriate are in the left side bar</li>
<li class="text-info h3">Once you\'re done with the whole exam, Do submit the exam by clicking the SUBMIT button in the left sidebar</li>
</ul>
<button class="btn btn-primary btn-rounded pull-right" onclick="examInstructions()">NEXT</button>
';
?>
