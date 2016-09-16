#!/bin/bash

function calc() {
	awk "BEGIN { print "$*" }"
}

function run() {
	RATE=$(calc $1/1000000)
	echo "Finished for number $1 means crossoverRate: $RATE"
	TARGET_NUMBER=42 TEST_COUNT=100 MUTATION_RATE=0.09375 CROSSOVER_RATE=$RATE bin/app gen-algo:tutorial -q
}

export -f run
export -f calc

# test from 0.09 bis 0.5 > Faktor 1000 > 900 - 500
parallel -j -2 run ::: {900::500}
