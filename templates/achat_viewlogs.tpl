<!-- start aChat View logs -->
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/achat/assets/css/achat.css">
<div id="achat_title">
    <h1><{$smarty.const._MD_ACHAT_TITLE}></h1>
    <h3><{$smarty.const._MD_ACHAT_TITLE_LOGS}></h3>
</div>
<{if $pagenav!=''}><{$pagenav}><{/if}>
<div id="achat_messages" style="overflow: hidden;">
    <{include file='db:achat_postmessage.tpl'}>
</div>
<{if $pagenav2!=''}><{$pagenav2}><{/if}>
<!-- end aChat View logs -->
