(function (exports) {
    var dom, element;
    var scene, camera, renderer, controls;
    var light, raycaster;

    var ais;
    var gridXY, gridYZ, gridZX;
    var nodes = [];

    var viewSettings = {};

    var LAST;
    var INTERSECTED;
    var mouse = new THREE.Vector2();

    var onSelected;

    function Init() {
        renderer = new THREE.WebGLRenderer({alpha: false});
        renderer.setSize(dom.width, dom.height);
        renderer.setClearColor("#ffffff");

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera(45, dom.width / dom.height, 0.1, 1000);

        camera.position.set(0, 10, 10);
        camera.lookAt(scene.position);

        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.noKeys = true;

        light = new THREE.DirectionalLight("#ffffff", 0.5);
        light.position.set(1, 1, 0);

        raycaster = new THREE.Raycaster();

        ais = new THREE.Mesh();

        gridZX = new THREE.GridHelper(10, 1);
        gridZX.name = 'gridZX';

        gridXY = new THREE.GridHelper(10, 1);
        gridXY.name = 'gridXY';
        gridXY.rotation.x = 90 * Math.PI / 180;

        gridYZ = new THREE.GridHelper(10, 1);
        gridYZ.name = 'gridYZ';
        gridYZ.rotation.z = 90 * Math.PI / 180;

        scene.add(ais);
        scene.add(gridZX);
        scene.add(gridYZ);
        scene.add(gridXY);
        scene.add(light);
        scene.add(new THREE.AmbientLight("#e1e1e1"));

        Axes();
        Event();

        dom.appendChild(renderer.domElement);
    }

    function ChangeViewSettings(settings) {
        viewSettings = settings;


        scene.getObjectByName('gridZX').visible = settings.planeZX;
        scene.getObjectByName('gridYZ').visible = settings.planeYZ;
        scene.getObjectByName('gridXY').visible = settings.planeXY;

        scene.traverse(function (child) {
            if (child instanceof THREE.Sprite) {
                if (child.type == 'node') {
                    child.visible = settings.nodesName;
                }

                if (child.type == 'line') {
                    child.visible = settings.wireframeName;
                }
            }

            if (child instanceof THREE.Mesh) {
                if (child.type == 'node') {
                    child.visible = settings.nodes;
                }

                if (child.type == 'member') {
                    child.visible = settings.members;
                }

                if (child.type == 'nodeLabel') {
                    child.visible = settings.nodesName;
                }

                if (child.type == 'memberLabel') {
                    child.visible = settings.wireframeName;
                }
            }

            if (child instanceof THREE.Line) {
                if (child.type == 'line') {
                    child.visible = settings.wireframe;
                }
            }
        });
    }

    function Axes(params) {
        params = params || {};

        var axisRadius = params.radius !== undefined ? params.radius : 0.02;
        var axisLength = params.length !== undefined ? params.length : 2;
        var axisTess = params.tess !== undefined ? params.tess : 12;

        var axisXMaterial = new THREE.MeshLambertMaterial({color: 0xFF0000});
        var axisYMaterial = new THREE.MeshLambertMaterial({color: 0x00FF00});
        var axisZMaterial = new THREE.MeshLambertMaterial({color: 0x0000FF});

        axisXMaterial.side = THREE.DoubleSide;
        axisYMaterial.side = THREE.DoubleSide;
        axisZMaterial.side = THREE.DoubleSide;

        var axisX = new THREE.Mesh(
            new THREE.CylinderGeometry(axisRadius, axisRadius, axisLength, axisTess, 1, true),
            axisXMaterial
        );
        var axisY = new THREE.Mesh(
            new THREE.CylinderGeometry(axisRadius, axisRadius, axisLength, axisTess, 1, true),
            axisYMaterial
        );
        var axisZ = new THREE.Mesh(
            new THREE.CylinderGeometry(axisRadius, axisRadius, axisLength, axisTess, 1, true),
            axisZMaterial
        );

        axisX.rotation.z = -Math.PI / 2;
        axisX.position.x = axisLength / 2 - 1;

        axisY.position.y = axisLength / 2 - 1;

        axisZ.rotation.y = -Math.PI / 2;
        axisZ.rotation.z = -Math.PI / 2;
        axisZ.position.z = axisLength / 2 - 1;

        scene.add(axisX);
        scene.add(axisY);
        scene.add(axisZ);

        var arrowX = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 4 * axisRadius, 4 * axisRadius, axisTess, 1, true),
            axisXMaterial
        );

        var arrowY = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 4 * axisRadius, 4 * axisRadius, axisTess, 1, true),
            axisYMaterial
        );

        var arrowZ = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 4 * axisRadius, 4 * axisRadius, axisTess, 1, true),
            axisZMaterial
        );

        arrowX.rotation.z = -Math.PI / 2;
        arrowX.position.x = axisLength - 1 + axisRadius * 4 / 2;

        arrowY.position.y = axisLength - 1 + axisRadius * 4 / 2;

        arrowZ.rotation.z = -Math.PI / 2;
        arrowZ.rotation.y = -Math.PI / 2;
        arrowZ.position.z = axisLength - 1 + axisRadius * 4 / 2;

        scene.add(arrowX);
        scene.add(arrowY);
        scene.add(arrowZ);
    }

    function Render() {
        Update();
        Resize();

        renderer.render(scene, camera);
        requestAnimationFrame(Render);
    }

    function Update() {

    }

    function Event() {
        dom.onclick = onMouseDown;

        function onMouseDown(event) {
            if (event.button != 0) {
                return false;
            }

            mouse.x = (event.offsetX / dom.width) * 2 - 1;
            mouse.y = -(event.offsetY / dom.height) * 2 + 1;

            raycaster.setFromCamera(mouse, camera);

            var intersects = raycaster.intersectObjects(ais.children, true);

            if (intersects.length > 0) {
                if (INTERSECTED != intersects[0].object) {
                    if (INTERSECTED && INTERSECTED.material) {
                        INTERSECTED.material.color.setHex(INTERSECTED.currentHex);
                    }

                    INTERSECTED = intersects[0].object;

                    if (INTERSECTED && INTERSECTED.material) {
                        INTERSECTED.currentHex = INTERSECTED.material.color.getHex();
                        INTERSECTED.material.color.setHex(0xff0000);
                    }
                }
            } else {
                if (INTERSECTED && INTERSECTED.material) {
                    INTERSECTED.material.color.setHex(INTERSECTED.currentHex);
                    LAST = INTERSECTED;
                }

                INTERSECTED = null;
            }

            if (typeof onSelected == "function") {
                if (LAST != null) {
                    onSelected.call({}, null);
                }

                onSelected.call({}, INTERSECTED);
            }

            event.preventDefault();
        }
    }

    function Resize() {
        dom = document.querySelector(element);

        var width = dom.innerWidth || dom.offsetWidth;
        var height = dom.innerHeight || dom.offsetHeight;

        if (dom.width != width || dom.height != height) {
            dom.width = width;
            dom.height = height;

            camera.aspect = dom.width / dom.height;
            camera.updateProjectionMatrix();

            renderer.setSize(dom.width, dom.height);
        }
    }

    function Run(selector) {
        element = selector;
        dom = document.querySelector(selector);

        dom.width = dom.innerWidth || dom.offsetWidth;
        dom.height = dom.innerHeight || dom.offsetHeight;

        Init();
        Render();
        Event();
    }

    function Draw(objects, state, type) {
        // console.log('objects, state, type', objects, state, type);

        var temp = [];
        var object = new THREE.Mesh();

        if (state == "update") {
            ais.traverse(function (child) {
                if (child instanceof THREE.Mesh) {
                    for (var key in objects) {
                        if (child.item == objects[key].id) {
                            temp.push(child);
                        }
                    }
                }
            });

            for (var key in temp) {
                ais.remove(temp[key]);
            }

            return ais;
        } else if (state == "delete") {
            ais.traverse(function (child) {
                if (child instanceof THREE.Mesh) {
                    if (objects.length) {
                        for (var key in objects) {
                            if (child.item == objects[key].id) {
                                temp.push(child);
                            }
                        }
                    } else {
                        temp.push(child);
                    }
                }
            });

            for (var key in temp) {
                ais.remove(temp[key]);
            }

            return ais;
        } else {
            if (type == "nodes") {
                drawNodes(objects, ais, "redraw");
            } else if(type == "cylinder") {
                drawCylinder(objects, ais, "redraw");
            } else if(type == "sphere") {
                drawSphere(objects, ais, "redraw");
            } else {
                drawObjects(objects, ais, "redraw");
            }
        }
        Aspect();

        return ais;
    }

    function drawObjects(objects, parent, action) {
        if (action == "redraw") {
            removeByType(parent, 'line');
            removeByType(parent, 'member');
            removeByType(scene, 'memberLabel');
        }

        objects.forEach(function (item) {
            if (item.other.node && item.other.node.s && item.other.node.e && item.other.node.s.length && item.other.node.e.length) {
                var approach = "byNodes";
            } else {
                var approach = "dirLth";
            }

            switch (approach) {
                case 'dirLth':
                    var app_p1 = "ny";
                    var app_p2 = item.length;
                    var app_p3 = "start";
                    break;
                case 'byNodes':
                    var app_p1 = item.other.node.s;
                    var app_p2 = item.other.node.e;

                    var app_p3 = '';
                    break;
                default:
                    break;
            }

            var material = "metal";
            var rot_x2stdy = 0;

            // console.log('item.shape: ' + item.shape + ', item.size: ' + item.size);
            
            // console.log('WEB GL', approach, app_p1, app_p2, app_p3, item.shape, item.size, material, rot_x2stdy);

            // var object = drawAISCmember('3D', approach, app_p1, app_p2, app_p3, item.shape, item.size, material, rot_x2stdy);

            // object.item = item.id;
            //
            // if (approach == "dirLth") {
            //     object.position.set(item.other.x1 || 0, item.other.y1 || 0, item.other.z1 || 0);
            //     object.rotation.set(item.other.x2 || 0, item.other.y2 || 0, item.other.z2 || 0);
            // }
            //
            // object.type = 'member';
            //
            // object.visible = viewSettings.members;

            if (item.nodes && item.nodes.NodeE && item.nodes.NodeS) {
                var geometry = new THREE.Geometry();

                geometry.vertices.push(parent.getObjectByName("node" + item.nodes.NodeE).position);
                geometry.vertices.push(parent.getObjectByName("node" + item.nodes.NodeS).position);

                var line = new THREE.Line(geometry, new THREE.LineBasicMaterial({color: 0x0051FF}));
                line.type = 'line';
                line.visible = viewSettings.wireframe;

                parent.add(line);
            }

            // console.log(item.name);

            if (item.nodes && item.nodes.NodeE && item.nodes.NodeS) {
                var nodeSPosition = parent.getObjectByName("node" + item.nodes.NodeS).position;
                var nodeEPosition = parent.getObjectByName("node" + item.nodes.NodeE).position;

                var nodeDirection = (nodeSPosition.x <= nodeEPosition.x || nodeSPosition.y <= nodeEPosition.y || nodeSPosition.z <= nodeEPosition.z);

                var nodeLabel = GetStaticLabel(item.name, 14, nodeDirection);

                SetAlongLine(nodeLabel, [
                    new THREE.Vector3(parseFloat(nodeSPosition.x), parseFloat(nodeSPosition.y), parseFloat(nodeSPosition.z)),
                    new THREE.Vector3(parseFloat(nodeEPosition.x), parseFloat(nodeEPosition.y), parseFloat(nodeEPosition.z))
                ], 0.5);

                nodeLabel.type = 'memberLabel';
                nodeLabel.visible = viewSettings.wireframeName;
                scene.add(nodeLabel);
            }


            //var spritey = makeTextSprite(item.name, {
            //    fontsize: 32
            //});
            //
            //var box3 = new THREE.Box3().setFromObject(object);
            //
            //spritey.position.set(box3.center().x, box3.center().y, box3.center().z);
            //spritey.type = 'line';
            //spritey.visible = viewSettings.wireframeName;
            //scene.add(spritey);

            // parent.add(object);

            // console.log(object.position);
        });
    }

    function drawNodes(nodes, parent, action) {
        // console.log(nodes, parent, action);
        if (action == "redraw") {
            removeByType(parent, 'node');
            removeByType(parent, 'nodeLabel');
            removeByType(parent, 'cylinderB');
            removeByType(parent, 'sphereB');
        }

        if (nodes) {
            nodes.forEach(function (node) {
                var geometry = new THREE.SphereGeometry(0.1, 32, 32);
                var material = new THREE.MeshBasicMaterial({color: 0x000000});
                var sphere = new THREE.Mesh(geometry, material);

                sphere.position.set(node.x, node.y, node.z);
                sphere.item = node.no;
                sphere.type = 'node';
                sphere.name = 'node' + node.no;
                sphere.visible = viewSettings.nodes;

                /*
                var nodeLabel = GetStaticLabel(node.node_name, 14);

                nodeLabel.position.set(0, 0.1, 0);

                nodeLabel.type = 'nodeLabel';
                nodeLabel.visible = viewSettings.nodesName;
                sphere.add(nodeLabel);
                */
                if(node.node_name) {
                    var spritey = makeTextSprite(node.node_name, {
                        fontsize: 32
                    });

                    spritey.position.set(node.x, node.y, node.z);
                    spritey.type = 'node';
                    spritey.visible = viewSettings.nodesName;
                    scene.add(spritey);
                }

                parent.add(sphere);
            });
        }
    }

    function drawCylinder(objects, parent, action) {
        if (action == "redraw") {
            removeByType(parent, 'cylinderB');
            removeByType(parent, 'sphereB');
            removeByType(parent, 'node');
            removeByType(parent, 'nodeLabel');
            removeByType(parent, 'line');
            removeByType(parent, 'member');
            removeByType(scene, 'memberLabel');
        }

        var height = objects[0];
        var radius = objects[1]/2;

        var geometry = new THREE.CylinderGeometry( radius, radius, height, 12 );
        var material = new THREE.MeshPhongMaterial({color: 0x0000ff, transparent: true, wireframe: true} );
        var cylinder = new THREE.Mesh( geometry, material );

        cylinder.position.set(0,height/2,0);
        cylinder.type = 'cylinderB';

        parent.add( cylinder );
    }

    function drawSphere(objects, parent, action) {
        if (action == "redraw") {
            removeByType(parent, 'cylinderB');
            removeByType(parent, 'sphereB');
            removeByType(parent, 'node');
            removeByType(parent, 'nodeLabel');
            removeByType(parent, 'line');
            removeByType(parent, 'member');
            removeByType(scene, 'memberLabel');
        }

        var radius = objects[0]/2;

        var geometry = new THREE.SphereGeometry(radius, 16, 16);
        var material = new THREE.MeshPhongMaterial({color: 0x0000ff, transparent: true, wireframe: true} );
        var sphere = new THREE.Mesh( geometry, material );

        sphere.position.set(0,radius,0);
        sphere.type = 'sphereB';

        parent.add( sphere );
    }

    function removeByType(parent, type) {
        var temp = [];
        var temp1 = [];

        parent.traverse(function (child) {
            if (child instanceof THREE.Mesh || child instanceof THREE.Line) {
                if (child.type == type) {
                    temp.push(child);
                }
            }
        });

        for (var key in temp) {
            parent.remove(temp[key]);
        }

        scene.traverse(function (child) {
            if (child instanceof THREE.Sprite) {
                if (child.type == type) {
                    temp1.push(child);
                }
            }
        });

        for (var key in temp1) {
            scene.remove(temp1[key]);
        }
    }

    function Aspect() {
        var box = new THREE.Box3().setFromObject(scene);

        camera.position.z = Math.abs(Math.max(box.size().x, box.size().y, box.size().z) + 5);
        camera.lookAt(scene.position);
    }

    function Selected(callback) {
        onSelected = callback;
    }

    function makeTextSprite(message, parameters) {
        if (parameters === undefined) {
            parameters = {};
        }

        var fontface = parameters.hasOwnProperty("fontface") ?
            parameters["fontface"] : "Arial";

        var fontsize = parameters.hasOwnProperty("fontsize") ?
            parameters["fontsize"] : 18;

        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');

        context.font = fontsize + "px " + fontface;
        context.fillStyle = "rgba(0, 0, 0, 1.0)";
        context.fillText(message, 0, fontsize * 2);

        var texture = new THREE.Texture(canvas);
        texture.needsUpdate = true;

        var spriteMaterial = new THREE.SpriteMaterial({
            map: texture
        });

        var sprite = new THREE.Sprite(spriteMaterial);
        sprite.position.set(0, 0, 1);
        sprite.scale.set(2, 1, 1);

        return sprite;
    }

    function GetStaticLabel(text, font, direction) {
        font = font || 14;

        var canvas = document.createElement('canvas');
        canvas.width = 100;
        canvas.height = 40;

        var context = canvas.getContext('2d');
        context.font = font + "px Arial";
        context.fillStyle = "rgba(0, 0, 0, 1)";
        context.fillText(text, 0, 14);

        var texture = new THREE.Texture(canvas);
        texture.needsUpdate = true;

        var material = new THREE.MeshBasicMaterial({
            map: texture,
            side: THREE.DoubleSide,
            transparent: true
        });

        var geometry = new THREE.PlaneGeometry(canvas.width, canvas.height);

        if (direction !== undefined) {
            if (direction === true) {
                geometry.applyMatrix(new THREE.Matrix4().makeRotationZ(Math.PI / 2));
                geometry.applyMatrix(new THREE.Matrix4().makeRotationY((-Math.PI / 3) - 0.1));
            } else {
                geometry.applyMatrix(new THREE.Matrix4().makeRotationZ(-Math.PI / 2));
                geometry.applyMatrix(new THREE.Matrix4().makeRotationY((-Math.PI / 3) - 0.3));
            }
        }

        geometry.verticesNeedUpdate = true;

        var mesh = new THREE.Mesh(
            geometry,
            material
        );

        mesh.position.set(0, 0, 0);
        mesh.scale.set(0.01, 0.01, 0.01);

        return mesh;
    }

    function SetAlongLine(marker, points, delta) {
        var up = new THREE.Vector3(0, 1, 0);

        var spline = new THREE.SplineCurve3(points);
        var pt = spline.getPoint(delta);

        var tangent = spline.getTangent(delta).normalize();
        var axis = new THREE.Vector3().crossVectors(up, tangent).normalize();

        var radians = Math.acos(up.dot(tangent));

        marker.position.set(pt.x, pt.y, pt.z);
        marker.quaternion.setFromAxisAngle(axis, radians);

        //var material = new THREE.LineBasicMaterial({
        //    color: 0xff00f0
        //});
        //
        //var geometry = new THREE.Geometry();
        //for (var i = 0; i < spline.getPoints(100).length; i++) {
        //    geometry.vertices.push(spline.getPoints(100)[i]);
        //}
        //
        //var line = new THREE.Line(geometry, material);
        //scene.add(line);
    }

    exports.run = Run;
    exports.draw = Draw;
    exports.selected = Selected;
    exports.changeViewSettings = ChangeViewSettings;
})(window.webgl || (window.webgl = {}));