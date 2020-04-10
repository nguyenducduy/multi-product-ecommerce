        <div><h3>Kết quả tìm kiếm</h3></div>
        {if {$countuser}>0}
            <table class="table table-condensed">
                <tr>

                    <th>dienmay ID</th>

                    <th>Avatar</th>

                    <th>Fullname</th>

                    <th>Department </th>

                    <th>Phone</th>

                    <th>Email</th>

                    <th>Region</th>

                    <th>Date Login</th>

                    <th>Thegioididong ID</th>

                </tr>
                {foreach $listuser as $k=>$v}
                <tr>

                    <td>
                        {$v->id}
                    </td>
                    <td>
                        <img src="{$v->imgavarta}" width="50px">
                    </td>
                    <td>
                        {$v->fullname}
                    </td>
                    <td>
                        {$v->depart}
                    </td>
                    <td>
                        {$v->phone}
                    </td>
                    <td>
                        {$v->email}
                    </td>
                    <td>
                        {$v->regionname}
                    </td>
                    <td>
                        {$v->lastdatef}
                    </td>
                    <td>
                        {$v->oauthUid}
                    </td>

                </tr>
                {/foreach}
                <tr>
                    <td colspan="9">
                        <div class="pagination">
                            {assign var="pageurl" value="page/::PAGE::"}
                                 {paginateajax count=$totalPage curr=$curPage lang=$paginateLang max=10 urlformat="sendpage('::PAGE::')"}
                        </div>
                    </td>
                    
                </tr>
            </table>
        {else}
            <table class="table table-condensed">
                <tr>

                    <tr>
                        <td colspan="9">
                            Không tìm thấy nhân viên bạn muốn tìm
                        </td>
                    </tr>

                </tr>

            </table>
        {/if}