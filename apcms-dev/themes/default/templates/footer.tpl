{config_load file='theme.conf' section='theme'}
{config_load file='theme.conf' section='author'}

<div id="copyright">
	<!-- BE FAIR!!! DON'T REMOVE OR MODIFY THE FOLLOWING COPYRIGHT NOTICE! -->
	Theme: <a href="{#infopage#}" class="copyright">{#title#} {#version#}</a>; Copyright &copy; by {#name#}<br />
	Powered by <a href="http://www.php-programs.de" class="copyright">APCms {$apcms.version}</a>; Copyright &copy; 2000- &nbsp; &nbsp;Alexander &acute;dma147&acute; Mieland<br />
	All trademarks are properties of their respective holders
</div>

{if $apcms_belowCopyright}{$apcms_belowCopyright}{/if}
</body>
</html>