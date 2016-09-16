#!/bin/bash

function calc() { awk "BEGIN { print "$*" }" }

# test from 0.000001 bis 0.01 > Faktor 1000000 > 1 - 10000
for ACT in {1..10000}
do
	RATE=$(calc $ACT/1000000)
	TARGET_NUMBER=21 TEST_COUNT=100 MUTATION_RATE=$RATE make run
	TARGET_NUMBER=42 TEST_COUNT=100 MUTATION_RATE=$RATE make run
	TARGET_NUMBER=84 TEST_COUNT=100 MUTATION_RATE=$RATE make run
done
