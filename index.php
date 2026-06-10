<?php

include("_configs.php");

if(isset($_GET['download']) && $_GET['download'] == "m3u_playlist")
{
    if(db__statusM3Uplaylist("get", "") !== "ON") { http_response_code(404); exit(); }
    if($_SERVER['SERVER_PORT'] !== "80" && $_SERVER['SERVER_PORT'] !== "443") { $playUrlBase = $streamenvproto."://".$plhoth.":".$_SERVER['SERVER_PORT'].str_replace(" ", "%20", str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF'])); } else { $playUrlBase = $streamenvproto."://".$plhoth.str_replace(" ", "%20", str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF'])); }
    $tvlist = data__channels();
    if(isset($tvlist[0]))
    {
        $mbline = "#EXTM3U\n";
        foreach($tvlist as $stv)
        {
            $playurl = $playUrlBase."livestream/".$stv['uid']."/master.m3u8";
            $drmurl = $playUrlBase."livestream/".$stv['uid']."/drmLicense";

            $mbline .= '#EXTINF:-1 tvg-id="'.$stv['uid'].'" tvg-name="'.$stv['title'].'" tvg-genre="'.$stv['genre'].'" tvg-language="'.$stv['language'].'" tvg-country="IN" tvg-logo="'.$stv['logo'].'" tvg-chno="'.$stv['id'].'" group-title="'.$stv['genre'].'",'.$stv['title']."\n";

            if(!empty($stv['stream']['wv']))
            {
                $mbline .= "#KODIPROP:inputstream=inputstream.adaptive"."\n";
                $mbline .= "#KODIPROP:inputstreamaddon=inputstream.adaptive"."\n";
                $mbline .= "#KODIPROP:inputstream.adaptive.manifest_type=mpd"."\n";
                $mbline .= '#KODIPROP:inputstream.adaptive.license_type=com.widevine.alpha'."\n";
                $mbline .= '#KODIPROP:inputstream.adaptive.license_key='.$drmurl."\n";
                $playurl = $playUrlBase."livestream/".$stv['uid']."/manifest.mpd";
            }
            if(!empty($stv['stream']['keys']))
            {
                $mbline .= "#KODIPROP:inputstream=inputstream.adaptive"."\n";
                $mbline .= "#KODIPROP:inputstreamaddon=inputstream.adaptive"."\n";
                $mbline .= "#KODIPROP:inputstream.adaptive.manifest_type=mpd"."\n";
                $mbline .= '#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey'."\n";
                $mbline .= '#KODIPROP:inputstream.adaptive.license_key='.$drmurl."\n";
                $playurl = $playUrlBase."livestream/".$stv['uid']."/manifest.mpd";
            }
            $mbline .= $playurl."\n";

        }
        $playlistfiledown = str_replace(" ", "", $APP_CONFIG['APP_NAME'])."_".bin2hex(random_bytes(4)).".m3u";
        header("Content-Type: application/x-mpegurl");
        header('Content-Disposition: attachment; filename="' . $playlistfiledown . '"');

        print(trim($mbline));
        exit();
    }
    http_response_code(404);
    exit();
}

$api = ""; if(isset($_POST['api'])) { $api = trim($_POST['api']); }

$tvlist = data__channels();

if($api == "get_channels")
{
    $live = array();
    foreach($tvlist as $itv)
    {
        if(empty($itv['logo'])) { $itv['logo'] = $APP_CONFIG['APP_LOGO']; }
        $live[] = array("id" => $itv['uid'], "title" => $itv['title'], "logo" => $itv['logo'], "category" => $itv['genre']);
    }
    if(!isset($tvlist[0])) {
        response("error", "No Channels Found", "");
    }
    response("success", "Total ".count($live)." Channels Found", array("count" => count($live), "list" => $live));
}
if($api == "search_channels")
{
    $query = "";
    if(isset($_REQUEST['query'])){ $query = trim(strip_tags($_REQUEST['query'])); }
    if(empty($query)) {
        response("error", "Please Enter Channel Name To Search", "");
    }
    foreach($tvlist as $itv) {
        if(stripos($itv['title'], $query) !== false)
        {
            if(empty($itv['logo'])) { $itv['logo'] = $APP_CONFIG['APP_LOGO']; }
            $live[] = array("id" => $itv['uid'], "title" => $itv['title'], "logo" => $itv['logo'], "category" => $itv['genre']);
        }
    }
    response("success", "Channel Search Results", array("query" => $query, "count" => count($live), "list" => $live));
}
//=============================================================================//

?>
<!doctype html>
<html lang="en">
<head>
<title><?php print($APP_CONFIG['APP_NAME']); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="icon" href="<?php print($APP_CONFIG['APP_FAVICON']); ?>" />
<link rel="shortcut icon" href="<?php print($APP_CONFIG['APP_FAVICON']); ?>" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<style>
body
{
    font-family: "Montserrat", sans-serif;
    background-color: black;
}
#txtCSearch {
    border-top-left-radius: 24px;
    border-bottom-left-radius: 24px;
    padding-left: 28px;
}
#downloadPlaylistBtn {
    border-top-right-radius: 24px;
    border-bottom-right-radius: 24px;
}
.card {
    color: #FFFFFF;
    border-radius:2rem .3rem ;
    background-color: #202020 !important;
    text-align: center;
    justify-content: center;
    item-align: center;
    border:2px solid black;
}
.card:hover {
    background-color: rgba(165, 42, 42, 0.521);
	border-color:white;
	border:2px solid white;
}
.card:hover .card-text {
    color:white;
}
.card a {
    text-decoration: none;
    color: #FFFFFF;
}
.tvimage {
    border-radius: 28px;
}
<?php if(db__statusM3Uplaylist("get", "") !== "ON") { ?>
#initCSearch {
    border-top-right-radius: 24px;
    border-bottom-right-radius: 24px;
} <?php } ?>
</style>
</head>
<body>
    
<div class="container">
    <!-- Logo Holder -->
        <div class="mt-5 mb-4"><img src="<?php print($APP_CONFIG['APP_LOGO']); ?>" alt="" class="img-fluid" width="140" height="80" /></div>
    <!-- //Logo Holder -->
    <div class="mb-4">
        <div class="input-group">
        <input class="form-control" type="text" id="txtCSearch" placeholder="Search Channels Here ..." autocomplete="off" />
        <button class="btn btn-secondary" id="initCSearch"><i class="fa-solid fa-magnifying-glass"></i></button>
        <?php if(db__statusM3Uplaylist("get", "") == "ON") { ?>
        <button class="btn btn-dark" id="downloadPlaylistBtn" title="Click To Download IPTV M3U-Playlist"><i class="fa-solid fa-download"></i></button>
        <?php } ?>
        </div>
    </div>
    <div class="tv_catalog">
        <div class="mt-5 px-3"><div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>
    </div>
</div>

<br/>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){ loadChannels(); });
function loadChannels()
{
    $.ajax({
        "url": "",
        "type": "POST",
        "data": "api=get_channels",
        "success": function(data) {
            try { data = JSON.parse(data); }catch(error){}
            if(data.status == "success")
            {
                let utml = '';
                utml = utml + '<div class="row">';
                $.each(data.data.list, function(k,v){
                    utml += `<div class="col-6 col-sm-4 col-lg-3 col-xl-2" data-id="` + v.id + `" title="Watch ` + v.title + ` Live Stream" onclick="openPlayer(this)">`;
		            utml += `<div align="center" class="card mt-2" title="Watch - ` + v.title + `">`;
                    utml += `<div><img src="` + v.logo + `" alt="` + v.title + `" width="140" height="130" class="tvimage" /></div>`;
                    utml += `<div class="card-body">`;
                    utml += `<div style="user-select: none;"><b><small>` + v.title + `</small></b></div>`;
                    utml += `</div>`;
		            utml += `</div>`;
		            utml += `</div>`;
                });
                utml = utml + '</div>';
                $(".tv_catalog").html(utml);
            }
            else
            {
                if(data.status == "error")
                {
                    $(".tv_catalog").html('<div class="text-warning"><b>Error: ' + data.message + '</b></div>');
                }
                else
                {
                    $(".tv_catalog").html('<div class="text-warning"><b>SOMETHING WENT WRONG</b></div>');
                }
            }
        },
        "error": function(data) {
            $(".tv_catalog").html('<div class="text-warning"><b>NETWORK OR INTERNAL SERVER ERROR</b></div>');
        }
    });
}
function searchChannels()
{
    $("#initCSearch").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
    $.ajax({
        "url": "",
        "type": "POST",
        "data": "api=search_channels&query=" + $("#txtCSearch").val(),
        "success": function(data)
        {
            $("#initCSearch").html('<i class="fa-solid fa-magnifying-glass"></i>');
            try { data = JSON.parse(data); }catch(error){}
            if(data.status == "success")
            {
                let utml = '';
                utml = utml + '<div class="row">';
                $.each(data.data.list, function(k,v){
                    utml += `<div class="col-6 col-sm-4 col-lg-3 col-xl-2" data-id="` + v.id + `" title="Watch ` + v.title + ` Live Stream" onclick="openPlayer(this)">`;
		            utml += `<div align="center" class="card mt-2" title="Watch - ` + v.title + `">`;
                    utml += `<div><img src="` + v.logo + `" alt="` + v.title + `" width="130" height="130" class="tvimage" /></div>`;
                    utml += `<div class="card-body">`;
                    utml += `<div style="user-select: none;"><b><small>` + v.title + `</small></b></div>`;
                    utml += `</div>`;
		            utml += `</div>`;
		            utml += `</div>`;
                });
                utml = utml + '</div>';
                $(".tv_catalog").html(utml);
            }
            else
            {
                loadChannels();
            }
        },
        "error": function(data) {
            loadChannels();
            $("#initCSearch").html('<i class="fa-solid fa-magnifying-glass"></i>');
        }
    });
}
$("#initCSearch").on("click", function(){
    searchChannels();
});
$("#txtCSearch").on('keypress', function(e) {
    if (e.which === 13 || e.key === 'Enter') { 
        e.preventDefault();
        searchChannels();
    }
});
$("#txtCSearch").on('input', function(e) {
    searchChannels();
});
function openPlayer(l)
{
    let channelID = $(l).attr("data-id");
    let playerLink = "player.php?id=" + channelID;
    window.location = playerLink;
}
$("#downloadPlaylistBtn").on("click", function(){
    window.location = "?download=m3u_playlist";
});
</script>
</body>
</html>