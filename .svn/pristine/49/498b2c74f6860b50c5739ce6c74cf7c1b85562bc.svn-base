<!-- navigation bar -->
<div class="navbarprod asdasd">
    <ul>
        <li><a href="{$conf.rooturl}" title="Về trang chủ dienmay.com">Trang chủ</a> ››</li>
        
    </ul>
</div>
<!-- content -->
<div id="container">

    <!-- content detail -->
    <div class="articlesdetail">
    
    <div class="main">
      <article class="post__article">
        <div class="wrap_article" style="width:100%">
         <!-- Bài viết -->
             {if !empty($productDetail->content)}
        <div id="articles" class="s3" style="width:100%">
                  <div class="articlesbar" id="introduction"><h2>Bài viết sản phẩm</h2></div>
                  <div class="articles">
                    {$productDetail->content}
                  </div>
                
                </div>
        {/if}

       <div class="clear"></div>

        <h6>Nhận xét</h6>
         <!-- Comment -->
            <div id="comment">
                   
            </div>
      </article>
  </div>

</div>

{literal}
<script type="text/javascript">
  var pid = "{/literal}{$productDetail->id}{literal}";
  $(document).ready(function(){
      
      //Load comment
      loadReview(pid , '');
      //End load cmment
 
  });

</script>
{/literal}