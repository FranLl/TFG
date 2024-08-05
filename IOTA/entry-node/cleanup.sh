#!/bin/bash

if [[ "$OSTYPE" != "darwin"* && "$EUID" -ne 0 ]]; then
  echo "Por favor, ejecutar como root o con sudo."
  exit
fi

echo "Eliminando contenedor..."
docker compose down --remove-orphans
