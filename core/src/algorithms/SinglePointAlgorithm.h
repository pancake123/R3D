#ifndef __RED_SINGLE_POINT_ALGORITHM__
#define __RED_SINGLE_POINT_ALGORITHM__

#include "../Algorithm.h"

namespace algorithms {
	class SinglePointAlgorithm : public Algorithm {
	public:
		Matrix getMatrix() {
			return Matrix(1.0f);
		}
	};
}

#endif // ~__RED_SINGLE_POINT_ALGORITHM__