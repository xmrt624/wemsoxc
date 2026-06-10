<?php

error_reporting(0);

$APP_CONFIG['ADMIN_CREDS']['USERNAME'] = "";
$APP_CONFIG['ADMIN_CREDS']['PASSWORD'] = "";

$APP_CONFIG['OPTION_WORLDWIDE_MODE'] = "OFF"; //"ON" or "OFF"

$APP_CONFIG['APP_NAME'] = "Welive by WingyCodes";
$APP_CONFIG['APP_FAVICON'] = "assets/welive.png";
$APP_CONFIG['APP_LOGO'] = "assets/welive.png";

//==========================================================================//

date_default_timezone_set('Asia/Kolkata');

$APP_CONFIG['DATA_FOLDER'] = "__AppData__";
if(!isset($APP_CONFIG['DATA_FOLDER']) || empty($APP_CONFIG['DATA_FOLDER'])){ $APP_CONFIG['DATA_FOLDER'] = "__AppData__"; }
if(!is_dir($APP_CONFIG['DATA_FOLDER'])){ mkdir($APP_CONFIG['DATA_FOLDER']); }
if(!file_exists($APP_CONFIG['DATA_FOLDER']."/index.html")){ @file_put_contents($APP_CONFIG['DATA_FOLDER']."/index.html", ""); }
if(!file_exists($APP_CONFIG['DATA_FOLDER']."/.htaccess")){ @file_put_contents($APP_CONFIG['DATA_FOLDER']."/.htaccess", "deny from all"); }

$_SERVER['HTTP_HOST'] = strtok($_SERVER['HTTP_HOST'], ':'); $_SERVER['HTTP_HOST'] = str_ireplace('localhost', '127.0.0.1', $_SERVER['HTTP_HOST']);
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") { $streamenvproto = "https"; } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "https") { $streamenvproto = "https"; } else { $streamenvproto = "http"; } $plhoth = ($_SERVER['SERVER_ADDR'] !== "127.0.0.1") ? $_SERVER['HTTP_HOST'] : getHostByName(php_uname('n'));
if(isset($_SERVER['HTTP_CF_VISITOR']) && !empty($_SERVER['HTTP_CF_VISITOR'])){ $htcfs = @json_decode($_SERVER['HTTP_CF_VISITOR'], true); if(isset($htcfs['scheme']) && !empty($htcfs['scheme'])){ $streamenvproto = $htcfs['scheme']; }}

//==========================================================================//

function response($status, $message, $data)
{
    header("Content-Type: application/json");
    $respnx = array("status" => $status, "message" => $message, "data" => $data);
    print(json_encode($respnx));
    exit();
}

function encdec($action, $data)
{
  $output = ""; $ky = $iv = "8Oy4ZzMlCbggY1Yt";
  if($action == "encrypt") {
    $encrypted = openssl_encrypt($data, "AES-128-CBC", $ky, OPENSSL_RAW_DATA, $iv);
    if(!empty($encrypted)) { $output = bin2hex($encrypted); }
  }
  if($action == "decrypt")
  {
    if(strlen($data) % 2 == 0) {
      $dexBinary = hex2bin($data);
      $decrypted = openssl_decrypt($dexBinary, "AES-128-CBC", $ky, OPENSSL_RAW_DATA, $iv);
      if(!empty($decrypted)) { $output = $decrypted; }
    }
  }
  return $output;
}

function get_request($url, $headers)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if(!empty($headers)) { curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); }
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    if(!isset($info['url'])){ $info['url'] = $url; }
    $result = ['data' => $response, 'url' => $info['url'], 'code' => $info['http_code'], 'content_type' => $info['content_type'] ];
    return $result;
}

function post_request($url, $headers, $payload)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if(!empty($headers)) { curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); }
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    if(!isset($info['url'])){ $info['url'] = $url; }
    $result = ['data' => $response, 'url' => $info['url'], 'code' => $info['http_code'], 'content_type' => $info['content_type'] ];
    return $result;
}

function isHex($str)
{
    return preg_match('/^[0-9a-fA-F]+$/', $str);
}

function extract_uri_value($txt)
{
    $output = "";
    if(stripos($txt, 'URI="') !== false) {
        $zxa = explode('URI="', $txt);
        if(isset($zxa[1]) && stripos($zxa[1], '"') !== false)
        {
            $mae = explode('"', $zxa[1]);
            if(isset($mae[0]) && !empty($mae[0])) {
                $output = trim($mae[0]);
            }
        }
    }
    return $output;
}

function extract_rel_baseurl($url)
{
    if(stripos($url, "?") !== false){ $xrl = explode("?", $url); if(isset($xrl[0]) && !empty($xrl[0])){ $url = trim($xrl[0]); } }
    $url = str_replace(basename($url), "", $url);
    return $url;
}

function getcachedfile($file)
{
    $output = "";
    if(file_exists($file)) {
        $getf = @file_get_contents($file);
        if(!empty($getf))
        {
            $adata = json_decode($getf, true);
            if(isset($adata['exp']) && isset($adata['data']) && !empty($adata['exp']) && !empty($adata['data'])) {
                if(time() < $adata['exp']) { $output = $adata['data']; }
            }
        }
    }
    return $output;
}

function toggleCase($text) {
    $result = '';
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_upper($char)) {
            $result .= strtolower($char);
        } elseif (ctype_lower($char)) {
            $result .= strtoupper($char);
        } else {
            $result .= $char;
        }
    }
    return $result;
}

function hideinhtml($text)
{
    $text = base64_encode($text);
    $text = base64_encode($text);
    $text = strrev($text);
    $text = toggleCase($text);
    $text = str_replace("=", "", $text);
    return $text;
}

function streamtokenmaker($id)
{
    $mtime = time();
    return "vtoken=".md5($id."ohyes".$mtime)."-".$mtime;
}

function validatetokenz($id, $token)
{
    if(stripos($token, "-") !== false)
    {
        $ctime = $ctoken = "";
        $xtoken = explode("-", $token);
        if(isset($xtoken[0]) && !empty($xtoken[0])) { $ctoken = trim($xtoken[0]); }
        if(isset($xtoken[1]) && !empty($xtoken[1])) { $ctime = trim($xtoken[1]); }
        if(empty($_SERVER['HTTP_USER_AGENT']))
        {
            return false;
        }
        elseif(empty($ctoken))
        {
            return false;
        }
        elseif(empty($ctime) || !is_numeric($ctime))
        {
            return false;
        }
        else
        {
            $xbhash = md5($id."ohyes".$ctime);
            $exptime = $ctime + 300; //5 Minutes
            if(time() > $exptime)
            {
                return false;
            }
            elseif($ctoken !== $xbhash)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }
    else
    {
        return false;
    }
}

function clearkey__hextobase64($omo)
{
    return str_replace("=", "", base64_encode(hex2bin($omo)));
}

function clearkey__base64tohex($encodedWithoutPadding)
{
    $encodedWithoutPadding = str_replace(['-', '_'], ['+', '/'], $encodedWithoutPadding);
    $paddingNeeded = strlen($encodedWithoutPadding) % 4;
    if($paddingNeeded > 0) { $encodedWithoutPadding .= str_repeat("=", 4 - $paddingNeeded);  }
    $decodedBinary = base64_decode($encodedWithoutPadding);
    $hexString = bin2hex($decodedBinary);
    return $hexString;
}

//==========================================================================//

function db__htmlplayer($action, $data)
{
    global $APP_CONFIG;
    $output = "jw";
    $dataFile = $APP_CONFIG['DATA_FOLDER']."/html_Player.enc";
    if(file_exists($dataFile)) {
        $cumiData = @file_get_contents($dataFile);
        if(!empty($cumiData)) { $output = $cumiData; }
    }
    if($action == "get")
    {
        return $output;
    }
    if($action == "change")
    {
        if(file_put_contents($dataFile, $data)) {
            return true;
        } else {
            return false;
        }
    }
}

function db__statusM3Uplaylist($action, $data)
{
    global $APP_CONFIG;
    $output = "OFF";
    $dataFile = $APP_CONFIG['DATA_FOLDER']."/status_M3UPlaylist.enc";
    if(file_exists($dataFile)) {
        $cumiData = @file_get_contents($dataFile);
        if(!empty($cumiData)) { $output = $cumiData; }
    }
    if($action == "get")
    {
        return $output;
    }
    if($action == "change")
    {
        if(file_put_contents($dataFile, $data)) {
            return true;
        } else {
            return false;
        }
    }
}

function db__livetv($action, $data)
{
    global $APP_CONFIG;
    $ols_data = array();
    $cachePath = $APP_CONFIG['DATA_FOLDER']."/livetv_list.enc";
    if(file_exists($cachePath)) {
        $cbnData = @json_decode(@file_get_contents($cachePath), true);
        if(isset($cbnData[0])) {
            foreach($cbnData as $huK) { $ols_data[] = $huK; }
        }
    }
    //----------------------------------------------------------------//
    if($action == "list")
    {
        return $ols_data;
    }
    if($action == "detail_by_id")
    {
        $aOut = array();
        foreach($ols_data as $bYa) {
            if(md5($data) == md5($bYa['uid'])) {
                $aOut = $bYa;
            }
        }
        return $aOut;
    }
    if($action == "add")
    {
        $ols_data[] = $data;
        if(file_put_contents($cachePath, json_encode($ols_data))) {
            return true;
        }
        else {
            return false;
        }
    }
    if($action == "update")
    {
        $ntMoo = array();
        foreach($ols_data as $bYa)
        {
            if(md5($data['uid']) == md5($bYa['uid']))
            {
                $ntMoo[] = $data;
            }
            else
            {
                $ntMoo[] = $bYa;
            }
        }
        if(file_put_contents($cachePath, json_encode($ntMoo))) {
            return true;
        }
        else {
            return false;
        }
    }
    if($action == "delete")
    {
        $ntMoo = array();
        foreach($ols_data as $bYa) {
            if(md5($data) !== md5($bYa['uid'])) {
                $ntMoo[] = $bYa;
            }
        }
        if(file_put_contents($cachePath, json_encode($ntMoo))) {
            return true;
        }
        else {
            return false;
        }
    }
}

function data__channels()
{
    $btvdata = db__livetv("list", "");
    $uxe = array_reverse($btvdata);
    return $uxe;
}

function get_channel_detail($id)
{
    $output = array();
    $tvlist = data__channels();
    foreach($tvlist as $itv) {
        if(md5($id) == md5($itv['uid'])) {
            $output = $itv;
        }
    }
    return $output;
}

//==========================================================================//


class HunterObfuscator
{
    private $code;
    private $mask;
    private $interval;
    private $option = 0;
    private $expireTime = 0;
    private $domainNames = array();

    function __construct($Code, $html = false)
    {
        if ($html) {
            $Code = $this->cleanHtml($Code);
            $this->code = $this->html2Js($Code);
        } else {
            $Code = $this->cleanJS($Code);
            $this->code = $Code;
        }

        $this->mask = $this->getMask();
        $this->interval = rand(1, 50);
        $this->option = rand(2, 8);
    }

    private function getMask()
    {
        $charset = str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        return substr($charset, 0, 9);
    }

    private function hashIt($s)
    {
        for ($i = 0; $i < strlen($this->mask); ++$i)
            $s = str_replace("$i", $this->mask[$i], $s);
        return $s;
    }

    private function prepare()
    {
        if (count($this->domainNames) > 0) {
            $code = "if(window.location.hostname==='" . $this->domainNames[0] . "' ";
            for ($i = 1; $i < count($this->domainNames); $i++)
                $code .= "|| window.location.hostname==='" . $this->domainNames[$i] . "' ";
            $this->code = $code . "){" . $this->code . "}";
        }
        if ($this->expireTime > 0)
            $this->code = 'if((Math.round(+new Date()/1000)) < ' . $this->expireTime . '){' . $this->code . '}';
    }

    private function encodeIt()
    {
        $this->prepare();
        $str = "";
        for ($i = 0; $i < strlen($this->code); ++$i)
            $str .= $this->hashIt(base_convert(ord($this->code[$i]) + $this->interval, 10, $this->option)) . $this->mask[$this->option];
        return $str;
    }

    public function Obfuscate()
    {
		$rand = rand(0,99);
		$rand1 = rand(0,99);
        return "var _0xc{$rand}e=[\"\",\"\x73\x70\x6C\x69\x74\",\"\x30\x31\x32\x33\x34\x35\x36\x37\x38\x39\x61\x62\x63\x64\x65\x66\x67\x68\x69\x6A\x6B\x6C\x6D\x6E\x6F\x70\x71\x72\x73\x74\x75\x76\x77\x78\x79\x7A\x41\x42\x43\x44\x45\x46\x47\x48\x49\x4A\x4B\x4C\x4D\x4E\x4F\x50\x51\x52\x53\x54\x55\x56\x57\x58\x59\x5A\x2B\x2F\",\"\x73\x6C\x69\x63\x65\",\"\x69\x6E\x64\x65\x78\x4F\x66\",\"\",\"\",\"\x2E\",\"\x70\x6F\x77\",\"\x72\x65\x64\x75\x63\x65\",\"\x72\x65\x76\x65\x72\x73\x65\",\"\x30\"];function _0xe{$rand1}c(d,e,f){var g=_0xc{$rand}e[2][_0xc{$rand}e[1]](_0xc{$rand}e[0]);var h=g[_0xc{$rand}e[3]](0,e);var i=g[_0xc{$rand}e[3]](0,f);var j=d[_0xc{$rand}e[1]](_0xc{$rand}e[0])[_0xc{$rand}e[10]]()[_0xc{$rand}e[9]](function(a,b,c){if(h[_0xc{$rand}e[4]](b)!==-1)return a+=h[_0xc{$rand}e[4]](b)*(Math[_0xc{$rand}e[8]](e,c))},0);var k=_0xc{$rand}e[0];while(j>0){k=i[j%f]+k;j=(j-(j%f))/f}return k||_0xc{$rand}e[11]}eval(function(h,u,n,t,e,r){r=\"\";for(var i=0,len=h.length;i<len;i++){var s=\"\";while(h[i]!==n[e]){s+=h[i];i++}for(var j=0;j<n.length;j++)s=s.replace(new RegExp(n[j],\"g\"),j);r+=String.fromCharCode(_0xe{$rand1}c(s,e,10)-t)}return decodeURIComponent(escape(r))}(\"" . $this->encodeIt() . "\"," . rand(1, 100) . ",\"" . $this->mask . "\"," . $this->interval . "," . $this->option . "," . rand(1, 60) . "))";
    }

    public function setExpiration($expireTime)
    {
        if (strtotime($expireTime)) {
            $this->expireTime = strtotime($expireTime);
            return true;
        }
        return false;
    }

    public function addDomainName($domainName)
    {
        if ($this->isValidDomain($domainName)) {
            $this->domainNames[] = $domainName;
            return true;
        }
        return false;
    }

    private function isValidDomain($domain_name)
    {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name)
            && preg_match("/^.{1,253}$/", $domain_name)
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name));
    }

    private function html2Js($code)
    {
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s', 
            '/<!--(.|\s)*?-->/'
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
        $code = preg_replace($search, $replace, $code);
        $code = "document.write('" . addslashes($code . " ") . "');";
        return $code;
    }

    private function cleanHtml($code)
    {
        return preg_replace('/<!--(.|\s)*?-->/', '', $code);
    }

    private function cleanJS($code)
    {
        $pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
        $code = preg_replace($pattern, '', $code);
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/'
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
        return preg_replace($search, $replace, $code);
    }
}

?>