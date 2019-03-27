cd build
docker-compose run --rm composer install
docker-compose up -d
cd ../
docker-compose up -d
# Wait some seconds to let the DB container fire up ...
docker-compose exec web chmod -R 0777 build/vendor
docker-compose exec web cp -rf build/vendor vendor
docker-compose exec web chgrp www-data web/assets runtime vendor
docker-compose exec web chmod g+rwx web/assets runtime vendor
docker-compose exec web chmod -R 0777 vendor
docker-compose exec web ./yii migrate
