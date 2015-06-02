#ifndef __RED_ALGORITHM_FACTORY__
#define __RED_ALGORITHM_FACTORY__

#include "Define.h"
#include "Strategy.h"
#include "Algorithm.h"
#include "Camera.h"

#include <set>
#include <map>

class AlgorithmCollection {
	friend class Algorithm;
public:
	static AlgorithmCollection* getCollection(void);
public:
	Algorithm* find(Strategy strategy = Strategy::R_STRATEGY_UNKNOWN);
public:
	inline void insert(Strategy strategy, Algorithm* algorithm) {
		this->algorithms.insert(std::pair<Strategy, Algorithm*>(algorithm->strategy = strategy, algorithm));
	}
	inline void erase(Strategy strategy) {
		this->algorithms.erase(strategy);
	}
	inline void camera(Camera* camera) {
		for (std::pair<Strategy, Algorithm*> p : this->algorithms) {
			p.second->camera = camera;
		}
	}
private:
	std::map<Strategy, Algorithm*> algorithms;
};

#endif // ~__RED_ALGORITHM_FACTORY__