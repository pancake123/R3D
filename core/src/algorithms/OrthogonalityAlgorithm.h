#ifndef __RED_ORTHOGONALITY_ALGORITHM__
#define __RED_ORTHOGONALITY_ALGORITHM__

#include "../Algorithm.h"

namespace algorithms {
	class OrthogonalityAlgorithm : public Algorithm {
	public:
		GLfloat left = -100.0f;
		GLfloat right = 100.0f;
		GLfloat bottom = -100.0f;
		GLfloat top = 100.0f;
	public:
		Matrix getMatrix() {
			return glm::ortho(
				this->left,
				this->right,
				this->bottom,
				this->top,
				-1000.0f,
				 1000.0f
			) * this->getCameraMatrix();
		}
	};
}

#endif // ~__RED_ORTHOGONALITY_ALGORITHM__