function getrecipeinfo(string)
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
		document.forms[0].type.value=xmlhttp.responseXML.getElementsByTagName("recipe_type")[0].childNodes[0].nodeValue;
		document.forms[0].style.value=xmlhttp.responseXML.getElementsByTagName("style_name")[0].childNodes[0].nodeValue;
		document.forms[0].style_og_min.value=xmlhttp.responseXML.getElementsByTagName("style_og_min")[0].childNodes[0].nodeValue;
		document.forms[0].style_og_max.value=xmlhttp.responseXML.getElementsByTagName("style_og_max")[0].childNodes[0].nodeValue;
		document.forms[0].style_fg_min.value=xmlhttp.responseXML.getElementsByTagName("style_fg_min")[0].childNodes[0].nodeValue;
		document.forms[0].style_fg_max.value=xmlhttp.responseXML.getElementsByTagName("style_fg_max")[0].childNodes[0].nodeValue;
		document.forms[0].style_ibu_min.value=xmlhttp.responseXML.getElementsByTagName("style_ibu_min")[0].childNodes[0].nodeValue;
		document.forms[0].style_ibu_max.value=xmlhttp.responseXML.getElementsByTagName("style_ibu_max")[0].childNodes[0].nodeValue;
		document.forms[0].style_color_min.value=xmlhttp.responseXML.getElementsByTagName("style_color_min")[0].childNodes[0].nodeValue;
		document.forms[0].style_color_max.value=xmlhttp.responseXML.getElementsByTagName("style_color_max")[0].childNodes[0].nodeValue;
		document.forms[0].style_abv_min.value=xmlhttp.responseXML.getElementsByTagName("style_abv_min")[0].childNodes[0].nodeValue;
		document.forms[0].style_abv_max.value=xmlhttp.responseXML.getElementsByTagName("style_abv_max")[0].childNodes[0].nodeValue;
		document.forms[0].est_og.value=xmlhttp.responseXML.getElementsByTagName("recipe_est_og")[0].childNodes[0].nodeValue;
		document.forms[0].est_fg.value=xmlhttp.responseXML.getElementsByTagName("recipe_est_fg")[0].childNodes[0].nodeValue;
		document.forms[0].est_abv.value=xmlhttp.responseXML.getElementsByTagName("recipe_est_abv")[0].childNodes[0].nodeValue;
		document.forms[0].est_ibu.value=xmlhttp.responseXML.getElementsByTagName("recipe_est_ibu")[0].childNodes[0].nodeValue;
		document.forms[0].est_color.value=xmlhttp.responseXML.getElementsByTagName("recipe_est_color")[0].childNodes[0].nodeValue;
	}
}

xmlhttp.open("GET","getrecipeinfo.php?q="+string,true);
xmlhttp.send();
}
