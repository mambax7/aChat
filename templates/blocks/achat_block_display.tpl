<!-- start Block aChat Display -->
<div id="achat_messages" style="height: <{$block.div_height}>px;">
    <{include file='db:achat_postmessage.tpl' messages=$block.messages}>
</div>
<div id="achat_div_temp" style="display: none;"></div>
<{$block.achatForm}>
<!-- end Block aChat Display -->
