echo "Start clearing cache..."
sudo php ./app/console cache:clear
sudo chmod 777 app/cache/dev/
sudo chmod 777 app/cache/
sudo chmod 777 app/logs/
sudo chmod 777 app/cache/dev/security/
sudo chmod 777 app/cache/dev/annotations/
sudo chmod 777 app/cache/dev/security/SecurityProxies/
sudo chmod 777 app/cache/dev/security/cache.meta 
sudo chmod 777 app/cache/dev/doctrine/orm/Proxies/

sudo chmod 777 app/cache/dev/twig/*
echo "Done..."
