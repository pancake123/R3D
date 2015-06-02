#ifndef __RED_DOUBLE_POINT_ALGORITHM__
#define __RED_DOUBLE_POINT_ALGORITHM__

#include "../Algorithm.h"

namespace algorithms {
	class DoublePointAlgorithm : public Algorithm {
	public:
		Matrix getMatrix() {
			return Matrix(1.0f);
		}
	};
}

#endif // ~__RED_DOUBLE_POINT_ALGORITHM__