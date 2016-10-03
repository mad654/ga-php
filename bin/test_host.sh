#!/bin/bash

function calc() {
        awk "BEGIN { print "$*" }"
}

function run() {
        RATE=$(calc $1/10000)
        echo "Finished for number $1 "
        APP_NAME="GenAlgo.20160930.BENCHMARK" TARGET_NUMBER=42 TEST_COUNT=100 MUTATION_RATE=0.001 CROSSOVER_RATE=0.7 bin/app gen-algo:tutorial -q
}

export -f run
export -f calc

parallel run ::: {1..100}
