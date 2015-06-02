#ifndef __RED__DEFINE__
#define __RED__DEFINE__

#define _CRT_SECURE_NO_WARNINGS

#include <stdio.h>
#include <stdlib.h>

#if defined(_WIN32)
#  pragma comment (lib, "../../lib/glfw3.lib")
#  pragma comment (lib, "opengl32.lib")
#  pragma comment (lib, "glu32.lib")
#endif

#ifndef APIENTRY
#  define APIENTRY __stdcall
#endif
#ifndef _GDI32_
#  ifndef WINGDIAPI
#    define WINGDIAPI __declspec (dllimport)
#  else
#    define WINGDIAPI
#  endif
#endif
#ifndef CALLBACK
#  define CALLBACK __stdcall
#endif

#ifdef __APPLE_CC__
#  include <OpenGL/gl.h>
#  include <OpenGL/glu.h>
#else
#  include <gl/gl.h>
#  include <gl/glu.h>
#endif

#include "glfw/glfw3.h"
#include "math/glm.hpp"
#include "math/gtc/matrix_transform.hpp"

#endif // ~__RED__DEFINE__