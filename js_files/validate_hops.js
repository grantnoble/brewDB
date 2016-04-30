function validate_hops() 
{
	var i;
	var error = "";

	for (i=0; i<=14; i++)
	{
		var name = document.recipeform["hop"+i+"_name"].value;
		var amount = document.recipeform["hop"+i+"_amount"].value;
		var alpha = document.recipeform["hop"+i+"_alpha"].value;
		var time = document.recipeform["hop"+i+"_time"].value;
		var use = document.recipeform["hop"+i+"_use"].value;
		var form = document.recipeform["hop"+i+"_form"].value;

		if (name)
		{
			if (amount == null || amount == "")
			{
				error += "- Hop requires an amount\n";
			}
			if (alpha == null || alpha == "")
			{
				error += "- Hop requires an alpha acid value\n";
			}
			if (time == null || time == "")
			{
				error += "- Hop requires a time value\n";
			}
			if (use == null || use == "")
			{
				error += "- Hop requires a use value\n";
			}
			if (form == null || form == "")
			{
				error += "- Hop requires a form\n";
			}
		}
	}
    return error;
}
