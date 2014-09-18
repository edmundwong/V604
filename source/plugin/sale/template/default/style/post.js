/**
* Post Flow Javascript v4.
× bobo.
*/
function $(id){
	return document.getElementById(id);
}

function showSc(v){
	firstCategoryEname = v.title;
	firstCategoryCname = v.innerHTML;
	
	$('secondCategory').innerHTML = $(v.title).innerHTML;
	$('secondCategory').style.display = 'block';
	$('jiantou').style.display = 'block';

	$('category').value = '';
	$('categoryCheck').innerHTML = '';
	$('categoryCheck').className = 'check';

	var fcategory = $('firstCategory');
	var fas = fcategory.getElementsByTagName('a');
	for(var i=0; i<fas.length; i++){
		fas[i].className = 'n';
		if(fas[i] == v) fas[i].className = 'on';
	}
	$('seCategory').style.display = 'none';
	$('setAttribute').innerHTML = '';
	$('setAttribute').style.display = 'none';

	return false;
}