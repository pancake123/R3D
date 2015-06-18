
const MODE_LINEAR = 1;
const MODE_REVERSE = 2;
const MODE_ORTHOGONAL = 3;

var fov = 45,
    near = 1,
    far = 1000;

var collection = {};

var createCamera = function(mode, width, height) {

    var camera = null;

    switch (mode) {
        case MODE_LINEAR:
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

    camera.position.z = 350;
    camera.position.y = 125;

    camera.lookAt(new THREE.Vector3(0, 0, 0));

    scene = new THREE.Scene();

    var helper = new THREE.GridHelper(1000, 50);
    helper.setColors(0x0000ff, 0x808080);
    helper.position.y = -50;
    scene.add( helper );

    scene.add(object);

    var light = new THREE.AmbientLight( 0x404040 ); // soft white light
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
        object.rotation.z += 0.75 * Math.PI / 90;

        phi += 0.05;
        renderer.render(scene, camera);
    };

    setInterval(render, 15);

    var gl = renderer.context;

    if (mode == MODE_LINEAR) {
        gl.enable(gl.CULL_FACE);
        gl.cullFace(gl.FRONT);
    } else {
        gl.enable(gl.DEPTH_TEST);
        gl.depthFunc(gl.LESS);
    }

    return renderer.domElement;
};

var init = function(object, mode) {

    var wrapper = $("#webgl-preview");

    if (!wrapper.children("#container").length) {
        wrapper.append($("<div></div>", { id: "container" }));
    }

	var width = wrapper.width() / 3;
	var height = wrapper.height();

    wrapper.children("#container").append(createWorld(object, mode, width, height));
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