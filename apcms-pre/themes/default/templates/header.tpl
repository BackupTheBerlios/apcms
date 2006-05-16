<?xml version="1.0" encoding="iso-8859-1"?>
<?xml-stylesheet type="text/xsl" href="copy.xsl"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title> {$TITLE} </title>

	<meta name="title" content="{$TITLE}" />
	<meta name="description" content="{$DESCRIPTION}" />
	<meta name="Powered-By" content="APCms v.{$head_version}" />
	<meta name="revisit-after" content="7 days" />
	<meta name="creation_date" content="2004-04-17" />
	<meta name="robots" content="index, follow" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />
	{if $redirect_url}<meta http-equiv="refresh" content="{$redirect_time}; URL={$redirect_url}">{/if}
	<link rel="stylesheet" href="{$THEMEURL}/theme.css" type="text/css" />
	<link rel="SHORTCUT ICON" href="{$THEMEURL}/favicon.ico" />
	
	{if $apcms_extraHead}{$apcms_extraHead}{/if}
	{if $fieldid}{literal}
	<script type="text/javascript">
		var formInUse = false;
		function setFocus(fieldid) {
			if(!formInUse) {
				document.getElementById(fieldid).focus();
			}
		}
	</script>{/literal}
</head>

<body onload="javascript:setFocus('{$fieldid}');">
{else}
</head>

<body>
{/if}
