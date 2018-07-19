<?php

    //配列
    //$array = [1,2,3];
    //arryを出力するときは、print_rを使う
    //print_r($array);

    //連想配列
    //$array =  [
        //"banana" => "バナナ"
        //];
    //print_r($array["banana"]);


    //二次配列
    //以下の場合は、ringoという配列の中の、$hogeの中の、jaを取り出している
    $hoge = ['ja' => 'りんご', 'us' => 'apple'];
    $array = ["ringo" => $hoge];

    ///2次配列に上書きする場合
    //$array["ringo"]["ja"] = "バナナ";
    print_r($array["ringo"]);