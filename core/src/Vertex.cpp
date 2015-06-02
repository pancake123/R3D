#include "Vertex.h"

#include <math.h>

void Vertex::normalize(void) {
	float magnitude = this->magnitude();
	this->x /= magnitude;
	this->y /= magnitude;
	this->z /= magnitude;
}

float Vertex::magnitude() {
	return sqrtf(
		(this->x * this->x) +
		(this->y * this->y) +
		(this->z * this->z)
	);
}

Vertex Vertex::cross(const Vertex& vertex) {
	return Vertex (
			(this->y * vertex.z) - (this->z * vertex.y),
			(this->z * vertex.x) - (this->x * vertex.z),
			(this->x * vertex.y) - (this->y - vertex.x)
		);
}

float Vertex::distance(const Vertex& vertex) {
	return sqrtf (
		powf (
			this->x - vertex.x, 2.0f
		) + powf (
			this->y - vertex.y, 2.0f
		) + powf (
			this->z - vertex.z, 2.0f
		)
	);
}

float Vertex::normalDistance(const Vertex& left, const Vertex& right) {
	return 2 * this->square(left, right) / (
		sqrtf (
			powf (
				left.x - right.x, 2.0f
			) + powf (
				left.y - right.y, 2.0f
			)
		)
	);
}

float Vertex::square(const Vertex& left, const Vertex& right ) {
	return fabs (
		(left.x - this->x) * (right.y - this->y) -
		(right.x - this->x) * (left.y - this->y)
	) / 2;
}
