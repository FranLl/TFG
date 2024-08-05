#!/bin/bash

if [[ "$OSTYPE" != "darwin"* && "$EUID" -ne 0 ]]; then
  echo "Por favor, ejecutar como root o con sudo."
  exit
fi

# Check if file exist
if [ ! -f "variables.env" ]; then
  echo "El fichero de variables no existe."
  exit
fi

echo "Eliminando contenedores..."
docker compose --env-file variables.env down --remove-orphans

# Include file
source variables.env

if [ -d ${HORNET_SNAPSHOT_PATH} ]; then
  echo "Eliminando instantánea..."
  rm -Rf ${HORNET_SNAPSHOT_PATH}
fi

if [ -d ${HORNET_DB_PATH} ]; then
  echo "Eliminando datos..."
  rm -Rf ${HORNET_DB_PATH}
fi

