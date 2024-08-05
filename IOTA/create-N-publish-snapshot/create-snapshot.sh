#!/bin/bash

if [[ "$OSTYPE" != "darwin"* && "$EUID" -ne 0 ]]; then
  echo "Por favor, ejecutar como root o con sudo."
  exit
fi

# Cleanup if necessary
if [ -d "snapshot" ]; then
  ./cleanup.sh
fi

echo "Creando directorio de instantánea y cambiando a los propietarios adecuados..."
mkdir snapshot
if [[ "$OSTYPE" != "darwin"* ]]; then
  # nonroot user
  chown -R 65532:65532 snapshot
fi

echo "Creando contenedor generador de la instantánea y creándola..."
docker compose up create-snapshot
echo "Eliminando contenedor generador de la instantánea..."
docker compose down create-snapshot
