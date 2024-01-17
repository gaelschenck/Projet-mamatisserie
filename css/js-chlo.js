
var init = function () {
	createShop();
}
window.addEventListener("load", init);

var createShop = function () {
	var shop = document.getElementById("boutique");
	for(var i = 0; i < catalog.length; i++) {
		shop.appendChild(createProduct(catalog[i], i));
	}
}

var createBlock = function (tag, content, cssClass) {
	var element = document.createElement(tag);
	if (cssClass != undefined) {
		element.className =  cssClass;
	}
	element.innerHTML = content;
	return element;
}

var createFigureBlock = function (product) {
	return createBlock("figure", "<img src=" + product.image + " alt="+ product.name + ">", );
}



var createProduct = function (product, index) {
	var block = document.createElement("div");
	block.className = "produit";
	block.id = index + "-";
	// block.appendChild(createBlock("h4", product.name));
	block.appendChild(createFigureBlock(product)); 
	// block.appendChild(createBlock("div", product.description, "description"));
	return block;
}
