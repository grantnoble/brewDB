function hops_messages(num)
{
	// reset the CustomValidity messages
	document.forms[0]["hop"+num+"_amount"].setCustomValidity("");
	document.forms[0]["hop"+num+"_alpha"].setCustomValidity("");
	document.forms[0]["hop"+num+"_time"].setCustomValidity("");
	
	// if there is a hop name, and a required field is empty, set the field to be required and set the CustomValidity message
	if (document.forms[0]["hop"+num+"_name"].value)
	{
		if (!document.forms[0]["hop"+num+"_amount"].value)
		{
			document.forms[0]["hop"+num+"_amount"].required=true;
			document.forms[0]["hop"+num+"_amount"].setCustomValidity("Amount required.");
		}
		if (!document.forms[0]["hop"+num+"_alpha"].value)
		{
			document.forms[0]["hop"+num+"_alpha"].required=true;
			document.forms[0]["hop"+num+"_alpha"].setCustomValidity("Alpha acid required.");
		}
		if (!document.forms[0]["hop"+num+"_time"].value)
		{
			document.forms[0]["hop"+num+"_time"].required=true;
			document.forms[0]["hop"+num+"_time"].setCustomValidity("Time required.");
		}
	}
}
