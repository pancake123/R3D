#ifndef __RED__VERTEX__
#define __RED__VERTEX__

#include "Define.h"

typedef class Vertex {
public:
	float x;
	float y;
	float z;
public:
	Vertex () :
		x(0),
		y(0),
		z(0)
	{
	}
	Vertex(float x, float y, float z = 0) :
		x(x),
		y(y),
		z(z)
	{
		this->set(x, y, z);
	}
public:
	void set(float x, float y, float z = 0) {
		this->x = x;
		this->y = y;
		this->z = z;
	}
	inline float* get() {
		return (float*) this;
	}
public:
	Vertex cross(const Vertex& vertex);
	void normalize();
	float magnitude();
	float distance(const Vertex& vertex);
	float normalDistance(const Vertex& left, const Vertex& right);
	float square(const Vertex& left, const Vertex& right);
public:
	inline Vertex operator + (const Vertex& vertex) const {
		return Vertex (
				this->x + vertex.x,
				this->y + vertex.y,
				this->z + vertex.z
			);
	}
	inline Vertex operator - (const Vertex& vertex) const {
		return Vertex (
				this->x - vertex.x,
				this->y - vertex.y,
				this->z - vertex.z
			);
	}
	inline Vertex operator * (const Vertex& vertex) const {
		return Vertex (
				this->x * vertex.x,
				this->y * vertex.y,
				this->z * vertex.z
			);
	}
	inline Vertex operator / (const Vertex& vertex) const {
		return Vertex (
				this->x / vertex.x,
				this->y / vertex.y,
				this->z / vertex.z
			);
	}
	inline Vertex operator + (float value) const {
		return Vertex (
				this->x + value,
				this->y + value,
				this->z + value
			);
	}
	inline Vertex operator - (float value) const {
		return Vertex (
				this->x - value,
				this->y - value,
				this->z - value
			);
	}
	inline Vertex operator * (float value) const {
		return Vertex (
				this->x * value,
				this->y * value,
				this->z * value
			);
	}
	inline Vertex operator / (float value) const {
		return Vertex (
				this->x / value,
				this->y / value,
				this->z / value
			);
	}
	inline void operator += (const Vertex& vertex) {
		this->x += vertex.x;
		this->y += vertex.y;
		this->z += vertex.z;
	}
	inline void operator -= (const Vertex& vertex) {
		this->x -= vertex.x;
		this->y -= vertex.y;
		this->z -= vertex.z;
	}
	inline void operator *= (const Vertex& vertex) {
		this->x *= vertex.x;
		this->y *= vertex.y;
		this->z *= vertex.z;
	}
	inline void operator /= (const Vertex& vertex) {
		this->x /= vertex.x;
		this->y /= vertex.y;
		this->z /= vertex.z;
	}
	inline void operator += (float value) {
		this->x += value;
		this->y += value;
		this->z += value;
	}
	inline void operator -= (float value) {
		this->x -= value;
		this->y -= value;
		this->z -= value;
	}
	inline void operator *= (float value) {
		this->x *= value;
		this->y *= value;
		this->z *= value;
	}
	inline void operator /= (float value) {
		this->x /= value;
		this->y /= value;
		this->z /= value;
	}
public:
	inline float& operator [] (unsigned int index) const {
		return ((float*) this) [index];
	}
} *VertexP;

#endif // ~__RED__VERTEX__