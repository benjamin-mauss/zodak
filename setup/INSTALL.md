Necessário antes de funcionar

- Estar utilizando o Debian 11, ajustar os PATHs de acordo.
- Estar com o XAMPP instalado em "/opt/lampp/" e rodando o Apache, 
- Executar os comandos SQL de zodak.SQL
- Fazer as pastas '/opt/lampp/htdocs/uploads/faces_imagens' e '/opt/lampp/htdocs/uploads/faces_encodes'
- Modificar usuário e senha do banco em ./database/connect.php
- Ter permissão de escrita, leitura e execução dos arquivos do projeto para o usuário www-data
- Estar com Python3 funcionando e no PATH do sistema operacional
- Instalar o requirements do python.
- (OPCIONAL) Configuração CRONTAB Linux de acordo com os horários, para rodar o script nos momentos adequados. Utiliza este website como auxiliar: https://crontab.guru/

pip install -r ./setup/requirements.txt



Se for utilizar numa VM, provavelmente precisará configurar para compartilhar a webcam do notebook com a da pessoa.





