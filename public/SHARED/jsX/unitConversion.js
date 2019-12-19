function unitConversion(crtValue, crtUnit, unit2be){

	var valuemultiple = 1;

	switch (unit2be){

		// -------------------------------------------------------------- angle
		case 'degree':
		switch (crtUnit){
			case 'degree': break;
			case 'radian':
			case 'radians':
			valuemultiple = 180/Math.PI; break;
			default:
			break;
		};
		break;
		
		case 'radian':
		case 'radians':
		switch (crtUnit){
			case 'radian':
			case 'radians':
			break;
			case 'degree': valuemultiple = Math.PI/180; break;
			default:
			break;
		};
		break;		
		
		// -------------------------------------------------------------- length
		case 'in.':
		case 'inch':
		switch (crtUnit){
			case 'in.':
			case 'inch': break;
			case 'ft': valuemultiple = 12; break;
			default:
			break;
		};
		break;			
		case 'ft':
		case 'foot':
		case 'feet':
		switch (crtUnit){
			case 'in.':		
			case 'inch': valuemultiple = 1/12; break;
			case 'ft': break;
			default:
			break;
		};
		break;

		// -------------------------------------------------------------- pressure
		case 'psi':
		switch (crtUnit){
			case 'psi': valuemultiple = 1; break;
			case 'ksi': valuemultiple = 1000; break;
			case 'ksf': valuemultiple = 144/1000; break;
			case 'psf': valuemultiple = 144; break;			
			default:
			break;
		};
		break;
		case 'ksi':
			switch (crtUnit){
				case 'psi': valuemultiple = 1/1000; break;
				case 'ksi': break;
				case 'ksf': valuemultiple = 144; break;
				default:
				break;
			};
			break;
		case 'ksf':
			switch (crtUnit){
				case 'psi': valuemultiple = 144/1000; break;
				case 'ksi': valuemultiple = 144; break;
				case 'ksf': valuemultiple = 1; break;
				case 'ksi': valuemultiple = 144; break;				
				default:
				break;
			};
			break;
		case 'psf':
			switch (crtUnit){
				case 'psi': valuemultiple = 144; break;
				case 'ksi': valuemultiple = 144/1000; break;
				case 'ksf': valuemultiple = 1000; break;
				default:
				break;
			};
			break;
		default:		
		break;

		// -------------------------------------------------------------- density
		case 'pcf':
			switch (crtUnit){
				case 'kcf': valuemultiple = 1000; break;
				case 'kci': valuemultiple = 1728*1000; break;
				case 'pci': valuemultiple = 1728; break;
				default:
				break;
			};
			break;
		case 'pci':
			switch (crtUnit){
				case 'kcf': valuemultiple = 1000/1728; break;
				case 'pcf': valuemultiple = 1/1728; break;
				case 'kci': valuemultiple = 1000; break;
				default:
				break;
			};
			break;
		case 'kcf':
			switch (crtUnit){
				case 'kcf': valuemultiple = 1; break;
				case 'pcf': valuemultiple = 1/1000; break;
				case 'kci': valuemultiple = 1728; break;
				case 'pci': valuemultiple = 1728/1000; break;
				default:
				break;
			};
			break;
		case 'kci':
			switch (crtUnit){
				case 'kcf': valuemultiple = 1/1728; break;
				case 'pcf': valuemultiple = 1/1000/1728; break;
				case 'pci': valuemultiple = 1/1000; break;
				default:
				break;
			};
			break;											
	};
	var value2be = crtValue*valuemultiple;
	return value2be;
}