{if $listpromotions|@count > 0}
            		<table class="table">
                    <thead>
                        <tr>
                        	<th></th>
                            <th>Promotion ID</th>
                            <th>Promotion Name</th>
                            <th>Tỉnh</th>
                            <th>Show giá gạch</th>
                            <th>Trạng thái khuyến mãi</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
            		{foreach key=rid item=promotion from=$listpromotions name=foo}                       
            			{if !empty($promotion.promotion)}
            			{foreach item=promo from=$promotion.promotion}
                        {assign var="displaystatus" value="$promo.promoid"}
            			<tr>
            				<td><input type="checkbox" name="fapplyprid[{$rid}]" value="{$promo.promoid}" {if $applypromotionlist|@count > 0}
            					{foreach item=prid key=reid from=$applypromotionlist}
            					{if $prid == $promo.promoid && $rid == $reid}
            						checked="checked"
            					{/if}
            					{/foreach}
            					{else}checked="checked"{/if} /></td>
            				<td>{$promo.promoid}</td>
            				<td>{$promo.promoname}</td>
            				<td>{$promotion.regionname}</td>
            				<td>{if !empty($listcurrentpromotion[$rid]) && $listcurrentpromotion[$rid] == $promo.promoid}<span class="label label-warning">YES</span>{/if}</td>
                            <td>
                            {if $smarty.foreach.foo.first || $promo.promoid == $displaystatus}  
                                 {assign var="displaystatus" value="$promo.promoid"}
                                <select name="{$promo.promoid}" class="promotionstatus"><!--fstatuspromo[-->
                                   	{html_options options=$promostatusList selected=$promo.promotionstatus}
                                    {assign var="displaystatus" value="0"}
                                </select>
                            {/if}
                            </td>
            				<td></td>                            
            			</tr>
            			{/foreach}
            			{/if}
            		{/foreach}
            			<tr><td colspan="2" align="center">
            				<input type="button" id="fsubmitpromotion" name="fsubmitpromotion" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
            			</td></tr>
            		</tbody>
            		</table>
            	{else}
            	Sản phẩm này hiện thời không có chương trình khuyến mãi nào.
            	{/if}
