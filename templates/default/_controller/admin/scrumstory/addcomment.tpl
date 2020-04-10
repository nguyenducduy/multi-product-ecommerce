
<li>
	<div class="user"  >
		<span >
			<a href="#">
			<img style="height:50px" src="{if {$comment->avatar}!=""}{$conf.rooturl}uploads/avatar/{$comment->avatar}{else}{$conf.rooturl}templates/default/images/plainicon.jpg{/if}"  width="50" />
			</a>
		</span>
	</div>
	<div class="noidung" id="noidung_{$comment->id}">
		<p>
			<a href="#">{$comment->username}</a>
			<input type="hidden" id="newid" value="{$comment->id}">
		</p>
		<p class="ptime adddown_{$comment->id}" >{$comment->datecreate} &nbsp<span class="btn btn-mini" onclick="editaction(this,'{$comment->id}')"><i class="icon-pencil"></i></span>&nbsp<a style="{if {$comment->filepath==""}}display:none{/if}" class="btn btn-mini" href="{$comment->filepath}" id="download_{$comment->id}"><i class="icon-paper-clip" ></i></a><a class="sb-nav-close exit_{$comment->id}" onclick="cancel();"  title="Close" style="display:none"></a></p>
		<div class="message_txt" id="content_{$comment->id}" >
			{$comment->content}
		</div>
	</div>
</li>