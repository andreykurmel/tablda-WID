    function drawAISCmember(XD, approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy, shrk_pct) {
        var mesh = new THREE.Mesh();

        if (XD == "2D" || XD == "23D") {
            clear2D();

            var dom = document.getElementById("webgl");
            var element = document.getElementById("2d");
            var canvas = element.querySelector("canvas");

            if (canvas == null) {
                canvas = document.createElement("canvas");
            }

            var context = canvas.getContext("2d");  

            canvas.width  = dom.width;
            canvas.height = dom.height;

            context.font = "18px Times";
            context.translate(canvas.width / 2, canvas.height / 2);
            context.scale(1.0, 1.0);   

            context.clearRect(0, 0, canvas.width, canvas.height);
        }

        if (XD == "3D" || XD == "23D"){

        }

        switch (approach) {

            case 'dirLth':

            break;

            case 'byNodes':
            var os_x = parseFloat(app_p1[0]), os_y = parseFloat(app_p1[1]), os_z = parseFloat(app_p1[2]);
            var oe_x = parseFloat(app_p2[0]), oe_y = parseFloat(app_p2[1]), oe_z = parseFloat(app_p2[2]);                    
            var lth_s2e = Math.pow(Math.pow(os_x - oe_x, 2) + Math.pow(os_y - oe_y, 2) + Math.pow(os_z - oe_z, 2), 0.5);
            var v_dx = (oe_x - os_x)/lth_s2e, v_dy = (oe_y - os_y)/lth_s2e, v_dz = (oe_z - os_z)/lth_s2e;
            var shrk_lth = shrk_pct*lth_s2e;
            var ns_x = os_x + v_dx*shrk_lth, ns_y = os_y + v_dy*shrk_lth, ns_z = os_z + v_dz*shrk_lth;
            var ne_x = oe_x - v_dx*shrk_lth, ne_y = oe_y - v_dy*shrk_lth, ne_z = oe_z - v_dz*shrk_lth;
            var app_p1 = [ns_x, ns_y, ns_z], app_p2 = [ne_x, ne_y, ne_z];

            break;

            default:
            break;
        }

        console.log('fsdfe - dbSRC: ' + dbSRC + ' Shape: ' + Shape + ' SizeType: ' + SizeType + ' SizeUnit: ' + SizeUnit + ' Size1: ' + Size1 + ' Size2: ' + Size2);

        var shapeData = getshapeDataX(dbSRC, Shape, SizeType, SizeUnit, Size1, Size2); 

        console.log('- shapeData: ' + shapeData);
        console.log(shapeData);        

        switch (Shape) {
            case 'W':
            case "I":

            var d = parseFloat(shapeData.d) / 12;
            var bf = parseFloat(shapeData.b_f) / 12;
            var max_dim_lth = Math.max(d, bf); // to the get the maxium dimension in two directions.
            var zoomscale = (canvas.height*2/4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft 

        for (var idir = 0; idir < 3; idir++) {
            app_p1[idir] = app_p1[idir]*zoomscale;
            app_p2[idir] = app_p2[idir]*zoomscale;
        }

        var T = parseFloat(shapeData.t) / 12;
        console.log('T_before: ' + T);
        if (!T) {
            console.log('k_det: ' + parseFloat(shapeData.k_det)/12);
            var k_det = parseFloat(shapeData.k_det) / 12;
            T = d - 2 * k_det;
        }         

        var T = T*zoomscale;
        var d = d*zoomscale;
        var bf = bf*zoomscale;

        var tw = parseFloat(shapeData.t_w) / 12*zoomscale;
        var tf = parseFloat(shapeData.t_f) / 12*zoomscale;
        var k1 = parseFloat(shapeData.k_1) / 12*zoomscale;

        var nodes = [
        [-bf / 2, -d / 2],
        [bf / 2, -d / 2],
        [bf / 2, -d / 2 + tf],

        [k1, -d / 2 + tf],

        [tw / 2, -T / 2],
        [tw / 2, T / 2],

        [k1, d / 2 - tf],

        [bf / 2, d / 2 - tf],
        [bf / 2, d / 2],
        [-bf / 2, d / 2],
        [-bf / 2, d / 2 - tf],
        [-k1, d / 2 - tf],
        [-tw / 2, T / 2],
        [-tw / 2, -T / 2],
        [-k1, -d / 2 + tf],
        [-bf / 2, -d / 2 + tf],
        [-bf / 2, -d / 2]];

            nodes = crdtTrft(nodes);

            console.log(nodes); 

            break;

            case "L":
            case "L_E":
            case "L_uE":
            case "Single Equal Angle":

            console.log('L / shapeData.d: ' + shapeData.d);

            var d = parseFloat(shapeData.d)/12;
            var b = parseFloat(shapeData.b)/12;            
            var max_dim_lth = Math.max(d, b); // to the get the maxium dimension in two directions.
            var zoomscale = (canvas.height*2/4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft

            console.log('zoomscale: ' + zoomscale);

            console.log('app_p2: ');
            console.log(app_p2);

            for (var idir = 0; idir < 3; idir++) {
                app_p1[idir] = app_p1[idir]*zoomscale;
                app_p2[idir] = app_p2[idir]*zoomscale;
            }

            console.log('app_p2: ');
            console.log(app_p2);            

            var d = d*zoomscale;
            var b = b*zoomscale;
            var t = parseFloat(shapeData.t)/12*zoomscale;
            var xbar = parseFloat(shapeData.x)/12*zoomscale;
            var ybar = parseFloat(shapeData.y)/12*zoomscale;

            console.log('d = ' + d + ', b = ' + b + ', t =  ' + t + ', xbar = ' + xbar + ', ybar = ' + ybar);
            console.log(-xbar, d - ybar);

            // in shape's local coordinate system
            var nodes = [[-xbar        , b - ybar],
            [-xbar + t    , b - ybar - t],
            [-xbar + t    , -ybar + t + t],
            [-xbar + t + t, -ybar + t],
            [-xbar + d - t, -ybar + t],
            [-xbar + d, -ybar],
            [-xbar, -ybar],
            [-xbar + t    , b - ybar],
            [0            , b - ybar],
            [-xbar + d    , 0]];

            nodes = crdtTrft(nodes);

            console.log(nodes); 

            break;

            case "C1":
            mesh = new drawC(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy);
            break;

            case "PIPE":
            case "pipe":
            case "Pipe":
            mesh = new drawPipe(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy);
            break;

            case "HHS(Rect)":
            mesh = new drawHHS_Rect(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy);
            break;

            case "SR":
            mesh = new drawSR(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy);
            break;

            default:
            alert("Something went wrong - the given Shape: <"+ Shape +"> not found!");
            break;
        }

        if (XD == "2D" || XD == "23D") {
            drawAISC_2D(Shape, nodes, zoomscale);
        }

        if (XD == "3D" || XD == "23D"){
            mesh = new draw_3D(Shape, approach, app_p1, app_p2, app_p3, nodes, material);
            // mesh.name = Shape + SizeType;
            mesh.rot  = rot_x2stdy;
        }
      


        mesh.max_dim_lth = max_dim_lth;
        mesh.zoomscale = zoomscale;
        return (mesh);
    }

    function drawHHS_Rect(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy) {

        switch (approach) {

            case 'dirLth':
            var dir = app_p1;
            var length = app_p2;
            var orginAt = app_p3;
            break;

            case 'byNodes':
            var NodeS = app_p1;
            var NodeE = app_p2;
            break;

            default:
            break;
        }

        var D1 = length;
        var h = D1;
        var b = shapeSize;
        var t_des = 5;
        var f1 = 0.01;

        var shape = new THREE.Shape();
        shape.moveTo(-b / 2 + f1, -h / 2);
        shape.lineTo(b / 2 - f1, -h / 2);
        shape.lineTo(b / 2, -h / 2 + f1);
        shape.lineTo(b / 2, h / 2 - f1);
        shape.lineTo(b / 2 - f1, h / 2);
        shape.lineTo(-b / 2 + f1, h / 2);
        shape.lineTo(-b / 2, h / 2 - f1);
        shape.lineTo(-b / 2, -h / 2 + f1);
        shape.lineTo(-b / 2 + f1, -h / 2);

        var hole = new THREE.Path();
        hole.moveTo(-b / 2 + f1 + t_des, -h / 2 + t_des);
        hole.lineTo(b / 2 - f1 - t_des, -h / 2 + t_des);
        hole.lineTo(b / 2 - t_des, -h / 2 + f1 + t_des);
        hole.lineTo(b / 2 - t_des, h / 2 - f1 - t_des);
        hole.lineTo(b / 2 - f1 - t_des, h / 2 - t_des);
        hole.lineTo(-b / 2 + f1 + t_des, h / 2 - t_des);
        hole.lineTo(-b / 2 + t_des, h / 2 - f1 - t_des);
        hole.lineTo(-b / 2 + t_des, -h / 2 + f1 + t_des);
        hole.lineTo(-b / 2 + f1 + t_des, -h / 2 + t_des);
        shape.holes.push(hole);

        geometry = new THREE.ExtrudeGeometry(shape, {bevelEnabled: false, amount: D1});

        geometry = memberAlignment(geometry, orginAt, dir);

        mesh = new THREE.Mesh(geometry, setMaterial(material));
        mesh.dimensions = {};
        mesh.dimensions.h = h;
        mesh.dimensions.b = b;
        mesh.dimensions.t_des = t_des;
        mesh.dimensions.f1 = f1;
        mesh.dimensions.D1 = D1;
        mesh.name = 'HHS(Rect) ' + shapeSize;
        ray_objects.push(mesh);
        mesh.matValue = material;
        return (mesh)
    }

    function drawC(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy) {

        switch (approach) {

            case 'dirLth':
            var dir = app_p1;
            var length = app_p2;
            var orginAt = app_p3;
            break;

            case 'byNodes':
            var NodeS = app_p1;
            var NodeE = app_p2;
            break;

            default:
            break;
        }

        var D1 = length;

        var shapeData = getshapeDataX('AISC140', 'C', shapeSize);
        var d = parseFloat(shapeData.d);
        var bf = parseFloat(shapeData.b_f);
        var tf = parseFloat(shapeData.t_f);
        var tw = parseFloat(shapeData.t_w);
        var xbar = parseFloat(shapeData.x);

        var shape = new THREE.Shape();
        shape.moveTo(-xbar, -d / 2);
        shape.lineTo(-xbar + bf, -d / 2);
        shape.lineTo(-xbar + bf - tf, -d / 2 + tf);
        shape.lineTo(-xbar + tw + tw, -d / 2 + tf);
        shape.lineTo(-xbar + tw, -d / 2 + tf + tw);
        shape.lineTo(-xbar + tw, d / 2 - tf - tw);
        shape.lineTo(-xbar + tw + tw, d / 2 - tf);
        shape.lineTo(-xbar + bf - tf, d / 2 - tf);
        shape.lineTo(-xbar + bf, d / 2);
        shape.lineTo(-xbar, d / 2);
        shape.lineTo(-xbar, -d / 2);

        geometry = new THREE.ExtrudeGeometry(shape, {bevelEnabled: false, amount: D1});

        geometry = memberAlignment(geometry, orginAt, dir);

        mesh = new THREE.Mesh(geometry, setMaterial(material));
        mesh.dimensions = {};
        mesh.dimensions.d = d;
        mesh.dimensions.bf = bf;
        mesh.dimensions.tf = tf;
        mesh.dimensions.tw = tw;
        mesh.dimensions.xbar = xbar;
        mesh.dimensions.D1 = D1;
        mesh.name = 'C ' + shapeSize;

        mesh.matValue = material;
        return (mesh)
    }

    function draw_3D(Shape, approach, app_p1, app_p2, app_p3, nodes, material) {

        switch (approach) {
            case 'dirLth':
            var dir = app_p1;
            var length = app_p2;
            var orginAt = app_p3;
            break;

            case 'byNodes':
            var NodeS = app_p1;
            var NodeE = app_p2;
            break;

            default:
            break;
        }

        var context = new THREE.Shape();

        var txtOn = false;
        crossSection = drawShapeBdry(Shape, nodes, context, txtOn);

        var geometry;
        if (approach == "byNodes") {
            geometry = extrudeLinearMember(crossSection, NodeS, NodeE);
        }else{
            geometry = new THREE.ExtrudeGeometry(crossSection, {
                bevelEnabled: false,
                amount: length
            });
        }

        mesh = new THREE.Mesh(geometry, setMaterial(material));

        mesh.dimensions = {};
        mesh.dimensions.length = length;
        switch (Shape) {
            case 'W':
            case "I":

            mesh.dimensions = {};
            mesh.dimensions.d = d;
            mesh.dimensions.bf = bf;
            mesh.dimensions.T = T;
            mesh.dimensions.tw = tw;
            mesh.dimensions.tf = tf;
            mesh.dimensions.k1 = k1;
            mesh.name = '???? ' + shapeSize;
            mesh.crds = crds;

            break;

            case "L":
            case "L_E":
            case "L_uE":
            case "Single Equal Angle":
            case "C1":
            break;

            case "PIPE":
            case "pipe":
            case "Pipe":
            break;

            case "HHS(Rect)":
            break;

            case "SR":
            break;

            default:
            alert("Something went wrong - the given Shape: <"+ Shape +"> not found!");
            break;
        }    

        mesh.matValue = material;
        ray_objects.push(mesh);
        return (mesh)
    }

    function drawPipe(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy) {
        var shapeSize = SizeShape;

        switch (approach) {

            case 'dirLth':
            var dir = app_p1;
            var length = app_p2;
            var orginAt = app_p3;
            break;

            case 'byNodes':
            var NodeS = app_p1;
            var NodeE = app_p2;

            break;

            default:
            break;
        }

        var D1 = length;
        var shapeData = getshapeDataX('AISC140', 'Pipe', shapeSize);
        var OD = parseFloat(shapeData.OD) / 12;
        var t_nom = parseFloat(shapeData.t) / 12;

        var shape = new THREE.Shape();
        shape.absarc(0, 0, OD, 0, Math.PI * 2, true);

        var holePath = new THREE.Path();
        holePath.absarc(0, 0, OD - t_nom, 0, Math.PI * 2, false);
        shape.holes.push(holePath);

        var geometry;

        if (approach == "byNodes") {
            geometry = extrudeLinearMember(shape, NodeS, NodeE);
        } else {
            geometry = new THREE.ExtrudeGeometry(shape, {
                bevelEnabled: false,
                amount: D1
            });
        }

        geometry = memberAlignment(geometry, orginAt, dir);

        var mesh = new THREE.Mesh(geometry, setMaterial(material));
        mesh.dimensions = {};
        mesh.dimensions.OD = OD;
        mesh.dimensions.t_nom = t_nom;
        mesh.dimensions.D1 = D1;
        mesh.name = 'Pipe ' + shapeSize;
        ray_objects.push(mesh);
        mesh.matValue = material;

        return (mesh);
    }

    function drawSR(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeShape, SizeUnit,  Size1, Size2, material, rot_x2stdy) {

        switch (approach) {

            case 'dirLth':
            var dir = app_p1;
            var length = app_p2;
            var orginAt = app_p3;
            break;

            case 'byNodes':
            var NodeS = app_p1;
            var NodeE = app_p2;
            break;

            default:
            break;
        }

        var D1 = length;
        var shapeData = getshapeDataX('AISC140', 'SR', shapeSize);
        var OD = parseFloat(shapeData.OD);

        var shape = new THREE.Shape();
        shape.absarc(0, 0, OD, 0, Math.PI * 2, true);

        geometry = new THREE.ExtrudeGeometry(shape, {bevelEnabled: false, amount: D1});

        geometry = memberAlignment(orginAt, geometry);

        mesh = new THREE.Mesh(geometry, setMaterial(material));
        mesh.dimensions = {};
        mesh.dimensions.OD = OD;
        mesh.dimensions.D1 = D1;
        mesh.name = 'SR ' + shapeSize;
        ray_objects.push(mesh);
        mesh.matValue = material;
        return (mesh)
    }

    function drawI(approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit,  Size1, Size2, material, rot_x2stdy) {

        switch (approach) {

            case 'dirLth':
            var dir = app_p1;
            var length = app_p2;
            var orginAt = app_p3;
            break;

            case 'byNodes':
            var NodeS = app_p1;
            var NodeE = app_p2;
            break;

            default:
            break;
        }

        var D1 = length;

        var shapeData = getshapeDataX('AISC140', 'W', shapeSize);

        console.log('shapeData: ');
        console.log(shapeData);



        var nodes4crsec_afRot = [];
        for (var inode = 0; inode < nodes4crsec_bfRot.length; inode++) {

            crds.push({x: nodes4crsec_bfRot[inode][0], y: nodes4crsec_bfRot[inode][1], z: 0});

            nodes4crsec_afRot[inode] = [
            nodes4crsec_bfRot[inode][0] * Math.cos(rot_x2stdy) - nodes4crsec_bfRot[inode][2] * Math.sin(rot_x2stdy),
            0,
            +nodes4crsec_bfRot[inode][0] * Math.sin(rot_x2stdy) + nodes4crsec_bfRot[inode][2] * Math.cos(rot_x2stdy)
            ];

            if (inode == 0) {
                shape.moveTo(nodes4crsec_afRot[inode][0], nodes4crsec_afRot[inode][2]);
            } else {
                shape.lineTo(nodes4crsec_afRot[inode][0], nodes4crsec_afRot[inode][2]);
            }
        }

        switch (approach) {
            case 'dirLth':
            geometry = new THREE.ExtrudeGeometry(shape, {bevelEnabled: false, amount: length});
            geometry = memberAlignment(geometry, orginAt, dir);
            break;

            case 'byNodes':
            geometry = new THREE.ExtrudeGeometry(shape, NodeS, NodeE);

            break;

            default:
            break;
        }

        mesh = new THREE.Mesh(geometry, setMaterial(material));
        mesh.dimensions = {};
        mesh.dimensions.d = d;
        mesh.dimensions.bf = bf;
        mesh.dimensions.T = T;
        mesh.dimensions.tw = tw;
        mesh.dimensions.tf = tf;
        mesh.dimensions.k1 = k1;
        mesh.name = '???? ' + shapeSize;
        mesh.crds = crds;
        ray_objects.push(mesh);
        mesh.matValue = material;
        return (mesh);
    }

function drawAISC_2D(Shape, nodes, zoomscale) {
    var dom = document.getElementById("webgl");
    var element = document.getElementById("2d");
    var canvas = element.querySelector("canvas");

    if (canvas == null) {
        canvas = document.createElement("canvas");
    }

    var context = canvas.getContext("2d");

    function drawAll() {
        drawGrids();

        var txtOn = false;
        context = drawShapeBdry(Shape, nodes, context, txtOn);
        context.stroke();
        context.fillStyle = "black";
        context.fill();

        drawLabel_2D(Shape, context, zoomscale, nodes);
    }

    function drawGrids() {
        context.lineWidth = 1;

        context.strokeStyle = "red";
        context.beginPath();
        context.moveTo(-canvas.width/2, 0);
        context.lineTo(+canvas.width/2, 0);
        context.stroke();

        context.strokeStyle = "blue";
        context.beginPath();
        context.moveTo(0, -canvas.height/2);
        context.lineTo(0, +canvas.height/2);
        context.stroke();

        context.lineWidth = 0;
        context.strokeStyle = "#DCDCDC";

        var Nbr_gridlines = Math.ceil( canvas.width/2 / (1/12*zoomscale) );

        for (var iline = 0; iline < Nbr_gridlines; iline++) {
            context.beginPath();
            context.moveTo(-canvas.width/2, iline*1/12*zoomscale);
            context.lineTo(+canvas.width/2, iline*1/12*zoomscale);

            context.beginPath();
            context.moveTo(iline*1/12*zoomscale, -canvas.height/2);
            context.lineTo(iline*1/12*zoomscale, +canvas.height/2);

            if(iline !=0){
                context.moveTo(-canvas.width/2, -iline*1/12*zoomscale);
                context.lineTo(+canvas.width/2, -iline*1/12*zoomscale);
                context.stroke();

                context.moveTo(-canvas.width/2, +iline*1/12*zoomscale);
                context.lineTo(+canvas.width/2, +iline*1/12*zoomscale);
                context.stroke();

                context.moveTo(-iline*1/12*zoomscale, -canvas.height/2);
                context.lineTo(-iline*1/12*zoomscale, +canvas.height/2);
                context.stroke();

                context.moveTo(+iline*1/12*zoomscale, -canvas.height/2);
                context.lineTo(+iline*1/12*zoomscale, +canvas.height/2);
                context.stroke();
            }
        }
    }


    function onMouseWheel(event) {
        event.preventDefault();
        event.stopPropagation();

        var delta = 0;

        if (event.wheelDelta !== undefined) {
            delta = event.wheelDelta;
        } else if (event.detail !== undefined) {
            delta = -event.detail;
        }

        if (delta > 0) {
            console.log("in");
        } else if (delta < 0) {
            console.log("out");
        }
    }

    function onResize(event) {
        canvas.width = dom.width;
        canvas.height = dom.height;

        context.font = "18px Times";
        context.translate(canvas.width / 2, canvas.height / 2);
        context.scale(0.9, 0.9);

        drawAll()
    }

    canvas.addEventListener('mousewheel', onMouseWheel, false);
    canvas.addEventListener('MozMousePixelScroll', onMouseWheel, false); // firefox
    window.addEventListener('resize', onResize, false);

    document.getElementById("2d").appendChild(canvas);

    //drawAll();
    onResize();
}

function reset2D() {
    console.log(111);
    window.dispatchEvent(new Event("resize"));
}

function clear2D() {
    var dom = document.getElementById("webgl");
    var element = document.getElementById("2d");
    var canvas = element.querySelector("canvas");

    if (canvas == null) {
        canvas = document.createElement("canvas");
    }

    var context = canvas.getContext("2d");

    canvas.width  = dom.width;
    canvas.height = dom.height;

    context.font = "18px Times";
    context.translate(canvas.width / 2, canvas.height / 2);
    context.scale(0.9, 0.9);

    context.clearRect(0, 0, canvas.width, canvas.height);
}


function crdtTrft(nodes) {
    for (var inode = 0; inode < nodes.length; inode++) {
        var x_temp = nodes[inode][0], y_temp = nodes[inode][1];
        nodes[inode][0] = +x_temp;
        nodes[inode][1] = -y_temp;
    }    
    return nodes;
}



function drawShapeBdry(Shape, nodes, ShapeBdry, txtOn) {

    switch (Shape){
        case "W":
        case "I":

            ShapeBdry.moveTo(nodes[0][0], nodes[0][1]);
        for (var inode = 0; inode < nodes.length; inode++) {
            ShapeBdry.lineTo(nodes[inode][0], nodes[inode][1]);
        }

        break;
        case "L":
        case "L_E":
        case "L_uE":
        case "Single Equal Angle":

        var  txtshift = 5;

        var nbr_div = 3;
        ShapeBdry.moveTo(nodes[0][0], nodes[0][1]);
        var inode = 0;
        var dist = Math.pow(Math.pow(nodes[inode][0] - nodes[inode + 1][0], 2) + Math.pow(nodes[inode][1] - nodes[inode + 1][1], 2), 1/2);
        var node_mdl  = [(nodes[inode][0] + nodes[inode + 1][0])/2, (nodes[inode][1] + nodes[inode + 1][1])/2];
        var node_ctrl = [node_mdl[0] + dist/nbr_div, node_mdl[1] - dist/nbr_div];
        ShapeBdry.quadraticCurveTo(node_ctrl[0], node_ctrl[1], nodes[inode + 1][0], nodes[inode + 1][1]);

        if (txtOn == true){
            ShapeBdry.fillText('0', nodes[0][0], nodes[0][1] - txtshift);
            ShapeBdry.fillText('1', nodes[1][0], nodes[1][1] - txtshift);
        }

        ShapeBdry.lineTo(nodes[2][0], nodes[2][1]);
        var inode = 2;
        var dist = Math.pow(Math.pow(nodes[inode][0] - nodes[inode + 1][0], 2) + Math.pow(nodes[inode][1] - nodes[inode + 1][1], 2), 1/2);
        var node_mdl  = [(nodes[inode][0] + nodes[inode + 1][0])/2, (nodes[inode][1] + nodes[inode + 1][1])/2];
        var node_ctrl = [node_mdl[0] - dist/nbr_div, node_mdl[1] + dist/nbr_div];
        ShapeBdry.quadraticCurveTo(node_ctrl[0], node_ctrl[1], nodes[inode + 1][0], nodes[inode + 1][1]);

        if (txtOn == true){
            ShapeBdry.fillText('2', nodes[2][0] + txtshift, nodes[2][1]);
            ShapeBdry.fillText('3', nodes[3][0], nodes[3][1] - txtshift); 
        }       

        ShapeBdry.lineTo(nodes[4][0], nodes[4][1]);
        var inode = 4;
        var dist = Math.pow(Math.pow(nodes[inode][0] - nodes[inode + 1][0], 2) + Math.pow(nodes[inode][1] - nodes[inode + 1][1], 2), 1/2);
        var node_mdl  = [(nodes[inode][0] + nodes[inode + 1][0])/2, (nodes[inode][1] + nodes[inode + 1][1])/2];
        var node_ctrl = [node_mdl[0] + dist/nbr_div, node_mdl[1] - dist/nbr_div];
        ShapeBdry.quadraticCurveTo(node_ctrl[0], node_ctrl[1], nodes[inode + 1][0], nodes[inode + 1][1]);

        ShapeBdry.lineTo(nodes[6][0], nodes[6][1]);
        ShapeBdry.lineTo(nodes[0][0], nodes[0][1]);

        if (txtOn == true){
            ShapeBdry.fillText('4', nodes[4][0], nodes[4][1] - txtshift);
            ShapeBdry.fillText('5', nodes[5][0] + txtshift, nodes[5][1]);  

            ShapeBdry.fillText('6', nodes[6][0], nodes[6][1] + 2*txtshift);

            ShapeBdry.fillText('7', nodes[7][0], nodes[7][1] + 2*txtshift);
            ShapeBdry.fillText('8', nodes[8][0], nodes[8][1] + 2*txtshift);
            ShapeBdry.fillText('9', nodes[9][0], nodes[9][1] + 2*txtshift);
        }               

        break;         
        case 'HSS':
        case 'W':
        break;
    }
    return ShapeBdry;
}

function drawLabel_2D(Shape, crossSection, zoomscale, nodes) {

    var metric = null;
    var text = '';

    switch (Shape){
        case "L":
        case "L_E":
        case "L_uE":
        case "Single Equal Angle":

        draw_dim(crossSection, nodes[7], nodes[0], 't',  2, 10, 30, 10, 20,   0, 'start', 'left'); 
        draw_dim(crossSection, nodes[0], nodes[8], 'x',  2, 10, 30, 10,  0,   0, 'middle', 'left');
        draw_dim(crossSection, nodes[5], nodes[6], 'b',  1, 10, 30, 10,  0,  -5, 'middle', 'center');
        draw_dim(crossSection, nodes[6], nodes[0], 'd',  1, 10, 30, 10, -10,  0, 'middle', 'center');

        draw_dim(crossSection, nodes[9], nodes[5], 'y',  2, 10, 30, 10,  0,  0, 'middle', 'center');

        break;         
        case 'HSS':
        case 'W':
        break;
    }

    return crossSection;
}


function draw_dim(crossSection, node_s, node_e, text, style, extline_offset, extline_lth, dimline_pos_frextlineend, offset_x, offset_y, txtAnchor, txtAlign){

crossSection.fillStyle = "black";  // arrow color
crossSection.strokeStyle = 'black'; // line color

var xs = node_s[0], zs = node_s[1];
var xe = node_e[0], ze = node_e[1];

var delta_x = xe - xs, delta_z = ze - zs;
var x2 = Math.pow(delta_x, 2), z2 = Math.pow(delta_z, 2);
var dis_nodes = Math.pow(x2 + z2, 1/2);
var dirx = delta_x/dis_nodes, dirz = delta_z/dis_nodes;

var rot = Math.PI/2;
var dirx_p = +dirx*Math.cos(rot) + dirz*Math.sin(rot);
var dirz_p = -dirx*Math.sin(rot) + dirz*Math.cos(rot);

var ext_line_node1_x = xs + dirx_p*extline_offset;
var ext_line_node1_z = zs + dirz_p*extline_offset;

var ext_line_node2_x = xs + dirx_p*(extline_offset + extline_lth);
var ext_line_node2_z = zs + dirz_p*(extline_offset + extline_lth);

crossSection.beginPath();
crossSection.moveTo(ext_line_node1_x, ext_line_node1_z);
crossSection.lineTo(ext_line_node2_x, ext_line_node2_z);
crossSection.stroke();

// ---
var ext_line_node3_x = xe + dirx_p*extline_offset;
var ext_line_node3_z = ze + dirz_p*extline_offset;

var ext_line_node4_x = xe + dirx_p*(extline_offset + extline_lth);
var ext_line_node4_z = ze + dirz_p*(extline_offset + extline_lth);

crossSection.beginPath();
crossSection.moveTo(ext_line_node3_x, ext_line_node3_z);
crossSection.lineTo(ext_line_node4_x, ext_line_node4_z);
crossSection.stroke();

// --- 
var dim_line_node1_x = xs + dirx_p*(extline_offset + extline_lth - dimline_pos_frextlineend);
var dim_line_node1_z = zs + dirz_p*(extline_offset + extline_lth - dimline_pos_frextlineend);

var dim_line_node2_x = xe + dirx_p*(extline_offset + extline_lth - dimline_pos_frextlineend);
var dim_line_node2_z = ze + dirz_p*(extline_offset + extline_lth - dimline_pos_frextlineend);

if (style==1){
    drawArrow(crossSection, dim_line_node1_x, dim_line_node1_z, dim_line_node2_x, dim_line_node2_z, 1, 3);
}else if (style==2){
    var dim_line_node1_x_offset = dim_line_node1_x + dirx*(-20);  
    var dim_line_node1_z_offset = dim_line_node1_z + dirz*(-20); 
    drawArrow(crossSection, dim_line_node1_x, dim_line_node1_z, dim_line_node1_x_offset, dim_line_node1_z_offset, 1, 2);

    var dim_line_node2_x_offset = dim_line_node2_x + dirx*20;  
    var dim_line_node2_z_offset = dim_line_node2_z + dirz*20; 
    drawArrow(crossSection, dim_line_node2_x, dim_line_node2_z, dim_line_node2_x_offset, dim_line_node2_z_offset, 1, 2);    
}else{

}

text_measure = crossSection.measureText(text);
switch (txtAnchor){
    case 'start':
    crossSection.fillText(text, dim_line_node1_x + offset_x, dim_line_node1_z + offset_y);
    break;

    case 'middle':
    crossSection.fillText(text, (dim_line_node1_x + dim_line_node2_x)/2 + offset_x, (dim_line_node1_z + dim_line_node2_z)/2 + offset_y);
    break;

    case 'end':
    crossSection.fillText(text, dim_line_node2_x + offset_x, dim_line_node2_z + offset_y);
    break;
}

crossSection.textAlign=txtAlign;

}
