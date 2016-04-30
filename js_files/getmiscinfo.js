function getmiscinfo(string,num)
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
		// the following use square bracket notation to include the row number in the field name
				// fill the yield, color, type, and use fields for the fermentable
		if (!document.recipeform["misc"+num+"_amount"].value)
		{
			document.recipeform["misc"+num+"_amount"].value = 1;
		}
		if (!document.recipeform["misc"+num+"_unit"].value)
		{
			document.recipeform["misc"+num+"_unit"].value = "each";
		}

		document.recipeform["misc"+num+"_id"].value=xmlhttp.responseXML.getElementsByTagName("misc_id")[0].childNodes[0].nodeValue;
		document.recipeform["misc"+num+"_type"].value=xmlhttp.responseXML.getElementsByTagName("misc_type")[0].childNodes[0].nodeValue;
	}
}

xmlhttp.open("GET","getmiscinfo.php?q="+string,true);
xmlhttp.send();
}
