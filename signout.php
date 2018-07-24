<?php
    session_start();

    //以下の２つがSESSIONを消す作業
    //①SESSION変数の破棄
    $_SESSION = [];

    //②サーバー内の$_SESSION変数のクリア
    session_destroy();

    //signin.phpへ移動
    header("Location: signin.php");
    exit();