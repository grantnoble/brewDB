function miscs_messages(num)
{
	// reset the CustomValidity messages
	document.forms[0]["misc"+num+"_amount"].setCustomValidity("");
	document.forms[0]["misc"+num+"_unit"].setCustomValidity("");
	
	// if there is a misc name, and a required field is empty, set the field to be required and set the CustomValidity message
	if (document.forms[0]["misc"+num+"_name"].value)
	{
		if (!document.forms[0]["misc"+num+"_amount"].value)
		{
			document.forms[0]["misc"+num+"_amount"].required=true;
			document.forms[0]["misc"+num+"_amount"].setCustomValidity("Amount required.");
		}
		if (!document.forms[0]["misc"+num+"_unit"].value)
		{
			document.forms[0]["misc"+num+"_unit"].required=true;
			document.forms[0]["misc"+num+"_unit"].setCustomValidity("Unit required.");
		}
	}
}
