var data;
  		$.ajax ({
  			url: "http://black-market.kl.com.ua/", dataType: "json", success : (result) => {
  				data = result;
  				/*console.log(data);*/
  				get_categories();
 			}
  		})

function get_categories() {
	let cat = '';
	data.categories.map((category) => {
		cat += '<button onclick="fun_open('+category.category_id+')">'+category.name+'</button>';
	})
	document.querySelector("#sub-category").innerHTML = cat;
}

function fun_open(category_id)
{
	/*var others = document.getElementsByClassName('sub-category');
	for (var i=0;i<others.length;++i){
		var other = others[i].getElementsByTagName('button');
		for(var j=0;j<other.length;++j)
			other[j].style.display = 'none';
		others[i].style.display = 'none';
	}

	var sub_cat = document.getElementById(category_id);
	sub_cat.style['display'] = 'flex';
	sub_cat.style['flex-direction'] = 'column';
	var prods = sub_cat.getElementsByTagName('button');
	for (var i=0;i<prods.length;++i){
		prods[i].style.display = 'block';
		prods[i].style.width = '200px';
	}
	sub_cat.style['width'] = 'auto';*/
	let items = [];
	data.products.map((item) => {
		if (item.category_id == category_id){
			items.push(item);
		}
	})
	add_product_to_list(items);
	// console.log(items);
}

function add_product_to_list(products){
	let items = "";
	products.map((item) =>{
		items+='<div class="item">'+
		'<div class="information">'+
		'<div class="name">Назва продукту: '+item.title+'</div>'+
		'<div class="price">Ціна: '+item.price+' грн</div>';
		if (item.old_price != 0 && item.old_price != "")
			items+='<div class="old-price">Стара ціна: '+item.old_price+' грн</div>';
		items+='</div><img src="'+item.img+'" height="150px" width="200px"></div>';
	})
	document.querySelector(".content-container").innerHTML = items;
}
