
	<div class="lbev-header">
	    <div class="lbev-header-center">

        </div>
    	<div class="lbev-header-left">   
        	<ul class="lbev-header-button">
                <li class="lbev-button lbev-button-prev-month" style="display: inline-block;">
                	<a href="javascript:void(0)" onclick="calendar_load('previous')">&lt;&lt; Previous Month</a>
				</li>
                <li class="lbev-button lbev-button-next-month" style="display: inline-block;">
                	<a href="javascript:void(0)" onclick="calendar_load('next')">Next Month &gt;&gt;</a>
				</li>

				{if $showTodayMonthLink == 1}
                <li class="lbev-button lbev-button-today lbev-button-visible">
                	<a href="javascript:void(0)" onclick="calendar_load('')">Current Month</a>
				</li>
				{/if}
				
				<li>
                	<h3 class="lbev-cur" style="display: block;">{$firstDayOfMonth|date_format:"F Y"} &nbsp;</h3>
					<input type="hidden" id="firstdayofmonth" value="{$firstDayOfMonth}" />
                </li>

			</ul>    

        </div>        
        <div class="lbev-header-right">
        	<ul class="lbev-header-button">            
				<li class="lbev-button"><a href="javascript:void(0)" onclick="alert('Đang mần')" class="btn btn-success" style="color:#fff;text-shadow:none;-webkit-text-shadow:none;"><i class="icon-plus"></i> Add Event</a></li>
                                                <li class="lbev-button lbev-button-month"><a href="#month" class="current">Month</a></li>
                                <li class="lbev-button lbev-button-day" style="display:none;"><a href="#day">Day</a></li>
                                <li class="lbev-button lbev-button-events"><a href="#events">Events</a></li>
                <!--<li class="lbev-button lbev-button-add-event"><a href="#filter">Filter</a></li>-->
                            </ul>
        </div>
        <div class="lbev-clear"></div>
    </div>


	<div class="lbev-body" style="height: 884px;">


	    <div class="lbev-month-view lbev-invisible lbev-visible" style="border-top-width: 1px; border-top-style: solid; border-top-color: rgb(204, 204, 204); border-left-width: 1px; border-left-style: solid; border-left-color: rgb(204, 204, 204);">

			<ul class="lbev-calendar-header">
				<li><span>Monday</span></li>
				<li><span>Tuesday</span></li>
				<li><span>Wednesday</span></li>
				<li><span>Thursday</span></li>
				<li><span>Friday</span></li>
				<li class="sat"><span>Saturday</span></li>
				<li class="sun"><span>Sunday</span></li>
			</ul>    

			{assign var=daycounter value=0}
			<ul class="lbev-calendar-week">
			{foreach item=dayinfo from=$monthDayList}
				<li class="lbev-day lbev-day-{$daycounter} {if $daycounter == 5}lbev-sat{elseif $daycounter == 6}lbev-sun{/if} {if $dayinfo.type == 'prev' || $dayinfo.type == 'next'}lbev-outday{elseif $dayinfo.today == 1}lbev-current{/if}" style=" height: 141px;">
					<div class="lbev-day-wrapper">
						{if $dayinfo.today == 1}
							<span style="font-size:11px;position:absolute;top:11px;left:5px;background-color:#0A99E7;color:#FFF;-webkit-border-radius:10px;padding:2px 8px;line-height:11px;">Today</span>
						{/if}
						<span class="lbev-dayname" style="line-height:141px;">{$dayinfo.timestamp|date_format:"d"}</span>
					</div>
				</li>
			
			
				{assign var=daycounter value=$daycounter+1}
				{if $daycounter == 7}
					<div class="cl"></div>
					</ul>
					{assign var=daycounter value=0}
					<ul class="lbev-calendar-week">
				{/if}	
			{/foreach}
			</ul>
			
		</div>
	</div>


