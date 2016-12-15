<?php
    
    /**
     * 浏览器友好的变量输出
     * @param mixed $var 变量
     * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
     * @param string $label 标签 默认为空
     * @param boolean $strict 是否严谨 默认为true
     * @return void|string
     */
    function obj_dump($var, $echo=true, $label=null, $strict=true) {
        $label = ($label === null) ? '' : rtrim($label) . ' ';
        if (!$strict) {
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = $label . print_r($var, true);
            }
        } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (!extension_loaded('xdebug')) {
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            return null;
        }else
            return $output;
    }

    /**
     * 格式化打印
     * @param  [必需] Object  array       要打印的对象
     */
    function p($array){
        obj_dump( $array, 1, '<pre>', 0);
    }

    /**
     * 格式化日期
     * @param  [type] $time [description]
     * @return [type]       [description]
     */
    function format_date($time) {
        $nowtime = time();
        $difference = $nowtime - $time;
        switch ($difference) {
            case $difference <= '60' :
                $msg = '刚刚';
                break;
            case $difference > '60' && $difference <= '3600' :
                $msg = floor($difference / 60) . '分钟前';
                break;
            case $difference > '3600' && $difference <= '86400' :
                $msg = floor($difference / 3600) . '小时前';
                break;
            case $difference > '86400' && $difference <= '2592000' :
                $msg = floor($difference / 86400) . '天前';
                break;
            case $difference > '2592000' &&  $difference <= '7776000':
                $msg = floor($difference / 2592000) . '个月前';
                break;
            case $difference > '7776000':
                $msg = '很久以前';
                break;
        }
        return $msg;
    }

    /**
     * 安全合并数组
     * @param  [type] $args [description]
     * @return [type]       [description]
     */
    function safe_array_merge(){
        $args = func_get_args();
        foreach ($args as $key => $item) {
            if(count($item) == 0){
                continue;
            }
            if($data){  
                $data = array_merge($data,$item);            
            }else{
                $data = $item;
            }
        }
        return $data;
    }