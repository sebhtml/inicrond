function popup(url,w,h)
		{
		params ='width='+w+',height='+h+',directories=0,scrollbars=0,location=0,menubar=0,resizable=0,status=0,titlebar=0,toolbar=0';
		winPop = window.open(url,'pop_up',params);//créer l'objet winpop hehe
		winPop.moveTo(0, 0);//met la fenetre en haut à gauche
		winPop.focus();//prend le focus
		}