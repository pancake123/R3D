#ifndef __RED__MODEL__
#define __RED__MODEL__

#include "Define.h"

#include "glm/glm.h"

typedef class Model {
public:
	enum {
		NONE     = 0x0000,
		FLAT     = 0x0001,
		SMOOTH   = 0x0002,
		TEXTURE  = 0x0004,
		COLOR    = 0x0008,
		MATERIAL = 0x0010,
		AUTO     = SMOOTH  |
		           COLOR   |
				   TEXTURE
	};
	typedef enum {
		XYZ = 0x0000,
		XZY = 0x0001
	} Axis;
public:
	Model() : model(NULL), axis(Axis::XYZ)
	{
	}
	~Model();
public:
	void revert(Axis axis);
	void load(const char* filename);
	void render(unsigned int mode = AUTO);
	void scale(float scale);
private:
	GLMmodel* model;
	Axis axis;
} *ModelP;

#endif // ~__RED__MODEL__