function miscs_messages(num)
{
	// reset the CustomValidity messages
	document.recipeform["misc"+num+"_amount"].setCustomValidity("");
	document.recipeform["misc"+num+"_unit"].setCustomValidity("");
	
	// if there is a misc name, and a required field is empty, set the field to be required and set the CustomValidity message
	if (document.recipeform["misc"+num+"_name"].value)
	{
		if (!document.recipeform["misc"+num+"_amount"].value)
		{
			document.recipeform["misc"+num+"_amount"].required=true;
			document.recipeform["misc"+num+"_amount"].setCustomValidity("Amount required.");
		}
		if (!document.recipeform["misc"+num+"_unit"].value)
		{
			document.recipeform["misc"+num+"_unit"].required=true;
			document.recipeform["misc"+num+"_unit"].setCustomValidity("Unit required.");
		}
	}
}
