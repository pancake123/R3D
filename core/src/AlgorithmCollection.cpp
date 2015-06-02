#include "AlgorithmCollection.h"

static AlgorithmCollection* singleton = NULL;

AlgorithmCollection* AlgorithmCollection::getCollection(void) {
	if (::singleton == NULL) {
		return (::singleton = new AlgorithmCollection());
	} else {
		return ::singleton;
	}
}

Algorithm* AlgorithmCollection::find(Strategy strategy) {
	if (strategy == Strategy::R_STRATEGY_UNKNOWN) {
		return NULL;
	}
	if (this->algorithms.count(strategy) > 0) {
		return this->algorithms.at(strategy);
	} else {
		return NULL;
	}
}