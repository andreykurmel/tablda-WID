function fraction2decimal(fraction) {
	var result;
	' X  - A /  B'

	// to remove the starting ' ' if any
	while (fraction[0]==' '){
		fraction = fraction.slice(1, fraction.length);
	}	

	if(fraction.search('-') >=0 && fraction.search(' ') >=0){
		fraction = fraction.replace(/ /g, '');
	}

	if(fraction.search('/') >=0){

		var after_split = fraction.split('/');
		// t('after_split[0]: ' + after_split[0] + ', after_split[1]: ' + after_split[1]);
		var B = after_split[1];
		
		// console.log('B: ' + B);

		var X2A = after_split[0];
		
		// console.log('X2A: ' + X2A);
		
		while (X2A[X2A.length]==' '){X2A = X2A.slice(0, X2A.length - 1);}	
		// to remove the ' ' at the end if any

		while (X2A.search('  ') >=0){X2A = X2A.replace('  ', ' ');}
		// to replace any '  ' with ' ' between X and A.

		// alert('X2A: ' + X2A);
		// alert('length of X2A: ' + X2A.length);
		// alert("X2A.search('-'): " + X2A.search('-'));
		// alert("X2A.search(' '): " + X2A.search(' '));

		if(X2A.search('-') > 0){
			var X2A_split = X2A.split('-');
			var splitted = true;			
		}else if(X2A.length>=3 && X2A.search(' ') > 0){
			var X2A_split = X2A.split(' ');
			var splitted = true;				
		}else{
			var X2A_split = X2A;
			var splitted = false;		
		}
		
		// alert('X2A: ' + X2A);
		// alert('splitted: ' + splitted);

		if(splitted){
			var X = X2A_split[0];
			var A = X2A_split[1];
			// alert('X2A_split[0]: ' + X2A_split[0] + ', X2A_split[1]: ' + X2A_split[1]);
		}else{
			var X = 0;
			var A = X2A_split;
		}
		
		// console.log('X: ' + X + ', A: ' + A + ', B: ' + B);

		result = Number(X) + Number(A)/Number(B);

	}else{

		result = fraction;
	}
	// console.log('fraction: ' + fraction + ', result: ' + result);
	return result;
}