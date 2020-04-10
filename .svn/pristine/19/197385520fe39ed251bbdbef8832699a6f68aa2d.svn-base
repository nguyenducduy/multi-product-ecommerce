<div id="dataTable1" class="handsontable" style="height:440px; overflow: scroll;">
    </div>
{literal}
    <script type="text/javascript">
	var data = {/literal}{$outputdataproduct}{literal}
	$(document).ready(function () {
        var maxed = false
            , resizeTimeout
            , availableWidth
            , availableHeight
            , $window = $(window)
            , $dataTable = $('#dataTable1');

         var calculateSize = function () {
        var offset = $dataTable.offset();
            availableWidth = $window.width() - offset.left + $window.scrollLeft();
            availableHeight = $window.height() - offset.top + $window.scrollTop();
        };

        var heightMax  = $window.height();
        var widthMax = $window.width();

        $window.on('resize', calculateSize);
        $dataTable.attr("width" , $window.width());

        var priceRender = function (instance, td, row, col, prop, value, cellProperties) {
                            var price = numeral(value).format('0,0');
                            td.innerHTML = price;
                            $(td).addClass('celleditor');
                            $(td).css({
                                /*background : 'yellow',*/
                                borderRightWidth: '11px',
                                textAlign : 'right'
                            });
                            return td;
                        };

        var yellowRender = function (instance, td, row, col, prop, value, cellProperties) {
                            td.innerHTML = value;
                            $(td).addClass('celleditor');
                            /*$(td).css({
                                background : 'yellow'
                            });*/
                            return td;
                        };

        var productRender = function (instance, td, row, col, prop, value, cellProperties) {
                            td.innerHTML = value;
                            $(td).addClass('cellreadonly');
                            /*$(td).css({
                                background : '#af9ec3'
                            });*/
                            return td;
                        };
        var categoryRender = function (instance, td, row, col, prop, value, cellProperties) {
                            td.innerHTML = value;
                            $(td).addClass('cellreadonly');
                            /*$(td).css({
                                background : '#ccc0da'
                            });*/
                            return td;
                        };

        var timeRender = function (instance, td, row, col, prop, value, cellProperties) {
                            td.innerHTML = value;
                            $(td).addClass('cellreadonly');
                            /*$(td).css({
                                background : '#e5e0ec'
                            });*/
                            return td;
                        };
        var costpriceRender = function (instance, td, row, col, prop, value, cellProperties) {
                            td.innerHTML = value;
                            $(td).addClass('celleditor');
                            $(td).css({
                                fontWeight : 'bold',
                                textAlign : 'right',
                            });
                            return td;
                        };

        var productnameRender = function (instance, td, row, col, prop, value, cellProperties) {
                            td.innerHTML = value;
                            $(td).addClass('cellreadonly');
                            $(td).css({
                                fontWeight : 'bold'
                            });
                            return td;
                        };
		var formularcellRender = function (instance, td, row, col, prop, value, cellProperties) {
                            td.innerHTML = value;
                            $(td).addClass('cellformular');
                            return td;
                        };
        $dataTable.handsontable({
            data: data,
            colWidths: [40, 40 , 170 ,  170 , 100 , 100 , 300 , 100 , 100 ,100 , 100, 100 , 100 , 100 ,100 , 100 ,100 ,100, 100 ,100 ,100, 100,100], //can also be a number or a function
            colHeaders: ["Year" , "Month" , "Category" , '<span class="dropsubcategory3">Sub Category</div>' , '<span class="titledropdown3">Brand</span>', "Barcode" , "SKU Name" , "STOCK Volume" , "STOCK value" , "STOCK <br/> sale-day" ,'TARGET-STOCK <br/> sale-day' ,  "STOCK volume <br /> 30 days" , "STOCK volume <br /> 60 days","STOCK volume <br /> 90 days" , "STOCK volume <br /> 120 days" , " STOCK volume <br /> > 120 days" , "STOCK value <br /> 30 days" , "STOCK value <br /> 60 days" , "STOCK value <br /> 90 days" , "STOCK value <br /> 120 days", "STOCK value <br /> > 120 days"],
            //stretchH: 'all',
            contextMenu: true,
            fixedColumnsLeft: 7,
            manualColumnResize: true,
            columnSorting: true,
            fillHandle: true, //possible values: true, false, "horizontal", "vertical"
            columns : [
                {
                     type: {renderer: timeRender},
                     readOnly: true
                },
                {
                     type: {renderer: timeRender},
                     readOnly: true
                },
                {
                    type: {renderer: categoryRender},
                    readOnly: true
                },
                {
                    type: {renderer: categoryRender},
                    readOnly: true
                },
                {
                     type: {renderer: categoryRender},
                     readOnly: true
                },
                {
                    type: {renderer: productRender},
                    readOnly: true
                },
                {
                    type: {renderer: productnameRender},
                    readOnly: true
                },
                {
                    type: {renderer: yellowRender}
                },
                {
                    type: {renderer: formularcellRender}
                },
                {
                    type: {renderer: formularcellRender}
                },
                {
                    type: {renderer: yellowRender}
                },
                {
                    type: {renderer: yellowRender}
                },
                {
                	type: {renderer: yellowRender}
                },
                {
                	type: {renderer: yellowRender}
                },
                {
                	type: {renderer: yellowRender}
                },
                {
                	type: {renderer: yellowRender}
                },
                {
                	type: {renderer: formularcellRender}
                },
                {
                	type: {renderer: formularcellRender}
                },
                {
                	type: {renderer: formularcellRender}
                },
                {
                	type: {renderer: formularcellRender}
                },
                {
                	type: {renderer: formularcellRender}
                }
            ],
        });


    });
	</script>
{/literal}