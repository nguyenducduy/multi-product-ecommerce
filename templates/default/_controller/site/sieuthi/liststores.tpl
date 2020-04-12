<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/supermarket.css" media="screen" />
<ul class="navbarprod">
    <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a> ››</li>    
    <li>Hệ thống siêu thị dienmay.com</li>
</ul>
<div class="wrap_supermark">
    <div class="mark_left">
        <h3 id="titlestoreproduct" rel="3_10.8231_106.63"></h3>
        <div class="s_point">
            <select name="listregion" id="listregion">
                <option value="">Danh sách tỉnh thành</option>
                <option value="{$conf.rooturl}sieuthi">Xem Tất cả</option>
                {if !empty($listregions)}
                    {foreach from=$listregions item=ritem}
                        <option {if $regionid == $ritem->id}selected="selected" {/if} value="{$ritem->getRegionPath()}">{$ritem->name}</option>
                    {/foreach}
                {/if}
            </select>
        </div>        
        <div id="showmaplist"></div>
        
    </div>
  <div class="mark_right" id="liststore">
    {if !empty($liststores)}
        <ul>
        {foreach from=$liststores item=str}
            {if $str->lat !=0 && $str->lng !=0}
             <li>
                <a href="{$str->getStorePath()}" id="{$str->lat}_{$str->lng}" rel="{$str->region}_{$listregions[$str->region]->lat}_{$listregions[$str->region]->lng}">{$str->name}</a>
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

            LoadListStore();
        $('#listregion').unbind('change').change(function(){
            var url = $(this).val();
            window.location.href = url;
        });
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

    function LoadListStore(){
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
            map = new google.maps.Map(document.getElementById("showmaplist"), mapOptions);//
            /*$('#listregion').unbind('change').change(function(){
                var currid = parseInt($(this).val());
                if(currid >0 )
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
                                map = new google.maps.Map(document.getElementById("showmaplist"), mapOptions);
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
                else if(currid == -1)
                {
                    var mapOptions = {
                        center: new google.maps.LatLng(curlat, curlng),
                        zoom: 15,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    map = new google.maps.Map(document.getElementById("showmaplist"), mapOptions);
                    $('#liststore li').each(function(){
                        $(this).css('display','block');
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
                        //}
                    });
                    map.setZoom(8);
                }
            });*/
            var i = 0;
            $('#liststore li').each(function(){
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
                            infowindow.setContent(createHtmlStore(obj.find('a').html(),obj.find('.saddress').html(),obj.find('.sfax').html(),obj.find('.sphone').html()));                               infowindow.open(map, marker);
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
            });
            map.setZoom(8);
        }
    }
</script>