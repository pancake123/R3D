//#ifndef __TGA_HEADER__
//#define __TGA_HEADER__

//#include "MainHeader.h"
//#include "TextureHeader.h"

#ifdef _WIN32
#  include <windows.h>
#  include <windowsx.h>
#endif

#include <stdlib.h>
#include <stdio.h>

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

#include <math.h>

typedef	struct									
{
	GLubyte	* imageData;									// Image Data (Up To 32 Bits)
	GLuint	bpp;											// Image Color Depth In Bits Per Pixel
	GLuint	width;											// Image Width
	GLuint	height;											// Image Height
	GLuint	texID;											// Texture ID Used To Select A Texture
	GLuint	type;											// Image Type (GL_RGB, GL_RGBA)
} Texture;	

typedef struct
{
	GLubyte Header[12];									// TGA File Header
} TGAHeader;


typedef struct
{
	GLubyte		header[6];								// First 6 Useful Bytes From The Header
	GLuint		bytesPerPixel;							// Holds Number Of Bytes Per Pixel Used In The TGA File
	GLuint		imageSize;								// Used To Store The Image Size When Setting Aside Ram
	GLuint		temp;									// Temporary Variable
	GLuint		type;	
	GLuint		Height;									//Height of Image
	GLuint		Width;									//Width ofImage
	GLuint		Bpp;									// Bits Per Pixel
} TGA;

bool LoadTGA(Texture * texture, char * filename);
bool LoadCompressedTGA(Texture * texture, char * filename, FILE * fTGA);
bool LoadUncompressedTGA(Texture * texture, char * filename, FILE * fTGA);
//#endif