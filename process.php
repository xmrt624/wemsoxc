<?php

include("_configs.php");

header("Access-Control-Allow-Origin: *");

$cru = srmtRoute();
if(empty($cru)) { http_response_code(400); exit(); }
$tvd = get_channel_detail($cru['id']);
if(empty($tvd)) { http_response_code(404); exit(); }
$BaseURL = extract_rel_baseurl($tvd['stream']['url']);

$actionHeader = array("User-Agent: ExoPlayer/2.4.2");

if($cru['path'] == "drmLicense")
{
    if($_SERVER['REQUEST_METHOD'] !== "POST"){ http_response_code(405); exit(); }
    if(empty($tvd['stream']['keys']) && empty($tvd['stream']['wv'])) {
        http_response_code(400);
        exit();
    }
    if(!empty($tvd['stream']['keys']))
    {
        if(db__statusM3Uplaylist("get", "") !== "ON") { http_response_code(404); exit(); }
        $eazyCK = explode(":", $tvd['stream']['keys']);
        $drmCKJSON = '{"keys":[{"kty":"oct","k":"'.clearkey__hextobase64($eazyCK[1]).'","kid":"'.clearkey__hextobase64($eazyCK[0]).'"}],"type":"temporary"}';
        header("Content-Type: application/json");
        print($drmCKJSON);
        exit();
    }
    if(!empty($tvd['stream']['wv']))
    {
        $drmapi = $tvd['stream']['wv'];
        $drmpayload = @file_get_contents("php://input");
        if(empty($drmpayload)) { exit("Error: DRM Payload Missing"); }
        $drmheader = array("Content-Type: application/octet-stream",
                           "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Firefox/99.0");
        $drmFetch = post_request($drmapi, $drmheader, $drmpayload);
        $drmdata = $drmFetch['data'];
        if($drmFetch['code'] == 200)
        {
            print($drmdata);
            exit();
        }
        else
        {
            http_response_code(307);
            header("Location: ".$drmapi);
            exit();
        }
        exit();
    }
}
elseif(stripos($cru['path'], ".mpd") !== false || stripos($cru['path'], "master.m3u8") !== false)
{
    $actionURL = $tvd['stream']['url'];
    if(isset($APP_CONFIG['OPTION_WORLDWIDE_MODE']) && $APP_CONFIG['OPTION_WORLDWIDE_MODE'] == "OFF") { 
	header("Location: ".$actionURL);
        exit();
    }
    $dfetch = get_request($actionURL, $actionHeader);
    $return = $dfetch['data'];
    if(stripos($return, "<mpd") !== false || stripos($return, "#EXTM3U") !== false)
    {
        print($return);
        exit();
    }
}
else
{
    $actionURL = $BaseURL.$cru['path'];
    $dfetch = get_request($actionURL, $actionHeader);
    $return = $dfetch['data'];
    if($dfetch['code'] == 200 || $dfetch['code'] == 206)
    {
        print($return);
        exit();
    }
}

//===========================================================//

function srmtRoute()
{
    $streamID = $streamPath = ""; $output = array();
    $path = $_SERVER['REQUEST_URI'];
    $aOpath = explode("livestream/", $path);
    if(isset($aOpath[1]) && !empty($aOpath[1]))
    {
        $ne8data = explode("/", $aOpath[1]);
        if(isset($ne8data[1]) && !empty($ne8data[1]))
        {
            $sfpth = "";
            if(isset($ne8data[0]) && !empty($ne8data[0])) { $streamID = trim($ne8data[0]); }
            array_shift($ne8data);
            foreach($ne8data as $l40) { $sfpth .= $l40."/"; }
            $sfpth = rtrim($sfpth, "/");
            if(!empty($sfpth)){ $streamPath = $sfpth; }
        }
    }
    return array("id" => $streamID, "path" => $streamPath);
}


?>