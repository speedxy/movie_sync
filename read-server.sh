echo "" > movies-serverlist
#find /mnt/Filme -maxdepth 1 -type d -printf '%f\n' > movies-serverlist
rsync --exclude=".*" --exclude=".*/" --list-only --password-file ~/.kodi/sync/rsync.pwd rehberg@192.168.123.1::Filme/ | sed 's/^.\{,46\}//' > movies-serverlist

echo "" > tv-serverlist
#find /mnt/Serien -maxdepth 1 -type d -printf '%f\n' > tv-serverlist
rsync --exclude=".*" --exclude=".*/" --list-only --password-file .~/.kodi/sync/rsync.pwd rehberg@192.168.123.1::Serien/ | sed 's/^.\{,46\}//' > tv-serverlist
