#!/bin/bash

function run() {
	echo "Finished for number $1"
	TARGET_NUMBER=$1 TEST_COUNT=100 MUTATION_RATE=0.093750 bin/app gen-algo:tutorial -q
}

export -f run
parallel -j -2 run ::: {1..10000}
