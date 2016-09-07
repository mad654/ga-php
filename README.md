# ga-php

Genetic algorithm implemented based on this
[tutorial](http://www.ai-junkie.com/ga/intro/gat1.html)

## How to build

```
git clone https://github.com/mad654/ga-php.git
cd src
make
```

### How to run

```
bin/app gen-algo:tutorial
```

### How it works and what it does

Implements this [tutorial](http://www.ai-junkie.com/ga/intro/gat1.html)
See [src/SimpleDemo.php](src/SimpleDemo.php) for details.

### Play with parameters

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
- [PROGRESS] add configuration object feature/mad654/configuration
- make file fetches own local composer to bin/composer
- emmit events [start, ok, error]
- log events as json together with configuration (Monolog json logger ???)
