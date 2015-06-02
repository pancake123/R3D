#ifndef __RED__POINT__
#define __RED__POINT__

#include "Define.h"

typedef class Point {
public:
	int x;
	int y;
public:
	Point () :
		x (0),
		y (0)
	{
	}
	Point (int x, int y) :
		x (x),
		y (y)
	{
	}
} *PointP;

#endif // ~__RED__POINT__