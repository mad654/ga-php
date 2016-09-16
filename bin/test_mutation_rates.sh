#!/bin/bash


function calc() {
    awk "BEGIN { print "$*" }"
}

function run() {
	RATE=$(calc $1/1000000)
	echo "Running for number $1 means mutationRate: $RATE"
	TARGET_NUMBER=42 TEST_COUNT=100 MUTATION_RATE=$RATE bin/app gen-algo:tutorial -q
}

export -f run
export -f calc

# test from 0.000001 bis 0.01 > Faktor 1000000 > 1 - 10000
parallel -j -2 run ::: {1..10000}
