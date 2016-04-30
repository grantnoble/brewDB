function hops_messages(num)
{
	// reset the CustomValidity messages
	document.recipeform["hop"+num+"_amount"].setCustomValidity("");
	document.recipeform["hop"+num+"_alpha"].setCustomValidity("");
	document.recipeform["hop"+num+"_time"].setCustomValidity("");
	
	// if there is a hop name, and a required field is empty, set the field to be required and set the CustomValidity message
	if (document.recipeform["hop"+num+"_name"].value)
	{
		if (!document.recipeform["hop"+num+"_amount"].value)
		{
			document.recipeform["hop"+num+"_amount"].required=true;
			document.recipeform["hop"+num+"_amount"].setCustomValidity("Amount required.");
		}
		if (!document.recipeform["hop"+num+"_alpha"].value)
		{
			document.recipeform["hop"+num+"_alpha"].required=true;
			document.recipeform["hop"+num+"_alpha"].setCustomValidity("Alpha acid required.");
		}
		if (!document.recipeform["hop"+num+"_time"].value)
		{
			document.recipeform["hop"+num+"_time"].required=true;
			document.recipeform["hop"+num+"_time"].setCustomValidity("Time required.");
		}
	}
}
