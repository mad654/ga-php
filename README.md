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

See [src/SimpleDemo.php](src/SimpleDemo.php) for details.

## ROADMAP
- [DONE] integrate as command
- add configuration object
- emmit events [start, ok, error]
- log events as json together with configuration (Monolog json logger ???)
