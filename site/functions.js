/*function get_categories() {
	var vagues = [];
	for (var i=0;i<data.categories.length;++i){
		if (data.categories[i].parent_id == null && data.categories[i].parent_id != "1" && data.categories[i].parent_id != "2") {
			vagues.push(data.categories[i]);
			continue;
		}

		if (data.categories[i].parent_id == null)
			continue;

		var bFoundParent = false;
		for (var j=0;j<data.categories.length;++j)
			if (data.categories[i].parent_id == data.categories[j].category_id){
				bFoundParent = true;
				break;
			}

		if (bFoundParent == false)
			vagues.push(data.categories[i]);
	}
	return vagues;
}*/

function fun_open(category_id)
{
	var others = document.getElementsByClassName('sub-category');
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
	sub_cat.style['width'] = 'auto';
}
