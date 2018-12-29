<?php
header('Content-type: text/plain; charset= UTF-8');
    if(isset($_POST['userid']) && isset($_POST['passward'])){
        $id = $_POST['userid'];
        $pas = $_POST['passward'];
       
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=privacymark_test;charset=utf8','root','pass',
            array(PDO::ATTR_EMULATE_PREPARES => false));

            } catch (PDOException $e) {
             exit('データベース接続失敗。'.$e->getMessage());
            }
        
        $sql = 'select section_id,authority,emp_number,user_name,reexamination_flag from m_user where emp_number = ? AND password = ? AND delete_flag = 0';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id, $pas));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $sectionId = $result['section_id'];
        $authority = $result['authority'];
        $empNumber = $result['emp_number'];
        $userName = $result['user_name'];
        $reexaminationFlag = $result['reexamination_flag'];

        if($reexaminationFlag === 1){
            echo "再受験不可";
            exit();
        }

        if($authority === 1){
            //POSTで送りたいデータ
            $query = array(
                'emp_number' => $empNumber,
                'section_id' => $sectionId,
                'emp_number' => $empNumber,
                'user_name'  => $userName,
                'authority'  => $authority
            );
 
            //URLエンコードされたクエリ文字列を生成
            $content = http_build_query($query, '', '&');
 
            //ヘッダ設定
            $header = array(
                    'Content-Type: application/x-www-form-urlencoded', //form送信の際、クライアントがWebサーバーに送信するコンテンツタイプ
                    'Content-Length: '.strlen($content) //メッセージ本文の長さ
            );
 
            //ストリームコンテキスト設定
            $context = array(
                'http' => array(
                'ignore_errors' => true, //ステータスコードが失敗を意味する場合でもコンテンツを取得
                'method' => 'POST', //メソッド。デフォルトはGET
                'header' => implode("\r\n", $header), //ヘッダ設定
                'content' => $content //送信したいデータ
                )
            );

            //めっちゃはまったところurlはフルパス　証明書を無効にする
            $url = 'https://localhost/test/question.php';
            $context['ssl']['verify_peer']=false;
            $context['ssl']['verify_peer_name']=false;
            $res = file_get_contents($url, false, stream_context_create($context));

            if($res == false){
                echo "ファイルの読み込みに失敗";
            }else{
                echo  $res;
            }

        }else if($authority === 0){
            echo $authority;
        }else{
            echo "alert('社員番号かパスワードが間違っています');";
        }

    }else{
        echo 'システムエラー';
    }

?>