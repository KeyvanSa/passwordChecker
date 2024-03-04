<?php

use JetBrains\PhpStorm\NoReturn;

class checkPassword
{
    #[NoReturn]
    public function generation()
    {
        $len         =getData('length');
        $useNumbers  =getData('useNumbers');
        $useUppercase=getData('useUppercase');
        $useLowercase=getData('useLowercase');
        $useSymbols  =getData('useSymbols');

        if(empty($len) || $len < 8)
            $len = 8;

        $sets = array();
        if($useUppercase=='true')
            $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($useLowercase=='true')
            $sets[] = 'abcdefghijkmnopqrstuvwxyz';
        if($useNumbers=='true')
            $sets[] = '0123456789';
        if($useSymbols=='true')
            $sets[]  = '~!@#$%^&*(){}[],./?';

        if(empty($sets))
            sendRequest('باید یک از موارد عدد،حروف بزرگ،حروف کوچک یا نمادها را انتخاب کنید');

        $password = '';

        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }

        while(strlen($password) < $len) {

            $randomSet = $sets[array_rand($sets)];

            $password .= $randomSet[array_rand(str_split($randomSet))];
        }

        $json['status'] = 'ok';
        $json['message']= '';
        $json['data']   = ["password"=>str_shuffle($password)];
        sendRequest(null,$json);
    }

    #[NoReturn]
    public function check()
    {
        $password = getData('password');

        $score = 0;
        $error = '';

        if ( empty($password) ) sendRequest('یک رمز ارسال کنید');

        $password = cleanData($password);
        str_replace('%','\%',$password);

        $passwordLength   = strlen($password) >= 8;
        $containNumber    = preg_match("#[0-9]+#",$password);
        $containLowerCase = preg_match("#[a-z]+#",$password);
        $containUpperCase = preg_match("#[A-Z]+#",$password);
        $containSymbol    = preg_match('/\W/',$password);

        $error = 'رمز با موفقیت ساخته شد';

        if (!$passwordLength) {
            $error = "رمز باید حداقل 8 کاراکتر باشد";
        }else $score += 20;

        if(!$containNumber && $passwordLength) {
            $error = "رمز باید حداقل شامل یک عدد باشد";
        }else $score += 20;

        if(!$containUpperCase && $containNumber && $passwordLength) {
            $error = "رمز باید حداقل شامل یک حرف بزرگ باشد";
        }else $score += 20;

        if(!$containLowerCase && $containUpperCase && $containNumber && $passwordLength) {
            $error = "رمز باید حداقل شامل یک حرف کوچک باشد";
        }else $score += 20;

        if(!$containSymbol && $containLowerCase && $containUpperCase && $containNumber && $passwordLength) {
            $error = "رمز باید حداقل شامل یک نماد باشد";
        }else $score += 20;

        $json['status'] = 'ok';
        $json['message']= $error;
        $json['data']   = ["password"=>$password,"score"=>$score,"max_score"=>100];
        sendRequest(null,$json);
    }

}