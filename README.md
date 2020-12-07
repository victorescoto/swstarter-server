# SWStarter - Server

## Get the project up and running

First of all, we need to setup somethings:
```bash
$ cp .env.example .env
$ docker-compose run --rm web composer install
$ docker-compose run --rm web php artisan key:generate
$ docker-compose run --rm web php artisan migrate
```

After that, you only need to run:
```bash
$ docker-compose up -d
```

### Last but not least

To start the worker that will be generating the statistics, run:
```bash
$ docker-compose run -d web php artisan schedule:work
```

Great, everything should be working now, enjoy :)

## Available Routes

| Method   | Path                            | Example                |
|----------|---------------------------------|------------------------|
| GET      | /api/{resource}/search/{search} | api/people/search/yoda |
| GET      | /api/{resource}/{id}            | api/films/2            |
| GET      | /api/statistics                 |                        |

If you prefer, you can use [Insomnia](https://insomnia.rest/) and import the file `./insomnia.json`
