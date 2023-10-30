# This script navigates to three different directories and starts Docker Compose for each of them.
# The first command starts Docker Compose for LoginEsotico, the second for PaguriShop, and the third for SQLH4ck.
#!/bin/bash

cd LoginEsotico && docker compose up -d
cd ../PaguriShop && docker compose up -d
cd ../SQLH4ck && docker compose up -d
