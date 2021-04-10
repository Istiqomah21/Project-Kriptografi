<?php

### ### ### ### ### ### VIGENERE ### ### ### ### ### ###
function encrypt($text, $key){
	$len_key=strlen($key);
    $len_text=strlen($text);
    $split_key=str_split(strtolower($key));
    $split_text=str_split(strtolower($text));
     
    $i=0;
    for($j=0;$j<$len_text;$j++){
        if ($i==$len_key){
            $i=0;
        }
        $split_key2[$j]=$split_key[$i];
        $i++;
    }

    for($k=0;$k<$len_text;$k++){
        $a=char_to_dec($split_key2[$k]);
        $b=char_to_dec($split_text[$k]);
        if (($a && $b)!=null){
            $i=$a+$b-1;
		    if ($i>26){
		        $i=$i-26;
		    }
		    $hasil[$k] = dec_to_char($i);
        } else {
            $hasil[$k] = $split_text[$k];
        }
    }
    return strtoupper(implode("",$hasil));
}


function decrypt($text, $key){
    $len_key=strlen($key);
    $len_text=strlen($text);
    $split_key=str_split(strtolower($key));
    $split_text=str_split(strtolower($text));
    
    $i=0;
    for($j=0;$j<$len_text;$j++){
        if ($i==$len_key){
            $i=0;
        }
        $split_key2[$j]=$split_key[$i];
        $i++;
    }

    for($k=0;$k<$len_text;$k++){
        $b=char_to_dec($split_key2[$k]);
        $a=char_to_dec($split_text[$k]);

        if (($a && $b)!=null){
        	$i=$a-$b+1;
		    if ($i<1){
		        $i=$i+26;
		    }
            $hasil[$k] = dec_to_char($i);
        } else {
            $hasil[$k] = $split_text[$k];
        }
    }
    return strtoupper(implode("",$hasil));
}

function char_to_dec($text){
	$i=ord($text);
    if ($i>=97 && $i<=122){
        return ($i-96);
    } else {
        return null;
    }
}

function dec_to_char($angka){
    if ($angka>=1 && $angka<=26){
        return (chr($angka+96));
    } else {
        return null;
    }
}
############ END OF VIGENERE ############
#########################################



############    PLAYFAIR    #############
function prepareText($s){
    $s = strtoupper($s);
	$s = str_replace("J", "I", $s);
    $s = preg_replace("/[^a-zA-Z]/", "", $s);
	return $s;  
}
function createTable($key) {
	$key = strrev(prepareText($key));
	$keyy = str_split($key);
	$s = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
    $arr = str_split($s);
	foreach ($keyy as $k) {
		$arr = array_diff($arr, array($k));
		array_unshift($arr, $k);
	}
    $hasil = array_chunk($arr,5);

    return $hasil;
}

function p_encrypt($text,$key) {
	$text = prepareText($text);
	$key = prepareText($key);
    $len = strlen($text);
    $arr = str_split($text);
    $z= "Z";
    for ($i=0;$i<$len;$i+=2) {
    	if ($arr[$i] == $arr[$i+1]){
            array_splice($arr, ($i+1), 0, $z);
            $text = implode("",$arr);
            $len = strlen($text);
        }else if($i==$len-1){
        	if($len%2==1){
            	array_push($arr, $z);
    		}
    	} 
    }

        return codec(implode("",$arr), $key, 1);
}

function p_decrypt($text,$key) {
	$text = prepareText($text);
	$key = prepareText($key);
	$len = strlen($text);
    $arr = str_split($text);
	$z= "Z";
    for ($i=0;$i<$len;$i+=2) {
    	if ($arr[$i] == $arr[$i+1]){
            array_splice($arr, ($i+1), 0, $z);
            $text = implode("",$arr);
            $len = strlen($text);
        }else if($i==$len-1){
        	if($len%2==1){
            	array_push($arr, $z);
    		}
    	} 
    }
    return codec(implode("",$arr), $key, 4);
}

function codec($text,$key,$dir) {
    $len = strlen($text);
    $arr_text = str_split($text);
    $arr_key = createTable($key);

    for ($i=0; $i<$len-1; $i+=2){
        $a = $arr_text[$i];
        $b = $arr_text[$i+1];

        for($j=0;$j<5;$j++){
            if(in_array($a,$arr_key[$j])){
                $key = array_search($a, $arr_key[$j]);
                $row1 = $j;
                $col1 = $key;
            }

            if(in_array($b,$arr_key[$j])){
                $key = array_search($b, $arr_key[$j]);
                $row2 = $j;
                $col2 = $key;
            }
        }

        if($row1==$row2){
            $col1 = ($col1 + $dir) % 5;
            $col2 = ($col2 + $dir) % 5;
        }else if($col1==$col2) {
            $row1 = ($row1 + $dir) % 5;
            $row2 = ($row2 + $dir) % 5;

        } else {
            $tmp = $col1;
            $col1 = $col2;
            $col2 = $tmp;
        }
        
        $arr_text[$i] = $arr_key[$row1][$col1];
        $arr_text[$i+1] = $arr_key[$row2][$col2];
    }

    return implode("",$arr_text);
}
############ END OF VIGENERE ############
#########################################
?>