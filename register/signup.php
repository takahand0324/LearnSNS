<?php
    session_start();

    date_default_timezone_set('Asia/Manila');

    // PHPプログラム
    $name = '';
    $email = '';
    $errors = [];
    //getにactionというキーが存在するか、そのactionの中にrewriteが存在するのか、check.phpから戻ってきているのかの確認
    if (isset($_GET['action']) && $_GET['action'] == 'rewrite'){
        $_POST['input_name'] = $_SESSION['register']['name'];
        $_POST['input_email'] = $_SESSION['register']['email'];
        $_POST['input_password'] = $_SESSION['register']['password'];

        $errors['rewrite'] = true;
    }

    if (!empty($_POST)){
        $name = $_POST['input_name'];
        $email = $_POST['input_email'];
        $password = $_POST['input_password'];

        // ユーザー名の空チェック
        // シングルクォーテーション''=空じゃなければ
        if ($name == ''){
            $errors['name'] = 'blank';
        }
        // ユーザー名の空チェック
        // シングルクォーテーション''=空じゃなければ
        if ($email == ''){
            $errors['email'] = 'blank';
        }

        if ($password == ''){
            $errors['password'] = 'blank';
        }
        $count = strlen($password);
        if ($password == ''){
            $errors['password'] = 'blank';
        }elseif ($count < 4 || 16 < $count){
            $errors['password'] = 'length';
        }
        //画像名を取得
        //undifined index連想配列が定義されていない
        //もしパラメーターが存在していなければ、ユーザーが送った画像が表示される。
        $file_name = '';
        if (!isset($_GET['action'])){
            $file_name = $_FILES['input_img_name']['name'];
        }
        //画像が送られてきた場合
        if (!empty($file_name)){
            $file_type = substr($file_name, -3);//画像名の後ろから3文字取得
            $file_type = strtolower($file_type);//大文字が含まれていた場合全て小文字化
            if ($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif'){
                $errors['img_name'] = 'type';
            }
            //拡張子チェックの処理
        }else{
            $errors['img_name'] = 'blank';
        }

        if (empty($errors)){
            $date_str = date('YmdHis');
            $submit_file_name = $date_str.$file_name;
            //ここで画像をアップデート先に移す
            move_uploaded_file($_FILES['input_img_name']['tmp_name'], '../user_profile_img/'.$submit_file_name);
            // $errorsが空だった場合はバリデーション成功
            //成功時の処理を記述する

            //セッションに変数を入れる

            $_SESSION['register']['name'] = $_POST['input_name'];
            $_SESSION['register']['email'] = $_POST['input_email'];
            $_SESSION['register']['password'] = $_POST['input_password'];
            $_SESSION['register']['img_name'] = $submit_file_name;

            header('Location: check.php');
            exit();
        }

    }
    // $hoge = '';
    // カラかどうかのチェック
    // (empty($hoge))
    // 変数が存在するかどうかのチェック
    // (isset($hoge))
    // empty = !isset
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Learn SNS</title>
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
    </head>
    <body style="margin-top: 60px">
        <div class="container">
            <div class="row">
                <!-- ここにコンテンツ -->
                <!-- ここから -->
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">アカウント作成</h2>
                <form method="POST" action="signup.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">ユーザー名</label>
                        <input type="text" name="input_name" class="form-control" id="name" placeholder="山田 太郎" value = "<?php echo htmlspecialchars($name); ?>">
                        <?php if (isset($errors['name']) && $errors['name'] == 'blank'):?>
                            <p class = "text-danger">ユーザー名を入力してください</p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com" value = "<?php echo htmlspecialchars($name); ?>">
                        <!-- issetは入っているかどうか -->
                        <?php if (isset($errors['email']) && $errors['email'] == 'blank'):?>
                            <p class = "text-danger">メールアドレスを入力してください</p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                        <?php if (isset($errors['password']) && $errors['password'] == 'blank'):?>
                            <p class = "text-danger">パスワードを入力してください</p>
                        <?php endif; ?>
                        <?php if (isset($errors['password']) && $errors['password'] == 'length'):?>
                            <p class = "text-danger">4 ~ 16文字のパスワードを入力してください</p>
                        <?php endif; ?>
                        <!-- もし$errorsが空じゃなければエラーメッセージを出力する -->
                        <?php if(!empty($errors)){ ?> <p class = "text-danger">パスワードを再度入力して下さい</p> <?php }?>
                    </div>
                    <div class="form-group">
                        <label for="img_name">プロフィール画像</label>
                        <input type="file" name="input_img_name" id="img_name" accept = "image/*">
                        <?php if (isset($errors['img_name']) && $errors['img_name'] == 'blank'){ ?>
                            <p class = "text-danger">画像を選択してください</p>
                        <?php } ?>
                        <?php if (isset($errors['img_name']) && $errors['img_name'] == 'type'){ ?>
                            <p class = "text-danger">拡張子が「jpg」「png」「gif」の画像を選択してください</p>
                        <?php } ?>
                    </div>
                    <input type="submit" class="btn btn-default" value="確認">
                    <a href="../signin.php" style="float: right; padding-top: 6px;" class="text-success">サインイン</a>
                </form>
            </div>
            <!-- ここまで -->

            </div>
        </div>
        <script src="../assets/js/jquery-3.1.1.js"></script>
        <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
        <script src="../assets/js/bootstrap.js"></script>
    </body>
</html>