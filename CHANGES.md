# Changes for *ga-php*

- Refactored output to logging utilizing events

  Now results not printed to stdout anymore, we are logging
  all results to `var/log/debug.log`.

  ```
  tail -f var/cache/debug.log | grep GENALGO.TUTORIAL.INFO
  ```

- install composer localy during `make`
- Make algo parameters configure able via
  - configuration file in `etc/config`
  - system envirnment variables

- Integrated SimpleDemo as a command

  Start it via:
  ```
  bin/app gen-algo:tutorial
  ```

