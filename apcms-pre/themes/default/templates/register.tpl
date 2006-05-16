{config_load file='theme.conf'}{include file='header.tpl'}

	{if $apcms_aboveHeadBanner}{$apcms_aboveHeadBanner}{/if}
	
	<div id="apcms_head">
		<h1><a class="headlink1" href="{$apcms_Baseurl}">{$head_title|@default:$apcms_Title}</a></h1>
		<h2><a class="headlink2" href="{$apcms_Baseurl}">{$head_subtitle|@default:$apcms_Subtitle}</a></h2>
	</div>
	
	{if $apcms_belowHeadBanner}{$apcms_belowHeadBanner}{/if}
	
	<table id="apcms_main">
		<tr>
	{if $apcms_leftSideBar}
			<td id="apcms_leftSideBar" valign="top">{$apcms_leftSideBar}</td>
	{/if}
			<td id="apcms_content" valign="top">{if $success}<div id="success">{$success}</div>{/if}{if $error}<div id="error">{$error}</div>{/if}
				{$CONTENT}</td>
	{if $apcms_rightSideBar}
			<td id="apcms_rightSideBar" valign="top">{$apcms_rightSideBar}</td>
	{/if}
		</tr>
	</table>
	
	{if $apcms_aboveFootBanner}{$apcms_aboveFootBanner}{/if}
	
{include file='footer.tpl'}
