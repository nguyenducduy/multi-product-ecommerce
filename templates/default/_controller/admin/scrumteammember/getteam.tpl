<div class="control-group" id="divstid">
		<label class="control-label" for="fstid">{$lang.controller.labelStid} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fstid" id="fstid">
				<option value='' selected>----</option>
				{foreach $team as $value}
				    <option value='{$value->id}' >{$value->name}</option>
				{/foreach}
			</select>
		</div>
</div>