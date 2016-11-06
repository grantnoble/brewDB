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
		// display the basic recipe and style details
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
		
		var i;
		
		// for each of the 15 possible fermentables, if there is one available (not undefined), display it, else set the rest of the fields to null
		for (i = 0; i < 15; i++)
		{
			if (typeof xmlhttp.responseXML.getElementsByTagName("fermentable_name")[i] !== 'undefined')
			{
				document.forms[0]["fermentable"+i+"_name"].value=xmlhttp.responseXML.getElementsByTagName("fermentable_name")[i].childNodes[0].nodeValue;
				document.forms[0]["fermentable"+i+"_amount"].value=xmlhttp.responseXML.getElementsByTagName("fermentable_amount")[i].childNodes[0].nodeValue;
				document.forms[0]["fermentable"+i+"_type"].value=xmlhttp.responseXML.getElementsByTagName("fermentable_type")[i].childNodes[0].nodeValue;
				document.forms[0]["fermentable"+i+"_yield"].value=xmlhttp.responseXML.getElementsByTagName("fermentable_yield")[i].childNodes[0].nodeValue;
				document.forms[0]["fermentable"+i+"_color"].value=xmlhttp.responseXML.getElementsByTagName("fermentable_color")[i].childNodes[0].nodeValue;
				document.forms[0]["fermentable"+i+"_use"].value=xmlhttp.responseXML.getElementsByTagName("fermentable_use")[i].childNodes[0].nodeValue;
			}
			else
			{
				document.forms[0]["fermentable"+i+"_name"].value=null;
				document.forms[0]["fermentable"+i+"_amount"].value=null;
				document.forms[0]["fermentable"+i+"_percent"].value=null;
				document.forms[0]["fermentable"+i+"_type"].value=null;
				document.forms[0]["fermentable"+i+"_yield"].value=null;
				document.forms[0]["fermentable"+i+"_color"].value=null;
				document.forms[0]["fermentable"+i+"_use"].value=null;
			}
		}
		
		// after all the fermentables are displayed, calculate the fermentable percentages
		calc_percent();

		// for each of the 15 possible hops, if there is one available (not undefined), display it, else set the rest of the fields to null
		for (i = 0; i < 15; i++)
		{
			if (typeof xmlhttp.responseXML.getElementsByTagName("hop_name")[i] !== 'undefined')
			{
				document.forms[0]["hop"+i+"_name"].value=xmlhttp.responseXML.getElementsByTagName("hop_name")[i].childNodes[0].nodeValue;
				document.forms[0]["hop"+i+"_amount"].value=xmlhttp.responseXML.getElementsByTagName("hop_amount")[i].childNodes[0].nodeValue;
				document.forms[0]["hop"+i+"_alpha"].value=xmlhttp.responseXML.getElementsByTagName("hop_alpha")[i].childNodes[0].nodeValue;
				document.forms[0]["hop"+i+"_time"].value=xmlhttp.responseXML.getElementsByTagName("hop_time")[i].childNodes[0].nodeValue;
				document.forms[0]["hop"+i+"_form"].value=xmlhttp.responseXML.getElementsByTagName("hop_form")[i].childNodes[0].nodeValue;
				document.forms[0]["hop"+i+"_use"].value=xmlhttp.responseXML.getElementsByTagName("hop_use")[i].childNodes[0].nodeValue;
			}
			else
			{
				document.forms[0]["hop"+i+"_name"].value=null;
				document.forms[0]["hop"+i+"_amount"].value=null;
				document.forms[0]["hop"+i+"_alpha"].value=null;
				document.forms[0]["hop"+i+"_time"].value=null;
				document.forms[0]["hop"+i+"_form"].value=null;
				document.forms[0]["hop"+i+"_use"].value=null;
			}
		}
		
		// for each of the 1 possible yeasts, if there is one available (not undefined), display it, else set the rest of the fields to null
		for (i = 0; i < 1; i++)
		{
			if (typeof xmlhttp.responseXML.getElementsByTagName("yeast_name")[i] !== 'undefined')
			{
				document.forms[0]["yeast"+i+"_fullname"].value=xmlhttp.responseXML.getElementsByTagName("yeast_name")[i].childNodes[0].nodeValue;
				document.forms[0]["yeast"+i+"_type"].value=xmlhttp.responseXML.getElementsByTagName("yeast_type")[i].childNodes[0].nodeValue;
				document.forms[0]["yeast"+i+"_form"].value=xmlhttp.responseXML.getElementsByTagName("yeast_form")[i].childNodes[0].nodeValue;
				document.forms[0]["yeast"+i+"_attenuation"].value=xmlhttp.responseXML.getElementsByTagName("yeast_attenuation")[i].childNodes[0].nodeValue;
				document.forms[0]["yeast"+i+"_flocculation"].value=xmlhttp.responseXML.getElementsByTagName("yeast_flocculation")[i].childNodes[0].nodeValue;
			}
			else
			{
				document.forms[0]["yeast"+i+"_fullname"].value=null;
				document.forms[0]["yeast"+i+"_type"].value=null;
				document.forms[0]["yeast"+i+"_form"].value=null;
				document.forms[0]["yeast"+i+"_attenuation"].value=null;
				document.forms[0]["yeast"+i+"_flocculation"].value=null;
			}
		}
		
		// for each of the 15 possible miscs, if there is one available (not undefined), display it, else set the rest of the fields to null
		for (i = 0; i < 15; i++)
		{
			if (typeof xmlhttp.responseXML.getElementsByTagName("misc_name")[i] !== 'undefined')
			{
				document.forms[0]["misc"+i+"_name"].value=xmlhttp.responseXML.getElementsByTagName("misc_name")[i].childNodes[0].nodeValue;
				document.forms[0]["misc"+i+"_type"].value=xmlhttp.responseXML.getElementsByTagName("misc_type")[i].childNodes[0].nodeValue;
				document.forms[0]["misc"+i+"_amount"].value=xmlhttp.responseXML.getElementsByTagName("misc_amount")[i].childNodes[0].nodeValue;
				document.forms[0]["misc"+i+"_unit"].value=xmlhttp.responseXML.getElementsByTagName("misc_unit")[i].childNodes[0].nodeValue;
				document.forms[0]["misc"+i+"_use"].value=xmlhttp.responseXML.getElementsByTagName("misc_use")[i].childNodes[0].nodeValue;
			}
			else
			{
				document.forms[0]["misc"+i+"_name"].value=null;
				document.forms[0]["misc"+i+"_type"].value=null;
				document.forms[0]["misc"+i+"_amount"].value=null;
				document.forms[0]["misc"+i+"_unit"].value=null;
				document.forms[0]["misc"+i+"_use"].value=null;
			}
		}
	}
}

xmlhttp.open("GET","getrecipeinfo.php?q="+string,true);
xmlhttp.send();
}
