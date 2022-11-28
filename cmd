sudo systemctl stop mysql.service &&
sudo lsyncd -delay 1 -rsync /home/benjamin/Documents/Projetos-II/ /opt/lampp/htdocs/v1 &&
sudo /opt/lampp/xampp start;