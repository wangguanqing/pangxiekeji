
{pc M=content action=lists catid=6 num=5 order='inputtime DESC'}
	{foreach from=$data key=key item=val}
	<a href="">{$val['title']}</a><br>
	{/foreach}
{/pc}


