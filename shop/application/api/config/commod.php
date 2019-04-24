<?php
/**
 * 公共的函数
 * User: Administrator
 * Date: 2019/4/10 0010
 * Time: 13:58
 */
/**
 * 引用算法
 */
function generateTree($array){
    //第一步 构造数据
    $items = array();
    foreach($array as $value){
        $items[$value['id']] = $value;
    }
    //第二部 遍历数据 生成树状结构
    $tree = array();
    foreach($items as $key => $item){
        if(isset($items[$item['pid']])){
            $items[$item['pid']]['son'][] = &$items[$key];
        }else{
            $tree[] = &$items[$key];
        }
    }
    return $tree;
}
function addressTree($array){
    //第一步 构造数据
    $items = array();
    foreach($array as $value){
        $items[$value['area_id']] = $value;
    }
    //第二部 遍历数据 生成树状结构
    $tree = array();
    foreach($items as $key => $item){
        if(isset($items[$item['area_parent_id']])){
            $items[$item['area_parent_id']]['son'][] = &$items[$key];
        }else{
            $tree[] = &$items[$key];
        }
    }
    return $tree;
}

function chinaTree($array){
    //第一步 构造数据
    $items = array();
    foreach($array as $key => $val){
        if( $val['pid'] == '0' ){
            $items[] = $val;
        }else{
            foreach($items as $k => $v){
                if($val['pid'] == $v['id']){
                    $items[$k]["son"][] = $val;
                }else{
                    foreach($v['son'] as $kk => $vv){
                        if($v['son'][$kk]['id'] == $val["pid"]){
                            $items[$k]["son"][$kk]["son"][] = $val;
                        }
                    }
                }
            }
        }
    }
    return $items;
}

function goodsList($array){
    $arr = [];
    foreach($array as $key => $val){
        $arr[$val['category_id']][] = $val;
    }
    return $arr;
}
