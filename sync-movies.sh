#!/bin/bash
cd "$(dirname "$0")"

# Sync Movies Wishlist
rsync -rav --timeout=300 --progress --include-from=movies-wishlist --append-verify --partial --password-file ./rsync.pwd rsync://rehberg@192.168.123.1:/Filme/ /media/MEDIA/Filme\ Wishlist/
