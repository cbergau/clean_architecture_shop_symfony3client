#docker build -t clean_arch_shop .

docker-compose up -d

docker run --rm -v $(pwd):/app composer/composer install --prefer-dist --ignore-platform-reqs
docker run -it --rm -v $(pwd):/data digitallyseamless/nodejs-bower-grunt bower install
