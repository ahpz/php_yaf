<?php
/**
 * Filename: PluginApiUtil.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 19:57
 **/
class Validate_PluginApiUtil
{
    public static $mbEncoding = 'UTF-8';

    /**
     * 储型 xss 攻击过滤函数 （能够解决 存储 和 显示类别的xss攻击 前端页可以解决直接的xss攻击)
     * @param $val
     * @return mixed
     */
    public static function RemoveXSS($val)    {
        //$val = trim($val);
        $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search.= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search.= '1234567890!@#$%^&*()';
        $search.= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
            $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
        }
        //黑名单，其中为存在攻击隐患的字符，可被用于引入HTML标记或者加载脚本代码
        $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        //黑名单，其中为js的事件处理函数名
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);
        $found = true;
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                        $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                        $pattern .= ')?';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
                $val = preg_replace($pattern, $replacement, $val);
                if ($val_before == $val) {
                    $found = false;
                }
            }
        }
        return $val;
    }

    /**
     * 检查数字大小范围
     * @param int $value
     * @param int $min
     * @param int $max
     * @return bool
     */
    public static function checkIntRange($value, $min, $max)
    {

        return ctype_digit((string)$value) && $value>=$min && $value<=$max;
    }
    /**
     * 检查字符串的长度范围
     *
     * @param string $str
     * @param int    $min
     * @param int    $max
     * @return bool
     */
    public static function checkStrlenRange($str, $min, $max)
    {
        $len = mb_strlen($str, self::$mbEncoding);
        return $len>=$min && $len<=$max;
    }

    /**
     * 检查字符串是否符合url格式，并且长度小于max Len
     * @param string $url
     * @param int    $maxLen
     * @return bool
     */
    public static function checkUrlWithLen($url, $maxLen)
    {
        return Utils_CheckUtils::is_valid_url($url) && self::checkStrlenMax($url, $maxLen);
    }

    /**
     *
     * 检查字符串是不是合法的ip
     *
     * @param string $ip
     * @return bool
     */
    public static function checkIp($ip = '')
    {
        if(!is_string($ip))
        {
            return false;
        }
        //\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]
        //1位数字、非0开头2位数字、1开头3位数字、255以下3位数字
        //?:表示括号()内的内容不需要被捕获，可以提供正则运行速度
        if(preg_match('/^(?:\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(?:\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(?:\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(?:\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])$/', $ip))
        {
            return true;
        }

        return false;
    }

    /**
     * 返回给出的字段一维数组
     *
     * @param  array $arr    原始数据，例如 array('app_id' => '111', 'xxx' => 'x');
     * @param  array $fields 一维数组，例如 array('app_id', 'app_name');
     * @return array e.g array('app_id' => '111', 'app_name' => '');
     */
    public static function fieldsFilter(Array $arr, Array $fields)
    {
        if (empty($fields))
        {
            return $arr;
        }
        $result = array();
        foreach ($fields as $field)
        {
            $result[$field] = isset($arr[$field]) ? $arr[$field] : '';
        }
        return $result;
    }

    /**
     * 过滤掉不不需要的字段
     *
     * @param array $input
     * @param array $keys
     *
     * @return array
     */
    public static function fieldFilter(Array $input, Array $need_keys)
    {
        if(empty($input) || empty($need_keys))
        {
            return array();
        }

        $keys = array_keys($input);
        foreach($keys as $key)
        {
            if(!in_array($key, $need_keys)){
                unset($input[$key]);
            }
        }
        return $input;
    }

    /**
     * 检查字符串是否符合email格式，并且长度小于maxLen
     * @param string $email
     * @param int    $maxLen
     * @return bool
     */
    public static function checkEmail($email='')
    {
        return Utils_CheckUtils::is_valid_email($email);
    }

    /**
     *
     * 检查字符串是不是合法的手机号码
     *
     * @param string $mobile
     * @return bool
     */
    public static function checkMobile($mobile = '')
    {
        if(!is_string($mobile))
        {
            return false;
        }

        if(preg_match('/^1[34578]\d{9}$/',$mobile))
        {
            return true;
        }

        if(preg_match('/^\([1-9]\d{0,3}\)\d{8,13}$/',$mobile))
        {
            return true;
        }

        return false;
    }

    /**
     * 校验订单所属年份是否合法
     * @param int $year
     * @return bool
     */
    public static function checkOrderYear($year)
    {
        if (! ctype_digit($year))
        {
            return false;
        }
        $this_year = date("Y");
        if ($year > $this_year || $year < 2014)
        {
            //订单最早是2014年的
            return false;
        }
        return true;
    }

    /**
     * 检测是否为json
     *
     * @param string $str
     * @return boolean
     */
    public static function checkJson($str)
    {
        if (!is_string($str))
        {
            return false;
        }
        $data = json_decode($str, true);
        if (!is_array($data))
        {
            return false;
        }
        return true;
    }

}