#ifndef __RED_SPHERE_ALGORITHM__
#define __RED_SPHERE_ALGORITHM__

#include "../Algorithm.h"

namespace algorithms {
	class SphereAlgorithm : public Algorithm {
	public:
		Matrix getMatrix() {
			return Matrix(1.0f);
		}
	};
}

#endif // ~__RED_SPHERE_ALGORITHM__