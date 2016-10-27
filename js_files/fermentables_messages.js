function fermentables_messages(num)
{
	// reset the CustomValidity messages
	document.forms[0]["fermentable"+num+"_amount"].setCustomValidity("");
	document.forms[0]["fermentable"+num+"_yield"].setCustomValidity("");
	document.forms[0]["fermentable"+num+"_color"].setCustomValidity("");
	
	// if there is a fermentable name, and a required field is empty, set the field to be required and set the CustomValidity message
	if (document.forms[0]["fermentable"+num+"_name"].value)
	{
		if (!document.forms[0]["fermentable"+num+"_amount"].value)
		{
			document.forms[0]["fermentable"+num+"_amount"].required=true;
			document.forms[0]["fermentable"+num+"_amount"].setCustomValidity("Amount required.");
		}
		if (!document.forms[0]["fermentable"+num+"_yield"].value)
		{
			document.forms[0]["fermentable"+num+"_yield"].required=true;
			document.forms[0]["fermentable"+num+"_yield"].setCustomValidity("Yield required.");
		}
		if (!document.forms[0]["fermentable"+num+"_color"].value)
		{
			document.forms[0]["fermentable"+num+"_color"].required=true;
			document.forms[0]["fermentable"+num+"_color"].setCustomValidity("Color required.");
		}
	}
}
