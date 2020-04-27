<?php
    define('HOST','127.0.0.1');
    define('HOSTNAME','root');
    define('PSW','root');
    define('DB','baishow');
    define('PORT',3306);
    function my_query($sql){
        $link=@mysqli_connect(HOST,HOSTNAME,PSW,DB,PORT);
        if(!$link){
            echo '数据库未连接成功';
            echo mysqli_error($link);
            return false;
        }
        $res=mysqli_query($link,$sql);
        $arr=[];
        if($res){
            while($row=mysqli_fetch_assoc($res)){
                $arr[]=$row;
            }
            return $arr;
        }else{
            echo '查询失败';
            echo mysqli_error($link);
            return false;
        }
    }
    function my_edit($sql){
        $link=@mysqli_connect(HOST,HOSTNAME,PSW,DB,PORT);
        if(!$link){
            echo '数据库未连接成功';
            echo mysqli_error($link);
            return false;
        }
        if(!mysqli_query($link,$sql)){
            echo '操作失败';
            echo mysqli_error($link);
            return false;
        }
    }
?>