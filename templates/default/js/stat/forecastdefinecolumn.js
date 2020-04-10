var priceRender = function (instance, td, row, col, prop, value, cellProperties) {
	var price = numeral(value).format('0,0');
	td.innerHTML = price;
	$(td).addClass('celleditor');
	$(td).css({
		borderRightWidth: '11px',
		textAlign : 'right'
	});
	return td;
};

var readonlyRender = function (instance, td, row, col, prop, value, cellProperties) {
	td.innerHTML = value;
	$(td).addClass('cellreadonly');
	return td;
};

var editorRender = function (instance, td, row, col, prop, value, cellProperties) {
	td.innerHTML = value;
	$(td).addClass('celleditor');
	return td;
};

var formularRender = function (instance, td, row, col, prop, value, cellProperties) {
	td.innerHTML = value;
	$(td).addClass('cellformular');
	return td;
};