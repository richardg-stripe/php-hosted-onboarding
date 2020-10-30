#!make
include .env
export $(shell sed 's/=.*//' .env)

.PHONY: no3DS

install:
	composer install

customAccountExample:
	php src/customAccountExample.php

expressAccountExample:
	php src/expressAccountExample.php

createAccountLink:
	php src/createAccountLink.php

