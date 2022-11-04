<?php
function make_slug($string) {
    return preg_replace('/\s+/u', '-', trim($string));
}



function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
function setting(){
    $options=\App\Models\Setting::all();
    $setting = array();
    foreach ($options as $option) {
        $name = $option['setting'];
        $value = $option['value'];
        $setting[$name] = $value;
    }
    return $setting;
}
/*function theme_name(){
    $setting = \App\Setting::where('setting', 'theme')->first();
    return '.'.$setting->orgv.'.';
}*/
function zarinpal_client(){
    $setting = \App\Models\Setting::where('setting', 'zarinpal_client')->first();
    return $setting->value;
}

function MerchantID_zarinpal(){
    $setting = \App\Models\Setting::where('setting', 'MerchantID_zarinpal')->first();
    return $setting->value;
}
function SMS($pattern=null,$mobile=null,$text=null){
    $user = \App\Models\Setting::where('setting', 'username_sms')->first();
    $pass = \App\Models\Setting::where('setting', 'password_sms')->first();
    $username=$user->value;
    $password=$pass->value;
    $from = "+983000505";
    $pattern_code = $pattern;
    $to = array($mobile);
    $input_data = array("verification-code" => $text);
    $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
    $handler = curl_init($url);
    curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handler);
}

function application_installed()
{
    return file_exists(storage_path('installed'));
}
