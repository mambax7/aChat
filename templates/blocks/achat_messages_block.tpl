<table class="outer">
    <tr class="head">
        <th><{$smarty.const.MB_ACHAT_MID}></th>
        <th><{$smarty.const.MB_ACHAT_UID}></th>
        <th><{$smarty.const.MB_ACHAT_UNAME}></th>
        <th><{$smarty.const.MB_ACHAT_MSG}></th>
        <th><{$smarty.const.MB_ACHAT_COLOR}></th>
        <th><{$smarty.const.MB_ACHAT_DATE}></th>
        <th><{$smarty.const.MB_ACHAT_IP}></th>
    </tr>
    <{foreach item=messages from=$block}>
    <tr class="<{cycle values = 'even,odd'}>">
        <td>
            <{$messages.mid}>
            <{$messages.uid}>
            <{$messages.uname}>
            <{$messages.msg}>
            <{$messages.color}>
            <{$messages.date}>
            <{$messages.ip}>
        </td>
    </tr>
    <{/foreach}>
</table>
