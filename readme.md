docker-compose -f docker/docker-compose.yml up -d
docker run -v /var/www/magnis/:/var/www/magnis -p 80:80 -t docker_magnis
docker exec -it docker_magnis bash
php /var/www/magnis migrate
mkdir /var/www/magnis/log
exit

Тормозим сервис docker-compose -f docker/docker-compose.yml down
Запускаем его заново docker-compose -f docker/docker-compose.yml up -d
Открываем localhost в браузере и смотрим на новый сайт.