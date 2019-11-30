<?php

namespace App\Logic;

class WeChatLogic
{
    public $apiTicket = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=';
    public $apiQrcode = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';


    /**
     * QR_SCENE             为临时的整型参数值
     * QR_STR_SCENE         为临时的字符串参数值
     * QR_LIMIT_SCENE       为永久的整型参数值
     * QR_LIMIT_STR_SCENE   为永久的字符串参数值
     * @param array $data ['action_name' => 'QR_STR_SCENE','expire_seconds' => 2592000,'scene_str' => 'EC_'.$id]
     * @param string $dir_name 保存的文件夹名
     * @param string|bool $logo logo url
     * @return mixed
     */
    public function getTicket($data, $dir_name = 'extend_code', $logo = false)
    {
        $at = $this->access_token();
        $param = [
            'action_name' => $data['action_name'],
            'action_info' => ['scene' => []]
        ];
        if ($data['action_name'] == 'QR_SCENE') {
            $param['expire_seconds'] = $data['expire_seconds'];
            $param['action_info']['scene']['scene_id'] = $data['scene_id'];
        } elseif ($data['action_name'] == 'QR_STR_SCENE') {
            $param['expire_seconds'] = $data['expire_seconds'];
            $param['action_info']['scene']['scene_str'] = $data['scene_str'];
        } elseif ($data['action_name'] == 'QR_LIMIT_SCENE') {
            $param['action_info']['scene']['scene_id'] = $data['scene_id'];
        } elseif ($data['action_name'] == 'QR_LIMIT_STR_SCENE') {
            $param['action_info']['scene']['scene_str'] = $data['scene_str'];
        }
        $url = $this->apiTicket . $at;
        $response = $this->post($url, json_encode($param));
        $response = json_decode($response, true);
        if (isset($response['errcode'])) {
            $res['state'] = false;
            $res['msg'] = $response['errmsg'];
            $res['data'] = $response;
        } else {
            // 保存二维码
            $sence = !empty($data['scene_id']) ? $data['scene_id'] : $data['scene_str'];
            if ($logo === false) {
                $response['filepath'] = $this->mark($this->apiQrcode . $response['ticket'], $sence, $dir_name);
            } else {
                $response['filepath'] = $this->customMark($this->apiQrcode . $response['ticket'], $sence, $dir_name, $logo);
            }
            $res['state'] = true;
            $res['msg'] = 'ok';
            $res['data'] = $response;
        }
        return $res;
    }

    // 获取access_token
    public function access_token()
    {
        $res = $this->get(env('API_URL') . '/getToken');
        $res = json_decode($res, true);
        if (isset($res['result']['access_token'])) {
            return $res['result']['access_token'];
        } else {
            var_dump($res);
            exit;
        }
    }

    public function get($url = '')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    /**
     * POST 请求
     * @param string $url
     * @param array|string $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    public function post($url, $param, $post_file = false)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }

        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        $data = json_decode($strPOST);
        if ($data && (is_object($data)) || (is_array($data) && !empty(current($data)))) {
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8'
                )
            );
        }
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);

        curl_close($oCurl);

        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * 添加水印logo
     *
     * @param string $qr_url 带参数二维码接口拼接的url
     * @param string $sence 参数
     * @param string $dirname 保存的文件夹名
     * @return bool|string
     */
    public function mark($qr_url, $sence, $dirname)
    {
        // 相对路径
        $path = config('filesystems.disks.qrcode.path') . $dirname . '/';
        // 绝对路径
        $root = config('filesystems.disks.qrcode.root');
        $logo = $root . '../logo.png';
        $root .= $dirname . DIRECTORY_SEPARATOR;
        if (!is_dir($root)) {
            mkdir($root, 755);
        }
        $filename = $sence . '.png';
        if (is_file($logo)) {
            $QR = imagecreatefromstring(file_get_contents($qr_url));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);
            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
            imagepng($QR, $root . $filename);

            // 返回相对路径
            return $path . $filename;
        }
        return false;
    }

    /**
     * 自定义添加水印logo
     *
     * @param string $qr_url 带参数二维码接口拼接的url
     * @param string $sence 参数
     * @param string $dirname 保存的文件夹名
     * @param string $logo logo url
     * @param bool $isWxUrl $qr_url是否是微信url
     * @return bool|array
     */
    public function customMark($qr_url, $sence, $dirname, $logo, $isWxUrl = true)
    {
        // 相对路径
        $path = config('filesystems.disks.qrcode.path') . $dirname . '/';
        // 绝对路径
        $root = config('filesystems.disks.qrcode.root');
//        $logo = $root . '../logo.png';
        $root .= $dirname . DIRECTORY_SEPARATOR;
        if (!is_dir($root)) {
            mkdir($root, 755);
            chmod($root, 755);
        }

        // 原图url
        $filename = $sence . '.png';
        $code_url = $path . $filename;
        if ($qr_url) {
            if (!$isWxUrl) { // 直接根据内容生成二维码
                require_once dirname(__FILE__) . '/../Libs/phpqrcode.php';
                $errorCorrectionLevel = 'L';    // 容错级别
                $matrixPointSize = 10;   // 生成图片大小
                \QRcode::png($qr_url, $root . $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                $qr_url = env('APP_URL') . $path . $filename;
            }
            $QR = imagecreatefromstring(file_get_contents($qr_url));
            imagepng($QR, $root . $filename);
        } else {
            if (is_file(public_path($code_url))) {
                $QR = imagecreatefromstring(file_get_contents(public_path($code_url)));
            } else {
                return ['code_url' => '', 'logo_code_url' => ''];
            }
        }

        // 带logo的图片
        $logo_code_url = '';
        if ($logo) {
            $filename = $sence . '@logo.png';
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);
            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
            imagepng($QR, $root . $filename);
            // 带logo的url
            $logo_code_url = $path . $filename;
        }

        return ['code_url' => $code_url, 'logo_code_url' => $logo_code_url];
    }
}