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
		// fill the amount and unit fields for the misc
		if (!document.forms[0]["misc"+num+"_amount"].value)
		{
			document.forms[0]["misc"+num+"_amount"].value = 1;
		}
		if (!document.forms[0]["misc"+num+"_unit"].value)
		{
			document.forms[0]["misc"+num+"_unit"].value = "each";
		}

		// retrieve the values from the xml returned by getmiscinfo.php
		// the following use square bracket notation to include the row number in the field name
		document.forms[0]["misc"+num+"_id"].value=xmlhttp.responseXML.getElementsByTagName("misc_id")[0].childNodes[0].nodeValue;
		document.forms[0]["misc"+num+"_type"].value=xmlhttp.responseXML.getElementsByTagName("misc_type")[0].childNodes[0].nodeValue;
	}
}

xmlhttp.open("GET","../php_files/getmiscinfo.php?q="+string,true);
xmlhttp.send();
}
