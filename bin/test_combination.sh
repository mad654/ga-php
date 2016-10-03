#!/bin/bash

function calc() {
  awk "BEGIN { print "$*" }"
}

function run() {
  CRATE=$(calc $1/100)
  MRATE=$(calc $2/1000)

  echo "Finished for number $1/$2 means crossoverRate: $CRATE | mutationRate: $MRATE"

  APP_NAME="GenAlgo.20160930.COMBINATION" \
  TARGET_NUMBER=42 \
  TEST_COUNT=100 \
  MUTATION_RATE=$MRATE \
  CROSSOVER_RATE=$CRATE \
  bin/app gen-algo:tutorial -q
}

export -f run
export -f calc

#combination:~
#  - crossover: 0.61 - 1.00 -> Faktor 100  -> 61 - 100
#  - mutation:  0.04 - 0.10 -> Faktor 1000 -> 40 - 100
parallel run ::: {100..61} ::: {100..40}
