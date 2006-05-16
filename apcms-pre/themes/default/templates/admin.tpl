{config_load file='theme.conf'}{include file='header.tpl'}

	<div id="apcms_head">
		<h1><a class="headlink1" href="{$apcms_Baseurl}">{$head_title|@default:$apcms_Title}</a></h1>
		<h2><a class="headlink2" href="{$apcms_Baseurl}">{$head_subtitle|@default:$apcms_Subtitle}</a></h2>
	</div>
	
	<table id="apcms_main">
		<tr>
			<td id="apcms_content" valign="top">{if $success}<div id="success">{$success}</div>{/if}{if $error}<div id="error">{$error}</div>{/if}
				{$CONTENT}</td>
			<td id="apcms_rightSideBar" valign="top">{$apcms_adminSideBar}</td>
		</tr>
	</table>

{include file='footer.tpl'}
