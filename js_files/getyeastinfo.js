function getyeastinfo(string)
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
		document.recipeform.yeast0_id.value=xmlhttp.responseXML.getElementsByTagName("yeast_id")[0].childNodes[0].nodeValue;
		document.recipeform.yeast0_type.value=xmlhttp.responseXML.getElementsByTagName("yeast_type")[0].childNodes[0].nodeValue;
		document.recipeform.yeast0_form.value=xmlhttp.responseXML.getElementsByTagName("yeast_form")[0].childNodes[0].nodeValue;
		document.recipeform.yeast0_attenuation.value=xmlhttp.responseXML.getElementsByTagName("yeast_attenuation")[0].childNodes[0].nodeValue;
		document.recipeform.yeast0_flocculation.value=xmlhttp.responseXML.getElementsByTagName("yeast_flocculation")[0].childNodes[0].nodeValue;
		
		// update the recipe og and fg in the style characteristics table
		calc_og();
	}
}

xmlhttp.open("GET","getyeastinfo.php?q="+string,true);
xmlhttp.send();
}
