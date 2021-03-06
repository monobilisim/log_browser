<?php

/* pfSense login check */
include_once("auth.inc");
include_once("priv.inc");

/* Authenticate user - exit if failed */
if (!session_auth()) {
	require_once("authgui.inc");
	display_login_form();
	exit;
}
/* ------------------- */

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>İmzalanmış Loglar</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="browser.js"></script>
<script type="text/javascript">
function init(){
browser({
	contentsDisplay:document.getElementById("dvContents"),
	refreshButton:document.getElementById("btnrefresh"),
	pathDisplay:document.getElementById("pPathDisplay"),
	filter:document.getElementById("txtFilter"),
	openFolderOnSelect:true,
	/*onSelect:function(item,params){
		if(item.type=="folder")
			return confirm("Do you want to open this Folder : "+item.path);
		else
			alert("You selected :"+item.path)
	},*/
	currentPath:""
	});
}
</script>

</head>

<?php
$log_browser = parse_ini_file('log_browser.ini');
global $HTTP_SERVER_VARS;
$username = $HTTP_SERVER_VARS['AUTH_USER'];
$user = getUserEntry($username);
$groups = local_user_get_groups($user);
if (in_array($log_browser['kisitli_grup'], $groups)):
?>

<body>
<p style="color:red">Bu sayfaya erişim yetkiniz yok.</p>

<?php else: ?>

<body onload="init()">

<h3>İmzalanmış Loglar</h3>

<div class="browser">
	<!--<p class="pfilter">File types filter
		<input type="text" id="txtFilter" value=""/>
		<input type="button" value="Refresh" id="btnrefresh"/>
	</p>-->
	<p id="pPathDisplay" class="pPathDisplay">Yükleniyor...</p>
	<div id="dvContents" class="dvContents">&nbsp;</div>
</div>

<div id="dogrulama" class="hide"></div>

<?php endif; ?>

<div class="returnlink"><a href="/">&#8629; pfSense</a></div>

</body>
</html>