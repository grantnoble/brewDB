function gethopinfo(string,num)
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
		document.forms[0]["hop"+num+"_id"].value = xmlhttp.responseXML.getElementsByTagName("hop_id")[0].childNodes[0].nodeValue;
		document.forms[0]["hop"+num+"_alpha"].value=xmlhttp.responseXML.getElementsByTagName("hop_alpha")[0].childNodes[0].nodeValue;
		document.forms[0]["hop"+num+"_amount"].value=10;
		document.forms[0]["hop"+num+"_time"].value=60;
		document.forms[0]["hop"+num+"_form"].value="Pellet";
		document.forms[0]["hop"+num+"_use"].value="Boil";
		
		// update the recipe ibu in the style characteristics table
		calc_ibu();
	}
}

xmlhttp.open("GET","gethopinfo.php?q="+string,true);
xmlhttp.send();
}
