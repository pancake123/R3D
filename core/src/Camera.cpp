#include "Camera.h"

#ifdef _WIN32
#  include <Windows.h>
#endif

#include <math.h>

#ifndef _WIN32
typedef struct POINT {
    int x;
    int y;
} *PPOINT;
#endif

void Camera::create(Vertex position, Vertex view) {

	this->_position = position;
	this->_view = view;

	this->_up.set(0, 1, 0);
	this->_move.set(1, 0, 1);

	this->_sensitivity = 1.0f;
}

void Camera::rotate(float angle, float x, float y, float z) {

	Vertex viewNew;
	Vertex viewRab;

	viewRab.x = this->_view.x - this->_position.x;
	viewRab.y = this->_view.y - this->_position.y;
	viewRab.z = this->_view.z - this->_position.z;

	float cosTheta = (float)cosf(angle);
	float sinTheta = (float)sinf(angle);

	viewNew.x  = (cosTheta + (1 - cosTheta) * x * x)     * viewRab.x;
	viewNew.x += ((1 - cosTheta) * x * y - z * sinTheta) * viewRab.y;
	viewNew.x += ((1 - cosTheta) * x * z + y * sinTheta) * viewRab.z;

	viewNew.y  = ((1 - cosTheta) * x * y + z * sinTheta) * viewRab.x;
	viewNew.y += (cosTheta + (1 - cosTheta) * y * y)     * viewRab.y;
	viewNew.y += ((1 - cosTheta) * y * z - x * sinTheta) * viewRab.z;

	viewNew.z  = ((1 - cosTheta) * x * z - y * sinTheta) * viewRab.x;
	viewNew.z += ((1 - cosTheta) * y * z + x * sinTheta) * viewRab.y;
	viewNew.z += (cosTheta + (1 - cosTheta) * z * z)     * viewRab.z;

	this->_view.x = this->_position.x + viewNew.x;
	this->_view.y = this->_position.y + viewNew.y;
	this->_view.z = this->_position.z + viewNew.z;
}

void Camera::move(float velocity) {

	Vertex vertex (
		this->_view.x - this->_position.x,
		this->_view.y - this->_position.y,
		this->_view.z - this->_position.z
	);

	vertex.normalize();

	this->_position.x += vertex.x * velocity * this->_move.x;
	this->_position.y += vertex.y * velocity * this->_move.y;
	this->_position.z += vertex.z * velocity * this->_move.z;

	this->_view.x += vertex.x * velocity * this->_move.x;
	this->_view.y += vertex.y * velocity * this->_move.y;
	this->_view.z += vertex.z * velocity * this->_move.z;
}

void Camera::lookAt(void) {
	gluLookAt (
		this->_position.x,
		this->_position.y,
		this->_position.z,
		this->_view.x,
		this->_view.y,
		this->_view.z,
		0, 1, 0
	);
}

void Camera::keyboard(float velocity, int key, bool pressed) {

#ifdef _WIN32
	if ((GetKeyState('W') & 0x80) == 0x80) {
		this->move(velocity);
	}
	if ((GetKeyState('S') & 0x80) == 0x80) {
		this->move(-velocity);
	}
	if ((GetKeyState('A') & 0x80) == 0x80) {
		this->strafe(-velocity);
	}
	if ((GetKeyState('D') & 0x80) == 0x80) {
		this->strafe(velocity);
	}
#else
    if (key == 'w' && pressed) {
        this->move(velocity);
    }
    if (key == 's' && pressed) {
        this->move(-velocity);
    }
    if (key == 'a' && pressed) {
        this->strafe(-velocity);
    }
    if (key == 'd' && pressed) {
        this->strafe(velocity);
    }
#endif
}

void Camera::mouse(const Point& mouse, bool center) {

	static ::Point last_mouse_position;

	POINT mouseposition;

	int middleX = 2560 / 2;
	int middleY = 1080 / 2;

	float angleY = 0.0f;
	float angleZ = 0.0f;

	Vertex axis;

	static float currentRotX = 0.0f;
	static float lastRotX    = 0.0f;

	if (center)
	{
#ifdef _WIN32
		GetCursorPos (&mouseposition);

		if (
			mouseposition.x == middleX &&
			mouseposition.y == middleY
		) {
			return ;
		}

		SetCursorPos (middleX, middleY);

		mouseposition.x = middleX - mouseposition.x;
		mouseposition.y = middleY - mouseposition.y;
#else
		mouseposition.x = 0;
		mouseposition.y = 0;
#endif
	}
	else
	{
		if (last_mouse_position.x == 0 &&
			last_mouse_position.y == 0)
		{
			last_mouse_position = mouse;
		}

		mouseposition.x = -mouse.x + last_mouse_position.x;
		mouseposition.y =  mouse.y - last_mouse_position.y;
	}

	angleY = (mouseposition.x) / 1000.0f;
	angleZ = (mouseposition.y) / 1000.0f;

	angleY *= this->_sensitivity;
	angleZ *= this->_sensitivity;

	lastRotX = currentRotX;

	if (currentRotX > 1.0f) {
		currentRotX = 1.0f;
		if (lastRotX != 1.0f) {
			axis = (this->_view - this->_position).cross(this->_up);
			axis.normalize();
			this->rotate(1.0f - lastRotX, axis.x, axis.y, axis.z);
		}
	}
	else if (currentRotX < -1.0f) {
		currentRotX = -1.0f;
		if (lastRotX != -1.0f) {
			axis = (this->_view - this->_position).cross(this->_up);
			axis.normalize();
			this->rotate(-1.0f - lastRotX, axis.x, axis.y, axis.z);
		}
	}
	else {
		axis = (this->_view - this->_position).cross(this->_up);
		axis.normalize();
		this->rotate(angleZ, axis.x, axis.y, axis.z);
	}

	this->rotate(angleY, 0, 1, 0);

	last_mouse_position = mouse;
}

void Camera::strafe(float velocity) {

	this->_strafe = (this->_view - this->_position).cross(this->_up);
	this->_strafe.normalize();

	this->_position.x += this->_strafe.x * velocity;
	this->_position.z += this->_strafe.z * velocity;

	this->_view.x += this->_strafe.x * velocity;
	this->_view.z += this->_strafe.z * velocity;
}
