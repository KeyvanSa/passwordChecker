<?php

class Core
{
    protected $controller = '';
    protected $method     = '';
    protected $params     = [];

    protected $path = "../app/api/";

    public function __construct()
    {
        $url = $this->getUrl();

        if(count($url)<1)
            sendRequest('خطا در ارسال پارامترهای ورودی');

        if(file_exists($this->path.ucwords($url[0]).'.php'))
        {
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        }else sendRequest('خطا در دریافت آدرس');

        require_once $this->path.$this->controller.'.php';
        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller,$url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }else sendRequest('خطا در پردازش تابع');
        }else sendRequest('خطا در پردازش تابع');

        $this->params = $url?array_values($url):[];

        call_user_func_array([$this->controller,$this->method],$this->params);
    }

    public function getUrl(): array|string
    {
        if(isset($_GET['url']))
        {
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            return explode('/',$url);
        }
        return '';
    }
}