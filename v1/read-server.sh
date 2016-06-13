echo "" > movies-serverlist
find /mnt/Filme -maxdepth 1 -type d -printf '%f\n' > movies-serverlist

echo "" > tv-serverlist
find /mnt/Serien -maxdepth 1 -type d -printf '%f\n' > tv-serverlist
