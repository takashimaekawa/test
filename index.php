<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<div class="result">
    <form id="form_1" method="post" accept-charset="utf-8" return false>
        <p>社員NO <input type="text" name = "userid" id ="userid"> </p>
        <p>パスワード <input type="text" name = "passward" id="passward"> </p>
    </form>

    <button id="send">login</button>
</div>

    <script type="text/javascript">

        $(function(){
            // Ajax button click
            $('#send').on('click',function(){
                $.ajax({
                    url:'request.php',
                    type:'POST',
                    data:{
                        'userid':$('#userid').val(),
                        'passward':$('#passward').val()
                    }
                })
                // Ajaxリクエストが成功した時発動
                .done( (data) => {
                    $('.result').html(data);
/*
                    if(data === '1') {
                       alert("管理者");
                        $('.result').html(data); 
                    }else if(data === '0'){
                       alert("ユーザ");
                    }else if(data == "再受験不可"){
                        alert("再受験不可");
                    }else{
                        alert('社員番号かパスワードが間違っています');
                        $('.result').html(data);
                    }
*/

                })
                // Ajaxリクエストが失敗した時発動
                .fail( (data) => {
               //     $('.result').html(data);
                    alert(data);
                })
                // Ajaxリクエストが成功・失敗どちらでも発動
                .always( (data) => {

                });
            });
        });

    </script>
</body>
</html>