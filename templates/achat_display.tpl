<{if $postmessage!=''}>
    <div id="achat_postmessage"><{$postmessage}></div>
    <{/if}>

<{if $ajax_display!=''}>
    <{include file='db:achat_postmessage.tpl'}>
    <{else}>

<!-- start aChat Display -->
    <div id="achat_title"><h1><{$smarty.const._MD_ACHAT_TITLE}></h1></div>
    <div id="achat_messages" style="height: 400px;">
        <{include file='db:achat_postmessage.tpl'}>
    </div>
    <div id="achat_div_temp" style="display: none;"></div>
    <{$achatForm}>
<!-- end aChat Display -->

    <{/if}>
