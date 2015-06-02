#ifndef __RED__CAMERA__
#define __RED__CAMERA__

#include "Define.h"
#include "Point.h"
#include "Vertex.h"

typedef class Camera {
public:
	Vertex _position;
	Vertex _view;
	Vertex _up;
	Vertex _strafe;
	float  _sensitivity;
	Vertex _move;
public:
	void create(Vertex position, Vertex view);
	void rotate(float angle, float x, float y, float z);
	void move(float velocity);
	void lookAt(void);
	void keyboard(float velocity, int key = 0, bool pressed = false);
	void mouse(const Point& mouse, bool center = 1);
	void strafe(float velocity);
} *CameraP;

#endif // ~__RED__CAMERA__