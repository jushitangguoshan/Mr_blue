<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h2>hello world!!!</h2>
</body>
</html>
<?php
$filename = date("d").".txt";
$date = "static/total/".date("Y/m/d");
if( !file_exists($date."/".$filename) ){
    if(!is_dir($date)) {
        if (!mkdir($date, 0777, true)) {
            echo "创建失败";
            exit;
        }
    }
    if($fp=fopen($date."/".$filename,'w')){
        $arr = [];
        $time = (time()-3600*25);
        $arr = [[['ip'=>$_SERVER["REMOTE_ADDR"],'number'=>1,'time'=>$time]],'total'=>1];
        $obj = serialize($arr);
        fwrite($fp,$obj);
        fclose($fp);
    }else{
        echo "<br>创建失败 ";
    }
}else{
    $array = unserialize(file_get_contents($date."/".$filename));
    $num = $array[0];
    $count = count($num);
    $start = strtotime(date("Y-m-d 00:00:00"));
    $end = strtotime(date("Y-m-d 00:00:00",time()+3600*24*1));
    for($i=0;$i<$count;$i++){
        if($_SERVER['SERVER_ADDR'] == $num[$i]['ip']){
            exit;
        }
    }
    $arr = [];
    $time = time();
    $total = $array['total']+1;
    $arr = ['ip'=>$_SERVER['REMOTE_ADDR'],'number'=>1,'time'=>$time];
    array_push($array[0],$arr);
    $array['total'] = $total;
    $obj = serialize($array);
    file_put_contents($date."/".$filename,$obj);
    echo "插入成功";
}
?>