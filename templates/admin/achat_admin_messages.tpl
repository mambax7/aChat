<{if $messagesRows > 0}>
    <div class="outer">
        <form name="select" action="messages.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('messagesId[]');} else if (isOneChecked('messagesId[]')) {return true;} else {alert('<{$smarty.const.AM_MESSAGES_SELECTED_ERROR}>'); return false;}">
            <input type="hidden" name="confirm" value="1">
            <div class="floatleft">
                <select name="op">
                    <option value=""><{$smarty.const.AM_ACHAT_SELECT}></option>
                    <option value="delete"><{$smarty.const.AM_ACHAT_SELECTED_DELETE}></option>
                </select>
                <input id="submitUp" class="formButton" type="submit" name="submitselect" value="<{$smarty.const._SUBMIT}>" title="<{$smarty.const._SUBMIT}>">
            </div>
            <div class="floatcenter0">
                <div id="pagenav"><{$pagenav}></div>
            </div>


            <table class="$messages" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectormid}></th>
                    <th class="left"><{$selectoruid}></th>
                    <th class="left"><{$selectoruname}></th>
                    <th class="left"><{$selectormsg}></th>
                    <th class="left"><{$selectorcolor}></th>
                    <th class="left"><{$selectordate}></th>
                    <th class="left"><{$selectorip}></th>

                    <th class="center width5"><{$smarty.const.AM_ACHAT_FORM_ACTION}></th>
                </tr>
                <{foreach item=messagesArray from=$messagesArrays}>
                <tr class="<{cycle values="odd,even"}>">

                    <td align="center" style="vertical-align:middle;"><input type="checkbox" name="messages_id[]" title="messages_id[]" id="messages_id[]" value="<{$messagesArray.messages_id}>"></td>
                    <td class='left'><{$messagesArray.mid}></td>
                    <td class='left'><{$messagesArray.uid}></td>
                    <td class='left'><{$messagesArray.uname}></td>
                    <td class='left'><{$messagesArray.msg}></td>
                    <td class='left'><{$messagesArray.color}></td>
                    <td class='left'><{$messagesArray.date}></td>
                    <td class='left'><{$messagesArray.ip}></td>


                    <td class="center width5"><{$messagesArray.edit_delete}></td>
                </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectormid}></th>
                    <th class="left"><{$selectoruid}></th>
                    <th class="left"><{$selectoruname}></th>
                    <th class="left"><{$selectormsg}></th>
                    <th class="left"><{$selectorcolor}></th>
                    <th class="left"><{$selectordate}></th>
                    <th class="left"><{$selectorip}></th>

                    <th class="center width5"><{$smarty.const.AM_ACHAT_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $messages</td>
                </tr>
            </table>
    </div>
<br>
<br>
    <{/if}>
