(function (exports) {
    var dom, element;
    var scene, camera, renderer, controls;
    var light,light1,light2,light3, raycaster;

    var DOMaxesHelper, rendererAxesHelper, axesHelperScene, axesHelperContainer, axesHelperCamera, axesHelper;

    var ais;
    var gridXY, gridYZ, gridZX;
    var Axises;
    var nodes = [];

    var viewSettings = {};


    var LAST;
    var INTERSECTED;
    var mouse = new THREE.Vector3();

    var onSelected;
    var onRigthClickSelect;
    var onCameraUpdate;

    var cameraHUD, sceneHUD;
    var hudCanvas, hudBitmap;

    var lastCameraType = '';
    var lastZoom = 0;

    var shape = 'shape'; // To be changed according to web selection.

    var terrain;

    function adaptFigureScale(figure, camera){
        let distance = camera.position.distanceTo(figure.position);
        if(figure.type === 'nodeLabel' || figure.type === 'memberLabel' || figure.type === 'equipmentLabel'){

            if(distance > 15) {
                distance = 15;
            } else if(distance < 3) {
                distance = 3;
            }

            let size = (distance/15) * (viewSettings.fontSize/20);
            figure.scale.set(size * 2, size, size);

        } else if (figure.type === 'node') {
            if (distance < 20) {
                if (distance < 1) distance = 1;
                let size = distance / 20;
                figure.scale.set(size, size, size);
            } else {
                figure.scale.set(1, 1, 1);
            }
        }
    }

    function AdjustFrameScale(frame, scale) {
        if(frame) frame.scale.set(scale, scale, scale);
    }

    function EnableAxesMinimap(selector) {
        DOMaxesHelper = document.querySelector(selector);
        rendererAxesHelper = new THREE.WebGLRenderer({antialias: true, alpha: true});
        rendererAxesHelper.setSize(DOMaxesHelper.offsetWidth, DOMaxesHelper.offsetHeight);

        axesHelperScene = new THREE.Scene();

        axesHelperCamera = new THREE.PerspectiveCamera( 30, DOMaxesHelper.offsetWidth / DOMaxesHelper.offsetHeight, 0.1, 1000 );
        axesHelperCamera.position.set(0, 0, 0.6);
        axesHelperScene.add(axesHelperCamera);

        var light = new THREE.AmbientLight( 0xCCCCCC ); // soft white light
        axesHelperScene.add( light );


        axesHelperContainer = new THREE.Object3D();
        axesHelperScene.add(axesHelperContainer);

        drawAllAxes({'axesHelperMinimap': true, 'needsLabels': true});

        DOMaxesHelper.appendChild(rendererAxesHelper.domElement);
    }

    function Init(mode) {
        raycaster = new THREE.Raycaster();

        renderer = new THREE.WebGLRenderer({antialias: true, alpha: false, preserveDrawingBuffer: true});

        renderer.setSize(dom.width, dom.height);
        renderer.setClearColor("#ffffff");
        renderer.autoClear = false;

        window.scene = scene = new THREE.Scene();

        camera = new THREE.CombinedCamera(dom.width / 2, dom.height / 2, 45, 0.1, 50000, -500, 50000);
        // THREE.CombinedCamera = function ( width, height, fov, near, far, orthoNear, orthoFar)

        // camera.setZoom(400);
        // camera.toOrthographic();

        if(mode === 'wid') EnableAxesMinimap('#DOMaxesHelper');

        camera.position.set(6, 6, 6); // (2ft,2ft,2ft), zoomscale: pixles/ft
        //camera.rotation.y = Math.PI/2;
        scene.add(camera);

        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableRotate = false;
        controls.enablePan = false;
        controls.enableKeys = false;

        controls.addEventListener('change', function (e) {
            scene.traverse(function (child) {
                if (child instanceof THREE.Sprite || THREE.Sphere) {
                    adaptFigureScale(child, camera);
                }
            });

            onCameraUpdate && onCameraUpdate(camera.position);

        });

        light2 = new THREE.HemisphereLight(0xffffff, 0xffffff, 0.2);
        light2.name = "Hemisphere";
        light2.visible = true;
        light2.position.set(0, 1, 0);
        scene.add(light2);

        // light3 = new THREE.DirectionalLight("#ffffff", 0.5);
        // light3.position.set(1.0, 1.0, 1.0).normalize(); // may need lights at other corners
        // scene.add(light);

        light = new THREE.DirectionalLight("#ffffff", 0.25);
        light.position.set(1.0, 1.0, 1.0).normalize(); // may need lights at other corners
        camera.add(light);

        var light = new THREE.AmbientLight( 0x606060 ); // soft white light
        scene.add( light );

        ais = new THREE.Mesh();
        scene.add(ais);

        gridZX = new THREE.GridHelper(12, 1); // grid line spacing is fixed to be 1/12 ft = 1 inch
        gridZX.name = 'gridZX';
        gridZX.visible = true;
        scene.add(gridZX);

        gridXY = new THREE.GridHelper(12, 1);
        gridXY.name = 'gridXY';
        gridXY.rotation.x = 90 * Math.PI / 180;
        gridXY.visible = false;
        scene.add(gridXY);

        gridYZ = new THREE.GridHelper(12, 1);
        gridYZ.name = 'gridYZ';
        gridYZ.rotation.z = 90 * Math.PI / 180;
        gridYZ.visible = false;
        scene.add(gridYZ);

        if(skyBox) {
            skyBox.visible = false;

            scene.add( skyBox );
        }

        if(Terrain) {
            terrain = new Terrain("../../../assets/img/textures/grass/" + 'grass', false);
            scene.add( terrain.TerrainPlatter );
        }

        // Axes();
        drawAllAxes();
        Event(mode);

        dom.appendChild(renderer.domElement);
    }

    function ChangeGridSettings(settings) {
        var size = settings.size;
        var grid_size = 12;
        var step = 1;

        switch (size) {
            case '1in':
                step = 1/12;
                break;
            case '3in':
                step = 1/4;
                break;
            case '6in':
                step = 1/2;
                break;
            case '1ft':
                step = 1;
                break;
            default:
                break;
        }

        scene.remove(scene.getObjectByName('gridZX'));
        scene.remove(scene.getObjectByName('gridYZ'));
        scene.remove(scene.getObjectByName('gridXY'));

        gridZX = new THREE.GridHelper(grid_size, step);
        gridZX.name = 'gridZX';
        gridZX.visible = viewSettings.planeZX;
        scene.add(gridZX);

        gridXY = new THREE.GridHelper(grid_size, step);
        gridXY.name = 'gridXY';
        gridXY.rotation.x = 90 * Math.PI / 180;
        gridXY.visible = viewSettings.planeXY;
        scene.add(gridXY);

        gridYZ = new THREE.GridHelper(grid_size, step);
        gridYZ.name = 'gridYZ';
        gridYZ.rotation.z = 90 * Math.PI / 180;
        gridYZ.visible = viewSettings.planeYZ;
        scene.add(gridYZ);

        // var max = Math.abs(Math.max(box.size().x, box.size().y, box.size().z));

        // if (max < Infinity) {
        //     if (camera.inPerspectiveMode) {
        //         camera.position.y = max*2;
        //         controls.target.set(0, box.size().y / 2, 0);
        //
        //         gridZX.scale.set(max, max, max);
        //         gridXY.scale.set(max, max, max);
        //         gridYZ.scale.set(max, max, max);
        //
        //         Axises.scale.set(max, max, max);
        //     } else if (camera.inOrthographicMode) {
        //         camera.setZoom(camera.zoom / max);
        //         controls.target.set(0, 0, 0);
        //     }
        // }
    }

    function ChangeCameraPosition(nPos){
        camera.position.set(nPos.x, nPos.y, nPos.z);
    }

    function GetCurentScreenshotURL() {
        return renderer.domElement.toDataURL("image/png");
    }

    function ChangeViewSettingsWLSC(settings) {
        viewSettings = settings;
        controls.enableRotate = settings.rotation || false;
        controls.enablePan = settings.pan || false;
    }

    function ChangeViewSettingsWID(settings) {
        viewSettings = settings;

        viewSettings.fontSize = viewSettings.fontSize || 20;

        scene.traverse(function (child) {
            if (child instanceof THREE.Sprite) {
                adaptFigureScale(child, camera);
            }
        });

        if(viewSettings.defaultAngle){
            camera.position.set(-5,8,6);

            // for sync w/ $scope.cameraSettings
            return {x:-5, y:8, z:6};
        }

        if (viewSettings.frameScale){
            AdjustFrameScale(Axises, viewSettings.frameScale);

            scene.traverse(function (child) {
                if (child.type === 'axises_help') {
                    AdjustFrameScale(child, viewSettings.frameScale);
                }
            });
        }

        if(viewSettings.sky_box === 'skyboxColorPicker'){
            let materialArray = [];
            for (let i = 0; i < 6; i++) {
                materialArray.push(new THREE.MeshBasicMaterial({
                    side: THREE.BackSide,
                    color: Number.parseInt(viewSettings.skyboxColor.replace("#", "0x"), 16)
                }));
            }

            skyBox.material = new THREE.MeshFaceMaterial(materialArray);
            skyBox.visible = true;
        }

        if(viewSettings.sky_box && skyBox && viewSettings.sky_box !== 'skyboxColorPicker') {
            var materialArray = [];
            var imagePrefix = "../../../assets/img/textures/" + viewSettings.sky_box + "/sky_";
            var directions = ["posX", "negX", "posY", "negY", "posZ", "negZ"];
            var imageSuffix = ".jpg";

            for (var i = 0; i < 6; i++) {
                materialArray.push(new THREE.MeshBasicMaterial({
                    map: THREE.ImageUtils.loadTexture(imagePrefix + directions[i] + imageSuffix),
                    side: THREE.BackSide
                }));
            }

            skyBox.material = new THREE.MeshFaceMaterial(materialArray);
            skyBox.visible = true;
        } else {
            if(!viewSettings.sky_box && skyBox) {
                skyBox.visible = false;
            }
        }

        if(viewSettings.terrain === 'terrainColorPicker'){
            terrain.TerrainPlatter.material = new THREE.MeshPhongMaterial({
                color: Number.parseInt(viewSettings.terrainColor.replace("#", "0x"), 16),
                shading: THREE.SmoothShading
            });
            terrain.TerrainPlatter.visible = true;
        }

        if(viewSettings.terrain && viewSettings.terrain !== 'terrainColorPicker') {
            var gt = THREE.ImageUtils.loadTexture("../../../assets/img/textures/" + viewSettings.terrain);

            terrain.TerrainPlatter.material = new THREE.MeshPhongMaterial({map: gt, shading: THREE.SmoothShading});
            terrain.TerrainPlatter.material.map.repeat.set(64, 64);
            terrain.TerrainPlatter.material.map.wrapS = terrain.TerrainPlatter.material.map.wrapT = THREE.RepeatWrapping;
            terrain.TerrainPlatter.visible = true;
        } else {
            if(!viewSettings.terrain){
                terrain.TerrainPlatter.visible = false;
            }
        }

        scene.traverse(function (child) {
            if (child instanceof THREE.EdgesHelper) {
                child.visible = viewSettings.edges && viewSettings.members;
            }
        });

        controls.enableRotate = true;
        controls.enablePan = true;
        // controls.reset();

        scene.getObjectByName('gridZX').visible = settings.planeZX;
        scene.getObjectByName('gridYZ').visible = settings.planeYZ;
        scene.getObjectByName('gridXY').visible = settings.planeXY;

        scene.traverse(function (child) {
            if (child instanceof THREE.Sprite) {
                if (child.type == 'nodeLabel') {
                    child.visible = settings.nodesName;
                }

                if (child.type == 'memberLabel') {
                    child.visible = settings.wireframeName;
                }

                if(child.type === 'equipmentLabel'){
                    child.visible = settings.showLabelsEqpt;
                }
            }

            if (child instanceof THREE.Mesh) {
                if (child.type == 'node') {
                    child.visible = settings.nodes;
                }

                if (child.type == 'member') {
                    child.visible = settings.members;
                }

                if (child.type == 'equipment') {
                    child.visible = settings.objects;
                }
            }

            if (child instanceof THREE.Line) {
                if (child.type == 'line') {
                    child.visible = settings.wireframe;
                }
            }
        });
    }

    function ChangeViewSettingsDPOSS(settings) {
        viewSettings = settings;

        viewSettings.planeZX = viewSettings.grid.zx;
        viewSettings.planeXY = viewSettings.grid.xy;
        viewSettings.planeYZ = viewSettings.grid.yz;

        ais.traverse(function (child) {
            if (child instanceof THREE.EdgesHelper) {
                child.visible = settings.wireframe;
            }
        });

        // if (lastCameraType == settings.camera.type) {
        //     return false;
        // }

        lastCameraType = settings.camera.type;

        if (settings.camera.type == '2D') {
            document.getElementById("2d").style.display = "block";

            ais.visible = false;

            controls.enableRotate = false;
            controls.enablePan = false;
            controls.reset();

            // camera.setZoom(400);
            camera.toOrthographic();

            scene.getObjectByName('gridZX').visible = false;
            scene.getObjectByName('gridYZ').visible = false;
            scene.getObjectByName('gridXY').visible = false;

            //camera.position.set(2*zoomscale, 0*zoomscale, 0*zoomscale);

        } else if (settings.camera.type == '3D') {
            document.getElementById("2d").style.display = "none";

            ais.visible = true;

            controls.enableRotate = true;
            controls.enablePan = true;
            // controls.reset();

            // camera.setZoom(1);
            camera.toPerspective();

            scene.getObjectByName('gridZX').visible = viewSettings.grid.zx;
            scene.getObjectByName('gridYZ').visible = viewSettings.grid.yz;
            scene.getObjectByName('gridXY').visible = viewSettings.grid.xy;

            //camera.position.set(3, 3, 3);
            //camera.position.set(2*zoomscale, 0*zoomscale, 0*zoomscale);
        }

        AspectDPoSS();
    }

    function Axes(params) {
        params = params || {};

        var axisRadius = params.radius !== undefined ? params.radius : 0.005; // 0.02
        var axisLength = params.length !== undefined ? params.length : 2; // 2
        var axisTess = params.tess !== undefined ? params.tess : 12;

        var axisXMaterial = new THREE.MeshBasicMaterial({color: 0xFF0000});
        var axisYMaterial = new THREE.MeshBasicMaterial({color: 0x0000FF});
        var axisZMaterial = new THREE.MeshBasicMaterial({color: 0x00FF00});

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

        Axises = new THREE.Object3D();

        Axises.add(axisX);
        Axises.add(axisY);
        Axises.add(axisZ);

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

        arrowY.position.y = axisLength - 1 + axisRadius * 4 / 2;

        arrowZ.rotation.z = -Math.PI / 2;
        arrowZ.rotation.y = -Math.PI / 2;
        arrowZ.position.z = axisLength - 1 + axisRadius * 4 / 2;

        scene.add(Axises);
        Axises.rotation.x = Math.PI/2;

        // scene.add(arrowX);
        // scene.add(arrowY);
        // scene.add(arrowZ);
    }

    function drawAllAxes(params) {
        params = params || {};
        var axisRadius = params.axisRadius !== undefined ? params.axisRadius : 0.02;
        var axisLength = params.axisLength !== undefined ? params.axisLength : 2;
        var axisTess = params.axisTess !== undefined ? params.axisTess : 24;

        var axisXMaterial = new THREE.MeshLambertMaterial({ color: 0xFF0000 });
        var axisYMaterial = new THREE.MeshLambertMaterial({ color: 0x00FF00 });
        var axisZMaterial = new THREE.MeshLambertMaterial({ color: 0x0000FF });
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
        axisX.rotation.z = - Math.PI / 2;
        axisX.position.x = axisLength/2-1;

        axisY.position.y = axisLength/2-1;

        axisZ.rotation.y = - Math.PI / 2;
        axisZ.rotation.z = - Math.PI / 2;
        axisZ.position.z = axisLength/2-1;

        // scene.add( axisX );
        // scene.add( axisY );
        // scene.add( axisZ );

        var arrowX = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 2*axisRadius, 8*axisRadius, axisTess, 1, true),
            axisXMaterial
        );
        var arrowY = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 2*axisRadius, 8*axisRadius, axisTess, 1, true),
            axisYMaterial
        );
        var arrowZ = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 2*axisRadius, 8*axisRadius, axisTess, 1, true),
            axisZMaterial
        );
        arrowX.rotation.z = - Math.PI / 2;
        arrowX.position.x = axisLength - 1 + axisRadius*4/2;

        arrowY.position.y = axisLength - 1 + axisRadius*4/2;

        arrowZ.rotation.z = - Math.PI / 2;
        arrowZ.rotation.y = - Math.PI / 2;
        arrowZ.position.z = axisLength - 1 + axisRadius*4/2;

        // scene.add( arrowX );
        // scene.add( arrowY );
        // scene.add( arrowZ );

        Axises = new THREE.Object3D();

        Axises.add(axisX);
        Axises.add(axisY);
        Axises.add(axisZ);

        Axises.add(arrowX);
        Axises.add(arrowY);
        Axises.add(arrowZ);

        if(params.needsLabels){
            const xLabel = addLabel('x', {fontSize: 24, position: {'x': 1, 'y': 0, 'z': 0}});
            Axises.add(xLabel);
            const yLabel = addLabel('y', {fontSize: 24, position: {'x': 0, 'y': 1, 'z': 0}});
            Axises.add(yLabel);
            const zLabel = addLabel('z', {fontSize: 24, position: {'x': 0, 'y': 0, 'z': 1}});
            Axises.add(zLabel);
        }

        if (params.axesHelperMinimap) {
            axesHelperContainer.add(Axises);
            axesHelper = Axises;
            axesHelper.scale.set(0.3, 0.3, 0.3);
        } else scene.add(Axises);
    }

    function Render() {
        Update();
        Resize();

        controls.update();

        renderer.clear();
        renderer.render(scene, camera);
        if(rendererAxesHelper) {
            rendererAxesHelper.render(axesHelperScene, axesHelperCamera);
            let nextPosition = controls.target.clone().sub( camera.position );
            axesHelperCamera.position.copy(nextPosition).normalize().negate();
            axesHelperCamera.lookAt(new THREE.Vector3(0, 0, 0));
        }
        //renderer.render(sceneHUD, cameraHUD);

        requestAnimationFrame(Render);
    }

    function Update() {
        // light.position.copy(camera.position).normalize();
        /*if (lastZoom != camera.zoom) {
         var zoom = 1;

         console.log(camera.zoom / 400);

         hudBitmap.clearRect(0, 0, dom.width, dom.height);

         hudBitmap.beginPath();
         hudBitmap.arc(-25 * zoom, 28 * zoom, 5, 0, 2 * Math.PI, false);
         hudBitmap.fillStyle = "red";
         hudBitmap.fill();

         hudBitmap.beginPath();
         hudBitmap.arc(-25 * zoom, -65 * zoom, 5, 0, 2 * Math.PI, false);
         hudBitmap.fillStyle = "red";
         hudBitmap.fill();

         hudBitmap.beginPath();
         hudBitmap.arc(65 * zoom, 28 * zoom, 5, 0, 2 * Math.PI, false);
         hudBitmap.fillStyle = "red";
         hudBitmap.fill();

         lastZoom = camera.zoom;

         console.log(zoom);
         }*/
    }

    function Event(mode) {
        if(mode == 'dposs') return false;

        dom.onclick = onMouseDown;
        dom.oncontextmenu = onRightClick;

        function onRightClick(event) {

            if (event.button != 2) {
                return false;
            }

            mouse.x = (event.offsetX / dom.width) * 2 - 1;
            mouse.y = -(event.offsetY / dom.height) * 2 + 1;
            mouse.unproject( camera );

            raycaster.set(camera.position, mouse.sub( camera.position ).normalize());

            let intersects = raycaster.intersectObjects(ais.children, true);

            let int = null;

            if (intersects.length > 0) {

                for(let i = 0; i < intersects.length; i++) {
                    if(intersects[i].object.type === 'Mesh' || intersects[i].object.type === 'node') {
                        int = intersects[i].object;
                        break;
                    }
                }

            }

            if (typeof onRigthClickSelect === "function") {
                onRigthClickSelect.call({}, int, event);
            }

            event.preventDefault();

        }

        function onMouseDown(event) {
            if (event.button != 0) {
                return false;
            }

            mouse.x = (event.offsetX / dom.width) * 2 - 1;
            mouse.y = -(event.offsetY / dom.height) * 2 + 1;
            mouse.unproject( camera );

            raycaster.set(camera.position, mouse.sub( camera.position ).normalize());
            var intersects = raycaster.intersectObjects(ais.children, true);

            if (intersects.length > 0) {
                if (INTERSECTED != intersects[0].object) {

                    if(INTERSECTED && INTERSECTED.parent && INTERSECTED.type != 'node') {
                        INTERSECTED.parent.children.forEach(function(child) {
                            if (child && child.material && child.type == 'Mesh') {
                                child.material.color.setHex(child.currentHex);
                            }
                        });

                        removeAxis(INTERSECTED.parent);
                    } else {
                        if (INTERSECTED && INTERSECTED.material) {
                            INTERSECTED.material.color.setHex(INTERSECTED.currentHex);
                            removeAxis(INTERSECTED);
                        }
                    }

                    var found = false;

                    for(var i = 0; i < intersects.length; i++) {
                        if(intersects[i].object.type == 'Mesh' || intersects[i].object.type == 'node') {
                            intersects[i].object.ctrlKey = event.ctrlKey || false;
                            INTERSECTED = intersects[i].object;
                            found = true;
                            break;
                        }
                    }

                    if(!found) INTERSECTED = null;

                    if(INTERSECTED && INTERSECTED.parent && INTERSECTED.type != 'node') {
                        INTERSECTED.parent.children.forEach(function(child) {
                            if (child && child.material && child.type == 'Mesh') {
                                child.currentHex = child.material.color.getHex();
                                child.material.color.setHex(0xff0000);
                            }
                        });

                        // var axisHelper = new THREE.AxisHelper(3);
                        // INTERSECTED.parent.add( axisHelper );
                        addAxis(INTERSECTED.parent);

                    } else {
                        if (INTERSECTED && INTERSECTED.material) {
                            INTERSECTED.currentHex = INTERSECTED.material.color.getHex();
                            INTERSECTED.material.color.setHex(0xff0000);

                            if(INTERSECTED.type != 'node') {
                                // var axisHelper = new THREE.AxisHelper(3);
                                // INTERSECTED.add( axisHelper );
                                addAxis(INTERSECTED);
                            }
                        }
                    }

                }
            } else {
                if(INTERSECTED && INTERSECTED.parent && INTERSECTED.type != 'node') {
                    INTERSECTED.parent.children.forEach(function(child) {
                        if (child && child.material && child.type == 'Mesh') {
                            child.material.color.setHex(child.currentHex);
                        }
                        removeAxis(INTERSECTED.parent);
                    });

                    LAST = INTERSECTED;
                } else {
                    if (INTERSECTED && INTERSECTED.material) {
                        INTERSECTED.material.color.setHex(INTERSECTED.currentHex);
                        LAST = INTERSECTED;
                        removeAxis(INTERSECTED);
                    }
                }

                INTERSECTED = null;
            }

            if (typeof onSelected == "function") {
                // if (LAST != null) {
                //     onSelected.call({}, null);
                // } else {
                    onSelected.call({}, INTERSECTED);
                // }
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

            camera.setSize(dom.width, dom.height);
            camera.updateProjectionMatrix();

            renderer.setSize(dom.width, dom.height);

            if (!window.drawAisc) {
                Grid();
            }
        }
    }

    function Run(selector, mode) {
        element = selector;
        dom = document.querySelector(selector);

        dom.width = dom.innerWidth || dom.offsetWidth;
        dom.height = dom.innerHeight || dom.offsetHeight;

        Init(mode);
        Grid();
        Render();
        Event(mode);
    }

    function Grid() {
        // var custom = document.getElementById("webgl");
        var custom = document.getElementById("2d");
        // var canvas = custom.querySelector("canvas");

        // var canvas = null;

        // if (canvas == null) {
            var canvas = document.createElement("canvas");
        // }

        var context = canvas.getContext("2d");
        var zoomscale = 1000;

        canvas.width  = dom.width;
        canvas.height = dom.height;

        context.font = "18px Times";
        context.translate(canvas.width / 2, canvas.height / 2);
        context.scale(1.0, 1.0);

        context.clearRect(0, 0, canvas.width, canvas.height);

        context.lineWidth = 1;

        context.beginPath();
        context.moveTo(-canvas.width / 2, 0);
        context.lineTo(+canvas.width / 2, 0);
        context.strokeStyle = "red";
        context.stroke();

        context.beginPath();
        context.moveTo(0, -canvas.height / 2);
        context.lineTo(0, +canvas.height / 2);
        context.strokeStyle = "blue";
        context.stroke();

        context.lineWidth = 0;
        context.strokeStyle = "#DCDCDC";

        var Nbr_gridlines = Math.ceil( canvas.width / 2 / (1 / 12 * zoomscale) );

        for (var iline = 0; iline < Nbr_gridlines; iline++) {
            context.beginPath();
            context.moveTo(-canvas.width / 2, iline * 1 / 12 * zoomscale);
            context.lineTo(+canvas.width / 2, iline * 1 / 12 * zoomscale);

            context.beginPath();
            context.moveTo(iline * 1 / 12 * zoomscale, -canvas.height / 2);
            context.lineTo(iline * 1 / 12 * zoomscale, +canvas.height / 2);

            if(iline !=0){
                context.moveTo(-canvas.width / 2, -iline * 1/ 12 * zoomscale);
                context.lineTo(+canvas.width / 2, -iline * 1/ 12 * zoomscale);
                context.stroke();

                context.moveTo(-canvas.width / 2, +iline * 1 / 12 * zoomscale);
                context.lineTo(+canvas.width / 2, +iline * 1 / 12 * zoomscale);
                context.stroke();

                context.moveTo(-iline * 1 / 12 * zoomscale, -canvas.height / 2);
                context.lineTo(-iline * 1 / 12 * zoomscale, +canvas.height / 2);
                context.stroke();

                context.moveTo(+iline * 1 / 12 * zoomscale, -canvas.height / 2);
                context.lineTo(+iline * 1 / 12 * zoomscale, +canvas.height / 2);
                context.stroke();
            }
        }

        while (custom.hasChildNodes()) {
            custom.removeChild(custom.lastChild);
        }

        custom.appendChild(canvas);
    }

    function Draw(objects, state, type, lc_data, shrink, equipments, dc, sectionsInfo) {
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
                if (child instanceof THREE.Mesh  || child instanceof THREE.Object3D) {
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
            ais.position.set(0, 0, 0);
            ais.rotation.set(0, 0, 0);

            switch(type) {
                case 'nodes':
                    drawNodes(objects, ais, "redraw");
                    break;
                case 'cuboid':
                    drawCuboid(objects, ais, "redraw");
                    break;
                case 'cylinder':
                    drawCylinder(objects, ais, "redraw");
                    break;
                case 'sphere':
                    drawSphere(objects, ais, "redraw");
                    break;

                case 'flat_panel':
                    drawFlatPanel(objects, ais, "redraw");
                    break;
                case 'conical_dish_w_shroud':
                    drawConicalDishShroud(objects, ais, "redraw");
                    break;
                case 'cylindrical_dish_w_shroud':
                    drawCylinderDishShroud(objects, ais, "redraw");
                    break;
                case 'dish_w_radome':
                    drawDishRadom(objects, ais, "redraw");
                    break;
                case 'parabolic_grid_dish':
                    drawParabolicGridDish(objects, ais, "redraw");
                    break;

                case 'wid_objects':
                    drawObjectsWID(objects, ais, "redraw", shrink, equipments, dc, sectionsInfo);
                    break;

                case 'wl_sc_objects':
                    console.log('will draw some object here!');
                    // TODO: drawObjectsWLSC();
                    break;

                case 'custom_object':
                    drawCustomFile(objects, ais, "redraw");
                    break;
                default:
                    drawObjects(objects, ais, "redraw", sectionsInfo);
                    break;
            }
        }
        Aspect();

        return ais;
    }

    function drawObjectsWID(objects, parent, action, shrink, equipments, dc, sectionsInfo) {
        if (action == "redraw") {
            removeByType(parent, 'line');
            removeByType(parent, 'member');
            removeByType(parent, 'memberLabel');
            removeByType(parent, 'equipmentLabel');
        }

        var arrToRemove = [];
        scene.traverse(function (child) {
            if (child instanceof THREE.EdgesHelper) {
                arrToRemove.push(child);
            }
        });

        arrToRemove.forEach(function(child){
            scene.remove(child);
        });

        // console.log(objects,equipments);

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
            var rot_x2stdy = item.other.y2 * (Math.PI/180);
            
            var object = drawAISCmember('3D', 'byNodes', app_p1, app_p2, app_p3, 'V141', item.shape, "AISC_Manual", 'US_Customary', item.size1, item.size2, material, rot_x2stdy, 0.0, 'wid', shrink, '', sectionsInfo);

            if(object.children[0]) {
                object.children.forEach(function (children) {
                    children.item_no = item.id;
                });
            }

            if (approach == "dirLth") {
                object.position.set(item.other.x1 || 0, item.other.y1 || 0, item.other.z1 || 0);
                object.rotation.set(item.other.x2 || 0, item.other.y2 || 0, item.other.z2 || 0);
            }

            object.type = 'member';

            object.visible = viewSettings.members;

            if(equipments) {
                equipments.forEach(function(eqpt) {
                    if(item.name == eqpt.lc.mbr_name) {
                        if(eqpt.eq.geometryType == 'structure' && eqpt.details) {
                            drawNodes(eqpt.details.nodes, object, "add");
                            drawObjectsWID(eqpt.details.objects, object, "redraw", shrink);
                        } else if(eqpt.eq.geometryType == 'single_object') {
                            if(eqpt.eq.geometryShapeType == 'Cuboid') {
                                drawCuboid({
                                    dimensions: [eqpt.eq.d1, eqpt.eq.d2, eqpt.eq.d3],
                                    texture: {
                                        type: eqpt.eq.texture_type,
                                        color: eqpt.eq.color,
                                        name: eqpt.eq.texture
                                    },
                                    product: {
                                        id: eqpt.eq.id
                                    }
                                }, object, "add", eqpt.lc, eqpt.eq.model);
                            } else if(eqpt.eq.geometryShapeType == 'FlatPanel') {
                                drawFlatPanel({
                                    dimensions: [eqpt.eq.d1, eqpt.eq.d2, eqpt.eq.d3, eqpt.eq.d4],
                                    texture: {
                                        type: eqpt.eq.texture_type,
                                        color: eqpt.eq.color,
                                        name: eqpt.eq.texture
                                    },
                                    product: {
                                        id: eqpt.eq.id
                                    }
                                }, object, "add", eqpt.lc, eqpt.eq.model);

                            } else if(eqpt.eq.geometryShapeType == 'Cylinder') {
                                drawCylinder({
                                    dimensions: [eqpt.eq.d1, eqpt.eq.d2],
                                    texture: {
                                        type: eqpt.eq.texture_type,
                                        color: eqpt.eq.color,
                                        name: eqpt.eq.texture
                                    },
                                    product: {
                                        id: eqpt.eq.id
                                    }
                                }, object, "add", eqpt.lc, eqpt.eq.model);
                            } else if(eqpt.eq.geometryShapeType == 'Sphere') {
                                drawSphere({
                                    dimensions: [eqpt.eq.d1],
                                    texture: {
                                        type: eqpt.eq.texture_type,
                                        color: eqpt.eq.color,
                                        name: eqpt.eq.texture
                                    },
                                    product: {
                                        id: eqpt.eq.id
                                    }
                                }, object, "add", eqpt.lc, eqpt.eq.model);

                            } else if(eqpt.eq.geometryShapeType == 'ConicalDishShroud') {
                                drawConicalDishShroud({
                                    dimensions: [eqpt.eq.d1, eqpt.eq.d2, eqpt.eq.d3, eqpt.eq.d4],
                                    texture: {
                                        type: eqpt.eq.texture_type,
                                        color: eqpt.eq.color,
                                        name: eqpt.eq.texture
                                    },
                                    product: {
                                        id: eqpt.eq.id
                                    }
                                }, object, "add", eqpt.lc, eqpt.eq.model);

                            } else if(eqpt.eq.geometryShapeType == 'CylinderDishShroud') {
                                drawCylinderDishShroud({
                                    dimensions: [eqpt.eq.d1, eqpt.eq.d2, eqpt.eq.d3, eqpt.eq.d4],
                                    texture: {
                                        type: eqpt.eq.texture_type,
                                        color: eqpt.eq.color,
                                        name: eqpt.eq.texture
                                    },
                                    product: {
                                        id: eqpt.eq.id
                                    }
                                }, object, "add", eqpt.lc);     

                            } else if(eqpt.eq.geometryShapeType == 'DishRadom') {
                                drawDishRadom({
                                    dimensions: [eqpt.eq.d1, eqpt.eq.d2, eqpt.eq.d3, eqpt.eq.d4],
                                    texture: {
                                        type: eqpt.eq.texture_type,
                                        color: eqpt.eq.color,
                                        name: eqpt.eq.texture
                                    },
                                    product: {
                                        id: eqpt.eq.id
                                    }
                                }, object, "add", eqpt.lc, eqpt.eq.model);

                            } else if(eqpt.eq.geometryShapeType == 'ParabolicGridDish') {
                                drawParabolicGridDish({
                                    dimensions: [eqpt.eq.d1, eqpt.eq.d2, eqpt.eq.d3, eqpt.eq.d4],
                                    texture: {
                                        type: eqpt.eq.texture_type,
                                        color: eqpt.eq.color,
                                        name: eqpt.eq.texture
                                    },
                                    product: {
                                        id: eqpt.eq.id
                                    }
                                }, object, "add", eqpt.lc, eqpt.eq.model);
                            }
                        }
                    }
                });
            }

            //axises changed oldZ = newY, oldY = newZ
            object.rotateY(rot_x2stdy);

            parent.add(object);

            if (item.nodes && item.nodes.NodeE && item.nodes.NodeS) {
                var geometry = new THREE.Geometry();

                geometry.vertices.push(parent.getObjectByName("node" + item.nodes.NodeE).position);
                geometry.vertices.push(parent.getObjectByName("node" + item.nodes.NodeS).position);

                var line = new THREE.Line(geometry, new THREE.LineBasicMaterial({color: 0x0051FF}));
                line.type = 'line';
                line.visible = viewSettings.wireframe;

                parent.add(line);
            }

            if (item.nodes && item.nodes.NodeE && item.nodes.NodeS) {
                var nodeSPosition = parent.getObjectByName("node" + item.nodes.NodeS).position;
                var nodeEPosition = parent.getObjectByName("node" + item.nodes.NodeE).position;

                var nodeDirection = (nodeSPosition.x <= nodeEPosition.x || nodeSPosition.y <= nodeEPosition.y || nodeSPosition.z <= nodeEPosition.z);

                // var nodeLabel = GetStaticLabel(item.name, 14, nodeDirection);

                var nodeLabel = makeTextSprite(item.name, {
                    fontsize: 32
                });

                SetAlongLine(nodeLabel, [
                    new THREE.Vector3(parseFloat(nodeSPosition.x), parseFloat(nodeSPosition.y), parseFloat(nodeSPosition.z)),
                    new THREE.Vector3(parseFloat(nodeEPosition.x), parseFloat(nodeEPosition.y), parseFloat(nodeEPosition.z))
                ], 0.5);

                nodeLabel.type = 'memberLabel';
                nodeLabel.visible = viewSettings.wireframeName;
                adaptFigureScale(nodeLabel, camera);
                parent.add(nodeLabel);
            }

            if(dc) {
                parent.position.set(dc.dx, dc.dy, dc.dz);
                parent.rotation.set(dc.rotx * (Math.PI/180), dc.roty * (Math.PI/180), dc.rotz * (Math.PI/180));
            }

            object.traverse(function (child) {

                if (child instanceof THREE.Mesh) {

                    var wfh = new THREE.EdgesHelper(child, "#ffffff");

                    wfh.material.opacity = 0.9;
                    wfh.material.transparent = true;

                    wfh.visible = viewSettings.edges && viewSettings.members;

                    scene.add(wfh);
                }
            });

        });
    }

    function drawObjects(section, parent, action, sectionsInfo) {
        if (action == "redraw") {
            removeByType(parent, 'line');
            removeByType(parent, 'member');
            removeByType(scene, 'memberLabel');
            removeByType(parent, 'equipmentLabel');
        }

        var arrToRemove = [];
        parent.traverse(function (child) {
            if (child instanceof THREE.EdgesHelper) {
                arrToRemove.push(child);
            }
        });

        arrToRemove.forEach(function(child){
            parent.remove(child);
        });

        if (!section) {
            Grid();
            return false;
        }

        section.nodes = {};
        section.nodes.NodeE = [0, 0, 0];
        section.nodes.NodeS = [0, 1, 0];

        var app_p1 = section.nodes.NodeS;
        var app_p2 = section.nodes.NodeE;
        var app_p3 = '';

        var material = "metal";
        var rot_x2stdy = 0;

        // var object = drawAISCmember("byNodes", app_p1, app_p2, app_p3, section.shape, section.size, material, rot_x2stdy);

        var dbSRC    = section.src;
        var Type     = section.shape;
        var SizeType = section.name;
        var SizeUnit = section.unit;
        var Size1    = section.Size1;
        var Size2    = section.Size2;
        var GridSize2D = section.grid_size2d;
        
        var XD = '23D'; // 2D to draw 2D only, 3D to draw 3D, '23D' to draw both 2D and 3D.
        var shrk_pct = 0.0; // no shrinkage
        var object = drawAISCmember(XD, "byNodes", app_p1, app_p2, app_p3, dbSRC, Type, SizeType, SizeUnit, Size1, Size2, material, rot_x2stdy, shrk_pct, 'dposs', 0, GridSize2D, sectionsInfo);

        // console.log('object.zoomscale', object.zoomscale);

        //camera.position.set(2*object.zoomscale, 2*object.zoomscale, 2*object.zoomscale);

        // setTimeout(function(){console.log(camera.position)}, 1000);

        object.type = 'member';
        object.section = section.id;
        object.visible = true;

        object.traverse(function (child) {

            if (child instanceof THREE.Mesh) {
                child.material.polygonOffset = true;
                child.material.polygonOffsetFactor = 1;
                child.material.polygonOffsetUnits = 1;
                child.material.side = THREE.DoubleSide;


                let wfh = new THREE.EdgesHelper(child, "#ffffff");

                wfh.material.opacity = 0.9;
                wfh.material.transparent = true;
                wfh.visible = viewSettings.wireframe;

                parent.add(wfh);
            }

        });

        parent.add(object);
    }

    function drawNodes(nodes, parent, action) {
        // console.log(nodes, parent, action);
        if (action == "redraw") {
            removeByType(parent, 'node');
            removeByType(parent, 'nodeLabel');
            removeByType(parent, 'equipment');
            removeByType(parent, 'customObject');
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
                adaptFigureScale(sphere, camera);

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
                    spritey.type = 'nodeLabel';
                    spritey.visible = viewSettings.nodesName;
                    adaptFigureScale(spritey, camera);
                    parent.add(spritey);
                }
                parent.add(sphere);
            });
        }
    }

    function drawCustomFile(data, parent, action) {
        if (action == "redraw") {
            clearScene();
            // removeByType(parent, 'customObject');
        }

        var loader = new THREE.OBJLoader();
        var mtlLoader = new THREE.MTLLoader('documents/product/' + data.id + '/3D/');

        var material = false;

        var object_name = data.file.split('.');

        mtlLoader.load(
            'documents/product/' + data.id + '/3D/' + object_name[0] + '.mtl',
            function (materials) {
                materials.preload();

                for (let key in materials.materials) {
                    material = materials.materials[key];

                    material.shading = THREE.SmoothShading;
                    material.side = THREE.DoubleSide;
                }


                if(data.file.indexOf('.obj') != -1) {
                    loader.load(

                        'documents/product/' + data.id + '/3D/' + data.file,

                        function ( object ) {

                            // console.log(object);

                            if(material) {
                                object.children[0].material = material;
                            }

                            object.type = 'customObject';

                            let box = new THREE.Box3().setFromObject(object);
                            let size = box.size();
                            let max = size.x;

                            if(size.y > max) {
                                max = size.y;
                            }

                            if(size.z > max) {
                                max = size.z;
                            }

                            let scale = 4 / max;

                            object.scale.set(scale, scale, scale);

                            parent.add( object );
                        }
                    );
                }

            }
        );
        
    }

    function clearScene(parent) {
        removeByType(parent, 'equipment');
        removeByType(parent, 'node');
        removeByType(parent, 'nodeLabel');
        removeByType(parent, 'line');
        removeByType(parent, 'member');
        removeByType(parent, 'memberLabel');
        removeByType(parent, 'equipmentLabel');
        removeByType(parent, 'customObject');

        let arrToRemove = [];
        scene.traverse(function (child) {
            if (child instanceof THREE.EdgesHelper) {
                arrToRemove.push(child);
            }
        });

        arrToRemove.forEach(function(child){
            scene.remove(child);
        });
    }

    function createPhongMaterial(options){
        return new THREE.MeshPhongMaterial({
            color: options.color || '#2222ff',
            specular: 0xcccccc,
            shininess: 20,
            emissive: 0x0,
            shading: THREE.SmoothShading,
            size: THREE.DoubleSide
       });
    }

    function drawFlatPanel(objects, parent, action, lc_data, label) {
        if (action == "redraw") {
            clearScene(parent);
        }

        let lineGeometry = new THREE.Geometry();
        let vertArray = lineGeometry.vertices;


        let d1 = parseFloat(objects.dimensions[0] / 12);
        let d2 = parseFloat(objects.dimensions[1] / 12);
        let d3 = parseFloat(objects.dimensions[2] / 12);
        let d4 = parseFloat(objects.dimensions[3] / 12);

        let dimensions = {
            "height": objects.dimensions[0],
            "width": objects.dimensions[1],
            "depth": objects.dimensions[2]
        };

        let sd3 = d3/2;
        let sd2 = d2/2;

        let irv = (d2 - 0.001) / 50;
        let MaxY = sd2;
        let Rat = d4 / MaxY;

        vertArray.push( new THREE.Vector3(-sd2, 0 , 0));
        vertArray.push( new THREE.Vector3(-sd2, d3 , 0));

        for(let x =- sd2; x <= sd2; x += irv){
            let y = Math.sqrt(sd2 * sd2 - x * x);
            vertArray.push( new THREE.Vector3(x, y * Rat + sd3*2 , 0));
        }

        vertArray.push( new THREE.Vector3(sd2, 0 , 0));
        vertArray.push( new THREE.Vector3(-sd2, 0 , 0));


        //let material = new THREE.MeshPhongMaterial( { color: objects.texture.color || '#2222ff' } );
        let material = createPhongMaterial({ color: objects.texture.color });
        
        let shape = new THREE.Shape(vertArray);

        let extrudeSettings = {
            steps: 1,
            amount: d1,
            bevelEnabled: false,
            bevelThickness: 0,
            bevelSize: 0,
            bevelSegments: 0
        };

        let geometry = new THREE.ExtrudeGeometry( shape, extrudeSettings );

        let group = new THREE.Mesh();

        let obj = new THREE.Mesh( geometry, material );

        obj.position.set(0, -d1/2, 0);
        obj.rotation.set(-Math.PI/2, 0, -Math.PI/2);


        obj.faces = {
            px:{ dir:[+1, 0,  0], area: d1*d2 },
            nx:{ dir:[-1, 0,  0], area: d1*d2 },
            pz:{ dir:[ 0, 0, +1], area: d1*d3 },
            nz:{ dir:[ 0, 0, -1], area: d1*d3 }                                    
        };

        let eqptLabel = makeTextSprite(label, {
            fontsize: 32
        });

        adaptSprite(eqptLabel, dimensions);

        eqptLabel.type = 'equipmentLabel';
        eqptLabel.visible = false;
        adaptFigureScale(eqptLabel, camera);
        group.add(eqptLabel);

        group.type = 'equipment';
        group.eqpt_id = objects.product.id;

        group.add(obj);

        if(lc_data) {
            group.lc_id = lc_data.id;

            let newD = rotateAndDeposeNodes(lc_data);

            lc_data.tdx = newD.dx;
            lc_data.tdy = newD.dy;
            lc_data.tdz = newD.dz;

            group.position.set(lc_data.tdx ? parseFloat(lc_data.tdx) : 0, lc_data.tdy ? parseFloat(lc_data.tdy) : 0, lc_data.tdz ? parseFloat (lc_data.tdz) : 0);
            group.rotation.set(lc_data.rotx * (Math.PI/180), -lc_data.roty * (Math.PI/180), lc_data.rotz * (Math.PI/180));
        } else {
            group.position.set(0,0,0);

        }

        createEdges(group);

        parent.add(group);
    }

    function drawCuboid(objects, parent, action, lc_data, label) {
        if (action == "redraw") {
            clearScene(parent);
        }

        var height = objects.dimensions[0] / 12;  //length
        var width = objects.dimensions[1] / 12;
        var depth = objects.dimensions[2] / 12;  //thickness

        let dimensions = {
            "height": objects.dimensions[0],
            "width": objects.dimensions[1],
            "depth": objects.dimensions[2]
        };

        var geometry = new THREE.BoxGeometry(depth, height, width);
        var material;

        if(objects.texture && objects.texture.type == 'texture') {

            material = new THREE.MeshLambertMaterial();

            material.map = THREE.ImageUtils.loadTexture('documents/product/' + objects.product.id + '/' + objects.texture.name);
            material.map.wrapS = material.map.wrapT = THREE.RepeatWrapping;

        } else {

            material = createPhongMaterial({ color: objects.texture.color || '#2222ff' });

        }

        var box = new THREE.Mesh( geometry, material );


        box.faces = {
            px:{ dir:[+1,  0,  0], area: height*width },
            nx:{ dir:[-1,  0,  0], area: height*width },
            py:{ dir:[ 0, +1,  0], area: depth*width },
            ny:{ dir:[-0, -1,  0], area: depth*width },
            pz:{ dir:[ 0,  0, +1], area: height*depth },
            nz:{ dir:[ 0,  0, -1], area: height*depth }
        };

        var group = new THREE.Mesh();
        //
        group.add(box);
        //
        group.type = 'equipment';
        group.eqpt_id = objects.product.id;

        if(lc_data) {
            group.lc_id = lc_data.id;

            var newD = rotateAndDeposeNodes(lc_data);

            lc_data.tdx = newD.dx;
            lc_data.tdy = newD.dy;
            lc_data.tdz = newD.dz;

            group.position.set(lc_data.tdx ? parseFloat(lc_data.tdx) : 0, lc_data.tdy ? parseFloat(lc_data.tdy) : 0, lc_data.tdz ? parseFloat (lc_data.tdz) : 0);
            group.rotation.set(lc_data.rotx * (Math.PI/180), -lc_data.roty * (Math.PI/180), lc_data.rotz * (Math.PI/180));
        } else {
            group.position.set(0,0,0);
        }

        createEdges(group);

        let eqptLabel = makeTextSprite(label, {
            fontsize: 32
        });

        adaptSprite(eqptLabel, dimensions);

        eqptLabel.type = 'equipmentLabel';
        eqptLabel.visible = false;
        adaptFigureScale(eqptLabel, camera);
        group.add(eqptLabel);

        parent.add(group);
    }

    function drawCylinder(objects, parent, action, lc_data, label) {
        if (action == "redraw") {
            clearScene(parent);
        }

        var height = objects.dimensions[0] / 12;
        var radius = objects.dimensions[1] / 24;

        let dimensions = {
            "height": objects.dimensions[0],
            "radius": objects.dimensions[1]
        };

        var geometry = new THREE.CylinderGeometry( radius, radius, height, 36 );
        var material;

        if(objects.texture && objects.texture.type == 'texture') {

            material = new THREE.MeshLambertMaterial();

            material.map = THREE.ImageUtils.loadTexture('documents/product/' + objects.product.id + '/' + objects.texture.name);
            material.map.wrapS = material.map.wrapT = THREE.RepeatWrapping;

        } else {

            material = createPhongMaterial({ color: objects.texture.color || '#2222ff' });

        }

        var cylinder = new THREE.Mesh( geometry, material );

        var group = new THREE.Mesh();

        group.add(cylinder);

        group.faces = {
            pxz:{ dir:[+1,  0,  0], area: height*radius },
            nxz:{ dir:[-1,  0,  0], area: height*radius },
            py:{ dir:[ 0, +1,  0], area: radius*radius/4*Math.PI },
            ny:{ dir:[ 0, -1,  0], area: radius*radius/4*Math.PI },
        };

        group.type = 'equipment';
        group.eqpt_id = objects.product.id;

        if(lc_data) {
            group.lc_id = lc_data.id;

            var newD = rotateAndDeposeNodes(lc_data);

            lc_data.tdx = newD.dx;
            lc_data.tdy = newD.dy;
            lc_data.tdz = newD.dz;

            group.position.set(lc_data.tdx ? parseFloat(lc_data.tdx) : 0, lc_data.tdy ? parseFloat(lc_data.tdy) : 0, lc_data.tdz ? parseFloat (lc_data.tdz) : 0);
            group.rotation.set(lc_data.rotx * (Math.PI/180), 0, lc_data.rotz * (Math.PI/180));
        } else {
            group.position.set(0,0,0);
            group.rotation.set(0,0,0);
        }

        createEdges(group);

        let eqptLabel = makeTextSprite(label, {
            fontsize: 32
        });

        adaptSprite(eqptLabel, dimensions);

        eqptLabel.type = 'equipmentLabel';
        eqptLabel.visible = false;
        adaptFigureScale(eqptLabel, camera);
        group.add(eqptLabel);

        parent.add( group );
    }

    function drawSphere(objects, parent, action, lc_data, label) {
        if (action == "redraw") {
            clearScene(parent);
        }

        var radius = objects.dimensions[0]/24;

        let dimensions = {
            "radius": objects.dimensions[0],
        };

        var geometry = new THREE.SphereGeometry(radius, 36, 36);
        var material;

        if(objects.texture && objects.texture.type == 'texture') {

            material = new THREE.MeshLambertMaterial();

            material.map = THREE.ImageUtils.loadTexture('documents/product/' + objects.product.id + '/' + objects.texture.name);
            material.map.wrapS = material.map.wrapT = THREE.RepeatWrapping;

        } else {

            material = createPhongMaterial({ color: objects.texture.color || '#2222ff' });

        }

        var sphere = new THREE.Mesh( geometry, material );

        var group = new THREE.Mesh();

        group.add(sphere);

        group.faces = {
            xyz:{ dir:[0,  0,  0], area: radius*radius/4*Math.PI  },
        }        

        group.type = 'equipment';
        group.eqpt_id = objects.product.id;

        if(lc_data) {
            group.lc_id = lc_data.id;

            var newD = rotateAndDeposeNodes(lc_data);

            lc_data.tdx = newD.dx;
            lc_data.tdy = newD.dy;
            lc_data.tdz = newD.dz;

            group.position.set(lc_data.tdx ? parseFloat(lc_data.tdx) : 0, lc_data.tdy ? parseFloat(lc_data.tdy) : 0, lc_data.tdz ? parseFloat (lc_data.tdz) : 0);
        } else {
            group.position.set(0,0,0);
        }

        createEdges(group);

        let eqptLabel = makeTextSprite(label, {
            fontsize: 32
        });

        adaptSprite(eqptLabel, dimensions);

        eqptLabel.type = 'equipmentLabel';
        eqptLabel.visible = false;
        adaptFigureScale(eqptLabel, camera);
        group.add(eqptLabel);

        parent.add( group );
    }

    function drawConicalDishShroud(objects, parent, action, lc_data, label) {

        if (action == "redraw") {
            clearScene(parent);
        }

        let lineGeometry = new THREE.Geometry();

        let d1 = parseFloat(objects.dimensions[0] / 12);
        let d2 = parseFloat(objects.dimensions[1] / 12);
        let d3 = parseFloat(objects.dimensions[2] / 12);
        let d4 = parseFloat(objects.dimensions[3] / 12);

        let dimensions = {
            "height": objects.dimensions[0],
            "width": objects.dimensions[1],
            "depth": objects.dimensions[2]
        };

        let sd1 = d2/2;

        let curve = new THREE.EllipseCurve(
            0,  0,            // ax, aY
            sd1, sd1,           // xRadius, yRadius
            0,  Math.PI/2,  // aStartAngle, aEndAngle
            false,            // aClockwise
            0                 // aRotation
        );

        let path = new THREE.Path( curve.getPoints( 50 ) );

        lineGeometry = path.createPointsGeometry( 50 );

        for(let i = 0; i < lineGeometry.vertices.length; i++){
            lineGeometry.vertices[i].z = lineGeometry.vertices[i].y;
            lineGeometry.vertices[i].y = lineGeometry.vertices[i].x;
            lineGeometry.vertices[i].x = 0;
        }


        lineGeometry.vertices.unshift(new THREE.Vector3(-0.01, 0.0, 0.0));

        lineGeometry.vertices.pop();

        let geometry = new THREE.LatheGeometry( lineGeometry.vertices, 48);
        let material = material = createPhongMaterial({ color: objects.texture.color || '#2222ff' });

        let obj = new THREE.Mesh( geometry, material );

        obj.position.set(d2/2, 0, 0);
        obj.rotation.set(0, -Math.PI/2, 0);

        let group = new THREE.Mesh();

        group.type = 'equipment';
        group.eqpt_id = objects.product.id;

        group.add(obj);

        if(lc_data) {
            group.lc_id = lc_data.id;

            let newD = rotateAndDeposeNodes(lc_data);

            lc_data.tdx = newD.dx;
            lc_data.tdy = newD.dy;
            lc_data.tdz = newD.dz;

            group.position.set(lc_data.tdx ? parseFloat(lc_data.tdx) : 0, lc_data.tdy ? parseFloat(lc_data.tdy) : 0, lc_data.tdz ? parseFloat (lc_data.tdz) : 0);
            group.rotation.set(lc_data.rotx * (Math.PI/180), -lc_data.roty * (Math.PI/180), lc_data.rotz * (Math.PI/180));
        } else {
            group.position.set(0,0,0);
        }

        createEdges(group);

        let eqptLabel = makeTextSprite(label, {
            fontsize: 32
        });

        adaptSprite(eqptLabel, dimensions);

        eqptLabel.type = 'equipmentLabel';
        eqptLabel.visible = false;
        adaptFigureScale(eqptLabel, camera);
        group.add(eqptLabel);


        parent.add(group);

    }

    function drawCylinderDishShroud(objects, parent, action, lc_data, label) {

        if (action == "redraw") {
            clearScene(parent);
        }

        let lineGeometry = new THREE.Geometry();
        let vertArray = lineGeometry.vertices;


        let d1 = parseFloat(objects.dimensions[0] / 12);
        let d2 = parseFloat(objects.dimensions[1] / 12);
        let d3 = parseFloat(objects.dimensions[2] / 12);
        let d4 = parseFloat(objects.dimensions[3] / 12);

        let dimensions = {
            "height": objects.dimensions[0],
            "width": objects.dimensions[1],
            "depth": objects.dimensions[2]
        };


        vertArray.push( new THREE.Vector3(-0.001, 0, -d4), new THREE.Vector3(-d3/2, 0, 0), new THREE.Vector3(-d3/2, 0, d2), new THREE.Vector3(-0.001, 0, d2) );


        let geometry = new THREE.LatheGeometry( vertArray, 48);

        let material = material = createPhongMaterial({ color: objects.texture.color || '#2222ff' });

        let obj = new THREE.Mesh( geometry, material );

        obj.position.set(0, 0, d4);

        let group_rotation = new THREE.Mesh();

        group_rotation.add(obj);

        group_rotation.rotation.set(0, Math.PI/2, 0);


        let group = new THREE.Mesh();

        group.type = 'equipment';
        group.eqpt_id = objects.product.id;

        group.add(group_rotation);


        if(lc_data) {
            group.lc_id = lc_data.id;

            let newD = rotateAndDeposeNodes(lc_data);

            lc_data.tdx = newD.dx;
            lc_data.tdy = newD.dy;
            lc_data.tdz = newD.dz;

            group.position.set(lc_data.tdx ? parseFloat(lc_data.tdx) : 0, lc_data.tdy ? parseFloat(lc_data.tdy) : 0, lc_data.tdz ? parseFloat (lc_data.tdz) : 0);
            group.rotation.set(lc_data.rotx * (Math.PI/180), -lc_data.roty * (Math.PI/180), lc_data.rotz * (Math.PI/180));
        } else {
            group.position.set(0,0,0);
        }

        createEdges(group);

        let eqptLabel = makeTextSprite(label, {
            fontsize: 32
        });

        adaptSprite(eqptLabel, dimensions);

        eqptLabel.type = 'equipmentLabel';
        eqptLabel.visible = false;
        adaptFigureScale(eqptLabel, camera);
        group.add(eqptLabel);

        parent.add(group);

    }

    function drawDishRadom(objects, parent, action, lc_data, label) {

        if (action == "redraw") {
            clearScene(parent);
        }

        let lineGeometry = new THREE.Geometry();
        let vertArray = lineGeometry.vertices;

        let d1 = parseFloat(objects.dimensions[0] / 12);
        let d2 = parseFloat(objects.dimensions[1] / 12);
        let d3 = parseFloat(objects.dimensions[2] / 12);
        let d4 = parseFloat(objects.dimensions[3] / 12);

        let dimensions = {
            "height": objects.dimensions[0],
            "width": objects.dimensions[1],
            "depth": objects.dimensions[2]
        };

        let sd1 = d1/2;
        let irv = sd1 / 50.0;
        let y = 6 * sd1 * sd1 * sd1 * sd1 * sd1 + 2;

        let rat = d2/y;

        vertArray.push( new THREE.Vector3(0.01, 0.0, 0));
        vertArray.push( new THREE.Vector3(sd1, 0, d4));
        vertArray.push( new THREE.Vector3(sd1, 0, d4+d3));

        var tmpArr = [];
        for(let x=0; x<sd1; x += irv){
            let y = 6 * x * x * x * x * x+ 2;
            tmpArr.push( new THREE.Vector3( x, 0,d2 - y * rat+d4+d3));
        }
        for(let i=0; i<tmpArr.length; i++){
            vertArray.push(tmpArr[tmpArr.length-i-1]);
        }

        let geometry = new THREE.LatheGeometry( vertArray, 48);
        let material = createPhongMaterial( { color: objects.texture.color || '#2222ff', side: THREE.DoubleSide } );

        let obj = new THREE.Mesh( geometry, material );

        obj.rotation.set(0, Math.PI/2, 0);


        let group = new THREE.Mesh();

        group.type = 'equipment';
        group.eqpt_id = objects.product.id;

        group.add(obj);

        if(lc_data) {
            group.lc_id = lc_data.id;

            let newD = rotateAndDeposeNodes(lc_data);

            lc_data.tdx = newD.dx;
            lc_data.tdy = newD.dy;
            lc_data.tdz = newD.dz;

            group.position.set(lc_data.tdx ? parseFloat(lc_data.tdx) : 0, lc_data.tdy ? parseFloat(lc_data.tdy) : 0, lc_data.tdz ? parseFloat (lc_data.tdz) : 0);
            group.rotation.set(lc_data.rotx * (Math.PI/180), -lc_data.roty * (Math.PI/180), lc_data.rotz * (Math.PI/180));
        } else {
            group.position.set(0,0,0);
        }

        createEdges(group);

        let eqptLabel = makeTextSprite(label, {
            fontsize: 32
        });

        adaptSprite(eqptLabel, dimensions);

        eqptLabel.type = 'equipmentLabel';
        eqptLabel.visible = false;
        adaptFigureScale(eqptLabel, camera);
        group.add(eqptLabel);

        parent.add(group);

    }

    function drawParabolicGridDish(objects, parent, action, lc_data, label) {

        if (action == "redraw") {
            clearScene(parent);
        }

        let lineGeometry = new THREE.Geometry();
        let vertArray = lineGeometry.vertices;

        let d1 = parseFloat(objects.dimensions[0] / 12);
        let d2 = parseFloat(objects.dimensions[1] / 12);
        let d3 = parseFloat(objects.dimensions[2] / 12);
        let d4 = parseFloat(objects.dimensions[3] / 12);

        let sd1 = d1/2;
        let sd2 = d2/2;

        let vertArray2 = [];
        let irv = (d1 - 0.001) / 50;
        let MaxY = sd2;
        let Rat = sd1 / MaxY;


        for(let x =- sd1; x <= sd1; x += irv){
            let y = Math.sqrt(sd1 * sd1 - x * x);
            vertArray.push( new THREE.Vector3(x, y / Rat , 0));
            vertArray2.push( new THREE.Vector3(x, y / Rat + d4 , 0));
        }

        for(let i=1; i<=vertArray2.length; i++) {
            vertArray.push(vertArray2[vertArray2.length-i]);
        }

        vertArray.push( new THREE.Vector3(-sd1, 0 , 0));


        let material = material = createPhongMaterial({ color: objects.texture.color || '#2222ff' });
        let shape = new THREE.Shape(vertArray);

        let extrudeSettings = {
            steps: 1,
            amount: d3,
            bevelEnabled: false,
            bevelThickness: 0,
            bevelSize: 0,
            bevelSegments: 0
        };
        let geometry = new THREE.ExtrudeGeometry( shape, extrudeSettings );


        let obj = new THREE.Mesh( geometry, material );

        obj.position.set(-d4 - d2/2, -d3/2, 0);
        obj.rotation.set(-Math.PI/2, 0, -Math.PI/2);


        let group = new THREE.Mesh();


        group.type = 'equipment';
        group.eqpt_id = objects.product.id;

        group.add(obj);

        if(lc_data) {
            group.lc_id = lc_data.id;

            let newD = rotateAndDeposeNodes(lc_data);

            lc_data.tdx = newD.dx;
            lc_data.tdy = newD.dy;
            lc_data.tdz = newD.dz;

            group.position.set(lc_data.tdx ? parseFloat(lc_data.tdx) : 0, lc_data.tdy ? parseFloat(lc_data.tdy) : 0, lc_data.tdz ? parseFloat (lc_data.tdz) : 0);
            group.rotation.set(lc_data.rotx * (Math.PI/180), -lc_data.roty * (Math.PI/180), lc_data.rotz * (Math.PI/180));
        } else {
            group.position.set(0,0,0);
        }

        createEdges(group);

        let eqptLabel = makeTextSprite(label, {
            fontsize: 32
        });

        adaptSprite(eqptLabel, dimensions);

        eqptLabel.type = 'equipmentLabel';
        eqptLabel.visible = false;
        adaptFigureScale(eqptLabel, camera);
        group.add(eqptLabel);

        parent.add(group);

    }

    function createEdges(group) {

        group.traverse(function (child) {

            if (child instanceof THREE.Mesh) {
                let wfh = new THREE.EdgesHelper(child, "#ffffff");

                wfh.material.opacity = 0.9;
                wfh.material.transparent = true;
                wfh.visible = viewSettings.edges && viewSettings.members;

                scene.add(wfh);
            }

        });

    }

    function rotateAndDeposeNodes(lc) {

        var newCoords = {
            dx: lc.dx,
            dy: lc.dy,
            dz: lc.dz
        };

        // if(lc.rotz) {
        //     var oldX = newCoords.dx,
        //         oldY = newCoords.dy,
        //         rotZ = lc.rotz * (Math.PI/180);
        //
        //     newCoords.dx = oldX * Math.cos(rotZ) - oldY * Math.sin(rotZ);
        //     newCoords.dy = oldX * Math.sin(rotZ) + oldY * Math.cos(rotZ);
        // }

        if(lc.roty) {
            var oldX = newCoords.dx,
                oldZ = newCoords.dz,
                rotY = lc.roty * (Math.PI/180);

            newCoords.dx = oldX * Math.cos(rotY) - oldZ * Math.sin(rotY);
            newCoords.dz = oldX * Math.sin(rotY) + oldZ * Math.cos(rotY);
        }

        // if(lc.rotx) {
        //     var oldY = newCoords.dy,
        //         oldZ = newCoords.dz,
        //         rotX = lc.rotx * (Math.PI/180);
        //
        //     newCoords.dy = oldY * Math.cos(rotX) - oldZ * Math.sin(rotX);
        //     newCoords.dz = oldY * Math.sin(rotX) + oldZ * Math.cos(rotX);
        // }

        newCoords.dx = parseFloat(newCoords.dx).toFixed(2);
        newCoords.dy = parseFloat(newCoords.dy).toFixed(2);
        newCoords.dz = parseFloat(newCoords.dz).toFixed(2);

        return newCoords;
    }

    function removeByType(parent, type) {
        var temp = [];
        var temp1 = [];

        parent.traverse(function (child) {
            if (child instanceof THREE.Mesh || child instanceof THREE.Line || child instanceof THREE.Object3D) {
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

    function addAxis(parent) {

        var axisRadius = 0.01;
        var axisLength = 2;
        var axisTess = 24;

        var axisXMaterial = new THREE.MeshLambertMaterial({ color: 0xFF0000 });
        var axisYMaterial = new THREE.MeshLambertMaterial({ color: 0x00FF00 });
        var axisZMaterial = new THREE.MeshLambertMaterial({ color: 0x0000FF });
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
        axisX.rotation.z = - Math.PI / 2;
        axisX.position.x = axisLength/2-1;

        axisY.position.y = axisLength/2-1;

        axisZ.rotation.y = - Math.PI / 2;
        axisZ.rotation.z = - Math.PI / 2;
        axisZ.position.z = axisLength/2-1;

        var group = new THREE.Mesh();

        group.add( axisX );
        group.add( axisY );
        group.add( axisZ );

        var arrowX = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 4*axisRadius, 18*axisRadius, axisTess, 1, true),
            axisXMaterial
        );
        var arrowY = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 4*axisRadius, 18*axisRadius, axisTess, 1, true),
            axisYMaterial
        );
        var arrowZ = new THREE.Mesh(
            new THREE.CylinderGeometry(0, 4*axisRadius, 18*axisRadius, axisTess, 1, true),
            axisZMaterial
        );
        arrowX.rotation.z = - Math.PI / 2;
        arrowX.position.x = axisLength - 1 + axisRadius*4/2;

        arrowY.position.y = axisLength - 1 + axisRadius*4/2;

        arrowZ.rotation.z = - Math.PI / 2;
        arrowZ.rotation.y = - Math.PI / 2;
        arrowZ.position.z = axisLength - 1 + axisRadius*4/2;

        group.add( arrowX );
        group.add( arrowY );
        group.add( arrowZ );

        group.type = 'axises_help';

        axesHelperContainer.rotation.setFromQuaternion(parent.getWorldQuaternion());
        parent.add(group);
    }

    function removeAxis(parent) {
        var temp = [];

        parent.traverse(function (child) {
            if (child.type == 'axises_help') {
                temp.push(child);
            }
        });

        for (var key in temp) {
            parent.remove(temp[key]);
        }
    }

    function AspectDPoSS() {
        var box = new THREE.Box3().setFromObject(ais);
        var max = Math.abs(Math.max(box.size().x, box.size().y, box.size().z));

        if (max < Infinity) {
            if (camera.inPerspectiveMode) {
                camera.position.y = max*2;
                controls.target.set(0, box.size().y / 2, 0);

                gridZX.scale.set(max, max, max);
                gridXY.scale.set(max, max, max);
                gridYZ.scale.set(max, max, max);

                Axises.scale.set(max, max, max);
            } else if (camera.inOrthographicMode) {
                camera.setZoom(camera.zoom / max);
                controls.target.set(0, 0, 0);
            }
        }

        // camera.position.z = Math.abs(Math.max(box.size().x, box.size().y, box.size().z) + 5);
        // camera.lookAt(scene.position);
    }

    function Aspect() {
        var box = new THREE.Box3().setFromObject(ais);
        var max = Math.abs(Math.max(box.size().x, box.size().y, box.size().z));

        // camera.position.z = Math.abs(Math.max(box.size().x, box.size().y, box.size().z) + 5);
        // camera.lookAt(scene.position);
    }

    function Selected(callback) {
        onSelected = callback;
    }

    function RigthClickSelected(callback) {
        onRigthClickSelect = callback;
    }

    function cameraUpdate(callback) {
        onCameraUpdate = callback;
    }

    function addLabel(text, props) {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        canvas.width = 75;
        canvas.height = 75;
        context.font = props.fontSize + 'px Arial';
        context.textAlign = 'center';
        context.textBaseline = 'bottom';
        context.fillStyle = '#565656';
        context.fillText(text, context.measureText(text).width, props.fontSize * 2);

        const texture = new THREE.Texture(canvas);
        texture.needsUpdate = true;

        const spriteMaterial = new THREE.SpriteMaterial({map: texture});

        const sprite = new THREE.Sprite(spriteMaterial);
        sprite.position.set(0, 0, 0);
        sprite.center = new THREE.Vector2(-1, -1);
        if(props.position) sprite.position.set(props.position.x, props.position.y, props.position.z);

        return sprite;
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
        // sprite.scale.set(2, 1, 1);
        adaptFigureScale(sprite, camera);
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

    function adaptSprite(sprite, dimensions) {
        sprite.scale.set(1, 0.58, 1);
        if (dimensions.radius) {
            sprite.position.set(0, 1, dimensions.radius / 14);
            return;
        }
        sprite.position.set(-0.1, 0, dimensions.width / 14);
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
    exports.enableAxesMinimap = EnableAxesMinimap;
    exports.draw = Draw;
    exports.selected = Selected;
    exports.cameraUpdate = cameraUpdate;
    exports.rightClickSelected = RigthClickSelected;
    exports.changeGridSettings = ChangeGridSettings;
    exports.changeCameraPosition = ChangeCameraPosition;
    exports.getCurentScreenshotURL = GetCurentScreenshotURL;
    exports.changeViewSettingsWID = ChangeViewSettingsWID;
    exports.changeViewSettingsWLSC = ChangeViewSettingsWLSC;
    exports.changeViewSettingsDPOSS = ChangeViewSettingsDPOSS;
})(window.webgl || (window.webgl = {}));