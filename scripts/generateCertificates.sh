#!/usr/bin/env bash

docker run --rm -v "$(pwd)"/config/certs:/app -it nginx openssl req -x509 -sha256 -nodes -days 365 -newkey rsa:2048 -keyout /app/privateKey.key -out /app/certificate.crt

docker run --rm -v "$(pwd)"/config/certs:/app -it nginx openssl dhparam -out /app/dhparam.pem 2048
