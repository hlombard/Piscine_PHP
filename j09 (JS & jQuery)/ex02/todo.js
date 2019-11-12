window.onload
{
	var button = document.getElementById("new");
	button.addEventListener('click', new_func);
	var list = document.getElementById('ft_list');
	list.innerHTML = decodeURIComponent(getCookie('everything'));
}

function new_func()
{

	var text = prompt("Entrez votre nouvelle tache:");
	if (text)
	{
		var ft_list = document.getElementById("ft_list");
		var node = document.createTextNode(text);
		var new_todo = document.createElement("div");
		new_todo.appendChild(node);
		new_todo.setAttribute('onclick', "remove(this)");
		ft_list.insertBefore(new_todo, ft_list.firstChild);

		date=new Date;
		date.setMonth(date.getMonth()+1);
		date = date.toUTCString();
		setCookie('everything', encodeURIComponent(ft_list.innerHTML), 1);
	}
}

function	remove(child)
{
	if (!confirm("Etes vous sure de vouloir supprimer cette tache ?"))
		return;
	var ft_list = document.getElementById('ft_list');
	ft_list.removeChild(child);
	setCookie('everything', encodeURIComponent(ft_list.innerHTML), 1);
}


function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires="+d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++) {
	  var c = ca[i];
	  while (c.charAt(0) == ' ') {
		c = c.substring(1);
	  }
	  if (c.indexOf(name) == 0) {
		return c.substring(name.length, c.length);
	  }
	}
	return "";
  }
