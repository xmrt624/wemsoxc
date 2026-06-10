<?php

include("_configs.php");
session_start();

if(isset($_SESSION['WELIVE_ADMIN']) && $_SESSION['WELIVE_ADMIN'] == "TRUE")
{
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard | <?php print($APP_CONFIG['APP_NAME']); ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="<?php print($APP_CONFIG['APP_FAVICON']); ?>" />
<link rel="shortcut icon" href="<?php print($APP_CONFIG['APP_FAVICON']); ?>" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" />
<style>
body {
    font-family: 'Montserrat', sans-serif;
    background-color: #000000;
}
.card {
    color: #ffffff;
    background-color: #333333;
    border-radius: 10px;
}
.btn {
    font-weight: bold;
    border-radius: 20px;
    padding-left: 15px;
    padding-right: 15px;
}
.modal-content {
    color: #FFFFFF;
    background-color: #333;
    border-radius: 10px;
}
#adm_html_player, #adm_status_m3uplaylist {
    border-top-left-radius: 22px;
    border-bottom-left-radius: 22px;
    padding-left: 28px;
}
#tvAddUpdm {
    padding: 22px;
}
</style>
</head>
<body>


<div class="container mt-5">

    <div class="card">
        <div class="card-body" style="padding: 30px;">
            <img src="<?php print($APP_CONFIG['APP_LOGO']); ?>" alt="<?php print($APP_CONFIG['APP_NAME']); ?>" width="100" height="100" class="img-fluid" />
            <h2 class="mt-3"><?php print($APP_CONFIG['APP_NAME']); ?></h2>
            <hr class="text-light">
            <div class="">
                <label class="form-label">HTML Player</label>
                <div class="input-group">
                    <select class="form-select" id="adm_html_player">
                        <option value="">- None -</option>
                        <option value="jw">JW Player</option>
                        <option value="shaka">Shaka Player</option>
                    </select>
                    <button class="btn btn-secondary" id="adm_html_player_btn"> OK </button>
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label">IPTV M3U Playlist</label>
                <div class="input-group">
                    <select class="form-select" id="adm_status_m3uplaylist">
                        <option value="">- None -</option>
                        <option value="ON">ON</option>
                        <option value="OFF">OFF</option>
                    </select>
                    <button class="btn btn-secondary" id="adm_status_m3uplaylist_btn"> OK </button>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-warning" id="addTVModalBtn">&nbsp;<i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Add TV</button>
                &nbsp;
                <button class="btn btn-danger" id="logoutBtn">&nbsp;<i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;Logout</button>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-body">
            <div class="hc3i8h0p3qr px-1"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div></div>
        </div>
    </div>

</div>

<div class="modal fade" id="tvaddUpdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body" id="tvAddUpdm">
                <h3 class="tvMdttl">Add LiveTV</h3>
                <div class="mt-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" id="omt__title" placeholder="Title" autocomplete="off" />
                </div>
                <div class="mt-3">
                    <label class="form-label">Logo Image URL</label>
                    <input type="text" class="form-control" id="omt__logo" placeholder="Logo Image URL" autocomplete="off" />
                </div>
                <div class="mt-3">
                    <label class="form-label">Genre</label>
                    <select class="form-select" id="omt__genre">
                        <option value="">- Please Select -</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Movies">Movies</option>
                        <option value="Music">Music</option>
                        <option value="Sports">Sports</option>
                        <option value="Business">Business</option>
                        <option value="News">News</option>
                        <option value="Shopping">Shopping</option>
                        <option value="Infotainment">Infotainment</option>
                        <option value="Kids">Kids</option>
                        <option value="Animation">Animation</option>
                        <option value="Lifestyle">Lifestyle</option>
                        <option value="Religious">Religious</option>
                        <option value="Devotional">Devotional</option>
                        <option value="Spiritual">Spiritual</option>
                        <option value="Travel">Travel</option>
                        <option value="Education">Education</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label class="form-label">Language</label>
                    <select class="form-select" id="omt__language">
                        <option value="">- Please Select -</option>
                        <option value="Hindi">Hindi</option>
                        <option value="English">English</option>
                        <option value="Tamil">Tamil</option>
                        <option value="Telugu">Telugu</option>
                        <option value="Bengali">Bengali</option>
                        <option value="Marathi">Marathi</option>
                        <option value="Gujarati">Gujarati</option>
                        <option value="Punjabi">Punjabi</option>
                        <option value="Urdu">Urdu</option>
                        <option value="Malayalam">Malayalam</option>
                        <option value="Kannada">Kannada</option>
                        <option value="Odia">Odia</option>
                        <option value="Assamese">Assamese</option>
                        <option value="Kashmiri">Kashmiri</option>
                        <option value="Bhojpuri">Bhojpuri</option>
                        <option value="Sindhi">Sindhi</option>
                        <option value="Dogri">Dogri</option>
                        <option value="Nepali">Nepali</option>
                        <option value="French">French</option>
                        <option value="Spanish">Spanish</option>
                        <option value="German">German</option>
                        <option value="Italian">Italian</option>
                        <option value="Arabic">Arabic</option>
                        <option value="Portuguese">Portuguese</option>
                        <option value="Russian">Russian</option>
                        <option value="Japanese">Japanese</option>
                        <option value="Korean">Korean</option>
                        <option value="Chinese">Chinese</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label class="form-label">Stream URL</label>
                    <input type="text" class="form-control" id="omt__streamurl" placeholder="Stream URL" autocomplete="off" />
                </div>
                <div class="mt-3">
                    <label class="form-label">DRM Type</label>
                    <select class="form-select" id="omt__drmtype">
                        <option value="">- None -</option>
                        <option value="wv">Widevine URL</option>
                        <option value="ck">ClearKey</option>
                    </select>
                </div>
                <div class="omt__drmhtml"></div>
                <div class="mt-4">
                    <input type="hidden" id="omt__uid" value="" />
                    <input type="hidden" id="omt__action" value="add" />
                    <div class="d-grid gap-2"><button id="omt__btn" class="btn btn-warning" type="button">Submit</button></div>
                </div>
                <div class="mt-3">
                    <div class="d-grid gap-2">
                        <button class="btn btn-light btn-sm" id="omt__closemodal">Close Window</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script>
let appLogoDefault = "<?php print($APP_CONFIG['APP_LOGO']); ?>";
$(document).ready(function(){
    fetchSettings();
    fetchTVListing();
});
function fetchSettings()
{
    $.ajax({
        "url": "api-admin.php",
        "type": "GET",
        "data": "action=get_settings",
        "success": function(data) {
            $("#adm_html_player").val(data.data.html_player);
            $("#adm_status_m3uplaylist").val(data.data.m3u_playlist);
        }
    });
}
$("#logoutBtn").on("click", function(){
    if(confirm("Sure To Logout ?"))
    {
        $.ajax({
            "url": "api-admin.php",
            "type": "POST",
            "data": "action=logout",
            "success": function(data)
            {
                window.location = "?view=login";
            },
            "error": function(data)
            {
                window.location = "?view=login";
            }
        });
    }
});
$("#omt__closemodal").on("click", function(){
    if(confirm("Make sure to submit form before closing the window to avoid loosing changes !")) {
        if(confirm("Sure To Close The Window ?")) {
            $("#tvaddUpdModal").modal("hide");
        }
    }
});
$("#addTVModalBtn").on("click", function(){
    $("#tvaddUpdModal").modal("show");
});
$("#omt__drmtype").on("change", function(e){
    let clnt = ``;
    let slv = $(this).val();
    if(slv == "wv")
    {
        clnt += `<div class="mt-3">
        <label class="form-label">Widevine URL</label>
        <input type="text" class="form-control" id="omt__widevine" placeholder="Widevine URL" autocomplete="off" />
        </div>`;
    }
    else if(slv == "cku")
    {
        clnt += `<div class="mt-3">
        <label class="form-label">ClearKey URL</label>
        <input type="text" class="form-control" id="omt__clearkey" placeholder="ClearKey URL" autocomplete="off" />
        </div>`;
    }
    else if(slv == "ck")
    {
        clnt += `<div class="mt-3">
        <label class="form-label">ClearKey - ID and Key</label>
        <div class="input-group">
            <input type="text" class="form-control" id="omt__clearkey_id" placeholder="ClearKey ID" autocomplete="off" />
            <input type="text" class="form-control" id="omt__clearkey_key" placeholder="ClearKey Key" autocomplete="off" />
        </div>
        </div>`;
    }
    else
    {

    }
    $(".omt__drmhtml").html(clnt);
});
$("#omt__btn").on("click", function(){
    addUpdateTV();
});
function addUpdateTV()
{
    let unb_payload = "";
    let frmAction = $("#omt__action").val() + "_live_tv";
    let luid = $("#omt__uid").val();
    let title = $("#omt__title").val();
    let logo = $("#omt__logo").val();
    let genre = $("#omt__genre").val();
    let language = $("#omt__language").val();
    let streamurl = $("#omt__streamurl").val();
    let drmtype = $("#omt__drmtype").val();
    unb_payload = "action=" + frmAction;
    if(frmAction === "update_live_tv") {
        unb_payload += "&uid=" + luid;
    }
    unb_payload += "&title=" + safe_btoa(safe_btoa(title)) + "&logo=" + safe_btoa(safe_btoa(logo)) + "&genre=" + genre + "&language=" + language + "&streamurl=" + safe_btoa(safe_btoa(streamurl));
    if(drmtype == "wv") {
        unb_payload += "&widevine=" + safe_btoa(safe_btoa($("#omt__widevine").val()));
    }
    if(drmtype == "cku") {
        unb_payload += "&clearkey=" + safe_btoa(safe_btoa($("#omt__clearkey").val()));
    }
    if(drmtype == "ck") {
        unb_payload += "&clearkey_id=" + $("#omt__clearkey_id").val() + "&clearkey_key=" + $("#omt__clearkey_key").val();
    }
    $.ajax({
        "url": "api-admin.php",
        "type": "POST",
        "data": unb_payload,
        "success": function(data)
        {
            try { data = JSON.parse(data); }catch(err){}
            if(data.status == "success")
            {
                $("#tvaddUpdModal").modal("hide");
                fetchTVListing();
                window.setTimeout(function(){
                    alert("Success: " + data.message);
                }, 600);
            }
            else
            {
                if(data.status == "error")
                {
                    alert("Error: " + data.message);
                }
                else
                {
                    alert("Error: Something Went Wrong");
                }
            }
        },
        "error": function(data)
        {
            alert("Error: Network or Server Failure");
        }
    });
}
function fetchTVListing()
{
    $.ajax({
        "url": "api-admin.php",
        "type": "POST",
        "data": "action=all_tv_list",
        "success": function(data) {
            try { data = JSON.parse(data); }catch(err) {}
            if(data.status == "success")
            {
                let ujn = `<div class="table-responsive py-3">
                <table class="table table-dark table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Title</th>
                            <th>Genre & Language</th>
                            <th>Stream URL</th>
                            <th>DRM Data</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody id="livetvhbdyBody">`;
                    let hu = data.data.length + 1;
                    $.each(data.data, function(k, v){
                        hu--;
                        ujn += `<tr>`;
                        ujn += `<td>` + hu + `</td>`;
                        ujn += `<td>` + v.title + `<div class="mt-2"><img src="` + v.logo + `" onerror="this.src='` + appLogoDefault + `'" class="img-thumbnail" width="110" height="90" alt="` + v.title +`" /></div></td>`;
                        ujn += `<td><span class="badge text-bg-light text-wrap">` + v.genre + `</span><br/><span class="badge text-bg-info text-wrap">` + v.language + `</span></td>`;
                        ujn += `<td style="word-break: break-all !important;"><small>` + v.stream.url + `</small></td>`;
                        ujn += `<td style="word-break: break-all !important;"><small>` + v.stream.wv + ` ` + v.stream.ck + ` ` + v.stream.keys + `</small></td>`;
                        ujn += `<td><button class="btn btn-success btn-sm" onclick="gettvdataedit(this)" data-id="` + v.uid + `">Edit</button><br/><button class="btn btn-danger btn-sm" onclick="deletethistv(this)" data-id="` + v.uid + `">Delete</button></td>`;
                        ujn += `</tr>`;
                    });
                ujn += `</tbody>
                    </table>
                </div>`;
                $(".hc3i8h0p3qr").html(ujn);
            }
            else
            {
                if(data.status == "error")
                {
                    $(".hc3i8h0p3qr").html(`<div class="text-info fw-bold py-3 px-3">` + data.message + `</div>`);
                }
                else
                {
                    $(".hc3i8h0p3qr").html(`<div class="text-info fw-bold py-3 px-3">Something Went Wrong</div>`);
                }

            }
        },
        "error": function(data) {
            $(".hc3i8h0p3qr").html(`<div class="text-info fw-bold py-3 px-3">Server or Network Failure Occured</div>`);
        }
    });
}

function gettvdataedit(t)
{
    let tv_id = $(t).attr("data-id");
    $.ajax({
        "url": "api-admin.php",
        "type": "POST",
        "data": "action=get_detail&id=" + tv_id,
        "success": function(data) {
            try { data = JSON.parse(data); }catch(err) {}
            if(data.status == "success")
            {
                $("#omt__action").val("update");
                $("#omt__uid").val(data.data.uid);
                $("#omt__title").val(data.data.title);
                $("#omt__logo").val(data.data.logo);
                $("#omt__genre").val(data.data.genre);
                $("#omt__language").val(data.data.language);
                $("#omt__streamurl").val(data.data.stream.url);
                if(data.data.stream.wv !== "")
                {
                    $("#omt__drmtype").val("wv");
                    $(".omt__drmhtml").html(`<div class="mt-3">
                        <label class="form-label">Widevine URL</label>
                        <input type="text" class="form-control" id="omt__widevine" placeholder="Widevine URL" autocomplete="off" />
                    </div>`);
                    $("#omt__widevine").val(data.data.stream.wv);
                }
                if(data.data.stream.keys !== undefined && data.data.stream.keys !== null && data.data.stream.keys !== "")
                {
                    $("#omt__drmtype").val("ck");
                    $(".omt__drmhtml").html(`<div class="mt-3">
                        <label class="form-label">ClearKey - ID and Key</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="omt__clearkey_id" placeholder="ClearKey ID" autocomplete="off" />
                            <input type="text" class="form-control" id="omt__clearkey_key" placeholder="ClearKey Key" autocomplete="off" />
                        </div>
                    </div>`);
                    let kkyu = data.data.stream.keys.split(":");
                    $("#omt__clearkey_id").val(kkyu[0]);
                    $("#omt__clearkey_key").val(kkyu[1]);
                }
                $("#tvaddUpdModal").modal("show");
            }
            else
            {
                if(data.status == "error")
                {
                    alert("Oops: " + data.message);
                }
                else
                {
                    alert("Oops: Unknown Error Occured");
                }

            }
        },
        "error": function(data) {
            alert("Oops: Server or Network Failure Occured");
        }
    });
}

function deletethistv(t)
{
    let tv_id = $(t).attr("data-id");
    if(confirm("Sure To Delete ?"))
    {
        $.ajax({
            "url": "api-admin.php",
            "type": "POST",
            "data": "action=delete_tv&id=" + tv_id,
            "success": function(data) {
                try { data = JSON.parse(data); }catch(err) {}
                if(data.status == "success")
                {
                    fetchTVListing();
                }
                else
                {
                    if(data.status == "error")
                    {
                        alert("Oops: " + data.message);
                    }
                    else
                    {
                        alert("Oops: Unknown Error Occured");
                    }

                }
            },
            "error": function(data) {
                alert("Oops: Server or Network Failure Occured");
            }
        });
    }
}
function safe_btoa(str)
{
    let utf8Bytes = new TextEncoder().encode(str);
    return btoa(String.fromCharCode(...utf8Bytes));
}
$("#adm_html_player").change(function() {
    changeHTMLPlayer();
 });
$("#adm_html_player_btn").on("click", function(){
   changeHTMLPlayer();
});
function changeHTMLPlayer()
{
    let plyr = $("#adm_html_player").val();
    $.ajax({
        "url": "api-admin.php",
        "type": "POST",
        "data": "action=change_html_player&payload=" + plyr,
            "success": function(data) {
                try { data = JSON.parse(data); }catch(err) {}
                if(data.status == "success")
                {
                    alert("Success: " + data.message);
                    fetchSettings();
                }
                else
                {
                    if(data.status == "error")
                    {
                        alert("Oops: " + data.message);
                    }
                    else
                    {
                        alert("Oops: Unknown Error Occured");
                    }

                }
            },
            "error": function(data) {
                alert("Oops: Server or Network Failure Occured");
            }
        });
}
$("#adm_status_m3uplaylist").change(function() {
    changeStatusM3UPlaylist();
 });
$("#adm_status_m3uplaylist_btn").on("click", function(){
   changeStatusM3UPlaylist();
});
function changeStatusM3UPlaylist()
{
    let plyr = $("#adm_status_m3uplaylist").val();
    $.ajax({
        "url": "api-admin.php",
        "type": "POST",
        "data": "action=change_status_m3u_playlist&payload=" + plyr,
            "success": function(data) {
                try { data = JSON.parse(data); }catch(err) {}
                if(data.status == "success")
                {
                    alert("Success: " + data.message);
                    fetchSettings();
                }
                else
                {
                    if(data.status == "error")
                    {
                        alert("Oops: " + data.message);
                    }
                    else
                    {
                        alert("Oops: Unknown Error Occured");
                    }

                }
            },
            "error": function(data) {
                alert("Oops: Server or Network Failure Occured");
            }
        });
}
</script>
</body>
</html>
<?php
}
else
{
//=================================================================================================//
    if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(!isset($APP_CONFIG['ADMIN_CREDS']['USERNAME']) || empty($APP_CONFIG['ADMIN_CREDS']['USERNAME'])) {
            print(json_encode(['status' => 'ERROR', 'message' => 'Login Service Unavailable' ]));
            exit;
        }
        if(!isset($APP_CONFIG['ADMIN_CREDS']['PASSWORD']) || empty($APP_CONFIG['ADMIN_CREDS']['PASSWORD'])) {
            print(json_encode(['status' => 'ERROR', 'message' => 'Login Service Unavailable' ]));
            exit;
        }
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            print(json_encode(['status' => 'ERROR', 'message' => 'Token Error. Refresh Page and Try Again' ]));
            exit;
        }
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username === $APP_CONFIG['ADMIN_CREDS']['USERNAME'] && $password === $APP_CONFIG['ADMIN_CREDS']['PASSWORD'])
        {
            $_SESSION['WELIVE_ADMIN'] = "TRUE";
            $response = [ 'status' => 'SUCCESS', 'message' => 'Logged In. Redirecting ...'];
        }
        else
        {
            $response = ['status' => 'ERROR', 'message' => 'Invalid username or password!'];
        }
        print(json_encode($response));
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Login | <?php print($APP_CONFIG['APP_NAME']); ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="<?php print($APP_CONFIG['APP_FAVICON']); ?>" />
<link rel="shortcut icon" href="<?php print($APP_CONFIG['APP_FAVICON']); ?>" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<style>
body, html {
    height: 100%;
    margin: 0;
    font-family: 'Montserrat', sans-serif;
    background-color: #121212;
    color: #e0e0e0;
}
.modal-content {
    background-color: #333;
    border-radius: 10px;
    padding: 20px;
}
.modal-header {
    border-bottom: none;
    justify-content: center;
}
.modal-title {
    font-weight: 500;
    font-size: 30px;
    color: #ffffff;
}
.modal-body {
    padding: 20px 30px;
}
.form-group label {
    color: #bbbbbb;
}
.form-control {
    background-color: #444;
    color: #ffffff;
    border: 1px solid #555;
    border-radius: 22px;
    padding-left: 26px;
}
.form-control:focus {
    background-color: #555;
    border-color: #007bff;
    color: #ffffff;
}
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}
.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
.fa {
    margin-right: 10px;
}
.toast {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    min-width: 200px;
    background-color: #333;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    display: none;
}
.toast.success {
    background-color: #28a745;
}
.toast.error {
    background-color: #dc3545;
}
</style>
</head>
<body>

<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Welive Admin</h5>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mt-3">
                            <label class="form-label"><i class="fas fa-user"></i>&nbsp;&nbsp;Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="" autocomplete="off" />
                        </div>
                        <div class="mt-3">
                            <label class="form-label"><i class="fas fa-lock"></i>&nbsp;&nbsp;Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="" autocomplete="off" />
                        </div>
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Login</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>

<div id="toast" class="toast"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script>
$(document).ready(function ()
{
    $('#loginModal').modal('show');
    $('#loginForm').submit(function (e)
    {
        e.preventDefault();
        var username = $('#username').val();
        var password = $('#password').val();
        var csrf_token = $("input[name='csrf_token']").val();

        if (!username) {
            $('#toast').removeClass('success').addClass('error').text('Please Enter Username').fadeIn();
            setTimeout(function () {
                $('#toast').fadeOut();
            }, 2000);
            return;
        }
        
        if (!password) {
            $('#toast').removeClass('success').addClass('error').text('Please Enter Password').fadeIn();
            setTimeout(function () {
                $('#toast').fadeOut();
            }, 2000);
            return;
        }
        
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                username: username, password: password, csrf_token: csrf_token
            },
            dataType: 'json',
            success: function (response)
            {
                if(response.status === 'SUCCESS')
                {
                    $('#toast').removeClass('error').addClass('success').text(response.message).fadeIn();
                    setTimeout(function () {
                        $('#toast').fadeOut();
                        window.location.reload();
                    }, 2000);
                }
                else
                {
                    $('#toast').removeClass('success').addClass('error').text(response.message).fadeIn();
                    setTimeout(function () {
                        $('#toast').fadeOut();
                    }, 2000);
                }
            },
            error: function ()
            {
                $('#toast').removeClass('success').addClass('error').text('An error occurred. Please try again later.').fadeIn();
                setTimeout(function () {
                    $('#toast').fadeOut();
                }, 2000);
            }
        });
    });
});
</script>
</body>
</html>


<?php
}
?>