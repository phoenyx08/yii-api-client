Getting started
===============

1 Install dependencies

```
composer install
```

1 Rename config/params.example.php to config/params.php and make necessary modifications

2 Rename config/db.default.php to config/db.php and make necessary modifications

3 Create table for entries in the database

```
create table entry
(
    id          text     not null,
    internal_id int      not null
        primary key,
    last_modify datetime null,
    regulator   text     null
);
```

4 Run migrations

```
php yii migrate
```
