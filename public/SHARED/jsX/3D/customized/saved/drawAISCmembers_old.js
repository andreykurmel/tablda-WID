function drawAISCmember(XD, approach, app_p1, app_p2, app_p3, dbSRC, Shape, SizeType, SizeUnit, Size1, Size2, material, rot_x2stdy, shrk_pct) {
    var mesh = new THREE.Mesh();

    // alert('Shape: ' + Shape);

    if (XD == "2D" || XD == "23D") {
        clear2D();

        var dom = document.getElementById("webgl");
        var element = document.getElementById("2d");
        var canvas = element.querySelector("canvas");

        if (canvas == null) {
            canvas = document.createElement("canvas");
        }

        var ctx_ShapeBdry = canvas.getContext("2d");

        canvas.width = dom.width;
        canvas.height = dom.height;

        ctx_ShapeBdry.font = "18px Times";
        ctx_ShapeBdry.translate(canvas.width / 2, canvas.height / 2);
        ctx_ShapeBdry.scale(1.0, 1.0);

        ctx_ShapeBdry.clearRect(0, 0, canvas.width, canvas.height);
    }

    if (XD == "3D" || XD == "23D") {

    }

    switch (approach) {

        case 'dirLth':

            break;

        case 'byNodes':
            var os_x = parseFloat(app_p1[0]), os_y = parseFloat(app_p1[1]), os_z = parseFloat(app_p1[2]);
            var oe_x = parseFloat(app_p2[0]), oe_y = parseFloat(app_p2[1]), oe_z = parseFloat(app_p2[2]);
            var lth_s2e = Math.pow(Math.pow(os_x - oe_x, 2) + Math.pow(os_y - oe_y, 2) + Math.pow(os_z - oe_z, 2), 0.5);
            var v_dx = (oe_x - os_x) / lth_s2e, v_dy = (oe_y - os_y) / lth_s2e, v_dz = (oe_z - os_z) / lth_s2e;
            var shrk_lth = shrk_pct * lth_s2e;
            var ns_x = os_x + v_dx * shrk_lth, ns_y = os_y + v_dy * shrk_lth, ns_z = os_z + v_dz * shrk_lth;
            var ne_x = oe_x - v_dx * shrk_lth, ne_y = oe_y - v_dy * shrk_lth, ne_z = oe_z - v_dz * shrk_lth;
            var app_p1 = [ns_x, ns_y, ns_z], app_p2 = [ne_x, ne_y, ne_z];

            break;

        default:
            break;
    }

    console.log('fsdfe - dbSRC: ' + dbSRC + ' Shape: ' + Shape + ' SizeType: ' + SizeType + ' SizeUnit: ' + SizeUnit + ' Size1: ' + Size1 + ' Size2: ' + Size2);

    var shapeData = getshapeDataX(dbSRC, Shape, SizeType, SizeUnit, Size1, Size2);

    console.log('- shapeData: ', shapeData);
    //console.log(shapeData);

    var nodes = '', nodes_hole = '';

    //console.log('shapeData: ');
    //console.log(shapeData);
    switch (Shape) {
        case 'W':
        case "I":

            console.log('d: ' + shapeData.d + ', bf: ' + shapeData.b_f + ', t:' + shapeData.t + ', k_det: ' + shapeData.k_det + ', t_w: ' + shapeData.t_w + ', t_f: ' + shapeData.t_f + ', k_1: ' + shapeData.k_1);

            var d = parseFloat(shapeData.d) / 12;
            var bf = parseFloat(shapeData.b_f) / 12;
            var max_dim_lth = Math.max(d, bf); // to the get the maxium dimension in two directions.
            var zoomscale = (canvas.height * 2 / 4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft

            /*            for (var idir = 0; idir < 3; idir++) {
             app_p1[idir] = app_p1[idir]*zoomscale;
             app_p2[idir] = app_p2[idir]*zoomscale;
             }*/

            var T = parseFloat(shapeData.t) / 12;
            console.log('T_before: ' + T);
            if (!T) {
                console.log('k_det, before parseFloat: ' + shapeData.k_det);
                console.log('k_det, after parseFloat: ' + parseFloat(shapeData.k_det));
                console.log('parseFloat(shapeData.k_det): ' + parseFloat(shapeData.k_det));
                console.log('fraction2decimal(shapeData.k_det): ' + fraction2decimal(shapeData.k_det));
                // var k_det = parseFloat(shapeData.k_det) / 12;
                var k_det = fraction2decimal(shapeData.k_det) / 12;
                T = d - 2 * k_det;
            }
            console.log('T_after: ' + T);

            var T = T * zoomscale;
            var d = d * zoomscale;
            var bf = bf * zoomscale;

            var tw = parseFloat(shapeData.t_w) / 12 * zoomscale;

            var tf = parseFloat(shapeData.t_f) / 12 * zoomscale;
            // var k1 = parseFloat(shapeData.k_1) / 12*zoomscale;
            var k1 = fraction2decimal(shapeData.k_1) / 12 * zoomscale;

            console.log('shapeData.k_1: ' + shapeData.k_1);
            console.log('parseFloat(shapeData.k_1): ' + parseFloat(shapeData.k_1));
            console.log('fraction2decimal(shapeData.k_1): ' + fraction2decimal(shapeData.k_1));

            console.log('zoomscale: ' + zoomscale);
            console.log('d: ' + d + ', bf: ' + bf + ', T: ' + T + ', tw: ' + tw + ', tf: ' + tf + ', k1: ' + k1);

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

            // console.log(nodes); 

            break;

        case "L":
        case "L_E":
        case "L_uE":
        case "Single Equal Angle":

            // console.log('L / shapeData.d: ' + shapeData.d);

            var d = parseFloat(shapeData.d) / 12;
            var b = parseFloat(shapeData.b) / 12; // d >= b
            var max_dim_lth = Math.max(d, b); // to the get the maxium dimension in two directions.
            // var max_dim_lth = d; // d is always greater than b            
            var zoomscale = (canvas.height * 2 / 4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft

            // console.log('zoomscale: ' + zoomscale);          

            var d = d * zoomscale;
            var b = b * zoomscale;
            var t = parseFloat(shapeData.t) / 12 * zoomscale;
            var xbar = parseFloat(shapeData.x) / 12 * zoomscale;
            var ybar = parseFloat(shapeData.y) / 12 * zoomscale;

            // console.log('d = ' + d + ', b = ' + b + ', t =  ' + t + ', xbar = ' + xbar + ', ybar = ' + ybar);
            // console.log(-xbar, d - ybar);

            // in shape's local coordinate system
            var nodes = [[-xbar, b - ybar],
                [-xbar + t, b - ybar - t],
                [-xbar + t, -ybar + t + t],
                [-xbar + t + t, -ybar + t],
                [-xbar + d - t, -ybar + t],
                [-xbar + d, -ybar],
                [-xbar, -ybar],
                [-xbar + t, b - ybar],
                [0, b - ybar],
                [-xbar + d, 0]];

            nodes = crdtTrft(nodes);
            nodes = [nodes];

            // console.log(nodes); 

            break;

        case '2L_E':
        case '2L_LLBB':
        case '2L_SLBB':

            console.warn('2L / shapeData: ', shapeData);

            var d = parseFloat(shapeData.d) / 12;
            var b = parseFloat(shapeData.b) / 12; // d >= b in AISC table

            switch (Shape) {
                case '2L_E':
                    var max_dim_lth = 2 * d; // to the get the maxium dimension in two directions.
                    break;
                case '2L_LLBB':
                    var max_dim_lth = Math.max(d, 2 * b); // to the get the maxium dimension in two directions.
                    break;
                case '2L_SLBB':
                    var max_dim_lth = 2 * d; // to the get the maxium dimension in two directions.
                    break;
            }

            var zoomscale = (canvas.height * 2 / 4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft

            // console.log('zoomscale: ' + zoomscale);          

            var d = d * zoomscale;
            var b = b * zoomscale;
            var t = parseFloat(shapeData.t) / 12 * zoomscale;
            // var xbar = parseFloat(shapeData.x)/12*zoomscale;
            var ybar = parseFloat(shapeData.y) / 12 * zoomscale; // only ybar is provided in db
            var xbar = ybar; // fake value, will be shifted back

            // console.log('d = ' + d + ', b = ' + b + ', t =  ' + t + ', xbar = ' + xbar + ', ybar = ' + ybar);
            // console.log(-xbar, d - ybar);

            // in shape's local coordinate system
            var nodes_part1 = [
                [-xbar, b - ybar],
                [-xbar + t, b - ybar - t],
                [-xbar + t, -ybar + t + t],
                [-xbar + t + t, -ybar + t],
                [-xbar + d - t, -ybar + t],
                [-xbar + d, -ybar],
                [-xbar, -ybar],
                [-xbar + t, b - ybar],
                [0, b - ybar],
                [-xbar + d, 0]
            ];

            var nodes_part2 = [];

            var spacing = (1 / 8) / 12 * zoomscale; // only ybar is provided in db

            for (var i = 0; i < nodes_part1.length; i++) {
                nodes_part2[i] = [];

                for (var j = 0; j < 1; j++) {

                    switch (Shape) {
                        case '2L_E':
                            nodes_part1[i][j] = nodes_part1[i][j] + xbar + spacing / 2;
                            break;
                        case '2L_LLBB':
                            nodes_part1[i][j] = nodes_part1[i][j] + xbar + spacing / 2;
                            break;
                        case '2L_SLBB':
                            nodes_part1[i][j] = nodes_part1[i][j] + xbar + spacing / 2;
                            break;
                    }

                    nodes_part2[i][j] = nodes_part1[i][j] * -1;
                }
            }


            //console.log('nodes_part1, before: ', nodes_part1[0][0]);
            //var nodes_part2 = nodes_part1;

            //for (var i = 0; i < nodes_part2.length; i++) {
            //    for (var j = 0; j < 1; j++) {
            //        nodes_part2[i][j] = nodes_part2[i][j] * -1;
            //    }
            //}

            console.log('nodes_part1: ', nodes_part1[0][0]);
            console.log('nodes_part2: ', nodes_part2[0][0]);

            // var nodes = [crdtTrft(nodes_part1), crdtTrft(nodes_part2)];
            var nodes = [crdtTrft(nodes_part1)];

            nodes_part1 = nodes[0];
            // nodes_part2 = nodes[1];
            // console.log('nodes_part2, after: ' + nodes_part2[0][0]);

            console.log('2L_nodes: ' + nodes);

            console.log(nodes);

            break;

        case "C":
            var d = parseFloat(shapeData.d) / 12;
            var bf = parseFloat(shapeData.b_f) / 12;

            var max_dim_lth = Math.max(d, bf); // to the get the maxium dimension in two directions.
            var zoomscale = (canvas.height * 2 / 4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft
            // console.log('zoomscale: ' + zoomscale);

            d = d * zoomscale;
            bf = bf * zoomscale;
            var tf = parseFloat(shapeData.t_f) / 12 * zoomscale;
            var tw = parseFloat(shapeData.t_w) / 12 * zoomscale;
            var xbar = parseFloat(shapeData.x) / 12 * zoomscale;

            var shape = new THREE.Shape();
            var nodes = [[-xbar, -d / 2],
                [-xbar + bf, -d / 2],
                [-xbar + bf - tf, -d / 2 + tf],
                [-xbar + tw + tw, -d / 2 + tf],
                [-xbar + tw, -d / 2 + tf + tw],
                [-xbar + tw, d / 2 - tf - tw],
                [-xbar + tw + tw, d / 2 - tf],
                [-xbar + bf - tf, d / 2 - tf],
                [-xbar + bf, d / 2],
                [-xbar, d / 2],
                [-xbar, -d / 2]];

            nodes = crdtTrft(nodes);

            // console.log('Nodes for C: ');
            // console.log(nodes);

            break;

        case "HSS(Rect)":
        case "HSS(Sqr)":

            var Ht = parseFloat(shapeData.Ht) / 12;
            var B = parseFloat(shapeData.B_upr) / 12;
            console.log(shapeData);
            var max_dim_lth = Math.max(Ht, B); // to the get the maxium dimension in two directions.
            var zoomscale = (canvas.height * 2 / 4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft

            // console.log('zoomscale: ' + zoomscale);

            //if(!zoomscale) zoomscale = 400;
            Ht = Ht * zoomscale;
            B = B * zoomscale;

            var h = parseFloat(shapeData.h) / 12 * zoomscale;
            var b = parseFloat(shapeData.b) / 12 * zoomscale;

            var t_des = parseFloat(shapeData.t_des) / 12 * zoomscale;

            var f1 = (Ht - h) / 2;

            // console.log("shapeData.h",shapeData.h,shapeData.b, zoomscale);

            nodes = [[-b / 2 + f1, -h / 2],
                [b / 2 - f1, -h / 2],
                [b / 2, -h / 2 + f1],
                [b / 2, h / 2 - f1],
                [b / 2 - f1, h / 2],
                [-b / 2 + f1, h / 2],
                [-b / 2, h / 2 - f1],
                [-b / 2, -h / 2 + f1],
                [-b / 2 + f1, -h / 2]];

            nodes_hole = [[-b / 2 + f1 + t_des, -h / 2 + t_des],
                [b / 2 - f1 - t_des, -h / 2 + t_des],
                [b / 2 - t_des, -h / 2 + f1 + t_des],
                [b / 2 - t_des, h / 2 - f1 - t_des],
                [b / 2 - f1 - t_des, h / 2 - t_des],
                [-b / 2 + f1 + t_des, h / 2 - t_des],
                [-b / 2 + t_des, h / 2 - f1 - t_des],
                [-b / 2 + t_des, -h / 2 + f1 + t_des],
                [-b / 2 + f1 + t_des, -h / 2 + t_des]];

            // console.log("NODES", nodes, nodes_hole)

            break;

        case "PIPE":
        case "pipe":
        case "Pipe":
        case "HSS(Rnd)":

            var OD = parseFloat(shapeData.OD) / 12;
            var t_nom = parseFloat(shapeData.t_nom) / 12;

            var max_dim_lth = OD; // to the get the maxium dimension in two directions.
            var zoomscale = (canvas.height * 2 / 4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft

            // console.log('zoomscale: ' + zoomscale);

            OD = OD * zoomscale;
            t_nom = t_nom * zoomscale;

            nodes = OD;
            nodes_hole = t_nom;

            break;

        case "SR":
            var OD = parseFloat(shapeData.OD);
            var max_dim_lth = OD;
            var zoomscale = (canvas.height * 2 / 4) / max_dim_lth; // the plot will fit up to 2/4 of canvas width, pixles/ft

            OD = OD * zoomscale;
            nodes = OD;

        default:
            alert("Something went wrong - the given Shape: <" + Shape + "> not found - !");
            break;
    }

    var is2LE = Shape == '2L_E', symmetryNodes = [];
    if (is2LE) {
        symmetryNodes = [nodes[0].concat([])];
        for (var i = 0; i < nodes[0].length; i++) {
            symmetryNodes[0][i] = [(-1) * nodes[0][i][0], nodes[0][i][1]];
        }
    }


    if (XD == "2D" || XD == "23D") {
        drawAISC_2D(Shape, nodes, nodes_hole, zoomscale, symmetryNodes);
    }

    if (XD == "3D" || XD == "23D") {
        // console.log('3D approach: ' + approach);

        // console.log('app_p1: ');
        // console.log(app_p1);

        // console.log('app_p2: ');
        // console.log(app_p2);

        for (var idir = 0; idir < 3; idir++) {
            app_p1[idir] = app_p1[idir] * zoomscale;
            app_p2[idir] = app_p2[idir] * zoomscale;
        }

        // console.log('app_p1: ');
        // console.log(app_p1);

        // console.log('app_p2: ');
        // console.log(app_p2);

        mesh = new draw_3D(Shape, approach, app_p1, app_p2, app_p3, nodes, nodes_hole, material, is2LE ? {} : false);

        if (symmetryNodes.length) {
            var symmetry = draw_3D(Shape, approach, app_p1, app_p2, app_p3, symmetryNodes, nodes_hole, material, {symmetry: true});
            THREE.GeometryUtils.merge(mesh.geometry, symmetry.geometry);
        }

        mesh.rot = rot_x2stdy;
    }

    mesh.Shape = Shape;
    mesh.SizeType = SizeType;
    mesh.SizeUnit = SizeUnit;
    mesh.Size1 = Size1;
    mesh.Size2 = Size2;
    mesh.shapeData = shapeData;
    mesh.nodes = nodes;

    mesh.zoomscale = zoomscale;

    switch (Shape) {
        case 'W':
        case "I":
            break;

        case "L":
        case "L_E":
        case "L_uE":
        case "Single Equal Angle":

            break;

        case "C":
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
            break;
    }

    ray_objects.push(mesh);
    return (mesh);
}


function draw_3D(Shape, approach, app_p1, app_p2, app_p3, nodes, nodes_hole, material, flag) {

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

    var ctx_ShapeBdry = new THREE.Shape();
    var path_Hole = new THREE.Path();

    var txtOn = false;
    var crossSection = drawShapeBdry(Shape, nodes, nodes_hole, ctx_ShapeBdry, path_Hole, txtOn, flag);


    var geometry;
    if (approach == "byNodes") {
        geometry = extrudeLinearMember(crossSection, NodeS, NodeE);
    } else {
        geometry = new THREE.ExtrudeGeometry(crossSection, {
            bevelEnabled: false,
            amount: length
        });

    }

    var mesh = new THREE.Mesh(geometry, setMaterial(material));
    mesh.matValue = material;

    return (mesh)
}


function drawAISC_2D(Shape, nodes, nodes_hole, zoomscale, symmetryNodes) {
    window.drawAisc = true;

    var dom = document.getElementById("webgl");
    var element = document.getElementById("2d");
    var canvas = element.querySelector("canvas");

    if (canvas == null) {
        canvas = document.createElement("canvas");
    }

    var ctx_ShapeBdry = canvas.getContext("2d");
    var path_Hole = canvas.getContext("2d");

    function drawAll() {
        drawGrids();

        var txtOn = false;

        ctx_ShapeBdry = drawShapeBdry(Shape, nodes, nodes_hole, ctx_ShapeBdry, path_Hole, txtOn, Shape == '2L_E' ? {} : false);

        if (symmetryNodes && symmetryNodes.length) {
            ctx_ShapeBdry = drawShapeBdry(Shape, symmetryNodes, nodes_hole, ctx_ShapeBdry, path_Hole, txtOn, {symmetry: true});
        }

        ctx_ShapeBdry.stroke();
        ctx_ShapeBdry.fillStyle = "black";
        ctx_ShapeBdry.fill();

        drawLabel_2D(Shape, ctx_ShapeBdry, zoomscale, nodes);
    }

    function drawGrids() {
        ctx_ShapeBdry.lineWidth = 1;

        ctx_ShapeBdry.strokeStyle = "red";
        ctx_ShapeBdry.beginPath();
        ctx_ShapeBdry.moveTo(-canvas.width / 2, 0);
        ctx_ShapeBdry.lineTo(+canvas.width / 2, 0);
        ctx_ShapeBdry.stroke();

        ctx_ShapeBdry.strokeStyle = "blue";
        ctx_ShapeBdry.beginPath();
        ctx_ShapeBdry.moveTo(0, -canvas.height / 2);
        ctx_ShapeBdry.lineTo(0, +canvas.height / 2);
        ctx_ShapeBdry.stroke();

        ctx_ShapeBdry.lineWidth = 0;
        ctx_ShapeBdry.strokeStyle = "#DCDCDC";

        var Nbr_gridlines = Math.ceil(canvas.width / 2 / (1 / 12 * zoomscale));

        for (var iline = 0; iline < Nbr_gridlines; iline++) {
            ctx_ShapeBdry.beginPath();
            ctx_ShapeBdry.moveTo(-canvas.width / 2, iline * 1 / 12 * zoomscale);
            ctx_ShapeBdry.lineTo(+canvas.width / 2, iline * 1 / 12 * zoomscale);

            ctx_ShapeBdry.beginPath();
            ctx_ShapeBdry.moveTo(iline * 1 / 12 * zoomscale, -canvas.height / 2);
            ctx_ShapeBdry.lineTo(iline * 1 / 12 * zoomscale, +canvas.height / 2);

            if (iline != 0) {
                ctx_ShapeBdry.moveTo(-canvas.width / 2, -iline * 1 / 12 * zoomscale);
                ctx_ShapeBdry.lineTo(+canvas.width / 2, -iline * 1 / 12 * zoomscale);
                ctx_ShapeBdry.stroke();

                ctx_ShapeBdry.moveTo(-canvas.width / 2, +iline * 1 / 12 * zoomscale);
                ctx_ShapeBdry.lineTo(+canvas.width / 2, +iline * 1 / 12 * zoomscale);
                ctx_ShapeBdry.stroke();

                ctx_ShapeBdry.moveTo(-iline * 1 / 12 * zoomscale, -canvas.height / 2);
                ctx_ShapeBdry.lineTo(-iline * 1 / 12 * zoomscale, +canvas.height / 2);
                ctx_ShapeBdry.stroke();

                ctx_ShapeBdry.moveTo(+iline * 1 / 12 * zoomscale, -canvas.height / 2);
                ctx_ShapeBdry.lineTo(+iline * 1 / 12 * zoomscale, +canvas.height / 2);
                ctx_ShapeBdry.stroke();
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
        console.log("onResize");

        canvas.width = dom.width;
        canvas.height = dom.height;

        ctx_ShapeBdry.font = "18px Times";
        ctx_ShapeBdry.translate(canvas.width / 2, canvas.height / 2);
        ctx_ShapeBdry.scale(1, 1);

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
    if (window && window.dispatchEvent) {
        window.dispatchEvent(new Event("resize"));
    }
}

function clear2D() {
    var dom = document.getElementById("webgl");
    var element = document.getElementById("2d");
    var canvas = element.querySelector("canvas");

    if (canvas == null) {
        canvas = document.createElement("canvas");
    }

    var ctx_ShapeBdry = canvas.getContext("2d");

    canvas.width = dom.width;
    canvas.height = dom.height;

    ctx_ShapeBdry.font = "18px Times";
    ctx_ShapeBdry.translate(canvas.width / 2, canvas.height / 2);
    ctx_ShapeBdry.scale(0.9, 0.9);

    ctx_ShapeBdry.clearRect(0, 0, canvas.width, canvas.height);
}


function crdtTrft(nodes) {
    for (var inode = 0; inode < nodes.length; inode++) {
        var x_temp = nodes[inode][0], y_temp = nodes[inode][1];
        nodes[inode][0] = +x_temp;
        nodes[inode][1] = -y_temp;
    }
    return nodes;
}

function drawShapeBdry(Shape, nodes, nodes_hole, ctx_ShapeBdry, path_Hole, txtOn, round) {
    switch (Shape) {
        case "W":
        case "I":
            ctx_ShapeBdry.moveTo(nodes[0][0], nodes[0][1]);
            for (var inode = 0; inode < nodes.length; inode++) {
                ctx_ShapeBdry.lineTo(nodes[inode][0], nodes[inode][1]);
            }
            break;
        case "L":
        case "L_E":
        case "L_uE":
        case "Single Equal Angle":

        case "2L_SLBB":
        case "2L_LLBB":
        case "2L_E":

            //console.log('nodes.length: ' + nodes.length);
            var ipart = 0;

            var txtshift = 5;

            var nbr_div = 3;
            ctx_ShapeBdry.moveTo(nodes[ipart][0][0], nodes[ipart][0][1]);
            var inode = 0;
            var dist = Math.pow(Math.pow(nodes[ipart][inode][0] - nodes[ipart][inode + 1][0], 2) + Math.pow(nodes[ipart][inode][1] - nodes[ipart][inode + 1][1], 2), 1 / 2);

            var node_mdl = [(nodes[ipart][inode][0] + nodes[ipart][inode + 1][0]) / 2, (nodes[ipart][inode][1] + nodes[ipart][inode + 1][1]) / 2];
            var node_ctrl;
            if (round) {
                node_ctrl = [(  round.symmetry ? node_mdl[0] - dist / nbr_div : node_mdl[0] + dist / nbr_div), node_mdl[1] - dist / nbr_div];
            } else {
                node_ctrl = [(  node_mdl[0] + dist / nbr_div), node_mdl[1] - dist / nbr_div];
            }

            ctx_ShapeBdry.quadraticCurveTo(node_ctrl[0], node_ctrl[1], nodes[ipart][inode + 1][0], nodes[ipart][inode + 1][1]);

            if (txtOn == true) {
                ctx_ShapeBdry.fillText('0', nodes[ipart][0][0], nodes[ipart][0][1] - txtshift);
                ctx_ShapeBdry.fillText('1', nodes[ipart][1][0], nodes[ipart][1][1] - txtshift);
            }

            ctx_ShapeBdry.lineTo(nodes[ipart][2][0], nodes[ipart][2][1]);
            var inode = 2;
            var dist = Math.pow(Math.pow(nodes[ipart][inode][0] - nodes[ipart][inode + 1][0], 2) + Math.pow(nodes[ipart][inode][1] - nodes[ipart][inode + 1][1], 2), 1 / 2);

            var node_mdl = [(nodes[ipart][inode][0] + nodes[ipart][inode + 1][0]) / 2, (nodes[ipart][inode][1] + nodes[ipart][inode + 1][1]) / 2];
            var node_ctrl = [(round && round.symmetry ? node_mdl[0] + dist / nbr_div : node_mdl[0] - dist / nbr_div), node_mdl[1] + dist / nbr_div];

            ctx_ShapeBdry.quadraticCurveTo(node_ctrl[0], node_ctrl[1], nodes[ipart][inode + 1][0], nodes[ipart][inode + 1][1]);

            if (txtOn == true) {
                ctx_ShapeBdry.fillText('2', nodes[ipart][2][0] + txtshift, nodes[ipart][2][1]);
                ctx_ShapeBdry.fillText('3', nodes[ipart][3][0], nodes[ipart][3][1] - txtshift);
            }

            ctx_ShapeBdry.lineTo(nodes[ipart][4][0], nodes[ipart][4][1]);
            var inode = 4;
            var dist = Math.pow(Math.pow(nodes[ipart][inode][0] - nodes[ipart][inode + 1][0], 2) + Math.pow(nodes[ipart][inode][1] - nodes[ipart][inode + 1][1], 2), 1 / 2);

            var node_mdl = [(nodes[ipart][inode][0] + nodes[ipart][inode + 1][0]) / 2, (nodes[ipart][inode][1] + nodes[ipart][inode + 1][1]) / 2];
            if (round) {
                node_ctrl = [( round.symmetry ? node_mdl[0] - dist / nbr_div : node_mdl[0] + dist / nbr_div), node_mdl[1] - dist / nbr_div];
            } else {
                node_ctrl = [(  node_mdl[0] + dist / nbr_div), node_mdl[1] - dist / nbr_div];
            }

            ctx_ShapeBdry.quadraticCurveTo(node_ctrl[0], node_ctrl[1], nodes[ipart][inode + 1][0], nodes[ipart][inode + 1][1]);

            ctx_ShapeBdry.lineTo(nodes[ipart][6][0], nodes[ipart][6][1]);
            ctx_ShapeBdry.lineTo(nodes[ipart][0][0], nodes[ipart][0][1]);

            if (txtOn == true) {
                ctx_ShapeBdry.fillText('4', nodes[ipart][4][0], nodes[ipart][4][1] - txtshift);
                ctx_ShapeBdry.fillText('5', nodes[ipart][5][0] + txtshift, nodes[ipart][5][1]);

                ctx_ShapeBdry.fillText('6', nodes[ipart][6][0], nodes[ipart][6][1] + 2 * txtshift);

                ctx_ShapeBdry.fillText('7', nodes[ipart][7][0], nodes[ipart][7][1] + 2 * txtshift);
                ctx_ShapeBdry.fillText('8', nodes[ipart][8][0], nodes[ipart][8][1] + 2 * txtshift);
                ctx_ShapeBdry.fillText('9', nodes[ipart][9][0], nodes[ipart][9][1] + 2 * txtshift);
            }

            break;
        case 'C':
            ctx_ShapeBdry.moveTo(nodes[0][0], nodes[0][1]);
            for (var inode = 0; inode < nodes.length; inode++) {
                ctx_ShapeBdry.lineTo(nodes[inode][0], nodes[inode][1]);
            }
            break;
        case 'HSS(Rect)':
        case 'HSS(Sqr)':
            console.log(nodes[0]);

            ctx_ShapeBdry.closePath();

            ctx_ShapeBdry.moveTo(nodes[0][0], nodes[0][1]);
            for (var inode = 1; inode < nodes.length; inode++) {
                ctx_ShapeBdry.lineTo(nodes[inode][0], nodes[inode][1]);
            }

            ctx_ShapeBdry.moveTo(nodes_hole[0][0], nodes_hole[0][1]);
            for (var inode = nodes_hole.length - 1; inode >= 0; inode--) {
                ctx_ShapeBdry.lineTo(nodes_hole[inode][0], nodes_hole[inode][1]);
            }

            break;

        case "PIPE":
        case "pipe":
        case "Pipe":
        case "HSS(Rnd)":
        case "SR":

            console.log('nodes: ' + nodes + ', nodes_hole: ' + nodes_hole);
            console.log(ctx_ShapeBdry);
            var OD = nodes;
            if (ctx_ShapeBdry instanceof THREE.Shape) {
                ctx_ShapeBdry.absarc(0, 0, OD / 2, 0, 2 * Math.PI, false);
                if (nodes_hole) {
                    var t_nom = nodes_hole || 10;
                    path_Hole.absarc(0, 0, (OD - 2 * t_nom) / 2, 0, Math.PI * 2, true);
                    if (!ctx_ShapeBdry.holes) ctx_ShapeBdry.holes = [];
                    ctx_ShapeBdry.holes.push(path_Hole);
                }
            } else {
                ctx_ShapeBdry.beginPath();
                ctx_ShapeBdry.arc(0, 0, OD / 2, 0, 2 * Math.PI);
                if (nodes_hole) {
                    var t_nom = nodes_hole || 10;
                    path_Hole.arc(0, 0, (OD - 2 * t_nom) / 2, 0, Math.PI * 2, true);
                    if (!ctx_ShapeBdry.holes) ctx_ShapeBdry.holes = [];
                    ctx_ShapeBdry.holes.push(path_Hole);
                }
                ctx_ShapeBdry.closePath();
            }

            break;
    }
    return ctx_ShapeBdry;
}

function drawLabel_2D(Shape, crossSection, zoomscale, nodes) {

    var metric = null;
    var text = '';

    switch (Shape) {
        case "L":
        case "L_E":
        case "L_uE":
        case "Single Equal Angle":

            draw_dim(crossSection, nodes[0][7], nodes[0][0], 't', 2, 10, 30, 10, 20, 0, 'start', 'left');
            draw_dim(crossSection, nodes[0][0], nodes[0][8], 'x', 2, 10, 30, 10, 0, 0, 'middle', 'left');
            draw_dim(crossSection, nodes[0][5], nodes[0][6], 'b', 1, 10, 30, 10, 0, -5, 'middle', 'center');
            draw_dim(crossSection, nodes[0][6], nodes[0][0], 'd', 1, 10, 30, 10, -10, 0, 'middle', 'center');

            draw_dim(crossSection, nodes[0][9], nodes[0][5], 'y', 2, 10, 30, 10, 0, 0, 'middle', 'center');

            break;
        case 'HSS':
        case 'W':
            break;
    }
    return crossSection;
}


function draw_dim(crossSection, node_s, node_e, text, style, extline_offset, extline_lth, dimline_pos_frextlineend, offset_x, offset_y, txtAnchor, txtAlign) {

    crossSection.fillStyle = "black";  // arrow color
    crossSection.strokeStyle = 'black'; // line color

    var xs = node_s[0], zs = node_s[1];
    var xe = node_e[0], ze = node_e[1];

    var delta_x = xe - xs, delta_z = ze - zs;
    var x2 = Math.pow(delta_x, 2), z2 = Math.pow(delta_z, 2);
    var dis_nodes = Math.pow(x2 + z2, 1 / 2);
    var dirx = delta_x / dis_nodes, dirz = delta_z / dis_nodes;

    var rot = Math.PI / 2;
    var dirx_p = +dirx * Math.cos(rot) + dirz * Math.sin(rot);
    var dirz_p = -dirx * Math.sin(rot) + dirz * Math.cos(rot);

    var ext_line_node1_x = xs + dirx_p * extline_offset;
    var ext_line_node1_z = zs + dirz_p * extline_offset;

    var ext_line_node2_x = xs + dirx_p * (extline_offset + extline_lth);
    var ext_line_node2_z = zs + dirz_p * (extline_offset + extline_lth);

    crossSection.beginPath();
    crossSection.moveTo(ext_line_node1_x, ext_line_node1_z);
    crossSection.lineTo(ext_line_node2_x, ext_line_node2_z);
    crossSection.stroke();

    // ---
    var ext_line_node3_x = xe + dirx_p * extline_offset;
    var ext_line_node3_z = ze + dirz_p * extline_offset;

    var ext_line_node4_x = xe + dirx_p * (extline_offset + extline_lth);
    var ext_line_node4_z = ze + dirz_p * (extline_offset + extline_lth);

    crossSection.beginPath();
    crossSection.moveTo(ext_line_node3_x, ext_line_node3_z);
    crossSection.lineTo(ext_line_node4_x, ext_line_node4_z);
    crossSection.stroke();

    // ---
    var dim_line_node1_x = xs + dirx_p * (extline_offset + extline_lth - dimline_pos_frextlineend);
    var dim_line_node1_z = zs + dirz_p * (extline_offset + extline_lth - dimline_pos_frextlineend);

    var dim_line_node2_x = xe + dirx_p * (extline_offset + extline_lth - dimline_pos_frextlineend);
    var dim_line_node2_z = ze + dirz_p * (extline_offset + extline_lth - dimline_pos_frextlineend);

    if (style == 1) {
        drawArrow(crossSection, dim_line_node1_x, dim_line_node1_z, dim_line_node2_x, dim_line_node2_z, 1, 3);
    } else if (style == 2) {
        var dim_line_node1_x_offset = dim_line_node1_x + dirx * (-20);
        var dim_line_node1_z_offset = dim_line_node1_z + dirz * (-20);
        drawArrow(crossSection, dim_line_node1_x, dim_line_node1_z, dim_line_node1_x_offset, dim_line_node1_z_offset, 1, 2);

        var dim_line_node2_x_offset = dim_line_node2_x + dirx * 20;
        var dim_line_node2_z_offset = dim_line_node2_z + dirz * 20;
        drawArrow(crossSection, dim_line_node2_x, dim_line_node2_z, dim_line_node2_x_offset, dim_line_node2_z_offset, 1, 2);
    } else {

    }

    text_measure = crossSection.measureText(text);
    switch (txtAnchor) {
        case 'start':
            crossSection.fillText(text, dim_line_node1_x + offset_x, dim_line_node1_z + offset_y);
            break;

        case 'middle':
            crossSection.fillText(text, (dim_line_node1_x + dim_line_node2_x) / 2 + offset_x, (dim_line_node1_z + dim_line_node2_z) / 2 + offset_y);
            break;

        case 'end':
            crossSection.fillText(text, dim_line_node2_x + offset_x, dim_line_node2_z + offset_y);
            break;
    }

    crossSection.textAlign = txtAlign;

}

window.reset2D = reset2D;
window.parent.reset2D = reset2D;
