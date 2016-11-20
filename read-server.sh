SCRIPT_DIR=$(dirname "$0")

echo "" > movies-serverlist
#find /mnt/Filme -maxdepth 1 -type d -printf '%f\n' > movies-serverlist
rsync --exclude=".*" --exclude=".*/" --list-only --password-file ~/.kodi/sync/rsync.pwd rehberg@192.168.123.1::Filme/ | sed 's/^.\{,46\}//' > ${SCRIPT_DIR}/movies-serverlist

echo "" > tv-serverlist
#find /mnt/Serien -maxdepth 1 -type d -printf '%f\n' > tv-serverlist
rsync --exclude=".*" --exclude=".*/" --list-only --password-file ~/.kodi/sync/rsync.pwd rehberg@192.168.123.1::Serien/ | sed 's/^.\{,46\}//' > ${SCRIPT_DIR}/tv-serverlist
