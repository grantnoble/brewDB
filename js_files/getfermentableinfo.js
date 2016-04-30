function getfermentableinfo(string,num)
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
		// retrieve the values from the xml returned by getfermentableinfo.php
		// the following use square bracket notation to include the row number in the field name
		document.recipeform["fermentable"+num+"_id"].value = xmlhttp.responseXML.getElementsByTagName("fermentable_id")[0].childNodes[0].nodeValue;
		var y = xmlhttp.responseXML.getElementsByTagName("fermentable_yield")[0].childNodes[0].nodeValue;
		var c = xmlhttp.responseXML.getElementsByTagName("fermentable_color")[0].childNodes[0].nodeValue;
		var t = xmlhttp.responseXML.getElementsByTagName("fermentable_type")[0].childNodes[0].nodeValue;
		
		// fill the yield, color, type, and use fields for the fermentable
		if (!document.recipeform["fermentable"+num+"_amount"].value)
		{
			document.recipeform["fermentable"+num+"_amount"].value = 1;
		}
		document.recipeform["fermentable"+num+"_yield"].value = y;
		document.recipeform["fermentable"+num+"_color"].value = c;
		
		// if type is "Grain", set use to "Mashed", otherwise "Extract", "Sugar", or "Other"
		if (t=="Grain")
		{
			document.recipeform["fermentable"+num+"_use"].value = "Mashed";
		}
		else if (t=="Extract" || t=="Dry Extract")
		{
			document.recipeform["fermentable"+num+"_use"].value = "Extract";
		}
		else if (t=="Sugar")
		{
			document.recipeform["fermentable"+num+"_use"].value = "Sugar";
		}
		else
		{
			document.recipeform["fermentable"+num+"_use"].value = "Other";
		}
		
		// update the recipe og and fg, and color in the style characteristics table
		calc_og_color_ibu();
	}
}

xmlhttp.open("GET","getfermentableinfo.php?q="+string,true);
xmlhttp.send();
}
