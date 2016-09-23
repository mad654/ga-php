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
See [src/GenAlgo/SimpleAlgorithm.php](src/GenAlgo/SimpleAlgorithm.php) for details.

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

### Events

Currently this events are fired and handled for logging purposes, to give
you a idea whats going on.

#### Results

You can watch which results were calculated by

```
tail -f var/log/genalgo.result-*.json
```

#### AlgorithmTestRunner events

This 4 events represent the current state of test runner.

- [RunStartedEvent](src/GenAlgo/Event/RunStartedEvent.php)
- [SingleTestStarted](src/GenAlgo/Event/SingleTestStarted.php)
- [SingleTestFinished](src/GenAlgo/Event/SingleTestFinished.php)
- [RunFinishedEvent](src/GenAlgo/Event/RunFinishedEvent.php)

```
tail -f var/log/genalgo.debug-*.json | grep GENALGO.DEFAULT.TUTORIAL.INFO
```

#### Algorithm events

This events represent the current internal state of the algorithm. So
if you wan't to take a deeper look, this will be you friend:

```
tail -f var/log/genalgo.debug-*.json | grep GENALGO.DEFAULT.TUTORIAL.DEBUG
```

- [NewOutcomeCreated](src/GenAlgo/Event/NewOutcomeCreated.php)
- [PopulationCreated](src/GenAlgo/Event/PopulationCreated.php)
- [SpezSelected](src/GenAlgo/Event/SpezSelected.php)
- [PairSelected](src/GenAlgo/Event/PairSelected.php)
- [PopulationFitnessCalculated](src/GenAlgo/Event/PopulationFitnessCalculated.php)

## results via rsyslog server logging

If you want to compute results in a multi process / multi host environment
you should enable logging to rsyslog server in order to make sure all things
logged well.

For now we added support for logging results to rsyslogd.

You can enable `APP_LOG_RSYSLOG=true` in `etc/config` and results
are send via UDP to the specified rsyslog server.
See `APP_LOG_HOST` and `APP_LOG_PORT` port to.

### setup rsyslog server

#### allow remote logs reception

#### Debian jessie

Add a new rsyslog config:

```
cat > /etc/rsyslog.d/20-gen-algo.conf
```

with the following content

```
$template json,"%msg%,\n"
$template GaFile, "/var/log/gen-algo/%$YEAR%/%$MONTH%/%$DAY%/%HOSTNAME%/%$YEAR%%$MONTH%%$DAY%T_%HOSTNAME%.gen-algo.json"

$RuleSet remote

*.* -?GaFile;json

# switch back to the default ruleset:
$RuleSet RSYSLOG_DefaultRuleset

# Bind the remote messages to the ruleset remote.
# NOTE: the server must be started after the BindRuleset
$ModLoad imudp
$InputUDPServerBindRuleset remote
$UDPServerRun 514

```

2. Configure logging behavior

- Only log to one file
- Only log json stuff
- Rotate daily or by 100 MB
- max 100 files, min 3 days
- Add date to filename something like this
  /var/log/gen-algo/2016/09/23/hostname/20160923T120001_hostname.gen-algo.json
  for easy rsync to archive

## ROADMAP
- [DONE] integrate as command
- [DONE] add configuration object feature/mad654/configuration
- [DONE] make file fetches own local composer to bin/composer
- [DONE] emmit events [start, ok, error] feature/mad654/emit-events
- make fitness function configurable
