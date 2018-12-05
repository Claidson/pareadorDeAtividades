
/* Função para criar o objeto XMLHttpRequest */
function openAjax()
{
	try
	{
		var ajax = new XMLHttpRequest();
	}
	catch(e)
	{
		try
		{
			var ajax = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(ee)
		{
			try
			{
				var ajax = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(eee)
			{
			    var ajax = false;
			}
		}
	}
	
	return ajax;
}