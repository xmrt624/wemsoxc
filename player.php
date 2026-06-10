<?php

include("_configs.php");

$id = "";
if(isset($_REQUEST['id'])){ $id = trim($_REQUEST['id']); }
if(empty($id)){ http_response_code(400); exit(); }
$pld = get_channel_detail($id);
if(empty($pld)){ http_response_code(404); exit(); }

$pBType = ""; $pBURL = "";
if(!empty($pld['stream']['keys'])) { $pBType = "ck"; }
if(!empty($pld['stream']['wv'])) { $pBType = "wv"; }
if(empty($pld['stream']['keys']) && empty($pld['stream']['wv'])) { $pBType = "hls"; }
if($pBType == "ck" || $pBType == "wv") { $pBURL = "livestream/".$pld['uid']."/manifest.mpd"; } else { $pBURL = "livestream/".$pld['uid']."/master.m3u8"; }
$pBTitle = $pld['title'];
$pBGenre = $pld['genre'];
$pBLanguage = $pld['language'];
$pBLogo = $pld['logo'];
$pBKey = $pld['stream']['keys'];
$pBWVine = "livestream/".$pld['uid']."/drmLicense";
$htmlPlyr = db__htmlplayer("get", "");
//=============================================================================//

?>
<!doctype html>
<html lang="en">
<head>
<title><?php print($pBTitle." | ".$APP_CONFIG['APP_NAME']); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="icon" href="<?php print($APP_CONFIG['APP_FAVICON']); ?>" />
<link rel="shortcut icon" href="<?php print($APP_CONFIG['APP_FAVICON']); ?>" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<?php

if($htmlPlyr == "shaka")
{
    print('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.3.5/controls.min.css" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.3.5/shaka-player.ui.min.js" crossorigin="anonymous"></script>');
}
else
{
    print('<script src="https://content.jwplatform.com/libraries/IDzF9Zmk.js"></script>');
}

?>
<style>
body
{
    font-family: "Montserrat", sans-serif;
    background-color: black;
}
.shaka-current-time, .shaka-time-container { display: none; } /* Hide time display */

</style>
</head>
<body>
<?php
if($htmlPlyr == "shaka") { ?>
    <div data-shaka-player-container style="position:absolute;z-index: -1;top: 0;left: 0;width: 100%; height: 100%;object-fit: cover;">
        <video autoplay muted data-shaka-player id="video" style="width:100%;height:100%;"></video>
    </div>
<?php } else { ?>
<div class="container">
<div class="row justify-content-center align-items-center vh-100">
    <div id="vplayer"></div>
</div>
</div>
<?php } ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php
$htmlCode = '
let player;
let wiNnUjoa = "'.$pBType.'";
let PNiZMw8R = "'.$pBURL.'";
let cR92gZiv = "'.$pBKey.'";
let DyJ9dOiA = "'.$pBLogo.'";
let K6loPDIE = "'.$pBWVine.'";
let iS2lsLPO = "'.$htmlPlyr.'";
$(document).ready(function()
{
    if(iS2lsLPO == "jw")
    {
        if(wiNnUjoa == "hls") { setup_hls_player(DyJ9dOiA, PNiZMw8R); }
        if(wiNnUjoa == "wv") { setup_wv_player(DyJ9dOiA, PNiZMw8R, K6loPDIE); }
        if(wiNnUjoa == "ck") { setup_ck_player(DyJ9dOiA, PNiZMw8R, get3ZebKy3289Ys3key(cR92gZiv), getMqA9eCUxVwK0nckid(cR92gZiv)); }
    }
    if(iS2lsLPO == "shaka")
    {
        if(wiNnUjoa == "hls") { setupShaka_hls_player(DyJ9dOiA, PNiZMw8R); }
        if(wiNnUjoa == "wv") { setupShaka_wv_player(DyJ9dOiA, PNiZMw8R, K6loPDIE); }
        if(wiNnUjoa == "ck") { setupShaka_ck_player(DyJ9dOiA, PNiZMw8R, get3ZebKy3289Ys3key(cR92gZiv), getMqA9eCUxVwK0nckid(cR92gZiv)); }
        
    }
});
function getMqA9eCUxVwK0nckid(h3n)
{
    let output = "";
    let ie3 = h3n.split(":");
    if(ie3[0] !== undefined && ie3[0] !== null && ie3[0] !== "") {
        output = ie3[0];
    }
    return output;
}
function get3ZebKy3289Ys3key(h3n)
{
    let output = "";
    let ie3 = h3n.split(":");
    if(ie3[1] !== undefined && ie3[1] !== null && ie3[1] !== "") {
        output = ie3[1];
    }
    return output;
}
function setup_hls_player(logo, link)
{
    jwplayer("vplayer").setup(
    {
        sources: [ { "file": link } ],
        image: logo,
        width: "100%",
        height: "100%",
        stretching: "uniform",
        preload: "auto",
        mute: false,
        skin: {controlbar: {text:"#FA7663", icons:"#FA7663"}, timeslider:{progress:"#FA7663"}, menus:{text:"#FA7663"} },
  });
}
function setup_ck_player(logo, link, clearkey, clearkeyID)
{
    jwplayer("vplayer").setup(
    {
        sources: [ { "file": link, "type": "mpd", "drm":{ "clearkey": { "key": clearkey, "keyId": clearkeyID } } }  ],
        image: logo,
        width: "100%", 
        height: "100%",
        stretching: "uniform",
        preload: "auto",
        mute: false,
        skin: {controlbar: {text:"#FA7663", icons:"#FA7663"}, timeslider:{progress:"#FA7663"}, menus:{text:"#FA7663"} },
  });
}
function setup_wv_player(logo, link, widevine)
{
    jwplayer("vplayer").setup(
    {
        sources: [ { "file": link, "type": "mpd", "drm": { "widevine": { "url": widevine } } } ],
        image: logo,
        width: "100%",
        height: "100%",
        stretching: "uniform",
        preload: "auto",
        skin: {controlbar: {text:"#FA7663", icons:"#FA7663"}, timeslider:{progress:"#FA7663"}, menus:{text:"#FA7663"} },
  });
}
function setupShaka_hls_player(logo, link)
{
    shaka.polyfill.installAll();
    
    shaka.Player.probeSupport().then(function ()
    {
        const video = document.getElementById("video");
        const ui = video["ui"];
        const controls = ui.getControls();
        const player = controls.getPlayer();
        window.player = player;
        window.ui = ui;

        const uiConfig = {
          controlPanelElements: [
          "play_pause",
            "mute",
            "volume",
            "spacer",
            "caption",
            "quality",
            "fullscreen"
          ],
          addSeekBar: true,
          seekBarColors: {
                base: "rgba(255, 255, 255, 0.3)",
                buffered: "rgba(255, 255, 255, 0.5)",
                played: "rgba(255, 0, 0, 0.8)"
            }
        };
        ui.configure(uiConfig);

        player.load(link).then(function () {
          video.play().catch(error => console.error("Autoplay Failed", error));
        }).catch(onPlayerError);

        player.addEventListener("trackschanged", () => {
          const tracks = player.getVariantTracks();
          if (tracks.length > 0) {
            player.selectVariantTrack(tracks[tracks.length - 1], true);
          }
        });
        
        controls.addEventListener("error", onUIErrorEvent);

    }).catch(onPlayerError);
}
function setupShaka_wv_player(logo, link, widevine)
{
    shaka.polyfill.installAll();
    
    shaka.Player.probeSupport().then(function ()
    {
        const video = document.getElementById("video");
        const ui = video["ui"];
        const controls = ui.getControls();
        const player = controls.getPlayer();
        window.player = player;
        window.ui = ui;
        
        const drmConfig = {
            drm: {
                servers: { "com.widevine.alpha": widevine }
            }
        };
        player.configure(drmConfig);
        
        const uiConfig = {
          controlPanelElements: [
          "play_pause",
            "mute",
            "volume",
            "spacer",
            "caption",
            "quality",
            "fullscreen"
          ],
          addSeekBar: true,
          seekBarColors: {
                base: "rgba(255, 255, 255, 0.3)",
                buffered: "rgba(255, 255, 255, 0.5)",
                played: "rgba(255, 0, 0, 0.8)"
            }
        };
        ui.configure(uiConfig);

        player.load(link).then(function () {
          video.play().catch(error => console.error("Autoplay Failed", error));
        }).catch(onPlayerError);

        player.addEventListener("trackschanged", () => {
          const tracks = player.getVariantTracks();
          if (tracks.length > 0) {
            player.selectVariantTrack(tracks[tracks.length - 1], true);
          }
        });
        
        controls.addEventListener("error", onUIErrorEvent);

    }).catch(onPlayerError);
}

function setupShaka_ck_player(logo, link, clearkey, clearkeyID)
{
    shaka.polyfill.installAll();
    
    shaka.Player.probeSupport().then(function ()
    {
        const video = document.getElementById("video");
        const ui = video["ui"];
        const controls = ui.getControls();
        const player = controls.getPlayer();
        window.player = player;
        window.ui = ui;
        
        const drmConfig = {
          drm: {
            clearKeys: {
              [clearkeyID]: clearkey
            }
          }
        };
        player.configure(drmConfig);
        
        const uiConfig = {
          controlPanelElements: [
          "play_pause",
            "mute",
            "volume",
            "spacer",
            "caption",
            "quality",
            "fullscreen"
          ],
          addSeekBar: true,
          seekBarColors: {
                base: "rgba(255, 255, 255, 0.3)",
                buffered: "rgba(255, 255, 255, 0.5)",
                played: "rgba(255, 0, 0, 0.8)"
            }
        };
        ui.configure(uiConfig);

        player.load(link).then(function () {
          video.play().catch(error => console.error("Autoplay Failed", error));
        }).catch(onPlayerError);

        player.addEventListener("trackschanged", () => {
          const tracks = player.getVariantTracks();
          if (tracks.length > 0) {
            player.selectVariantTrack(tracks[tracks.length - 1], true);
          }
        });
        
        controls.addEventListener("error", onUIErrorEvent);

    }).catch(onPlayerError);
}

function onPlayerErrorEvent(errorEvent) {
    onPlayerError(errorEvent.detail);
}
function onPlayerError(error) {
    console.error("Error code", error.code, "object", error);
}
function onUIErrorEvent(errorEvent) {
    onPlayerError(errorEvent.detail);
}
function initFailed(errorEvent) {
    console.error("Unable to load the UI library!");
}
';
$hunter = new HunterObfuscator($htmlCode);
$obsfucated = $hunter->Obfuscate();
echo "<script>" . $obsfucated . "</script>";
?>
</body>
</html>