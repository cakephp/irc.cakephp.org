# irc.cakephp.org

The official irc.cakephp.org website application.

## Installation

```bash
# clone the repository
git clone git@github.com:cakephp/irc.cakephp.org.git

# install dependencies
composer install
```

## Deploying

On the Dokku server:

```shell
# create the app
dokku apps:create irc

# create and link the database
dokku mysql:create irc
dokku mysql:link irc irc
```

On your local computer:

```shell
# add the remote
git remote add dokku dokku@SERVER_IP:irc

# push the app
git push dokku master
```
