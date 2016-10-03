#!/bin/bash


function calc() {
    awk "BEGIN { print "$*" }"
}

function run() {
    echo "Starting factor $1"

        RATE=$(calc $1/1000)
        echo "Finished for number $1 means mutationRate: $RATE"
        APP_NAME="GenAlgo.20160930.MUTATION" TARGET_NUMBER=42 TEST_COUNT=100 MUTATION_RATE=$RATE bin/app gen-algo:tutorial -q
}

export -f run
export -f calc

# mutation: 0.001 - 0.10 -> 100x Faktor 1000 -> 1 - 100
parallel -j -2 run ::: {1..100}
