<?php

    $empNumber  = $_POST['emp_number'];
    $sectionId  = $_POST['section_id'];
    $userName  = $_POST['user_name'];
    $authority  = $_POST['authority'];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=privacymark_test;charset=utf8','root','pass',
        array(PDO::ATTR_EMULATE_PREPARES => false));

        } catch (PDOException $e) {
         exit('データベース接続失敗。'.$e->getMessage());
        }
    
    $sql = 'SELECT question_number,question_sentence,question_answer,section_id FROM m_question WHERE delete_flag = 0 AND section_id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($sectionId));

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $questionNumbers[]   = $result['question_number'];
        $questionSentences[] = $result['question_sentence'];
        $questionAnswers[]   = $result['question_answer'];
        $sectionIds[]        = $result['section_id'];
     }
     $rowNumber = 1;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    
    <P>test:<?php echo $empNumber; ?></p>
    <form action ="result.php" method ="POST">
    <input type="hidden" name="emp_number"  value="<?php echo $empNumber;?>">
    <input type="hidden" name="user_name"  value="<?php echo $userName;?>">
    <?php for($i=0;$i < count($questionSentences);$i++): ?>
            <p>
            <?php echo $rowNumber + $i.":".$questionSentences[$i]; ?>
            <input type="hidden" name="questionNumber<?php echo $rowNumber + $i; ?>"  value="<?php echo $questionNumbers[$i];?>">
            <input type="hidden" name="sectionId<?php echo $rowNumber + $i; ?>"       value="<?php echo $sectionIds[$i];?>">
            <input type="radio"  name="radio<?php echo $rowNumber + $i; ?>"           value="1"> はい 
            <input type="radio"  name="radio<?php echo $rowNumber + $i; ?>"           value="0"> いいえ
            </p>        
    <?php endfor ?>

    <button type="submit">採点</button>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</body>
</html>