#ifndef __RED_LINEAR_ALGORITHM__
#define __RED_LINEAR_ALGORITHM__

#include "../Algorithm.h"

namespace algorithms {
	class LinearAlgorithm : public Algorithm {
	public:
		GLfloat fov = 90.0f;
		GLfloat aspect = 4.0f / 3.0f;
		GLfloat near = 1.0f;
		GLfloat far = 10000.0f;
	public:
		Matrix getMatrix() {
			Matrix mat = glm::perspective(
				this->fov,
				this->aspect,
				this->near,
				this->far
			);
			return mat;
		}
	};
}

#endif // ~__RED_LINEAR_ALGORITHM__