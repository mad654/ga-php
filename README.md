# ga-php

Genetic algorithm implemented based on this
[tutorial](http://www.ai-junkie.com/ga/intro/gat1.html)

## How to build

```
git clone https://github.com/mad654/ga-php.git
cd ga-php
make
```

### How to run

```
make run

# or

bin/app gen-algo:tutorial
```

### How it works and what it does

Implements this [tutorial](http://www.ai-junkie.com/ga/intro/gat1.html)
See [src/SimpleDemo.php](src/SimpleDemo.php) for details.

### Required parameters

They are defined with the following defaults:

```
TARGET_NUMBER = 42
TEST_COUNT = 10
```

Which means on call of this command would try to find `10` solutions
for number `42`.

If you want to change the test count or the target number you can change
`etc/config` or use system environment variables:

```
TARGET_NUMBER=99 TEST_COUNT=100 bin/app gen-algo:tutorial
```

### Play with evolution parameters

You want to evaluate how which parameter influences the performance of
the algorithm?

Adjust the setting in `etc/config` :
```
MAX_POPULATIONS=100
POPULATION_SIZE=100
CROSSOVER_RATE=0.7
MUTATION_RATE=0.001
MAX_SELECTION_ATTEMPTS=10000
```

or simply use system environment variables:

```
MAX_POPULATIONS=100 \
POPULATION_SIZE=100 \
CROSSOVER_RATE=0.7 \
MUTATION_RATE=0.001 \
MAX_SELECTION_ATTEMPTS=10000 \
bin/app gen-algo:tutorial
```

## ROADMAP
- [DONE] integrate as command
- [DONE] add configuration object feature/mad654/configuration
- [DONE] make file fetches own local composer to bin/composer
- [PROGRESS] emmit events [start, ok, error] feature/mad654/emit-events
- Find tool to analyse log entries which can:
   - group log entries
   - calc min/max/avg
   - draw charts
   
