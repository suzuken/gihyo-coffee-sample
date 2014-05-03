install:
	php composer.phar install

update:
	php composer.phar update

init_db:
	mysql -u root -p < query/init.q

insert:
	mysql -u coffee -pcoffeepass coffee_db < query/data.q

select:
	mysql -u coffee -pcoffeepass coffee_db < query/select.q

login:
	mysql -u coffee -pcoffeepass coffee_db

fixer:
	php php-cs-fixer.phar fix .

ci: fixer
	git add --all
	git commit
