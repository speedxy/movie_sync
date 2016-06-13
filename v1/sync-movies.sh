


# Sync Movies Wishlist
rsync -rav --timeout=300 --progress --include-from=movies-wishlist --append --partial /mnt/Filme/ /media/MEDIA/Filme\ Wishlist/
