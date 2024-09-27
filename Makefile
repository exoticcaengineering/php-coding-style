fix := false

ecs:
ifeq ($(fix), true)
	vendor/bin/ecs --fix --clear-cache --ansi
else
	vendor/bin/ecs --clear-cache --ansi
endif

phpstan:
	vendor/bin/phpstan --ansi

psalm:
	vendor/bin/psalm --threads=4 --diff

coding-standards: ecs
static-analysis: phpstan psalm
