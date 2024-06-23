# Laravel Advertisements
## Installation

1. Clone project from GitHub
``` bash
git clone git@github.com:IlyaHar/LaravelAd.git
```

## Settings

2. **Copy all from .env.example, create .env and paste it there. Then configure database, Google API and GitHub API for oAuth2**
``` bash
 composer install
```
3. Open Docker, run the container and come in container

``` bash
 vendor/bin/sail up -d
```
**Copy container_id from *docker ps***
``` bash
 docker ps
```
``` bash
 docker exec -it container_id /bin/bash
```

4. Install Composer and Npm
``` bash
 composer install
```
``` bash
 npm install
```

``` bash
 php artisan key:generate
```
``` bash
 php artisan storage:link
```
``` bash
 php artisan migrate --seed
```

*After starting seeding you need to wait a little (30-60 seconds)*

``` bash
 npm run dev
```
``` bash
 php artisan serve
```
# Have a great time!
