var container,
	camera,
	scene,
	renderer,
	floorMesh,
	object,
	phi = 0,
	width,
	height,
	fov;

var init = function(wrapper) {

	width = $(wrapper).width();
	height = $(wrapper).height();

	container = $("<div>", {
		id: "container"
	}).appendTo(wrapper);

	camera = new THREE.PerspectiveCamera(
		fov = 45, width / height, 1, 10000
	);
	camera.position.z = 350;
	camera.position.y = 150;

	camera.lookAt(new THREE.Vector3(0, 0, 0));

	scene = new THREE.Scene();

	var light = new THREE.AmbientLight( 0x404040 ); // soft white light
	scene.add(light);

	var directionalLight = new THREE.DirectionalLight( 0xffffff );
	directionalLight.position.set(1, 1, 1).normalize();
	directionalLight.intensity = 1.0;
	scene.add( directionalLight );

	directionalLight = new THREE.DirectionalLight( 0xffffff );
	directionalLight.position.set(-1, 0.6, 0.5).normalize();
	directionalLight.intensity = 0.5;
	scene.add(directionalLight);

	directionalLight = new THREE.DirectionalLight();
	directionalLight.position.set(-0.3, 0.6, -0.8).normalize( 0xffffff );
	directionalLight.intensity = 0.45;
	scene.add(directionalLight);

	renderer = new THREE.WebGLRenderer();
	renderer.setSize(width, height);
	container.append(renderer.domElement);

	var gl = renderer.context;

	gl.enable(gl.DEPTH_TEST);
	gl.depthFunc(gl.LESS);
	gl.enable(gl.CULL_FACE);
	gl.cullFace(gl.FRONT);
};

var render = function() {

	if (!object) {
		return void 0;
	}

	//вращаем куб по всем трем осям (переменная мэша куба доступна глобально)
	//object.rotation.x += 0.05 * Math.PI / 90;
	object.rotation.y += 0.25 * Math.PI / 90;
	//object.rotation.z += 1.05 * Math.PI / 90;

	//двигаем куб по кругу, изменяя координаты его позиции по осям x и y
	//object.position.x = Math.sin( phi ) * 50;
	//object.position.y = Math.cos( phi ) * 50;

	//итерируем глобальную переменную
	phi += 0.05;

	camera.fov = fov;
	camera.updateProjectionMatrix();

	//рендерим
	renderer.render(scene, camera);
};

var timer = function() {
	render();
	setTimeout(function() {
		timer();
	}, 15);
};

$(document).ready(function() {
	init("#webgl-preview");
	timer();
});