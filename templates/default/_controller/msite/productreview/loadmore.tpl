{if $productreviewList|@count > 0}
        {foreach item=productreviews key=parentid from=$productreviewList}
            {foreach item=productreview from=$productreviews name=foo}
                
                    {if $smarty.foreach.foo.first}
                        <li>
                        <div class="nameuser">{if in_array($productreview->uid , $admindienmayarr)}dienmay.com{else}{$productreview->fullname}{/if}<span style="float:right;font-weight: normal;font-size:12px;"><i>{$productreview->datecreated|date_format:"%H:%M Ngày: %d/%m/%Y"}</span></i></div>
                            <div class="contuser">{$productreview->text}</div>
                           
                            <div class="right">
                                <div id="likeproductreview{$productreview->id}">
                                    <a href="javascript:void(0)" {if $smarty.session.productreviewthumb[$productreview->id] != $productreview->id}onclick="likereview({$fpid},{$productreview->id})" {else}style="background:#f1f1f1"{/if}>Thích</a>
                                    <span id="likecom{$productreview->id}">{$productreview->countthumbup}</span>
                                </div>
                                <!-- reply-->
                                <!--
                                <div class="click reply"><a href="javascript:void(0)" onclick="replyopen({$productreview->id})" style="border: none;border-radius: 0;color:#900">Trả lời</a></div>
                                <div class="dropdown_{$productreview->id} wrapreply">
                                    <textarea class="contreply" name="freviewcontentreply{$productreview->id}" id="freviewcontentreply{$productreview->id}"  cols="3" rows="" placeholder="Nội dung"></textarea>
                                      <a href="javascript:void(0)" onclick="sendReview({$fpid} , {$productreview->id} , {if $me->id > 0}1{else}0{/if} , 1)" style="background: #900;border-radius:0;color: #fff;margin-top: 2px;">Gửi</a>
                                </div>
                                -->
                            </div>
                            
                        <!-- Reply-->
                         {else}
                            <div class="listreply">
                                <ul>
                                    <li>
                                        <div class="nameuser">{if in_array($productreview->uid , $admindienmayarr)}dienmay.com{else}{$productreview->fullname}{/if}<span style="float:right;font-weight: normal;font-size:12px;"><i>{$productreview->datecreated|date_format:"%H:%M Ngày: %d/%m/%Y"}</i></span></div>
                                        <div class="contuser">{$productreview->text}</div>
                                        <div class="right">
                                            <div id="likeproductreview{$productreview->id}">
                                                <a href="javascript:void(0)" onclick="likereview({$fpid},{$productreview->id})">Thích</a>
                                                <span id="likecom{$productreview->id}"><i class="icon-likecom"></i>{$productreview->countthumbup}</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            </li>
                        {/if}
                    
            {/foreach}
        {/foreach}
    {/if}