<{foreach item=post from=$messages}>
    <div class="achat_dp" id="achat_p<{$post.mid}>">
        <span class="achat_<{if $post.uid == 0}>guest_<{/if}>uname" <{if $post.uid != 0}>style="color:#<{$post.color}>;" <{/if}>title="<{$post.date}><{if $xoops_isadmin == 1}> | <{$post.ip}> | <{$post.mid}><{/if}>"><{$post.uname}>: </span>
        <span class="achat_message" style="color:#<{$post.color}>;"> <{$post.msg}> </span>
    </div>
    <{/foreach}>
