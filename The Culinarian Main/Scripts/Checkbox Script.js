function anyCheckbox()
{
	var mess = document.getElementsByClassName("mess");
	var btn = document.getElementsByClassName("search");
	var flag = 0;
	var inputElements = document.getElementsByTagName("input");
	for (var i = 0; i < inputElements.length; i++)
	{
		if (inputElements[i].type == "checkbox")
		{
			if (inputElements[i].checked)
			{
				mess[0].style.display = "none";
				btn[0].disabled = false;
				flag = 1;
			}
		}
	}
	if (flag==0)
	{
		mess[0].style.display = "block";
		btn[0].disabled = true;
	}
}

var coll = document.getElementsByClassName("collapsible");
var i;
for(i=0;i<coll.length;i++)
{
	coll[i].addEventListener("click", function(){
		this.classList.toggle("active");
		var content = this.nextElementSibling;
		if (content.style.maxHeight)
		{
			content.style.maxHeight = null;
		}
		else
		{
			content.style.maxHeight = content.scrollHeight + "px";
		}
	});
}