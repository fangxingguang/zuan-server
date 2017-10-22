<?php
// 应用公共文件

//解析验证规则
function rulesToArr($rules){
    foreach ($rules as $key => $rule) {
        if (is_string($rule)) {
            $ruleArr = [];
            $rule = explode('|', $rule);
            foreach($rule as $item){
                if (strpos($item, ':')) {
                    list($subType, $subRule) = explode(':', $item, 2);
                    $ruleArr[$subType] = $subRule;
                }else{
                    $ruleArr[] = $item;
                }
            }
            $rule = $ruleArr;
        }
        $rules[$key] = $rule;
    }
    return $rules;
}

//数组查找合并
function listMerge($arr1,$arr2,$column1,$column2,$subKey){
    foreach($arr1 as $key1=>&$val1){
        foreach($arr2 as $val2){
            if($val1[$column1] == $val2[$column2]){
                $val1[$subKey] = $val2;
            }
        }
    }
    return $arr1;
}

//二维数组指定列当作key
function arrayKey($arr,$column){
    foreach($arr as $val){
        $newArr[$val[$column]] = $val;
    }
    return $newArr;
}

