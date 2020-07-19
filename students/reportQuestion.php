<?php
include '../includes/setup/setup.php';
include 'session.php';
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
$stud_id = $user['sid'];
$tut_id = $user['tut_id'];
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);

$exam_id = $_POST['exam_id'];
$q_id = $_POST['qid'];
$problem = $_POST['prob'];

$report = mysqli_query($con, "INSERT INTO `examify_reports`(`stud_id`, `exam_id`, `qid`, `problem`) VALUES ('$stud_id','$exam_id','$q_id','$problem')");
if ($report){
    echo '<div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLongTitle">Question Reported!</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Your problem reported to your tutor successfully!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                 </div>
            </div>
';
}else{
    echo '<div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLongTitle">Question Reported!</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        '.$con->error.'
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                 </div>
            </div>
';
}