install:
	php composer.phar install

update:
	php composer.phar update

fixer:
	php php-cs-fixer.phar fix .

ci: fixer
	git add --all
	git commit
