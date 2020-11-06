VHOST Notes

```bash

# Apache
apachectl configtest
cd /etc/apache2/sites-available/
sudo a2ensite sjp.trenchdevs.org

sudo systemctl reload apache2
sudo apachectl restart
```