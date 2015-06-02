#include "Algorithm.h"

void Algorithm::load() {
	Algorithm::Matrix mat = this->getMatrix();
	glLoadMatrixf((GLfloat*)&mat);
}

Algorithm::Matrix Algorithm::getCameraMatrix(void) {
	if (!this->camera) {
		return glm::mat4x4(1.0f);
	}
	auto x = glm::vec3(
		this->camera->_position.x,
		this->camera->_position.y,
		this->camera->_position.z);
	auto y = glm::vec3(
		this->camera->_view.x,
		this->camera->_view.y,
		this->camera->_view.z);
	auto z = glm::vec3(
		this->camera->_up.x,
		this->camera->_up.y,
		this->camera->_up.z);
	return glm::lookAt(x, y, z);
}