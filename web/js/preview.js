
const MODE_LINEAR = 0;
const MODE_REVERSE = 1;
const MODE_ORTHOGONAL = 2;
const MODE_DEPTH = 3;

var fov = 45,
    near = 1,
    far = 1000;

var collection = {};

var localization = [
    "Линейная перспектива",
    "Обратная перспектива",
    "Ортографическая проекция",
    "Инверсная воздушная перспектива"
];

var createCamera = function(mode, width, height) {

    var camera = null;

    switch (mode) {
        case MODE_LINEAR:
        case MODE_DEPTH:
            camera = new THREE.PerspectiveCamera(
                fov, width / height, near, far
            );
            break;
        case MODE_REVERSE:
            camera = new THREE.PerspectiveCamera(
                fov, width / height, far, near
            );
            break;
        case MODE_ORTHOGONAL:
            camera = new THREE.OrthographicCamera(
                -width / 2, width / 2, -height / 2, height / 2, near, far
            );
            break;
    }

    collection[mode] = camera;

    return camera;
};

var createWorld = function(object, mode, width, height) {

    var camera = createCamera(mode, width, height),
        scene,
        renderer,
        phi = 0;

    if (mode == MODE_DEPTH) {
        camera.position.z = 500;
        camera.position.y = 250;
    } else {
        camera.position.z = 350;
        camera.position.y = 125;
    }

    camera.lookAt(new THREE.Vector3(0, 0, 0));

    scene = new THREE.Scene();

    //if (mode == MODE_LINEAR || mode == MODE_DEPTH) {
    //    var helper = new THREE.GridHelper(1000, 50);
    //    helper.setColors(0x0000ff, 0x808080);
    //    helper.position.y = -50;
    //    scene.add( helper );
    //}

    scene.add(object);

    if (mode == MODE_DEPTH) {
        var depth = [ -1000, -500, -250, 0, 250, 500, 1000 ];
        for (var d in depth) {
            var geometry = new THREE.BoxGeometry( 100, 100, 100 );
            for ( var i = 0; i < geometry.faces.length; i += 2 ) {
                var hex = Math.random() * 0xffffff;
                geometry.faces[ i ].color.setHex( hex );
                geometry.faces[ i + 1 ].color.setHex( hex );
            }
            var material = new THREE.MeshDepthMaterial( { overdraw: 0.5 } );
            var cube = new THREE.Mesh( geometry, material );
            cube.position.y = 0;
            cube.position.x = 200;
            cube.position.z = -depth[d];
            scene.add(cube);
        }
        material = new THREE.MeshDepthMaterial( { side: THREE.DoubleSide, overdraw: 0.5 } );
        var plane = new THREE.Mesh( new THREE.PlaneBufferGeometry( 1000, 1000, 10, 10 ), material );
        plane.position.y = - 100;
        plane.rotation.x = - Math.PI / 2;
        scene.add( plane );
    }

    var light = new THREE.AmbientLight( 0x404040 );
    scene.add(light);
    var directionalLight = new THREE.DirectionalLight( 0xffffff );
    directionalLight.position.set(1, 1, 1).normalize();
    directionalLight.intensity = 1.0;
    scene.add(directionalLight);
    directionalLight = new THREE.DirectionalLight(0xffffff);
    directionalLight.position.set(-1, 0.6, 0.5).normalize();
    directionalLight.intensity = 0.5;
    scene.add(directionalLight);
    directionalLight = new THREE.DirectionalLight(0xffffff);
    directionalLight.position.set(-0.3, 0.6, -0.8).normalize();
    directionalLight.intensity = 0.45;
    scene.add(directionalLight);

    renderer = new THREE.WebGLRenderer();
    renderer.setSize(width, height);

    var render = function() {

        if (!object) {
            return void 0;
        }

        //object.rotation.x += 0.05 * Math.PI / 90;
        object.rotation.y += 0.25 * Math.PI / 90;
        object.rotation.z += 0.075 * Math.PI / 90;

        phi += 0.05;
        renderer.render(scene, camera);

        $("#angle").text(object.rotation.y.toFixed(2) + " x " + object.rotation.z.toFixed(2));
    };

    setInterval(render, 15);

    var gl = renderer.context;

    if (mode == MODE_LINEAR || mode == MODE_DEPTH) {
        gl.enable(gl.CULL_FACE);
        gl.cullFace(gl.FRONT);
    } else {
        gl.enable(gl.DEPTH_TEST);
        gl.depthFunc(gl.LESS);
    }

    return renderer.domElement;
};

var init = function(object, mode) {

    var wrapper = $("#webgl-preview"), e;

    if (!wrapper.children("#container").length) {
        wrapper.append($("<div></div>", { id: "container" }));
    }

	var width = wrapper.width() / 2;
	var height = 350;

    var t = $("<span></span>", {
        text: localization[mode],
        class: "canvas-title"
    }).appendTo("body");

    wrapper.children("#container").append(e = $(createWorld(object, mode, width, height)));

    t.css({
        left: e.position().left + 10,
        top: e.position().top + 10
    });
};

var changeParameter = function(step) {

    var label = $(this).parents(".preview-control-wrapper").find("label:last-child"),
        key = label.attr("id");

    if (window[key] == void 0) {
        return void 0;
    } else {
        window[key] += step;
    }

    label.text(window[key]);

    for (var i in collection) {
        var value;
        if (i == MODE_REVERSE) {
            if (key == "near") {
                value = window['far'];
            }  else if (key == "far") {
                value = window['near'];
            }
        } else {
            value = window[key];
        }
        collection[i][key] = value;
        collection[i].updateProjectionMatrix();
    }
};