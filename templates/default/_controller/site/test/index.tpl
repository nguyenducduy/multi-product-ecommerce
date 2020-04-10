
<div id="example1"  class="handsontable"></div>
{literal}
    <script type="text/javascript">
        function getData() {
            return [
              ["", "Kia", "Nissan", "Toyota", "Honda"],
              ["2008", 10, 11, 12, 13],
              ["2009", 20, 11, 14, 13],
              ["2010", 30, 15, 12, 13]
            ];
          }
          $("#example1").handsontable({
            data: getData(),
            startRows: 5,
            startCols: 5,
            minRows: 5,
            minCols: 5,
            maxRows: 10,
            maxCols: 10,
            rowHeaders: true,
            colHeaders: true,
            minSpareRows: 1,
            contextMenu: true
          });
    </script>
{/literal}