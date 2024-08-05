#!/bin/bash

if [[ "$OSTYPE" != "darwin"* && "$EUID" -ne 0 ]]; then
  echo "Por favor, ejecutar como root o con sudo."
  exit
fi

if [ ! -d "snapshot" ]; then
  echo "Instantánea no encontrada."
  exit
fi

echo "Publicando instantánea..."
docker compose up httpd
