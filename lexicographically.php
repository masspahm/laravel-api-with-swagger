<?php
$data = ["11","12","cii","001","2","1998","7","89","iia","fii"];
$str = array_filter($data,function($v){
    if (is_numeric($v)) {
        return false;
    }
    return true;
});
$str = array_values($str);

function get_all_substrings($input) {
    $arr = str_split($input);
    $out = array();
    for ($i = 0; $i < count($arr); $i++) {
        for ($j = $i; $j < count($arr); $j++) {
            $out[] = implode(array_slice($arr, $i, $j - $i + 1));
        }       
    }
    return $out;
}
print_r($str);
for ($i=0; $i < count($str); $i++) { 
    $subs = get_all_substrings($str[$i]);
    print_r($subs);
}

?>