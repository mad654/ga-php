#!/bin/bash

function calc() { awk "BEGIN { print "$*" }" }

# test from 0.0009 bis 0.9 > Faktor 10000 > 9 - 9000
for ACT in {9..9000}
do
	RATE=$(calc $ACT/10000)
	TARGET_NUMBER=21 TEST_COUNT=100 MUTATION_RATE=$RATE make run
	TARGET_NUMBER=42 TEST_COUNT=100 MUTATION_RATE=$RATE make run
	TARGET_NUMBER=84 TEST_COUNT=100 MUTATION_RATE=$RATE make run
done
