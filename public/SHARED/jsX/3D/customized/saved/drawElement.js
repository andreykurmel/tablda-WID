


function drawElement(dir, D1, sectionShape, shapeSize, description, material, partNo, centerPivot, hole, holeSize, holeShape, xLength, yLength, regEdges, regEdgeLen){
	// alert('sectionShape: ' + sectionShape);
	var mesh;
	switch (sectionShape){
		case 'W':
		case "I":
		mesh = new drawI(dir, shapeSize, D1, material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case "L":
		case "L_E":
		case "L_uE":
		mesh = new drawL(dir, shapeSize, D1, material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case "C":
		mesh = new drawC(dir, shapeSize, D1, material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case "Pipe":
		mesh = new drawPipe(dir, shapeSize, D1, material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case "HHS(Rect)":
		mesh = new drawHHS_Rect(dir, shapeSize, D1, material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case 'Circular':
		mesh = new drawCircular(dir, shapeSize, D1, material, centerPivot, hole, holeSize, holeShape);
		mesh.name = partNo + " ";
		break;			

		case "U Bolt":
		// NOTE D1 = length, shapeSize = width
		mesh = new drawUBolt(dir, D1, shapeSize, 0.2, D1/2, true, true, 0.5, material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case "SR":
		mesh = new drawSR(dir, shapeSize,D1, material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case "Nut":
		// NOTE D1 = radius, shapeSize = thickness
		mesh = new drawNut(dir, D1, shapeSize ,material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case "Hex Bolt":
		mesh = new drawHexBolt(dir, 8, 1.125, 5, 0.5, material, centerPivot);
		mesh.name = partNo + " ";
		break;

		case "Donut":
		// NOTE D1 = radius, shapeSize = tubular radius
		mesh = new drawDonut(dir, D1, shapeSize, material,centerPivot);
		mesh.name = partNo + " ";
		break;

		case "Square":
		mesh = new drawSquare(dir, shapeSize, D1, material, centerPivot, hole, holeSize, holeShape);
		mesh.name = partNo + " ";
		break;

		case "Rectangle":
		case 'Rectangular':
		mesh = new drawRectangle(dir, shapeSize, D1, material, centerPivot, hole, holeSize, holeShape, xLength, yLength);
		mesh.name = partNo + " ";
		break;

		case "Regular": 
		mesh = new drawRegular(dir, shapeSize, D1, material, centerPivot, hole, holeSize, holeShape, regEdges, regEdgeLen);
		mesh.name = partNo + " ";
		break;

		default:
		alert("Something went wrong - the given <sectionShape> not found!");
		break;
	}

	mesh.partNo = partNo;
	mesh.description = description;
	return(mesh);
}

/////////////Drawing functions.
/////////////Please note that these functions now create a mesh and not a shape thus simplyfing drawElement function

function extrudeShape(points, height){
	var shape = new THREE.Shape();
	shape.moveTo(points[0][0],0);
	for (var i = 0; i < points.length; i++) {
		shape.lineTo(points[i][0], points[i][1]);
	};
	var mat = new THREE.MeshLambertMaterial();
	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:height, uvGenerator: THREE.ExtrudeGeometry.WorldUVGenerator} );
	geometry.applyMatrix( new THREE.Matrix4().makeRotationX(-Math.PI / 2) );
	mesh = new THREE.Mesh( geometry, mat );
	return mesh;
}

function drawHHS_Rect(dir, shapeSize, D1, material, centerPivot, hole){
	/*var shapeData = getshapeData('HHS(Rect)',shapeSize);
	var h = parseFloat(shapeData.Ht);
	var b = parseFloat(shapeData.b);
	var t_des = parseFloat(shapeData.t_des);*/
	var h = D1;
	var b = shapeSize;
	var t_des = 5;
	var f1 = 0.01;
	
	var shape = new THREE.Shape();
	shape.moveTo(-b/2+f1,-h/2);
	shape.lineTo(b/2-f1,-h/2);
	shape.lineTo(b/2,-h/2+f1);
	shape.lineTo(b/2,h/2-f1);
	shape.lineTo(b/2-f1,h/2);
	shape.lineTo(-b/2+f1,h/2);
	shape.lineTo(-b/2,h/2-f1);
	shape.lineTo(-b/2,-h/2+f1);
	shape.lineTo(-b/2+f1,-h/2);

	var hole = new THREE.Path();
	hole.moveTo(-b/2+f1+t_des,-h/2+t_des);
	hole.lineTo(b/2-f1-t_des,-h/2+t_des);
	hole.lineTo(b/2-t_des,-h/2+f1+t_des);
	hole.lineTo(b/2-t_des,h/2-f1-t_des);
	hole.lineTo(b/2-f1-t_des,h/2-t_des);
	hole.lineTo(-b/2+f1+t_des,h/2-t_des);
	hole.lineTo(-b/2+t_des,h/2-f1-t_des);
	hole.lineTo(-b/2+t_des,-h/2+f1+t_des);
	hole.lineTo(-b/2+f1+t_des,-h/2+t_des);
	shape.holes.push( hole );

	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount: D1} );
	//geometry.applyMatrix
	if(centerPivot) THREE.GeometryUtils.center(geometry);
	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.h = h;
	mesh.dimensions.b = b;
	mesh.dimensions.t_des = t_des;
	mesh.dimensions.f1 = f1;
	mesh.dimensions.D1 = D1;
	mesh.name = 'HHS(Rect) ' + shapeSize;
	ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh)
}


function drawRectangle (dir, xLength, yLength, thickness, material, centerPivot, hole, holeShape, holeSize){

	var rectPoints = [];
	rectPoints.push( new THREE.Vector3 (-xLength/2, -yLength/2 ));
	rectPoints.push( new THREE.Vector3 (-xLength/2,  yLength/2 ));
	rectPoints.push( new THREE.Vector3 ( xLength/2,  yLength/2 ));
	rectPoints.push( new THREE.Vector3 ( xLength/2, -yLength/2 ));
	rectPoints.push( new THREE.Vector3 (-xLength/2, -yLength/2 ));
	var shape = new THREE.Shape(rectPoints);

	if(hole && holeSize != undefined){

		switch(holeShape){
			case 'Square':
			var t_des = Number(holeSize);
			var hole = new THREE.Path();
			hole.moveTo(-t_des / 2, t_des / 2);
			hole.lineTo(-t_des / 2,-t_des / 2);
			hole.lineTo(t_des / 2,-t_des / 2);
			hole.lineTo(t_des / 2,t_des / 2);
			hole.lineTo(-t_des / 2,t_des / 2);
			shape.holes.push( hole );
			break;

			case 'Circular':
			var t_des = Number(holeSize);
			var hole = new THREE.Path();
			hole.absarc(0, 0, t_des, 0, Math.PI*2, true );
			shape.holes.push( hole );
			break;

			default:
			break;
		}
		
	}
	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:thickness} );

	geometry.applyMatrix( new THREE.Matrix4().makeRotationX(Math.PI / 2) );

	if(centerPivot) THREE.GeometryUtils.center(geometry);
	
	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.name = 'Rect: xLength-yLength = ' + xLength + ' x ' + yLength;	
	mesh.dimensions = {};
	mesh.dimensions.xLength = xLength;
	mesh.dimensions.yLength = yLength;	
	mesh.dimensions.hole = hole;
	mesh.dimensions.holeShape = holeShape;			
	mesh.dimensions.holeSize  = holeSize;
	mesh.dimensions.thickness = thickness;
	mesh.localVertex = rectPoints;
	mesh.matValue = material;	
	//ray_objects.push(mesh);

	return(mesh)
}

function drawC(dir, shapeSize, D1, material, centerPivot){
	var shapeData = getshapeData('C',shapeSize);
	var d  = parseFloat(shapeData.d);
	var bf = parseFloat(shapeData.b_f);
	var tf = parseFloat(shapeData.t_f);
	var tw = parseFloat(shapeData.t_w);
	var xbar = parseFloat(shapeData.x);

	// var d  = shapeSize * 2;
	// var bf = 3;
	// var tf = 0.3;
	// var tw = 0.3;
	// var xbar = 0.3;

	var shape = new THREE.Shape();
	shape.moveTo(-xbar,-d/2);
	shape.lineTo(-xbar+bf,-d/2);
	shape.lineTo(-xbar+bf-tf,-d/2+tf);
	shape.lineTo(-xbar+tw+tw,-d/2+tf);
	shape.lineTo(-xbar+tw,-d/2+tf+tw);
	shape.lineTo(-xbar+tw,d/2-tf-tw);
	shape.lineTo(-xbar+tw+tw,d/2-tf);
	shape.lineTo(-xbar+bf-tf,d/2-tf);
	shape.lineTo(-xbar+bf,d/2);
	shape.lineTo(-xbar,d/2);
	shape.lineTo(-xbar,-d/2);

	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:D1} );
	geometry.applyMatrix( new THREE.Matrix4().makeRotationX(Math.PI / 2) );
	if(centerPivot)
		THREE.GeometryUtils.center(geometry);
	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.d = d;
	mesh.dimensions.bf = bf;
	mesh.dimensions.tf = tf;
	mesh.dimensions.tw = tw;
	mesh.dimensions.xbar = xbar;
	mesh.dimensions.D1 = D1;
	mesh.name = 'C ' + shapeSize;
	//ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh)
}

function drawL(dir, shapeSize, D1, material, centerPivot){
	var shapeData = getshapeDataX('L_E',shapeSize);

	console.log('L / shapeData.d: ' + shapeData.d);

	var d  = parseFloat(shapeData.d);
	var b = parseFloat(shapeData.b);
	var t = parseFloat(shapeData.t);
	var xbar = parseFloat(shapeData.x);
	var ybar = parseFloat(shapeData.y);

	var shape = new THREE.Shape();
	shape.moveTo(-xbar,d-ybar);
	shape.lineTo(-xbar+t,d-ybar-t);
	shape.lineTo(-xbar+t,-ybar+t+t);
	shape.lineTo(-xbar+t+t,-ybar+t);
	shape.lineTo(-xbar+b-t,-ybar+t);
	shape.lineTo(-xbar+b,-ybar);
	shape.lineTo(-xbar,-ybar);
	shape.lineTo(-xbar,d-ybar);
	
	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:D1} );

	var Rot_X_angle;
	switch (dir){
		case 'nx':  break;
		case 'px':  break;
		case 'ny':  break;
		case 'py': 	Rot_X_angle = -Math.PI / 2; break;
		case 'nz':  break;
		case 'pz':  break;
	}
	geometry.applyMatrix( new THREE.Matrix4().makeRotationX(Rot_X_angle) );


	if(centerPivot) THREE.GeometryUtils.center(geometry);

	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.d = d;
	mesh.dimensions.b = b;
	mesh.dimensions.t = t;
	mesh.dimensions.ybar = ybar;
	mesh.dimensions.xbar = xbar;
	mesh.dimensions.D1 = D1;
	mesh.name = 'L_E ' + shapeSize;
	ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh)
}

function drawRegular(dir, shapeSize, D1, material, centerPivot, hole, holeSize, holeType, regEdges, regEdgeLen){
	/*var shapeData = getshapeData('Pipe',shapeSize);
	var OD = parseFloat(shapeData.OD);
	var t_nom = parseFloat(shapeData.t);*/
	var OD = shapeSize;
	var b = holeSize;
	var t_nom = D1;
	var f1 = 0.01;	
	var regPoints = [];

	var circumf = regEdges * regEdgeLen;
	var diam = circumf / Math.PI,
	pieces = regEdges,
	increase = Math.PI * 2 / pieces,
	angle = 0, x = 0, y = 0;

	for( var i = 0; i < pieces; i++ ) {
		x = diam * Math.cos( angle );
		z = diam * Math.sin( angle );
		regPoints.push(new THREE.Vector2(x, z));
		angle += increase;
	}   
	var shape = new THREE.Shape(regPoints);

	if(hole && holeSize != undefined){
		if(holeType == 'Square'){		
			var t_des = Number(holeSize);
			var hole = new THREE.Path();
			hole.moveTo(-b/2+f1+(b-t_des),-b/2+(b-t_des));
			hole.lineTo(b/2-f1-(b-t_des),-b/2+(b-t_des));
			hole.lineTo(b/2-(b-t_des),-b/2+f1+(b-t_des));
			hole.lineTo(b/2-(b-t_des),b/2-f1-(b-t_des));
			hole.lineTo(b/2-f1-(b-t_des),b/2-(b-t_des));
			hole.lineTo(-b/2+f1+(b-t_des),b/2-(b-t_des));
			hole.lineTo(-b/2+(b-t_des),b/2-f1-(b-t_des));
			hole.lineTo(-b/2+(b-t_des),-b/2+f1+(b-t_des));
			hole.lineTo(-b/2+f1+(b-t_des),-b/2+(b-t_des));
			shape.holes.push( hole );
		}
		else if(holeType == 'Circular'){
			var t_des2 = Number(holeSize);
			var hole2 = new THREE.Path();
			hole2.absarc(0, 0, t_des2, 0, Math.PI*2, true );
			shape.holes.push( hole2 );
		}		
	}

	var geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:D1} );
	geometry.applyMatrix( new THREE.Matrix4().makeRotationX(Math.PI / 2) );
	if(centerPivot) THREE.GeometryUtils.center(geometry);

	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.OD = OD;
	mesh.dimensions.t_nom = t_nom;
	mesh.dimensions.D1 = D1;
	mesh.name = 'Pipe ' + shapeSize;

	//ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh);
};

function drawCircular(dir, OD, length, material, centerPivot, hole, holeSize, holeType){
	// circular outshape with varied inner hole shape.
	// console.log('dir: ' + dir +', shapeSize: '+ shapeSize +', length: ' + length + ', material: ' + material + ' , centerPivot:' + centerPivot + ' , hole: ' + hole + ' , holeSize: ' + holeSize + ' , holeType: ' + holeType);
	// var shapeData = getshapeData('Pipe',shapeSize);
	// var OD = parseFloat(shapeData.OD);
	// var t_nom = parseFloat(shapeData.t);

	var OD;
	var b = holeSize;
	var f1 = 0.01;
    var localVertex = [];
	var shape = new THREE.Shape();
	shape.absarc( 0, 0, OD, 0, Math.PI*2, true );

	//var holePath = new THREE.Path();
	//holePath.absarc(0, 0, OD-t_nom, 0, Math.PI*2, false );
	//shape.holes.push( holePath );

	if(hole && holeSize != undefined){
		if(holeType == 'Square'){		
			var t_des = Number(holeSize);
			var hole = new THREE.Path();
			hole.moveTo(-b/2+f1+(b-t_des),-b/2+(b-t_des));
			hole.lineTo(b/2-f1-(b-t_des),-b/2+(b-t_des));
			hole.lineTo(b/2-(b-t_des),-b/2+f1+(b-t_des));
			hole.lineTo(b/2-(b-t_des),b/2-f1-(b-t_des));
			hole.lineTo(b/2-f1-(b-t_des),b/2-(b-t_des));
			hole.lineTo(-b/2+f1+(b-t_des),b/2-(b-t_des));
			hole.lineTo(-b/2+(b-t_des),b/2-f1-(b-t_des));
			hole.lineTo(-b/2+(b-t_des),-b/2+f1+(b-t_des));
			hole.lineTo(-b/2+f1+(b-t_des),-b/2+(b-t_des));
			shape.holes.push( hole );
		}
		else if(holeType == 'Circular'){
			var t_des2 = Number(holeSize);
			var hole2 = new THREE.Path();
			hole2.absarc(0, 0, t_des2, 0, Math.PI*2, true );
			shape.holes.push( hole2 );
		}		
	}

	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:length} );
	geometry.applyMatrix( new THREE.Matrix4().makeRotationX(Math.PI / 2) );

	if(centerPivot) THREE.GeometryUtils.center(geometry);

	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.OD = OD;
	mesh.dimensions.length = length;
	mesh.name = 'Circ- ' + OD;
    localVertex.push({x: mesh.position.x, y: mesh.position.y, z: mesh.position.z});
	//ray_objects.push(mesh);
	mesh.localVertex = localVertex;
    mesh.matValue = material;
	return(mesh);
}


function drawPipe(dir, shapeSize, D1, material, centerPivot){
	var shapeData = getshapeDataX('Pipe',shapeSize);
	var OD = parseFloat(shapeData.OD)/12;
	var t_nom = parseFloat(shapeData.t)/12;

	// alert('OD: ' + OD + ', t_nom: ' + t_nom);

	var shape = new THREE.Shape();
	shape.absarc( 0, 0, OD, 0, Math.PI*2, true );

	var holePath = new THREE.Path();
	holePath.absarc(0, 0, OD-t_nom, 0, Math.PI*2, false );
	shape.holes.push( holePath );

	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:D1} );

	var Rot_X_angle;
	switch (dir){
		case 'nx':  break;
		case 'px':  break;
		case 'ny':  break;
		case 'py': 	Rot_X_angle = -Math.PI / 2; break;
		case 'nz':  break;
		case 'pz':  break;
	}

	geometry.applyMatrix( new THREE.Matrix4().makeRotationX(Rot_X_angle) );

	if(centerPivot) THREE.GeometryUtils.center(geometry);
	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.OD = OD;
	mesh.dimensions.t_nom = t_nom;
	mesh.dimensions.D1 = D1;
	mesh.name = 'Pipe ' + shapeSize;
	ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh)
}


function drawSR(dir, shapeSize, D1, material, centerPivot){
	var shapeData = getshapeDataX('SR',shapeSize);
	var OD = parseFloat(shapeData.OD);

	var shape = new THREE.Shape();
	shape.absarc( 0, 0, OD, 0, Math.PI*2, true );

	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:D1} );
	if(centerPivot)
		THREE.GeometryUtils.center(geometry);
	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.OD = OD;
	mesh.dimensions.D1 = D1;
	mesh.name = 'SR ' + shapeSize;
	ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh)
}



function drawHexBolt(dir, height, radius, thread, NutOffset, material, centerPivot){
	var shape = new THREE.Shape();
	shape.moveTo(-(radius*Math.sqrt(3))/2,-radius/2);
	shape.lineTo(0,-radius);	
	shape.lineTo((radius*Math.sqrt(3))/2,-radius/2);
	shape.lineTo((radius*Math.sqrt(3))/2,radius/2);
	shape.lineTo(0,radius);
	shape.lineTo(-(radius*Math.sqrt(3))/2,radius/2);
	shape.lineTo(-(radius*Math.sqrt(3))/2,-radius/2);

	var geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:radius/2.25} );

	if(centerPivot) THREE.GeometryUtils.center(geometry);
	
	var cylinder_geo = new THREE.CylinderGeometry(radius/2, radius/2, height - thread, 16, 16, false);
	cylinder_geo.applyMatrix( new THREE.Matrix4().makeRotationX( - Math.PI / 2 ) );
	cylinder_geo.applyMatrix( new THREE.Matrix4().makeTranslation( 0, 0, height/2 - thread/2) )

	var thread_geo = new THREE.CylinderGeometry(radius/2.2, radius/2.2, thread, 16, 16, false);
	thread_geo.applyMatrix( new THREE.Matrix4().makeRotationX( - Math.PI / 2 ) );
	thread_geo.applyMatrix( new THREE.Matrix4().makeTranslation( 0, 0, height - thread/2) )

	THREE.GeometryUtils.merge(geometry, cylinder_geo);
	THREE.GeometryUtils.merge(geometry, thread_geo);

	var nut = new drawNut(radius/2.2, radius/2.25 ,setMaterial(material), true);
	nut.position.z = height - NutOffset;

	THREE.GeometryUtils.merge(geometry, nut);

	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.radius = radius;
	mesh.name = 'Hex Bolt ' + radius;
	//ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh)
}

function drawNut(dir, innerRadius, height ,material, centerPivot){
	var radius = innerRadius*2.0;
	var shape = new THREE.Shape();
	shape.moveTo(-(radius*Math.sqrt(3))/2,-radius/2);
	shape.lineTo(0,-radius);	
	shape.lineTo((radius*Math.sqrt(3))/2,-radius/2);
	shape.lineTo((radius*Math.sqrt(3))/2,radius/2);
	shape.lineTo(0,radius);
	shape.lineTo(-(radius*Math.sqrt(3))/2,radius/2);
	shape.lineTo(-(radius*Math.sqrt(3))/2,-radius/2);

	var holePath = new THREE.Path();
	holePath.absarc(0, 0, innerRadius, 0, Math.PI*2, false );
	shape.holes.push( holePath );

	var geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:height} );
	if(centerPivot) THREE.GeometryUtils.center(geometry);

	mesh = new THREE.Mesh( geometry, setMaterial(material) );
	mesh.dimensions = {};
	mesh.dimensions.radius = radius;
	mesh.name = 'Nut ' + innerRadius;
	//ray_objects.push(mesh);
	return(mesh)
}

function drawI(dir, shapeSize, D1, material, centerPivot){
	////////////////////////////////////////////////
	//////////////Need DB entry for shapeType///////
	////////////////////////////////////////////////
	// alert('shapeSize: ' + shapeSize);

	var shapeData = getshapeDataX('W',shapeSize);
	
	// alert(shapeData);
	console.log('W / shapeData.d: ' + shapeData.d);

	var d  = parseFloat(shapeData.d);
	var bf = parseFloat(shapeData.b_f);
	var T = parseFloat(shapeData.t);
	var tw = parseFloat(shapeData.t_w);
	var tf = parseFloat(shapeData.t_f);
	var k1 = parseFloat(shapeData.k_1);

	var shape = new THREE.Shape();
	shape.moveTo(-bf/2, -d/2);
	shape.lineTo(bf/2, -d/2);
	shape.lineTo(bf/2, -d/2 + tf);
	shape.lineTo(k1, -d/2 + tf);
	shape.lineTo(tw/2, -T/2);
	shape.lineTo(tw/2, T/2);
	shape.lineTo(k1, d/2 - tf); 
	shape.lineTo(bf/2, d/2 - tf);
	shape.lineTo(bf/2, d/2);
	shape.lineTo(-bf/2, d/2);
	shape.lineTo(-bf/2, d/2 - tf);
	shape.lineTo(-k1, d/2 - tf);
	shape.lineTo(-tw/2, T/2);
	shape.lineTo(-tw/2, -T/2);
	shape.lineTo(-k1, -d/2 + tf);
	shape.lineTo(-bf/2, -d/2 + tf);
	shape.lineTo(-bf/2, -d/2);

	geometry = new THREE.ExtrudeGeometry( shape, {bevelEnabled: false, amount:D1} );

	var Rot_X_angle;
	switch (dir){
		case 'nx':  break;
		case 'px':  break;
		case 'ny':  break;
		case 'py': 	Rot_X_angle = -Math.PI / 2; break;
		case 'nz':  break;
		case 'pz':  break;
	}

	geometry.applyMatrix( new THREE.Matrix4().makeRotationX(Rot_X_angle) );

	if(centerPivot) THREE.GeometryUtils.center(geometry);

	mesh = new THREE.Mesh( geometry, setMaterial(material));
	mesh.dimensions = {};
	mesh.dimensions.d = d;
	mesh.dimensions.bf = bf;
	mesh.dimensions.T = T;
	mesh.dimensions.tw = tw;
	mesh.dimensions.tf = tf;
	mesh.dimensions.k1 = k1;
	mesh.name = '???? ' + shapeSize;
	//ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh);
}

function drawDonut(dir, radius, tubeRadius, material, centerPivot){
	var arc = 350*Math.PI/180;
	var geometry = new THREE.TorusGeometry( radius, tubeRadius, 16, 32, arc );
	if(centerPivot)
		THREE.GeometryUtils.center(geometry);
	mesh = new THREE.Mesh(geometry, setMaterial(material));
	mesh.dimensions = {};
	mesh.dimensions.radius = radius;
	mesh.dimensions.tubeRadius = tubeRadius;
	mesh.name = "Donut " + radius;
	ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh)
}

function drawUBolt(dir, height, width, thickness, thread, leftNut, rightNut, NutOffset, material, centerPivot){
//Create the extrusion path
var points = [];
	//Push the first point
	points.push(new THREE.Vector3(width/2 ,(height-width/2)-thread,0));
	points.push(new THREE.Vector3(width/2 ,((height-width/2)-thread)/2,0));
	//Draw half circle
	var resolution = 9;
	var size = 180/resolution;
	var radius = width/2;
	for(var i=0; i <=resolution; i++) {
		var segment = ( i * size ) * Math.PI / 180;
		points.push( 
			new THREE.Vector3( 
				Math.cos( segment ) * radius,
				-Math.sin( segment ) * radius,
				0
				));
	}
	//Push the last point
	points.push(new THREE.Vector3(-width/2,((height-width/2)-thread)/2,0));
	points.push(new THREE.Vector3(-width/2,(height-width/2)-thread,0));
	//Create the spline from the above points
	var spline = new THREE.SplineCurve3(points);
	//Extrude settings
	var extrudeSettings = {
		steps           : 100,
		bevelEnabled    : false,
		extrudePath     : spline
	};

	//Create the section shape
	var arcShape = new THREE.Shape();
	arcShape.absarc( 0, 0, thickness, 0, Math.PI*2, true );

	//Create the geometry
	var geometry = new THREE.ExtrudeGeometry( arcShape, extrudeSettings );
	if(centerPivot)
		THREE.GeometryUtils.center(geometry);

	//Create the thread parts
	var cylinderL = new THREE.Mesh(new THREE.CylinderGeometry(thickness*0.8, thickness*0.8, thread, 16, resolution, false),setMaterial(material));
	cylinderL.position.x = -width/2;
	cylinderL.position.y = height - width/2 -thread/2;

	THREE.GeometryUtils.merge(geometry, cylinderL);

	var cylinderR = new THREE.Mesh(new THREE.CylinderGeometry(thickness*0.8, thickness*0.8, thread, 16, resolution, false),setMaterial(material));
	cylinderR.position.x = width/2;
	cylinderR.position.y = height - width/2 -thread/2;

	THREE.GeometryUtils.merge(geometry, cylinderR);

	//Create Nuts
	if(leftNut){
		var NutLeft = new drawNut(thickness*0.81, thickness ,setMaterial(material));
		NutLeft.rotation.x = Math.PI/2;
		NutLeft.position.x = -width/2;
		NutLeft.position.y = height - width/2 - NutOffset;
		THREE.GeometryUtils.merge(geometry, NutLeft);
	}

	if(rightNut){
		var NutRight = new drawNut(thickness*0.81, thickness ,setMaterial(material));
		NutRight.rotation.x = Math.PI/2;
		NutRight.position.x = width/2;
		NutRight.position.y = height - width/2 - NutOffset
		THREE.GeometryUtils.merge(geometry, NutRight);
	}

	var mesh = new THREE.Mesh(geometry,setMaterial(material));
	mesh.dimensions = {};
	mesh.dimensions.height = height;
	mesh.dimensions.width = width;
	mesh.dimensions.thickness = thickness;
	mesh.dimensions.thread = thread;
	mesh.dimensions.leftNut = leftNut;
	mesh.dimensions.rightNut = rightNut;
	mesh.dimensions.NutOffset = NutOffset;
	mesh.name = 'U Bolt ' + height + " " + width;
	ray_objects.push(mesh);
	mesh.matValue = material;
	return(mesh)
}


function drawPolygonSection(dir, resolution, thickness, radius1, radius2, length) {
	var size = 360 / resolution;
	var geometry = new THREE.Geometry();
	var i, segment, face;

    //Vertices
    //First ring
    for (i = 0; i < resolution; i++) {
    	segment = (i * size) * Math.PI / 180;
    	geometry.vertices.push(new THREE.Vector3(Math.cos(segment) * radius1, 0, Math.sin(segment) * radius1));
    }

    for (i = 0; i < resolution; i++) {
    	segment = (i * size) * Math.PI / 180;
    	geometry.vertices.push(new THREE.Vector3(Math.cos(segment) * (radius1 - thickness), 0, Math.sin(segment) * (radius1 - thickness)));
    }

    //Second ring
    for (i = 0; i < resolution; i++) {
    	segment = (i * size) * Math.PI / 180;
    	geometry.vertices.push(new THREE.Vector3(Math.cos(segment) * radius2, length, Math.sin(segment) * radius2));
    }

    for (i = 0; i < resolution; i++) {
    	segment = (i * size) * Math.PI / 180;
    	geometry.vertices.push(new THREE.Vector3(Math.cos(segment) * (radius2 - thickness), length, Math.sin(segment) * (radius2 - thickness)));
    }

    //Faces
    var ringStep = 2 * resolution;
    for (i = 0; i < resolution - 1; i++) {

                    //First ring
                    face = new THREE.Face3(
                    	i,
                    	i + 1,
                    	i + resolution + 1);
                    geometry.faces.push(face);
                    face = new THREE.Face3(
                        i + resolution + 1,
                        i + resolution,
                        i);
                    geometry.faces.push(face);

                    //Second ring
                    face = new THREE.Face3(
                    	i + ringStep,
                    	i + ringStep + resolution,
                    	i + ringStep + resolution + 1);
                    geometry.faces.push(face);
                    face = new THREE.Face3(
                    	i + ringStep + resolution + 1,
                    	i + ringStep + 1,
                        i + ringStep);
                    geometry.faces.push(face);

                    //Inner mesh
                    face = new THREE.Face3(
                    	i + resolution + 1,
                    	i + ringStep + resolution + 1,
                    	i + ringStep + resolution);
                    geometry.faces.push(face);
                    face = new THREE.Face3(
                    	i + ringStep + resolution,
                    	i + resolution,
                        i + resolution + 1);
                    geometry.faces.push(face);

                    //Outer mesh
                    face = new THREE.Face3(
                    	i,
                    	i + ringStep,
                    	i + ringStep + 1);
                    geometry.faces.push(face);
                    face = new THREE.Face3(
                    	i + ringStep + 1,
                        i + 1,
                        i);
                    geometry.faces.push(face);
                }
                //Last round
                //First ring
                face = new THREE.Face3(
                	resolution - 1,
                	0,
                	resolution);
                geometry.faces.push(face);
                face = new THREE.Face3(
                    resolution,
                    2 * resolution - 1,
                    resolution - 1);
                geometry.faces.push(face);

                //Second ring
                face = new THREE.Face3(
                	resolution - 1 + ringStep,
                	2 * resolution - 1 + ringStep,
                	resolution + ringStep);
                geometry.faces.push(face);
                face = new THREE.Face3(
                	resolution + ringStep,
                	ringStep,
                    resolution - 1 + ringStep);
                geometry.faces.push(face);

                //Inner mesh
                face = new THREE.Face3(
                	resolution,
                	resolution + ringStep,
                	2 * resolution - 1 + ringStep);
                geometry.faces.push(face);
                face = new THREE.Face3(
                	2 * resolution - 1 + ringStep,
                    2 * resolution - 1,
                    resolution);
                geometry.faces.push(face);

//                //Outer mesh
                face = new THREE.Face3(
                    resolution - 1,
                    resolution - 1 + ringStep,
                    ringStep);
                geometry.faces.push(face);
                face = new THREE.Face3(
                    ringStep,
                    0,
                    resolution - 1);
                geometry.faces.push(face);



                //Compute normals
                geometry.computeFaceNormals();
                geometry.computeVertexNormals();
                // geometry.computeTangents();
				// geometry.computeCentroids();
				geometry.dynamic = true;

				var material = new THREE.MeshLambertMaterial( { color: 0xAAAAAA, shading: THREE.SmoothShading} );

				var polySectionMaterial = material.clone();
				polySectionMaterial.shading = THREE.FlatShading;
				var mesh = new THREE.Mesh(geometry, polySectionMaterial);

				var polySection = new THREE.Object3D();
				polySection.add(mesh);

				return polySection;
			}

