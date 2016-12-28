function getyeastinfo(string,num)
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
		document.forms[0]["yeast"+num+"_id"].value=xmlhttp.responseXML.getElementsByTagName("yeast_id")[0].childNodes[0].nodeValue;
		document.forms[0]["yeast"+num+"_type"].value=xmlhttp.responseXML.getElementsByTagName("yeast_type")[0].childNodes[0].nodeValue;
		document.forms[0]["yeast"+num+"_form"].value=xmlhttp.responseXML.getElementsByTagName("yeast_form")[0].childNodes[0].nodeValue;
		document.forms[0]["yeast"+num+"_attenuation"].value=xmlhttp.responseXML.getElementsByTagName("yeast_attenuation")[0].childNodes[0].nodeValue;
		document.forms[0]["yeast"+num+"_flocculation"].value=xmlhttp.responseXML.getElementsByTagName("yeast_flocculation")[0].childNodes[0].nodeValue;
		
		// update the recipe og and fg in the style characteristics table
		calc_og();
	}
}

xmlhttp.open("GET","../php_files/getyeastinfo.php?q="+string,true);
xmlhttp.send();
}
