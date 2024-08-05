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

# Include file
source variables.env

# Cleanup if necessary
if [ -d ${HORNET_DB_PATH} ] || [ -d ${HORNET_SNAPSHOT_PATH} ]; then
  ./cleanup.sh
fi

# Prepare directories for hornet
echo "Creando los directorios necesarios..."
mkdir -p ${HORNET_DB_PATH}/privatedb
mkdir -p ${HORNET_DB_PATH}/state
mkdir -p ${HORNET_SNAPSHOT_PATH}

if [ ! -f "${HORNET_SNAPSHOT_PATH}/${SNAPSHOT_NAME}" ]; then
  echo "Descargando la instantánea..."
  wget -P ${HORNET_SNAPSHOT_PATH} ${FULL_SNAPSHOT_URL}
fi

echo "Cambiando los propietarios de los directorios a los adecuados..."
chown -R 65532:65532 ${HORNET_DB_PATH}
chown -R 65532:65532 ${HORNET_SNAPSHOT_PATH}

# Bootstrap network (create hornet database, create genesis milestone, create coo state)
echo "Generando la configuración inicial del sistema..."
docker compose --env-file variables.env up bootstrap-network
docker compose --env-file variables.env down bootstrap-network

# Pull latest images
echo "Descargando las imágenes de los contenedores necesarias..."
docker compose --env-file variables.env pull hornet
docker compose --env-file variables.env pull inx-dashboard
docker compose --env-file variables.env pull inx-coordinator
