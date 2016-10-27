function validate_details() 
{
	var error = "";
    var name = document.forms[0]["name"].value;
    var style = document.forms[0]["style"].value;
    var type = document.forms[0]["type"].value;
    var batch_size = document.forms[0]["batch_size"].value;
    var mash_efficiency = document.forms[0]["mash_efficiency"].value;
    
    if (name == null || name == "")
    {
		error += "- Name is mandatory\n";
	}
    
    if (style == null || style == "")
    {
		error += "- Style is mandatory\n";
	}
    
    if (type == null || type == "")
    {
		error += "- Type is mandatory\n";
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
