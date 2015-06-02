#include "Define.h"
#include "Algorithm.h"
#include "AlgorithmCollection.h"
#include "Model.h"
#include "Point.h"
#include "Vertex.h"
#include "Camera.h"

#include "algorithms/DoublePointAlgorithm.h"
#include "algorithms/LinearAlgorithm.h"
#include "algorithms/ReverseAlgorithm.h"
#include "algorithms/SinglePointAlgorithm.h"
#include "algorithms/SphereAlgorithm.h"
#include "algorithms/TriplePointAlgorithm.h"
#include "algorithms/OrthogonalityAlgorithm.h"

#include <iostream>

#define WIDTH 1024
#define HEIGHT 768

Camera camera;
Algorithm* algorithm;
Model car;
int key = 0;
static int keyboard[0xFF] = { 0 };

GLvoid frustum(GLfloat left, GLfloat right, GLfloat bottom, GLfloat top, GLfloat near, GLfloat far) {
	
	glm::mat4x4 matrix(
		(2 * near) / (right - left), 0, (right + left) / (right - left), 0,
		0, (2 * near) / (top - bottom), (top + bottom) / (top - bottom), 0,
		0, 0, -(far + near) / (far - near), -(2 * far + near) / (far - near),
		0, 0, -1, 0
	);

    auto t = glm::transpose(matrix);
	glLoadMatrixf((const GLfloat*)&t);
}

GLvoid perspective(GLfloat fov, GLfloat aspectRatio, GLfloat near, GLfloat far) {

	GLfloat y = near * tanf(fov * M_PI / 360.0),
		x = y * aspectRatio;

	glFrustum(-x, x, -y, y, near, far);
}

GLvoid reverse(GLfloat fov, GLfloat aspectRatio, GLfloat near, GLfloat far) {

	perspective(fov, aspectRatio, far, near);
	camera.lookAt();
	glScalef(-1, 1, 1);
	glTranslatef(0, 0, -(far - near) / 2);
	glRotatef(180.0, 0, 1, 0);
	glTranslatef(0, 0, (far - near) / 2);
}

void render() {

	glMatrixMode(GL_MODELVIEW);
	glLoadIdentity();
	glMatrixMode(GL_PROJECTION);
	glLoadIdentity();

#ifdef _WIN32
	camera.keyboard(10, key, keyboard[key]);
#else
	camera.keyboard(10, key, keyboard[key]);
#endif

	algorithm->load();

	glm::mat4x4 matrix = algorithm->getMatrix();

	glPushMatrix();
		glm::mat4x4 camera = algorithm->getCameraMatrix();
		glMultMatrixf((GLfloat*)&camera);
		glPushMatrix();
			//algorithms::OrthogonalityAlgorithm o;
			//o.left = -WIDTH / 2.0f;
			//o.right = WIDTH / 2.0f;
			//o.bottom = -HEIGHT / 2.0f;
			//o.top = HEIGHT / 2.0f;
			//o.camera = &camera;
			glm::mat4x4 inverse = glm::inverse(matrix) * glm::perspective(45.0f, 4.0f / 3.0f, 1.0f, 10000.0f);
			glMultMatrixf((GLfloat*)&inverse);
			car.render();
		glPopMatrix();
		glPushMatrix();
			glTranslatef(0, 0, -500);
			car.render();
		glPopMatrix();
	glPopMatrix();
}

int main(int argc, char** argv) {

	AlgorithmCollection* algorithms = AlgorithmCollection::getCollection();

	algorithms->insert(Strategy::R_STRATEGY_DOUBLE_POINT, new algorithms::DoublePointAlgorithm());
	algorithms->insert(Strategy::R_STRATEGY_LINEAR, new algorithms::LinearAlgorithm());
	algorithms->insert(Strategy::R_STRATEGY_REVERSE, new algorithms::ReverseAlgorithm());
	algorithms->insert(Strategy::R_STRATEGY_SINGLE_POINT, new algorithms::SinglePointAlgorithm());
	algorithms->insert(Strategy::R_STRATEGY_SPHERE, new algorithms::SphereAlgorithm());
	algorithms->insert(Strategy::R_STRATEGY_TRIPLE_POINT, new algorithms::TriplePointAlgorithm());
	algorithms->insert(Strategy::R_STRATEGY_ORTHOGONALITY, new algorithms::OrthogonalityAlgorithm());

	algorithms->camera(&camera);

	algorithm = algorithms->find(Strategy::R_STRATEGY_LINEAR);

	if (!glfwInit()) {
		return -1;
	}

	GLFWwindow* window = glfwCreateWindow(WIDTH, HEIGHT, "Hello, World", NULL, NULL);

	if (!window) {
		glfwTerminate();
		return -1;
	}

	glfwSetWindowPos(window, 400, 100);
	glfwMakeContextCurrent(window);

	glfwSetKeyCallback(window, [](GLFWwindow* window, int key, int code, int action, int mod) {
		if (action == GLFW_RELEASE) {
			return;
		}
		if (key == GLFW_KEY_ESCAPE) {
			glfwSetWindowShouldClose(window, GL_TRUE);
		}
		switch (char(key)) {
		case '1':
			algorithm = AlgorithmCollection::getCollection()->find(Strategy::R_STRATEGY_DOUBLE_POINT);
			break;
		case '2':
			algorithm = AlgorithmCollection::getCollection()->find(Strategy::R_STRATEGY_LINEAR);
			break;
		case '3':
			algorithm = AlgorithmCollection::getCollection()->find(Strategy::R_STRATEGY_REVERSE);
			break;
		case '4':
			algorithm = AlgorithmCollection::getCollection()->find(Strategy::R_STRATEGY_SINGLE_POINT);
			break;
		case '5':
			algorithm = AlgorithmCollection::getCollection()->find(Strategy::R_STRATEGY_SPHERE);
			break;
		case '6':
			algorithm = AlgorithmCollection::getCollection()->find(Strategy::R_STRATEGY_TRIPLE_POINT);
			break;
		case '7':
			algorithm = AlgorithmCollection::getCollection()->find(Strategy::R_STRATEGY_ORTHOGONALITY);
			break;
		default:
			break;
		}
        ::keyboard[key] = (action == GLFW_PRESS ? true : false);
        ::key = key;
	});

	glfwSetWindowRefreshCallback(window, [] (GLFWwindow* window) {
		int width, height;
		glfwGetWindowSize(window, &width, &height);
		glViewport(0, 0, width, height);
		glMatrixMode(GL_PROJECTION);
		glLoadIdentity();
		glMatrixMode(GL_MODELVIEW);
		glLoadIdentity();
		//gluPerspective(150, (float) WIDTH / HEIGHT, 1, 10000);
		float aspectRatio = (float)WIDTH / HEIGHT;
		glFrustum(-1 * aspectRatio, 1 * aspectRatio, -1, 1, 2, 2000);
	});

	glfwSetCursorPosCallback(window, [] (GLFWwindow* window, double x, double y) {
#ifdef _WIN32
		camera.mouse(Point(int(x), -int(y)), true);
#else
		camera.mouse(Point(int(x), -int(y)), false);
#endif
	});

	camera.create(Vertex(150, 50, 400), Vertex(0, 0, 0));
	
#ifdef __APPLE_CC__
	car.load("../../../../static/models/moskvitch/moskvitch.obj");
#else
	car.load("../../static/models/moskvitch/moskvitch.obj");
#endif

	glfwWindowHint(GLFW_DEPTH_BITS, 32);
	glEnable(GL_DEPTH_TEST);

	while (!glfwWindowShouldClose(window)) {

		// Clear color and depth
		glClearColor(0, 0, 0, 0);
		glClearDepth(1.0f);

		// Clear scene
		glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);

		// Render scene
		render();

		// Swap buffers
		glfwSwapBuffers(window);

		// Poll for and process events
		glfwPollEvents();
	}

	glfwTerminate();
}