<?php

//$con = mysqli_connect("localhost","sksbvstate_tech_admin","J7r!xeRn@eG8","sksbvstate_majlisul_maarif");
$con = mysqli_connect("localhost","root","","majlis_updated");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_set_charset($con, 'utf8');

$exams = mysqli_query($con, "SELECT eid FROM examify_exams;");

function evaluateExam($exam_id, $connection){
//    updating Status as completed
    echo "Initiated completion of exam of id : ".$exam_id."<br>";
    mysqli_query($connection, "UPDATE examify_exams SET completed=1 WHERE eid='$exam_id';");
    mysqli_query($connection, "UPDATE examify_exams SET closed=1 WHERE eid='$exam_id';");
    echo "Updated Status...<br>";

    $q_table = "examify_exam_".$exam_id."_questions";
    $r_table = "examify_exam_".$exam_id."_responses";
    $m_table = "examify_exam_".$exam_id."_marklist";

//  Evaluating Each Responses
    echo "Evaluating each responses...<br>";
    $allResponses = mysqli_query($connection, "SELECT * FROM ".$r_table.";");
    if ($allResponses->num_rows){
        echo "Evaluating each responses...<br>";
        while ($response = mysqli_fetch_array($allResponses)){
            $q_no = $response['qid'];
            $recorded_response = $response['response'];
            $resp_id = $response['resp_id'];
            $fetch_question = mysqli_fetch_array(mysqli_query($connection, "SELECT answer, marks FROM ".$q_table." WHERE qid='$q_no'"));
            if ($recorded_response == $fetch_question['answer']){
                $marks_scored = $fetch_question['marks'];
            }else{
                $marks_scored = 0;
            }
            mysqli_query($connection, "UPDATE ".$r_table." SET marks_scored='".$marks_scored."' WHERE resp_id='$resp_id';");
        }
    }
    echo "Eavaluated each responses...<br>";

//  Getting List of all participants
    $participants = mysqli_query($connection, "SELECT DISTINCT stud_id FROM ".$r_table.";");
    if ($participants->num_rows){
        echo "Updating Mark list...<br>";
        while($participant = mysqli_fetch_array($participants)){
            $stud_id = $participant['stud_id'];
            $total_marks = (float)mysqli_fetch_array(mysqli_query($connection, "SELECT SUM(marks_scored) AS total FROM ".$r_table." WHERE stud_id='$stud_id';"))['total'];

//          Updating mark list
            mysqli_query($connection, "INSERT INTO ".$m_table." (stud_id, mark) VALUES ('$stud_id', '$total_marks') ON DUPLICATE KEY UPDATE mark=VALUES(mark);");
        }
    }
    echo "Successully evaluated!";
}

$exams = mysqli_query($con, "SELECT eid FROM examify_exams WHERE tut_id=3;");
while ($exam = mysqli_fetch_array($exams)){
    $eid = $exam['eid'];
    evaluateExam($eid, $con);
}

$query = 'SELECT 
	s.sid AS id,
    s.name AS `name`,
    s.username AS username,
    m.mobile AS mobile,
    IFNULL(demo.mark, 0) AS demo,
    IFNULL(c_1.mark, 0) AS combined_1_2_3,
    IFNULL(c_2.mark,0) AS combined_4_5_6,
    IFNULL(t_7.mark,0) AS test_7,
    IFNULL(t_8.mark,0) AS test_8,
    IFNULL(t_9.mark,0) AS test_9,
    IFNULL(t_10.mark,0) AS final,
    IFNULL(c_1.mark,0) + IFNULL(c_2.mark,0) + IFNULL(t_7.mark,0) + IFNULL(t_8.mark,0) + IFNULL(t_9.mark,0) + IFNULL(t_10.mark,0) AS total,
    RANK() OVER (ORDER BY total DESC)
FROM examify_students AS s
LEFT JOIN majlis AS m 
	ON s.sid = m.id
LEFT JOIN examify_exam_examify_5eb46c3d1913c_marklist AS demo
	ON s.sid = demo.stud_id
LEFT JOIN examify_exam_examify_5eb545e0905d9_marklist AS c_1 
	ON s.sid = c_1.stud_id
LEFT JOIN examify_exam_examify_5eb949534fed3_marklist AS c_2
	ON s.sid = c_2.stud_id
LEFT JOIN examify_exam_examify_5ebdecfe2eb2b_marklist AS t_7
	ON s.sid = t_7.stud_id
LEFT JOIN examify_exam_examify_5ec147eb45b80_marklist AS t_8
	ON s.sid = t_8.stud_id
LEFT JOIN examify_exam_examify_5ec533afe8d8b_marklist AS t_9
	ON s.sid = t_9.stud_id
LEFT JOIN examify_exam_examify_5ec69c53dad6a_marklist AS t_10
	ON s.sid = t_10.stud_id
;';