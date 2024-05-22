# kavithai and Quotes

kavithai and Quotes Public Index.  

> **Our database collects kavithai and quotes from users. Users can submit their kavithai and quotes to the database.**  

## Built USing

- HTML
- Bulma CSS
- Javascript
- Fetch API
- PHP
- PDO
- MYSQL
- Pagination

> **Get Pushbullet text Note Push Notification alert while user register a account or login or Submit kavithai/Quotes.**  

- Create database `query.sql` use this Queries to create database for Store user and kavithai/Quotes data
- API: `/api`
- Add `.env` variables

```env
APIKEY=xxxxxxxx
DBNAME=xxxxxxxxxx
DBUSER=xxxxxxx
DBPASSWORD=xxxxxxxxxxxxxxxxxxxxxx
AccessToken=<Pushbullet access token>
DEVICE=<Device ID>
```

- Submit Kavithai and Quotes

```sh
http://localhost:6005/post
```

- View Kavithai and Quotes Submitted by the user

```sh
http://localhost:6005/?username=username

(or)

## Requrite Proper Rewrite Rules for Both apache and nginx
http://localhost:6005/p/username
```

## LICENSE

MIT
