# Experimentations

## --@result 190214 Built NodeJS as part of a Docker Composing activity

- --@stcgoal A NodeJS Platform Composable whatever where without action

### --@v Build Node Source and Install

- --@a Download/Extract node source
- --@a Configure/build/test/install node

# Observations

## the YAML Stack has build context

context: ./bin/webserver

## Rebuild

```bash
docker-compose build
```

## Bundle

- Generate a Docker bundle from the Compose file

```bash
  docker-compose bundle...
```
