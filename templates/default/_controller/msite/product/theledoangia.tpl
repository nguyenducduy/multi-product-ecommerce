 <section>
    	<div class="navibarlist">
        	<ul>
            	 <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ ››</a> </li>
               
                <li><a><span>Thể lệ chương trình</span></a></li>
            </ul>
        </div>
        <!-- Thông số kỹ thuật -->    
        <div class="conttable">


		<div class="conttitle"><div class="back"><a href="javascript:history.back();">&#171;Trở về</a></div>Thể lệ chương trình</div>
        <div class="rulemobile">
        	{$myproductguess->rule}
        </div>
       
        
    	  
        
        <div class="back-bottom" style=" margin-bottom: 10px; margin-left: 20px;"><a href="javascript:history.back();" style="text-decoration: none;
color: #fff;
background: #00a1e6;
padding: 10px 20px;
border-radius: 5px;">&#171;Trở về</a>
    </div>       
        
</section>
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$productDetail->pcid}{literal}";
var pid = "{/literal}{$productDetail->id}{literal}";
var fgpa = "{/literal}{$gpa}{literal}";
var fpa = "{/literal}{$pa}{literal}";
var prel = "{/literal}{$prel}{literal}";
</script>
{/literal}