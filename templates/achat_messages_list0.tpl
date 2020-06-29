<{include file="db:achat_header.tpl"}>
<div class="panel panel-info">
    <div class="panel-heading"><h2 class="panel-title"><strong>Messages</strong></h2></div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th><{$smarty.const.MD_ACHAT_MESSAGES_MID}></th>
            <th><{$smarty.const.MD_ACHAT_MESSAGES_UID}></th>
            <th><{$smarty.const.MD_ACHAT_MESSAGES_UNAME}></th>
            <th><{$smarty.const.MD_ACHAT_MESSAGES_MSG}></th>
            <th><{$smarty.const.MD_ACHAT_MESSAGES_COLOR}></th>
            <th><{$smarty.const.MD_ACHAT_MESSAGES_DATE}></th>
            <th><{$smarty.const.MD_ACHAT_MESSAGES_IP}></th>
            <th width="80"><{$smarty.const.MD_ACHAT_ACTION}></th>
        </tr>
        </thead>
        <{foreach item=messages from=$messages}>
        <tbody>
        <tr>

            <td><{$messages.mid}></td>
            <td><{$messages.uid}></td>
            <td><{$messages.uname}></td>
            <td><{$messages.msg}></td>
            <td><span style="background-color: <{$messages.color}>;">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
            <td><{$messages.date}></td>
            <td><{$messages.ip}></td>
            <td>
                <a href="messages.php?op=view&mid=<{$messages.mid}>" title="<{$smarty.const._PREVIEW}>"><img src="<{xoModuleIcons16 search.png}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>"</a>
                <{if $xoops_isadmin === true}>
                <a href="messages.php?op=edit&mid=<{$messages.mid}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>"></a>
                <a href="admin/messages.php?op=delete&mid=<{$messages.mid}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
                <{/if}>
            </td>
        </tr>
        </tbody>
        <{/foreach}>
    </table>
</div>
<{$pagenav}>
<{$commentsnav}> <{$lang_notice}>
<{if $comment_mode == "flat"}> <{include file="db:system_comments_flat.tpl"}> <{elseif $comment_mode == "thread"}> <{include file="db:system_comments_thread.tpl"}> <{elseif $comment_mode == "nest"}> <{include file="db:system_comments_nest.tpl"}> <{/if}>
<{include file="db:achat_footer.tpl"}>
