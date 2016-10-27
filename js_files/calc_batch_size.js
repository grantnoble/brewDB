function calc_batch_size()
{
	if (document.forms[0].boil_size.value && document.forms[0].boil_time.value && document.forms[0].evaporation_rate.value)
	{
		var boil_size = document.forms[0].boil_size.value;
		var boil_time = document.forms[0].boil_time.value;
		var evaporation_rate = document.forms[0].evaporation_rate.value;
		document.forms[0].batch_size.value = boil_size - (evaporation_rate * boil_time / 60);
	
		calc_og_color_ibu();
	}
}
