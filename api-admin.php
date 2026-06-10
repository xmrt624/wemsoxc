<?php

session_start();
include("_configs.php");

$action = "";
if(isset($_REQUEST['action'])) {
    $action = trim($_REQUEST['action']);
}

//================================================================//

if($action == "logout")
{
    session_destroy();
    response("success", "Logged Out Successfully", "");
}
else
{
    if(!isset($_SESSION['WELIVE_ADMIN']) || $_SESSION['WELIVE_ADMIN'] !== "TRUE") {
        response("error", "Access Denied", "");
    }

    if($action == "add_live_tv" || $action == "update_live_tv")
    {
        $vc__uid = ""; $vc__title = ""; $vc__logo = ""; $vc__genre = "";
        $vc__language = ""; $vc__streamurl = ""; $vc__widevine = "";
        $vc__clearkey = ""; $vc__clearkey_id = ""; $vc__clearkey_key = "";
        $vc__makekey = "";
        if(!empty($_REQUEST['uid'])) { $vc__uid = trim(strip_tags($_REQUEST['uid'])); }
        if(!empty($_REQUEST['title'])) { $vc__title = trim(strip_tags($_REQUEST['title'])); }
        if(!empty($_REQUEST['logo'])) { $vc__logo = trim(strip_tags($_REQUEST['logo'])); }
        if(!empty($_REQUEST['genre'])) { $vc__genre = trim(strip_tags($_REQUEST['genre'])); }
        if(!empty($_REQUEST['language'])) { $vc__language = trim(strip_tags($_REQUEST['language'])); }
        if(!empty($_REQUEST['streamurl'])) { $vc__streamurl = trim(strip_tags($_REQUEST['streamurl'])); }
        if(!empty($_REQUEST['widevine'])) { $vc__widevine = trim(strip_tags($_REQUEST['widevine'])); }
        if(!empty($_REQUEST['clearkey'])) { $vc__clearkey = trim(strip_tags($_REQUEST['clearkey'])); }
        if(!empty($_REQUEST['clearkey_id'])) { $vc__clearkey_id = trim(strip_tags($_REQUEST['clearkey_id'])); }
        if(!empty($_REQUEST['clearkey_key'])) { $vc__clearkey_key = trim(strip_tags($_REQUEST['clearkey_key'])); }
        $vc__title = base64_decode(base64_decode($vc__title));
        $vc__logo = base64_decode(base64_decode($vc__logo));
        $vc__streamurl = base64_decode(base64_decode($vc__streamurl));
        $vc__widevine = base64_decode(base64_decode($vc__widevine));
        $vc__clearkey = base64_decode(base64_decode($vc__clearkey));
        if($action == "update_live_tv")
        {
            if(empty($vc__uid)) {
                response("error", "Asset Identifier Missing", "");
            }
            $chUDb = db__livetv("detail_by_id", $vc__uid);
            if(empty($chUDb)) {
                response("error", "Asset Does Not Exist", "");
            }
        }
        if(empty($vc__title)) {
            response("error", "Please Enter Title", "");
        }
        if(empty($vc__genre)) {
            response("error", "Please Enter Genre", "");
        }
        if(empty($vc__language)) {
            response("error", "Please Enter Language", "");
        }
        if(empty($vc__streamurl)) {
            response("error", "Please Enter Stream URL", "");
        }
        if(!empty($vc__clearkey_id) && empty($vc__clearkey_key)) {
            response("error", "Please Enter Clear Key", "");
        }
        if(empty($vc__clearkey_id) && !empty($vc__clearkey_key)) {
            response("error", "Please Enter Clear Key ID", "");
        }
        if(!empty($vc__clearkey_id) && !empty($vc__clearkey_key))
        {
            if(!isHex($vc__clearkey_id)) { $vc__clearkey_id = clearkey__base64tohex($vc__clearkey_id); }
            if(!isHex($vc__clearkey_key)) { $vc__clearkey_key = clearkey__base64tohex($vc__clearkey_key); }
            $vc__makekey = $vc__clearkey_id.":".$vc__clearkey_key;
        }
        $tvpayld = array();
        $tvpayld['modifiedTime'] = time();
        $tvpayld['title'] = $vc__title;
        $tvpayld['logo'] = $vc__logo;
        $tvpayld['genre'] = $vc__genre;
        $tvpayld['language'] = $vc__language;
        $tvpayld['stream']['url'] = $vc__streamurl;
        $tvpayld['stream']['wv'] = $vc__widevine;
        $tvpayld['stream']['ck'] = $vc__clearkey;
        $tvpayld['stream']['keys'] = $vc__makekey;
        if($action == "add_live_tv")
        {
            $tvpayld['uid'] = bin2hex(random_bytes(5));
            $opsbd = db__livetv("add", $tvpayld);
            if($opsbd) {
                response("success", "Added Successfully", "");
            }
        }
        if($action == "update_live_tv")
        {
            $tvpayld['uid'] = $vc__uid;
            $opsbd = db__livetv("update", $tvpayld);
            if($opsbd) {
                response("success", "Updated Successfully", "");
            }
        }
        response("error", "Operation Failed", "");
    }
    elseif($action == "get_detail")
    {
        $id = "";
        if(isset($_REQUEST['id'])) { $id = trim(strip_tags($_REQUEST['id'])); }
        if(empty($id)) {
            response("error", "Asset Identifier Missing", "");
        }
        $ops = db__livetv("detail_by_id", $id);
        if(empty($ops)) {
            response("error", "No Data Found", "");
        }
        response("success", "OK", $ops);
    }
    elseif($action == "delete_tv")
    {
        $id = "";
        if(isset($_REQUEST['id'])) { $id = trim(strip_tags($_REQUEST['id'])); }
        if(empty($id)) {
            response("error", "Asset Identifier Missing", "");
        }
        $ops = db__livetv("delete", $id);
        if(!$ops) {
            response("error", "Failed To Delete TV", "");
        }
        response("success", "Deleted Successfully", "");
    }
    elseif($action == "all_tv_list")
    {
        $hlv = db__livetv("list", "");
        if(empty($hlv)) {
            response("error", "No Streams Exist", "");
        }
        response("success", "OK", array_reverse($hlv));
    }
    elseif($action == "get_settings")
    {
        $oSetting = array("html_player" => db__htmlplayer("get", ""),
                          "m3u_playlist" => db__statusM3Uplaylist("get", ""));
        response("success", "Settings Data", $oSetting);
    }
    elseif($action == "change_html_player")
    {
        $payload = "";
        if(isset($_REQUEST['payload'])) {
            $payload = trim($_REQUEST['payload']);
        }
        if($payload !== "jw" && $payload !=="shaka")
        {
            response("error", "Invalid Payload For HTML Player", "");
        }
        if(db__htmlplayer("change", $payload)) {
            response("success", "HTML Player Changed Successfully", "");
        }
        response("error", "Failed To Change HTML Player", "");
    }
    elseif($action == "change_status_m3u_playlist")
    {
        $payload = "";
        if(isset($_REQUEST['payload'])) {
            $payload = trim($_REQUEST['payload']);
        }
        if($payload !== "ON" && $payload !=="OFF")
        {
            response("error", "Invalid Payload Supplied", "");
        }
        if(db__statusM3Uplaylist("change", $payload)) {
            response("success", "M3UPlaylist Status Changed Successfully", "");
        }
        response("error", "Failed To Change M3UPlaylist Status", "");
    }
    else
    {
        response("error", "Access Forbidden", "");
    }
}

?>