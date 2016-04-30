function validate_details() 
{
	var error = "";
    var name = document.recipeform["name"].value;
    var style = document.recipeform["style"].value;
    var type = document.recipeform["type"].value;
    var batch_size = document.recipeform["batch_size"].value;
    var mash_efficiency = document.recipeform["mash_efficiency"].value;
    
    if (name == null || name == "")
    {
		error += "- Recipe name is mandatory\n";
	}
    
    if (style == null || style == "")
    {
		error += "- Recipe style is mandatory\n";
	}
    
    if (type == null || type == "")
    {
		error += "- Recipe type is mandatory\n";
	}
    
    if (batch_size == null || batch_size == "")
    {
		error += "- Batch size is mandatory\n";
	}
    
    if (mash_efficiency == null || mash_efficiency == "")
    {
		error += "- Mash efficiency is mandatory\n";
	}
    
    return error;
}
