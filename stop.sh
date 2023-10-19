#!/bin/bash

cd LoginEsotico && docker compose down
cd ../PaguriShop && docker compose down
cd ../SQLH4ck && docker compose down

if [[ $1 == "image" ]] ; then
    docker image prune -a -f
fi

if [[ $2 == "volume" ]] ; then
    docker volume prune -a -f
fi
