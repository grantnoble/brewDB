function fermentables_messages(num)
{
	// reset the CustomValidity messages
	document.recipeform["fermentable"+num+"_amount"].setCustomValidity("");
	document.recipeform["fermentable"+num+"_yield"].setCustomValidity("");
	document.recipeform["fermentable"+num+"_color"].setCustomValidity("");
	
	// if there is a fermentable name, and a required field is empty, set the field to be required and set the CustomValidity message
	if (document.recipeform["fermentable"+num+"_name"].value)
	{
		if (!document.recipeform["fermentable"+num+"_amount"].value)
		{
			document.recipeform["fermentable"+num+"_amount"].required=true;
			document.recipeform["fermentable"+num+"_amount"].setCustomValidity("Amount required.");
		}
		if (!document.recipeform["fermentable"+num+"_yield"].value)
		{
			document.recipeform["fermentable"+num+"_yield"].required=true;
			document.recipeform["fermentable"+num+"_yield"].setCustomValidity("Yield required.");
		}
		if (!document.recipeform["fermentable"+num+"_color"].value)
		{
			document.recipeform["fermentable"+num+"_color"].required=true;
			document.recipeform["fermentable"+num+"_color"].setCustomValidity("Color required.");
		}
	}
}
