#!/bin/bash

if [ ! -d ${HORNET_SNAPSHOT_PATH} ]; then
  echo "Directorio de instantánea no encontrado. Por favor, ejecuta './bootstrap.sh' primero."
  exit
fi

# Check if file exist
if [ ! -f "variables.env" ]; then
  echo "El fichero de variables no existe."
  exit
fi

docker compose --env-file variables.env --profile run up
