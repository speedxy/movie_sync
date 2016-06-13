#!/bin/bash
cd "$(dirname "$0")"

# Mount
#./mnt.sh

# Sync Movies
echo "Syncing Movies...";
./sync-movies.sh

# UMount
#./umnt.sh
