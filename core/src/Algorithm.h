#ifndef __RED_ALGORITHM__
#define __RED_ALGORITHM__

#include "Define.h"
#include "Strategy.h"
#include "Camera.h"

class Algorithm {
public:
	typedef glm::mat4x4 Matrix;
public:
	virtual Matrix getMatrix() = 0;
public:
	void load(void);
	Matrix getCameraMatrix(void);
public:
	Strategy strategy;
	Camera* camera;
};

#endif // ~__RED_ALGORITHM__