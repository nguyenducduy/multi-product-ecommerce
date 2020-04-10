<div id="dashboard">
	<div id="dashinfo">
		<h1>Data Since 01/01/2013</h1>
		<input type="hidden" id="dateRangeStart" value="{$dateRangeStart}" />
		<ul class="stats-plain">
			<li>										
				<h4 id="totalArchivedOrder">- - -</h4>
				<span>{$lang.controller.totalArchivedOrder}</span>
			</li>
			<li>										
				<h4 id="totalArchivedOrderAmount">- - -</h4>
				<span>{$lang.controller.totalArchivedOrderAmount}</span>
			</li>
			<li>										
				<h4 id="totalAccount">- - -</h4>
				<span>{$lang.controller.totalAccount}</span>
			</li>
			<li>										
				<h4 id="totalAccountOnline">- - -</h4>
				<span>{$lang.controller.totalAccountOnline}</span>
			</li>
			<li>										
				<h4 id="totalProductView">- - -</h4>
				<span>{$lang.controller.totalProductView}</span>
			</li>
			<li>										
				<h4 id="totalNewsView">- - -</h4>
				<span>{$lang.controller.totalNewsView}</span>
			</li>
			<li>										
				<h4 id="totalPageView">- - -</h4>
				<span>{$lang.controller.totalPageView}</span>
			</li>
			
			<li>										
				<h4 id="totalAdsClick">- - -</h4>
				<span>{$lang.controller.totalAdsClick}</span>
			</li>
			
			<li>										
				<h4 id="totalStuff">- - -</h4>
				<span>{$lang.controller.totalStuff}</span>
			</li>
			<li>										
				<h4 id="totalStuffView">- - -</h4>
				<span>{$lang.controller.totalStuffView}</span>
			</li>
			
			
			
			
		</ul>
	</div><!-- end #dashinfo -->
	<div id="realtimemap"></div><!-- end #map -->
</div><!-- end #dashboard -->
	
{literal}
<script type="text/javascript">
	var map;
	
	function map_initialize() {
	    var myOptions = {
	      zoom: 6,
	      center: new google.maps.LatLng(16.066667, 108.233333),
	      mapTypeId: google.maps.MapTypeId.ROADMAP,
	      mapTypeControl: false,
	      backgroundColor: '#fff',
	      zoomControl: false,
	      streetViewControl: false,
	      panControl: false,
	      styles: [
	        {
	          stylers: [
	            { visibility: "off" }
	          ]
	        },{
	          featureType: "water",
	          stylers: [
	            { visibility: "on" },
	            { lightness: -10 },
	            { saturation: -10 }
	          ]
	        },{
	          featureType: "administrative.province",
	          elementType: "geometry",
	          stylers: [
	            { visibility: "off" }
	          ]
	        },{
	          featureType: "administrative.country",
	          elementType: "geometry",
	          stylers: [
	            { visibility: "on" }
	          ]
	        },{
	          featureType: "water",
	          elementType: "labels",
	          stylers: [
	            { visibility: "off" }
	          ]
	        }
	      ]
	    };
	    map = new google.maps.Map(document.getElementById("realtimemap"), myOptions);
	  }
	
	function map_bubble(lat, lng)
	{
	
		
		var location = new google.maps.LatLng(lat, lng);

		    var outer = new google.maps.Marker({
		      position: location,
		      clickable: false,
		      icon: {
		        path: google.maps.SymbolPath.CIRCLE,
		        fillOpacity: 0.5,
		        fillColor: '#f00',
		        strokeOpacity: 1.0,
		        strokeColor: '#f00',
		        strokeWeight: 1.0,
		        scale: 0,
		      },
		      optimized: false,
		      map: map
		    });
		
		for (var i = 0; i <= 10; i++) {
		      setTimeout(setScale(outer, i / 10), i * 60);
		}
		
	}
	
	function setScale(outer, scale) {
	    return function() {
	      if (scale == 1) {
	        outer.setMap(null);
	      } else {
	        var icono = outer.get('icon');
	        icono.strokeOpacity = Math.cos((Math.PI/2) * scale);
	        icono.fillOpacity = icono.strokeOpacity * 0.5;
	        icono.scale = Math.sin((Math.PI/2) * scale) * 25;
	        outer.set('icon', icono);

	      }
	    }
	  }
	
	$(document).ready(function(){
		map_initialize();
		setTimeout("markersampleHCM()", 400);
		setTimeout("markersampleAnGiang()", 600);
		setTimeout("markersampleTayNinh()", 800);
		setTimeout("markersampleVinhLong()", 700);
		setTimeout("markersampleBaRia()", 500);
		setTimeout("markersampleSocTrang()", 900);
		setTimeout("markersampleDaklak()", 1000);
		dashboardReload();
	});
	
	function markersampleHCM()
	{
		map_bubble(10.769444, 106.681944);
		setTimeout("markersampleHCM()", 400);
	}
	
	function markersampleAnGiang()
	{
		map_bubble(10.381116, 105.419884);
		setTimeout("markersampleAnGiang()", 2000);
	}
	
	function markersampleTayNinh()
	{
		map_bubble(11.367795, 106.119003);
		setTimeout("markersampleTayNinh()", 1000);
	}
	
	function markersampleVinhLong()
	{
		map_bubble(10.244823, 105.959015);
		setTimeout("markersampleVinhLong()", 1500);
	}
	
	function markersampleBaRia()
	{
		map_bubble(10.410157, 107.136555);
		setTimeout("markersampleBaRia()", 1200);
	}
	
	
	
	function markersampleSocTrang()
	{
		map_bubble(9.602781, 105.973949);
		setTimeout("markersampleSocTrang()", 3000);
	}
	
	function markersampleDaklak()
	{
		map_bubble(12.766268, 108.325195);
		setTimeout("markersampleDaklak()", 900);
	}
	
	function dashboardReload()
	{
		$.ajax({
		   type: "GET",
		   dataType: 'xml',
		   url: rooturl + 'stat/index/indexajax?dateRangeStart=' + $('#dateRangeStart').val(),
		   success: function(xml){
			
				var totalAccount = $(xml).find('totalAccount').text();
				var totalAccountOnline = $(xml).find('totalAccountOnline').text();
				var totalArchivedOrder = $(xml).find('totalArchivedOrder').text();
				var totalArchivedOrderAmount = $(xml).find('totalArchivedOrderAmount').text();
				var totalProductView = $(xml).find('totalProductView').text();
				var totalNewsView = $(xml).find('totalNewsView').text();
				var totalStuffView = $(xml).find('totalStuffView').text();
				var totalPageView = $(xml).find('totalPageView').text();
				var totalStuff = $(xml).find('totalStuff').text();
				var totalAdsClick = $(xml).find('totalAdsClick').text();
				
				$('#totalAccount').html(numberWithCommas(totalAccount));
				$('#totalAccountOnline').html(numberWithCommas(totalAccountOnline));
				$('#totalArchivedOrder').html(numberWithCommas(totalArchivedOrder));
				$('#totalArchivedOrderAmount').html(numberWithCommas(totalArchivedOrderAmount));
				$('#totalProductView').html(numberWithCommas(totalProductView));
				$('#totalNewsView').html(numberWithCommas(totalNewsView));
				$('#totalStuffView').html(numberWithCommas(totalStuffView));
				$('#totalPageView').html(numberWithCommas(totalPageView));
				$('#totalStuff').html(numberWithCommas(totalStuff));
				$('#totalAdsClick').html(numberWithCommas(totalAdsClick));
				
		   }
		 });
		
		setTimeout("dashboardReload()", 5000);
	}
	
</script>
{/literal}

