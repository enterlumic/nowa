#!/bin/bash

# Renombrar archivos y directorios
find . -path ./storage -prune -o -path ./vendor -prune -o -iname "*productos*" | while read file; do
  path=$(dirname "$file")
  filename=$(basename "$file")
  newfilename=$(echo "$filename" | sed 's/productos/productos/g')
  mv "$file" "$path/$newfilename"
done

# Reemplazar contenido dentro de los archivos
find . -path ./storage -prune -o -path ./vendor -prune -o -type f -name "*" | while read file; do
  if grep -q "productos" "$file"; then
    sed -i 's/productos/productos/g' "$file"
    echo "Reemplazo realizado en $file"
  fi
done

echo "Proceso completado."
