<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/stores.css" media="screen" />
<div class="warranty">
	<h2 id="titlepopup">Danh sách siêu thị còn hàng</h2>
    <div class="mark_left">
        <h3 id="titlestoreproduct" rel="{$firstRegion->id}_{$firstRegion->lat}_{$firstRegion->lng}"></h3>
        <div class="s_point">
            <!--<input name="" type="text" placeholder="Nhập tên tỉnh/thành phố cần tìm" style="float:left" />
            <input class="btn-all go" type="submit" value="Tìm" style="margin-left:-2px" />-->
            <select name="listregion" id="listregion">
              <option value="">Danh sách tỉnh thành</option>
              {if !empty($listregions)}
                {foreach from=$listregions item=ritem}
                    <option value="{$ritem->id}">{$ritem->name}</option>
                {/foreach}
              {/if}                
            </select>            
        </div>        
        <div id="showmap"></div>
        
    </div>
  <div class="mark_right" id="liststore">
    {if !empty($liststores)}
        <ul>
        {foreach from=$liststores item=str}
            {if $str->lat !=0 && $str->lng !=0}
             <li>
                <a href="javascript:void(0)" id="{$str->lat}_{$str->lng}" rel="{$str->region}_{$listregions[$str->region]->lat}_{$listregions[$str->region]->lng}">{$str->name}</a>                
                <p class="sphone">{$str->storephonenum}</p>
                <p class="sfax">{$str->storefax}</p>
                <div class="saddress">{$str->storeaddress}</div>
            </li>
            {/if}
        {/foreach}
        </ul>
    {/if}
  </div>
</div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">    
    var map;
    var infowindow = new google.maps.InfoWindow();
    var icondm = new google.maps.MarkerImage('https://ecommerce.kubil.app/templates/default/images/site/mapdienmay.png',
                new google.maps.Size(22, 37),
                new google.maps.Point(0, 0),
                new google.maps.Point(0, 0));

    var icondmac = new google.maps.MarkerImage('https://ecommerce.kubil.app/templates/default/images/site/mapdienmayactive.png',
                new google.maps.Size(22, 37),
                new google.maps.Point(0, 0),
                new google.maps.Point(0, 0));    
    $(document).ready(function(){
        var strregionlatlng = $('#titlestoreproduct').attr('rel');
        var regionlatlng = strregionlatlng.split('_');
        if(regionlatlng.length ==3)
        {
            var curregion = regionlatlng[0];
            var curlat = regionlatlng[1];
            var curlng = regionlatlng[2];            
            
            var firstobj;            
            
            var mapOptions = {
                  center: new google.maps.LatLng(curlat, curlng),
                  zoom: 15,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                };
            map = new google.maps.Map(document.getElementById("showmap"), mapOptions);
            
            $('#liststore li').each(function(){
               var childstrregionlatlng = $(this).find('a').attr('rel');
               if(childstrregionlatlng==strregionlatlng) 
               {
                   $(this).css('display','block');
               }
               else {
                   $(this).removeClass('active');
                   $(this).css('display','none');
               }
            });
            $('#listregion option[value="' + curregion + '"]').attr('selected', true);
            $('#listregion').unbind('change').change(function(){
                var currid = $(this).val();                
                if(currid !='')
                {
                    var i = 0;
                    var childcurlat, childcurlng;
                    $('#liststore li').each(function(){
                    var childstrregionlatlng = $(this).find('a').attr('rel');
                    var childregionlatlng = childstrregionlatlng.split('_');
                    var childcurregion = childregionlatlng[0];                        
                       if(currid==childcurregion) 
                       {
                           if(!childcurlat && !childcurlng)
                            {
                                childcurlat = childregionlatlng[1];
                                childcurlng = childregionlatlng[2];
                                var mapOptions = {
                                  center: new google.maps.LatLng(childcurlat, childcurlng),
                                  zoom: 15,
                                  mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                map = new google.maps.Map(document.getElementById("showmap"), mapOptions);
                            }
                           var obj = $(this);
                            var latlng = obj.find('a').attr('id');
                            var arrlg = latlng.split("_");
                            if(arrlg.length ==2)
                            {
                                var marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(arrlg[0], arrlg[1]),
                                    map: map,
                                    icon: icondm
                                });                        
                                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                    return function () {                                
                                        infowindow.setContent(createHtmlStore(obj.find('a').html(),obj.find('.saddress').html(),obj.find('.sphone').html(),obj.find('.sfax').html()));                               infowindow.open(map, marker);
                                    }
                                })(marker, i));
                                google.maps.event.addListener(marker, "mouseover", (function (marker, i) {
                                    return function () {
                                        marker.setIcon(icondmac);
                                    }
                                })(marker, i));
                                google.maps.event.addListener(marker, 'mouseout', (function (marker, i) {
                                    return function () {
                                        marker.setIcon(icondm);
                                    }
                                })(marker, i));
                            }
                            i++;
                           map.setZoom(8);
                           $(this).css('display','block');
                       }
                       else {
                           $(this).removeClass('active');
                           $(this).css('display','none');
                       }
                    });                    
                }
            });
            $(window).load(function() {
                var i = 0;                
                $('#liststore li').each(function(){
                    if($(this).css('display')=='block')
                    {
                        var obj = $(this);
                        var latlng = obj.find('a').attr('id');
                        var arrlg = latlng.split("_"); 
                        if(arrlg.length ==2)
                        {
                            var marker = new google.maps.Marker({
                                position: new google.maps.LatLng(arrlg[0], arrlg[1]),
                                map: map,
                                icon: icondm
                            });                        
                            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                return function () {                                
                                    infowindow.setContent(createHtmlStore(obj.find('a').html(),obj.find('.saddress').html(),obj.find('.sphone').html(),obj.find('.sfax').html()));                               infowindow.open(map, marker);
                                }
                            })(marker, i));
                            google.maps.event.addListener(marker, "mouseover", (function (marker, i) {
                                return function () {
                                    marker.setIcon(icondmac);
                                }
                            })(marker, i));
                            google.maps.event.addListener(marker, 'mouseout', (function (marker, i) {
                                return function () {
                                    marker.setIcon(icondm);
                                }
                            })(marker, i));
                        }
                        i++;
                    }
                });
                map.setZoom(8);
            });
            
            $('#liststore li').unbind('click').click(function(){
                $('#liststore li').removeClass('active');
                $(this).addClass('active');
                var obj = $(this);
                var childstrregionlatlng = obj.find('a').attr('id');
                var arrlg = childstrregionlatlng.split('_');
                if(arrlg.length == 2)
                {
                    var positionmap = new google.maps.LatLng(arrlg[0], arrlg[1]);
                    //map.setCenter(positionmap);
                    var mapOptions = {
                          center: positionmap,
                          zoom: 15,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                    map = new google.maps.Map(document.getElementById("showmap"), mapOptions);
                    marker = new google.maps.Marker({
                        map: map,
                        position: positionmap,
                        icon: icondmac
                    });
                    infowindow.setContent(createHtmlStore(obj.find('a').html(),obj.find('.saddress').html(),obj.find('.sphone').html(),obj.find('.sfax').html()));
                    infowindow.open(map, marker);          
                }
            });
        }       
    });
    function createHtmlStore(storename, storeaddress, fax, phone)
    {
        var strImageIcon = '';
        strImageIcon = 'http://www.dienmay.com/favicon.ico';
        storename = '' + storename;
        var strResult = '<div class="store-info">';
        strResult += '<div class="l"><div class="img"><img src="https://ecommerce.kubil.app/templates/default/images/site/logo-dien-may.png" alt="' + storename + '" width=100/></div></div>';
        strResult += '<div class="r"><h4>' + storename + '</h4>';
        strResult += '<div class="address"><strong>Địa chỉ:</strong> <span>' + storeaddress + '</span></div>';
        if (phone !='' ) strResult += '<div class="phone"><strong>Điện thoại:</strong> <span>' + phone + '</span></div>';
        if(fax !='') strResult += '<div class="fax"><strong>Fax:</strong> <span>' + fax + '</span></div>';
        strResult += '<div class="mail"><strong>Email:</strong> <span>cskh@dienmay.com</span></div>';        
        strResult += '</div></div>';
        return strResult;
    }
</script>