function getstyleinfo(string)
{
if (window.XMLHttpRequest)
{
	// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
}
else
{
	// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}

xmlhttp.onreadystatechange=function()
{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		document.recipeform.style_og_min.value=xmlhttp.responseXML.getElementsByTagName("style_og_min")[0].childNodes[0].nodeValue;
		document.recipeform.style_og_max.value=xmlhttp.responseXML.getElementsByTagName("style_og_max")[0].childNodes[0].nodeValue;
		document.recipeform.style_fg_min.value=xmlhttp.responseXML.getElementsByTagName("style_fg_min")[0].childNodes[0].nodeValue;
		document.recipeform.style_fg_max.value=xmlhttp.responseXML.getElementsByTagName("style_fg_max")[0].childNodes[0].nodeValue;
		document.recipeform.style_ibu_min.value=xmlhttp.responseXML.getElementsByTagName("style_ibu_min")[0].childNodes[0].nodeValue;
		document.recipeform.style_ibu_max.value=xmlhttp.responseXML.getElementsByTagName("style_ibu_max")[0].childNodes[0].nodeValue;
		document.recipeform.style_color_min.value=xmlhttp.responseXML.getElementsByTagName("style_color_min")[0].childNodes[0].nodeValue;
		document.recipeform.style_color_max.value=xmlhttp.responseXML.getElementsByTagName("style_color_max")[0].childNodes[0].nodeValue;
		document.recipeform.style_abv_min.value=xmlhttp.responseXML.getElementsByTagName("style_abv_min")[0].childNodes[0].nodeValue;
		document.recipeform.style_abv_max.value=xmlhttp.responseXML.getElementsByTagName("style_abv_max")[0].childNodes[0].nodeValue;
	}
}

xmlhttp.open("GET","getstyleinfo.php?q="+string,true);
xmlhttp.send();
}
