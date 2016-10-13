#!/bin/bash

function calc() {
        awk "BEGIN { print "$*" }"
}

function run() {
        RATE=$(calc $1/100)
        echo "Finished for number $1 means crossoverRate: $RATE"
        APP_NAME="GenAlgo.20161013.CROSSOVER" TARGET_NUMBER=42 TEST_COUNT=900 MUTATION_RATE=0.09375 CROSSOVER_RATE=$RATE bin/app gen-algo:tutorial -q
}

export -f run
export -f calc

#crossover: 0.01 - 1.00 -> 100x Faktor 100 -> 1 - 100
parallel run ::: {100..1}
