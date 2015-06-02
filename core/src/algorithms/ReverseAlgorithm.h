#ifndef __RED_REVERSE_ALGORITHM__
#define __RED_REVERSE_ALGORITHM__

#include "../Algorithm.h"

namespace algorithms {
	class ReverseAlgorithm : public Algorithm {
	public:
		GLfloat fov = 45.0f;
		GLfloat aspect = 4.0f / 3.0f;
		GLfloat near = 1.0f;
		GLfloat far = 1000.0f;
	public:
		Matrix getMatrix() {
			Matrix mat = glm::perspective(
				this->fov,
				this->aspect,
				this->far,
				this->near
			);
			mat = glm::scale(mat, glm::vec3({
				-1.0f, 1.0f, 1.0f
			}));
			mat = glm::translate(mat, glm::vec3({
				0.0f, 0.0f, -(this->far - this->near) / 1.5f
			}));
			mat = glm::rotate(mat, 180.0f, glm::vec3({
				0.0f, 1.0f, 0.0f
			}));
			mat = glm::translate(mat, glm::vec3({
				0.0f, 0.0f, (this->far - this->near) / 1.5f
			}));
			return mat;
		}
	};
}

#endif // ~__RED_REVERSE_ALGORITHM__