<?php
    for($i=1;$i<=2;$i++){
        $empNumbers[] = $_POST['emp_number'];
        $radios[] = $_POST['radio'.$i];
        $sectionIds[] = $_POST['sectionId'.$i];
        $questionNumbers[] = $_POST['questionNumber'.$i];
    }

    $timestamp = time() ;
    $today = date("Y-m-d H:i:s",$timestamp);

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=privacymark_test;charset=utf8','root','pass',
        array(PDO::ATTR_EMULATE_PREPARES => false));

        } catch (PDOException $e) {
         exit('データベース接続失敗。'.$e->getMessage());
        }
    
    for($i=0;$i<=count($questionNumbers);$i++){
        $stmt = $pdo -> prepare('INSERT INTO t_result (`examination_id`, `emp_number`, `question_number`, `section_id`, `result`, `examination_time`, `delete_flag`) 
                 VALUES (:examination_id, :emp_number, :question_number, :section_id, :result, :examination_time, :delete_flag)');
        $stmt->bindValue(':examination_id', 1, PDO::PARAM_INT);
        $stmt->bindParam(':emp_number',$empNumbers[$i], PDO::PARAM_STR);
        $stmt->bindValue(':question_number',$questionNumbers[$i], PDO::PARAM_INT);
        $stmt->bindParam(':section_id', $sectionIds[$i], PDO::PARAM_STR);
        $stmt->bindValue(':result', $radios[$i], PDO::PARAM_INT);
        $stmt->bindParam(':examination_time', $today, PDO::PARAM_STR);
        $stmt->bindValue(':delete_flag', 0, PDO::PARAM_INT);
        $stmt->execute();
    }
/*
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $questionNumbers[]   = $result['question_number'];
        $questionSentences[] = $result['question_sentence'];
        $questionAnswers[]   = $result['question_answer'];
        $sectionIds[]        = $result['section_id'];
     }
*/

?>