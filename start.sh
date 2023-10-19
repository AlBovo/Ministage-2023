#!/bin/bash

cd LoginEsotico && docker compose up -d
cd ../PaguriShop && docker compose up -d
cd ../SQLH4ck && docker compose up -d
